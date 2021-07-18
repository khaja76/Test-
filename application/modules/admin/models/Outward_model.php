<?php
class Outward_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function searchOutwards($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        }else {
            $this->db->select("i.customer_id,i.job_id as inward_job_id,i.product,i.remarks as inward_remarks,i.description,i.serial_no,i.model_no,i.manufacturer_name,i.status as inward_status,i.gatepass_no,oc.challan,i.created_on as inward_date,m.*,m.created_on as outward_date,CONCAT_WS(' ',first_name,last_name) as customer_name",false);
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }

        if (!empty($s['outward_date'])) {
            $this->db->where("DATE(oc.created_on)", $s['outward_date']);
        }

        if (!empty($s['from_date'])) {
            $from = $s['from_date'];
            $to = $s['to_date'];
            $this->db->where("DATE(oc.created_on) BETWEEN '" . $from . "' AND '" . $to . "'");
        }

       
        $this->db->join("tbl_inwards i", "i.pk_id = m.inward_id");
        $this->db->join("tbl_customers c", "c.pk_id = i.customer_id");

        $this->db->join("tbl_outward_challans oc", "oc.pk_id = m.outward_challan_id", "LEFT");

        if (!empty($s['created_by']) && isset($s['created_by'])) {
            $this->db->where('m.created_by', $s['created_by']);
        }

        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);
        }

        if (!empty($s['outward_challan_id']) && isset($s['outward_challan_id'])) {
            $this->db->where("m.outward_challan_id", $s['outward_challan_id']);
        }
        $this->db->order_by("i.pk_id DESC");
        $query = $this->db->get("tbl_outwards m");
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
  
}