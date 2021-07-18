<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notifications extends MY_Controller
{
    public $header_data = array();
    function __construct()
    {
        parent::__construct();
        $this->load->model("Notification_model", "notification", TRUE);
    }
    public function index()
    {
        $data = [];
        $sArray = [];
        $this->header_data['title'] = 'Notifications';
        if (!empty($this->_REQ['view']) && ($this->_REQ['view'] == "current")) {
            $sArray['date'] = date('Y-m-d');
            $sArray['is_viewed'] = 'NO';
        }
        if (!empty($this->_REQ['view']) && ($this->_REQ['view'] == "all")) {            
            $sArray['view_all'] = 'YES';
        }
        if (!empty($this->_REQ['from_date'])) {
            $sArray['from_date'] = dateRangeForm2DB($this->_REQ['from_date']);
            $sArray['to_date'] = dateRangeForm2DB($this->_REQ['to_date']);
            $sArray['is_viewed'] = 'NO';
        }
        $notifications_cnt = $this->notification->searchNotifications($sArray, 'CNT');
        $search_data = array();
        if (!empty($this->_REQ['from_date'])) {
            $search_data['from_date'] = dateRangeForm2DB($this->_REQ['from_date']);
            $search_data['to_date'] = dateRangeForm2DB($this->_REQ['to_date']);
        }
        if(!empty($this->_REQ['view'])&& ($this->_REQ['view']=='current')){
            $search_data['date'] = date('Y-m-d');
        }
        if (!empty($this->_REQ['view']) && ($this->_REQ['view'] == "all")) {            
            $search_data['view_all'] = 'YES';
        }
        $this->load->library('Pagenavi');
        $this->pagenavi->search_data = $search_data;
        $this->pagenavi->per_page = 10000;
        $this->pagenavi->base_url = base_url() . 'admin/notifications/?';
        if (!empty($this->_REQ['notification_id'])) {
            $pk_id = $this->_REQ['notification_id'];
            $notification = $this->notification->getNotificationById($pk_id);
            $notification['title'] = str_replace("{{user_name}}", $notification['created_by'], $notification['title']);
            $notification['title'] = str_replace("{{customer_name}}", $notification['customer_name'], $notification['title']);
            $notification['title'] = str_replace("{{sub_ordinate}}", $notification['subordinate_name'], $notification['title']);
            $notification['title'] = str_replace("{{branch}}", $notification['branch_name'], $notification['title']);
            $notification['title'] = str_replace("{{job_id}}", $notification['job_id'], $notification['title']);
            if (!empty($notification['inward_status'])) {
                $notification['title'] = str_replace("{{status}}", $notification['inward_status'], $notification['title']);
                $notification['title'] = str_replace("{{inward_challan}}", $notification['inward_challan'], $notification['title']);
                $notification['title'] = str_replace("{{outward_challan}}", $notification['outward_challan'], $notification['title']);
            }
            $data['notification'] = $notification;
            $notifications_cnt = $this->notification->searchNotifications([], 'CNT');
        }
        if (!empty($this->_REQ['view']) && ($this->_REQ['view'] == "unread")) {
            $sData['is_viewed'] = 'YES';
        } elseif (!empty($this->_REQ['view']) && ($this->_REQ['view'] == "current")) {
            $sData['date'] = date('Y-m-d');
        }else {
        }
        $this->pagenavi->process($this->notification, 'searchNotifications');
        $data['PAGING'] = $this->pagenavi->links_html;
        $notifications = $this->pagenavi->items;
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
        $this->_template('common_pages/notifications', $data);
    }
    public function updateNotificationStatus()
    {
        if (!empty($this->_REQ['pk_id'])) {
            $pk_id = $this->_REQ['pk_id'];
            $data = [];
            $data['is_viewed'] = 'YES';
            $data['viewed_on'] = date('Y-m-d H:i:s');
            $this->notification->updateNotificationStatus($data, $pk_id);
        }
        if (!empty($this->_REQ['user_id'])) {
            $user_id = $this->_REQ['user_id'];
            $data = [];
            $data['is_viewed'] = 'YES';
            $data['viewed_on'] = date('Y-m-d H:i:s');
            $this->notification->updateUserNotificationStatus($data, $user_id);
        }
    }
}