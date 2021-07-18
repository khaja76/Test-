<?php

class Payment_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function searchInwards($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,c.customer_id,c.pk_id as customer_pk_id,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,c.img_path as customer_path,c.img,u.name as created_by,a.name as assigned_to,ic.challan as inward_challan,oc.challan as outward_challan,m.outward_date", FALSE);
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
        } elseif (!empty($s['date'])) {
            $this->db->where("DATE(m.created_on)", $s['date']); //Need to change into payment done date
        }


        //Admin Reports

        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);;
        }
        if (!empty($s['location_id']) && isset($s['location_id'])) {
            $this->db->where("m.location_id", $s['location_id']);;
        }
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_inwards m");
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function getInwardById($pk_id)
    {
        $this->db->select("m.*,c.customer_id,c.pk_id as customer_pk_id,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,c.img_path as customer_path,c.img,u.name as assign_to,m.inward_challan_id,ic.challan as inward_challan,ic.created_on as challan_created_on,oc.challan as outward_challan,", FALSE);
        $this->db->join("tbl_customers c", "c.pk_id = m.customer_id", "LEFT");
        $this->db->join("tbl_users u", "u.user_id = m.assigned_to", "LEFT");
        $this->db->join("tbl_inward_challans ic", "ic.pk_id = m.inward_challan_id", "LEFT");
        $this->db->join("tbl_outward_challans oc", "oc.pk_id = m.outward_challan_id", "LEFT");
        $this->db->where("m.pk_id", $pk_id);
        $query = $this->db->get("tbl_inwards m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function getInwardByJobId($job_id, $branch_id = '')
    {
        $this->db->select("m.*,c.customer_id,c.pk_id as customer_pk_id,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,c.img_path as customer_path,c.img,u.name as assign_to,m.inward_challan_id,ic.challan as inward_challan,ic.created_on as challan_created_on,oc.challan as outward_challan,o.outward_images_path,o.remarks as outward_remarks", FALSE);
        $this->db->join("tbl_customers c", "c.pk_id = m.customer_id", "LEFT");
        $this->db->join("tbl_users u", "u.user_id = m.assigned_to", "LEFT");

        $this->db->join("tbl_inward_challans ic", "ic.pk_id = m.inward_challan_id", "LEFT");
        $this->db->join("tbl_outwards o", "o.inward_id = m.pk_id", "LEFT");


        $this->db->join("tbl_outward_challans oc", "oc.pk_id = m.outward_challan_id", "LEFT");
        if (!empty($_SESSION) && ($_SESSION['ROLE'] == "SUPER_ADMIN")) {
            $this->db->where("m.branch_id", $branch_id);
        } else {
            $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        }
        $this->db->where("(m.inward_no LIKE '%" . $job_id . "' OR m.job_id = '" . $job_id . "') ");
        $query = $this->db->get("tbl_inwards m");
        //echo $this->db->last_query();
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

    function getPaymentsList($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            if ($s['payment_type'] == 'job_id') {
                $this->db->select("m.pk_id,m.inward_no,m.job_id,m.paid_amt,m.invoice_id,
            CASE WHEN ij.final_amount !=0 THEN ij.final_amount ELSE m.estimation_amt END AS estimation_amt", FALSE);
            } else {
                $this->db->select("m.pk_id,m.final_amount,m.paid_amt,m.invoice");
            }
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        if ($s['payment_type'] == 'job_id') {
            $this->db->join("tbl_invoices i", "i.pk_id = m.invoice_id", "LEFT");
            $this->db->join("tbl_invoice_jobs ij", "ij.invoice_id = i.pk_id", "LEFT");

            if (isset($s['paid'])) {
                if ($s['paid']) {
                    $this->db->where("m.paid_amt =estimation_amt");
                } else {
                    $this->db->where("m.paid_amt < estimation_amt");
                }
            }
            if (!empty($s['branch_id']) && isset($s['branch_id'])) {
                $this->db->where("m.branch_id", $s['branch_id']);;
            }
            if (!empty($s['location_id']) && isset($s['location_id'])) {
                $this->db->where("m.location_id", $s['location_id']);;
            }
            $this->db->where("m.estimation_amt !=0");
        }else {
            if (isset($s['paid'])) {
                if ($s['paid']) {
                    $this->db->where("m.paid_amt = m.final_amount");
                } else {
                    $this->db->where("m.paid_amt < m.final_amount");
                }
            }
            $this->db->where("m.final_amount > 0");
        }
        if($mode != "CNT") {
            $this->db->group_by("m.pk_id");
            $this->db->order_by("m.pk_id DESC");
        }
        if ($s['payment_type'] == 'job_id') {
            $query = $this->db->get("tbl_inwards m");
        }else{
            $query = $this->db->get("tbl_invoices m");
        }
//        echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function getPaymentInvoiceById($invoiceId){
        $this->db->select("*");
        $this->db->where("pk_id",$invoiceId);
        $query = $this->db->get("tbl_invoices");
        if($query->num_rows()>0){
            return $query->row_array();
        }
        return false;
    }

    function updateInvoice($pData,$invoiceId){
        $this->db->where("pk_id", $invoiceId);
        return $this->db->update("tbl_invoices", $pData);
    }

    function addInvoicePayment($pData){
        if (!isset($data['created_on'])) {
            $date = date('Y-m-d H:i:s');
            $this->db->set("created_on", $date);
        }
        $this->db->insert("tbl_invoice_transactions", $pData);
        return $this->db->insert_id();
    }

    function getPaymentsByInvoice($invoiceId){
        $this->db->select("m.*,u.name as user_name");
        $this->db->join("tbl_users u", "u.user_id = m.created_by");
        $this->db->where("m.invoice_id",$invoiceId);
        $this->db->order_by('m.id DESC');
        $query = $this->db->get("tbl_invoice_transactions m");
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
}