<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends MY_Controller
{
    public $header_data = array();
    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["ADMIN","SUPER_ADMIN","RECEPTIONIST"]);
        $this->load->model("Products_model", "dbapi", TRUE);
    }
    public function index()
    {
        // For Viewing Products List , Delete, Status
        $data = [];
        if (!empty($_GET['act']) && $_GET['act'] == "status" && !empty($_GET['pk_id']) && isset($_GET['sta'])) {
            $is_active = (!empty($_GET['sta']) && $_GET['sta'] == "1") ? "1" : "0";
            $this->dbapi->updateProduct(array("is_active" => $is_active), $_GET['pk_id']);
            redirect(base_url() . "admin/products/");
        }
        $this->header_data['title'] = 'Products';
        $data['products'] = $this->dbapi->searchProducts();
        $this->_template('products/index', $data);
    }
    public function add()
    {
        $this->header_data['title'] = 'Add Product';
        $data = [];
        $data['companies'] = $this->dbapi->getProductCompaniesList();
        if (!empty($_POST['product_name'])) {
            $pData = [];
            $company_name = !empty($_POST['company_name']) ? trim($_POST['company_name']) : '';
            $branch_id = !empty($_POST['branch_id']) ? $_POST['branch_id'] : $_SESSION['BRANCH_ID'];
            $company = $this->dbapi->getCompanyDetails(['company_name' => $company_name, 'branch_id' => $branch_id]);
            if (!empty($company)) {
                $company_id = $company['pk_id'];
            } else {
                $company_id = $this->dbapi->addProductCompany(['company_name' => $company_name, 'branch_id' => $branch_id, 'created_by' => $_SESSION['USER_ID']]);
            }
            $pData['company_id'] = $company_id;
            $pData['category_id'] = !empty($_POST['category_id']) ? trim($_POST['category_id']) : 0;
            $pData['product_name'] = !empty($_POST['product_name']) ? trim($_POST['product_name']) : '';
            $pData['model_no'] = !empty($_POST['model_no']) ? trim($_POST['model_no']) : '';
            $pData['serial_no'] = !empty($_POST['serial_no']) ? trim($_POST['serial_no']) : '';
            $pData['description'] = !empty($_POST['description']) ? trim($_POST['description']) : '';
            $pData['price'] = !empty($_POST['price']) ? trim($_POST['price']) : '0.00';
            $pData['product_condition'] = !empty($_POST['product_condition']) ? trim($_POST['product_condition']) : '';
            $pData['shipping'] = !empty($_POST['shipping']) ? trim($_POST['shipping']) : '';
            $pData['delivery_estimation'] = !empty($_POST['delivery_estimation']) ? trim($_POST['delivery_estimation']) : '';
            $pData['returns'] = !empty($_POST['returns']) ? trim($_POST['returns']) : '';
            $pData['warranty'] = !empty($_POST['warranty']) ? trim($_POST['warranty']) : '';
            $pData['branch_id'] = $branch_id;
            if (!$this->dbapi->checkProductExists($pData['serial_no'])) {
                $product_id = $this->dbapi->addProduct($pData);
                if ($product_id) {
                    
                    if (!empty($_FILES['photo'])) {
                        $img_path = '/data/products/' . $product_id . '/';
                        createFolder($img_path);
                        uploadThumbFiles($img_path, 'photo', 200);
                        $this->dbapi->updateProduct(["img_path" => $img_path], $product_id);
                    }
                    
                    $_SESSION['message'] = "Product Added Successfully";
                    redirect(base_url() . 'admin/products/');
                }
            } else {
                $_SESSION['error'] = 'This Product Serial No already exists';
                $data['product'] = $_POST;
            }
        }
        $data['categories']=$this->dbapi->getProductCategroyByList();
        $this->_template('products/form', $data);
    }
    function check_product()
    {
        if (!$this->dbapi->checkProductExists($this->_REQ['serial_no'])) {
            echo "true";
            exit;
        }
        echo "false";
        exit;
    }
    public function edit($pk_id)
    {
        $data = [];
        $this->header_data['title'] = 'Edit Product';
        if (!empty($_POST['pk_id'])) {
            $company_name = !empty($_POST['company_name']) ? trim($_POST['company_name']) : '';
            $branch_id = !empty($_POST['branch_id']) ? $_POST['branch_id'] : $_SESSION['BRANCH_ID'];
            $company = $this->dbapi->getCompanyDetails(['company_name' => $company_name, 'branch_id' => $branch_id]);
            if (!empty($company)) {
                $company_id = $company['pk_id'];
            } else {
                $company_id = $this->dbapi->addProductCompany(['company_name' => $company_name, 'branch_id' => $branch_id]);
            }
            $pData['company_id'] = $company_id;
            $pData['category_id'] = !empty($_POST['category_id']) ? trim($_POST['category_id']) : 0;
            $pData['product_name'] = !empty($_POST['product_name']) ? trim($_POST['product_name']) : '';
            $pData['model_no'] = !empty($_POST['model_no']) ? trim($_POST['model_no']) : '';
            $pData['serial_no'] = !empty($_POST['serial_no']) ? trim($_POST['serial_no']) : '';
            $pData['description'] = !empty($_POST['description']) ? trim($_POST['description']) : '';
            $pData['price'] = !empty($_POST['price']) ? trim($_POST['price']) : '0.00';
            $pData['product_condition'] = !empty($_POST['product_condition']) ? trim($_POST['product_condition']) : '';
            $pData['shipping'] = !empty($_POST['shipping']) ? trim($_POST['shipping']) : '';
            $pData['delivery_estimation'] = !empty($_POST['delivery_estimation']) ? trim($_POST['delivery_estimation']) : '';
            $pData['returns'] = !empty($_POST['returns']) ? trim($_POST['returns']) : '';
            $pData['warranty'] = !empty($_POST['warranty']) ? trim($_POST['warranty']) : '';
            if (isset($_POST['add']) && $_POST['add'] == 'add') {
                $pData['is_sold'] = 'NO';
            }
            $update = $this->dbapi->updateProduct($pData, $_POST['pk_id']);
            if ($update) {                
                if (!empty($_FILES['photo'])) {
                    $img_path = '/data/products/' . $_POST['pk_id'] . '/';
                    createFolder($img_path);
                    uploadThumbFiles($img_path, 'photo', 200);
                    $this->dbapi->updateProduct(["img_path" => $img_path], $_POST['pk_id']);
                }                
                $_SESSION['message'] = "Product updated Successfully";
                redirect(base_url() . 'admin/products/');
            } else {
                $_SESSION['error'] = "Failed to update Product";
                $data['product'] = $_POST;
            }
        }
        $data['product'] = $this->dbapi->getProductById($pk_id);
        $data['categories']=$this->dbapi->getProductCategroyByList();
        $this->_template('products/form', $data);
    }
    public function view($str = '')
    {
        if (!empty($str)) {
            $data = [];
            $product = $this->dbapi->getProductById($str);
            $history = $this->dbapi->getProductHistoryById($str);
            if (!empty($history)) {
                $product['history'] = $history;
            }
            $data['product'] = $product;
            $this->header_data['title'] = $data['product']['product_name'];
            $this->_template('products/view', $data);
        }
    }
    public function getProductCompaniesList()
    {
        $companies = $this->dbapi->getProductCompaniesList();
        echo json_encode($companies);
    }
    public function getProductsList()
    {
        if (!empty($this->_REQ['company_name'])) {
            $name = $this->_REQ['company_name'];
            $company = $this->dbapi->getCompanyDetails(['company_name' => $name]);
            if (!empty($company)) {
                $products = $this->dbapi->getProductsList(['company_id' => $company['pk_id']]);
                echo json_encode($products);
            }
        }
        return false;
    }
    function updateProductStatus()
    {
        if (!empty($this->_REQ['product_id'])) {
            $pdata = [];
            $product_id = $this->_REQ['product_id'];
            $pdata['product_id'] = $product_id;
            $pdata['remarks'] = !empty($this->_REQ['remarks']) ? $this->_REQ['remarks'] : '';
            $last_id = $this->dbapi->addProductTrack($pdata);
            if (!empty($last_id)) {
                $this->dbapi->updateProduct(['is_sold' => 'YES'], $product_id);
            }
            echo 'Success';
        } else {
            echo "Invalid Request !";
        }
    }
    public function import()
    {
        $data = array();
        $this->header_data['title'] = 'Import Products';
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
            $exist = array();
            while (!feof($csv_file)) {
                $row = fgetcsv($csv_file);
                if (!empty($row[0])) {
                    $pData = [];
                    $branch_id = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '0';
                    $location_id = !empty($_SESSION['LOCATION_ID']) ? $_SESSION['LOCATION_ID'] : '0';
                    $company_name = !empty($row[0]) ? $row[0] : "";
                    $company = $this->dbapi->getCompanyDetails(['company_name' => $company_name]);// , 'branch_id' => $branch_id-14-05-2018-Removed @14/05/2018
                    if (!empty($company)) {
                        $company_id = $company['pk_id'];
                    } else {
                        $company_id = $this->dbapi->addProductCompany(['company_name' => $company_name, 'branch_id' => $branch_id, 'created_by' => $_SESSION['USER_ID']]);
                    }
                    $pData['company_id'] = $company_id;
                    $pData['product_name'] = !empty($row[1]) ? $row[1] : "";
                    $pData['model_no'] = !empty($row[2]) ? $row[2] : "";
                    $pData['serial_no'] = !empty($row[3]) ? $row[3] : "";
                    $pData['description'] = !empty($row[4]) ? $row[4] : "";
                    $pData['price'] = !empty($row[5]) ? $row[5] : "0.00";
                    $pData['is_sold'] = !empty($row[6]) ? $row[6] : "NO";
                    $pData['branch_id'] = $branch_id;
                    $pData['created_by'] = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '0';
                    $error_nos = 'Error is at ';
                    if (!$this->dbapi->checkProductExists($pData['serial_no'])) {
                        $this->dbapi->addProduct($pData);
                    } else {
                        $existbranch=$this->dbapi->getBranchById($branch_id);                        
                        $error_nos .= $row[3] .",";                         
                        $_SESSION['error'] = $error_nos; 
                    }
                }
            }
            fclose($csv_file);
            unlink($csv_file_path);
            $_SESSION['message'] = 'Data Imported successfully';
            redirect(base_url() . 'admin/products/');
        }
        $this->_template('products/import', $data);
    }
    public function sample_csv()
    {
        $csv_data = array();
        $csv_header = array("Company Name", "Product Name", "Model Number", "Serial Number", "Description", "Price", "Is Sold (YES/NO)");
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=sample.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, $csv_header);
        foreach ($csv_data as $csv_row) {
            fputcsv($output, $csv_row);
        }
    }
    public function category($act='',$str='')
    {
        $data=array();
        if($act=='add'){
            if(!empty($_POST['category_name'])){
                $pdata=array();
                $pdata['category_name']=!empty($_POST['category_name']) ? $_POST['category_name']:'';
                $pdata['product_category_description']=!empty($_POST['product_category_description']) ? $_POST['product_category_description']:'';
                $pdata['created_by']=!empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] :'';
                $pdata['branch_id']=!empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] :'';
                $pdata['location_id']=!empty($_SESSION['LOCATION_ID']) ? $_SESSION['LOCATION_ID'] :'';
                $last_id=$this->dbapi->addProductCategory($pdata);
                if($last_id){
                    redirect(get_role_based_link().'/products/category');
                }
            }
            $this->_template('products/product-category-add',$data);
        }else if($act=='edit'){
            if(!empty($_POST['category_id'])){
                $pdata=array();
                $categroy_id=$_POST['category_id'];
                $pdata['category_name']=!empty($_POST['category_name']) ? $_POST['category_name']:'';
                $pdata['product_category_description']=!empty($_POST['product_category_description']) ? $_POST['product_category_description']:'';
                $pdata['created_by']=!empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] :'';
                $this->dbapi->updateProductCategory($pdata,$categroy_id);
                redirect(get_role_based_link().'/products/category');
            }
            $data['category']=$this->dbapi->getProductCategroyById($str);
            $this->_template('products/product-category-add',$data);
        } else{
            $data['product_categories']=$this->dbapi->searchProductCategroies();
            $this->_template('products/product-categories',$data);
        }
    }

    public function export(){
        $data = [];
        $search_data = array();        
        $search_data['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '' ;
        $results = $this->dbapi->searchProducts();
        // echo "<pre>";
        // print_r($results);
        // exit;
        if(!empty($results)){
            $data['fileName'] = "PRODUCTS-EXPORT-".date("YmdHis");
            $data['results'] = $results;
            $this->load->view("products/export", $data);
        }
        return false;
    }
}