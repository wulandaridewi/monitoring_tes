<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home_m extends CI_Model {
    
    public function get_menu_id($menu_uri) {
        $this->db->select('menu_id,menu_name,menu_header,parent,menu_icon');
        $this->db->from('sec_menu');
        $this->db->where('menu_uri', $menu_uri);
        $hasil = $this->db->get();
        return $hasil->result();
    }    

    public function getDocRegis($year,$idUser,$usergroup) {
        if($usergroup == 2){
        	$sql2 = "select top 1
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-01' and owner='$idUser'),0) as pointJan,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-02' and owner='$idUser'),0) as pointFeb,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-03' and owner='$idUser'),0) as pointMar,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-04' and owner='$idUser'),0) as pointApr,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-05' and owner='$idUser'),0) as pointMei,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-06' and owner='$idUser'),0) as pointJuni,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-07' and owner='$idUser'),0) as pointJuli,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-08' and owner='$idUser'),0) as pointAgu,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-09' and owner='$idUser'),0) as pointSep,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-10' and owner='$idUser'),0) as pointOkt,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-11' and owner='$idUser'),0) as pointNov,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-12' and owner='$idUser'),0) as pointDes
				from doc_register";
        }else{
        	$sql2 = "select top 1
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-01'),0) as pointJan,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-02'),0) as pointFeb,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-03'),0) as pointMar,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-04'),0) as pointApr,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-05'),0) as pointMei,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-06'),0) as pointJuni,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-07'),0) as pointJuli,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-08'),0) as pointAgu,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-09'),0) as pointSep,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-10'),0) as pointOkt,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-11'),0) as pointNov,
				ISNULL((select count(register_doc_id) from doc_register where FORMAT(create_date,'yyyy-MM') = '$year-12'),0) as pointDes
				from doc_register";
        }
        
	   // echo $sql2;die();
        $query2 = $this->db->query($sql2);
        return $query2->result_array();        
    }

    public function getNonDocRegis($year,$idUser,$usergroup) {
        if($usergroup == 2){
        	$sql2 = "select top 1
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-01' and nowner='$idUser'),0) as pointJan,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-02' and nowner='$idUser'),0) as pointFeb,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-03' and nowner='$idUser'),0) as pointMar,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-04' and nowner='$idUser'),0) as pointApr,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-05' and nowner='$idUser'),0) as pointMei,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-06' and nowner='$idUser'),0) as pointJuni,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-07' and nowner='$idUser'),0) as pointJuli,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-08' and nowner='$idUser'),0) as pointAgu,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-09' and nowner='$idUser'),0) as pointSep,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-10' and nowner='$idUser'),0) as pointOkt,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-11' and nowner='$idUser'),0) as pointNov,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-12' and nowner='$idUser'),0) as pointDes
				from non_doc_register";
        }else{
        	$sql2 = "select top 1
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-01'),0) as pointJan,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-02'),0) as pointFeb,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-03'),0) as pointMar,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-04'),0) as pointApr,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-05'),0) as pointMei,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-06'),0) as pointJuni,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-07'),0) as pointJuli,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-08'),0) as pointAgu,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-09'),0) as pointSep,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-10'),0) as pointOkt,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-11'),0) as pointNov,
				ISNULL((select count(register_non_doc_id) from non_doc_register where FORMAT(create_date,'yyyy-MM') = '$year-12'),0) as pointDes
				from non_doc_register";
        }
        
	    //echo $sql2;die();
        $query2 = $this->db->query($sql2);
        return $query2->result_array();        
    }

    public function getListRegis($year,$idUser,$usergroup,$date) {
    	$dateBefore = date('Y-m-d', strtotime('-7 days', strtotime($date)));
        //echo $dir;
        if($usergroup == 2){
            $selectAll = "and a.owner = '$idUser'";
        }else{
            $selectAll = "";
        }
        $sql = "SELECT b.name,b.name_file_image,c.department,a.register_doc_id,a.type,a.doc_description,a.doc_status,FORMAT(a.create_date,'dd-MM-yyyy hh:mm:ss') as create_date,a.register_status,a.delivery_status 
					from doc_register a
					left join sec_passwd b on a.owner = b.userid
					left join master_department c on b.dept_id = c.dept_id
					where FORMAT(a.create_date,'yyyy-MM-dd') between  '$dateBefore' and '$date' $selectAll
					";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result_array(); // returning rows, not row
    }

    public function getSizeContainer($year,$idUser,$usergroup,$date) {
    	$dateBefore = date('Y-m-d', strtotime('-7 days', strtotime($date)));
        //echo $dir;
        if($usergroup == 2){
            $selectAll = "where a.create_by = '$idUser' and b.status=0";
        }else{
            $selectAll = "where b.status=0";
        }
        $sql = "SELECT b.folder_name,SUM(a.document_size) as size from trans_document a
				left join master_folder b on a.folder_id = b.folder_id
				$selectAll group by b.folder_name";
        //echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result_array(); // returning rows, not row
    }

}

/* End of file homeModel.php */
/* Location: ./application/models/homemodel.php */