<?php

class Branch_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function addBranch($data)
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_branches", $data);
        return $this->db->insert_id();
    }

    function updateBranch($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_branches", $data);
    }

    function delBranch($pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->delete("tbl_branches");
    }

    function searchBranches($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,l.location_name");
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        if(!empty($s['location']) && isset($s['location'])){
            $this->db->where('m.location_id',$s['location']);
        }
        $this->db->join("tbl_locations l", "l.pk_id=m.location_id");
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_branches m");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function getBranchById($pk_id)
    {
        $this->db->select("m.*,l.location_name,CASE WHEN m.state_code = 'OTH' THEN m.other_location ELSE s.state_name END as state_name");
        $this->db->join("tbl_locations l", "l.pk_id = m.location_id","LEFT");
        $this->db->join("tbl_states s", "s.state_code = m.state_code","LEFT");
        $this->db->where("m.pk_id", $pk_id);
        if(isset($location_id)) {
            $this->db->where("m.location_id", $location_id);
        }/*else{
            $this->db->where("m.location_id", $_SESSION['LOCATION_ID']);
        }*/
        $query = $this->db->get("tbl_branches m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function getLocationsList()
    {
        $this->db->select("m.*");
        $query = $this->db->get("tbl_locations m");
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['pk_id']] = $row['location_name'];
            }
            return $rows;
        }
        return false;
    }

    function getStatesList()
    {
        $this->db->select("s.*");
        $this->db->order_by("state_name ASC");
        $query = $this->db->get("tbl_states s");
        if ($query->num_rows() > 0) {
            return $query->result_array();

        }
        return false;
    }
    function getBranchAdmin($branch_id)
    {
        $this->db->select("u.*");
        $this->db->where("m.branch_id", $branch_id);
        $this->db->join('tbl_users u','u.user_id = m.user_id');
        $this->db->where("m.is_active", 1);
        $this->db->where("m.role", "ADMIN");
        $query = $this->db->get("tbl_branch_users m");
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
}