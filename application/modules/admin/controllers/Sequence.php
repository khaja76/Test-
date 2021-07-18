<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sequence extends MY_Controller
{
    public $header_data = array();

    function __construct()
    {
        parent::__construct();
        $this->_user_login_check(["ADMIN"]);
        $this->load->model("Sequence_model", "sequence", TRUE);
    }

    public function index()
    {
        $this->header_data['title'] = " Sequence Numbers ";
        $data = array();        
        $s['branch_id'] = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
        $sequences = $this->sequence->getAllNumberSequences($s);
        $data['sequences'] = $sequences;
        $this->_template('sequence/index', $data);
    }

    public function add(){
        redirect(base_url() . 'admin/sequence/');
        $data = [];
        $branch_id = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
        
        if(!empty($branch_id)){            
            if(!empty($_POST)){
                $pData['branch_id'] = $branch_id;
                $pData['action_type'] = !empty($_POST['action_type']) ? $_POST['action_type'] : '';
                $pData['number'] = !empty($_POST['number']) ? $_POST['number'] : '';                                
                $check = $this->sequence->checkNumberSequence($pData['action_type'],$branch_id);
                if(empty($check)){
                    $sequence_id = $this->sequence->addBranchNumberSequence($pData);   
                    if (!empty($sequence_id)) {
                        $_SESSION['message'] = "Added Successfully";
                        redirect(base_url() . 'admin/sequence/');
                    } else {
                        $_SESSION['error'] = "Failed to add Number";
                        $data['sequence'] = $_POST;
                    }
                }else{
                    $_SESSION['error'] = "Already Data added to this type";
                    //$data['sequence'] = $_POST;
                }
                                          
            }            
            $this->_template('sequence/form', $data);
        }
    }

    public function edit(){
        $data = [];
        $branch_id = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
        
        if(!empty($branch_id)){
            $pk_id = !empty($this->_REQ['id']) ? $this->_REQ['id'] : '';
            if(!empty($_POST)){
                $pData['branch_id'] = $branch_id;
                $pData['action_type'] = !empty($_POST['action_type']) ? $_POST['action_type'] : '';
                $pData['number'] = !empty($_POST['number']) ? $_POST['number'] : ''; 
                $check = $this->sequence->checkNumberSequence($pData['action_type'],$branch_id,$pk_id);               
                if(empty($check)){
                    if(!empty($pk_id)){
                        // edit sequence
                        $sequence_id = $this->sequence->updateBranchNumberSequence($pData,$pk_id);
                        if (!empty($sequence_id)) {
                            $_SESSION['message'] = "updated Successfully";
                            redirect(base_url() . 'admin/sequence/');
                        } else {
                            $_SESSION['error'] = "Failed to add Number";
                            $data['sequence'] = $_POST;
                        }
                    }
                }else{
                    $_SESSION['error'] = "Already Data added to this type";
                }               
            }
            if(!empty($pk_id)){
                $data['sequence'] = $this->sequence->getBranchNumberSequenceById($pk_id,$branch_id);
                if(!empty($data['sequence'])){
                    $this->_template('sequence/form', $data);
                }else{
                    redirect(base_url() . 'admin/sequence/');
                }
            }
            
        }
    }

}