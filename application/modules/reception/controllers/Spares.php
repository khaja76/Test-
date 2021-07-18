<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spares extends MY_Controller
{
    public $header_data = array();

    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["SUPER_ADMIN", "ADMIN","RECEPTIONIST"]);
        $this->load->model("admin/Inward_model","inward",TRUE);
        $this->load->model("admin/Spare_model", "spare", TRUE);
        $this->load->model("admin/Component_model", "component", TRUE);
        $this->load->model("Notification_model", "notification", TRUE);
    }


    public function index()
    {
        $this->header_data['title'] = " Spare Requests ";
        $data = array();
        $data['status_list'] = $this->inward->getStatusList();
        $search_data = [];
        $search_data['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
        $search_data['location_id'] = !empty($_SESSION['LOCATION_ID']) ? $_SESSION['LOCATION_ID'] : '';
        if (!empty($this->_REQ['from_date'])) {
            $search_data['from_date'] = dateRangeForm2DB($this->_REQ['from_date']);
            $search_data['to_date'] = dateRangeForm2DB($this->_REQ['to_date']);
        } else if (!isset($_GET['type'])) {
            $search_data['date'] = date('Y-m-d');
        }
        $search_data['is_outwarded'] = 'NO';
        $inwards = $this->spare->searchSpareRequests($search_data);
        $data['inwards'] = $inwards;
        $this->_template('admin/spares/index', $data);
    }

    public function view($pk_id = '')
    {
        $data = [];
        if (!empty($_GET['act']) && $_GET['act'] == "status" && !empty($_GET['pk_id']) && isset($_GET['pk_id'])) {
            $is_received = "REJECTED";
            $this->spare->updateSpareRequest(['request_status' => $is_received], $_GET['pk_id']);
            redirect(get_role_based_link().'/spares/');
        }
        if (!empty($pk_id)) {

            $inward = $this->spare->getSpareRequestById($pk_id);
            $data['inward'] = $inward;
            $data['history'] = $this->spare->getSpareRequestHistory(['spare_id' => $pk_id]);
        }
        if (!empty($this->_REQ['type']) && (!empty($this->_REQ['name']))) {
            $type = $this->_REQ['type'];
            $name = $this->_REQ['name'];
            $component = '';
            if ($type == "company") {
                $company = $this->component->getCompanyDetails(['company_name' => $name, 'branch_id' => $_SESSION['BRANCH_ID']]);
                if (!empty($company)) {
                    $component = $this->component->searchComponents(['company_id' => $company['pk_id'], "spare" => true, 'branch_id' => $_SESSION['BRANCH_ID'], 'location_id' => $_SESSION['LOCATION_ID']]);
                }
            } elseif ($type == "component") {
                $component = $this->component->searchComponents(['component_name' => $name, "spare" => true, 'branch_id' => $_SESSION['BRANCH_ID'], 'location_id' => $_SESSION['LOCATION_ID']]);
            } elseif ($type == "description") {
                $component = $this->component->searchComponents(['description' => $name, "spare" => true, 'branch_id' => $_SESSION['BRANCH_ID'], 'location_id' => $_SESSION['LOCATION_ID']]);
            } else {
                $component = $this->component->searchComponents(['model_no' => $name, "spare" => true, 'branch_id' => $_SESSION['BRANCH_ID'], 'location_id' => $_SESSION['LOCATION_ID']]);
            }
            $data['components'] = $component;
            if (isset($_POST['submit'])) {
                $branch_id = !empty($_POST['branch_id']) ? $_POST['branch_id'] : $_SESSION['BRANCH_ID'];
                $location_id = !empty($_POST['location_id']) ? $_POST['location_id'] : $_SESSION['LOCATION_ID'];
                $created_by = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                $spare_id = !empty($_POST['spare_request_id']) ? trim($_POST['spare_request_id']) : '';
                $component_id = !empty($_POST['component_id']) ? trim($_POST['component_id']) : '';
                $component_name = !empty($_POST['component_name']) ? trim($_POST['component_name']) : '';
                if (!empty($component_name)) {
                    // Save in Required Component Section
                    $rData['spare_id'] = $spare_id;
                    $rData['component_name'] = $component_name;
                    $rData['branch_id'] = $branch_id;
                    $rData['location_id'] = $location_id;
                    $rData['created_by'] = $created_by;
                    $this->spare->addRequiredComponent($rData);
                    $_SESSION['message'] = "Component added in Required Section";
                    redirect(get_role_based_link().'/spares/');
                } else {

                    if (!empty($_POST['spare_quantity'])) {
                        $sData['inward_id'] = !empty($_POST['inward_id']) ? trim($_POST['inward_id']) : '';
                        $sData['inward_no'] = !empty($_POST['inward_no']) ? trim($_POST['inward_no']) : '';
                        $sData['quantity'] = !empty($_POST['spare_quantity']) ? trim($_POST['spare_quantity']) : '';
                        $sData['spare_id'] = $spare_id;
                        $sData['type'] = "SPARE";
                        $sData['component_id'] = $component_id;
                        $sData['branch_id'] = $branch_id;
                        $sData['location_id'] = $location_id;
                        $this->component->addComponentStock($sData);
                        $qty = $this->component->getComponentQuantity(['branch_id' => $branch_id, 'component_id' => $component_id]);
                        $quantity = $qty['add_qty'] + $qty['sub_qty'] - $qty['inward_qty'];
                        $this->component->updateComponent(['quantity' => $quantity], $component_id);
                        $rData = [];
                        $rData['supplied_component_id'] = $component_id;
                        $rData['request_status'] ="GRANTED";
                        $rData['supplied_quantity'] = !empty($_POST['spare_quantity']) ? $inward['supplied_quantity'] + $_POST['spare_quantity'] : '';
                        $rData['updated_by'] = $created_by;
                        $rData['updated_on'] = date('Y-m-d H:i:s');
                        $this->spare->updateSpareRequest($rData, $spare_id);
                        redirect(get_role_based_link().'/spares/');
                    }
                }
            }
        }
        $this->_template('spares/view', $data);
    }
}