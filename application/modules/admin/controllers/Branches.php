<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Branches extends MY_Controller
{
    public $header_data = array();
    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["SUPER_ADMIN"]);
        $this->load->model("Branch_model", "dbapi", TRUE);
    }
    public function index()
    {        
        if (!empty($_GET['act']) && $_GET['act'] == "status" && !empty($_GET['pk_id']) && isset($_GET['sta'])) {
            $is_active = (!empty($_GET['sta']) && $_GET['sta'] == "1") ? "1" : "0";
            $this->dbapi->updateBranch(array("is_active" => $is_active), $_GET['pk_id']);
            redirect(base_url() . "admin/branches/");
        }
        $data = array();
        $this->header_data['title'] = "::  Branches ::";
        $search_data = array();
        if (!empty($this->_REQ['location'])) {
            $search_data['location'] = $this->_REQ['location'];
        }
        $this->load->library('Pagenavi');
        $this->pagenavi->search_data = $search_data;
        $this->pagenavi->per_page = 20;
        $this->pagenavi->base_url = base_url() . 'admin/branches/?';
        $this->pagenavi->process($this->dbapi, 'searchBranches');
        $data['PAGING'] = $this->pagenavi->links_html;
        $data['branches'] = $this->pagenavi->items;
        $this->_template('branches/index', $data);
    }
    public function postData($data)
    {
        $pdata = [];
        $inward_code = !empty($data['inward_code']) ? trim($data['inward_code']) : '';
        $inward_code = str_replace(' ', '', $inward_code);
        $pdata['name'] = !empty($data['name']) ? trim($data['name']) : '';
        $pdata['branch_code'] = !empty($data['branch_code']) ? trim($data['branch_code']) : '';
        $pdata['inward_code'] = $inward_code;
        $pdata['location_id'] = !empty($data['location_id']) ? trim($data['location_id']) : '';
        $pdata['address1'] = !empty($data['address1']) ? trim($data['address1']) : '';
        $pdata['address2'] = !empty($data['address2']) ? trim($data['address2']) : '';
        $pdata['phone_1'] = !empty($data['phone_1']) ? trim($data['phone_1']) : '';
        $pdata['phone_2'] = !empty($data['phone_2']) ? trim($data['phone_2']) : '';
        $pdata['mobile_1'] = !empty($data['mobile_1']) ? trim($data['mobile_1']) : '';
        $pdata['mobile_2'] = !empty($data['mobile_2']) ? trim($data['mobile_2']) : '';
        $pdata['email'] = !empty($data['email']) ? trim($data['email']) : '';
        $pdata['city'] = !empty($data['city']) ? trim($data['city']) : '';
        $pdata['state_code'] = !empty($data['state_code']) ? trim($data['state_code']) : '';
        $pdata['pincode'] = !empty($data['pincode']) ? trim($data['pincode']) : '';
        $pdata['branch_info'] = !empty($data['branch_info']) ? trim($data['branch_info']) : '';
        $pdata['gst_no'] = !empty($data['gst_no']) ? trim($data['gst_no']) : '';
        $pdata['hsn_no'] = !empty($data['hsn_no']) ? trim($data['hsn_no']) : '';
        $pdata['pan_no'] = !empty($data['pan_no']) ? trim($data['pan_no']) : '';
        $pdata['bank_info'] = !empty($data['bank_info']) ? trim($data['bank_info']) : '';
        $pdata['ifsc_no'] = !empty($data['ifsc_no']) ? trim($data['ifsc_no']) : '';
        $pdata['account_no'] = !empty($data['account_no']) ? trim($data['account_no']) : '';
        $pdata['reference'] = !empty($data['reference']) ? trim($data['reference']) : '';
        $pdata['other_location'] = !empty($data['other_location']) ? trim($data['other_location']) : '';
        $pdata['proforma_reference'] = !empty($data['proforma_reference']) ? trim($data['proforma_reference']) : '';
        $pdata['remarks'] = !empty($data['remarks']) ? trim($data['remarks']) : '';

        $pdata['inwards_tc'] = !empty($data['inwards_tc']) ? trim($data['inwards_tc']) : '';
        $pdata['outwards_tc'] = !empty($data['outwards_tc']) ? trim($data['outwards_tc']) : '';
        $pdata['quotation_tc'] = !empty($data['quotation_tc']) ? trim($data['quotation_tc']) : '';
        $pdata['proforma_invoice_tc'] = !empty($data['proforma_invoice_tc']) ? trim($data['proforma_invoice_tc']) : '';
        return $pdata;
    }
    public function add()
    {
        $data = array();
        $this->header_data['title'] = ":: Add  Branches ::";
        if (!empty($_POST['name'])) {
            $pdata = [];
            $pdata = $this->postData($_POST);
            if(!empty($pdata['state_code']) && ($pdata['state_code']!='OTH')){
                $pdata['other_location'] = '';
            }
            $branch_id = $this->dbapi->addBranch($pdata);
            if ($branch_id) {
                $this->load->model("Sequence_model", "sequenceM", TRUE);
                $types = ['TAX_INVOICE','OUTWARD','INWARD','PROFORMA','QUOTATION','INWARD_CHALLAN','OUTWARD_CHALLAN'];
                foreach($types as $type){
                    $sequence = [];
                    $sequence['branch_id'] = $branch_id;
                    $sequence['action_type'] = $type;
                    $sequence['number'] = 0;
                    $sequence['created_on'] = date('Y-m-d H:i:s');
                    $sequence['updated_on'] = date('Y-m-d H:i:s');
                    $this->sequenceM->addBranchNumberSequence($sequence);
                }
                $img_path = '/data/branches/';
                if (!empty($_FILES['branch_logo']) && ($_FILES['branch_logo']['size'] > 0)) {
                    $img = uploadImage('branch_logo', $img_path, 'logo' . $branch_id, 200);
                    $this->dbapi->updateBranch(["branch_logo" => $img], $branch_id);
                }
                $_SESSION['message'] = "New Branch Added Successfully";
                redirect(base_url() . 'admin/branches/');
            } else {
                $_SESSION['error'] = "Failed to add New Branch";
                $data['branch'] = $_POST;
            }
        }
        $data['locations'] = $this->dbapi->getLocationsList();
        $data['states'] = $this->dbapi->getStatesList();
        $this->_template('branches/form', $data);
    }
    public function edit($pk_id = '')
    {
        $data = array();
        $this->header_data['title'] = ":: Edit Branches ::";
        if (!empty($_POST['pk_id'])) {
            $pdata = [];
            $pdata = $this->postData($_POST);
            if(!empty($pdata['state_code']) && ($pdata['state_code']!='OTH')){
                $pdata['other_location'] = '';
            }
            $this->dbapi->updateBranch($pdata, $_POST['pk_id']);
            if ($_POST['pk_id']) {
                $img_path = '/data/branches/';
                if (!empty($_FILES['branch_logo']) && ($_FILES['branch_logo']['size'] > 0)) {
                    $img = uploadImage('branch_logo', $img_path, 'logo' . $_POST['pk_id'], 200);
                    $this->dbapi->updateBranch(["branch_logo" => $img], $_POST['pk_id']);
                }
                $_SESSION['message'] = "Branch Updated Successfully";
                redirect(base_url() . 'admin/branches/');
            } else {
                $_SESSION['error'] = "Failed to update Branch";
                $data['branch'] = $_POST;
            }
        }
        if (!empty($pk_id)) {
            $data['branch'] = $this->dbapi->getBranchById($pk_id);
        }
        $data['locations'] = $this->dbapi->getLocationsList();
        $data['states'] = $this->dbapi->getStatesList();
        $this->_template('branches/form', $data);
    }
}
