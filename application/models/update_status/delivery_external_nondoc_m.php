<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Delivery_external_nondoc_m extends CI_Model {

    public function getDevAll1() {
        $sql = "SELECT a.register_non_doc_id,a.ndoc_description,a.ndelivery_location,a.nrecipient,b.name,a.create_date
                from non_doc_register a 
                left join sec_passwd b on a.nowner = b.userid
                where a.ntype = 'DOC_OUT' and a.ndelivery_status='EXTERNAL' and nexpedition=''";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

     public function getDevAll($dir,$start,$length,$sRegNum,$sCreateDate,$sExpedition,$sOwner,$sReceiptNum) {
        // echo $dir;
        if($sRegNum =='' && $sCreateDate ==''  && $sExpedition ==''  && $sOwner =='' && $sReceiptNum ==''){
            $selectAll = "where a.ntype = 'DOC_OUT' and a.ndelivery_status='EXTERNAL' and nexpedition <> '' and nreceipt_number <> '' and nregister_status=1 ORDER BY a.register_non_doc_id ".$dir." OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }else{
            if($sRegNum ==''){
               $selectSTEgNum = ""; 
            }else{
                $selectSTEgNum = " and a.register_non_doc_id like '%".$sRegNum."%'";
            }

            if($sCreateDate ==''){
               $selectCreateDate = ""; 
            }else{
                $selectCreateDate = "and FORMAT(a.create_date, 'dd-MM-yyyy HH:mm:ss') LIKE '%".$sCreateDate."%'";               
            }

            if($sExpedition ==''){
                $selectExpedition = ""; 
            }else{
                $selectExpedition = "and a.nexpedition like '%".$sExpedition."%'";               
            }
            if($sOwner ==''){
               $selectOwner = ""; 
            }else{
                $selectOwner = "and b.name like '%".$sOwner."%'";               
            }

            if($sReceiptNum ==''){
               $selectReceiptNum = ""; 
            }else{
                $selectReceiptNum = "and a.nreceipt_number like '%".$sReceiptNum."%'";               
            }
            
            $selectAll = "where a.ntype = 'DOC_OUT' and a.ndelivery_status='EXTERNAL' and nexpedition <> '' and nreceipt_number <> '' and nregister_status=1 $selectSTEgNum $selectCreateDate $selectExpedition $selectOwner $selectReceiptNum ORDER BY a.register_non_doc_id DESC OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }
        $sql = "SELECT a.register_non_doc_id,a.ndoc_description,a.ndelivery_location,a.nrecipient,b.name,a.create_date,a.nexpedition,a.nreceipt_number,a.estimated_time
                from non_doc_register a 
                left join sec_passwd b on a.nowner = b.userid $selectAll";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getRecordsTotal() {
        $sql = "SELECT * FROM non_doc_register a where a.ntype = 'DOC_OUT' and a.ndelivery_status='EXTERNAL' and nexpedition <> '' ";
        $query = $this->db->query($sql);
        $recordsTotal = $query->num_rows();
        return $recordsTotal;
    }

    public function getRecordsFilteredTotal($dir,$start,$length,$sRegNum,$sCreateDate,$sExpedition,$sOwner,$sReceiptNum) {
        // echo $dir;
        if($sRegNum =='' && $sCreateDate ==''  && $sExpedition ==''  && $sOwner =='' && $sReceiptNum ==''){
            $selectAll = "where a.ntype = 'DOC_OUT' and a.ndelivery_status='EXTERNAL' and nexpedition <> '' and nreceipt_number <> '' and nregister_status=1 ORDER BY a.register_non_doc_id ".$dir." OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }else{
            if($sRegNum ==''){
               $selectSTEgNum = ""; 
            }else{
                $selectSTEgNum = " and a.register_non_doc_id like '%".$sRegNum."%'";
            }

            if($sCreateDate ==''){
               $selectCreateDate = ""; 
            }else{
                $selectCreateDate = "and FORMAT(a.create_date, 'dd-MM-yyyy HH:mm:ss') LIKE '%".$sCreateDate."%'";               
            }

            if($sExpedition ==''){
                $selectExpedition = ""; 
            }else{
                $selectExpedition = "and a.nexpedition like '%".$sExpedition."%'";               
            }
            if($sOwner ==''){
               $selectOwner = ""; 
            }else{
                $selectOwner = "and b.name like '%".$sOwner."%'";               
            }

            if($sReceiptNum ==''){
               $selectReceiptNum = ""; 
            }else{
                $selectReceiptNum = "and a.nreceipt_number like '%".$sReceiptNum."%'";               
            }
            
            $selectAll = "where a.ntype = 'DOC_OUT' and a.ndelivery_status='EXTERNAL' and nexpedition <> '' and nreceipt_number <> '' and nregister_status=1 $selectSTEgNum $selectCreateDate $selectExpedition $selectOwner $selectReceiptNum ORDER BY a.register_non_doc_id DESC OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }
        $sql = "SELECT a.register_non_doc_id,a.ndoc_description,a.ndelivery_location,a.nrecipient,b.name,a.create_date,a.nexpedition,a.estimated_time
                from non_doc_register a 
                left join sec_passwd b on a.nowner = b.userid $selectAll";
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
        $this->db->where('register_non_doc_id', $RegisterId);
        $this->db->update('non_doc_register', $dataTable);
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function getDataReg($idDocReg) {
        $sql = "SELECT a.register_non_doc_id,a.ndoc_description,a.ndelivery_location,a.nrecipient,b.name,a.create_date,a.nexpedition,a.estimated_time
                from non_doc_register a 
                left join sec_passwd b on a.nowner = b.userid
                where a.register_non_doc_id='$idDocReg'";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getEmail($Owner){
        $sql    = "SELECT email from sec_passwd where name = '$Owner'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        $email  = $result[0]->email;
        return $email;
    } 

}

/* End of file sec_group_user_m.php */
/* Location: ./application/models/sec_group_user.php */