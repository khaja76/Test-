<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Locations extends MY_Controller
{
    public $header_data = array();
    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["SUPER_ADMIN", "ADMIN"]);
        $this->load->model("Location_model", "dbapi", TRUE);
    }
    public function index()
    {
        if (!empty($_GET['act']) && $_GET['act'] == "status" && !empty($_GET['pk_id']) && isset($_GET['sta'])) {
            $is_active = (!empty($_GET['sta']) && $_GET['sta'] == "1") ? "1" : "0";
            $this->dbapi->updateLocation(array("is_active" => $is_active), $_GET['pk_id']);
            redirect(base_url() . "admin/locations/");
        }
        $data = array();
        $this->header_data['title'] = "::  Locations ::";
        $search_data = array();
        if (!empty($this->_REQ['key'])) {
            $search_data['key'] = $this->_REQ['key'];
        }
        $this->load->library('Pagenavi');
        $this->pagenavi->search_data = $search_data;
        $this->pagenavi->per_page = 20;
        $this->pagenavi->base_url = base_url() . 'admin/locations/?';
        $this->pagenavi->process($this->dbapi, 'searchLocations');
        $data['PAGING'] = $this->pagenavi->links_html;
        $locations = $this->pagenavi->items;
        if (!empty($locations)) {
            foreach ($locations as &$location) {
                $location['branch_cnt'] = $this->dbapi->getBranchesCntByLocationId($location['pk_id']);
            }
        }
        $data['locations'] = $locations;
        $this->_template('locations/index', $data);
    }
    public function add()
    {
        $data = array();
        $this->header_data['title'] = ":: Add  Locations ::";
        if (!empty($_POST['location_name'])) {
            $pdata = [];
            $location_name = !empty($_POST['location_name']) ? ucfirst($_POST['location_name']) : '';
            $check = $this->dbapi->checkLocation($location_name);
            if (!$check) {
                $pdata['country'] = !empty($_POST['country']) ? trim($_POST['country']) : '';
                $pdata['location_name'] = !empty($location_name) ? trim($location_name) : '';
                $pdata['location_code'] = !empty($_POST['location_code']) ? trim($_POST['location_code']) : '';
                $location_id = $this->dbapi->addLocation($pdata);
                if ($location_id) {
                    $_SESSION['message'] = "New Location Added Successfully";
                    redirect(base_url() . 'admin/locations/');
                } else {
                    $_SESSION['message'] = "Failed to add New Location";
                    $data['location'] = $_POST;
                }
            } else {
                $_SESSION['error'] = "Location with this name already exists";
                $data['location'] = $_POST;
            }
        }
        $this->_template('locations/form', $data);
    }
    public function edit($pk_id = '')
    {
        $data = array();
        $this->header_data['title'] = ":: Edit Locations ::";
        if (!empty($_POST['pk_id'])) {
            $pdata = [];
            $location_name = !empty($_POST['location_name']) ? ucfirst($_POST['location_name']) : '';
            $pk_id = !empty($_POST['pk_id']) ? $_POST['pk_id'] : '';
            $check = $this->dbapi->checkLocation($location_name, $_POST['pk_id']);
            if (!$check) {
                $pdata['country'] = !empty($_POST['country']) ? trim($_POST['country']) : '';
                $pdata['location_name'] = !empty($location_name) ? trim($location_name) : '';
                $pdata['location_code'] = !empty($_POST['location_code']) ? trim($_POST['location_code']) : '';
                $location_id = $this->dbapi->updateLocation($pdata, $pk_id);
                if ($location_id) {
                    $_SESSION['message'] = "Location Updated Successfully";
                    redirect(base_url() . 'admin/locations/');
                } else {
                    $_SESSION['message'] = "Failed to update Location";
                    $data['location'] = $_POST;
                }
            } else {
                $_SESSION['error'] = "Location with this name already exists";
                $data['location'] = $_POST;
            }
        }
        if (!empty($pk_id)) {
            $data['location'] = $this->dbapi->getLocationById($pk_id);
        }
        $this->_template('locations/form', $data);
    }
}