<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReceptionBase extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["RECEPTION"]);
        $this->load->model("admin/Message_model", "messages", TRUE);

        $today = date("Y-m-d");
        $this->header_data['messageCnt'] = $this->messages->searchInboxMessages(['user_id' => $_SESSION['USER_ID'], 'date' => $today], "CNT");
    }
}