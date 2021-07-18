<?php

class Message_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getInwardApprovalsCNT()
    {
        $date=date('Y-m-d');
        $this->db->select("COUNT(1) as CNT");
        $this->db->where("branch_id",$_SESSION['BRANCH_ID']);
        $this->db->where("location_id",$_SESSION['LOCATION_ID']);
        $this->db->where("DATE(m.approved_date)",$date);
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_inward_approvals m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['CNT'];
        }
        return false;
    }

    function addMessage($data)
    {
        if (!isset($data['created_on'])) {
            $date = date('Y-m-d H:i:s');
            $this->db->set("created_on", $date);
        }
        $this->db->insert("tbl_messages", $data);
        return $this->db->insert_id();
    }


    function searchMessages($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,b.name as branch_name,h.pk_id as view_id,h.is_viewed,h.sent_to,
            u.name as sender,u.role as sender_role ,us.name as receiver,us.role as receiver_role,
            i.inward_no,i.pk_id as job_pk_id,i.job_id");
        }

        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        $this->db->join("tbl_message_history h", "h.message_id = m.pk_id");
        $this->db->join("tbl_users u", "u.user_id = m.created_by");
        $this->db->join("tbl_users us", "us.user_id = h.sent_to");
        $this->db->join("tbl_inwards i", "i.pk_id = m.job_id");
        $this->db->join("tbl_branches b", "b.pk_id = m.branch_id");
        if (!empty($s['date']) && isset($s['date'])) {
            $this->db->where("DATE(m.created_on)", $s['date']);
        }
        if (!empty($s['created_by']) && isset($s['created_by'])) {
            $this->db->where("m.created_by", $s['created_by']);
        }
        if (!empty($s['branch_id']) && isset($s['branch_id'])) {
            $this->db->where("m.branch_id", $s['branch_id']);
        }
        if (!empty($s['sent_to']) && isset($s['sent_to'])) {
            $this->db->where("h.sent_to", $s['sent_to']);
        }
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_messages m");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function searchInboxMessages($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.pk_id,m.message_id,n.subject,n.description,n.created_on,u.user_id,u.name as sender,n.job_id");
        }

        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }
        $this->db->join("tbl_messages n", "n.pk_id = m.message_id");
        $this->db->join("tbl_users u", "u.user_id = n.created_by");

        if (!empty($s['from_date'])) {
            $from = $s['from_date'];
            $to = $s['to_date'];
            $this->db->where("DATE(n.created_on) BETWEEN '" . $from . "' AND '" . $to . "'");
        } else if (!empty($s['date']) && isset($s['date'])) {
            $this->db->where("DATE(n.created_on)", $s['date']);

        }

        $this->db->where("m.sent_to", $s['user_id']);
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_message_history m");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function searchSentMessages($s = [], $mode = "DATA")
    {
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,i.inward_no,i.pk_id as job_pk_id,i.branch_id,u.name as receiver");
        }

        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        }

        $this->db->join("tbl_inwards i", "i.pk_id = m.job_id", "LEFT");
        $this->db->join("tbl_message_history h", "h.message_id = m.pk_id");
        $this->db->join("tbl_users u", "u.user_id = h.sent_to");


        if (!empty($s['from_date'])) {
            $from = $s['from_date'];
            $to = $s['to_date'];
            $this->db->where("DATE(m.created_on) BETWEEN '" . $from . "' AND '" . $to . "'");
        } else if (!empty($s['date']) && isset($s['date'])) {
            $this->db->where("DATE(m.created_on)", $s['date']);

        }

        $this->db->where("m.created_by", $_SESSION['USER_ID']);
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_messages m");
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    function getMessageById($pk_id)
    {
        $this->db->select("m.*,i.inward_no,u.name as sender,u.role as sender_role,b.name as branch_name,r.name as receiver,r.role as receiver_role");
        $this->db->join("tbl_users u", "u.user_id = m.created_by");
        $this->db->join("tbl_branches b", "b.pk_id = m.branch_id", "LEFT");
        $this->db->join("tbl_message_history h", "h.message_id = m.pk_id");
        $this->db->join("tbl_users r", "r.user_id = h.sent_to");
        $this->db->join("tbl_inwards i", "i.job_id = m.job_id", "LEFT");
        $this->db->where("m.pk_id", $pk_id);
        $query = $this->db->get("tbl_messages m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }


    function addMessageHistory($data)
    {
        $this->db->insert("tbl_message_history", $data);
        $this->addMessageStatus(['message_id' => $data['message_id'], 'user_id' => $data['sent_to']]);
    }

    function updateMessageHistory($data, $pk_id)
    {
        if (!isset($data['view_time'])) {
            $date = date('Y-m-d H:i:s');
            $this->db->set("view_time", $date);
        }
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_message_history", $data);
    }

    function getMessageHistoryById($s = [])
    {
        $this->db->select("m.*");
        if (!empty($s['message_id']) && isset($s['message_id'])) {
            $this->db->where("m.message_id", $s['message_id']);
        }
        if (!empty($s['sent_to']) && isset($s['sent_to'])) {
            $this->db->where("m.sent_to", $s['sent_to']);
        }
        if (!empty($s['pk_id']) && isset($s['pk_id'])) {
            $this->db->where("m.pk_id", $s['pk_id']);
        }
        $query = $this->db->get("tbl_message_history m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function addMessageStatus($data)
    {
        if (!isset($data['created_on'])) {
            $date = date('Y-m-d H:i:s');
            $this->db->set("created_on", $date);
        }
        $this->db->insert("tbl_message_status", $data);
        return $this->db->insert_id();
    }

    function getInwardsList($s = [])
    {
        $this->db->select("m.*");
        if (!empty($_SESSION) && ($_SESSION['ROLE'] == "ADMIN")) {
            $this->db->where("m.branch_id", $_SESSION['BRANCH_ID']);
        }
        if (!empty($_SESSION) && ($_SESSION['ROLE'] == "RECEPTIONIST")) {
            $this->db->where("m.created_by", $_SESSION['USER_ID']);
        }
        if (!empty($_SESSION) && ($_SESSION['ROLE'] == "ENGINEER")) {
            $this->db->where("m.assigned_to", $_SESSION['USER_ID']);
        }

        $this->db->order_by('m.pk_id DESC');
        $query = $this->db->get("tbl_inwards m");

        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['pk_id']] = $row['job_id'];
            }
            return $rows;
        }
        return false;
    }

    function getUserById($user_id)
    {
        $this->db->select("m.*");
        $this->db->where("m.user_id", $user_id);
        $query = $this->db->get("tbl_users m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    //Super admin Location search

    function getLocationsList()
    {
        $this->db->select("m.*");
        $query = $this->db->get("tbl_locations m");
        if ($query->num_rows() > 0) {
            $rows = array();
            foreach ($query->result_array() as $row) {
                $rows[$row['pk_id']] = $row['location_name'];
            }
            return $rows;
        }
        return false;
    }

    function delMessageFromStatus($data)
    {
        if (!empty($data['user_id'])) {
            $this->db->where("user_id", $data['user_id']);
        }
        if (!empty($data['message_id'])) {
            $this->db->where("message_id", $data['message_id']);
        }
        return $this->db->delete("tbl_message_status");
    }
}