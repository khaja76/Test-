<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Customers extends MY_Controller
{
    public $header_data = array();
    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["ADMIN","SUPER_ADMIN"]);
        $this->load->model("Customers_model", "dbapi", TRUE);
        $this->load->model("Notification_model", "notification", TRUE);
        $this->load->model("Inward_model", "inward", TRUE);
    }
    private function addCustomer($s = [])
    {
        $pdata = array();
        $checkEmail = $this->dbapi->searchCustomers(['type'=>'email','data'=>$s['email']]);
        if(!empty($checkEmail)){           
            $checkMobile = $this->dbapi->searchCustomers(['type'=>'mobile','data'=>$s['mobile']]); 
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
            //$pdata['cc']='sairam@mydwayz.com';
            $pdata['customer_id'] = $customer_id;
            $pdata['subject'] = "Customer Registration";
            $pdata['branch_data']=$this->dbapi->getBranchById($_SESSION['BRANCH_ID']);
            $this->sendEmail("email/customer-registration", $pdata);
        }
        $this->sendSMS($pdata['mobile'], "Greetings from HiFi Technologies, Thank you " . $pdata['first_name'] . " for choosing HiFi. Your Customer Id is: " . $customer_id . ', Please use this for further interactions.K.SaiBabu, Hi.Fi Technologies, Hyd, 9490746511.');
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
    public function add()
    {
        $this->_user_login_check(["ADMIN"]);
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
                $sData['user_id'] = 1;
                $this->notification->addNotificationStatus($sData);
                $_SESSION['message'] = "Customer added successfully.";
                $data['customer'] = $this->dbapi->getCustomerById($customer);
            }
        }
        $this->_template('customers/form', $data);
    }
    public function index()
    {
        $data = [];
        $this->header_data['title'] = "Customers";
        $search_data = array();
        if (!empty($this->_REQ['location_id'])) {
            $search_data['location_id'] = $this->_REQ['location_id'];
        }
        if (!empty($this->_REQ['branch_id'])) {
            $search_data['branch_id'] = $this->_REQ['branch_id'];
        } else {
            $search_data['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
        }
        if (!empty($this->_REQ['select_type'])) {
            $search_data['type'] = $this->_REQ['select_type'];
            $search_data['data'] = $this->_REQ['name'];
        }
        if (!empty($_SESSION) && ($_SESSION['ROLE'] == "ADMIN")) {
            $search_data['branch_id'] = $_SESSION['BRANCH_ID'];
        }
        $this->load->library('Pagenavi');
        $this->pagenavi->search_data = $search_data;
        $this->pagenavi->per_page = 10;
        $this->pagenavi->base_url = base_url() . 'admin/customers/?';
        $this->pagenavi->process($this->dbapi, 'searchCustomers');
        $data['PAGING'] = $this->pagenavi->links_html;
        $data['customers'] = $this->pagenavi->items;
        $data['locations'] = $this->dbapi->getLocationsList();
        $data['branches_else'] = $this->dbapi->getBranchesList(!empty($this->_REQ['location_id']) ? $this->_REQ['location_id'] : '');
        $this->_template("customers/index", $data);
    }
    public function view($str = '')
    {
        $data = array();
        $this->header_data['title'] = "::  Customer Profile ::";
        $pk_id = !empty($str) ? $str : 0;
        if (!empty($pk_id)) {
            $customer = $this->dbapi->getCustomerById($pk_id);
            $data['inwards'] = $this->inward->searchInwards(['customer_id' => $customer['customer_no'], 'branch_id' => $customer['branch_id']]);
            $data['profile'] = $customer;
        }
        $this->_template('customers/view', $data);
    }
    public function edit($str = '')
    {
        $this->_user_login_check(["ADMIN"]);
        $data = array();
        $this->header_data['title'] = ":: Edit Customer Profile ::";
        $customer = $this->dbapi->getCustomerById($str);
        if (!empty($_POST['pk_id'])) {
            $pk_id = $_POST['pk_id'];
            $pdata['email'] = !empty($_POST['email']) ? trim($_POST['email']) : "";
            $pdata['location_id'] = $customer['location_id'];
            $pdata['branch_id'] = $customer['branch_id'];
            $pdata['first_name'] = !empty($_POST['first_name']) ? trim($_POST['first_name']) : "";
            $pdata['last_name'] = !empty($_POST['last_name']) ? trim($_POST['last_name']) : "";
            $pdata['mobile'] = !empty($_POST['mobile']) ? trim($_POST['mobile']) : "";
            $pdata['opt_mobile'] = !empty($_POST['opt_mobile']) ? trim($_POST['opt_mobile']) : "";
            $pdata['address1'] = !empty($_POST['address1']) ? trim($_POST['address1']) : "";
            $pdata['address2'] = !empty($_POST['address2']) ? trim($_POST['address2']) : "";
            $pdata['city'] = !empty($_POST['city']) ? trim($_POST['city']) : "";
            $pdata['state'] = !empty($_POST['state']) ? trim($_POST['state']) : "";
            $pdata['pincode'] = !empty($_POST['pincode']) ? trim($_POST['pincode']) : "";
            $pdata['occupation'] = !empty($_POST['occupation']) ? trim($_POST['occupation']) : "";
            $customer_id = !empty($_POST['customer_id']) ? trim($_POST['customer_id']) : "";
            $check_company = $this->dbapi->checkCustomerCompanyExists(['customer_id' => $pk_id]);
            $comData = array();
            $comData['company_name'] = !empty($_POST['company_name']) ? trim($_POST['company_name']) : "";
            $comData['company_mail'] = !empty($_POST['company_mail']) ? trim($_POST['company_mail']) : "";
            $comData['contact_name'] = !empty($_POST['company_user_name']) ? trim($_POST['company_user_name']) : "";
            $comData['phone'] = !empty($_POST['company_mobile']) ? trim($_POST['company_mobile']) : "";
            $comData['gst_no'] = !empty($_POST['gst_no']) ? trim($_POST['gst_no']) : "";
            if ($check_company) {
                $this->dbapi->updateCompany($comData, $check_company['company_id']);
            } else {
                if (!empty($_POST['company_name'])) {
                    $comp_last_id = $this->dbapi->addCompany($comData);
                    $mData = array();
                    $mData['customer_id'] = $pk_id;
                    $mData['company_id'] = $comp_last_id;
                    $this->dbapi->addCompanyCustomers($mData);
                }
            }
            $this->dbapi->updateCustomer($pdata, $_POST['pk_id']);
            $customer_id = str_replace('/', '-', $customer_id);
            $img_path = "data/customers/" . $customer_id . "/";
            $img = uploadImage('photo', $img_path, 'profile' . $_POST['pk_id'], 200);
            if ($img !== false) {
                $this->dbapi->updateCustomer(['img' => $img, 'thumb_img' => 'thumb_' . $img, 'img_path' => $img_path], $_POST['pk_id']);
            }
            $_SESSION['message'] = "Customer details Updated Successfuly !";
            redirect(base_url() . 'admin/customers/');
        }
        $data['states'] = $this->dbapi->getStatesList();
        $data['customer'] = $customer;
        $this->_template('customers/edit', $data);
    }
   
    function companies()
    {
        $this->header_data['title'] = " Customer Companies";
        $data = [];
        $data['customer_companies'] = $this->dbapi->searchCustomerCompanies();
        $this->_template('customer-companies/index', $data);
    }
    function send_sms(){

       $cust_ids=!empty($_POST['SMS_cust']) ? $_POST['SMS_cust']:'';
       $cust_meesage=!empty($_POST['SMS_custContent']) ? $_POST['SMS_custContent']:'';
       $custArray=explode(',',$cust_ids);
       foreach ($custArray as $customer_id){
           $customer = $this->dbapi->getCustomerById($customer_id);
           if(!empty($customer)){
               $this->sendSMS($customer['mobile'], "" . $cust_meesage . " .  K.SaiBabu, Hi.Fi Technologies, Hyd, 9490746511.");
           }
       }
    }
}
