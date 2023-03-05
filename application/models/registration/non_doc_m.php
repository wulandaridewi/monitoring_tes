<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Non_doc_m extends CI_Model {

    public function getUser() {
        $sql = "SELECT a.userid,a.name,a.dept_id,b.department from sec_passwd a
        left join master_department b on a.dept_id = b.dept_id";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function insert_doc_in($data){
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well   

        $this->db->insert('non_doc_register', $data);

        $this->db->trans_complete(); # Completing transaction
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function getEmail($ownerID){
        $sql= "SELECT email,name from sec_passwd where userid = '$ownerID'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        $email  = $result[0]->email;
        $name   = $result[0]->name;
        return $email.'_'.$name;
    }  

}

/* End of file sec_group_user_m.php */
/* Location: ./application/models/sec_group_user.php */