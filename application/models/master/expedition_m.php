<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expedition_m extends CI_Model {

    public function getExpeditionAll() {
        $sql = "SELECT dh.*,sp.name from master_expedition dh
                left join sec_passwd sp on dh.create_by = sp.userid
                ORDER BY dh.expedition_id DESC";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getFieldAll($expedition_id) {
        $sql = "SELECT a.expedition_name,a.expedition_id from master_expedition a where a.expedition_id = '$expedition_id'";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function insert_expedition($data) {
        $this->db->insert('master_expedition', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function delete_expedition($expedition_id){
        $this->db->where('expedition_id', $expedition_id);
        $this->db->delete('master_expedition');
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function editExpedition($data,$editExpeditionID){
        $this->db->where('expedition_id', $editExpeditionID);
        $this->db->update('master_expedition', $data);
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

}
