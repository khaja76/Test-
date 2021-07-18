<?php
class Admin_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function getUserDocumentsByUser($user_id)
    {
        $this->db->select("d.*");
        $this->db->where("d.is_active", 1);
        $this->db->where("d.user_id", $user_id);
        $query = $this->db->get("tbl_user_documents d");
        if ($query->num_rows() > 0) {
            return $query->row_array();
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
    function getRolesList()
    { // For Roles
        $this->db->select("m.*");
        $this->db->where("m.is_active", 1);
        $this->db->where_not_in("m.role", 'SUPER_ADMIN');
        $query = $this->db->get("tbl_roles m");
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['role']] = $row['name'];
            }
            return $rows;
        }
        return false;
    }
    function userLogin($email, $pwd)
    {
        $this->db->select("*");
        $this->db->where("email", $email);
        $this->db->where("password", $pwd);
        $query = $this->db->get("tbl_users");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function checkUserEmail($email, $user_id = '')
    {
        $this->db->select("m.*");
        $this->db->where("email", $email);
        if (!empty($user_id)) {
            $this->db->where("user_id !=", $user_id);
        }
        $query = $this->db->get("tbl_users m");
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }
    function getUsersList($s = [])
    { // For Roles
        $this->db->select("m.*");
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);
        }
        if ((!empty($s['role']) && isset($s['role']))) {
            $this->db->where("m.role", $s['role']);
        }
        $this->db->where("m.user_id !=" . $_SESSION['USER_ID'] . "");
        $this->db->where("m.status", 'ACTIVE');
        $query = $this->db->get("tbl_users m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['user_id']] = $row['name'];
            }
            return $rows;
        }
        return false;
    }
    function getRoleStatusList()
    { // For Roles
        $this->db->select("m.*");
        $this->db->where("m.is_active", 1);
        $query = $this->db->get("tbl_role_status m");
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['status']] = $row['status'];
            }
            return $rows;
        }
        return false;
    }
    function getBranchIdByUserId($user_id)
    {
        $this->db->select("m.branch_id");
        $this->db->where("m.user_id", $user_id);
        $query = $this->db->get("tbl_users m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getJobsList($s = [])
    {
        $this->db->select("m.*");
        if (!empty($s['user_id']) && isset($s['user_id'])) {
            $this->db->where("m.assigned_to", $s['user_id']);
        }
        if (!empty($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);
        }
        $query = $this->db->get("tbl_inwards m");
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['pk_id']] = $row['job_id'];
            }
            return $rows;
        }
        return false;
    }
    function getLocationsList()
    {
        $this->db->select("m.*");
        $this->db->where("m.is_active", 1);
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
    function getBranchesList($location_id = '')
    {
        $this->db->select("m.*");
        if (!empty($location_id)) {
            $this->db->where("m.location_id", $location_id);
        }
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
    function checkBranchAdmin($branch_id, $user_id = '')
    {
        $this->db->select("m.*");
        $this->db->where("branch_id", $branch_id);
        if (!empty($user_id)) {
            $this->db->where("pk_id !=", $user_id);
        }
        $this->db->where("is_active", 1);
        $this->db->where("role", "ADMIN");
        $query = $this->db->get("tbl_branch_users m");
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }
    function checkBranchUser($branch_id, $user_id = '', $role = '')
    {
        $this->db->select("m.*");
        $this->db->where("branch_id", $branch_id);
        if (!empty($user_id)) {
            $this->db->where("pk_id !=", $user_id);
        }
        $this->db->where("is_active", 1);
        if (!empty($role)) {
            $this->db->where("role", $role);
        }
        $query = $this->db->get("tbl_branch_users m");
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }
    function getLocationsCnt($s = [])
    {
        $this->db->select("COUNT(*) as cnt");
        if (isset($s['is_active'])) {
            $this->db->where("is_active", $s['is_active']);
        }
        $query = $this->db->get("tbl_locations");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getBranchesCnt($s = [])
    {
        $this->db->select("COUNT(*) as cnt");
        if (isset($s['is_active'])) {
            $this->db->where("m.is_active", $s['is_active']);
        }
        if (isset($s['location_id']) && !empty($s['location_id'])) {
            $this->db->where("m.location_id", $s['location_id']);
        }
        if (isset($s['parent_status'])) {
            $this->db->join("tbl_locations l", "l.pk_id = m.location_id");
            $this->db->where("l.is_active", $s['parent_status']);
        }
        $query = $this->db->get("tbl_branches m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getUsersCnt($s = [])
    {
        $this->db->select("COUNT(*) as cnt");
        if (isset($s['status']) && (!empty($s['status']) && ($s['status'] == "ACTIVE"))) {
            $this->db->where("m.status", $s['status']);
        } elseif (isset($s['status']) && (!empty($s['status']) && ($s['status'] == "OTHERS"))) {
            $this->db->where("m.status !=", "ACTIVE");
        }
        if (isset($s['role']) && !empty($s['role'])) {
            $this->db->where("m.role", $s['role']);
        }
        if (isset($s['location_id']) && !empty($s['location_id'])) {
            $this->db->where("m.location_id", $s['location_id']);
        }
        if (isset($s['branch_id']) && !empty($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);
        }
        if (isset($s['parent_status'])) {
            $this->db->join("tbl_locations l", "l.pk_id = m.location_id");
            $this->db->where("l.is_active", $s['parent_status']);
        }
        $query = $this->db->get("tbl_users m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getCustomersCnt($s = [])
    {
        $this->db->select("COUNT(*) as cnt");
        if (isset($s['is_active'])) {
            $this->db->where("m.is_active", $s['is_active']);
        }
        if (isset($s['location_id']) && !empty($s['location_id'])) {
            $this->db->where("m.location_id", $s['location_id']);
        }
        if (isset($s['branch_id']) && !empty($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);
        }
        if (isset($s['parent_status'])) {
            $this->db->join("tbl_locations l", "l.pk_id = m.location_id");
            $this->db->where("l.is_active", $s['parent_status']);
        }
        $query = $this->db->get("tbl_customers m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getInwardsCnt($s = [])
    {
        $this->db->select("COUNT(*) as cnt");
        if (isset($s['status'])) {
            $this->db->where("m.status", $s['status']);
        }
        if (isset($s['is_approved'])) {
            $this->db->where("m.is_approved", $s['is_approved']);
        }
        if (isset($s['location_id']) && !empty($s['location_id'])) {
            $this->db->where("m.location_id", $s['location_id']);
        }
        if (isset($s['branch_id']) && !empty($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);
        }
        if (isset($s['date']) && !empty($s['date'])) {
            $this->db->where("DATE(m.created_on)", $s['date']);
        }
        if (isset($s['paid'])) {
            if ($s['paid']) {
                $this->db->where("m.paid_amt = m.estimation_amt and m.estimation_amt != 0");
            } else {
                $this->db->where("m.paid_amt < m.estimation_amt and m.estimation_amt != 0");
            }
        }
//        $this->db->where("m.estimation_amt != 0");
        if (isset($s['parent_status'])) {
            $this->db->join("tbl_locations l", "l.pk_id = m.location_id");
            $this->db->where("l.is_active", $s['parent_status']);
        }
        $query = $this->db->get("tbl_inwards m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    // Outwards
    function getOutwardsCnt($s = [])
    {
        $this->db->select("COUNT(*) as cnt");
        if (isset($s['status'])) {
            $this->db->where("m.status", $s['status']);
        }
        if (isset($s['location_id']) && !empty($s['location_id'])) {
            $this->db->where("m.location_id", $s['location_id']);
        }
        if (isset($s['branch_id']) && !empty($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);
        }
        if (isset($s['date']) && !empty($s['date'])) {
            $this->db->where("DATE(m.created_on)", $s['date']);
        }
        $query = $this->db->get("tbl_outwards m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    // Locations Data
    function searchLocations($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,b.pk_id as branch_id,b.name as branch_name");
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        if (isset($s['is_active'])) {
            $this->db->where_in("m.is_active", $s['is_active']);
        }
        if (isset($s['location_id']) && (!empty($s['location_id']))) {
            $this->db->where("m.pk_id", $s['location_id']);
        }
        $this->db->join("tbl_branches b", "m.pk_id = b.location_id", "LEFT");
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
    function getAdminDetails($s = [])
    {
        $this->db->select("user_id,name");
        //if(!empty($s['branch_id'])){
        $this->db->where("branch_id", $s['branch_id']);
        //}
        $this->db->where("role", "ADMIN");
        $query = $this->db->get("tbl_users");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function searchUsers($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,l.location_name,l.pk_id as location_id,b.pk_id as branch_id,b.name as branch_name");
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        if (!empty($s['role']) && isset($s['role'])) {
            $this->db->where("m.role", $s['role']);
        }
        $this->db->join("tbl_locations l", "l.pk_id = m.location_id");
        $this->db->join("tbl_branches b", "b.pk_id = m.branch_id");
        if (!empty($s['location_id']) && isset($s['location_id'])) {
            $this->db->where("m.location_id", $s['location_id']);
        }
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);
        }
        $this->db->order_by("m.user_id DESC");
        $query = $this->db->get("tbl_users m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }
    function getUserById($user_id)
    {
        if (!empty($_SESSION) && ($_SESSION['ROLE'] == "SUPER_ADMIN")) {
            $this->db->select("m.*,s.state_name");
        } else {
            $this->db->select("l.location_name,l.pk_id as location_id,b.pk_id as branch_id,b.name as branch_name,d.*,d.user_id as doc_user_id,m.*,s.state_name");
            $this->db->join("tbl_locations l", "l.pk_id = m.location_id");
            $this->db->join("tbl_branches b", "b.pk_id = m.branch_id");
            $this->db->join("tbl_user_documents d", "d.user_id = m.user_id", "LEFT");
        }
        $this->db->join("tbl_states s", "s.state_code = m.state", "LEFT");
        $this->db->where("m.user_id", $user_id);
        $query = $this->db->get("tbl_users m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    //
    function searchCustomers($data = [], $mode = 'DATA')
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*");
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
        if (!empty($s['location_id']) && isset($s['location_id'])) {
            $this->db->where("m.location_id", $s['location_id']);
        }
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);
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
    function getCustomerById($user_id)
    {
        $this->db->select("m.*,l.location_name,l.pk_id as location_id,b.pk_id as branch_id,b.name as branch_name");
        $this->db->join("tbl_locations l", "l.pk_id = m.location_id");
        $this->db->join("tbl_branches b", "b.pk_id = m.branch_id");
        $this->db->where("m.pk_id", $user_id);
        $query = $this->db->get("tbl_customers m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getTransactions($job_pk_id, $branch_id = '')
    {
        $this->db->select("i.job_id,i.status,i.estimation_amt,i.paid_amt,b.name as branch_name,c.customer_id,c.first_name,c.last_name,c.mobile as customer_mobile,c.email as customer_email,ccom.company_name as customer_company_name,ccom.company_mail as customer_company_mail,ccom.phone as customer_company_mobile,oc.challan as outward_challan,q.pk_id as q_id,q.quotation,pi.pk_id as p_id,pi.proforma,in.pk_id as i_id,in.invoice");
        $this->db->join("tbl_branches b", "b.pk_id = i.branch_id");
        $this->db->join("tbl_customers c", "c.pk_id = i.customer_id");
        $this->db->join("tbl_company_customers cc", "cc.customer_id = c.customer_id", "LEFT");
        $this->db->join("tbl_client_companies ccom", "ccom.pk_id = cc.company_id", "LEFT");
        $this->db->join("tbl_outwards o", "o.inward_id = i.pk_id", "LEFT");
        $this->db->join("tbl_outward_challans oc", "oc.pk_id = o.outward_challan_id", "LEFT");
        $this->db->join("tbl_quotation_jobs qj", "qj.job_id = i.pk_id", "LEFT");
        $this->db->join("tbl_quotations q", "q.pk_id = qj.quotation_id", "LEFT");
        $this->db->join("tbl_proforma_invoice_jobs pij", "pij.quotation_job_id =qj.pk_id", "LEFT");
        $this->db->join("tbl_proforma_invoices pi", "pi.pk_id = pij.proforma_id", "LEFT");

        $this->db->join("tbl_invoice_jobs ij", "ij.job_id =qj.pk_id", "LEFT");
        $this->db->join("tbl_invoices in", "in.pk_id = ij.invoice_id", "LEFT");
        $this->db->where("i.pk_id", $job_pk_id);
        $query = $this->db->get("tbl_inwards i");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getWorkOrder($job_id, $branch_id)
    {
        $this->db->select("pi.work_order");
        $this->db->where("qj.job_id", $job_id);
        $this->db->where("pi.branch_id", $branch_id);
        $this->db->join("tbl_branches b", "b.pk_id = pi.branch_id", "LEFT");
        $this->db->join("tbl_proforma_invoice_jobs pij", "pij.proforma_id =pi.pk_id", "LEFT");
        $this->db->join("tbl_quotation_jobs qj", "qj.pk_id = pij.quotation_job_id", "LEFT");
        $query = $this->db->get("tbl_proforma_invoices pi");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getBranchAdmin($branch_id)
    {
        $this->db->select("u.*");
        $this->db->where("m.branch_id", $branch_id);
        $this->db->join('tbl_users u', 'u.user_id = m.user_id');
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
