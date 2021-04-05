<?php

function get_infinite_sign() {
    return '∞';
}

function get_selected_month_year_array($start_month_year_string, $end_month_year_string, $month_duration_count) {
    $array = array();
    $start = date("Y-m-d", strtotime($start_month_year_string));
    $end = date("Y-m-d", strtotime($end_month_year_string));
    $start = (new DateTime($start))->modify('first day of this month');
    $end = (new DateTime($end))->modify('first day of next month');
    $interval = DateInterval::createFromDateString('1 month');
    $period = new DatePeriod($start, $interval, $end);

    foreach ($period as $dt) {
        array_push($array, $dt->format("Y-m-d"));
    }
    return $array;
}

function get_next_month_from_selected_date($selected_date, $plus_month = 1) {
    $selected_date = get_string_to_date_fromat_ymd($selected_date);
    return $next_month = date('Y-m-d', strtotime($selected_date . "+" . $plus_month . " months"));
}

function get_previous_month_from_selected_date($selected_date, $minus_month = 1) {
    $selected_date = get_string_to_date_fromat_ymd($selected_date);
    return $next_month = date('Y-m-d', strtotime($selected_date . "-" . $minus_month . " months"));
}

function get_month_number_by_month_name($monthName) {
    return date('m', strtotime($monthName));
}

function get_month_diff($start, $end) {
    get_time_zone();
    $start = date('Y-m-01', strtotime($start));
    $end = date('Y-m-t', strtotime($end));
    $end OR $end = time();
    $start = new DateTime($start);
    $end = new DateTime($end);
    $diff = $start->diff($end);
    $year = intval($diff->format('%y'));
    $month = intval($diff->format('%m'));
    $day = intval($diff->format('%d'));
    $res = ($year * 12) + ($month);
    $res = (($day) > 0) ? ($res + 1) : $res;
    $res = ((intval($res) == 0) ? 1 : $res);
    return $res;
//    $start = date("Y-m-d", strtotime($start));
//    $end = date("Y-m-d", strtotime($end));
//    $date1 = DateTime::createFromFormat('Y-m-d', $start);
//    $date2 = DateTime::createFromFormat('Y-m-d', $end)->add(new DateInterval('P1D'));
//    return (($date1->diff($date2)->y * 12) + ($date1->diff($date2)->m) + 1);
}

function remove_employee_ids() {
    return array(6, 11, 12); //here admin employee id = 6
}

function get_admin_employee_id() {
    return 6;
}

function get_last_uri_segment() {
    $ci = &get_instance();
    $last = $ci->uri->total_segments();
    return $last_uri_segment = $ci->uri->segment($last);
}

function get_admin_email() {
    $ip_address_array = array('127.0.0.1', '::1');
    if (in_array($_SERVER['REMOTE_ADDR'], $ip_address_array)) {
        return 'amit.giantssoft@gmail.com';
    } else {
        return 'mishu.minhaj@gmail.com';
    }
}

function getUserPlatform() {
    $CI = &get_instance();
    $agentArray = array();
    $CI->load->library('user_agent');
    if ($CI->agent->is_browser()) {
        $agent = $CI->agent->browser() . ' ' . $CI->agent->version();
    } elseif ($CI->agent->is_robot()) {
        $agent = $CI->agent->robot();
    } elseif ($CI->agent->is_mobile()) {
        $agent = $CI->agent->mobile();
    } else {
        $agent = 'Unidentified User Agent';
    }
    $platform = $CI->agent->platform();
    $agentArray = array(
        'agent' => !empty($agent) ? $agent : '',
        'platform' => !empty($platform) ? $platform : '',
    );
    return $agentArray;
}

function get_next_date_from_current_date_by_month($plus_month = 1) {
    $current_date = get_current_date();
    return date('Y-m-d', strtotime($current_date . "+" . $plus_month . " months"));
}

function get_previous_date_from_current_date_by_month($minus_month = 1) {
    $current_date = get_current_date();
    return date('Y-m-d', strtotime($current_date . "-" . $minus_month . " months"));
}

function get_next_date_from_current_date($plus_day = 1) {
    $current_date = get_current_date();
    return $next_day = date('Y-m-d', strtotime($current_date . "+" . $plus_day . " days"));
}

function get_previous_date_from_current_date($minus_day = 1) {
    $current_date = get_current_date();
    return $next_day = date('Y-m-d', strtotime($current_date . "-" . $minus_day . " days"));
}

