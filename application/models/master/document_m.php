<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Document_m extends CI_Model {

    public function update_field($id,$data){
        $this->db->where('specific_index_id', $id);
        $this->db->update('indexing_specific', $data);
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function insert_field($data){
        $this->db->trans_begin();
        $this->db->insert('indexing_specific', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function removeFieldDB($idField) {
        $this->db->where('specific_index_id', $idField);
        $this->db->delete('indexing_specific');
        if ($this->db->trans_status() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function getDocumentAll() {
        $sql = "SELECT dh.*,sp.name from master_document dh
                left join sec_passwd sp on dh.create_by = sp.userid
                where dh.status = 0 ORDER BY dh.document_id DESC";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function getFieldAll($document_id) {
        $sql = "SELECT a.specific_index_name,a.specific_index_id,a.specific_index_format,a.document_id,b.document_name from indexing_specific a
                left join master_document b on a.document_id = b.document_id
                where a.document_id=$document_id and a.status = 0 and b.status = 0";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

    public function delete_document($idDocument,$data) {
        $this->db->trans_start();
        $this->db->trans_strict(TRUE); 

        #update status document menjadi 1 (diweb terhapus)
        $this->db->where('document_id', $idDocument);
        $this->db->update('master_document',$data);

        // $sql = "SELECT group_document from master_folder where status = 0 and group_document like '%$document_name%'";
        // $query = $this->db->query($sql)->result_array();
        // //print_r($query);
       
        // foreach ($query as $key => $value){
        //     $group_document = $value['group_document'];
        //     $hasilArr    = explode('+', $group_document);
        //     $col_val = "";
        //     for ($i=0; $i < count($hasilArr); $i++) {           
        //       if($hasilArr[$i] !== $document_name){
        //         $col_val .= $hasilArr[$i]."+";
        //       }
        //     }
        //     $col_val = rtrim($col_val, '+');
        //     $this->db->where('CAST(group_document AS NVARCHAR(max))=', $group_document);
        //     $this->db->set('group_document', $col_val);
        //     $this->db->update('master_folder');
        // }
        
        #update status indexing_specific menjadi 1  (diweb terhapus)
        $this->db->where('document_id', $idDocument);
        $this->db->update('indexing_specific',$data);

        #update status group_document menjadi 1  (diweb terhapus)
        $this->db->where('document_id', $idDocument);
        $this->db->update('group_document',$data);
        
        $this->db->trans_complete(); # Completing transaction
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } 
        else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function updateDocumentName($idDocument,$data1) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(TRUE); # See Note 01. If you wish can remove as well        

        $this->db->where('document_id', $idDocument);
        $this->db->update('master_document', $data1);    

        $this->db->trans_complete(); # Completing transaction
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function insert_document($data) {
        $this->db->trans_begin();
        $this->db->insert('master_document', $data);
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
        $this->db->insert('indexing_specific', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
        
    }

    public function getDataCariNameDoc($nameDoc) {
        $sql = "SELECT document_name from master_document where document_name = '".$nameDoc."' and status = 0";
        $query = $this->db->query($sql);
        return $query->result(); // returning rows, not row
    }

}

/* End of file sec_group_user_m.php */
/* Location: ./application/models/sec_group_user.php */