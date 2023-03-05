<?php
error_reporting(E_ERROR | E_PARSE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Doc_in extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('registration/doc_in_m');  
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
        $menuId = $this->home_m->get_menu_id('registration/doc_in/home');
        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_name']   = $menuId[0]->menu_name;
        $this->auth->restrict($data['menu_id']);
        $this->auth->cek_menu($data['menu_id']);
        $data['getUser']    = $this->doc_in_m->getUser();
        $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
        $data['menu_all']   = $this->user_m->get_menu_all(0);
        $this->template->set('title', 'home');
        $this->template->load('default_template/template9', 'registration/doc_in_v', $data);
    }

    function saveDocIn() {
        //echo "string";die();
        $idUser       = $this->session->userdata('id_user');
        $date         = date("Y-m-d H:i:s");
        $typeRegisDoc = trim($this->input->post('typeRegisDoc'));        
        $ownerID      = trim($this->input->post('ownerName'));
        $description  = trim($this->input->post('description'));
        $indexing     = trim($this->input->post('indexing'));
        
        if($indexing=='INDEX'){
            $status_index = 0;
        }elseif($indexing=='NOT_INDEX'){
            $status_index = 2;
        }
        $date2       = date("Y-m-d");
        $table       = "doc_register"; 
        $fieldID     = "register_doc_id";
        $getID       = $this->global_m->getIdMaxCharDate($table,$fieldID,$date2);
        //start send email
        $getEmail    = $this->doc_in_m->getEmail($ownerID);
        $getEmailArr = explode('_', $getEmail);
        $email       = $getEmailArr[0];
        $nameUser    = $getEmailArr[1];

        $this->load->config('email');
        $this->load->library('email');
        $this->email->from('Chairul.Elyasa@astragraphia.co.id', 'Mailroom');
        $this->email->to($email);
        $this->email->subject('Notifikasi Dokumen Masuk Mailroom');
        $massage = 'Dear '.$nameUser.',<br><br><br> Anda mendapat kiriman dokumen '.$description.'.<br> Berikut ini nomor registrasi dokumen '.$getID.' yang dapat digunakan untuk pengambilan di mailroom.<br>Jika dokumen ingin dikirim ke divisi/deparment klik link dibawah ini: '.base_url().'update_status/update_deliver_doc/home/?regNum='.$getID.'<br><br><br> Hormat kami, <br><br>Mailroom';
        $this->email->message($massage);
        if($this->email->send()) {
            $statusEmail = 1;
        }else{
            $statusEmail = 0;
        }
        //end kirim email
        //echo 'Email berhasil dikirim';
        $data = array(
            'register_doc_id' => $getID,
            'type'            => $typeRegisDoc,
            'doc_description' => $description,
            'owner'           => $ownerID,
            'doc_status'      => 'PICKUP',
            'delivery_status' => 'INTERNAL',
            'status_email'    => $statusEmail,
            'create_date'     => $date,
            'create_by'       => $idUser,
            'update_date'     => $date,
            'update_by'       => $idUser,
            'status_indexing' => $status_index
        );
        $model = $this->doc_in_m->insert_doc_in($data);
        if ($model) {
            $imagePath = 'assets/barcode/';
            $imagePathNew = $imagePath.date("Y-m-d");
            if(!is_dir($imagePathNew)) {
               mkdir($imagePathNew, 0777, TRUE);
            }
            $this->load->library('zend');
            $this->zend->load('Zend/Barcode'); 
            $imageResource = Zend_Barcode::factory('code128', 'image', array('text'=>$getID), array())->draw();
            $imageName = $getID.'.png';
            $store_image = imagepng($imageResource, $imagePathNew.'/'.$imageName);
            
            if($statusEmail == 1) {
                //$statusEmail = 1;
                $array = array(
                    'act'        => 1,
                    'tipePesan'  => 'success',
                    'pesan'      => 'success',
                    'barcodeNum' => $getID,
                    'folder'     => $imagePathNew
                );
             }else{
                //$statusEmail = 0;
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
    
    function saveDocOut() {
        $idUser       = $this->session->userdata('id_user');
        $date         = date("Y-m-d H:i:s");
        $typeRegisDoc = trim($this->input->post('typeRegisDoc'));
        $ownerID      = trim($this->input->post('ownerName'));
        $description  = trim($this->input->post('description'));
        $recipient    = trim($this->input->post('recipient'));
        $deliveryLoc  = trim($this->input->post('delivery_location'));
        $indexing     = trim($this->input->post('indexing'));
        $estimasiWaktuEmail     = trim($this->input->post('estimasiWaktu'));
        //kirim email
                $getEmail    = $this->doc_in_m->getEmail($ownerID);
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
                $massage = 'Dear '.$nameUser.',<br><br><br> Dokumen '.$description.' anda sedang di proses mailroom.<br>Setelah selesai di proses mailroom, dokumen akan dikirim ke '.$recipient.',lokasi '.$deliveryLoc.' dan estimasi Sampai '.$estimasiWaktuEmail.'.<br> Berikut ini nomor registrasi dokumen '.$getID.' yang dapat digunakan mengetahui status dokumen.<br><br><br> Hormat kami, <br><br>Mailroom';
                $this->email->message($massage);

                if($this->email->send()) {
                    $statusEmail = 1;
                 }else{
                    $statusEmail = 0;
                   }
            //end kirim email  
        if($indexing=='INDEX'){
            $status_index = 0;
        }elseif($indexing=='NOT_INDEX'){
            $status_index = 2;
        }
        // $estimasiWaktu = trim($this->input->post('estimasiWaktu'));
        $estimasiWaktu = date('Y-m-d',strtotime(trim($this->input->post('estimasiWaktu'))));
        //echo $tes;die();        
        $date2        = date("Y-m-d");
        $table        = "doc_register"; 
        $fieldID      = "register_doc_id";
        $getID        = $this->global_m->getIdMaxCharDate($table,$fieldID,$date2);     
        $data = array(
            'register_doc_id'   => $getID,
            'type'              => $typeRegisDoc,
            'doc_description'   => $description,
            'owner'             => $ownerID,
            'recipient'         => $recipient,
            'delivery_location' => $deliveryLoc,
            'doc_status'        => 'DELIVER',
            'delivery_status'   => 'EXTERNAL',
            'status_email'      => $statusEmail,
            'create_date'       => $date,
            'create_by'         => $idUser,
            'update_date'       => $date,
            'update_by'         => $idUser,
            'status_indexing'   => $status_index,
            'estimated_time'    => $estimasiWaktu
        );
        $model = $this->doc_in_m->insert_doc_in($data);
        if ($model) {
            $imagePath = 'assets/barcode/';
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
            if($statusEmail == 1) {
                    //$statusEmail = 1;
                    $array = array(
                        'act'        => 1,
                        'tipePesan'  => 'success',
                        'pesan'      => 'success',
                        'barcodeNum' => $getID,
                        'folder'     => $imagePathNew
                    );
                 }else{
                    //$statusEmail = 0;
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

