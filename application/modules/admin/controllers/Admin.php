<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller
{
    public $header_data = array();

    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["SUPER_ADMIN", "ADMIN","RECEPTION","ENGINEER"]);
        $this->load->model("Admin_model", "admin", TRUE);
        $this->load->model("Message_model", "message", TRUE);
        $this->load->model("Notification_model", "dbapi", TRUE);
        $this->load->model("Spare_model", "spare", TRUE);
        $this->load->model("Inward_model", "inward", TRUE);
        $this->load->model("Quotation_model", "quotation", TRUE);
        $this->load->model("Proforma_model", "proforma", TRUE);
        $this->load->model("Payment_model", "payment", TRUE);
    }

    public function index()
    { // Default Page After Login
        $data = array();
        $this->header_data['title'] = ":: Dashboard ::";

        if (!empty($_SESSION) && ($_SESSION['ROLE'] == "SUPER_ADMIN")) {
            $data['locationCnt'] = $this->admin->getLocationsCnt();
            $data['branchCnt'] = $this->admin->getBranchesCnt();
            $data['adminCnt'] = $this->admin->getUsersCnt(['role' => 'ADMIN']);
            $data['receptionCnt'] = $this->admin->getUsersCnt(['role' => 'RECEPTIONIST']);
            $data['engineerCnt'] = $this->admin->getUsersCnt(['role' => 'ENGINEER']);
            $data['customerCnt'] = $this->admin->getCustomersCnt();
            $data['inwardsCntAll'] = $this->admin->getInwardsCnt();
            $data['outwardsCntAll'] = $this->admin->getOutwardsCnt();
            $data['quotationCntAll'] = $this->quotation->searchQuotations([], $mode = 'CNT');
        } else {
            $branch_id = $_SESSION['BRANCH_ID'];
            $date = date("Y-m-d");
            $data['notificationCnt'] = $this->dbapi->searchNotifications(['date' => $date], $mode = 'CNT');
            $data['notificationCntAll'] = $this->dbapi->searchNotifications(['view_all' => 'YES'], $mode = 'CNT');
            $data['inwardsCnt'] = $this->admin->getInwardsCnt(['branch_id' => $branch_id, 'date' => $date]);
            $data['inwardsCntAll'] = $this->admin->getInwardsCnt(['branch_id' => $branch_id]);
            $data['outwardsCnt'] = $this->admin->getOutwardsCnt(['branch_id' => $branch_id, 'date' => $date]);
            $data['outwardsCntAll'] = $this->admin->getOutwardsCnt(['branch_id' => $branch_id]);
            $data['messagesCnt'] = $this->message->searchInboxMessages(['user_id' => $_SESSION['USER_ID'], 'date' => $date], 'CNT');
            $data['messagesCntAll'] = $this->message->searchInboxMessages(['user_id' => $_SESSION['USER_ID']], 'CNT');
            $data['spareReqCnt'] = $this->spare->searchSpareRequests(['branch_id' => $branch_id, 'date' => $date], $mode = 'CNT');
            $data['spareReqCntAll'] = $this->spare->searchSpareRequests(['branch_id' => $branch_id], $mode = 'CNT');
            $data['quotationCntAll'] = $this->quotation->searchQuotations(['branch_id' => $branch_id], $mode = 'CNT');
            //Payments
            $data['duesAmt'] = $this->admin->getInwardsCnt(['branch_id' => $branch_id, 'paid' => false]);
            $data['doneAmt'] = $this->admin->getInwardsCnt(['branch_id' => $branch_id, 'paid' => true]);
        }
        $data['paymentCntAll'] = $this->payment->getPaymentsList([], $mode = 'CNT');
        $data['proformaCntAll'] = $this->proforma->getProformaJobs([], $mode = 'CNT');
        $this->_template('home', $data);
    }

    // View Roles
    public function getUserRoles()
    {
        $sel_roles = [];
        $roles = $this->admin->getRolesList();
        if ($_SESSION['ROLE'] == "SUPER_ADMIN") {
            $sel_roles['ADMIN'] = $roles['ADMIN'];
        } else if ($_SESSION['ROLE'] == "ADMIN") {
            $sel_roles['RECEPTIONIST'] = $roles['RECEPTIONIST'];
            $sel_roles['ENGINEER'] = $roles['ENGINEER'];
        }
        return $sel_roles;
    }

    public function fetch_branches()
    {
        if (!empty($this->_REQ['location_id'])) {
            $locations = $this->admin->getBranchesList($this->_REQ['location_id']);
            echo json_encode($locations);
        }
    }

    public function fetchUserByRole()
    {
        $branch_id = !empty($this->_REQ['branch_id']) ? $this->_REQ['branch_id'] : '';
        if (!empty($this->_REQ['role'])) {
            $users = $this->admin->getUsersList(['role' => $this->_REQ['role'], 'branch_id' => $branch_id]);
        } else {
            $users = $this->admin->getUsersList(['branch_id' => $branch_id]);
        }
        echo json_encode($users);
    }

    public function fetchJobsByUserId()
    {
        if (!empty($this->_REQ['branch_id'])) {
            $branch_id = !empty($this->_REQ['branch_id']) ? $this->_REQ['branch_id'] : '';
            $users = $this->admin->getJobsList([
                'role' => !empty($this->_REQ['role']) ? $this->_REQ['role'] : '',
                'user_id' => !empty($this->_REQ['user_id']) ? $this->_REQ['user_id'] : '',
                'branch_id' => $branch_id
            ]);
        } else {
            $users = $this->admin->getJobsList(['branch_id' => $_SESSION['BRANCH_ID']]);
        }
        echo json_encode($users);
    }

    public function getNotifications()
    {
        //$data = [];

        $notifications_cnt = $this->dbapi->searchNotifications([], 'CNT');
        $notifications = $this->dbapi->searchNotifications(['limit' => 3]);
        if (!empty($notifications)) {
            foreach ($notifications as &$notification) {
                $notification['title'] = str_replace("{{user_name}}", $notification['created_by'], $notification['title']);
                $notification['title'] = str_replace("{{customer_name}}", $notification['customer_name'], $notification['title']);
                $notification['title'] = str_replace("{{sub_ordinate}}", $notification['subordinate_name'], $notification['title']);
                $notification['title'] = str_replace("{{branch}}", $notification['branch_name'], $notification['title']);
                $notification['title'] = str_replace("{{job_id}}", $notification['job_id'], $notification['title']);
                $notification['title'] = str_replace("{{inward_challan}}", $notification['inward_challan'], $notification['title']);
                $notification['title'] = str_replace("{{outward_challan}}", $notification['outward_challan'], $notification['title']);
                if (!empty($notification['inward_status'])) {
                    $notification['title'] = str_replace("{{status}}", $notification['inward_status'], $notification['title']);
                }
            }
        }
        $data['notification_cnt'] = $notifications_cnt;
        $data['notifications'] = $notifications;
        $this->load->view('notifications', $data);
    }

    public function fetchJobsByBranchId()
    {
        $branch_id = !empty($this->_REQ['branch_id']) ? $this->_REQ['branch_id'] : '';
        $user_id = !empty($this->_REQ['user_id']) ? $this->_REQ['user_id'] : '';
        if ($branch_id != 0) {
            $users = $this->admin->getJobsList($branch_id);
        } else {
            $branchUser = $this->admin->getBranchIdByUserId($user_id);
            $users = $this->admin->getJobsList($branchUser['branch_id']);
        }
        echo json_encode($users);
    }

    public function getUserById()
    {
        if (!empty($this->_REQ['user_id'])) {
            $users = $this->admin->getUserById($this->_REQ['user_id']);
            echo json_encode($users);
        }
    }

    public function removeImages()
    {
        if (!empty($_POST)) {
            foreach ($_POST as $file) {
                $file = FCPATH . $file;
                if (file_exists($file)) {
                    unlink($file);
                }
            }
            echo 'success';
        }
    }

    public function accept_approval()
    {
        if (!empty($this->_REQ)) {
            $hData = [];
            $hData['inward_id'] = $this->_REQ['ap_pk_id'];
            $hData['status'] = 'APPROVAL';
            $hData['remarks'] = '';
            $hData['user_id'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';

            $aData = [];
            $aData['inward_id'] = $this->_REQ['ap_pk_id'];
            $aData['approved_by'] = $this->_REQ['approved_by'];
            $aData['approval_taken_by'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
            $aData['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
            $aData['location_id'] = !empty($_SESSION['LOCATION_ID']) ? $_SESSION['LOCATION_ID'] : '';
            $aData['approved_date'] = date('Y-m-d H:i:s');
            $aData['is_viewed_admin'] = 'NO';
            $aData['is_viewed_engineer'] = 'NO';

            $this->inward->addApprovalStatus($aData);
            $sta = $this->inward->addInwardStatus($hData);
            $this->inward->updateInward(['is_approved' => 'YES', 'approved_time' => date('Y-m-d H:i:s'), 'approved_by' => $this->_REQ['approved_by']], $this->_REQ['ap_pk_id']);
            echo "TRUE";
        }
    }

    public function send_sms()
    {
        if (!empty($this->_REQ)) {
            $pdata = $this->_REQ;

            if ($pdata['type_message'] == 'SMS') {
                if ($pdata['_smsTo'] == '1') {
                    $status = $this->sendSMS($pdata['sms_to_mobile'][0], $pdata['sms_message']);
                } else if ($pdata['_smsTo'] == '2') {
                    $status = $this->sendSMS($pdata['sms_to_mobile'][1], $pdata['sms_message']);
                } else {
                    foreach ($pdata['sms_to_mobile'] as $mobile) {
                        $status = $this->sendSMS($mobile, $pdata['sms_message']);
                    }
                }
                if (!empty($status)) {
                    echo "TRUE";
                }
            } else {
                if ($pdata['_smsTo'] == '1') {
                    $mdata['to'] = $pdata['sms_to_email'][0];
                    $mdata['subject'] = $pdata['subject'];
                    $mdata['body'] = $pdata['sms_message'];
                    $this->sendEmail("", $mdata);
                    echo "TRUE";

                } else if ($pdata['_smsTo'] == '2') {
                    $mdata['to'] = $pdata['sms_to_email'][1];
                    $mdata['subject'] = $pdata['subject'];
                    $mdata['body'] = $pdata['sms_message'];
                    $this->sendEmail("", $mdata);
                    echo "TRUE";
                } else {
                    foreach ($pdata['sms_to_email'] as $email) {
                        $mdata['to'] = $email;
                        $mdata['subject'] = $pdata['subject'];
                        $mdata['body'] = $pdata['sms_message'];
                        $this->sendEmail("", $mdata);
                    }
                    echo "TRUE";
                }
            }
        }
    }

}