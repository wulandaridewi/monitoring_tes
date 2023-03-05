<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Update_deliver_nondoc_m extends CI_Model {

    public function getKetDoc($regNum) {
        $sql = "SELECT a.ndoc_description,b.username from non_doc_register a
        left join sec_passwd b on a.nowner = b.userid
        where a.register_non_doc_id = '$regNum' and ntype='DOC_IN'";
        $query            = $this->db->query($sql);
        $result           = $query->result();
        $doc_description  = $result[0]->ndoc_description;
        $username         = $result[0]->username;
        return $doc_description.'_'.$username;
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