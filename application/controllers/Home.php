<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{
    public $header_data = array();

    function __construct()
    {
        parent::__construct();
        $this->load->model("Home_model", "dbapi", TRUE);
    }

    public function index()
    {
        $data = array();
        //phpinfo();
        //exit;
        if (!empty($_SESSION['USER_ID'])) {
            if (($_SESSION['ROLE'] == 'SUPER_ADMIN') || ($_SESSION['ROLE'] == 'ADMIN')) {
                redirect(base_url() . "admin/");
            } elseif ($_SESSION['ROLE'] == "RECEPTIONIST") {
                redirect(base_url() . "reception/");
            } elseif ($_SESSION['ROLE'] == "ENGINEER") {
                redirect(base_url() . "engineer/");
            }
        }
        $this->header_data['title'] = ":: Login ::";
        if (!empty($_POST['LOGIN']) && !empty($_POST['email']) && !empty($_POST['password'])) {
            $user = $this->dbapi->userLogin($_POST['email'], $_POST['password']);
            if (!empty($user['user_id']) && ($user['status'] == "ACTIVE")) {
                $_SESSION = array();
                $_SESSION['USER_ID'] = $user['user_id'];
                $_SESSION['USER_NAME'] = $user['name'];
                $_SESSION['USER_EMAIL'] = $user['email'];
                $_SESSION['LOCATION_ID'] = $user['location_id'];
                $_SESSION['BRANCH_ID'] = $user['branch_id'];
                $_SESSION['BRANCH_CODE'] = $user['branch_code'];
                $_SESSION['INWARD_CODE'] = $user['inward_code'];
                $_SESSION['ROLE'] = $user['role'];
                if (($user['role'] == "ADMIN") || ($user['role'] == "SUPER_ADMIN")) {
                    redirect(base_url() . "admin/");
                } elseif ($user['role'] == "RECEPTIONIST") {
                    redirect(base_url() . "reception/");
                } elseif ($user['role'] == "ENGINEER") {
                    redirect(base_url() . "engineer/");
                } else {
                    $_SESSION['error'] = "Please define a role to the User first .!";
                    $data['user'] = $_POST;
                }
            } else if (!empty($user['status']) && $user['status'] != "ACTIVE") {
                $_SESSION['error'] = "Your account is not active.";
                $data['user'] = $_POST;
            } else {
                $_SESSION['error'] = "Invalid Email/Password";
                $data['user'] = $_POST;
            }
        }

        $this->_template("home", $data);
    }

    public function forgot_password()
    {
        $data = [];
        $this->header_data['title'] = ":: Forget Password ::";
        if (!empty($_POST['FORGOT']) && !empty($_POST['email'])) {
            $user = $this->dbapi->getUserDetails(['email' => $_POST['email']]);
            if (!empty($user['user_id'])) {
                $reset_token = generateOTP(6);
                $this->dbapi->updateUser(["reset_token" => $reset_token], $user['user_id']);
                $person['reset_token'] = $reset_token;
                $person['to'] = $user['email'];
                $person['to_name'] = $user['name'];
                $person['password'] = $user['password'];
                $person['subject'] = "Reset Password";
                $this->sendEmail("email/forget_password", $person);
                $_SESSION['message'] = "Please Check Your Email to Reset Password";
                redirect(base_url());
            } else { // If Email not Exists in DB
                $_SESSION['error'] = "Your Email is not in Our Records..!";
                redirect(base_url());
            }
        }
        $this->_template("forgot-password", $data);
    }

    public function reset_password()
    {
        $data = [];
        if (!empty($this->_REQ['reset']) && !empty($_POST['pwd']) && !empty($_POST['confirm_pwd'])) {
            $user = $this->dbapi->getUserByToken($this->_REQ['reset']);
            if (!empty($user['user_id'])) {
                if (trim($_POST['pwd']) == trim($_POST['confirm_pwd'])) {
                    $this->dbapi->updateUser(["password" => trim($_POST['pwd']), "reset_token" => ""], $user['user_id']);
                    $_SESSION['message'] = "Your Password Updated Successfully..!";
                    redirect(base_url());
                } else {
                    $_SESSION['message'] = "Your Password and Retype Password must same!";
                }
            } else {
                $_SESSION['warning'] = "Invalid request or already expired your request!";
                redirect(base_url());
            }
        }
        $this->_template("reset-password", $data);
    }

    function session_expired()
    {
        $this->load->view('session-expired');
    }

    public function checkUserMail()
    {
        if (!empty($_GET['email'])) {
            if ($this->dbapi->checkUserEmail($_GET['email']) !== true) {
                echo "true";
                exit;
            }
        }
        echo "false";
        exit;
    }

    public function checkCustomerMail()
    {
        if (!empty($_GET['email'])) {
            $branch_id = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
            if ($this->dbapi->checkCustomerEmail($_GET['email'], '', $branch_id)) {
                echo "false";
                exit;
            }
        }
        echo "true";
        exit;
    }

    public function checkCustomerMobile()
    {

        if (!empty($_GET['mobile'])) {
            $branch_id = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
            if ($this->dbapi->checkCustomerMobile(($_GET['mobile']), '', $branch_id)) {
                echo "false";
                exit;
            }
        }
        echo "true";
        exit;
    }

    public function upload_post_image()
    {
        $accepted_origins = array("http://localhost", "http://192.168.1.1", "https://hifitech.in/pcakage/", "http://hifitech.in/pcakage/", "*");
        $imageFolder = "data/products/uploads/";
        reset($_FILES);
        $temp = current($_FILES);
        if (is_uploaded_file($temp['tmp_name'])) {
            if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
                header("HTTP/1.1 400 Invalid extension.");
                return;
            }
            if (!is_dir($imageFolder)) {
                @mkdir($imageFolder);
            }
            $filetowrite = $imageFolder . generatePassword() . $temp['name'];
            move_uploaded_file($temp['tmp_name'], $filetowrite);
            echo json_encode(array('location' => base_url() . $filetowrite));
        } else {
            echo "No";
        }
    }

    public function sendSMS2($to, $msg)
    {
        $from = "HFTSAI";
        $msg = str_replace(' ', '%20', $msg);
        //$sendUrl = "http://smslogin.mobi/spanelv2/api.php?username=hifite&password=tinku@123&to=$to&from=$from&message=$msg";
        //$sendUrl = "Your Url Address with login Details";
        $val=curl_get_contents($sendUrl);
        return $val;
    }

    public function test_sms()
    {

        $success = $this->sendSMS2("9989938828", "Hello");
        if ($success)
            echo "Sent";
        else
            echo "Oops";
    }

    public function logout()
    {
        $_SESSION = [];
        if (isset($_GET['session_exp'])) {
            $_SESSION['error'] = "Your Session is expired ! Please login again ";
        }
        redirect(base_url());
    }
}
