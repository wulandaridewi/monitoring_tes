<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_m extends CI_Model {

    public function get_data($induk = 0, $user_group) {
        $data = array();
        $SQL ="select * from sec_menu where parent=$induk and menu_allowed like '%+$user_group%' ORDER BY menu_seq ASC";
        $result= $this->db->query($SQL);        
       //print_r($SQL); die();
        foreach ($result->result() as $row) {
            $data[] = array(
                'id'          => $row->menu_id,
                'nama'        => $row->menu_name,
                'menu_header' => $row->menu_header,
                'parent'      => $row->parent,
                'link'        => $row->menu_uri,
                'menu_icon'   => $row->menu_icon,
                'child'       => $this->get_data($row->menu_id, $user_group)
            );
        }
        return $data;
    }

    public function get_menu_all($induk = 0) {
        $data = array();
        $this->db->select('*');
        $this->db->from('sec_menu');
        $this->db->where('parent', $induk);
        $this->db->order_by("menu_seq", "asc");
        $result = $this->db->get();
//        print_r($result->result());die();        
        foreach ($result->result() as $row) {
            $data[] = array(
                'id'     => $row->menu_id,
                'nama'   => $row->menu_name,
                'header' => $row->menu_header,
                'urutan' => $row->menu_seq,
                'parent' => $row->parent,
                'link'   => $row->menu_uri,
                'menu_icon'   => $row->menu_icon,
                'child' => $this->get_menu_all($row->menu_id)
            );
        }
        return $data;
    } 

    function get_array_menu($id) {
        $this->db->select('menu_allowed');
        $this->db->from('sec_menu');
        $this->db->where('menu_id', $id);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            $row = $data->row();
            $level = $row->menu_allowed;
            $arr = explode('+', $level);
            return $arr;
        } else {
            die();
        }
    }

}
