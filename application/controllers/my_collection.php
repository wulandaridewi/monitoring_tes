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
        $this->auth->restrict($data['menu_id']);
        $this->auth->cek_menu($data['menu_id']);
        
        $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
        $data['menu_all']   = $this->user_m->get_menu_all(0);
        //$data['getCategoryDoc'] = $this->my_collection_m->getCategoryDoc();
        $this->template->set('title', 'home');
        $this->template->load('default_template/template9', 'collection/my_collection_v', $data);
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
        // echo $userid;
        $rows   = $this->my_collection_m->getSubFolder($folder_id);
        $data['data'] = array();        
        foreach ($rows as $row) {
            $data = array(
                'folder_id'      => trim($row->folder_id),
                'folder_name'    => trim($row->folder_name),
                'group_document' => str_replace('+', ',', trim($row->group_document)),
            );
        }
        $this->output->set_output(json_encode($data));    
    }

    public function getOpenSubFolder() {
        $sub_folder = $this->input->post('sub_folder', TRUE);  
        $rows   = $this->my_collection_m->getOpenSubFolder($sub_folder);
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
        //echo $document_id.'-'.$sub_folder;
        $data          = array();
        $col           = array();
        $specificIndexFormat = array();
        $getFolderID   = $this->my_collection_m->getFolderID($sub_folder,$document_id);
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
                $folderId      = $value->folder_id;
                $document_name = $value->document_name;
                // $document_id   = $value->document_id;
                $getGeneralIndexName  = $this->my_collection_m->getGeneralIndexName($folderId,$sub_folder);
                $getFieldNameIndexSpecific = $this->my_collection_m->getFieldNameIndexSpecific($document_id);
                foreach ($getFieldNameIndexSpecific as $key => $value) {
                   $col[$key] = $value['specific_index_name'];
                   $specificIndexFormat[$key] = $value['specific_index_format'];
                } 
                // $getTransDoc = $this->my_collection_m->getTransDoc($sub_folder,$document_id);
                $getSpecificIndexNameTable = $this->my_collection_m->getSpecificIndexNameTable($document_id,$sub_folder,$col);
                $data = array(
                    'document_name'             => $document_name,
                    'getGeneralIndexName'       => $getGeneralIndexName,
                    'getSpecificIndexNameTable' => $getSpecificIndexNameTable,
                    'getFieldNameIndexSpecific' => $getFieldNameIndexSpecific,
                    'specificIndexFormat' => $specificIndexFormat,
                );  
                // echo "<pre>";
                // print_r($data);
                // echo "</pre>";
                $this->load->view('collection/list_doc_v', $data);          
            } 
        }
       
    }

    public function getKetFile() {
        $subFolder   = $this->input->post('subFolder', TRUE); 
        $document_id = $this->input->post('document_id', TRUE); 
        $trans_doc_id = $this->input->post('trans_doc_id', TRUE); 
        $folder_id = $this->input->post('folder_id', TRUE); 
        //echo $document_id.'+'.$subFolder;
        $getGeneralIndexName  = $this->my_collection_m->getGeneralIndexName($folder_id,$subFolder);
        $getSpecificIndexName = $this->my_collection_m->getSpecificIndexName($document_id,$trans_doc_id);
        $data = array(
            'getGeneralIndexName'  => $getGeneralIndexName,
            'getSpecificIndexName' => $getSpecificIndexName,
        );  
        $this->output->set_output(json_encode($data));          
    }

    public function getCollectionSub() {
        $folder_id = $this->input->post('folder_id', TRUE);  
        $rows = $this->my_collection_m->getCollectionSub($folder_id);
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
        $categoryDoc = $_GET['categoryDoc'];
        $rows = $this->my_collection_m->getFieldAll($categoryDoc);
        
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
      
        $this->output->set_output(json_encode($data));
    }

    function getFieldAllEdit() {
        $trans_doc_id = $_GET['trans_doc_id'];
        $rows = $this->my_collection_m->getFieldAllEdit($trans_doc_id);
        
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
      
        $this->output->set_output(json_encode($data));
    }


    function getFieldGeneralAll() {
        // $folder_id = $this->input->post('folder_id', TRUE);  
        // $subFolder = $this->input->post('subFolder', TRUE);  
        $folder_id = $_GET['folder_id'];
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
        // $folder_id = $this->input->post('folder_id', TRUE);  
        // $subFolder = $this->input->post('subFolder', TRUE);  
        $folder_id = $_GET['folder_id'];
        $subFolder = $_GET['subFolder'];
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
        $nameGeneralArrNew    = str_replace(' ', '_', $nameGeneralArr);
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
        $folder_id = $_GET['folder_id'];
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
        $sub_folder = $_GET['sub_folder'];
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
        $trans_doc_id = $_GET['trans_doc_id'];
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
        $directory = $_GET['directory'];
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
        $directoryDropZone        = $this->input->post('directory'); 
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
        $folderIDEditDoc         = trim($this->input->post('folderIDEditDoc'));
        $subFolderEditDoc        = trim($this->input->post('subFolderEditDoc'));
        $folderNameEditDoc       = $this->input->post('folderNameEditDoc');
        $transDocIdEditDoc         = trim($this->input->post('transDocIdEditDoc'));
        $subFolderEditDocNew     = $folderNameEditDoc.'_'.implode("_",$nameGeneralArrNew); 
        $directory              = "uploads/".$folderNameEditDoc."/".$subFolderEditDoc;
        $directoryNew           = "uploads/".$folderNameEditDoc."/".$subFolderEditDocNew;
        $fileSizeEditDoc         = trim($this->input->post('fileSizeEditDoc'));


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