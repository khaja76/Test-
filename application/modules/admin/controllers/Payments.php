<?php
ini_set("display_errors",true);
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends MY_Controller
{
    public $header_data = array();

    function __construct()
    {
        parent::__construct();
        $this->load->model("Payment_model", "payments", TRUE);
        $this->load->model("Inward_model", "inward", TRUE);
    }

    public function index()
    { // For Viewing Components List , Delete, Status
        $data = [];
        $search_data = [];
        $check_payment = (isset($_GET['payment-status']) && !empty($_GET['payment-status'])) ? $_GET['payment-status'] : false;
        if ($check_payment && $check_payment != 'all') {
            $search_data['paid'] = ($check_payment == 'due') ? false : true;
        }
        if (!empty($this->_REQ['location_id']))
            $search_data['location_id'] = $this->_REQ['location_id'];
        else
            $search_data['location_id'] = !empty($_SESSION['LOCATION_ID']) ? $_SESSION['LOCATION_ID'] : '';
        if (!empty($this->_REQ['branch_id']))
            $search_data['branch_id'] = $this->_REQ['branch_id'];
        else
            $search_data['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
        $search_data ['payment_type'] = $_GET['payment-type'];
        $data['inwards'] = $this->payments->getPaymentsList($search_data);
        $this->_template('payments/index', $data);
    }

    public function paymentToInward()
    {
        if (!empty($_POST)) {
            $pData = [];
            $pData['inward_id'] = !empty($_POST['inward_id']) ? trim($_POST['inward_id']) : '';
            $pData['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? ($_SESSION['BRANCH_ID']) : '';
            $pData['created_by'] = !empty($_SESSION['USER_ID']) ? ($_SESSION['USER_ID']) : '';
            $pData['payment_mode'] = !empty($_POST['payment_mode']) ? trim($_POST['payment_mode']) : '';
            $pData['amount'] = !empty($_POST['amount']) ? trim($_POST['amount']) : '0.00';
            $pData['cheque_no'] = !empty($_POST['cheque_no']) ? trim($_POST['cheque_no']) : '';
            $pData['bank_details'] = !empty($_POST['bank_details']) ? trim($_POST['bank_details']) : '';
            $pData['remarks'] = !empty($_POST['remarks']) ? trim($_POST['remarks']) : '';
            if (!empty($pData['amount'])) {
                $payment_id = $this->inward->addPayment($pData);
                if (!empty($payment_id)) {
                    $inward = $this->inward->getInwardById($pData['inward_id']);
                    $old_amt = !empty($inward['paid_amt']) ? $inward['paid_amt'] : '0.00';
                    $add_amt = !empty($pData['amount']) ? $pData['amount'] : '0.00';
                    $new_amt = $old_amt + $add_amt;
                    $this->inward->updateInward(['paid_amt' => $new_amt], $pData['inward_id']);
                    $hData['inward_id'] = $pData['inward_id'];
                    $hData['status'] = 'PAYMENT';
                    $hData['remarks'] = '';
                    $hData['user_id'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                    $sta = $this->inward->addInwardStatus($hData);
                    echo "TRUE";
                } else {
                    echo "FALSE";
                }
            }
        }
        return false;
    }

    public function history()
    {
        $data = [];
        if (!empty($this->_REQ['inward'])) {
            $s['inward_id'] = $this->_REQ['inward'];

            if (!empty($_SESSION['ROLE']) && $_SESSION['ROLE'] == 'SUPER_ADMIN') {
                $s['branch_id'] = $this->_REQ['branch_id'];
            } else {
                $s['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
            }
            $inward = $this->inward->getInwardByJobId($s['inward_id'], $s['branch_id']);
            $inward['payments'] = $this->inward->getPaymentDetails($s);
            $data['inward'] = $inward;
        }
        if(!empty($this->_REQ['invoice'])){
            $data['invoice'] = $this->payments->getPaymentInvoiceById($this->_REQ['invoice']);
            $data['inward']['payments'] = $this->payments->getPaymentsByInvoice($this->_REQ['invoice']);
        }
        $this->_template('payments/history', $data);
    }

    public function invoicePayment()
    {
        if (!empty($_POST)) {
            $pData = [];
            $pData['invoice_id'] = !empty($_POST['invoice_id']) ? trim($_POST['invoice_id']) : '';
            $pData['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? ($_SESSION['BRANCH_ID']) : '';
            $pData['created_by'] = !empty($_SESSION['USER_ID']) ? ($_SESSION['USER_ID']) : '';
            $pData['payment_mode'] = !empty($_POST['payment_mode']) ? trim($_POST['payment_mode']) : '';
            $pData['amount'] = !empty($_POST['amount']) ? trim($_POST['amount']) : '0.00';
            $pData['cheque_no'] = !empty($_POST['cheque_no']) ? trim($_POST['cheque_no']) : '';
            $pData['bank_details'] = !empty($_POST['bank_details']) ? trim($_POST['bank_details']) : '';
            $pData['remarks'] = !empty($_POST['remarks']) ? trim($_POST['remarks']) : '';
            if (!empty($pData['amount'])) {
                $payment_id = $this->payments->addInvoicePayment($pData);
                if (!empty($payment_id)) {
                    $invoice = $this->payments->getPaymentInvoiceById($pData['invoice_id']);
                    $old_amt = !empty($invoice['paid_amt']) ? $invoice['paid_amt'] : '0.00';
                    $add_amt = !empty($pData['amount']) ? $pData['amount'] : '0.00';
                    $new_amt = $old_amt + $add_amt;
                    $this->payments->updateInvoice(['paid_amt' => $new_amt], $pData['invoice_id']);
                    echo "TRUE";
                } else {
                    echo "FALSE";
                }
            }
        }
        return false;
    }

    public function getInvoiceById()
    {
        $invoice = $this->payments->getPaymentInvoiceById($_POST['invoice_id']);
        echo json_encode($invoice);
    }
}