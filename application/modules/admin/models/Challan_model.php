<?php
class Challan_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function getInwardChallansCnt($s = [])
    {
        $this->db->select('COUNT(1) as CNT');
        if (!empty($s['branch_id'])) {
            $this->db->where("branch_id", $s['branch_id']);
        }
        if (!empty($s['financial_year'])) {
            $this->db->where("financial_year", $s['financial_year']);
        }
        $query = $this->db->get("tbl_inward_challans");
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['CNT'];
        }
        return false;
    }
    //Challans
    function addInwardChallan($data)
    {
        if (!isset($data['created_on'])) {
            $date = date('Y-m-d H:i:s');
            $this->db->set("created_on", $date);
        }
        $this->db->insert("tbl_inward_challans", $data);
        return $this->db->insert_id();
    }
    function updateInwardChallan($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        $this->db->update("tbl_inward_challans", $data);
        return $this->db->insert_id();
    }
    function getInwardChallanById($pk_id)
    {
        $this->db->select("m.*");
        $this->db->where("pk_id", $pk_id);
        $query = $this->db->get("tbl_inward_challans m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function addOutwardChallan($data)
    {
        if (!isset($data['created_on'])) {
            $date = date('Y-m-d H:i:s');
            $this->db->set("created_on", $date);
        }
        $this->db->insert("tbl_outward_challans", $data);
        return $this->db->insert_id();
    }
    function updateOutwardChallan($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        $this->db->update("tbl_outward_challans", $data);
        return $this->db->insert_id();
    }
    function addOutwards($data)
    {
        if (!isset($data['created_on'])) {
            $date = date('Y-m-d H:i:s');
            $this->db->set("created_on", $date);
        }
        $this->db->insert("tbl_outwards", $data);
        return $this->db->insert_id();
    }
    function updateOutward($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        $this->db->update("tbl_outwards", $data);
        return $this->db->insert_id();
    }
    //--------
    function getLocationsList()
    {
        $this->db->select("m.*");
        $query = $this->db->get("tbl_locations m");
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['pk_id']] = $row['location_name'];
            }
            return $rows;
        }
        return false;
    }
    function getBranchesList($location_id)
    {
        $this->db->select("m.*");
        $this->db->where("m.location_id", $location_id);
        $query = $this->db->get("tbl_branches m");
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['pk_id']] = $row['name'];
            }
            return $rows;
        }
        return false;
    }
    //Admin
    function getInwardChallansList($s = [])
    {
        $this->db->select("i.inward_no,i.pk_id as job_pk_id,i.job_id,i.product,i.manufacturer_name,i.model_no,i.serial_no,i.remarks,i.created_on,i.outward_date,i.status,i.branch_id,c.customer_id,c.pk_id as customer_pk_id,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,c.img_path as customer_path,c.img,u.name as created_by,a.name as assigned_to,i.inward_challan_id,ic.challan as inward_challan,ic.created_on as challan_created_on,q.pk_id as company_id,q.company_name", FALSE);
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        $this->db->join("tbl_inwards i", "i.inward_challan_id = ic.pk_id", "LEFT");
        $this->db->join("tbl_customers c", "c.pk_id = i.customer_id", "LEFT");
        $this->db->join("tbl_users u", "u.user_id = i.created_by", "LEFT");
        $this->db->join("tbl_users a", "a.user_id = i.assigned_to", "LEFT");
        $this->db->join("tbl_company_customers cc", "cc.customer_id = c.pk_id", "LEFT");
        $this->db->join("tbl_client_companies q", "q.pk_id = cc.company_id", "LEFT");
        if (isset($s['today']) && !empty($s['today'])) {
            $this->db->where("DATE(ic.created_on)", $s['today']);
        }
        if (!empty($s['from_date'])) {
            $from = $s['from_date'];
            $to = $s['to_date'];
            $this->db->where("DATE(ic.created_on) BETWEEN '" . $from . "' AND '" . $to . "'");
        }
        if (!empty($s['location_id']) && isset($s['location_id'])) {
            $this->db->where("i.location_id", $s['location_id']);;
        }
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where("i.branch_id", $s['branch_id']);;
        }
        if (!empty($s['is_taken_challan']) && isset($s['is_taken_challan'])) {
            $this->db->where('i.is_taken_challan', $s['is_taken_challan']);
        }
        if (!empty($s['ic_challan']) && isset($s['ic_challan'])) {
            $this->db->where('i.inward_challan_id', $s['ic_challan']);
        }
        $this->db->where("i.inward_challan_id !=0");;
        if (empty($s['ic_challan']) && !isset($s['ic_challan'])) {
            $this->db->group_by("ic.pk_id");
        }
        $this->db->order_by("ic.pk_id DESC");
        $query = $this->db->get("tbl_inward_challans ic");
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    function getOutwardChallansList($s = [], $mode = 'DATA')
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("i.inward_no,i.pk_id as job_pk_id,i.job_id,i.product,i.model_no,i.manufacturer_name,i.serial_no,i.remarks,i.description,i.created_on,i.branch_id,i.outward_date,i.status,c.customer_id,c.pk_id as customer_pk_id,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,c.img_path as customer_path,c.img,u.name as created_by,a.name as assigned_to,i.outward_challan_id,oc.challan,oc.created_on as challan_created_on", FALSE);
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        $this->db->join("tbl_inwards i", "i.outward_challan_id = oc.pk_id", "LEFT");
        $this->db->join("tbl_customers c", "c.pk_id = i.customer_id", "LEFT");
        $this->db->join("tbl_users u", "u.user_id = i.created_by", "LEFT");
        $this->db->join("tbl_users a", "a.user_id = i.assigned_to", "LEFT");
        if (isset($s['date']) && !empty($s['date'])) {
            $this->db->where("DATE(oc.created_on)", $s['date']);
        }
        if (!empty($s['from_date'])) {
            $from = $s['from_date'];
            $to = $s['to_date'];
            $this->db->where("DATE(oc.created_on) BETWEEN '" . $from . "' AND '" . $to . "'");
        }
        if (!empty($s['location_id']) && isset($s['location_id'])) {
            $this->db->where("i.location_id", $s['location_id']);
        }
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where("i.branch_id", $s['branch_id']);
        }
        $this->db->where("i.outward_challan_id !=0");;
        if (empty($s['oc_challan']) && !isset($s['oc_challan'])) {
            $this->db->group_by("oc.pk_id");
        }
        if (!empty($s['oc_challan']) && isset($s['oc_challan'])) {
            $this->db->where('i.outward_challan_id', $s['oc_challan']);
        }
        $this->db->order_by("oc.pk_id DESC");
        $query = $this->db->get("tbl_outward_challans oc");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }
    function checkChallanStatus($customer_id,$status='')
    {
        $this->db->select("m.*,c.customer_id,c.pk_id as customer_pk_id,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,u.name as created_by,m.inward_challan_id,q.company_name,q.pk_id as company_id", FALSE);
        $this->db->join("tbl_customers c", "c.pk_id = m.customer_id", "LEFT");
        $this->db->join("tbl_users u", "u.user_id = m.created_by", "LEFT");
        if(!empty($status)){
            $this->db->where('m.is_taken_challan', 'YES');
        }else{
            $this->db->where('m.is_taken_challan', 'NO');
        }
        
        // $this->db->where("DATE(m.created_on)", date('Y-m-d'));
        $this->db->where('m.customer_id', $customer_id);
        $this->db->join("tbl_company_customers cc", "cc.customer_id ='" . $customer_id."'", "LEFT");
        $this->db->join("tbl_client_companies q", "q.pk_id = cc.company_id", "LEFT");
        $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        $this->db->order_by("m.pk_id ASC");
        $query = $this->db->get("tbl_inwards m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    function checkOutwardsStatus($customer_id)
    {
        $this->db->select("m.*,c.customer_id,c.pk_id as customer_pk_id,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,u.name as created_by,m.inward_challan_id", FALSE);
        $this->db->join("tbl_customers c", "c.pk_id = m.customer_id", "LEFT");
        $this->db->join("tbl_users u", "u.user_id = m.created_by", "LEFT");
        $this->db->where('m.is_outwarded', 'NO');
        $this->db->where('m.customer_id', $customer_id);
        $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_inwards m");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    function getOutwardsList($s = [])
    {
        $this->db->select("m.*,i.inward_no,i.job_id,i.product,i.manufacturer_name,i.model_no,i.serial_no,i.description,i.remarks as inward_remarks,i.status,i.gatepass_no");
        if (!empty($s['customer_id'])) {
            $this->db->where('m.customer_id', $s['customer_id']);
        }
        $this->db->join("tbl_inwards i", "i.pk_id = m.inward_id");
        $this->db->where('m.outward_challan_id', 0);
        $this->db->order_by("m.pk_id DESC");
        
        $query = $this->db->get("tbl_outwards m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    /*function checkOutwardsChallanStatus($customer_id)
    {
        $this->db->select("m.*,c.customer_id,c.pk_id as customer_pk_id,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,u.name as created_by,m.inward_challan_id", FALSE);
        $this->db->join("tbl_customers c", "c.pk_id = m.customer_id", "LEFT");
        $this->db->join("tbl_users u", "u.user_id = m.created_by", "LEFT");
        $this->db->where('m.outward_challan_id','0');
        $this->db->where('m.customer_id', $customer_id);
        $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_inwards m");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }*/
    /*function prepareJobsForOutwards($s = [])
    {
        $this->db->select("m.*,c.customer_id,c.pk_id as customer_pk_id,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,c.img_path as customer_path,c.img,u.name as created_by", FALSE);
        //$this->db->select("m.*,c.customer_id,c.pk_id as customer_pk_id,CONCAT_WS(' ',c.first_name,c.last_name) as customer_name,u.name as created_by,m.inward_challan_id", FALSE);
        //$this->db->select("m.job_id");
        $this->db->join("tbl_customers c", "c.pk_id = m.customer_id", "LEFT");
        $this->db->join("tbl_users u", "u.user_id = m.created_by", "LEFT");
        if (isset($s['is_outwarded'])) {
            $this->db->where('m.is_outwarded','NO');
        }
        if (!empty($s['job_pk_id']) && isset($s['job_pk_id'])) {
            $this->db->where('m.pk_id', $s['job_pk_id']);
        }
        if (!empty($s['customer_pk_id']) && isset($s['customer_pk_id'])) {
            $this->db->where('m.customer_id', $s['customer_pk_id']);
        }
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);;
        }
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_inwards m");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }*/
    function getBranchById($pk_id)
    {
        $this->db->select("m.*,l.location_name,CASE WHEN m.state_code = 'OTH' THEN m.other_location ELSE s.state_name END as state_name");
        $this->db->join("tbl_locations l", "l.pk_id = m.location_id","LEFT");
        $this->db->join("tbl_states s", "s.state_code = m.state_code","LEFT");
        $this->db->where("m.pk_id", $pk_id);
        $query = $this->db->get("tbl_branches m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getBranchOutwardChallansCnt($branch_id)
    {
        $this->db->select("COUNT(1) as CNT");
        $this->db->where("m.branch_id", $branch_id);
        $query = $this->db->get("tbl_outward_challans m");
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['CNT'];
        }
        return false;
    }
    function getOutwardChallanById($pk_id)
    {
        $this->db->select("m.*");
        $this->db->where("pk_id", $pk_id);
        $query = $this->db->get("tbl_outward_challans m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getOutwardsByChallanId($pk_id)
    {
        $this->db->select("m.pk_id,o.challan,o.challan_no,m.branch_id,m.remarks as outward_remarks,o.created_by,i.job_id,i.product,i.remarks,i.serial_no,i.model_no,i.manufacturer_name,i.status");
        $this->db->join("tbl_outward_challans  o", "o.pk_id=m.outward_challan_id");
        $this->db->join("tbl_inwards i", "i.outward_challan_id=m.outward_challan_id");
        $this->db->where("m.outward_challan_id", $pk_id);
        $query = $this->db->get("tbl_outwards m");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    function getCustomerById($pk_id)
    {
        $this->db->select("m.*,l.pk_id as location_id, l.location_name, b.pk_id as branch_id, b.name as branch_name,s.state_code,s.state_name as state , q.company_name");
        $this->db->join("tbl_locations l", "l.pk_id = m.location_id");
        $this->db->join("tbl_branches b", "b.pk_id = m.branch_id");
        $this->db->join("tbl_states s", "s.state_code = m.state");
        $this->db->join("tbl_company_customers cc", "cc.customer_id =m.pk_id", "LEFT");
        $this->db->join("tbl_client_companies q", "q.pk_id = cc.company_id", "LEFT");
        $this->db->where("m.pk_id", $pk_id);
        $query = $this->db->get("tbl_customers m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
}
?>