<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search_file extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('search/search_file_m');
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
        $menuId              = $this->home_m->get_menu_id('search/search_file/home');
        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_name']   = $menuId[0]->menu_name;
        $this->auth->restrict($data['menu_id']);
        //$this->auth->cek_menu($data['menu_id']);
      
        $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
        $data['menu_all']   = $this->user_m->get_menu_all(0);
        //$data['getCategoryDoc']     = $this->search_file_m->getCategoryDoc();
        $usergroup = trim($this->session->userdata('usergroup'));
        $idUser    = trim($this->session->userdata('id_user'));
        $data['getContainer'] = $this->search_file_m->getContainer($usergroup,$idUser);

        $this->template->set('title', 'home');
        $this->template->load('default_template/template9', 'search/search_file_v', $data);
    }
    public function getListDocDetailFolder() {
        $document_id     = $this->input->post('document_id', TRUE);  
        $folderId        = $this->input->post('folder_id', TRUE); 
        $idUser          = trim($this->session->userdata('id_user'));
        $usergroup       = trim($this->session->userdata('usergroup'));
        $getFieldNameIndexGeneral  = $this->search_file_m->getFieldNameIndexGeneral($folderId);
        $getFieldNameIndexSpecific = $this->search_file_m->getFieldNameIndexSpecific($document_id);
        
        $data = array(
            'getFieldNameIndexGeneral'  => $getFieldNameIndexGeneral,
            'getFieldNameIndexSpecific' => $getFieldNameIndexSpecific,
        );
        $this->output->set_output(json_encode($data));   
    }

    public function getListDoc() {
        $post            = $this->input->post();
        // echo "<pre>";
        // print_r($post);die();
        // echo "<pre>";
        $start       = $post['start'];
        $length      = $post['length'];
        $draw        = $post['draw'];
        $dir         = $post['order'][0]['dir'];
        $search      = $post['search']['value'];
        $document_id = $this->input->post('document_id', TRUE);  
        $folderId    = $this->input->post('folderId', TRUE); 
        $idUser      = trim($this->session->userdata('id_user'));
        $usergroup   = trim($this->session->userdata('usergroup'));
        //echo $start.'_'.$length.'_'.$draw.'_'.$dir.'_'.$document_id.'_'.$subFolderID;die();
        $data                = array();
        $col                 = array();
        $colGeneral          = array();
        $specificIndexFormat = array();
        $getFieldNameIndexGeneral  = $this->search_file_m->getFieldNameIndexGeneral($folderId);
        foreach ($getFieldNameIndexGeneral as $key2 => $value2) {
            $colGeneral[$key2] = $value2['general_index_id'];           
        }
        $getFieldNameIndexSpecific = $this->search_file_m->getFieldNameIndexSpecific($document_id);
        foreach ($getFieldNameIndexSpecific as $key => $value) {
           $col[$key] = $value['specific_index_name'];
           $specificIndexFormat[$key] = $value['specific_index_format'];
        } 
        $getSpecificIndexNameTable    = $this->search_file_m->getSpecificIndexNameTable($document_id,$folderId,$col,$idUser,$usergroup,$start,$length,$dir,$search);
        $countAll    = $this->search_file_m->getSpecificIndexNameTableCountAll($document_id,$folderId,$col,$idUser,$usergroup,$dir);
        $count_filtered = $this->search_file_m->getSpecificIndexNameTableCountFilter($document_id,$folderId,$col,$idUser,$usergroup,$dir,$search);
        foreach ($getSpecificIndexNameTable as $key => $value) {
            $document_size = $value['document_size'];
            $trans_doc_id  = $value['trans_doc_id'];
            $usershare     = $value['usershare'];
            $usergroup     = $value['usergroup'];
            $sub_folder_id = $value['sub_folder_id'];
            $row = array();
            $row[] = '';
            
            if(($usergroup == "NULL" || empty($usergroup) || $usergroup == "" || $usergroup == "null") AND ($usershare == "NULL" || empty($usershare) || $usershare == "" || $usershare == "null")){
            $row[] = '';
            }else{  
                $row[] = "<a onclick=detilShareDoc('".trim($usershare)."+".trim($usergroup)."') style='cursor: pointer;'><i class='fa fa-user-friends'></i></a>";
            }
            $row[] =  "<button class='btn btn-icon btn-primary btn-sm mr-2' title='dokumen'><i class='far fa-file-pdf' style='color:white' onclick=prepareFrame('".trim($trans_doc_id)."')></i></button>";
            $getValueTransIndexGeneral  = $this->search_file_m->getValueTransIndexGeneral($sub_folder_id,$colGeneral);
            foreach($getValueTransIndexGeneral as $key => $value2){
                for ($k=0; $k < count($colGeneral); $k++) { 
                    $row[] = $value2[$colGeneral[$k]];
                }
            }
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
            
            $row[] = $document_size;
            $data[] = $row;
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $countAll,//$countAll,
            "recordsFiltered" => $count_filtered,//$count_filtered,
            "data" => $data,
        ); 

        $this->output->set_output(json_encode($output));   
        // $this->load->view('container/list_doc_v', $data);         
    }

    public function getKetFile() { 
        $trans_doc_id = $this->input->post('trans_doc_id', TRUE);         
        $idUser       = trim($this->session->userdata('id_user'));
        //echo $document_id.'+'.$subFolder;
        $getDataTransDoc      = $this->search_file_m->getDataTransDoc($trans_doc_id);
 
        foreach ($getDataTransDoc as $key => $value) {
            $folder_id    = trim($value->folder_id);
            $document_id  = $value->document_id;
            $subFolderID  = trim($value->sub_folder_id);
            $file_name    = trim($value->file_name);
            $documentName = trim($value->document_name);
            $folder_name  = trim($value->folder_name);
            $sub_folder   = trim($value->sub_folder);
            $getGeneralIndexName  = $this->search_file_m->getGeneralIndexName($folder_id,$subFolderID);
            $getSpecificIndexName = $this->search_file_m->getSpecificIndexName($document_id,$trans_doc_id,$idUser);
            $data = array(
                'file_name'           => $file_name,
                'document_name'       => $documentName,
                'folder_name'         => $folder_name,
                'sub_folder'          => $sub_folder,
                'getGeneralIndexName' => $getGeneralIndexName,
                'getSpecificIndexName'=> $getSpecificIndexName,
            ); 
        }
                      
        $this->output->set_output(json_encode($data));          
    }

     public function getDocument() {
        $folder_id = $this->input->post('folder_id', TRUE);  
        // echo $userid;
        $rows   = $this->search_file_m->getDocument($folder_id);
        //  echo "<pre>";
        // print_r($rows);
        // echo "</pre>";
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
      
        $this->output->set_output(json_encode($data));    
    }

    function getUserApproval() {       
        $trans_doc_id = $_GET['trans_doc_id'];
        $rows = $this->search_file_m->getUserApproval($trans_doc_id);
        
        $data = array();
        foreach ($rows as $row)
                $data[] = $row;
      
        $this->output->set_output(json_encode($data));
    }

    function downloadExcel(){
        $usergroup = trim($this->session->userdata('usergroup'));
        $idUser    = trim($this->session->userdata('id_user'));
        $document_id = $_GET['document_id']; 
        $folder_id = $_GET['folder_id'];  
        $start       = '0';
        $length      = '-1';
        $dir         = 'ASC';
        $search      = '';
        $folder_name = '';
        $document_name = '';
        //echo $document_id.'-'.$sub_folder;
        $data          = array();
        $col           = array();
        $colGeneral    = array();
        $specificIndexFormat = array();
        $getGeneralIndexNameTable = array();
        $getFieldNameIndexSpecific = $this->search_file_m->getFieldNameIndexSpecific($document_id);
        foreach ($getFieldNameIndexSpecific as $key => $value) {
           $col[$key] = $value['specific_index_name'];
            $specificIndexFormat[$key] = $value['specific_index_format'];
        } 
        $getSpecificIndexNameTable    = $this->search_file_m->getSpecificIndexNameTable($document_id,$folder_id,$col,$idUser,$usergroup,$start,$length,$dir,$search);
        $getFieldNameIndexGeneral  = $this->search_file_m->getFieldNameIndexGeneral($folder_id,$usergroup,$idUser);
        foreach ($getFieldNameIndexGeneral as $key => $value) {
           $colGeneral[$key] = $value['general_index_name'];
        }

        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('System DigitizeDocument')
                 ->setLastModifiedBy('System DigitizeDocument')
                 ->setTitle("Data DigitizeDocument")
                 ->setSubject("Data DigitizeDocument")
                 ->setDescription("Data DigitizeDocument")
                 ->setKeywords("Data DigitizeDocument");

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ));

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );

        $sheetNumber = 0;
        $totalHeaderIndexGeneral = count($getFieldNameIndexGeneral);
        $excel->createSheet();        
        $sheetNumber1 = 0;
        $count1 = 0;
        $totalHeaderSpecific = count($getFieldNameIndexSpecific);
        $row = 1;
        $row2 = 1;        
        $count = 0;
        $row3 = 1;
        foreach ($getSpecificIndexNameTable as $key => $value) {
            $trans_doc_id=$value['trans_doc_id'];
            $folder_name=$value['folder_name'];
            $document_name=$value['document_name'];
            $path=$value['path'];
            $file_name=$value['file_name'];
            $getGeneralIndexNameTable = $this->search_file_m->getGeneralIndexNameTable($trans_doc_id,$colGeneral,$usergroup,$idUser);
            
            for($i = 0, $charGeneral = 'E'; $i < $totalHeaderIndexGeneral; $i++, $charGeneral++) {

            foreach($getGeneralIndexNameTable as $row => $value4){
                $count = $count + 1;
                $row3++;
                if($count == 1001){
                    $sheetNumber++;
                    $row3 = 2;
                    $count = 1;
                    $excel->createSheet();
                }
// echo $row3.'_'.trim($file_name).'_'.$sheetNumber.'_'.$count;
//                     echo "<br>";
                                   
                    $excel->setActiveSheetIndex($sheetNumber)->setCellValue('A1', 'Container');
                    $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
                    $excel->setActiveSheetIndex($sheetNumber)->setCellValue('B1', 'Document');
                    $excel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
                    $excel->setActiveSheetIndex($sheetNumber)->setCellValue('C1', 'Path');
                    $excel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
                    $excel->setActiveSheetIndex($sheetNumber)->setCellValue('D1', 'Filename');
                    $excel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
                    $row = 1;
                    $cell = $charGeneral.$row;
                    $excel->setActiveSheetIndex($sheetNumber)->setCellValue($cell, $colGeneral[$i]);
                    $excel->getActiveSheet()->getStyle($cell)->applyFromArray($style_col);


                    $excel->setActiveSheetIndex($sheetNumber)->setCellValue('A'.$row3, trim($folder_name));
                    $excel->getActiveSheet()->getStyle('A'.$row3)->applyFromArray($style_col); 
                    $excel->setActiveSheetIndex($sheetNumber)->setCellValue('B'.$row3, trim($document_name));
                    $excel->getActiveSheet()->getStyle('B'.$row3)->applyFromArray($style_col); 
                    $excel->setActiveSheetIndex($sheetNumber)->setCellValue('C'.$row3, trim($path));
                    $excel->getActiveSheet()->getStyle('C'.$row3)->applyFromArray($style_col); 
                    $excel->setActiveSheetIndex($sheetNumber)->setCellValue('D'.$row3, trim($file_name));
                    $excel->getActiveSheet()->getStyle('D'.$row3)->applyFromArray($style_col); 
                    $indexGeneral = $value4[$colGeneral[$i]];                    
                    $cell3 = $charGeneral.$row3;
                    $cell4 = chr($totalHeaderIndexGeneral + 1);
                    $excel->setActiveSheetIndex($sheetNumber)->setCellValue($cell3, trim($indexGeneral));
                    $excel->getActiveSheet()->getStyle($cell3)->applyFromArray($style_col);
                }                                 
            }

            $count1 = $count1 + 1;
            $row2++;
            if($count1 == 1001){
                $sheetNumber1 = $sheetNumber1 + 1;
                $row2 = 2;
                $count1 = 1;
                //$excel->createSheet();
            }           
             
            for($i = 0, $char = $charGeneral; $i < $totalHeaderSpecific; $i++, $char++) { 
                $indexSpecific = $value[$col[$i]];
                $cell2 = $char.$row2;
                $cell = $char.$row;
                $excel->setActiveSheetIndex($sheetNumber1)->setCellValue($cell, $col[$i]);
                $excel->getActiveSheet()->getStyle($cell)->applyFromArray($style_col);
                $excel->setActiveSheetIndex($sheetNumber1)->setCellValue($cell2, trim($indexSpecific));
                $excel->getActiveSheet()->getStyle($cell2)->applyFromArray($style_col); 
            }
            $excel->getActiveSheet($sheetNumber)->setTitle("Data".$sheetNumber);
        } 
        

        $datefile        = date("Y-m-d_His");                
        ob_end_clean();
        header( "Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" );
        header('Content-Disposition: attachment; filename="'.$folder_name.'_'.$document_name.'_'.$datefile.'.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
        ob_end_clean();
    
    }

    function getUserShare() {       
        $trans_doc_id      = $this->input->post('trans_doc_id', TRUE); 
        $group_user_doc_id = $this->input->post('group_user_doc_id', TRUE); 
        $rows = $this->search_file_m->getUserShare($trans_doc_id,$group_user_doc_id);
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
            $row  = array();
            $row[]  = $no;
            $row[] = "<div class='d-flex align-items-center'><div class='symbol symbol-50 symbol-light mr-4'><span class='symbol-label'><img src='".base_url()."assets/media/svg/avatars/".$userimage."' class='h-75 align-self-end'></span></div><div><a class='text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg'>".$nameUser."</a><span class='text-muted font-weight-bold d-block'>".$deptUser."</span></div></div>";  
                            
            $row[]  = $lastDate;
            $row[]  = $shared_by;
            $row[]  = $status;

            if($status == 'Not Group User Document'){
                //buttonStatus = '<span class="btn btn-label-warning">'+status+'</span>';
                $row[] = '<a class="btn btn-danger btn-elevate btn-pill btn-elevate-air btn-sm" onclick=deleteShareDoc("'.$trans_doc_id.'+'.$userid.'")><i class="flaticon-reply"></i>Unshare</a>';
            }else{
                //buttonStatus = '<span class="btn btn-label-warning">'+status+'</span>';
                $row[] = '<a class="btn btn-danger btn-elevate btn-pill btn-elevate-air btn-sm disabled" ><i class="flaticon-reply"></i>Unshare</a>';
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

    function deleteShareDoc() {
        $trans_doc_id = $this->input->post('trans_doc_id', TRUE); 
        $userid       = $this->input->post('userid', TRUE); 
        $model        = $this->search_file_m->deleteShareDoc($trans_doc_id,$userid);
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
}