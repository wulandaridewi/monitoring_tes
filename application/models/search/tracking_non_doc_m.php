<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tracking_non_doc_m extends CI_Model {

    public function getKetDoc($regNum) {
        $sql = "SELECT a.register_non_doc_id,a.ntype,a.ndoc_description,b.name,a.ndoc_status,ISNULL(a.npickup_by,'-') as npickup_by,a.ndelivery_status,a.ndelivery_location,ISNULL(a.nrecipient,'-') as nrecipient,ISNULL(a.nexpedition,'-') as nexpedition,ISNULL(a.nreceipt_number,'-') as nreceipt_number,a.nstatus_email,a.nregister_status,b.email,a.create_date,a.update_date
            from non_doc_register a
            left join sec_passwd b on a.nowner = b.userid
            where a.register_non_doc_id = '$regNum'";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function update_doc_reg($regNum,$data){
        $this->db->where('register_non_doc_id', $regNum);
        $this->db->update('non_doc_register', $data);
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

}

/* End of file sec_group_user_m.php */
/* Location: ./application/models/sec_group_user.php */