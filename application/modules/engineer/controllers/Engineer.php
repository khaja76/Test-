<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Engineer extends MY_Controller
{
    public $header_data = array();

    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["ENGINEER"]);
        $this->load->model("Engineer_model", "dbapi", TRUE);
        $this->load->model("admin/Spare_model", "spare", TRUE);
        $this->load->model("admin/Message_model", "messages", TRUE);
        $this->header_data['spare_grant_cnt'] = $this->spare->searchApprovedSparesCnt();
        $this->header_data['approvals'] = $this->dbapi->getApprovalStatus(['today'=>date('Y-m-d')],"CNT");
    }

    public function index()
    {
        $data = [];
        $today = date("Y-m-d");
        $data['components'] = $this->dbapi->searchComponents();
        $data['inwardsCnt'] = $this->dbapi->searchLatestAssignedInwards(['assigned_to' => $_SESSION['USER_ID'], 'status' => 'ASSIGNED', 'date' => $today], "CNT");
        $data['inwardsCntAll'] = $this->dbapi->searchLatestAssignedInwards(['assigned_to' => $_SESSION['USER_ID'], 'status' => 'ASSIGNED'], "CNT");
        $data['messagesCnt'] = $this->messages->searchInboxMessages(['user_id' => $_SESSION['USER_ID'], 'date' => $today], "CNT");
        $data['messagesCntAll'] = $this->messages->searchInboxMessages(['user_id' => $_SESSION['USER_ID']], "CNT");
        $data['inwards'] = $this->dbapi->searchLatestAssignedInwards(['assigned_to' => $_SESSION['USER_ID'], 'status' => 'ASSIGNED', 'date' => $today]);
        $data['status_list'] = $this->dbapi->getStatusList();
        $search_data = [];
        $search_data['created_by'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
        $search_data['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
        $search_data['pending'] = 'YES';
        $search_data['is_outwarded'] = 'NO';
        $data['started_cnt'] = $this->dbapi->searchStatus(['status' => 'STARTED'], "CNT");
        $data['paused_cnt'] = $this->dbapi->searchStatus(['status' => 'PAUSED'], "CNT");
        //$data['spare_req_cnt'] = $this->spare->searchSpareRequests($search_data, "CNT");
        $data['spare_req_cnt'] = $this->dbapi->searchStatus(['status' => 'SPARE REQUIREMENT'], "CNT");
        $data['repair_cnt'] = $this->dbapi->searchStatus(['status' => 'REPAIRABLE'], "CNT");
        $data['not_repair_cnt'] = $this->dbapi->searchStatus(['status' => 'NOT REPAIRABLE'], "CNT");
        $data['send_for_test_cnt'] = $this->dbapi->searchStatus(['status' => 'SEND FOR TESTING'], "CNT");
        $data['repaired_cnt'] = $this->dbapi->searchStatus(['status' => 'REPAIRED'], "CNT");
        $data['work_in_progress_cnt'] = $this->dbapi->searchStatus(['status' => 'WORK IN PROGRESS'], "CNT");
        $data['wait_for_appr_cnt'] = $this->dbapi->searchStatus(['status' => 'WAITING FOR APPROVAL'], "CNT");
        $data['send_same'] = $this->dbapi->searchStatus(['status' => 'SEND AS IT IS'], "CNT");
        $data['received_cnt'] = $this->dbapi->searchStatus(['status' => 'SPARE RECEIVED'], "CNT");
        $data['delivered_cnt'] = $this->dbapi->searchStatus(['status' => 'OUTWARD', 'req' => '1'], "CNT");
        $data['others_cnt'] = $this->dbapi->searchStatus(['status' => 'OTHERS'], "CNT"); 
        $this->_template('dashboard', $data);
    }

    public function status($list_type = '', $type = '')
    {
        $data = [];
        $data['status_list'] = $this->dbapi->getStatusList();
        if ($list_type == 'type' && !empty($type)) {
            $type = ucwords($type);
            $type = str_replace('-', ' ', $type);
            $this->header_data['page_status'] = ucwords($type);            
            if ($type == 'Outward') {                
                $inwards = $this->dbapi->searchStatus(['status' => strtoupper($type), 'req' => '1']);               
            } else {                
                $inwards = $this->dbapi->searchStatus(['status' => strtoupper($type)]);
            }
            if (!empty($inwards)) {
                foreach ($inwards as &$inward) {
                    $inward['latest'] = $this->dbapi->getInwardLatestStatus(['status' => $inward['status'], 'inward_id' => $inward['pk_id']]);
                }
            }
            $data['inwards'] = $inwards;
            $data['components'] = $this->dbapi->searchComponents();
            $this->_template('status/view', $data);
        }
    }


}