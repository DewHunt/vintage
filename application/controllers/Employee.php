<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->helper('file');
        $this->load->model('Employee_Model');
        $this->load->model('Employee_total_leave_Model');
        $this->load->model('User_Model');
        $this->load->model('Loan_Model');
        $this->load->model('Pf_funds_Model');
        $this->load->model('Pf_funds_details_Model');
        $this->load->model('Employee_target_Model');
    }

    public function index() {  // load Employee details
        if (get_user_permission('employee') === false) {
            redirect(base_url('user_login'));
        }
        $user_info = $this->session->userdata('user_session');
        $this->data['title'] = "Employee";
        $this->data['employee_list'] = $this->Employee_Model->get_employee();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('employee/employee_details_list', $this->data);
    }

    public function create_new_employee() { // load create new employee page
        if (get_user_permission('employee') === false) {
            redirect(base_url('user_login'));
        }
        $user_info = $this->session->userdata('user_session');
        $this->data['title'] = "Employee";
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('employee/create_new_employee');
    }

    public function save_employee() {  // save employee information
        if (get_user_permission('employee') === false) {
            redirect(base_url('user_login'));
        }
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id']; // session user id
        $this->data['title'] = 'Create New Employee';
        $joining_date = trim($this->input->post('joining_date'));
        $year = date("Y", strtotime($joining_date));  //get year from joining date
        $casual_leave = trim($this->input->post('casual_leave'));
        $medical_leave = trim($this->input->post('medical_leave'));
        $earn_leave = trim($this->input->post('earn_leave'));
        $is_loan = trim($this->input->post('is_loan'));
        $deactivate_employee = trim($this->input->post('deactivate_employee'));
        $sort_order = trim($this->input->post('sort_order'));
        $blood_group = trim($this->input->post('blood_group'));
        $same_as_address_checkbox = trim($this->input->post('same_as_address_checkbox'));
        $address = trim($this->input->post('address'));
        $others_benefit = trim($this->input->post('others_benefit'));
        $less_others_benefit = trim($this->input->post('less_others_benefit'));
        $less_others_misc = trim($this->input->post('less_others_misc'));
        $pf_contribution_company_part = trim($this->input->post('pf_contribution_company_part'));
        $previous_provident_fund_amount = !empty(trim($this->input->post('previous_provident_fund_amount'))) ? trim($this->input->post('previous_provident_fund_amount')) : 0;
        $target_amount = get_floating_point_number(trim($this->input->post('target_amount')));

        /* if ((!empty($same_as_address_checkbox)) || $same_as_address_checkbox == 'on') {
          $permanent_address = $address;
          } else {
          $permanent_address = trim($this->input->post('permanent_address'));
          } */

        $permanent_address = trim($this->input->post('permanent_address'));
        // if ((!empty($is_loan)) || $is_loan == 'on') {
        //     $is_loan = 1;
        // } else {
        //     $is_loan = 0;
        // }

        if ((!empty($deactivate_employee)) || $deactivate_employee == 'on') {
            $deactivate_employee = 1;
        } else {
            $deactivate_employee = 0;
        }

        $employee_data = array(
            'employee_name' => trim($this->input->post('employee_name')),
            'employee_code' => trim($this->input->post('employee_code')),
            'employee_email' => trim($this->input->post('employee_email')),
            'designation' => trim($this->input->post('designation')),
            'gender' => trim($this->input->post('gender')),
            'phone' => trim($this->input->post('phone')),
            'mobile' => trim($this->input->post('mobile')),
            'address' => $address,
            'joining_date' => $joining_date,
            'closing_date' => trim($this->input->post('closing_date')),
            'basic_salary' => trim($this->input->post('basic_salary')),
            'phone_allowance' => trim($this->input->post('phone_allowance')),
            'tuition_allowance' => trim($this->input->post('tuition_allowance')),
            'attendance_allowance' => trim($this->input->post('attendance_allowance')),
            'bonus' => trim($this->input->post('bonus')),
            'others' => trim($this->input->post('others')),
            'pf_contribution' => trim($this->input->post('pf_contribution')),
            'loan_installment' => 0, //$this->input->post('loan_installment')
            // 'is_loan' => $is_loan,
            'current_loan_id' => 0,
            'deactivate_employee' => $deactivate_employee,
            'casual_leave' => $casual_leave,
            'medical_leave' => $medical_leave,
            'earn_leave' => $earn_leave,
            'sort_order' => $sort_order,
            'permanent_address' => $permanent_address,
            'blood_group' => $blood_group,
            'others_benefit' => $others_benefit,
            'less_others_benefit' => $less_others_benefit,
            'less_others_misc' => $less_others_misc,
            'pf_contribution_company_part' => $pf_contribution_company_part,
            'target_amount' => 0,
        );
        $this->form_validation->set_rules('employee_name', 'Employee Name', 'required');
        $this->form_validation->set_rules('employee_code', 'Employee Code', 'required');
        /* $this->form_validation->set_rules('employee_email', 'Email', 'required'); */
        $this->form_validation->set_rules('designation', 'Designation', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('joining_date', 'Joining Date', 'required');
        $this->form_validation->set_rules('casual_leave', 'Casual Leave', 'required');
        $this->form_validation->set_rules('medical_leave', 'Medical Leave', 'required');
        $this->form_validation->set_rules('earn_leave', 'Earn Leave', 'required');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'required');
        $this->form_validation->set_rules('permanent_address', 'Permanent Address', 'required');
        $this->form_validation->set_rules('blood_group', 'Blood Group', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('employee/create_new_employee', $this->data);
        } else {
            $path = '';
            $default_image_path = '';
            $default_image_path = '';
//                $default_image_path = 'assets/uploads/employee_images/no_employee_image.jpg';
            $new_name = $_FILES["image"]['name'];
            $config['file_name'] = $new_name;
            $size = $_FILES["image"]["size"];
            $config['upload_path'] = './assets/uploads/employee_images/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 100;
            $this->load->library('upload', $config);
            if ((int) $size > (100 * 1024)) {
                $this->session->set_flashdata('image_upload_error_message', 'Image size can not be more than 100 kb');
                redirect(base_url('employee/create_new_employee'));
            } else {
                $is_upload = $this->upload->do_upload('image');
                $data = array('upload_data' => $this->upload->data());
                if (!empty(trim($new_name))) {
                    $path = 'assets/uploads/employee_images/' . $data['upload_data']['file_name'];
                }
                $employee_data['employee_image'] = !empty($path) ? $path : $default_image_path;
                $this->Employee_Model->db->insert('employee_info', $employee_data);
                $currently_inserted_employee_id = $this->db->insert_id();
                if (!empty($currently_inserted_employee_id)) {
                    $this->employee_total_leave_save($currently_inserted_employee_id, $year, $casual_leave, $medical_leave, $earn_leave);
                    if ($previous_provident_fund_amount > 0) {
                        $this->pf_information_save($currently_inserted_employee_id, $user_id, $previous_provident_fund_amount);
                    }
                    redirect(base_url('employee'));
                }
            }
        }
    }

    public function update_employee($id = 0) {  // load update employee information page
        if (get_user_permission('employee') === false) {
            redirect(base_url('user_login'));
        }
        $employee = $this->Employee_Model->get_employee($id);
        $pf_funds_by_employee_id = $this->Pf_funds_Model->get_pf_funds_by_employee_id($id);
        $current_year = get_current_year();
        if (!empty($employee)) {
            $this->data['title'] = "Update Employee";
            $this->data['employee'] = $employee;
            $employee_total_leave_by_current_year = $this->Employee_total_leave_Model->get_employee_total_leave_by_current_year($id, $current_year);
            $this->data['employee_total_leave_by_current_year'] = $employee_total_leave_by_current_year;
            $this->data['pf_funds_by_employee_id'] = $pf_funds_by_employee_id;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('employee/update_employee', $this->data);
        } else {
            redirect(base_url('employee'));
        }
    }

    public function update() {  // update employee
        if (get_user_permission('employee') === false) {
            redirect(base_url('user_login'));
        }
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id']; // session user id
        $this->data['title'] = 'Update Employee';
        $id = trim($this->input->post('id'));  // employee_id
        $employee = $this->Employee_Model->get_employee($id);
        $employee_current_loan_id = $employee->current_loan_id;
        if ((int) $employee_current_loan_id > 0) {
            $loan_information = $this->Loan_Model->get_loan_by_employee_id($id);
        } else {
            $loan_information = '';
        }
        $year = get_current_year();
        $employee_name = trim($this->input->post('employee_name'));
        $employee_email = trim($this->input->post('employee_email'));
        $mobile = trim($this->input->post('mobile'));
        $address = trim($this->input->post('address'));
        $casual_leave = trim($this->input->post('casual_leave'));
        $medical_leave = trim($this->input->post('medical_leave'));
        $earn_leave = trim($this->input->post('earn_leave'));
        $deactivate_employee = trim($this->input->post('deactivate_employee'));
        $sort_order = trim($this->input->post('sort_order'));
        $is_loan = trim($this->input->post('is_loan'));
        $this->data['employee'] = $employee;
        $blood_group = trim($this->input->post('blood_group'));
        $same_as_address_checkbox = trim($this->input->post('same_as_address_checkbox'));
        $others_benefit = trim($this->input->post('others_benefit'));
        $less_others_benefit = trim($this->input->post('less_others_benefit'));
        $less_others_misc = trim($this->input->post('less_others_misc'));
        $pf_contribution_company_part = trim($this->input->post('pf_contribution_company_part'));
        $previous_provident_fund_amount = !empty(trim($this->input->post('previous_provident_fund_amount'))) ? trim($this->input->post('previous_provident_fund_amount')) : 0;
        $loan_installment = trim($this->input->post('loan_installment'));
        $target_amount = get_floating_point_number(trim($this->input->post('target_amount')));

        /* if ((!empty($same_as_address_checkbox)) || $same_as_address_checkbox == 'on') {
          $permanent_address = $address;
          } else {
          $permanent_address = trim($this->input->post('permanent_address'));
          } */
        $permanent_address = trim($this->input->post('permanent_address'));

        if (empty($loan_information)) {
            if ((!empty($is_loan)) || $is_loan == 'on') {
                $this->session->set_flashdata('is_loan_error_message', 'This employee has no loan');
                redirect('employee/update_employee/' . $id);
            }
        } else {
            if ((empty($is_loan))) {
                $this->session->set_flashdata('is_loan_error_message', 'This employee has loan');
                redirect('employee/update_employee/' . $id);
            }
        }

        $pf_funds_by_employee_id = $this->Pf_funds_Model->get_pf_funds_by_employee_id($id);
        if (!empty($pf_funds_by_employee_id) && (double) $previous_provident_fund_amount > 0) {
            if ((double) $pf_funds_by_employee_id->total_deposit_amount > 0) {
                $this->session->set_flashdata('previous_pf_error_message', 'You can not add Previous Provident Fund');
                redirect('employee/update_employee/' . $id);
            }
        }

        $leave_input_error_message = '';
        $leave_input_error_message = $this->check_leave_input_error($id, $year, $casual_leave, $medical_leave, $earn_leave);
        if (!empty($leave_input_error_message) || $leave_input_error_message != '') {
            $this->session->set_flashdata('leave_error_message', $leave_input_error_message);
            redirect(base_url('employee/update_employee/') . $id);
        }

        if ((!empty($is_loan)) || $is_loan == 'on') {
            $is_loan = 1;
        } else {
            $is_loan = 0;
        }

        if ((!empty($deactivate_employee)) || $deactivate_employee == 'on') {
            $deactivate_employee = 1;
        } else {
            $deactivate_employee = 0;
        }

        $employee_data = array(
            'id' => $id,
            'employee_name' => $employee_name,
            'employee_code' => trim($this->input->post('employee_code')),
            'employee_email' => $employee_email,
            'designation' => trim($this->input->post('designation')),
            'gender' => trim($this->input->post('gender')),
            'phone' => trim($this->input->post('phone')),
            'mobile' => $mobile,
            'address' => $address,
            'joining_date' => trim($this->input->post('joining_date')),
            'closing_date' => trim($this->input->post('closing_date')),
            'basic_salary' => trim($this->input->post('basic_salary')),
            'phone_allowance' => trim($this->input->post('phone_allowance')),
            'tuition_allowance' => trim($this->input->post('tuition_allowance')),
            'attendance_allowance' => trim($this->input->post('attendance_allowance')),
            'bonus' => trim($this->input->post('bonus')),
            'others' => trim($this->input->post('others')),
            'pf_contribution' => trim($this->input->post('pf_contribution')),
            'loan_installment' => 0,
            // 'is_loan' => $is_loan,
            'current_loan_id' => $employee_current_loan_id,
            'deactivate_employee' => $deactivate_employee,
            'casual_leave' => $casual_leave,
            'medical_leave' => $medical_leave,
            'earn_leave' => $earn_leave,
            'sort_order' => $sort_order,
            'permanent_address' => $permanent_address,
            'blood_group' => $blood_group,
            'others_benefit' => $others_benefit,
            'less_others_benefit' => $less_others_benefit,
            'less_others_misc' => $less_others_misc,
            'pf_contribution_company_part' => $pf_contribution_company_part,
            'target_amount' => 0,
        );
        $this->form_validation->set_rules('employee_name', 'Employee name', 'required');
        $this->form_validation->set_rules('employee_code', 'Employee Code', 'required');
        /* $this->form_validation->set_rules('employee_email', 'Email', 'required'); */
        $this->form_validation->set_rules('designation', 'Designation', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('joining_date', 'Joining Date', 'required');
        $this->form_validation->set_rules('casual_leave', 'Casual Leave', 'required');
        $this->form_validation->set_rules('medical_leave', 'Medical Leave', 'required');
        $this->form_validation->set_rules('earn_leave', 'Earn Leave', 'required');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'required');
        $this->form_validation->set_rules('permanent_address', 'Permanent Address', 'required');
        $this->form_validation->set_rules('blood_group', 'Blood Group', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('employee/update_employee', $this->data);
        } else {
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
                    redirect(base_url('employee/update_employee/' . $id));
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
            $employee_data['employee_image'] = !empty($path) ? $path : $employee->employee_image;
            $this->db->where('id', $employee_data['id']);
            $this->Employee_Model->db->update('employee_info', $employee_data);
            if ($previous_provident_fund_amount > 0) {
                $this->pf_information_save($id, $user_id, $previous_provident_fund_amount);  // $id = employee_id
            } else {
                $this->update_pf_per_month($id);
            }
            $this->update_user_information($id, $employee_name, $employee_email, $mobile, $address);  // employee_id
            $this->employee_total_leave_save($id, $year, $casual_leave, $medical_leave, $earn_leave);
            if ((int) $employee_current_loan_id > 0) {
                $this->update_loan_per_installment_in_loan($employee, $loan_installment);
            }
            redirect(base_url('employee'));
        }
    }

    public function delete_uploaded_image($employee_image) {
        if (!empty($employee_image)) {
            unlink(($employee_image));
        }
    }

    public function update_loan_per_installment_in_loan($employee, $loan_installment) {
        $loan_data = array(
            'id' => $employee->current_loan_id,
            'per_installment_amount' => $loan_installment,
        );
        $this->db->where('id', $loan_data['id']);
        $this->Loan_Model->db->update('loan', $loan_data);
    }

    public function update_pf_per_month($employee_id) {
        $employee = $this->Employee_Model->get_employee($employee_id);
        $pf_funds_by_employee_id = $this->Pf_funds_Model->get_pf_funds_by_employee_id($employee_id);
        if (!empty($pf_funds_by_employee_id)) {
            $pf_funds_data = array(
                'id' => $pf_funds_by_employee_id->id,
                'employee_id' => $employee_id,
                'pf_contribution_per_month' => $employee->pf_contribution,
                'total_deposit_amount' => $pf_funds_by_employee_id->total_deposit_amount,
                'starting_date' => $pf_funds_by_employee_id->starting_date,
                'user_id' => $pf_funds_by_employee_id->user_id,
            );
            $this->db->where('id', $pf_funds_data['id']);
            $this->Pf_funds_Model->db->update('pf_funds', $pf_funds_data);
        }
    }

    public function update_user_information($employee_id, $employee_name, $employee_email, $mobile, $address) {
        $user_by_employee_id = $this->User_Model->get_user_by_employee_id($employee_id);
        if (!empty($user_by_employee_id)) {
            $data = array(
                'id' => $user_by_employee_id->id,
                'name' => $employee_name, //
                'user_name' => $user_by_employee_id->user_name,
                'password' => $user_by_employee_id->password,
                'user_type' => $user_by_employee_id->user_type,
                'email' => $employee_email, //
                'mobile' => $mobile, //
                'address' => $address, //
                'employee_id' => $employee_id,
            );
            $this->db->where('id', $data['id']);
            $this->User_Model->db->update('user_info', $data);
        }
    }

    public function employee_total_leave_save($employee_id, $year, $casual_leave, $medical_leave, $earn_leave) {
        $current_year = date("Y");
        $employee = $this->Employee_Model->get_employee($employee_id);
        $employee_total_leave_by_current_year = $this->Employee_total_leave_Model->get_employee_total_leave_by_current_year($employee_id, $current_year);
        if (($employee->deactivate_employee) <= 0) {
            if (!empty($employee_total_leave_by_current_year)) {
                $employee_total_leave_data = array(
                    'id' => $employee_total_leave_by_current_year->id,
                    'employee_id' => $employee_total_leave_by_current_year->employee_id,
                    'year' => $employee_total_leave_by_current_year->year,
                    'total_casual_leave' => $casual_leave,
                    'total_medical_leave' => $medical_leave,
                    'total_earn_leave' => $earn_leave,
                    'paid_casual_leave' => $employee_total_leave_by_current_year->paid_casual_leave,
                    'paid_medical_leave' => $employee_total_leave_by_current_year->paid_medical_leave,
                    'paid_earn_leave' => $employee_total_leave_by_current_year->paid_earn_leave,
                );
                $this->db->where('id', $employee_total_leave_data['id']);
                $this->Employee_total_leave_Model->db->update('employee_total_leave', $employee_total_leave_data);
            } else {
                $employee_total_leave_data = array(
                    'employee_id' => $employee_id,
                    'year' => $year,
                    'total_casual_leave' => $casual_leave,
                    'total_medical_leave' => $medical_leave,
                    'total_earn_leave' => $earn_leave,
                    'paid_casual_leave' => 0,
                    'paid_medical_leave' => 0,
                    'paid_earn_leave' => 0,
                );
                $this->Employee_total_leave_Model->db->insert('employee_total_leave', $employee_total_leave_data);
            }
        }
    }

    public function check_leave_input_error($id, $year, $casual_leave, $medical_leave, $earn_leave) {
        $employee_total_leave_by_current_year = $this->Employee_total_leave_Model->get_employee_total_leave_by_current_year($id, $year);
        if (!empty($employee_total_leave_by_current_year)) {
            $paid_casual_leave = $employee_total_leave_by_current_year->paid_casual_leave;
            $paid_medical_leave = $employee_total_leave_by_current_year->paid_medical_leave;
            $paid_earn_leave = $employee_total_leave_by_current_year->paid_earn_leave;
            $message = '';
            if ((int) $casual_leave < (int) ($paid_casual_leave)) {
                return $message = 'Input Casual Leave must be greater than Paid Casual Leave';
            }
            if ((int) $medical_leave < (int) ($paid_medical_leave)) {
                return $message = 'Input Medical Leave must be greater than Paid Medical Leave';
            }
            if ((int) $earn_leave < (int) ($paid_earn_leave)) {
                return $message = 'Input Earn Leave must be greater than Paid Earn Leave';
            }
        }
    }

    public function delete($id) {
        if (get_user_permission('employee') === false) {
            redirect(base_url('user_login'));
        }
        if ((int) $id > 0) {
            $employee_information = $this->Employee_Model->get_employee($id);
            $this->Employee_Model->delete($id);
            $this->delete_uploaded_image($employee_information->employee_image);
            redirect(base_url('employee'));
        }
    }

    public function get_is_loan_information() {
        if ($this->input->is_ajax_request()) {
            $employee_id = trim($this->input->post('employee_id'));
            $current_loan_id = trim($this->input->post('current_loan_id'));
            $loan_information = $this->Loan_Model->get_loan_by_employee_id($employee_id);
            if (empty($loan_information)) {
                echo 'This employee has no loan';
            } else {
                
            }
        }
    }

    public function pf_information_save($employee_id, $user_id, $previous_provident_fund_amount) {
        $starting_date = '';
        $employee = $this->Employee_Model->get_employee($employee_id);
        $pf_funds_by_employee_id = $this->Pf_funds_Model->get_pf_funds_by_employee_id($employee->id);
        $joining_date = date('Y-m-d', strtotime($employee->joining_date));
        $check_date = date('Y-m-d', strtotime('2016-08-01 00:00:00'));
        if (($joining_date) <= ($check_date)) {
            $starting_date = $check_date;
        } else {
            $starting_date = $joining_date;
        }
        if (empty($pf_funds_by_employee_id)) {
            $total_deposit_amount = $employee->pf_contribution;
            $pf_funds_data = array(
                'employee_id' => $employee->id,
                'pf_contribution_per_month' => $employee->pf_contribution,
                'total_deposit_amount' => $previous_provident_fund_amount,
                'starting_date' => $starting_date,
                'user_id' => $user_id,
            );
            $this->Pf_funds_Model->db->insert('pf_funds', $pf_funds_data);
        } else {
            $total_deposit_amount = ($pf_funds_by_employee_id->total_deposit_amount) + ($employee->pf_contribution);
            $pf_funds_data = array(
                'id' => $pf_funds_by_employee_id->id,
                'employee_id' => $employee->id,
                'pf_contribution_per_month' => $employee->pf_contribution,
                'total_deposit_amount' => $previous_provident_fund_amount,
                'starting_date' => $starting_date,
                'user_id' => $user_id,
            );
            $this->db->where('id', $pf_funds_data['id']);
            $this->Pf_funds_Model->db->update('pf_funds', $pf_funds_data);
        }
        $pf_funds_details_data = array(
            'employee_id' => $employee->id,
            'deposit_date' => date("Y-m-d"),
            'previous_deposit_amount' => 0,
            'deposit_amount' => $previous_provident_fund_amount,
            'deposit_amount_total' => $previous_provident_fund_amount,
            'user_id' => $user_id,
            'salary_details_id' => 0,
        );
        $this->Pf_funds_details_Model->db->insert('pf_funds_details', $pf_funds_details_data);
    }

    public function employee_target() {  // load Employee target list
        if (get_user_permission('employee') === false) {
            redirect(base_url('user_login'));
        }
        $user_info = $this->session->userdata('user_session');
        $this->data['title'] = "Employee";
        $this->data['page_title'] = "Employee Target List";
        $this->data['employee_list'] = $this->Employee_Model->get_employee();
        $this->data['employee_target_list'] = $this->Employee_target_Model->get_employee_target();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('employee/employee_target_list', $this->data);
    }

    public function create_new_target() {  // load Employee target list
        if (get_user_permission('employee') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "Employee Target";
        $this->data['page_title'] = "Create Employee Target";
        $this->data['employee_list'] = $this->Employee_Model->get_employee();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('employee/employee_target_create', $this->data);
    }

    public function save_target() {
        if (get_user_permission('employee') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = 'Create New Target';
        $employee_id = intval(trim($this->input->post('employee_id')));
        $target_start_date = get_string_to_date_fromat_ymd(trim($this->input->post('target_start_date')));
        $target_end_date = get_string_to_date_fromat_ymd(trim($this->input->post('target_end_date')));
        $target_amount = get_floating_point_number(trim($this->input->post('target_amount')));
        if (!empty($employee_id) && ($employee_id > 0)) {
            $data = array(
                'employee_id' => $employee_id,
                'target_start_date' => $target_start_date,
                'target_end_date' => ($target_end_date == '1970-01-01') ? get_next_month_from_selected_date($target_start_date, 12) : $target_start_date, // if end date empty then add one year and set it to end date
                'target_amount' => $target_amount,
            );
            $this->form_validation->set_rules('employee_id', 'Employee', 'required');
            $this->form_validation->set_rules('target_start_date', 'Start Date', 'required');

            if ($this->form_validation->run() === FALSE) {
                $this->data['title'] = "Employee";
                $this->data['page_title'] = "Create Employee Target";
                $this->data['employee_list'] = $this->Employee_Model->get_employee();
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('employee/employee_target_create', $this->data);
            } else {
                $last_target = $this->Employee_target_Model->get_last_target_by_employee_id($employee_id);
                if (!empty($last_target)) {
                    $last_data = array(
                        'id' => $last_target->id,
                        'target_end_date' => date('Y-m-d', strtotime($target_start_date . "-" . 1 . " days")),
                    );
                    $this->db->where('id', $last_data['id']);
                    $this->Employee_target_Model->db->update('employee_target', $last_data);
                }
                $this->Employee_target_Model->db->insert('employee_target', $data);
                redirect(base_url('employee/employee_target'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update_employee_target($id = 0) {  // load Employee target list
        if (get_user_permission('employee') === false) {
            redirect(base_url('user_login'));
        }
        $employee_target = $this->Employee_target_Model->get_employee_target($id);
        if (!empty($employee_target)) {
            $this->data['title'] = "Employee Target";
            $this->data['page_title'] = "Update Employee Target";
            $this->data['employee_list'] = $this->Employee_Model->get_employee();
            $this->data['employee_target'] = $employee_target;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('employee/employee_target_update', $this->data);
        } else {
            redirect(base_url('employee/employee_target'));
        }
    }

    public function update_target() {
        if (get_user_permission('employee') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = 'Update New Target';
        $id = intval(trim($this->input->post('id')));
        $employee_id = intval(trim($this->input->post('employee_id')));
        $target_start_date = get_string_to_date_fromat_ymd(trim($this->input->post('target_start_date')));
        $target_end_date = get_string_to_date_fromat_ymd(trim($this->input->post('target_end_date')));
        $target_amount = get_floating_point_number(trim($this->input->post('target_amount')));
        if (!empty($employee_id) && ($employee_id > 0)) {
            $data = array(
                'id' => $id,
                'employee_id' => $employee_id,
                'target_start_date' => $target_start_date,
                'target_end_date' => ($target_end_date == '1970-01-01') ? get_next_month_from_selected_date($target_start_date, 12) : $target_start_date, // if end date empty then add one year and set it to end date
                'target_amount' => $target_amount,
            );
            $this->form_validation->set_rules('employee_id', 'Employee', 'required');
            $this->form_validation->set_rules('target_start_date', 'Start Date', 'required');

            if ($this->form_validation->run() === FALSE) {
                $this->data['title'] = "Employee";
                $this->data['page_title'] = "Create Employee Target";
                $this->data['employee_list'] = $this->Employee_Model->get_employee();
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('employee/employee_target_create', $this->data);
            } else {
                $this->db->where('id', $data['id']);
                $this->Employee_target_Model->db->update('employee_target', $data);
                redirect(base_url('employee/employee_target'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

}
