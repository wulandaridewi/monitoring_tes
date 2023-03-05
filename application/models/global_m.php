<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Global_m extends CI_Model {

    function ipaddress() {
        $ip_num = $this->input->ip_address(); //untuk mendeteksi alamat IP
        return $ip_num;
    }

    function hostname() {
        $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        return $host_name;
    }

    public function getIdMaxInt($table,$fieldID){
	    $sql= "select $fieldID from $table";
	    $query = $this->db->query($sql);
	    $jml = $query->num_rows();
	    if($jml == 0){
	        $idMax = 1;
	        return $idMax;
	    }else{
	        $sql= "select max(($fieldID)) as $fieldID from $table";
	        $query = $this->db->query($sql);
	        $hasil = $query->result();
	        $idMax = $hasil[0]->$fieldID;
	        $idMax = (int) $idMax + 1;
	        return $idMax;
	    }
    }

    public function getUser() {
        $sql = "SELECT a.userid,a.name,a.dept_id,b.department from sec_passwd a
        left join master_department b on a.dept_id = b.dept_id
        where a.usergroup=2";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getIdMaxChar($table,$fieldID){
	    $sql= "select $fieldID from $table";
	    $query = $this->db->query($sql);
	    $jml = $query->num_rows();
	    if($jml == 0){
	        $idMax = "0001";
	        return $idMax;
	    }else{
	        $sql= "select max(($fieldID)) as $fieldID from $table";
	        $query = $this->db->query($sql);
	        $hasil = $query->result();
	        $idMax = $hasil[0]->$fieldID;
	        $idMax = sprintf('%04u',(int) $idMax + 1);
	        //echo $idMax;die();
	        return $idMax;
	    }
    }

    public function getIdMaxCharDate($table,$fieldID,$date){
        $dateNEW = str_replace('-', '', $date);
        //echo $dateNEW;die();
        $sql= "select $fieldID from $table where SUBSTRING($fieldID, 1, 8) = $dateNEW";
        $query = $this->db->query($sql);
        $jml = $query->num_rows();
        if($jml == 0){
            $idMax = $dateNEW."00001";
            return $idMax;
        }else{
            $sql= "select max(($fieldID)) as $fieldID from $table where SUBSTRING($fieldID, 1, 8) = '$dateNEW'";
            $query = $this->db->query($sql);
            $hasil = $query->result();
            $idMax = $hasil[0]->$fieldID;
            // $idMax = "2018071899998";
            $idMax = substr($idMax,8,5);            
            $idMax = sprintf('%05u',(int) $idMax + 1);
            $idMax = $dateNEW.$idMax;
            //echo $idMax;die();
            return $idMax;
            }
        }

    public function getIdMaxChar2($table,$fieldID){
        $sql= "select $fieldID from $table";
        $query = $this->db->query($sql);
        $jml = $query->num_rows();
        if($jml == 0){
            $idMax = "000001";
            return $idMax;
        }else{
            $sql= "select max(($fieldID)) as $fieldID from $table";
            $query = $this->db->query($sql);
            $hasil = $query->result();
            $idMax = $hasil[0]->$fieldID;
            $idMax = sprintf('%06u',(int) $idMax + 1);
            //echo $idMax;die();
            return $idMax;
        }
    }

    public function getNewApproval($idUser,$usergroup,$start,$length) {
        $sp = "sp_showNewApproval ?,?,?,?";
        $params = array(
        'PARAM_1' => $idUser,
        'PARAM_2' => $usergroup,
        'PARAM_3' => $start,
        'PARAM_4' => $length);
        //print_r($params);die();
        $query = $this->db->query($sp,$params);   
        return $query->result_array();      
    }

     public function getCountNotifications($idUser,$usergroup) {
        $sp = "sp_countNotifications ?,?";
                $params = array(
                        'PARAM_1' => $idUser,
                        'PARAM_2' => $usergroup);
                $query = $this->db->query($sp,$params);
        $ret = $query->row();
        return $ret->TOTAL_DOC;       
    }

    public function getCountNotifApproval($idUser,$usergroup) {
        $sp = "sp_countNotifApproval ?,?";
                $params = array(
                        'PARAM_1' => $idUser,
                        'PARAM_2' => $usergroup);
                $query = $this->db->query($sp,$params);
        $ret = $query->row();
        return $ret->TOTAL_APPROVAL;       
    }

    public function getNewDocument($idUser,$usergroup,$start,$length) {
        $sp = "sp_showDocumetNew ?,?,?,?";
        $params = array(
        'PARAM_1' => $idUser,
        'PARAM_2' => $usergroup,
        'PARAM_3' => $start,
        'PARAM_4' => $length);
        //print_r($params);die();
        $query = $this->db->query($sp,$params);   
        return $query->result_array();
    }

    public function getEmail($ownerID){
        $sql= "SELECT email,name from sec_passwd where userid = '$ownerID'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        $email  = $result[0]->email;
        $name   = $result[0]->name;
        return $email.'_'.$name;
    } 

    public function sendEmailApproval($transDocSetApprove,$userId,$statusApproval){
        //echo $transDocSetApprove.'-'.$userId.'-'.$statusApproval;die();
        #get data document untuk link email
        try {
            $sp_getDataEmail = "sp_getDataEmail ?";
            $paramsgetDataEmail = array(
                    'PARAM_1' => "".$transDocSetApprove."");
            $getDataEmail = $this->db->query($sp_getDataEmail,$paramsgetDataEmail);
            $rowDataEmail = $getDataEmail->row();
            if(isset($rowDataEmail)){
                $sub_folder     = trim($rowDataEmail->sub_folder);
                $document_id    = $rowDataEmail->document_id;
                $folder_id      = trim($rowDataEmail->folder_id);
                $document_name  = trim($rowDataEmail->document_name);
                $folder_name    = trim($rowDataEmail->folder_name);
                $sub_folder_id  = trim($rowDataEmail->sub_folder_id);
                $trans_doc_id   = trim($rowDataEmail->trans_doc_id);

                #get data email user
                $getEmail    = $this->getEmail($userId);
                $getEmailArr = explode('_', $getEmail);
                $email       = $getEmailArr[0];
                $nameUser    = $getEmailArr[1];
                $this->load->config('email');
                $this->load->library('email');
                $this->email->from('Chairul.Elyasa@astragraphia.co.id', 'Mailroom');
                $this->email->to($email);
                if($statusApproval == 'reject'){
                    $this->email->subject('Approval Document Rejected');
                     $valueOpen = $document_id.'%2B'.$folder_id.'%2B'.$sub_folder_id.'%2B'.$trans_doc_id.'%2B'.str_replace(' ', '%20',$folder_name).'%2B'.str_replace(' ', '%20',$sub_folder).'%2B'.str_replace(' ', '%20',$document_name);
                    $link = base_url().'container/my_container/home?detail=2&value='.$valueOpen;
                    $massage = 'Dear '.$nameUser.',<br><br><br> Request approval anda untuk document '.$document_name.' tidak disetujui <br>Klik link di bawah ini:<br>'.$link.'<br><br><br> Hormat kami, <br><br>Mailroom';
                }else{
                    $this->email->subject('Request Approval Document');
                     $valueOpen = $document_id.'%2B'.$folder_id.'%2B'.$sub_folder_id.'%2B'.$trans_doc_id.'%2B'.str_replace(' ', '%20',$folder_name).'%2B'.str_replace(' ', '%20',$sub_folder).'%2B'.str_replace(' ', '%20',$document_name);
                    $link = base_url().'container/my_container/home?detail=2&value='.$valueOpen;
                    $massage = 'Dear '.$nameUser.',<br><br><br> Anda diminta untuk approval document '.$document_name.'<br>Klik link di bawah ini:<br>'.$link.'<br><br><br> Hormat kami, <br><br>Mailroom';
                }
                
                $this->email->message($massage);
                //$this->email->send();
                if($this->email->send()) {
                    $statusEmail = 1;
                    return $statusEmail;
                   // echo "send email";
                 }else{
                    $statusEmail = 0;
                    return $statusEmail;
                    //echo "error send email";
                 }
            }
        } catch (Exception $e) {
            // this will not catch DB related errors. But it will include them, because this is more general. 
            log_message('error: ',$e->getMessage());
            return;
        }
        
    } 
}

/* End of file sec_menu_user_m.php */
/* Location: ./application/models/sec_menu_user.php */