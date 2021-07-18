<?php
class Customers_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
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
    function addCustomer($data)
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
    function searchCustomers($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,l.pk_id as location_id, l.location_name, b.pk_id as branch_id, b.name as branch_name,s.state_code,s.state_name as state");
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        if (isset($s['location_id']) && !empty($s['location_id'])) {
            $this->db->where('m.location_id', $s['location_id']);
        }
        if (isset($s['branch_id']) && !empty($s['branch_id'])) {
            $this->db->where('m.branch_id', $s['branch_id']);
        }else if(!empty($_SESSION['BRANCH_ID']) && ($_SESSION['ROLE'] != 'SUPER_ADMIN')){
            $this->db->where('m.branch_id', $_SESSION['BRANCH_ID']);
        }        
        //search
        if (!empty($s['type']) && $s['type'] == 'mobile') {
            $this->db->where("m.mobile", $s['data']);
        } elseif (!empty($s['type']) && $s['type'] == 'email') {
            $this->db->where("m.email", $s['data']);
        } elseif (!empty($s['type']) && $s['type'] == 'name') {
            $this->db->where("m.first_name LIKE '%" . $s['data'] . "%' OR m.last_name LIKE '%" . $s['data'] . "%'");
        } elseif (!empty($s['type']) && $s['type'] == 'customer_id') {
            $this->db->where("(m.customer_no LIKE '%" . $s['data'] . "' OR m.customer_id = '".$s['data']."'  )");
        }
        $this->db->join("tbl_locations l", "l.pk_id = m.location_id");
        $this->db->join("tbl_branches b", "b.pk_id = m.branch_id");
        $this->db->join("tbl_states s", "s.state_code = m.state");
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
    function getCustomersByCustom($key, $value)
    {
        $this->db->select("m.pk_id,CONCAT_WS(' ',m.first_name,m.last_name) as customer_name,q.company_name,cc.company_id,m.email,m.customer_id,m.mobile,m.img,m.img_path,m.thumb_img", FALSE);
        $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        if (!empty($key) && $key == 'mobile') {
            $this->db->where("m.mobile", $value);
        } elseif (!empty($key) && $key == 'email') {
            $this->db->where("m.email", $value);
        } elseif (!empty($key) && $key == 'name') {
            $this->db->where("m.first_name LIKE '%" . $value . "%' OR m.last_name LIKE '%" . $value . "%'");
        } elseif (!empty($key) && $key == 'customer_id') {
            $this->db->where("(m.customer_no LIKE '%" . $value . "' OR m.customer_id = '" . $value . "' )");
        }
        $this->db->join("tbl_company_customers cc", "cc.customer_id = m.pk_id", "LEFT");
        $this->db->join("tbl_client_companies q", "q.pk_id = cc.company_id", "LEFT");
        $query = $this->db->get("tbl_customers m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    function getCustomerById($pk_id)
    {
        $this->db->select("m.*,l.pk_id as location_id, l.location_name, b.pk_id as branch_id, b.name as branch_name,s.state_code,s.state_name as state , q.company_name,q.company_mail,q.phone as company_mobile,q.contact_name,q.gst_no");
        $this->db->join("tbl_locations l", "l.pk_id = m.location_id");
        $this->db->join("tbl_branches b", "b.pk_id = m.branch_id");
        $this->db->join("tbl_states s", "s.state_code = m.state");
        $this->db->join("tbl_company_customers cc", "cc.customer_id =m.pk_id", "LEFT");
        $this->db->join("tbl_client_companies q", "q.pk_id = cc.company_id", "LEFT");
        $this->db->where("m.pk_id", $pk_id);
        $query = $this->db->get("tbl_customers m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getCustomerDetails($s = [])
    {
        $this->db->select("m.*,CONCAT_WS(' ',first_name,last_name) as customer_name,l.pk_id as location_id, l.location_name, b.pk_id as branch_id, b.name as branch_name,s.state_code,s.state_name as state , q.company_name,q.phone as company_phone ,q.company_mail,m.mobile as customer_mobile",false);
        $this->db->join("tbl_locations l", "l.pk_id = m.location_id");
        $this->db->join("tbl_branches b", "b.pk_id = m.branch_id");
        $this->db->join("tbl_states s", "s.state_code = m.state");
        $this->db->join("tbl_company_customers cc", "cc.customer_id =m.pk_id", "LEFT");
        $this->db->join("tbl_client_companies q", "q.pk_id = cc.company_id", "LEFT");
        if(!empty($s['customer_no']) && (isset($s['customer_no']))){
            $this->db->where("m.customer_no", $s['customer_no']);
        }
        if(!empty($s['pk_id']) && (isset($s['pk_id']))){
            $this->db->where("m.pk_id", $s['pk_id']);
        }
        if(!empty($s['branch_id']) && isset($s['branch_id'])){
            $this->db->where('m.branch_id',$s['branch_id']);
        }else{
            $this->db->where('m.branch_id',$_SESSION['BRANCH_ID']);
        }
        $query = $this->db->get("tbl_customers m");
       // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
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
    function getBranchesList($location_id)
    {
        $this->db->select("m.*");
        $this->db->where("m.location_id", $location_id);
        $query = $this->db->get("tbl_branches m");
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['pk_id']] = $row['name'];
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
    function searchCustomerCompanies(){
        $this->db->select("m.*,CONCAT_WS(' ',first_name,last_name) as customer_name,c.pk_id as customer_pk_id",false);
        if(!empty($s['branch_id']) && isset($s['branch_id'])){
            $this->db->where('c.branch_id',$s['branch_id']);
        }else{
            $this->db->where('c.branch_id',$_SESSION['BRANCH_ID']);
        }
        $this->db->join("tbl_company_customers cc", "cc.company_id =m.pk_id", "LEFT");
        $this->db->join("tbl_customers c", "c.pk_id = cc.customer_id", "LEFT");
        $query = $this->db->get("tbl_client_companies m");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    function checkCustomerCompanyExists($s=[]){
        $this->db->select("m.*,cc.company_name,cc.company_mail,cc.phone,cc.contact_name,cc.gst_no");
        if(!empty($s['customer_id']) && isset($s['customer_id'])){
            $this->db->where('m.customer_id',$s['customer_id']);
        }
        $this->db->join("tbl_client_companies cc", "cc.pk_id =m.company_id", "LEFT");
        $query = $this->db->get(" tbl_company_customers m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    // Company Related
    function addCompany($data = [])
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_client_companies", $data);
        return $this->db->insert_id();
    }
    function updateCompany($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_client_companies", $data);
    }
    function addCompanyCustomers($data = [])
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_company_customers", $data);
        return $this->db->insert_id();
    }
}