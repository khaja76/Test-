<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Details extends MY_Controller
{
    public $header_data = array();
    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["SUPER_ADMIN", "ADMIN"]);
        $this->load->model("Admin_model", "admin", TRUE);
        $this->load->model("Inward_model", "inward", TRUE);
    }
    public function branches()
    {
        $data = array();
        $this->header_data['title'] = "::  Branch Information ::";
        if (!empty($this->_REQ['branch'])) {
            $branch_id = $this->_REQ['branch'];
            $data['adminCnt'] = $this->admin->getUsersCnt(['role' => 'ADMIN', 'branch_id' => $branch_id]); // Admins
            $data['receptionCnt'] = $this->admin->getUsersCnt(['role' => 'RECEPTIONIST', 'branch_id' => $branch_id]); // Receptionist
            $data['engineerCnt'] = $this->admin->getUsersCnt(['role' => 'ENGINEER', 'branch_id' => $branch_id]);
            $data['customerCnt'] = $this->admin->getCustomersCnt(['branch_id' => $branch_id]);
            $data['inwardsCnt'] = $this->admin->getInwardsCnt(['branch_id' => $branch_id]);
            $data['outwardsCnt'] = $this->admin->getOutwardsCnt(['branch_id' => $branch_id]);
            $branches = $this->admin->searchLocations(['branch_id' => $branch_id]);
            foreach ($branches as &$branch) {
                $branch['user'] = $this->admin->getAdminDetails(['branch_id' => $branch['branch_id']]);
            }
            $data['branches'] = $branches;
        }
        $this->_template('details/branch', $data);
    }
    public function subOrdinates()
    {
        $data = array();
        $search_data = array();
        if (!empty($this->_REQ['role'])) {
            $search_data['role'] = $this->_REQ['role'];
            $this->header_data['title'] = ":: Sub Ordinate Details ::";
        }
        if (!empty($this->_REQ['branch'])) {
            $search_data['branch_id'] = $this->_REQ['branch'];
        }
        $this->load->library('Pagenavi');
        $this->pagenavi->search_data = $search_data;
        $this->pagenavi->per_page = 20;
        $this->pagenavi->base_url = base_url() . 'admin/details/subOrdinates/?';
        $this->pagenavi->process($this->admin, 'searchUsers');
        $data['PAGING'] = $this->pagenavi->links_html;
        $data['users'] = $this->pagenavi->items;
        $this->_template('details/sub-ordinates', $data);
    }
    public function profile()
    {
        $data = array();
        $this->header_data['title'] = "::  View Profile ::";
        $user_id = !empty($this->_REQ['user']) ? $this->_REQ['user'] : '';
        $user = $this->admin->getUserById($user_id);
        $branch_id = $user['branch_id'];
        if ($user['role'] == "RECEPTIONIST") {
            $data['inwards'] = $this->inward->searchInwards(['created_by' => $user_id, 'branch_id' => $branch_id]);
        } elseif ($user['role'] == "ENGINEER") {
            $data['inwards'] = $this->inward->searchInwards(['assigned_to' => $user_id, 'branch_id' => $branch_id]);
        } else {
            $data['inwards'] = $this->inward->searchInwards(['branch_id' => $branch_id]);
        }
        $data['profile'] = $user;
        $data['documents'] = $this->admin->getUserDocumentsByUser($user['user_id']);
        $this->_template('details/user-profile', $data);
    }
}
