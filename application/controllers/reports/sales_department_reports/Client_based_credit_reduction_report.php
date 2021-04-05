<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_based_credit_reduction_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Product_Model');
        $this->load->model('Invoice_details_Model');
        $this->load->model('Sale_product_Model');
        $this->load->model('Client_Model');
        $this->load->model('Employee_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $this->data['title'] = "Client Based Credit Reduction Report";
            $this->data['page_title'] = "Client Based Credit Reduction Report";
            $this->data['user_type'] = $this->User_Model->get_loggedin_user_type();
            $employee_id = $this->User_Model->get_loggedin_user_employee_id();
            $this->data['employee_info'] = $this->Employee_Model->get_employee($employee_id);
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $client_list = $this->Client_Model->get_client();
            $this->data['client_list'] = $client_list;
            $all_client_by_employee_id = $this->Client_Model->get_all_client_by_employee_id($employee_id);
            $this->data['all_client_by_employee_id'] = $all_client_by_employee_id;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/sales_department_reports/client_based_credit_reduction_report/client_based_credit_reduction_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function client_based_credit_reduction_report_show_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $this->data['report_title'] = "Client Based Credit Reduction Report";
            $client_ids = (($this->input->post('client_id')));
            $start_month_year = trim($this->input->post('start_month_year'));
            $end_month_year = trim($this->input->post('end_month_year'));
            if (empty($start_month_year) || empty($end_month_year) || empty($client_ids)) {
                echo "<div class='error text-align-center'>Please Select Duration and Client</div>";
            } else {
                if (!empty($client_ids)) {
                    $client_names = $this->Client_Model->get_comma_seperated_client_names($client_ids);
                } else {
                    $client_names = '';
                }
                $this->data['user_type'] = $this->User_Model->get_loggedin_user_type();
                $this->data['print_access'] = $this->User_Model->is_loggedin_user_print_access();
                $this->data['company_information'] = $this->Company_Model->get_company();
                $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
                $this->data['month_duration_count'] = get_month_diff($start_month_year, $end_month_year);
                $this->data['client_based_credit_reduction_report'] = $this->Client_Model->get_client_based_credit_reduction_report($start_month_year, $end_month_year, $client_ids);
//                get_print_r($this->db->last_query());
                $this->data['client_names'] = $client_names;
                $this->data['start_month_year'] = $start_month_year;
                $this->data['end_month_year'] = $end_month_year;
                $this->load->view('reports/sales_department_reports/client_based_credit_reduction_report/client_based_credit_reduction_report_table', $this->data);
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

}
