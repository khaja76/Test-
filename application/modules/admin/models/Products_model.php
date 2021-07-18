<?php

class Products_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    // Product Data
    function addProduct($data = [])
    {
        $date=date('Y-m-d H:i:s');
        $this->db->set("created_on",$date);
        $this->db->set("created_by", $_SESSION['USER_ID']);
        $this->db->insert("tbl_products", $data);
        return $this->db->insert_id();
    }

    function addProductCategory($data = array())
    {
        $date = date('Y-m-d H:i:s');
        $this->db->set("created_on",$date);
        $this->db->insert("tbl_product_categories", $data);
        return $this->db->insert_id();
    }

    function addProductTrack($data = [])
    {
        $date=date('Y-m-d H:i:s');
        $this->db->set("created_on",$date);
        $this->db->set("sold_by", $_SESSION['USER_ID']);
        $this->db->insert("tbl_products_track", $data);
        return $this->db->insert_id();
    }

    function updateProduct($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_products", $data);
    }

    function updateProductCategory($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_product_categories", $data);
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
            $this->db->select("m.*,c.pk_id as company_id,c.company_name,u.name as created_by,pc.category_name");
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        if (!empty($_SESSION['BRANCH_ID']) && ($_SESSION['ROLE'] != 'SUPER_ADMIN')) {
            $this->db->where('m.branch_id', $_SESSION['BRANCH_ID']);
        }
        $this->db->order_by("m.pk_id DESC");
        $this->db->join("tbl_users u", "u.user_id=m.created_by", "LEFT");
        $this->db->join("tbl_product_companies c", "c.pk_id=m.company_id",'LEFT');
        $this->db->join("tbl_product_categories pc", "pc.pk_id=m.category_id",'LEFT');
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

    function searchProductCategroies($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,u.name as created_by");
        }
        if(!empty($_SESSION['BRANCH_ID']) && ($_SESSION['ROLE']!='SUPER_ADMIN')){
            $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        $this->db->order_by("m.pk_id DESC");
        $this->db->join("tbl_users u", "u.user_id=m.created_by", "LEFT");
        $query = $this->db->get("tbl_product_categories m");
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
        $this->db->select("m.*,c.company_name,u.name as created_by");
        $this->db->join("tbl_product_companies c", "c.pk_id = m.company_id", "LEFT");
        $this->db->where("m.pk_id", $pk_id);
        $this->db->join("tbl_users u", "u.user_id=m.created_by", "LEFT");
        $query = $this->db->get("tbl_products m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function getProductCategroyById($pk_id)
    {
        $this->db->select("m.*,u.name as created_by");
        $this->db->where("m.pk_id", $pk_id);
        $this->db->join("tbl_users u", "u.user_id=m.created_by", "LEFT");
        $query = $this->db->get("tbl_product_categories m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function getProductCategroyByList()
    {
        $this->db->select("m.*");
        if(!empty($_SESSION['BRANCH_ID']) && ($_SESSION['ROLE']!='SUPER_ADMIN')){
            $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        }
        $query = $this->db->get("tbl_product_categories m");
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['pk_id']] = $row['category_name'];
            }
            return $rows;;
        }
        return false;
    }

    function checkProductExists($serial = '')
    {
        $this->db->select("m.serial_no");
        if(!empty($_SESSION['BRANCH_ID']) && ($_SESSION['ROLE']!='SUPER_ADMIN')){
            $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        }        
        $this->db->where("m.serial_no", $serial);
        $query = $this->db->get("tbl_products m");
        if ($query->num_rows() > 0) {
            return true;
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
    function getProductsList($s = [])
    {
        $this->db->select("m.*");
        if(!empty($_SESSION['BRANCH_ID']) && ($_SESSION['ROLE']!='SUPER_ADMIN')){
            $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        } 
        if (!empty($s['company_id'])) {
            $this->db->where('m.company_id', $s['company_id']);
        }
        $this->db->group_by("m.product_name");
        $query = $this->db->get("tbl_products m");
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['pk_id']] = $row['product_name'];
            }
            return $rows;

        }
        return false;
    }


// Product Companies Data

    function addProductCompany($data = [])
    {
        $date=date('Y-m-d H:i:s');
        $this->db->set("created_on",$date);
        $this->db->set("created_by", $_SESSION['USER_ID']);
        $this->db->insert("tbl_product_companies", $data);
        return $this->db->insert_id();
    }

    function getProductCompaniesList($s = [])
    {
        $this->db->select("m.*");
        if(!empty($_SESSION['BRANCH_ID']) && ($_SESSION['ROLE']!='SUPER_ADMIN')){
            $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        } 
        $this->db->group_by("m.company_name");
        $query = $this->db->get("tbl_product_companies m");
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['pk_id']] = $row['company_name'];
            }
            return $rows;

        }
        return false;
    }

    function getCompanyDetails($s = [])
    {
        $this->db->select("m.*");
        if(!empty($_SESSION['BRANCH_ID']) && ($_SESSION['ROLE']!='SUPER_ADMIN')){
            $this->db->where('m.branch_id', $_SESSION['BRANCH_ID']);
        }
        if (!empty($s['company_name'])) {
            $this->db->where('m.company_name', $s['company_name']);
        }
        $query = $this->db->get("tbl_product_companies m");
        if ($query->num_rows() > 0) {
            return $query->row_array();

        }
        return false;
    }

    function getProductHistoryById($product_id = '')
    {
        $this->db->select("pt.remarks,pt.created_on as sold_date,u.name as sold_by");
        $this->db->where("p.pk_id", $product_id);
        $this->db->join("tbl_products p", "p.pk_id=pt.product_id");
        $this->db->join("tbl_users u", "u.user_id=pt.sold_by", "LEFT");
        $this->db->order_by("pt.pk_id DESC");
        $query = $this->db->get("tbl_products_track pt");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


}