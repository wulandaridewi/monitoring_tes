<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sec_group_menu_m extends CI_Model {

    public function getUserGroup() {
        $sql = "select * from sec_usergroup";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
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

    public function get_menu_group_user_m($kd_group_user,$userid=null) {
          
        if($userid!='')
        {
            $selectmenuid ="SELECT * FROM sec_menu
                            JOIN users ON users.userid =sec_menu_akses.userid
                            WHERE users.userid =$userid  AND users.roles ='$kd_group_user'";
            $exe =$this->db->query($selectmenuid)->result();
        }else{
            $exe =[];
        }
    
        if(count($exe)>0)
        {
            $getMenu =$exe[0]->menu_id;
            $sql = "SELECT menu_id,parent,menu_allowed,lvl
                    FROM sec_menu 
                    WHERE menu_id IN ($getMenu)  AND menu_uri NOT IN ('#','-')";
        }else{
            $getMenu =null;
            $sql = "SELECT menu_id,parent,menu_allowed,lvl
                    FROM sec_menu
                    WHERE menu_allowed LIKE '%+$kd_group_user%' AND  menu_uri NOT IN ('#','-')";
        }
        $query=$this->db->query($sql)->result();
        return $query;
    }

    public function update_menu_status_user_m($data_menu, $status_user) {

   
//      
        if (empty($data_menu[0])) {
            return false;
        } else {
            $allowed_new = '+' . $status_user;

            $sql = "update sec_menu set menu_allowed = replace(menu_allowed,'" . $allowed_new . "','')"; // hilangkan semua
            $query = $this->db->query($sql);

            foreach ($data_menu as $x => $x_value) {
                $data_menu2 = array();

                $data_menu2 = explode('_', $x_value);
 
                if (count($data_menu2) > 1) {

                    $sql1 = "select menu_allowed,parent,menu_id from sec_menu where menu_id = " . $data_menu2[0];
                    $query1 = $this->db->query($sql1)->result();

                    foreach ($query1 as $valSub) {
                       
                        $menu_id = $valSub->menu_id;
                        $parent = $valSub->parent;
                        $sqll = "  SELECT count(*) as jml FROM sec_menu WHERE menu_id = " . $menu_id . " AND menu_allowed LIKE '%" . $allowed_new . "%'";
                        $cekAllow = $this->db->query($sqll)->result();

                        if ($cekAllow[0]->jml < 1) {
//                            LEVEL 4
                            $sqlupd = "update sec_menu set menu_allowed = concat(menu_allowed,'" . $allowed_new . "') where menu_id = " . $menu_id;
                            $queryupd = $this->db->query($sqlupd);

                            $sqlparentsubparent = "SELECT count(*) as jml  FROM sec_menu WHERE menu_id = " . $parent . " AND menu_allowed LIKE '%" . $allowed_new . "%'";
                            $cekAllowsubparent = $this->db->query($sqlparentsubparent)->result();


                            if ($cekAllowsubparent[0]->jml < 1) {
                                //LEVEL 3
                                $sqlupd1 = "update sec_menu set menu_allowed = concat(menu_allowed,'" . $allowed_new . "') where menu_id = " . $parent;
                                $queryupd1 = $this->db->query($sqlupd1);
                            }


                            //LEVEL 2
                            $sql2 = "select parent from sec_menu where menu_id = '" . $parent . "'";
                            $query2 = $this->db->query($sql2)->result();

                            $sqlparent = "SELECT count(*) as jml  FROM sec_menu WHERE menu_id = " . $query2[0]->parent . " AND menu_allowed LIKE '%" . $allowed_new . "%'";
                            $cekAllowparent = $this->db->query($sqlparent)->result();

                            if ($cekAllowparent[0]->jml < 1) {

                                $sqlsb2 = "select parent from sec_menu where menu_id = '" . $query2[0]->parent . "'";
                                $querysb2 = $this->db->query($sqlsb2)->result();

                                if (sizeof($querysb2) > 0) {
                                    $sqlparent2 = "SELECT count(*) as jml  FROM sec_menu WHERE menu_id = " . $querysb2[0]->parent . " AND menu_allowed LIKE '%" . $allowed_new . "%'";
                                    $cekAllowparent2 = $this->db->query($sqlparent2)->result();

                                    if ($cekAllowparent2[0]->jml < 1) {
                                        foreach ($querysb2 as $valParent2) {
                                            $sql2 = "update sec_menu set menu_allowed = concat(menu_allowed,'" . $allowed_new . "') where menu_id = " . $valParent2->parent;
                                            $this->db->query($sql2);
//                                    dd($query2);
                                        }
                                    }
                                }

                                foreach ($query2 as $valParent) {
                                    $sql2 = "update sec_menu set menu_allowed = concat(menu_allowed,'" . $allowed_new . "') where menu_id = " . $valParent->parent;
                                    $this->db->query($sql2);
//                                    dd($query2);
                                }
                            }
                            //LEVEL 1
                        }
                    }
                } else {
                     
                    foreach ($data_menu2 as $rows) {
                        
                        $sqlparentone = "SELECT count(*) as jml  FROM sec_menu WHERE menu_id = " . $rows . " AND menu_allowed LIKE '%" . $allowed_new . "%'";
                       
                        $cekAllowparentone = $this->db->query($sqlparentone)->result();
                        
//                         print_r($cekAllowparentone[0]->jml);die();
                        
                        if ($cekAllowparentone[0]->jml < 1) {
                            $sqlone = "update sec_menu set menu_allowed = concat(menu_allowed,'" . $allowed_new . "') where menu_id = '" . $rows . "'";
                            $query = $this->db->query($sqlone);
                        }
                    }
                }
            }// end foreach($data_menu as $x=>$x_value){

            return true;
        }
    }


}

/* End of file sec_menu_user_m.php */
/* Location: ./application/models/sec_menu_user.php */