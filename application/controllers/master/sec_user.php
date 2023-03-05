<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sec_user extends CI_Controller {

	function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('master/sec_user_m');
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
        $menuId              = $this->home_m->get_menu_id('master/sec_user/home');
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
            $data['group_user'] = $this->sec_user_m->get_status_user();
            $data['get_dept'] = $this->sec_user_m->get_dept_all();
            $this->template->set('title', 'home');
            $this->template->load('default_template/template9', 'master/sec_user_v', $data);
        }
    }

    public function getUserAll() {
        $post            = $this->input->post();
        // echo "<pre>";
        // print_r($post);
        // echo "</pre>";
        // echo $post['order'][0]['dir'];
        $draw            = $this->input->post('draw', TRUE);
        // $order           = $post['order'][0]['column'];
        $dir             = $post['order'][0]['dir'];
        $start           = $this->input->post('start', TRUE);
        $length          = $this->input->post('length', TRUE);        
        $sName           = $post['columns'][1]['search']['value']; 
        $sDept           = $post['columns'][2]['search']['value']; 
        $sEmail          = $post['columns'][4]['search']['value']; 
        $sUserName       = $post['columns'][5]['search']['value']; 
        $sUsergroupDesc  = $post['columns'][7]['search']['value'];       
        // echo $dir;
        $rows = $this->sec_user_m->getUserAll($dir,$start,$length,$sName,$sUserName,$sUsergroupDesc,$sDept,$sEmail);
        $data = [];
        foreach ($rows as $row)
        {
            //$passwd = base64_decode(trim($row->password));
            $data[] = [
                'userid'        => trim($row->userid),
                'name'          => trim($row->name),
                'username'      => trim($row->username),
                'password'      => trim($row->password),
                'usergroup'     => trim($row->usergroup),
                'usergroupDesc' => trim($row->usergroup_desc),                
                'email'         => trim($row->email),
                'department'    => trim($row->department),
                'dept_id'       => trim($row->dept_id),
                'gender'        => trim($row->gender),
                'Actions'       => null
            ];
        }

        $arrCompiledData = [           
            'recordsTotal'    => $this->sec_user_m->getRecordsTotal(),
            'recordsFiltered' => $this->sec_user_m->getRecordsFilteredTotal($dir,$sName,$sUserName,$sUsergroupDesc),
            'draw'            => $draw,
            'data'            => $data,
        ];
        $this->output->set_output(json_encode($arrCompiledData));
        
    }

    public function getDataRowTable() {
        $userid = $this->input->post('userid', TRUE);  
        // echo $userid;
        $rows   = $this->sec_user_m->getDataRowTable($userid);
        $data['data'] = array();        
        foreach ($rows as $row) {
            $passwd = base64_decode(trim($row->password));
            $data = array(
                'userid'      => trim($row->userid),
                'username'    => trim($row->username),
                'passwd'      => $passwd,
                'usergroupid' => trim($row->usergroup),
                'name'        => trim($row->name),
                'email'       => trim($row->email),
                'department'  => trim($row->department),
                'dept_id'     => trim($row->dept_id),
                'gender'      => trim($row->gender),
            );
        }
        $this->output->set_output(json_encode($data));
        // // echo $userid;      
        // $rows   = $this->sec_user_m->getDataRowTable($userid);
        // $this->output->set_output(json_encode($rows));
        
    }

    function save() {
        // $userId       = trim($this->input->post('userId'));
        $name         = trim($this->input->post('karyawan'));
        $userName     = trim($this->input->post('userName'));
        $password     = base64_encode(trim($this->input->post('password')));
        $confPassword = base64_encode(trim($this->input->post('confPassword')));
        $usergroup    = trim($this->input->post('userGroup'));
        $department   = trim($this->input->post('department'));
        $email        = trim($this->input->post('email'));
        $gender       = trim($this->input->post('gender'));

        if($gender=='L'){
            $fileImage = '001-boy.svg';
        }else{
            $fileImage = '005-girl-2.svg';
        }

        $user          = $this->session->userdata('namaKyw');
        $atwaktuupdate = date("Y/m/d H:i:s");

        $table   = "sec_passwd"; 
        $fieldID = "userid";
        $getID   = $this->global_m->getIdMaxChar($table,$fieldID);
        $data = array(
            'userid'        => $getID,
            'name'          => $name,
            'userName'      => $userName,
            'password'      => $password,
            'usergroup'     => $usergroup,
            'date_password' => $atwaktuupdate,
            'inputon'       => $atwaktuupdate,
            'inputby'       => $user,
            'email'         => $email,
            'dept_id'       => $department,
            'gender'        => $gender,
            'name_file_image' => $fileImage
        );
//        print_r($data);
//        die();
        $model = $this->sec_user_m->insert_user_m($data);
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

    function editUser() {
        $userIdEdit     = trim($this->input->post('userIdEdit'));
        $karyawanEdit   = trim($this->input->post('karyawanEdit'));
        $userNameEdit   = trim($this->input->post('userNameEdit'));
        $userGroupEdit  = trim($this->input->post('userGroupEdit'));
        $passwordEdit   = trim($this->input->post('passwordEdit'));
        $emailEdit      = trim($this->input->post('emailEdit'));
        $departmentEdit = trim($this->input->post('departmentEdit'));
        $genderEdit     = trim($this->input->post('genderEdit'));

        if($genderEdit=='L'){
            $fileImage = '001-boy.svg';
        }else{
            $fileImage = '005-girl-2.svg';
        }
        // echo $editUserGroupName;
        $data = array(
            'name'      => $karyawanEdit,
            'username'  => $userNameEdit,
            'password'  => base64_encode($passwordEdit),
            'usergroup' => $userGroupEdit,
            'email'     => $emailEdit,
            'dept_id'   => $departmentEdit,
            'gender'    => $genderEdit,
            'name_file_image' => $fileImage
        );
        //echo $editUserGroupID;die();
        $model = $this->sec_user_m->editUser($data,$userIdEdit);
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

    function delete() {
        $userid = trim($this->input->post('userid'));
        // echo $userid;die();
        $model = $this->sec_user_m->delete_user($userid);
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