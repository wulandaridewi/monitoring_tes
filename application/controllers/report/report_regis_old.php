
<?php
error_reporting(E_ERROR | E_PARSE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    // use PhpOffice\PhpSpreadsheet\Spreadsheet;
    // use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report_regis extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('report/report_regis_m');  
        $this->load->helper('cookie');
        $this->load->library('PHPExcel');
        // Load plugin PHPExcel nya        
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
        $menuId = $this->home_m->get_menu_id('report/report_regis/home');
        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_name']   = $menuId[0]->menu_name;
        $this->auth->restrict($data['menu_id']);
        $this->auth->cek_menu($data['menu_id']);
        $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
        $data['menu_all']   = $this->user_m->get_menu_all(0);
        $this->template->set('title', 'home');
        $this->template->load('default_template/template9', 'report/report_regis_v', $data);
    }

    public function getDevAll() {
        $post    = $this->input->post();
        $idUser  = $this->session->userdata('id_user');
        // echo "<pre>";
        // print_r($post);
        // echo "</pre>";
        // echo $post['order'][0]['dir'];
        $draw            = $this->input->post('draw', TRUE);
        // $order           = $post['order'][0]['column'];
        $dir             = $post['order'][0]['dir'];
        $start           = $this->input->post('start', TRUE);
        $length          = $this->input->post('length', TRUE);        
        $sRegNum         = $post['columns'][1]['search']['value']; 
        $sCreateDate     = $post['columns'][2]['search']['value'];      
        // echo $dir;
        $rows = $this->report_regis_m->getDevAll($dir,$start,$length,$sRegNum,$idUser,$sCreateDate);
        $data = [];
        $no = 1;
        foreach ($rows as $row)
        {   
            $doc_status      = trim($row->doc_status);
            $delivery_status = trim($row->delivery_status);
            $status_indexing = trim($row->status_indexing);
            $service_1       = $doc_status.'_'.$delivery_status;
            //$passwd = base64_decode(trim($row->password));
            if($service_1 == 'DELIVER_INTERNAL'){
                $service = 'Delivery Internal';
            }elseif($service_1 == 'DELIVER_EXTERNAL'){
                $service = 'Delivery External';
            }elseif($service_1 == 'PICKUP_INTERNAL'){
                $service = 'Pickup';
            }elseif($service_1 == 'PICKUP_EXTERNAL'){
                $service = 'Pickup';
            }
            $type            = trim($row->type);
            $register_status = trim($row->register_status);
            $pickup_by       = trim($row->pickup_by);
            $recipient       = trim($row->recipient);
            $expedition      = trim($row->expedition);
            $receipt_number  = trim($row->receipt_number);
            if($type == 'DOC_IN' && $doc_status == 'PICKUP' && $register_status == 0 && $status_indexing == 0){
                $status_doc  = 'Progress';
                $information = 'Waiting for Indexing by Operator';
            }elseif($type == 'DOC_IN' && $doc_status == 'PICKUP' && $register_status == 0 && ($status_indexing == 1 || $status_indexing == 2) && $pickup_by=='-'){
                $status_doc  = 'Progress';
                $information = 'Waiting for Pickup by Owner';
            }elseif($type == 'DOC_IN' && $doc_status == 'PICKUP' && $register_status == 1 && ($status_indexing == 1 || $status_indexing == 2)){
                $status_doc  = 'Done';
                $information = 'Pickup by '.$pickup_by;
            }elseif($type == 'DOC_IN' && $doc_status == 'DELIVER' && $register_status == 0 && $status_indexing == 0){
                $status_doc  = 'Progress';
                $information = 'Waiting for Indexing by Operator';
            }elseif($type == 'DOC_IN' && $doc_status == 'DELIVER' && $register_status == 0 && ($status_indexing == 1 || $status_indexing == 2)){
                $status_doc  = 'Progress';
                $information = 'Waiting to be Send by Operator';
            }elseif($type == 'DOC_IN' && $doc_status == 'DELIVER' && $register_status == 1 && ($status_indexing == 1 || $status_indexing == 2)){
                $status_doc  = 'Done';
                $information = 'Received by '.$recipient;
            }elseif($type == 'DOC_OUT' && $doc_status == 'DELIVER' && $register_status == 0 && $status_indexing == 0){
                $status_doc  = 'Progress';
                $information = 'Waiting for Indexing by Operator';
            }elseif($type == 'DOC_OUT' && $doc_status == 'DELIVER' && $register_status == 0 && ($status_indexing == 1 || $status_indexing == 2)){
                $status_doc  = 'Progress';
                $information = 'Waiting to be Send by Expidition ('.$expedition.')';
            }elseif($type == 'DOC_OUT' && $doc_status == 'DELIVER' && $register_status == 1 && ($status_indexing == 1 || $status_indexing == 2)){
                $status_doc  = 'Done';
                $information = 'Expedition ('.$expedition.') and Receipt Number ('.$receipt_number.')';
            }
            $data[] = [
                'no'                => $no++,
                'register_doc_id'   => trim($row->register_doc_id),
                'type'              => trim($row->type),
                'doc_description'   => trim($row->doc_description),
                'name'              => trim($row->name),
                'service'           => $service,
                'status_doc'        => $status_doc,
                'information'       => $information,
                'update_date'       => date('d-m-Y H:i:s',strtotime($row->update_date)),                 
                'create_date'       => date('d-m-Y H:i:s',strtotime($row->create_date)),  
                'Actions'           => null
            ];
        }

        $arrCompiledData = [           
            'recordsTotal'    => $this->report_regis_m->getRecordsTotal($idUser),
            'recordsFiltered' => $this->report_regis_m->getRecordsFilteredTotal($dir,$start,$length,$sRegNum,$idUser,$sCreateDate),
            'draw'            => $draw,
            'data'            => $data,
        ];
        $this->output->set_output(json_encode($arrCompiledData));
        
    }
}

