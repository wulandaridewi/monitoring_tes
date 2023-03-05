
<?php
error_reporting(E_ERROR | E_PARSE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    // use PhpOffice\PhpSpreadsheet\Spreadsheet;
    // use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class delivery_external_nondoc extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('update_status/delivery_external_nondoc_m');  
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
        $menuId = $this->home_m->get_menu_id('update_status/delivery_external_nondoc/home');
        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_name']   = $menuId[0]->menu_name;
        $this->auth->restrict($data['menu_id']);
        $this->auth->cek_menu($data['menu_id']);
        $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
        $data['menu_all']   = $this->user_m->get_menu_all(0);
        $data['getExpedition'] = $this->delivery_external_nondoc_m->getExpedition();
        $this->template->set('title', 'home');
        $this->template->load('default_template/template9', 'update_status/delivery_external_nondoc_v', $data);
    }

    public function getDevAll() {
        $post            = $this->input->post();
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
        $sCreateDate     = $post['columns'][9]['search']['value'];  
        $sReceiptNum     = $post['columns'][8]['search']['value'];   
        $sExpedition     = $post['columns'][6]['search']['value'];     
        $sOwner          = $post['columns'][5]['search']['value'];       
        // echo $dir;
        $rows = $this->delivery_external_nondoc_m->getDevAll($dir,$start,$length,$sRegNum,$sCreateDate,$sExpedition,$sOwner,$sReceiptNum);
        $data = [];
        $no = 1;
        foreach ($rows as $row)
        {
            //$passwd = base64_decode(trim($row->password));
            $data[] = [
                'no'                => $no++,
                'register_doc_id'   => trim($row->register_non_doc_id),
                'doc_description'   => trim($row->ndoc_description),
                'delivery_location' => trim($row->ndelivery_location),
                'recipient'         => trim($row->nrecipient),
                'name'              => trim($row->name),
                'create_date'       => date('d-m-Y H:i:s',strtotime($row->create_date)),
                'expedition'        => trim($row->nexpedition),
                'receipt_number'    => trim($row->nreceipt_number),
                'estimated_time'    => date('d-m-Y',strtotime($row->estimated_time)),   
                'Actions'           => null
            ];
        }

        $arrCompiledData = [           
            'recordsTotal'    => $this->delivery_external_nondoc_m->getRecordsTotal(),
            'recordsFiltered' => $this->delivery_external_nondoc_m->getRecordsFilteredTotal($dir,$start,$length,$sRegNum,$sCreateDate,$sExpedition,$sOwner,$sReceiptNum),
            'draw'            => $draw,
            'data'            => $data,
        ];
        $this->output->set_output(json_encode($arrCompiledData));
        
    }

    public function getDevAll1() {
        $rows = $this->delivery_external_nondoc_m->getDevAll();
        $data['data'] = array();
        $no = 0;
        foreach ($rows as $row) {
            $no++;
            $array = array(
                'no'                => $no,
                'register_doc_id'   => trim($row->register_doc_id),
                'doc_description'   => trim($row->doc_description),
                'delivery_location' => trim($row->delivery_location),
                'recipient'         => trim($row->recipient),
                'name'              => trim($row->name),
                'create_date'       => date('d-m-Y H:i:s',strtotime($row->create_date)),
            );

            array_push($data['data'], $array);
        }
        $this->output->set_output(json_encode($data));        
    }   

    public function uploadExcel(){
        try{
            //echo "Arsip Sementara";die();   
            $fileName   = time().$_FILES['namafile']['name'];
            //echo $fileName;die();
            $path       = "./assets/delivery_external_nondoc_doc/".date("Y-m-d");
            //$path   = realpath(FCPATH."/assets/delivery_external_nondoc_doc/".date("Y-m-d"));
            if(!is_dir($path)) {
               mkdir($path, 0777, TRUE);
            }
            //echo $jnsDoc;die();
            $config['upload_path']   = $path; //buat folder dengan nama assets di root folder
            $config['file_name']     = $fileName;
            $config['allowed_types'] = 'xls|xlsx|csv';
            $config['max_size']      = 90000;
            $config['encrypt_name']  = TRUE;
             
            $this->load->library('upload');
            $this->upload->initialize($config);
             
            if(! $this->upload->do_upload('namafile') )
            $this->upload->display_errors();
                 
            // $media         = $this->upload->data('namafile');
            // $inputFileName =  $path ."/". $fileName; 
            //echo $inputFileName;die();       

            $up_data = $this->upload->data();
            $objPHPExcel   = PHPExcel_IOFactory::load($up_data['full_path']);

            // $objPHPExcel   = PHPExcel_IOFactory::load($inputFileName);
            //var_dump($objPHPExcel);die();
            
            $date       = date("Y-m-d");
            $dateTime   = date("Y-m-d H:i:s");
            $idUser     = $this->session->userdata('id_user');
            foreach($objPHPExcel->getWorksheetIterator() as $worksheet)
            {
                $highestRow   = $worksheet->getHighestRow();
                $countSuccess = 0;
                $countError   = 0;
                $countInsert  = $highestRow-3;
                //echo $countInsert;die(); 
                $format = "true";
                    //echo $countInsert;die(); 
                $judul = trim($worksheet->getCellByColumnAndRow(0, 1)->getValue());
                if($judul == "DATA DELIVERY EXTERNAL NON DOC"){
                    for($row=4; $row<=$highestRow; $row++)
                    {
                        $no                  = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $RegisterId          = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $DocumentDescription = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $LocationPickup      = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $DeliveryLocation    = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $Recipient           = $worksheet->getCellByColumnAndRow(5, $row)->getValue();  
                        $Owner               = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $Expedition          = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $estimasi            = $worksheet->getCellByColumnAndRow(8, $row)->getValue(); 
                        $RecipientNumber     = $worksheet->getCellByColumnAndRow(9, $row)->getValue();


                        $email    = $this->delivery_external_nondoc_m->getEmail($Owner);
                        //KIRIM EMAIL
                        $config['mailtype']     = 'html';
                        $config['protocol']     = 'smtp';
                        $config['smtp_host']    = '172.31.152.95';
                        $config['smtp_user']    = 'Chairul.Elyasa@astragraphia.co.id';
                        $config['smtp_pass']    = 'Desember2020-1';
                        $config['smtp_port']    = 25;
                        $config['charset']      = 'utf-8'; // Default should be utf-8 (this should be a text field) 
                        $config['newline']      = "\r\n"; //"\r\n" or "\n" or "\r". DEFAULT should be "\r\n" 
                        $config['crlf']         = "\r\n"; //"\r\n" or "\n" or "\r" DEFAULT should be "\r\n" 
                        $config['smtp_timeout'] = 30;

                        $this->load->library('email', $config);
                        $this->email->from('Chairul.Elyasa@astragraphia.co.id', 'Mailroom');
                        $this->email->to($email);
                        $this->email->subject('Nomor Resi Ekspedisi');
                        $massage = 'Dear '.$Owner.',<br><br><br> Dokumen '.$description.'.<br> dengan nomor registrasi dokumen '.$RegisterId.' sudah dalam proses pengiriman menggunakan '.$Expedition.' dengan nomor resi '.$RecipientNumber.' selanjut dapat melakukan tracking dokumen dengan nomor resi tersebut .<br><br><br> Hormat kami, <br><br>Mailroom';
                        $this->email->message($massage);
                         if($this->email->send()) {
                            $statusEmail = 1;
                         }else{
                            $statusEmail = 0;
                         }
                        //UPDATE KE DATABASE
                        $dataTable  = array(
                            'nreceipt_number'  => $RecipientNumber,
                            'nregister_status' => 1,
                            'nstatus_email'    => $statusEmail,
                            'update_by'       => $idUser,
                            'update_date'     => $dateTime
                        );
                        $updateRow = $this->delivery_external_nondoc_m->update_doc_reg($dataTable,$RegisterId);
                        if($updateRow == 'true'){
                            $countSuccess++;
                        }else{
                            $countError++;
                        }                               
                    //echo $cetakError; 
                    }
                }else{
                    $format = "false";
                    break;
                }
            }  

            if($countSuccess == $countInsert){
                $array = array(
                    'act'        => 1,
                    'tipePesan'  => 'success',
                    'pesan'      => 'success',
                );
            }elseif($countSuccess == 0){
                if($format == "false"){
                    $array = array(
                        'act'        => 0,
                        'tipePesan'  => 'error',
                        'pesan'      => 'Excel format is not matching',
                    );
                }else{
                    $array = array(
                        'act'        => 0,
                        'tipePesan'  => 'error',
                        'pesan'      => 'error',
                    );
                }
            }else{
                $array = array(
                    'act'        => 2,
                    'tipePesan'  => 'warning',
                    'pesan'      => $countError.' upload failed',
                );
            }
            $this->output->set_output(json_encode($array));  
        } catch (Exception $e) {
           $array = array(
                'act'        => 0,
                'tipePesan'  => 'error',
                'pesan'      => 'Only xlsx or xls',
            );
            $this->output->set_output(json_encode($array));   
        }              
                  
    } 

}

