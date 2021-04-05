<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_leave extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Employee_total_leave_Model');
        $this->load->model('Employee_leave_details_Model');
        $this->load->model('Leave_application_Model');
    }

    public function index() {  // Load Employee Leave
        if (get_user_permission('hr/employee_leave') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "Employee Leave";
        $employee_list = $this->Employee_Model->get_employee();
        $this->data['employee_list'] = $employee_list;
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('hr/employee_leave/employee_leave', $this->data);
    }

    public function employee_leave_save() {
        if (get_user_permission('hr/employee_leave') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = "Employee Leave Save";
        $employee_list = $this->Employee_Model->get_employee();
        $this->data['employee_list'] = $employee_list;
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id']; // session user id
        $current_date = date('Y-m-d');  //entry_date
        $employee_id = trim($this->input->post('employee_id'));
        $leave_type = trim($this->input->post('leave_type'));
        $start_date = trim($this->input->post('start_date'));
        $end_date = trim($this->input->post('end_date'));
        $total_day = trim($this->input->post('total_day'));
        $comments = trim($this->input->post('comments'));
        $current_year = get_current_year();
        $employee_total_leave_by_current_year = $this->Employee_total_leave_Model->get_employee_total_leave_by_current_year($employee_id, $current_year);
        $employee_leave_details_data = array(
            'employee_id' => $employee_id,
            'leave_type' => $leave_type,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'total_day' => $total_day,
            'comments' => $comments,
            'entry_date' => $current_date,
            'user_id' => $user_id,
            'employee_total_leave_id' => ($employee_total_leave_by_current_year->id),
        );
        $this->form_validation->set_rules('employee_id', 'Employee Name', 'required');
        $this->form_validation->set_rules('leave_type', 'Leave Type', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('end_date', 'End Date', 'required');
        $this->form_validation->set_rules('total_day', 'Total Day', 'required');
        $this->form_validation->set_rules('comments', 'Comments', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->data['title'] = "Employee Leave";
            $employee_list = $this->Employee_Model->get_employee();
            $this->data['employee_list'] = $employee_list;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('hr/employee_leave/employee_leave', $this->data);
        } else {
            $leave_information_ability = $this->Employee_total_leave_Model->get_leave_information_ability($employee_id, $leave_type, $total_day);
            if ($leave_information_ability == FALSE) {
                $this->session->set_flashdata('total_day_leave_error_message', 'Insufficient Leave');
                redirect(base_url('hr/employee_leave'));
            } else {
                $this->Employee_leave_details_Model->db->insert('employee_leave_details', $employee_leave_details_data);
                // update_employee_total_leave while employee take a leave
                $this->update_employee_total_leave($employee_total_leave_by_current_year, $leave_type, $total_day);
                $this->session->set_flashdata('employee_leave_details_save_message', 'Employee Leave Information has been saved Successfully');
                redirect(base_url('hr/employee_leave'));
            }
        }
    }

    public function update_employee_total_leave($employee_total_leave_by_current_year, $leave_type, $total_day) {
        if (strtolower($leave_type) == 'casual') {
            $paid_casual_leave = (int) $employee_total_leave_by_current_year->paid_casual_leave + (int) $total_day;
        } elseif (strtolower($leave_type) == 'medical') {
            $paid_medical_leave = (int) $employee_total_leave_by_current_year->paid_medical_leave + (int) $total_day;
        } else {  // For earn leave
            $paid_earn_leave = (int) $employee_total_leave_by_current_year->paid_earn_leave + (int) $total_day;
        }
        $employee_total_leave_data = array(
            'id' => $employee_total_leave_by_current_year->id,
            'employee_id' => $employee_total_leave_by_current_year->employee_id,
            'year' => $employee_total_leave_by_current_year->year,
            'total_casual_leave' => $employee_total_leave_by_current_year->total_casual_leave,
            'total_medical_leave' => $employee_total_leave_by_current_year->total_medical_leave,
            'total_earn_leave' => $employee_total_leave_by_current_year->total_earn_leave,
            'paid_casual_leave' => !empty($paid_casual_leave) ? $paid_casual_leave : $employee_total_leave_by_current_year->paid_casual_leave,
            'paid_medical_leave' => !empty($paid_medical_leave) ? $paid_medical_leave : $employee_total_leave_by_current_year->paid_medical_leave,
            'paid_earn_leave' => !empty($paid_earn_leave) ? $paid_earn_leave : $employee_total_leave_by_current_year->paid_earn_leave,
        );
        $this->db->where('id', $employee_total_leave_data['id']);
        $this->Employee_total_leave_Model->db->update('employee_total_leave', $employee_total_leave_data);
    }

    public function leave_application() {
        if (get_user_permission('hr/employee_leave/leave_application') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['employee_list'] = $this->Employee_Model->get_employee();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('hr/employee_leave/leave_application', $this->data);
    }

    public function leave_application_save() {
        if (get_user_permission('hr/employee_leave/leave_application') === false) {
            redirect(base_url('user_login'));
        }
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id']; // session user id
        $leave_application_data = array(
            'employee_id' => trim($this->input->post('employee_id')),
            'start_date' => trim($this->input->post('start_date')),
            'end_date' => trim($this->input->post('end_date')),
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
        $this->form_validation->set_rules('employee_id', 'Employee Name', 'required');
        $this->form_validation->set_rules('start_date', 'Start date', 'required');
        $this->form_validation->set_rules('end_date', 'End date', 'required');
        $this->form_validation->set_rules('total_day', 'Total day', 'required');
        $this->form_validation->set_rules('leave_type', 'Leave type', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('contact_no', 'Contact No', 'required');
        $this->form_validation->set_rules('leave_details', 'Leave details', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->data['employee_list'] = $this->Employee_Model->get_employee();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('hr/employee_leave/leave_application', $this->data);
        } else {
            $this->Leave_application_Model->db->insert('leave_application', $leave_application_data);
            $this->session->set_flashdata('leave_application_save_success_message', 'Information has been saved Successfully.');
            redirect(base_url('hr/employee_leave/leave_application'));
        }
    }

}
