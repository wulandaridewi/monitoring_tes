<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search_file_multiple_m extends CI_Model {

    public function getDocumentName($valueTextSearch,$idUser,$usergroup) {
        if($valueTextSearch == ''){
            $result = [];
            return $result;
        }
        if($usergroup == 2){
            $sql = "SELECT c.trans_doc_id,a.document_name,ROW_NUMBER() OVER(Partition BY a.document_name ORDER BY a.document_name) 
                AS [counter] 
                FROM trans_document c
                LEFT JOIN master_document a ON c.document_id = a.document_id
                WHERE c.status = 0 AND a.status = 0 AND c.folder_id IN (SELECT b.folder_id FROM master_folder b 
                LEFT JOIN list_group_user_doc d ON b.group_user_doc_id = d.group_user_doc_id WHERE d.userid = '$idUser') 
                OR c.trans_doc_id IN (SELECT trans_doc_id FROM list_user_doc_share WHERE userid = '$idUser')
                AND c.trans_doc_id IN (SELECT trans_doc_id FROM trans_indexing_specific WHERE specific_index LIKE '$valueTextSearch') 
                OR c.sub_folder_id IN (SELECT sub_folder_id FROM trans_indexing_general WHERE general_index LIKE '$valueTextSearch')
                ORDER BY c.trans_doc_id ASC";
        }else{
            $sql = "SELECT c.trans_doc_id,a.document_name,ROW_NUMBER() OVER(Partition BY a.document_name ORDER BY a.document_name) as [counter] FROM trans_document c
                LEFT JOIN master_document a ON c.document_id = a.document_id
                WHERE c.status = 0 AND c.trans_doc_id IN (SELECT trans_doc_id FROM trans_indexing_specific WHERE specific_index LIKE '$valueTextSearch') 
                OR c.sub_folder_id IN (SELECT sub_folder_id FROM trans_indexing_general WHERE general_index LIKE '$valueTextSearch') AND c.status = 0 AND a.status =0 ORDER BY c.trans_doc_id ASC";            
        }
        
        
        $query = $this->db->query($sql);
        return $query->result_array();            
    }

    public function getGeneralIndexName($trans_doc_id) {
        #by stored procedure

        $sql = "SELECT a.general_index_name,b.general_index 
                FROM trans_document td
                LEFT JOIN indexing_general a ON td.folder_id = a.folder_id
                LEFT JOIN trans_indexing_general b ON td.sub_folder_id = b.sub_folder_id AND a.general_index_id = b.general_index_id
                WHERE td.status =0 AND a.status = 0 AND b.status = 0 AND td.trans_doc_id = '$trans_doc_id'";
                //echo $sql;die();
                $query = $this->db->query($sql);
                return $query->result();// r
    }

    public function getSpecificIndexName($trans_doc_id) {
        #by stored procedure

        $sql = "SELECT a.specific_index_name,b.specific_index,a.specific_index_format
                FROM indexing_specific a
                LEFT JOIN trans_indexing_specific b on a.specific_index_id = b.specific_index_id
                LEFT JOIN trans_document c on b.trans_doc_id = c.trans_doc_id
                WHERE a.status=0 AND b.status=0 AND c.status=0 
                AND c.trans_doc_id = '$trans_doc_id'";
                //echo $sql;die();
                $query = $this->db->query($sql);
                return $query->result();// r
    }

    public function getDataTransDoc($trans_doc_id) {
        //echo "string";die();
        $sp = "sp_getDataTransDocSearch ?";
        $params = array(
                'PARAM_1' => "".$trans_doc_id."");
        $query = $this->db->query($sp,$params);
        return $query->result(); // returning rows, not row  
    }

    public function getGeneralIndexNameView($folderId,$subFolderID) {
        #by stored procedure
        $query =  $this->db->query("EXEC sp_getGeneralIndexName '".$folderId."','".$subFolderID."'");
        return $query->result_array();
    }

    public function getSpecificIndexNameView($document_id,$trans_doc_id,$idUser) {
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

}
