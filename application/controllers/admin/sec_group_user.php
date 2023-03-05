<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sec_group_user extends CI_Controller {

	function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('admin/sec_group_user_m');
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
        $menuId              = $this->home_m->get_menu_id('admin/sec_group_user/home');
        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_name']   = $menuId[0]->menu_name;
        $this->auth->restrict($data['menu_id']);
        $this->auth->cek_menu($data['menu_id']);
      
        if (isset($_POST["submituserGroupName"])) {
            // $this->saveUserGroup();
        } elseif (isset($_POST["submitEdituserGroupName"])) {
            //$this->editUserGroup();
        } elseif (isset($_POST["btnModalDeleteMenuRoot"])) {
            $this->deleteMenuRoot();
        } else {
              
            $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
            $data['menu_all']   = $this->user_m->get_menu_all(0);

            $this->template->set('title', 'home');
            $this->template->load('default_template/template9', 'admin/sec_group_user_v', $data);
        }
    }

    public function getUserGroupAll() {
        $post            = $this->input->post();
        // print_r($post);
        // echo $draw[0]['search']['regex'];
        $draw            = $this->input->post('draw', TRUE);
        $order           = $post['order'][0]['column'];
        $dir             = $post['order'][0]['dir'];
        $start           = $this->input->post('start', TRUE);
        $length          = $this->input->post('length', TRUE);        
        $sValueGroupDesc = $post['columns'][1]['search']['value'];       
        // echo $sValueGroupDesc;
        $rows = $this->sec_group_user_m->getUserGroupAll($dir,$start,$length,$sValueGroupDesc);
        $data = [];
        foreach ($rows as $row)
        {
            $data[] = [
                'usergroupId'   => trim($row->usergroup_id),
                'usergroupDesc' => trim($row->usergroup_desc),
                'Actions'       => null
            ];
        }

        $arrCompiledData = [           
            'recordsTotal'    => $this->sec_group_user_m->getRecordsTotal(),
            'recordsFiltered' => $this->sec_group_user_m->getRecordsFilteredTotal($dir,$sValueGroupDesc),
            'draw'            => $draw,
            'sValueGroupDesc' => $sValueGroupDesc,
            'data'            => $data,
        ];
        $this->output->set_output(json_encode($arrCompiledData));
        
    }

    function saveUserGroup() {
        $userGroupName    = trim($this->input->post('userGroupName'));
        $table = "sec_usergroup"; 
        $fieldID = "usergroup_id";
        $getID  = $this->global_m->getIdMaxInt($table,$fieldID);
        $data = array(
            'usergroup_id'   => $getID,
            'usergroup_desc' => $userGroupName,
        );
//        print_r($data);
//        die();
        $model = $this->sec_group_user_m->insert_usergroup_m($data);
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

    function editUserGroup() {
        $editUserGroupName  = trim($this->input->post('editUserGroupName'));
        $editUserGroupID    = trim($this->input->post('editUserGroupID'));
        // echo $editUserGroupName;
        $data = array(
            'usergroup_desc' => $editUserGroupName,
        );
        //echo $editUserGroupID;die();
        $model = $this->sec_group_user_m->edit_usergroup_m($data,$editUserGroupID);
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

    function deleteUserGroup() {
        $usergroupId = trim($this->input->post('usergroupId'));
        $model = $this->sec_group_user_m->delete_usergroup($usergroupId);
        //echo $model;die();
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

    // public function getUserGroupAll() {
    //     $rows = $this->sec_group_user_m->getUserGroupAll();
    //     $data['data'] = array();
    //     foreach ($rows as $row) {
    //         $array = array(
    //             'usergroupId' => trim($row->usergroup_id),
    //             'usergroupDesc' => trim($row->usergroup_desc)
    //         );

    //         array_push($data['data'], $array);
    //     }
    //     $this->output->set_output(json_encode($data));
    // }
}