<?php

class Proforma_model extends CI_Model

{
    function __construct()
    {
        parent::__construct();
    }
    function addProforma($data)
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_proforma_invoices", $data);
        return $this->db->insert_id();
    }
    function addProformaHistory($data)
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_proforma_history", $data);
        return $this->db->insert_id();
    }
    function updateProforma($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_proforma_invoices", $data);
    }
    function delProforma($pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->delete("tbl_proforma_invoices");
    }
    // Proforma Items

    function addProformaJobs($data)
    {
        $this->db->insert("tbl_proforma_invoice_jobs", $data);
        return $this->db->insert_id();
    }
    function addProformaHistoryJobs($data)
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_proforma_history_jobs", $data);
        return $this->db->insert_id();
    }
    function updateProformaJobs($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_proforma_invoice_jobs", $data);
    }
    function delProformaJobs($pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->delete("tbl_proforma_invoice_jobs");
    }
    function deleteMultipleProformaJobs($s)
    {
        $this->db->where_in("pk_id", $s);
        return $this->db->delete("tbl_proforma_invoice_jobs");
    }
    function delProformaItemsByQId($pk_id)
    {
        $this->db->where("proforma_id", $pk_id);
        return $this->db->delete("tbl_proforma_invoice_jobs");
    }
    function getProformaJobs($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("qj.*,pj.*,qj.pk_id as quotation_job_id,pj.pk_id as proforma_job_id,i.job_id as job,i.description,i.product,i.model_no,i.manufacturer_name,i.serial_no,i.remarks,i.gatepass_no,qj.amount,oc.challan as outward_challan,pj.pi_remarks");
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }        
        if(isset($s['is_invoiced']) && $s['is_invoiced']=='NO'){
            $this->db->where("qj.invoice_job_id =0");    
        }
        $this->db->where("pj.proforma_id", $s['proforma_id']);
        // $this->db->where("pi.branch_id", $s['proforma_id']);
        //   $this->db->join("tbl_proforma_invoices pi","pi.pk_id=pj.proforma_id");
        $this->db->join("tbl_quotation_jobs qj", "qj.pk_id=pj.quotation_job_id");
        $this->db->join("tbl_inwards i", "i.pk_id=qj.job_id");
        $this->db->join("tbl_outwards o", "o.inward_id=i.pk_id", "LEFT");
        $this->db->join("tbl_outward_challans oc", "oc.pk_id=o.outward_challan_id", "LEFT");
        $this->db->order_by("pj.pk_id ASC");
        $query = $this->db->get("tbl_proforma_invoice_jobs pj");
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
    function getProformasList($s = [])
    {
        $this->db->select("m.*");
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where('m.branch_id', $s['branch_id']);
        } else {
            $this->db->where('m.branch_id', $_SESSION['BRANCH_ID']);
        }
        if (!empty($s['proforma']) && isset($s['proforma'])) {
            $this->db->where('m.proforma_id', 0);
        }
        if (!empty($s['proforma_id']) && isset($s['proforma_id'])) {
            $this->db->where('m.proforma_id', $s['proforma_id']);
        }
        $query = $this->db->get("tbl_proforma_invoices m");
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['pk_id']] = $row['proforma'];
            }
            return $rows;
        }
        return false;
    }
    function getBranchProformas($branch_id)
    {
        $this->db->select("COUNT(1) as CNT");
        $this->db->where('m.branch_id', $branch_id);
        $query = $this->db->get("tbl_proforma_invoices m");
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['CNT'];
        }
        return false;
    }
    function getProformaById($pk_id, $branch_id = '')
    {
        $this->db->select("m.*,CONCAT_WS(' ', first_name,last_name) as customer_name", false);
        $this->db->where("m.pk_id", $pk_id);
        $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        $this->db->join("tbl_customers c", "m.customer_id = c.pk_id", "LEFT");
        $query = $this->db->get("tbl_proforma_invoices m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getProformaJobById($pk_id, $branch_id = '')
    {
        $this->db->select("m.*", false);
        $this->db->where("m.pk_id", $pk_id);
        $query = $this->db->get("tbl_proforma_invoice_jobs m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function searchProformas($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("CONCAT_WS(' ',first_name,last_name) as customer_name,c.customer_id as customer_number,m.*", false);
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
        $query = $this->db->get("tbl_proforma_invoices m");
        //$this->db->last_query();
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function getProformaListNotInInvoice($s=[]){
        $this->db->select("m.*");
        if(!empty($s['branch_id']) && isset($s['branch_id'])){
            $this->db->where('m.branch_id',$s['branch_id']);
        }else{
            $this->db->where('m.branch_id',$_SESSION['BRANCH_ID']);
        }
        $branch_id = !empty($s['branch_id']) ? $s['branch_id'] : $_SESSION['BRANCH_ID'];                              
        $this->db->join("tbl_proforma_invoice_jobs pi","pi.proforma_id=m.pk_id");        
        $this->db->join("tbl_quotation_jobs qj","qj.pk_id=pi.quotation_job_id"); 
        $this->db->where('qj.pk_id NOT IN (SELECT `job_id` FROM `tbl_invoice_jobs` WHERE `invoice_id` IN (SELECT `pk_id` FROM tbl_invoices WHERE `branch_id`='.$branch_id.'))');        
        $query = $this->db->get("tbl_proforma_invoices m");                              
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['pk_id']] = $row['proforma'];
            }
            return $rows;
        }
        return false;
    }
}