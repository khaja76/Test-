<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends MY_Controller
{
    public $header_data = array();

    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["RECEPTIONIST","ADMIN","SUPER_ADMIN","ENGINEER"]);
        $this->load->model("admin/Message_model", "messages", TRUE);
    }

    public function latest()
    {
        $data = [];
        $date = date("Y-m-d");
        $user_id = !empty($_SESSION) ? $_SESSION['USER_ID'] : '';
        $data['messages'] = $this->messages->searchInboxMessages(['date' => $date,'user_id' => $user_id]);
        $this->_template('admin/messages/latest', $data);
    }
    public function index()
    {
        redirect(base_url() . 'reception/messages/inbox');
    }

    public function inbox()
    {
        $data = [];
        $user_id = !empty($_SESSION) ? $_SESSION['USER_ID'] : '';
        if (!empty($this->_REQ['from_date'])) {
            $search_data['from_date'] = dateRangeForm2DB($this->_REQ['from_date']);
            $search_data['to_date'] = dateRangeForm2DB($this->_REQ['to_date']);
        }else if ((empty($this->_REQ['location_id']) || (empty($this->_REQ['branch_id'])) ) && !isset($_GET['type'])) {
            $search_data['date'] = date('Y-m-d');
        }
        $search_data['user_id']= $user_id;
        $data['messages'] = $this->messages->searchInboxMessages($search_data);
        $this->_template('admin/messages/index', $data);
    }

    public function sent()
    {
        $data = [];
        $search_data = [];
        if (!empty($this->_REQ['from_date'])) {
            $search_data['from_date'] = dateRangeForm2DB($this->_REQ['from_date']);
            $search_data['to_date'] = dateRangeForm2DB($this->_REQ['to_date']);
        }else if ((empty($this->_REQ['location_id']) || (empty($this->_REQ['branch_id'])) ) && !isset($_GET['type'])) {
            $search_data['date'] = date('Y-m-d');
        }
        $data['messages'] = $this->messages->searchSentMessages($search_data);
        $this->_template('admin/messages/sent', $data);
    }

    public function view()
    {
        $data = [];
        if (!empty($this->_REQ['message'])) {
            $pk_id = $this->_REQ['message'];
            $search = $this->messages->getMessageHistoryById(['pk_id'=>$pk_id]);
            $this->messages->updateMessageHistory(['is_viewed' => 1], $pk_id);
            $data['message'] = $this->messages->getMessageById($search['message_id']);
        }
        $this->_template('admin/messages/view', $data);
    }

    public function compose()
    {
        $data = [];
        if (!empty($_POST['subject'])) {
            $pData = [];
            $pData['job_id'] = !empty($_POST['job_id']) ? trim($_POST['job_id']) : '';
            $pData['subject'] = !empty($_POST['subject']) ? trim($_POST['subject']) : '';
            $pData['description'] = !empty($_POST['description']) ? trim($_POST['description']) : '';
            $pData['branch_id'] = !empty($_SESSION) ? $_SESSION['BRANCH_ID'] : '';
            $pData['created_by'] = !empty($_SESSION) ? $_SESSION['USER_ID'] : '';
            $pData['is_available'] = 1;
            $message_id = $this->messages->addMessage($pData);
            if ($message_id) {
                $this->messages->addMessageStatus(['message_id' => $message_id, 'user_id' => $pData['created_by']]);
                $hData = [];
                $hData['message_id'] = $message_id;
                $hData['sent_to'] = !empty($_POST['sent_to']) ? trim($_POST['sent_to']) : '';
                $this->messages->addMessageHistory($hData);
                $_SESSION['message'] = "Mail Sent Successfully";
                redirect(base_url() . 'reception/messages/sent');
            }
            else {
                $_SESSION['error'] = "Fail to send Message";
                $data['message'] = $_POST;
            }
        }

        $data['inwards'] = $this->messages->getInwardsList();
        $this->_template('admin/messages/compose', $data);
    }
}