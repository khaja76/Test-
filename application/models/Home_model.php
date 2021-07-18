<?php

class Home_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function checkUserEmail($email, $user_id = '')
    {
        $this->db->select("m.*");
        $this->db->where("email", $email);
        $this->db->where("branch_id", $_SESSION['BRANCH_ID']);
        if (!empty($user_id)) {
            $this->db->where("user_id !=", $user_id);
        }
        $query = $this->db->get("tbl_users m");
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }

    function checkCustomerEmail($email, $customer_id = '', $branch_id = '')
    {
        $this->db->select("m.*");
        $this->db->where("email", $email);
        if (!empty($user_id)) {
            $this->db->where("customer_id !=", $customer_id);
        }
        if (!empty($branch_id)) {
            $this->db->where("branch_id", $branch_id);
        }
        $query = $this->db->get("tbl_customers m");
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }

    function checkCustomerMobile($mobile, $customer_id = '', $branch_id = '')
    {
        $this->db->select("m.*");
        $this->db->where("mobile", $mobile);
        if (!empty($user_id)) {
            $this->db->where("customer_id !=", $customer_id);
        }
        if (!empty($branch_id)) {
            $this->db->where("branch_id", $branch_id);
        }
        $query = $this->db->get("tbl_customers m");

        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }

    function userLogin($email, $pwd)
    {
        $this->db->select("m.*,b.branch_code,b.inward_code");
        $this->db->where("m.email", $email);
        $this->db->where("m.password", $pwd);
        $this->db->join("tbl_branches b", "b.pk_id = m.branch_id", "LEFT");
        $query = $this->db->get("tbl_users m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function getUserDetails($s = [])
    {
        $this->db->select("m.*");
        if (!empty($s['email'])) {
            $this->db->where("m.email", $s['email']);
        } elseif (!empty($s['user_id'])) {
            $this->db->where("m.user_id", $s['user_id']);
        }

        $query = $this->db->get("tbl_users m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function updateUser($pdata, $user_id)
    {
        $this->db->where("user_id", $user_id);
        return $this->db->update("tbl_users", $pdata);
    }


    function updateUserByToken($pdata, $reset_token)
    {
        $this->db->where("reset_token", $reset_token);
        return $this->db->update("tbl_users", $pdata);
    }

    function getUserByToken($reset_token)
    {
        $this->db->select("m.*");
        $this->db->where("reset_token", $reset_token);
        $query = $this->db->get("tbl_users m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

}