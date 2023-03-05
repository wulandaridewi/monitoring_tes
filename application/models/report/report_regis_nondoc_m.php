<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_regis_nondoc_m extends CI_Model {

    public function getListRegis($startDate,$endDate,$idUser,$usergroup) {
        // echo $dir;
        if($usergroup == 1 || $usergroup == 3){
            $selectAll = "where FORMAT(create_date, 'yyyy-MM-dd') between '".$startDate."' and '".$endDate."' ORDER BY a.register_non_doc_id DESC";
        }else{
            $selectAll = "where a.nowner='$idUser' and FORMAT(create_date, 'yyyy-MM-dd') between '".$startDate."' and '".$endDate."' ORDER BY a.register_non_doc_id DESC";
        }

        $sql = "SELECT a.register_non_doc_id,a.ntype,a.ndoc_description,b.name,a.ndoc_status,a.npickup_by,
                a.ndelivery_status,a.nrecipient,a.nreceipt_number,a.create_date,a.update_date,a.ntype,a.nexpedition,a.nregister_status
                from non_doc_register a
                left join sec_passwd b on a.nowner = b.userid $selectAll";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result_array(); // returning rows, not row
    }

    public function getListRegisDownload($startDate,$endDate,$idUser,$usergroup) {
        // echo $dir;
        if($usergroup == 1 || $usergroup == 3){
            $selectAll = "where FORMAT(create_date, 'yyyy-MM-dd') between '".$startDate."' and '".$endDate."' ORDER BY a.register_non_doc_id DESC";
        }else{
            $selectAll = "where a.nowner='$idUser' and FORMAT(create_date, 'yyyy-MM-dd') between '".$startDate."' and '".$endDate."' ORDER BY a.register_non_doc_id DESC";
        }
        $sql = "SELECT a.register_non_doc_id,a.ntype,a.ndoc_description,b.name,a.ndoc_status,a.npickup_by,
                a.ndelivery_status,a.nrecipient,a.nreceipt_number,a.create_date,a.update_date,a.ntype,a.nexpedition,a.nregister_status
                from non_doc_register a
                left join sec_passwd b on a.nowner = b.userid $selectAll";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

   

}

/* End of file sec_group_user_m.php */
/* Location: ./application/models/sec_group_user.php */