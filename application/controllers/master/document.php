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
            $this->template->load('default_template/template9', 'master/document_v', $data);
        }
    }

    function clean($string) {
       $string = str_replace(' ', '_', $string);
       $string = preg_replace('~[\\\\/:*?"<>|]~', '', $string);
       return str_replace("'", "", $string); // Removes special chars.
    }

    function cleanIndex($string) {
        return preg_replace('~["]~', '', $string); // Removes special chars.
    }

    public function getDocumentAll() {
        $rows = $this->document_m->getDocumentAll();
        $data['data'] = array();
        $no = 0;
        foreach ($rows as $row) {
            $no++;
            $array = array(
                'no'            => $no,
                'document_id'   => trim($row->document_id),
                'document_name' => trim($row->document_name),
                'createDate'    => date('d-m-Y H:i:s',strtotime($row->create_date)),
                'createBy'      => trim($row->name),
                'createById'    => trim($row->create_by),
                'Actions'       => null
            );

            array_push($data['data'], $array);
        }
        $this->output->set_output(json_encode($data));
    }

    function ubah() {
        $document_name   = trim($this->input->post('nameDocumentEdit'));
        $documentNameOld = trim($this->input->post('nameDocumentOldEdit'));        
        //$document_nameNew = $this->clean($document_name);//str_replace(' ', '_', $document_name);
        $name = $this->input->post('name');
        $nameFormat = $this->input->post('nameFormat');
        $number = count($this->input->post('name'));
        $documentField = $this->input->post('documentField');
        $idDocument = trim($this->input->post('idDocument'));
        $date = date("Y-m-d H:i:s");
        $idUser = $this->session->userdata('id_user');
        $idField = $this->input->post('idField');
        #update document name in master_document
        $data1 = array(
                'document_name' => $document_name,
            );

        $model = $this->document_m->updateDocumentName($idDocument,$data1);
        
        if ($model) {

                $current_field = array();
                $new_field = array();
                $success = 0;
                for ($i=0; $i < $number ; $i++) { 
                    // $a = isset($idField[$i]);
                    // echo $a."<br>";
                    if (isset($idField[$i])) {
                        $field = array(
                            'specific_index_name'   => $name[$i],//$this->cleanIndex($name[$i]),
                            'specific_index_format' => $nameFormat[$i],
                        );
                        //array_push($current_field, $field);
                        $updateIndexing = $this->document_m->update_field($idField[$i],$field);
                        if($updateIndexing){
                            $success++;
                        }
                        
                    }else{
                        $table         = "indexing_specific"; 
                        $fieldID       = "specific_index_id";
                        $idMaxSpecific = $this->global_m->getIdMaxInt($table,$fieldID); 

                        $field = array(
                            'specific_index_id'     => $idMaxSpecific,
                            'document_id'           => $idDocument,
                            'specific_index_name'   => $name[$i],//$this->cleanIndex($name[$i]),
                            'specific_index_format' => $nameFormat[$i],
                            'create_date'           => date("Y-m-d H:i:s"),
                            'create_by'             => $idUser,
                        );
                        //array_push($new_field, $field);
                        $insertIndexing = $this->document_m->insert_field($field);
                        if($insertIndexing){
                            $success++;
                        }
                    }
                }
                //echo $success.'_'.$number;die();
                if ($success == $number) {               

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
        $idUser = $this->session->userdata('id_user');
        //echo $idUser;die();
        $document_name = trim($this->input->post('nameDocument'));
        //$document_nameNew = $this->clean($document_name);//str_replace(' ', '_', $document_name);       
        $number        = count($this->input->post('name'));
        $documentField = $this->input->post('documentField');
        $countFormat   = count($this->input->post('nameFormat'));
        $date          = date("Y-m-d H:i:s");
        //echo $document_nameNew;die();
        $table = "master_document"; 
        $fieldID = "document_id";
        $idMax  = $this->global_m->getIdMaxInt($table,$fieldID);        
        $data = array(
            'document_id'   => $idMax,
            'document_name' => $document_name,
            'create_date'   => $date,
            'create_by'     => $idUser,
        );
        $model = $this->document_m->insert_document($data);

        if ($model) {
            for($i=0; $i<$number; $i++)
            {
                //echo $number.'-'.$document_name.'-'.$_POST["name"][$i].'<br>';
                $table         = "indexing_specific"; 
                $fieldID       = "specific_index_id";
                $idMaxSpecific = $this->global_m->getIdMaxInt($table,$fieldID);    
                $data = array(
                    'specific_index_id'     => $idMaxSpecific,
                    'document_id'           => $idMax,
                    'specific_index_name'   => $_POST["name"][$i],//$this->cleanIndex($_POST["name"][$i]),
                    'specific_index_format' => $_POST["nameFormat"][$i],
                    'create_date'           => $date,
                    'create_by'             => $idUser,
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
                'pesan' => 'error'
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
        $document_id = $_GET['document_id'];
        // $document_name = $_GET['document_name'];
        //echo $document_id."-".$document_name;die();
        $data = array(
            'status' => 1,
        );
        $model = $this->document_m->delete_document($document_id,$data);
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
        $document_id = $_GET['document_id'];
        $rows = $this->document_m->getFieldAll($document_id);
        
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
      
        $this->output->set_output(json_encode($data));
    }

    function getDataCariNameDoc() {
        $nameDoc = trim($_GET['nameDoc']);
        // echo $nomorPolis;die();        
        $rows = $this->document_m->getDataCariNameDoc($nameDoc);
        // echo "<pre>";
        // echo $row;
        // echo "</pre>";die();
        $data['data'] = array();
            foreach ($rows as $row) {
                $array = array(
                    'document_name' => trim($row->document_name),
                );

                array_push($data['data'], $array);
            }

        if (empty($array)) {
            $this->output->set_output(json_encode($data));
        }else{
            $this->output->set_output(json_encode($array));
        }       

    }

    function getDatacariNameIndexSubmit() {
        $count   = count($this->input->post('name'));
        $numText = $count -1 ;
        //echo $name;die();
        if($count==0 || $count==1 || $count == "" || $count == "null"){
            $array = array(
                'result' => "singel",
                'text' => "",
            );
        }else{
            for($i=0; $i<$count-1; $i++)
            {
                
                $nameTextCari = strtoupper(trim($_POST["name"][$i]));
                for($x=0; $x<$count; $x++)
                {
                    $nameText = strtoupper(trim($_POST["name"][$x]));
                    if($nameText == $nameTextCari && $i !== $x){
                        $array = array(
                            'result' => "double",
                            'text' => $_POST["name"][$i],
                        );
                        $result = "sama";
                        //echo $nameText."_".$nameTextCari."_".$i."_".$x."_sama<br>";
                        break 2; 
                    }else{
                        $array = array(
                            'result' => "singel",
                            'text' => $_POST["name"][$i],
                        );
                        $result = "beda";
                        //echo $nameText."_".$nameTextCari."_".$i."_".$x."_beda<br>";
                    }
                }          
            }
        }
        
        //print_r($array);die();
        $this->output->set_output(json_encode($array));
    }

    function getDatacariNameIndex() {
        $count   = count($this->input->post('name'));
        $numText = $count -1 ;
        //echo $name;die();
        if($count==0 || $count==1 || $count == "" || $count == "null"){
            $array = array(
                'result' => "singel",
                'text' => "",
            );
        }else{
            for($i=0; $i<$count-1; $i++)
            {
              $nameText = strtoupper(trim($_POST["name"][$i]));
              $nameTextCari = strtoupper(trim($_POST["name"][$numText]));
              if($nameText == $nameTextCari){
                $array = array(
                    'result' => "double",
                    'text' => $_POST["name"][$i],
                );
                //echo $nameText."_".$nameTextCari."string<br>";
                break; 
              }else{
                $array = array(
                    'result' => "singel",
                    'text' => $_POST["name"][$i],
                );
                //echo $nameText."_".$nameTextCari."tes<br>";
              }
            } 
        }

        //print_r($array);die();
        $this->output->set_output(json_encode($array));
    }
}

/* End of file sec_group_user.php */
/* Location: ./application/controllers/sec_group_user.php */