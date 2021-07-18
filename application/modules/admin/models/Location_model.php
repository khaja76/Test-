<?php
class Location_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function addLocation($data)
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_locations", $data);
        return $this->db->insert_id();
    }

    function updateLocation($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_locations", $data);
    }

    function delLocation($pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->delete("tbl_locations");
    }

    function searchLocations($s = [], $mode = "DATA")
    {
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
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_locations m");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function getLocationById($pk_id)
    {
        $this->db->select("m.*");
        $this->db->where("m.pk_id", $pk_id);
        $query = $this->db->get("tbl_locations m");
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

    function checkLocation($location_name,$location_id=''){
        $this->db->select("m.*");
        $this->db->where("location_name",$location_name);
        if (!empty($location_id)) {
            $this->db->where("pk_id !=", $location_id);
        }
        $query = $this->db->get("tbl_locations m");
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }

    function getBranchesCntByLocationId($location_id){
        $this->db->select("COUNT(*) as CNT");
        if (!empty($location_id)) {
            $this->db->where("location_id", $location_id);
        }
        $query = $this->db->get("tbl_branches m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }


}