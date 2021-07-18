<?php
class bk_Component_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    // Component Details
    function addComponent($data = [])
    {
        $this->db->set("created_on", "NOW()", false);
        $this->db->set("created_by",$_SESSION['USER_ID']);
        $this->db->insert("tbl_components", $data);
        return $this->db->insert_id();
    }
    function updateComponent($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_components", $data);
    }
    function delComponent($pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->delete("tbl_components");
    }
    function searchComponents($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,c.pk_id as company_id,c.company_name");
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        if (!empty($s['branch_id'])) {
            $this->db->where('m.branch_id', $s['branch_id']);
        }

        $this->db->order_by("m.pk_id DESC");
        $this->db->join("tbl_component_companies c", "c.pk_id = m.company_id");
        $query = $this->db->get("tbl_components m");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }
    function getComponentById($pk_id)
    {
        $this->db->select("m.*,c.company_name");
        $this->db->join("tbl_component_companies c","c.pk_id = m.company_id","LEFT");
        $this->db->where("m.pk_id", $pk_id);
        $query = $this->db->get("tbl_components m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getComponentsList($s = []){
        $this->db->select("m.*");
        if (!empty($s['company_id'])) {
            $this->db->where('m.company_id', $s['company_id']);
        }
        if (!empty($s['component_name'])) {
            $this->db->where('m.component_name', $s['component_name']);
        }
        if (!empty($s['branch_id'])) {
            $this->db->where('m.branch_id', $s['branch_id']);
        }
        $query = $this->db->get("tbl_components m");
        if ($query->num_rows() > 0) {
            $rows = [];
            foreach($query->result_array() as $row){
                $rows[$row['pk_id']] = $row['component_name'];
            }
            return $rows;
        }
        return false;
    }
    function getComponentModelsList($s = []){
        $this->db->select("m.*");
        if (!empty($s['company_id'])) {
            $this->db->where('m.company_id', $s['company_id']);
        }
        if (!empty($s['component_name'])) {
            $this->db->where('m.component_name', $s['component_name']);
        }
        if (!empty($s['branch_id'])) {
            $this->db->where('m.branch_id', $s['branch_id']);
        }
        $query = $this->db->get("tbl_components m");
        if ($query->num_rows() > 0) {
            $rows = [];
            foreach($query->result_array() as $row){
                $rows[$row['pk_id']] = $row['model_no'];
            }
            return $rows;
        }
        return false;
    }
    function getComponentDetails($s= []){
        $this->db->select("m.*");
        if (!empty($s['company_id'])) {
            $this->db->where('m.company_id', $s['company_id']);
        }
        if (!empty($s['component_name'])) {
            $this->db->where('m.component_name', $s['component_name']);
        }
        if (!empty($s['model_no'])) {
            $this->db->where('m.model_no', $s['model_no']);
        }
        if (!empty($s['branch_id'])) {
            $this->db->where('m.branch_id', $s['branch_id']);
        }
        $query = $this->db->get("tbl_components m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    // Component Company Details
    function addComponentCompany($data = [])
    {
        $this->db->set("created_on", "NOW()", false);
        $this->db->set("created_by",$_SESSION['USER_ID']);
        $this->db->insert("tbl_component_companies", $data);
        return $this->db->insert_id();
    }
    function getComponentCompaniesList()
    {
        $this->db->select("m.*");
        $query = $this->db->get("tbl_component_companies m");
        if ($query->num_rows() > 0) {
            $rows = [];
            foreach($query->result_array() as $row){
                $rows[$row['pk_id']] = $row['company_name'];
            }
            return $rows;
        }
        return false;
    }
    function getCompanyDetails($s = [])
    {
        $this->db->select("m.*");
        if (!empty($s['company_name'])) {
            $this->db->where('m.company_name', $s['company_name']);
        }
        if (!empty($s['branch_id'])) {
            $this->db->where('m.branch_id', $s['branch_id']);
        }
        $query = $this->db->get("tbl_component_companies m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    // Component Stock Details
    function addComponentStock($data = [])
    {
        $this->db->set("created_on", "NOW()", false);
        $this->db->set("created_by",$_SESSION['USER_ID']);
        $this->db->insert("tbl_component_stock", $data);
        return $this->db->insert_id();
    }
    function getComponentQuantity($s = []){
        $this->db->select("(SELECT SUM(m.quantity) FROM tbl_component_stock m WHERE m.type = 'ADD' AND m.component_id = '".$component_id."') as add_qty, 
        (SELECT SUM(s.quantity) FROM tbl_component_stock s WHERE s.type = 'UPDATE' AND s.component_id = '".$component_id."' ) as sub_qty,
        (SELECT SUM(i.quantity) FROM tbl_component_stock i WHERE i.type = 'INWARD' AND i.component_id = '".$component_id."' ) as inward_qty
        ");
        $this->db->where('component_id', $component_id);
        $this->db->group_by('component_id');
        $query = $this->db->get("tbl_component_stock");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
}