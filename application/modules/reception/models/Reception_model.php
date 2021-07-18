<?php

class Reception_model extends CI_Model
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
        $this->db->join("tbl_states s","s.state_code=m.state","LEFT");
        $this->db->where("m.user_id", $user_id);
        $query = $this->db->get("tbl_users m");
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getTransactions($job_pk_id,$branch_id=''){
        $this->db->select("i.job_id,i.status,i.estimation_amt,i.paid_amt,b.name as branch_name,c.customer_id,c.first_name,c.last_name,c.mobile as customer_mobile,c.email as customer_email,ccom.company_name as customer_company_name,ccom.company_mail as customer_company_mail,ccom.phone as customer_company_mobile,oc.challan as outward_challan,q.quotation,pi.proforma");
        $this->db->join("tbl_branches b", "b.pk_id = i.branch_id");
        $this->db->join("tbl_customers c", "c.pk_id = i.customer_id");
        $this->db->join("tbl_company_customers cc", "cc.customer_id = c.customer_id","LEFT");
        $this->db->join("tbl_client_companies ccom", "ccom.pk_id = cc.company_id","LEFT");
        $this->db->join("tbl_outwards o", "o.inward_id = i.pk_id","LEFT");
        $this->db->join("tbl_outward_challans oc", "oc.pk_id = o.outward_challan_id","LEFT");
      
        $this->db->join("tbl_quotation_jobs qj", "qj.job_id = i.pk_id","LEFT");
        $this->db->join("tbl_quotations q", "q.pk_id = qj.quotation_id","LEFT");

        $this->db->join("tbl_proforma_invoice_jobs pij", "pij.quotation_job_id =qj.pk_id","LEFT");
        $this->db->join("tbl_proforma_invoices pi", "pi.pk_id = pij.proforma_id","LEFT");

        $this->db->where("i.pk_id", $job_pk_id);
        $query = $this->db->get("tbl_inwards i");
       
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getWorkOrder($job_id,$branch_id){
        $this->db->select("pi.work_order");
        $this->db->where("qj.job_id",$job_id);
        $this->db->where("pi.branch_id",$branch_id);
        $this->db->join("tbl_branches b", "b.pk_id = pi.branch_id","LEFT");
        $this->db->join("tbl_proforma_invoice_jobs pij", "pij.proforma_id =pi.pk_id","LEFT");
        $this->db->join("tbl_quotation_jobs qj", "qj.pk_id = pij.quotation_job_id","LEFT");
        $query = $this->db->get("tbl_proforma_invoices pi");
        
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
    function getBranchAdmin($branch_id)
    {
        $this->db->select("u.*");
        $this->db->where("m.branch_id", $branch_id);
        $this->db->join('tbl_users u','u.user_id = m.user_id');
        $this->db->where("m.is_active", 1);
        $this->db->where("m.role", "ADMIN");
        $query = $this->db->get("tbl_branch_users m");
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    // Activities
    function addActivity($data = [])
    {
        if (!isset($data['created_on'])) {
            $date=date('Y-m-d H:i:s');
            $this->db->set("created_on",$date);
        }
        $this->db->insert("tbl_reception_activities", $data);
        return $this->db->insert_id();
    }
    function getCustomerById($pk_id)
    {
        $this->db->select("m.*,CONCAT_WS(' ',m.first_name,m.last_name) as customer_name, l.location_name,l.pk_id as location_id,b.pk_id as branch_id,b.name as branch_name", FALSE);
        $this->db->join("tbl_locations l", "l.pk_id = m.location_id");
        $this->db->join("tbl_branches b", "b.pk_id = m.branch_id");
        $this->db->where("m.pk_id", $pk_id);
        $query = $this->db->get("tbl_customers m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getUserDocumentsByUser($user_id){
        $this->db->select("d.*");
        $this->db->where("d.is_active", 1);
        $this->db->where("d.user_id", $user_id);
        $query=$this->db->get("tbl_user_documents d");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
}