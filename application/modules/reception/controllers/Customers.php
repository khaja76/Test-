<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Customers extends MY_Controller
{
    public $header_data = array();
    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["RECEPTIONIST","ADMIN"]);
        $this->load->model("Customer_model", "dbapi", TRUE);
        $this->load->model("Reception_model", "reception", TRUE);
        $this->load->model("admin/Inward_model", "inward", TRUE);
        $this->load->model("Notification_model", "notification", TRUE);
    }
    private function addCustomer($s = [])
    {
        $pdata = array();
        $checkEmail = $this->dbapi->searchCustomers(['email'=>$s['email']]);
        if(!empty($checkEmail)){           
            $checkMobile = $this->dbapi->searchCustomers(['mobile'=>$s['mobile']]); 
            if(!empty($checkMobile)){               
                echo "Customer with this Mobile No in the same Branch already exists";
                exit;
            }           
            echo "Customer with this Email in the same branch already exists";
            exit;
        }
        $pdata['email'] = !empty($s['email']) ? trim($s['email']) : "";
        $pdata['location_id'] = !empty($_SESSION) ? $_SESSION['LOCATION_ID'] : '';
        $pdata['branch_id'] = !empty($_SESSION) ? $_SESSION['BRANCH_ID'] : '';
        $pdata['first_name'] = !empty($s['first_name']) ? trim($s['first_name']) : "";
        $pdata['last_name'] = !empty($s['last_name']) ? trim($s['last_name']) : "";
        $pdata['mobile'] = !empty($s['mobile']) ? trim($s['mobile']) : "";
        $pdata['opt_mobile'] = !empty($s['opt_mobile']) ? trim($s['opt_mobile']) : "";
        $pdata['address1'] = !empty($s['address1']) ? trim($s['address1']) : "";
        $pdata['address2'] = !empty($s['address2']) ? trim($s['address2']) : "";
        $pdata['city'] = !empty($s['city']) ? trim($s['city']) : "";
        $pdata['state'] = !empty($s['state']) ? trim($s['state']) : "";
        $pdata['pincode'] = !empty($s['pincode']) ? trim($s['pincode']) : "";
        $pdata['occupation'] = !empty($s['occupation']) ? trim($s['occupation']) : "";
       
         
        $insert_id = $this->dbapi->addCustomer($pdata);
        $customer = $this->dbapi->getBranchCustomersCnt($pdata['branch_id']);
        $branch_code = (!empty($_SESSION) && ($_SESSION['BRANCH_CODE'])) ? $_SESSION['BRANCH_CODE'] : '';
        $customer_cnt = str_pad($customer['customers_cnt'] + 1, 3, '0', STR_PAD_LEFT);
        $customer_id = customerFormat($customer_cnt, $branch_code);
        $this->dbapi->updateBranch(['customers_cnt' => $customer_cnt], $pdata['branch_id']);
        $this->dbapi->updateCustomer(['customer_id' => $customer_id, 'customer_no' => $customer_cnt], $insert_id);
        if (!empty($pdata['email'])) {
            $pdata['to'] = $pdata['email'];
            $pdata['customer_id'] = $customer_id;
            $pdata['subject'] = "Customer Registration";
            $this->sendEmail("email/customer-registration", $pdata);
        }
        $admin=$this->dbapi->getBranchAdmin($_SESSION['BRANCH_ID']);
        $mybranch=$this->dbapi->getBranchById($_SESSION['BRANCH_ID']);
        if (!empty($admin['email'])) {
            $pdata['to'] = $admin['email'];
            $pdata['customer_id'] = $customer_id;
            $pdata['subject'] = "Customer Registration";
            $pdata['branch_data']=$mybranch;
            $this->sendEmail("admin/email/customer-registration", $pdata);
        }
        
        $this->sendSMS($pdata['mobile'],"Greetings from ".$mybranch['name'].", Thank you ".$pdata['first_name']." for choosing HiFi. Your Customer Id is: ".$customer_id.', Please use this for further interactions, K.SaiBabu, Hi.Fi Technologies, Hyd, 9490746511');
        $customer_id = str_replace('/', '-', $customer_id);
        $img_path = "data/customers/" . $customer_id . "/";
        createFolder($img_path);
        $this->dbapi->updateCustomer(['img_path' => $img_path], $insert_id);
        $img = uploadImage('photo', $img_path, 'profile' . $insert_id, 200);
        if ($img !== false) {
            $this->dbapi->updateCustomer(['img' => $img, 'thumb_img' => 'thumb_' . $img], $insert_id);
        }
        if (!empty($s['company_name'])) {
            $comData = array();
            $comData['company_name'] = !empty($s['company_name']) ? trim($s['company_name']) : "";
            $comData['company_mail'] = !empty($s['company_mail']) ? trim($s['company_mail']) : "";
            $comData['contact_name'] = !empty($s['company_user_name']) ? trim($s['company_user_name']) : "";
            $comData['phone'] = !empty($s['company_mobile']) ? trim($s['company_mobile']) : "";
            $comData['gst_no'] = !empty($s['gst_no']) ? trim($s['gst_no']) : "";
            $comData['location'] = !empty($s['location']) ? trim($s['location']) : "";
            $comp_last_id = $this->dbapi->addCompany($comData);
            $mData = array();
            $mData['customer_id'] = $insert_id;
            $mData['company_id'] = $comp_last_id;
            $this->dbapi->addCompanyCustomers($mData);
        }
        return $insert_id; 
    }
    public function index()
    {
        $data = array();
        $this->header_data['title'] = "Add Customer";
      
       
        $data['states'] = $this->dbapi->getStatesList();
        if (!empty($_POST['first_name'])) {
           
                $customer = $this->addCustomer($_POST);
                 if (!empty($customer)) {
                   
                    $nData = [];
                    $nData['customer_id'] = $customer;
                    $nData['notification_type_id'] = 1;
                    $notification_id = $this->notification->addNotification($nData);
                    $sData = [];
                    $sData['notification_id'] = $notification_id;
                    $admin = $this->reception->getBranchAdmin($_SESSION['BRANCH_ID']);
                  
                    $users = [1, $admin['user_id']];
                    foreach ($users as $user) {
                        $sData['user_id'] = $user;
                        $this->notification->addNotificationStatus($sData);
                    }
                   
                    $aData = [];
                    $aData['user_id'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                    $aData['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
                    $aData['type_id'] = 1;
                    $aData['customer_id'] = $customer;
                    $this->reception->addActivity($aData);
                    $_SESSION['message'] = "Customer added successfully.";
                    $data['customer'] = $this->dbapi->getCustomerById($customer);
                } 
           
            
        }
        $this->_template('customers/form', $data);
    }
    public function getCustomerById()
    {
        if (!empty($this->_REQ['pk_id'])) {
            $data = [];
            $pk_id = $this->_REQ['pk_id'];
            $data['customer'] = $this->dbapi->getCustomerById($pk_id);
            $this->load->view('inwards/form-data', $data);
        }
    }
    public function getCustomerAndInwardsByCId()
    {
        if (!empty($this->_REQ['pk_id'])) {
            $data = [];
            $pk_id = $this->_REQ['pk_id'];
            $data['customer'] = $this->dbapi->getCustomerById($pk_id);
            $data['inwards']= $this->inward->searchInwards(['customer_id' => $data['customer']['customer_no'], 'branch_id' =>$data['customer']['branch_id']]);
            $this->load->view('customers/inwards', $data);
        }
    }
}