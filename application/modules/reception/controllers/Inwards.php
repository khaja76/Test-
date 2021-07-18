<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Inwards extends MY_Controller
{
    public $header_data = array();
    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["RECEPTIONIST","ADMIN","SUPER_ADMIN","ENGINEER"]);
        $this->load->model("admin/Admin_model", "dbapi", TRUE);
        $this->load->model("admin/Inward_model", "inward", TRUE);
        $this->load->model("admin/Branch_model", "branch", TRUE);
        $this->load->model("admin/Challan_model", "challan", TRUE);
        $this->load->model("Reception_model", "reception", TRUE);
        $this->load->model("Notification_model", "notification", TRUE);
    }
    public function index()
    {
        $this->header_data['title'] = " Inwards ";
        $data = array();
        if (!empty($this->_REQ['job_id'])) {
            $job_id = $this->_REQ['job_id'];
            $data['inward'] = $this->inward->getInwardByJobId($job_id);
        }
        $this->_template('inwards/index', $data);
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
            
            $_SESSION['inward']['gatepass_no']= $pdata['gatepass_no'];
            $_SESSION['inward']['inward_dispatch_through']=$pdata['inward_dispatch_through'];            
            $last_id = $this->inward->addInward($pdata);
            if ($last_id) {                
                //$inward = $this->inward->getBranchInwardsCnt(['branch_id'=>$pdata['branch_id']]);//,'financial_year'=>$financial_year]
                $action_type = 'INWARD';
                $inward = $this->inward->getBranchSequenceNumber($_SESSION['BRANCH_ID'],$action_type);
                $inward_code = (!empty($_SESSION) && ($_SESSION['INWARD_CODE'])) ? $_SESSION['INWARD_CODE'] : '';
                $cnt = str_pad($inward + 1, 3, '0', STR_PAD_LEFT);
                $inward_id = inwardFormat($cnt, $inward_code);
                //$this->inward->updateBranch(['inwards_cnt' => $cnt], $pdata['branch_id']);
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
                // Notification Related Code
                $nData = [];
                $nData['customer_id'] = $pdata['customer_id'];
                $nData['inward_id'] = $last_id;
                $nData['inward_status'] = 'ADDED';
                $nData['notification_type_id'] = 2;
                $notification_id = $this->notification->addNotification($nData);
                $sData = [];
                $sData['notification_id'] = $notification_id;
                $admin = $this->reception->getBranchAdmin($_SESSION['BRANCH_ID']);
                $users = [1, $admin['user_id']];
                foreach ($users as $user) {
                    $sData['user_id'] = $user;
                    $this->notification->addNotificationStatus($sData);
                }
                // Reception Activity
                $aData = [];
                $aData['user_id'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                $aData['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
                $aData['type_id'] = 2;
                $aData['customer_id'] = $pdata['customer_id'];
                $aData['inward_id'] = $last_id;
                $this->reception->addActivity($aData);
            }
            $smsMessage="Your Inward Id : ".$inward_id .", This will reference your product : ".$pdata['product'].". We will update product repair status soon.  K.SaiBabu, Hi.Fi Technologies, Hyd, 9490746511";
            $this->sendSMS($customer['mobile'],$smsMessage);
            $_SESSION['message'] = "Inward added successfully  Job Id  :: " . $inward_id;
            redirect(base_url() . 'reception/inwards/challan/?customer_id=' . $_POST['cpk_id']);
        }
        $this->_template('inwards/form', $data);
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
           $jobs = !empty($_POST['jobids']) ? $_POST['jobids'] :''; 
           $branch_id = (!empty($_SESSION) && !empty($_SESSION['BRANCH_ID'])) ? $_SESSION['BRANCH_ID'] : '';
           $branch_code = (!empty($_SESSION) && ($_SESSION['BRANCH_CODE'])) ? $_SESSION['BRANCH_CODE'] : '';
           $financial_year = financialYear();
           //$ic_count = $this->challan->getInwardChallansCnt(['branch_id'=>$branch_id,'financial_year'=>$financial_year]);
           $action_type = 'INWARD_CHALLAN';
           $ic_count = $this->inward->getBranchSequenceNumber($_SESSION['BRANCH_ID'],$action_type);                     
           $last_id = $this->challan->addInwardChallan(['branch_id' => $branch_id,'financial_year'=>$financial_year]);
           $challan_no = str_pad($ic_count + 1, 3, '0', STR_PAD_LEFT);
           $challan = challanFormat($challan_no, $type = "IC", $branch_code);
          
           $this->challan->updateInwardChallan(['challan' => $challan, 'challan_no' => $challan_no, 'created_by' => $_SESSION['USER_ID']], $last_id);
          
           foreach($jobs as $key=>$job_pk_id) {
               $this->inward->updateInward(['is_taken_challan' => 'YES', 'inward_challan_id' => $last_id], $job_pk_id);//ic_id, $last_id
           }
           foreach ($jobs as $key => $job_pk_id) {
            $hData['inward_id'] =$job_pk_id;
            $hData['status'] = 'INWARD CHALLAN';
            $hData['remarks'] ='';
            $hData['user_id'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
            $sta = $this->inward->addInwardStatus($hData);
        }
           if (!empty($branch_id)) {
               $data['branch_data'] = $this->branch->getBranchById($branch_id);
           }
           $upd['number']=$ic_count+1; 
            $this->inward->updateSequenceNumber($upd,$_SESSION['BRANCH_ID'],$action_type);                               
           $admin = $this->reception->getBranchAdmin($_SESSION['BRANCH_ID']);
           if (!empty($admin['email'])) {
               $pdata['to'] = $admin['email'];
               $customer = $this->reception->getCustomerById($_GET['customer_id']);
               $smsMessage = "Your Inward Challan : " . $challan . ", This will reference your products. We will update product(s) repair status soon..K.SaiBabu, Hi.Fi Technologies, Hyd, 9490746511.";
               $this->sendSMS($customer['mobile'], $smsMessage);
               $pdata['cc'] = $customer['email'];
               $pdata['customer'] =  $customer;
               $pdata['branch_data'] =  $data['branch_data'];
               $pdata['inward_challan'] = $challan;
               $pdata['subject'] = "Inward Challan";
               if (!empty($last_id)) {
                   $challana = $this->challan->getInwardChallanById($last_id);
                   $pdata['inwards'] = $this->inward->searchInwards(['inward_challan_id' => $challana['pk_id']]);
                   if (!empty($pdata['inwards'])) {
                       $pdata['branch_data'] = $this->inward->getBranchById($pdata['inwards'][0]['branch_id']);
                       $pdata['customer'] = $this->inward->getCustomerById($pdata['inwards'][0]['customer_pk_id']);
                   }
               }
               $this->sendEmail("admin/email/inward-challan", $pdata);
           }
           // Reception Activity
           $aData = [];
           $aData['user_id'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
           $aData['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
           $aData['type_id'] = 3;
           $aData['inward_challan_id'] = $last_id;
           $this->reception->addActivity($aData);
           $nData = [];
           $nData['inward_status'] = 'INWARD CHALLAN';
           $nData['notification_type_id'] = 9;
           $nData['inward_challan_id']=$last_id;
           $notification_id = $this->notification->addNotification($nData);
           $sData = [];
           $sData['notification_id'] = $notification_id;
           $admin = $this->reception->getBranchAdmin($_SESSION['BRANCH_ID']);
           $users = [1, $admin['user_id']];
           foreach ($users as $user) {
               $sData['user_id'] = $user;
               $this->notification->addNotificationStatus($sData);
           }
          
           unset($_SESSION['inward']['inward_dispatch_through']);
           unset($_SESSION['inward']['gatepass_no']);
           redirect(base_url() . 'reception/inwards/challan-print/?challan='.$last_id);
        }
        if (!empty($this->_REQ['customer_id'])) {
            $customer_id = $this->_REQ['customer_id'];
            $data['inwards'] = $this->challan->checkChallanStatus($customer_id);
            $data['customer'] = $this->inward->getCustomerById($customer_id);
        }
        
        $this->_template('inwards/challan', $data);
    }
    public function challan_print()
    {
        $data = [];
        $pk_id=!empty($this->_REQ['challan']) ? $this->_REQ['challan'] :'';
        if(!empty($pk_id)){
            $challan = $this->challan->getInwardChallanById($pk_id);
            $data['inwards'] = $this->inward->searchInwards(['inward_challan_id' => $pk_id]);
            if (!empty($data['inwards'])) {
                $data['branch_data'] = $this->challan->getBranchById($data['inwards'][0]['branch_id']);
                $data['customer'] = $this->inward->getCustomerById($data['inwards'][0]['customer_pk_id']);
            }
            $this->header_data['title']=  $challan['challan'];
        }
        $this->header_data['title']=$challan['challan'];
        $this->_template('inwards/challan', $data);
        //$this->_template('inwards/print', $data);
    }
    public function view($inward_id = '')
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
        $this->_template('inwards/view', $data);
    }
    public function damage()
    {
        $this->header_data['title'] = " Damage ";
        $data = array();
        if (!empty($this->_REQ['job_id'])) {
            $job_id = $this->_REQ['job_id'];
            $data['inward'] = $this->inward->getInwardByJobId($job_id);
        }
        $this->_template('inwards/index', $data);
    }
    public function history($str = '')
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
            if(!empty($dates)){
                foreach($dates as &$date){
                    $date['inwards'] = $this->inward->getInwardHistoryByIdC(['inward_id' => $date['inward_id'], 'date' => $date['date']]);
                    foreach ( $date['inwards'] as &$inward) {
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
    public function approvals(){
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
            $search_data['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID']:'';
        }
        $data['inwards']=$this->inward->searchApprovals($search_data);
        // print_r($data['inwards']);
        $data['locations'] = $this->challan->getLocationsList();
        $data['branches_else'] = $this->challan->getBranchesList(!empty($this->_REQ['location_id']) ? $this->_REQ['location_id'] : '');
        $this->_template("inwards/approvals", $data);
    }
}