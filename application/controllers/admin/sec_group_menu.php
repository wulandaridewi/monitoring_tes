<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sec_group_menu extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('admin/sec_group_menu_m');
    }

    public function index() {
        if ($this->auth->is_logged_in() == false) {
            $this->login();
        } else {
            $data['multilevel'] = $this->user_m->get_data(0, $this->session->userdata('usergroup'));


            $this->template->set('title', 'home');
            $this->template->load('default_template/template9', 'global/index', $data);
        }
    }

    function home() {
        //echo "string";
        $menuId              = $this->home_m->get_menu_id('admin/sec_group_menu/home');
        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_name']   = $menuId[0]->menu_name;
        $this->auth->restrict($data['menu_id']);
        $this->auth->cek_menu($data['menu_id']);
        $data['status_user'] = $this->sec_group_menu_m->get_status_user();
         if (isset($_POST["btnSimpan"])) {
            //$this->simpan();
        } else {
              
            $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
            $data['menu_all']   = $this->user_m->get_menu_all(0);

            $this->template->set('title', 'home');
            $this->template->load('default_template/template9', 'admin/sec_group_menu_v', $data);
        }
    }

    function getDescMenu() {
        $idMenu = $this->input->post('idMenu', TRUE);
        $rows   = $this->sec_group_menu_m->getDescMenu($idMenu);
        if ($rows) {
            foreach ($rows as $row)
            $header    = $row->menu_header;
            $urutan    = $row->menu_seq;
            $menu_icon = $row->menu_icon;
            $array = array(
                'baris'     => 1,
                'header'    => $header,
                'urutan'    => $urutan,
                'menu_icon' => $menu_icon
            );
        } else {
            $array = array('baris' => 0);
        }
        $this->output->set_output(json_encode($array));
    }

    function get_menu_group_user() {
        $kd_group_user = $this->input->post('kd_group_user', TRUE);
        $rows = $this->sec_group_menu_m->get_menu_group_user_m($kd_group_user,null);
//      die($rows);
       $data['data_menu'] = array();
        foreach ($rows as $keyword2) {
            $menu_alowed2 = explode('+', $keyword2->menu_allowed);

            foreach ($menu_alowed2 as $keyword) {
                if ((strlen(trim($keyword)) != 0) && ($keyword == $kd_group_user)) {
                    $array = array(
                        'menu_id' => $keyword2->menu_id,
                        'parent' => $keyword2->parent
                    );
                    array_push($data['data_menu'], $array);
                }else{

                }
            }
        }
        $this->output->set_output(json_encode($data));
    }

    function saveMenuGroup() {
        //echo "string";
        $status_user = trim($this->input->post('status_user'));
        $menu_allow = trim($this->input->post('menu_allow'));

        $data_menu = array();
        $data_menu = explode(',', $menu_allow);
        ///print_r($data_menu);
        //die($menu_allow);
        $model = $this->sec_group_menu_m->update_menu_status_user_m($data_menu, $status_user);
        if ($model) {
            $array = array(
                'act'       => 1,
                'tipePesan' => 'success',
                'pesan'     => 'success'
            );
        } else {
            $array = array(
                'act'       => 0,
                'tipePesan' => 'error',
                'pesan'     => 'error'
            );
        }
        $this->output->set_output(json_encode($array));
    }

    
}

/* End of file sec_group_menu_user.php */
/* Location: ./application/controllers/sec_group_menu_user.php */