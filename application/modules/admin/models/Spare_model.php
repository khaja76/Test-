<?php

class Spare_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function addSpareRequest($data)
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_spare_requests", $data);
        return $this->db->insert_id();
    }

    function updateSpareRequest($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_spare_requests", $data);
    }

    function delSpareRequest($pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->delete("tbl_spare_requests");
    }

    function searchApprovedSparesCnt()
    {
        $this->db->select("COUNT(1) as CNT");
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where('m.branch_id', $s['branch_id']);
        } else {
            $this->db->where('m.branch_id', $_SESSION['BRANCH_ID']);
        }
        $this->db->where('m.created_by', $_SESSION['USER_ID']);
        $this->db->where('i.is_outwarded', 'NO');
        $this->db->where("m.request_status = 'GRANTED'");
        $this->db->join("tbl_users u", "u.user_id=m.created_by");
        $this->db->join("tbl_inwards i", "i.pk_id=m.job_id");
        $this->db->join("tbl_customers c", "c.pk_id=i.customer_id", 'LEFT');
        $this->db->join("tbl_components co", "co.pk_id=m.supplied_component_id", "LEFT");
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_spare_requests m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['CNT'];
        }
        return false;
    }

    function searchSpareRequests($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,u.name as user_name,co.component_name as supplied_component_name,m.job_id as inward_id,i.is_outwarded,i.inward_no,i.job_id,i.status,i.created_on as inward_date,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,i.is_outwarded", false);
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where('m.branch_id', $s['branch_id']);
        }
        if (!empty($s['location_id']) && isset($s['location_id'])) {
            $this->db->where('m.location_id', $s['location_id']);
            $this->db->join("tbl_locations l", "l.pk_id=m.location_id", "LEFT");
        }
        if (!empty($s['created_by']) && isset($s['created_by'])) {
            $this->db->where('m.created_by', $s['created_by']);
        }
        if (!empty($s['is_outwarded']) && isset($s['is_outwarded'])) {
            $this->db->where('i.is_outwarded', $s['is_outwarded']);
        }
        if (!empty($s['from_date'])) {
            $from = $s['from_date'];
            $to = $s['to_date'];
            $this->db->where("DATE(m.created_on) BETWEEN '" . $from . "' AND '" . $to . "'");
        }
        if (!empty($s['date']) && isset($s['date'])) {
            $this->db->where("DATE(m.created_on)", $s['date']);
        }
        if (!empty($s['pending']) && isset($s['pending'])) {
            //$this->db->where("m.quantity != m.supplied_quantity");
            $this->db->where("m.request_status != 'REJECTED'");
            $this->db->where("m.request_status != 'RECEIVED'");
        }
        $this->db->join("tbl_users u", "u.user_id=m.created_by");
        $this->db->join("tbl_inwards i", "i.pk_id=m.job_id");
        $this->db->join("tbl_customers c", "c.pk_id=i.customer_id", 'LEFT');
        $this->db->join("tbl_components co", "co.pk_id=m.supplied_component_id", "LEFT");
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_spare_requests m");
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

    function getSpareRequestById($pk_id)
    {
        $this->db->select("m.*,u.name as user_name,co.component_name as supplied_component_name,m.job_id as inward_id,i.is_outwarded,i.inward_no,i.job_id,i.status,i.created_on as inward_date,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name", false);
        $this->db->join("tbl_users u", "u.user_id=m.created_by");
        $this->db->join("tbl_inwards i", "i.pk_id=m.job_id");
        $this->db->join("tbl_customers c", "c.pk_id=i.customer_id");
        $this->db->join("tbl_components co", "co.pk_id=m.supplied_component_id", "LEFT");
        $this->db->where("m.pk_id", $pk_id);
        $query = $this->db->get("tbl_spare_requests m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function addRequiredComponent($data)
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_required_components", $data);
        return $this->db->insert_id();
    }

    function searchRequiredComponents($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,i.job_id,i.inward_no,u.name as user_name");
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where('m.branch_id', $s['branch_id']);
        }
        if (!empty($s['location_id']) && isset($s['location_id'])) {
            $this->db->where('m.location_id', $s['location_id']);
        }
        if (!empty($_SESSION['BRANCH_ID']) && ($_SESSION['ROLE'] != 'SUPER_ADMIN')) {
            $this->db->where('m.branch_id', $_SESSION['BRANCH_ID']);
        }
        if (!empty($_SESSION['LOCATION_ID']) && ($_SESSION['ROLE'] != 'SUPER_ADMIN')) {
            $this->db->where('m.location_id', $_SESSION['LOCATION_ID']);
        }
        if (!empty($s['from_date'])) {
            $from = $s['from_date'];
            $to = $s['to_date'];
            $this->db->where("DATE(m.created_on) BETWEEN '" . $from . "' AND '" . $to . "'");
        }
        if (!empty($s['date']) && isset($s['date'])) {
            $this->db->where("DATE(m.created_on)", $s['date']);
        }
        $this->db->join("tbl_users u", "u.user_id = m.created_by");
        $this->db->join("tbl_spare_requests s", "s.pk_id = m.spare_id");
        $this->db->join("tbl_inwards i", "i.pk_id = s.job_id");
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_required_components m");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function delRequiredComponent($pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->delete("tbl_required_components");
    }

    function getSpareRequestHistory($s = [])
    {
        $this->db->select("m.*,u.name as created_by,c.component_name,c.model_no");
        if (!empty($s['spare_id']) && isset($s['spare_id'])) {
            $this->db->where("m.spare_id", $s['spare_id']);
        }
        if (!empty($_SESSION['BRANCH_ID']) && ($_SESSION['ROLE'] != 'SUPER_ADMIN')) {
            $this->db->where('m.branch_id', $_SESSION['BRANCH_ID']);
        }
        if (!empty($_SESSION['LOCATION_ID']) && ($_SESSION['ROLE'] != 'SUPER_ADMIN')) {
            $this->db->where('m.location_id', $_SESSION['LOCATION_ID']);
        }
        $this->db->join("tbl_users u", "u.user_id = m.created_by");
        $this->db->join("tbl_components c", "c.pk_id = m.component_id");
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_component_stock m");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
}