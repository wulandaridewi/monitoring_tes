<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Delivery_external_m extends CI_Model {

    public function getDevAll1() {
        // $sql = "SELECT a.register_doc_id,a.doc_description,a.delivery_location,a.recipient,b.name,a.create_date
        //         from doc_register a 
        //         left join sec_passwd b on a.owner = b.userid
        //         where a.type = 'DOC_OUT' and a.delivery_status='EXTERNAL' and expedition=''";
        // $query = $this->db->query($sql);
        $query =  $this->db->query("EXEC sp_getDeliveryExternal");
        return $query->result(); // returning rows, not row
    }

     public function getDevAll($dir,$start,$length,$sRegNum,$sCreateDate,$sExpedition,$sOwner,$sReceiptNum) {
        // echo $dir;
        if($sRegNum =='' && $sCreateDate ==''  && $sExpedition ==''  && $sOwner =='' && $sReceiptNum ==''){
            $selectAll = "where a.type = 'DOC_OUT' and a.delivery_status='EXTERNAL' and expedition <> '' and receipt_number <> '' and register_status=1 ORDER BY a.register_doc_id ".$dir." OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }else{
            if($sRegNum ==''){
               $selectSTEgNum = ""; 
            }else{
                $selectSTEgNum = " and a.register_doc_id like '%".$sRegNum."%'";
            }

            if($sCreateDate ==''){
               $selectCreateDate = ""; 
            }else{
                $selectCreateDate = "and FORMAT(a.create_date, 'dd-MM-yyyy hh:mm:ss') LIKE '%".$sCreateDate."%'";               
            }

            if($sExpedition ==''){
                $selectExpedition = ""; 
            }else{
                $selectExpedition = "and a.expedition like '%".$sExpedition."%'";               
            }
            if($sOwner ==''){
               $selectOwner = ""; 
            }else{
                $selectOwner = "and b.name like '%".$sOwner."%'";               
            }

            if($sReceiptNum ==''){
               $selectReceiptNum = ""; 
            }else{
                $selectReceiptNum = "and a.receipt_number like '%".$sReceiptNum."%'";               
            }
            
            $selectAll = "where a.type = 'DOC_OUT' and a.delivery_status='EXTERNAL' and expedition <> '' and receipt_number <> '' and register_status=1 $selectSTEgNum $selectCreateDate $selectExpedition $selectOwner $selectReceiptNum ORDER BY a.register_doc_id DESC OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }
        $sql = "SELECT a.register_doc_id,a.doc_description,a.delivery_location,a.recipient,b.name,a.create_date,a.expedition,a.receipt_number,a.estimated_time
                from doc_register a 
                left join sec_passwd b on a.owner = b.userid $selectAll";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getRecordsTotal() {
        $sql = "SELECT * FROM doc_register a where a.type = 'DOC_OUT' and a.delivery_status='EXTERNAL' and expedition <> '' ";
        $query = $this->db->query($sql);
        $recordsTotal = $query->num_rows();
        return $recordsTotal;
    }

    public function getRecordsFilteredTotal($dir,$start,$length,$sRegNum,$sCreateDate,$sExpedition,$sOwner,$sReceiptNum) {
        // echo $dir;
        if($sRegNum =='' && $sCreateDate ==''  && $sExpedition ==''  && $sOwner =='' && $sReceiptNum ==''){
            $selectAll = "where a.type = 'DOC_OUT' and a.delivery_status='EXTERNAL' and expedition <> '' and receipt_number <> '' and register_status=1 ORDER BY a.register_doc_id ".$dir." OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }else{
             if($sRegNum ==''){
               $selectSTEgNum = ""; 
            }else{
                $selectSTEgNum = " and a.register_doc_id like '%".$sRegNum."%'";
            }

            if($sCreateDate ==''){
               $selectCreateDate = ""; 
            }else{
                $selectCreateDate = "and FORMAT(a.create_date, 'dd-MM-yyyy hh:mm:ss') LIKE '%".$sCreateDate."%'";               
            }

            if($sExpedition ==''){
                $selectExpedition = ""; 
            }else{
                $selectExpedition = "and a.expedition like '%".$sExpedition."%'";               
            }
            if($sOwner ==''){
               $selectOwner = ""; 
            }else{
                $selectOwner = "and b.name like '%".$sOwner."%'";               
            }

            if($sReceiptNum ==''){
               $selectReceiptNum = ""; 
            }else{
                $selectReceiptNum = "and a.receipt_number like '%".$sReceiptNum."%'";               
            }
            $selectAll = "where a.type = 'DOC_OUT' and a.delivery_status='EXTERNAL' and expedition <> '' and receipt_number <> '' and register_status=1 $selectSTEgNum $selectCreateDate $selectExpedition $selectOwner $selectReceiptNum ORDER BY a.register_doc_id DESC";
        }
        $sql = "SELECT a.register_doc_id,a.doc_description,a.delivery_location,a.recipient,b.name,a.create_date,a.expedition,a.estimated_time
                from doc_register a 
                left join sec_passwd b on a.owner = b.userid $selectAll";
        // echo $sql;die();
        $query = $this->db->query($sql);
        $RecordsFilteredTotal = $query->num_rows();
        return $RecordsFilteredTotal;
    }

    public function getExpedition() {
        $sql = "SELECT expedition_id,expedition_name from master_expedition";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function update_doc_reg($dataTable,$RegisterId){
        // echo $idDocReg;
        // print_r($data);die();
        $this->db->where('register_doc_id', $RegisterId);
        $this->db->update('doc_register', $dataTable);
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function getDataReg($idDocReg) {
        $sql = "SELECT a.register_doc_id,a.doc_description,a.delivery_location,a.recipient,b.name,a.create_date,a.expedition
                from doc_register a 
                left join sec_passwd b on a.owner = b.userid
                where a.register_doc_id='$idDocReg'";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getEmail($Owner){
        $sql= "SELECT email from sec_passwd where name = '$Owner'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        $email  = $result[0]->email;
        return $email;
    } 

}

/* End of file sec_group_user_m.php */
/* Location: ./application/models/sec_group_user.php */