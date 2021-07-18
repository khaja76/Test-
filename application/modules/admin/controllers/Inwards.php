<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Inwards extends MY_Controller
{
    public $header_data = array();
    public $branch_id;
    function __construct()
    {
        parent::__construct();
        $this->load->model("Inward_model", "inward", TRUE);
        $this->load->model("Admin_model", "dbapi", TRUE);
        $this->load->model("Challan_model", "challan", TRUE);
        $this->load->model("Customers_model", "customer", TRUE);
        $this->load->model("Branch_model", "branch", TRUE);
        $this->load->model("Notification_model", "notification", TRUE);
        $this->load->model("Sub_ordinates_model", "subordinate", TRUE);
        $this->branch_id = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
    }
    public function add()
    {
        $this->header_data['title'] = " Add Inwards ";
        $data = array();
        if (isset($_GET['select_type']) && !empty($_GET['select_type']) && !empty($_GET['name'])) {
            $type = $_GET['select_type'];
            $query = $_GET['name'];
            $data['customers_data'] = $this->inward->getCustomersByCustom($type, $query);
        }
        if (!empty($_POST['cpk_id'])) {
            $financial_year = financialYear();
            $pdata['financial_year'] = $financial_year;
            $pdata['location_id'] = !empty($_SESSION) ? $_SESSION['LOCATION_ID'] : "";
            $pdata['branch_id'] = !empty($_SESSION) ? $_SESSION['BRANCH_ID'] : "";
            $pdata['customer_id'] = !empty($_POST['cpk_id']) ? trim($_POST['cpk_id']) : "";
            $pdata['product'] = !empty($_POST['product']) ? trim($_POST['product']) : "";
            $pdata['model_no'] = !empty($_POST['model_no']) ? trim($_POST['model_no']) : "";
            $pdata['manufacturer_name'] = !empty($_POST['manufacturer_name']) ? trim($_POST['manufacturer_name']) : "";
            $pdata['serial_no'] = !empty($_POST['serial_no']) ? trim($_POST['serial_no']) : "";
            $pdata['remarks'] = !empty($_POST['remarks']) ? trim($_POST['remarks']) : "";
            $pdata['description'] = !empty($_POST['description']) ? trim($_POST['description']) : "";
            $pdata['gatepass_no'] = !empty($_POST['gatepass_no']) ? trim($_POST['gatepass_no']) : "";
            $pdata['inward_dispatch_through'] = !empty($_POST['inward_dispatch_through']) ? trim($_POST['inward_dispatch_through']) : "";
            $pdata['created_by'] = !empty($_SESSION) ? $_SESSION['USER_ID'] : '';
            $pdata['status'] = "ADDED";
            $_SESSION['inward']['gatepass_no'] = $pdata['gatepass_no'];
            $_SESSION['inward']['inward_dispatch_through'] = $pdata['inward_dispatch_through'];            
            //$inward = $this->inward->getBranchInwardsCnt(['branch_id' => $pdata['branch_id']]); 
            $action_type = 'INWARD';
            $inward = $this->inward->getBranchSequenceNumber($_SESSION['BRANCH_ID'],$action_type);            
            
            $last_id = $this->inward->addInward($pdata);
            if ($last_id) {
                $inward_code = (!empty($_SESSION) && ($_SESSION['INWARD_CODE'])) ? $_SESSION['INWARD_CODE'] : '';
                $cnt = str_pad($inward + 1, 3, '0', STR_PAD_LEFT);
                $inward_id = inwardFormat($cnt, $inward_code);
                $this->inward->updateInward(['job_id' => $inward_id, 'inward_no' => $cnt], $last_id);
                $upd['number']=$inward+1;                
                $this->inward->updateSequenceNumber($upd,$_SESSION['BRANCH_ID'],$action_type);                
                $customer = $this->inward->getCustomerById($pdata['customer_id']);
                $folder = str_replace('/', '-', $inward_id);
                $img_path = $customer['img_path'] . 'inwards/' . $folder . '/';
                createFolder($img_path);
                if (!empty($_FILES['photo'])) {
                    uploadThumbFiles($img_path, 'photo', 200);
                }
                $this->inward->updateInward(["img_path" => $img_path], $last_id);
                $sData = [];
                $sData['inward_id'] = $last_id;
                $sData['user_id'] = $pdata['created_by'];
                $sData['status'] = $pdata['status'];
                $sData['remarks'] = $pdata['remarks'];
                $this->inward->addInwardStatus($sData);
                $nData = [];
                $nData['customer_id'] = $pdata['customer_id'];
                $nData['inward_id'] = $last_id;
                $nData['inward_status'] = 'ADDED';
                $nData['notification_type_id'] = 2;
                $notification_id = $this->notification->addNotification($nData);
                $sData = [];
                $sData['notification_id'] = $notification_id;
                $users = [1];
                foreach ($users as $user) {
                    $sData['user_id'] = $user;
                    $this->notification->addNotificationStatus($sData);
                }
            }
            $smsMessage = "Your Inward Id : " . $inward_id . ", This will reference your product : " . $pdata['product'] . ". We will update product repair status soon..K.SaiBabu, Hi.Fi Technologies, Hyd, 9490746511.";
            $this->sendSMS($customer['mobile'], $smsMessage);
            $_SESSION['message'] = "Inward added successfully  Job Id  :: " . $inward_id;
            redirect(base_url() . 'admin/inwards/challan/?customer_id=' . $_POST['cpk_id']);
        }
        $this->_template('inwards/form', $data);
    }
    public function challan_add(){
        $this->header_data['title'] = " Add Inward Challan ";
        $data = array();
        $branch_id = (!empty($_SESSION) && !empty($_SESSION['BRANCH_ID'])) ? $_SESSION['BRANCH_ID'] : '';
        if (!empty($branch_id)) {
            $data['branch_data'] = $this->branch->getBranchById($branch_id);
        }
        if (isset($_GET['select_type']) && !empty($_GET['select_type']) && ($_GET['select_type']=='customer_no')) {
        //if (!empty($this->_REQ['customer_no'])) {
            $customer_no = $this->_REQ['name'];
            $customer = $this->inward->getCustomerByNo($customer_no);
            if(!empty($customer)){
                $customer_id = $customer['pk_id'];
                $inwards = $this->challan->checkChallanStatus($customer_id);
                if(!empty($inwards)){
                    redirect(base_url() . 'admin/inwards/challan/?customer_id=' . $customer_id);
                }
                $data['inwards'] = $inwards;            
            }                       
        }
        $this->_template('inwards/challan-form', $data);
    }
    public function challan()
    {
        $this->header_data['title'] = " Review Inwards ";
        $data = array();
        $branch_id = (!empty($_SESSION) && !empty($_SESSION['BRANCH_ID'])) ? $_SESSION['BRANCH_ID'] : '';
        if (!empty($branch_id)) {
            $data['branch_data'] = $this->branch->getBranchById($branch_id);
        }
        if (!empty($_POST['jobids'])) {
            $jobs = !empty($_POST['jobids']) ? $_POST['jobids'] : '';
            $branch_id = (!empty($_SESSION) && !empty($_SESSION['BRANCH_ID'])) ? $_SESSION['BRANCH_ID'] : '';
            $branch_code = (!empty($_SESSION) && ($_SESSION['BRANCH_CODE'])) ? $_SESSION['BRANCH_CODE'] : '';
            $financial_year = financialYear();            
            //$ic_count = $this->challan->getInwardChallansCnt(['branch_id' => $branch_id]);
            $action_type = 'INWARD_CHALLAN';
            $ic_count = $this->inward->getBranchSequenceNumber($_SESSION['BRANCH_ID'],$action_type);            

            $challan_no = str_pad($ic_count + 1, 3, '0', STR_PAD_LEFT);
            $challan = challanFormat($challan_no, $type = "IC", $branch_code);

            $last_id = $this->challan->addInwardChallan(['branch_id' => $branch_id, 'financial_year' => $financial_year]);
            $this->challan->updateInwardChallan(['challan' => $challan, 'challan_no' => $challan_no, 'created_by' => $_SESSION['USER_ID']], $last_id);
            foreach ($jobs as $key => $job_pk_id) {
                $this->inward->updateInward(['is_taken_challan' => 'YES', 'inward_challan_id' => $last_id], $job_pk_id);//ic_id, $last_id
            }
            if (!empty($branch_id)) {
                $data['branch_data'] = $this->branch->getBranchById($branch_id);
            }
            $admin = $this->dbapi->getBranchAdmin($_SESSION['BRANCH_ID']);
            if (!empty($admin['email'])) {
                $pdata['cc'] = $admin['email'];
                $customer = $this->dbapi->getCustomerById($_GET['customer_id']);
                $pdata['to'] = $customer['email'];
                $pdata['inward_challan'] = $challan;
                $pdata['subject'] = "Inward Challan";
                if (!empty($last_id)) {
                    $upd['number']=$ic_count+1; 
                    $this->inward->updateSequenceNumber($upd,$_SESSION['BRANCH_ID'],$action_type);                    
                    $challana = $this->challan->getInwardChallanById($last_id);
                    $pdata['inwards'] = $this->inward->searchInwards(['inward_challan_id' => $challana['pk_id']]);
                    if (!empty($pdata['inwards'])) {
                        $pdata['branch_data'] = $this->inward->getBranchById($pdata['inwards'][0]['branch_id']);
                        $pdata['customer'] = $this->inward->getCustomerById($pdata['inwards'][0]['customer_pk_id']);
                    }
                }
                $this->sendEmail("email/inward-challan", $pdata);
            }
            $nData = [];
            $nData['inward_status'] = 'INWARD CHALLAN -' . $challan;
            $nData['notification_type_id'] = 9;
            $nData['inward_challan_id'] = $last_id;
            $notification_id = $this->notification->addNotification($nData);
            $smsMessage = "Your Inward Challan : " . $challan . ", This will reference your products. We will update product(s) repair status soon..K.SaiBabu, Hi.Fi Technologies, Hyd, 9490746511.";
            $this->sendSMS($customer['mobile'], $smsMessage);
            $sData = [];
            $sData['notification_id'] = $notification_id;
            $users = [1];
            foreach ($users as $user) {
                $sData['user_id'] = $user;
                $this->notification->addNotificationStatus($sData);
            }
            foreach ($jobs as $key => $job_pk_id) {
                $hData['inward_id'] = $job_pk_id;
                $hData['status'] = 'INWARD CHALLAN';
                $hData['remarks'] = '';
                $hData['user_id'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                $sta = $this->inward->addInwardStatus($hData);
            }
            unset($_SESSION['inward']['inward_dispatch_through']);
            unset($_SESSION['inward']['gatepass_no']);
            redirect(base_url() . 'admin/inwards/challan-print/?challan=' . $last_id);
        }
        if (!empty($this->_REQ['customer_id'])) {
            $customer_id = $this->_REQ['customer_id'];
            $data['inwards'] = $this->challan->checkChallanStatus($customer_id);
            $data['customer'] = $this->inward->getCustomerById($customer_id);
        }
        $this->_template('inwards/challan', $data);
    }
    public function index()
    {
        $data = [];
        $this->header_data['title'] = "Inwards";
        $search_data = array();
        $search_data['join_challan'] = true;
        if (!empty($this->_REQ['location_id'])) {
            $search_data['location_id'] = $this->_REQ['location_id'];
        }
        if (!empty($this->_REQ['branch_id'])) {
            $search_data['branch_id'] = $this->_REQ['branch_id'];
        }
        if (!empty($_SESSION['ROLE']) && $_SESSION['ROLE'] == 'ADMIN') {
            $search_data['branch_id'] = $_SESSION['BRANCH_ID'];
        }
        if (!empty($this->_REQ['from_date'])) {
            $search_data['from_date'] = dateRangeForm2DB($this->_REQ['from_date']);
            $search_data['to_date'] = dateRangeForm2DB($this->_REQ['to_date']);
        } else if ((empty($this->_REQ['location_id']) || (empty($this->_REQ['branch_id']))) && !isset($_GET['type'])) {
            $search_data['date'] = date('Y-m-d');
        }
        $data['inwards'] = $this->inward->searchInwards($search_data);
        $data['locations'] = $this->challan->getLocationsList();
        $data['branches_else'] = $this->challan->getBranchesList(!empty($this->_REQ['location_id']) ? $this->_REQ['location_id'] : '');
        $this->_template("inwards/index", $data);
    }
    public function getInwardById()
    {
        if (!empty($_POST['inward_id'])) {
            $job_id = $_POST['inward_id'];
            $job = $this->inward->getInwardById($job_id);
            echo json_encode($job);
        }
    }
    public function inwardAssignToEngineer()
    {
        if (!empty($this->_REQ['inwardPkId']) && !empty($this->_REQ['engineerId'])) {
            $inward = $this->_REQ['inwardPkId'];
            $user = $_SESSION['USER_ID'];
            $assigned_to = $this->_REQ['engineerId'];
            $remarks = $this->_REQ['remarks'];
            $sta = $this->inward->addInwardStatus(['inward_id' => $inward, 'user_id' => $user, 'assigned_to' => $assigned_to, 'status' => 'ASSIGNED', 'remarks' => $remarks]);
            $this->inward->updateInward(['status' => 'ASSIGNED', 'assigned_to' => $assigned_to], $inward);
            if ($sta) {
                echo "TRUE";
                $engineer = $this->subordinate->getUserById($assigned_to);
                if(!empty($engineer)){
                    $mobile = $engineer['phone'];
                    //$mobile = '9490746511,9966716022';
                    $job = $this->inward->getInwardById($inward);
                    if(!empty($job)){
                        $job_id = $job['job_id'];
                    }
                    $smsMessage = "New Job ".$job_id." is assigned to you. Please check related information in Portal";                    
                    $this->sendSMS($mobile, $smsMessage);
                    
                } 
                exit();            
            } else {
                echo "FALSE";
                exit();
            }
        }
    }
    public function damage()
    {
        $this->header_data['title'] = " Damage ";
        $data = array();
        if (!empty($this->_REQ['job_id'])) {
            $job_id = $this->_REQ['job_id'];
            $data['inward'] = $this->inward->getInwardByJobId($job_id);
        }
        $this->_template('inwards/damage', $data);
    }
    public function view()
    {
        $this->header_data['title'] = " Inward ";
        $data = array();
        if ((!empty($this->_REQ['job_id'])) || (!empty($this->_REQ['inward']))) {
            $job_id = !empty($this->_REQ['job_id']) ? $this->_REQ['job_id'] : $this->_REQ['inward'];
            $branch_id = !empty($this->_REQ['branch_id']) ? $this->_REQ['branch_id'] : $_SESSION['BRANCH_ID'];
            $data['inward'] = $this->inward->getInwardByJobId($job_id, $branch_id);
            $data['transaction'] = $this->dbapi->getTransactions($data['inward']['pk_id'], $branch_id);
            $data['_workorder'] = $this->dbapi->getWorkOrder($data['inward']['pk_id'], $branch_id);
        }
        $data['engineers'] = $this->inward->getUsersList(['role' => 'ENGINEER', 'branch_id' => $_SESSION['BRANCH_ID']]);
        $data['branch']=$this->branch->getBranchById($_SESSION['BRANCH_ID']);
        $data['branch_admin']=$this->branch->getBranchAdmin($_SESSION['BRANCH_ID']);
        $this->_template('inwards/view', $data);
    }
    public function search()
    {
        $this->header_data['title'] = " Inward ";
        $data = [];
        if (!empty($this->_REQ['job_id'])) {
            $job_id = $this->_REQ['job_id'];
            $data['inward'] = $this->inward->getInwardByJobId($job_id);
            if (!empty($this->_REQ['branch_id'])) {
                $branch_id = $this->_REQ['branch_id'];
            } else {
                $branch_id = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
            }
            $data['transaction'] = $this->dbapi->getTransactions($data['inward']['pk_id'], $branch_id);
            $data['_workorder'] = $this->dbapi->getWorkOrder($data['inward']['pk_id'], $branch_id);
        }
        if (isset($_GET['select_type']) && !empty($_GET['select_type']) && !empty($_GET['name'])) {
            $type = $_GET['select_type'];
            $query = $_GET['name'];
            $data['customers_data'] = $this->inward->getCustomersByCustom($type, $query);
            $data['inwards'] = $this->inward->searchInwards(['customer_id' => $data['customers_data'][0]['customer_no'], 'branch_id' => $data['customers_data'][0]['branch_id']]);
        }
        $data['engineers'] = $this->inward->getUsersList(['role' => 'ENGINEER', 'branch_id' => $_SESSION['BRANCH_ID']]);
        $this->_template('inwards/search', $data);
    }
    public function challans()
    {
        $data = [];
        $search_data = [];
        if (!empty($this->_REQ['location_id']) && isset($this->_REQ['location_id'])) {
            $search_data['location_id'] = $this->_REQ['location_id'];
        }
        if (!empty($this->_REQ['branch_id']) && isset($this->_REQ['branch_id'])) {
            $search_data['branch_id'] = $this->_REQ['branch_id'];
        } else {
            $search_data['branch_id'] = $this->branch_id;
        }
        if (!empty($this->_REQ['from_date'])) {
            $search_data['from_date'] = dateRangeForm2DB($this->_REQ['from_date']);
            $search_data['to_date'] = dateRangeForm2DB($this->_REQ['to_date']);
        } else {
            $search_data['today'] = date('Y-m-d');
        }
        $search_data['inward_challan'] = true;
        $data['inwards'] = $this->challan->getInwardChallansList($search_data);
        $data['locations'] = $this->challan->getLocationsList();
        $data['branches_else'] = $this->challan->getBranchesList(!empty($this->_REQ['location_id']) ? $this->_REQ['location_id'] : '');
        $this->_template("inwards/challans", $data);
    }
    public function challan_view()
    {
        $data = [];
        $pk_id = !empty($this->_REQ['challan']) ? $this->_REQ['challan'] : '';
        if (!empty($pk_id)) {
            $challan = $this->challan->getInwardChallanById($pk_id);
            $data['inwards'] = $this->inward->searchInwards(['inward_challan_id' => $challan['pk_id']]);
            if (!empty($data['inwards'])) {
                $data['branch_data'] = $this->inward->getBranchById($data['inwards'][0]['branch_id']);
                $data['customer'] = $this->inward->getCustomerById($data['inwards'][0]['customer_pk_id']);
            }
        }
        $this->header_data['title']=$challan['challan'];
        $this->_template("inwards/challans-view", $data);
    }
    public function challan_print()
    {
        $data = [];
        $pk_id = !empty($this->_REQ['challan']) ? $this->_REQ['challan'] : '';
        if (!empty($pk_id)) {
            $challan = $this->challan->getInwardChallanById($pk_id);
            $data['inwards'] = $this->inward->searchInwards(['inward_challan_id' => $challan['pk_id']]);
            if (!empty($data['inwards'])) {
                $data['branch_data'] = $this->challan->getBranchById($data['inwards'][0]['branch_id']);
                $data['customer'] = $this->inward->getCustomerById($data['inwards'][0]['customer_pk_id']);
            }
        }
        $this->header_data['title']=$challan['challan'];
        $this->_template("inwards/challans-view", $data);
    }
    public function history()
    {
        $data = [];
        $this->header_data['title'] = " Inward History";
        if (!empty($this->_REQ['inward'])) {
            $pk_id = $this->_REQ['inward'];
            if (!empty($_SESSION['ROLE']) && $_SESSION['ROLE'] == 'SUPER_ADMIN') {
                $branch_id = !empty($this->_REQ['branch_id']) ? $this->_REQ['branch_id'] : '';
            } else {
                $branch_id = $_SESSION['BRANCH_ID'];
            }
            $dates = $this->inward->getInwardHistoryByIdGroupByDate(['inward_no' => $pk_id, 'branch_id' => $branch_id]);
            if (!empty($dates)) {
                foreach ($dates as &$date) {
                    $date['inwards'] = $this->inward->getInwardHistoryByIdC(['inward_id' => $date['inward_id'], 'date' => $date['date']]);
                    foreach ($date['inwards'] as &$inward) {
                        $inward['status_type'] = str_replace("{{user_name}}", $inward['user_name'], $inward['status_type']);
                        $inward['status_type'] = str_replace("{{job_id}}", $inward['job_id'], $inward['status_type']);
                        $inward['status_type'] = str_replace("{{status}}", $inward['status'], $inward['status_type']);
                        $inward['status_type'] = str_replace("{{assigned_to}}", $inward['assigned_to'], $inward['status_type']);
                        $inward['status_type'] = str_replace("{{customer_name}}", $inward['customer_name'], $inward['status_type']);
                    }
                }
            }
        }
        $data['dates'] = $dates;
        $this->_template("inwards/history", $data);
    }
    public function edit($pk_id = '')
    {
        $data = [];
        if (!empty($pk_id)) {
            $inward = $this->inward->getInwardById($pk_id);
            $data['inward'] = $inward;
            if (!empty($_POST['inward_id'])) {
                $pdata['product'] = !empty($_POST['product']) ? trim($_POST['product']) : "";
                $pdata['model_no'] = !empty($_POST['model_no']) ? trim($_POST['model_no']) : "";
                $pdata['manufacturer_name'] = !empty($_POST['manufacturer_name']) ? trim($_POST['manufacturer_name']) : "";
                $pdata['serial_no'] = !empty($_POST['serial_no']) ? trim($_POST['serial_no']) : "";
                $pdata['remarks'] = !empty($_POST['remarks']) ? trim($_POST['remarks']) : "";
                $pdata['description'] = !empty($_POST['description']) ? trim($_POST['description']) : "";
                $pdata['gatepass_no'] = !empty($_POST['gatepass_no']) ? trim($_POST['gatepass_no']) : "";
                $pdata['inward_dispatch_through'] = !empty($_POST['inward_dispatch_through']) ? trim($_POST['inward_dispatch_through']) : "";
                $img_path = $inward['img_path'];
                if (!empty($_FILES['photo'])) {
                    createFolder($img_path);
                    uploadThumbFiles($img_path, 'photo', 200);
                }
                $this->inward->updateInward($pdata, $pk_id);
                $_SESSION['message'] = "Inward Updated Successfully";
                redirect(base_url() . 'admin/inwards/view/?inward=' . $inward['inward_no']);
            }
        }
        $this->_template('inwards/edit', $data);
    }
    public function approvals()
    {
        $data = [];
        if (!empty($this->_REQ['from_date'])) {
            $search_data['from_date'] = dateRangeForm2DB($this->_REQ['from_date']);
            $search_data['to_date'] = dateRangeForm2DB($this->_REQ['to_date']);
        } else {
            $search_data['today'] = date('Y-m-d');
        }
        if (!empty($this->_REQ['branch_id']) && isset($this->_REQ['branch_id'])) {
            $search_data['branch_id'] = $this->_REQ['branch_id'];
        } else {
            $search_data['branch_id'] = $this->branch_id;
        }
        $data['inwards'] = $this->inward->searchApprovals($search_data);
        // print_r($data['inwards']);
        $data['locations'] = $this->challan->getLocationsList();
        $data['branches_else'] = $this->challan->getBranchesList(!empty($this->_REQ['location_id']) ? $this->_REQ['location_id'] : '');
        $this->_template("inwards/approvals", $data);
    }
    function generate_challan(){
        $this->header_data['title'] = " Generate Challan for missed inwards ";
        $data = array();
        if (!empty($this->_REQ['customer_id'])) {
            $customer_no = $this->_REQ['customer_id'];
            $data['customer'] = $this->inward->getCustomerByNo($customer_no);
            $data['inwards'] = $this->challan->checkChallanStatus($data['customer']['pk_id']);            
        }
        $this->_template('inwards/challan',$data);
    }
}