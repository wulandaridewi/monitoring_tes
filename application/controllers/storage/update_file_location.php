<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Update_file_location extends CI_Controller {

	function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('storage/update_file_location_m');
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
        $menuId              = $this->home_m->get_menu_id('storage/update_file_location/home');
        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_name']   = $menuId[0]->menu_name;
        $this->auth->restrict($data['menu_id']);
        $this->auth->cek_menu($data['menu_id']);
      
        $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
        $data['menu_all']   = $this->user_m->get_menu_all(0);
        //$data['getCategoryDoc']     = $this->update_file_location_m->getCategoryDoc();
        $usergroup = trim($this->session->userdata('usergroup'));
        $idUser    = trim($this->session->userdata('id_user'));
        $data['getContainer']     = $this->update_file_location_m->getContainer();

        $this->template->set('title', 'home');
        $this->template->load('default_template/template9', 'storage/update_file_location_v', $data);
    }

    function getListDoc() {
        $usergroup = trim($this->session->userdata('usergroup'));
        $idUser    = trim($this->session->userdata('id_user'));
        $folder_id = $this->input->post('folder_id', TRUE);  
        //echo $document_id.'-'.$sub_folder;
        $data          = array();
        $col           = array();
        $colGeneral    = array();
        $specificIndexFormat = array();
        $getGeneralIndexNameTable = array();
        $getFieldNameIndexSpecific = $this->search_file_m->getFieldNameIndexSpecific($document_id);
        foreach ($getFieldNameIndexSpecific as $key => $value) {
           $col[$key] = $value['specific_index_name'];
            $specificIndexFormat[$key] = $value['specific_index_format'];
        } 
        $getSpecificIndexNameTable = $this->search_file_m->getSpecificIndexNameTable($document_id,$col,$folder_id,$usergroup,$idUser);
        $getFieldNameIndexGeneral  = $this->search_file_m->getFieldNameIndexGeneral($folder_id,$usergroup,$idUser);
        foreach ($getFieldNameIndexGeneral as $key => $value) {
           $colGeneral[$key] = $value['general_index_name'];
        }
        // foreach ($getSpecificIndexNameTable as $key => $value) {

        //     $trans_doc_id=$value['trans_doc_id'];
        //     $getGeneralIndexNameTable[$key] = $this->search_file_m->getGeneralIndexNameTable($folder_id,$colGeneral,$document_id,$trans_doc_id);
        // }
        
        $data = array(
            'getFieldNameIndexGeneral'  => $getFieldNameIndexGeneral,
            // 'getGeneralIndexNameTable'  => $getGeneralIndexNameTable,
            'getSpecificIndexNameTable' => $getSpecificIndexNameTable,
            'getFieldNameIndexSpecific' => $getFieldNameIndexSpecific,
            'colGeneral' => $colGeneral,
            'specificIndexFormat' => $specificIndexFormat,
         );  
        // echo "<pre>";
        // print_r($getGeneralIndexNameTable);
        // echo "</pre>";
        $this->load->view('search/list_file_v', $data); 
    }

   
}