<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sec_menu_m extends CI_Model {

    public function get_user_group_modal() {
        $this->db->select('usergroup_id,usergroup_desc');
        $this->db->from('sec_usergroup');
        $this->db->order_by("usergroup_id", "asc");
        return $this->db->get();
    }

    public function insert_menu_m($data) {
//        print_r($data['parent']);die();
        $id = $data['parent'];
        $model1 = "update sec_menu set menu_uri='#' where menu_id='$id'";
        $this->db->query($model1);
        $model = $this->db->insert('sec_menu', $data);
        if ($model) {
            return true;
        } else {
            return false;
        }
    }


    public function update_menu_m($idMenu, $data) {
        $model1 = $this->db->where('menu_id', $idMenu);
        $model2 = $this->db->update('sec_menu', $data);
        if ($model1 && $model2) {
            return true;
        } else {
            return false;
        }
    }

    public function getDescMenu($idMenu) {
        $this->db->select('menu_name,menu_header,menu_seq,menu_icon');
        $this->db->from('sec_menu sc');
        $this->db->where('sc.menu_id', $idMenu);
        $query = $this->db->get();
        if ($query->num_rows() == '1') {
            return $query->result();
        } else {
            return false;
        }
    }

    public function delete_menu_m($idMenu) {
        $model1 = $this->db->where('menu_id', $idMenu);
        $model2 = $this->db->delete('sec_menu');
        if ($model1 && $model2) {
            return true;
        } else {
            return false;
        }
    }

    public function cek_menuChild_m($idRootMenu) {
        $this->db->select('parent');
        $this->db->from('sec_menu');
        $this->db->where("parent", $idRootMenu);
        $query = $this->db->get();
        return $query->num_rows();
    }

}

/* End of file sec_menu_user_m.php */
/* Location: ./application/models/sec_menu_user.php */