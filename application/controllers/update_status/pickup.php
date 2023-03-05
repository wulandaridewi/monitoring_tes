
<?php
error_reporting(E_ERROR | E_PARSE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pickup extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('update_status/pickup_m');  
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
        $menuId = $this->home_m->get_menu_id('update_status/pickup/home');
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
        $this->template->load('default_template/template9', 'update_status/pickup_v', $data);
    }

    function getNoRegDoc() {
    	$regNum    		 = trim($this->input->post('regNum'));
    	$getKetDoc 		 = $this->pickup_m->getKetDoc($regNum);
    	$getKetDocArr 	 = explode('_', $getKetDoc);
    	//print_r($getKetDocArr);die();
        $doc_description = $getKetDocArr[0];
        $username 		 = $getKetDocArr[1];
        $pickup_by 		 = $getKetDocArr[2];
        $email           = $getKetDocArr[3];

        $array = array(
            'username'        => $username,
            'doc_description' => $doc_description,
            'pickup_by'		  => $pickup_by,
            'email'           => $email,
        );

        $this->output->set_output(json_encode($array));
    }

    function updateDeliver() {
        $regNum       = $this->input->get('regNum');
        //echo $regNum;die();
        $getKetDoc    = $this->pickup_m->getKetDoc($regNum);
        $getKetDocArr = explode('_', $getKetDoc);
        //print_r($getKetDocArr);die();
        $doc_description = $getKetDocArr[0];
        $username        = $getKetDocArr[1];
        $pickup_by       = $getKetDocArr[2];
        $email           = $getKetDocArr[3];

        $array = array(
            'username'        => $username,
            'doc_description' => $doc_description,
            'pickup_by'       => $pickup_by,
            'email'           => $email,
        );
        $menuId = $this->home_m->get_menu_id('update_status/pickup/home');
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
        $this->template->load('default_template/template9', 'update_status/update_deliver_doc_v', $data);
        //$this->output->set_output(json_encode($array));
    }

    function save() {
    	$regNum      = trim($this->input->post('regNum'));
    	$ownerName   = trim($this->input->post('ownerName'));
    	$description = trim($this->input->post('description'));
    	$pickup_by   = trim($this->input->post('pickup_by'));
    	$email       = trim($this->input->post('email'));
        //send email
            $this->load->config('email');
            $this->load->library('email');
            $this->email->from('Chairul.Elyasa@astragraphia.co.id', 'Mailroom');
            $this->email->to($email);
            $this->email->subject('Contoh Kirim Status Pickup Document');
            $massage = 'Dear '.$ownerName.',<br><br><br> Dokumen '.$description.'.<br> dengan nomor registrasi '.$regNum.' sudah diambil oleh '.$pickup_by.'<br><br><br> Hormat kami, <br><br>Mailroom';
            $this->email->message($massage);
            if($this->email->send()) {
                $statusEmail = 1;
             }else{
                $statusEmail = 0;
             }
        //end send email
    	$data = array(
            'pickup_by'       => $pickup_by,
            'register_status' => 1,
            'status_email'    => $statusEmail,
        );
        $model = $this->pickup_m->update_doc_reg($regNum,$data);
        if ($model) {
            if($statusEmail == 1) {
                //$statusEmail = 1;
                $array = array(
                    'act'        => 1,
                    'tipePesan'  => 'success',
                    'pesan'      => 'success',
                );
             }else{
                //$statusEmail = 0;
                $array = array(
                    'act'        => 1,
                    'tipePesan'  => 'warning',
                    'pesan'      => 'Email failed to send',
                );
             }
        }else{
            $array = array(
                'act'       => 0,
                'tipePesan' => 'error',
                'pesan'     => 'error'
            );
        }
        $this->output->set_output(json_encode($array));
    }

}

