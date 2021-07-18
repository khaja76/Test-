<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class SubOrdinates extends MY_Controller
{
    public $header_data = array();
    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["SUPER_ADMIN", "ADMIN"]);
        $this->load->model("Sub_ordinates_model", "dbapi", TRUE);
        $this->load->model("Admin_model", "admin", TRUE);
        $this->load->model("Notification_model", "notification", TRUE);
        $this->load->model("Inward_model", "inward", TRUE);
    }
    public function index($act = '', $str = '')
    {
        $this->header_data['title'] = " Sub Ordinates ";
        $data = array();
        $search_data = array();
        $this->load->library('Pagenavi');
        $this->pagenavi->search_data = $search_data;
        $this->pagenavi->per_page = 10;
        $this->pagenavi->base_url = base_url() . 'admin/subOrdinates/?';
        $this->pagenavi->process($this->dbapi, 'searchUsers');
        $data['PAGING'] = $this->pagenavi->links_html;
        $data['users'] = $this->pagenavi->items;
        $this->_template('subordinates/index', $data);
    }
    public function add()
    {
        $this->header_data['title'] = " Add Ordinates ";
        $data = array();
        if (!empty($_POST['name'])) {
            $pdata = $this->postData($_POST);
            if (!empty($_SESSION) && ($_SESSION['ROLE'] == "SUPER_ADMIN")) {
                $checkAdmin = $this->admin->checkBranchAdmin($pdata['branch_id']);
                if (!$checkAdmin) {
                    $user_id = $this->addUser($pdata);
                    if ($user_id) {
                        $pdata['to'] = $pdata['email'];
                        $pdata['subject'] = "New Registration";
                        $branch_d = $this->admin->getBranchById($pdata['branch_id']);
                        $pdata['branch_data'] = $branch_d;
                        $this->sendEmail("admin/email/registration", $pdata);
                        $_SESSION['message'] = "Sub Ordinate Added Successfully ";
                        redirect(base_url() . 'admin/subOrdinates/');
                    } else {
                        $_SESSION['error'] = "Failed to add Sub Ordinate";
                        $data['user'] = $_POST;
                    }
                } else {
                    $_SESSION['error'] = "Admin for this Branch is already Exists";
                    $data['user'] = $_POST;
                }
            } else {
                $user_id = $this->addUser($pdata);
                if ($user_id) {
                    /* For Notification Code Starts  */
                    $nData = [];
                    $nData['subordinate_id'] = $user_id;
                    $nData['notification_type_id'] = 8;
                    $notification_id = $this->notification->addNotification($nData);
                    $sData = [];
                    $sData['notification_id'] = $notification_id;
                    $sData['user_id'] = 1;
                    $this->notification->addNotificationStatus($sData);
                    /* Notification Code Ends */
                    $_SESSION['message'] = "Sub Ordinate Added Successfully";
                    redirect(base_url() . 'admin/subOrdinates/');
                } else {
                    $_SESSION['error'] = "Failed to add Sub Ordinate";
                    $data['user'] = $_POST;
                }
            }
        }
        $data['roles'] = $this->getUserRoles();
        $data['status'] = $this->admin->getRoleStatusList();
        $data['locations'] = $this->admin->getLocationsList();
        $data['branches'] = $this->admin->getBranchesList(!empty($this->_REQ['location_id']) ? $this->_REQ['location_id'] : '');
        $data['states'] = $this->dbapi->getStatesList();
        $this->_template('subordinates/form', $data);
    }
    public function edit($str = '')
    {
        $this->header_data['title'] = " Edit Ordinates ";
        $data = array();
        $user = $this->dbapi->getUserById($str);
        if (!empty($_POST['user_id'])) {
            $pdata = array();
            $check = $this->admin->checkUserEmail($_POST['email'], $_POST['user_id']);
            if (!$check) {
                $pdata = $this->postData($_POST);
                $img_path = $user['img_path'];
                if (!empty($_SESSION) && ($_SESSION['ROLE'] == "SUPER_ADMIN")) {
                    if ($pdata['role'] == 'ADMIN') {
                        $checkAdmin = $this->admin->checkBranchAdmin($pdata['branch_id'], $_POST['branch_pk_id']);
                        if (!$checkAdmin) {
                            $update = $this->updateUser($pdata, $img_path, $_POST['user_id']);
                            if ($update) {
                                $qdata = [];
                                $qdata['is_active'] = ($pdata['status'] == "ACTIVE") ? 1 : 0;
                                $qdata['role'] = $pdata['role'];
                                if (($pdata['location_id'] != $user['location_id']) || ($pdata['branch_id'] != $user['branch_id'])) {
                                    $qdata['location_id'] = $pdata['location_id'];
                                    $qdata['branch_id'] = $pdata['branch_id'];
                                    $qdata['user_id'] = $_POST['user_id'];
                                    $qdata['created_by'] = $_SESSION['USER_ID'];
                                    $this->dbapi->updateBranchUser(['is_active' => 0], $_POST['branch_pk_id']);
                                    $this->dbapi->addBranchUser($qdata);
                                } else {
                                    $this->dbapi->updateBranchUser($qdata, $_POST['branch_pk_id']);
                                }
                                $_SESSION['message'] = "Employee Details are updated Successfully";
                                redirect(base_url() . 'admin/subOrdinates/');
                            } else {
                                $_SESSION['error'] = "Failed to update Employee";
                                $data['user'] = $_POST;
                            }
                        } else {
                            $_SESSION['error'] = "Admin For this Branch is already Exists";
                            $data['user'] = $_POST;
                        }
                    } else {
                        $update = $this->updateUser($pdata, $img_path, $_POST['user_id']);
                        if ($update) {
                            $qdata = [];
                            $qdata['is_active'] = ($pdata['status'] == "ACTIVE") ? 1 : 0;
                            $qdata['role'] = $pdata['role'];
                            $this->dbapi->updateBranchUser($qdata, $_POST['branch_pk_id']);
                            //}
                            $_SESSION['message'] = "Employee Details are updated Successfully";
                            redirect(base_url() . 'admin/subOrdinates/');
                        } else {
                            $_SESSION['error'] = "Failed to update Employee";
                            $data['user'] = $_POST;
                        }
                    }
                } else {
                    $update = $this->updateUser($pdata, $img_path, $_POST['user_id']);
                    if ($update) {
                        $qdata = [];
                        $qdata['is_active'] = ($pdata['status'] == "ACTIVE") ? 1 : 0;
                        $qdata['role'] = $pdata['role'];
                        $this->dbapi->updateBranchUser($qdata, $_POST['branch_pk_id']);
                        $_SESSION['message'] = "Employee Details are updated Successfully";
                        redirect(base_url() . 'admin/subOrdinates/');
                    } else {
                        $_SESSION['error'] = "Failed to update Employee";
                        $data['user'] = $_POST;
                    }
                }
            } else {
                $_SESSION['error'] = "Mail Already Exists";
                $data['user'] = $_POST;
            }
        }
        $data['user'] = $user;
        $data['roles'] = $this->getUserRoles();
        $data['status'] = $this->admin->getRoleStatusList();
        $data['locations'] = $this->admin->getLocationsList();
        $data['branches'] = $this->admin->getBranchesList($user['location_id']);
        $data['documents'] = $this->admin->getUserDocumentsByUser($user['user_id']);
        $data['states'] = $this->dbapi->getStatesList();
        $this->_template('subordinates/form', $data);
    }
    private function addUser($pdata)
    {
        $user_id = $this->dbapi->addUser($pdata);
        $img_path = "data/users/" . slugify($pdata['name']) . "_" . $user_id . "/";
        createFolder($img_path);
        $this->dbapi->updateUser(['img_path' => $img_path], $user_id);
        $this->uploadDocuments($img_path, $user_id);
        return $user_id;
    }
    private function uploadDocuments($img_path, $user_id)
    {
        $img = uploadImage('photo', $img_path, 'profile' . $user_id, 200);
        if ($img !== false) {
            $this->dbapi->updateUser(['img_path' => $img_path, 'img' => $img, 'thumb_img' => 'thumb_' . $img], $user_id);
        }
        if (!empty($_FILES['resume'])) {
            $resume = imgUpload('resume', $img_path, 'resume');
            if ($resume !== false) {
                $this->dbapi->addUserDocuments(['user_id' => $user_id, 'path' => $img_path, 'resume' => $resume]);
            }
        }
        if (!empty($_FILES['experience'])) {
            $experience = imgUpload('experience', $img_path, 'experience');
            if ($experience !== false) {
                $this->dbapi->addUserDocuments(['user_id' => $user_id, 'path' => $img_path, 'experience_letter' => $experience]);
            }
        }
        if (!empty($_FILES['bond_paper'])) {
            $bond_paper = imgUpload('bond_paper', $img_path, 'bond_paper');
            if ($bond_paper !== false) {
                $this->dbapi->addUserDocuments(['user_id' => $user_id, 'path' => $img_path, 'bond_paper' => $bond_paper]);
            }
        }
        if (!empty($_FILES['others'])) {
            $others = imgUpload('others', $img_path, 'others');
            if ($others !== false) {
                $this->dbapi->addUserDocuments(['user_id' => $user_id, 'path' => $img_path, 'others' => $others]);
            }
        }
        if (!empty($_FILES['others2'])) {
            $others2 = imgUpload('others2', $img_path, 'others2');
            if ($others2 !== false) {
                $this->dbapi->addUserDocuments(['user_id' => $user_id, 'path' => $img_path, 'others2' => $others2]);
            }
        }
    }
    private function updateUser($pdata, $img_path, $user_id)
    {
        $update = $this->dbapi->updateUser($pdata, $user_id);
        $this->uploadDocuments($img_path, $user_id);
        return $update;
    }
    private function postData($data)
    {
        $pdata = array();
        $location_id = $_SESSION['LOCATION_ID'];
        $branch_id = $_SESSION['BRANCH_ID'];
        $pdata['name'] = !empty($data['name']) ? trim($data['name']) : '';
        $pdata['email'] = !empty($data['email']) ? trim($data['email']) : '';
        $pdata['password'] = !empty($data['password']) ? trim($data['password']) : '';
        $pdata['gender'] = !empty($data['gender']) ? trim($data['gender']) : '';
        $pdata['phone'] = !empty($data['phone']) ? trim($data['phone']) : '';
        $pdata['role'] = !empty($data['role']) ? trim($data['role']) : '';
        $pdata['address1'] = !empty($data['address1']) ? trim($data['address1']) : '';
        $pdata['address2'] = !empty($data['address2']) ? trim($data['address2']) : '';
        $pdata['city'] = !empty($data['city']) ? trim($data['city']) : '';
        $pdata['state'] = !empty($data['state']) ? trim($data['state']) : '';
        $pdata['pincode'] = !empty($data['pincode']) ? trim($data['pincode']) : '';
        $pdata['status'] = !empty($data['status']) ? trim($data['status']) : '';
        $pdata['location_id'] = !empty($data['location_id']) ? trim($data['location_id']) : $location_id;
        $pdata['branch_id'] = !empty($data['branch_id']) ? trim($data['branch_id']) : $branch_id;
        return $pdata;
    }
    public function track()
    {
        $data = [];
        if (!empty($this->_REQ['role'])) {
            $branch_id = !empty($this->_REQ['branch_id']) ? $this->_REQ['branch_id'] : $_SESSION['BRANCH_ID'];
            $data['sub_ordinates'] = $this->dbapi->getUsersList(['role' => $this->_REQ['role'], 'branch_id' => $branch_id]);
        }
        $search_data = array();
        if (!empty($this->_REQ['location_id'])) {
            $search_data['location_id'] = $this->_REQ['location_id'];
        }
        if (!empty($this->_REQ['branch_id'])) {
            $search_data['branch_id'] = $this->_REQ['branch_id'];
        }
        if (!empty($this->_REQ['role'])) {
            $search_data['role'] = $this->_REQ['role'];
        }
        if (!empty($this->_REQ['sub_ordinates'])) {
            $search_data['sub_ordinates'] = $this->_REQ['sub_ordinates'];
        }
        if (!empty($this->_REQ['status'])) {
            $search_data['status'] = $this->_REQ['status'];
        }
        $this->load->library('Pagenavi');
        // $this->pagenavi->per_page = 10;
        $this->pagenavi->base_url = base_url() . 'admin/SubOrdinates/track/?';
        if (!empty($this->_REQ['role']) && ($this->_REQ['role'] == "ENGINEER")) {
            if (!empty($this->_REQ['from_date'])) {
                $search_data['from_date'] = dateRangeForm2DB($this->_REQ['from_date']);
                $search_data['to_date'] = dateRangeForm2DB($this->_REQ['to_date']);
            }
            $search_data['assigned_to'] = $this->_REQ['sub_ordinates'];
            $this->pagenavi->search_data = $search_data;
            $this->pagenavi->process($this->inward, 'searchInwards');
            $data['PAGING'] = $this->pagenavi->links_html;
            $data['inwards'] = $this->pagenavi->items;
        }
        if (!empty($this->_REQ['role']) && ($this->_REQ['role'] == "RECEPTIONIST")) {
            if (!empty($this->_REQ['from_date'])) {
                $search_data['from_date'] = dateRangeForm2DB($this->_REQ['from_date']);
                $search_data['to_date'] = dateRangeForm2DB($this->_REQ['to_date']);
            } else {
                $search_data['date'] = date('Y-m-d');
            }
            $search_data['sub_ordinates'] = $this->_REQ['sub_ordinates'];
            /*  $this->pagenavi->search_data = $search_data;
             $this->pagenavi->process($this->dbapi, 'getReceptionActivities');
             $data['PAGING'] = $this->pagenavi->links_html;
             $activities = $this->pagenavi->items; */
            $activities = $this->dbapi->getReceptionActivities($search_data);
            if (!empty($activities)) {
                foreach ($activities as &$activity) {
                    $activity['title'] = str_replace("{{user_name}}", $activity['user_name'], $activity['title']);
                    $activity['title'] = str_replace("{{customer_name}}", $activity['customer_name'], $activity['title']);
                    $activity['title'] = str_replace("{{inward_job_id}}", $activity['inward_job_id'], $activity['title']);
                    $activity['title'] = str_replace("{{inward_challan_no}}", $activity['inward_challan'], $activity['title']);
                    $activity['title'] = str_replace("{{outward_job_id}}", $activity['outward_job_id'], $activity['title']);
                    $activity['title'] = str_replace("{{outward_challan_no}}", $activity['outward_challan'], $activity['title']);
                    $activity['title'] = str_replace("{{product_name}}", $activity['product_name'], $activity['title']);
                    $activity['title'] = str_replace("{{component_name}}", $activity['component_name'], $activity['title']);
                    $activity['title'] = str_replace("{{quantity}}", $activity['quantity'], $activity['title']);
                }
            }
            $data['activities'] = $activities;
        }
        $data['locations'] = $this->admin->getLocationsList();
        $data['branches_else'] = $this->admin->getBranchesList(!empty($this->_REQ['location_id']) ? $this->_REQ['location_id'] : '');
        $data['status_list'] = $this->inward->getStatusList();
        $this->_template('subordinates/track', $data);
    }
    public function getSubOrdinatesByRole()
    {
        if (!empty($this->_REQ['role'])) {
            $role = !empty($this->_REQ['role']) ? $this->_REQ['role'] : '';
            $branch_id = !empty($this->_REQ['branch_id']) ? $this->_REQ['branch_id'] : '';
            //$location_id = !empty($this->_REQ['location_id']) ? $this->_REQ['branch_id'] : '';
            $users = $this->dbapi->getUsersList(['role' => $role, 'branch_id' => $branch_id]);
            echo json_encode($users);
        }
    }
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
}
