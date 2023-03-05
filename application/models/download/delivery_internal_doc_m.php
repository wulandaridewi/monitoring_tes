<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Delivery_internal_doc_m extends CI_Model {

    public function getDevAll() {
        // $sql = "SELECT a.register_doc_id,a.doc_description,ISNULL(a.recipient,'-') as recipient,b.name,a.create_date,c.department,ISNULL(a.information,'-') as information,a.note
        //         from doc_register a 
        //         left join sec_passwd b on a.owner = b.userid
        //         left join master_department c on b.dept_id = c.dept_id
        //         where a.type = 'DOC_IN' and a.doc_status = 'DELIVER' and a.delivery_status='INTERNAL' and a.register_status=0 and a.status_indexing != 0";
        //         //echo $sql;die();
        // $query = $this->db->query($sql);
        $query =  $this->db->query("EXEC sp_getDeliveryInternal");
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
        // $sql = "SELECT a.register_doc_id,a.information,a.doc_description,ISNULL(a.recipient,'-') as recipient,b.name,a.create_date,c.department,a.note
        //         from doc_register a 
        //         left join sec_passwd b on a.owner = b.userid
        //         left join master_department c on b.dept_id = c.dept_id
        //         where a.register_doc_id='$idDocReg'";
        // $query = $this->db->query($sql);
        $sp = "sp_getKetDoc_tracking ?";
        $params = array(
                'PARAM_1' => "".$regNum."");
        $query = $this->db->query($sp,$params);
        return $query->result(); // returning rows, not row
    }

}

/* End of file sec_group_user_m.php */
/* Location: ./application/models/sec_group_user.php */