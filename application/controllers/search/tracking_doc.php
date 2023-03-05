
<?php
error_reporting(E_ERROR | E_PARSE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tracking_doc extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('search/tracking_doc_m');  
        $this->load->helper('cookie');
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
        $menuId = $this->home_m->get_menu_id('search/tracking_doc/home');
        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_name']   = $menuId[0]->menu_name;
        $this->auth->restrict($data['menu_id']);
        //$this->auth->cek_menu($data['menu_id']);
        $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
        $data['menu_all']   = $this->user_m->get_menu_all(0);
        $this->template->set('title', 'home');
        $this->template->load('default_template/template9', 'search/tracking_doc_v', $data);
    }

    function getNoRegDoc() {
    	$regNum    		   = trim($this->input->post('regNum'));
    	$getKetDoc 		   = $this->tracking_doc_m->getKetDoc($regNum);
        $data['getKetDoc'] = $getKetDoc;
        $this->load->view('search/list_tracking_doc_v', $data); 
    }
}

