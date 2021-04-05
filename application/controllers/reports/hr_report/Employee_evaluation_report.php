<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_evaluation_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Employee_evaluation_Model');
        $this->load->model('User_Model');
    }

    public function index() {
        if (get_user_permission('reports/hr_report/employee_evaluation_report') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "Employee Evaluation Report";
        $this->data['company_information'] = $this->Company_Model->get_company();
        $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
        $this->data['employee_list'] = $this->Employee_Model->get_employee();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('reports/hr_report/employee_evaluation_report/employee_evaluation_report', $this->data);
    }

    public function employee_evaluation_report_show_in_table() {  //show in table
        if (get_user_permission('reports/hr_report/employee_evaluation_report') === false) {
            redirect(base_url('user_login'));
        }
        $year = trim($this->input->post('year'));
        $employee_id = trim($this->input->post('employee_id'));
        if (empty($year)) {
            echo '<div class="error-message text-align-center">Please Select Year</div>';
        } else {
            $employee_information = $this->Employee_Model->get_employee($employee_id);
            if (!empty($employee_information)) {
                $employee_name = ucfirst($employee_information->employee_name);
            } else {
                $employee_name = 'All';
            }
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id'];
            $user_type = $user_info['user_type'];
            $this->data['year'] = $year;
            $this->data['employee_id'] = $employee_id;
            $this->data['employee_name'] = $employee_name;
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $this->data['employee_evaluation_by_employee_and_year'] = $this->Employee_evaluation_Model->get_employee_evaluation_by_employee_and_year($year, $employee_id);
            $this->load->view('reports/hr_report/employee_evaluation_report/employee_evaluation_report_table', $this->data);
        }
    }

    public function employee_evaluation_report_show_in_modal() {  // modal view
        if (get_user_permission('reports/hr_report/employee_evaluation_report') === false) {
            redirect(base_url('user_login'));
        }
        $id = trim($this->input->post('id')); //employee_evaluation_id
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id'];
        $user_type = $user_info['user_type'];
        $this->data['company_information'] = $this->Company_Model->get_company();
        $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
        $this->data['employee_evaluation_by_employee_evaluation_id'] = $this->Employee_evaluation_Model->get_employee_evaluation_by_employee_evaluation_id($id);
        $this->load->view('reports/hr_report/employee_evaluation_report/employee_evaluation_report_modal', $this->data);
    }

}
