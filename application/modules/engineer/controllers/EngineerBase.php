<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EngineerBase extends MY_Controller
{
    public $header_data = array();

    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["ENGINEER"]);
        $this->load->model("admin/Message_model", "messages", TRUE);
        $today = date("Y-m-d");
        $this->header_data['messageCnt'] = $this->messages->searchInboxMessages(['user_id' => $_SESSION['USER_ID'], 'date' => $today], "CNT");
    }
}