function get_first_date_of_current_month() {
    get_time_zone();
    return date('Y-m-01');
}

function get_last_date_of_current_month() {
    get_time_zone();
    return date('Y-m-t');
}

function display_date($date, $time = FALSE) {
    if (!$time) {
        return (!empty($date)) ? date('d-m-Y', strtotime(($date))) : '';
    } else {
        return (!empty($date)) ? date('d-m-Y h:i A', strtotime(($date))) : '';
    }
}

function display_date_format($date, $time = FALSE) {
    get_time_zone();
    return ($time) ? date('j<\s\up>S</\s\up> M-Y h:i A', strtotime(($date))) : date('j<\s\up>S</\s\up> M-Y', strtotime(($date)));
}

function display_date_format_for_account_statment($date, $time = FALSE) {
    get_time_zone();
    return ($time) ? date('j<\s\up>S</\s\up> M-Y h:i A', strtotime(($date))) : date('j<\s\up>S</\s\up> M-Y', strtotime(($date)));
}

function get_first_date_of_current_year() {
    get_time_zone();
    return $date = date('Y-01-01');
}

function get_last_date_of_current_year() {
    get_time_zone();
    return $date = date('Y-12-31');
}

function get_last_date_of_selected_month($date) {
//    return date('Y-m-t', strtotime($date));
    $year = date('Y', strtotime($date));
    $month_number = date('m', strtotime($date));
    $last_day_of_month = date('t', strtotime($date));
    return $year . '-' . $month_number . '-' . $last_day_of_month;
}

function get_month_name_by_month_number($monthNumber, $short = FALSE) {
    get_time_zone();
    $dateObj = DateTime::createFromFormat('!m', $monthNumber);
    return (!$short) ? $dateObj->format('F') : $dateObj->format('M');
}

function get_first_date_of_month($date = NULL) {
    get_time_zone();
    return ($date == NULL) ? date('Y-m-01') : $date;
}

function get_last_date_of_month($date = NULL) {
    get_time_zone();
    return ($date == NULL) ? date('Y-m-t') : $date;
}

function get_start_date_format($date) {
    $date = ($date == null) ? get_current_date() : $date;
    return $start_date = get_string_to_date_fromat_ymd($date) . ' 00:00:00';
}

function get_end_date_format($date) {
    $date = ($date == null) ? get_current_date() : $date;
    return $end_date = get_string_to_date_fromat_ymd($date) . ' 23:59:59';
}

function get_string_to_date_fromat_ymd($date) {
    get_time_zone();
    return $result = date("Y-m-d", strtotime($date));
}

function redirect_using_jquery($url = '') {
    echo "<script>window.location.href='" . $url . "';</script>";
}

function alert_message($message = '') {
    echo '<script language="javascript">';
    echo 'alert("' . $message . '")';
    echo '</script>';
}

function delete_uploaded_file($path) {
    if (!empty($path)) {
        $path = (file_exists($path)) ? './' . $path : '';
        unlink(($path));
    }
}

function email_send($data = array()) {
    $CI = &get_instance();
    $is_sent = FALSE;
    $email_cc = array_key_exists('cc', $data) ? $data['cc'] : '';
    $email_bcc = array_key_exists('bcc', $data) ? $data['bcc'] : '';
    $attach_array = array_key_exists('attach', $data) ? $data['attach'] : '';
    $attach_array_count = !empty($attach_array) ? ((is_array($attach_array)) ? count($attach_array) : 0) : 0;
    $CI->load->library('email');
    $CI->email->initialize(smtp_config());
    $CI->email->from($data['from_email'], $data['from_title']);
    $CI->email->to($data['to_email_array']);
    $CI->email->cc($email_cc);
    $CI->email->bcc($email_bcc);
    $CI->email->subject($data['subject']);
    $CI->email->message($data['body']);
    if ($attach_array_count > 0) {
        foreach ($attach_array as $key => $value) {
            $CI->email->attach($value);
        }
    }
    try {
        $is_sent = $CI->email->send();
    } catch (Exception $e) {
        $is_sent = FALSE;
    }
    return $is_sent;
}

function is_json($string, $return_data = false) {
    $data = json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE) ? (($return_data) ? $data : true) : false;
}

function smtp_config() {
    return $config = Array(
        'protocol' => 'smtp',
        'mailpath' => 'ssl://' . trim("mail.stackmail.com"),
        'smtp_host' => 'ssl://' . trim("mail.stackmail.com"),
        'smtp_port' => 465,
        'smtp_user' => trim("no-reply@aoclbd.net"), // change it to yours
        'smtp_pass' => trim("21?w4rjL[Qtp"), // change it to yours
        'mailtype' => 'html',
    );
}

