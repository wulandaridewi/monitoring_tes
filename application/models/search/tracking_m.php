<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tracking_m extends CI_Model {

    public function getKetDoc($regNum) {
        // $sql = "SELECT a.register_doc_id,a.type,a.doc_description,b.name,a.doc_status,ISNULL(a.pickup_by,'-') as pickup_by,a.delivery_status,a.delivery_location,ISNULL(a.recipient,'-') as recipient,ISNULL(a.expedition,'-') as expedition,ISNULL(a.receipt_number,'-') as receipt_number,a.status_email,a.register_status,a.status_indexing,b.email,a.create_date,a.update_date,ISNULL(a.information,'-') as information
        //     from doc_register a
        //     left join sec_passwd b on a.owner = b.userid
        //     where a.register_doc_id = '$regNum'";
        // //echo $sql;die();
        // $query = $this->db->query($sql);
        $sp = "sp_getKetDoc_tracking ?";
        $params = array(
                'PARAM_1' => "".$regNum."");
        // print_r($params);die();
        $query = $this->db->query($sp,$params);
        return $query->result_array();
    }

    public function update_doc_reg($regNum,$data){
        $this->db->where('register_doc_id', $regNum);
        $this->db->update('doc_register', $data);
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function getKetNonDoc($regNum) {
        $sql = "SELECT a.register_non_doc_id,a.ntype,a.ndoc_description,b.name,a.ndoc_status,ISNULL(a.npickup_by,'-') as npickup_by,a.ndelivery_status,a.ndelivery_location,ISNULL(a.nrecipient,'-') as nrecipient,ISNULL(a.nexpedition,'-') as nexpedition,ISNULL(a.nreceipt_number,'-') as nreceipt_number,a.nstatus_email,a.nregister_status,b.email,a.create_date,a.update_date
            from non_doc_register a
            left join sec_passwd b on a.nowner = b.userid
            where a.register_non_doc_id = '$regNum'";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function update_nondoc_reg($regNum,$data){
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