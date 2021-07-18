<?php

class Inward_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getInwardByJobId($job_id)
    {
        $this->db->select("m.*,c.customer_id,c.pk_id as customer_pk_id,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,c.img_path as customer_path,c.img,q.company_name,q.company_mail,q.phone as company_mobile,q.contact_name,u.name as assign_to,m.inward_challan_id,ic.challan as inward_challan,ic.created_on as challan_created_on,oc.challan as outward_challan,o.outward_images_path,o.remarks as outward_remarks,usr.name as created_by", FALSE);
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

            $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);

        //$this->db->where("(m.inward_no = '" . $job_id . "' OR m.pk_id = '" . $job_id . "') ");
        $this->db->where("m.inward_no" , $job_id);
        
        $this->db->where("m.assigned_to" , $_SESSION['USER_ID']);

        $query = $this->db->get("tbl_inwards m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function searchInwards($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,c.customer_id,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,c.img_path as customer_path,c.img,u.name as created_by,s.created_on as updated_on", FALSE);
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }

        $this->db->join("tbl_customers c", "c.pk_id = m.customer_id", "LEFT");
        $this->db->join("tbl_users u", "u.user_id = m.created_by", "LEFT");
        if (!empty($s['date'])) {
            $this->db->where("DATE(s.created_on)", $s['date']);
        }
        if (!empty($s['from_date'])) {
            $from = $s['from_date'];
            $to = $s['to_date'];
            $this->db->where("DATE(s.created_on) BETWEEN '" . $from . "' AND '" . $to . "'");
        }
        if(!empty($s['status'])){
            $this->db->where("m.status",$s['status']);
        }

        $this->db->join("tbl_inward_status s", "s.inward_id = m.pk_id AND s.assigned_to = " . $s['assigned_to'], "LEFT");
        $this->db->where("m.branch_id", $s['branch_id']);
        $this->db->where("m.assigned_to", $s['assigned_to']);
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_inwards m");
        //echo '<br/>'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function updateInward($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_inwards", $data);
    }

    function addInwardStatus($data)
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_inward_status", $data);
        return $this->db->insert_id();
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

    function getInwardHistoryById($s = [], $date = '')
    {
        $this->db->select("m.*,i.job_id,u.name as user_name,a.name as assigned_to,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,l.status_type ", FALSE);
        if (!empty($s['inward_no']) && isset($s['inward_no'])) {
            $this->db->where("i.inward_no", $s['inward_no']);
        }
        if (!empty($s['job_id']) && isset($s['job_id'])) {
            $this->db->where("m.job_id", $s['job_id']);
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

    function getInwardsList($s = [])
    {
        $this->db->select("m.*");
        $this->db->where("m.assigned_to", $_SESSION['USER_ID']);
        $this->db->order_by('m.pk_id DESC');
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


    function getCustomerById($user_id)
    {
        $this->db->select("m.*");
        $this->db->where("m.pk_id", $user_id);
        $query = $this->db->get("tbl_customers m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
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
        $this->db->join("tbl_customers c", "i.customer_id = c.pk_id",'LEFT');
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

}