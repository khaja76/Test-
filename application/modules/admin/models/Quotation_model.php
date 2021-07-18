<?php
class Quotation_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function addQuotation($data)
    {
        if (!isset($data['created_on'])) {
            $this->db->set("created_on", "NOW()", false);
        }
        $this->db->insert("tbl_quotations", $data);
        return $this->db->insert_id();
    }
    function addQuotationHistory($data) {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_quotations_history", $data);
        return $this->db->insert_id();
    }

    function updateQuotation($data,$pk_id) {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_quotations", $data);
    }

    function delQuotation($pk_id) {
        $this->db->where("pk_id", $pk_id);
        return $this->db->delete("tbl_quotations");
    }

    function searchQuotations($s = [], $mode = "DATA") {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("CONCAT_WS(' ',first_name,last_name) as customer_name,c.customer_id as customer_number,m.*",false);//,p.pro_invoice
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
     
        if(!empty($s['branch_id']) && isset($s['branch_id'])){
            $this->db->where('m.branch_id',$s['branch_id']);
        }
        //$this->db->join("tbl_quotation_jobs j","j.quotation_id = m.pk_id","LEFT");
        //$this->db->join("tbl_inwards i"," `i`.`pk_id`=`j`.`job_id`","LEFT",false);
        $this->db->join("tbl_customers c","m.customer_id = c.pk_id","LEFT");
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_quotations m");
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

    function getQuotationDetails($s = []) {
        $this->db->select("m.*,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name");//,p.proforma_no
        if(!empty($s['pk_id'])){
            $this->db->where("m.pk_id", $s['pk_id']);
        }
        if(!empty($s['quotation_no'])){
            $this->db->where("m.quotation_no", $s['quotation_no']);
        }
        if(!empty($s['branch_id']) && isset($s['branch_id'])){
            $this->db->where('m.branch_id',$s['branch_id']);
        }else{
            $this->db->where('m.branch_id',$_SESSION['BRANCH_ID']);
        }
        $this->db->join("tbl_customers c","m.customer_id = c.pk_id","LEFT");
    
        $query = $this->db->get("tbl_quotations m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function getQuotationById($pk_id)
    {
        $this->db->select("m.*,CONCAT_WS(' ', first_name,last_name) as customer_name", false);
        $this->db->where("m.pk_id", $pk_id);
        $this->db->join("tbl_customers c", "m.customer_id = c.pk_id", "LEFT");
        $query = $this->db->get("tbl_quotations m");
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function getBranchQuotations($branch_id){
        $this->db->select("COUNT(1) as CNT");
        $this->db->where('m.branch_id',$branch_id);
        $query = $this->db->get("tbl_quotations m");
        if ($query->num_rows() > 0) {
            $row =  $query->row_array();
            return $row['CNT'];
        }
        return false;
    }
    // Quotation Items
    function addQuotationJobs($data) {
        $this->db->insert("tbl_quotation_jobs", $data);
        return $this->db->insert_id();
    }
    function addQuotationHistoryJobs($data) {
        $this->db->insert("tbl_quotation_history_jobs", $data);
        return $this->db->insert_id();
    }
    function updateQuotationJobs($data,$pk_id) {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_quotation_jobs", $data);
    }
    function delQuotationJobs($pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->delete("tbl_quotation_jobs");
    }
    function deleteMultipleQuotationJobs($s)
    {
        $this->db->where_in("pk_id", $s);
        return $this->db->delete("tbl_quotation_jobs");
    }


    function delQuotationItemsByQId($pk_id)
    {
        $this->db->where("quotation_id", $pk_id);
        return $this->db->delete("tbl_quotation_jobs");
    }

    function getQuotationJobs($s = [], $mode = "DATA") {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,m.pk_id as quotation_job_id,m.remarks as quotation_remarks,i.job_id as job,i.description,i.product,i.model_no,i.manufacturer_name,i.serial_no,i.remarks,i.gatepass_no,oc.challan as outward_challan,i.status as status");
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        if(isset($s['is_quote']) && !empty($s['is_quote'])){
            $this->db->where("m.proforma_job_id =0");    
        }
        if(isset($s['is_invoiced']) && $s['is_invoiced']=='NO'){
            $this->db->where("m.invoice_job_id =0");    
        }
        $this->db->where("m.quotation_id", $s['quotation_id']);
        $this->db->join("tbl_inwards i","i.pk_id=m.job_id");    
        $this->db->join('tbl_outwards o','o.inward_id=i.pk_id',"LEFT");
        $this->db->join('tbl_outward_challans oc','oc.pk_id=o.outward_challan_id',"LEFT"); 
       
        $this->db->order_by("m.pk_id ASC");
        $query = $this->db->get("tbl_quotation_jobs m");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function getQuotationsList($s=[]){
        $this->db->select("m.*");

        if(!empty($s['branch_id']) && isset($s['branch_id'])){
            $this->db->where('m.branch_id',$s['branch_id']);
        }else{
            $this->db->where('m.branch_id',$_SESSION['BRANCH_ID']);
        }
        if(!empty($s['proforma']) && isset($s['proforma'])){
            $this->db->where('m.proforma_id',0);
        }
        if(!empty($s['proforma_id']) && isset($s['proforma_id'])){
            $this->db->where('m.proforma_id',$s['proforma_id']);
        }
        $query = $this->db->get("tbl_quotations m");        
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['pk_id']] = $row['quotation'];
            }
            return $rows;
        }
        return false;
    }

    function getQuotationHistoryById($pk_id)
    {
        $this->db->select("m.*,CONCAT_WS(' ', c.first_name,c.last_name) as customer_name", false);
        $this->db->where("m.pk_id", $pk_id);
        $this->db->join("tbl_customers c", "m.customer_id = c.pk_id", "LEFT");
        $query = $this->db->get("tbl_quotations_history m");

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getQuotationJobById($qj_pk_id){
        $this->db->select("m.*", false);
        $this->db->where("m.pk_id", $qj_pk_id);
        $query = $this->db->get("tbl_quotation_jobs m");

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getQuotationHistoryJobs($s = [], $mode = "DATA") {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,m.remarks as quotation_remarks,i.job_id as job,i.description,i.product,i.model_no,i.manufacturer_name,i.serial_no,i.remarks");
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        $this->db->where("m.history_id", $s['history_id']);
        $this->db->join("tbl_inwards i","i.pk_id=m.job_id");
        $this->db->order_by("m.pk_id ASC");
        $query = $this->db->get("tbl_quotation_history_jobs m");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function searchQuotationHistories($s = [], $mode = "DATA") {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,m.*",false);//,p.pro_invoice
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
       
        if(!empty($s['branch_id']) && isset($s['branch_id'])){
            $this->db->where('m.branch_id',$s['branch_id']);
        }
        if(!empty($s['quotation_id']) && isset($s['quotation_id'])){
            $this->db->where('m.quotation_id',$s['quotation_id']);
        }
        //$this->db->join("tbl_proforma_invoices p","m.proforma_id = p.pk_id","LEFT");
        $this->db->join("tbl_customers c","m.customer_id = c.pk_id","LEFT");
        $this->db->join("tbl_quotations q","m.quotation_id = q.pk_id");
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_quotations_history m");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function getQuotationsListForProforma($s=[]){    
        if(!empty($s['branch_id']) && isset($s['branch_id'])){
            $this->db->where('m.branch_id',$s['branch_id']);
        }else{
            $this->db->where('m.branch_id',$_SESSION['BRANCH_ID']);
        }           
        $this->db->select("m.`pk_id`,m.`quotation`");
        $this->db->join("tbl_quotation_jobs qj","qj.quotation_id=m.pk_id","LEFT");
        $this->db->where('qj.proforma_job_id',0);
        $query = $this->db->get("tbl_quotations m"); 
        //echo $this->db->last_query();              
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['pk_id']] = $row['quotation'];
            }
            return $rows;
        }
        return false;
    }

    function getQuotationsListNotInInvoice($s=[]){       
        if(!empty($s['branch_id']) && isset($s['branch_id'])){
            $this->db->where('m.branch_id',$s['branch_id']);
        }else{
            $this->db->where('m.branch_id',$_SESSION['BRANCH_ID']);
        }           
        $this->db->select("m.`pk_id`,m.`quotation`");
        $this->db->join("tbl_quotation_jobs qj","qj.quotation_id=m.pk_id","LEFT");
        $this->db->where('qj.invoice_job_id',0);
        $query = $this->db->get("tbl_quotations m");               
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['pk_id']] = $row['quotation'];
            }
            return $rows;
        }
        return false;
    }
    
}