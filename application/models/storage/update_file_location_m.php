<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Update_file_location_m extends CI_Model {

    public function getContainer() {
        $sql = "SELECT * from master_folder where status = 0";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

}
