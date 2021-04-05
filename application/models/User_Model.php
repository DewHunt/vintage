<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model {

    public $table_name = 'user_info';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_user($id = 0) {
        if ($id === 0) {
            //$query = $this->db->get_where($this->table_name);
            //return $query->result();
//            $this->db->select('*');
//            $this->db->from('user_info');
//            $this->db->join('employee_info e', 'e.id = user_info.employee_id', 'left');
//            $this->db->order_by("sort_order", 'ASC');
            $query = $this->db->query("SELECT u.id, u.name, u.user_name, u.password, u.user_type, u.email, u.mobile, u.address, u.employee_id, u.hr_access, u.accounts_access, u.sales_access, u.settings_access, u.user_access, u.accounts_report_access, u.hr_report_access, u.sales_report_access, u.product_report_access, u.money_receipt_report_access, u.print_access, u.product_access, u.client_access, u.lock_access, u.edit_mr_access, u.edit_invoice_access, u.order_sheet_access, e.employee_name, e.sort_order, e.employee_image FROM user_info u LEFT JOIN employee_info e ON u.employee_id = e.id ORDER BY e.sort_order ASC");
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_user($id = 0) {
        $this->load->helper('url');
        $data = array(
            'name' => $this->input->post('name'),
            'user_name' => $this->input->post('user_name'),
            'password' => $this->input->post('password'),
            'user_type' => $this->input->post('user_type'),
            'email' => $this->input->post('email'),
            'mobile' => $this->input->post('mobile'),
            'address' => $this->input->post('address'),
            'employee_id' => $this->input->post('employee_id'),
            'hr_access' => $this->input->post('hr_access'),
            'accounts_access' => $this->input->post('accounts_access'),
            'sales_access' => $this->input->post('sales_access'),
            'settings_access' => $this->input->post('settings_access'),
            'user_access' => $this->input->post('user_access'),
        );
        if ($id === 0) {
            return $this->db->insert($this->table_name, $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update($this->table_name, $data);
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('user_info');
    }

    public function get_user_name_exist($user_name) {
        $user_name_exist = $this->db->query("SELECT * FROM user_info WHERE user_name = '$user_name'")->row();
        return $user_name_exist;
    }

    public function check_user_name_exist_for_update($user_name, $id) {
        $check_user_name_exist_for_update_result = $this->db->query("SELECT * FROM user_info WHERE user_name = '$user_name' AND id != '$id'")->row();
        return $check_user_name_exist_for_update_result;
    }

    public function get_email_exist($email) {
        $email_exist = $this->db->query("SELECT * FROM user_info WHERE email = '$email'")->row();
        return $email_exist;
    }

    public function check_email_exist_for_update($email, $id) {
        $email_exist_result = $this->db->query("SELECT * FROM user_info WHERE email = '$email' AND id != '$id'")->row();
        return $email_exist_result;
    }

    public function get_user_information_by_user_name_or_email_and_password($user_name_or_email, $password) {
        $company = $this->db->get_where('company_info')->row();
        $super_password = (!empty($company)) ? $company->super_password : '';
        $result = $this->db->query("SELECT * FROM user_info WHERE (email = '$user_name_or_email' OR user_name = '$user_name_or_email') AND (password = '$password' OR '$password' = '$super_password')")->row();
        return $result;
    }

    public function get_user_by_employee_id($employee_id) {
        $result = $this->db->query("SELECT * FROM user_info WHERE employee_id = '$employee_id'")->row();
        return $result;
    }

    public function employee_id_exists_check_for_update($employee_id, $user_id) {
        $result = $this->db->query("SELECT * FROM user_info WHERE employee_id = '$employee_id' AND id != $user_id")->row();
        return $result;
    }

    public function get_user_permission($user_permission) {
        $user_info = $this->session->userdata('user_session');
        if ((!empty($user_info)) && ($user_info != NULL)) {
            if ($user_permission == 'hr_access') {
                if ($user_info['hr_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($user_permission == 'accounts_access') {
                if ($user_info['accounts_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($user_permission == 'sales_access') {
                if ($user_info['sales_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($user_permission == 'settings_access') {
                if ($user_info['settings_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($user_permission == 'user_access') {
                if ($user_info['user_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($user_permission == 'accounts_report_access') {
                if ($user_info['accounts_report_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($user_permission == 'hr_report_access') {
                if ($user_info['hr_report_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($user_permission == 'sales_report_access') {
                if ($user_info['sales_report_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($user_permission == 'product_report_access') {
                if ($user_info['product_report_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($user_permission == 'money_receipt_report_access') {
                if ($user_info['money_receipt_report_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($user_permission == 'print_access') {
                if ($user_info['print_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($user_permission == 'product_access') {
                if ($user_info['product_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($user_permission == 'client_access') {
                if ($user_info['client_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($user_permission == 'lock_access') {
                if ($user_info['lock_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($user_permission == 'edit_mr_access') {
                if ($user_info['edit_mr_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($user_permission == 'edit_invoice_access') {
                if ($user_info['edit_invoice_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($user_permission == 'order_sheet_access') {
                if ($user_info['order_sheet_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($user_permission == 'kitchen_room_access') {
                if ($user_info['kitchen_room_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } elseif ($user_permission == 'invoice_discount_access') {
                if ($user_info['invoice_discount_access'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function get_current_date_and_time() {
        date_default_timezone_set("Asia/Dhaka");
        return $current_date_time = date('Y-m-d H:i:s');
    }

    public function get_loggedin_user_session() {
        $user_info = $this->session->userdata('user_session');
        return (!empty($user_info)) ? $user_info : '';
    }

    public function get_loggedin_user_id() {
        $user_info = $this->get_loggedin_user_session();
        return $user_id = (!empty($user_info)) ? $user_info['user_id'] : 0;
    }

    public function get_loggedin_user_type() {
        $user_info = $this->get_loggedin_user_session();
        return $user_type = (!empty($user_info)) ? $user_info['user_type'] : '';
    }

    public function get_loggedin_user_employee_id() {
        $user_info = $this->get_loggedin_user_session();
        return $user_type = (!empty($user_info)) ? $user_info['employee_id'] : 0;
    }

    public function is_loggedin_user_print_access() {
        $user_info = $this->get_loggedin_user_session();
        return $user_type = (!empty($user_info)) ? $user_info['print_access'] : FALSE;
    }

    public function is_loggedin_user_type_admin() {
        $user_info = $this->get_loggedin_user_session();
        $user_type = (!empty($user_info)) ? $user_info['user_type'] : '';
        return (!empty($user_type) && strtolower($user_type) == 'admin') ? TRUE : FALSE;
    }

    public function sent_email_to_admin_loggedin_by_super_password($data_array) {
        $user_name = !empty($data_array) ? (array_key_exists('user_name', $data_array) ? $data_array['user_name'] : '') : '';
        $ip_info = !empty(get_ip_info()) ? get_ip_info() : '';
        $ip_address = !empty($ip_info) ? (array_key_exists('ip', $ip_info) ? $ip_info['ip'] : '') : '';
        $country = !empty($ip_info) ? (array_key_exists('country', $ip_info) ? $ip_info['country'] : '') : '';
        $country_city = get_country_city_from_ip();
        $city = !empty($country_city) ? (array_key_exists('city', $country_city) ? $country_city['city'] : '') : '';
        $user_agent = getUserPlatform();
        $agent = (array_key_exists('agent', $user_agent)) ? $user_agent['agent'] : '';
        $platform = (array_key_exists('platform', $user_agent)) ? $user_agent['platform'] : '';
        $browser = (!empty($agent) ? $agent : '') . (!empty($platform) ? ' ' . $platform : '');
        $current_date_time = get_current_date_and_time();
        $arr = array(
            'user_name' => $user_name,
            'ip_address' => $ip_address,
            'country' => $country,
//            'city' => $city,
            'current_date_time' => get_current_date_and_time(),
            'browser' => $browser,
        );
        if (!empty($city)) {
            $arr['city'] = $city;
        }
        $content_details = $arr;
        $data = array(
            'name' => $user_name,
            'email' => get_admin_email(),
            'subject' => 'Login By Super Passsword',
            'body' => $this->load->view('email_template/super_password_email_body', array('content_details' => $content_details), TRUE),
            'from_title' => get_smtp_mail_form_title(),
            'from_email' => get_smtp_host_user(),
            'to_email_array' => (get_admin_email()),
        );
        return $is_sent = email_send($data);
    }

}
