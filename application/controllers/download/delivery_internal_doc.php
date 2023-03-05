
<?php
error_reporting(E_ERROR | E_PARSE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    // use PhpOffice\PhpSpreadsheet\Spreadsheet;
    // use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Delivery_internal_doc extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('download/delivery_internal_doc_m');  
        $this->load->helper('cookie');
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
        $menuId = $this->home_m->get_menu_id('download/delivery_internal_doc/home');
        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_name']   = $menuId[0]->menu_name;
        $this->auth->restrict($data['menu_id']);
        $this->auth->cek_menu($data['menu_id']);
        $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
        $data['menu_all']   = $this->user_m->get_menu_all(0);
        $data['getExpedition'] = $this->delivery_internal_doc_m->getExpedition();
        $this->template->set('title', 'home');
        $this->template->load('default_template/template9', 'download/delivery_internal_doc_v', $data);
    }

    public function getDevAll() {
        $rows = $this->delivery_internal_doc_m->getDevAll();
        $data['data'] = array();
        $no = 0;
        foreach ($rows as $row) {
            $no++;
            $array = array(
                'no'                => $no,
                'register_doc_id'   => trim($row->register_doc_id),
                'doc_description'   => trim($row->doc_description),
                'recipient'         => trim($row->recipient),
                'name'              => trim($row->name),
                'department'        => trim($row->department),
                'information'       => trim($row->information),
                'create_date'       => date('d-m-Y H:i:s',strtotime($row->create_date)),
                'note'              => trim($row->note),
            );

            array_push($data['data'], $array);
        }
        $this->output->set_output(json_encode($data));
        
    }

    function downloadExcel(){

        $expedition      = $this->input->get('expedition');
        $regNumAll       = $this->input->get('regNumAll');
        $regNumAllArrNew = explode('_', $regNumAll);; 
        $countRegNum     = count($regNumAllArrNew);
        $date            = date("Y-m-d H:i:s");
        $datefile        = date("Y-m-d_His");
        $idUser          = $this->session->userdata('id_user');
        //echo $regNumAll;die();

        
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('Mailroom AG')
                 ->setLastModifiedBy('Admin Mailroom')
                 ->setTitle("Data Delivery internal")
                 ->setSubject("Delivery internal")
                 ->setDescription("Expedition for delivery internal")
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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA DELIVERY INTERNAL"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:I1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', 'No');
        $excel->setActiveSheetIndex(0)->setCellValue('B3', 'Register Id');
        $excel->setActiveSheetIndex(0)->setCellValue('C3', 'Document Description');
        $excel->setActiveSheetIndex(0)->setCellValue('D3', 'Owner');
        $excel->setActiveSheetIndex(0)->setCellValue('E3', 'Department');
        $excel->setActiveSheetIndex(0)->setCellValue('F3', 'Note');
        $excel->setActiveSheetIndex(0)->setCellValue('G3', 'Recipient');
        $excel->setActiveSheetIndex(0)->setCellValue('H3', 'Information');
        $excel->setActiveSheetIndex(0)->setCellValue('I3', 'Signature');
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

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4

        

        for($k=0; $k<$countRegNum; $k++){
            $idDocReg = $regNumAllArrNew[$k];
            $data = array(
                'register_status' => 2,  
                'update_date'     => $date,
                'update_by'       => $idUser
            );                    
            $model = $this->delivery_internal_doc_m->update_doc_reg($data,$idDocReg);
            $rows  = $this->delivery_internal_doc_m->getDataReg($idDocReg);

            // print_r($rows);

            foreach($rows as $row)
            {
                $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no++);
                $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row->register_doc_id);
                $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row->doc_description);
                $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row->name);
                $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row->department);
                $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row->note);
                $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row->recipient);
                $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row->information);
                $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, '');

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
                // $no++;
                $numrow++;
            }
            //echo $model;
        }

        // die();


        // Set width kolom
        // $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        // $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
        // $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        // $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
        // $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E
        
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("DATA DELIVERY INTERNAL DOCUMENT");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment; filename="delivery_internal.xlsx"'); // Set nama file excel nya
        // header('Cache-Control: max-age=0');
        // $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        // $write->save('php://output');
        //echo $regNum;die();

        ob_end_clean();
        header( "Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" );
        header('Content-Disposition: attachment; filename="'.$datefile.'_delivery_internal_doc.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
        ob_end_clean();
        
    }

}

