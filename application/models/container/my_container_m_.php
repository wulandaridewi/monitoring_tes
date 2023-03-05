<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class My_container_m_ extends CI_Model {
    function cleanIndex($string) {
       $string = str_replace(' ', '_', $string);
       $string = preg_replace('~[\\\\/:*?"<>|]~', '', $string);
       return str_replace("'", "", $string); // Removes special chars.
    }

    function cleanSpecificIndex($string) {
       //$string = str_replace(' ', '_', $string);
       // $string = preg_replace('~["]~', '', $string);
       // return str_replace("'", "", $string); // Removes special chars.
       return preg_replace('~["]~', '', $string); // Removes special chars.
    }
    public function getCollection($idUser,$usergroup) {
        //echo $idUser;
        if($usergroup == '2'){
             // $sql = "SELECT dh.*,sp.name from master_folder dh
             //    left join sec_passwd sp on dh.create_by = sp.userid
             //    where dh.status = 0 and dh.group_user_doc_id in (select group_user_doc_id from group_user_doc where group_user_doc like '%+$idUser%')
             //    ORDER BY dh.folder_id DESC";
            $sql = "SELECT distinct(dh.folder_id),dh.folder_name,dh.create_date,dh.create_by,sp.name from master_folder dh 
                    left join trans_document td on dh.folder_id = td.folder_id
                    inner join sec_passwd sp on dh.create_by = sp.userid 
                    where dh.status = 0 and (td.document_allowed like '%+$idUser%' or 
                    dh.group_user_doc_id in (select group_user_doc_id from group_user_doc where group_user_doc like '%+$idUser%'))
                    ORDER BY dh.folder_id DESC";
            //echo "string";
           
        }else{
            //echo "tes";
            $sql = "SELECT dh.*,sp.name from master_folder dh
                left join sec_passwd sp on dh.create_by = sp.userid
                where dh.status = 0
                ORDER BY dh.folder_id DESC";
        }
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getCollectionSub($folder_id,$idUser,$usergroup) {
        // $sql = "SELECT CAST(a.sub_folder AS NVARCHAR(max)) as sub_folder,b.folder_id,max(a.create_by) as create_by,max(sp.name) as name,max(a.create_date) as create_date 
        // from trans_indexing_general a
        // left join sec_passwd sp on a.create_by = sp.userid
        // left join indexing_general b on a.general_index_id = b.general_index_id
        // where b.folder_id = '$folder_id' and a.status = 0 and b.status = 0
        // group by CAST(a.sub_folder AS NVARCHAR(max)),b.folder_id ORDER BY max(a.create_date) DESC";
        

        if($usergroup == '2'){
            $sql = "SELECT CAST(a.sub_folder AS NVARCHAR(max)) as sub_folder,b.folder_id,max(a.create_by) as create_by,max(sp.name) as name,max(a.create_date) as create_date 
                from trans_indexing_general a
                left join sec_passwd sp on a.create_by = sp.userid
                left join indexing_general b on a.general_index_id = b.general_index_id
                left join master_folder d on b.folder_id = d.folder_id
                left join trans_document c on CAST(a.sub_folder AS NVARCHAR(max)) = CAST(c.sub_folder AS NVARCHAR(max))
                where b.folder_id = '$folder_id' and a.status = 0 and b.status = 0 and d.status=0 and ((c.document_allowed like '%+$idUser%' and c.status=0) or 
                d.group_user_doc_id in (select group_user_doc_id from group_user_doc where group_user_doc like '%+$idUser%'))
                group by CAST(a.sub_folder AS NVARCHAR(max)),b.folder_id ORDER BY max(a.create_date) DESC";
           
        }else{
            $sql = "SELECT CAST(a.sub_folder AS NVARCHAR(max)) as sub_folder,b.folder_id,max(a.create_by) as create_by,max(sp.name) as name,max(a.create_date) as create_date 
                from trans_indexing_general a
                left join sec_passwd sp on a.create_by = sp.userid
                left join indexing_general b on a.general_index_id = b.general_index_id
                left join master_folder d on b.folder_id = d.folder_id
                left join trans_document c on CAST(a.sub_folder AS NVARCHAR(max)) = CAST(c.sub_folder AS NVARCHAR(max))
                where b.folder_id = '$folder_id' and a.status = 0 and b.status = 0 and d.status=0
                group by CAST(a.sub_folder AS NVARCHAR(max)),b.folder_id ORDER BY max(a.create_date) DESC";
        }
        //echo $sql;die();
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

    public function getSubFolder($folder_id,$idUser,$usergroup) {
        // $sql = "SELECT a.* FROM master_folder a where a.status = 0 and a.folder_id = '".$folder_id."'";
        if($usergroup == '2'){
            $sql = "SELECT a.*,ISNULL((select group_user_doc_id from group_user_doc where status=0 and group_user_doc like '%+$idUser%' and group_user_doc_id = a.group_user_doc_id),'-') as group_user_doc_id 
                FROM master_folder a where a.status = 0 and a.folder_id = '".$folder_id."'";
           
        }else{
            $sql = "SELECT a.*,('allowed') as group_user_doc_id FROM master_folder a where a.status = 0 and a.folder_id = '".$folder_id."'";
        
        }
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result();
    } 

    public function getOpenSubFolder($sub_folder,$idUser,$usergroup) {
        // $sql = "SELECT b.document_name,COUNT(a.document_id) as total_doc,a.document_id from trans_document a
        //         left join master_document b on a.document_id = b.document_id
        //         where a.status = 0 and b.status = 0 and CAST(a.sub_folder AS NVARCHAR(max)) = '".$sub_folder."'
        //         group by b.document_name,a.document_id";
        if($usergroup == '2'){
            $sql = "SELECT b.document_name,COUNT(a.document_id) as total_doc,a.document_id 
                    from trans_document a 
                    left join master_document b on a.document_id = b.document_id 
                    left join master_folder c on a.folder_id = c.folder_id
                    where a.status = 0 and b.status = 0 and CAST(a.sub_folder AS NVARCHAR(max)) = '".$sub_folder."' 
                    and (a.document_allowed like '%+$idUser%' or 
                    c.group_user_doc_id in (select group_user_doc_id from group_user_doc where group_user_doc like '%+$idUser%'))
                    group by b.document_name,a.document_id";
           
        }else{
            $sql = "SELECT b.document_name,COUNT(a.document_id) as total_doc,a.document_id 
                    from trans_document a 
                    left join master_document b on a.document_id = b.document_id 
                    left join master_folder c on a.folder_id = c.folder_id
                    where a.status = 0 and b.status = 0 and CAST(a.sub_folder AS NVARCHAR(max)) = '".$sub_folder."' 
                    group by b.document_name,a.document_id";
        }
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

    public function getFieldAllEdit($trans_doc_id) {
        $sql = "SELECT a.specific_index_id,a.document_id,a.specific_index_name,a.specific_index_format, 
                COALESCE((select specific_index from trans_indexing_specific where trans_doc_id = c.trans_doc_id and status=0 and specific_index_id = a.specific_index_id), '') as specific_index,
                COALESCE((select trans_index_specific_id from trans_indexing_specific where trans_doc_id = c.trans_doc_id and status=0 and specific_index_id = a.specific_index_id), '') as trans_index_specific_id
                from indexing_specific a 
                left join trans_document c on a.document_id = c.document_id 
                where a.status=0 and c.status=0 and c.trans_doc_id = '$trans_doc_id'";
        //echo $sql;
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
        // $sql = "SELECT c.general_index_id,c.general_index_name,c.general_index_format,a.general_index from indexing_general c 
        //         left join trans_indexing_general a on c.general_index_id = a.general_index_id
        //         where  c.status=0 and a.status=0 and c.folder_id = '$folder_id' and CAST(a.sub_folder AS NVARCHAR(max)) = '$subFolder'";
        $sql = "SELECT c.general_index_id,c.general_index_name,c.general_index_format,
                COALESCE((select trans_index_general_id from trans_indexing_general 
                where CAST(sub_folder AS NVARCHAR(max)) = '$subFolder' and status = 0 and general_index_id=c.general_index_id), '') as trans_index_general_id ,
                COALESCE((select general_index from trans_indexing_general 
                where CAST(sub_folder AS NVARCHAR(max)) = '$subFolder' and status = 0 and general_index_id=c.general_index_id), '') as general_index 
                from indexing_general c where c.status=0 and c.folder_id = '$folder_id'";
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
    

    public function insert_all($nameGeneralArr,$nameGeneralIDArr,$totalNameGeneral,$date,$folderID,$datetime,$idUser,$subFolder,$nameSpecificArr,$nameSpecificIDArr,$totalNameSpecfic,$categoryDocVal,$directory,$fileNameUpload,$formatSpesificIDArrr,$general_index_format,$fileSize){
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well   

        $sql = "SELECT sub_folder from trans_indexing_general where CAST(sub_folder AS NVARCHAR(max)) = '$subFolder' and status=0";   
        $selectSubFolder = $this->db->query($sql)->num_rows();
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
                'specific_index'          => $this->cleanSpecificIndex($nameSpecificArrvAl),//$nameSpecificArrvAl,
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
            'directory'         => $directory,
            'file_name'         => $fileNameUpload,
            'document_allowed'  => '-',
            'document_size'     => $fileSize,
        ); 
        $this->db->insert('trans_document', $dataTransDoc);

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
                    'general_index'          => $this->cleanIndex($nameGenralArrvAl),//$nameGenralArrvAl,
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

    public function getFolderID($sub_folder,$document_id,$idUser,$usergroup) {
        if($usergroup == '2'){
             // $sql = "SELECT Top 1 a.folder_id,a.trans_doc_id,a.document_id,b.document_name from trans_document a 
             //    left join master_document b on a.document_id = b.document_id
             //    where a.status=0 and b.status=0 and CAST(a.sub_folder AS NVARCHAR(max)) = '$sub_folder' and a.document_id = $document_id";
            $sql = "SELECT Top 1 a.folder_id,a.trans_doc_id,a.document_id,b.document_name,
                ISNULL((select group_user_doc_id from group_user_doc where status=0 and group_user_doc like '%+$idUser%' and group_user_doc_id = c.group_user_doc_id),'-') as group_user_doc_id 
                from trans_document a 
                left join master_document b on a.document_id = b.document_id
                left join master_folder c on a.folder_id = a.folder_id
                where a.status=0 and b.status=0 and CAST(a.sub_folder AS NVARCHAR(max)) = '$sub_folder' and a.document_id = $document_id";
            //echo "string";
           
        }else{
            //echo "tes";
            $sql = "SELECT Top 1 a.folder_id,a.trans_doc_id,a.document_id,b.document_name,('allowed') as group_user_doc_id from trans_document a 
                left join master_document b on a.document_id = b.document_id
                where a.status=0 and b.status=0 and CAST(a.sub_folder AS NVARCHAR(max)) = '$sub_folder' and a.document_id = $document_id";
        }
        
       // echo $sql;die();
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
                left join trans_indexing_general b on a.general_index_id = b.general_index_id
                where a.status=0 and b.status=0 and a.folder_id = '$folderId' and CAST(b.sub_folder AS NVARCHAR(max)) = '$sub_folder'";
        // echo $sql;
        $query = $this->db->query($sql);
        return $query->result_array(); // returning rows, not row
    }

    public function getSpecificIndexName($document_id,$trans_doc_id,$idUser) {
        $sqlCek = "SELECT * from view_document where trans_doc_id='$trans_doc_id' and user_id='$idUser'";
        $getViewDoc = $this->db->query($sqlCek)->num_rows();
        $date      = date("Y-m-d");
        $datetime  = date("Y-m-d H:i:s");
        if($getViewDoc==0){            
            $table            = "view_document"; 
            $fieldID          = "id_view_doc";
            $idMaxGeneral     = $this->global_m->getIdMaxCharDate($table,$fieldID,$date);    
            $dataViewDoc = array(
                'id_view_doc'  => $idMaxGeneral,
                'trans_doc_id' => $trans_doc_id,
                'user_id'      => $idUser,//$nameFieldArr[$i],//
                'update_date'  => $datetime,
                'update_by'    => $idUser,
            );
            $this->db->insert('view_document', $dataViewDoc);
        }
        $sql   = "SELECT a.specific_index_name,b.specific_index,a.specific_index_format,c.trans_doc_id,
                    ISNULL((select status_approve from user_approval where trans_doc_id = '$trans_doc_id' and user_id = '$idUser'), '-') as approval
                    from indexing_specific a
                    left join trans_indexing_specific b on a.specific_index_id = b.specific_index_id
                    left join trans_document c on b.trans_doc_id = c.trans_doc_id
                    where a.status=0 and b.status=0 and c.status=0 and c.document_id = $document_id and c.trans_doc_id = '$trans_doc_id'";

        // $sql   = "SELECT a.specific_index_name,b.specific_index,a.specific_index_format from indexing_specific a
        //             inner join trans_indexing_specific b on a.specific_index_id = b.specific_index_id
        //             inner join trans_document c on b.trans_doc_id = c.trans_doc_id
        //             where a.status=0 and b.status=0 and c.status=0 and c.document_id = $document_id and c.trans_doc_id = '$trans_doc_id'";
        //echo $sql;die();
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
                    'general_index'          => $this->cleanIndex($nameGenralArrvAl),
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

    public function edit_folder($idUser,$datetime,$date,$folderIDEditSf,$nameGeneralArr,$nameGeneralArrNew,$totalNameGeneral,$nameGeneralIDArr,$transIndexGeneralIDArr,$general_index_format,$subFolderEditSf,$subFolderEditSfNew,$directory,$directoryNew){
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well   
        if(trim($directory) !== trim($directoryNew)){
            $sql = "SELECT sub_folder,file_name from trans_document where CAST(sub_folder AS NVARCHAR(max)) = '$subFolderEditSf' and status=0"; 
            //echo $sql; 
            $query           = $this->db->query($sql);
            $selectSubFolder = $query->num_rows();       
            
            //echo $fileName;
            if($selectSubFolder > 0){
                //echo "ada";
                $hasil           = $query->result();
                $fileName        = $hasil[0]->file_name;
                $data = array(
                    'sub_folder' => trim($subFolderEditSfNew),
                    'directory'  => trim($directoryNew)."/".trim($fileName),
                );
                $this->db->where('CAST(sub_folder AS NVARCHAR(max)) =', $subFolderEditSf);
                $this->db->update('trans_document', $data);
                rename($directory,$directoryNew);
            }
        }

        for($k=0; $k<$totalNameGeneral; $k++){ 
            if($general_index_format[$k] == 4)
            {     
                $nameGenralArrvAl = str_replace(',', '', $nameGeneralArr[$k]);

            }else{
                 $nameGenralArrvAl = $nameGeneralArr[$k];
            } 

            if (empty($transIndexGeneralIDArr[$k]) || $transIndexGeneralIDArr[$k] == "" || $transIndexGeneralIDArr[$k] == "null") {
                
                $table            = "trans_indexing_general"; 
                $fieldID          = "trans_index_general_id";
                $idMaxGeneral     = $this->global_m->getIdMaxCharDate($table,$fieldID,$date);  
                $dataIndexGeneral = array(
                    'trans_index_general_id' => $idMaxGeneral,                
                    'general_index_id'       => $nameGeneralIDArr[$k],
                    'general_index'          => $this->cleanIndex($nameGenralArrvAl),//$nameGenralArrvAl,
                    'sub_folder'             => $subFolderEditSfNew,
                    'create_date'            => $datetime,
                    'create_by'              => $idUser,
                    'indexing_by'            => $idUser,
                );                    
                $this->db->insert('trans_indexing_general', $dataIndexGeneral);
            }else{

                $dataIndexGeneral = array(
                    'general_index' => $this->cleanIndex($nameGenralArrvAl),//$nameGenralArrvAl,
                    'sub_folder'    => trim($subFolderEditSfNew),
                );

                $this->db->where('trans_index_general_id', $transIndexGeneralIDArr[$k]);
                $this->db->update('trans_indexing_general', $dataIndexGeneral);
            }
            //echo $this->db->last_query();
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

     public function editDoc($idUser,$datetime,$date,$folderIDEditDoc,$nameGeneralArr,$nameGeneralArrNew,$totalNameGeneral,$nameGeneralIDArr,$transIndexGeneralIDArr,$general_index_format,$subFolderEditDoc,$subFolderEditDocNew,$directory,$directoryNew,$nameSpecificArr,$nameSpecificIDArr,$totalNameSpecfic,$transDocIdEditDoc,$formatSpesificIDArr,$transIndexSpecificIDArr,$fileNameUpload,$directoryDropZone,$fileSizeEditDoc){

        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well  
      
        $sql = "SELECT sub_folder,file_name from trans_document where CAST(sub_folder AS NVARCHAR(max)) = '$subFolderEditDoc' and trans_doc_id='$transDocIdEditDoc' and status=0"; 
        //echo $sql; 
        $query           = $this->db->query($sql);
        $selectSubFolder = $query->num_rows();      
        //echo $fileName;
        if($selectSubFolder > 0){
            //echo "ada";
            $hasil           = $query->result();
            $fileName        = $hasil[0]->file_name;
            if(empty($fileNameUpload) || $fileNameUpload=="" || $fileNameUpload=="null"){
                $data = array(
                    'sub_folder' => trim($subFolderEditDocNew),
                    'directory'  => trim($directoryNew)."/".trim($fileName),
                );
            }else{
                unlink("./".$directory."/".trim($fileName)."");
                $data = array(
                    'sub_folder' => trim($subFolderEditDocNew),
                    'directory'  => trim($directoryNew)."/".trim($fileNameUpload),
                    'file_name'  => trim($fileNameUpload),
                    'document_size' => trim($fileSizeEditDoc),
                );
            }
            
            $this->db->where('trans_doc_id', $transDocIdEditDoc);
            $this->db->update('trans_document', $data);

            rename("./".$directory."","./".$directoryNew."");
        }        
            
        //echo $this->db->last_query();
        for($k=0; $k<$totalNameGeneral; $k++){ 
            if($general_index_format[$k] == 4)
            {     
                $nameGenralArrvAl = str_replace(',', '', $nameGeneralArr[$k]);

            }else{
                 $nameGenralArrvAl = $nameGeneralArr[$k];
            } 

            if (empty($transIndexGeneralIDArr[$k]) || $transIndexGeneralIDArr[$k] == "" || $transIndexGeneralIDArr[$k] == "null") {
                
                $table            = "trans_indexing_general"; 
                $fieldID          = "trans_index_general_id";
                $idMaxGeneral     = $this->global_m->getIdMaxCharDate($table,$fieldID,$date);  
                $dataIndexGeneral = array(
                    'trans_index_general_id' => $idMaxGeneral,                
                    'general_index_id'       => $nameGeneralIDArr[$k],
                    'general_index'          => $this->cleanIndex($nameGenralArrvAl),//$nameGenralArrvAl,
                    'sub_folder'             => $subFolderEditDocNew,
                    'create_date'            => $datetime,
                    'create_by'              => $idUser,
                    'indexing_by'            => $idUser,
                );                    
                $this->db->insert('trans_indexing_general', $dataIndexGeneral);
            }else{

                $dataIndexGeneral = array(
                    'general_index' => $this->cleanIndex($nameGenralArrvAl),//$nameGenralArrvAl,
                    'sub_folder'    => trim($subFolderEditDocNew),
                );

                $this->db->where('trans_index_general_id', $transIndexGeneralIDArr[$k]);
                $this->db->update('trans_indexing_general', $dataIndexGeneral);
            }
            //echo $this->db->last_query();
        }


        for($j=0; $j<$totalNameSpecfic; $j++){
            if($formatSpesificIDArr[$j] == 4){    

                $nameSpecificArrvAl = str_replace(',', '', $nameSpecificArr[$j]);

            }else{
                 $nameSpecificArrvAl = $nameSpecificArr[$j];
            }

            if (empty($transIndexSpecificIDArr[$j]) || $transIndexSpecificIDArr[$j] == "" || $transIndexSpecificIDArr[$j] == "null") {
                //echo "dewi";
                $table            = "trans_indexing_specific"; 
                $fieldID          = "trans_index_specific_id";
                $idMaxSpecific    = $this->global_m->getIdMaxCharDate($table,$fieldID,$date); 
                //echo $nameSpecificArr[$j];  

                //echo $nameSpecificArrvAl.'ooo';
                $dataIndexSpecific = array(
                    'trans_index_specific_id' => $idMaxSpecific,
                    'trans_doc_id'            => $transDocIdEditDoc,                
                    'specific_index_id'       => $nameSpecificIDArr[$j],
                    'specific_index'          => $this->cleanSpecificIndex($nameSpecificArrvAl),//$nameSpecificArrvAl,
                    'create_date'             => $datetime,
                    'create_by'               => $idUser,
                    'indexing_by'             => $idUser,
                );                    
                $this->db->insert('trans_indexing_specific', $dataIndexSpecific);
                //echo $this->db->last_query();
            }else{
                //echo "dio";
                $dataIndexSpecific = array(
                    'specific_index' => $this->cleanSpecificIndex($nameSpecificArrvAl),//$nameSpecificArrvAl,
                );

                $this->db->where('trans_index_specific_id', $transIndexSpecificIDArr[$j]);
                $this->db->update('trans_indexing_specific', $dataIndexSpecific);
            }
            //echo $this->db->last_query();
            //echo $idMax.'adada';
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

    public function getStatusApprove($trans_doc_id) {
        $sql = "SELECT a.* from user_approval a
                where a.trans_doc_id='$trans_doc_id'";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result_array(); // returning rows, not row
    }

    public function getFieldNameIndexSpecific($document_id) {
        $sql = "SELECT specific_index_name,specific_index_format from indexing_specific where status=0 and document_id=$document_id";
        $query = $this->db->query($sql);
        return $query->result_array(); // returning rows, not row
    }
    public function getSpecificIndexNameTable($document_id,$sub_folder,$col,$idUser,$usergroup) {
        $col_val = "";
        for ($i=0; $i < count($col); $i++) { 
          $col_val .= "[".$col[$i]."],";
        }
        $col_val = rtrim($col_val, ',');

        // $sql = "SELECT * from (select CAST(c.directory AS NVARCHAR(max)) as directory,d.document_name,b.specific_index_name,a.specific_index,c.trans_doc_id,c.document_id,c.folder_id,c.document_size,CAST(c.sub_folder AS NVARCHAR(max)) as subFolder
        //     from trans_indexing_specific a 
        //     LEFT join indexing_specific b on a.specific_index_id = b.specific_index_id
        //     LEFT join trans_document c on a.trans_doc_id = c.trans_doc_id
        //     LEFT join master_document d on c.document_id = d.document_id
        //     where a.status=0 and b.status=0 and d.status=0 and c.status=0 and CAST(c.sub_folder AS NVARCHAR(max)) = '$sub_folder' and c.document_id = $document_id
        //     ) AS doc_child 
        //     PIVOT(
        //         MAX(specific_index)
        //         FOR specific_index_name in (".$col_val.")
        //     ) piv;";
        if($usergroup == '2'){
            $sql = "SELECT * from (select CAST(c.directory AS NVARCHAR(max)) as directory,d.document_name,b.specific_index_name,a.specific_index,c.trans_doc_id,c.document_id,c.folder_id,c.document_size,CAST(c.sub_folder AS NVARCHAR(max)) as subFolder
            from trans_indexing_specific a 
            left join indexing_specific b on a.specific_index_id = b.specific_index_id 
            left join trans_document c on a.trans_doc_id = c.trans_doc_id 
            left join master_document d on c.document_id = d.document_id 
            left join master_folder e on c.folder_id = e.folder_id
            where a.status=0 and b.status=0 and d.status=0 and c.status=0 and CAST(c.sub_folder AS NVARCHAR(max)) = '$sub_folder' and c.document_id = $document_id and (c.document_allowed like '%+$idUser%' or e.group_user_doc_id in (select group_user_doc_id from group_user_doc where group_user_doc like '%+$idUser%'))
            ) AS doc_child 
            PIVOT(
                MAX(specific_index)
                FOR specific_index_name in (".$col_val.")
            ) piv;";
           
        }else{
            $sql = "SELECT * from (select CAST(c.directory AS NVARCHAR(max)) as directory,d.document_name,b.specific_index_name,a.specific_index,c.trans_doc_id,c.document_id,c.folder_id,c.document_size,CAST(c.sub_folder AS NVARCHAR(max)) as subFolder
            from trans_indexing_specific a 
            left join indexing_specific b on a.specific_index_id = b.specific_index_id 
            left join trans_document c on a.trans_doc_id = c.trans_doc_id 
            left join master_document d on c.document_id = d.document_id 
            left join master_folder e on c.folder_id = e.folder_id
            where a.status=0 and b.status=0 and d.status=0 and c.status=0 and CAST(c.sub_folder AS NVARCHAR(max)) = '$sub_folder' and c.document_id = $document_id
            ) AS doc_child 
            PIVOT(
                MAX(specific_index)
                FOR specific_index_name in (".$col_val.")
            ) piv;";
        }
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

    public function getUserApproval($trans_doc_id) {
        $sql = "SELECT a.id_approval,a.trans_doc_id,a.user_id,a.status_approve,a.create_date,a.update_date,ISNULL(a.note,'-') as note,b.name,b.name_file_image,c.department from user_approval a 
                left join sec_passwd b on a.user_id = b.userid
                left join master_department c on b.dept_id = c.dept_id
                where a.trans_doc_id ='$trans_doc_id' and a.status=0";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getstatusApproval($trans_doc_id,$idUser) {
        $sql = "SELECT a.id_approval,a.status_approve,a.update_date,ISNULL(a.note,'-') as note,b.name,b.name_file_image,c.department from user_approval a 
                left join sec_passwd b on a.user_id = b.userid
                left join master_department c on b.dept_id = c.dept_id
                where a.trans_doc_id ='$trans_doc_id' and a.status=0 and user_id = '$idUser'";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getEmail($ownerID){
        $sql= "SELECT email,name from sec_passwd where userid = '$ownerID'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        $email  = $result[0]->email;
        $name   = $result[0]->name;
        return $email.'_'.$name;
    }  


    public function insertSetApproval($setUserApproval,$transDocSetApprove,$totalUser,$idUser,$date,$datetime,$userAllowed){
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well        
        $sql = "SELECT b.directory,b.sub_folder,b.document_id,b.folder_id,c.document_name,d.folder_name
                from trans_document b 
                left join master_document c on b.document_id = c.document_id
                left join master_folder d on b.folder_id = d.folder_id
                where b.trans_doc_id= '$transDocSetApprove' and b.status=0 and c.status = 0 and d.status=0"; 
        //echo $sql; 
        $query              = $this->db->query($sql);
        $selectUserApproval = $query->result_array();
        foreach ($selectUserApproval as $key => $value) {
            $directory          = trim($value['directory']);
            $sub_folder         = trim($value['sub_folder']);
            $document_id        = trim($value['document_id']);
            $folder_id          = trim($value['folder_id']);
            $document_name      = trim($value['document_name']);
            $folder_name      = trim($value['folder_name']);
        }
        if($totalUser==0){
            return true;
        }else{
            for($i=0; $i<$totalUser; $i++){
                $table     = "user_approval"; 
                $fieldID   = "id_approval";
                $idMax     = $this->global_m->getIdMaxCharDate($table,$fieldID,$date);    
                $data = array(
                    'id_approval'   => $idMax,
                    'trans_doc_id'  => $transDocSetApprove,
                    'user_id'       => $setUserApproval[$i],
                    'create_date'   => $datetime,
                    'create_by'     => $idUser,
                    'update_date'   => $datetime,
                );
                $this->db->insert('user_approval', $data);
                //email
                $getEmail    = $this->getEmail($setUserApproval[$i]);
                $getEmailArr = explode('_', $getEmail);
                $email       = $getEmailArr[0];
                $nameUser    = $getEmailArr[1];
                //echo $email.'_'.$nameUser;die();
                //start send email
                $config['mailtype']     = 'html';
                $config['protocol']     = 'smtp';
                $config['smtp_host']    = '172.31.152.95';
                $config['smtp_user']    = 'Chairul.Elyasa@astragraphia.co.id';
                $config['smtp_pass']    = 'Desember2020-1';
                $config['smtp_port']    = 25;
                $config['charset']      ='utf-8'; // Default should be utf-8 (this should be a text field) 
                $config['newline']      ="\r\n"; //"\r\n" or "\n" or "\r". DEFAULT should be "\r\n" 
                $config['crlf']         = "\r\n"; //"\r\n" or "\n" or "\r" DEFAULT should be "\r\n" 
                $config['smtp_timeout'] = 30;

                $this->load->library('email', $config);
                $this->email->from('Chairul.Elyasa@astragraphia.co.id', 'Mailroom');
                $this->email->to($email);
                $this->email->subject('Approval Document');
                     $valueOpen = $directory.'+'.$sub_folder.'+'.$document_id.'+'.$transDocSetApprove.'+'.$folder_id.'+'.$document_name.'+'.$folder_name;
                $link = base_url().'collection/my_collection/home?detail=1&value='.$valueOpen;
                $massage = 'Dear '.$nameUser.',<br><br><br> Anda diminta untuk approval document '.$document_name.'<br>Klik link di bawah ini:<br>'.$link.'';
                $this->email->message($massage);
                //$this->email->send();
                if($this->email->send()) {
                    $statusEmail = 1;
                 }else{
                    $statusEmail = 0;
                 }
                //email
            }
            $dataAllowed = array(
                    'document_allowed' => $userAllowed,
            );
            $this->db->where('trans_doc_id', $transDocSetApprove);
            $this->db->update('trans_document', $dataAllowed);
            
            $this->db->trans_complete(); # Completing transaction
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }

        

        
    }

    public function updateSetApproval($setUserApproval,$transDocSetApprove,$totalUser,$idUser,$date,$datetime,$userAllowed){
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well 

        // $sql = "SELECT * from user_approval where trans_doc_id= '$transDocSetApprove' and status=0 order by user_id asc"; 
        $sql = "SELECT a.*,b.directory,b.sub_folder,b.document_id,b.folder_id,c.document_name,d.folder_name
                from user_approval a 
                inner join trans_document b on a.trans_doc_id = b.trans_doc_id
                left join master_document c on b.document_id = c.document_id
                left join master_folder d on b.folder_id = d.folder_id
                where a.trans_doc_id= '$transDocSetApprove' and a.status=0 and b.status=0 and c.status=0 and d.status=0 order by a.user_id asc"; 
        //echo $sql; 
        $query              = $this->db->query($sql);
        $selectUserApproval = $query->result_array();
        $useriddb = array();
        foreach ($selectUserApproval as $key => $value) {
            $useriddb[$key]     = $value['user_id'];
            $id_approval[$key]  = $value['id_approval'];
            $directory          = trim($value['directory']);
            $sub_folder         = trim($value['sub_folder']);
            $document_id        = trim($value['document_id']);
            $folder_id          = trim($value['folder_id']);
            $document_name      = trim($value['document_name']);
            $folder_name        = trim($value['folder_name']);
        }
        $totalUserDb = count($useriddb);

        if($totalUserDb == 0){
            for($i=0; $i<$totalUser; $i++){
                $table     = "user_approval"; 
                $fieldID   = "id_approval";
                $idMax     = $this->global_m->getIdMaxCharDate($table,$fieldID,$date);    
                $data = array(
                    'id_approval'   => $idMax,
                    'trans_doc_id'  => $transDocSetApprove,
                    'user_id'       => $setUserApproval[$i],
                    'create_date'   => $datetime,
                    'create_by'     => $idUser,
                    'update_date'   => $datetime,
                );
                $this->db->insert('user_approval', $data);
                //email
                $getEmail    = $this->getEmail($setUserApproval[$i]);
                $getEmailArr = explode('_', $getEmail);
                $email       = $getEmailArr[0];
                $nameUser    = $getEmailArr[1];
                //echo $email.'_'.$nameUser;die();
                //start send email
                $config['mailtype']     = 'html';
                $config['protocol']     = 'smtp';
                $config['smtp_host']    = '172.31.152.95';
                $config['smtp_user']    = 'Chairul.Elyasa@astragraphia.co.id';
                $config['smtp_pass']    = 'Desember2020-1';
                $config['smtp_port']    = 25;
                $config['charset']      ='utf-8'; // Default should be utf-8 (this should be a text field) 
                $config['newline']      ="\r\n"; //"\r\n" or "\n" or "\r". DEFAULT should be "\r\n" 
                $config['crlf']         = "\r\n"; //"\r\n" or "\n" or "\r" DEFAULT should be "\r\n" 
                $config['smtp_timeout'] = 30;

                $this->load->library('email', $config);
                $this->email->from('Chairul.Elyasa@astragraphia.co.id', 'Mailroom');
                $this->email->to($email);
                $this->email->subject('Approval Document');
                     $valueOpen = $directory.'+'.$sub_folder.'+'.$document_id.'+'.$transDocSetApprove.'+'.$folder_id.'+'.$document_name.'+'.$folder_name;
                $link = base_url().'collection/my_collection/home?detail=1&value='.$valueOpen;
                $massage = 'Dear '.$nameUser.',<br><br><br> Anda diminta untuk approval document '.$document_name.'<br>Klik link di bawah ini:<br>'.$link.'';
                $this->email->message($massage);

                if($this->email->send()) {
                    $statusEmail = 1;
                 }else{
                    $statusEmail = 0;
                 }
                $dataAllowed = array(
                    'document_allowed' => $userAllowed,
                );
                $this->db->where('trans_doc_id', $transDocSetApprove);
                $this->db->update('trans_document', $dataAllowed);
            }
        }elseif($totalUserDb == $totalUser){
            for($x=0; $x<$totalUserDb; $x++){
                $useridcari = trim($useriddb[$x]);
                $apprvidcari = trim($id_approval[$x]);
                $userid = $setUserApproval[$x];
                
                if($useridcari == $userid){
                    //echo $useridcari."=".$userid."sama<br>";
                    //break;
                }elseif($useridcari !== $userid){
                    $sql = "SELECT user_id from user_approval where id_approval= '$apprvidcari' and user_id='$userid'";   
                    $selectUserId = $this->db->query($sql)->num_rows();

                    if($selectUserId == 0){
                        $data = array(
                            'user_id'     => $userid,
                            'note'        => "-",
                            'update_date' => $datetime,
                        );

                        $this->db->where('id_approval', $apprvidcari);
                        $this->db->update('user_approval', $data);
                    }

                }
            }

            $dataAllowed = array(
                    'document_allowed' => $userAllowed,
            );
            $this->db->where('trans_doc_id', $transDocSetApprove);
            $this->db->update('trans_document', $dataAllowed);
        }else{

            for($x=0; $x<$totalUserDb; $x++){
                $useridcari = trim($useriddb[$x]);
                $result1 = 0;
                $result2 = 0;
                for($i=0; $i<$totalUser; $i++){
                    $userid = $setUserApproval[$i];

                    if($useridcari == $userid){
                        //echo $useridcari."=".$userid."sama <br>";
                        $result1++;
                        //break;
                    }elseif($useridcari !== $userid){
                        $result2++;
                        //echo $useridcari."=".$userid."beda gak ada di db <br>";
                        $sql = "SELECT user_id from user_approval where trans_doc_id= '$transDocSetApprove' and user_id='$userid'";   
                        $selectUserId = $this->db->query($sql)->num_rows();
                        if($selectUserId == 0){
                            $table     = "user_approval"; 
                            $fieldID   = "id_approval";
                            $idMax     = $this->global_m->getIdMaxCharDate($table,$fieldID,$date);    
                            $data = array(
                                'id_approval'   => $idMax,
                                'trans_doc_id'  => $transDocSetApprove,
                                'user_id'       => $userid,
                                'create_date'   => $datetime,
                                'create_by'     => $idUser,
                                'update_date'   => $datetime,
                            );
                            $this->db->insert('user_approval', $data);

                            //email
                            $getEmail    = $this->getEmail($userid);
                            $getEmailArr = explode('_', $getEmail);
                            $email       = $getEmailArr[0];
                            $nameUser    = $getEmailArr[1];
                            //echo $email.'_'.$nameUser;die();
                            //start send email
                            $config['mailtype']     = 'html';
                            $config['protocol']     = 'smtp';
                            $config['smtp_host']    = '172.31.152.95';
                            $config['smtp_user']    = 'Chairul.Elyasa@astragraphia.co.id';
                            $config['smtp_pass']    = 'Desember2020-1';
                            $config['smtp_port']    = 25;
                            $config['charset']      ='utf-8'; // Default should be utf-8 (this should be a text field) 
                            $config['newline']      ="\r\n"; //"\r\n" or "\n" or "\r". DEFAULT should be "\r\n" 
                            $config['crlf']         = "\r\n"; //"\r\n" or "\n" or "\r" DEFAULT should be "\r\n" 
                            $config['smtp_timeout'] = 30;

                            $this->load->library('email', $config);
                            $this->email->from('Chairul.Elyasa@astragraphia.co.id', 'Mailroom');
                            $this->email->to($email);
                            $this->email->subject('Approval Document');
                            $valueOpen = $directory.'+'.$sub_folder.'+'.$document_id.'+'.$transDocSetApprove.'+'.$folder_id.'+'.$document_name.'+'.$folder_name;
                            $link = base_url().'collection/my_collection/home?detail=1&value='.$valueOpen;
                            $massage = 'Dear '.$nameUser.',<br><br><br> Anda diminta untuk approval document '.$document_name.'<br>Klik link di bawah ini:<br>'.$link.'';
                            $this->email->message($massage);

                            if($this->email->send()) {
                                $statusEmail = 1;
                             }else{
                                $statusEmail = 0;
                             }
                            //email
                        }
                    }
                }
                if($result1 == 0){
                    $this->db->where('user_id', $useridcari);
                    $this->db->where('trans_doc_id', $transDocSetApprove);                        
                    $this->db->delete('user_approval');  
                }
                //echo "string<br>";
                //break;
            }

            $dataAllowed = array(
                    'document_allowed' => $userAllowed,
            );
            $this->db->where('trans_doc_id', $transDocSetApprove);
            $this->db->update('trans_document', $dataAllowed);
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

    public function updateApproval($data,$id_approval){
        $this->db->where('id_approval', $id_approval);
        $this->db->update('user_approval', $data);
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
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
