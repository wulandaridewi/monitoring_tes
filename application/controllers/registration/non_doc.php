<?php
error_reporting(E_ERROR | E_PARSE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Non_doc extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('registration/non_doc_m');  
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
        $menuId = $this->home_m->get_menu_id('registration/non_doc/home');
        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_name']   = $menuId[0]->menu_name;
        $this->auth->restrict($data['menu_id']);
        $this->auth->cek_menu($data['menu_id']);
        $data['getUser']    = $this->non_doc_m->getUser();
        $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
        $data['menu_all']   = $this->user_m->get_menu_all(0);
        $this->template->set('title', 'home');
        $this->template->load('default_template/template9', 'registration/non_doc_v', $data);
    }

    // public function sendEmail()
    //  {
    //       $config['mailtype'] = 'text';
    //       $config['protocol'] = 'smtp';
    //       $config['smtp_host'] = '172.31.152.95';
    //       // $config['smtp_user'] = 'Dewi.Wulandari@astragraphia.co.id';
    //       // $config['smtp_pass'] = 'Astragraphia39';
    //       $config['smtp_user'] = 'Chairul.Elyasa@astragraphia.co.id';
    //       $config['smtp_pass'] = 'Desember2020-1';
    //       $config['smtp_port'] = 25;
    //       $config['charset']='utf-8'; // Default should be utf-8 (this should be a text field) 
    //       $config['newline']="\r\n"; //"\r\n" or "\n" or "\r". DEFAULT should be "\r\n" 
    //       $config['crlf'] = "\r\n"; //"\r\n" or "\n" or "\r" DEFAULT should be "\r\n" 
    //       $config['smtp_timeout'] = 30;

    //       $this->load->library('email', $config);

    //       $this->email->from('Chairul.Elyasa@astragraphia.co.id', 'Mailroom');
    //       $this->email->to('Dewi.Wulandari@astragraphia.co.id');
    //       $this->email->subject('Contoh Kirim Email Dengan Codeigniter');
    //       $this->email->message('Contoh pesan yang dikirim dengan codeigniter');

    //       if($this->email->send()) {
    //            echo 'Email berhasil dikirim';
    //       }
    //       else {
    //            echo 'Email tidak berhasil dikirim';
    //            echo '<br />';
    //            echo $this->email->print_debugger();
    //       }

    //  }

    function saveNonDocIn() {
        //echo "string";die();
        $idUser       = $this->session->userdata('id_user');
        $date         = date("Y-m-d H:i:s");
        $typeRegisDoc = trim($this->input->post('typeRegisDoc'));
        $ownerID      = trim($this->input->post('ownerName'));
        $description  = trim($this->input->post('description'));
        $date2        = date("Y-m-d");
        $table        = "non_doc_register"; 
        $fieldID      = "register_non_doc_id";
        $getID        = $this->global_m->getIdMaxCharDate($table,$fieldID,$date2);

        $getEmail    = $this->non_doc_m->getEmail($ownerID);
        $getEmailArr = explode('_', $getEmail);
        $email       = $getEmailArr[0];
        $nameUser    = $getEmailArr[1];
        //echo $email.'_'.$nameUser;die();
        //start send email
        $this->load->config('email');
        $this->load->library('email');
        $this->email->from('Chairul.Elyasa@astragraphia.co.id', 'Mailroom');
        $this->email->to($email);
        $this->email->subject('Notifikasi Barang Masuk Mailroom');
        $massage = 'Dear '.$nameUser.',<br><br><br> Anda mendapat kiriman '.$description.'.<br> Berikut ini nomor registrasi '.$getID.' yang dapat digunakan untuk pengambilan di mailroom.<br>Jika ingin dikirim ke divisi/deparment klik link dibawah ini: '.base_url().'update_status/update_deliver_nondoc/home/?regNum='.$getID.'<br><br><br> Hormat kami, <br><br>Mailroom';
        $this->email->message($massage);

         if($this->email->send()) {
            $statusEmail = 1;
         }else{
            $statusEmail = 0;
         }

            //echo 'Email berhasil dikirim';
            $data = array(
                'register_non_doc_id' => $getID,
                'ntype'            => $typeRegisDoc,
                'ndoc_description' => $description,
                'nowner'           => $ownerID,
                'ndoc_status'      => 'PICKUP',
                'ndelivery_status' => 'INTERNAL',
                'nstatus_email'    => $statusEmail,
                'create_date'      => $date,
                'create_by'        => $idUser,
                'update_date'      => $date,
                'update_by'        => $idUser,
            );
            $model = $this->non_doc_m->insert_doc_in($data);
            if ($model) {
                $imagePath = 'assets/barcode_non_doc/';
                $imagePathNew = $imagePath.date("Y-m-d");
                // $imagePathNew = $imagePath."2018-07-19";            
                if(!is_dir($imagePathNew)) {
                   mkdir($imagePathNew, 0777, TRUE);
                }
                $this->load->library('zend');
                $this->zend->load('Zend/Barcode'); 
                $imageResource = Zend_Barcode::factory('code128', 'image', array('text'=>$getID), array())->draw();
                $imageName = $getID.'.png';
                $store_image = imagepng($imageResource, $imagePathNew.'/'.$imageName);  // penyimpanan file barcode
                
                if($statusEmail == 1){
                    $array = array(
                        'act'        => 1,
                        'tipePesan'  => 'success',
                        'pesan'      => 'success',
                        'barcodeNum' => $getID,
                        'folder'     => $imagePathNew
                    );
                }else{
                    $array = array(
                        'act'        => 1,
                        'tipePesan'  => 'warning',
                        'pesan'      => 'Email failed to send',
                        'barcodeNum' => $getID,
                        'folder'     => $imagePathNew
                    );
                }                
            } else {
                $array = array(
                    'act'       => 0,
                    'tipePesan' => 'error',
                    'pesan'     => 'error'
                );
            }
        
        //end send email
        
        $this->output->set_output(json_encode($array));
    }
    
    function saveNonDocOut() {
        //echo "string";die();
        $idUser       = $this->session->userdata('id_user');
        $date         = date("Y-m-d H:i:s");
        $typeRegisDoc = trim($this->input->post('typeRegisDoc'));
        $ownerID      = trim($this->input->post('ownerName'));
        $description  = trim($this->input->post('description'));
        $recipient    = trim($this->input->post('recipient'));
        $deliveryLoc  = trim($this->input->post('delivery_location'));
        $locOther     = trim($this->input->post('locOther'));
        $estimasiWaktuEmail     = trim($this->input->post('estimasiWaktu'));
        if($locOther == "" || empty($locOther)){
            $locOther = "Mailroom";
        }
        $estimasiWaktu = date('Y-m-d',strtotime(trim($this->input->post('estimasiWaktu'))));
        
        $date2        = date("Y-m-d");
        $table        = "non_doc_register"; 
        $fieldID      = "register_non_doc_id";
        $getID        = $this->global_m->getIdMaxCharDate($table,$fieldID,$date2);

        $getEmail    = $this->non_doc_m->getEmail($ownerID);
        $getEmailArr = explode('_', $getEmail);
        $email       = $getEmailArr[0];
        $nameUser    = $getEmailArr[1];
        //echo $email.'_'.$nameUser;die();
        //start send email
        $this->load->config('email');
        $this->load->library('email');
        $this->email->from('Chairul.Elyasa@astragraphia.co.id', 'Mailroom');
        $this->email->to($email);
        $this->email->subject('Notifikasi Pengiriman Mailroom');
        $massage = 'Dear '.$nameUser.',<br><br><br> '.$description.' anda akan dikirim ke '.$recipient.', lokasi '.$deliveryLoc.' dan Estimasi Sampai '.$estimasiWaktuEmail.'.<br> Berikut ini nomor registrasi pengiriman di mailroom '.$getID.'.<br><br><br> Hormat kami, <br><br>Mailroom';
        $this->email->message($massage);

        if($this->email->send()) {
            $statusEmail = 1;
         }else{
            $statusEmail = 0;
         }

            //echo 'Email berhasil dikirim';
            $data = array(
                'register_non_doc_id' => $getID,
                'ntype'               => $typeRegisDoc,
                'ndoc_description'    => $description,
                'nowner'              => $ownerID,
                'nrecipient'          => $recipient,
                'ndelivery_location'  => $deliveryLoc,
                'ndoc_status'         => 'DELIVER',
                'ndelivery_status'    => 'EXTERNAL',
                'nstatus_email'       => $statusEmail,
                'create_date'         => $date,
                'create_by'           => $idUser,
                'location_pickup'     => $locOther,
                'update_date'         => $date,
                'update_by'           => $idUser,
                'estimated_time'      => $estimasiWaktu
            );
            $model = $this->non_doc_m->insert_doc_in($data);
            if ($model) {
                $imagePath = 'assets/barcode_non_doc/';
                $imagePathNew = $imagePath.date("Y-m-d");
                // $imagePathNew = $imagePath."2018-07-19";            
                if(!is_dir($imagePathNew)) {
                   mkdir($imagePathNew, 0777, TRUE);
                }
                $this->load->library('zend');
                $this->zend->load('Zend/Barcode'); 
                $imageResource = Zend_Barcode::factory('code128', 'image', array('text'=>$getID), array())->draw();
                $imageName = $getID.'.png';
                $store_image = imagepng($imageResource, $imagePathNew.'/'.$imageName);  // penyimpanan file barcode
                
                if($statusEmail == 1){
                    $array = array(
                    'act'        => 1,
                    'tipePesan'  => 'success',
                    'pesan'      => 'success',
                    'barcodeNum' => $getID,
                    'folder'     => $imagePathNew
                );
                }else{
                    $array = array(
                        'act'        => 1,
                        'tipePesan'  => 'warning',
                        'pesan'      => 'Email failed to send',
                        'barcodeNum' => $getID,
                        'folder'     => $imagePathNew
                    );
                }  
            } else {
                $array = array(
                    'act'       => 0,
                    'tipePesan' => 'error',
                    'pesan'     => 'error'
                );
            }
        
        //end send email
        
        $this->output->set_output(json_encode($array));
    }
}

