<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_regis_m extends CI_Model {

    public function getDevAll($dir,$start,$length,$sRegNum,$idUser,$sCreateDate) {
        // echo $dir;
        if($sRegNum =='' && $sCreateDate ==''){
            $selectAll = "where a.owner='$idUser' ORDER BY a.register_doc_id ".$dir." OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }else{
            if($sRegNum ==''){
               $selectSTEgNum = ""; 
            }else{
                $selectSTEgNum = " and a.register_doc_id = '".$sRegNum."'";
            }

            if($sCreateDate ==''){
               $selectCreateDate = ""; 
            }else{
                $selectCreateDate = "and FORMAT(a.create_date, 'dd-MM-yyyy HH:mm:ss') LIKE '%".$sCreateDate."%'";               
            }

            
            $selectAll = "where a.owner='$idUser' $selectSTEgNum $selectCreateDate ORDER BY a.register_doc_id DESC OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }
        $sql = "SELECT a.register_doc_id,a.type,a.doc_description,b.name,a.doc_status,a.pickup_by,
                a.delivery_status,a.recipient,a.receipt_number,a.create_date,a.update_date,a.type,a.status_indexing,a.expedition,a.register_status
                from doc_register a
                left join sec_passwd b on a.owner = b.userid $selectAll";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getRecordsTotal($idUser) {
        $sql = "SELECT a.register_doc_id,a.type,a.doc_description,b.name,a.doc_status,a.pickup_by,
                a.delivery_status,a.recipient,a.receipt_number,a.create_date,a.update_date,a.type,a.status_indexing,a.expedition,a.register_status
                from doc_register a
                left join sec_passwd b on a.owner = b.userid
                where a.owner='$idUser'";
        $query = $this->db->query($sql);
        $recordsTotal = $query->num_rows();
        return $recordsTotal;
    }

    public function getRecordsFilteredTotal($dir,$start,$length,$sRegNum,$idUser,$sCreateDate) {
        // echo $dir;
         if($sRegNum =='' && $sCreateDate ==''){
            $selectAll = "where a.owner='$idUser' ORDER BY a.register_doc_id ".$dir." OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }else{
            if($sRegNum ==''){
               $selectSTEgNum = ""; 
            }else{
                $selectSTEgNum = " and a.register_doc_id = '".$sRegNum."'";
            }

            if($sCreateDate ==''){
               $selectCreateDate = ""; 
            }else{
                $selectCreateDate = "and FORMAT(a.create_date, 'dd-MM-yyyy HH:mm:ss') LIKE '%".$sCreateDate."%'";               
            }

            
            $selectAll = "where a.owner='$idUser' $selectSTEgNum $selectCreateDate ORDER BY a.register_doc_id DESC OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }
        $sql = "SELECT a.register_doc_id,a.type,a.doc_description,b.name,a.doc_status,a.pickup_by,
                a.delivery_status,a.recipient,a.receipt_number,a.create_date,a.update_date,a.type,a.status_indexing,a.expedition,a.register_status
                from doc_register a
                left join sec_passwd b on a.owner = b.userid $selectAll";
        // echo $sql;die();
        $query = $this->db->query($sql);
        $RecordsFilteredTotal = $query->num_rows();
        return $RecordsFilteredTotal;
    }

   

}

/* End of file sec_group_user_m.php */
/* Location: ./application/models/sec_group_user.php */