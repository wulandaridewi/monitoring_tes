<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Delivery_internal_nondoc_m extends CI_Model {

    public function getDevAll($dir,$start,$length,$sRegNum,$sCreateDate,$owner,$sDept,$sRecipt) {
        // echo $dir;
        if($sRegNum =='' && $sCreateDate ==''  && $sDept ==''  && $owner =='' && $sRecipt ==''){
            $selectAll = "where a.ntype = 'DOC_IN' and a.ndoc_status = 'DELIVER' and a.ndelivery_status='INTERNAL' and nregister_status=1 ORDER BY a.register_non_doc_id ".$dir." OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }else{
            if($sRegNum ==''){
               $selectSTEgNum = ""; 
            }else{
                $selectSTEgNum = " and a.register_non_doc_id = '".$sRegNum."'";
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
            
            $selectAll = "where a.ntype = 'DOC_IN' and a.ndoc_status = 'DELIVER' and a.ndelivery_status='INTERNAL' and nregister_status=1 $selectSTEgNum $selectCreateDate $selectDept $selectOwner $selectReceiptNum ORDER BY a.register_non_doc_id DESC OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }
        $sql = "SELECT a.register_non_doc_id,a.ndoc_description,ISNULL(a.nrecipient,'-') as nrecipient,b.name,a.create_date,c.department,ISNULL(a.information,'-') as information,ISNULL(a.note,'-') as note
                from non_doc_register a 
                left join sec_passwd b on a.nowner = b.userid
                left join master_department c on b.dept_id = c.dept_id $selectAll";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getRecordsTotal() {
        $sql = "SELECT * FROM non_doc_register a where a.ntype = 'DOC_IN' and a.ndoc_status = 'DELIVER' and a.ndelivery_status='INTERNAL' and nregister_status=1";
        $query = $this->db->query($sql);
        $recordsTotal = $query->num_rows();
        return $recordsTotal;
    }

    public function getRecordsFilteredTotal($dir,$start,$length,$sRegNum,$sCreateDate,$owner,$sDept,$sRecipt) {
        // echo $dir;
        if($sRegNum =='' && $sCreateDate ==''  && $sDept ==''  && $sOwner =='' && $sRecipt ==''){
            $selectAll = "where a.ntype = 'DOC_IN' and a.ndoc_status = 'DELIVER' and a.ndelivery_status='INTERNAL' and nregister_status=1 ORDER BY a.register_non_doc_id ".$dir." OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }else{
            if($sRegNum ==''){
               $selectSTEgNum = ""; 
            }else{
                $selectSTEgNum = " and a.register_non_doc_id = '".$sRegNum."'";
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
            
            
            $selectAll = "where a.ntype = 'DOC_IN' and a.ndoc_status = 'DELIVER' and a.ndelivery_status='INTERNAL' and nregister_status=1 $selectSTEgNum $selectCreateDate $selectDept $selectOwner $selectReceiptNum ORDER BY a.register_non_doc_id DESC OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }
        $sql = "SELECT a.register_non_doc_id,a.ndoc_description,ISNULL(a.nrecipient,'-') as nrecipient,b.name,a.create_date,c.department,ISNULL(a.information,'-') as information,ISNULL(a.note,'-') as note
                from non_doc_register a 
                left join sec_passwd b on a.nowner = b.userid
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
        $this->db->where('register_non_doc_id', $idDocReg);
        $this->db->update('non_doc_register', $data);
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function getDataReg($idDocReg) {
        $sql = "SELECT a.register_non_doc_id,a.ndoc_description,a.ndelivery_location,a.nrecipient,b.name,a.create_date,a.nexpedition,ISNULL(a.information,'-') as information,ISNULL(a.note,'-') as note
                from non_doc_register a 
                left join sec_passwd b on a.nowner = b.userid
                where a.register_non_doc_id='$idDocReg'";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

}

/* End of file sec_group_user_m.php */
/* Location: ./application/models/sec_group_user.php */