<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["ADMIN"]);
        $this->load->model("Inward_model", "inward", TRUE);
        $this->load->model("Branch_model", "branch", TRUE);
        $this->load->model("Quotation_model", "quotation", TRUE);
        $this->load->model("Proforma_model", "proforma", TRUE);
        $this->load->model("Customers_model", "customer", TRUE);
        $this->load->model("Invoice_model", "invoice", TRUE);
    }

    public function index()
    {
        $data = [];
        $this->header_data['title'] = 'Invoices';
        $search_data = array();
        if (isset($_GET['branch_id'])) {
            $search_data['branch_id'] = $_GET['branch_id'];
        } else {
            $search_data['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
        }
        $this->load->library('Pagenavi');
        $this->pagenavi->search_data = $search_data;
        $this->pagenavi->per_page = 20;
        $this->pagenavi->base_url = get_role_based_link() . '/invoice/?';
        $this->pagenavi->process($this->invoice, 'searchInvoices');
        $data['PAGING'] = $this->pagenavi->links_html;
        $data['invoices'] = $this->pagenavi->items;
        $this->_template("invoice/index", $data);
    }

    public function add()
    {
        $data = [];
        $this->header_data['title'] = 'Add Invoice';
        if (!empty($this->_REQ['quotation_no'])) {
            $pk_id = $this->_REQ['quotation_no'];
            $quotation = $this->quotation->getQuotationById($pk_id);
            if (!empty($quotation)) {
                $quotation['quotation_items'] = $this->quotation->getQuotationJobs(["quotation_id" => $quotation['pk_id'], 'is_invoiced' => 'NO']);
            }
            $data['branch'] = $this->inward->getBranchById($quotation['branch_id']);
            $data['customer'] = $this->customer->getCustomerDetails(['pk_id' => $quotation['customer_id']]);
            $data['quotation'] = $quotation;
        }        
        else if (!empty($this->_REQ['proforma_no'])) {
            $pk_id = $this->_REQ['proforma_no'];
            $quotation = $this->proforma->getProformaById($pk_id);
            if (!empty($quotation)) {
                $quotation['quotation_items'] = $this->proforma->getProformaJobs(["proforma_id" => $quotation['pk_id'], 'is_invoiced' => 'NO']);
            }
            $data['branch'] = $this->inward->getBranchById($quotation['branch_id']);
            $data['customer'] = $this->customer->getCustomerDetails(['pk_id' => $quotation['customer_id']]);
            $data['quotation'] = $quotation;
        }
        else if (!empty($this->_REQ['job_id'])) {
            $pk_id = $this->_REQ['job_id'];
            $quotation = $this->inward->getInwardById($pk_id);
            // if (!empty($quotation)) {
            //     $quotation['quotation_items'] = $quotation;
            // }
            $data['branch'] = $this->inward->getBranchById($quotation['branch_id']);
            $data['customer'] = $this->customer->getCustomerDetails(['pk_id' => $quotation['customer_pk_id']]);
            $data['quotation'] = $quotation;
        }

        if (!empty($_POST['job_pk_id'])) {
            $pdata = [];
            $date = !empty($_POST['work_order_date']) ? '$' . dateRangeForm2DB($_POST['work_order_date']) : '';
            $pdata['customer_id'] = !empty($_POST['customer_id']) ? trim($_POST['customer_id']) : '';
            $pdata['invoice_date'] = !empty($_POST['invoice_date']) ? dateRangeForm2DB($_POST['invoice_date']) : '';
            $pdata['total_amount'] = !empty($_POST['total_amount']) ? trim($_POST['total_amount']) : '0.00';
            $pdata['total_tax'] = !empty($_POST['total_tax']) ? trim($_POST['total_tax']) : '0.00';
            $pdata['cgst_amount'] = !empty($_POST['cgst_amount']) ? trim($_POST['cgst_amount']) : '0.00';
            $pdata['sgst_amount'] = !empty($_POST['sgst_amount']) ? trim($_POST['sgst_amount']) : '0.00';
            $pdata['igst_amount'] = !empty($_POST['igst_amount']) ? trim($_POST['igst_amount']) : '0.00';
            $pdata['final_amount'] = !empty($_POST['final_amount']) ? trim($_POST['final_amount']) : '0.00';
            $pdata['work_order'] = !empty($_POST['work_order']) ? $_POST['work_order'] . $date : '';
            $pdata['text_amount'] = !empty($_POST['text_amount']) ? $_POST['text_amount'] : '';
            $pdata['branch_id'] = $_SESSION['BRANCH_ID'];
            $pdata['created_by'] = $_SESSION['USER_ID'];
            $branch_code = !empty($_SESSION['BRANCH_CODE']) ? $_SESSION['BRANCH_CODE'] : '';
            //$count = $this->invoice->getBranchInvoices($_SESSION['BRANCH_ID']);
            $action_type = 'TAX_INVOICE';
            $count = $this->inward->getBranchSequenceNumber($_SESSION['BRANCH_ID'],$action_type);            
            $number = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
            $pdata['invoice_no'] = $number;
            $pdata['invoice'] = transactionFormat($number, $type = 'I', $branch_code);            
            
            $in_last_id = $this->invoice->addInvoice($pdata);
            if (!empty($in_last_id)) {
                $upd['number']=$count+1;                
                $this->inward->updateSequenceNumber($upd,$_SESSION['BRANCH_ID'],$action_type);                
                $pdata['invoice_id'] = $in_last_id;
                if (!empty($_GET['type']) && ($_GET['type']=='Job_ID')) {                    
                    $jData = [];
                    $jData['invoice_id'] = $in_last_id;
                    $jData['job_id'] = $_POST['job_pk_id'];
                    $jData['i_remarks'] = $_POST['i_remarks'];
                    $jData['amount'] = $_POST['amount'];
                    $jData['final_amount'] = $_POST['final_amount'];                    
                    $last_id = $this->invoice->addInvoiceJobs($jData);                    
                    if(!empty($_POST['quotation_job_id'])){
                        $this->quotation->updateQuotationJobs(['invoice_job_id' => $last_id], $_POST['quotation_job_id']);
                    }
                    if(!empty($_POST['proforma_job_id'])){
                        $this->proforma->updateProformaJobs(['invoice_job_id' => $last_id], $_POST['proforma_job_id']);
                    }                    
                    $hData = [];
                    $hData['inward_id'] = $_POST['job_pk_id'];
                    $hData['status'] = 'INVOICE';
                    $hData['remarks'] = '';
                    $hData['user_id'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                    $sta = $this->inward->addInwardStatus($hData);
                    $this->inward->updateInward(['invoice_id'=>$in_last_id],$_POST['job_pk_id']);
                }else{
                    foreach ($_POST['job_pk_id'] as $k => $v) {
                        $jData = [];
                        $jData['invoice_id'] = $in_last_id;
                        $jData['job_id'] = $_POST['job_pk_id'][$k];
                        $jData['i_remarks'] = $_POST['i_remarks'][$k];
                        $jData['amount'] = $_POST['amount'][$k];
                        $jData['final_amount'] = $_POST['tax_amount'][$k];
                        $last_id = $this->invoice->addInvoiceJobs($jData);                    
                        $this->quotation->updateQuotationJobs(['invoice_job_id' => $last_id], $_POST['quotation_job_id'][$k]);
                        if(!empty($_POST['proforma_job_id'][$k])){
                            $this->proforma->updateProformaJobs(['invoice_job_id' => $last_id], $_POST['proforma_job_id'][$k]);
                        }                    
                        $hData = [];
                        $hData['inward_id'] = $_POST['job_pk_id'][$k];
                        $hData['status'] = 'INVOICE';
                        $hData['remarks'] = '';
                        $hData['user_id'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                        $sta = $this->inward->addInwardStatus($hData);
                        $this->inward->updateInward(['invoice_id'=>$in_last_id],$_POST['job_pk_id'][$k]);
                    }
                }
                
                redirect(base_url() . 'admin/invoice/view/' . $in_last_id);
            }
        }
        $data['quotations'] = $this->quotation->getQuotationsListNotInInvoice();
        $data['proformas'] = $this->proforma->getProformaListNotInInvoice();
        $data['jobs'] = $this->inward->getInwardListNotInInvoice();
        $this->_template("invoice/form", $data);
    }

    public function view($pk_id = '')
    {
        $data = [];
        $this->header_data['title'] = 'View Invoice';
        $branch_id = !empty($_GET['branch_id']) ? $_GET['branch_id'] : $_SESSION['BRANCH_ID'];
        $invoice = $this->invoice->getInvoiceById($pk_id, $branch_id);
        if (!empty($invoice)) {
            $invoice['invoice_items'] = $this->invoice->getInvoiceJobs(["invoice_id" => $invoice['pk_id'], 'branch_id' => $branch_id]);
        }
        $data['invoice'] = $invoice;
        $data['branch'] = $this->inward->getBranchById($invoice['branch_id']);
        $data['customer'] = $this->customer->getCustomerById($invoice['customer_id']);
        $admin = $this->branch->getBranchAdmin($_SESSION['BRANCH_ID']);
        $data['to'] = $data['customer']['email'];
        $data['cc'] = $admin['email'];
        $data['invoice_email'] = $invoice['invoice'];
        $data['subject'] = "Invoice -" . $invoice['invoice'];
        $data['branch_admin'] = $this->branch->getBranchAdmin($_SESSION['BRANCH_ID']);     
        $this->_template("invoice/view", $data);
    }

    public function invoice_print($pk_id = '')
    {
        $data = [];
        $branch_id = !empty($_GET['branch_id']) ? $_GET['branch_id'] : $_SESSION['BRANCH_ID'];
        $invoice = $this->invoice->getInvoiceById($pk_id, $branch_id);
        if (!empty($invoice)) {
            $invoice['invoice_items'] = $this->invoice->getInvoiceJobs(["invoice_id" => $invoice['pk_id'], 'branch_id' => $branch_id]);
        }
        $data['invoice'] = $invoice;
        $data['branch'] = $this->inward->getBranchById($invoice['branch_id']);
        $data['customer'] = $this->customer->getCustomerById($invoice['customer_id']);
        $this->load->view("invoice/print", $data);
    }
    public function edit($pk_id = '')
    {
        $data = [];
        $this->header_data['title'] = 'Edit Invoice';
        $branch_id = !empty($_GET['branch_id']) ? $_GET['branch_id'] : $_SESSION['BRANCH_ID'];
        if (!empty($pk_id)) {
            $invoice = $this->invoice->getInvoiceById($pk_id,$branch_id);
            if (!empty($invoice)) {
                $invoice['invoice_items'] = $this->invoice->getInvoiceJobs(["invoice_id" => $invoice['pk_id'], 'branch_id' => $branch_id]);
            }
            $data['branch'] = $this->inward->getBranchById($invoice['branch_id']);
            $data['customer'] = $this->customer->getCustomerById($invoice['customer_id']);
            $data['invoice'] = $invoice;
        }
        
        if (!empty($_POST['invoice_id'])) {                           
            $pdata = [];                        
            $pdata['invoice_date'] = !empty($_POST['invoice_date']) ? date("Y-m-d", strtotime($_POST['invoice_date']))  : '';            
            $pdata['total_amount'] = !empty($_POST['total_amount']) ? $_POST['total_amount'] : '0.00';
            $pdata['cgst_amount'] = !empty($_POST['cgst_amount']) ? $_POST['cgst_amount'] : '0.00';
            $pdata['sgst_amount'] = !empty($_POST['sgst_amount']) ? $_POST['sgst_amount'] : '0.00';
            $pdata['igst_amount'] = !empty($_POST['igst_amount']) ? $_POST['igst_amount'] : '0.00';            
            $pdata['total_tax'] = !empty($_POST['total_tax']) ? $_POST['total_tax'] : '';
            $pdata['final_amount'] = !empty($_POST['final_amount']) ? $_POST['final_amount'] : '0.00';
            $pdata['text_amount'] = !empty($_POST['text_amount']) ? $_POST['text_amount'] : '';            
            $pdata['notes'] = !empty($_POST['notes']) ? $_POST['notes'] : '';
            $work_order = !empty($_POST['work_order']) ? trim($_POST['work_order']) : '';
            $work_order_date = !empty($_POST['work_order_date']) ? date("Y-m-d", strtotime($_POST['work_order_date'])) : '';            
            $pdata['work_order'] = $work_order . '$' . $work_order_date;
            
            $this->invoice->updateInvoice($pdata, $_POST['invoice_id']);
            if (!empty($_POST['invoice_id'])) {                
                foreach ($_POST['inward_pk_id'] as $k => $v) {
                    if (!empty($_POST['amount'][$k])) {                                      
                        $qData = [];
                        $qData['invoice_id'] = $pk_id;
                        $invoice_job_id = !empty($_POST['inward_pk_id'][$k]) ? $_POST['inward_pk_id'][$k] : '';
                        $qData['job_id'] = !empty($_POST['job_id'][$k]) ? $_POST['job_id'][$k] : '';
                        $qData['i_remarks'] = !empty($_POST['i_remarks'][$k]) ? $_POST['i_remarks'][$k] : '';
                        $qData['amount'] = !empty($_POST['amount'][$k]) ? $_POST['amount'][$k] : '0.00';
                        $qData['final_amount'] = !empty($_POST['tax_amount'][$k]) ? $_POST['amount'][$k]+$_POST['tax_amount'][$k] : $_POST['amount'][$k];
                        $this->invoice->updateInvoiceJobs($qData,$invoice_job_id);                     
                    }
                }
                $_SESSION['message'] = 'Invoice updated Successfully';
                redirect(base_url() . 'admin/invoice/view/' . $pk_id);
            } else {
                $_SESSION['error'] = 'Failed to Update Invoice';
                $data['invoice'] = $_POST;
            }
        }        
        $this->_template("invoice/edit", $data);
    }
}