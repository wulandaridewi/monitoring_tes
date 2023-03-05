<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Document_m extends CI_Model {

    public function update_field($id,$data){
        $this->db->where('idField', $id);
        $this->db->update('document_detail', $data);
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function insert_field($data){
        $this->db->trans_begin();
        $this->db->insert('document_detail', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function removeFieldDB($idField) {
        $this->db->where('idField', $idField);
        $this->db->delete('document_detail');
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function getDocumentAll() {
        $sql = "SELECT dh.*,sp.name from document_header dh
                left join sec_passwd sp on dh.createBy = sp.userid ";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getFieldAll($document_id) {
        $sql = "SELECT a.fieldName,a.idField,a.document_format,b.document_name from document_detail a
                left join document_header b on a.document_id = b.document_id
                where a.document_id=$document_id";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function delete_document($idDocument) {
        $model1 = $this->db->where('document_id', $idDocument);
        $model1 = $this->db->delete('document_header');

        $model2 = $this->db->where('document_id', $idDocument);
        $model2 = $this->db->delete('document_detail');
        if ($model1 && $model2) {
            return true;
        } else {
            return false;
        }
    }

    public function update_total_field($document_id,$data1) {
        $model1 = $this->db->where('document_id', $document_id);
        $model2 = $this->db->update('document_header', $data1);
        if ($model1 && $model2) {
            return true;
        } else {
            return false;
        }
    }

    public function insert_document($data) {
        $this->db->trans_begin();
        $this->db->insert('document_header', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function insert_documentDetail($data) {
        $this->db->trans_begin();
        $this->db->insert('document_detail', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
        
    }

    // public function getDocumentName($document_id) {
    //     $sql = "SELECT document_name from document_header where document_id=$document_id";
    //     $query = $this->db->query($sql);
    //     return $query->result(); // returning rows, not row
    // }
    
    // public function getIdUsergroup() {
    //     $sql = "select usergroup_id from sec_usergroup";
    //     $query = $this->db->query($sql);
    //     $jml = $query->num_rows();
    //     if ($jml == 0) {
    //         $usergroup_id = "1";
    //         return $usergroup_id;
    //     } else {
    //         $sql = "select max(usergroup_id) as usergroup_id from sec_usergroup";
    //         $query = $this->db->query($sql);
    //         $hasil = $query->result();
    //         $usergroup_id = $hasil[0]->usergroup_id;
    //         $usergroup_id = $usergroup_id + 1;
    //         return $usergroup_id;
    //     }
    // }

    // public function getIdFieldTranChild($document_id) {
    //     $sql = "select tdc.field_id from document_header dh
    //             left join document_detail dt on dt.document_id = dh.document_id
    //             left join trans_doc_parent tdp on dt.document_id = tdp.document_id
    //             left join trans_doc_child tdc on tdc.parent_id = tdp.parent_id
    //             where tdp.document_id=$document_id group by tdc.field_id";
    //     $query = $this->db->query($sql);
    //     return $query->result(); // returning rows, not row
    // }

    // public function ubah($idDocument,$data1,$data2,$number) {
    //     $this->db->trans_begin(); 
    //     $model = $this->db->where('document_id', $idDocument);
    //     $model = $this->db->delete('document_detail');

    //     $model1 = $this->db->where('document_id', $idDocument);
    //     $model1 = $this->db->update('document_header', $data1);

    //     for($i=0; $i<$number; $i++)
    //         {   
    //             $model2 = $this->db->insert('document_detail', $data2);
    //             //echo $number.'-'.$document_name.'-'.$_POST["name"][$i].'<br>';                
    //         }
               
    //     if ($this->db->trans_status() === FALSE) {
    //         $this->db->trans_rollback();
    //         return false;
    //     } else {
    //         $this->db->trans_commit();
    //         return true;
    //     }
    // }

    
    // public function delete_field($document_id) {
    //     $model1 = $this->db->where('document_id', $document_id);
    //     $model2 = $this->db->delete('document_detail');
    //     if ($model1 && $model2) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    

    // public function update_document($document_id, $data) {
    //     $model1 = $this->db->where('document_id', $document_id);
    //     $model2 = $this->db->update('master_document', $data);
    //     if ($model1 && $model2) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    

}

/* End of file sec_group_user_m.php */
/* Location: ./application/models/sec_group_user.php */