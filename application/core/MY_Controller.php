<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH ."third_party/MX/Controller.php";

class MY_Controller extends MX_Controller
{

    public $header_data = [];
    function __construct()
    {
        parent::__construct();
        
        $this->_REQ = $_POST + $_GET;
        $this->load->helper('common');
        $this->header_data['product_name'] = 'Hifi Technologies';
        $this->load->model("admin/Message_model", "messages", TRUE);
        $today = date("Y-m-d");
        if(!empty($_SESSION['USER_ID'])){
            $this->header_data['inwardAppCnt']=$this->messages->getInwardApprovalsCNT();
            $this->header_data['messageCnt'] = $this->messages->searchInboxMessages(['user_id' => $_SESSION['USER_ID'], 'date' => $today], "CNT");
        }

    }

    public function _user_login_check($role = array())
    {
        if (!isset($_SESSION))
            session_start();
        if (!empty($_SESSION['USER_ID'])) {
            if (!empty($role) && is_array($role) && in_array($_SESSION['ROLE'], $role)) {
                    
            } else{
                redirect(base_url());
                /* if($_SESSION['ROLE']=='SUPER_ADMIN' || $_SESSION['ROLE']=='ADMIN' ){
                    redirect(base_url().'admin/');
                    exit;
                }
                else if($_SESSION['ROLE']=='ENGINEER'){
                    redirect(base_url().'engineer/');
                }else if($_SESSION['ROLE']=='RECEPTIONIST'){
                    redirect(base_url().'reception/');
                }  */
            } 
        } else {
            redirect(base_url());
        }
    }
    
    public function sendSMS($to, $msg)
    {
        $sendUrl = '';
        $from = "HFTSAI";
        $msg=str_replace(' ','%20',$msg);
        //$sendUrl = "http://smslogin.mobi/spanelv2/api.php?username=hifite&password=tinku@123&to=$to&from=$from&message=$msg";
        //$sendUrl = "Your Url Address with login Details";
        return curl_get_contents($sendUrl);
    }


    public function sendEmail($view='', $data = [])
    {
        if (empty($data['from'])) {
            $data['from'] = "ksaibabu@hifitech.in";
        }
        include_once(rtrim(APPPATH, "/") . "/third_party/phpmailer/class.phpmailer.php");
        if (empty($data['body'])) {
            $body = $this->load->view($view, $data, true);
        }
        try {
            $mail = new PHPMailer();
            if (!empty($data['from']) && !empty($data['from_name'])) {
                $mail->SetFrom($data['from'], $data['from_name']);
            } else if (!empty($data['from'])) {
                $mail->SetFrom($data['from']);
            }
            if (!empty($data['to']) && !empty($data['to_name'])) {
                $mail->AddAddress($data['to']);
            } else if (!empty($data['to'])) {
                $mail->AddAddress($data['to']);
            }
            if (!empty($data['cc'])) {
                $mail->AddAddress($data['cc']);
            }
            $mail->Subject = !empty($data['subject']) ? $data['subject'] : "";
            $mail->isHTML(true);
            //$mail->MsgHTML($body);
            if (empty($data['body'])) {
                $mail->Body = $body;
            }else{
                $mail->Body = $data['body'];
            }
            //return $mail->Send();
        } catch (phpmailerException $e) {
            echo $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
            echo $e->getMessage(); //Boring error messages from anything else!
        }
    }

    public function _remap($method, $params = array())
    {
        $data = array();
        $this->header_data['page_name'] = $method;
        $method = str_replace("-", "_", $method);
        $this->method = $method;
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            //redirect(base_url());
        }
    }


    public function _json_out($response = [])
    {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    public function _template($page_name = 'index', $data = array())
    {
        if(!empty($_SESSION['ROLE']) && ($_SESSION['ROLE'] == "SUPER_ADMIN")){
            $this->load->view('super_header', $this->header_data);
        }else{
            $this->load->view('header', $this->header_data);
        }

        $this->load->view($page_name, $data);
        $this->load->view('footer');
    }

    public function _iframe($page_name = 'index', $data = array())
    {
        $this->load->view('iframe_header', $this->header_data);
        $this->load->view($page_name, $data);
        $this->load->view('iframe_footer');
    }

}
