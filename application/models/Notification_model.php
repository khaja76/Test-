<?php

class Notification_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    // Add Notification
    function addNotification($data)
    {
        $branch_id = !empty($_SESSION['BRANCH_ID']) ? $_SESSION['BRANCH_ID'] : '';
        $created_by = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
        if (!isset($data['created_on'])) {
            $date = date('Y-m-d H:i:s');
            $this->db->set("created_on", $date);
        }
        if (!isset($data['branch_id'])) {
            $this->db->set("branch_id", $branch_id, false);
        }
        if (!isset($data['created_by'])) {
            $this->db->set("created_by", $created_by, false);
        }
        $this->db->insert('tbl_notifications', $data);
        return $this->db->insert_id();
    }

    function addNotificationStatus($data)
    {
        if (!isset($data['created_on'])) {
            $date = date('Y-m-d H:i:s');
            $this->db->set("created_on", $date);
        }
        $this->db->insert('tbl_notification_status', $data);
        return $this->db->insert_id();
    }

    // Update Notification
    function updateNotification($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_notifications", $data);
    }

    // Delete Notification
    function delNotification($pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->delete("tbl_notifications");
    }

    // Search All Notifications
    function searchNotifications($s = [], $mode = "DATA")
    {
        $user_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
        if ($mode == "CNT") {
            $this->db->select("COUNT(1) as CNT");
        } else {
            $this->db->select("m.*,t.type,t.title,n.notification_type_id,n.inward_status,u.name as created_by,s.name as subordinate_name,b.name as branch_name,i.job_id,CONCAT_WS(' ',first_name,last_name) as customer_name,ic.challan as inward_challan,oc.challan as outward_challan", false);
        }
        if (isset($s['limit']) && isset($s['offset'])) {
            $this->db->limit($s['limit'], $s['offset']);
        } else if (isset($s['limit'])) {
            $this->db->limit($s['limit']);
        } else {
            $this->db->limit(10);
        }
        $this->db->where('m.user_id', $user_id);
        if (!empty($s['from_date'])) {
            $from = $s['from_date'];
            $to = $s['to_date'];
            $this->db->where("DATE(m.created_on) BETWEEN '" . $from . "' AND '" . $to . "'");
        } elseif (isset($s['date']) && !empty($s['date'])) {
            $this->db->where("DATE(m.created_on)", $s['date']);
        } else if(isset($s['view_all']) && ($s['view_all']=='YES')){
            
        }else{
            $this->db->where('m.is_viewed', 'NO');
        }
        if(!empty($s['is_viewed']) && ($s['is_viewed']=='NO')){
            $this->db->where('m.is_viewed', 'NO');
        }
        $this->db->join('tbl_notifications n', 'n.pk_id = m.notification_id');
        $this->db->join('tbl_notification_types t', 't.pk_id = n.notification_type_id');
        $this->db->join('tbl_users u', 'u.user_id = n.created_by');
        $this->db->join('tbl_users s', 's.user_id = n.subordinate_id', 'LEFT');
        $this->db->join('tbl_branches b', 'b.pk_id = n.branch_id');
        $this->db->join('tbl_customers c', 'c.pk_id = n.customer_id', 'LEFT');
        $this->db->join('tbl_inwards i', 'i.pk_id = n.inward_id', 'LEFT');
        $this->db->join('tbl_inward_challans ic', 'ic.pk_id = n.inward_challan_id', 'LEFT');
        $this->db->join('tbl_outward_challans oc', 'oc.pk_id = n.outward_challan_id', 'LEFT');
        $this->db->order_by("m.pk_id DESC");
        $query = $this->db->get("tbl_notification_status m");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            if ($mode == "CNT") {
                $row = $query->row_array();
                return $row['CNT'];
            }
            return $query->result_array();
        }
        return false;
    }

    // View Single Notification
    function getNotificationById($pk_id)
    {
        $data = [];
        $data['is_viewed'] = 'YES';
        if (!isset($data['viewed_on'])) {
            $date = date('Y-m-d H:i:s');
            $this->db->set("viewed_on", $date);
        }
        $this->updateNotificationStatus($data, $pk_id);
        $this->db->select("m.*,t.type,t.title,n.notification_type_id,n.inward_status,u.name as created_by,s.name as subordinate_name,b.name as branch_name,i.job_id,CONCAT_WS(' ',first_name,last_name) as customer_name,ic.challan as inward_challan,oc.challan as outward_challan", false);
        // $this->db->where('m.is_viewed', 'NO');
        $this->db->join('tbl_notifications n', 'n.pk_id = m.notification_id');
        $this->db->join('tbl_notification_types t', 't.pk_id = n.notification_type_id');
        $this->db->join('tbl_users u', 'u.user_id = n.created_by');
        $this->db->join('tbl_users s', 's.user_id = n.subordinate_id', 'LEFT');
        $this->db->join('tbl_branches b', 'b.pk_id = n.branch_id');
        $this->db->join('tbl_customers c', 'c.pk_id = n.customer_id', 'LEFT');
        $this->db->join('tbl_inwards i', 'i.pk_id = n.inward_id', 'LEFT');
        $this->db->join('tbl_inward_challans ic', 'ic.pk_id = n.inward_challan_id', 'LEFT');
        $this->db->join('tbl_outward_challans oc', 'oc.pk_id = n.outward_challan_id', 'LEFT');
        $this->db->where("m.pk_id", $pk_id);
        $query = $this->db->get("tbl_notification_status m");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function updateNotificationStatus($data, $pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->update("tbl_notification_status", $data);
    }

    function updateUserNotificationStatus($data, $user_id)
    {
        $this->db->where("user_id", $user_id);
        return $this->db->update("tbl_notification_status", $data);
    }

// Delete Notification
    function delNotificationStatus($pk_id)
    {
        $this->db->where("pk_id", $pk_id);
        return $this->db->delete("tbl_notification_status");
    }
}

?>