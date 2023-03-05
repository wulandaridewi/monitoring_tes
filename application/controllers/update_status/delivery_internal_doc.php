
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
        $this->load->model('update_status/delivery_internal_doc_m');  
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
        $menuId = $this->home_m->get_menu_id('update_status/delivery_internal_doc/home');
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
        $this->template->load('default_template/template9', 'update_status/delivery_internal_doc_v', $data);
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
        $sCreateDate     = $post['columns'][8]['search']['value'];  
        $owner           = $post['columns'][3]['search']['value'];   
        $sDept           = $post['columns'][4]['search']['value'];     
        $sRecipt         = $post['columns'][6]['search']['value'];       
        // echo $dir;
        $rows = $this->delivery_internal_doc_m->getDevAll($dir,$start,$length,$sRegNum,$sCreateDate,$owner,$sDept,$sRecipt);
        $data = [];
        $no = 1;
        foreach ($rows as $row)
        {
            //$passwd = base64_decode(trim($row->password));
            $data[] = [
                'no'                => $no++,
                'register_doc_id'   => trim($row->register_doc_id),
                'doc_description'   => trim($row->doc_description),
                'recipient'         => trim($row->recipient),
                'name'              => trim($row->name),
                'department'        => trim($row->department),
                'information'       => trim($row->information),
                'note'              => trim($row->note),
                'create_date'       => date('d-m-Y H:i:s',strtotime($row->create_date)),
                'Actions'       => null
            ];
        }

        $arrCompiledData = [           
            'recordsTotal'    => $this->delivery_internal_doc_m->getRecordsTotal(),
            'recordsFiltered' => $this->delivery_internal_doc_m->getRecordsFilteredTotal($dir,$start,$length,$sRegNum,$sCreateDate,$sExpedition,$sOwner,$sReceiptNum),
            'draw'            => $draw,
            'data'            => $data,
        ];
        $this->output->set_output(json_encode($arrCompiledData));
        
    }



    public function uploadExcel(){
               
        try {
            //echo "Arsip Sementara";die();   
            $fileName   = time().$_FILES['namafile']['name'];
            $path       = "./assets/delivery_internal_doc/".date("Y-m-d");
            //$path   = realpath(FCPATH."/assets/delivery_internal_doc/".date("Y-m-d"));
            if(!is_dir($path)) {
               mkdir($path, 0777, TRUE);
            }
            //echo $jnsDoc;die();
            $config['upload_path']   = $path; //buat folder dengan nama assets di root folder
            $config['file_name']     = $fileName;
            $config['allowed_types'] = 'xls|xlsx|csv';
            $config['max_size']      = 90000;
             
            $this->load->library('upload');
            $this->upload->initialize($config);
             
            if(! $this->upload->do_upload('namafile') )
            $this->upload->display_errors();
                 
            // $media         = $this->upload->data('namafile');
            // $inputFileName =  $path ."/". $fileName; 
            // //echo $inputFileName;die();       
            // $objPHPExcel   = PHPExcel_IOFactory::load($inputFileName);
            $up_data = $this->upload->data();
            $objPHPExcel   = PHPExcel_IOFactory::load($up_data['full_path']);
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
                if($judul == "DATA DELIVERY INTERNAL"){
                    for($row=4; $row<=$highestRow; $row++)
                    {
                        $no                  = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $RegisterId          = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $DocumentDescription = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $Owner               = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $department          = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $note                = $worksheet->getCellByColumnAndRow(5, $row)->getValue();                  
                        $Recipient           = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $information         = $worksheet->getCellByColumnAndRow(7, $row)->getValue();

                        $email    = $this->delivery_internal_doc_m->getEmail($Owner);
                        //KIRIM EMAIL
                        $config['mailtype']     = 'html';
                        $config['protocol']     = 'smtp';
                        $config['smtp_host']    = '172.31.152.95';
                        $config['smtp_user']    = 'Chairul.Elyasa@astragraphia.co.id';
                        $config['smtp_pass']    = 'Desember2020-1';
                        $config['smtp_port']    = 25;
                        $config['charset']      ='utf-8'; // Default should be utf-8 (this should be a text field) 
                        $config['newline']      ="\r\n"; //"\r\n" or "\n" or "\r". DEFAULT should be "\r\n" 
                        $config['crlf']         = "\r\n"; //"\r\n" or "\n" or "\r" DEFAULT should be "\r\n" 
                        $config['smtp_timeout'] = 30;

                        $this->load->library('email', $config);
                        $this->email->from('Chairul.Elyasa@astragraphia.co.id', 'Mailroom');
                        $this->email->to($email);
                        $this->email->subject('Dokumen Penerima');
                        $massage = 'Dear '.$Owner.',<br><br><br> Dokumen '.$description.'.<br> dengan nomor registrasi dokumen '.$RegisterId.' sudah di terima oleh '.$Recipient.' department '.$department.' .<br><br><br> Hormat kami, <br><br>Mailroom';
                        $this->email->message($massage);
                         if($this->email->send()) {
                            $statusEmail = 1;
                         }else{
                            $statusEmail = 0;
                         }
                        //UPDATE KE DATABASE
                        $dataTable  = array(
                            'recipient'       => $Recipient,
                            'register_status' => 1,
                            'status_email'    => $statusEmail,
                            'update_by'       => $idUser,
                            'update_date'     => $dateTime,
                            'information'     => $information,
                        );
                        $updateRow = $this->delivery_internal_doc_m->update_doc_reg($dataTable,$RegisterId);
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

