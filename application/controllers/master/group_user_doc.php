<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Group_user_doc extends CI_Controller {

	function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('master/group_user_doc_m');
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
        $menuId              = $this->home_m->get_menu_id('master/group_user_doc/home');
        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_name']   = $menuId[0]->menu_name;
        $this->auth->restrict($data['menu_id']);
        $this->auth->cek_menu($data['menu_id']);
        $data['getUser']    = $this->group_user_doc_m->getUser();
        $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
        $data['menu_all']   = $this->user_m->get_menu_all(0);

        $this->template->set('title', 'home');
        $this->template->load('default_template/template9', 'master/group_user_doc_v', $data);
    }

    public function getGroupUserDoc() {
        $rows = $this->group_user_doc_m->getGroupUserDoc();
        $data['data'] = array();
        $no = 0;
        foreach ($rows as $row) {
            $no++;
            $array = array(
                'no'                  => $no,
                'group_user_doc_id'   => trim($row->group_user_doc_id),
                'group_user_doc_name' => trim($row->group_user_doc_name),
                //'group_user_doc'      => str_replace('+', ' , ', trim($row->group_user_doc)),
                'createDate'          => date('d-m-Y H:i:s',strtotime($row->create_date)),
                'createBy'            => trim($row->name),
                'createById'          => trim($row->create_by),
                'Actions'             => null
            );

            array_push($data['data'], $array);
        }
        $this->output->set_output(json_encode($data));
        
    }

    function save() {
        //echo "string";die();
        $idUser           = $this->session->userdata('id_user');
        $nameGroupUserDoc = trim($this->input->post('nameGroupUserDoc'));
        $userTotal        = count((array)$this->input->post('groupUserDoc'));
        $groupUserDocArr  = $this->input->post('groupUserDoc');
        //echo $userTotal;die();
       // print_r($groupUserDocArr) ;die();
        //$groupUserDoc     = '+'.trim(implode("+",$groupUserDocArr));
        $date             = date("Y-m-d H:i:s");

        $table      = "group_user_doc"; 
        $fieldID    = "group_user_doc_id";
        $idMax      = $this->global_m->getIdMaxChar($table,$fieldID);        
        $dataGroupUserDoc = array(
            'group_user_doc_id'   => $idMax,
            'group_user_doc_name' => $nameGroupUserDoc,
            'create_date'         => $date,
            'create_by'           => $idUser,
        );

        $model = $this->group_user_doc_m->insert_group_user_doc($dataGroupUserDoc,$groupUserDocArr,$userTotal,$idMax,$date,$idUser);
        
        if($model){
            $array = array(
            'act' => 1,
            'tipePesan' => 'success',
            'pesan' => 'success'
            );
        }else{
           $array = array(
            'act' => 0,
            'tipePesan' => 'error',
            'pesan' => 'error'
            ); 
        }
        $this->output->set_output(json_encode($array));   
    }

    function getFieldAll() {       
        $group_user_doc_id = $_GET['group_user_doc_id'];
        $rows = $this->group_user_doc_m->getFieldAll($group_user_doc_id);
        
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
      
        $this->output->set_output(json_encode($data));
    }

    function edit() {
        //echo "string";die();
        $idUser           = $this->session->userdata('id_user');
        $nameGroupUserDoc = trim($this->input->post('nameGroupUserDocEdit'));
        $groupUserDocID   = trim($this->input->post('groupUserDocID'));
        $userTotal        = count((array)$this->input->post('groupUserDocEdit'));
        $groupUserDocArr  = $this->input->post('groupUserDocEdit');
        //$groupUserDoc     = '+'.trim(implode("+",$groupUserDocArr));
        $date             = date("Y-m-d H:i:s");
      
         $dataGroupUserDoc = array(
            'group_user_doc_name' => $nameGroupUserDoc,
            'create_date'         => $date,
            'create_by'           => $idUser,
        );


        $model = $this->group_user_doc_m->edit_group_user_doc($dataGroupUserDoc,$groupUserDocArr,$userTotal,$date,$idUser,$groupUserDocID);
        
        if($model){
            $array = array(
            'act' => 1,
            'tipePesan' => 'success',
            'pesan' => 'success'
            );
        }else{
           $array = array(
            'act' => 0,
            'tipePesan' => 'error',
            'pesan' => 'error'
            ); 
        }
        $this->output->set_output(json_encode($array));   
    }

    function delete() {
        $group_user_doc_id = $_GET['group_user_doc_id'];
        $data = array(
            'status' => 1,
        );
        $dataMasterFolder = array(
            'group_user_doc_id' => '',
        );
        $model = $this->group_user_doc_m->deleteGroupUserDoc($group_user_doc_id,$data,$dataMasterFolder);
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

}