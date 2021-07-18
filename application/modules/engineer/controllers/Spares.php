<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spares extends MY_Controller
{
    public $header_data = array();

    function __construct()
    {
        parent::__construct();
        $this->load->model("Inward_model", "inward", TRUE);
        $this->load->model("admin/Spare_model", "spare", TRUE);
        $this->load->model("Engineer_model", "engineer", TRUE);
        $this->header_data['spare_grant_cnt'] = $this->spare->searchApprovedSparesCnt();
        $this->header_data['approvals'] = $this->engineer->getApprovalStatus(['today'=>date('Y-m-d')],"CNT");
    }

    public function index($act='',$str='')
    {
        if (!empty($_GET['act']) && $_GET['act'] == "status" && !empty($_GET['pk_id']) && isset($_GET['pk_id'])) {
            $received = "RECEIVED";
            $is_received = "SPARE RECEIVED";
            $this->spare->updateSpareRequest(['request_status'=>$received],$_GET['pk_id']);
            $this->inward->updateInward(['status'=>$is_received],$_GET['inward_id']);
            $sData['inward_id'] = !empty($_GET['inward_id']) ? $_GET['inward_id'] : '';
            $sData['status'] = $is_received;
            $sData['remarks'] =  '';
            $sData['user_id'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';

            $sta = $this->inward->addInwardStatus($sData);
            redirect(base_url().'engineer/spares/');
        }

        $this->header_data['title'] = " Spare Requests ";
        $data = array();
        $data['status_list'] = $this->inward->getStatusList();
        $search_data=[];
        if (!empty($this->_REQ['from_date'])) {
            $search_data['from_date'] = dateRangeForm2DB($this->_REQ['from_date']);
            $search_data['to_date'] = dateRangeForm2DB($this->_REQ['to_date']);
        } else {
            $search_data['today'] = date('Y-m-d');
        }

        $search_data['created_by']=!empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID']:'';
        $search_data['branch_id']=!empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID']:'';
        $search_data['location_id']=!empty($_SESSION['LOCATION_ID']) ? $_SESSION['LOCATION_ID']:'';
        //$search_data['status']='SPARE REQUIREMENT';
        $inwards = $this->spare->searchSpareRequests($search_data);
        $data['inwards'] = $inwards;

        $this->_template('spares/index', $data);
    }

    public function pending_spares(){
        $this->header_data['title'] = " Pending Spare Requests ";
        $data = array();
        $data['status_list'] = $this->inward->getStatusList();
        $search_data=[];
        if (!empty($this->_REQ['from_date'])) {
            $search_data['from_date'] = dateRangeForm2DB($this->_REQ['from_date']);
            $search_data['to_date'] = dateRangeForm2DB($this->_REQ['to_date']);
        } else {
            $search_data['today'] = date('Y-m-d');
        }

        $search_data['created_by']=!empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID']:'';
        $search_data['branch_id']=!empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID']:'';
        $search_data['location_id']=!empty($_SESSION['LOCATION_ID']) ? $_SESSION['LOCATION_ID']:'';
        $search_data['pending'] = 'YES';
        $search_data['is_outwarded'] = 'NO';
        
        $inwards = $this->spare->searchSpareRequests($search_data);
        $data['inwards'] = $inwards;

        $this->_template('spares/index', $data);
    }
}