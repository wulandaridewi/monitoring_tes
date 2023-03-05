<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sec_group_user_m extends CI_Model {

    public function getUserGroupAll($dir,$start,$length,$sValueGroupDesc) {
    	if($sValueGroupDesc == ''){
            $selectGroupDesc = "ORDER BY usergroup_id ".$dir." OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }else{
            $selectGroupDesc = "where usergroup_desc = '".$sValueGroupDesc."' ORDER BY usergroup_id ".$dir." OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }
        $sql = "SELECT * from sec_usergroup $selectGroupDesc";
        // echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getRecordsTotal() {
        $sql = "SELECT * FROM sec_usergroup";
        $query = $this->db->query($sql);
        $recordsTotal = $query->num_rows();
        return $recordsTotal;
    }

    public function getRecordsFilteredTotal($dir,$sValueGroupDesc) {
    	if($sValueGroupDesc == ''){
            $selectGroupDesc = "";
        }else{
            $selectGroupDesc = "where usergroup_desc = '".$sValueGroupDesc."' ORDER BY usergroup_id ".$dir."";
        }
        $sql = "SELECT * from sec_usergroup $selectGroupDesc";
        $query = $this->db->query($sql);
        $RecordsFilteredTotal = $query->num_rows();
        return $RecordsFilteredTotal;
    }

    public function insert_usergroup_m($data) {
		$this->db->insert('sec_usergroup', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function edit_usergroup_m($data,$editUserGroupID){
        $this->db->where('usergroup_id', $editUserGroupID);
        $this->db->update('sec_usergroup', $data);
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_usergroup($usergroupId){
        $this->db->trans_start();
        $this->db->where('usergroup_id', $usergroupId);
        $this->db->delete('sec_usergroup');
        $this->db->trans_complete();
        //echo $this->db->trans_status();die();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


}

/* End of file sec_group_user_m.php */
/* Location: ./application/models/sec_group_user.php */