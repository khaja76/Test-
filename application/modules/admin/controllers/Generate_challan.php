<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Generate_challan extends MY_Controller
{
    public $header_data = array();
    function __construct()
    {
        parent::__construct();
    }
    function index(){
        echo "Hello";
        //customer Id
    }
    function save(){
    }
}