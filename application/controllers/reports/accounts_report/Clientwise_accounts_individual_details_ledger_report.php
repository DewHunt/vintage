<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientwise_accounts_individual_details_ledger_report extends CI_Controller {

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
        $this->load->model('Client_accounts_transaction_details_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == TRUE)) {
            $this->data['title'] = "Client Accounts Individual Details Ledger Report";
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id'];
            $user_type = $user_info['user_type'];
            $employee_id = $user_info['employee_id'];
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['currency_settings'] = $currency_settings;
            $client_list = $this->Client_Model->get_client();
            $this->data['client_list'] = $client_list;
            $all_client_by_employee_id = $this->Client_Model->get_all_client_by_employee_id($employee_id);
            $this->data['all_client_by_employee_id'] = $all_client_by_employee_id;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/accounts_report/clientwise_accounts_individual_details_ledger_report/clientwise_accounts_individual_details_ledger_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function clientwise_accounts_individual_details_ledger_report_show_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == TRUE)) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id'];
            $user_type = $user_info['user_type'];
            $employee_id = $user_info['employee_id'];
            $client_id = trim($this->input->post('client_id'));
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            $client_information = $this->Client_Model->get_client($client_id);
            if (!empty($client_information)) {
                $client_name = $client_information->client_name;
                $client_code = $client_information->client_code;
            } else {
                if ($client_id == 'import' || $client_id == 'lubzone') {
                    $client_name = 'All ' . '(' . $client_id . ')';
                    $client_code = '';
                } else {
                    $client_name = 'All';
                    $client_code = '';
                }
            }
            $start_last_client_accounts_transaction_details_by_date = $this->Client_accounts_transaction_details_Model->get_last_client_accounts_transaction_details_by_date($client_id, $start_date);
            $opening_balance = 0;
            if (!empty($start_last_client_accounts_transaction_details_by_date)) {
                $current_date_first_transaction = $this->Client_accounts_transaction_details_Model->get_current_date_first_transaction($client_id, $start_date);
                $opening_balance = $current_date_first_transaction->opening_balance;
            } else {
                $last_transaction_from_current_date_for_opening = $this->Client_accounts_transaction_details_Model->get_last_transaction_from_current_date($client_id, $start_date);
                $opening_balance = !empty($last_transaction_from_current_date_for_opening) ? $last_transaction_from_current_date_for_opening->closing_balance : 0;
            }
            $this->data['opening_balance'] = $opening_balance;
            $this->data['start_last_client_accounts_transaction_details_by_date'] = $start_last_client_accounts_transaction_details_by_date;
            $end_last_client_accounts_transaction_details_by_date = $this->Client_accounts_transaction_details_Model->get_last_client_accounts_transaction_details_by_date($client_id, $end_date);
            $closing_balance = 0;
            if (!empty($end_last_client_accounts_transaction_details_by_date)) {
                $closing_balance = $end_last_client_accounts_transaction_details_by_date->closing_balance;
            } else {
                $last_transaction_from_current_date_for_closing = $this->Client_accounts_transaction_details_Model->get_last_transaction_from_current_date($client_id, $end_date);
                $closing_balance = !empty($last_transaction_from_current_date_for_closing) ? $last_transaction_from_current_date_for_closing->closing_balance : 0;
            }
            $this->data['closing_balance'] = $closing_balance;
            $this->data['end_last_client_accounts_transaction_details_by_date'] = $end_last_client_accounts_transaction_details_by_date;
            $client_accounts_transaction_details_by_date = $this->Client_accounts_transaction_details_Model->get_client_accounts_transaction_details_by_date($client_id, $start_date, $end_date);
            $this->data['client_accounts_transaction_details_by_date'] = $client_accounts_transaction_details_by_date;
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['currency_settings'] = $currency_settings;
            $this->data['client_name'] = $client_name;
            $this->data['client_code'] = $client_code;
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            if (!empty($client_id) && ((int) $client_id > 0)) {
                $this->load->view('reports/accounts_report/clientwise_accounts_individual_details_ledger_report/clientwise_accounts_individual_details_ledger_report_table', $this->data);
            } elseif ($client_id == 'import' || $client_id == 'lubzone') {
                $client_type = trim($client_id);
                $import_or_lubzone_type_client_accounts_individual_details_ledger_report = $this->get_import_or_lubzone_type_client_accounts_individual_details_ledger_report($client_type, $start_date, $end_date, $user_type, $employee_id);
                $this->data['all_client_accounts_individual_details_ledger_report'] = $import_or_lubzone_type_client_accounts_individual_details_ledger_report;
                $this->load->view('reports/accounts_report/clientwise_accounts_individual_details_ledger_report/clientwise_accounts_all_individual_details_ledger_report_table', $this->data);
            } else {
                $all_client_accounts_individual_details_ledger_report = $this->get_all_client_accounts_individual_details_ledger_report($start_date, $end_date);
                $this->data['all_client_accounts_individual_details_ledger_report'] = $all_client_accounts_individual_details_ledger_report;
                $this->load->view('reports/accounts_report/clientwise_accounts_individual_details_ledger_report/clientwise_accounts_all_individual_details_ledger_report_table', $this->data);
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_import_or_lubzone_type_client_accounts_individual_details_ledger_report($client_type, $start_date, $end_date, $user_type, $employee_id) {
        $client_all_accounts_individual_ledger_details = array();
        if (strtolower($user_type) === 'marketing') {
            $client_list = $this->Client_Model->get_client_list_by_client_type_and_employee_id($client_type, $employee_id);
        } else {
            $client_list = $this->Client_Model->get_client_list_by_client_type($client_type);
        }
        if (!empty($client_list)) {
            foreach ($client_list as $client) {
                $client_id = $client->id;
                $client_name = ucfirst($client->client_name);
                $opening_balance = $this->get_opening_balance($client_id, $start_date);
                $closing_balance = $this->get_closing_balance($client_id, $end_date);
                $client_total_accounts_transaction_details_by_date = $this->Client_accounts_transaction_details_Model->get_client_total_accounts_transaction_details_by_date($client_id, $start_date, $end_date);
                $data_array = array(
                    'client_id' => $client_id,
                    'client_name' => $client_name,
                    'opening_balance' => !empty($opening_balance) ? $opening_balance : 0,
                    'total_debit_amount' => !empty($client_total_accounts_transaction_details_by_date) ? $client_total_accounts_transaction_details_by_date->total_debit_amount : 0,
                    'total_credit_amount' => !empty($client_total_accounts_transaction_details_by_date) ? $client_total_accounts_transaction_details_by_date->total_credit_amount : 0,
                    'closing_balance' => !empty($closing_balance) ? $closing_balance : 0,
                );
                array_push($client_all_accounts_individual_ledger_details, $data_array);
            }
        }
        return $client_all_accounts_individual_ledger_details;
    }

    public function get_all_client_accounts_individual_details_ledger_report($start_date, $end_date) {
        $client_all_accounts_individual_ledger_details = array();
        $client_list = $this->Client_Model->get_client();
        if (!empty($client_list)) {
            foreach ($client_list as $client) {
                $client_id = $client->id;
                $client_name = $client->client_name;
                $opening_balance = $this->get_opening_balance($client_id, $start_date);
                $closing_balance = $this->get_closing_balance($client_id, $end_date);
                $client_total_accounts_transaction_details_by_date = $this->Client_accounts_transaction_details_Model->get_client_total_accounts_transaction_details_by_date($client_id, $start_date, $end_date);
                $data_array = array(
                    'client_id' => $client_id,
                    'client_name' => $client_name,
                    'opening_balance' => !empty($opening_balance) ? $opening_balance : 0,
                    'total_debit_amount' => !empty($client_total_accounts_transaction_details_by_date) ? $client_total_accounts_transaction_details_by_date->total_debit_amount : 0,
                    'total_credit_amount' => !empty($client_total_accounts_transaction_details_by_date) ? $client_total_accounts_transaction_details_by_date->total_credit_amount : 0,
                    'closing_balance' => !empty($closing_balance) ? $closing_balance : 0,
                );
                array_push($client_all_accounts_individual_ledger_details, $data_array);
            }
        }
        return $client_all_accounts_individual_ledger_details;
    }

    public function get_opening_balance($client_id, $start_date) {
        $opening_balance = 0;
        $start_last_client_accounts_transaction_details_by_date = $this->Client_accounts_transaction_details_Model->get_last_client_accounts_transaction_details_by_date($client_id, $start_date);
        if (!empty($start_last_client_accounts_transaction_details_by_date)) {
            $current_date_first_transaction = $this->Client_accounts_transaction_details_Model->get_current_date_first_transaction($client_id, $start_date);
            $opening_balance = $current_date_first_transaction->opening_balance;
        } else {
            $last_transaction_from_current_date_for_opening = $this->Client_accounts_transaction_details_Model->get_last_transaction_from_current_date($client_id, $start_date);
            $opening_balance = !empty($last_transaction_from_current_date_for_opening) ? $last_transaction_from_current_date_for_opening->closing_balance : 0;
        }
        return $opening_balance;
    }

    public function get_closing_balance($client_id, $end_date) {
        $closing_balance = 0;
        $end_last_client_accounts_transaction_details_by_date = $this->Client_accounts_transaction_details_Model->get_last_client_accounts_transaction_details_by_date($client_id, $end_date);
        if (!empty($end_last_client_accounts_transaction_details_by_date)) {
            $closing_balance = $end_last_client_accounts_transaction_details_by_date->closing_balance;
        } else {
            $last_transaction_from_current_date_for_closing = $this->Client_accounts_transaction_details_Model->get_last_transaction_from_current_date($client_id, $end_date);
            $closing_balance = !empty($last_transaction_from_current_date_for_closing) ? $last_transaction_from_current_date_for_closing->closing_balance : 0;
        }
        return $closing_balance;
    }

}
