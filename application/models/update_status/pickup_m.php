<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pickup_m extends CI_Model {

    public function getKetDoc($regNum) {
        // $sql = "SELECT a.doc_description,a.pickup_by,b.name,b.email 
        // FROM doc_register a
        // LEFT JOIN sec_passwd b on a.owner = b.userid
        // WHERE a.register_doc_id = '$regNum' and type='DOC_IN' and doc_status='PICKUP' and a.status_indexing != 0";
        //echo $sql;die();
        $sp = "sp_getKetDoc ?";
        $params = array(
                'PARAM_1' => "".$regNum."");
        // print_r($params);die();
        $query = $this->db->query($sp,$params);
        $result           = $query->result();
        $doc_description  = $result[0]->doc_description;
        $username         = $result[0]->name;
        $pickup_by        = $result[0]->pickup_by;
        $email            = $result[0]->email;
        return $doc_description.'_'.$username.'_'.$pickup_by.'_'.$email;
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

}

/* End of file sec_group_user_m.php */
/* Location: ./application/models/sec_group_user.php */