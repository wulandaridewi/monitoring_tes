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
        
        // $this->auth->restrict($data['menu_id']);
        // $this->auth->cek_menu($data['menu_id']);
        if ($this->session->userdata('id_user') == '') {
            $this->loginApproval();
            //$this->index();
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
        // $sub_folder_id = $this->input->post('sub_folder_id', TRUE); 
        $idUser    = trim($this->session->userdata('id_user'));
        $usergroup = trim($this->session->userdata('usergroup')); 
        // echo $userid;
        $rows              = $this->my_container_m->viewSubContainer($folder_id,$idUser,$usergroup);
        $data['data'] = array();        
        foreach ($rows as $row) {
            $data = array(
                'folder_name'       => trim($row->folder_name),
                'group_user_doc_id' => trim($row->group_user_doc_id),
            );
        }      
        
        $this->output->set_output(json_encode($data));    
    }

    public function viewSubContainerComp() {
        $folder_id     = $this->input->post('folder_id', TRUE); 
        $sub_folder_id = $this->input->post('sub_folder_id', TRUE); 
        $idUser        = trim($this->session->userdata('id_user'));
        $usergroup     = trim($this->session->userdata('usergroup')); 
        // echo $userid;
        $rows                 = $this->my_container_m->viewSubContainerComp($folder_id,$idUser,$usergroup);
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
        $filePathNew     = $filePath.'/'.$folderName.'/'.$SubFolder.'/'.$catDoc;
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
            $directory = 'uploads/'.$folderName.'/'.$SubFolder.'/'.$catDoc.'/'.$fileName;
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
        $folderId        = $this->input->post('folder_id', TRUE); 
        $idUser          = trim($this->session->userdata('id_user'));
        $usergroup       = trim($this->session->userdata('usergroup'));
        $getDocumentName = $this->my_container_m->getDocumentName($document_id);
        $getGeneralIndexName       = $this->my_container_m->getGeneralIndexName($folderId,$subFolderID);
        $getFieldNameIndexSpecific = $this->my_container_m->getFieldNameIndexSpecific($document_id);
        //print_r($getGeneralIndexName);die();
        $data = array(
            'document_name'             => $getDocumentName,
            'getGeneralIndexName'       => $getGeneralIndexName, 
            'getFieldNameIndexSpecific' => $getFieldNameIndexSpecific,
        );
        $this->output->set_output(json_encode($data));   
    }

    public function getListDoc() {
        $post            = $this->input->post();
        // echo "<pre>";
        // print_r($post);die();
        // echo "<pre>";
        $start        = $post['start'];
        $length       = $post['length'];
        $draw         = $post['draw'];
        $dir          = $post['order'][0]['dir'];
        $search       = $post['search']['value'];
        $document_id  = $this->input->post('document_id', TRUE);  
        $subFolderID  = $this->input->post('subFolderID', TRUE); 
        $idUser       = trim($this->session->userdata('id_user'));
        $usergroup    = trim($this->session->userdata('usergroup'));
        //echo $start.'_'.$length.'_'.$draw.'_'.$dir.'_'.$document_id.'_'.$subFolderID;die();
        $data                = array();
        $col                 = array();
        $specificIndexFormat = array();
        $header              = array();
        $getFieldNameIndexSpecific = $this->my_container_m->getFieldNameIndexSpecific($document_id);
        foreach ($getFieldNameIndexSpecific as $key => $value) {
           $col[$key] = $value['specific_index_name'];
           $specificIndexFormat[$key] = $value['specific_index_format'];
          
        } 
        $getSpecificIndexNameTable    = $this->my_container_m->getSpecificIndexNameTable($document_id,$subFolderID,$col,$idUser,$usergroup,$start,$length,$dir,$search);
        $countAll    = $this->my_container_m->getSpecificIndexNameTableCountAll($document_id,$subFolderID,$col,$idUser,$usergroup,$dir);
        $count_filtered = $this->my_container_m->getSpecificIndexNameTableCountFilter($document_id,$subFolderID,$col,$idUser,$usergroup,$dir,$search);
        //$getStatusApprove = $this->my_container_m->getStatusApprove($document_id);
        foreach ($getSpecificIndexNameTable as $key => $value) {
            $document_size     = $value['document_size'];
            $trans_doc_id      = $value['trans_doc_id'];
            $usershare         = $value['usershare'];
            $usergroup         = $value['usergroup'];
            $group_user_doc_id = $value['group_user_doc_id'];
            $row = array();
            $row[] = '';
            
             if(($usergroup == "NULL" || empty($usergroup) || $usergroup == "" || $usergroup == "null") AND ($usershare == "NULL" || empty($usershare) || $usershare == "" || $usershare == "null")){
            $row[] = '';
            }else{  
                $row[] = "<a onclick=detilShareDoc('".trim($usershare)."+".trim($usergroup)."') style='cursor: pointer;'><i class='fa fa-user-friends'></i></a>";
            }
            if($group_user_doc_id == "NULL" || empty($group_user_doc_id) || $group_user_doc_id == "" || $group_user_doc_id == "null"){
                $row[] =  "<button class='btn btn-icon btn-primary btn-sm mr-2' title='dokumen'><i class='far fa-file-pdf' style='color:white' onclick=prepareFrame('".trim($trans_doc_id)."')></i></button>
                <div class='dropdown dropdown-inline'>
                    <a href='javascript:;' class='btn btn-icon btn-light-primary btn-sm mr-2' data-toggle='dropdown'>
                    <i class='la la-cog'></i></a>
                    <div class='dropdown-menu dropdown-menu-sm dropdown-menu-right'>
                        <ul class='nav nav-hoverable flex-column'>
                            <li class='nav-item'><a class='nav-link' onclick=shareDoc('".trim($trans_doc_id)."+".trim($usershare)."+".trim($usergroup)."') style='cursor: pointer;'><i class='fa fa-share-alt'></i>
                            <span class='nav-text'>&nbsp;Share Document</span></a></li>
                        </ul>
                    </div>
                </div>";
            }else{
                $row[] =  "<button class='btn btn-icon btn-primary btn-sm mr-2' title='dokumen'><i class='far fa-file-pdf' style='color:white' onclick=prepareFrame('".trim($trans_doc_id)."')></i></button>
                <div class='dropdown dropdown-inline'>
                    <a href='javascript:;' class='btn btn-icon btn-light-primary btn-sm mr-2' data-toggle='dropdown'>
                    <i class='la la-cog'></i></a>
                    <div class='dropdown-menu dropdown-menu-sm dropdown-menu-right'>
                        <ul class='nav nav-hoverable flex-column'>
                            <li class='nav-item'><a class='nav-link' onclick=editDocument('".trim($trans_doc_id)."') style='cursor: pointer;'><i class='nav-icon la la-edit'></i>
                            <span class='nav-text'>Edit Indexing</span></a></li>
                            <li class='nav-item'><a class='nav-link' onclick=deleteDocument('".trim($trans_doc_id)."') style='cursor: pointer;'><i class='nav-icon la la-trash'></i>
                            <span class='nav-text'>Delete File</span></a></li>
                            <li class='nav-item'><a class='nav-link' onclick=shareDoc('".trim($trans_doc_id)."+".trim($usershare)."+".trim($usergroup)."') style='cursor: pointer;'><i class='fa fa-share-alt'></i>
                            <span class='nav-text'>&nbsp;Share Document</span></a></li>
                            <li class='nav-item'><a class='nav-link' onclick=setApproval('".trim($trans_doc_id)."') style='cursor: pointer;'><i class='fa fa-user-edit'></i>
                            <span class='nav-text'>&nbsp;Set Approval</span></a></li>
                        </ul>
                    </div>
                </div>";
            }
            //-------info approval
            $getStatusApprove = $this->my_container_m->getStatusApprove($trans_doc_id);
            $totalUserApproval = count($getStatusApprove);
            $hitung = 0;
            $total_waiting = 0;
            $total_approved = 0;
            $total_reject = 0;
            $cetakStatusApproval = "-";
            if(empty($getStatusApprove)){
                $row[] = "-";
            }else{
                foreach ($getStatusApprove as $key => $valueSetApproval) {
                    $statusapprove = trim($valueSetApproval['status_approve']);
                    $hitung++;
                    
                    if($statusapprove == 'waiting'){
                        $total_waiting++;
                    }elseif($statusapprove == 'reject'){
                        $total_reject++;
                    }elseif($statusapprove == 'approved'){
                        $total_approved++;
                    } 
                }

                if($total_waiting == $totalUserApproval || $total_waiting !== 0){
                        $cetakStatusApproval = "<a class='label label-lg label-light-warning label-inline' onclick=detailApproval('".trim($trans_doc_id)."') style='cursor: pointer;'>Waiting</a>";
                }elseif ($total_reject == $totalUserApproval || ($total_reject !==0 && $total_waiting == 0)) {
                    $cetakStatusApproval = "<a class='label label-lg label-light-danger label-inline' onclick=detailApproval('".trim($trans_doc_id)."') style='cursor: pointer;'>Rejected</a>";
                }elseif ($total_approved == $totalUserApproval || ($total_waiting == 0 && $total_reject == 0)) {
                    $cetakStatusApproval = "<a class='label label-lg label-light-primary label-inline' onclick=detailApproval('".trim($trans_doc_id)."') style='cursor: pointer;'>Approved</a>";
                } 
                $row[] = "$cetakStatusApproval";
            }
            //-------End info approval
                for ($i=0; $i < count($col); $i++) { 
                    if($specificIndexFormat[$i] == 4){
                        if($value[$col[$i]] == "" || $value[$col[$i]]=="NULL" || empty($value[$col[$i]])){
                            $valueSpecific = "0.00";
                        }else{
                           $valueSpecific = number_format($value[$col[$i]], 2); 
                        }
                        
                    }else{
                        $valueSpecific = $value[$col[$i]];
                    }
            $row[] = $valueSpecific;   
                }
            
            $row[] = $document_size." Kb";
            $data[] = $row;
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $countAll,//$countAll,
            "recordsFiltered" => $count_filtered,//$count_filtered,
            //"columns" => $header,
            "data" => $data,
        ); 
        // echo "<pre>";
        // print_r($output);die();
        // echo "<pre>";
        $this->output->set_output(json_encode($output));   
    }

    public function getKetFile() {
        $subFolderID  = $this->input->post('subFolderID', TRUE); 
        $document_id  = $this->input->post('document_id', TRUE); 
        $folder_id    = $this->input->post('folder_id', TRUE); 
        $trans_doc_id = $this->input->post('trans_doc_id', TRUE); 
        $statusApprove = $this->input->post('statusApprove', TRUE); 
        // echo $trans_doc_id;die();
        $idUser       = trim($this->session->userdata('id_user'));
        //echo $document_id.'+'.$subFolder;
        $getFileName          = $this->my_container_m->getFileName($trans_doc_id);
        $getGeneralIndexName  = $this->my_container_m->getGeneralIndexName($folder_id,$subFolderID);
        $getSpecificIndexName = $this->my_container_m->getSpecificIndexName($document_id,$trans_doc_id,$idUser,$statusApprove);
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
        $categoryDocEdit         = $this->input->post('categoryDocEdit');
        $directory               = "uploads/".$folderNameEditDoc."/".$subFolderNameEditDocOld."/".$categoryDocEdit;
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

    function deleteShareDoc() {
        $trans_doc_id = $this->input->post('trans_doc_id', TRUE); 
        $userid       = $this->input->post('userid', TRUE); 
        $model = $this->my_container_m->deleteShareDoc($trans_doc_id,$userid);
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
        $trans_doc_id      = $this->input->post('trans_doc_id', TRUE); 
        $group_user_doc_id = $this->input->post('group_user_doc_id', TRUE); 
        $rows = $this->my_container_m->getUserShare($trans_doc_id,$group_user_doc_id);
        $data = array();
        $no=0;
        foreach ($rows as $key => $value) {
            $no++;
            
            $userimage = trim($value['name_file_image']);
            $nameUser  = trim($value['user_share']);
            $deptUser  = trim($value['department']);
            $lastDate  = trim($value['share_date']);
            $shared_by = trim($value['shared_by']);
            $status    = trim($value['status']);
            $userid    = trim($value['userid']);
            //echo $nameUser;die();
            $row  = array();
            $row[]  = $no;
            $row[] = "<div class='d-flex align-items-center'><div class='symbol symbol-50 symbol-light mr-4'><span class='symbol-label'><img src='".base_url()."assets/media/svg/avatars/".$userimage."' class='h-75 align-self-end'></span></div><div><a class='text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg'>".$nameUser."</a><span class='text-muted font-weight-bold d-block'>".$deptUser."</span></div></div>";  
                            
            $row[]  = $lastDate;
            $row[]  = $shared_by;
            

            if($status == 0){
                $row[]  = 'User Group Document';
                $row[] = '<a class="btn btn-danger btn-elevate btn-pill btn-elevate-air btn-sm disabled" ><i class="flaticon-reply"></i>Unshare</a>';
                
            }elseif($status == 3){
                $row[]  = 'User Approval';
                 $row[] = '<a class="btn btn-danger btn-elevate btn-pill btn-elevate-air btn-sm disabled" ><i class="flaticon-reply"></i>Unshare</a>';
            }elseif($status == 1){
                $row[]  = 'User Share';
                $row[] = '<a class="btn btn-danger btn-elevate btn-pill btn-elevate-air btn-sm" onclick=deleteShareDoc("'.$trans_doc_id.'+'.$userid.'")><i class="flaticon-reply"></i>Unshare</a>';
            }elseif($status == 2){
                //$row[]  = 'User Share & Approval';
                $row[]  = 'User Share';
                $row[] = '<a class="btn btn-danger btn-elevate btn-pill btn-elevate-air btn-sm" onclick=deleteShareDoc("'.$trans_doc_id.'+'.$userid.'")><i class="flaticon-reply"></i>Unshare</a>';
            }
            $data[] = $row;
        }
        $output = array(
            "data" => $data,
        );
        // echo "<pre>";
        // print_r($output);die();
        //  echo "</pre>";
        $this->output->set_output(json_encode($output));
    }

    function getNotUserShare() {       
        //$trans_doc_id = $_GET['trans_doc_id'];
        $trans_doc_id      = $this->input->post('trans_doc_id', TRUE); 
        $group_user_doc_id = $this->input->post('group_user_doc_id', TRUE); 
        $rows = $this->my_container_m->getNotUserShare($trans_doc_id,$group_user_doc_id);

        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
        $this->output->set_output(json_encode($data));
    }

    function getUserApproval() {       
        //$trans_doc_id = $_GET['trans_doc_id'];
        $trans_doc_id      = $this->input->post('trans_doc_id', TRUE); 
        $rows = $this->my_container_m->getUserApproval($trans_doc_id);

        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
        $this->output->set_output(json_encode($data));
    }
     public function InsertShareDoc(){   
        $datetime = date("Y-m-d H:i:s");
        $date     = date("Y-m-d");
        $idUser   = $this->session->userdata('id_user');

        $transDocShareDoc     = $this->input->post('transDocShareDoc'); 
        $setUserShareDocArr   = $this->input->post('setUserShareDoc');
        $totalUser            = count((array)$this->input->post('setUserShareDoc'));

        $model = $this->my_container_m->insertShareDoc($setUserShareDocArr,$transDocShareDoc,$totalUser,$idUser,$date,$datetime);
        //$editOrInsertShareDoc = $this->input->post('editOrInsertShareDoc');
        //echo $totalUser;die();
        // if($editOrInsertShareDoc == ""){
        //     $model = $this->my_container_m->insertShareDoc($setUserShareDocArr,$transDocShareDoc,$totalUser,$idUser,$date,$datetime);
        // }else{
        //     $model = $this->my_container_m->editShareDoc($setUserShareDocArr,$transDocShareDoc,$totalUser,$idUser,$date,$datetime,$editOrInsertShareDoc);
        // }    

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
    
     public function insertSetApproval(){   
        $datetime = date("Y-m-d H:i:s");
        $date     = date("Y-m-d");
        $idUser   = $this->session->userdata('id_user');
        $transDocSetApprove      = $this->input->post('transDocSetApprove'); 
        $editOrInsertSetApproval = $this->input->post('editOrInsertSetApproval'); 
        $setUserApprovalArr      = $this->input->post('setUserApproval');
        $totalUser               = count((array)$this->input->post('setUserApproval'));        
        //echo $totalUser;die();

        if($editOrInsertSetApproval == ""){
            $model = $this->my_container_m->insertSetApproval($setUserApprovalArr,$transDocSetApprove,$totalUser,$idUser,$date,$datetime);
        }else{
            $model = $this->my_container_m->editSetApproval($setUserApprovalArr,$transDocSetApprove,$totalUser,$idUser,$date,$datetime,$editOrInsertSetApproval);
        }    

        if($model == 'true'){
            $array = array(
            'act' => 1,
            'tipePesan' => 'success',
            'pesan' => 'success',
            );
        }elseif($model == 'sendEmailFailed'){
            $array = array(
            'act' => 1,
            'tipePesan' => 'warning',
            'pesan' => 'email failed to send',
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

    function getstatusApproval() {       
        $trans_doc_id = $this->input->post('trans_doc_id', TRUE); 
        $idUser       = trim($this->session->userdata('id_user'));
        $rows = $this->my_container_m->getstatusApproval($trans_doc_id,$idUser);
        
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
      
        $this->output->set_output(json_encode($data));
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
        $model = $this->my_container_m->updateApproval($data,$id_approval,$status);
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
            $success = $this->auth->do_login($username, $password, $tgl_d, $tgl_y,$bind);
            if ($bind) {
                // echo "ooooooookkkkkkkkkkkkkkkk";die();
                @ldap_close($ldap); 
               
                if ($success) {
                    $data ['multilevel'] = $this->user_m->get_data(0, $this->session->userdata('usergroup'));
                    $array = array(
                        'act' => 1,
                        'ldap' => $bind
                    );
                    $this->output->set_output(json_encode($array));
                } else {
                    //echo "not ooooooookkkkkkkkkkkkkkkk";die();    
                    $data ['title']             = "Astragraphia | Login";
                    $data ['login_info']        = "Maaf, username dan password salah!";
                    //$this->load->view('login_template/login_v', $data);
                    $array = array(
                        'act'       => 0,
                        'tipePesan' => 'User dan Password salah',
                        'pesan'     => 'danger',
                        'ldap' => $bind
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
                    $array = array(
                        'act'       => 0,
                        'tipePesan' => 'User dan Password salah',
                        'pesan'     => 'danger',
                        'ldap'      => $bind
                    );
                    $this->output->set_output(json_encode($array));
                } 
            }            
            //---------LDAP--------------            
        }
    } 
}