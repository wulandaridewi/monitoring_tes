
<?php
error_reporting(E_ERROR | E_PARSE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    // use PhpOffice\PhpSpreadsheet\Spreadsheet;
    // use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report_regis_nondoc extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('report/report_regis_nondoc_m');  
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
        $menuId = $this->home_m->get_menu_id('report/report_regis_nondoc/home');
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
        $this->template->load('default_template/template9', 'report/report_regis_nondoc_v', $data);
    }

    function getListDoc() {
        $usergroup = trim($this->session->userdata('usergroup'));
        $idUser    = trim($this->session->userdata('id_user'));
        $startDate = date('Y-m-d',strtotime($this->input->post('startDate', TRUE)));  
        $endDate   = date('Y-m-d',strtotime($this->input->post('endDate', TRUE)));   
        //echo $startDate.'-'.$endDate;die();
        $rows = $this->report_regis_nondoc_m->getListRegis($startDate,$endDate,$idUser,$usergroup);
        
        $data = array(
            'getListRegis'  => $rows,
        );  

        $this->load->view('report/list_regis_nondoc_v', $data); 
    }

    function downloadExcel(){
        $startDate   = date('Y-m-d',strtotime($this->input->get('startDate')));  
        $endDate     = date('Y-m-d',strtotime($this->input->get('endDate'))); 
        $date        = date("Y-m-d H:i:s");
        $idUser      = $this->session->userdata('id_user');
        $usergroup   = trim($this->session->userdata('usergroup'));
        $rows        = $this->report_regis_nondoc_m->getListRegisDownload($startDate,$endDate,$idUser,$usergroup);
        //$countRegNum = count($rows);
        //echo $countRegNum;die();
        //echo $startDate."_".$endDate;die();
        //print_r($regNumAllArrNew);die();
        
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('Mailroom AG')
                 ->setLastModifiedBy('Admin Mailroom')
                 ->setTitle("Data Delivery External")
                 ->setSubject("Delivery External")
                 ->setDescription("Expedition for delivery external")
                 ->setKeywords("Expedition");

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ));

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
          'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );



        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Report Registrasi Non Document"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:J1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('B1:B1000')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', 'No');
        $excel->setActiveSheetIndex(0)->setCellValue('B3', 'Register Id');
        $excel->setActiveSheetIndex(0)->setCellValue('C3', 'Register Date');
        $excel->setActiveSheetIndex(0)->setCellValue('D3', 'Type');
        $excel->setActiveSheetIndex(0)->setCellValue('E3', 'Document Description');
        $excel->setActiveSheetIndex(0)->setCellValue('F3', 'Owner');
        $excel->setActiveSheetIndex(0)->setCellValue('G3', 'Service');
        $excel->setActiveSheetIndex(0)->setCellValue('H3', 'Status Document');
        $excel->setActiveSheetIndex(0)->setCellValue('I3', 'Information');
        $excel->setActiveSheetIndex(0)->setCellValue('J3', 'Last Update');
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);

        $no     = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4        

        foreach($rows as $row){
                $doc_status      = trim($row->ndoc_status);
                $delivery_status = trim($row->ndelivery_status);
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
                $type            = trim($row->ntype);
                $register_status = trim($row->nregister_status);
                $pickup_by       = trim($row->npickup_by);
                $recipient       = trim($row->nrecipient);
                $expedition      = trim($row->nexpedition);
                $receipt_number  = trim($row->nreceipt_number);
                if($type == 'DOC_IN' && $doc_status == 'PICKUP' && $register_status == 0 && $pickup_by=='-'){
                    $type = 'NON_DOC_IN';
                    $status_doc  = 'Progress';
                    $information = 'Waiting for Pickup by Owner';
                }elseif($type == 'DOC_IN' && $doc_status == 'PICKUP' && $register_status == 1){
                    $type = 'NON_DOC_IN';
                    $status_doc  = 'Done';
                    $information = 'Pickup by '.$pickup_by;
                }elseif($type == 'DOC_IN' && $doc_status == 'DELIVER' && $register_status == 0){
                    $type = 'NON_DOC_IN';
                    $status_doc  = 'Progress';
                    $information = 'Waiting to be Send by Operator';
                }elseif($type == 'DOC_IN' && $doc_status == 'DELIVER' && $register_status == 1){
                    $type = 'NON_DOC_IN';
                    $status_doc  = 'Done';
                    $information = 'Received by '.$recipient;
                }elseif($type == 'DOC_OUT' && $doc_status == 'DELIVER' && $register_status == 0){
                    $type = 'NON_DOC_OUT';
                    $status_doc  = 'Progress';
                    $information = 'Waiting to be Send by Expidition ('.$expedition.')';
                }elseif($type == 'DOC_OUT' && $doc_status == 'DELIVER' && $register_status == 1){
                    $type = 'NON_DOC_OUT';
                    $status_doc  = 'Done';
                    $information = 'Expedition ('.$expedition.') and Receipt Number ('.$receipt_number.')';
                }

                $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no++);
                $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, trim($row->register_non_doc_id));
                $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, date('d-m-Y H:i:s',strtotime($row->create_date)));
                $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, trim($row->ntype));
                $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, trim($row->ndoc_description));
                $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, trim($row->name));
                $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $service);
                $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $status_doc);
                $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $information);
                $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, date('d-m-Y H:i:s',strtotime($row->update_date)));
                

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
                // $no++;
                $numrow++;
            }     
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Report Registrasi Non Document");
        $excel->setActiveSheetIndex(0);
        ob_end_clean();
        header( "Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" );
        header('Content-Disposition: attachment; filename="report_registrasi_non_doc.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
        ob_end_clean();
    }
}

