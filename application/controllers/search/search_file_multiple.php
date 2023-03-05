<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class search_file_multiple extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('search/search_file_multiple_m');
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
        $menuId              = $this->home_m->get_menu_id('search/search_file_multiple/home');
        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_name']   = $menuId[0]->menu_name;
        $this->auth->restrict($data['menu_id']);
        //$this->auth->cek_menu($data['menu_id']);
      
        $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
        $data['menu_all']   = $this->user_m->get_menu_all(0);
        //$data['getCategoryDoc']     = $this->search_file_multiple_m->getCategoryDoc();
        $usergroup = trim($this->session->userdata('usergroup'));
        $idUser    = trim($this->session->userdata('id_user'));

        $this->template->set('title', 'home');
        $this->template->load('default_template/template9', 'search/search_file_multiple_v', $data);
    }
    
    public function searchDocument() {
        $idUser              = trim($this->session->userdata('id_user'));
        $usergroup           = trim($this->session->userdata('usergroup'));
        $valueTextSearch     = $this->input->post('valueTextSearch', TRUE); 
        $getlistDocumentName = $this->search_file_multiple_m->getDocumentName($valueTextSearch,$idUser,$usergroup);
        //  echo "<pre>";
        // print_r($getDocumentName);
        // echo "</pre>";
        $x = 0;  
        $listDocumentName = '';
        foreach ($getlistDocumentName as $key => $value) {
            $x++;
            $trans_doc_id         = trim($value['trans_doc_id']); 
            $document_name        = trim($value['document_name']);
            $counter              = trim($value['counter']); 
            $getGeneralIndexName  = $this->search_file_multiple_m->getGeneralIndexName($trans_doc_id);
            $getSpecificIndexName = $this->search_file_multiple_m->getSpecificIndexName($trans_doc_id);
            $listDocumentName .= '<div class="col-md-4" ><div class="card card-custom gutter-b" style="background-color: #F3F6F9;">';
            $listDocumentName .= '<div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">'.trim($document_name)." ".trim($counter).'</h3>
                                    </div>
                                  </div>';
            $listDocumentName .= '<div class="card-body">
                                    <div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle" id="accordionExample7">
                                    <div class="card">';        
            $listDocumentName .= '<div class="card-header" id="headingOne7" style="background-color: #F3F6F9;">
                                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapse'.$x.'" aria-expanded="false">
                                                <span class="svg-icon svg-icon-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                        <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"></path>
                                                        <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999)"></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <div class="card-label pl-4">Show Detail</div>
                                            </div>
                                        </div>
                                        <div id="collapse'.$x.'" class="collapse" data-parent="#accordionExample7" style="background-color: #F3F6F9;">';            
            $listDocumentName     .= '<div class="card-body md-12">';
            foreach ($getGeneralIndexName as $value) {
                $general_index_name = trim($value->general_index_name);
                $general_index      = trim($value->general_index);
                //$listDocumentName .=$general_index_name.' : '.$general_index.'<br>';
                $listDocumentName .= '<div class="row"><label for="example-password-input" class="col-5 col-form-label"><b>'.$general_index_name.'</b></label><label class="col-1 col-form-label"><b>:</b></label><div class="col-5"><label for="example-password-input" class="col-form-label"><b>'.$general_index.'</b></label></div></div>';
            }
            
            foreach ($getSpecificIndexName as $row) {
                $specific_index_format = trim($row->specific_index_format);
                $specific_index_name   = trim($row->specific_index_name);
                $specific_index        = trim($row->specific_index);

                if($specific_index_format == 4){
                    if($specific_index == "" || $specific_index == "NULL" || empty($specific_index)){
                        $valueSpecific = "0.00";
                    }else{
                       $valueSpecific = number_format($specific_index, 2); 
                    }                    
                }else{
                    $valueSpecific = $specific_index;
                }
                
                $listDocumentName .= '<div class="row"><label for="example-password-input" class="col-5 col-form-label"><b>'.$specific_index_name.'</b></label><label class="col-1 col-form-label"><b>:</b></label><div class="col-5"><label for="example-password-input" class="col-form-label"><b>'.$valueSpecific.'</b></label></div></div>';
            }
            $listDocumentName .='<div>&nbsp;</div>';
            $listDocumentName .='<a class="btn btn-primary btn-primary--icon form-control datatable-input" id="kt_search" onclick="viewDocumentDetail('.$trans_doc_id."+'+'+".$counter.')">
                                    <span>
                                        <i class="fa flaticon2-file"></i>
                                        <span>View Document</span>
                                    </span>
                                    </a>';
            $listDocumentName .='</div></div>';        
            $listDocumentName .='</div></div></div>';
            $listDocumentName .= '</div></div>';
        }     
        $output = array(
            "listDocumentName" => $listDocumentName,
        ); 

        $this->output->set_output(json_encode($output));    
    }

    public function getKetFile() { 
        $trans_doc_id = $this->input->post('trans_doc_id', TRUE);         
        $idUser       = trim($this->session->userdata('id_user'));
        //echo $document_id.'+'.$subFolder;
        $getDataTransDoc      = $this->search_file_multiple_m->getDataTransDoc($trans_doc_id);
 
        foreach ($getDataTransDoc as $key => $value) {
            $folder_id    = trim($value->folder_id);
            $document_id  = $value->document_id;
            $subFolderID  = trim($value->sub_folder_id);
            $file_name    = trim($value->file_name);
            $documentName = trim($value->document_name);
            $folder_name  = trim($value->folder_name);
            $sub_folder   = trim($value->sub_folder);
            $getGeneralIndexName  = $this->search_file_multiple_m->getGeneralIndexNameView($folder_id,$subFolderID);
            $getSpecificIndexName = $this->search_file_multiple_m->getSpecificIndexNameView($document_id,$trans_doc_id,$idUser);
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
}