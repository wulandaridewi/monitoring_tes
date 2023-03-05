<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search_file_m extends CI_Model {

    public function getDocument($folder_id) {
        //echo $folder_id;die();
        //$query =  $this->db->query("EXEC sp_getDocumentSearch $folder_id");
        $sp = "sp_getDocumentSearch ?";
        $params = array(
                'PARAM_1' => "".$folder_id."");
        $query = $this->db->query($sp,$params);
        return $query->result_array(); // returning rows, not row
    }
    public function getContainer($usergroup,$idUser) {
        $sp = "sp_getContainerSearch ?,?";
        $params = array(
                'PARAM_1' => $usergroup,
                'PARAM_2' => "".$idUser."");
        $query = $this->db->query($sp,$params);
        return $query->result(); 
    }
    public function getDataTransDoc($trans_doc_id) {
        //echo "string";die();
        $sp = "sp_getDataTransDocSearch ?";
        $params = array(
                'PARAM_1' => "".$trans_doc_id."");
        $query = $this->db->query($sp,$params);
        return $query->result(); // returning rows, not row  
    }
    public function getFolderID($document_id) {
        $sql = "SELECT a.folder_id,a.trans_doc_id,a.document_id,b.document_name from trans_document a 
                left join master_document b on a.document_id = b.document_id
                where a.status=0 and b.status=0 and a.document_id = $document_id";
        $query = $this->db->query($sql);
        return $query->result();// returning rows, not row        
    }

    public function getFieldNameIndexGeneral($folderId) {
        $sp = "sp_getFieldNameIndexGeneralSearch ?";
        $params = array(
                'PARAM_1' => "".$folderId."");
        $query = $this->db->query($sp,$params);
        return $query->result_array();
    }

    public function getValueTransIndexGeneral($sub_folder_id,$colGeneral) {
        $col_val = "";
        for ($i=0; $i < count($colGeneral); $i++) { 
          $col_val .= "[".$colGeneral[$i]."],";
        }
        if($col_val=="" || $col_val == "NULL" || empty($col_val)){
            $col_val = "[ ]";
        }else{
            $col_val = rtrim($col_val, ',');
        }
        //echo $col_val;die();
        $sp = "sp_getValueTransIndexGeneralSearch ?,?";
        $params = array(
                'PARAM_1' => "".$sub_folder_id."",
                'PARAM_2' => "".$col_val."");
        $query = $this->db->query($sp,$params);

        return $query->result_array();
    }

    public function getFieldNameIndexSpecific($document_id) {
        #by stored procedure
        $query =  $this->db->query("EXEC sp_getFieldNameIndexSpecific $document_id");
        return $query->result_array();
    }

  public function getSpecificIndexNameTable($document_id,$folderId,$col,$idUser,$usergroup,$start,$length,$dir,$search) {
        $col_val = "";
        for ($i=0; $i < count($col); $i++) { 
          $col_val .= "[".$col[$i]."],";
        }
        $col_val = rtrim($col_val, ',');
        if($usergroup == '2'){
                $sp = "sp_getSpecificIndexNameTableSearch_user ?,?,?,?,?,?,?,?";
                $params = array(
                        'PARAM_1' => "".$folderId."",
                        'PARAM_2' => $col_val,
                        'PARAM_3' => $document_id,
                        'PARAM_4' => $idUser,
                        'PARAM_5' => $start,
                        'PARAM_6' => $length,
                        'PARAM_7' => $dir,
                        'PARAM_8' => $search);
                //print_r($params);die();
                $query = $this->db->query($sp,$params);
        }elseif($usergroup == '1' || $usergroup == '3'){
            $sp = "sp_getSpecificIndexNameTableSearch_admin ?,?,?,?,?,?,?";
                $params = array(
                        'PARAM_1' => "".$folderId."",
                        'PARAM_2' => $col_val,
                        'PARAM_3' => $document_id,
                        'PARAM_4' => $start,
                        'PARAM_5' => $length,
                        'PARAM_6' => $dir,
                        'PARAM_7' => $search);
            //print_r($params);die();
            $query = $this->db->query($sp,$params);
        }
        //print_r($query);die();
        return $query->result_array();
    }

    public function getSpecificIndexNameTableCountAll($document_id,$folderId,$col,$idUser,$usergroup,$dir) {
        $col_val = "";
        for ($i=0; $i < count($col); $i++) { 
          $col_val .= "[".$col[$i]."],";
        }
        $col_val = rtrim($col_val, ',');
        if($usergroup == '2'){
                $sp = "sp_getSpecificIndexNameTableSearchCount ?,?,?,?,?";
                        $params = array(
                        'PARAM_1' => "".$folderId."",
                        'PARAM_2' => $col_val,
                        'PARAM_3' => $document_id,
                        'PARAM_4' => $idUser,
                        'PARAM_5' => $dir);
                $query = $this->db->query($sp,$params);
        }elseif($usergroup == '1' || $usergroup == '3'){
             $sp = "sp_getSpecificIndexNameTableSearchCount ?,?,?,?,?";
                        $params = array(
                        'PARAM_1' => "".$folderId."",
                        'PARAM_2' => $col_val,
                        'PARAM_3' => $document_id,
                        'PARAM_4' => '',
                        'PARAM_5' => $dir);
                $query = $this->db->query($sp,$params);
        }
        //print_r($query);die();
        return $query->num_rows();
    }

     public function getSpecificIndexNameTableCountFilter($document_id,$folderId,$col,$idUser,$usergroup,$dir,$search) {
        $col_val = "";
        for ($i=0; $i < count($col); $i++) { 
          $col_val .= "[".$col[$i]."],";
        }
        $col_val = rtrim($col_val, ',');
        if($usergroup == '2'){
                $sp = "sp_getSpecificIndexNameTableSearchCountFilter ?,?,?,?,?,?";
                        $params = array(
                        'PARAM_1' => "".$folderId."",
                        'PARAM_2' => $col_val,
                        'PARAM_3' => $document_id,
                        'PARAM_4' => $idUser,
                        'PARAM_5' => $dir,
                        'PARAM_6' => "".$search."");
                $query = $this->db->query($sp,$params);
        }elseif($usergroup == '1' || $usergroup == '3'){
                $sp = "sp_getSpecificIndexNameTableSearchCountFilter ?,?,?,?,?,?";
                        $params = array(
                        'PARAM_1' => "".$folderId."",
                        'PARAM_2' => $col_val,
                        'PARAM_3' => $document_id,
                        'PARAM_4' => '',
                        'PARAM_5' => $dir,
                        'PARAM_6' => "".$search."");
                $query = $this->db->query($sp,$params);
        }
        //print_r($query);die();
        return $query->num_rows();
    } 

    public function getGeneralIndexNameTable($trans_doc_id,$colGeneral,$usergroup,$idUser) {
        $col_val = "";
        for ($i=0; $i < count($colGeneral); $i++) { 
          $col_val .= "[".$colGeneral[$i]."],";
        }
        if($col_val=="" || $col_val == "NULL" || empty($col_val)){
            $col_val = "[ ]";
        }else{
            $col_val = rtrim($col_val, ',');
        }

         if($usergroup == '2'){
            $sp = "sp_getGeneralIndexNameTableSearch_user ?,?,?";
            $params = array(
                    'PARAM_1' => "".$trans_doc_id."",
                    'PARAM_2' => $col_val,
                    'PARAM_3' => "".$idUser."");
            $query = $this->db->query($sp,$params);        
        }else{
            $sp = "sp_getGeneralIndexNameTableSearch_admin ?,?";
            $params = array(
                    'PARAM_1' => "".$trans_doc_id."",
                    'PARAM_2' => $col_val);
            $query = $this->db->query($sp,$params);    
        }
        //print_r($params);die();
        return $query->result_array();
    } 

     public function getGeneralIndexName($folderId,$subFolderID) {
        #by stored procedure
        $query =  $this->db->query("EXEC sp_getGeneralIndexName '".$folderId."','".$subFolderID."'");
        return $query->result_array();
    }

    public function getSpecificIndexName($document_id,$trans_doc_id,$idUser) {
         $statusApprove = "-";
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
        $sp = "sp_getSpecificIndexNamec ?,?,?,?";
        $params = array(
                'PARAM_1' => "".$document_id."",
                'PARAM_2' => "".$trans_doc_id."",
                'PARAM_3' => "".$idUser."",
            'PARAM_4' => "".$statusApprove."");
        $query = $this->db->query($sp,$params);
        return $query->result_array(); // returning rows, not row
    }

    public function getStatusApprove($trans_doc_id) {
        $sql = "SELECT a.* from user_approval a
                where a.trans_doc_id='$trans_doc_id'";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result_array(); // returning rows, not row
    }

    public function getUserApproval($trans_doc_id) {
        $sql = "SELECT a.id_approval,a.trans_doc_id,a.user_id,a.status_approve,a.create_date,a.update_date,ISNULL(a.note,'-') as note,b.name,b.name_file_image,c.department from user_approval a 
                left join sec_passwd b on a.user_id = b.userid
                left join master_department c on b.dept_id = c.dept_id
                where a.trans_doc_id ='$trans_doc_id' and a.status=0";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getContainerDocument($folder_id,$document_id) {
        $sql   = "SELECT top 1 b.folder_name,c.document_name from trans_document a
                    left join master_folder b on a.folder_id = b.folder_id
                    left join master_document c on a.document_id = c.document_id
                    where c.document_id = '$document_id' and b.folder_id='$folder_id' ";
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result_array(); // returning rows, not row
    }

    public function getUserShare($trans_doc_id,$group_user_doc_id) {
        $sp = "sp_getUserShare ?,?";
                        $params = array(
                        'PARAM_1' => "".$trans_doc_id."",
                        'PARAM_2' => "".$group_user_doc_id."");
        // echo "<pre>";
        // print_r($params);die;
        // echo "<pre>";

        $query = $this->db->query($sp,$params);
        return $query->result_array(); // returning rows, not row
    }

     public function deleteShareDoc($trans_doc_id,$userid){
        $this->db->trans_start();
        $this->db->trans_strict(TRUE);
        #array user share old
        $this->db->where('trans_doc_id', $trans_doc_id);
        $this->db->where('userid', $userid);
        $this->db->delete('list_user_doc_share'); 

        $this->db->where('trans_doc_id', $trans_doc_id);
        $this->db->where('user_id', $userid);
        $this->db->delete('view_document'); 

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
