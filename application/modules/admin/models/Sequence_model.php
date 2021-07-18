<?php
class Sequence_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    // Branch Sequence Number
    function addBranchNumberSequence($data = [])
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_number_sequence", $data);
        return $this->db->insert_id();
    }
    function updateBranchNumberSequence($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        if (!isset($data['updated_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("updated_on",$date);
        }
        return $this->db->update("tbl_number_sequence", $data);
    }

    function getBranchNumberSequenceById($pk_id,$branch_id){
        $this->db->select("*");        
        $this->db->where("pk_id", $pk_id);
        $this->db->where("branch_id", $branch_id);
        $query = $this->db->get("tbl_number_sequence");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function getAllNumberSequences($s = [], $mode = "DATA"){
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*");
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);
        }
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_number_sequence m");        
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function checkNumberSequence($type,$branch_id,$pk_id=''){
        $this->db->select("m.*");
        $this->db->where("m.action_type",$type);
        $this->db->where("m.branch_id",$branch_id);
        if (!empty($pk_id)) {
            $this->db->where("m.pk_id !=", $pk_id);
        }
        $query = $this->db->get("tbl_number_sequence m");
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }


}