<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_login extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->helper('lock_helper');
        $this->load->model('User_Model');
        $this->load->model('Login_log_details_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Lock_time_Model');
        $this->load->model('Lock_user_Model');
        $this->load->model('Block_ip_Model');
        $this->load->model('Company_Model');
    }

    public function index() {
        //if (!is_valid_user_check_by_user_country()) {
            //header('HTTP/1.0 401 Unauthorized');
        //} else {
            $block_ip_by_ip_address = $this->Block_ip_Model->is_ip_block(get_user_ip_address());
            if (!$block_ip_by_ip_address) {
                if (!empty($this->session->userdata('user_session'))) {
                    redirect(base_url());
                } else {
                    $this->data['title'] = "User Login";
                    $this->load->view('header');
                    $this->load->view('user/user_login');
                }
            } else {
                header('HTTP/1.0 401 Unauthorized');
            }
        //}
    }

    public function login_action() {
    //  Biswajit
        $user_name_or_email = trim($this->input->post('user_name_or_email'));
        $password = sha1(trim($this->input->post('password')));
   /*     if(strtolower($user_name_or_email) != 'admin' && strtolower($user_name_or_email) != 'biswajit' ){
         echo $msg = "<div style='color: red; font-size: 30px; text-align: center; margin-top: 10%;'>Now Time to Year Closing. Please try to login after some hours later.</div>";
         exit;
         }
      */
        $user_information = $this->User_Model->get_user_information_by_user_name_or_email_and_password($user_name_or_email, $password);
        if (!empty($user_information)) {
            $employee = $this->Employee_Model->get_employee($user_information->employee_id);
            if (!empty($employee) && (int) $employee->deactivate_employee <= 0) { // not a deactive employee
                if ((!is_lock_time()) || (!is_lock_user($user_information->id))) {
                    if (!empty($this->session->userdata('user_session'))) {
                        $this->session->unset_userdata('user_session');
                    }
                    $employee_image = '';
                    $employee = $this->Employee_Model->get_employee($user_information->employee_id);
                    if (!empty($employee->employee_image) || $employee->employee_image != NULL) {
                        $employee_image = base_url($employee->employee_image);
                    } else {
                        $employee_image = base_url('assets/uploads/employee_images/no_employee_image.jpg');
                    }
                    $user_information_data = array(
                        'user_id' => $user_information->id,
                        'name' => $user_information->name,
                        'user_name' => $user_information->user_name,
                        'user_type' => $user_information->user_type,
                        'outlet' => explode(',', $user_information->outlet),
                        'user_email' => $user_information->email,
                        'user_mobile' => $user_information->mobile,
                        'is_loggedIn' => true,
                        'employee_id' => $user_information->employee_id,
                        'hr_access' => $user_information->hr_access,
                        'accounts_access' => $user_information->accounts_access,
                        'sales_access' => $user_information->sales_access,
                        'settings_access' => $user_information->settings_access,
                        'user_access' => $user_information->user_access,
                        'accounts_report_access' => $user_information->accounts_report_access,
                        'hr_report_access' => $user_information->hr_report_access,
                        'sales_report_access' => $user_information->sales_report_access,
                        'product_report_access' => $user_information->product_report_access,
                        'money_receipt_report_access' => $user_information->money_receipt_report_access,
                        'print_access' => $user_information->print_access,
                        'product_access' => $user_information->product_access,
                        'client_access' => $user_information->client_access,
                        'lock_access' => $user_information->lock_access,
                        'edit_mr_access' => $user_information->edit_mr_access,
                        'edit_invoice_access' => $user_information->edit_invoice_access,
                        'order_sheet_access' => $user_information->order_sheet_access,
                        'kitchen_room_access' => $user_information->kitchen_room_access,
                        'invoice_discount_access' => $user_information->invoice_discount_access,
                        'employee_image' => $employee_image,
                    );
                    $this->session->set_userdata('user_session', $user_information_data);
                    $user_info = $this->session->userdata('user_session');
                    $current_date_time = $this->get_current_date_time();
                    $user_id = $user_info['user_id']; // session user id
                    $user_name = $user_info['user_name']; // session user id
                    $this->login_log_details_save($current_date_time, '', $user_id, $user_name);
                    $this->get_count_of_login_attempt_session_clear();
                    $is_super_password = $this->Company_Model->is_super_password($password);
                    if ($is_super_password) {
                        $this->User_Model->sent_email_to_admin_loggedin_by_super_password($user_information_data);
                    }
                    redirect(base_url());
                } else {
                    $this->session->set_flashdata('login_error_message', 'Business is now closed');
                    redirect(base_url('user_login'));
                }
            } else {
                $this->session->set_flashdata('login_error_message', 'Please Check User Name Or Password');
                redirect(base_url('user_login'));
            }
        } else {
            $this->data['title'] = "User Login";
            $current_date_time = $this->get_current_date_time();
            $this->login_log_details_save($current_date_time, '', 0, $user_name_or_email);
            $currently_inserted_login_log_details_id = $this->db->insert_id();
            $count_of_login_attempt = (int) $this->get_count_of_login_attempt();
            if (!empty($count_of_login_attempt) && (int) $count_of_login_attempt > 3) {
                if (!is_valid_user_ip()) {
                    $this->block_ip_information_save($currently_inserted_login_log_details_id);
                }
            }
            $this->session->set_flashdata('login_error_message', 'Please Check User Name Or Password');
            redirect(base_url('user_login'));
        }
    }

    public function block_ip_information_save($currently_inserted_login_log_details_id) {
        $ip_info = get_ip_info();
        $block_ip_data = array(
            'ip_address' => get_user_ip_address(),
            'login_log_details_id' => $currently_inserted_login_log_details_id,
            'city' => $ip_info['city'],
            'state' => $ip_info['state'],
            'country' => $ip_info['country'],
            'country_code' => $ip_info['country_code'],
            'continent' => $ip_info['continent'],
            'continent_code' => $ip_info['continent_code'],
            'latitude' => $ip_info['latitude'],
            'longitude' => $ip_info['longitude'],
            'current_date_time' => get_current_date_and_time(),
        );
        $this->Block_ip_Model->db->insert('block_ip', $block_ip_data);
    }

    public function login_log_details_save($login_time, $logout_time, $user_id, $user_name_or_email) {
        $login_log_details_data = array(
            'login_time' => $login_time,
            'logout_time' => $logout_time,
            'user_id' => $user_id,
            'user_name_or_email' => $user_name_or_email,
            'ip_address' => get_user_ip_address(),
        );
        $this->Login_log_details_Model->db->insert('login_log_details', $login_log_details_data);
    }

    public function get_current_date_time() {
        $date_time_now = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $current_date_time = $date_time_now->format("Y-m-d H:i:s");
        return $current_date_time;
    }

    public function logout() {
        if (!empty($this->session->userdata('user_session'))) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $user_name = $user_info['user_name']; // session user id
            $current_date_time = $this->get_current_date_time();
            $this->login_log_details_save('', $current_date_time, $user_id, $user_name);
            $this->session->sess_destroy();
            //$this->get_all_session_clear();
            redirect(base_url('user_login'));
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_all_session_clear() {
        $this->session->unset_userdata('user_session');
        $this->session->unset_userdata('product_total_price');
        $this->session->unset_userdata('products');
        $this->session->unset_userdata('assign_assets');
        $this->session->unset_userdata('voucher_info');
        $this->session->unset_userdata('voucher_debit_amount');
        $this->session->unset_userdata('voucher_credit_amount');
        $this->session->unset_userdata('month_name_session');
        $this->session->unset_userdata('year_session');
    }

    public function update_my_profile($id = 0) {  // load update User information page
        if (!empty($this->session->userdata('user_session'))) {
            $user_session = $this->session->userdata('user_session');
            $id = $user_session['user_id'];
            $user = $this->User_Model->get_user($id);
            if (!empty($user)) {
                $this->data['title'] = "Update My Profile";
                $user_type_list = $this->get_user_types();
                $this->data['user_type_list'] = $user_type_list;
                $this->data['user'] = $user;
                $employee_information = $this->Employee_Model->get_employee($user->employee_id);
                $this->data['employee_information'] = $employee_information;
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('user/update_my_profile', $this->data);
            } else {
                redirect(base_url('user'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update() {  // update My Profile Information
        if (!empty($this->session->userdata('user_session'))) {
            $this->data['title'] = 'Update User';
//            $id = trim($this->input->post('id'));
            $user_session = $this->session->userdata('user_session');
            $id = $user_session['user_id'];
//            $employee_id = trim($this->input->post('employee_id'));
            $employee_id = $user_session['employee_id'];
            $employee = $this->Employee_Model->get_employee($employee_id);
            $name = trim($this->input->post('name'));
            $user_name = trim($this->input->post('user_name'));
            $user_type = trim($this->input->post('user_type'));
            $email = trim($this->input->post('email'));
            $mobile = trim($this->input->post('mobile'));
            $address = trim($this->input->post('address'));
            $user = $this->User_Model->get_user($id);
            $this->data['user'] = $user;
            $user_type_list = $this->get_user_types();
            $this->data['user_type_list'] = $user_type_list;

            if (empty($name)) {
                $this->session->set_flashdata('name_error_message', 'Please Input Name');
                redirect(base_url('user_login/update_my_profile'));
            }

            if (empty($user_name)) {
                $this->session->set_flashdata('user_name_error_message', 'Please Input User Name');
                redirect(base_url('user_login/update_my_profile'));
            }

            $user_name_exist_result = $this->User_Model->check_user_name_exist_for_update($user_name, $id);
            if (!empty($user_name_exist_result)) {
                $this->session->set_flashdata('user_name_error_message', 'User Name Already Exists');
                redirect(base_url('user_login/update_my_profile'));
            }

            if (empty($user_type) || $user_type == '') {
                $this->session->set_flashdata('user_type_error_message', 'Please Select User Type');
                redirect(base_url('user_login/update_my_profile'));
            }

            if (empty($email)) {
                $this->session->set_flashdata('email_error_message', 'Please Input Email');
                redirect(base_url('user_login/update_my_profile'));
            }

            $email_exist_result = $this->User_Model->check_email_exist_for_update($email, $id);
            if (!empty($email_exist_result)) {
                $this->session->set_flashdata('email_error_message', 'Email Already Exists');
                redirect(base_url('user_login/update_my_profile'));
            }

            if (empty($mobile)) {
                $this->session->set_flashdata('mobile_error_message', 'Please Input Mobile Number');
                redirect(base_url('user_login/update_my_profile'));
            }

            if (empty($address)) {
                $this->session->set_flashdata('address_error_message', 'Please Input Address');
                redirect(base_url('user_login/update_my_profile'));
            }
            if ((!empty($user_type)) && (empty($user_name_exist_result)) && (empty($email_exist_result) || $email_exist_result == NULL)) {
                $path = '';
                $default_image_path = '';
                $new_name = $_FILES["image"]['name'];
                $size = $_FILES["image"]["size"];
                if (!empty($new_name)) {
                    $config['file_name'] = $new_name;
                    $config['upload_path'] = './assets/uploads/employee_images/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = 100;
                    $this->load->library('upload', $config);
                    if ((int) $size > (100 * 1024)) {
                        $this->session->set_flashdata('image_upload_error_message', 'Image size can not be more than 100 kb');
                        redirect(base_url('user_login/update_my_profile'));
                    }
                    if ((!empty($employee->employee_image)) || ($employee->employee_image != NULL)) {
                        $this->delete_uploaded_image($employee->employee_image);
                    }
                    $is_upload = $this->upload->do_upload('image');
                    $d = array('upload_data' => $this->upload->data());
                    $error = array('error' => $this->upload->display_errors());
                    $d = array('upload_data' => $this->upload->data());
                    if (!empty($new_name)) {
                        $path = 'assets/uploads/employee_images/' . $d['upload_data']['file_name'];
                    }
                }
                $employee_image = !empty($path) ? $path : $employee->employee_image;
                $this->update_employee_information($employee_id, $name, $email, $mobile, $address, $employee_image);
                $employee = $this->Employee_Model->get_employee($employee_id);
                $data = array(
                    'id' => $id,
//                    'name' => $name,
                    'user_name' => $user_session['user_name'],
//                    'password' => $password,
                    'user_type' => $user_session['user_type'],
                    'email' => $email,
                    'mobile' => $mobile,
                    'address' => $address,
                    'employee_id' => $employee_id,
                );

                $this->db->where('id', $data['id']);
                $this->User_Model->db->update('user_info', $data);
                $this->session->set_flashdata('update_successful_message', 'Information has been Updated Successfully');
                redirect(base_url('user_login/update_my_profile'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function password_change() {  // load update User password page
        if (!empty($this->session->userdata('user_session'))) {
            $user_id = $this->User_Model->get_loggedin_user_id();
            $user = $this->User_Model->get_user($user_id);
            if (!empty($user)) {
                $this->data['title'] = "Update User Password";
                $this->data['user_type_list'] = $this->get_user_types();
                $this->data['user'] = $user;
                $employee_information = $this->Employee_Model->get_employee($user->employee_id);
                $this->data['employee_information'] = $employee_information;
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('user/update_my_password', $this->data);
            } else {
                redirect(base_url('user'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update_password() {  // update My Profile Information
        if (!empty($this->session->userdata('user_session'))) {
            $this->data['title'] = 'Update User Password';
            $user_id = $this->User_Model->get_loggedin_user_id();
            $password = (trim($this->input->post('password')));
            $confirm_password = (trim($this->input->post('confirm_password')));
            $user = $this->User_Model->get_user($user_id);
            if (!empty($user) && (trim($password) == trim($confirm_password))) {
                if (strlen($password) < 5) {
                    $this->session->set_flashdata('password_confirm_error_message', 'Your password must be at least 5 characters long');
                } else {
                    $data = array(
                        'id' => $user_id,
                        'password' => sha1($password),
                    );
                    $this->db->where('id', $data['id']);
                    $this->User_Model->db->update('user_info', $data);
                    $this->session->set_flashdata('update_successful_message', 'Information has been Updated Successfully');
                }
            } else {
                $this->session->set_flashdata('password_confirm_error_message', 'Password Does not Match');
            }
            redirect(base_url('user_login/password_change'));
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function delete_uploaded_image($employee_image) {
        unlink(($employee_image));
    }

    public function update_employee_information($employee_id, $name, $email, $mobile, $address, $employee_image) {
        $employee = $this->Employee_Model->get_employee($employee_id);
        $employee_data = array(
            'id' => $employee_id,
//            'employee_name' => $name,
            'employee_email' => $email,
            'mobile' => $mobile,
            'address' => $address,
            'employee_image' => $employee_image,
        );
        $this->db->where('id', $employee_data['id']);
        $this->Employee_Model->db->update('employee_info', $employee_data);
    }

    public function get_user_types() {
        $user_type_list = $this->db->query("SELECT * FROM user_type;")->result();
        return $user_type_list;
    }

    public function get_count_of_login_attempt() {
        if (!empty($this->session->userdata('login_attempt'))) {
            $count = ((int) $this->session->userdata('login_attempt')) + 1;
            $this->session->set_userdata('login_attempt', $count);
        } else {
            $count = 1;
            $this->session->set_userdata('login_attempt', $count);
        }
        return $this->session->userdata('login_attempt');
    }

    public function get_count_of_login_attempt_session_clear() {
        if (!empty($this->session->userdata('login_attempt'))) {
            $this->session->unset_userdata('login_attempt');
        }
    }

}
