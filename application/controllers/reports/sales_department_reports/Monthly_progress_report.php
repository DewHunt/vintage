<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Monthly_progress_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Product_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Invoice_details_Model');
        $this->load->model('Sale_product_Model');
        $this->load->model('Client_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Employee_target_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $this->data['title'] = "Monthly Progress Report";
            $this->data['page_title'] = "Monthly Progress Report";
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id'];
            $this->data['user_type'] = $this->User_Model->get_loggedin_user_type();
            $employee_id = $this->User_Model->get_loggedin_user_employee_id();
            $this->data['employee_info'] = $this->Employee_Model->get_employee($employee_id);
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $this->data['employee_list'] = $this->Employee_Model->get_employee();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/sales_department_reports/monthly_progress_report/monthly_progress_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function monthly_progress_report_show_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $this->data['report_title'] = "Monthly Progress Report";
            $employee_ids = (($this->input->post('employee_id')));
            $start_month_year = trim($this->input->post('start_month_year'));
            $end_month_year = trim($this->input->post('end_month_year'));
            if (empty($start_month_year) || empty($end_month_year)) {
                echo "<div class='error text-align-center'>Please Select Duration</div>";
            } else {
                if (!empty($employee_ids)) {
                    $employee_names = $this->Employee_Model->get_comma_seperated_employee_names($employee_ids);
                } else {
                    $employee_names = 'All';
                }
                $this->data['user_type'] = $this->User_Model->get_loggedin_user_type();
                $this->data['print_access'] = $this->User_Model->is_loggedin_user_print_access();
                $this->data['company_information'] = $this->Company_Model->get_company();
                $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
                $this->data['month_duration_count'] = get_month_diff($start_month_year, $end_month_year);
                $this->data['monthly_progress_report'] = $this->Employee_Model->get_monthly_progress_report($start_month_year, $end_month_year, $employee_ids);
                $this->data['employee_names'] = $employee_names;
                $this->data['start_month_year'] = $start_month_year;
                $this->data['end_month_year'] = $end_month_year;
                $this->load->view('reports/sales_department_reports/monthly_progress_report/monthly_progress_report_table', $this->data);
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

}
