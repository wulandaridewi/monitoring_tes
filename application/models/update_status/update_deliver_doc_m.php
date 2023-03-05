<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Update_deliver_doc_m extends CI_Model {

    public function getKetDoc($regNum) {
        $sql = "SELECT a.doc_description,b.username from doc_register a
        left join sec_passwd b on a.owner = b.userid
        where a.register_doc_id = '$regNum' and type='DOC_IN'";
        $query            = $this->db->query($sql);
        $result           = $query->result();
        $doc_description  = $result[0]->doc_description;
        $username         = $result[0]->username;
        return $doc_description.'_'.$username;
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