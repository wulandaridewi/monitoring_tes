<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Delivery_internal_doc_m extends CI_Model {

    public function getDevAll($dir,$start,$length,$sRegNum,$sCreateDate,$owner,$sDept,$sRecipt) {
        // echo $sRecipt;
        if($sRegNum =='' && $sCreateDate ==''  && $sDept ==''  && $owner =='' && $sRecipt ==''){
            $selectAll = "where a.type = 'DOC_IN' and a.doc_status = 'DELIVER' and a.delivery_status='INTERNAL' and register_status=1 ORDER BY a.register_doc_id ".$dir." OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
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

            if($sDept ==''){
                $selectDept = ""; 
            }else{
                $selectDept = "and c.department like '%".$sDept."%'";               
            }
            if($owner ==''){
               $selectOwner = ""; 
            }else{
                $selectOwner = "and b.name like '%".$owner."%'";               
            }

            if($sRecipt ==''){
               $selectReceipt = ""; 
            }else{
                $selectReceipt = "and a.recipient like '%".$sRecipt."%'";               
            }
            
            $selectAll = "where a.type = 'DOC_IN' and a.doc_status = 'DELIVER' and a.delivery_status='INTERNAL' and register_status=1 $selectSTEgNum $selectCreateDate $selectDept $selectOwner $selectReceipt ORDER BY a.register_doc_id DESC OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }
        $sql = "SELECT a.register_doc_id,a.doc_description,ISNULL(a.recipient,'-') as recipient,b.name,a.create_date,c.department,ISNULL(a.information,'-') as information,ISNULL(a.note,'-') as note
                from doc_register a 
                left join sec_passwd b on a.owner = b.userid
                left join master_department c on b.dept_id = c.dept_id $selectAll";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getRecordsTotal() {
        $sql = "SELECT * FROM doc_register a where a.type = 'DOC_IN' and a.doc_status = 'DELIVER' and a.delivery_status='INTERNAL' and register_status=1";
        $query = $this->db->query($sql);
        $recordsTotal = $query->num_rows();
        return $recordsTotal;
    }

    public function getRecordsFilteredTotal($dir,$start,$length,$sRegNum,$sCreateDate,$owner,$sDept,$sRecipt) {
        // echo $dir;
        if($sRegNum =='' && $sCreateDate ==''  && $sDept ==''  && $sOwner =='' && $sRecipt ==''){
            $selectAll = "where a.type = 'DOC_IN' and a.doc_status = 'DELIVER' and a.delivery_status='INTERNAL' and register_status=1 ORDER BY a.register_doc_id ".$dir." OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
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

            if($sDept ==''){
                $selectDept = ""; 
            }else{
                $selectDept = "and c.department like '%".$sDept."%'";               
            }
            if($owner ==''){
               $selectOwner = ""; 
            }else{
                $selectOwner = "and b.name like '%".$owner."%'";               
            }

            if($sRecipt ==''){
               $selectReceiptNum = ""; 
            }else{
                $selectReceiptNum = "and a.recipient like '%".$sRecipt."%'";               
            }
            
            $selectAll = "where a.type = 'DOC_IN' and a.doc_status = 'DELIVER' and a.delivery_status='INTERNAL' and register_status=1 $selectSTEgNum $selectCreateDate $selectDept $selectOwner $selectReceiptNum ORDER BY a.register_doc_id DESC OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }
        $sql = "SELECT a.register_doc_id,a.doc_description,ISNULL(a.recipient,'-') as recipient,b.name,a.create_date,c.department,ISNULL(a.information,'-') as information,ISNULL(a.note,'-') as note
                from doc_register a 
                left join sec_passwd b on a.owner = b.userid
                left join master_department c on b.dept_id = c.dept_id $selectAll";
        // echo $sql;die();
        $query = $this->db->query($sql);
        $RecordsFilteredTotal = $query->num_rows();
        return $RecordsFilteredTotal;
    }

    public function getEmail($Owner){
        $sql= "SELECT email from sec_passwd where name = '$Owner'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        $email  = $result[0]->email;
        return $email;
    } 

    public function update_doc_reg($data,$idDocReg){
        // echo $idDocReg;
        // print_r($data);die();
        $this->db->where('register_doc_id', $idDocReg);
        $this->db->update('doc_register', $data);
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

}

/* End of file sec_group_user_m.php */
/* Location: ./application/models/sec_group_user.php */