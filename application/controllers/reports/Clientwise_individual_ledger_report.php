<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientwise_individual_ledger_report extends CI_Controller {

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
            $this->load->view('reports/clientwise_individual_ledger_report/clientwise_individual_ledger_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function clientwise_individual_ledger_report_show_in_table() {

        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id'];
            $user_type = $user_info['user_type'];
            $client_id = trim($this->input->post('client_id'));
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            $client_information = $this->Client_Model->get_client($client_id);
            if (!empty($client_information)) {
                $client_name = $client_information->client_name;
                $client_code = $client_information->client_code;
            } else {
                $client_name = 'All';
                $client_code = '';
            }
            $client_individual_ledger = '';
            if (((int) $client_id > 0)) {
                $client_individual_ledger = $this->get_client_individual_ledger($client_id, $start_date, $end_date);
            }
            $this->data['client_individual_ledger'] = $client_individual_ledger;
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['currency_settings'] = $currency_settings;
            $this->data['client_name'] = $client_name;
            $this->data['client_code'] = $client_code;
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->load->view('reports/clientwise_individual_ledger_report/clientwise_individual_ledger_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_client_individual_ledger($client_id, $start_date, $end_date) {
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
        $report_array = array();
        $client_all_sales_details_by_date = $this->Client_sales_details_Model->get_client_all_sales_details_by_date($client_id, $start_date, $end_date);

        if (!empty($client_all_sales_details_by_date)) {
            foreach ($client_all_sales_details_by_date as $client_sales_details) {
                $last_client_sales_details_by_date = $this->Client_sales_details_Model->get_last_client_sales_details_by_date($client_id, $client_sales_details->sale_date);
                $client_sales_details_by_end_date = $this->Client_sales_details_Model->get_last_client_sales_details_by_end_date($client_id, $client_sales_details->sale_date);

                $client_name = $client_sales_details->client_name;
                $client_code = $client_sales_details->client_code;
                $sale_date = $client_sales_details->sale_date;
                $dealer_code = $client_sales_details->dealer_code;
                $employee_code = $client_sales_details->employee_code;
                $opening_credit_balance = !empty($last_client_sales_details_by_date) ? $last_client_sales_details_by_date->total_credit_balance : 0;
                $total_sale = $client_sales_details->total_sale;

                $total_payment_amount = $client_sales_details->total_payment;

//                $total_advance_amount += $client_sales_details->total_advance_balance;
                $total_advance_amount = $client_sales_details->total_advance_balance;
                $receive_amount = $total_payment_amount + $total_advance_amount;
                $result = (double) $opening_credit_balance + (double) $total_sale;
                $closing_amount = 0;
                if (!empty($client_sales_details_by_end_date)) {
                    if ((double) $client_sales_details_by_end_date->total_credit_balance > 0) {
                        $closing_amount = $client_sales_details_by_end_date->total_credit_balance;
                        $type = '(Dr)';
                    } else {
                        $closing_amount = $client_sales_details_by_end_date->total_advance_balance;
                        $type = '(Cr)';
                    }
                }
                if ($closing_amount == 0) {
                    $type = '';
                }
                $arr = array(
                    'client_id' => $client_id,
                    'client_name' => $client_name,
                    'client_code' => $client_code,
                    'sale_date' => $sale_date,
                    'opening_balance' => $opening_credit_balance,
                    'total_sale' => $total_sale,
                    'total_payment' => $total_payment_amount,
                    'closing_amount' => abs($closing_amount),
                    'type' => $type, // dr or cr
                );
                array_push($report_array, $arr);
            }
            return $report_array;
        }
    }

}
