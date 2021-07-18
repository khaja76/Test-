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
        //$data = [];
        $notifications = $this->dbapi->searchNotifications();
        if (!empty($notifications)) {
            foreach ($notifications as &$notification) {
                //if ($notification['notification_type_id'] == 1) {
                $notification['title'] = str_replace("{{user_name}}", $notification['created_by'], $notification['title']);
                $notification['title'] = str_replace("{{customer_name}}", $notification['customer_name'], $notification['title']);
                $notification['title'] = str_replace("{{sub_ordinate}}", $notification['subordinate_name'], $notification['title']);
                $notification['title'] = str_replace("{{branch}}", $notification['branch_name'], $notification['title']);
                $notification['title'] = str_replace("{{job_id}}", $notification['job_id'], $notification['title']);
                //}
            }
        }
        $data['notifications'] = $notifications;
        $this->load->view('notifications',$data);
    }

}