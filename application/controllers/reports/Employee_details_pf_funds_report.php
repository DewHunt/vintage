<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_details_pf_funds_report extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Employee_Model');
    }

    public function index()
    {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $this->data['title'] = "Employee P/F Funds Details Report";
            $employee_list = $this->Employee_Model->get_employee();
            $this->data['employee_list'] = $employee_list;
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/pf_funds_report/pf_funds_details_report/employee_details_pf_funds_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function employee_details_pf_funds_report_show()
    {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
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
            $pf_funds_details_report_by_employee_id_and_date = $this->get_pf_funds_details_report_by_employee_id__and_date($employee_id, $start_date, $end_date);
            $this->data['company_information'] = $company_information;
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->data['employee_information'] = $employee_information;
            $this->data['employee_name'] = $employee_name;
            $this->data['designation'] = $designation;
            $this->data['pf_funds_details_report_by_employee_id_and_date'] = $pf_funds_details_report_by_employee_id_and_date;
            $this->load->view('reports/pf_funds_report/pf_funds_details_report/employee_details_pf_funds_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_pf_funds_details_report_by_employee_id__and_date($employee_id, $start_date, $end_date)
    {
        if ($employee_id <= 0 || $employee_id == '') {
            $pf_funds_details_report_by_employee_id_and_date = $this->db->query("SELECT pd.id, pd.employee_id, pd.deposit_date, pd.previous_deposit_amount, pd.deposit_amount, pd.deposit_amount_total, pd.user_id, pd.salary_details_id, e.employee_name, e.employee_code, e.designation, u.user_name, u.user_type FROM pf_funds_details pd JOIN employee_info e ON pd.employee_id=e.id JOIN user_info u ON pd.user_id= u.id WHERE pd.deposit_date >= '$start_date' AND pd.deposit_date <= '$end_date'")->result();
        } else {
            $pf_funds_details_report_by_employee_id_and_date = $this->db->query("SELECT pd.id, pd.employee_id, pd.deposit_date, pd.previous_deposit_amount, pd.deposit_amount, pd.deposit_amount_total, pd.user_id, pd.salary_details_id, e.employee_name, e.employee_code, e.designation, u.user_name, u.user_type FROM pf_funds_details pd JOIN employee_info e ON pd.employee_id=e.id JOIN user_info u ON pd.user_id= u.id WHERE pd.employee_id ='$employee_id' AND pd.deposit_date >= '$start_date' AND pd.deposit_date <= '$end_date'")->result();
        }
        return $pf_funds_details_report_by_employee_id_and_date;
    }
}
