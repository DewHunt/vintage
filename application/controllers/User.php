<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Branch_Model');
    }

    public function index() {  // load User details
        if (get_user_permission('user') === false) {
            redirect(base_url('user_login'));
        }
        $user_info = $this->session->userdata('user_session');
        $this->data['title'] = "User";
        $this->data['user_list'] = $this->User_Model->get_user();
        $this->data['employee_list'] = $this->Employee_Model->get_employee();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('user/user_details_list', $this->data);
    }

    public function create_new_user() { // load create new User page
        if (get_user_permission('user') === false) {
            redirect(base_url('user_login'));
        }
        $user_info = $this->session->userdata('user_session');

        $this->data['title'] = "User";
        $this->data['user_type_list'] = $this->get_user_types();
        $this->data['employee_list'] = $this->Employee_Model->get_employee();
        $this->data['outlet_list'] = $this->Branch_Model->get_branch();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('user/create_new_user', $this->data);
    }

    public function save_user() {  // save User information
        if (get_user_permission('user') === false) {
            redirect(base_url('user_login'));
        }
        // echo "<pre>"; print_r($this->input->post()); exit();
        $user_info = $this->session->userdata('user_session');
        $this->data['title'] = 'Create New User';
        //$name = $this->input->post('name');
        $user_name = trim($this->input->post('user_name'));
        $user_type = trim($this->input->post('user_type'));
        //$email = trim($this->input->post('email'));
        //$mobile = trim($this->input->post('mobile'));
        //$address = trim($this->input->post('address'));

        if ($user_type == 'admin' || $user_type == 'hr') {
            $outlet = 'all';
        }
        else {
            $outlet = '';
            if ($this->input->post('outlet')) {
                $outlet = implode(',', $this->input->post('outlet'));
            }
        }

        // print_r($outlet); exit();

        $password_without_encrypt = (trim($this->input->post('password')));
        $confirm_password_without_encrypt = (trim($this->input->post('confirm_password')));
        $password = sha1(trim($this->input->post('password')));
        $confirm_password = sha1(trim($this->input->post('confirm_password')));
        $employee_id = (int) trim($this->input->post('employee_id'));

        $hr_access = !empty(trim($this->input->post('hr_access'))) ? 1 : 0;
        $accounts_access = !empty(trim($this->input->post('accounts_access'))) ? 1 : 0;
        $sales_access = !empty(trim($this->input->post('sales_access'))) ? 1 : 0;
        $settings_access = !empty(trim($this->input->post('settings_access'))) ? 1 : 0;
        $user_access = !empty(trim($this->input->post('user_access'))) ? 1 : 0;
        $accounts_report_access = !empty(trim($this->input->post('accounts_report_access'))) ? 1 : 0;
        $hr_report_access = !empty(trim($this->input->post('hr_report_access'))) ? 1 : 0;
        $sales_report_access = !empty(trim($this->input->post('sales_report_access'))) ? 1 : 0;
        $product_report_access = !empty(trim($this->input->post('product_report_access'))) ? 1 : 0;
        $money_receipt_report_access = !empty(trim($this->input->post('money_receipt_report_access'))) ? 1 : 0;
        $print_access = !empty(trim($this->input->post('print_access'))) ? 1 : 0;
        $product_access = !empty(trim($this->input->post('product_access'))) ? 1 : 0;
        $client_access = !empty(trim($this->input->post('client_access'))) ? 1 : 0;
        $lock_access = !empty(trim($this->input->post('lock_access'))) ? 1 : 0;
        $edit_mr_access = !empty(trim($this->input->post('edit_mr_access'))) ? 1 : 0;
        $edit_invoice_access = !empty(trim($this->input->post('edit_invoice_access'))) ? 1 : 0;
        $order_sheet_access = !empty(trim($this->input->post('order_sheet_access'))) ? 1 : 0;
        $kitchen_room_access = !empty(trim($this->input->post('kitchen_room_access'))) ? 1 : 0;
        $invoice_discount_access = !empty(trim($this->input->post('invoice_discount_access'))) ? 1 : 0;

        $employee_list = $this->Employee_Model->get_employee();
        $this->data['employee_list'] = $employee_list;

        $user_name_exist_result = $this->User_Model->get_user_name_exist($user_name);
        //$email_exist_result = $this->User_Model->get_email_exist($email);
        $user_by_employee_id = $this->User_Model->get_user_by_employee_id($employee_id);

        if (empty($user_name)) {
            $this->session->set_flashdata('user_name_error_message', 'Please Enter User Name');
            redirect('user/create_new_user');
        }

        if ($employee_id <= 0) {
            $this->session->set_flashdata('employee_id_error_message', 'Please Select Employee');
            redirect('user/create_new_user');
        }

        if (!empty($user_by_employee_id)) {
            $this->session->set_flashdata('employee_id_exists_error_message', 'This Employee Already Assigned');
            redirect('user/create_new_user');
        }

        $employee_information = $this->Employee_Model->get_employee($employee_id);

        $user_info_data = array(
            'name' => $employee_information->employee_name,
            'user_name' => $user_name,
            'password' => $password,
            'user_type' => $user_type,
            'outlet' => $outlet,
            'email' => $employee_information->employee_email,
            'mobile' => $employee_information->mobile,
            'address' => $employee_information->address,
            'employee_id' => $employee_id,
            'hr_access' => $hr_access,
            'accounts_access' => $accounts_access,
            'sales_access' => $sales_access,
            'settings_access' => $settings_access,
            'user_access' => $user_access,
            'accounts_report_access' => $accounts_report_access,
            'hr_report_access' => $hr_report_access,
            'sales_report_access' => $sales_report_access,
            'product_report_access' => $product_report_access,
            'money_receipt_report_access' => $money_receipt_report_access,
            'print_access' => $print_access,
            'product_access' => $product_access,
            'client_access' => $client_access,
            'lock_access' => $lock_access,
            'edit_mr_access' => $edit_mr_access,
            'edit_invoice_access' => $edit_invoice_access,
            'order_sheet_access' => $order_sheet_access,
            'kitchen_room_access' => $kitchen_room_access,
            'invoice_discount_access' => $invoice_discount_access,
        );

        $this->form_validation->set_rules('user_name', 'User name', 'required');
        $this->form_validation->set_rules('user_type', 'User Type', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('employee_id', 'Employee', 'required');

        if ($this->form_validation->run() === FALSE) {
            $user_type_list = $this->get_user_types();
            $this->data['user_type_list'] = $user_type_list;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('user/create_new_user', $this->data);
        }

        if (trim($password) != trim($confirm_password)) {
            $this->session->set_flashdata('password_confirm_error_message', 'Password Does Not Match');
            redirect(base_url('user/create_new_user'));
        }

        if (strtolower($password_without_encrypt) == strtolower($confirm_password_without_encrypt)) {
            if (strlen($password_without_encrypt) < 5) {
                $this->session->set_flashdata('password_confirm_error_message', 'Your password must be at least 5 characters long');
                redirect(base_url('user/create_new_user'));
            }
        }

        if (!empty($user_name_exist_result)) {
            $this->session->set_flashdata('user_name_error_message', 'User Name Already Exists');
            redirect(base_url('user/create_new_user'));
        }

        if (empty($user_type) || ($user_type == '')) {
            $this->session->set_flashdata('user_type_error_message', 'Please Select User Type');
            redirect(base_url('user/create_new_user'));
        }

        if ((trim($password) == trim($confirm_password)) && (!empty($user_type)) && (empty($user_name_exist_result)) && (empty($email_exist_result)) && ($this->form_validation->run() === TRUE)) {
            $this->User_Model->db->insert('user_info', $user_info_data);
            redirect(base_url('user'));
        }
    }

    public function update_user($id = 0) {  // load update User information page
        if (get_user_permission('user') === false) {
            redirect(base_url('user_login'));
        }
        $user_info = $this->session->userdata('user_session');

        $user = $this->User_Model->get_user($id);
        if (!empty($user)) {
            $this->data['title'] = "Update User";
            $this->data['user_type_list'] = $this->get_user_types();
            $this->data['employee_list'] = $this->Employee_Model->get_employee();
            $this->data['outlet_list'] = $this->Branch_Model->get_branch();
            $employee_information = $this->Employee_Model->get_employee($user->employee_id);
            $this->data['employee_information'] = $employee_information;
            $this->data['user'] = $user;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('user/update_user', $this->data);
        } else {
            redirect(base_url('user'));
        }
    }

    public function update() {  // update User
        if (get_user_permission('user') === false) {
            redirect(base_url('user_login'));
        }
        $user_info = $this->session->userdata('user_session');
        $this->data['title'] = 'Update User';
        $id = trim($this->input->post('id'));
        //$name = trim($this->input->post('name'));
        $user_name = trim($this->input->post('user_name'));
        $user_type = trim($this->input->post('user_type'));

        if ($user_type == 'admin' || $user_type == 'hr') {
            $outlet = 'all';
        }
        else {
            if ($this->input->post('outlet')) {
                $outlet = implode(',', $this->input->post('outlet'));
            }
            else {
                $outlet = '';
            }
        }

        //$email = trim($this->input->post('email'));
        //$mobile = trim($this->input->post('mobile'));
        //$address = trim($this->input->post('address'));
        $password = (trim($this->input->post('password')));
        $confirm_password = (trim($this->input->post('confirm_password')));
        $employee_id = (int) trim($this->input->post('employee_id'));

        $hr_access = !empty(trim($this->input->post('hr_access'))) ? 1 : 0;
        $accounts_access = !empty(trim($this->input->post('accounts_access'))) ? 1 : 0;
        $sales_access = !empty(trim($this->input->post('sales_access'))) ? 1 : 0;
        $settings_access = !empty(trim($this->input->post('settings_access'))) ? 1 : 0;
        $user_access = !empty(trim($this->input->post('user_access'))) ? 1 : 0;
        $accounts_report_access = !empty(trim($this->input->post('accounts_report_access'))) ? 1 : 0;
        $hr_report_access = !empty(trim($this->input->post('hr_report_access'))) ? 1 : 0;
        $sales_report_access = !empty(trim($this->input->post('sales_report_access'))) ? 1 : 0;
        $product_report_access = !empty(trim($this->input->post('product_report_access'))) ? 1 : 0;
        $money_receipt_report_access = !empty(trim($this->input->post('money_receipt_report_access'))) ? 1 : 0;
        $print_access = !empty(trim($this->input->post('print_access'))) ? 1 : 0;
        $product_access = !empty(trim($this->input->post('product_access'))) ? 1 : 0;
        $client_access = !empty(trim($this->input->post('client_access'))) ? 1 : 0;
        $lock_access = !empty(trim($this->input->post('lock_access'))) ? 1 : 0;
        $edit_mr_access = !empty(trim($this->input->post('edit_mr_access'))) ? 1 : 0;
        $edit_invoice_access = !empty(trim($this->input->post('edit_invoice_access'))) ? 1 : 0;
        $order_sheet_access = !empty(trim($this->input->post('order_sheet_access'))) ? 1 : 0;
        $kitchen_room_access = !empty(trim($this->input->post('kitchen_room_access'))) ? 1 : 0;
        $invoice_discount_access = !empty(trim($this->input->post('invoice_discount_access'))) ? 1 : 0;

        $employee_list = $this->Employee_Model->get_employee();
        $this->data['employee_list'] = $employee_list;

        $user = $this->User_Model->get_user($id);
        $this->data['user'] = $user;
        $user_type_list = $this->get_user_types();
        $this->data['user_type_list'] = $user_type_list;

        $user_name_exist_result = $this->User_Model->check_user_name_exist_for_update($user_name, $id);

        $user_by_employee_id = $this->User_Model->employee_id_exists_check_for_update($employee_id, $id);

        if (empty($user_name)) {
            $this->session->set_flashdata('user_name_error_message', 'Please Enter User Name');
            redirect(base_url('user/update_user/' . $id));
        }

        if ($employee_id <= 0) {
            $this->session->set_flashdata('employee_id_error_message', 'Please Select Employee');
            redirect(base_url('user/update_user/' . $id));
        }

        if (!empty($user_by_employee_id)) {
            $this->session->set_flashdata('employee_id_exists_error_message', 'This Employee Already Assigned');
            redirect(base_url('user/update_user/' . $id));
        }

        $employee_information = $this->Employee_Model->get_employee($employee_id);
        $user_info_data = array(
            'id' => $id,
            'name' => $employee_information->employee_name,
            'user_name' => $user->user_name,
//                'password' => $password,
            'user_type' => $user_type,
            'outlet' => $outlet,
            'email' => $employee_information->employee_email,
            'mobile' => $employee_information->mobile,
            'address' => $employee_information->address,
            'employee_id' => $employee_id,
            'hr_access' => $hr_access,
            'accounts_access' => $accounts_access,
            'sales_access' => $sales_access,
            'settings_access' => $settings_access,
            'user_access' => $user_access,
            'accounts_report_access' => $accounts_report_access,
            'hr_report_access' => $hr_report_access,
            'sales_report_access' => $sales_report_access,
            'product_report_access' => $product_report_access,
            'money_receipt_report_access' => $money_receipt_report_access,
            'print_access' => $print_access,
            'product_access' => $product_access,
            'client_access' => $client_access,
            'lock_access' => $lock_access,
            'edit_mr_access' => $edit_mr_access,
            'edit_invoice_access' => $edit_invoice_access,
            'order_sheet_access' => $order_sheet_access,
            'kitchen_room_access' => $kitchen_room_access,
            'invoice_discount_access' => $invoice_discount_access,
        );

        $this->form_validation->set_rules('user_name', 'User name', 'required');

        if ($this->form_validation->run() === FALSE) {
            redirect(base_url('user/update_user/' . $id));
        }
        if (!empty($user_name_exist_result)) {
            $this->session->set_flashdata('user_name_error_message', 'User Name Already Exists');
            redirect(base_url('user/update_user/' . $id));
        }

        if (empty($user_type) || ($user_type == '')) {
            $this->session->set_flashdata('user_type_error_message', 'Please Select User Type');
            redirect(base_url('user/update_user/' . $id));
        }

        if ((!empty($user_type)) && (empty($user_name_exist_result)) && ($this->form_validation->run() === TRUE)) {
            $this->db->where('id', $user_info_data['id']);
            $this->User_Model->db->update('user_info', $user_info_data);
            //$this->session->set_flashdata('update_successful_message', 'Information has been Updated Successfully');
            redirect(base_url('user'));
        }
    }

    public function permission($id)
    {
        if (get_user_permission('user') === false) {
            redirect(base_url('user_login'));
        }
        $user_info = $this->session->userdata('user_session');

        $this->data['title'] = "User Permission";
        $this->data['user_info'] = $this->User_Model->get_user($id);
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('user/menu_permission', $this->data);
    }

    public function update_permisssion()
    {
        if (get_user_permission('user') === false) {
            redirect(base_url('user_login'));
        }
        // echo "<pre>"; print_r($this->input->post()); exit();

        $user_id = $this->input->post('user_id');

        if ($this->input->post('usermenu') == "") {
            $user_menus = NULL;
        } else {
            $user_menus = implode(',',$this->input->post('usermenu'));
        }

        $data = array(
            'menu_permission' => $user_menus,
        );

        $this->db->where('id',$user_id);
        $this->db->update('user_info', $data);
        $this->session->set_flashdata('message', 'User Menu Permission Updated Successfully.');
        redirect(base_url('user'));
    }

    public function user_password_change($id = 0) {  // load update User password page
        if (get_user_permission('user') === false) {
            redirect(base_url('user_login'));
        }
        $user = $this->User_Model->get_user(intval($id));
        // echo "<pre>"; print_r($user); exit();
        if (!empty($user)) {
            $this->data['title'] = "Update User Password";
            $this->data['user_type_list'] = $this->get_user_types();
            $this->data['user'] = $user;
            $employee_information = $this->Employee_Model->get_employee($user->employee_id);
            $this->data['employee_information'] = $employee_information;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('user/update_user_password', $this->data);
        } else {
            redirect(base_url('user'));
        }
    }

    public function update_password() {  // update My Profile Information
        if (get_user_permission('user') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = 'Update User Password';
        $user_id = intval(trim($this->input->post('id')));
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
        redirect(base_url('user/user_password_change/'.$user_id));
    }

    public function delete($id) {
        if (get_user_permission('user') === false) {
            redirect(base_url('user_login'));
        }
        if (intval($id) > 0) {
            $user = $this->User_Model->get_user($id);
            if (!empty($user)) {
                $this->User_Model->delete($id);
            }
        }
        redirect(base_url('user'));
    }

    public function get_user_types() {
        $user_type_list = $this->db->query("SELECT * FROM user_type WHERE status = 1")->result();
        return $user_type_list;
    }

}
