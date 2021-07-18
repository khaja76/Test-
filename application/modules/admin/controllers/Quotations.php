<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Quotations extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["ADMIN"]);
        $this->load->model("Inward_model", "inward", TRUE);
        $this->load->model("Quotation_model", "quotation", TRUE);
        $this->load->model("Customers_model", "customer", TRUE);
        $this->load->model("Branch_model", "branch", TRUE);
    }
    public function index()
    {
        $data = [];
        $this->header_data['title'] = 'Quotations';
        $search_data = array();
        if (!empty($this->_REQ['location_id'])) {
            $search_data['location_id'] = $this->_REQ['location_id'];
        }
        if (!empty($this->_REQ['branch_id'])) {
            $search_data['branch_id'] = $this->_REQ['branch_id'];
        } else {
            $search_data['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
        }
        $this->load->library('Pagenavi');
        $this->pagenavi->search_data = $search_data;
        $this->pagenavi->per_page = 20;
        $this->pagenavi->base_url = base_url() . '/admin/quotations/?';
        $this->pagenavi->process($this->quotation, 'searchQuotations');
        $data['PAGING'] = $this->pagenavi->links_html;
        $data['quotations'] = $this->pagenavi->items;
        $data['locations'] = $this->customer->getLocationsList();
        $data['branches_else'] = $this->customer->getBranchesList(!empty($this->_REQ['location_id']) ? $this->_REQ['location_id'] : '');
        $this->_template("quotations/index", $data);
    }
    public function add()
    {
        $data = [];
        $this->header_data['title'] = 'Add Quotation';
        if (!empty($this->_REQ['type'])) {
            $type = $this->_REQ['type'];
            $value = $this->_REQ['value'];
            if ($type == 'customer_id') {
                $data['customer'] = $this->customer->getCustomerDetails(['customer_no' => $value]);
                $data['inwards'] = $this->inward->searchInwards(['customer_id' => $value, 'branch_id' => $_SESSION['BRANCH_ID'], 'is_outwarded' => 'NO', 'quotation' => 'YES']);            
            } else {
                $inward = $this->inward->getInwardDetails(['job_id' => $value, 'quotation' => 'YES']);
                $data['customer'] = $this->customer->getCustomerDetails(['pk_id' => $inward[0]['customer_pk_id']]);
                $data['inwards'] = $inward;                
            }
            $data['branch'] = $this->inward->getBranchById($_SESSION['BRANCH_ID']);
            if (!empty($_POST['final_amount'])) {
                $pData = [];
                $pData['customer_id'] = !empty($_POST['customer_id']) ? $_POST['customer_id'] : '';
                $pData['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
                $pData['created_by'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                $pData['quotation_date'] = !empty($_POST['quotation_date']) ? dateRangeForm2DB($_POST['quotation_date']) : '';
                $pData['total_amount'] = !empty($_POST['total_amount']) ? $_POST['total_amount'] : '0.00';
                $pData['cgst_amount'] = !empty($_POST['cgst_amount']) ? round($_POST['cgst_amount']) : '0.00';
                $pData['sgst_amount'] = !empty($_POST['sgst_amount']) ? round($_POST['sgst_amount']) : '0.00';
                $pData['igst_amount'] = !empty($_POST['igst_amount']) ? round($_POST['igst_amount']) : '0.00';
                $pData['discount_amount'] = !empty($_POST['discount_amount']) ? round($_POST['discount_amount']) : '0.00';
                $pData['total_tax'] = !empty($_POST['total_tax']) ? round($_POST['total_tax']) : '0.00';
                $pData['final_amount'] = !empty($_POST['final_amount']) ? round($_POST['final_amount']) : '0.00';
                $pData['text_amount'] = !empty($_POST['text_amount']) ? $_POST['text_amount'] : '';
                $pData['notes'] = !empty($_POST['notes']) ? $_POST['notes'] : '';
                $branch_code = !empty($_SESSION['BRANCH_CODE']) ? $_SESSION['BRANCH_CODE'] : '';
                //$count = $this->quotation->getBranchQuotations($_SESSION['BRANCH_ID']);
                $action_type = 'QUOTATION';
                $count = $this->inward->getBranchSequenceNumber($_SESSION['BRANCH_ID'],$action_type);                
                $number = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
                $pData['quotation_no'] = $number;
                $pData['quotation'] = transactionFormat($number, $type = 'Q', $branch_code);
                $pk_id = $this->quotation->addQuotation($pData);
                if (!empty($pk_id)) {
                    $upd['number']=$count+1;                
                    $this->inward->updateSequenceNumber($upd,$_SESSION['BRANCH_ID'],$action_type);
                    $data['customer'] = $this->customer->getCustomerDetails(['pk_id' => $pData['customer_id']]);
                    $pData['quotation_id'] = $pk_id;
                    $history_id = $this->quotation->addQuotationHistory($pData);
                    foreach ($_POST['job_id'] as $k => $v) {
                        if (!empty($_POST['amount'][$k])) {
                            $qData = [];
                            $qData['quotation_id'] = $pk_id;
                            $qData['job_id'] = !empty($_POST['job_id'][$k]) ? $_POST['job_id'][$k] : '';
                            $qData['status'] = !empty($_POST['status'][$k]) ? $_POST['status'][$k] : '';
                            $qData['remarks'] = !empty($_POST['remarks'][$k]) ? $_POST['remarks'][$k] : '';
                            $qData['discount'] = !empty($_POST['discount'][$k]) ? $_POST['discount'][$k] : '0.00';
                            $qData['amount'] = !empty($_POST['amount'][$k]) ? round($_POST['amount'][$k]) : '0.00';
                            $qData['disc_amount'] = !empty($_POST['dis_amt'][$k]) ? round($_POST['dis_amt'][$k]) : '0.00';
                            $qData['tax_amount'] = !empty($_POST['tax_amount'][$k]) ? round($_POST['tax_amount'][$k]) : '0.00';
                            $qData['net_amount'] = !empty($_POST['net_amount'][$k]) ? round($_POST['net_amount'][$k]) : '0.00';
                            $this->inward->updateInward(['estimation_amt' => round($qData['net_amount'])], $qData['job_id']);
                            $this->quotation->addQuotationJobs($qData);
                            $qData['history_id'] = $history_id;
                            $this->quotation->addQuotationHistoryJobs($qData);
                            $data['iunward_data'] = $this->inward->getInwardById($qData['job_id']);
                            $this->sendSMS($data['customer']['mobile'], "Quotation  for your Job Id " . $data['iunward_data']['job_id'] . "having repair charges are Rs." . $qData['net_amount'] . " .Thank you, from  K.SaiBabu, Hi.Fi Technologies, Hyd, 9490746511.");
                            $hData = [];
                            $hData['inward_id'] = $qData['job_id'];
                            $hData['status'] = 'Quotation';
                            $hData['remarks'] = '';
                            $hData['user_id'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                            $sta = $this->inward->addInwardStatus($hData);

                        }
                    }
                    $_SESSION['message'] = 'Quotation added Successfully';
                    redirect(base_url() . 'admin/quotations/view/' . $pk_id);
                } else {
                    $_SESSION['error'] = 'Failed to Create Quotation';
                    $data['details'] = $_POST;
                }
            }
        }
        $this->_template("quotations/form", $data);
    }
    public function edit($pk_id = '')
    {
        $data = [];
        $this->header_data['title'] = 'Edit Quotation';
        if (!empty($pk_id)) {
            $quotation = $this->quotation->getQuotationById($pk_id);
            if (!empty($quotation)) {
                $quotation['quotation_items'] = $this->quotation->getQuotationJobs(["quotation_id" => $quotation['pk_id']]);
            }
            $data['branch'] = $this->inward->getBranchById($quotation['branch_id']);
            $data['customer'] = $this->customer->getCustomerDetails(['pk_id' => $quotation['customer_id']]);
            $data['quotation'] = $quotation;
        }
        if (!empty($_POST['quotation_id'])) {
            $quotation_job_ids = [];
            $form_quotation_job_ids = [];
            if (!empty($quotation['quotation_items'])) {
                foreach ($quotation['quotation_items'] as $qua) {
                    $quotation_job_ids['job_id'][] = $qua['job_id'];
                    $quotation_job_ids['quotation_job_id'][] = $qua['pk_id'];
                }
            }
            foreach ($_POST['job_id'] as $k => $v) {
                $form_quotation_job_ids['job_id'][] = !empty($_POST['job_id'][$k]) ? $_POST['job_id'][$k] : '';
                $form_quotation_job_ids['quotation_job_id'][] = !empty($_POST['quotation_job_id'][$k]) ? $_POST['quotation_job_id'][$k] : '';
            }
            $result1 = array_diff($quotation_job_ids['job_id'], $form_quotation_job_ids['job_id']);
            $result2 = array_diff($quotation_job_ids['quotation_job_id'], $form_quotation_job_ids['quotation_job_id']);
            if (!empty($result1)) {
                // Set Estimate value to Zero in Inwards Table
                foreach ($result1 as $res1) {
                    $this->inward->updateInward(['estimation_amt' => '0.00'], $res1);
                }
            }
            if (!empty($result2)) {
                // Remove Quotation Job from Quotation Job Table
                $this->quotation->deleteMultipleQuotationJobs($result2);
            }
            $pData = [];
            $pData['customer_id'] = !empty($_POST['customer_id']) ? $_POST['customer_id'] : '';
            $pData['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
            $pData['created_by'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
            $pData['quotation_date'] = !empty($_POST['quotation_date']) ? dateRangeForm2DB($_POST['quotation_date']) : '';
            $pData['total_amount'] = !empty($_POST['total_amount']) ? $_POST['total_amount'] : '0.00';
            $pData['cgst_amount'] = !empty($_POST['cgst_amount']) ? $_POST['cgst_amount'] : '0.00';
            $pData['sgst_amount'] = !empty($_POST['sgst_amount']) ? $_POST['sgst_amount'] : '0.00';
            $pData['igst_amount'] = !empty($_POST['igst_amount']) ? $_POST['igst_amount'] : '0.00';
            $pData['discount_amount'] = !empty($_POST['discount_amount']) ? $_POST['discount_amount'] : '0.00';
            $pData['total_tax'] = !empty($_POST['total_tax']) ? $_POST['total_tax'] : '0.00';
            $pData['final_amount'] = !empty($_POST['final_amount']) ? $_POST['final_amount'] : '0.00';
            $pData['text_amount'] = !empty($_POST['text_amount']) ? $_POST['text_amount'] : '';
            $pData['quotation'] = !empty($_POST['quotation']) ? $_POST['quotation'] : '';
            $pData['quotation_no'] = !empty($_POST['quotation_no']) ? $_POST['quotation_no'] : '';
            $pData['notes'] = !empty($_POST['notes']) ? $_POST['notes'] : '';
            $this->quotation->updateQuotation($pData, $_POST['quotation_id']);
            if (!empty($_POST['quotation_id'])) {
                $pData['quotation_id'] = $_POST['quotation_id'];
                $history_id = $this->quotation->addQuotationHistory($pData);
                foreach ($_POST['job_id'] as $k => $v) {
                    if (!empty($_POST['amount'][$k])) {
                        $qData = [];
                        $qData['quotation_id'] = $pk_id;
                        $quotation_job_id = !empty($_POST['quotation_job_id'][$k]) ? $_POST['quotation_job_id'][$k] : '';
                        $qData['job_id'] = !empty($_POST['job_id'][$k]) ? $_POST['job_id'][$k] : '';
                        $qData['status'] = !empty($_POST['status'][$k]) ? $_POST['status'][$k] : '';
                        $qData['remarks'] = !empty($_POST['remarks'][$k]) ? $_POST['remarks'][$k] : '';
                        $qData['discount'] = !empty($_POST['discount'][$k]) ? $_POST['discount'][$k] : '0.00';
                        $qData['amount'] = !empty($_POST['amount'][$k]) ? $_POST['amount'][$k] : '0.00';
                        $qData['disc_amount'] = !empty($_POST['dis_amt'][$k]) ? $_POST['dis_amt'][$k] : '0.00';
                        $qData['tax_amount'] = !empty($_POST['tax_amount'][$k]) ? $_POST['tax_amount'][$k] : '0.00';
                        $qData['net_amount'] = !empty($_POST['net_amount'][$k]) ? $_POST['net_amount'][$k] : '0.00';
                        $this->inward->updateInward(['estimation_amt' => $qData['net_amount']], $qData['job_id']);
                        $this->quotation->updateQuotationJobs($qData, $quotation_job_id);
                        $qData['history_id'] = $history_id;
                        $this->quotation->addQuotationHistoryJobs($qData);
                        $data['iunward_data'] = $this->inward->getInwardById($qData['job_id']);
                        $this->sendSMS($data['customer']['mobile'], "Quotation  for your Job Id " . $data['iunward_data']['job_id'] . "having repair charges are Rs." . $qData['net_amount'] . " .Thank you, from  K.SaiBabu, Hi.Fi Technologies, Hyd, 9490746511.");
                    }
                }
                $_SESSION['message'] = 'Quotation updated Successfully';
                redirect(base_url() . 'admin/quotations/view/' . $pk_id);
            } else {
                $_SESSION['error'] = 'Failed to Update Quotation';
                $data['quotation'] = $_POST;
            }
        }
        $this->_template("quotations/edit", $data);
    }
    public function view($pk_id = '')
    {
        $data = [];
        $this->header_data['title'] = 'View Quotation';
        $quotation = $this->quotation->getQuotationById($pk_id);
        if (!empty($quotation)) {
            $quotation['quotation_items'] = $this->quotation->getQuotationJobs(["quotation_id" => $quotation['pk_id']]);
        }
        $data['branch'] = $this->inward->getBranchById($quotation['branch_id']);
        $data['customer'] = $this->customer->getCustomerDetails(['pk_id' => $quotation['customer_id'], 'branch_id' => $quotation['branch_id']]);
        $data['quotation'] = $quotation;
        $admin = $this->branch->getBranchAdmin($_SESSION['BRANCH_ID']);
        $data['to'] = $data['customer']['email'];
        $data['cc'] = $admin['email'];
        $data['quotation_email'] =$quotation['quotation'];
        $data['subject'] = "Quotation -".$quotation['quotation'];
        $data['branch_admin']=$this->branch->getBranchAdmin($_SESSION['BRANCH_ID']);
        $this->sendEmail("email/transactions/quotation", $data);
        $this->_template("quotations/view", $data);
    }
    public function quotation_print($pk_id = '')
    {
        $data = [];
        $this->header_data['title'] = 'Quotation';
        $quotation = $this->quotation->getQuotationById($pk_id);
        if (!empty($quotation)) {
            $quotation['quotation_items'] = $this->quotation->getQuotationJobs(["quotation_id" => $quotation['pk_id']]);
        }
        $data['branch'] = $this->inward->getBranchById($quotation['branch_id']);
        $data['customer'] = $this->customer->getCustomerDetails(['pk_id' => $quotation['customer_id']]);
        $data['quotation'] = $quotation;
        $this->load->view("quotations/print", $data);
    }

    // Quotation History
    public function history($pk_id = '')
    {
        $data = [];
        $this->header_data['title'] = 'Quotation History';
        $search_data = array();
        if (!empty($this->_REQ['location_id'])) {
            $search_data['location_id'] = $this->_REQ['location_id'];
        }
        if (!empty($this->_REQ['branch_id'])) {
            $search_data['branch_id'] = $this->_REQ['branch_id'];
        } else {
            $search_data['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
        }
        $search_data['quotation_id'] = $pk_id;
        $this->load->library('Pagenavi');
        $this->pagenavi->search_data = $search_data;
        $this->pagenavi->per_page = 20;
        $this->pagenavi->base_url = base_url() . '/admin/quotations/history/?';
        $this->pagenavi->process($this->quotation, 'searchQuotationHistories');
        $data['PAGING'] = $this->pagenavi->links_html;
        $data['quotations'] = $this->pagenavi->items;
        $this->_template("quotations/history", $data);
    }
    public function view_history($pk_id = '')
    {
        $data = [];
        $this->header_data['title'] = 'View Quotation History';
        $quotation = $this->quotation->getQuotationHistoryById($pk_id);
        if (!empty($quotation)) {
            $quotation['quotation_items'] = $this->quotation->getQuotationHistoryJobs(["history_id" => $quotation['pk_id']]);
        }
        $data['branch'] = $this->inward->getBranchById($quotation['branch_id']);
        $data['customer'] = $this->customer->getCustomerDetails(['pk_id' => $quotation['customer_id']]);
        $data['quotation'] = $quotation;
        $this->_template("quotations/view-history", $data);
    }
    public function history_print($pk_id = '')
    {
        $data = [];
        $this->header_data['title'] = 'View Quotation History';
        $quotation = $this->quotation->getQuotationHistoryById($pk_id);
        if (!empty($quotation)) {
            $quotation['quotation_items'] = $this->quotation->getQuotationHistoryJobs(["history_id" => $quotation['pk_id']]);
        }
        $data['branch'] = $this->inward->getBranchById($quotation['branch_id']);
        $data['customer'] = $this->customer->getCustomerDetails(['pk_id' => $quotation['customer_id']]);
        $data['quotation'] = $quotation;
        $this->load->view("quotations/print", $data);
    }

    public function send_sms()
    {
        if (!empty($this->_REQ)) {
            $pdata = $this->_REQ;
            if ($pdata['type_message'] == 'SMS') {
                if ($pdata['_smsTo'] == '1') {
                    $status = $this->sendSMS($pdata['sms_to_mobile'][0], $pdata['sms_message']);
                } else if ($pdata['_smsTo'] == '2') {
                    $status = $this->sendSMS($pdata['sms_to_mobile'][1], $pdata['sms_message']);
                } else {
                    foreach ($pdata['sms_to_mobile'] as $mobile) {
                        $status = $this->sendSMS($mobile, $pdata['sms_message']);
                    }
                }
                if (!empty($status)) {
                    echo "TRUE";
                }
            } else {
                if ($pdata['_smsTo'] == '1') {
                    $mdata['to'] = $pdata['sms_to_email'][0];
                    $mdata['subject'] = $pdata['subject'];
                    $mdata['body'] = $pdata['sms_message'];
                    $this->sendEmail("", $mdata);
                    echo "TRUE";
                } else if ($pdata['_smsTo'] == '2') {
                    $mdata['to'] = $pdata['sms_to_email'][1];
                    $mdata['subject'] = $pdata['subject'];
                    $mdata['body'] = $pdata['sms_message'];
                    $this->sendEmail("", $mdata);
                    echo "TRUE";
                } else {
                    foreach ($pdata['sms_to_email'] as $email) {
                        $mdata['to'] = $email;
                        $mdata['subject'] = $pdata['subject'];
                        $mdata['body'] = $pdata['sms_message'];
                        $this->sendEmail("", $mdata);
                    }
                    echo "TRUE";
                }
            }
        }
    }
}