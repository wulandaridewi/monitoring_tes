<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Delivery_internal_nondoc_m extends CI_Model {

    public function getDevAll() {
        $sql = "SELECT a.register_non_doc_id,a.ndoc_description,ISNULL(a.nrecipient,'-') as nrecipient,b.name,a.create_date,c.department,ISNULL(a.information,'-') as information,a.note
                from non_doc_register a 
                left join sec_passwd b on a.nowner = b.userid
                left join master_department c on b.dept_id = c.dept_id
                where a.ntype = 'DOC_IN' and a.ndoc_status = 'DELIVER' and a.ndelivery_status='INTERNAL' and nregister_status=0";
                //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    // public function getExpedition() {
    //     $sql = "SELECT expedition_id,expedition_name from master_expedition";
    //     $query = $this->db->query($sql);
    //     return $query->result(); // returning rows, not row
    // }

    public function update_doc_reg($data,$idDocReg){
        // echo $idDocReg;
        // print_r($data);die();
        $this->db->where('register_non_doc_id', $idDocReg);
        $this->db->update('non_doc_register', $data);
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function getDataReg($idDocReg) {
        $sql = "SELECT a.register_non_doc_id,a.ndoc_description,ISNULL(a.nrecipient,'-') as nrecipient,b.name,a.create_date,c.department,ISNULL(a.information,'-') as information,a.note
                from non_doc_register a 
                left join sec_passwd b on a.nowner = b.userid
                left join master_department c on b.dept_id = c.dept_id
                where a.register_non_doc_id='$idDocReg'";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

}

/* End of file sec_group_user_m.php */
/* Location: ./application/models/sec_group_user.php */