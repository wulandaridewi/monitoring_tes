<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Auth library
 */
class Auth {

    var $CI = NULL;

    function __construct() {
        // get CI's object
        $this->CI = & get_instance();
    }



    function do_login($username, $password, $tgl_d, $tgl_y, $bind) {
        //echo $username."-".$password."-".$tgl_y."-".$tgl_d."-".$bind;die();
        $password = base64_encode($password);

        // cek di database, ada ga?        
        // $SQL ="select p.userid,p.username,p.usergroup,p.name,u.usergroup_desc,p.name_file_image,p.email from sec_passwd p left join sec_usergroup u on p.usergroup=u.usergroup_id where p.username = '$username'";
        // // echo $SQL;die();
        // $result= $this->CI->db->query($SQL);   

        $this->CI->db->select('p.userid,p.username,p.usergroup,p.name,u.usergroup_desc,p.name_file_image,p.email');
        $this->CI->db->from('sec_passwd p');
        $this->CI->db->join('sec_usergroup u', 'p.usergroup=u.usergroup_id');
        $this->CI->db->where('p.username', $username);
        //$this->CI->db->where('p.password', $password);
        if(!$bind){
          $this->CI->db->where('p.password', $password);
        }else{

        }
        
        $result = $this->CI->db->get();
        // echo "<pre>";
        // echo print_r($result->result());
        // echo "</pre>";
        // die();
        if ($result->num_rows() == 0) {
            // username dan password tsb tidak ada
            return false;
        } else {
            // ada, maka ambil informasi dari database
            $userdata = $result->row();
            $session_data = array(
                'id_user'        => $userdata->userid,
                'namaKyw'        => $userdata->name,
                'usergroup'      => $userdata->usergroup,
                'usergroup_desc' => $userdata->usergroup_desc,
                'tgl_y'          => $tgl_y,
                'tgl_d'          => $tgl_d,
                'images_user'    => $userdata->name_file_image,
                'email'    => $userdata->email,
            );
            // buat session
            $this->CI->session->set_userdata($session_data);
            return true;
        }
    }

    // untuk mengecek apakah user sudah login/belum
    function is_logged_in() {
        if ($this->CI->session->userdata('id_user') == '') {
            return false;
        }
        return true;
    }

    // untuk validasi di setiap halaman yang mengharuskan authentikasi
    function restrict() {
        if ($this->is_logged_in() == false) {
            redirect('main/login');
        }
    }

        // untuk mengecek menu
    function cek_menu($idmenu) {
        $this->CI->load->model('user_m');
        $status_user   = $this->CI->session->userdata('usergroup');
        $allowed_level = $this->CI->user_m->get_array_menu($idmenu);
        if (in_array($status_user, $allowed_level) == false) {
            die("Maaf, Anda tidak berhak untuk mengakses halaman ini.");
        }
    }

    function do_logout() {
        $this->CI->session->sess_destroy();
        session_destroy();
    }

   
}
