<?php

class Customer_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    // Branch Customers Count Update
    function getBranchCustomersCnt($branch_id)
    {
        $this->db->select('customers_cnt');
        $this->db->where("pk_id", $branch_id);
        $query = $this->db->get("tbl_branches");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function updateBranch($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_branches", $data);
    }

    // Customer Related
    function addCustomer($data = [])
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_customers", $data);
        return $this->db->insert_id();
    }

    function updateCustomer($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_customers", $data);
    }

    function delCustomer($pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->delete("tbl_customers");
    }

    function getCustomerById($pk_id)
    {
        $this->db->select("m.*,CONCAT_WS(' ',m.first_name,m.last_name) as customer_name, l.location_name,l.pk_id as location_id,b.pk_id as branch_id,b.name as branch_name,q.company_name", FALSE);
        $this->db->join("tbl_locations l", "l.pk_id = m.location_id");
        $this->db->join("tbl_branches b", "b.pk_id = m.branch_id");
        $this->db->join("tbl_company_customers cc", "cc.customer_id =m.pk_id", "LEFT");
        $this->db->join("tbl_client_companies q", "q.pk_id = cc.company_id", "LEFT");

        $this->db->where("m.pk_id", $pk_id);
        $query = $this->db->get("tbl_customers m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function searchCustomers($data = [], $mode = 'DATA')
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*");
        }
        if(!empty($_SESSION['BRANCH_ID']) && ($_SESSION['ROLE'] != 'SUPER_ADMIN')){
            $this->db->where('m.branch_id', $_SESSION['BRANCH_ID']);
        }        
        if (isset($data['limit']) && isset($data['offset'])) {
            $this->db->limit($data['limit'], $data['offset']);
        }
        if (isset($data['name']) && !empty($data['name'])) {
            $this->db->where('m.name', $data['name']);
        }
        if (isset($data['email']) && !empty($data['email'])) {
            $this->db->where('m.email', $data['email']);
        }
        if (isset($data['mobile']) && !empty($data['mobile'])) {
            $this->db->where('m.mobile', $data['mobile']);
        }
        if (isset($data['customer_id']) && !empty($data['customer_id'])) {
            $this->db->where('m.customer_id', $data['customer_id']);
        }
        if (isset($data['is_active']) && !empty($data['is_active'])) {
            $this->db->where('m.is_active', $data['is_active']);
        }
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_customers m");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function checkCustomerEmail($email, $user_id = '')
    {
        //if($data == "TRUE"){
        $this->db->select("m.*");
        $this->db->where("m.email", $email);
        $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        if (!empty($user_id)) {
            $this->db->where("user_id !=", $user_id);
        }
        $query = $this->db->get("tbl_customers m");
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }

    // Company Related
    function addCompany($data = [])
    {
        if (!isset($data['created_on'])) {
            $date = date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_client_companies", $data);
        return $this->db->insert_id();
    }

    function addCompanyCustomers($data = [])
    {
        if (!isset($data['created_on'])) {
            $date = date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_company_customers", $data);
        return $this->db->insert_id();
    }

    // Company Approaches

    function addCustomerApproaches($data = [])
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_approaches", $data);
        return $this->db->insert_id();
    }

    function updateCustomerApproaches($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_approaches", $data);
    }

    function delCustomerApproaches($pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->delete("tbl_approaches");
    }

    function getCustomerApproachById($pk_id)
    {
        $this->db->select("m.*");
        $this->db->where("m.pk_id", $pk_id);
        $query = $this->db->get("tbl_approaches m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function searchCustomerApproaches($data = [], $mode = 'DATA')
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*");
        }
        if (isset($data['limit']) && isset($data['offset'])) {
            $this->db->limit($data['limit'], $data['offset']);
        }
        if (isset($data['customer_id']) && !empty($data['customer_id'])) {
            $this->db->where('m.customer_id', $data['customer_id']);
        }
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_approaches m");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
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
    function getBranchById($pk_id)
    {
        $this->db->select("m.*,l.location_name,CASE WHEN m.state_code = 'OTH' THEN m.other_location ELSE s.state_name END as state_name");
        $this->db->join("tbl_locations l", "l.pk_id = m.location_id","LEFT");
        $this->db->join("tbl_states s", "s.state_code = m.state_code","LEFT");
        $this->db->where("m.pk_id", $pk_id);
        if(isset($location_id)) {
            $this->db->where("m.location_id", $location_id);
        }                    
        $query = $this->db->get("tbl_branches m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

}