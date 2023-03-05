<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Department extends CI_Controller {

	function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('master/department_m');
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
        $menuId              = $this->home_m->get_menu_id('master/department/home');
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
        $this->template->load('default_template/template9', 'master/department_v', $data);
    }

    public function getDeptAll() {
        $rows = $this->department_m->getDeptAll();
        $data['data'] = array();
        $no = 0;
        foreach ($rows as $row) {
            $no++;
            $array = array(
                'no'            => $no,
                'dept_id'       => trim($row->dept_id),
                'department'    => trim($row->department),
                'createDate'    => date('d-m-Y H:i:s',strtotime($row->create_date)),
                'createBy'      => trim($row->name),
                'createById'    => trim($row->create_by),
                'Actions'       => null
            );

            array_push($data['data'], $array);
        }
        $this->output->set_output(json_encode($data));
        
    }

    function save() {
        //echo "string";die();
        $idUser     = $this->session->userdata('id_user');
        $date       = date("Y-m-d H:i:s");
        $deptName   = trim($this->input->post('deptName'));
        $table      = "master_department"; 
        $fieldID    = "dept_id";
        $getID      = $this->global_m->getIdMaxInt($table,$fieldID);
        $data       = array(
            'dept_id'       => $getID,
            'department'    => $deptName,
            'create_date'   => $date,
            'create_by'     => $idUser,
        );
//        print_r($data);
//        die();
        $model = $this->department_m->insert_dept($data);
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

    function editDept() {
        $ediDeptName  = trim($this->input->post('ediDeptName'));
        $editDeptID   = trim($this->input->post('editDeptID'));
        // echo $editUserGroupName;
        $data = array(
            'department' => $ediDeptName,
        );
        //echo $editUserGroupID;die();
        $model = $this->department_m->editDept($data,$editDeptID);
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
        $dept_id = $_GET['dept_id'];
        $data = array(
            'status' => 1,
        );
        $model = $this->department_m->delete_dept($dept_id,$data);
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