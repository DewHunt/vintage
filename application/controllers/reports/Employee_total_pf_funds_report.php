<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_total_pf_funds_report extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Employee_Model');
    }

    public function index()
    {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $this->data['title'] = "Employee P/F Funds Report";
            $employee_list = $this->Employee_Model->get_employee();
            $this->data['employee_list'] = $employee_list;
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/pf_funds_report/pf_funds_total_report/employee_total_pf_funds_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function employee_wise_pf_funds_report_show()
    {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $employee_id = $this->input->post('employee_id');
            $company_information = $this->Company_Model->get_company();
            $employee_information = $this->Employee_Model->get_employee($employee_id);
            if (!empty($employee_information)) {
                $employee_name = $employee_information->employee_name;
                $designation = $employee_information->designation;
            } else {
                $employee_name = 'All';
                $designation = 'All';
            }
            $pf_funds_report_by_employee_id = $this->get_pf_funds_report_by_employee_id($employee_id);
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $this->data['company_information'] = $company_information;
            $this->data['employee_information'] = $employee_information;
            $this->data['employee_name'] = $employee_name;
            $this->data['designation'] = $designation;
            $this->data['pf_funds_report_by_employee_id'] = $pf_funds_report_by_employee_id;
            $this->load->view('reports/pf_funds_report/pf_funds_total_report/employee_total_pf_funds_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_pf_funds_report_by_employee_id($employee_id)
    {
        if ($employee_id <= 0 || $employee_id == '') {
            $pf_funds_report_by_employee_id = $this->db->query("SELECT p.id, p.employee_id, p.pf_contribution_per_month, p.total_deposit_amount, p.starting_date, p.user_id, e.employee_name, e.employee_code, e.designation, u.user_name, u.user_type FROM pf_funds p JOIN employee_info e ON p.employee_id=e.id JOIN user_info u ON p.user_id=u.id")->result();
        } else {
            $pf_funds_report_by_employee_id = $this->db->query("SELECT p.id, p.employee_id, p.pf_contribution_per_month, p.total_deposit_amount, p.starting_date, p.user_id, e.employee_name, e.employee_code, e.designation, u.user_name, u.user_type FROM pf_funds p JOIN employee_info e ON p.employee_id=e.id JOIN user_info u ON p.user_id=u.id WHERE p.employee_id ='$employee_id'")->result();
        }
        return $pf_funds_report_by_employee_id;
    }
}
