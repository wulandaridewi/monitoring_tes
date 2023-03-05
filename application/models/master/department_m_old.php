<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Department_m extends CI_Model {

    public function getDeptAll() {
        $sql = "SELECT dh.*,sp.name from master_department dh
                left join sec_passwd sp on dh.create_by = sp.userid
                ORDER BY dh.dept_id DESC";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function insert_dept($data) {
        $this->db->insert('master_department', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function delete_dept($dept_id){
        $this->db->where('dept_id', $dept_id);
        $this->db->delete('master_department');
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function editDept($data,$editDeptID){
        $this->db->where('dept_id', $editDeptID);
        $this->db->update('master_department', $data);
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

}
