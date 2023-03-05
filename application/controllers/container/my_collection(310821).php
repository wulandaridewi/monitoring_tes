<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class My_collection extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('collection/my_collection_m');
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
        $menuId              = $this->home_m->get_menu_id('collection/my_collection/home');

        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_name']   = $menuId[0]->menu_name;

        //$this->auth->restrict($data['menu_id']);
        //$this->auth->cek_menu($data['menu_id']);
        
        if ($this->session->userdata('id_user') == '') {
            $this->loginApproval();
            //redirect(base_url().'update_status/update_deliver_doc/loginUpdateDeliver/?regNum='.$regNum);
            //echo "string";
        }else{
            $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
            $data['menu_all']   = $this->user_m->get_menu_all(0);
            //$data['getCategoryDoc'] = $this->my_collection_m->getCategoryDoc();
            $data['getUser']    = $this->global_m->getUser();
            $this->template->set('title', 'home');
            $this->template->load('default_template/template9', 'collection/my_collection_v', $data);
        }
        
        
    }

    function clean($string) {
       $string = str_replace(' ', '_', $string);
       $string = preg_replace('~[\\\\/:*?"<>|]~', '', $string);
       return str_replace("'", "", $string); // Removes special chars.
    }

    public function getCollection() {
        $idUser    = trim($this->session->userdata('id_user'));
        $usergroup = trim($this->session->userdata('usergroup'));
        $rows   = $this->my_collection_m->getCollection($idUser,$usergroup);

        $data['data'] = array();
        $no = 0;
        foreach ($rows as $row) {
            $no++;
            $array = array(
                'no'            => $no,
                'folder_id'       => trim($row->folder_id),
                'folder_name'    => trim($row->folder_name),
                'createDate'    => date('d-m-Y H:i:s',strtotime($row->create_date)),
                'createBy'      => trim($row->name),
                'createById'    => trim($row->create_by),
                'Actions'       => null
            );

            array_push($data['data'], $array);
        }
        $this->output->set_output(json_encode($data));        
    }

    public function getSubFolder() {
        $folder_id = $this->input->post('folder_id', TRUE); 
        $idUser    = trim($this->session->userdata('id_user'));
        $usergroup = trim($this->session->userdata('usergroup')); 
        // echo $userid;
        $rows   = $this->my_collection_m->getSubFolder($folder_id,$idUser,$usergroup);
        $data['data'] = array();        
        foreach ($rows as $row) {
            $data = array(
                'folder_id'      => trim($row->folder_id),
                'folder_name'    => trim($row->folder_name),
                'group_user_doc_id'    => trim($row->group_user_doc_id),
                'group_document' => str_replace('+', ',', trim($row->group_document)),
            );
        }
        $this->output->set_output(json_encode($data));    
    }

    public function getOpenSubFolder() {
        $sub_folder = $this->input->post('sub_folder', TRUE);  
        $idUser    = trim($this->session->userdata('id_user'));
        $usergroup = trim($this->session->userdata('usergroup'));
        $rows   = $this->my_collection_m->getOpenSubFolder($sub_folder,$idUser,$usergroup);
        $data['data'] = array();
        $no = 0;
        foreach ($rows as $row) {
            $no++;
            $array = array(
                'no'            => $no,
                'document_name'  => trim($row->document_name),
                'total_doc'      => trim($row->total_doc),
                'document_id'   => trim($row->document_id),
                'Actions'       => null
            );

            array_push($data['data'], $array);
        }
        $this->output->set_output(json_encode($data));   
    }

    public function getListDoc() {
        $document_id = $this->input->post('document_id', TRUE);  
        $sub_folder  = $this->input->post('subFolderNew', TRUE);  
        $idUser    = trim($this->session->userdata('id_user'));
        $usergroup = trim($this->session->userdata('usergroup'));
        //echo $document_id.'-'.$sub_folder;
        $data          = array();
        $col           = array();
        $specificIndexFormat = array();
        $getFolderID   = $this->my_collection_m->getFolderID($sub_folder,$document_id,$idUser,$usergroup);
        // echo "<pre>";
        //     print_r($getFolderID);
        //     echo "</pre>";
        $idTabel = 0;
        if (empty($getFolderID)) {
            // $array = array(
            //     'act' => 0,
            // ); 
            echo "kosong";
        }else{
            foreach ($getFolderID as $key => $value) {
                $folderId      = trim($value->folder_id);
                $document_name = trim($value->document_name);
                $group_user_doc_id = trim($value->group_user_doc_id);
                //echo $group_user_doc_id;die();
                // $document_id   = $value->document_id;
                $getGeneralIndexName  = $this->my_collection_m->getGeneralIndexName($folderId,$sub_folder);
                $getFieldNameIndexSpecific = $this->my_collection_m->getFieldNameIndexSpecific($document_id);
                foreach ($getFieldNameIndexSpecific as $key => $value) {
                   $col[$key] = $value['specific_index_name'];
                   $specificIndexFormat[$key] = $value['specific_index_format'];
                } 
                // $getTransDoc = $this->my_collection_m->getTransDoc($sub_folder,$document_id);
                $getSpecificIndexNameTable = $this->my_collection_m->getSpecificIndexNameTable($document_id,$sub_folder,$col,$idUser,$usergroup);
                //print_r($statusapproveArr);die();
                $data = array(
                    'document_name'             => $document_name,
                    'getGeneralIndexName'       => $getGeneralIndexName,
                    'getSpecificIndexNameTable' => $getSpecificIndexNameTable,
                    'getFieldNameIndexSpecific' => $getFieldNameIndexSpecific,
                    'specificIndexFormat' => $specificIndexFormat,
                    'group_user_doc_id' => $group_user_doc_id,
                );  
                // echo "<pre>";
                // print_r($data);
                // echo "</pre>";
                $this->load->view('collection/list_doc_v', $data);          
            } 
        }
       
    }

    public function getKetFile() {
        $subFolder    = $this->input->post('subFolder', TRUE); 
        $document_id  = $this->input->post('document_id', TRUE); 
        $trans_doc_id = $this->input->post('trans_doc_id', TRUE); 
        $folder_id    = $this->input->post('folder_id', TRUE); 
        $idUser       = trim($this->session->userdata('id_user'));
        //echo $document_id.'+'.$subFolder;
        $getGeneralIndexName  = $this->my_collection_m->getGeneralIndexName($folder_id,$subFolder);
        $getSpecificIndexName = $this->my_collection_m->getSpecificIndexName($document_id,$trans_doc_id,$idUser);
        $data = array(
            'getGeneralIndexName'  => $getGeneralIndexName,
            'getSpecificIndexName' => $getSpecificIndexName,
        );  
        $this->output->set_output(json_encode($data));          
    }

    public function getCollectionSub() {
        $folder_id = $this->input->post('folder_id', TRUE);  
        $idUser       = trim($this->session->userdata('id_user'));
        $usergroup = trim($this->session->userdata('usergroup'));
        $rows = $this->my_collection_m->getCollectionSub($folder_id,$idUser,$usergroup);
        $data['data'] = array();
        $no = 0;
        foreach ($rows as $row) {
            $no++;
            $array = array(
                'no'            => $no,
                'folder_id'     => trim($row->folder_id),
                'sub_folder'    => trim($row->sub_folder),
                'createDate'    => date('d-m-Y H:i:s',strtotime($row->create_date)),
                'createBy'      => trim($row->name),
                'createById'    => trim($row->create_by),
                'Actions'       => null
            );

            array_push($data['data'], $array);
        }
        $this->output->set_output(json_encode($data));        
    }

    function getFieldAll() {
        $categoryDoc = $this->input->post('categoryDoc', TRUE);  
        //$categoryDoc = $_GET['categoryDoc'];
        $rows = $this->my_collection_m->getFieldAll($categoryDoc);
        
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
      
        $this->output->set_output(json_encode($data));
    }

    function getFieldAllEdit() {
        $trans_doc_id = $this->input->post('trans_doc_id', TRUE); 
        //$trans_doc_id = $_GET['trans_doc_id'];
        $rows = $this->my_collection_m->getFieldAllEdit($trans_doc_id);
        
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
      
        $this->output->set_output(json_encode($data));
    }

    function getUserApproval() {       
        $trans_doc_id = $_GET['trans_doc_id'];
        $rows = $this->my_collection_m->getUserApproval($trans_doc_id);
        
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
      
        $this->output->set_output(json_encode($data));
    }

    function getstatusApproval() {       
        $trans_doc_id = $_GET['trans_doc_id'];
        $idUser       = trim($this->session->userdata('id_user'));
        $rows = $this->my_collection_m->getstatusApproval($trans_doc_id,$idUser);
        
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
      
        $this->output->set_output(json_encode($data));
    }

    function getFieldGeneralAll() {
        $folder_id = $this->input->post('folder_id', TRUE);  
        // $subFolder = $this->input->post('subFolder', TRUE);  
        //$folder_id = $_GET['folder_id'];
        //echo $folder_id;
        
        $rows = $this->my_collection_m->getFieldGeneralAll($folder_id);
        
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
      
        $this->output->set_output(json_encode($data));
    }

    // function getFieldGeneralAllEdit() {
    //     $folder_id  = $_GET['folder_id'];
    //     $sub_folder = $_GET['sub_folder'];
    //     //echo $folder_id;
        
    //     $rows = $this->my_collection_m->getFieldGeneralAllAndValue($folder_id,$sub_folder);
        
    //     $data = array();
    //     foreach ($rows as $row)
    //             $data[] = $row;
      
    //     $this->output->set_output(json_encode($data));
    // }

    function getFieldGeneralAllAndValue() {
        $folder_id = $this->input->post('folder_id', TRUE);  
        $subFolder = $this->input->post('subFolder', TRUE);  
        // $folder_id = $_GET['folder_id'];
        // $subFolder = $_GET['subFolder'];
        //echo $folder_id.'-'.$subFolder;
        
        $rows = $this->my_collection_m->getFieldGeneralAllAndValue($folder_id,$subFolder);
        
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
      
        $this->output->set_output(json_encode($data));
    }

    function simpanFolder(){
        $idUser               = $this->session->userdata('id_user');
        $datetime             = date("Y-m-d H:i:s");
        $date                 = date("Y-m-d");
        $folderID             = trim($this->input->post('folderID2'));
        // $categoryDocVal2      = trim($this->input->post('categoryDocVal2'));
        $nameGeneralArr       = $this->input->post('nameGeneral');
        $nameGeneralIDArr     = $this->input->post('general_index_id');
        $totalNameGeneral     = count($this->input->post('nameGeneral'));
        $folderNameID         = $this->input->post('folderNameID2');
        $nameGeneralArrNew    = $this->clean($nameGeneralArr);//str_replace(' ', '_', $nameGeneralArr);
        $subFolder            = $folderNameID.'_'.implode("_",$nameGeneralArrNew);
        $general_index_format = $this->input->post('general_index_format');


        //cho($totalNameGeneral);
        
        $model = $this->my_collection_m->insert_folder($nameGeneralArr,$nameGeneralIDArr,$totalNameGeneral,$date,$folderID,$datetime,$idUser,$subFolder,$general_index_format);
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
            'tipePesan' => 'error',
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

    function editFolder(){
        $idUser                 = $this->session->userdata('id_user');
        $datetime               = date("Y-m-d H:i:s");
        $date                   = date("Y-m-d");        
        $nameGeneralArr         = $this->input->post('nameGeneral');         
        $nameGeneralArrNew      = str_replace(' ', '_', $nameGeneralArr);          
        $totalNameGeneral       = count($this->input->post('nameGeneral'));
        $nameGeneralIDArr       = $this->input->post('general_index_id');
        $transIndexGeneralIDArr = $this->input->post('transIndexGeneralID');
        $general_index_format   = $this->input->post('general_index_format');
        $folderIDEditSf         = trim($this->input->post('folderIDEditSf'));
        $subFolderEditSf        = trim($this->input->post('subFolderEditSf'));
        $folderNameEditSf       = $this->input->post('folderNameEditSf');
        $subFolderEditSfNew     = $folderNameEditSf.'_'.implode("_",$nameGeneralArrNew); 
        $directory              = "uploads/".$folderNameEditSf."/".$subFolderEditSf;
        $directoryNew           = "uploads/".$folderNameEditSf."/".$subFolderEditSfNew;
   
        // rename($directory,$directoryNew);
        // echo $directory."_".$directoryNew;die();        
        $model = $this->my_collection_m->edit_folder($idUser,$datetime,$date,$folderIDEditSf,$nameGeneralArr,$nameGeneralArrNew,$totalNameGeneral,$nameGeneralIDArr,$transIndexGeneralIDArr,$general_index_format,$subFolderEditSf,$subFolderEditSfNew,$directory,$directoryNew);
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

    function hapus() {
        $folder_id = $this->input->post('folder_id', TRUE);  
        //$folder_id = $_GET['folder_id'];
        $data = array(
            'status' => 1,
        );
        $model = $this->my_collection_m->deletefolder($folder_id,$data);
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

    function DeleteSubFolder() {
        $sub_folder = $this->input->post('sub_folder', TRUE); 
        //$sub_folder = $_GET['sub_folder'];
        $data = array(
            'status' => 1,
        );
        $model = $this->my_collection_m->DeleteSubFolder($sub_folder,$data);
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

    function deleteDocument() {
        $trans_doc_id = $this->input->post('trans_doc_id', TRUE); 
        //$trans_doc_id = $_GET['trans_doc_id'];
        $data = array(
            'status' => 1,
        );
        $model = $this->my_collection_m->deleteDocument($trans_doc_id,$data);
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

    public function deleteFile(){
        $directory = $this->input->post('directory', TRUE); 
        //$directory = $_GET['directory'];
        //echo $directory;
        chown($directory, 666);
        //rename("./".$directory."","./".$directoryNew."");
        if (unlink("./".$directory."")) {
            $array = array(
            'act' => 0,
            'tipePesan' => 'success',
            'pesan' => 'success',
            );
        } else {
            $array = array(
            'act' => 0,
            'tipePesan' => 'error',
            'pesan' => 'error',
            );
        }
        $this->output->set_output(json_encode($array));   
    }

    public function simpan(){
        //echo "The file $filename exists";
        $idUser               = $this->session->userdata('id_user');
        $datetime             = date("Y-m-d H:i:s");
        $date                 = date("Y-m-d");
        $fileNameUpload       = $this->input->post('fileNameUpload');
        $directory            = $this->input->post('directory');
        $folderID             = trim($this->input->post('folderID'));
        $categoryDocVal       = trim($this->input->post('categoryDocVal'));
        $nameGeneralArr       = $this->input->post('nameGeneral');
        $nameGeneralIDArr     = $this->input->post('general_index_id');
        $totalNameGeneral     = count($this->input->post('nameGeneral'));
        $folderNameID         = $this->input->post('folderNameID');
        $nameGeneralArrNew    = str_replace(' ', '_', $nameGeneralArr);
        $subFolder            = $folderNameID.'_'.implode("_",$nameGeneralArrNew);
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

        // for($j=0; $j<$totalNameSpecfic; $j++){
        //             if($formatSpesificIDArr[$j] == 4)
        //       {     

        //             $nameSpecificArrvAl = str_replace(',', '', $nameSpecificArr[$j]);

        //         }else{
        //              $nameSpecificArrvAl = $nameSpecificArr[$j];
        //         }
        // }
        // echo $nameSpecificArrvAl;
        // echo "<pre>";
        // print_r( $nameSpecificArrvAl);die();
        // echo "</pre>";

        if (file_exists($directory)) {
           $model = $this->my_collection_m->insert_all($nameGeneralArr,$nameGeneralIDArr,$totalNameGeneral,$date,$folderID,$datetime,$idUser,$subFolder,$nameSpecificArr,$nameSpecificIDArr,$totalNameSpecfic,$categoryDocVal,$directory,$fileNameUpload,$formatSpesificIDArr,$general_index_format,$fileSize);
        
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

    public function editDoc(){
        
        $fileNameUpload         = $this->input->post('fileNameUpload'); 
        $directoryDropZone      = $this->input->post('directory'); 
        //echo $fileNameUpload.'_'.$directoryDropZone;die();
        $idUser                 = $this->session->userdata('id_user');
        $datetime               = date("Y-m-d H:i:s");
        $date                   = date("Y-m-d");        
        $nameGeneralArr         = $this->input->post('nameGeneral');         
        $nameGeneralArrNew      = str_replace(' ', '_', $nameGeneralArr);          
        $totalNameGeneral       = count($this->input->post('nameGeneral'));
        $nameGeneralIDArr       = $this->input->post('general_index_id');
        $transIndexGeneralIDArr = $this->input->post('transIndexGeneralID');
        $general_index_format   = $this->input->post('general_index_format');
        $folderIDEditDoc        = trim($this->input->post('folderIDEditDoc'));
        $subFolderEditDoc       = trim($this->input->post('subFolderEditDoc'));
        $folderNameEditDoc      = $this->input->post('folderNameEditDoc');
        $transDocIdEditDoc      = trim($this->input->post('transDocIdEditDoc'));
        $subFolderEditDocNew    = $folderNameEditDoc.'_'.implode("_",$nameGeneralArrNew); 
        $directory              = "uploads/".$folderNameEditDoc."/".$subFolderEditDoc;
        $directoryNew           = "uploads/".$folderNameEditDoc."/".$subFolderEditDocNew;
        $fileSizeEditDoc        = trim($this->input->post('fileSizeEditDoc'));


        $nameSpecificArr      = $this->input->post('name');
        $nameSpecificIDArr    = $this->input->post('specific_index_id');
        if($nameSpecificArr == 0 || $nameSpecificArr=="" || is_null($nameSpecificArr)){
            $totalNameSpecfic     = 0;
        }else{
            $totalNameSpecfic     = count($nameSpecificArr);
        }
        
        $formatSpesificIDArr  = $this->input->post('specific_index_format');
        $transIndexSpecificIDArr = $this->input->post('transIndexSpecificID');
     
        $model = $this->my_collection_m->editDoc($idUser,$datetime,$date,$folderIDEditDoc,$nameGeneralArr,$nameGeneralArrNew,$totalNameGeneral,$nameGeneralIDArr,$transIndexGeneralIDArr,$general_index_format,$subFolderEditDoc,$subFolderEditDocNew,$directory,$directoryNew,$nameSpecificArr,$nameSpecificIDArr,$totalNameSpecfic,$transDocIdEditDoc,$formatSpesificIDArr,$transIndexSpecificIDArr,$fileNameUpload,$directoryDropZone,$fileSizeEditDoc);
        //echo $model;        
        if($model == 1){
            $array = array(
            'act' => 1,
            'tipePesan' => 'success',
            'pesan' => 'success',
            'subFolder' => $subFolderEditDocNew,
            );
        }else{
           $array = array(
            'act' => 0,
            'tipePesan' => 'error',
            'pesan' => 'error',
            'subFolder' => $subFolderEditDocNew,
            ); 
        }
        $this->output->set_output(json_encode($array));   
                
    }

    public function editSetApproval(){        
        $setUserApproval         = $this->input->post('setUserApproval'); 
        $transDocSetApprove      = $this->input->post('transDocSetApprove'); 
        $valeuOpenSetApproval    = $this->input->post('valeuOpenSetApproval');
        $editOrInsertSetApproval = trim($this->input->post('editOrInsertSetApproval'));
        $setUserApprovalArr      = $this->input->post('setUserApproval');
        if($setUserApprovalArr=="" || empty($setUserApprovalArr)){
            $userAllowed            = "-";
        }else{
            $userAllowed         = '+'.trim(implode("+",$setUserApprovalArr));
        }
        
        
        //echo $this->input->post('setUserApproval');
        if($this->input->post('setUserApproval') == "" || empty($this->input->post('setUserApproval'))){
            $totalUser = 0;
        }else{
            $totalUser = count($this->input->post('setUserApproval'));
        }
        
        $datetime = date("Y-m-d H:i:s");
        $date     = date("Y-m-d");
        $idUser   = $this->session->userdata('id_user');
        //$model = $this->my_collection_m->insertSetApproval($setUserApproval,$transDocSetApprove,$totalUser,$idUser,$date,$datetime);
        if($editOrInsertSetApproval==0){
            //echo "string";die();
            $model = $this->my_collection_m->insertSetApproval($setUserApproval,$transDocSetApprove,$totalUser,$idUser,$date,$datetime,$userAllowed);
        }else{
             //echo "rrr";die();
            $model = $this->my_collection_m->updateSetApproval($setUserApproval,$transDocSetApprove,$totalUser,$idUser,$date,$datetime,$userAllowed);
        }
        if($model == 1){
            $array = array(
            'act' => 1,
            'tipePesan' => 'success',
            'pesan' => 'success',
            'valeuOpenSetApproval' => $valeuOpenSetApproval,
            );
        }else{
           $array = array(
            'act' => 0,
            'tipePesan' => 'error',
            'pesan' => 'error',
            'valeuOpenSetApproval' => $valeuOpenSetApproval,
            ); 
        }
        $this->output->set_output(json_encode($array));  

        //echo $totalUser;die();         
    }

    public function updateApproval(){        
        $id_approval = $this->input->post('id_approval'); 
        $note        = $this->input->post('note'); 
        $status      = $this->input->post('status');
        $datetime    = date("Y-m-d H:i:s");

        $data = array(
                'note'           => $note,
                'status_approve' => $status,
                'update_date'    => $datetime,
            );
        $model = $this->my_collection_m->updateApproval($data,$id_approval);
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

        //echo $totalUser;die();         
    }

    function loginApproval() {
        $value       = $this->input->get('value');
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
            $data ['value'] = $value;
            $this->load->view('login_template/login_approval_v', $data);
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

    //  public function uploadFileAdd(){
    //     $folderNameCmp   = $this->input->post('folderNameCmp');
    //     $folderNameArr   = explode('+', $folderNameCmp);
    //     $folderName      = $folderNameArr[0];
    //     $SubFolder       = $folderNameArr[1];
    //     $date            = date("Y-m-d H:i:s");
    //     $date2           = date("Y-m-d");
    //     $filePath        = './uploads';
    //     $filePathNew     = $filePath.'/'.$folderName.'/'.$SubFolder;
    //     $dateFile        = date("YmdH:i:s");
    //     // $imagePathNew = $imagePath."2018-07-19";            
    //     if(!is_dir($filePathNew)) {
    //        mkdir($filePathNew, 0777, TRUE);
    //     }
    //     $config['upload_path']   = "".$filePathNew."";
    //     $config['allowed_types'] = 'jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF|pdf|PDF|TIF|tif';
    //     $config['max_size']      = 0;
    //     $this->load->library('upload', $config);

    //     if ($this->upload->do_upload("filenameAdd")) {
    //         $error    = array('array' => $this->upload->display_errors());
    //         $data     = $this->upload->data();
           
    //         $fileName = $this->upload->data('file_name');
            
            
    //         $source   = $filePathNew. "/" . $fileName;
    //         //die($source);
    //         chmod($source, 0777);
    //         $directory = 'uploads/'.$folderName.'/'.$SubFolder.'/'.$fileName;
    //         $array = array(
    //             'fileName'  => $fileName,
    //             'directory' => $directory
    //         ); 
    //         $this->output->set_output(json_encode($array));

    //     } else {
    //         echo $this->upload->display_errors();
    //         echo "gagal";
    //     }
    // }

    // public function simpan(){
    //     //echo "The file $filename exists";
    //     $idUser               = $this->session->userdata('id_user');
    //     $datetime             = date("Y-m-d H:i:s");
    //     $date                 = date("Y-m-d");
    //     $fileNameUpload       = $this->input->post('fileNameUpload');
    //     $directory            = $this->input->post('directory');
    //     $folderID             = trim($this->input->post('folderID'));
    //     $categoryDocVal       = trim($this->input->post('categoryDocVal'));
    //     $nameGeneralArr       = $this->input->post('nameGeneral');
    //     $nameGeneralIDArr     = $this->input->post('general_index_id');
    //     $totalNameGeneral     = count($this->input->post('nameGeneral'));
    //     $folderNameID         = $this->input->post('folderNameID');
    //     $nameGeneralArrNew    = str_replace(' ', '_', $nameGeneralArr);
    //     $subFolder            = $folderNameID.'_'.implode("_",$nameGeneralArrNew);
    //     $nameSpecificArr      = $this->input->post('name');
    //     $nameSpecificIDArr    = $this->input->post('specific_index_id');
    //     if($nameSpecificArr == 0 || $nameSpecificArr=="" || is_null($nameSpecificArr)){
    //         $totalNameSpecfic     = 0;
    //     }else{
    //         $totalNameSpecfic     = count($nameSpecificArr);
    //     }
        
    //     $formatSpesificIDArr  = $this->input->post('specific_index_format');
    //     $general_index_format = $this->input->post('general_index_format');
    //     $fileSize             = $this->input->post('fileSize');

    //     if (file_exists($directory)) {
    //        $model = $this->my_collection_m->insert_all($nameGeneralArr,$nameGeneralIDArr,$totalNameGeneral,$date,$folderID,$datetime,$idUser,$subFolder,$nameSpecificArr,$nameSpecificIDArr,$totalNameSpecfic,$categoryDocVal,$directory,$fileNameUpload,$formatSpesificIDArr,$general_index_format,$fileSize);
        
    //         if($model){
    //             $array = array(
    //             'act' => 1,
    //             'tipePesan' => 'success',
    //             'pesan' => 'success',
    //             );
    //         }else{
    //            unlink($directory);
    //            $array = array(
    //             'act' => 0,
    //             'tipePesan' => 'error',
    //             'pesan' => 'error',
    //             ); 
    //         }
    //         $this->output->set_output(json_encode($array));   
    //     } else {
    //         $array = array(
    //             'act' => 0,
    //             'tipePesan' => 'error',
    //             'pesan' => 'error',
    //             );
    //         $this->output->set_output(json_encode($array));  
    //     }      
                
    // }

    // function simpan(){
    //     $idUser               = $this->session->userdata('id_user');
    //     $datetime             = date("Y-m-d H:i:s");
    //     $date                 = date("Y-m-d");
    //     $fileNameUpload       = $this->input->post('fileNameUploadArr');
    //     $fileNameUploadArr    = explode('+', $fileNameUpload);
    //     $totalFileNameUpload  = count($fileNameUploadArr);
    //     $directory            = $this->input->post('directoryArr');
    //     $directoryArr         = explode('+', $directory);

    //     $folderID             = trim($this->input->post('folderID'));
    //     $categoryDocVal       = trim($this->input->post('categoryDocVal'));
    //     $nameGeneralArr       = $this->input->post('nameGeneral');
    //     $nameGeneralIDArr     = $this->input->post('general_index_id');
    //     $totalNameGeneral     = count($this->input->post('nameGeneral'));
    //     $folderNameID         = $this->input->post('folderNameID');
    //     $nameGeneralArrNew    = str_replace(' ', '_', $nameGeneralArr);
    //     $subFolder            = $folderNameID.'_'.implode("_",$nameGeneralArrNew);
    //     $nameSpecificArr      = $this->input->post('name');
    //     $nameSpecificIDArr    = $this->input->post('specific_index_id');
    //     if($nameSpecificArr == 0 || $nameSpecificArr=="" || is_null($nameSpecificArr)){
    //         $totalNameSpecfic     = 0;
    //     }else{
    //         $totalNameSpecfic     = count($nameSpecificArr);
    //     }
        
    //     $formatSpesificIDArr  = $this->input->post('specific_index_format');
    //     $general_index_format = $this->input->post('general_index_format');
    //     $fileSize             = $this->input->post('fileSize');


    //     //cho($totalNameGeneral);
        
    //     $model = $this->my_collection_m->insert_all($nameGeneralArr,$nameGeneralIDArr,$totalNameGeneral,$date,$folderID,$datetime,$idUser,$subFolder,$nameSpecificArr,$nameSpecificIDArr,$totalNameSpecfic,$totalFileNameUpload,$categoryDocVal,$directoryArr,$fileNameUploadArr,$formatSpesificIDArr,$general_index_format,$fileSize);
        
    //     if($model){
    //         $array = array(
    //         'act' => 1,
    //         'tipePesan' => 'success',
    //         'pesan' => 'success',
    //         'subFolder' => $subFolder
    //         );
    //     }else{
    //        $array = array(
    //         'act' => 0,
    //         'tipePesan' => 'error',
    //         'pesan' => 'error',
    //         'subFolder' => $subFolder
    //         ); 
    //     }
    //     $this->output->set_output(json_encode($array));   
    // }

    // public function uploadFileAdd(){
    //     $folderNameCmp   = $this->input->post('folderNameCmp');
    //     $folderNameArr   = explode('+', $folderNameCmp);
    //     $folderName      = $folderNameArr[0];
    //     $SubFolder       = $folderNameArr[1];
    //     $date            = date("Y-m-d H:i:s");
    //     $date2           = date("Y-m-d");
    //     $filePath        = './uploads';
    //     $filePathNew     = $filePath.'/'.$folderName.'/'.$SubFolder;
    //     $dateFile        = date("YmdH:i:s");
    //     // $imagePathNew = $imagePath."2018-07-19";            
    //     if(!is_dir($filePathNew)) {
    //        mkdir($filePathNew, 0777, TRUE);
    //     }
    //     $config['upload_path']   = "".$filePathNew."";
    //     $config['allowed_types'] = 'jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF|pdf|PDF|TIF|tif';
    //     $config['max_size']      = 0;
    //     $this->load->library('upload', $config);

    //     if ($this->upload->do_upload("filenameAdd")) {
    //         $error    = array('array' => $this->upload->display_errors());
    //         $data     = $this->upload->data();
           
    //         $fileName = $this->upload->data('file_name');
            
            
    //         $source   = $filePathNew. "/" . $fileName;
    //         //die($source);
    //         chmod($source, 0777);
    //         $directory = 'uploads/'.$folderName.'/'.$SubFolder.'/'.$fileName;
    //         $array = array(
    //             'fileName'  => $fileName,
    //             'directory' => $directory
    //         ); 
    //         $this->output->set_output(json_encode($array));

    //     } else {
    //         echo $this->upload->display_errors();
    //         echo "gagal";
    //     }
    // }

}