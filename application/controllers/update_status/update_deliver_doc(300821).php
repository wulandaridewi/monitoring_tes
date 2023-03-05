
<?php
error_reporting(E_ERROR | E_PARSE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Update_deliver_doc extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('update_status/update_deliver_doc_m');  
        $this->load->helper('cookie');
    }

    // public function index() {
    //     if ($this->auth->is_logged_in() == false) {
    //         $this->login();
    //     } else {
    //         $data['multilevel'] = $this->user_m->get_data(0, $this->session->userdata('usergroup'));
    //         $this->template->set('title', 'home');
    //         $this->template->load('default_template/template9', 'global/index', $data);
    //     }
    // }

    function home() {
        $regNum       = $this->input->get('regNum');
        $getKetDoc    = $this->update_deliver_doc_m->getKetDoc($regNum);
        $getKetDocArr = explode('_', $getKetDoc);
        //print_r($getKetDocArr);die();
        $doc_description = $getKetDocArr[0];
        $username        = $getKetDocArr[1];

        $menuId = $this->home_m->get_menu_id('update_status/update_deliver_doc/home');
        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_name']   = $menuId[0]->menu_name;
        //$this->auth->restrict($data['menu_id']);
        //$this->auth->cek_menu($data['menu_id']);
                //echo $regNum;die();
        if ($this->session->userdata('id_user') == '') {
            $this->loginUpdateDeliver($regNum);
            //redirect(base_url().'update_status/update_deliver_doc/loginUpdateDeliver/?regNum='.$regNum);
            //echo "string";
        }else{
            $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
            $data['menu_all']   = $this->user_m->get_menu_all(0);

            $data['username']        = $username;
            $data['doc_description'] = $doc_description;
            $data['regNum']          = $regNum;
            $this->template->set('title', 'home');
            $this->template->load('default_template/template9', 'update_status/update_deliver_doc_v', $data);
        }

       
    }

    function save() {
        $regNum      = trim($this->input->post('regNum'));
        $note      = trim($this->input->post('note'));
        $data = array(
            'doc_status' => 'DELIVER',
            'note'       => $note
        );
        $model = $this->update_deliver_doc_m->update_doc_reg($regNum,$data);
         if ($model) {
            $array = array(
                'act'        => 1,
                'tipePesan'  => 'success',
                'pesan'      => 'success',
            );
        }else{
            $array = array(
                'act'       => 0,
                'tipePesan' => 'error',
                'pesan'     => 'error'
            );
        }
        $this->output->set_output(json_encode($array));
    }

    function loginUpdateDeliver() {
        $regNum       = $this->input->get('regNum');
        //echo $regNum;die();
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
            $data ['regNum'] = $regNum;
            $this->load->view('login_template/login_update_doc_v', $data);
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
            if($username=="admin" || $username=="Admin" || $username=="ADMIN"){

                $success = $this->auth->do_login($username, $password, $tgl_d, $tgl_y);
                // echo $this->session->userdata('name_file_image');die();
                if ($success) {
                    $data ['multilevel'] = $this->user_m->get_data(0, $this->session->userdata('usergroup'));
                    // $this->template->set('title', 'Microtech | Beranda');
                    $array = array(
                        'act' => 1,
                    );
                    $this->output->set_output(json_encode($array));
                    //redirect("".base_url().'update_status/update_deliver_doc/home/?regNum='.$regNum."");
                } else {
                    $data ['title']             = "Astragraphia | Login";
                    $data ['login_info']        = "Maaf, username dan password salah!";
                    //$this->load->view('login_template/login_v', $data);
                    $array = array(
                        'act'       => 0,
                        'tipePesan' => 'User dan Password salah',
                        'pesan'     => 'danger'
                    );
                    $this->output->set_output(json_encode($array));
                } 
            }else{

                $cekUserGroup = $this->auth->do_login($username, $password, $tgl_d, $tgl_y);
                $userGroup    = $this->session->userdata('usergroup');

                if($userGroup == 3){
                    if ($cekUserGroup) {
                        $data ['multilevel'] = $this->user_m->get_data(0, $userGroup);
                        // $this->template->set('title', 'Microtech | Beranda');
                        $array = array(
                            'act' => 1,
                        );
                        $this->output->set_output(json_encode($array));
                        //redirect("".base_url().'update_status/update_deliver_doc/home/?regNum='.$regNum."");
                    } else {
                        $data ['title']             = "Astragraphia | Login";
                        $data ['login_info']        = "Maaf, username dan password salah!";
                        //$this->load->view('login_template/login_v', $data);
                        $array = array(
                            'act'       => 0,
                            'tipePesan' => 'User dan Password salah',
                            'pesan'     => 'danger'
                        );
                        $this->output->set_output(json_encode($array));
                    } 
                }else{
                    if ($bind) {
                    // echo "ooooooookkkkkkkkkkkkkkkk";die();
                    @ldap_close($ldap);   

                    $success = $this->auth->do_login($username, $password, $tgl_d, $tgl_y);
            
                    if ($success) {
                        $data ['multilevel'] = $this->user_m->get_data(0, $this->session->userdata('usergroup'));
                        // $this->template->set('title', 'Microtech | Beranda');
                        $array = array(
                            'act' => 1,
                        );
                        $this->output->set_output(json_encode($array));
                        //redirect("".base_url().'update_status/update_deliver_doc/home/?regNum='.$regNum."");
                    } else {
                        //echo "not ooooooookkkkkkkkkkkkkkkk";die();    
                        $data ['title']             = "Astragraphia | Login";
                        $data ['login_info']        = "Maaf, username dan password salah!";
                        //$this->load->view('login_template/login_v', $data);
                        $array = array(
                            'act'       => 0,
                            'tipePesan' => 'User dan Password salah',
                            'pesan'     => 'danger'
                        );
                        $this->output->set_output(json_encode($array));
                    }//else if (success)*/echo 'Authentication Succed';
                }else {
                    // echo "not ooooooookkkkkkkkkkkkkkkk";die();
                        $data ['title']             = "Astragraphia | Login";
                        $data ['login_info']        = "Maaf, username dan password salah!";
                        // $this->load->view('login_template/login_v', $data);
                        $array = array(
                            'act'       => 0,
                            'tipePesan' => 'User dan Password salah',
                            'pesan'     => 'danger'
                        );
                        $this->output->set_output(json_encode($array));
                    // echo 'Authentication Failed';
                }
                }
            }            
            //---------LDAP--------------            
        }
    } 
    

}

