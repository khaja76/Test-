<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Outwards extends MY_Controller
{
    public $header_data = array();
    function __construct()
    {
        parent::__construct();
        $this->load->model("Outward_model", "outward", TRUE);
        $this->load->model("Inward_model", "inward", TRUE);
        $this->load->model("Challan_model", "challan", TRUE);
        $this->load->model("Branch_model", "branch", TRUE);
        $this->load->model("Customers_model", "customer", TRUE);
        $this->load->model("Notification_model", "notification", TRUE);
    }
    public function index()
    {
        $this->header_data['title'] = "Outwards";
        if (!empty($this->_REQ['location_id'])) {
            $search_data['location_id'] = $this->_REQ['location_id'];
        } else {
            $search_data['location_id'] = !empty($_SESSION['LOCATION_ID']) ? $_SESSION['LOCATION_ID'] : '';
        }
        if (!empty($this->_REQ['branch_id'])) {
            $search_data['branch_id'] = $this->_REQ['branch_id'];
        } else {
            $search_data['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
        }
        if (!empty($this->_REQ['from_date'])) {
            $search_data['from_date'] = dateRangeForm2DB($this->_REQ['from_date']);
            $search_data['to_date'] = dateRangeForm2DB($this->_REQ['to_date']);
        } else if (!isset($_GET['type'])) {
            $search_data['outward_date'] = date('Y-m-d');
        }
        $this->load->library('Pagenavi');
        $this->pagenavi->search_data = $search_data;
        $this->pagenavi->per_page = 20;
        $this->pagenavi->base_url = base_url() . 'admin/outwards/?';
        $this->pagenavi->process($this->outward, 'searchOutwards');
        $data['PAGING'] = $this->pagenavi->links_html;
        $data['locations'] = $this->challan->getLocationsList();
        $data['branches_else'] = $this->challan->getBranchesList(!empty($this->_REQ['location_id']) ? $this->_REQ['location_id'] : '');
        $data['inwards'] = $this->pagenavi->items;
        $this->_template('outwards/index', $data);
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
            $search_data['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
        }
        if (!empty($this->_REQ['from_date'])) {
            $search_data['from_date'] = dateRangeForm2DB($this->_REQ['from_date']);
            $search_data['to_date'] = dateRangeForm2DB($this->_REQ['to_date']);
        } else {
            $search_data['date'] = date('Y-m-d');
        }
        $search_data['inward_challan'] = true;
        $data['inwards'] = $this->challan->getOutwardChallansList($search_data);
        $data['locations'] = $this->challan->getLocationsList();
        $data['branches_else'] = $this->challan->getBranchesList(!empty($this->_REQ['location_id']) ? $this->_REQ['location_id'] : '');
        $this->_template("outwards/challans", $data);
    }
    public function view()
    {
        $data = [];
        $pk_id = !empty($this->_REQ['challan']) ? $this->_REQ['challan'] : '';
        if (!empty($pk_id)) {
            $challan = $this->challan->getOutwardChallanById($pk_id);
            $data['outwards'] = $this->outward->searchOutwards(['outward_challan_id' => $pk_id]);
            $data['branch_data'] = $this->branch->getBranchById($challan['branch_id']);
            $data['customer'] = $this->inward->getCustomerById($data['outwards'][0]['customer_id']);
            $data['challan'] = $challan;
            $admin = $this->branch->getBranchAdmin($_SESSION['BRANCH_ID']);
            $data['to'] = $data['customer']['email'];
            $data['cc'] = $admin['email'];
            $data['subject'] = "Delivery Challan -".  $challan['challan'];
            $this->sendEmail("email/outward-challan", $data);
        }
        $this->header_data['title']=$challan['challan'];
        $this->_template('reception/outwards/view', $data);
    }
    public function challan_print()
    {
        $data = [];
        $pk_id = !empty($this->_REQ['challan']) ? $this->_REQ['challan'] : '';
        if (!empty($pk_id)) {
            $challan = $this->challan->getOutwardChallanById($pk_id);
            $data['outwards'] = $this->outward->searchOutwards(['outward_challan_id' => $pk_id]);
            $data['branch_data'] = $this->branch->getBranchById($challan['branch_id']);
            $data['customer'] = $this->inward->getCustomerById($data['outwards'][0]['customer_id']);
            $data['challan'] = $challan;
        }
        $this->header_data['title']=$challan['challan'];
        $this->load->view('reception/outwards/print', $data);
    }
    public function add()
    {
        $data = [];
        if (!empty($this->_REQ['type'])) {
            $type = $this->_REQ['type'];
            $value = $this->_REQ['value'];
            if ($type == 'customer_id') {
                $data['customer'] = $this->customer->getCustomerDetails(['customer_no' => $value]);
                $data['inwards'] = $this->inward->searchInwards(['customer_id' => $value, 'branch_id' => $_SESSION['BRANCH_ID'], 'is_outwarded' => 'NO']);
                $data['branch'] = $this->inward->getBranchById($_SESSION['BRANCH_ID']);
            } else {
                $inward = $this->inward->getInwardDetails(['job_id' => $value, 'branch_id' => $_SESSION['BRANCH_ID'], 'is_outwarded' => 'NO']);
                $data['customer'] = $this->customer->getCustomerDetails(['pk_id' => $inward[0]['customer_pk_id']]);
                $data['inwards'] = $inward;
                $data['branch'] = $this->inward->getBranchById($_SESSION['BRANCH_ID']);
            }
        }
        if (!empty($_POST['inward_no'])) {
            redirect(base_url() . 'admin/outwards/upload/?inward_no=' . $_POST['inward_no'] . '&select_type=customer_id&name=' . $_POST['customer_no']);
        }
        $this->_template('reception/outwards/index', $data);
    }
    public function upload()
    {
        $this->header_data['title'] = "Upload Outward Images ";
        $jobid = isset($_GET['inward_no']) ? $_GET['inward_no'] : '';
        $data['inward'] = $this->inward->getInwardByJobId($jobid);
        if (!empty($_POST['pk_id'])) {
            $job_id = !empty($_POST['job_id']) ? $_POST['job_id'] : '';
            $pk_id = !empty($_POST['pk_id']) ? $_POST['pk_id'] : '';
            $customer = $this->inward->getCustomerById($_POST['customer_id']);
            $branch_id = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
            $oData['remarks'] = !empty($_POST['remarks']) ? trim($_POST['remarks']) : '';
            $oData['customer_id'] = !empty($_POST['customer_id']) ? trim($_POST['customer_id']) : '';
            $oData['branch_id'] = $branch_id;
            $time = date('Y-m-d H:i:s');
            $oData['inward_id'] = $pk_id;
            $oData['job_id'] = $job_id;
            $oData['job_no'] = !empty($_POST['job_no']) ? trim($_POST['job_no']) : '';
            $hData = [];
            $hData['inward_id'] = $pk_id;
            $hData['status'] = 'OUTWARD';
            $hData['remarks'] = !empty($this->_REQ['remarks']) ? $this->_REQ['remarks'] : '';
            $hData['user_id'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
            $sta = $this->inward->addInwardStatus($hData);
            $this->inward->updateInward(['status' => $hData['status']], $pk_id);
            $smsMessage = "Your Item " . $job_id . " has been sent Outward. Thank you, from SaiBabu, Hifi Technologies, Hyd, 9490746511";
            $this->sendSMS($customer['mobile'], $smsMessage);
            $outward_lastid = $this->challan->addOutwards($oData); // Outward Creation
            $this->inward->updateInward(['is_outwarded' => 'YES', 'outward_date' => $time], $pk_id);
            $folder = str_replace('/', '-', $job_id);
            $img_path = $customer['img_path'] . 'outward/' . $folder . '/';
            createFolder($img_path);
            if (!empty($_FILES['photo'])) {
                uploadThumbFiles($img_path, 'photo', 200);
            }
            $this->challan->updateOutward(['outward_images_path' => $img_path], $outward_lastid);
            if (!empty($outward_lastid)) {
                redirect(base_url() . "admin/outwards/outwards-list/?customer_id=" . $oData['customer_id']);
            }
        }
        $this->_template('reception/outwards/upload', $data);
    }
    public function outwards_list()
    {
        $data = [];
        if (!empty($this->_REQ['customer_id'])) {
            $customer_id = $this->_REQ['customer_id'];
            $customer = $this->inward->getCustomerById($customer_id);
            $data['customer'] = $customer;
            $data['branch_data'] = $this->branch->getBranchById($_SESSION['BRANCH_ID']);
            if (!empty($customer)) {
                $data['outwards'] = $this->challan->getOutwardsList(['customer_id' => $customer_id]);
            }
            if (!empty($_POST['outward_ids'])) {
                $branch_id = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
                $pData['branch_id'] = $branch_id;
                $pData['financial_year'] = financialYear();
                $pData['created_by'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';                
                //$outwardCnt = $this->challan->getBranchOutwardChallansCnt($branch_id);
                $action_type = 'OUTWARD';
                $outwardCnt = $this->inward->getBranchSequenceNumber($_SESSION['BRANCH_ID'],$action_type);            
                
                $challan_no = str_pad($outwardCnt + 1, 3, '0', STR_PAD_LEFT);
                $branch_code = (!empty($_SESSION) && ($_SESSION['BRANCH_CODE'])) ? $_SESSION['BRANCH_CODE'] : '';
                $pData['challan'] = challanFormat($challan_no, $type = "OC", $branch_code);
                $pData['challan_no'] = $challan_no;
                $challan_id = $this->challan->addOutwardChallan($pData);
                $smsMessage = "Your Item(s) delivered with Challan " . $pData['challan'] . ".  K.SaiBabu, Hi.Fi Technologies, Hyd, 9490746511";
                $this->sendSMS($customer['mobile'], $smsMessage);
                if (!empty($challan_id)) {
                    $upd['number']=$outwardCnt+1;                
                    $this->inward->updateSequenceNumber($upd,$_SESSION['BRANCH_ID'],$action_type);                    
                    foreach ($_POST['outward_ids'] as $k => $v) {
                        //Update Remarks
                        $this->challan->updateOutward(['remarks' => $_POST['remarks'][$k]], $v);
                        $hData = [];
                        $hData['inward_id'] = $_POST['inward_ids'][$k];
                        $hData['status'] = 'DELIVERED';
                        $hData['remarks'] = '';
                        $hData['user_id'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                        $sta = $this->inward->addInwardStatus($hData);
                        $this->inward->updateInward(['status' => $hData['status']], $_POST['inward_ids'][$k]);
                        
                        $oData = [];
                        $oData['outward_challan_id'] = $challan_id;
                        $nData = [];
                        $nData['outward_challan_id'] = $challan_id;
                        $nData['inward_status'] = 'DELIVERED';
                        $nData['notification_type_id'] = 10;
                        $notification_id = $this->notification->addNotification($nData);
                        $sData = [];
                        $sData['notification_id'] = $notification_id;
                        $users = [1];
                        foreach ($users as $user) {
                            $sData['user_id'] = $user;
                            $this->notification->addNotificationStatus($sData);
                        }
                        $outward_id = !empty($_POST['outward_ids'][$k]) ? trim($_POST['outward_ids'][$k]) : '';
                        $inward_id = !empty($_POST['inward_ids'][$k]) ? trim($_POST['inward_ids'][$k]) : '';
                        $this->inward->updateInward(['outward_challan_id' => $challan_id], $inward_id);
                        $this->challan->updateOutward(['outward_challan_id' => $challan_id], $outward_id);
                    }
                    redirect(base_url() . 'admin/outwards/view/?challan=' . $challan_id);
                }
            }
            $this->_template('reception/outwards/list', $data);
        }
    }
}