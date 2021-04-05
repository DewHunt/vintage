<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_own_leave_application extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Employee_total_leave_Model');
        $this->load->model('Employee_leave_details_Model');
        $this->load->model('Leave_application_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session'))) {
            $this->data['title'] = 'Employee Own Leave Application';
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('employee_own_leave_application/employee_own_leave_application', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function employee_own_leave_application_show_in_table() {
        if (!empty($this->session->userdata('user_session'))) {
            $user_info = $this->session->userdata('user_session');
            $employee_id = $user_info['employee_id'];
            $this->data['employee'] = $this->Employee_Model->get_employee($employee_id);
            $year = trim($this->input->post('year'));
            $application_status = trim($this->input->post('application_status'));
            if (empty($year) || empty($application_status)) {
                echo "<div class='error-message text-align-center'>Please Select Year.</div>";
            } else {
                $this->data['leave_application_list_by_employee_year_status'] = $this->Leave_application_Model->get_leave_application_by_employee_year_status($employee_id, $year, $application_status);
                $this->data['year'] = $year;
                $this->data['title'] = 'Employee Own Leave Application List';
                $this->load->view('employee_own_leave_application/employee_own_leave_application_table', $this->data);
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function employee_own_leave_application_show_in_modal() {
        if (!empty($this->session->userdata('user_session'))) {
            $id = trim($this->input->post('id'));  //leave_application id
            $leave_application_by_leave_application_id = $this->Leave_application_Model->get_leave_application_by_leave_application_id($id);
            $this->data['leave_application_by_leave_application_id'] = $leave_application_by_leave_application_id;
            $this->data['title'] = 'Employee Own Leave Application List';
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->load->view('employee_own_leave_application/employee_own_leave_application_modal', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function employee_own_leave_application() { // Load Employee Own Leave Application
        if (!empty($this->session->userdata('user_session'))) {
            $user_info = $this->session->userdata('user_session');
            $employee_id = $user_info['employee_id'];
            $this->data['employee'] = $this->Employee_Model->get_employee($employee_id);
            $this->data['title'] = 'Employee Own Leave Application';
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('employee_own_leave_application/employee_own_leave_application_create', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function employee_own_leave_application_save() { // Employee Own Leave Application Save
        if (!empty($this->session->userdata('user_session'))) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $employee_id = $user_info['employee_id'];
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            if (date('d-m-Y', strtotime($start_date)) > date('d-m-Y', strtotime($end_date))) {
                $this->session->set_flashdata('employee_own_leave_application_date_error_message', 'Please select correct date duration.');
                redirect(base_url('employee_own_leave_application/employee_own_leave_application'));
            }
            $leave_application_data = array(
                'employee_id' => $employee_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_day' => trim($this->input->post('total_day')),
                'leave_type' => trim($this->input->post('leave_type')),
                'address' => trim($this->input->post('address')),
                'contact_no' => trim($this->input->post('contact_no')),
                'leave_details' => trim($this->input->post('leave_details')),
                'application_status' => 'pending',
                'accept_reject_employee_id' => trim($this->input->post('accept_reject_employee_id')),
                'current_date_time' => get_current_date_and_time(),
                'user_id' => $user_id,
            );
            $this->form_validation->set_rules('start_date', 'Start date', 'required');
            $this->form_validation->set_rules('end_date', 'End date', 'required');
            $this->form_validation->set_rules('total_day', 'Total day', 'required');
            $this->form_validation->set_rules('leave_type', 'Leave type', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('contact_no', 'Contact No', 'required');
            $this->form_validation->set_rules('leave_details', 'Leave details', 'required');
            if ($this->form_validation->run() === FALSE) {
                $user_info = $this->session->userdata('user_session');
                $employee_id = $user_info['employee_id'];
                $this->data['employee'] = $this->Employee_Model->get_employee($employee_id);
                $this->data['title'] = 'Employee Own Leave Application';
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('employee_own_leave_application/employee_own_leave_application', $this->data);
            } else {
                $this->Leave_application_Model->db->insert('leave_application', $leave_application_data);
                $this->session->set_flashdata('employee_own_leave_application_save_success_message', 'Information has been saved Successfully.');
                redirect(base_url('employee_own_leave_application/employee_own_leave_application'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

}
