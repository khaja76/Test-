<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller
{
    public $header_data = array();

    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["SUPER_ADMIN", "ADMIN"]);
        $this->load->model("Admin_model", "admin", TRUE);
        $this->load->model("Sub_ordinates_model", "dbapi", TRUE);
    }

    public function index()
    {
        $data = array();
        $this->header_data['title'] = "::  View Profile ::";
        $user_id = !empty($_SESSION) ? $_SESSION['USER_ID'] : '';
        if (!empty($user_id)) {
            $data['profile'] = $this->admin->getUserById($user_id);
        }
        $this->_template('details/user-profile', $data);
    }

    public function edit($id = '')
    {
        $data = array();
        if(!empty($_SESSION) && ($_SESSION['ROLE'] != 'SUPER_ADMIN')){
            redirect(base_url() . 'admin/profile/');
        }
        $this->header_data['title'] = ":: Edit Profile ::";
        $pk_id = !empty($id) ? $id : $_SESSION['USER_ID'];
        if (!empty($pk_id)) {
            $data['user'] = $this->admin->getUserById($pk_id);
        }
        if (!empty($_POST['user_id'])) {
            $pdata = array();
            $pdata['name'] = !empty($_POST['name']) ? trim($_POST['name']) : '';
            $pdata['password'] = !empty($_POST['password']) ? trim($_POST['password']) : '';
            $pdata['gender'] = !empty($_POST['gender']) ? trim($_POST['gender']) : '';
            $pdata['phone'] = !empty($_POST['phone']) ? trim($_POST['phone']) : '';
            $pdata['address1'] = !empty($_POST['address1']) ? trim($_POST['address1']) : '';
            $pdata['address2'] = !empty($_POST['address2']) ? trim($_POST['address2']) : '';
            $pdata['city'] = !empty($_POST['city']) ? trim($_POST['city']) : '';
            $pdata['state'] = !empty($_POST['state']) ? trim($_POST['state']) : '';
            $pdata['pincode'] = !empty($_POST['pincode']) ? trim($_POST['pincode']) : '';
            $img_path = (!empty($data['user']['img_path'])) ? $data['user']['img_path'] : "data/users/" . slugify($pdata['name']) . "_" . $_POST['user_id'] . "/";
            $update = $this->dbapi->updateUser($pdata, $_POST['user_id']);
            $img = uploadImage('photo', $img_path, 'profile' . $_POST['user_id'], 200);
            if ($img !== false) {
                $this->dbapi->updateUser(['img_path' => $img_path, 'img' => $img, 'thumb_img' => 'thumb_' . $img], $_POST['user_id']);
            }
            if ($update) {
                $_SESSION['message'] = "Employee Details are updated Successfully";
                redirect(base_url() . 'admin/profile/');
            } else {
                $_SESSION['error'] = "Failed to update Employee";
                $data['user'] = $_POST;
            }
        }
        $data['states'] = $this->admin->getStatesList();
        $this->_template('profile/form', $data);
    }
}
