<?php

class Engineer_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getUserById($user_id)
    {

        $this->db->select("l.location_name,l.pk_id as location_id,b.pk_id as branch_id,b.name as branch_name,d.*,d.user_id as doc_user_id,m.*,s.state_name");
        $this->db->join("tbl_locations l", "l.pk_id = m.location_id");
        $this->db->join("tbl_branches b", "b.pk_id = m.branch_id");
        $this->db->join("tbl_user_documents d", "d.user_id = m.user_id", "LEFT");
        $this->db->join("tbl_states s", "s.state_code=m.state", "LEFT");
        $this->db->where("m.user_id", $user_id);
        $query = $this->db->get("tbl_users m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function updateUser($data, $user_id)
    {
        $this->db->where("user_id", $user_id);
        return $this->db->update("tbl_users", $data);

    }

    function searchLatestAssignedInwards($s = [], $mode = 'DATA')
    {
        $branch_id = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,m.remarks as admin_remarks,i.*,m.created_on as assigned_on,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name", FALSE);
            $this->db->group_by("m.inward_id ");
        }

        if (isset($s['status'])) {
            $this->db->where('m.status', $s['status']);
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }

        $this->db->join("tbl_inwards i", "i.pk_id = m.inward_id", "LEFT");
        $this->db->join("tbl_customers c", "c.pk_id = i.customer_id", "LEFT");
        if (isset($s['date'])) {
            $this->db->where("DATE(m.created_on)", $s['date']);
        }        
        $this->db->where("m.assigned_to" , $_SESSION['USER_ID']);
        $this->db->where("i.branch_id", $branch_id);
        $this->db->order_by("m.pk_id DESC ");
        $query = $this->db->get("tbl_inward_status m");
        if (isset($s['date']) && ($mode != "CNT")) {
            //echo '<br/>'.$this->db->last_query();
        }
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function searchInwards($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,c.customer_id,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,c.img_path as customer_path,c.img,u.name as created_by,a.name as assigned_to", FALSE);
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }

        $this->db->join("tbl_customers c", "c.pk_id = m.customer_id", "LEFT");
        $this->db->join("tbl_users u", "u.user_id = m.created_by", "LEFT");
        $this->db->join("tbl_users a", "a.user_id = m.assigned_to", "LEFT");
        if (!empty($s['date'])) {
            $this->db->where("DATE(m.created_on)", $s['date']);

        }
        if (!empty($s['from_date'])) {
            $from = $s['from_date'];
            $to = $s['to_date'];
            $this->db->where("DATE(m.created_on) BETWEEN '" . $from . "' AND '" . $to . "'");
        }
        if (!empty($s['status'])) {
            $this->db->where('m.status', $s['status']);
        }
        if (!empty($s['created_by']) && isset($s['created_by'])) {
            $this->db->where('m.created_by', $s['created_by']);
        }
        if (!empty($s['customer_id']) && isset($s['customer_id'])) {
            $this->db->where('m.customer_id', $s['customer_id']);
        }
        if (!empty($s['assigned_to']) && isset($s['assigned_to'])) {
            $this->db->where('m.assigned_to', $s['assigned_to']);
        }
        //$this->db->join("tbl_inward_status s", "s.inward_id = m.pk_id", "LEFT");
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);;
        }
        $this->db->order_by("m.pk_id DESC");
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

    //Messages---send to users list
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

    function searchStatus($s = [], $mode = "DATA")
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
        if (isset($s['status']) && !empty($s['status'])) {
            if ($s['status'] == 'OUTWARD') {
                $this->db->where("(m.status = 'OUTWARD' OR m.status = 'DELIVERED') ");
            } else if ($s['status'] == 'OTHERS') {
                $this->db->where("(m.status = 'OTHERS' OR m.status = 'ADDED' OR m.status = 'PAUSED') ");
            } else {
                $this->db->where('m.status', $s['status']);
            }

        }
        if (isset($s['branch_id']) && !empty($s['branch_id'])) {
            $this->db->where('m.branch_id', $s['branch_id']);
        } else {
            $this->db->where('m.branch_id', $_SESSION['BRANCH_ID']);
        }
        if (!isset($s['req'])) {
            $this->db->where("(m.outward_challan_id = 0 OR m.outward_challan_id IS NULL) AND m.is_outwarded = 'NO'");
        }
        $this->db->where("m.assigned_to = '" . $_SESSION['USER_ID'] . "'");
        $query = $this->db->get("tbl_inwards m");
        //if ($s['status'] == 'OTHERS') {
        //echo '<br/>'.$this->db->last_query();
        //exit();
        //}
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function getInwardLatestStatus($s = [])
    {
        $this->db->select("*");
        $this->db->where('status', $s['status']);
        $this->db->where('inward_id', $s['inward_id']);
        $this->db->order_by("pk_id DESC");
        $query = $this->db->get("tbl_inward_status");

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function searchComponents($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.pk_id as component_id,m.component_name ");
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        if(!empty($_SESSION['BRANCH_ID']) && ($_SESSION['ROLE'] != 'SUPER_ADMIN')){
            $this->db->where('m.branch_id', $_SESSION['BRANCH_ID']);
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

    function getBranchAdmin($branch_id)
    {
        $this->db->select("u.*");
        $this->db->where("m.branch_id", $branch_id);
        $this->db->join('tbl_users u', 'u.user_id = m.user_id');
        $this->db->where("m.is_active", 1);
        $this->db->where("m.role", "ADMIN");
        $query = $this->db->get("tbl_branch_users m");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    function getUserDocumentsByUser($user_id)
    {
        $this->db->select("d.*");
        $this->db->where("d.is_active", 1);
        $this->db->where("d.user_id", $user_id);
        $query = $this->db->get("tbl_user_documents d");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    function getApprovalStatus($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.inward_id,m.approved_date,m.approved_by,i.inward_no,i.job_id,u.name as approval_taken_by,i.status,c.first_name,c.last_name,i.created_on as inward_date,i.pk_id,i.is_outwarded");
        }
        if (!empty($s['from_date'])) {
            $from = $s['from_date'];
            $to = $s['to_date'];
            $this->db->where("DATE(m.approved_date) BETWEEN '" . $from . "' AND '" . $to . "'");
        }

        if (!empty($s['today'])) {
            $this->db->where("DATE(m.approved_date)", $s['today']);
        }
        $this->db->where("i.assigned_to", $_SESSION['USER_ID']);
        $this->db->join("tbl_inwards i", "i.pk_id = m.inward_id", "LEFT");
        $this->db->join("tbl_users u", "u.user_id = m.approval_taken_by", "LEFT");
        $this->db->join("tbl_customers c", "c.pk_id = i.customer_id", "LEFT");
        if (isset($s['branch_id']) && !empty($s['branch_id'])) {
            $this->db->where('i.branch_id', $s['branch_id']);
        } else {
            $this->db->join("tbl_locations l", "l.pk_id=i.location_id", "LEFT");
            $this->db->where('i.branch_id', $_SESSION['BRANCH_ID']);
            $this->db->where('c.branch_id', $_SESSION['BRANCH_ID']);
        }
        $this->db->order_by('i.pk_id DESC');
        $query = $this->db->get("tbl_inward_approvals m");
        //echo $this->db->last_query();
        //exit();
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