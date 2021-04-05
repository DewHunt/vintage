<?php

function is_lock_time() {
    $ci = &get_instance();
    $ci->load->model("Lock_time_Model");
    date_default_timezone_set("Asia/Dhaka");
    $current_day_name = date('l');
    $time = date('G:i:s');
    $time = get_minute((string) $time);
    $company_timing = $ci->Lock_time_Model->get_lock_time_by_day_name(strtolower($current_day_name));
    if (empty($company_timing)) {
        return FALSE; // no this is not lock time
    }
    $open_time = date('G:i:s', strtotime($company_timing->start_time));
    $open_time = get_minute((string) $open_time);
    $close_time = date('G:i:s', strtotime($company_timing->end_time));
    $close_time = get_minute((string) $close_time);
    if ($open_time > $close_time) {
        $c_time = date('G:i:s', strtotime('23:59:59'));
        $c_time = get_minute((string) $c_time);
        $o_time = date('G:i:s', strtotime('00:00:00'));
        $o_time = get_minute((string) $o_time);
        if ($time >= $open_time && $time <= $c_time) {
            return TRUE; // yes this is lock time
        }
        if ($time >= $o_time && $time <= $close_time) {
            return TRUE; // yes this is lock time
        }
    } elseif ($time >= $open_time && $time <= $close_time) {
        return TRUE;  // yes this is lock time
    }
    return FALSE; // no this is not lock time
}

/* function is_lock_time() {
  $ci = &get_instance();
  $ci->load->model("Lock_time_Model");
  date_default_timezone_set("Asia/Dhaka");
  $current_day_name = date('l');
  $time = date('G:i:s');
  $time = get_minute($time);
  $shop_timing = $ci->Lock_time_Model->get_lock_time_by_day_name(strtolower($current_day_name));
  if (empty($shop_timing)) {
  return FALSE; // no this is not lock time
  }
  $open_time = date('G:i:s', strtotime($shop_timing->start_time));
  $open_time = get_minute((string) $open_time);
  $close_time = date('G:i:s', strtotime($shop_timing->end_time));
  $close_time = get_minute((string) $close_time);
  if ($time >= $open_time && $time <= $close_time) {
  return TRUE;  // yes this is lock time
  }
  return FALSE; // no this is not lock time
  } */

function get_minute($from_time) {
    $minute = 0;
    $hour = 0;
    $min = 0;
    $hour = (int) ((string) $from_time[0] . (string) $from_time[1]);
    $min = (int) ((string) $from_time[3] . (string) $from_time[4]);
    $minute = $min + ($hour * 60);
    return $minute;
}

function is_lock_user($user_id) {
    $ci = &get_instance();
    $ci->load->model("Lock_user_Model");
    $user = $ci->Lock_user_Model->get_lock_user_by_user_id($user_id);
    if (!empty($user)) {
        return TRUE; // tick
    } else {
        return FALSE; // not tick
    }
}
