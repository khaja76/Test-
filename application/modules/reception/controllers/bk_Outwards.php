<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Outwards extends MY_Controller
{
    public $header_data = array();
    function __construct()
    {
        parent::__construct();
        $this->load->model("admin/Inward_model", "inward", TRUE);
        $this->load->model("admin/Outward_model", "outward", TRUE);
        $this->load->model("admin/Branch_model", "branch", TRUE);
        $this->load->model("admin/Challan_model", "challan", TRUE);
    }
    public function index()
    {
        $data = [];
        unset($_SESSION['challan-out-jobs']);
        if (isset($_GET['select_type']) && !empty($_GET['select_type']) && !empty($_GET['name'])) {
            $type = $_GET['select_type'];
            $query = $_GET['name'];
            $customer = $this->inward->getCustomersByCustom($type, $query);
            if (!empty($customer)) {
                $data['inwards'] = $this->challan->checkOutwardsStatus($customer[0]['pk_id']);
            }
            $data['customer'] = $customer;
        }
        if (!empty($_POST['inward_no'])) {
            redirect(base_url() . 'reception/outwards/upload/?inward_no=' . $_POST['inward_no'].'&select_type=customer_id&name='.$_POST['customer_no']);
        }
        //$challan_id=isset($_GET['challan'])  ? $_GET['challan'] :'';
        $this->_template('outwards/index', $data);
    }
    public function upload(){
        $this->header_data['title']="Upload Delivery Images ";
        $jobid=isset($_GET['inward_no']) ? $_GET['inward_no']:'';
        $data['inward']=$this->inward->getInwardByJobId($jobid);
        if (!empty($_POST['pk_id'])) {
            $job_id = !empty($_POST['job_id']) ? $_POST['job_id'] : '';
            $pk_id = !empty($_POST['pk_id']) ? $_POST['pk_id'] : '';
            $remarks = !empty($_POST['remarks']) ? $_POST['remarks'] : '';
            $user = $_SESSION['USER_ID'];
            $customer = $this->inward->getCustomerById($_POST['customer_id']);
            $branch_id = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] :'';
            /*  $pData['remarks'] = !empty($_POST['remarks'])  ? trim($_POST['remarks']) : '';
             $pData['branch_id'] = $branch_id;
             $pData['created_by'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] :''; */
            $oData['remarks'] = !empty($_POST['remarks'])  ? trim($_POST['remarks']) : '';
            $oData['branch_id'] = $branch_id;
            /*   $outwardCnt = $this->challan->getBranchOutwardChallansCnt($branch_id);
              $challan_no = str_pad($outwardCnt + 1, 3, '0', STR_PAD_LEFT);
              $branch_code = (!empty($_SESSION) && ($_SESSION['BRANCH_CODE'])) ? $_SESSION['BRANCH_CODE'] : '';
              $pData['challan'] = challanFormat($challan_no, $type = "OC", $branch_code);
              $pData['challan_no'] = $challan_no;
              $challan_id = $this->challan->addOutwardChallan($pData);
              if(!empty($challan_id)){
                  $oData = [];
                  $oData['outward_challan_id'] = $challan_id;
                  $oData['branch_id'] = $branch_id;
                  $oData['inward_id'] = $pk_id;
                  $oData['job_id'] = !empty($_POST['job_id'])  ? trim($_POST['job_id']) : '';
                  $oData['job_no'] = !empty($_POST['job_no'])  ? trim($_POST['job_no']) : '';
                  $outward_lastid=$this->challan->addOutwards($oData);
                  $time = date('Y-m-d H:i:s');
                  $this->inward->updateInward(['outward_challan_id'=>$challan_id,'is_outwarded'=>'YES','outward_date'=>$time],$oData['inward_id']);
              }
                */
            $time = date('Y-m-d H:i:s');
            $oData['branch_id'] = $branch_id;
            $oData['inward_id'] = $pk_id;
            $oData['job_id'] = !empty($_POST['job_id'])  ? trim($_POST['job_id']) : '';
            $oData['job_no'] = !empty($_POST['job_no'])  ? trim($_POST['job_no']) : '';
            $outward_lastid=$this->challan->addOutwards($oData);
            $this->inward->updateInward(['is_outwarded'=>'YES','outward_date'=>$time],$oData['inward_id']);
            $folder = str_replace('/', '-', $job_id);
            $img_path = $customer['img_path'] . 'outward/' . $folder . '/';
            createFolder($img_path);
            if (!empty($_FILES['photo'])) {
                uploadThumbFiles($img_path, 'photo', 200);
            }
            $this->challan->updateOutward(['outward_images_path'=>$img_path],$outward_lastid);
            $outIds = array();
            array_push($outIds,$outward_lastid);
            $this->session->set_flashdata('outward_ids', $outIds);
            redirect(base_url()."reception/outwards/?outward=".$outward_lastid.'&select_type=customer_id&name='.$_GET['name']);
        }
        $this->_template('outwards/upload', $data);
    }
    public function challan1(){
        $data = [];
        $this->header_data['title'] = "Delivery Challans";
        $branch_id = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] :'';
        if (!empty($this->_REQ['customer_id'])) {
            //$customer_id = $this->_REQ['customer_id'];
            $jobs = !empty($_SESSION['challan-out-jobs']) ? explode(',',$_SESSION['challan-out-jobs']) : '';
            $inwards = [];
            if(!empty($jobs)){
                foreach($jobs as $job){
                    $data['inwards'] = $this->inward->getInwardById($job);
                    array_push($inwards, $data['inwards']);
                }
            }
            $data['inwards'] = $inwards;
            $data['branch_data'] = $this->branch->getBranchById($branch_id);
        }
        if(!empty($_POST['pk_id']) && isset($_POST['save'])){
            $pData = [];
            $branch_id = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] :'';
            $pData['remarks'] = !empty($_POST['remarks'])  ? trim($_POST['remarks']) : '';
            $pData['branch_id'] = $branch_id;
            $pData['created_by'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] :'';
            $outwardCnt = $this->challan->getBranchOutwardChallansCnt($branch_id);
            $challan_no = str_pad($outwardCnt + 1, 3, '0', STR_PAD_LEFT);
            $branch_code = (!empty($_SESSION) && ($_SESSION['BRANCH_CODE'])) ? $_SESSION['BRANCH_CODE'] : '';
            $pData['challan'] = challanFormat($challan_no, $type = "OC", $branch_code);
            $pData['challan_no'] = $challan_no;
            $challan_id = $this->challan->addOutwardChallan($pData);
            if(!empty($challan_id)){
                foreach($_POST['inward_id'] as $k=>$v){
                    $oData = [];
                    $oData['outward_challan_id'] = $challan_id;
                    $oData['branch_id'] = $branch_id;
                    $oData['inward_id'] = !empty($_POST['inward_id'][$k])  ? trim($_POST['inward_id'][$k]) : '';
                    $oData['job_id'] = !empty($_POST['job_id'][$k])  ? trim($_POST['job_id'][$k]) : '';
                    $oData['job_no'] = !empty($_POST['job_no'][$k])  ? trim($_POST['job_no'][$k]) : '';
                    $oData['status'] = !empty($_POST['status'][$k])  ? trim($_POST['status'][$k]) : '';
                    $this->challan->addOutwards($oData);
                    $time = date('Y-m-d H:i:s');
                    $this->inward->updateInward(['outward_challan_id'=>$challan_id,'is_outwarded'=>'YES','outward_date'=>$time],$oData['inward_id']);
                }
            }
            /*
            $nData = [];
            $nData['customer_id'] = $customer; // Customer_id
            $nData['outward_challan_id'] = $challan_id; // Outward-Challan-id
            $nData['notification_type_id'] = 10;
            $notification_id = $this->notification->addNotification($nData); */
            // Get Customer Email and Customer Code
            /* if (!empty($eData['email'])) {
                $edata['to'] = $pdata['email'];
                $edata['customer_id'] = $customer_id;
                $edata['subject'] = "Delivery Challan";
                $this->sendEmail("email/customer-registration", $pdata);
            }
            $admin=$this->dbapi->getBranchAdmin($_SESSION['BRANCH_ID']);
            if (!empty($admin['email'])) {
                $pdata['to'] = $admin['email'];
                $pdata['customer_id'] = $customer_id;
                $pdata['subject'] = "Delivery Challan";
                $this->sendEmail("email/customer-registration", $pdata);
            } */
            redirect(base_url() . 'reception/outwards/challan/?challan='.$challan_id);
        }
        $this->_template('outwards/challan', $data);
    }
    public function challan_print(){ // Save and Print
        $data = [];
        if (!empty($this->_REQ['customer_id'])) {
            $customer_id = $this->_REQ['customer_id'];
            $customer = $this->inward->getCustomerById($customer_id);
            $data['customer']=$customer;
            $data['branch_data'] = $this->branch->getBranchById($_SESSION['BRANCH_ID']);
        }
        if(!empty($this->_REQ['challan'])){
            $challan_id = $this->_REQ['challan'];
            $challan = $this->challan->getOutwardChallanById($challan_id);
            if(!empty($challan)){
                $challan['outwards'] = $this->challan->getOutwardsByChallanId($challan_id);
            }
            $data['outwards'] = $challan;
        }
        $this->_template('outwards/challan', $data);
    }
    //temp
    public function challan(){
        $data = [];
        if (!empty($this->_REQ['customer_id'])) {
            $customer_id = $this->_REQ['customer_id'];
            $customer = $this->inward->getCustomerById($customer_id);
            $data['customer']=$customer;
            $data['branch_data'] = $this->branch->getBranchById($_SESSION['BRANCH_ID']);
            if (!empty($customer)) {
                $data['outwards'] = $this->challan->checkOutwardsChallanStatus($customer['pk_id']);
            }
            $this->_template('outwards/challan', $data);
        }
    }
}