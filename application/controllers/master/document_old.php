<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Document extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('master/document_m');  
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
        $menuId = $this->home_m->get_menu_id('master/document/home');
        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_nama']   = $menuId[0]->menu_nama;
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
            $this->template->load('default_template/template9', 'master/document_v', $data);
        }
    }

    public function getDocumentAll() {
        $rows = $this->document_m->getDocumentAll();
        $data['data'] = array();
        $no = 1;
        foreach ($rows as $row) {
            $array = array(
                'no'            => $no,
                'document_id'   => trim($row->document_id),
                'document_name' => trim($row->document_name),
                'createDate'    => date('d-m-Y H:i:s',strtotime($row->createDate)),
                'createBy'      => trim($row->name),
                'createById'    => trim($row->createBy),
                'status_barcode'=> trim($row->status_barcode),
                'Actions'       => null
            );

            array_push($data['data'], $array);
        }
        $this->output->set_output(json_encode($data));
    }

    function ubah() {
        $barcode = trim($this->input->post('barcode'));
        if($barcode == 1){
           $status_barcode = $barcode;
        }else{
            $status_barcode = 0;
        }
        $document_name = trim($this->input->post('nameDocument'));
        $name = $this->input->post('name');
        $nameFormat = $this->input->post('nameFormat');
        $number = count($this->input->post('name'));
        $documentField = $this->input->post('documentField');
        $idDocument = trim($this->input->post('idDocument'));
        $createDate = trim($this->input->post('createDate'));
        $createBy = trim($this->input->post('createBy'));
        $createById = trim($this->input->post('createById'));
        $date = date("Y-m-d H:i:s");
        $idUser = $this->session->userdata('id_user');
        $idField = $this->input->post('idField');

        $data1 = array(
                'document_total' => $number,
                'document_name' => $document_name,
                'createDate'     => date("Y-m-d H:i:s",strtotime($createDate)),
                'createBy'       => $createById,
                'status'         => 1,
                'updateDate'     => $date,
                'updateBy'       => $idUser,
                'status_barcode' => $status_barcode,
            );
        $model = $this->document_m->update_total_field($idDocument,$data1);

        
        if ($model) {

                $current_field = array();
                $new_field = array();
                for ($i=0; $i < $number ; $i++) { 
                    // $a = isset($idField[$i]);
                    // echo $a."<br>";
                    if (isset($idField[$i])) {
                        $field = array(
                            //'idField'        => $idField[$i],
                            // 'document_id'    => $idDocument,
                            'fieldName'      => $name[$i],
                            'document_format'      => $nameFormat[$i],
                            //'createDate'     => date("Y-m-d H:i:s",strtotime($createDate)),
                            //'createBy'       => $createById,
                            'status'         => 1,
                            'updateDate'     => $date,
                            'updateBy'       => $idUser,
                        );
                        //array_push($current_field, $field);
                        $result_curr = $this->document_m->update_field($idField[$i],$field);
                    }else{

                        $field = array(
                            'document_id' => $idDocument,
                            'fieldName'   => $name[$i],
                            'document_format'      => $nameFormat[$i],
                            'createDate'  => date("Y-m-d H:i:s",strtotime($createDate)),
                            'createBy'    => $createById,
                            'status'      => 1,
                            'updateDate'  => $date,
                            'updateBy'    => $idUser,
                        );
                        //array_push($new_field, $field);
                        $result_new = $this->document_m->insert_field($field);
                    }
                }

            $array = array(
                'act'       => 0,
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

    function simpan(){
        $barcode = trim($this->input->post('barcode'));
        if($barcode == 1){
           $status_barcode = $barcode;
        }else{
            $status_barcode = 0;
        }
        $idUser = $this->session->userdata('id_user');
        //echo $idUser;die();
        $document_name = trim($this->input->post('nameDocument'));
        $number = count($this->input->post('name'));
        $documentField = $this->input->post('documentField');
        $countFormat = count($this->input->post('nameFormat'));
        $date = date("Y-m-d H:i:s");

        $table = "document_header"; 
        $fieldID = "document_id";
        $idMax  = $this->global_m->getIdMaxInt($table,$fieldID);        
        $data = array(
            'document_id' => $idMax,
            'document_name' => $document_name,
            'document_total' => $number,
            'status_barcode' => $status_barcode,
            'createDate' => $date,
            'createBy'   => $idUser,
        );
        $model = $this->document_m->insert_document($data);

        if ($model) {
            for($i=0; $i<$number; $i++)
            {
                //echo $number.'-'.$document_name.'-'.$_POST["name"][$i].'<br>';
                $data = array(
                    'document_id' => $idMax,
                    'fieldName' => $_POST["name"][$i],
                    'document_format' => $_POST["nameFormat"][$i],
                    'createDate' => $date,
                    'createBy'   => $idUser,
                );
                $model2 = $this->document_m->insert_documentDetail($data);
            }
                if($model2){
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
            
        } else {
            $array = array(
                'act' => 0,
                'tipePesan' => 'error',
                'pesan' => 'success'
            );
        }
        $this->output->set_output(json_encode($array));        

        //$model = $this->document_m->insert_document($data);
        
    }

    function removeFieldDB() {
        //$this->CI = & get_instance();
        
        $idField = $_GET['idField'];
       
        $model = $this->document_m->removeFieldDB($idField);
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

    function hapus() {
        $idDocument = trim($this->input->post('idDocument'));
        $model = $this->document_m->delete_document($idDocument);
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
        $this->CI = & get_instance();
        
        $document_id = $_GET['document_id'];
        $rows = $this->document_m->getFieldAll($document_id);
        
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
      
        $this->output->set_output(json_encode($data));
    }
}

/* End of file sec_group_user.php */
/* Location: ./application/controllers/sec_group_user.php */