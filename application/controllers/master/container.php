<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Container extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('master/container_m');  
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
        $menuId = $this->home_m->get_menu_id('master/container/home');
        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_name']   = $menuId[0]->menu_name;
        $this->auth->restrict($data['menu_id']);
        $this->auth->cek_menu($data['menu_id']);
        $data['jenis_document'] = $this->container_m->getJenisDocument();
        $data['getUserGroupDoc'] = $this->container_m->getUserGroupDoc();
        $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
        $data['menu_all']   = $this->user_m->get_menu_all(0);
        $this->template->set('title', 'home');
        $this->template->load('default_template/template9', 'master/container_v', $data);
    }

    public function getFolderAll() {
        $getMasterContainer = $this->container_m->getFolderAll();
        $data['data'] = array();
        $no = 0;
        foreach ($getMasterContainer as $row) {
            $no++;
            $folder_id = trim($row->folder_id);
            $getGroupDoc = $this->container_m->getGroupDoc($folder_id);
            $groupDoc = implode(", ", $getGroupDoc);
            $array = array(
                'no'             => $no,
                'folder_id'      => $folder_id,
                'folder_name'    => trim($row->folder_name),
                'document_total' => count($getGroupDoc),
                'group_document' => $groupDoc,//str_replace('+', ' ,', trim($row->group_document)),
                'createDate'     => date('d-m-Y H:i:s',strtotime($row->create_date)),
                'createBy'       => trim($row->name),
                'createById'     => trim($row->create_by),
                'Actions'        => null
            );

            array_push($data['data'], $array);
        }
        $this->output->set_output(json_encode($data));
    }

    function clean($string) {
       $string = str_replace(' ', '_', $string);
       $string = preg_replace('~[\\\\/:*?"<>|]~', '', $string);
       return str_replace("'", "", $string); // Removes special chars.
    }

    function simpan(){
        $idUser           = $this->session->userdata('id_user');
        $folderName       = trim($this->input->post('folderName'));
        //$folderNameNew    = $this->clean($folderName);//str_replace(' ', '_', $folderName);
        $documentTotal    = count($this->input->post('groupDocument'));
        $groupDocument    = $this->input->post('groupDocument');
        //print_r($documentTotal) ;die();
        //$groupDocument    = trim(implode("+",$groupDocumentArr));
        $nameFieldArr     = $this->input->post('name');
        $formatFieldArr   = $this->input->post('nameFormat');
        $totalIndexing    = count($this->input->post('name'));
        $date             = date("Y-m-d H:i:s");
        $userGroupDoc     = $this->input->post('userGroupDoc');

        $tableFolder      = "master_folder"; 
        $fieldIDFolder    = "folder_id";
        $idMaxFolder      = $this->global_m->getIdMaxChar2($tableFolder,$fieldIDFolder);        
        $dataMasterFolder = array(
            'folder_id'         => $idMaxFolder,
            'folder_name'       => $folderName,
            //'document_total'    => $documentTotal,
            'group_user_doc_id' => $userGroupDoc,
            //'group_document'    => $groupDocument,
            'create_date'       => $date,
            'create_by'         => $idUser,
        );

        $model = $this->container_m->insert_all($dataMasterFolder,$groupDocument,$documentTotal,$idMaxFolder,$nameFieldArr,$formatFieldArr,$totalIndexing,$idUser,$date);
        
        if($model){
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
        $this->output->set_output(json_encode($array));   
    }

    function getDataCariFolderName() {
        $folderName = trim($_GET['folderName']);
        // echo $nomorPolis;die();        
        $rows = $this->container_m->getDataCariFolderName($folderName);
        // echo "<pre>";
        // echo $row;
        // echo "</pre>";die();
        $data['data'] = array();
            foreach ($rows as $row) {
                $array = array(
                    'folder_name' => trim($row->folder_name),
                );

                array_push($data['data'], $array);
            }

        if (empty($array)) {
            $this->output->set_output(json_encode($data));
        }else{
            $this->output->set_output(json_encode($array));
        }       

    }

    function hapus() {
        $folder_id = $_GET['folder_id'];
        $data = array(
            'status' => 1,
        );
        $model = $this->container_m->deletefolder($folder_id,$data);
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
        $folder_id = $_GET['folder_id'];
        $getIndexGeneral          = $this->container_m->getFieldAll($folder_id);
        $getGroupDocinContainer   = $this->container_m->getGroupDocinContainer($folder_id);
        $getFolderNameinContainer = $this->container_m->getFolderNameinContainer($folder_id);
        //print_r($getGroupDocinContainer);die();
        $array = array(
        'getIndexGeneral'          => $getIndexGeneral,
        'getGroupDocinContainer'   => $getGroupDocinContainer,
        'getFolderNameinContainer' => $getFolderNameinContainer,
        ); 
        $this->output->set_output(json_encode($array));
    }

    function ubah(){
        $idUser            = $this->session->userdata('id_user');
        $folderNameEdit    = trim($this->input->post('folderNameEdit'));
        //$folderNameEditNew = $this->clean($folderNameEdit);//str_replace(' ', '_', $folderNameEdit);
        $userGroupDocEdit  = trim($this->input->post('userGroupDocEdit'));
        $idFolderEdit      = trim($this->input->post('idFolderEdit'));
        $documentTotal     = count($this->input->post('groupDocumentEdit'));
        $groupDocumentEdit  = $this->input->post('groupDocumentEdit');
        //$groupDocumentEdit = trim(implode("+",$groupDocumentArr));
        $nameFieldArr      = $this->input->post('name');
        $formatFieldArr    = $this->input->post('nameFormat');
        $totalIndexing     = count($this->input->post('name'));
        $idField           = $this->input->post('idField');
        $date              = date("Y-m-d H:i:s");
       
        $dataMasterFolder = array(
            'folder_name'       => $folderNameEdit,
            //'document_total'    => $documentTotal,
            'group_user_doc_id' => $userGroupDocEdit,
        );

        $model = $this->container_m->update_all($dataMasterFolder,$idFolderEdit,$idField,$nameFieldArr,$formatFieldArr,$totalIndexing,$idUser,$date,$groupDocumentEdit,$documentTotal);
        
        if($model){
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
        $this->output->set_output(json_encode($array));   
    }

    function removeFieldDB() {
        //$this->CI = & get_instance();
        
        $idField = $_GET['idField'];
       
        $model = $this->container_m->removeFieldDB($idField);
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