<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class My_container_m extends CI_Model {
    #function for string
    function cleanIndex($string) {
       //$string = str_replace(' ', '_', $string);
       $string = preg_replace('~[\\\\/:*?"<>|]~', '', $string);
       return str_replace("'", "", $string); // Removes special chars.
    }

    function cleanSpecificIndex($string) {
       return preg_replace('~["]~', '', $string); // Removes special chars.
    }
    #end function for string

    public function getContainer($idUser,$usergroup) {
        //echo $idUser;
        if($usergroup == '2'){

            $sql = "SELECT dh.folder_id,dh.folder_name,dh.create_date,dh.create_by,sp.name 
            FROM master_folder dh
            LEFT JOIN sec_passwd sp ON dh.create_by = sp.userid 
            WHERE dh.status = 0 AND (dh.group_user_doc_id in (SELECT gud.group_user_doc_id FROM list_group_user_doc gud where gud.userid = $idUser AND gud.status=0)
            OR dh.folder_id in (SELECT td.folder_id FROM trans_document td
            LEFT JOIN list_user_doc_share luds on td.trans_doc_id = luds.trans_doc_id
            WHERE luds.userid = $idUser AND td.status=0 AND luds.status=0))
            ORDER BY dh.folder_id DESC";

        }elseif($usergroup == '1' || $usergroup == '3'){

            $sql = "SELECT dh.*,sp.name FROM master_folder dh
                    LEFT JOIN sec_passwd sp ON dh.create_by = sp.userid
                    WHERE dh.status = 0
                    ORDER BY dh.folder_id DESC";
        }
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function viewSubContainer($folder_id,$idUser,$usergroup) {
        if($usergroup == '2'){

            $sql = "SELECT TOP 1 a.group_user_doc_id,a.folder_name, 
                    STUFF((SELECT '+'+ TRIM(f.document_name) FROM group_document e LEFT JOIN master_document f on e.document_id = f.document_id 
                    WHERE e.status=0 AND e.folder_id = $folder_id AND f.status=0 FOR XML PATH('')), 1, 1, '') as group_document,
                    STUFF((SELECT '+'+ TRIM(CAST(e.document_id AS varchar)) FROM group_document e 
                    WHERE e.status=0 AND e.folder_id = $folder_id FOR XML PATH('')), 1, 1, '') as group_document_id  
                    FROM master_folder a 
                    LEFT JOIN list_sub_folder b on a.folder_id = b.folder_id
                    WHERE a.status = 0 AND a.folder_id = $folder_id AND (a.group_user_doc_id in (SELECT gud.group_user_doc_id FROM list_group_user_doc gud where gud.userid = $idUser AND gud.status=0)
                    OR b.sub_folder_id in (SELECT td.sub_folder_id FROM trans_document td
                    LEFT JOIN list_user_doc_share luds on td.trans_doc_id = luds.trans_doc_id
                    WHERE td.status=0  AND luds.userid = $idUser AND luds.status=0) AND b.status = 0) ORDER BY a.folder_id DESC";
           
        }elseif($usergroup == '1' || $usergroup == '3'){

            $sql = "SELECT TOP 1 a.group_user_doc_id,a.folder_name,
                    STUFF((SELECT '+'+ TRIM(f.document_name) 
                    FROM group_document e
                    LEFT JOIN master_document f on e.document_id = f.document_id
                    WHERE e.status = 0 AND e.folder_id = $folder_id AND f.status = 0 FOR XML PATH('')), 1, 1, '') as group_document,
                    STUFF((SELECT '+'+ TRIM(CAST(e.document_id AS varchar)) FROM group_document e 
                    WHERE e.status = 0 AND e.folder_id = $folder_id FOR XML PATH('')), 1, 1, '') as group_document_id
                    FROM master_folder a
                    WHERE a.status = 0  AND a.folder_id = $folder_id ORDER BY a.folder_id DESC";
        
        }
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result();
    } 

    public function getSubContainer($folder_id,$idUser,$usergroup) {        

        if($usergroup == '2'){

            $sql = "SELECT a.sub_folder_id,a.sub_folder,a.create_date,a.create_by,e.name
                    FROM list_sub_folder a
                    LEFT JOIN master_folder c on a.folder_id = c.folder_id
                    LEFT JOIN sec_passwd e on a.create_by = e.userid
                    WHERE a.folder_id = $folder_id AND a.status=0 AND c.status=0 AND (c.group_user_doc_id in (SELECT gud.group_user_doc_id FROM list_group_user_doc gud where gud.userid = $idUser AND gud.status=0)
                    OR a.sub_folder_id in (SELECT td.sub_folder_id FROM trans_document td
                    LEFT JOIN list_user_doc_share luds on td.trans_doc_id = luds.trans_doc_id
                    WHERE td.status=0 AND luds.userid = $idUser AND luds.status=0)) ORDER BY a.sub_folder_id DESC";
           
        }elseif($usergroup == '1' || $usergroup == '3'){

            $sql = "SELECT a.sub_folder_id,a.sub_folder,a.create_date,a.create_by,e.name
                    FROM list_sub_folder a
                    LEFT JOIN sec_passwd e ON a.create_by = e.userid
                    WHERE a.folder_id = $folder_id AND a.status = 0";         
        }
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getSubContainerName($sub_folder_id) {
        $sql = "SELECT sub_folder FROM list_sub_folder where sub_folder_id = $sub_folder_id AND status=0";
        //echo $sql;
        $query = $this->db->query($sql);
        $ret = $query->row();
        return $ret->sub_folder;
    }

    public function deleteContainer($folder_id,$data) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well

        $this->db->where('folder_id', $folder_id);
        $this->db->update('master_folder',$data);

        $this->db->where('folder_id', $folder_id);
        $this->db->update('trans_indexing_general',$data);

        $this->db->where('folder_id', $folder_id);
        $this->db->update('trans_document',$data);

        $this->db->where('folder_id', $folder_id);
        $this->db->update('trans_document',$data);

         $this->db->where('folder_id', $folder_id);
        $this->db->update('list_sub_folder',$data);

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

    public function getFieldGeneralAll($folder_id) {
        $sql = "SELECT c.general_index_id,c.general_index_name,c.general_index_format
                FROM indexing_general c
                WHERE c.folder_id = '$folder_id' AND c.status=0";
        // echo $sql;
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }  

    public function getFieldGeneralAllANDValue($folder_id,$subFolderID) {
        //echo $folder_id.'-'.$subFolder;die();
        $sql = "SELECT c.general_index_id,c.general_index_name,c.general_index_format, 
        COALESCE((select trans_index_general_id FROM trans_indexing_general 
        where sub_folder_id = $subFolderID AND status = 0 AND general_index_id=c.general_index_id), '') as trans_index_general_id , 
        COALESCE((select general_index FROM trans_indexing_general where sub_folder_id = $subFolderID 
        AND status = 0 AND general_index_id=c.general_index_id), '') as general_index 
        FROM indexing_general c 
        WHERE c.status=0 AND c.folder_id = $folder_id";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }  

    public function insert_sub_container($nameGeneralArr,$nameGeneralIDArr,$totalNameGeneral,$date,$folderID,$datetime,$idUser,$subFolder,$general_index_format){
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well   

        $sql = "SELECT sub_folder from list_sub_folder where CAST(sub_folder AS NVARCHAR(max)) = '$subFolder' AND status=0";  
        // echo $sql; 
        $selectSubFolder = $this->db->query($sql)->num_rows();
        
        if($selectSubFolder == 0){
            #insert list_sub_folder
            $tableSubFolder   = "list_sub_folder"; 
            $fieldIDSubFolder = "sub_folder_id";
            $idMaxSubFolder   = $this->global_m->getIdMaxChar($tableSubFolder,$fieldIDSubFolder);  
            $dataSubFolder    = array(
                'sub_folder_id' => $idMaxSubFolder,                
                'sub_folder'    => $subFolder,
                'folder_id'     => $folderID,
                'create_date'   => $datetime,
                'create_by'     => $idUser,
            );  
            $this->db->insert('list_sub_folder', $dataSubFolder);
            #insert trans_indexing_general
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
                    'folder_id'              => $folderID,
                    'sub_folder_id'          => $idMaxSubFolder,               
                    'general_index_id'       => $nameGeneralIDArr[$k],
                    'general_index'          => $this->cleanIndex($nameGenralArrvAl),
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

    public function getListCategoryDoc($sub_folder_id,$idUser,$usergroup) {
        if($usergroup == '2'){

            $sql = "SELECT COUNT(a.document_id) as total_doc,a.document_id,b.document_name
                    FROM trans_document a
                    LEFT JOIN master_document b on a.document_id = b.document_id
                    LEFT JOIN master_folder c on a.folder_id = c.folder_id
                    WHERE a.status = 0 AND a.sub_folder_id=$sub_folder_id AND (a.trans_doc_id IN (SELECT luds.trans_doc_id FROM list_user_doc_share luds WHERE luds.userid = $idUser AND luds.status = 0) OR c.group_user_doc_id IN (SELECT gud.group_user_doc_id FROM list_group_user_doc gud where gud.userid = $idUser AND gud.status = 0)) AND b.status = 0 AND c.status = 0
                    GROUP BY a.document_id, b.document_name";
           
        }elseif($usergroup == '1' || $usergroup == '3'){

            $sql = "SELECT COUNT(a.document_id) as total_doc,a.document_id,b.document_name 
                    FROM trans_document a
                    LEFT JOIN master_document b on a.document_id = b.document_id
                    WHERE a.status = 0 AND a.sub_folder_id = $sub_folder_id AND b.status = 0
                    GROUP BY a.document_id,b.document_name";
        }
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result();
    } 

    public function insert_document($nameGeneralArr,$nameGeneralIDArr,$totalNameGeneral,$date,$folderID,$datetime,$idUser,$nameSpecificArr,$nameSpecificIDArr,$totalNameSpecfic,$docID,$directory,$fileNameUpload,$formatSpesificIDArr,$general_index_format,$fileSize,$subFolderIdName){
        $this->db->trans_start(); 
        $this->db->trans_strict(TRUE); 
        #id untuk trans_document
        $tableFolder    = "trans_document"; 
        $fieldIDFolder  = "trans_doc_id";
        $idMax          = $this->global_m->getIdMaxCharDate($tableFolder,$fieldIDFolder,$date); 
        #insert trans_indexing_specific

        for($j=0; $j<$totalNameSpecfic; $j++){
            $table            = "trans_indexing_specific"; 
            $fieldID          = "trans_index_specific_id";
            $idMaxSpecific    = $this->global_m->getIdMaxCharDate($table,$fieldID,$date); 
            //echo $nameSpecificArr[$j];  
              if($formatSpesificIDArr[$j] == 4)
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
        }   

        #insert trans_document     
        $dataTransDoc = array(
            'trans_doc_id'      => $idMax,
            'folder_id'         => $folderID,
            'document_id'       => $docID,
            'sub_folder_id'     => $subFolderIdName,
            'create_date'       => $datetime,
            'create_by'         => $idUser,
            'scan_by'           => $idUser,
            'file_name'         => $fileNameUpload,
            'document_size'     => $fileSize,
        ); 
        $this->db->insert('trans_document', $dataTransDoc);
        //echo $this->db->last_query();die();

        #insert trans_indexing_general 
        // if($selectSubFolder == 0){
        //     for($k=0; $k<$totalNameGeneral; $k++){
        //         $table            = "trans_indexing_general"; 
        //         $fieldID          = "trans_index_general_id";
        //         $idMaxGeneral     = $this->global_m->getIdMaxCharDate($table,$fieldID,$date);   
        //         if($general_index_format[$k] == 4)
        //             {     
        //                 $nameGenralArrvAl = str_replace(',', '', $nameGeneralArr[$k]);

        //             }else{
        //                  $nameGenralArrvAl = $nameGeneralArr[$k];
        //             } 
        //         $dataIndexGeneral = array(
        //             'trans_index_general_id' => $idMaxGeneral,                
        //             'general_index_id'       => $nameGeneralIDArr[$k],
        //             'general_index'          => $this->cleanIndex($nameGenralArrvAl),//$nameGenralArrvAl,
        //             'sub_folder'             => $subFolder,
        //             'create_date'            => $datetime,
        //             'create_by'              => $idUser,
        //             'indexing_by'            => $idUser,
        //         );                    
        //         $this->db->insert('trans_indexing_general', $dataIndexGeneral);
        //     }
        // }

        $this->db->trans_complete(); # Completing transaction
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function deleteSubContainer($sub_folder_id,$data) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well
 
        $this->db->where('sub_folder_id', $sub_folder_id);
        $this->db->update('trans_indexing_general',$data);

        $this->db->where('sub_folder_id', $sub_folder_id);
        $this->db->update('trans_document',$data);

        $this->db->where('sub_folder_id', $sub_folder_id);
        $this->db->update('list_sub_folder',$data);

        $this->db->trans_complete(); # Completing transaction
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function getFieldAll($document_id) {
        $sql = "SELECT a.specific_index_id,a.document_id,a.specific_index_name,a.specific_index_format,b.document_name 
                FROM indexing_specific a
                LEFT JOIN master_document b ON a.document_id = b.document_id 
                WHERE a.status=0 AND a.document_id = $document_id";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getDocumentName($document_id) {

        $query          =  $this->db->query("EXEC sp_getDocumentName $document_id");
        $row            = $query->row();
        if(isset($row)){
            $result = $row->document_name;
        }else{
            $result = 'undefined';
        }
        return $result;// returning rows, not row         
    }

    public function getFileName($trans_doc_id) {
        //echo "string";die();
        $query          =  $this->db->query("EXEC sp_getFileName $trans_doc_id");
        $row            = $query->row();
        if(isset($row)){
            $result = $row->file_name;
        }else{
            $result = 'undefined';
        }
        return $result;// returning rows, not row  
    }

    public function getGeneralIndexName($folderId,$subFolderID) {
        #by stored procedure
        $query =  $this->db->query("EXEC sp_getGeneralIndexName '".$folderId."','".$subFolderID."'");
        return $query->result_array();
       
        // $sql = "SELECT a.general_index_name,b.general_index 
        //         FROM indexing_general a
        //         LEFT JOIN trans_indexing_general b ON a.general_index_id = b.general_index_id
        //         WHERE a.status=0 AND a.folder_id = $folderId AND b.status=0 AND b.sub_folder_id = $subFolderID";
        // // echo $sql;
        // $query = $this->db->query($sql);
        // return $query->result_array(); 
    }

    public function getFieldNameIndexSpecific($document_id) {
        #by stored procedure
        $query =  $this->db->query("EXEC sp_getFieldNameIndexSpecific $document_id");
        return $query->result_array();
        // $sql = "SELECT specific_index_name,specific_index_format 
        //         FROM indexing_specific
        //         WHERE status=0 AND document_id = $document_id";
        // // echo $sql;die();
        // $query = $this->db->query($sql);
        // return $query->result_array(); // returning rows, not row
    }

    public function getSpecificIndexNameTable($document_id,$subFolderID,$col,$idUser,$usergroup) {
        $col_val = "";
        for ($i=0; $i < count($col); $i++) { 
          $col_val .= "[".$col[$i]."],";
        }
        $col_val = rtrim($col_val, ',');
         if($usergroup == '2'){
            $sp = "sp_getSpecificIndexNameTable_user ?,?,?,?";
            $params = array(
                    'PARAM_1' => "".$subFolderID."",
                    'PARAM_2' => $col_val,
                    'PARAM_3' => $document_id,
                    'PARAM_4' => $idUser);
            $query = $this->db->query($sp,$params);
        }elseif($usergroup == '1' || $usergroup == '3'){
            $sp = "sp_getSpecificIndexNameTable_admin ?,?,?";
            $params = array(
                    'PARAM_1' => "".$subFolderID."",
                    'PARAM_2' => $col_val,
                    'PARAM_3' => $document_id);
            $query = $this->db->query($sp,$params);
        }       
        
        //print_r($query);die();
        return $query->result_array();
    } 

    // public function getStatusApprove($trans_doc_id) {
    //     $sql = "SELECT a.* FROM user_approval a
    //             WHERE a.trans_doc_id='$trans_doc_id'";
    //     //echo $sql;die();
    //     $query = $this->db->query($sql);
    //     return $query->result_array(); // returning rows, not row
    // }

    public function getSpecificIndexName($document_id,$trans_doc_id,$idUser) {
        $sp = "sp_cekViewDoc ?,?";
            $params = array(
                    'PARAM_1' => "".$trans_doc_id."",
                    'PARAM_2' => "".$idUser."");
        $getViewDoc = $this->db->query($sp,$params)->num_rows();
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
        $sp = "sp_getSpecificIndexNamec ?,?,?";
        $params = array(
                'PARAM_1' => "".$document_id."",
                'PARAM_2' => "".$trans_doc_id."",
                'PARAM_3' => "".$idUser."");
        $query = $this->db->query($sp,$params);
        return $query->result_array(); // returning rows, not row
    }

    public function getFieldAllEdit($trans_doc_id) {
        $sql = "SELECT a.specific_index_id,a.specific_index_name,a.specific_index_format, 
                COALESCE((SELECT specific_index FROM trans_indexing_specific WHERE trans_doc_id = c.trans_doc_id AND status=0 AND specific_index_id = a.specific_index_id), '') AS specific_index,
                COALESCE((select trans_index_specific_id FROM trans_indexing_specific WHERE trans_doc_id = c.trans_doc_id AND status=0 AND specific_index_id = a.specific_index_id), '') AS trans_index_specific_id
                FROM indexing_specific a 
                LEFT JOIN trans_document c ON a.document_id = c.document_id 
                WHERE a.status=0 AND c.status=0 AND c.trans_doc_id = '$trans_doc_id'";
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function editDoc($idUser,$datetime,$date,$fileNameUpload,$fileSizeEditDoc,$transDocIdEditDoc,$directory,$totalNameSpecfic,$formatSpesificIDArr,$transIndexSpecificIDArr,$nameSpecificIDArr,$nameSpecificArr){

        $this->db->trans_start(); 
        $this->db->trans_strict(TRUE); 
        if(empty($fileNameUpload) || $fileNameUpload=="" || $fileNameUpload=="null"){
            
        }else{
            $sql = "SELECT ISNULL(a.file_name, '-') AS file_name FROM trans_document a 
            WHERE a.trans_doc_id='$transDocIdEditDoc' AND a.status=0";  

            $query           = $this->db->query($sql);
            $hasil           = $query->result();  
            $fileName        = $hasil[0]->file_name; 
            #remove File in folder
            unlink("./".$directory."/".trim($fileName)."");

            $data = array(
                'file_name'  => trim($fileNameUpload),
                'document_size' => trim($fileSizeEditDoc),
            );
            $this->db->where('trans_doc_id', $transDocIdEditDoc);
            $this->db->update('trans_document', $data);
            
        }

        #update trans_indexing_specific
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
            }else{
                $dataIndexSpecific = array(
                    'specific_index' => $this->cleanSpecificIndex($nameSpecificArrvAl),//$nameSpecificArrvAl,
                );

                $this->db->where('trans_index_specific_id', $transIndexSpecificIDArr[$j]);
                $this->db->update('trans_indexing_specific', $dataIndexSpecific);
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

    public function deleteDocument($trans_doc_id,$data) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well
 
        $this->db->where('trans_doc_id', $trans_doc_id);
        $this->db->update('trans_indexing_specific',$data);

        $this->db->where('trans_doc_id', $trans_doc_id);
        $this->db->update('trans_document',$data);

        $this->db->where('trans_doc_id', $trans_doc_id);
        $this->db->update('user_approval',$data);

        $this->db->where('trans_doc_id', $trans_doc_id);
        $this->db->update('list_user_doc_share',$data);

        $this->db->where('trans_doc_id', $trans_doc_id);
        $this->db->update('view_document',$data);

        $this->db->trans_complete(); # Completing transaction
        if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();
            return FALSE;
        } 
        else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function insertShareDoc($setUserShareDocArr,$transDocShareDoc,$totalUser,$idUser,$date,$datetime){
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well 

        for($j=0; $j<$totalUser; $j++){
            $table    = "list_user_doc_share"; 
            $fieldID  = "list_user_doc_share_id";
            $idMaX    = $this->global_m->getIdMaxCharDate($table,$fieldID,$date); 
            $data = array(
                'list_user_doc_share_id' => $idMaX,
                'trans_doc_id'           => $transDocShareDoc,
                'userid'                 => $setUserShareDocArr[$j],
                'create_date'            => $datetime,
                'create_by'              => $idUser,
                'share_date'             => $datetime
            );
            $this->db->insert('list_user_doc_share', $data);
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

    public function editShareDoc($setUserShareDocArr,$transDocShareDoc,$totalUser,$idUser,$date,$datetime,$editOrInsertShareDoc){
        $this->db->trans_start();
        $this->db->trans_strict(TRUE);
        #array user share old
        $editOrInsertShareDocArr = explode('+', $editOrInsertShareDoc);
        $totalUserShareOld = count((array)$editOrInsertShareDocArr);
        #cek adakah userid lama di list usershare baru.Jika tidak ada userid lama di hapus
        if (is_array($setUserShareDocArr)) {
            for($a=0; $a<$totalUserShareOld; $a++){
                if (in_array($editOrInsertShareDocArr[$a], $setUserShareDocArr)) {
                    //echo $editOrInsertShareDocArr[$a]."adaLama<br>";
                }else{
                    //echo $editOrInsertShareDocArr[$a]."delete<br>";
                    $spListUserDocShareId = "sp_getListUserShareID ?,?";
                    $paramsListUserDocShareId = array(
                            'PARAM_1' => "".$transDocShareDoc."",
                            'PARAM_2' => "".$editOrInsertShareDocArr[$a]."");
                    $getListUserDocShareId = $this->db->query($spListUserDocShareId,$paramsListUserDocShareId);
                    $rowListUserDocShareId    = $getListUserDocShareId->row();
                    if(isset($rowListUserDocShareId)){
                        $listUserDocShareId = $rowListUserDocShareId->list_user_doc_share_id;
                        $this->db->where('trans_doc_id', $transDocShareDoc);
                        $this->db->where('userid', $editOrInsertShareDocArr[$a]);
                        $this->db->delete('list_user_doc_share'); 
                    }
                }
            }
        }else{
            $this->db->where('trans_doc_id', $transDocShareDoc);
            $this->db->delete('list_user_doc_share'); 
        }
        #cek adakah userid baru di list usershare lama.Jika tidak ada insert ke list user doc
        for($i=0; $i<$totalUser; $i++){
            if (in_array($setUserShareDocArr[$i], $editOrInsertShareDocArr)) {
                 //echo $setUserShareDocArr[$i]."adaBaru<br>";
            }else{
                //echo $setUserShareDocArr[$i]."insert<br>";
                $table    = "list_user_doc_share"; 
                $fieldID  = "list_user_doc_share_id";
                $idMaX    = $this->global_m->getIdMaxCharDate($table,$fieldID,$date); 
                $data = array(
                    'list_user_doc_share_id' => $idMaX,
                    'trans_doc_id'           => $transDocShareDoc,
                    'userid'                 => $setUserShareDocArr[$i],
                    'create_date'            => $datetime,
                    'create_by'              => $idUser,
                    'share_date'             => $datetime
                );
                $this->db->insert('list_user_doc_share', $data);
            }
        } 
        //echo $this->db->last_query();
        //die();
        //$this->db->last_query();die();
        $this->db->trans_complete(); # Completing transaction
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function getUserShare($trans_doc_id) {
       //  $sql = "SELECT a.document_allowed from trans_document a 
       //          where a.trans_doc_id ='$trans_doc_id' and a.status=0";
       // echo $sql;die();
        $query =  $this->db->query("EXEC sp_getUserShare $trans_doc_id");
        return $query->result(); // returning rows, not row
    }



    // public function getSpecificIndexNameTable($document_id,$subFolderID,$col,$idUser,$usergroup) {
    //     $col_val = "";
    //     for ($i=0; $i < count($col); $i++) { 
    //       $col_val .= "[".$col[$i]."],";
    //     }
    //     $col_val = rtrim($col_val, ',');

    //     if($usergroup == '2'){
    //         $sql = "SELECT * FROM (SELECT a.specific_index,b.specific_index_name,c.trans_doc_id,c.document_size
    //                 FROM trans_indexing_specific a 
    //                 LEFT JOIN indexing_specific b on a.specific_index_id = b.specific_index_id 
    //                 LEFT JOIN trans_document c on a.trans_doc_id = c.trans_doc_id 
    //                 LEFT JOIN master_folder f on c.folder_id = f.folder_id
    //                 WHERE a.status=0 AND b.status=0 AND c.status=0 AND c.sub_folder_id = $subFolderID 
    //                 AND c.document_id = $document_id AND (c.trans_doc_id in (SELECT luds.trans_doc_id FROM list_user_doc_share luds 
    //                 WHERE luds.userid = $idUser AND luds.status=0) OR f.group_user_doc_id in (SELECT gud.group_user_doc_id FROM list_group_user_doc gud 
    //                 WHERE gud.userid = $idUser AND gud.status = 0) AND f.status = 0)
    //                 ) AS doc_child 
    //                 PIVOT(
    //                     MAX(specific_index)
    //                     FOR specific_index_name in (".$col_val.")
    //                 ) piv;";
           
    //     }elseif($usergroup == '1' || $usergroup == '3'){
    //     $sql = "SELECT TOP 100 * FROM (SELECT a.specific_index,b.specific_index_name,c.trans_doc_id,c.document_size
    //         FROM trans_indexing_specific a 
    //         LEFT JOIN indexing_specific b on a.specific_index_id = b.specific_index_id 
    //         LEFT JOIN trans_document c on a.trans_doc_id = c.trans_doc_id 
    //         WHERE a.status=0 AND b.status=0 AND c.status=0 AND c.sub_folder_id = $subFolderID 
    //         AND c.document_id = $document_id
    //         ) AS doc_child 
    //         PIVOT(
    //             MAX(specific_index)
    //             FOR specific_index_name in (".$col_val.")
    //         ) piv;";
    //     }
    //     //echo $sql;die();
    //     $query = $this->db->query($sql);
    //     return $query->result_array();
    // } 

    // public function getSpecificIndexName($document_id,$trans_doc_id,$idUser) {
    //     $sqlCek = "SELECT * FROM view_document where trans_doc_id='$trans_doc_id' AND user_id='$idUser' AND status = 0";
    //     $sqlCek;die();
    //     $getViewDoc = $this->db->query($sqlCek)->num_rows();
    //     $date      = date("Y-m-d");
    //     $datetime  = date("Y-m-d H:i:s");
    //     if($getViewDoc==0){            
    //         $table            = "view_document"; 
    //         $fieldID          = "id_view_doc";
    //         $idMaxGeneral     = $this->global_m->getIdMaxCharDate($table,$fieldID,$date);    
    //         $dataViewDoc = array(
    //             'id_view_doc'  => $idMaxGeneral,
    //             'trans_doc_id' => $trans_doc_id,
    //             'user_id'      => $idUser,//$nameFieldArr[$i],//
    //             'update_date'  => $datetime,
    //             'update_by'    => $idUser,
    //         );
    //         $this->db->insert('view_document', $dataViewDoc);
    //     }
    //     $sql  = "SELECT a.specific_index_name,b.specific_index,a.specific_index_format,c.trans_doc_id,
    //             ISNULL((SELECT status_approve FROM user_approval WHERE trans_doc_id = $trans_doc_id 
    //             AND user_id = $idUser), '-') as approval
    //             FROM indexing_specific a
    //             LEFT JOIN trans_indexing_specific b on a.specific_index_id = b.specific_index_id
    //             LEFT JOIN trans_document c on b.trans_doc_id = c.trans_doc_id
    //             WHERE a.status=0 AND b.status=0 AND c.status=0 AND c.document_id = $document_id 
    //             AND c.trans_doc_id = $trans_doc_id
    //             ";

    //     $query = $this->db->query($sql);
    //     return $query->result_array(); // returning rows, not row
    // }

}
