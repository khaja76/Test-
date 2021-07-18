<?php
class Inward_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function getBranchInwardsCnt($s = [])
    {
        $this->db->select('COUNT(1) as CNT');
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where("branch_id", $s['branch_id']);
        }
        if (!empty($s['financial_year']) && isset($s['financial_year'])) {
            $this->db->where("financial_year", $s['financial_year']);
        }
        $query = $this->db->get("tbl_inwards");
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['CNT'];
        }
        return false;
    }
    function updateBranch($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_branches", $data);
    }
    function getBranchById($pk_id)
    {
        $this->db->select("m.*,l.location_name,CASE WHEN m.state_code = 'OTH' THEN m.other_location ELSE s.state_name END as state_name");
        $this->db->join("tbl_locations l", "l.pk_id = m.location_id","LEFT");
        $this->db->join("tbl_states s", "s.state_code = m.state_code","LEFT");
        $this->db->where("m.pk_id", $pk_id);        
        $query = $this->db->get("tbl_branches m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function addInward($data)
    {
        if (!isset($data['created_on'])) {
            $date = date('Y-m-d H:i:s');
            $this->db->set("created_on", $date);
        }
        $this->db->insert("tbl_inwards", $data);
        return $this->db->insert_id();
    }
    function addInwardStatus($data)
    {
        if (!isset($data['created_on'])) {
            $date = date('Y-m-d H:i:s');
            $this->db->set("created_on", $date);
        }
        $this->db->insert("tbl_inward_status", $data);
        return $this->db->insert_id();
    }
    function updateInward($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_inwards", $data);
        //echo $this->db->last_query();
    }
    function delInward($pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->delete("tbl_inwards");
    }
    function searchInwards($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,c.customer_id,c.pk_id as customer_pk_id,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,c.mobile,c.city,c.img_path as customer_path,c.img,u.name as created_by,a.name as assigned_to,ic.challan as inward_challan,oc.challan as outward_challan,m.outward_date", FALSE);
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        $this->db->join("tbl_customers c", "c.pk_id = m.customer_id", "LEFT");
        $this->db->join("tbl_users u", "u.user_id = m.created_by", "LEFT");
        $this->db->join("tbl_users a", "a.user_id = m.assigned_to", "LEFT");
        $this->db->join("tbl_inward_challans ic", "ic.pk_id = m.inward_challan_id", "LEFT");
        $this->db->join("tbl_outward_challans oc", "oc.pk_id = m.outward_challan_id", "LEFT");
        if (!empty($s['from_date'])) {
            $from = $s['from_date'];
            $to = $s['to_date'];
            $this->db->where("DATE(m.created_on) BETWEEN '" . $from . "' AND '" . $to . "'");
        }
        if (!empty($s['date']) && isset($s['date'])) {
            $this->db->where("DATE(m.created_on)", $s['date']);
        }
        if (!empty($s['status'])) {
            $this->db->where('m.status', $s['status']);
        }
        if (!empty($s['outward_from_date'])) {
            $from = $s['outward_from_date'];
            $to = $s['outward_to_date'];
            $this->db->where("DATE(m.outward_date) BETWEEN '" . $from . "' AND '" . $to . "'");
        }
        if (!empty($s['outward_date'])) {
            $this->db->where("DATE(m.outward_date)", $s['outward_date']);
        }
        if (!empty($s['quotation'])) {
            $this->db->where("m.estimation_amt",0);
        }
        //Admin Reports
        if (isset($s['is_outwarded']) && !empty($s['is_outwarded'])) {
            // $this->db->where('m.is_outwarded', 'YES');
            $this->db->where('m.is_outwarded', $s['is_outwarded']);
        }
        if (!empty($s['created_by']) && isset($s['created_by'])) {
            $this->db->where('m.created_by', $s['created_by']);
        }
        if (!empty($s['customer_id']) && isset($s['customer_id'])) {
            $this->db->where('c.customer_no', $s['customer_id']);
        }
        if (!empty($s['assigned_to']) && isset($s['assigned_to'])) {
            $this->db->where('m.assigned_to', $s['assigned_to']);
        }
        if (!empty($s['job_pk_id']) && isset($s['job_pk_id'])) {
            $this->db->where('m.pk_id', $s['job_pk_id']);
        }
        if (!empty($s['customer_pk_id']) && isset($s['customer_pk_id'])) {
            $this->db->where('m.pk_id', $s['customer_pk_id']);
        }
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);;
        }
        if (!empty($s['location_id']) && isset($s['location_id'])) {
            $this->db->where("m.location_id", $s['location_id']);;
        }
        if (!empty($s['inward_challan_id']) && isset($s['inward_challan_id'])) {
            $this->db->where("m.inward_challan_id", $s['inward_challan_id']);;
        }
        if (isset($s['paid'])) {
            if ($s['paid']) {
                $this->db->where("m.paid_amt =m.estimation_amt AND m.estimation_amt !=0");
            } else {
                $this->db->where("m.paid_amt < m.estimation_amt AND m.estimation_amt !=0");
            }
        }
        if (!empty($s['inward_challan_id']) && isset($s['inward_challan_id'])) {
            $this->db->order_by("m.pk_id ASC");
        } else {
            $this->db->order_by("m.pk_id DESC");
        }
        $query = $this->db->get("tbl_inwards m");
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
    function getInwardById($pk_id, $branch_id = '')
    {
        /*$this->db->select("m.*,c.customer_id,c.pk_id as customer_pk_id,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,c.img_path as customer_path,c.img,u.name as assign_to,m.inward_challan_id,ic.challan as inward_challan,ic.created_on as challan_created_on,oc.challan as outward_challan,", FALSE);
        $this->db->join("tbl_customers c", "c.pk_id = m.customer_id", "LEFT");
        $this->db->join("tbl_users u", "u.user_id = m.assigned_to", "LEFT");
        $this->db->join("tbl_inward_challans ic", "ic.pk_id = m.inward_challan_id", "LEFT");
        $this->db->join("tbl_outward_challans oc", "oc.pk_id = m.outward_challan_id", "LEFT");
        $this->db->where("m.pk_id", $pk_id);
        $query = $this->db->get("tbl_inwards m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;*/
        $this->db->select("m.*,c.customer_id,c.pk_id as customer_pk_id,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,c.img_path as customer_path,c.img,q.company_name,u.name as assign_to,m.inward_challan_id,ic.challan as inward_challan,ic.created_on as challan_created_on,oc.challan as outward_challan,o.outward_images_path,o.remarks as outward_remarks,usr.name as created_by", FALSE);
        $this->db->join("tbl_customers c", "c.pk_id = m.customer_id", "LEFT");
        $this->db->join("tbl_users u", "u.user_id = m.assigned_to", "LEFT");
        $this->db->join("tbl_users usr", "usr.user_id = m.created_by", "LEFT");
        $this->db->join("tbl_inward_challans ic", "ic.pk_id = m.inward_challan_id", "LEFT");
        ///Customer Companies
        $this->db->join("tbl_company_customers cc", "cc.customer_id =c.pk_id", "LEFT");
        $this->db->join("tbl_client_companies q", "q.pk_id = cc.company_id", "LEFT");
        //////
        $this->db->join("tbl_outward_challans oc", "oc.pk_id = m.outward_challan_id", "LEFT");
        $this->db->join("tbl_outwards o", "o.inward_id = m.pk_id AND oc.pk_id = o.outward_challan_id", "LEFT");
        if (!empty($_SESSION) && ($_SESSION['ROLE'] == "SUPER_ADMIN")) {
            $this->db->where("m.branch_id", $branch_id);
        } else {
            $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        }
        //$this->db->where("(m.inward_no = '" . $job_id . "' OR m.pk_id = '" . $job_id . "') ");
        $this->db->where("m.pk_id", $pk_id);
        $query = $this->db->get("tbl_inwards m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getInwardByJobId($job_id, $branch_id = '')
    {
        $this->db->select("m.*,c.customer_id,c.pk_id as customer_pk_id,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,c.img_path as customer_path,c.img,c.mobile,q.company_name,q.company_mail,q.phone as company_mobile,q.contact_name,q.gst_no,u.name as assign_to,m.inward_challan_id,ic.challan as inward_challan,ic.created_on as challan_created_on,oc.challan as outward_challan,o.outward_images_path,o.remarks as outward_remarks,usr.name as created_by", FALSE);
        $this->db->join("tbl_customers c", "c.pk_id = m.customer_id", "LEFT");
        $this->db->join("tbl_users u", "u.user_id = m.assigned_to", "LEFT");
        $this->db->join("tbl_users usr", "usr.user_id = m.created_by", "LEFT");
        $this->db->join("tbl_inward_challans ic", "ic.pk_id = m.inward_challan_id", "LEFT");
        ///Customer Companies
        $this->db->join("tbl_company_customers cc", "cc.customer_id =c.pk_id", "LEFT");
        $this->db->join("tbl_client_companies q", "q.pk_id = cc.company_id", "LEFT");
        //////
        $this->db->join("tbl_outward_challans oc", "oc.pk_id = m.outward_challan_id", "LEFT");
        $this->db->join("tbl_outwards o", "o.inward_id = m.pk_id AND oc.pk_id = o.outward_challan_id", "LEFT");
        if (!empty($_SESSION) && ($_SESSION['ROLE'] == "SUPER_ADMIN")) {
            $this->db->where("m.branch_id", $branch_id);
        } else {
            $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        }
        //$this->db->where("(m.inward_no = '" . $job_id . "' OR m.pk_id = '" . $job_id . "') ");
        $this->db->where("m.inward_no", $job_id);
        $query = $this->db->get("tbl_inwards m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getInwardDetails($s = [])
    {
        $this->db->select("m.*,c.customer_id,c.pk_id as customer_pk_id,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,c.img_path as customer_path,c.img,q.company_name,u.name as assign_to,m.inward_challan_id,ic.challan as inward_challan,ic.created_on as challan_created_on,oc.challan as outward_challan,o.outward_images_path,o.remarks as outward_remarks,usr.name as created_by", FALSE);
        $this->db->join("tbl_customers c", "c.pk_id = m.customer_id", "LEFT");
        $this->db->join("tbl_users u", "u.user_id = m.assigned_to", "LEFT");
        $this->db->join("tbl_users usr", "usr.user_id = m.created_by", "LEFT");
        $this->db->join("tbl_inward_challans ic", "ic.pk_id = m.inward_challan_id", "LEFT");
        $this->db->join("tbl_company_customers cc", "cc.customer_id =c.pk_id", "LEFT"); //Customer Companies
        $this->db->join("tbl_client_companies q", "q.pk_id = cc.company_id", "LEFT");
        $this->db->join("tbl_outward_challans oc", "oc.pk_id = m.outward_challan_id", "LEFT");
        $this->db->join("tbl_outwards o", "o.inward_id = m.pk_id AND oc.pk_id = o.outward_challan_id", "LEFT");
        if (!empty($_SESSION) && ($_SESSION['ROLE'] == "SUPER_ADMIN") && (!empty($s['branch_id']))) {
            $this->db->where("m.branch_id", $s['branch_id']);
        } else {
            $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        }
        if (!empty($s['job_id']) && (isset($s['job_id']))) {
            $this->db->where("(m.inward_no = '" . $s['job_id'] . "' OR m.job_id LIKE '%" . $s['job_id'] . "') ");
        }
        if (isset($s['is_outwarded']) && !empty($s['is_outwarded'])) {
            $this->db->where('m.is_outwarded', $s['is_outwarded']);
        }
        if (!empty($s['quotation'])) {
            $this->db->where("m.estimation_amt",0);
        }
        $query = $this->db->get("tbl_inwards m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    function getInwardChallanByChallanId($challan_id)
    {
        $this->db->select("m.challan as inward_challan");
        $this->db->where("m.pk_id", $challan_id);
        $query = $this->db->get("tbl_inward_challans m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getCustomersByCustom($key, $value)
    {
        $this->db->select("m.pk_id,CONCAT_WS(' ',m.first_name,m.last_name) as customer_name,q.company_name,q.company_mail,q.phone as company_mobile,q.gst_no,q.contact_name,cc.company_id,m.email,m.customer_id,m.branch_id,m.customer_no,m.mobile,m.img,m.img_path,m.thumb_img", FALSE);
        $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        if (!empty($key) && $key == 'mobile') {
            $this->db->where("m.mobile", $value);
        } elseif (!empty($key) && $key == 'email') {
            $this->db->where("m.email", $value);
        } elseif (!empty($key) && $key == 'name') {
            $this->db->where("CONCAT_WS(' ',m.first_name,m.last_name) LIKE '%" . $value . "%'");
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
        $this->db->select("m.*,q.company_name");
        $this->db->where("m.pk_id", $pk_id);
        $this->db->join("tbl_company_customers cc", "cc.customer_id = m.pk_id", "LEFT");
        $this->db->join("tbl_client_companies q", "q.pk_id = cc.company_id", "LEFT");
        $query = $this->db->get("tbl_customers m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getCustomerByNo($c_no)
    {
        $this->db->select("m.*,q.company_name");
        $this->db->where("m.customer_no", $c_no);
        if(!empty($_SESSION) && ($_SESSION['ROLE']!='SUPER_ADMIN')){
            $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        }
        $this->db->join("tbl_company_customers cc", "cc.customer_id = m.pk_id", "LEFT");
        $this->db->join("tbl_client_companies q", "q.pk_id = cc.company_id", "LEFT");
        $query = $this->db->get("tbl_customers m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getUsersList($s = [])
    {
        $this->db->select("m.*");
        if (!empty($s['role'])) {
            $this->db->where("m.role", $s['role']);
        }
        if (!empty($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);
        }
        $query = $this->db->get("tbl_users m");
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['user_id']] = $row['name'];
            }
            return $rows;
        }
        return false;
    }
    function getInwardHistoryById($s = [], $date = '')
    {
        $this->db->select("m.*,i.job_id,u.name as user_name,a.name as assigned_to,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,l.status_type ", FALSE);
        if (!empty($s['inward_no']) && isset($s['inward_no'])) {
            $this->db->where("i.inward_no", $s['inward_no']);
        }
        if (!empty($s['job_id']) && isset($s['job_id'])) {
            $this->db->where("m.job_id", $s['job_id']);
        }
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where("i.branch_id", $s['branch_id']);
        }
        if (!empty($date)) {
            $this->db->where("DATE(m.created_on)", $date);
        }
        $this->db->join("tbl_inwards i", "i.pk_id = m.inward_id");
        $this->db->join("tbl_job_status_list l", "l.name = m.status");
        $this->db->join("tbl_customers c", "i.customer_id = c.pk_id");
        $this->db->join("tbl_users u", "u.user_id = m.user_id");
        $this->db->join("tbl_users a", "a.user_id = m.assigned_to", "LEFT");
        $this->db->order_by('m.pk_id DESC');
        $query = $this->db->get("tbl_inward_status m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    function getInwardHistoryByIdC($s = [])
    {
        $this->db->select("m.*,i.job_id,u.name as user_name,a.name as assigned_to,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,l.status_type ", FALSE);
        if (!empty($s['inward_id']) && isset($s['inward_id'])) {
            $this->db->where("m.inward_id", $s['inward_id']);
        }
        if (!empty($s['date'])) {
            $this->db->where("DATE(m.created_on)", $s['date']);
        }
        $this->db->join("tbl_inwards i", "i.pk_id = m.inward_id");
        $this->db->join("tbl_job_status_list l", "l.name = m.status");
        $this->db->join("tbl_customers c", "i.customer_id = c.pk_id", 'LEFT');
        $this->db->join("tbl_users u", "u.user_id = m.user_id");
        $this->db->join("tbl_users a", "a.user_id = m.assigned_to", "LEFT");
        $this->db->order_by('m.pk_id DESC');
        $query = $this->db->get("tbl_inward_status m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    function getInwardHistoryByIdGroupByDate($s = [])
    {
        $this->db->select("DISTINCT(DATE(m.created_on)) as date,m.inward_id,i.job_id");
        if (!empty($s['inward_no']) && isset($s['inward_no'])) {
            $this->db->where("i.inward_no", $s['inward_no']);
        }
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where("i.branch_id", $s['branch_id']);
        }
        $this->db->join("tbl_inwards i", "i.pk_id = m.inward_id");
        $this->db->order_by('m.pk_id DESC');
        $query = $this->db->get("tbl_inward_status m");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    function getInwardLatestStatus($s = [])
    {
        $this->db->select("*");
        $this->db->where('status', $s['status']);
        $this->db->where('inward_id', $s['inward_id']);
        $query = $this->db->get("tbl_inward_status");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getStatusList()
    {
        $this->db->select("*");
        $this->db->where('is_active', 1);
        $query = $this->db->get("tbl_job_status_list");
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['name']] = $row['name'];
            }
            return $rows;
        }
        return false;
    }
    function addPayment($data)
    {
        if (!isset($data['created_on'])) {
            $date = date('Y-m-d H:i:s');
            $this->db->set("created_on", $date);
        }
        $this->db->insert("tbl_payments", $data);
        return $this->db->insert_id();
    }
    function getPaymentDetails($s = [])
    {
        $this->db->select("i.job_id,m.*,u.name as user_name");
        if (!empty($s['inward_id']) && isset($s['inward_id'])) {
            $this->db->where("i.inward_no", $s['inward_id']);
        }
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);
        }
        $this->db->join("tbl_inwards i", "i.pk_id = m.inward_id");
        $this->db->join("tbl_users u", "u.user_id = m.created_by");
        $this->db->order_by('m.pk_id DESC');
        $query = $this->db->get("tbl_payments m");
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    function addApprovalStatus($data)
    {
        $this->db->insert("tbl_inward_approvals", $data);
        return $this->db->insert_id();
    }
    function searchApprovals($s = [])
    {
        $this->db->select("m.inward_id,m.approved_date,m.approved_by,i.inward_no,i.job_id,u.name as approval_taken_by,i.status,c.first_name,c.last_name,i.created_on as inward_date");
        if (!empty($s['from_date'])) {
            $from = $s['from_date'];
            $to = $s['to_date'];
            $this->db->where("DATE(m.approved_date) BETWEEN '" . $from . "' AND '" . $to . "'");
        }
        if (!empty($s['today'])) {
            $this->db->where("DATE(m.approved_date)", $s['today']);
        }
        $this->db->where("i.branch_id", $_SESSION['BRANCH_ID']);
        $this->db->join("tbl_inwards i", "i.pk_id = m.inward_id", "LEFT");
        $this->db->join("tbl_users u", "u.user_id = m.approval_taken_by", "LEFT");
        $this->db->join("tbl_customers c", "c.pk_id = i.customer_id", "LEFT");
        $this->db->order_by('i.pk_id DESC');
        $query = $this->db->get("tbl_inward_approvals m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    function getInwardListNotInInvoice(){
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);;
        }else{
            $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        }
        $this->db->where("(m.invoice_id =0 OR m.invoice_id IS NULL)");
        $query = $this->db->get("tbl_inwards m");
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['pk_id']] = $row['job_id'];
            }
            return $rows;
        }
        return false;
    }
    function getBranchSequenceNumber($branch_id,$type)
    {
        $this->db->select("m.number");
        $this->db->where('m.branch_id', $branch_id);
        $this->db->where('m.action_type', $type);        
        $query = $this->db->get("tbl_number_sequence m");
        //echo $this->db->last_query(); exit();
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['number'];
        }
        return false;
    }
    function updateSequenceNumber($data, $pk_id,$type)
    {
        $this->db->where("branch_id", $pk_id);
        $this->db->where("action_type", $type);
        return $this->db->update("tbl_number_sequence", $data);
        //echo $this->db->last_query(); exit();
    }
}