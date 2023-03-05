<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Group_user_doc_m extends CI_Model {

    public function getGroupUserDoc() {
        $sql = "SELECT dh.group_user_doc_name,dh.group_user_doc_id,dh.create_date,dh.create_by,sp.name from group_user_doc dh
                left join sec_passwd sp on dh.create_by = sp.userid
                where dh.status=0
                ORDER BY dh.group_user_doc_id DESC";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getUser() {
        $sql = "SELECT a.userid,a.name,a.dept_id,b.department from sec_passwd a
        left join master_department b on a.dept_id = b.dept_id
        where a.usergroup=2";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function insert_group_user_doc($dataGroupUserDoc,$groupUserDocArr,$userTotal,$idMax,$date,$idUser) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well
        #insert to group_user_doc
        $this->db->insert('group_user_doc', $dataGroupUserDoc);
        #insert to list_user_document
        for($x=0; $x<$userTotal; $x++){
            $tableGroupDoc    = "list_group_user_doc"; 
            $fieldIDGroupDoc  = "list_group_user_doc_id";
            $idMaxGroupDoc    = $this->global_m->getIdMaxChar($tableGroupDoc,$fieldIDGroupDoc);    
            $dataGroupDoc = array(
                'list_group_user_doc_id'  => $idMaxGroupDoc,
                'group_user_doc_id'       => $idMax,
                'userid'                  => $groupUserDocArr[$x],//$this->clean($nameFieldArr[$i]),//
                'create_date'             => $date,
                'create_by'               => $idUser,
            );
            $this->db->insert('list_group_user_doc', $dataGroupDoc);
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

    public function getFieldAll($group_user_doc_id) {
        $sql = "SELECT b.group_user_doc_id,b.group_user_doc_name,STUFF((SELECT '+'+ TRIM(a.userid) 
                FROM list_group_user_doc a
                WHERE a.group_user_doc_id =$group_user_doc_id
                FOR XML PATH('')), 1, 1, '') as group_user_doc
                from group_user_doc b 
                where b.status = 0 and b.group_user_doc_id =$group_user_doc_id";
        // $sql = "SELECT a.group_user_doc_id,a.group_user_doc_name,a.group_user_doc from group_user_doc a where a.status = 0 and a.group_user_doc_id =$group_user_doc_id";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function edit_group_user_doc($dataGroupUserDoc,$groupUserDocArr,$userTotal,$date,$idUser,$groupUserDocID){
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well
        #update to group_user_doc
        $this->db->where('group_user_doc_id', $groupUserDocID);
        $this->db->update('group_user_doc', $dataGroupUserDoc);
        #delete to list_user_document
        $this->db->where('group_user_doc_id', $groupUserDocID);
        $this->db->delete('list_group_user_doc');
        #insert to list_user_document
        for($x=0; $x<$userTotal; $x++){
            $tableGroupDoc    = "list_group_user_doc"; 
            $fieldIDGroupDoc  = "list_group_user_doc_id";
            $idMaxGroupDoc    = $this->global_m->getIdMaxChar($tableGroupDoc,$fieldIDGroupDoc);    
            $dataGroupDoc = array(
                'list_group_user_doc_id'  => $idMaxGroupDoc,
                'group_user_doc_id'       => $groupUserDocID,
                'userid'                  => $groupUserDocArr[$x],//$this->clean($nameFieldArr[$i]),//
                'create_date'             => $date,
                'create_by'               => $idUser,
            );
            $this->db->insert('list_group_user_doc', $dataGroupDoc);
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

    public function deleteGroupUserDoc($group_user_doc_id,$data,$dataMasterFolder){
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well

        $this->db->where('group_user_doc_id', $group_user_doc_id);
        $this->db->delete('group_user_doc');
        // $this->db->where('group_user_doc_id', $group_user_doc_id);
        // $this->db->update('group_user_doc', $data);
        // $this->db->where('group_user_doc_id', $group_user_doc_id);
        // $this->db->update('master_folder', $dataMasterFolder);

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
