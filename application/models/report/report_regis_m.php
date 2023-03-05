<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_regis_m extends CI_Model {

    public function getListRegis($startDate,$endDate,$idUser,$usergroup) {
        // echo $dir;
        // if($usergroup == 1 || $usergroup == 3){
        //     $selectAll = "where FORMAT(create_date, 'yyyy-MM-dd') between '".$startDate."' and '".$endDate."' ORDER BY a.register_doc_id DESC";
        // }else{
        //     $selectAll = "where a.owner='$idUser' and FORMAT(create_date, 'yyyy-MM-dd') between '".$startDate."' and '".$endDate."' ORDER BY a.register_doc_id DESC";
        // }
        // $sql = "SELECT a.register_doc_id,a.type,a.doc_description,b.name,a.doc_status,ISNULL(a.pickup_by,'-') as pickup_by,
        //         a.delivery_status,ISNULL(a.recipient,'-') as recipient,ISNULL(a.receipt_number,'-') as receipt_number,a.create_date,a.update_date,a.type,a.status_indexing,ISNULL(a.expedition,'-') as expedition,a.register_status,ISNULL(a.information,'-') as information
        //         from doc_register a
        //         left join sec_passwd b on a.owner = b.userid $selectAll";
        //echo $sql;die();
        $sp = "sp_getListRegis ?,?,?,?";
        $params = array(
                'PARAM_1' => "".$startDate."",
                'PARAM_2' => "".$endDate."",
                'PARAM_3' => "".$idUser."",
                'PARAM_4' => "".$usergroup."",);
        // print_r($params);die();
        $query = $this->db->query($sp,$params);
        return $query->result_array(); // returning rows, not row
    }

    public function getListRegisDownload($startDate,$endDate,$idUser,$usergroup) {
        // echo $dir;
        if($usergroup == 1 || $usergroup == 3){
            $selectAll = "where FORMAT(create_date, 'yyyy-MM-dd') between '".$startDate."' and '".$endDate."' ORDER BY a.register_doc_id DESC";
        }else{
            $selectAll = "where a.owner='$idUser' and FORMAT(create_date, 'yyyy-MM-dd') between '".$startDate."' and '".$endDate."' ORDER BY a.register_doc_id DESC";
        }
        $sql = "SELECT a.register_doc_id,a.type,a.doc_description,b.name,a.doc_status,a.pickup_by,
                a.delivery_status,a.recipient,a.receipt_number,a.create_date,a.update_date,a.type,a.status_indexing,a.expedition,a.register_status
                from doc_register a
                left join sec_passwd b on a.owner = b.userid $selectAll";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

   

}

/* End of file sec_group_user_m.php */
/* Location: ./application/models/sec_group_user.php */