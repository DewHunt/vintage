<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_yearly_benefit_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Voucher_posting_details_Model');
        $this->load->model('Voucher_details_Model');
        $this->load->model('Head_details_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Salary_details_Model');
        $this->load->model('Employee_benefit_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $this->data['title'] = "Employee Benefit Report";
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $employee_list = $this->Employee_Model->get_employee();
            $this->data['employee_list'] = $employee_list;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/accounts_report/employee_yearly_benefit_report/employee_yearly_benefit_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function employee_yearly_benefit_report_show() {  //yearly benefit report show in table
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $year = trim($this->input->post('year'));
            $employee_id = trim($this->input->post('employee_id'));
            $employee = $this->Employee_Model->get_employee($employee_id);
            if (!empty($employee)) {
                $employee_name = $employee->employee_name;
            } else {
                $employee_name = 'All';
            }
            if ((int) $employee_id <= 0) {
                $employee_list = $this->Employee_Model->get_employee_list(0);
            } else {
                $employee_list = $this->Employee_Model->get_employee_list($employee_id);
            }
            if ((int) $employee_id <= 0) {
                $salary_details_by_year = $this->Salary_details_Model->get_salary_details_by_year($year, 0);
            } else {
                $salary_details_by_year = $this->Salary_details_Model->get_salary_details_by_year($year, $employee_id);
            }
            $this->data['year'] = $year;
            $this->data['employee'] = $employee;
            $this->data['employee_name'] = $employee_name;
            $this->data['employee_list'] = $employee_list;
            $this->data['salary_details_by_year'] = $salary_details_by_year;
            $this->load->view('reports/accounts_report/employee_yearly_benefit_report/employee_yearly_benefit_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

}
