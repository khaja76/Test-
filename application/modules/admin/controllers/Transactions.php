<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Transactions extends MY_Controller
{
    public $header_data = array();
    function __construct()
    {
        parent::__construct();
        $this->load->model("Inward_model", "dbapi", TRUE);
        $this->load->model("bk_Quotation_model", "quotation", TRUE);
        $this->load->model("Invoice_model", "invoice", TRUE);
    }
    public function index()
    {
        $data = [];
        unset($_SESSION['trans_jobs']);
        if (!empty($this->_REQ['transac'])) {
            $mode = $this->_REQ['transac'];
            $type = $this->_REQ['transac_type'];
            $value = $this->_REQ['value'];
            if ($type == 'customer_id') {
                $data['inwards'] = $this->dbapi->searchInwards(['customer_id' => $value, 'branch_id' => $_SESSION['BRANCH_ID'],'is_outwarded'=>'NO']);
                if (!empty($_POST['job_id'])) {
                    $_SESSION['trans_jobs'] = $_POST['job_id'];
                    redirect(base_url() . 'admin/transactions/transaction-details/?transaction=' . $_POST['transaction'] . '&customer_id=' . $value);
                }
            } else {
                $data['inward'] = $this->dbapi->getInwardByJobId($value);
            }
        }
        $this->_template('transactions/index', $data);
    }
    public function transaction_details()
    {
        $data = [];
        $data['branch'] = $this->quotation->getBranchById(!empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '');
        $mode = isset($_GET['transaction']) ? $_GET['transaction'] : '';
        $this->header_data['title'] = 'Transaction -' . ucwords(str_replace('-', ' ', $mode));
        //Quotation
        if ($mode == 'quotation') {
            //Post Quotation
            if (!empty($_POST['job_id']) && !empty($_GET['customer_id'])) {
                $pData = [];
                $pData['customer_id'] = !empty($_POST['customer_id']) ? $_POST['customer_id'] : '';
                $pData['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
                $pData['created_by'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                $pData['quotation_date'] = !empty($_POST['quotation_date']) ? dateForm2DB($_POST['quotation_date']) : '';
                $pData['total_amount'] = !empty($_POST['total_amount']) ? $_POST['total_amount'] : '0.00';
                $pData['cgst_amount'] = !empty($_POST['cgst_amount']) ? $_POST['cgst_amount'] : '0.00';
                $pData['sgst_amount'] = !empty($_POST['sgst_amount']) ? $_POST['sgst_amount'] : '0.00';
                $pData['igst_amount'] = !empty($_POST['igst_amount']) ? $_POST['igst_amount'] : '0.00';
                $pData['total_tax'] = !empty($_POST['total_tax']) ? $_POST['total_tax'] : '0.00';
                $pData['final_amount'] = !empty($_POST['final_amount']) ? $_POST['final_amount'] : '0.00';
                $pData['notes'] = !empty($_POST['notes']) ? $_POST['notes'] : '';
                $branch_code = !empty($_SESSION['BRANCH_CODE']) ? $_SESSION['BRANCH_CODE'] : '';
                $count = $this->quotation->getBranchQuotations($_SESSION['BRANCH_ID']);
                $number = str_pad($count['CNT'] + 1, 3, '0', STR_PAD_LEFT);
                $pData['quotation_no'] = $number;
                $pData['quotation'] = transactionFormat($number, $type = 'Q', $branch_code);
                $pk_id = $this->quotation->addQuotation($pData);
                if (!empty($pk_id)) {
                    foreach ($_POST['job_id'] as $k => $v) {
                        $qData = [];
                        $qData['quotation_id'] = $pk_id;
                        $qData['job_id'] = !empty($_POST['job_id'][$k]) ? $_POST['job_id'][$k] : '';
                        $qData['remarks'] = !empty($_POST['remarks'][$k]) ? $_POST['remarks'][$k] : '';
                        $qData['amount'] = !empty($_POST['amount'][$k]) ? $_POST['amount'][$k] : '0.00';
                        $this->dbapi->updateInward(['estimation_amt'=>$qData['amount']],$qData['job_id']);
                        $this->quotation->addQuotationJobs($qData);
                    }
                    redirect(base_url() . 'admin/transactions/pdf/?customer_id=' . $_POST['customer_id'] . '&transaction=' . $_GET['transaction'] . '&trans_id=' . $pk_id);
                } else {
                    $_SESSION['error'] = 'Failed to Create Quotation';
                    $data['details'] = $_POST;
                }
            }
            if (!empty($_POST['job_id']) && !empty($_GET['inward_no'])) {
                $pData = [];
                $pData['customer_id'] = !empty($_POST['customer_id']) ? $_POST['customer_id'] : '';
                $pData['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
                $pData['created_by'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                $pData['quotation_date'] = !empty($_POST['quotation_date']) ? dateForm2DB($_POST['quotation_date']) : '';
                $pData['total_amount'] = !empty($_POST['total_amount']) ? $_POST['total_amount'] : '0.00';
                $pData['cgst_amount'] = !empty($_POST['cgst_amount']) ? $_POST['cgst_amount'] : '0.00';
                $pData['sgst_amount'] = !empty($_POST['sgst_amount']) ? $_POST['sgst_amount'] : '0.00';
                $pData['igst_amount'] = !empty($_POST['igst_amount']) ? $_POST['igst_amount'] : '0.00';
                $pData['total_tax'] = !empty($_POST['total_tax']) ? $_POST['total_tax'] : '0.00';
                $pData['final_amount'] = !empty($_POST['final_amount']) ? $_POST['final_amount'] : '0.00';
                $pData['notes'] = !empty($_POST['notes']) ? $_POST['notes'] : '';
                $branch_code = !empty($_SESSION['BRANCH_CODE']) ? $_SESSION['BRANCH_CODE'] : '';
                $count = $this->quotation->getBranchQuotations($_SESSION['BRANCH_ID']);
                $number = str_pad($count['CNT'] + 1, 3, '0', STR_PAD_LEFT);
                $pData['quotation_no'] = $number;
                $pData['quotation'] = transactionFormat($number, $type = 'Q', $branch_code);
                echo $pData['quotation'];
                $pk_id = $this->quotation->addQuotation($pData);
                if (!empty($pk_id)) {
                    $qData = [];
                    $qData['quotation_id'] = $pk_id;
                    $qData['job_id'] = !empty($_POST['job_id']) ? $_POST['job_id'] : '';
                    $qData['remarks'] = !empty($_POST['remarks']) ? $_POST['remarks'] : '';
                    $qData['amount'] = !empty($_POST['amount']) ? $_POST['amount'] : '0.00';
                    $this->dbapi->updateInward(['estimation_amt'=>$qData['amount']],$qData['job_id']);
                    $this->quotation->addQuotationJobs($qData);
                    redirect(base_url() . 'admin/transactions/pdf/?customer_id=' . $_POST['customer_id'] . '&transaction=' . $_GET['transaction'] . '&trans_id=' . $pk_id);
                } else {
                    $_SESSION['error'] = 'Failed to Create Quotation';
                    $data['details'] = $_POST;
                }
            }
            //Show Data
            if (!empty($this->_REQ['transaction']) && !empty($this->_REQ['inward_no'])) {
                $data['inward'] = $this->dbapi->getInwardByJobId($this->_REQ['inward_no']);
            }
            if (!empty($this->_REQ['transaction']) && !empty($this->_REQ['customer_id'])) {
                $jobs = explode(',', $_SESSION['trans_jobs']);
                $inwards = [];
                for ($i = 0; $i < count($jobs); $i++) {
                    $inward = $this->dbapi->searchInwards(['customer_id' => $this->_REQ['customer_id'], 'job_pk_id' => $jobs[$i], 'branch_id' => $_SESSION['BRANCH_ID']]);
                    array_push($inwards, $inward);
                }
                $data['inwards'] = $inwards;
            }
            $data['customer'] = $this->quotation->getCustomerByNo($this->_REQ['customer_id']);
            $this->_template('transactions/quotation/quotation-details', $data);
        } //Pro-Forma
        else if ($mode == "pro-forma-invoice") {
            //Post  Proforma
            if (!empty($_POST['job_id']) && !empty($_GET['customer_id'])) {
                $pData = [];
                $pData['customer_id'] = !empty($_POST['customer_id']) ? $_POST['customer_id'] : '';
                $pData['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
                $pData['created_by'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                $pData['pro_invoice_date'] = !empty($_POST['pro_invoice_date']) ? dateForm2DB($_POST['pro_invoice_date']) : '';
                $pData['total_amount'] = !empty($_POST['total_amount']) ? $_POST['total_amount'] : '0.00';
                $pData['cgst_amount'] = !empty($_POST['cgst_amount']) ? $_POST['cgst_amount'] : '0.00';
                $pData['sgst_amount'] = !empty($_POST['sgst_amount']) ? $_POST['sgst_amount'] : '0.00';
                $pData['igst_amount'] = !empty($_POST['igst_amount']) ? $_POST['igst_amount'] : '0.00';
                $pData['ship_handling_amount'] = !empty($_POST['ship_handling_amount']) ? $_POST['ship_handling_amount'] : '0.00';
                $pData['total_tax'] = !empty($_POST['total_tax']) ? $_POST['total_tax'] : '0.00';
                $pData['final_amount'] = !empty($_POST['final_amount']) ? $_POST['final_amount'] : '0.00';
                $pData['notes'] = !empty($_POST['notes']) ? $_POST['notes'] : '';
                $branch_code = !empty($_SESSION['BRANCH_CODE']) ? $_SESSION['BRANCH_CODE'] : '';
                $count = $this->invoice->getBranchProInvoices($_SESSION['BRANCH_ID']);
                $number = str_pad($count['CNT'] + 1, 3, '0', STR_PAD_LEFT);
                $pData['pro_invoice_no'] = $number;
                $pData['pro_invoice'] = transactionFormat($number, $type = 'PI', $branch_code);
                $pk_id = $this->invoice->addProInvoice($pData);
                if (!empty($pk_id)) {
                    foreach ($_POST['job_id'] as $k => $v) {
                        $qData = [];
                        $qData['pro_invoice_id'] = $pk_id;
                        $qData['job_id'] = !empty($_POST['job_id'][$k]) ? $_POST['job_id'][$k] : '';
                        $qData['remarks'] = !empty($_POST['remarks'][$k]) ? $_POST['remarks'][$k] : '';
                        $qData['amount'] = !empty($_POST['amount'][$k]) ? $_POST['amount'][$k] : '0.00';
                        $this->invoice->addProInvoiceJobs($qData);
                    }
                    redirect(base_url() . 'admin/transactions/pdf/?customer_id=' . $_POST['customer_id'] . '&transaction=' . $_GET['transaction'] . '&trans_id=' . $pk_id);
                } else {
                    $_SESSION['error'] = 'Failed to Create Pro-Forma Invoice';
                    $data['details'] = $_POST;
                }
            }
            if (!empty($_POST['job_id']) && !empty($_GET['inward_no'])) {
                $pData = [];
                $pData['customer_id'] = !empty($_POST['customer_id']) ? $_POST['customer_id'] : '';
                $pData['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
                $pData['created_by'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                $pData['pro_invoice_date'] = !empty($_POST['pro_invoice_date']) ? dateForm2DB($_POST['pro_invoice_date']) : '';
                $pData['total_amount'] = !empty($_POST['total_amount']) ? $_POST['total_amount'] : '0.00';
                $pData['cgst_amount'] = !empty($_POST['cgst_amount']) ? $_POST['cgst_amount'] : '0.00';
                $pData['sgst_amount'] = !empty($_POST['sgst_amount']) ? $_POST['sgst_amount'] : '0.00';
                $pData['igst_amount'] = !empty($_POST['igst_amount']) ? $_POST['igst_amount'] : '0.00';
                $pData['ship_handling_amount'] = !empty($_POST['ship_handling_amount']) ? $_POST['ship_handling_amount'] : '0.00';
                $pData['total_tax'] = !empty($_POST['total_tax']) ? $_POST['total_tax'] : '0.00';
                $pData['final_amount'] = !empty($_POST['final_amount']) ? $_POST['final_amount'] : '0.00';
                $pData['notes'] = !empty($_POST['notes']) ? $_POST['notes'] : '';
                $branch_code = !empty($_SESSION['BRANCH_CODE']) ? $_SESSION['BRANCH_CODE'] : '';
                $count = $this->invoice->getBranchProInvoices($_SESSION['BRANCH_ID']);
                $number = str_pad($count['CNT'] + 1, 3, '0', STR_PAD_LEFT);
                $pData['pro_invoice_no'] = $number;
                $pData['pro_invoice'] = transactionFormat($number, $type = 'PI', $branch_code);
                $pk_id = $this->invoice->addProInvoice($pData);
                if (!empty($pk_id)) {
                    $qData = [];
                    $qData['pro_invoice_id'] = $pk_id;
                    $qData['job_id'] = !empty($_POST['job_id']) ? $_POST['job_id'] : '';
                    $qData['remarks'] = !empty($_POST['remarks']) ? $_POST['remarks'] : '';
                    $qData['amount'] = !empty($_POST['amount']) ? $_POST['amount'] : '0.00';
                    $this->invoice->addProInvoiceJobs($qData);
                    redirect(base_url() . 'admin/transactions/pdf/?customer_id=' . $_POST['customer_id'] . '&transaction=' . $_GET['transaction'] . '&trans_id=' . $pk_id);
                } else {
                    $_SESSION['error'] = 'Failed to Create Pro-Forma Invoice';
                    $data['details'] = $_POST;
                }
            }
            //Show Data
            if (!empty($this->_REQ['transaction']) && !empty($this->_REQ['inward_no'])) {
                $data['inward'] = $this->dbapi->getInwardByJobId($this->_REQ['inward_no']);
            }
            if (!empty($this->_REQ['transaction']) && !empty($this->_REQ['customer_id'])) {
                $jobs = explode(',', $_SESSION['trans_jobs']);
                $inwards = [];
                for ($i = 0; $i < count($jobs); $i++) {
                    $inward = $this->dbapi->searchInwards(['customer_id' => $this->_REQ['customer_id'], 'job_pk_id' => $jobs[$i], 'branch_id' => $_SESSION['BRANCH_ID']]);
                    array_push($inwards, $inward);
                }
                $data['inwards'] = $inwards;
            }
            $data['customer'] = $this->quotation->getCustomerByNo($this->_REQ['customer_id']);
            $this->_template('transactions/pro-forma/pro-invoice-details', $data);
        } //Invoice
        else if ($mode == "invoice") {
            //Post invoice
            if (!empty($_POST['job_id']) && !empty($_GET['customer_id'])) {
                $pData = [];
                $pData['customer_id'] = !empty($_POST['customer_id']) ? $_POST['customer_id'] : '';
                $pData['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
                $pData['created_by'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                $pData['invoice_date'] = !empty($_POST['invoice_date']) ? dateForm2DB($_POST['invoice_date']) : '';
                $pData['total_amount'] = !empty($_POST['total_amount']) ? $_POST['total_amount'] : '0.00';
                $pData['cgst_amount'] = !empty($_POST['cgst_amount']) ? $_POST['cgst_amount'] : '0.00';
                $pData['sgst_amount'] = !empty($_POST['sgst_amount']) ? $_POST['sgst_amount'] : '0.00';
                $pData['igst_amount'] = !empty($_POST['igst_amount']) ? $_POST['igst_amount'] : '0.00';
                $pData['ship_handling_amount'] = !empty($_POST['ship_handling_amount']) ? $_POST['ship_handling_amount'] : '0.00';
                $pData['total_tax'] = !empty($_POST['total_tax']) ? $_POST['total_tax'] : '0.00';
                $pData['final_amount'] = !empty($_POST['final_amount']) ? $_POST['final_amount'] : '0.00';
                $pData['notes'] = !empty($_POST['notes']) ? $_POST['notes'] : '';
                $branch_code = !empty($_SESSION['BRANCH_CODE']) ? $_SESSION['BRANCH_CODE'] : '';
                $count = $this->invoice->getBranchInvoices($_SESSION['BRANCH_ID']);
                $number = str_pad($count['CNT'] + 1, 3, '0', STR_PAD_LEFT);
                $pData['invoice_no'] = $number;
                $pData['invoice'] = transactionFormat($number, $type = 'I', $branch_code);
                $pk_id = $this->invoice->addInvoice($pData);
                if (!empty($pk_id)) {
                    foreach ($_POST['job_id'] as $k => $v) {
                        $qData = [];
                        $qData['invoice_id'] = $pk_id;
                        $qData['job_id'] = !empty($_POST['job_id'][$k]) ? $_POST['job_id'][$k] : '';
                        $qData['remarks'] = !empty($_POST['remarks'][$k]) ? $_POST['remarks'][$k] : '';
                        $qData['amount'] = !empty($_POST['amount'][$k]) ? $_POST['amount'][$k] : '0.00';
                        $this->invoice->addInvoiceJobs($qData);
                    }
                    redirect(base_url() . 'admin/transactions/pdf/?customer_id=' . $_POST['customer_id'] . '&transaction=' . $_GET['transaction'] . '&trans_id=' . $pk_id);
                } else {
                    $_SESSION['error'] = 'Failed to Create Pro-Forma Invoice';
                    $data['details'] = $_POST;
                }
            }
            if (!empty($_POST['job_id']) && !empty($_GET['inward_no'])) {
                $pData = [];
                $pData['customer_id'] = !empty($_POST['customer_id']) ? $_POST['customer_id'] : '';
                $pData['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
                $pData['created_by'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                $pData['invoice_date'] = !empty($_POST['invoice_date']) ? dateForm2DB($_POST['invoice_date']) : '';
                $pData['total_amount'] = !empty($_POST['total_amount']) ? $_POST['total_amount'] : '0.00';
                $pData['cgst_amount'] = !empty($_POST['cgst_amount']) ? $_POST['cgst_amount'] : '0.00';
                $pData['sgst_amount'] = !empty($_POST['sgst_amount']) ? $_POST['sgst_amount'] : '0.00';
                $pData['igst_amount'] = !empty($_POST['igst_amount']) ? $_POST['igst_amount'] : '0.00';
                $pData['ship_handling_amount'] = !empty($_POST['ship_handling_amount']) ? $_POST['ship_handling_amount'] : '0.00';
                $pData['total_tax'] = !empty($_POST['total_tax']) ? $_POST['total_tax'] : '0.00';
                $pData['final_amount'] = !empty($_POST['final_amount']) ? $_POST['final_amount'] : '0.00';
                $pData['notes'] = !empty($_POST['notes']) ? $_POST['notes'] : '';
                $branch_code = !empty($_SESSION['BRANCH_CODE']) ? $_SESSION['BRANCH_CODE'] : '';
                $count = $this->invoice->getBranchInvoices($_SESSION['BRANCH_ID']);
                $number = str_pad($count['CNT'] + 1, 3, '0', STR_PAD_LEFT);
                $pData['invoice_no'] = $number;
                $pData['invoice'] = transactionFormat($number, $type = 'I', $branch_code);
                $pk_id = $this->invoice->addInvoice($pData);
                if (!empty($pk_id)) {
                    $qData = [];
                    $qData['invoice_id'] = $pk_id;
                    $qData['job_id'] = !empty($_POST['job_id']) ? $_POST['job_id'] : '';
                    $qData['remarks'] = !empty($_POST['remarks']) ? $_POST['remarks'] : '';
                    $qData['amount'] = !empty($_POST['amount']) ? $_POST['amount'] : '0.00';
                    $this->invoice->addInvoiceJobs($qData);
                    redirect(base_url() . 'admin/transactions/pdf/?customer_id=' . $_POST['customer_id'] . '&transaction=' . $_GET['transaction'] . '&trans_id=' . $pk_id);
                } else {
                    $_SESSION['error'] = 'Failed to Create Pro-Forma Invoice';
                    $data['details'] = $_POST;
                }
            }
            //Show Data
            if (!empty($this->_REQ['transaction']) && !empty($this->_REQ['inward_no'])) {
                $data['inward'] = $this->dbapi->getInwardByJobId($this->_REQ['inward_no']);
            }
            if (!empty($this->_REQ['transaction']) && !empty($this->_REQ['customer_id'])) {
                $jobs = explode(',', $_SESSION['trans_jobs']);
                $inwards = [];
                for ($i = 0; $i < count($jobs); $i++) {
                    $inward = $this->dbapi->searchInwards(['customer_id' => $this->_REQ['customer_id'], 'job_pk_id' => $jobs[$i], 'branch_id' => $_SESSION['BRANCH_ID']]);
                    array_push($inwards, $inward);
                }
                $data['inwards'] = $inwards;
            }
            $data['customer'] = $this->quotation->getCustomerByNo($this->_REQ['customer_id']);
            $this->_template('transactions/invoice/invoice-details', $data);
        } else {
            redirect(base_url() . 'admin/transactions/');
        }
    }
    public function pdf()
    {
        $data = [];
        if ($_GET['transaction'] == 'quotation') {
            $data['quotation'] = $this->quotation->getQuotationById($this->_REQ['trans_id']);
            $data['quotation_jobs'] = $this->quotation->getQuotationJobs(['quotation_id' => $this->_REQ['trans_id']]);
            $data['branch'] = $this->quotation->getBranchById(!empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '');
            $data['customer'] = $this->quotation->getCustomerById($this->_REQ['customer_id']);
            $this->header_data['title'] = $data['quotation']['quotation'];
            $this->_template('transactions/quotation/quotation-print', $data);
        } else if ($_GET['transaction'] == 'pro-forma-invoice') {
            $data['pro_forma_invoice'] = $this->invoice->getProInvoiceById($this->_REQ['trans_id']);
            $data['pro_forma_invoice_jobs'] = $this->invoice->getProInvoiceJobs(['pro_invoice_id' => $this->_REQ['trans_id']]);
            $data['branch'] = $this->invoice->getBranchById(!empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '');
            $data['customer'] = $this->invoice->getCustomerById($this->_REQ['customer_id']);
            $this->header_data['title'] = $data['pro_forma_invoice']['pro_invoice'];
            $this->_template('transactions/pro-forma/pro-invoice-print', $data);
        } else if ($_GET['transaction'] == 'invoice') {
            $data['invoice'] = $this->invoice->getInvoiceById($this->_REQ['trans_id']);
            $data['invoice_jobs'] = $this->invoice->getInvoiceJobs(['invoice_id' => $this->_REQ['trans_id']]);
            $data['branch'] = $this->invoice->getBranchById(!empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '');
            $data['customer'] = $this->invoice->getCustomerById($this->_REQ['customer_id']);
            $this->header_data['title'] = $data['invoice']['invoice'];
            $this->_template('transactions/invoice/invoice-print', $data);
        }
    }
    public function fetchCustomersByTransaction()
    {
        if (!empty($this->_REQ['transaction'])) {
            $branch_id = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
            if ($this->_REQ['transaction'] == 'quotation') {
                $users = $this->quotation->searchCustomers(['branch_id' => $branch_id, 'quotation' => true]);
            } else if ($this->_REQ['transaction'] == 'proforma') {
                $users = $this->invoice->searchCustomers(['branch_id' => $branch_id, 'pro_forma_invoice' => true]);
            } else if ($this->_REQ['transaction'] == 'invoice') {
                $users = $this->invoice->searchCustomers(['branch_id' => $branch_id, 'invoice' => true]);
            }
            echo json_encode($users);
        }
    }
    public function reports()
    {
        $this->header_data['title'] = "Transaction Reports";
        $data = [];
        $transaction_no = (!empty($this->_REQ['transac']) && isset($this->_REQ['transac'])) ? $this->_REQ['transac'] : '';
        $search_value = (!empty($this->_REQ['transaction_value']) && isset($this->_REQ['transaction_value'])) ? $this->_REQ['transaction_value'] : '';
        if (!empty($search_value)) {
            if ($transaction_no == 'quotation') {
                $data['transactions'] = $this->quotation->getQuotationJobsByQuotationNo($search_value);
            } else if ($transaction_no == 'proforma') {
                $data['transactions'] = $this->invoice->getProInvoiceJobsByProInvoiceNo($search_value);
            } else if ($transaction_no == 'invoice') {
                $data['transactions'] = $this->invoice->getInvoiceJobsByInvoiceNo($search_value);
            }
            if (!empty($_GET)) {
                $data['customers_else'] = $this->quotation->searchCustomers(['branch_id' => $_SESSION['BRANCH_ID']]);
            }
            $data['response'] = true;
        } else if (empty($search_value)) {
            if (!empty($_GET['transac']) && ($_GET['transac'] == 'quotation')) {
                $data['transactions_list'] = $this->quotation->getTransactionsByCustomerId(['quotation' => true, 'customer_id' => $this->_REQ['customer_id']]);
            } else if (!empty($_GET['transac']) && ($_GET['transac'] == 'proforma')) {
                $data['transactions_list'] = $this->quotation->getTransactionsByCustomerId(['proforma' => true, 'customer_id' => $this->_REQ['customer_id']]);
            } else if (!empty($_GET['transac']) && ($_GET['transac'] == 'invoice')) {
                $data['transactions_list'] = $this->quotation->getTransactionsByCustomerId(['invoice' => true, 'customer_id' => $this->_REQ['customer_id']]);
            }
            $data['branch'] = $this->quotation->getBranchById(!empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '');
            if (!empty($_GET['customer_id'])) {
                $data['customer'] = $this->quotation->getCustomerByNo($this->_REQ['customer_id']);
            }
            if (!empty($_GET)) {
                $data['customers_else'] = $this->quotation->searchCustomers(['branch_id' => $_SESSION['BRANCH_ID']]);
            }
        } else {
        }
        $this->_template('transactions/reports/index', $data);
    }
    public function send($type = 'mail', $format = '', $trans_id = '', $to = '', $customer_id = '')
    {
        if ($type == "mail") {
            $customer = $this->quotation->getCustomerByNo($customer_id);
            $transMail = [];
            $transMail['to'] = $customer['email'];
            $transMail['to_name'] = $customer['first_name'];
            $data['customer'] = $customer;
            $transMail['from'] = 'no-reply@hifitech.in';
            $transMail['from_name'] = 'HiFi Transactions';
            if ($format == 'quotation') {
                $data['quotation'] = $this->quotation->getQuotationById($trans_id);
                $data['quotation_jobs'] = $this->quotation->getQuotationJobs(['quotation_id' => $trans_id]);
                $data['branch'] = $this->quotation->getBranchById(!empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '');
                $transMail['subject'] = "Quotation for " . $data['quotation']['quotation'];
                $transMail['body'] = $data;
                $check_mail = $this->sendEmail('email/transactions/quotation', $transMail);
            } else if ($format == 'proforma') {
                $data['pro_forma_invoice'] = $this->invoice->getProInvoiceById($trans_id);
                $data['pro_forma_invoice_jobs'] = $this->invoice->getProInvoiceJobs(['pro_invoice_id' => $trans_id]);
                $data['branch'] = $this->invoice->getBranchById(!empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '');
                $transMail['subject'] = "Pro-Forma Invoice for " . $data['pro_forma_invoice']['pro_invoice'];
                $transMail['body'] = $data;
                $check_mail = $this->sendEmail('email/transactions/pro-invoice', $transMail);
            } else if ($format == 'invoice') {
                $data['invoice'] = $this->invoice->getInvoiceById($trans_id);
                $data['invoice_jobs'] = $this->invoice->getInvoiceJobs(['invoice_id' => $trans_id]);
                $data['branch'] = $this->invoice->getBranchById(!empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '');
                $transMail['subject'] = " Invoice for " . $data['invoice']['invoice'];
                $transMail['body'] = $data;
                $check_mail = $this->sendEmail('email/transactions/invoice', $transMail);
            }
            if ($check_mail) {
                echo "<h1 style='color:forestgreen'>" . $transMail['subject'] . " Sent Successfully to " . $customer['email'] . "</h1>";
                redirect(base_url() . 'admin/transactions/?mail=true');
            } else {
                echo "<h1  style='color:red'>We couldn't send " . $transMail['subject'] . " to " . $customer['email'] . "</h1>";
                redirect(base_url() . 'admin/transactions/?mail=false');
            }
        } else if ($type == "sms") {
            echo "<h1>SMS</h1>";
        }
    }
}
