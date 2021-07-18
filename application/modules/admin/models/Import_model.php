<?php
class Import_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function addImportedInwards($data)
    {
        $this->db->insert("tbl_imported_inwarddata", $data);
        return $this->db->insert_id();
    }
    function updateImportedInward($data,$pk_id){
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_imported_inwarddata", $data);
    }
    function getBranchById($pk_id)
    {
        $this->db->select("m.*,l.location_name,CASE WHEN m.state_code = 'OTH' THEN m.other_location ELSE s.state_name END as state_name");
        $this->db->join("tbl_locations l", "l.pk_id = m.location_id","LEFT");
        $this->db->join("tbl_states s", "s.state_code = m.state_code","LEFT");
        $this->db->where("m.pk_id", $pk_id);
        if(isset($location_id)) {
            $this->db->where("m.location_id", $location_id);
        }/*else{
            $this->db->where("m.location_id", $_SESSION['LOCATION_ID']);
        }*/
        $query = $this->db->get("tbl_branches m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function checkJobExist($job_id){
        $this->db->select("m.job_id");
        if(!empty($_SESSION['ROLE']) && ($_SESSION['ROLE']=="ADMIN")){
            $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        }
        $this->db->where("m.job_id", $job_id);
        $query = $this->db->get("tbl_imported_inwarddata m");
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }
    function searchImportedInwards($data = array(), $mode = 'DATA')
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*");
        }
        if (!empty($data['from_date'])) {
            $from = $data['from_date'];
            $to = $data['to_date'];
            $this->db->where("DATE(m.created_on) BETWEEN '" . $from . "' AND '" . $to . "'");
        }
        if(!empty($_SESSION['ROLE']) && ($_SESSION['ROLE']=="ADMIN")){
            $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        }
        if (!empty($data['date']) && isset($data['date'])) {
            $this->db->where("DATE(m.created_on)", $data['date']);
        }
        if (!empty($data['status']) && ($data['status']!='ALL')) {
            if($data['status']=="R"){
                $this->db->where("m.status IN ('OK','ok','R')");
            }else{
                $this->db->where("m.status",$data['status']);
            }            
        }
        if (isset($data['limit']) && isset($data['offset'])) {
            $this->db->limit($data['limit'], $data['offset']);
        }
        //$this->db->order_by("SUBSTRING_INDEX(m.job_id, '/', -1)"." as job_no  DESC",FALSE);
        $this->db->order_by("m.job_id DESC");
        $query = $this->db->get("tbl_imported_inwarddata m");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }
    function getImportedInwardById($pk_id)
    {
        $this->db->select("m.*,u.name as created_by");
        $this->db->where("m.pk_id", $pk_id);
        $this->db->join("tbl_users u","u.user_id=m.created_by","LEFT");
        $query = $this->db->get("tbl_imported_inwarddata m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
}
