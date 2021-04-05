<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_details_ledger_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('User_Model');
        $this->load->model('Product_Model');
        $this->load->model('Client_Model');
        $this->load->model('Bank_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Payment_Model');
        $this->load->model('Client_sales_details_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $this->data['title'] = "Client Details Ledger Report";
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
            $this->load->view('reports/client_details_ledger_report/client_details_ledger_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function client_details_ledger_report_show_in_table() {  // show in table
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id'];
            $user_type = $user_info['user_type'];
            $client_id = trim($this->input->post('client_id'));
            $start_date = get_start_date_format(trim($this->input->post('start_date')));
            $end_date = get_end_date_format(trim($this->input->post('end_date')));
            $client_information = $this->Client_Model->get_client($client_id);
            $flag = FALSE;
            if (!empty($client_information)) {
                $client_name = $client_information->client_name;
                $flag = TRUE;
            } else {
                $client_name = 'All';
            }
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['currency_settings'] = $currency_settings;

            if ((int) $client_id < 0) {  // please select value= -1
                echo '<div class="error-message text-align-center">Please Select a Date and Client</div>';
            } else {
                $report_array = array();
                $client_details_ledger = array();
                $client_list = $this->Client_Model->get_client();
                if (!empty($client_list)) {
                    foreach ($client_list as $client) {
                        if (($flag) && ((int) $client_id === (int) $client->id)) { // for single client
                            $client_details_ledger = $this->get_client_details_ledger($client, $start_date, $end_date);
                            array_push($report_array, $client_details_ledger);
                            $client_details_ledger = $report_array;
                        } elseif (!$flag) { // for all client
                            $client_details_ledger = $this->get_client_details_ledger($client, $start_date, $end_date);
                            array_push($report_array, $client_details_ledger);
                            $client_details_ledger = $report_array;
                        }
                    }
                }
                $this->data['client_details_ledger'] = $client_details_ledger;
                $this->data['client_name'] = $client_name;
                $this->data['start_date'] = $start_date;
                $this->data['end_date'] = $end_date;
                $this->load->view('reports/client_details_ledger_report/client_details_ledger_report_table', $this->data);
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_client_details_ledger($client, $start_date, $end_date) {
        $receive_amount = 0;
        $total_advance_amount = 0;
        $opening_credit_balance = 0;
        $total_sale = 0;
        $total_payment_amount = 0;
        $closing_amount = 0;
        $client_name = '';
        $client_code = '';
        $dealer_code = '';
        $employee_code = '';
        $type = '';
        $client_all_sales_details_by_date = $this->Client_sales_details_Model->get_client_all_sales_details_by_date($client->id, $start_date, $end_date);
        $last_client_sales_details_by_date = $this->Client_sales_details_Model->get_last_client_sales_details_by_date($client->id, $start_date);
        $client_sales_details_by_end_date = $this->Client_sales_details_Model->get_client_sales_details_by_end_date($client->id, $end_date);
        $total_payment_amount = $this->Payment_Model->get_clientwise_payment_total_amount_by_date($client->id, $start_date, $end_date);
        $total_payment_amount = !empty($total_payment_amount) ? $total_payment_amount : 0;
        if (!empty($client_all_sales_details_by_date)) {
            foreach ($client_all_sales_details_by_date as $client_sales_details) {
                $client_name = $client_sales_details->client_name;
                $client_code = $client_sales_details->client_code;
                $dealer_code = $client_sales_details->dealer_code;
                $employee_code = $client_sales_details->employee_code;
                $opening_credit_balance = !empty($last_client_sales_details_by_date) ? $last_client_sales_details_by_date->total_credit_balance : 0;
                $total_sale += $client_sales_details->total_sale;
                //$total_payment_amount += $client_sales_details->total_payment;
                $total_advance_amount += $client_sales_details->total_advance_balance;
            }
//            $closing_amount = 0;
//            if (!empty($client_sales_details_by_end_date)) {
//                if ((double) $client_sales_details_by_end_date->total_credit_balance > 0) {
//                    $closing_amount = (double) $client_sales_details_by_end_date->total_credit_balance;
//                    $type = '(Dr)';
//                } else {
//                    $closing_amount = (double) $client_sales_details_by_end_date->total_advance_balance;
//                    $type = '(Cr)';
//                }
//            }
//            if ($closing_amount == 0) {
//                $type = '';
//            }
        }
        $arr = array(
            'client_name' => $client->client_name,
            'client_code' => $client->client_code,
            'dealer_code' => $dealer_code,
            'employee_code' => $employee_code,
            'opening_balance' => $opening_credit_balance,
            'total_sale' => $total_sale,
            'total_payment' => $total_payment_amount,
            'closing_amount' => ($total_sale - $total_payment_amount), //abs($closing_amount),
            'type' => (($total_sale - $total_payment_amount) > 0) ? '(Dr)' : '(Cr)', //$type, // dr or cr
        );
        return $arr;
    }

}
