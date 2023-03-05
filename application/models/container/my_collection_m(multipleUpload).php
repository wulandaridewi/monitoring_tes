<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class My_collection_m extends CI_Model {

    public function getCollection($idUser,$usergroup) {
        //echo $idUser;
        if($usergroup == '1'){
            $sql = "SELECT dh.*,sp.name from master_folder dh
                left join sec_passwd sp on dh.create_by = sp.userid
                where dh.status = 0
                ORDER BY dh.folder_id DESC";
            //echo "string";
           
        }else{
            //echo "tes";
            $sql = "SELECT dh.*,sp.name from master_folder dh
                left join sec_passwd sp on dh.create_by = sp.userid
                where dh.status = 0 and dh.group_user_doc_id in (select group_user_doc_id from group_user_doc where group_user_doc like '%+$idUser%')
                ORDER BY dh.folder_id DESC";
        }
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getCollectionSub($folder_id) {
        $sql = "SELECT CAST(a.sub_folder AS NVARCHAR(max)) as sub_folder,b.folder_id,max(a.create_by) as create_by,max(sp.name) as name,max(a.create_date) as create_date 
        from trans_indexing_general a
        left join sec_passwd sp on a.create_by = sp.userid
        left join indexing_general b on a.general_index_id = b.general_index_id
        where b.folder_id = '$folder_id' and a.status = 0 and b.status = 0
        group by CAST(a.sub_folder AS NVARCHAR(max)),b.folder_id ORDER BY max(a.create_date) DESC";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    // public function getCollectionSub($folder_id) {
    //     $sql = "SELECT CAST(a.sub_folder AS NVARCHAR(max)) as sub_folder,a.folder_id,max(a.create_by) as create_by,max(sp.name) as name,max(a.create_date) as create_date 
    //     from trans_document a
    //     left join sec_passwd sp on a.create_by = sp.userid
    //     where a.folder_id = '$folder_id'
    //     group by CAST(a.sub_folder AS NVARCHAR(max)),a.folder_id";
    //     $query = $this->db->query($sql);
    //     return $query->result(); // returning rows, not row
    // }

    public function getSubFolder($folder_id) {
        $sql = "SELECT a.* FROM master_folder a where a.status = 0 and a.folder_id = '".$folder_id."'";
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result();
    } 

    public function getOpenSubFolder($sub_folder) {
        $sql = "SELECT b.document_name,COUNT(a.document_id) as total_doc,a.document_id from trans_document a
                left join master_document b on a.document_id = b.document_id
                where a.status = 0 and b.status = 0 and CAST(a.sub_folder AS NVARCHAR(max)) = '".$sub_folder."'
                group by b.document_name,a.document_id";
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result();
    } 

    public function getFieldAll($categoryDoc) {
        $sql = "SELECT a.specific_index_id,a.document_id,a.specific_index_name,a.specific_index_format 
                from indexing_specific a 
                left join master_document b on a.document_id = b.document_id where a.status=0 and b.status=0 and b.document_name = '$categoryDoc'";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getFieldGeneralAll($folder_id) {
        $sql = "SELECT c.general_index_id,c.general_index_name,c.general_index_format
                from indexing_general c
                where c.folder_id = '$folder_id' and c.status=0";
        // echo $sql;
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }  

    public function getFieldGeneralAllAndValue($folder_id,$subFolder) {
        $sql = "SELECT c.general_index_id,c.general_index_name,c.general_index_format,a.general_index from indexing_general c 
                left join trans_indexing_general a on c.general_index_id = a.general_index_id
                where  c.status=0 and a.status=0 and c.folder_id = '$folder_id' and CAST(a.sub_folder AS NVARCHAR(max)) = '$subFolder'";
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }  

    public function getDocId($categoryDoc) {
        $sql = "SELECT document_id FROM master_document where status=0 and document_name = '".$categoryDoc."'";
        //echo $sql;
        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->document_id;
    } 
    

    public function insert_all($nameGeneralArr,$nameGeneralIDArr,$totalNameGeneral,$date,$folderID,$datetime,$idUser,$subFolder,$nameSpecificArr,$nameSpecificIDArr,$totalNameSpecfic,$totalFileNameUpload,$categoryDocVal,$directoryArr,$fileNameUploadArr,$formatSpesificIDArrr,$general_index_format,$fileSize){
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well   

        $sql = "SELECT sub_folder from trans_indexing_general where CAST(sub_folder AS NVARCHAR(max)) = '$subFolder' and status=0";   
        $selectSubFolder = $this->db->query($sql)->num_rows();
        for($i=0; $i<$totalFileNameUpload; $i++){
                $tableFolder    = "trans_document"; 
                $fieldIDFolder  = "trans_doc_id";
                $idMax          = $this->global_m->getIdMaxCharDate($tableFolder,$fieldIDFolder,$date); 
                
                for($j=0; $j<$totalNameSpecfic; $j++){
                    $table            = "trans_indexing_specific"; 
                    $fieldID          = "trans_index_specific_id";
                    $idMaxSpecific    = $this->global_m->getIdMaxCharDate($table,$fieldID,$date); 
                    //echo $nameSpecificArr[$j];  
                      if($formatSpesificIDArrr[$j] == 4)
                      {     

                            $nameSpecificArrvAl = str_replace(',', '', $nameSpecificArr[$j]);

                        }else{
                             $nameSpecificArrvAl = $nameSpecificArr[$j];
                        }
                    //echo $nameSpecificArrvAl.'ooo';
                    $dataIndexGeneral = array(
                        'trans_index_specific_id' => $idMaxSpecific,
                        'trans_doc_id'            => $idMax,                
                        'specific_index_id'       => $nameSpecificIDArr[$j],
                        'specific_index'          => $nameSpecificArrvAl,
                        'create_date'             => $datetime,
                        'create_by'               => $idUser,
                        'indexing_by'             => $idUser,
                    );                    
                    $this->db->insert('trans_indexing_specific', $dataIndexGeneral);
                    //echo $idMax.'adada';
                }   

                //echo $idMax.'ggg';
                $sql = "SELECT document_id FROM master_document where document_name = '".$categoryDocVal."' and status = 0";
                $query = $this->db->query($sql);
                $row = $query->row();
                $documentID = $row->document_id;
                //echo $documentID;      
                $dataTransDoc = array(
                    'trans_doc_id'      => $idMax,
                    'folder_id'         => $folderID,
                    'document_id'       => $documentID,
                    'sub_folder'        => $subFolder,
                    'create_date'       => $datetime,
                    'create_by'         => $idUser,
                    'scan_by'           => $idUser,
                    'directory'         => $directoryArr[$i],
                    'file_name'         => $fileNameUploadArr[$i],
                    'document_allowed'  => 'tes',
                    'document_size'     => $fileSize,
                );  

                $this->db->insert('trans_document', $dataTransDoc);
            }

        if($selectSubFolder == 0){
            for($k=0; $k<$totalNameGeneral; $k++){
                $table            = "trans_indexing_general"; 
                $fieldID          = "trans_index_general_id";
                $idMaxGeneral     = $this->global_m->getIdMaxCharDate($table,$fieldID,$date);   
                if($general_index_format[$k] == 4)
                    {     
                        $nameGenralArrvAl = str_replace(',', '', $nameGeneralArr[$k]);

                    }else{
                         $nameGenralArrvAl = $nameGeneralArr[$k];
                    } 
                $dataIndexGeneral = array(
                    'trans_index_general_id' => $idMaxGeneral,                
                    'general_index_id'       => $nameGeneralIDArr[$k],
                    'general_index'          => $nameGenralArrvAl,
                    'sub_folder'             => $subFolder,
                    'create_date'            => $datetime,
                    'create_by'              => $idUser,
                    'indexing_by'            => $idUser,
                );                    
                $this->db->insert('trans_indexing_general', $dataIndexGeneral);
            }
        }

        $this->db->trans_complete(); # Completing transaction
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function getFolderID($sub_folder,$document_id) {
        $sql = "SELECT Top 1 a.folder_id,a.trans_doc_id,a.document_id,b.document_name from trans_document a 
                left join master_document b on a.document_id = b.document_id
                where a.status=0 and b.status=0 and CAST(a.sub_folder AS NVARCHAR(max)) = '$sub_folder' and a.document_id = $document_id";
        $query = $this->db->query($sql);
        return $query->result();// returning rows, not row        
    }

    public function getTransDoc($sub_folder,$document_id) {
        $sql = "SELECT a.directory,a.document_size,CAST(a.sub_folder AS NVARCHAR(max)) as subFolder from trans_document a 
                where a.status=0 and CAST(a.sub_folder AS NVARCHAR(max)) = '$sub_folder' and a.document_id = $document_id";
        $query = $this->db->query($sql);
        return $query->result_array();// returning rows, not row        
    }

    public function getGeneralIndexName($folderId,$sub_folder) {
        $sql   = "SELECT a.general_index_name,general_index from indexing_general a
                inner join trans_indexing_general b on a.general_index_id = b.general_index_id
                where a.status=0 and b.status=0 and a.folder_id = '$folderId' and CAST(b.sub_folder AS NVARCHAR(max)) = '$sub_folder'";
        // echo $sql;
        $query = $this->db->query($sql);
        return $query->result_array(); // returning rows, not row
    }

    public function getSpecificIndexName($document_id,$trans_doc_id) {
        $sql   = "SELECT a.specific_index_name,specific_index from indexing_specific a
                    inner join trans_indexing_specific b on a.specific_index_id = b.specific_index_id
                    inner join trans_document c on b.trans_doc_id = c.trans_doc_id
                    where a.status=0 and b.status=0 and c.status=0 and c.document_id = $document_id and c.trans_doc_id = '$trans_doc_id'";
        $query = $this->db->query($sql);
        return $query->result_array(); // returning rows, not row
    }

    public function getFileName($trans_doc_id) {
        $sql   = "SELECT a.directory,a.file_name,a.sub_folder from trans_document a
                    where a.status=0 and a.trans_doc_id = '$trans_doc_id'";
        $query = $this->db->query($sql);
        return $query->result_array(); // returning rows, not row
    }

    public function insert_folder($nameGeneralArr,$nameGeneralIDArr,$totalNameGeneral,$date,$folderID,$datetime,$idUser,$subFolder,$general_index_format){
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well   

        $sql = "SELECT sub_folder from trans_indexing_general where CAST(sub_folder AS NVARCHAR(max)) = '$subFolder' and status=0";  
        // echo $sql; 
        $selectSubFolder = $this->db->query($sql)->num_rows();
        
        if($selectSubFolder == 0){
            for($k=0; $k<$totalNameGeneral; $k++){
                $table            = "trans_indexing_general"; 
                $fieldID          = "trans_index_general_id";
                $idMaxGeneral     = $this->global_m->getIdMaxCharDate($table,$fieldID,$date);   
                if($general_index_format[$k] == 4)
                    {     
                        $nameGenralArrvAl = str_replace(',', '', $nameGeneralArr[$k]);

                    }else{
                         $nameGenralArrvAl = $nameGeneralArr[$k];
                    } 
                $dataIndexGeneral = array(
                    'trans_index_general_id' => $idMaxGeneral,                
                    'general_index_id'       => $nameGeneralIDArr[$k],
                    'general_index'          => $nameGenralArrvAl,
                    'sub_folder'             => $subFolder,
                    'create_date'            => $datetime,
                    'create_by'              => $idUser,
                    'indexing_by'            => $idUser,
                );                    
                $this->db->insert('trans_indexing_general', $dataIndexGeneral);
            }

            $this->db->trans_complete(); # Completing transaction
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } else {
            return 'already';
        }
    }

    public function getFieldNameIndexSpecific($document_id) {
        $sql = "SELECT specific_index_name from indexing_specific where status=0 and document_id=$document_id";
        $query = $this->db->query($sql);
        return $query->result_array(); // returning rows, not row
    }
    public function getSpecificIndexNameTable($document_id,$sub_folder,$col) {
        $col_val = "";
        for ($i=0; $i < count($col); $i++) { 
          $col_val .= "[".$col[$i]."],";
        }
        $col_val = rtrim($col_val, ',');

        $sql = "SELECT * from (select CAST(c.directory AS NVARCHAR(max)) as directory,d.document_name,b.specific_index_name,a.specific_index,c.trans_doc_id,c.document_id,c.folder_id,c.document_size,CAST(c.sub_folder AS NVARCHAR(max)) as subFolder
            from trans_indexing_specific a 
            LEFT join indexing_specific b on a.specific_index_id = b.specific_index_id
            LEFT join trans_document c on a.trans_doc_id = c.trans_doc_id
            LEFT join master_document d on c.document_id = d.document_id
            where a.status=0 and b.status=0 and d.status=0 and c.status=0 and CAST(c.sub_folder AS NVARCHAR(max)) = '$sub_folder' and c.document_id = $document_id
            ) AS doc_child 
            PIVOT(
                MAX(specific_index)
                FOR specific_index_name in (".$col_val.")
            ) piv;";
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result_array();
    } 

    public function getGeneralIndex($sub_folder) {
        $sql   = "SELECT general_index from trans_indexing_general where status=0 and CAST(sub_folder AS NVARCHAR(max)) = '$sub_folder'";
        $query = $this->db->query($sql);
        return $query->result_array(); // returning rows, not row
    } 

    public function deletefolder($folder_id,$data) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well
        $this->db->where('folder_id', $folder_id);
        $this->db->update('master_folder',$data);

        $this->db->where('folder_id', $folder_id);
        $this->db->update('indexing_general',$data);

        $this->db->where('folder_id', $folder_id);
        $this->db->update('trans_document',$data);

        $this->db->trans_complete(); # Completing transaction
        if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();
            return FALSE;
        } 
        else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function deleteSubfolder($sub_folder,$data) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well
 
        $this->db->where('CAST(sub_folder AS NVARCHAR(max))=', $sub_folder);
        $this->db->update('trans_indexing_general',$data);

        $this->db->where('CAST(sub_folder AS NVARCHAR(max))=', $sub_folder);
        $this->db->update('trans_document',$data);

        $this->db->trans_complete(); # Completing transaction
        if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();
            return FALSE;
        } 
        else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function deleteDocument($trans_doc_id,$data) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well
 
        $this->db->where('trans_doc_id', $trans_doc_id);
        $this->db->update('trans_indexing_specific',$data);

        $this->db->where('trans_doc_id', $trans_doc_id);
        $this->db->update('trans_document',$data);

        $this->db->trans_complete(); # Completing transaction
        if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();
            return FALSE;
        } 
        else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            return TRUE;
        }
    }

    // public function getOpenSubFolder($sub_folder,$col) {
    //     $col_val = "";
    //     for ($i=0; $i < count($col); $i++) { 
    //       $col_val .= "[".$col[$i]."],";
    //     }
    //     $col_val = rtrim($col_val, ',');

    //     $sql = "SELECT * from (select CAST(c.sub_folder AS NVARCHAR(max)) as sub_folder,d.document_name,b.general_index_name,
    //             a.general_index 
    //             from trans_indexing_general a 
    //             inner join indexing_general b on a.general_index_id = b.general_index_id
    //             inner join trans_document c on CAST(a.sub_folder AS NVARCHAR(max)) = CAST(c.sub_folder AS NVARCHAR(max))
    //             inner join master_document d on c.document_id = d.document_id
    //             where CAST(c.sub_folder AS NVARCHAR(max)) = '$sub_folder'
    //             ) AS doc_child 
    //             PIVOT(
    //                 MAX(general_index)
    //                 FOR general_index_name in (".$col_val.")
    //             ) piv;";
    //     //echo $sql;
    //     $query = $this->db->query($sql);
    //     return $query->result_array();
    // } 

    // public function getOpenSubFolder($sub_folder) {
    //     $sql = "SELECT CAST(a.sub_folder AS NVARCHAR(max)) as sub_folder,b.document_name 
    //             from trans_document a 
    //             left join master_document b on a.document_id = b.document_id
    //             where CAST(a.sub_folder AS NVARCHAR(max)) = '$sub_folder'";
    //     //echo $sql;
    //     $query = $this->db->query($sql);
    //     return $query->result();
    // } 

}
