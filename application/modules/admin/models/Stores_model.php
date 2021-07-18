<?php
class Stores_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    // Add to Store
    // Edit in Store
    // Delete Item Store
    // View By Item Id
    // Get All Items Store List
    // Report by Item Id includes used for which Inward

    public function addProduct($data=[])
    {
        $this->db->set("created_on",date("Y-m-d H:i:s"), false);
        $this->db->insert("tbl_products", $data);
        return $this->db->insert_id();
    }
    function updateProduct($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_products", $data);
    }

    function delProduct($pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->delete("tbl_products");
    }
    function searchProducts($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,c.pk_id as company_id,c.company_name");
        }
        if(!empty($_SESSION['BRANCH_ID']) && ($_SESSION['ROLE'] != 'SUPER_ADMIN')){
            $this->db->where('m.branch_id', $_SESSION['BRANCH_ID']);
        }       
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        $this->db->order_by("m.pk_id DESC");
        $this->db->join("tbl_product_companies c","c.pk_id=m.company_id");
        $query = $this->db->get("tbl_products m");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function getProductById($pk_id)
    {
        $this->db->select("m.*");
        $this->db->where("m.pk_id", $pk_id);
        $query = $this->db->get("tbl_products m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getProductCompanyList($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("c.pk_id as company_id,c.company_name");
        }
        if(!empty($_SESSION['BRANCH_ID']) && ($_SESSION['ROLE'] != 'SUPER_ADMIN')){
            $this->db->where('c.branch_id', $_SESSION['BRANCH_ID']);
        }        
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        $query = $this->db->get("tbl_product_companies c");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }
    //Components
    public function addComponent($data=[])
    {
        $this->db->set("created_on", "NOW()", false);
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
        if(!empty($_SESSION['BRANCH_ID']) && ($_SESSION['ROLE'] != 'SUPER_ADMIN')){
            $this->db->where('m.branch_id', $_SESSION['BRANCH_ID']);
        }        
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        $this->db->order_by("m.pk_id DESC");
        $this->db->join("tbl_component_companies c","c.pk_id=m.company_id");
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
        $this->db->select("m.*");
        $this->db->where("m.pk_id", $pk_id);
        $query = $this->db->get("tbl_components m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getComponenetCompanyList($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("c.pk_id as company_id,c.company_name");
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        if(!empty($_SESSION['BRANCH_ID']) && ($_SESSION['ROLE'] != 'SUPER_ADMIN')){
            $this->db->where('c.branch_id', $_SESSION['BRANCH_ID']);
        }        
        $query = $this->db->get("tbl_component_companies c");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }
}