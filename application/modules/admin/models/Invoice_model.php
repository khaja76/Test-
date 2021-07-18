<?php
class Invoice_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function addInvoice($data)
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_invoices", $data);
        return $this->db->insert_id();
    }
    function addInvoiceHistory($data)
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_invoices_history", $data);
        return $this->db->insert_id();
    }
    function updateInvoice($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_invoices", $data);
    }
    function delInvoice($pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->delete("tbl_invoices");
    }
    // Invoice Items

    function addInvoiceJobs($data)
    {
        $this->db->insert("tbl_invoice_jobs", $data);
        return $this->db->insert_id();
    }
    function addInvoiceHistoryJobs($data)
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_invoices_history_jobs", $data);
        return $this->db->insert_id();
    }
    function updateInvoiceJobs($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_invoice_jobs", $data);
    }
    function delInvoiceJobs($pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->delete("tbl_invoice_jobs");
    }
    function deleteMultipleInvoiceJobs($s)
    {
        $this->db->where_in("pk_id", $s);
        return $this->db->delete("tbl_invoice_jobs");
    }
    function delInvoiceItemsByQId($pk_id)
    {
        $this->db->where("invoice_id", $pk_id);
        return $this->db->delete("tbl_invoice_jobs");
    }
    function getInvoiceJobs($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } 
        //else if (!isset($s['from_quote'])) {
            $this->db->select("ij.*,
            i.job_id as job,i.description,i.product,i.model_no,i.manufacturer_name,i.serial_no,i.remarks,i.gatepass_no,            
            oc.challan as outward_challan");
            //$this->db->select("qj.*,i.job_id,i.*,qj.net_amount,in.text_amount,ij.i_remarks");
        //}
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        $this->db->where('ij.invoice_id', $s['invoice_id']);
        //if (!isset($s['from_quote'])) {
            //$this->db->join("tbl_quotation_jobs qj", "qj.pk_id=ij.job_id");
            //$this->db->join("tbl_quotations q", "q.pk_id=qj.quotation_id");
            $this->db->join("tbl_inwards i", "i.pk_id=ij.job_id", "LEFT");
            $this->db->join("tbl_outwards o", "o.inward_id=i.pk_id", "LEFT");
            $this->db->join("tbl_outward_challans oc", "oc.pk_id=o.outward_challan_id", "LEFT");
            $this->db->where('i.branch_id', $s['branch_id']);
        //}
        $this->db->join("tbl_invoices in", "in.pk_id=ij.invoice_id", "LEFT");
        $this->db->order_by("ij.pk_id ASC");
        $query = $this->db->get("tbl_invoice_jobs ij");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }
    function getInvoicesList($s = [])
    {
        $this->db->select("m.*");
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where('m.branch_id', $s['branch_id']);
        } else {
            $this->db->where('m.branch_id', $_SESSION['BRANCH_ID']);
        }
        if (!empty($s['invoice']) && isset($s['invoice'])) {
            $this->db->where('m.invoice_id', 0);
        }
        if (!empty($s['invoice_id']) && isset($s['invoice_id'])) {
            $this->db->where('m.invoice_id', $s['invoice_id']);
        }
        $query = $this->db->get("tbl_invoices m");
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['pk_id']] = $row['quotation'];
            }
            return $rows;
        }
        return false;
    }
    function getBranchInvoices($branch_id)
    {
        $this->db->select("COUNT(1) as CNT");
        $this->db->where('m.branch_id', $branch_id);
        $query = $this->db->get("tbl_invoices m");
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['CNT'];
        }
        return false;
    }
    function getInvoiceById($pk_id, $branch_id)
    {
        $this->db->select("m.*,CONCAT_WS(' ', first_name,last_name) as customer_name", false);
        $this->db->where("m.pk_id", $pk_id);
        $this->db->join("tbl_customers c", "m.customer_id = c.pk_id", "LEFT");
        $this->db->where("m.branch_id", $branch_id);
        $this->db->join("tbl_branches b", "b.pk_id=m.branch_id", "LEFT");
        // echo $this->db->last_query();
        $query = $this->db->get("tbl_invoices m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function searchInvoices($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("CONCAT_WS(' ',first_name,last_name) as customer_name,c.customer_id as customer_number,m.*", false);//,p.pro_invoice
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where('m.branch_id', $s['branch_id']);
        }
        $this->db->join("tbl_customers c", "m.customer_id = c.pk_id", "LEFT");
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_invoices m");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }
    /*function searchInvoices($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("CONCAT_WS(' ',first_name,last_name) as customer_name,m.*,i.job_id,ij.amount", false);//,p.pro_invoice
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where('m.branch_id', $s['branch_id']);
        }
        $this->db->join("tbl_customers c", "m.customer_id = c.pk_id", "LEFT");
        $this->db->join("tbl_invoice_jobs ij", "ij.invoice_id = m.pk_id", "LEFT");
        //$this->db->join("tbl_quotation_jobs qj","qj.pk_id=ij.job_id");
        $this->db->join("tbl_inwards i", "i.pk_id = ij.job_id", "LEFT");
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_invoices m");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }*/
}