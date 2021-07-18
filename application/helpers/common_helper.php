<?php
require_once 'SimpleImage.php';
if (!function_exists("getMessage")) {
    function getMessage($sub = '')
    {
        $msg = "";
        if (!empty($sub) && !empty($_SESSION[$sub]['message'])) {
            $msg = '<div class="alert alert-success  fade in"> <button type="button" class="close" data-dismiss="alert">&times;</button> ' . $_SESSION[$sub]['message'] . '</div>';
            $_SESSION[$sub]['message'] = "";
        }// if end.
        if (empty($sub) && !empty($_SESSION['message'])) {
            $msg = '<div class="alert alert-success fade in"> <button type="button" class="close" data-dismiss="alert">&times;</button> ' . $_SESSION['message'] . '</div>';
            $_SESSION['message'] = "";
        }// if end.
        if (!empty($sub) && !empty($_SESSION[$sub]['error'])) {
            $msg = '<div class="alert alert-danger fade in"> <button type="button" class="close" data-dismiss="alert">&times;</button> ' . $_SESSION[$sub]['error'] . '</div>';
            $_SESSION[$sub]['error'] = "";
        }// if end.
        if (empty($sub) && !empty($_SESSION['error'])) {
            $msg = '<div class="alert alert-danger fade in"> <button type="button" class="close" data-dismiss="alert">&times;</button> ' . $_SESSION['error'] . '</div>';
            $_SESSION['error'] = "";
        }// if end.
        return $msg;
    }
}
if (!function_exists("get_active_link")) {
    function get_active_link($urls = [])
    {
        foreach($urls as $url){
            if (explode('/', $_SERVER['REQUEST_URI'])[2] == $url) {
                return "class='active'";
            } 
        }
    }
}
if(!function_exists("isLoginExists")){
    function isLoginExists(){            
        if (isset($_SESSION['LAST_REQUEST_TIME'])) {
            if (time() - $_SESSION['LAST_REQUEST_TIME'] > 900) {
                $_SESSION = array();
                session_destroy();
                redirect(base_url().'logout/?session_exp=1');
            }
        }
        $_SESSION['LAST_REQUEST_TIME'] = time();
    }
}
if (!function_exists("generatePassword")) {
    function generatePassword($length = 8)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        //'0123456789``-=~!@#$%^&*()_+,./<>?;:[]{}\|';
        $str = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++)
            $str .= $chars[rand(0, $max)];
        return $str;
    }
}
if (!function_exists("generateOTP")) {
    function generateOTP($length = 6)
    {
        $chars = '0123456789';
        $str = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++)
            $str .= $chars[rand(0, $max)];
        return $str;
    }
}
if (!function_exists("dateDB2SHOW")) {
    function dateDB2SHOW($db_date = "", $format = "", $display = "")
    {
        if (!empty($db_date) && $db_date != "0000-00-00" && $db_date != "0000-00-00 00:00:00") {
            $db_date = strtotime($db_date);
            if (!empty($format)) {
                return date($format, $db_date);
            }
            return date("d/m/Y", $db_date);
        }
        return $display;
    }
}
if (!function_exists("dateRangeDB2SHOW")) {
    function dateRangeDB2SHOW($db_date = "", $format = "", $display = "")
    {
        if (!empty($db_date) && $db_date != "0000-00-00" && $db_date != "0000-00-00 00:00:00") {
            $db_date = strtotime($db_date);
            if (!empty($format)) {
                return date($format, $db_date);
            }
            return date("d-m-Y", $db_date);
        }
        return $display;
    }
}
if (!function_exists("dateNameDB2SHOW")) {
    function dateNameDB2SHOW($db_date = "", $display = "")
    {
        if (!empty($db_date) && $db_date != "0000-00-00" && $db_date != "0000-00-00 00:00:00") {
            $db_date = strtotime($db_date);
            return date("d M Y", $db_date);
        }
        return $display;
    }
}
if (!function_exists("timeDB2SHOW")) {
    function timeDB2SHOW($db_date = "", $display = "")
    {
        if (!empty($db_date) && $db_date != "0000-00-00" && $db_date != "0000-00-00 00:00:00") {
            $db_date = strtotime($db_date);
            return date("h:m A", $db_date);
        }
        return $display;
    }
}
if (!function_exists("dateTimeDB2SHOW")) {
    function dateTimeDB2SHOW($db_date = "", $format = "", $display = "")
    {
        if (!empty($db_date) && $db_date != "0000-00-00" && $db_date != "0000-00-00 00:00:00") {
            $db_date = strtotime($db_date);
            if (!empty($format)) {
                return date($format, $db_date);
            } else {
                return date("d/m/Y h:i A", $db_date);
            }
        }
        return $display;
    }
}
if (!function_exists("dateForm2DB")) {
    function dateForm2DB($frm_date)
    {
        $frm_date = explode("/", $frm_date);
        if (!empty($frm_date[0]) && !empty($frm_date[1]) && !empty($frm_date[2])) {
            return $frm_date[2] . "-" . $frm_date[1] . "-" . $frm_date[0];
        } else {
            return '';
        }
    }
}
if (!function_exists("dateRangeForm2DB")) {
    function dateRangeForm2DB($frm_date)
    {
        $frm_date = explode("-", $frm_date);
        if (!empty($frm_date[0]) && !empty($frm_date[1]) && !empty($frm_date[2])) {
            return $frm_date[2] . "-" . $frm_date[1] . "-" . $frm_date[0];
        } else {
            return '';
        }
    }
}
if (!function_exists("dateTimeForm2DB")) {
    function dateTimeForm2DB($frm_date)
    {
        $frm_date_time = explode(" ", $frm_date);
        $frm_date = explode("/", $frm_date_time[0]);
        $frm_time = explode(":", $frm_date_time[1]);
        if (!empty($frm_date[0]) && !empty($frm_date[1]) && !empty($frm_date[2])) {
            if (!isset($frm_time[0]))
                $frm_time[0] = "00";
            if (!isset($frm_time[1]))
                $frm_time[1] = "00";
            if (!isset($frm_time[2]))
                $frm_time[2] = "00";
            if (!empty($frm_date_time[2]) && $frm_date_time[2] == "AM" && $frm_time[0] == 12) {
                $frm_time[0] = "00";
            } else if (!empty($frm_date_time[2]) && $frm_date_time[2] == "PM" && $frm_time[0] < 12) {
                $frm_time[0] = (int)$frm_time[0];
                $frm_time[0] = $frm_time[0] + 12;
            }
            return $frm_date[2] . "-" . $frm_date[1] . "-" . $frm_date[0] . " " . $frm_time[0] . ":" . $frm_time[1] . ":" . $frm_time[2];
        } else {
            return "";
        }
    }
}
if (!function_exists("priceFormat")) {
    function priceFormat($price)
    {
        return number_format($price, 2);
    }
}
if (!function_exists("stdNameFormat")) {
    function stdNameFormat($str, $space = '-')
    {
        $str = strtolower($str);
        $str = str_replace("  ", " ", $str);
        $str = str_replace(" ", $space, $str);
        return $str;
    }
}
if (!function_exists("stdURLFormat")) {
    function stdURLFormat($str, $space = '-')
    {
        $str = strtolower($str);
        $str = preg_replace('/[^a-zA-Z0-9\-\ ]/i', '', $str);
        $str = str_replace("  ", " ", $str);
        $str = str_replace(" ", $space, $str);
        return $str;
    }
}
if (!function_exists("imgUpload")) {
    function imgUpload($field, $folder = '/data/', $file_name = '', $overwrite = true)
    {
        $allowed_types = 'gif|jpg|jpeg|png';
        if (!empty($_FILES[$field]['name'])) {
            if (!file_exists(FCPATH . $folder)) {
                mkdir(FCPATH . $folder, 0775);
            }
            $upload_path = FCPATH . $folder;
            if ($_FILES[$field]['error'] === 0) {
                $file_info = pathinfo($_FILES[$field]['name']);
                $file_name = $file_name . "." . $file_info['extension'];
                $file_path = $upload_path . $file_name;
                if (@move_uploaded_file($_FILES[$field]["tmp_name"], $file_path)) {
                    return $file_name;
                }
            }
        }
        return false;
    }
}
if (!function_exists("uploadFiles")) {
    function uploadFiles($folder = '/data/', $field_name)
    {
        $sent_file_name = $field_name;
        if (!empty($_FILES[$field_name]['name'])) {
            $tmp_files = $_FILES[$sent_file_name]['tmp_name'];
            if (!file_exists(FCPATH . $folder)) {
                mkdir(FCPATH . $folder, 0775);
            }
            $upload_path = FCPATH . $folder;
            foreach ($tmp_files as $key => $tmp_name) {
                if ($_FILES[$field_name]['error'][0] === 0) {
                    $files = $_FILES[$sent_file_name]['name'][$key];
                    @move_uploaded_file($tmp_name, $upload_path . '/' . $files);
                }
            }
        }
    }
}
if (!function_exists("uploadThumbFiles")) {
    function uploadThumbFiles($folder = '/data/', $field_name, $width)
    {
        $sent_file_name = $field_name;
        if (!empty($_FILES[$field_name]['name'])) {
            $tmp_files = $_FILES[$sent_file_name]['tmp_name'];
            if (!file_exists(FCPATH . $folder)) {
                mkdir(FCPATH . $folder, 0775);
            }
            $upload_path = FCPATH . $folder;
            foreach ($tmp_files as $key => $tmp_name) {
                if ($_FILES[$field_name]['error'][0] === 0) {
                    //$files = $_FILES[$sent_file_name]['name'][$key];
                    $files = $_FILES[$sent_file_name]['name'][$key];
                    $file_path = $upload_path . '/' . $files;
                    $file_thumb_path = $upload_path . '/thumb_' . $files;
                    if (@move_uploaded_file($tmp_name, $file_path)) {
                        if (@copy($file_path, $file_thumb_path)) {
                            $img = new abeautifulsite\SimpleImage($file_thumb_path);
                            $img->fit_to_width($width)->save($file_thumb_path);
                        }
                    }
                }
            }
        }
    }
}
if (!function_exists("uploadImage")) {
    function uploadImage($field, $folder_name = '/data/', $file_name = '', $width)
    {
        if (!empty($_FILES[$field]['name'])) {
            if (!file_exists(FCPATH . $folder_name)) {
                mkdir(FCPATH . $folder_name, 0775);
            }
            $upload_path = FCPATH . $folder_name;
            if ($_FILES[$field]['error'] === 0) {
                $file_info = pathinfo($_FILES[$field]['name']);
                $tmp = $_FILES[$field]['tmp_name'];
                $file_name = $file_name . "." . $file_info['extension'];
                $file_path = $upload_path . $file_name;
                $file_thumb_path = $upload_path . "thumb_" . $file_name;
                try {
                    if (@move_uploaded_file($tmp, $file_path)) {
                        if (@copy($file_path, $file_thumb_path)) {
                            $img = new abeautifulsite\SimpleImage($file_thumb_path);
                            $img->fit_to_width($width)->save($file_thumb_path);
                        }
                        return $file_name;
                    }
                } catch (Exception $e) {
                }
            }
        }
        return false;
    }
}
if (!function_exists("createFolder")) {
    function createFolder($folder = '/data/')
    {
        if (!file_exists(FCPATH . $folder)) {
            //mkdir(DOC_ROOT_PATH . $folder, 0755, true);
            mkdir(FCPATH . $folder, 0777, true);
        }
    }
}
if (!function_exists("shortDesc")) {
    function shortDesc($str, $len = 300)
    {
        $str = substr($str, 0, $len);
        return $str;
    }
}
if (!function_exists("curl_get_contents")) {
    function curl_get_contents($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
if (!function_exists("getIPInfo")) {
    function getIPInfo($ip = '')
    {
        if (empty($ip)) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return json_decode(curl_get_contents("http://ipinfo.io/{$ip}/json"));
    }
}
if (!function_exists("numToMonth")) {
    function numToMonth($number)
    {
        $monthNum = $number;
        $monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
        return $monthName;
    }
}
if (!function_exists("timeAgo")) {
    function timeAgo($date)
    {
        $minutes_to_add = 725;
        $time = new DateTime($date);
        $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
        $date = $time->format('Y-m-d H:i:s');
        $timestamp = strtotime($date);
        $strTime = array("second", "minute", "hour", "day", "month", "year");
        $length = array("60", "60", "24", "30", "12", "10");
        $currentTime = time();
        if ($currentTime >= $timestamp) {
            $diff = time() - $timestamp;
            for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
                $diff = $diff / $length[$i];
            }
            $diff = round($diff);
            if (($strTime[$i] == "hour") || ($strTime[$i] == "minute") || ($strTime[$i] == "second")) {
                return $diff . " " . $strTime[$i] . "(s) ago ";
            } else {
                return dateDB2SHOW($date, "M d, Y");
            }
        }
    }
    if (!function_exists("dummyLogo")) {
        function dummyLogo()
        {
            return base_url() . "data/avatar.jpeg";
        }
    }
    if (!function_exists("slugify")) {
        function slugify($text)
        {
            $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
            $text = trim($text, '-');
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
            $text = strtolower($text);
            $text = preg_replace('~[^-\w]+~', '', $text);
            if (empty($text)) {
                return 'n-a';
            }
            return $text;
        }
    }
}
if (!function_exists("financialYear")) {
    function financialYear()
    {
        $financialYear = '';
        $prev_year = substr(date('Y'), 2, 2) - 1;
        $current_year = substr(date('Y'), 2, 2);
        $next_year = substr(date('Y'), 2, 2) + 1;
        if (date('m') >= '04') {
            $financialYear =  $current_year . '-' . $next_year;
        }
        if (date('m') <= '03') {
            $financialYear =  $prev_year . '-' . $current_year;
        }
        return $financialYear;
    }
}
if (!function_exists("customerFormat")) {
    function customerFormat($number, $branch_code)
    {
        $finance_year = financialYear();
        return $branch_code . '-'. $number;
    }
}
if (!function_exists("inwardFormat")) {
    function inwardFormat($number, $inward_code)
    {
        $finance_year = financialYear();
        return $inward_code . '/' . $finance_year . '/' . $number;
    }
}
if (!function_exists("challanFormat")) {
    function challanFormat($number,$type, $branch_code)
    {
        $finance_year = financialYear();
        return $branch_code . '/' . $finance_year . '/'.date('m').'/'.$type.'-'. $number;
    }
}
// Quotation Foramt
if (!function_exists("transactionFormat")) {
    function transactionFormat($number, $type,$branch_code)
    {
        $finance_year = financialYear();
        return $branch_code . '/' . $finance_year . '/'.$type.'-' . $number;
    }
}

if (!function_exists("getFiles")) {
    function getFiles($path)
    {
        $path = FCPATH . $path;
        $thumbs = glob($path . "thumb_*[.jpg,.jpeg,.JPG,.JPEG,.png,.PNG,.gif,.GIF]");
        return $thumbs;
    }
}
if (!function_exists("currentModuleView")) {
    function currentModuleView($module)
    {
        return APPPATH.'modules/'.$module.'/views/';
    }
}
 function get_role_based_link(){
    $role='';
    if(!empty($_SESSION['ROLE'])){
        if(($_SESSION['ROLE']=='ADMIN') || ($_SESSION['ROLE']=='SUPER_ADMIN')){
            $role='admin';
        }else if($_SESSION['ROLE']=='RECEPTIONIST'){
            $role='reception';
        }
        else if($_SESSION['ROLE']=='ENGINEER'){
            $role='engineer';
        }
        return base_url().$role;
    }
}
?>
