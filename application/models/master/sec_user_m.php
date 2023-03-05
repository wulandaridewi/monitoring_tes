<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sec_user_m extends CI_Model {

    public function getUserAll($dir,$start,$length,$sName,$sUserName,$sUsergroupDesc,$sDept,$sEmail) {
        // echo $dir;
    	if($sName =='' && $sUserName =='' && $sUsergroupDesc ==''){
            $selectAll = "ORDER BY a.userid ".$dir." OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }else{
            if($sUsergroupDesc ==''){
               $selectGroupDesc = ""; 
            }else{
                $selectGroupDesc = "b.usergroup_desc = '".$sUsergroupDesc."'";
            }

            if($sUserName ==''){
               $selectUserName = ""; 
            }else{
                if($sUsergroupDesc ==''){
                    $selectUserName = "a.username LIKE'%".$sUserName."%'";
                }else{
                    $selectUserName = "and a.username LIKE '%".$sUserName."%'";
                }                
            }

            if($sName ==''){
               $selectName = ""; 
            }else{
                
                if($sUsergroupDesc =='' && $sUserName ==''){
                    $selectName = "a.name LIKE '%".$sName."%'";
                }else{
                    $selectName = "and a.name LIKE '%".$sName."%'";
                } 
            }           
            
            if($sDept ==''){
               $selectDept = ""; 
            }else{
                
                if($sUsergroupDesc =='' && $sUserName =='' && $sName ==''){
                    $selectDept = "md.department LIKE '%".$sDept."%'";
                }else{
                    $selectDept = "and md.department LIKE '%".$sDept."%'";
                } 
            }   

            if($sEmail ==''){
               $selectEmail = ""; 
            }else{
                
                if($sUsergroupDesc =='' && $sUserName =='' && $sName =='' && $sDept ==''){
                    $selectEmail = "a.email LIKE '%".$sEmail."%'";
                }else{
                    $selectEmail = "and a.email LIKE '%".$sEmail."%'";
                } 
            }  
            $selectAll = "where $selectGroupDesc $selectUserName $selectName $selectDept $selectEmail ORDER BY a.userid DESC OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";
        }
        $sql = "SELECT a.userid,a.name,a.email,a.username,a.password,a.usergroup,b.usergroup_desc,md.dept_id,md.department,a.gender from sec_passwd a 
        left join sec_usergroup b on a.usergroup = b.usergroup_id 
        left join master_department md on a.dept_id = md.dept_id $selectAll";
        // echo $sql;die();
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getDataRowTable($userid) {
        $sql = "SELECT * FROM sec_passwd sc
        left join master_department md on sc.dept_id =md.dept_id where sc.userid = '".$userid."'";
        $query = $this->db->query($sql);
        return $query->result();
    }    

    public function getRecordsTotal() {
        $sql = "SELECT * FROM sec_passwd";
        $query = $this->db->query($sql);
        $recordsTotal = $query->num_rows();
        return $recordsTotal;
    }

    public function getRecordsFilteredTotal($dir,$sName,$sUserName,$sUsergroupDesc) {
    	if($sName =='' && $sUserName =='' && $sUsergroupDesc ==''){
            $selectAll = "";
        }else{
            if($sUsergroupDesc ==''){
               $selectGroupDesc = ""; 
            }else{
                $selectGroupDesc = "b.usergroup_desc = '".$sUsergroupDesc."'";
            }

            if($sUserName ==''){
               $selectUserName = ""; 
            }else{
                if($sUsergroupDesc ==''){
                    $selectUserName = "a.username LIKE'%".$sUserName."%'";
                }else{
                    $selectUserName = "and a.username LIKE '%".$sUserName."%'";
                }                
            }

            if($sName ==''){
               $selectName = ""; 
            }else{
                
                if($sUsergroupDesc =='' && $sUserName ==''){
                    $selectName = "a.name LIKE '%".$sName."%'";
                }else{
                    $selectName = "and a.name LIKE '%".$sName."%'";
                } 
            }           
            
            $selectAll = "where $selectGroupDesc $selectUserName $selectName ORDER BY a.userid ".$dir."";
        }
        $sql = "SELECT a.userid,a.name,a.username,a.password,a.usergroup,b.usergroup_desc from sec_passwd a 
        left join sec_usergroup b on a.usergroup = b.usergroup_id $selectAll";
        // echo $sql;die();
        $query = $this->db->query($sql);
        $RecordsFilteredTotal = $query->num_rows();
        return $RecordsFilteredTotal;
    }

    public function get_status_user() {
        $rows = array(); //will hold all results
        $sql = "select * from sec_usergroup order by usergroup_id asc ";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {
            $rows[] = $row; //add the fetched result to the result array;
        }
        return $rows; // returning rows, not row
    }

     public function get_dept_all() {
        $rows = array(); //will hold all results
        $sql = "select * from master_department order by dept_id asc ";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {
            $rows[] = $row; //add the fetched result to the result array;
        }
        return $rows; // returning rows, not row
    }

    public function insert_user_m($data) {
		$this->db->insert('sec_passwd', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function editUser($data,$userIdEdit){
        $this->db->where('userid', $userIdEdit);
        $this->db->update('sec_passwd', $data);
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_user($userid){
        $this->db->where('userid', $userid);
        $this->db->delete('sec_passwd');
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }


}
