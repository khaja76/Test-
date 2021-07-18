<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends MY_Controller
{
    public $header_data = array();
    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["RECEPTIONIST","ADMIN","SUPER_ADMIN","ENGINEER"]);
        $this->load->model("admin/Products_model", "dbapi", TRUE);
        $this->load->model("Notification_model", "notification", TRUE);
    }
    public function index()
    {
        // For Viewing Products List , Delete, Status
        $data = [];
        $data['products'] = $this->dbapi->searchProducts();
        $this->_template('admin/products/index', $data);
    }
    public function add()
    {
        // For Viewing Products List , Delete, Status
        $data = [];
        $data['companies'] = $this->dbapi->getProductCompaniesList();
        if(!empty($_POST['product_name'])){
            $pData = [];
            $company_name = !empty($_POST['company_name']) ? trim($_POST['company_name']) : '';
            $branch_id = !empty($_POST['branch_id']) ? $_POST['branch_id'] :  $_SESSION['BRANCH_ID'];
            $company = $this->dbapi->getCompanyDetails(['company_name'=> $company_name,'branch_id'=>$branch_id]);
            if(!empty($company)){
                $company_id = $company['pk_id'];
            }else{
                $company_id = $this->dbapi->addProductCompany(['company_name'=>$company_name,'branch_id'=>$branch_id,'created_by'=>$_SESSION['USER_ID']]);
            }
            $pData['company_id'] = $company_id;
            $pData['product_name'] = !empty($_POST['product_name']) ? trim($_POST['product_name']) : '';
            $pData['model_no'] = !empty($_POST['model_no']) ? trim($_POST['model_no']) : '';
            $pData['serial_no'] = !empty($_POST['serial_no']) ? trim($_POST['serial_no']) : '';
            $pData['description'] = !empty($_POST['description']) ? trim($_POST['description']) : '';
            $pData['price'] = !empty($_POST['price']) ? trim($_POST['price']) : '';
            $pData['branch_id'] = $branch_id;
            $product_id = $this->dbapi->addProduct($pData);
            if($product_id){
                $img_path = '/data/products/' . $product_id.'/';
                createFolder($img_path);
                if(!empty($_FILES['photo'])){
                    uploadThumbFiles($img_path,'photo',200);
                }
                $this->dbapi->updateProduct(["img_path" => $img_path], $product_id);
                $_SESSION['message'] = "Product Added Successfully";
                redirect(base_url().'reception/products/');
            }else{
                $_SESSION['error'] = "Failed to add Product";
                $data['product'] = $_POST;
            }
        }
        $this->_template('admin/products/form', $data);
    }
    public function edit($pk_id)
    {
        $data = [];
        if(!empty($_POST['pk_id'])){
            $company_name = !empty($_POST['company_name']) ? trim($_POST['company_name']) : '';
            $branch_id = !empty($_POST['branch_id']) ? $_POST['branch_id'] :  $_SESSION['BRANCH_ID'];
            $company = $this->dbapi->getCompanyDetails(['company_name'=> $company_name,'branch_id'=>$branch_id]);
            if(!empty($company)){
                $company_id = $company['pk_id'];
            }else{
                $company_id = $this->dbapi->addProductCompany(['company_name'=>$company_name,'branch_id'=>$branch_id]);
            }
            $pData['company_id'] = $company_id;
            $pData['product_name'] = !empty($_POST['product_name']) ? trim($_POST['product_name']) : '';
            $pData['model_no'] = !empty($_POST['model_no']) ? trim($_POST['model_no']) : '';
            $pData['serial_no'] = !empty($_POST['serial_no']) ? trim($_POST['serial_no']) : '';
            $pData['description'] = !empty($_POST['description']) ? trim($_POST['description']) : '';
            $pData['price'] = !empty($_POST['price']) ? trim($_POST['price']) : '';
            if(isset($_POST['add']) && $_POST['add']=='add'){
                $pData['is_sold'] = 'NO';
            }
            $update = $this->dbapi->updateProduct($pData,$_POST['pk_id']);
            if($update){
                $img_path = '/data/products/' . $_POST['pk_id'].'/';
                createFolder($img_path);
                if(!empty($_FILES['photo'])){
                    uploadThumbFiles($img_path,'photo',200);
                }
                $this->dbapi->updateProduct(["img_path" => $img_path], $_POST['pk_id']);
                $_SESSION['message'] = "Product updated Successfully";
                redirect(base_url().'reception/products/');
            }else{
                $_SESSION['error'] = "Failed to update Product";
                $data['product'] = $_POST;
            }
        }
        $data['product'] = $this->dbapi->getProductById($pk_id);
        $this->_template('admin/products/form', $data);
    }
    public function view($str=''){
        if(!empty($str))
        {
            $data=[];
            $product = $this->dbapi->getProductById($str);
            $history= $this->dbapi->getProductHistoryById($str);
            if(!empty($history)){
                $product['history']=$history;
            }
            $data['product']=$product;
            $this->header_data['title']=$data['product']['product_name'];
            $this->_template('admin/products/view', $data);
        }
    }
}