function get_smtp_host_user() {
    $config = smtp_config();
    return (array_key_exists('smtp_user', $config)) ? !empty($config['smtp_user']) ? $config['smtp_user'] : '' : '';
}

function get_company() {
    $ci = &get_instance();
    $ci->load->model("Company_Model");
    $company = $ci->Company_Model->get_company();
    return !empty($company) ? ($company) : '';
}

function get_smtp_mail_form_title() {
    return get_company_name();
}

function get_company_name() {
    $company = get_company();
    return !empty($company->company_name_1) ? ($company->company_name_1) : '';
}

function get_company_website() {
    $company = get_company();
    return !empty($company->website) ? ($company->website) : '';
}

function get_company_address() {
    $company = get_company();
    return !empty($company->company_address_1) ? ($company->company_address_1) : '';
}

function get_array_key_value($key = '', $data = array()) {
    if (!empty($key) && !empty($data)) {
        return array_key_exists($key, $data) ? $data[$key] : '';
    } else {
        return '';
    }
}

function set_json_output($data_array = array()) {
    $CI = &get_instance();
    $CI->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data_array));
}

function is_valid_date($date) {
    return $is_date = (($date == NULL) || ($date == '0000-00-00 00:00:00')) ? FALSE : TRUE;
}

function get_currency() {
    $ci = &get_instance();
    $ci->load->model("Currency_settings_Model");
    $currency_settings = $ci->Currency_settings_Model->get_currency_settings();
    return !empty($currency_settings->currency_symbol) ? $currency_settings->currency_symbol : '';
}

function get_time_zone() {
    $ip_address_array = array('127.0.0.1', '::1');
    if (in_array($_SERVER['REMOTE_ADDR'], $ip_address_array)) {
        return date_default_timezone_set("Asia/Dhaka");
    } else {
        return date_default_timezone_set("Asia/Dhaka");
    }
}

function get_current_date_and_time($date = NULL) {
    get_time_zone();
    if ($date == NULL) {
        return $current_date_time = date('Y-m-d H:i:s');
    } else {
        return $current_date_time = date($date . ' H:i:s');
    }
}

function get_current_date() {
    get_time_zone();
    return $current_date = date('Y-m-d');
}

function get_current_time() {
    get_time_zone();
    return $time = date('G:i:s');
}

function get_string_to_date_fromat($date) {
    return $result = date("d-m-Y", strtotime($date));
}

function get_string_to_time_fromat($time) {
    return $result = date('g:i a', strtotime($time));
}

function get_current_year() {
    get_time_zone();
    return $current_year = date("Y");
}

function get_current_month_name() {
    get_time_zone();
    return $current_month_name = date("F");
}

function convert_number_to_words($number) {
    $hyphen = '-';
    $conjunction = ' and ';
    $separator = ', ';
    $negative = 'negative ';
    $decimal = ' point ';
    $dictionary = array(
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
        20 => 'twenty',
        30 => 'thirty',
        40 => 'fourty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety',
        100 => 'hundred',
        1000 => 'thousand',
        1000000 => 'million',
        1000000000 => 'billion',
        1000000000000 => 'trillion',
        1000000000000000 => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    if (!is_numeric($number)) {
        return false;
    }
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
        );
        return false;
    }
    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
    $string = $fraction = null;
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens = ((int) ($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    return $string;
}

function valid_numeric_number_check($amount) {
    if (empty($amount) || (!is_numeric($amount))) {
        return FALSE;
    }
    return TRUE;
}

function get_floating_point_number($number = 0, $thousands_separator = FALSE) {
    if ($thousands_separator == FALSE) {
        $result = number_format((double) $number, 2, '.', '');
    } else {
        $result = number_format((double) $number, 2);
    }
    return $result;
}

function get_date_interval($start_date, $end_date) {
    $datetime1 = new DateTime($start_date);
    $datetime2 = new DateTime($end_date);
    $interval = $datetime1->diff($datetime2);
    $result = $interval->format('%a');
    return $result = (int) $result + 1;
}

function get_days_name_list() {
    $timestamp = strtotime('next Sunday');
    $days = array();
    for ($i = 0; $i < 7; $i++) {
        $days[] = strftime('%A', $timestamp);
        $timestamp = strtotime('+1 day', $timestamp);
    }
    return $days;
}

function get_start_year_to_current_year_array() {
    $years = array();
    $start_Year = '2016';
    $current_year = get_current_year();
    $diff = ($current_year - $start_Year);
    $lastYear = ($start_Year + $diff);
    if ($start_Year == $current_year) {
        array_push($years, $current_year);
    } else {
        for ($i = $start_Year; $i <= $lastYear; $i++) {
            array_push($years, $i);
        }
    }
    return $years;
}

function get_months_name_array() {
    $months_name = array();
    for ($m = 1; $m <= 12; ++$m) {
        array_push($months_name, date('F', mktime(0, 0, 0, $m, 1)));
    }
    return $months_name;
}

function get_user_ip_address() {
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];
    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }
    return $ip;
}

