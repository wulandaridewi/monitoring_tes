<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expedition extends CI_Controller {

	function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('master/expedition_m');
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
        $menuId              = $this->home_m->get_menu_id('master/expedition/home');
        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_name']   = $menuId[0]->menu_name;
        $this->auth->restrict($data['menu_id']);
        $this->auth->cek_menu($data['menu_id']);
      
        $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
        $data['menu_all']   = $this->user_m->get_menu_all(0);

        $this->template->set('title', 'home');
        $this->template->load('default_template/template9', 'master/expedition_v', $data);
    }

    public function getExpeditionAll() {
        $rows = $this->expedition_m->getExpeditionAll();
        $data['data'] = array();
        $no = 0;
        foreach ($rows as $row) {
            $no++;
            $array = array(
                'no'              => $no,
                'expedition_id'   => trim($row->expedition_id),
                'expedition_name' => trim($row->expedition_name),
                'createDate'      => date('d-m-Y H:i:s',strtotime($row->create_date)),
                'createBy'        => trim($row->name),
                'createById'      => trim($row->create_by),
                'Actions'         => null
            );

            array_push($data['data'], $array);
        }
        $this->output->set_output(json_encode($data));
        
    }

    function save() {
        //echo "string";die();
        $idUser     = $this->session->userdata('id_user');
        $date       = date("Y-m-d H:i:s");
        $expediton  = trim($this->input->post('expediton'));
        $table      = "master_expedition"; 
        $fieldID    = "expedition_id";
        $getID      = $this->global_m->getIdMaxInt($table,$fieldID);
        $data       = array(
            'expedition_id'   => $getID,
            'expedition_name' => $expediton,
            'create_date'     => $date,
            'create_by'       => $idUser,
        );
//        print_r($data);
//        die();
        $model = $this->expedition_m->insert_expedition($data);
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

    function editExpedition() {
        $editExpedition   = trim($this->input->post('editExpedition'));
        $editExpeditionID = trim($this->input->post('editExpeditionID'));
        // echo $editUserGroupName;
        $data = array(
            'expedition_name' => $editExpedition,
        );
        //echo $editUserGroupID;die();
        $model = $this->expedition_m->editExpedition($data,$editExpeditionID);
        //echo $model;
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

    function hapus() {
        $expedition_id = $_GET['expedition_id'];
        $model = $this->expedition_m->delete_expedition($expedition_id);
        if ($model) {
            $array = array(
                'act' => 1,
                'tipePesan' => 'success',
                'pesan' => 'success'
            );
        } else {
            $array = array(
                'act' => 0,
                'tipePesan' => 'error',
                'pesan' => 'error'
            );
        }

        $this->output->set_output(json_encode($array));
    }

    function getFieldAll() {       
        $expedition_id = $_GET['expedition_id'];
        $rows = $this->expedition_m->getFieldAll($expedition_id);
        
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
      
        $this->output->set_output(json_encode($data));
    }

}