<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proforma extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["ADMIN"]);
        $this->load->model("Inward_model", "inward", TRUE);
        $this->load->model("Quotation_model", "quotation", TRUE);
        $this->load->model("Proforma_model", "proforma", TRUE);
        $this->load->model("Customers_model", "customer", TRUE);
        $this->load->model("Branch_model", "branch", TRUE);
    }

    public function index()
    {
        $data = [];
        $this->header_data['title'] = 'Proforma Invoices';
        $search_data = array();
        if (isset($_GET['branch_id'])) {
            $search_data['branch_id'] = $_GET['branch_id'];
        } else {
            $search_data['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
        }
        $this->load->library('Pagenavi');
        $this->pagenavi->search_data = $search_data;
        $this->pagenavi->per_page = 20;
        $this->pagenavi->base_url = get_role_based_link() . '/proforma/?';
        $this->pagenavi->process($this->proforma, 'searchProformas');
        $data['PAGING'] = $this->pagenavi->links_html;
        $data['invoices'] = $this->pagenavi->items;
        $this->_template("proforma/index", $data);
    }

    public function add()
    {
        $data = [];
        $this->header_data['title'] = 'Add Proforma';
        $type = isset($this->_REQ['type']) ? $this->_REQ['type'] : '';
        $value = isset($this->_REQ['value']) ? $this->_REQ['value'] : '';
        if (!empty($this->_REQ['quotation_no'])) {
            $pk_id = $this->_REQ['quotation_no'];
            $quotation = $this->quotation->getQuotationById($pk_id);
            if (!empty($quotation)) {
                $quotation['quotation_items'] = $this->quotation->getQuotationJobs(["quotation_id" => $quotation['pk_id'], "is_quote" => 'NO']);
            }
            $data['branch'] = $this->inward->getBranchById($quotation['branch_id']);
            $data['customer'] = $this->customer->getCustomerDetails(['pk_id' => $quotation['customer_id']]);
            $data['quotation'] = $quotation;
        }
        if (!empty($_POST['quotation_job_id'])) {
            $pdata = [];
            $date = !empty($_POST['work_order_date']) ? '$' . dateRangeForm2DB($_POST['work_order_date']) : '';
            $pdata['customer_id'] = !empty($_POST['customer_id']) ? trim($_POST['customer_id']) : '';
            $pdata['proforma_date'] = !empty($_POST['proforma_date']) ? dateRangeForm2DB($_POST['proforma_date']) : '';
            $pdata['total_amount'] = !empty($_POST['total_amount']) ? trim($_POST['total_amount']) : '0.00';
            $pdata['total_tax'] = !empty($_POST['total_tax']) ? trim($_POST['total_tax']) : '0.00';
            $pdata['cgst_amount'] = !empty($_POST['cgst_amount']) ? trim($_POST['cgst_amount']) : '0.00';
            $pdata['sgst_amount'] = !empty($_POST['sgst_amount']) ? trim($_POST['sgst_amount']) : '0.00';
            $pdata['igst_amount'] = !empty($_POST['igst_amount']) ? trim($_POST['igst_amount']) : '0.00';
            $pdata['final_amount'] = !empty($_POST['final_amount']) ? trim($_POST['final_amount']) : '0.00';
            $pdata['work_order'] = !empty($_POST['work_order']) ? $_POST['work_order'] . $date : '';
            $pdata['text_amount'] = !empty($_POST['text_amount']) ? $_POST['text_amount'] : '';
            $pdata['notes'] = !empty($_POST['notes']) ? $_POST['notes'] : '';
            $pdata['branch_id'] = $_SESSION['BRANCH_ID'];
            $pdata['created_by'] = $_SESSION['USER_ID'];
            $pdata['notes'] = !empty($_POST['notes']) ? $_POST['notes'] : '';
            $branch_code = !empty($_SESSION['BRANCH_CODE']) ? $_SESSION['BRANCH_CODE'] : '';
            //$count = $this->proforma->getBranchProformas($_SESSION['BRANCH_ID']);
            $action_type = 'PROFORMA';
            $count = $this->inward->getBranchSequenceNumber($_SESSION['BRANCH_ID'],$action_type);                        
            $number = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
            $pdata['proforma_no'] = $number;
            $pdata['proforma'] = transactionFormat($number, $type = 'P', $branch_code);
            $last_pk_id = $this->proforma->addProforma($pdata);
            if (!empty($last_pk_id)) {
                $upd['number']=$count+1;                
                $this->inward->updateSequenceNumber($upd,$_SESSION['BRANCH_ID'],$action_type);                
                $pdata['proforma_id'] = $last_pk_id;
                $data['customer'] = $this->customer->getCustomerDetails(['pk_id' => $pdata['customer_id']]);
                $history_id = $this->proforma->addProformaHistory($pdata);
                foreach ($_POST['job_id'] as $k => $v) {
                    if (!empty($_POST['amount'][$k])) {
                        $qData = [];
                        $qData['proforma_id'] = $last_pk_id;
                        $sData['proforma'] = $pdata['proforma'];
                        $sData['proforma_no'] = $number;
                        $qData['job_id'] = !empty($_POST['job_id'][$k]) ? $_POST['job_id'][$k] : '';
                        $qData['status'] = !empty($_POST['status'][$k]) ? $_POST['status'][$k] : '';
                        $qData['amount'] = !empty($_POST['amount'][$k]) ? $_POST['amount'][$k] : '0.00';
                        $qData['tax_amount'] = !empty($_POST['tax_amount'][$k]) ? $_POST['tax_amount'][$k] : '0.00';
                        $qData['net_amount'] = !empty($_POST['net_amount'][$k]) ? $_POST['net_amount'][$k] : '0.00';
                        $upfData['job_id'] = !empty($_POST['job_pk_id'][$k]) ? $_POST['job_pk_id'][$k] : '';
                        $this->proforma->updateProforma(['job_id' => $upfData['job_id']], $pk_id);
                        $jData = [];
                        $jData['proforma_id'] = $last_pk_id;
                        $jData['quotation_job_id'] = $_POST['quotation_job_id'][$k];
                        $jData['pi_remarks'] = $_POST['pi_remarks'][$k];
                        $last_id = $this->proforma->addProformaJobs($jData);
                        $this->quotation->updateQuotationJobs(['proforma_job_id' => $last_id], $_POST['quotation_job_id'][$k]);
                        $qData['history_id'] = $history_id;
                        $this->proforma->addProformaHistoryJobs($qData);
                        $data['iunward_data'] = $this->inward->getInwardById($qData['job_id']);
                        $this->sendSMS($data['customer']['mobile'], "Proforma Invoice  for your Job Id " . $data['iunward_data']['job_id'] . "having repair charges are Rs." . $qData['net_amount'] . " .Thank you, from  K.SaiBabu, Hi.Fi Technologies, Hyd, 9490746511.");
                        $hData = [];
                        $hData['inward_id'] = $upfData['job_id'];
                        $hData['status'] = 'Pro-Forma INVOICE';
                        $hData['remarks'] = '';
                        $hData['user_id'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                        $sta = $this->inward->addInwardStatus($hData);
                    }
                }
                redirect(base_url() . 'admin/proforma/view/' . $last_pk_id);
            }
        }        
        $data['quotations'] = $this->quotation->getQuotationsListForProforma();
        $this->_template("proforma/form", $data);
    }

    public function edit1($pk_id = '')
    {
        
        if (!empty($_POST['proforma_id'])) {
            $pdata = [];
            $pdata['customer_id'] = !empty($_POST['customer_id']) ? trim($_POST['customer_id']) : '';
            $pdata['proforma'] = !empty($_POST['proforma']) ? trim($_POST['proforma']) : '';
            $pdata['proforma_no'] = !empty($_POST['proforma_no']) ? trim($_POST['proforma_no']) : '';
            $pdata['proforma_date'] = !empty($_POST['proforma_date']) ? dateForm2DB($_POST['proforma_date']) : '';
            $pdata['total_amount'] = !empty($_POST['total_amount']) ? trim($_POST['total_amount']) : '0.00';
            $pdata['total_tax'] = !empty($_POST['total_tax']) ? trim($_POST['total_tax']) : '0.00';
            $pdata['cgst_amount'] = !empty($_POST['cgst_amount']) ? trim($_POST['cgst_amount']) : '0.00';
            $pdata['sgst_amount'] = !empty($_POST['sgst_amount']) ? trim($_POST['sgst_amount']) : '0.00';
            $pdata['igst_amount'] = !empty($_POST['igst_amount']) ? trim($_POST['igst_amount']) : '0.00';
            $pdata['final_amount'] = !empty($_POST['final_amount']) ? trim($_POST['final_amount']) : '0.00';
            $work_order = !empty($_POST['work_order']) ? trim($_POST['work_order']) : '';
            $work_order_date = !empty($_POST['work_order_date']) ? dateForm2DB($_POST['work_order_date']) : '';
            $pdata['work_order'] = $work_order . '$' . $work_order_date;
            $pdata['text_amount'] = !empty($_POST['text_amount']) ? trim($_POST['text_amount']) : '';
            $pdata['notes'] = !empty($_POST['notes']) ? $_POST['notes'] : '';
            $proforma_id = $this->proforma->updateProforma($pdata, $_POST['proforma_id']);
            $pData = [];
            if (!empty($_POST['proforma_id'])) {
                $pData['proforma_id'] = $_POST['proforma_id'];
                $history_id = $this->proforma->addProformaHistory($pData);
                foreach ($_POST['job_id'] as $k => $v) {
                    if (!empty($_POST['amount'][$k])) {
                        $qData = [];
                        $qData['proforma_id'] = $pk_id;
                        $quotation_job_id = !empty($_POST['quotation_job_id'][$k]) ? $_POST['quotation_job_id'][$k] : '';
                        $this->inward->updateInward(['estimation_amt' => $pdata['final_amount']], $_POST['job_id'][$k]);
                        $this->proforma->updateProformaJobs($qData, $quotation_job_id);
                        $qData['history_id'] = $history_id;
                        $qData['job_id'] = !empty($_POST['job_id'][$k]) ? $_POST['job_id'][$k] : '';
                        $qData['job'] = !empty($_POST['job'][$k]) ? $_POST['job'][$k] : '';
                        $qData['amount'] = !empty($_POST['amount'][$k]) ? $_POST['amount'][$k] : '0.00';
                        $this->proforma->addProformaHistoryJobs($qData);
                    }
                }
                $_SESSION['message'] = 'Proforma updated Successfully';
                redirect(base_url() . 'admin/proforma/view/' . $pk_id);
            } else {
                $_SESSION['error'] = 'Failed to Update Quotation';
                $data['proforma'] = $_POST;
            }
            redirect(base_url() . 'admin/proforma/proforma-print/' . $proforma_id);
        }
        
    }

    public function edit($pk_id = '')
    {
        $data = [];
        $this->header_data['title'] = 'Edit Proforma';
        if (!empty($pk_id)) {
            $proforma = $this->proforma->getProformaById($pk_id);
            if (!empty($proforma)) {
                $proforma['proforma_items'] = $this->proforma->getProformaJobs(["proforma_id" => $proforma['pk_id']]);
            }
            $data['branch'] = $this->inward->getBranchById($proforma['branch_id']);
            $data['customer'] = $this->customer->getCustomerDetails(['pk_id' => $proforma['customer_id']]);
            $data['proforma'] = $proforma;
        }
        if (!empty($_POST['proforma_id'])) {                                   
            foreach ($_POST['quotation_job_id'] as $job_id) {
                $this->quotation->updateQuotationJobs(['proforma_job_id' => '0'], $job_id);
            }             
            $pdata = [];
            $pData = [];
            $pdata['customer_id'] = !empty($_POST['customer_id']) ? $_POST['customer_id'] : '';                        
            $pdata['proforma'] = !empty($_POST['proforma']) ? $_POST['proforma'] : '';
            $pdata['proforma_no'] = !empty($_POST['proforma_no']) ? $_POST['proforma_no'] : '';                    
            //$pdata['proforma_date'] = ($pdata['proforma_date']=='0000-00-00') ? dateForm2DB($_POST['proforma_date']) : '';
            $pdata['proforma_date'] = !empty($_POST['proforma_date']) ? dateRangeForm2DB($_POST['proforma_date'])  : '';            
            $pdata['total_amount'] = !empty($_POST['total_amount']) ? $_POST['total_amount'] : '0.00';
            $pdata['cgst_amount'] = !empty($_POST['cgst_amount']) ? $_POST['cgst_amount'] : '0.00';
            $pdata['sgst_amount'] = !empty($_POST['sgst_amount']) ? $_POST['sgst_amount'] : '0.00';
            $pdata['igst_amount'] = !empty($_POST['igst_amount']) ? $_POST['igst_amount'] : '0.00';            
            $pdata['total_tax'] = !empty($_POST['total_tax']) ? $_POST['total_tax'] : '';
            $pdata['final_amount'] = !empty($_POST['final_amount']) ? $_POST['final_amount'] : '0.00';
            $pdata['text_amount'] = !empty($_POST['text_amount']) ? $_POST['text_amount'] : '';            
            $pdata['notes'] = !empty($_POST['notes']) ? $_POST['notes'] : '';
            $work_order = !empty($_POST['work_order']) ? trim($_POST['work_order']) : '';
            $work_order_date = !empty($_POST['work_order_date']) ? dateRangeForm2DB($_POST['work_order_date']) : '';            
            $pdata['work_order'] = $work_order . '$' . $work_order_date;
            $this->proforma->updateProforma($pdata, $_POST['proforma_id']);
            if (!empty($_POST['proforma_id'])) {
                $pdata['proforma_id'] = $_POST['proforma_id'];
                $pdata['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';            
                $pdata['created_by'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';            
                $history_id = $this->proforma->addProformaHistory($pdata);
                foreach ($_POST['job_id'] as $k => $v) {
                    if (!empty($_POST['amount'][$k])) {                                      
                        $qData = [];
                        $qData['proforma_id'] = $pk_id;
                        $quotation_job_id = !empty($_POST['quotation_job_id'][$k]) ? $_POST['quotation_job_id'][$k] : '';
                        $this->inward->updateInward(['estimation_amt' => $pdata['final_amount']], $_POST['job_id'][$k]);
                        $this->proforma->updateProformaJobs($qData, $quotation_job_id);
                        $last_id = !empty($_POST['proforma_job_id'][$k]) ? $_POST['proforma_job_id'][$k] : '';
                        $this->quotation->updateQuotationJobs(['proforma_job_id' => $last_id], $_POST['quotation_job_id'][$k]);
                        $qData['history_id'] = $history_id;                        
                        $qData['job_id'] = !empty($_POST['job'][$k]) ? $_POST['job'][$k] : '';
                        $qData['amount'] = !empty($_POST['amount'][$k]) ? $_POST['amount'][$k] : '0.00';
                        $this->proforma->addProformaHistoryJobs($qData);                     
                    }
                }
                $_SESSION['message'] = 'Proforma updated Successfully';
                redirect(base_url() . 'admin/proforma/view/' . $pk_id);
            } else {
                $_SESSION['error'] = 'Failed to Update Proforma';
                $data['proforma'] = $_POST;
            }
        }
        $this->_template("proforma/edit", $data);
    }

    public function view($pk_id = '')
    {
        $data = [];
        $this->header_data['title'] = 'View Proforma';
        $proforma = $this->proforma->getProformaById($pk_id);
        if (!empty($proforma)) {
            $proforma['proforma_items'] = $this->proforma->getProformaJobs(["proforma_id" => $proforma['pk_id']]);
        }
        $data['proforma'] = $proforma;
        $data['branch'] = $this->inward->getBranchById($proforma['branch_id']);
        $data['customer'] = $this->customer->getCustomerById($proforma['customer_id']);
        $data['branch_admin'] = $this->branch->getBranchAdmin($_SESSION['BRANCH_ID']);
        $admin = $this->branch->getBranchAdmin($_SESSION['BRANCH_ID']);
        $data['to'] = $data['customer']['email'];
        $data['cc'] = $admin['email'];
        $data['proforma_email'] = $proforma['proforma'];
        $data['subject'] = "Pro-Forma Invoice -" . $proforma['proforma'];
        $this->sendEmail("email/transactions/pro-invoice", $data);
        $this->_template("proforma/view", $data);
    }

    public function proforma_print($pk_id = '')
    {
        $data = [];
        $proforma = $this->proforma->getProformaById($pk_id);
        if (!empty($proforma)) {
            $proforma['proforma_items'] = $this->proforma->getProformaJobs(["proforma_id" => $proforma['pk_id']]);
        }
        $data['proforma'] = $proforma;
        $data['branch'] = $this->inward->getBranchById($proforma['branch_id']);
        $data['customer'] = $this->customer->getCustomerById($proforma['customer_id']);
        $this->load->view("proforma/print", $data);
    }

    public function proforma_edit_item()
    {
        if (!empty($this->_REQ)) {
            $proforma_id = !empty($this->_REQ['pi']) ? $this->_REQ['pi'] : '';
            $job = !empty($this->_REQ['pij']) ? $this->_REQ['pij'] : ''; 
            $pf_job = $this->proforma->getProformaJobById($job); 
            $qdata = $this->quotation->getQuotationJobById($pf_job['quotation_job_id']);          
            $this->proforma->delProformaJobs($job);
            $this->quotation->updateQuotationJobs(['proforma_job_id'=>0],$qdata['pk_id']);
            //echo $job;
            //echo "<br/>proforma_id".$proforma_id;
            //exit();
           /* $proforma = $this->proforma->getProformaById($proforma_id);
            $pf_job = $this->proforma->getProformaJobById($job);
            $qdata = $this->quotation->getQuotationJobById($pf_job['quotation_job_id']);
            $_amount = $proforma['total_amount'] - $qdata['amount'];
            $_item_tax = $qdata['tax_amount'] - $qdata['amount'];
            $_tax_amount = $proforma['total_tax'] - $_item_tax;
            $_final_amount = $proforma['final_amount'] - $qdata['net_amount'];
            $new_data = array();
            $new_data['total_amount'] = $_amount;
            if (!empty($proforma['igst_amount']) && $proforma['igst_amount'] != '0.00') {
                $new_data['igst_amount'] = $_tax_amount;
                $new_data['total_tax'] = $new_data['igst_amount'];
            } else {
                $new_data['cgst_amount'] = $_tax_amount / 2;
                $new_data['sgst_amount'] = $_tax_amount / 2;
                $new_data['total_tax'] = $new_data['cgst_amount'] + $new_data['sgst_amount'];
            } */
        }
    }
}