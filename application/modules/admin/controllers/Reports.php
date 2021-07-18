<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reports extends MY_Controller
{
    public $header_data = array();
    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["ADMIN","SUPER_ADMIN"]);
        $this->load->model("Inward_model", "dbapi", TRUE);
        $this->load->model("Customers_model", "customer", TRUE);
    }
    public function index()
    {
        // For Viewing Spares Requests
        $data = [];
        $search_data = array();
        
        $search_data['branch_id'] = $_SESSION['BRANCH_ID'];
        if (!empty($this->_REQ['from_date'])) {
            $search_data['from_date'] = dateRangeForm2DB($this->_REQ['from_date']);
            $search_data['to_date'] = dateRangeForm2DB($this->_REQ['to_date']);
        } else {
            $search_data['date'] = date('Y-m-d');
        }
        if (!empty($this->_REQ['status'])) {
            $search_data['status'] = $this->_REQ['status'];
        }
        if (!empty($this->_REQ['location_id'])) {
            $search_data['location_id'] = $this->_REQ['location_id'];
        }
        if (!empty($this->_REQ['branch_id'])) {
            $search_data['branch_id'] = $this->_REQ['branch_id'];
        }
        $this->load->library('Pagenavi');
        $this->pagenavi->search_data = $search_data;
        $this->pagenavi->per_page = 100;
        $this->pagenavi->base_url = base_url() . 'admin/reports/?';
        $this->pagenavi->process($this->dbapi, 'searchInwards');
        $data['PAGING'] = $this->pagenavi->links_html;
        $data['inwards'] = $this->pagenavi->items;
        $data['status_list'] = $this->dbapi->getStatusList();

        $data['locations'] = $this->customer->getLocationsList();
        $data['branches_else'] = $this->customer->getBranchesList(!empty($this->_REQ['location_id']) ? $this->_REQ['location_id'] : '');

        /*  $data['total_amount_paid']= */
        $this->_template('reports/index', $data);
    }

    public function export_data(){
        $data = [];
        $search_data = array();        
        $search_data['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '' ;
        if(!empty($search_data['branch_id'])){
            if(!empty($_REQUEST['from_date'])){
                $search_data['from_date'] = dateRangeForm2DB($_REQUEST['from_date']);
                $search_data['to_date'] = dateRangeForm2DB($_REQUEST['to_date']);
            }else{
                $search_data['date'] = date('Y-m-d');
            }
            
            if(!empty($_REQUEST['status'])){
                $search_data['status'] = $_REQUEST['status'];
            }
            if (!empty($_REQUEST['location_id'])) {
                $search_data['location_id'] = $_REQUEST['location_id'];
            }
            if (!empty($_REQUEST['branch_id'])) {
                $search_data['branch_id'] = $_REQUEST['branch_id'];
            }
            $results = $this->dbapi->searchInwards($search_data);
            if(!empty($results)){
                $data['fileName'] = "INWARDS-EXPORT-".date("YmdHi");
                $data['results'] = $results;
                $this->load->view("reports/inwards-export", $data);
            }
            return false;
            
        }
    }

}
