<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Import extends MY_Controller
{
    public $header_data = array();
    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["SUPER_ADMIN", "ADMIN"]);
        $this->load->model("Import_model", "dbapi", TRUE);
    }
    public function inwards()
    {
        $data = array();
        $this->header_data['title'] = 'Import Inwards';
        $search_data=array();
        if (!empty($this->_REQ['from_date'])) {
            $search_data['from_date'] = dateRangeForm2DB($this->_REQ['from_date']);
            $search_data['to_date'] = dateRangeForm2DB($this->_REQ['to_date']);
        } else if ((empty($this->_REQ['location_id']) || (empty($this->_REQ['branch_id']))) && !isset($_GET['type'])) {
            $search_data['date'] = date('Y-m-d');
        }
        if (!empty($this->_REQ['status'])) {
            $search_data['status'] =str_replace('-',' ',$this->_REQ['status']);
        }
        $data['inwards'] = $this->dbapi->searchImportedInwards($search_data);
        $this->_template('import/inwards', $data);
    }
    public function edit_inward($pk_id = '')
    {
        $data = array();
        $this->header_data['title'] = 'Edit Imported Inward';
        if (!empty($_POST['pk_id'])) {
            $pdata = array();
            $pdata['job_id'] = !empty($_POST['job_id']) ? $_POST['job_id'] : '';
            //$pdata['job_no'] = !empty($_POST['job_no']) ? $_POST['job_no'] : '';
            $pdata['created_on'] = !empty($_POST['created_on']) ? dateForm2DB($_POST['created_on']) : '';
            $pdata['status'] = !empty($_POST['status']) ? $_POST['status'] : '';
            $pdata['mobile'] = !empty($_POST['mobile']) ? $_POST['mobile'] : '';
            $pdata['gatepass'] = !empty($_POST['gatepass']) ? $_POST['gatepass'] : '';
            $pdata['delivery_details'] = !empty($_POST['delivery_details']) ? $_POST['delivery_details'] : '';
            $pdata['description'] = !empty($_POST['description']) ? $_POST['description'] : '';
            $pdata['estimation'] = !empty($_POST['estimation']) ? $_POST['estimation'] : 0;
            $pdata['payment'] = !empty($_POST['payment']) ? $_POST['payment'] : '';
            $pdata['cheque_no'] = !empty($_POST['cheque_no']) ? $_POST['cheque_no'] : '';
            $pdata['problem'] = !empty($_POST['problem']) ? $_POST['problem'] : '';
            $pdata['customer_details'] = !empty($_POST['customer_details']) ? $_POST['customer_details'] : '';
            $this->dbapi->updateImportedInward($pdata, $_POST['pk_id']);
            redirect(base_url() . 'admin/import/inwards');
        }
        $data['inward'] = $this->dbapi->getImportedInwardById($pk_id);
        $this->_template('import/edit-inward', $data);
    }
    public function upload_inwards()
    {
        $data = array();
        $this->header_data['title'] = 'Upload CSV';
        if (!empty($_POST['import'])) {
            $file_name = date("YmdHis");
            $upload_path = FCPATH . '/data/tmp/';
            if (!file_exists($upload_path) || !is_dir($upload_path)) {
                mkdir($upload_path);
            }
            $file_info = pathinfo($_FILES['import_csv']['name']);
            $csv_file_path = $upload_path . $file_name . "." . $file_info['extension'];
            @move_uploaded_file($_FILES["import_csv"]["tmp_name"], $csv_file_path);
            $csv_file = fopen($csv_file_path, "r");
            fgetcsv($csv_file);
            $error_nos = 'Error is at ';
            while (!feof($csv_file)) {
                $row = fgetcsv($csv_file);                
                if (!empty($row[2])) { // If Job ID is not empty                   
                    $pData = [];
                    $branch_id = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
                    $location_id = !empty($_SESSION['LOCATION_ID']) ? $_SESSION['LOCATION_ID'] : '';
                    //$pzData['pk_id'] = !empty($row[0]) ? $row[0] : "";
                    $pData['created_on'] = !empty($row[1]) ? date('Y-m-d', strtotime($row[1])) : "";
                    $pData['job_id'] = !empty($row[2]) ? $row[2] : "";
                    //$pData['job_no'] = !empty($row[3]) ? $row[3] : "";
                    $pData['customer_details'] = !empty($row[3]) ? $row[3] : "";
                    $pData['mobile'] = !empty($row[4]) ? $row[4] : "";
                    $pData['description'] = !empty($row[5]) ? $row[5] : "";
                    $pData['problem'] = !empty($row[6]) ? $row[6] : "";
                    $pData['gatepass'] = !empty($row[7]) ? $row[7] : "";
                    $pData['status'] = !empty($row[8]) ? $row[8] : "P";
                    $pData['estimation'] = !empty($row[9]) ? $row[9] : "0";
                    $pData['delivery_details'] = !empty($row[10]) ? $row[10] : "";
                    $pData['payment'] = !empty($row[11]) ? $row[11] : "";
                    $pData['cheque_no'] = !empty($row[12]) ? $row[12] : "";
                    $pData['branch_id'] = $branch_id;
                    $pData['location_id'] = $location_id;
                    $pData['created_by'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                    $pData['added_date_time'] = date('Y-m-d H:i:s');
                    if(!$this->dbapi->checkJobExist($pData['job_id'])) {
                        $this->dbapi->addImportedInwards($pData);
                    }else{
                        $mybranch = $this->dbapi->getBranchById($branch_id);
                        $error_nos .= $row[2] .",";                         
                        $_SESSION['error'] = $error_nos;                        
                    }
                }
            }
            fclose($csv_file);
            unlink($csv_file_path);
            $_SESSION['message'] = 'Data Imported successfully';
            redirect(base_url() . 'admin/import/inwards');
        }
        $this->_template('import/inwards-upload', $data);
    }
    public function inwards_csv()
    {
        $csv_data = array();
        $csv_header = array("Sr.no","Date","Job Id","Customer Details","Mobile", "Description", "Problem", "Gatepass","Status","Estimation", "Delivery Details","Payment","Cheque No");
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=sample.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, $csv_header);
        // foreach ($csv_data as $csv_row) {
        //     fputcsv($output, $csv_row);
        // }
    }
}