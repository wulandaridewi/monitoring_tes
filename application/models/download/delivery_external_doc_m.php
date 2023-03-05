<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Delivery_external_doc_m extends CI_Model {

    public function getDevAll() {
        // $sql = "SELECT a.register_doc_id,a.doc_description,CAST(a.delivery_location as varchar(max)) as delivery_location,a.recipient,b.name,a.create_date,a.estimated_time
        //         from doc_register a 
        //         left join sec_passwd b on a.owner = b.userid where a.type = 'DOC_OUT' and a.delivery_status='EXTERNAL' and a.register_status=0 and (a.expedition IS NULL or a.expedition = '') and a.status_indexing!=0";
        // // where a.type = 'DOC_OUT' and a.delivery_status='EXTERNAL' and expedition=''";
        // $query = $this->db->query($sql);
        //echo $sql;die();
        $category = 'doc';
        $query =  $this->db->query("EXEC sp_getDeliveryExternal $category");
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
        $this->db->where('register_doc_id', $idDocReg);
        $this->db->update('doc_register', $data);
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function getDataReg($idDocReg) {
        $sql = "SELECT a.register_doc_id,a.doc_description,a.delivery_location,a.recipient,b.name,a.create_date,a.expedition,a.estimated_time
                from doc_register a 
                left join sec_passwd b on a.owner = b.userid
                where a.register_doc_id='$idDocReg'";
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