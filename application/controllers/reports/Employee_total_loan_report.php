<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_total_loan_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Employee_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $this->data['title'] = "Employee Total Loan Report";
            $this->data['employee_list'] = $this->Employee_Model->get_employee();
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/loan_report/employee_total_loan_report/employee_total_loan_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function employee_wise_total_loan_report_show() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            $employee_id = trim($this->input->post('employee_id'));
            $employee_information = $this->Employee_Model->get_employee($employee_id);
            if (!empty($employee_information)) {
                $employee_name = $employee_information->employee_name;
                $designation = $employee_information->designation;
            } else {
                $employee_name = 'All';
                $designation = 'All';
            }
            $total_loan_report_by_employee_id_and_date = $this->get_total_loan_report_by_employee_id_and_date($employee_id, $start_date, $end_date);
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->data['employee_information'] = $employee_information;
            $this->data['employee_name'] = $employee_name;
            $this->data['designation'] = $designation;
            $this->data['total_loan_report_by_employee_id_and_date'] = $total_loan_report_by_employee_id_and_date;
            $this->load->view('reports/loan_report/employee_total_loan_report/employee_total_loan_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_total_loan_report_by_employee_id_and_date($employee_id, $start_date, $end_date) {
        if ($employee_id <= 0 || $employee_id == '') {
            $where_condition = "WHERE l.loan_start_date >= '$start_date' AND l.loan_start_date <= '$end_date'";
        } else {
            $where_condition = "WHERE l.employee_id = $employee_id AND l.loan_start_date >= '$start_date' AND l.loan_start_date <= '$end_date'";
        }
        $total_loan_report_by_employee_id_and_date = $this->db->query("SELECT l.id, l.employee_id, l.loan_start_date, l.total_loan_amount, l.number_of_installment, l.per_installment_amount, l.total_installment_amount, l.details, l.user_id, e.employee_name, e.employee_code, e.designation, u.user_name, u.user_type FROM loan l JOIN employee_info e ON l.employee_id=e.id JOIN user_info u ON l.user_id=u.id $where_condition")->result();
        return $total_loan_report_by_employee_id_and_date;
    }

    public function employee_current_loan_report() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == true)) {
            $this->data['title'] = "Employee Current Loan Report";
            $this->data['employee_list'] = $this->Employee_Model->get_employee();
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/loan_report/employee_current_loan_report/employee_current_loan_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function employee_current_total_loan_report_show() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $employee_id = trim($this->input->post('employee_id'));
            $employee_information = $this->Employee_Model->get_employee($employee_id);
            if (!empty($employee_information)) {
                $employee_name = $employee_information->employee_name;
                $designation = $employee_information->designation;
            } else {
                $employee_name = 'All';
                $designation = 'All';
            }
            $employee_current_loan_report_by_employee_id = $this->get_employee_current_loan_report_by_employee_id($employee_id);
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['employee_information'] = $employee_information;
            $this->data['employee_name'] = $employee_name;
            $this->data['designation'] = $designation;
            $this->data['employee_current_loan_report_by_employee_id'] = $employee_current_loan_report_by_employee_id;
            $this->load->view('reports/loan_report/employee_current_loan_report/employee_current_loan_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_employee_current_loan_report_by_employee_id($employee_id) {
        if ($employee_id <= 0 || $employee_id == '') {
            $where_condition = "WHERE e.current_loan_id > 0";
        } else {
            $where_condition = "WHERE e.current_loan_id > 0 AND l.employee_id = $employee_id";
        }
        $employee_current_loan_report_by_employee_id = $this->db->query("SELECT l.id, l.employee_id, l.loan_start_date, l.total_loan_amount, l.number_of_installment, l.per_installment_amount, l.total_installment_amount, l.details, l.user_id, e.employee_name, e.employee_code, e.current_loan_id, u.user_name, u.user_type FROM loan l JOIN employee_info e ON l.employee_id=e.id JOIN user_info u ON l.user_id=u.id $where_condition")->result();
        return $employee_current_loan_report_by_employee_id;
    }

    //employee_details_loan_report
    public function employee_details_loan_report() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $this->data['title'] = "Employee Details Loan Report";
            $this->data['employee_list'] = $this->Employee_Model->get_employee();
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/loan_report/employee_details_loan_report/employee_details_loan_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function employee_details_loan_report_show() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            $employee_id = trim($this->input->post('employee_id'));
            $employee_information = $this->Employee_Model->get_employee($employee_id);
            if (!empty($employee_information)) {
                $employee_name = $employee_information->employee_name;
                $designation = $employee_information->designation;
            } else {
                $employee_name = 'All';
                $designation = 'All';
            }
            $employee_loan_details_report_by_employee_id_and_date = $this->get_employee_loan_details_report_by_employee_id_and_date($employee_id, $start_date, $end_date);
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->data['employee_information'] = $employee_information;
            $this->data['employee_name'] = $employee_name;
            $this->data['designation'] = $designation;
            $this->data['employee_loan_details_report_by_employee_id_and_date'] = $employee_loan_details_report_by_employee_id_and_date;
            $this->load->view('reports/loan_report/employee_details_loan_report/employee_details_loan_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_employee_loan_details_report_by_employee_id_and_date($employee_id, $start_date, $end_date) {
        if ($employee_id <= 0 || $employee_id == '') {
            $where_condition = "WHERE ld.loan_payment_date >= '$start_date' AND ld.loan_payment_date <= '$end_date'";
        } else {
            $where_condition = "WHERE ld.employee_id = $employee_id AND ld.loan_payment_date >= '$start_date' AND ld.loan_payment_date <= '$end_date'";
        }
        $employee_loan_details_report_by_employee_id_and_date = $this->db->query("SELECT ld.id, ld.loan_id, ld.employee_id, ld.month, ld.year, ld.loan_payment_date, ld.per_installment, ld.total_loan_amount, ld.previous_loan_payment, ld.total_loan_payment, ld.due_loan_amount, ld.user_id, e.employee_name, e.employee_code, e.designation, u.user_name, u.user_type FROM loan_details ld JOIN employee_info e ON ld.employee_id = e.id JOIN user_info u ON ld.user_id = u.id $where_condition")->result();
        return $employee_loan_details_report_by_employee_id_and_date;
    }

}
