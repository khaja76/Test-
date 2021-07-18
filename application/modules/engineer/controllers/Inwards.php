<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inwards extends MY_Controller
{
    public $header_data = array();

    function __construct()
    {
        parent::__construct();
        $this->load->model("admin/Spare_model", "spare", TRUE);
        $this->header_data['spare_grant_cnt'] = $this->spare->searchApprovedSparesCnt();
        $this->load->model("Inward_model", "dbapi", TRUE);
        $this->load->model("Engineer_model", "engineer", TRUE);
        $this->load->model("Notification_model", "notification", TRUE);
        $this->header_data['approvals'] = $this->engineer->getApprovalStatus(['today'=>date('Y-m-d')],"CNT");
    }

    public function index()
    {
        $data = [];
        $search_data = [];
        $this->header_data['title'] = "Inwards";
        $type = !empty($_GET['type']) ? "type=".$_GET['type'] : '';
        $search_data['branch_id'] = $_SESSION['BRANCH_ID'];
        $search_data['assigned_to'] = $_SESSION['USER_ID'];
        if (!empty($this->_REQ['from_date'])) {
            $search_data['from_date'] = dateRangeForm2DB($this->_REQ['from_date']);
            $search_data['to_date'] = dateRangeForm2DB($this->_REQ['to_date']);
        } else if (!isset($_GET['type'])) {
            $search_data['date'] = date('Y-m-d');
        }
        $this->load->library('Pagenavi');
        $this->pagenavi->search_data = $search_data;
        $this->pagenavi->per_page = 20;
        $this->pagenavi->base_url = base_url() . 'engineer/inwards/?'.$type;
        $this->pagenavi->process($this->dbapi, 'searchInwards');
        $data['PAGING'] = $this->pagenavi->links_html;
        $data['inwards'] = $this->pagenavi->items;
        $data['status_list'] = $this->dbapi->getStatusList();
        $data['components'] = $this->engineer->searchComponents();
        $this->_template("inwards/index", $data);
    }

    public function view()
    {
        $this->header_data['title'] = "View Inwards ";
        $data = array();
        if (!empty($this->_REQ['inward'])) {
            $inward_id = !empty($this->_REQ['inward']) ? $this->_REQ['inward'] : '';
            $data['inward'] = $this->dbapi->getInwardByJobId($inward_id);
        }
        $this->_template('inwards/view', $data);
    }

    public function updateInwardStatus()
    {        
        //print_r($_POST);
        if (!empty($this->_REQ['inwardPkId']) && !empty($this->_REQ['status'])) {
            $sData = [];
            $sData['inward_id'] = !empty($this->_REQ['inwardPkId']) ? $this->_REQ['inwardPkId'] : '';
            $sData['status'] = !empty($this->_REQ['status']) ? $this->_REQ['status'] : '';
            $sData['remarks'] = !empty($this->_REQ['remarks']) ? $this->_REQ['remarks'] : '';
            $sData['user_id'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
            
            $sta = $this->dbapi->addInwardStatus($sData);
            $this->dbapi->updateInward(['status' => $sData['status']], $sData['inward_id']);
            $nData = [];
            if ($sData['status'] == "SPARE REQUIREMENT") {
                $qData = [];
                $qData['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
                $qData['location_id'] = !empty($_SESSION['LOCATION_ID']) ? $_SESSION['LOCATION_ID'] : '';
                $qData['created_by'] = $sData['user_id'];
                $qData['component_name'] = !empty($this->_REQ['component']) ? $this->_REQ['component'] : '';
                $qData['component_model'] = !empty($this->_REQ['component_model']) ? $this->_REQ['component_model'] : '';
                $qData['quantity'] = !empty($this->_REQ['quantity']) ? $this->_REQ['quantity'] : '';
                $qData['remarks'] = $sData['remarks'];
                $qData['job_id'] = $sData['inward_id'];
                $last_req_id = $this->spare->addSpareRequest($qData);                
                if (!empty($_FILES['component_image']['name'])) {
                    $folder = '/data/spare-requests/';
                    $img = imgUpload('component_image', $folder, 'spare-component' . $last_req_id);
                    $this->spare->updateSpareRequest(['component_image' => $folder . '' . $img], $last_req_id);
                }
                $nData['notification_type_id'] = 5;
            } else {
                $nData['notification_type_id'] = 4;
            }

            $nData['inward_status'] = $sData['status'];
            $nData['inward_id'] = $this->_REQ['inwardPkId'];

            $notification_id = $this->notification->addNotification($nData);
            $sData = [];
            $sData['notification_id'] = $notification_id;

            $admin = $this->engineer->getBranchAdmin($_SESSION['BRANCH_ID']);
  
            $users = [1, $admin[0]['user_id']];
            foreach ($users as $user) {
                $sData['user_id'] = $user;
                $this->notification->addNotificationStatus($sData);
            }


            if ($sta) {
                echo "TRUE";
            } else {
                echo "FALSE";
            }
        }
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
            $dates = [];
            $dates = $this->dbapi->getInwardHistoryByIdGroupByDate(['inward_no' => $pk_id, 'branch_id' => $branch_id]);
            if (!empty($dates)) {
                foreach ($dates as &$date) {
                    $date['inwards'] = $this->dbapi->getInwardHistoryByIdC(['inward_id' => $date['inward_id'], 'date' => $date['date']]);
                    if (!empty($date['inwards'])) {
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
        }
        $data['dates'] = $dates;
        $this->_template("inwards/history", $data);
    }

    public function damage()
    {
        $this->header_data['title'] = " Damaged Images ";
        $data = array();

        if (!empty($this->_REQ['inward'])) {
            $inward_no = $this->_REQ['inward'];
            $data['inward'] = $this->dbapi->getInwardByJobId($inward_no);
        }
        if (!empty($_POST['pk_id'])) {
            $job_id = !empty($_POST['job_id']) ? $_POST['job_id'] : '';
            $pk_id = !empty($_POST['pk_id']) ? $_POST['pk_id'] : '';
            $remarks = !empty($_POST['remarks']) ? $_POST['remarks'] : '';
            $user = $_SESSION['USER_ID'];
            $status = "DAMAGED";
            $customer = $this->dbapi->getCustomerById($_POST['customer_id']);
            $this->dbapi->addInwardStatus(['inward_id' => $pk_id, 'user_id' => $user, 'status' => $status, 'remarks' => $remarks]);
            $folder = str_replace('/', '-', $job_id);
            $img_path = $customer['img_path'] . 'damage/' . $folder . '/';
            createFolder($img_path);
            if (!empty($_FILES['photo'])) {
                uploadThumbFiles($img_path, 'photo', 200);
            }

            $nData = [];
            $nData['notification_type_id'] = 11;
            $nData['inward_status'] = $status;
            $nData['inward_id'] = $pk_id;
            $nData['inward_status'] = "DAMAGED";
            $notification_id = $this->notification->addNotification($nData);
            $stData = [];
            $stData['notification_id'] = $notification_id;

            $admin = $this->engineer->getBranchAdmin($_SESSION['BRANCH_ID']);            
            $users = [1, $admin[0]['user_id']];                        
            foreach ($users as $user) {
                $stData['user_id'] = $user;
                $this->notification->addNotificationStatus($stData);
            }
            $this->dbapi->updateInward(["damage_img_path" => $img_path], $pk_id);
            $_SESSION['message'] = 'Damaged Images added Successfully !';
            redirect(base_url() . 'engineer/inwards/damage/?inward=' . $_POST['inward_no']);
        }

        $this->_template('inwards/damage', $data);
    }

    public function approvals()
    {
        $data = [];
        $this->header_data['title'] = " Inward Approvals";
        $search_data=[];
        if (!empty($this->_REQ['from_date'])) {
            $search_data['from_date'] = dateRangeForm2DB($this->_REQ['from_date']);
            $search_data['to_date'] = dateRangeForm2DB($this->_REQ['to_date']);
        } else {
            $search_data['today'] = date('Y-m-d');
        }
        $data['inwards'] = $this->engineer->getApprovalStatus($search_data);
        $data['status_list'] = $this->dbapi->getStatusList();
        $data['components'] = $this->engineer->searchComponents();
        $this->_template('inwards/approvals', $data);

    }
}