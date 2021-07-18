<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Reception extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["RECEPTIONIST"]);
        $this->load->model("Reception_model", "dbapi", TRUE);
        $this->load->model("admin/Inward_model", "inward", TRUE);
        $this->load->model("Notification_model", "notification", TRUE);
    }

    public function index()
    {
        $this->header_data['title'] = ":: Dashboard ::";
        $data = [];
         if (!empty($this->_REQ['job_id'])) {
             $job_id = $this->_REQ['job_id'];
             $branch_id=!empty($this->_REQ['branch_id']) ? $this->_REQ['branch_id']:$_SESSION['BRANCH_ID'];
             $data['inward'] = $this->inward->getInwardByJobId($job_id);
             $data['transaction'] = $this->dbapi->getTransactions($data['inward']['pk_id'], $branch_id);
            $data['_workorder'] = $this->dbapi->getWorkOrder($data['inward']['pk_id'], $branch_id);
         }
        if (isset($_GET['select_type']) && !empty($_GET['select_type']) && !empty($_GET['name'])) {
            $type = $_GET['select_type'];
            $query = $_GET['name'];
            $data['customers_data'] = $this->inward->getCustomersByCustom($type, $query);
            $data['inwards']= $this->inward->searchInwards(['customer_id' => $data['customers_data'][0]['customer_no'], 'branch_id' =>$data['customers_data'][0]['branch_id']]);
        }
        $this->_template('inwards/index', $data);
    }
   
}
