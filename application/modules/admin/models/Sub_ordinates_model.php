<?php

class Sub_ordinates_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function addUser($data)
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_users", $data);
        $qdata = [];
        $qdata['user_id'] = $this->db->insert_id();
        $qdata['location_id'] = $data['location_id'];
        $qdata['branch_id'] = $data['branch_id'];
        $qdata['role'] = $data['role'];
        $qdata['is_active'] = ($data['status'] == "ACTIVE") ? 1 : 0;
        $qdata['created_by'] = $_SESSION['USER_ID'];
        $this->addBranchUser($qdata);

        return $qdata['user_id'];
    }

    function addBranchUser($data)
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_branch_users", $data);
        $pk_id = $this->db->insert_id();
        $this->updateUser(['branch_pk_id' => $pk_id], $data['user_id']);
    }

    function addUserDocuments($data)
    {
        $this->db->select("*");
        $this->db->where("user_id", $data['user_id']);
        $query = $this->db->get("tbl_user_documents");
        if ($query->num_rows() > 0) {
            $this->updateUserDocuments($data, $data['user_id']);
        }else{
            if (!isset($data['created_on'])) {
                $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
            }
            $this->db->insert("tbl_user_documents", $data);
        }
    }

    function updateUserDocuments($data, $user_id)
    {
        $this->db->where("user_id", $user_id);
        return $this->db->update("tbl_user_documents", $data);
    }

    function updateUser($data, $user_id)
    {
        $this->db->where("user_id", $user_id);
        return $this->db->update("tbl_users", $data);
    }

    function updateBranchUser($data, $user_id)
    {
        $this->db->where("pk_id", $user_id);
        if (!isset($data['updated_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("updated_on",$date);
        }
        return $this->db->update("tbl_branch_users", $data);
    }

    function delUser($user_id)
    {
        $this->db->where("user_id", $user_id);
        return $this->db->delete("tbl_users");
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
        if (!empty($s['location_id']) && isset($s['location_id'])) {
            $this->db->where("m.location_id", $s['location_id']);
        }
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);
        }
        $this->db->join("tbl_locations l","l.pk_id = m.location_id");
        $this->db->join("tbl_branches b","b.pk_id = m.branch_id");
        if ($_SESSION['ROLE'] == "SUPER_ADMIN") {
            $this->db->where_not_in("m.role", "SUPER_ADMIN");
            $this->db->where_in("m.role", "ADMIN");
        } elseif ($_SESSION['ROLE'] == "ADMIN") {
            $this->db->where("m.role IN ('ENGINEER','RECEPTIONIST')");
            $this->db->where("m.location_id", $_SESSION['LOCATION_ID']);
            $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        } else {
            $this->db->where("m.role", $s['role']);
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

    function getUsersList($s=[])
    {
        $this->db->select("m.*");
        if(!empty($s['role']) && isset($s['role'])){
            $this->db->where("m.role", $s['role']);
        }
        if(!empty($s['branch_id']) && isset($s['branch_id'])){
            $this->db->where("m.branch_id", $s['branch_id']);
        }
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

    function checkRole($role, $user_id = '')
    {
        $this->db->select("m.*");
        $this->db->where("role", $role);
        if (!empty($user_id)) {
            $this->db->where("user_id !=", $user_id);
        }
        $query = $this->db->get("tbl_users m");
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }

    function getUserById($user_id)
    {
        $this->db->select("m.*");
        $this->db->where("m.user_id", $user_id);
        $query = $this->db->get("tbl_users m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
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
        $query = $this->db->get("tbl_branch_users m");
        if ($query->num_rows() > 0) {
            return true;
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

    function getReceptionActivities($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,t.type,t.title,u.name as user_name,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,b.name as branch_name,
            i.job_id as inward_job_id,ic.challan as inward_challan,o.job_id as outward_job_id, oc.challan as outward_challan,
            p.product_name,p.model_no as product_model_no,p.serial_no as product_serial_no,
            tc.component_name,tc.model_no as component_model_no",false);
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        if (!empty($s['date'])) {
            $this->db->where("DATE(m.created_on)", $s['date']);
        }
        if (!empty($s['from_date'])) {
            $from = $s['from_date'];
            $to = $s['to_date'];
            $this->db->where("DATE(m.created_on) BETWEEN '" . $from . "' AND '" . $to . "'");
        }
        $this->db->join("tbl_reception_activity_types t","t.pk_id = m.type_id","LEFT");
        $this->db->join("tbl_users u","u.user_id = m.user_id","LEFT");
        $this->db->join("tbl_customers c","c.pk_id = m.customer_id","LEFT");
        $this->db->join("tbl_branches b","b.pk_id = m.branch_id","LEFT");
        $this->db->join("tbl_inwards i","i.pk_id = m.inward_id","LEFT");
        $this->db->join("tbl_outwards o","o.pk_id = m.outward_id","LEFT");
        $this->db->join("tbl_inward_challans ic","ic.pk_id = m.inward_challan_id","LEFT");
        $this->db->join("tbl_outward_challans oc","oc.pk_id = m.outward_challan_id","LEFT");
        $this->db->join("tbl_products p","p.pk_id = m.product_id","LEFT");
        $this->db->join("tbl_components tc","tc.pk_id = m.component_id","LEFT");
        $this->db->where("m.user_id",$s['sub_ordinates']);
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_reception_activities m");

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