function get_user_server_information() {
    return $_SERVER;
}

function get_country_city_from_ip($ip = '') {
    $array = array();
    try {
        if (empty($ip)) {
            $ip = get_user_ip_address();
        }
        $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
//    $query = 'http://ip-api.com/php/' . $ip;
        if ($query && $query['status'] == 'success') {
            $array = array(
                'country' => $query['country'],
                'city' => $query['city']
            );
        }
    } catch (Exception $ex) {
        
    }
    return $array;
}

function get_ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = get_user_ip_address();
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        //$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        $url = "http://www.geoplugin.net/json.gp?ip=" . $ip;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ipdat = curl_exec($ch);
        $ipdat = json_decode($ipdat);
        curl_close($ch);
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "ip" => $ip,
                        "city" => @$ipdat->geoplugin_city,
                        "state" => @$ipdat->geoplugin_regionName,
                        "country" => @$ipdat->geoplugin_countryName,
                        "country_code" => @$ipdat->geoplugin_countryCode,
                        "continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode,
                        "latitude" => @$ipdat->geoplugin_latitude,
                        "longitude" => @$ipdat->geoplugin_longitude
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}

function is_valid_user_check_by_user_country() {
    $access_country_array = get_valid_user_country();
    $ip_info = get_ip_info();
    $ip_address = get_user_ip_address();
    $user_country = $ip_info['country'];
    if ($ip_address == '::1') {
        return TRUE;
    }
    if (!empty($ip_address) || $ip_address != NULL) {
        if ((!empty($user_country)) || ($user_country != NULL)) {
            if (in_array(strtolower($user_country), $access_country_array)) {
                return TRUE;
            }
            return FALSE;
        }
        return FALSE;
    }
    return FALSE;
}

function is_valid_user_ip() {
    $access_ip_address_array = get_valid_user_ip_address();
    $ip_address = get_user_ip_address();
    if (in_array(strtolower($ip_address), $access_ip_address_array)) {
        return TRUE;
    }
    return FALSE;
}

function get_valid_user_country() {
    $access_country_array = array("bangladesh", "thailand"); //N.B: provide a full country name in lower case ;
    return $access_country_array;
}

function get_valid_user_ip_address() {
    $access_ip_address_array = array("202.4.107.210", "180.234.79.190", "103.35.168.22", "27.147.220.17");
    return $access_ip_address_array;
}

function get_new_leave_application_count() {
    $ci = &get_instance();
    $ci->load->model("Leave_application_Model");
    get_time_zone();
    $is_show_status = FALSE;
    $leave_application_by_is_show = $ci->Leave_application_Model->get_leave_application_by_is_show($is_show_status);
    return !empty($leave_application_by_is_show) ? count($leave_application_by_is_show) : 0;
}

function get_employee_image($employee_id) {
    $ci = &get_instance();
    $ci->load->model("Employee_Model");
    $employee = $ci->Employee_Model->get_employee($employee_id);
    return !empty($employee->employee_image) ? base_url($employee->employee_image) : get_default_employee_image();
}

function get_company_logo() {
    $ci = &get_instance();
    $ci->load->model("Company_Model");
    $company = $ci->Company_Model->get_company();
    return !empty($company->company_logo) ? base_url($company->company_logo) : get_default_company_logo();
}

function get_default_employee_image() {
    return $default_employee_image = base_url('assets/uploads/employee_images/no_employee_image.jpg');
}

function get_default_company_logo() {
    return $default_company_logo = base_url('assets/uploads/company_logo/no_company_logo.png');
}

function get_print_r($expression) {
    echo '<pre>';
    print_r($expression);
    echo '</pre>';
    exit;
}
