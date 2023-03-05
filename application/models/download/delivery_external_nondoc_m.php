<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Delivery_external_nondoc_m extends CI_Model {

    public function getDevAll() {
        $sql = "SELECT a.register_non_doc_id,a.ndoc_description,ndelivery_location,a.nrecipient,b.name,a.create_date,a.location_pickup,a.estimated_time
                from non_doc_register a 
                left join sec_passwd b on a.nowner = b.userid
                where a.ntype = 'DOC_OUT' and a.ndelivery_status='EXTERNAL' and a.nregister_status=0 and (a.nexpedition IS NULL or a.nexpedition = '')";
        // where a.type = 'DOC_OUT' and a.delivery_status='EXTERNAL' and expedition=''";
        $query = $this->db->query($sql);
        //echo $sql;die();
        return $query->result(); // returning rows, not row
    }

    public function getExpedition() {
        $sql = "SELECT expedition_id,expedition_name from master_expedition";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

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
        $sql = "SELECT a.register_non_doc_id,a.ndoc_description,a.ndelivery_location,a.nrecipient,b.name,a.create_date,a.nexpedition,a.location_pickup,a.estimated_time
                from non_doc_register a 
                left join sec_passwd b on a.nowner = b.userid
                where a.register_non_doc_id='$idDocReg'";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    // public function getDataReg($idDocReg) {
    //     $sql = "SELECT a.register_doc_id,a.doc_description,a.delivery_location,a.recipient,b.name,a.create_date,a.expedition
    //             from doc_register a 
    //             left join sec_passwd b on a.owner = b.userid
    //             where a.register_doc_id='$idDocReg'";
    //     $query = $this->db->query($sql);
    //     // return $query->result(); // returning rows, not row
    //     return $query->row_array();
    // }

}

/* End of file sec_group_user_m.php */
/* Location: ./application/models/sec_group_user.php */