<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Components extends MY_Controller
{
    public $header_data = array();
    function __construct()
    {
        parent::__construct();
        $this->load->model("Component_model", "dbapi", TRUE);
        $this->load->model("Spare_model", "spare", TRUE);
    }
    public function index()
    {
        $data = [];
        $s = [];
        $s['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
        $s['location_id'] = !empty($_SESSION['LOCATION_ID']) ? $_SESSION['LOCATION_ID'] : '';
        $data['components'] = $this->dbapi->searchComponents($s);
        $data['alertCnt'] = $this->dbapi->searchComponents(['alert' => true,'branch_id'=>$_SESSION['BRANCH_ID'],'location_id'=>$_SESSION['LOCATION_ID']], $mode = "CNT");
        $data['required'] = $this->spare->searchRequiredComponents(['branch_id'=>$_SESSION['BRANCH_ID'],'location_id'=>$_SESSION['LOCATION_ID']], $mode = "CNT");
        $this->_template('components/index', $data);
    }
    function alert_components()
    {
        $data = [];
        $data['components'] = $this->dbapi->searchComponents(['alert' => true,'branch_id'=>$_SESSION['BRANCH_ID'],'location_id'=>$_SESSION['LOCATION_ID']]);
        $this->_template('components/index', $data);
    }
    function required_components($act = '', $str = '')
    {
        $data = [];
        if ((isset($_GET['act']) && $_GET['act'] == 'del') && (isset($_GET['pk_id']) && !empty($_GET['pk_id']))) {
            $this->spare->delRequiredComponent($_GET['pk_id']);
            $_SESSION['message'] = "Component is removed Successfully !";
            redirect(base_url() . 'admin/components/required-components/');
        }
        $data['components'] = $this->spare->searchRequiredComponents();
        $this->_template('components/required', $data);
    }
    public function add()
    {
        $data = [];
        $data['companies'] = $this->dbapi->getComponentCompaniesList();
        if (!empty($_POST['component_name'])) {
            $pData = [];
            $company_name = !empty($_POST['company_name']) ? trim($_POST['company_name']) : '';
            $branch_id = !empty($_POST['branch_id']) ? $_POST['branch_id'] : $_SESSION['BRANCH_ID'];
            $location_id = !empty($_POST['location_id']) ? $_POST['locationid'] : $_SESSION['LOCATION_ID'];
            $company = $this->dbapi->getCompanyDetails(['company_name' => $company_name, 'branch_id' => $branch_id]);
            if (!empty($company)) {
                $company_id = $company['pk_id'];
            } else {
                $company_id = $this->dbapi->addComponentCompany(['company_name' => $company_name, 'branch_id' => $branch_id]);
            }
            $pData['company_id'] = $company_id;
            $pData['component_name'] = !empty($_POST['component_name']) ? trim($_POST['component_name']) : '';
            $pData['model_no'] = !empty($_POST['model_no']) ? trim($_POST['model_no']) : '';
            $pData['quantity'] = !empty($_POST['quantity']) ? trim($_POST['quantity']) : '0';
            $pData['alert_quantity'] = !empty($_POST['alert_quantity']) ? trim($_POST['alert_quantity']) : '0';
            $pData['description'] = !empty($_POST['description']) ? trim($_POST['description']) : '';
            $pData['location'] = !empty($_POST['location']) ? trim($_POST['location']) : '';
            $pData['branch_id'] = $branch_id;
            $pData['location_id'] = $location_id;
            $component = $this->dbapi->getComponentDetails(['company_id' => $company_id, 'component_name' => $pData['component_name'], 'model_no' => $pData['model_no'], 'branch_id' => $branch_id,'location_id' => $location_id]);
            if (!empty($component)) {
                $component_id = $component['pk_id'];
                $description = !empty($_POST['description']) ? trim($_POST['description']) : $component['description'];
                $alert_qty = !empty($_POST['alert_quantity']) ? trim($_POST['alert_quantity']) : $component['alert_quantity'];
                $this->dbapi->updateComponent(['description' => $description, 'alert_quantity' => $alert_qty], $component_id);
            } else {
                $component_id = $this->dbapi->addComponent($pData);
            }
            if ($component_id) {
                $sData = [];
                $sData['component_id'] = $component_id;
                $sData['quantity'] = $pData['quantity'];
                $sData['branch_id'] = $branch_id;
                $sData['location_id'] = $location_id;
                $sData['type'] = "ADD";
                $this->dbapi->addComponentStock($sData);
                $qty = $this->dbapi->getComponentQuantity(['branch_id' => $branch_id, 'component_id' => $component_id]);
                $quantity = $qty['add_qty'] + $qty['sub_qty'] - $qty['inward_qty'];
                $this->dbapi->updateComponent(['quantity' => $quantity], $component_id);
                $img_path = '/data/components/';
                if (!empty($_FILES['photo']) && ($_FILES['photo']['size'] > 0)) {
                    $img = uploadImage('photo', $img_path, 'component' . $component_id, 200);
                    $this->dbapi->updateComponent(["img" => $img], $component_id);
                }
                $_SESSION['message'] = "Component Added Successfully";
                redirect(base_url() . 'admin/components/');
            } else {
                $_SESSION['error'] = "Failed to add Component";
                $data['component'] = $_POST;
            }
        }
        $this->_template('components/form', $data);
    }
    public function edit($pk_id)
    {
        $data = [];
        if (!empty($_POST['pk_id'])) {
            $pData = [];
            $company_name = !empty($_POST['company_name']) ? trim($_POST['company_name']) : '';
            $branch_id = !empty($_POST['branch_id']) ? $_POST['branch_id'] : $_SESSION['BRANCH_ID'];
            $location_id = !empty($_POST['location_id']) ? $_POST['blocationid'] : $_SESSION['LOCATION_ID'];
            $company = $this->dbapi->getCompanyDetails(['company_name' => $company_name, 'branch_id' => $branch_id,'location_id'=>$location_id]);
            if (!empty($company)) {
                $company_id = $company['pk_id'];
            } else {
                $company_id = $this->dbapi->addComponentCompany(['company_name' => $company_name, 'branch_id' => $branch_id,'location_id'=>$location_id]);
            }
            $pData['company_id'] = $company_id;
            $pData['component_name'] = !empty($_POST['component_name']) ? trim($_POST['component_name']) : '';
            $pData['model_no'] = !empty($_POST['model_no']) ? trim($_POST['model_no']) : '';
            $pData['alert_quantity'] = !empty($_POST['alert_quantity']) ? trim($_POST['alert_quantity']) : '0';
            $pData['description'] = !empty($_POST['description']) ? trim($_POST['description']) : '';
            $pData['location'] = !empty($_POST['location']) ? trim($_POST['location']) : '';
            $pData['branch_id'] = $branch_id;
            $pData['location_id'] = $location_id;
            $this->dbapi->updateComponent($pData, $_POST['pk_id']);
            if ($_POST['pk_id']) {
                $sData = [];
                $component_id = $_POST['pk_id'];
                $sData['component_id'] = $component_id;
                $sData['quantity'] = $_POST['quantity'];
                $sData['branch_id'] = $branch_id;
                $sData['type'] = "UPDATE";
                if (!empty($sData['quantity'])) {
                    $this->dbapi->addComponentStock($sData);
                }
                $qty = $this->dbapi->getComponentQuantity(['branch_id' => $branch_id, 'component_id' => $component_id]);
                $quantity = $qty['add_qty'] + $qty['sub_qty'] - $qty['inward_qty'];
                $this->dbapi->updateComponent(['quantity' => $quantity], $component_id);
                $img_path = '/data/components/';
                if (!empty($_FILES['photo']) && ($_FILES['photo']['size'] > 0)) {
                    $img = uploadImage('photo', $img_path, 'component' . $component_id, 200);
                    $this->dbapi->updateComponent(["img" => $img], $component_id);
                }
                $_SESSION['message'] = "Component updated Successfully";
                redirect(base_url() . 'admin/components/');
            } else {
                $_SESSION['error'] = "Failed to update Component";
                $data['component'] = $_POST;
            }
        }
        $data['component'] = $this->dbapi->getComponentById($pk_id);
        $data['companies'] = $this->dbapi->getComponentCompaniesList();
        $this->_template('components/form', $data);
    }
    public function history()
    {
        $this->header_data['title'] = "Component History";
        $data = [];
        $data['companies'] = $this->dbapi->getComponentCompaniesList();
        $s = [];
        if (!empty($this->_REQ['company_id'])) {
            $s['company_id'] = !empty($this->_REQ['company_id']) ? $this->_REQ['company_id'] : '';
            $data['components'] = $this->dbapi->getComponentsList($s);
        }
        if (!empty($this->_REQ['component'])) {
            $s['component_id'] = !empty($this->_REQ['component']) ? $this->_REQ['component'] : '';
            $s['company_id'] = !empty($this->_REQ['company_id']) ? $this->_REQ['company_id'] : '';
        }
        $data['history'] = $this->dbapi->getComponentHistory($s);
        $this->_template('components/history', $data);
    }
    public function getComponentCompaniesList()
    {
        $companies = $this->dbapi->getComponentCompaniesList();
        echo json_encode($companies);
    }
    public function getComponentsList()
    {
        if (!empty($this->_REQ['company_name'])) {
            $name = $this->_REQ['company_name'];
            $company = $this->dbapi->getCompanyDetails(['company_name' => $name]);
            if (!empty($company)) {
                $components = $this->dbapi->getComponentsList(['company_id' => $company['pk_id']]);
                echo json_encode($components);
            }
            return false;
        }
        if (!empty($this->_REQ['company_id'])) {
            $company_id = $this->_REQ['company_id'];
            if (!empty($company_id)) {
                $components = $this->dbapi->getComponentsList(['company_id' => $company_id]);
                echo json_encode($components);
            }
            return false;
        }
    }
    public function getComponentModelsList()
    {
        if (!empty($this->_REQ['component_name']) && !empty($this->_REQ['branch'])) {
            $name = $this->_REQ['company_name'];
            $component = $this->_REQ['component_name'];
            $company = $this->dbapi->getCompanyDetails(['company_name' => $name]);
            if (!empty($company)) {
                $components = $this->dbapi->getComponentModelsList(['company_id' => $company['pk_id'], 'component_name' => $component]);
                echo json_encode($components);
                return false;
            }
        }
    }
    public function getComponentDetails()
    {
        $name = $this->_REQ['company_name'];
        $component = $this->_REQ['component_name'];
        $model = $this->_REQ['model_no'];
        $company = $this->dbapi->getCompanyDetails(['company_name' => $name]);
        if (!empty($company)) {
            $branch = $this->_REQ['branch'];
            $data = [];
            $data['component_name'] = $component;
            $data['model_no'] = $model;
            $data['branch_id'] = $branch;
            $data['location_id'] = !empty($_SESSION['LOCATION_ID']) ?$_SESSION['LOCATION_ID']:'' ;
            $data['company_id'] = $company['pk_id'];
            $components = $this->dbapi->getComponentDetails($data);
            echo json_encode($components);
            return false;
        }
    }
    public function import()
    {
        $data = array();
        $this->header_data['title'] = 'Import Components';
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
            while (!feof($csv_file)) {
                $row = fgetcsv($csv_file);
                if (!empty($row[0])) {
                    $pData = [];
                    $pData['created_by'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
                    $branch_id = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
                    $location_id = !empty($_SESSION['LOCATION_ID']) ? $_SESSION['LOCATION_ID'] : '';
                    $company_name = !empty($row[0]) ? $row[0] : "";
                    $company = $this->dbapi->getCompanyDetails(['company_name' => $company_name, 'branch_id' => $branch_id]);
                    if (!empty($company)) {
                        $company_id = $company['pk_id'];
                    } else {
                        $company_id = $this->dbapi->addComponentCompany(['company_name' => $company_name, 'branch_id' => $branch_id]);
                    }
                    $pData['company_id'] = $company_id;
                    $pData['component_name'] = !empty($row[1]) ? $row[1] : "";
                    $pData['model_no'] = !empty($row[2]) ? $row[2] : "";
                    $pData['description'] = !empty($row[3]) ? $row[3] : "";
                    $pData['quantity'] = !empty($row[4]) ? $row[4] : "0";
                    $pData['alert_quantity'] = !empty($row[5]) ? $row[5] : "0";
                    $pData['location'] = !empty($row[6]) ? $row[6] : "";
                    $pData['branch_id'] = $branch_id;
                    $pData['location_id'] = $location_id;
                    $component = $this->dbapi->getComponentDetails(['company_id' => $company_id,
                        'component_name' => $pData['component_name'],
                        'model_no' => $pData['model_no'],
                        'branch_id' => $location_id]);
                    if (!empty($component)) {
                        $component_id = $component['pk_id'];
                        $description = !empty($pData['description']) ? trim($pData['description']) : $component['description'];
                        $alert_qty = !empty($pData['alert_quantity']) ? trim($pData['alert_quantity']) : $component['alert_quantity'];
                        $this->dbapi->updateComponent(['description' => $description, 'alert_quantity' => $alert_qty], $component_id);
                    } else {
                        $component_id = $this->dbapi->addComponent($pData);
                    }
                    if ($component_id) {
                        $sData = [];
                        $sData['component_id'] = $component_id;
                        $sData['quantity'] = $pData['quantity'];
                        $sData['branch_id'] = $branch_id;
                        $sData['location_id'] = $location_id;
                        $sData['type'] = "ADD";
                        $this->dbapi->addComponentStock($sData);
                        $qty = $this->dbapi->getComponentQuantity(['branch_id' => $branch_id, 'component_id' => $component_id]);
                        $quantity = $qty['add_qty'] + $qty['sub_qty'] - $qty['inward_qty'];
                        $this->dbapi->updateComponent(['quantity' => $quantity], $component_id);
                    } else {
                        $_SESSION['error'] = 'Failed to add Data';
                    }
                }
            }
            fclose($csv_file);
            unlink($csv_file_path);
            $_SESSION['message'] = 'Data Imported successfully';
            redirect(base_url() . 'admin/components/');
        }
        $this->_template('components/import', $data);
    }
    public function sample_csv()
    {
        $csv_data = array();
        $csv_header = array("Component Name", "Component Type", "Model Number", "Description", "Quantity", "Alert Quantity","Location");
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=sample.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, $csv_header);
        foreach ($csv_data as $csv_row) {
            fputcsv($output, $csv_row);
        }
    }
}
