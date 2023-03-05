<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class My_container extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('container/my_container_m');
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
        $menuId              = $this->home_m->get_menu_id('container/my_container/home');

        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_name']   = $menuId[0]->menu_name;
        
        if ($this->session->userdata('id_user') == '') {
            $this->loginApproval();
        }else{
            $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
            $data['menu_all']   = $this->user_m->get_menu_all(0);
            $data['getUser']    = $this->global_m->getUser();
            $this->template->set('title', 'home');
            $this->template->load('default_template/template9', 'container/my_container_v', $data);
        }       
        
    }

    function clean($string) {
       $string = str_replace(' ', '_', $string);
       $string = preg_replace('~[\\\\/:*?"<>|]~', '', $string);
       return str_replace("'", "", $string); // Removes special chars.
    }

    public function getContainer() {
        $idUser    = trim($this->session->userdata('id_user'));
        $usergroup = trim($this->session->userdata('usergroup'));
        $rows      = $this->my_container_m->getContainer($idUser,$usergroup);

        $data['data'] = array();
        $no = 0;
        foreach ($rows as $row) {
            $no++;
            $array = array(
                'no'            => $no,
                'folder_id'     => trim($row->folder_id),
                'folder_name'   => trim($row->folder_name),
                'createDate'    => date('d-m-Y H:i:s',strtotime($row->create_date)),
                'createBy'      => trim($row->name),
                'createById'    => trim($row->create_by),
                'Actions'       => null
            );

            array_push($data['data'], $array);
        }
        $this->output->set_output(json_encode($data));        
    }

    public function viewSubContainer() {
        $folder_id = $this->input->post('folder_id', TRUE); 
        $sub_folder_id = $this->input->post('sub_folder_id', TRUE); 
        $idUser    = trim($this->session->userdata('id_user'));
        $usergroup = trim($this->session->userdata('usergroup')); 
        // echo $userid;
        $rows              = $this->my_container_m->viewSubContainer($folder_id,$idUser,$usergroup);
        if($sub_folder_id=="" || empty($sub_folder_id)){
            $data['data'] = array();        
            foreach ($rows as $row) {
                $data = array(
                    'folder_name'       => trim($row->folder_name),
                    'group_user_doc_id' => trim($row->group_user_doc_id),
                    'group_document'    => str_replace('+', ',', trim($row->group_document)),
                    'group_document_id' => str_replace('+', ',', trim($row->group_document_id)),
                );
            }
        }else{
            $getSubContainerName  = $this->my_container_m->getSubContainerName($sub_folder_id);
            $data['data'] = array();        
            foreach ($rows as $row) {
                $data = array(
                    'folder_name'       => trim($row->folder_name),
                    'group_user_doc_id' => trim($row->group_user_doc_id),
                    'group_document'    => str_replace('+', ',', trim($row->group_document)),
                    'group_document_id' => str_replace('+', ',', trim($row->group_document_id)),
                    'sub_folder'        => $getSubContainerName,
                );
            }
        }       
        
        $this->output->set_output(json_encode($data));    
    }

    public function getSubContainer() {
        $folder_id    = $this->input->post('folder_id', TRUE);  
        //echo $folder_id;die();
        $idUser       = trim($this->session->userdata('id_user'));
        $usergroup    = trim($this->session->userdata('usergroup'));
        $rows         = $this->my_container_m->getSubContainer($folder_id,$idUser,$usergroup);
        $data['data'] = array();
        $no           = 0;
        foreach ($rows as $row) {
            $no++;
            $array = array(
                'no'            => $no,
                'folder_id'     => trim($folder_id),
                'sub_folder'    => trim($row->sub_folder),
                'sub_folder_id' => trim($row->sub_folder_id),
                'createDate'    => date('d-m-Y H:i:s',strtotime($row->create_date)),
                'createBy'      => trim($row->name),
                'createById'    => trim($row->create_by),
                'Actions'       => null
            );

            array_push($data['data'], $array);
        }
        $this->output->set_output(json_encode($data));        
    }

    function deleteContainer() {
         $folder_id = $this->input->post('folder_id', TRUE); 
        // $folder_id = $_GET['folder_id'];
        //echo $folder_id;die();
        $data = array(
            'status' => 1,
        );
        $model = $this->my_container_m->deleteContainer($folder_id,$data);
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

    function deleteSubContainer() {
        $sub_folder_id = $this->input->post('sub_folder_id', TRUE); 
        //$sub_folder = $_GET['sub_folder'];
        $data = array(
            'status' => 1,
        );
        $model = $this->my_container_m->deleteSubContainer($sub_folder_id,$data);
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

    function getFieldGeneralAll() {
        $folder_id = $this->input->post('folder_id', TRUE);  
        // $subFolder = $this->input->post('subFolder', TRUE);  
        //$folder_id = $_GET['folder_id'];
        //echo $folder_id;
        
        $rows = $this->my_container_m->getFieldGeneralAll($folder_id);
        
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
      
        $this->output->set_output(json_encode($data));
    }

    function saveSubContainer(){
        $idUser               = $this->session->userdata('id_user');
        $datetime             = date("Y-m-d H:i:s");
        $date                 = date("Y-m-d");
        $folderID             = trim($this->input->post('folderIdSubContainerAdd'));
        $nameGeneralArr       = $this->input->post('nameGeneral');
        $nameGeneralIDArr     = $this->input->post('general_index_id');
        $totalNameGeneral     = count($this->input->post('nameGeneral'));
        $folderNameID         = $this->input->post('folderNameSubContainerAdd');
        $subFolder            = $folderNameID.' '.implode(" ",$nameGeneralArr);
        $general_index_format = $this->input->post('general_index_format');        
        //$nameGeneralArrNew    = $this->clean($nameGeneralArr);
        // $categoryDocVal2      = trim($this->input->post('categoryDocVal2'));
        //cho($totalNameGeneral);        
        $model = $this->my_container_m->insert_sub_container($nameGeneralArr,$nameGeneralIDArr,$totalNameGeneral,$date,$folderID,$datetime,$idUser,$subFolder,$general_index_format);
        //echo $model;        
        if($model == 1){
            $array = array(
            'act' => 1,
            'tipePesan' => 'success',
            'pesan' => 'success',
            );
        }elseif ($model == 'already') {
            $array = array(
            'act' => 0,
            'tipePesan' => 'warning',
            'pesan' => 'Folder Name already exists',
            ); 
                  
        }else{
           $array = array(
            'act' => 0,
            'tipePesan' => 'error',
            'pesan' => 'error',
            ); 
        }
        $this->output->set_output(json_encode($array));   
    }

    public function getListCategoryDoc() {
        $sub_folder_id = $this->input->post('sub_folder_id', TRUE);  
        $idUser        = trim($this->session->userdata('id_user'));
        $usergroup     = trim($this->session->userdata('usergroup'));
        $rows          = $this->my_container_m->getListCategoryDoc($sub_folder_id,$idUser,$usergroup);
        $data['data']  = array();
        $no = 0;
        foreach ($rows as $row) {
            $no++;
            $array = array(
                'no'            => $no,
                'document_name' => trim($row->document_name),
                'total_doc'     => trim($row->total_doc),
                'document_id'   => trim($row->document_id),
                'Actions'       => null
            );

            array_push($data['data'], $array);
        }
        $this->output->set_output(json_encode($data));   
    }

    public function saveDocument(){
        $idUser               = $this->session->userdata('id_user');
        $datetime             = date("Y-m-d H:i:s");
        $date                 = date("Y-m-d");
        $fileNameUpload       = $this->input->post('fileNameUpload');
        $directory            = $this->input->post('directory');
        $folderID             = trim($this->input->post('folderID'));
        $subFolderIdName      = trim($this->input->post('subFolderIdName'));
        $docID                = trim($this->input->post('categoryDocVal'));
        $nameGeneralArr       = $this->input->post('nameGeneral');
        $nameGeneralIDArr     = $this->input->post('general_index_id');
        $totalNameGeneral     = count((array)$this->input->post('nameGeneral'));
        $folderNameID         = $this->input->post('folderNameID');
        $nameSpecificArr      = $this->input->post('name');
        $formatSpesificIDArr  = $this->input->post('specific_index_format');
        $nameSpecificIDArr    = $this->input->post('specific_index_id');
        if($nameSpecificArr == 0 || $nameSpecificArr=="" || is_null($nameSpecificArr)){
            $totalNameSpecfic     = 0;
        }else{
            $totalNameSpecfic     = count($nameSpecificArr);
        }        
        
        $general_index_format = $this->input->post('general_index_format');
        $fileSize             = $this->input->post('fileSize');

        // echo $nameSpecificArrvAl;
        // echo "<pre>";
        // print_r( $nameSpecificArrvAl);die();
        // echo "</pre>";

        if (file_exists($directory)) {
           $model = $this->my_container_m->insert_document($nameGeneralArr,$nameGeneralIDArr,$totalNameGeneral,$date,$folderID,$datetime,$idUser,$nameSpecificArr,$nameSpecificIDArr,$totalNameSpecfic,$docID,$directory,$fileNameUpload,$formatSpesificIDArr,$general_index_format,$fileSize,$subFolderIdName);
        
            if($model){
                $array = array(
                'act' => 1,
                'tipePesan' => 'success',
                'pesan' => 'success',
                );
            }else{
                //echo $directory;
                chown($directory, 666);
                unlink("./".$directory."");
                //unlink($directory);
               $array = array(
                'act' => 0,
                'tipePesan' => 'error',
                'pesan' => 'error',
                ); 
            }
            $this->output->set_output(json_encode($array));   
        } else {
            $array = array(
                'act' => 0,
                'tipePesan' => 'error',
                'pesan' => 'error',
                );
            $this->output->set_output(json_encode($array));  
        }      
                
    }

    function getFieldGeneralAllAndValue() {
        $folder_id   = $this->input->post('folder_id', TRUE);  
        $subFolderID = $this->input->post('subFolderID', TRUE);  
        // $folder_id = $_GET['folder_id'];
        // $subFolder = $_GET['subFolder'];
        //echo $folder_id.'-'.$subFolder;die();        
        $rows = $this->my_container_m->getFieldGeneralAllAndValue($folder_id,$subFolderID);        
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;      
        $this->output->set_output(json_encode($data));
    }

    function getFieldAll() {
        $document_id = $this->input->post('document_id', TRUE);  
        //$categoryDoc = $_GET['categoryDoc'];
        $rows = $this->my_container_m->getFieldAll($document_id);
        
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
      
        $this->output->set_output(json_encode($data));
    }

    public function uploadFileAdd(){
        $folderNameCmp   = $this->input->post('folderNameCmp');
        $folderNameArr   = explode('+', $folderNameCmp);
        $folderName      = $folderNameArr[0];
        $SubFolder       = $folderNameArr[1];
        $catDoc          = $folderNameArr[2];
        $date            = date("Y-m-d H:i:s");
        $date2           = date("Y-m-d");
        $filePath        = './uploads';
        $filePathNew     = $filePath.'/'.$folderName.'/'.$SubFolder;
        $dateFile        = date("YmdHis");
        $fileNameNew     = $catDoc."_".$dateFile;
        // $imagePathNew = $imagePath."2018-07-19";            
        if(!is_dir($filePathNew)) {
           mkdir($filePathNew, 0777, TRUE);
        }
        $config['upload_path']   = "".$filePathNew."";
        $config['allowed_types'] = '*';
        $config['max_size']      = 0;
        $config['file_name'] = $fileNameNew; // set the name here
        $this->load->library('upload', $config);

        if ($this->upload->do_upload("filenameAdd")) {
            $error    = array('array' => $this->upload->display_errors());
            $data     = $this->upload->data();
           
            $fileName = $this->upload->data('file_name');
            //$typeFile = $this->upload->data('file_ext');//$data['file_ext'];           
            
            
            $source   = $filePathNew. "/" . $fileName;
            //die($source);
            chmod($source, 0777);
            $directory = 'uploads/'.$folderName.'/'.$SubFolder.'/'.$fileName;
            $array = array(
                'fileName'  => $fileName,
                'directory' => $directory,
                'tipePesan' => 'success',
                'pesan'     => 'success',
            ); 
            $this->output->set_output(json_encode($array));

        } else {
            $pesan = $this->upload->display_errors();
            echo $pesan;
            $array = array(
                'tipePesan' => 'error',
                'pesan'     => 'upload failed<br>'.$pesan,
            ); 
            $this->output->set_output(json_encode($array));
        }
    }

    public function getListDocDetailFolder() {
        $document_id     = $this->input->post('document_id', TRUE);  
        $subFolderID     = $this->input->post('subFolderID', TRUE);  
        $idUser          = trim($this->session->userdata('id_user'));
        $usergroup       = trim($this->session->userdata('usergroup'));
        $getDocumentName = $this->my_container_m->getDocumentName($document_id);
        $data = array(
            'document_name' => $getDocumentName,
        );
        $this->output->set_output(json_encode($data));   
    }

    public function getListDoc() {
        $document_id         = $this->input->post('document_id', TRUE);  
        $subFolderID         = $this->input->post('subFolderID', TRUE); 
        $folderId            = $this->input->post('folder_id', TRUE); 
        $idUser              = trim($this->session->userdata('id_user'));
        $usergroup           = trim($this->session->userdata('usergroup'));
        $data                = array();
        $col                 = array();
        $specificIndexFormat = array();
        $getDocumentName     = $this->my_container_m->getDocumentName($document_id);
        $idTabel = 0;
        $getGeneralIndexName       = $this->my_container_m->getGeneralIndexName($folderId,$subFolderID);
        $getFieldNameIndexSpecific = $this->my_container_m->getFieldNameIndexSpecific($document_id);
        foreach ($getFieldNameIndexSpecific as $key => $value) {
           $col[$key] = $value['specific_index_name'];
           $specificIndexFormat[$key] = $value['specific_index_format'];
        } 
        $getSpecificIndexNameTable    = $this->my_container_m->getSpecificIndexNameTable($document_id,$subFolderID,$col,$idUser,$usergroup);
        $data = array(
            'document_name'             => trim($getDocumentName),
            'getGeneralIndexName'       => $getGeneralIndexName,
            'getSpecificIndexNameTable' => $getSpecificIndexNameTable,
            'getFieldNameIndexSpecific' => $getFieldNameIndexSpecific,
            'specificIndexFormat'       => $specificIndexFormat,
        ); 
        $this->load->view('container/list_doc_v', $data);          
        
       
    }

    public function getKetFile() {
        $subFolderID  = $this->input->post('subFolderID', TRUE); 
        $document_id  = $this->input->post('document_id', TRUE); 
        $folder_id    = $this->input->post('folder_id', TRUE); 
        $trans_doc_id = $this->input->post('trans_doc_id', TRUE); 
        
        $idUser       = trim($this->session->userdata('id_user'));
        //echo $document_id.'+'.$subFolder;
        $getFileName          = $this->my_container_m->getFileName($trans_doc_id);
        $getGeneralIndexName  = $this->my_container_m->getGeneralIndexName($folder_id,$subFolderID);
        $getSpecificIndexName = $this->my_container_m->getSpecificIndexName($document_id,$trans_doc_id,$idUser);
        $data = array(
            'file_name'           => $getFileName,
            'getGeneralIndexName' => $getGeneralIndexName,
            'getSpecificIndexName'=> $getSpecificIndexName,
        );       
        $this->output->set_output(json_encode($data));          
    }

    function getFieldAllEdit() {
        $trans_doc_id = $this->input->post('trans_doc_id', TRUE); 
        $rows         = $this->my_container_m->getFieldAllEdit($trans_doc_id);
        
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
      
        $this->output->set_output(json_encode($data));
    }

    public function editDoc(){
        $datetime                = date("Y-m-d H:i:s");
        $date                    = date("Y-m-d"); 
        $idUser                  = $this->session->userdata('id_user');
        $fileNameUpload          = $this->input->post('fileNameUpload');
        $transDocIdEditDoc       = trim($this->input->post('transDocIdEditDoc'));
        $folderNameEditDoc       = $this->input->post('folderNameEditDoc');
        $subFolderNameEditDocOld = $this->input->post('subFolderNameEditDocOld');
        $directory               = "uploads/".$folderNameEditDoc."/".$subFolderNameEditDocOld;
        $fileSizeEditDoc         = $this->input->post('fileSizeEditDoc');
        $nameSpecificArr         = $this->input->post('name');
        $nameSpecificIDArr       = $this->input->post('specific_index_id');
        $formatSpesificIDArr     = $this->input->post('specific_index_format');
        $transIndexSpecificIDArr = $this->input->post('transIndexSpecificID'); 
        if($nameSpecificArr == 0 || $nameSpecificArr=="" || is_null($nameSpecificArr)){
            $totalNameSpecfic     = 0;
        }else{
            $totalNameSpecfic     = count($nameSpecificArr);
        }     
        
        $model = $this->my_container_m->editDoc($idUser,$datetime,$date,$fileNameUpload,$fileSizeEditDoc,$transDocIdEditDoc,$directory,$totalNameSpecfic,$formatSpesificIDArr,$transIndexSpecificIDArr,$nameSpecificIDArr,$nameSpecificArr);
        //echo $model;        
        if($model == 1){
            $array = array(
            'act' => 1,
            'tipePesan' => 'success',
            'pesan' => 'success',
            );
        }else{
           $array = array(
            'act' => 0,
            'tipePesan' => 'error',
            'pesan' => 'error',
            ); 
        }
        $this->output->set_output(json_encode($array));                   
    }

    function deleteDocument() {
        $trans_doc_id = $this->input->post('trans_doc_id', TRUE); 
        //$trans_doc_id = $_GET['trans_doc_id'];
        $data = array(
            'status' => 1,
        );
        $model = $this->my_container_m->deleteDocument($trans_doc_id,$data);
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

     function getUserShare() {       
        $trans_doc_id = $_GET['trans_doc_id'];
        $rows = $this->my_container_m->getUserShare($trans_doc_id);
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
        $this->output->set_output(json_encode($data));
    }

     public function editOrInsertShareDoc(){   
        $datetime = date("Y-m-d H:i:s");
        $date     = date("Y-m-d");
        $idUser   = $this->session->userdata('id_user');

        $transDocShareDoc     = $this->input->post('transDocShareDoc'); 
        $setUserShareDocArr   = $this->input->post('setUserShareDoc');
        $totalUser            = count((array)$this->input->post('setUserShareDoc'));
        $editOrInsertShareDoc = $this->input->post('editOrInsertShareDoc');
        //echo $totalUser;die();
        if($editOrInsertShareDoc == ""){
            $model = $this->my_container_m->insertShareDoc($setUserShareDocArr,$transDocShareDoc,$totalUser,$idUser,$date,$datetime);
        }else{
            $model = $this->my_container_m->editShareDoc($setUserShareDocArr,$transDocShareDoc,$totalUser,$idUser,$date,$datetime,$editOrInsertShareDoc);
        }    

        if($model == 1){
            $array = array(
            'act' => 1,
            'tipePesan' => 'success',
            'pesan' => 'success',
            );
        }else{
           $array = array(
            'act' => 0,
            'tipePesan' => 'error',
            'pesan' => 'error',
            ); 
        }
        $this->output->set_output(json_encode($array));  

        //echo $totalUser;die();         
    }
    
}