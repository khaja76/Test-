<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends MY_Controller
{
    public $header_data = array();


    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["RECEPTIONIST","ADMIN","SUPER_ADMIN","ENGINEER"]);
        $this->load->model("admin/Inward_model", "inward", TRUE);
        $this->load->model("Notification_model", "notification", TRUE);
    }

    public function index()
    {
        $data = [];
        $search_data=[];
        if (!empty($this->_REQ['job_id'])) {
            $job_id = $this->_REQ['job_id'];
            $data['inward'] = $this->inward->getInwardByJobId($job_id);
        }
        $this->_template('admin/payments/index', $data);
        
    }
    public function add()
    {
        $this->_template('payments/form');
    }
    public function history(){
        $data = [];
        if(!empty($this->_REQ['inward'])){
            $s['inward_id'] = $this->_REQ['inward'];
            
            if(!empty($_SESSION['ROLE']) && $_SESSION['ROLE']=='SUPER_ADMIN'){
                $s['branch_id'] = $this->_REQ['branch_id'];
            }else{
                $s['branch_id'] = $_SESSION['BRANCH_ID'];
            }
            $inward = $this->inward->getInwardById($s['inward_id'],$s['branch_id']);
            $inward['payments'] = $this->inward->getPaymentDetails($s);
            $data['inward'] = $inward;
        }
        $this->_template('payments/history',$data);
    }
}