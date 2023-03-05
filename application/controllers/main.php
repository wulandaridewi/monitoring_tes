<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

   function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('global_m');
        $this->load->model('home_m');
        $this->load->model('user_m');
        $this->load->helper('cookie');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index() {
        if ($this->auth->is_logged_in() == false) {
            $this->login();
        } else {
            $data ['multilevel'] = $this->user_m->get_data(0, $this->session->userdata('usergroup'));
            $data['menu_id']     = 0;
            $tanggal             = $this->session->userdata('tgl_d');
            $date                = date("Y-m-d");
            $year                = date("Y");
            $idUser              = $this->session->userdata('id_user');
            $usergroup           = $this->session->userdata('usergroup');
            $name_file_image     = $this->session->userdata('name_file_image');
            $data['menu_name']   = 'Home';
            $data['menu_header'] = '';
            $this->template->set('title', 'Dashboard Pipeline | Beranda');
            $this->template->set('title', 'Home');
            //$this->template->load('default_template/template9', 'menu/home', $data);      
            $data['getUser']    = $this->global_m->getUser();
            //$this->template->load('default_template/template9', 'collection/my_collection_v', $data);  
            $data['getDocRegis'] = $this->home_m->getDocRegis($year,$idUser,$usergroup);
            $data['getNonDocRegis'] = $this->home_m->getNonDocRegis($year,$idUser,$usergroup);
            $data['getListRegis'] = $this->home_m->getListRegis($year,$idUser,$usergroup,$date);
            $data['getSizeContainer'] = $this->home_m->getSizeContainer($year,$idUser,$usergroup,$date);
            $this->template->load('default_template/template9', 'dashboard/dashboard_v', $data);              
        }
            
    }

    // public function login() {
    //     $this->load->library('form_validation');
    //     $this->form_validation->set_rules('username', 'Username', 'trim|required');
    //     $this->form_validation->set_rules('password', 'Password', 'trim|required');
    //     $this->form_validation->set_rules('tgl_login', 'tgl login', 'trim|required');
    //     $this->form_validation->set_error_delimiters(' <span style="color:#FF0000">', '</span>');
    //     $ipaddress = $this->global_m->ipaddress();
    //     $hostname  = $this->global_m->hostname();
    //        $data['menu_name']   = 'Home';
    //         $data['menu_header'] = '';

    //     if ($this->form_validation->run() == FALSE) {
    //         //COPYRIGHT 
    //         $data ['title'] = "Astragraphia | Login";
    //         $this->load->view('login_template/login_v', $data);
    //     } else {
    //         $username     = $this->input->post('username');
    //         $password     = $this->input->post('password');
    //         $tgl_y        = $this->input->post('tgl_login');
    //         $tgl_d        = date('d-m-Y', strtotime($tgl_y));
    //         // //---------LDAP--------------
    //         // $adServer = "ldap://10.21.1.102";
            
    //         // $ldap = ldap_connect($adServer) or die("That LDAP-URI was not parseable");

    //         // $ldaprdn = 'Astragraphia' . "\\" . $username;

    //         // ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    //         // ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
    //         $bind = '';
    //         $success = $this->auth->do_login($username, $password, $tgl_d, $tgl_y,$bind);
    //         if ($success) {
    //                 $data ['multilevel'] = $this->user_m->get_data(0, $this->session->userdata('usergroup'));
    //                 $array = array(
    //                     'act' => 1,
    //                     //'ldap' => $bind
    //                 );
    //                 $this->output->set_output(json_encode($array));
    //             } else {
    //                 $data ['title']             = "Astragraphia | Login";
    //                 $data ['login_info']        = "Maaf, username dan password salah!";
    //                 //$this->load->view('login_template/login_v', $data);
    //                 $array = array(
    //                     'act'       => 0,
    //                     'tipePesan' => 'User dan Password salah',
    //                     'pesan'     => 'danger',
    //                     //'ldap'      => $bind
    //                 );
    //                 $this->output->set_output(json_encode($array));
    //             }
    //         //---------LDAP--------------
            
    //     }// else if ($this->form_validation->run () == FALSE) {
    // }

     public function login() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('tgl_login', 'tgl login', 'trim|required');
        $this->form_validation->set_error_delimiters(' <span style="color:#FF0000">', '</span>');
        $ipaddress = $this->global_m->ipaddress();
        $hostname  = $this->global_m->hostname();
           $data['menu_name']   = 'Home';
            $data['menu_header'] = '';

        if ($this->form_validation->run() == FALSE) {
            //COPYRIGHT 
            $data ['title'] = "Astragraphia | Login";
            $this->load->view('login_template/login_v', $data);
        } else {
            $username     = $this->input->post('username');
            $password     = $this->input->post('password');
            $tgl_y        = $this->input->post('tgl_login');
            $tgl_d        = date('d-m-Y', strtotime($tgl_y));
            // //---------LDAP--------------
            $adServer = "ldap://10.21.1.102";
            
            $ldap = ldap_connect($adServer);

            $ldaprdn = 'Astragraphia' . "\\" . $username;

            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
            $bind = @ldap_bind($ldap, $ldaprdn, $password);
            $success = $this->auth->do_login($username, $password, $tgl_d, $tgl_y,$bind);
            if ($bind) {
                // echo "ooooooookkkkkkkkkkkkkkkk";die();
                @ldap_close($ldap);                
                if ($success) {
                    $data ['multilevel'] = $this->user_m->get_data(0, $this->session->userdata('usergroup'));
                    $array = array(
                        'act' => 1,
                        //'ldap' => $bind
                    );
                    $this->output->set_output(json_encode($array));
                } else {
                    //echo "not ooooooookkkkkkkkkkkkkkkk";die();    
                    $data ['title']             = "Astragraphia | Login";
                    $data ['login_info']        = "Maaf, username dan password salah!";
                    //$this->load->view('login_template/login_v', $data);
                    $array = array(
                        'act'       => 0,
                        'tipePesan' => 'danger',
                        'pesan'     => 'User dan Password salah',
                        //'ldap' => $bind
                    );
                    $this->output->set_output(json_encode($array));
                }
            }else {
                if ($success) {
                    $data ['multilevel'] = $this->user_m->get_data(0, $this->session->userdata('usergroup'));
                    $array = array(
                        'act' => 1,
                        'ldap' => $bind
                    );
                    $this->output->set_output(json_encode($array));
                } else {
                    $data ['title']             = "Astragraphia | Login";
                    $data ['login_info']        = "Maaf, username dan password salah!";
                    //$this->load->view('login_template/login_v', $data);
                    $array = array(
                        'act'       => 0,
                        'tipePesan' => 'danger',
                        'pesan'     => 'User dan Password salah',
                        'ldap'      => $bind
                    );
                    $this->output->set_output(json_encode($array));
                } 
            }
            //---------LDAP--------------
            
        }// else if ($this->form_validation->run () == FALSE) {
    }

    public function logout() {
        if ($this->auth->is_logged_in() == true) {
            // jika dia memang sudah login, destroy session
            //$this->auth->do_logout();
            $this->session->sess_destroy();
        }
        // larikan ke halaman utama
        redirect('main');
        //$this->load->view ( 'admin/login_form' );
    }

    public function countNotifNewDocument() {  
        $date      = date("Y-m-d");
        $year      = date("Y");
        $idUser    = trim($this->session->userdata('id_user'));
        $usergroup = trim($this->session->userdata('usergroup'));
        $getCountNotifications = $this->global_m->getCountNotifications($idUser,$usergroup);               
        $this->output->set_output(json_encode($getCountNotifications));                                 
    }

    public function showNotifNewDocument() {  
        $date      = date("Y-m-d");
        $year      = date("Y");
        $idUser    = trim($this->session->userdata('id_user'));
        $usergroup = trim($this->session->userdata('usergroup'));
        $data      = array();
        $post      = $this->input->post();
        $start     = $post['start'];
        $length    = $post['length'];
        $draw      = $post['draw'];
        $dir       = $post['order'][0]['dir'];
        $search    = $post['search']['value'];
        // echo $start.'-'.$length;die();
        $getNewDocument = $this->global_m->getNewDocument($idUser,$usergroup,$start,$length);
        $getCountNotifications = $this->global_m->getCountNotifications($idUser,$usergroup);
        foreach ($getNewDocument as $key => $value) {
            $document_id   = $value['document_id'];
            $folder_id     = trim($value['folder_id']);
            $sub_folder_id = trim($value['sub_folder_id']);
            $trans_doc_id  = trim($value['trans_doc_id']);
            $folder_name   = trim($value['folder_name']);
            $document_name = trim($value['document_name']);
            $sub_folder    = trim($value['sub_folder']);
            $create_date   = trim($value['create_date']);
            $createdby     = trim($value['createdby']);
            $sharedby      = trim($value['sharedby']);
            if($sharedby == '' || $sharedby  == 'NULL' || empty($sharedby)){
                $created = "Created By : ".$createdby;
            }else{
                $created = "Shared By : ".$sharedby;
            }
            $indexNameSpecific   =  str_replace(',', '<br />', trim($value['indexNameSpecific']));
            $indexNameGeneral   =  str_replace(',', '<br />', trim($value['indexNameGeneral']));
            $row = array();
            //$row[] = '';
            $row[] =  "<a class='navi-item' onclick=prepareFrameNotif('".$document_id."%2B".$folder_id."%2B".$sub_folder_id."%2B".$trans_doc_id."%2B".str_replace(" ", "%20",$folder_name)."%2B".str_replace(" ", "%20",$sub_folder)."%2B".str_replace(" ", "%20",$document_name)."')>
                <div class='navi-link rounded'><div class='symbol symbol-50 symbol-circle mr-3'>
                    <div class='symbol-label'><i class='far fa-file-alt text-primary icon-lg'></i></div>
                </div>
                <div class='navi-text'>
                <div class='font-weight-bold font-size-lg'>Document : ".$document_name."</div>
                <div class='text-muted'>Container : ".$sub_folder."</div>
                <div class='text-muted'>".$created."</div>
                <div class='text-muted'>Create Date : ".$create_date."</div>
                <div class='text-muted'>Indexing : <br>".$indexNameGeneral."<br>".$indexNameSpecific."</div>
                
                </div>
            </div>
            </a>";

            $data[] = $row;
        }
        
        $output = array(
            //"draw" => $draw,
            "recordsTotal" => $getCountNotifications,//$countAll,
            "recordsFiltered" => $getCountNotifications,//$count_filtered,
            "data" => $data,
        );
                
        $this->output->set_output(json_encode($output));                                  
    }

    public function countNotifNewApproval() {  
        $date      = date("Y-m-d");
        $year      = date("Y");
        $idUser    = trim($this->session->userdata('id_user'));
        $usergroup = trim($this->session->userdata('usergroup'));
        $getCountNotifApproval = $this->global_m->getCountNotifApproval($idUser,$usergroup);               
        $this->output->set_output(json_encode($getCountNotifApproval));                                 
    }

    public function showNotifApproval() {  
        $date      = date("Y-m-d");
        $year      = date("Y");
        $idUser    = trim($this->session->userdata('id_user'));
        $usergroup = trim($this->session->userdata('usergroup'));
        $data      = array();
        $post      = $this->input->post();
        $start     = $post['start'];
        $length    = $post['length'];
        $draw      = $post['draw'];
        $dir       = $post['order'][0]['dir'];
        $search    = $post['search']['value'];
        // echo $start.'-'.$length;die();
        $getNewDocument = $this->global_m->getNewApproval($idUser,$usergroup,$start,$length);
        $getCountNotifications = $this->global_m->getCountNotifApproval($idUser,$usergroup);
        foreach ($getNewDocument as $key => $value) {
            $document_id    = $value['document_id'];
            $folder_id      = trim($value['folder_id']);
            $sub_folder_id  = trim($value['sub_folder_id']);
            $trans_doc_id   = trim($value['trans_doc_id']);
            $folder_name    = trim($value['folder_name']);
            $document_name  = trim($value['document_name']);
            $sub_folder     = trim($value['sub_folder']);
            $create_date    = trim($value['create_date']);
            $created_by     = trim($value['created_by']);
            $status_approve = trim($value['status_approve']);
            $row = array();
            //$row[] = '';
            if($status_approve == 'reject'){
                $row[] =  "<a class='navi-item' onclick=prepareFrameNotif('".$document_id."%2B".$folder_id."%2B".$sub_folder_id."%2B".$trans_doc_id."%2B".str_replace(" ", "%20",$folder_name)."%2B".str_replace(" ", "%20",$sub_folder)."%2B".str_replace(" ", "%20",$document_name)."%2B".$status_approve."')>
                        <div class='navi-link rounded'><div class='symbol symbol-50 symbol-circle mr-3'>
                            <div class='symbol-label'><i class='far fa-file-alt text-danger icon-lg'></i></div>
                        </div>
                        <div class='navi-text'>
                        <div class='font-weight-bold font-size-lg text-danger'>Reject Approval</div>
                        <div class='text-muted'>Document : ".$document_name."</div>
                        <div class='text-muted'>Container : ".$sub_folder."</div>
                        <div class='text-muted'>Created By : ".$created_by."</div>
                        <div class='text-muted'>Create Date : ".$create_date."</div>
                        </div>
                    </div>
                    </a>";
            }elseif($status_approve == 'waiting'){
                $row[] =  "<a class='navi-item' onclick=prepareFrameNotif('".$document_id."%2B".$folder_id."%2B".$sub_folder_id."%2B".$trans_doc_id."%2B".str_replace(" ", "%20",$folder_name)."%2B".str_replace(" ", "%20",$sub_folder)."%2B".str_replace(" ", "%20",$document_name)."%2B".$status_approve."')>
                        <div class='navi-link rounded'><div class='symbol symbol-50 symbol-circle mr-3'>
                            <div class='symbol-label'><i class='far fa-file-alt text-primary icon-lg'></i></div>
                        </div>
                        <div class='navi-text'>
                        <div class='font-weight-bold font-size-lg'>Request Approval</div>
                        <div class='text-muted'>Document : ".$document_name."</div>
                        <div class='text-muted'>Container : ".$sub_folder."</div>
                        <div class='text-muted'>Created By : ".$created_by."</div>
                        <div class='text-muted'>Create Date : ".$create_date."</div>
                        </div>
                    </div>
                    </a>";
            }            

            $data[] = $row;
        }
        
        $output = array(
            //"draw" => $draw,
            "recordsTotal" => $getCountNotifications,//$countAll,
            "recordsFiltered" => $getCountNotifications,//$count_filtered,
            "data" => $data,
        );
                
        $this->output->set_output(json_encode($output));                                   
    }

    
}
