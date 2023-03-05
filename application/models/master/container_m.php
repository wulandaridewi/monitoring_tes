<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Container_m extends CI_Model {
    function clean($string) {
       //$string = str_replace(' ', '_', $string);
       // $string = preg_replace('~["]~', '', $string);
       // return str_replace("'", "", $string); // Removes special chars.
       return preg_replace('~["]~', '', $string); // Removes special chars.
    }

    public function getFolderAll() {
        $sql = "SELECT dh.*,sp.name from master_folder dh
                left join sec_passwd sp on dh.create_by = sp.userid
                where dh.status = 0 ORDER BY dh.folder_id DESC";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }
    public function getGroupDoc($folder_id) {
        $sql = "SELECT md.document_name from group_document gp 
        left join master_document md on gp.document_id = md.document_id 
        where gp.folder_id='".$folder_id."' and gp.status = 0";
        $query = $this->db->query($sql);
        $result1 = $query->result_array();
        $result2 = array_column($result1,"document_name");
        return $result2; // returning rows, not row

    }

    public function getGroupDocinContainer($folder_id) {
        $sql = "SELECT gp.document_id from group_document gp 
        where gp.folder_id='".$folder_id."' and gp.status = 0";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result_array(); // returning rows, not row
    }

    public function getFolderNameinContainer($folder_id) {
        $sql = "SELECT mf.folder_id,mf.folder_name,TRIM(mf.group_user_doc_id) as group_user_doc_id from master_folder mf 
        where mf.folder_id=".$folder_id." and mf.status = 0";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result_array(); // returning rows, not row

    }

    public function getJenisDocument() {
        $sql = "SELECT document_id,document_name from master_document where status=0";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getUserGroupDoc() {
        $sql = "SELECT group_user_doc_id,group_user_doc_name from group_user_doc where status=0";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function insert_all($dataMasterFolder,$groupDocument,$documentTotal,$idMaxFolder,$nameFieldArr,$formatFieldArr,$totalIndexing,$idUser,$date){
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well  
        #insert master folder     
        $this->db->insert('master_folder', $dataMasterFolder);
        #insert index_general
        for($i=0; $i<$totalIndexing; $i++){
            $table            = "indexing_general"; 
            $fieldID          = "general_index_id";
            $idMaxGeneral     = $this->global_m->getIdMaxChar($table,$fieldID);    
            $dataIndexGeneral = array(
                'general_index_id'      => $idMaxGeneral,
                'folder_id'             => $idMaxFolder,
                'general_index_name'    => $nameFieldArr[$i],//$this->clean($nameFieldArr[$i]),//
                'general_index_format'  => $formatFieldArr[$i],
                'create_date'           => $date,
                'create_by'             => $idUser,
            );
            $this->db->insert('indexing_general', $dataIndexGeneral);
        }
        #insert group document
        for($x=0; $x<$documentTotal; $x++){
            $tableGroupDoc    = "group_document"; 
            $fieldIDGroupDoc  = "group_document_id";
            $idMaxGroupDoc    = $this->global_m->getIdMaxChar2($tableGroupDoc,$fieldIDGroupDoc);    
            $dataGroupDoc = array(
                'group_document_id'     => $idMaxGroupDoc,
                'folder_id'             => $idMaxFolder,
                'document_id'           => $groupDocument[$x],//$this->clean($nameFieldArr[$i]),//
                'create_date'           => $date,
                'create_by'             => $idUser,
            );
            $this->db->insert('group_document', $dataGroupDoc);
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

    public function getDataCariFolderName($folderName) {
        $sql = "SELECT folder_name from master_folder where folder_name = '".$folderName."' and status=0";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function deletefolder($folder_id,$data) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well
        $this->db->where('folder_id', $folder_id);
        $this->db->update('master_folder',$data);

        $this->db->where('folder_id', $folder_id);
        $this->db->update('indexing_general',$data);

        $this->db->where('folder_id', $folder_id);
        $this->db->update('group_document',$data);

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

    public function getFieldAll($folder_id) {
        // $sql = "SELECT a.general_index_name,a.general_index_id,a.general_index_format,a.folder_id,
        //         b.folder_name,b.group_user_doc_id,(SELECT '+' + CAST(gd.document_id AS varchar) 
        //         FROM group_document gd WHERE gd.folder_id = $folder_id FOR XML PATH('')) as group_document 
        //         from master_folder b 
        //         left join indexing_general a on b.folder_id = a.folder_id 
        //         where a.folder_id=$folder_id and a.status = 0 and b.status = 0";
        $sql = "SELECT a.general_index_name,a.general_index_id,a.general_index_format,a.folder_id from indexing_general a
                where a.folder_id=$folder_id and a.status = 0";
        // $sql = "SELECT a.general_index_name,a.general_index_id,a.general_index_format,a.folder_id,b.folder_name,b.group_user_doc_id from master_folder b
        //         left join indexing_general a on b.folder_id = a.folder_id
        //         where a.folder_id=$folder_id and a.status = 0 and b.status = 0";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function removeFieldDB($idField) {
        $this->db->where('general_index_id', $idField);
        $this->db->delete('indexing_general');
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function update_all($dataMasterFolder,$idFolderEdit,$idField,$nameFieldArr,$formatFieldArr,$totalIndexing,$idUser,$date,$groupDocumentEdit,$documentTotal){
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well
        
        for($i=0; $i<$totalIndexing; $i++){  

            if (isset($idField[$i])) {
                $dataIndexGeneral = array(
                    'general_index_name'    => $nameFieldArr[$i],//$this->clean($nameFieldArr[$i]),
                    'general_index_format'  => $formatFieldArr[$i],
                );

                $this->db->where('general_index_id', $idField[$i]);
                $this->db->update('indexing_general', $dataIndexGeneral);
            }else{
                $table            = "indexing_general"; 
                $fieldID          = "general_index_id";
                $idMaxGeneral     = $this->global_m->getIdMaxChar($table,$fieldID);    
                $dataIndexGeneral = array(
                    'general_index_id'      => $idMaxGeneral,
                    'folder_id'             => $idFolderEdit,
                    'general_index_name'    => $nameFieldArr[$i],//$this->clean($nameFieldArr[$i]),
                    'general_index_format'  => $formatFieldArr[$i],
                    'create_date'           => $date,
                    'create_by'             => $idUser,
                );
                $this->db->insert('indexing_general', $dataIndexGeneral);
            }
            
        }
        #update master folder
        $this->db->where('folder_id', $idFolderEdit);
        $this->db->update('master_folder', $dataMasterFolder);
        #delete group document
        $this->db->where('folder_id', $idFolderEdit);
        $this->db->delete('group_document');

        #insert group document
        for($x=0; $x<$documentTotal; $x++){
            $tableGroupDoc    = "group_document"; 
            $fieldIDGroupDoc  = "group_document_id";
            $idMaxGroupDoc    = $this->global_m->getIdMaxChar2($tableGroupDoc,$fieldIDGroupDoc);    
            $dataGroupDoc = array(
                'group_document_id'     => $idMaxGroupDoc,
                'folder_id'             => $idFolderEdit,
                'document_id'           => $groupDocumentEdit[$x],//$this->clean($nameFieldArr[$i]),//
                'create_date'           => $date,
                'create_by'             => $idUser,
            );
            $this->db->insert('group_document', $dataGroupDoc);
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

}

/* End of file sec_group_user_m.php */
/* Location: ./application/models/sec_group_user.php */