<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employeewise_details_ledger_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('User_Model');
        $this->load->model('Product_Model');
        $this->load->model('Client_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Dealer_Model');
        $this->load->model('Bank_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Payment_Model');
        $this->load->model('Client_sales_details_Model');
        $this->load->model('Client_transaction_details_Model');
        $this->load->model('Invoice_details_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $this->data['title'] = "Employeewise Details Ledger Report";
            $this->data['page_title'] = "Employeewise Details Ledger Report";
            $this->data['user_type'] = $this->User_Model->get_loggedin_user_type();
            $employee_id = $this->User_Model->get_loggedin_user_employee_id();
            $this->data['employee_info'] = $this->Employee_Model->get_employee($employee_id);
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $this->data['employee_list'] = $this->Employee_Model->get_employee();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/employeewise_details_ledger_report/employeewise_details_ledger_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    //debit change into credit and credit change into debit
    public function employeewise_details_ledger_report_show_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $this->data['title'] = "Employeewise Details Ledger Report";
            $this->data['page_title'] = "Employeewise Details Ledger Report";
            $employee_id = intval(trim($this->input->post('employee_id')));
            $start_date = get_start_date_format(trim($this->input->post('start_date')));
            $end_date = get_end_date_format(trim($this->input->post('end_date')));
            if (intval($employee_id) > 0) {
                $employee_information = $this->Employee_Model->get_employee($employee_id);
                $employee_name = !empty($employee_information) ? $employee_information->employee_name : '';
                $employee_code = !empty($employee_information) ? $employee_information->employee_code : '';
                $this->data['employeewise_client_details_ledger_report'] = $this->get_employeewise_client_details_ledger_report($start_date, $end_date, $employee_id);
                $this->data['company_information'] = $this->Company_Model->get_company();
                $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
                $this->data['start_date'] = $start_date;
                $this->data['end_date'] = $end_date;
                $this->data['employee_name'] = $employee_name;
                $this->data['employee_code'] = $employee_code;
                $this->load->view('reports/employeewise_details_ledger_report/employeewise_details_ledger_report_table', $this->data);
            } else {
                echo '<div class="error-message text-align-center">Please Select Employee.</div>';
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_employeewise_client_details_ledger_report($start_date, $end_date, $employee_id = 0) {
        $client_all_individual_ledger_details = array();
        $sum_of_amount_to_paid = 0;
        $sum_of_amount_received = 0;
        if (intval($employee_id) > 0) {
            $client_list = $this->Client_Model->get_client_list_employee_id($employee_id);
        } else {
            $client_list = $this->Client_Model->get_client();
        }
        if (!empty($client_list)) {
            foreach ($client_list as $client) {
                $client_id = $client->id;
                $client_name = $client->client_name;
                $opening_balance = $this->get_opening_balance($client_id, $start_date);
                $closing_balance = $this->get_closing_balance($client_id, $end_date);
                $client_total_transaction_details_by_date = $this->Client_transaction_details_Model->get_client_total_transaction_details_by_date($client_id, $start_date, $end_date);
                $sum_of_amount_to_paid = $this->Invoice_details_Model->get_clientwise_sale_total_amount_by_date($client_id, $start_date, $end_date);
                $sum_of_amount_received = $this->Payment_Model->get_clientwise_payment_total_amount_by_date($client_id, $start_date, $end_date);
                $data_array = array(
                    'client_id' => $client_id,
                    'client_name' => $client_name,
                    'opening_balance' => !empty($opening_balance) ? $opening_balance : 0,
                    'total_debit_amount' => $sum_of_amount_received,
                    'total_credit_amount' => $sum_of_amount_to_paid,
                    'closing_balance' => !empty($closing_balance) ? $closing_balance : 0,
                );
                array_push($client_all_individual_ledger_details, $data_array);
            }
        }
        if (!empty($client_all_individual_ledger_details)) {

            function compare_by_client_name($a, $b) {
                return strcmp($a["client_name"], $b["client_name"]);
            }

            usort($client_all_individual_ledger_details, 'compare_by_client_name');
        }
        return $client_all_individual_ledger_details;
    }

    public function get_opening_balance($client_id, $start_date) {
        $opening_balance = 0;
        $last_client_transaction_details_by_date = $this->Client_transaction_details_Model->get_last_client_transaction_details_by_date($client_id, $start_date);
        if (!empty($last_client_transaction_details_by_date)) {
            $client_current_date_first_transaction_for_opening = $this->Client_transaction_details_Model->get_client_current_date_first_transaction($client_id, $start_date);
            $opening_balance = !empty($client_current_date_first_transaction_for_opening) ? $client_current_date_first_transaction_for_opening->opening_balance : 0;
        } else {
            $client_last_transaction_from_current_date_for_opening = $this->Client_transaction_details_Model->get_client_last_transaction_from_current_date($client_id, $start_date);
            $opening_balance = !empty($client_last_transaction_from_current_date_for_opening) ? $client_last_transaction_from_current_date_for_opening->closing_balance : 0;
        }
        return $opening_balance;
    }

    public function get_closing_balance($client_id, $end_date) {
        $closing_balance = 0;
        $end_client_transaction_details_by_date = $this->Client_transaction_details_Model->get_last_client_transaction_details_by_date($client_id, $end_date);
        if (!empty($end_client_transaction_details_by_date)) {
            $closing_balance = $end_client_transaction_details_by_date->closing_balance;
        } else {
            $client_last_transaction_from_current_date_for_closing = $this->Client_transaction_details_Model->get_client_last_transaction_from_current_date($client_id, $end_date);
            $closing_balance = !empty($client_last_transaction_from_current_date_for_closing) ? $client_last_transaction_from_current_date_for_closing->closing_balance : 0;
        }
        return $closing_balance;
    }

}
