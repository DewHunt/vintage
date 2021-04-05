<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Account_statement_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Head_details_Model');
        $this->load->model('Daywise_head_posting_Model');
        $this->load->model('Financial_statement_accounts_assign_Model');
        $this->load->model('User_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == TRUE)) {
            redirect(base_url());
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function trading_account() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == TRUE)) {
            $this->data['title'] = "Trading Account Report";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/accounts_report/account_statement_report/trading_account_report/trading_account_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function profit_and_loss_account() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == TRUE)) {
            $this->data['title'] = "Profit and Loss Account Report";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/accounts_report/account_statement_report/profit_and_loss_account_report/profit_and_loss_account_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function profit_and_loss_account_appropriation() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == TRUE)) {
            $this->data['title'] = "Profit and Loss Appropriation Report";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/accounts_report/account_statement_report/profit_and_loss_appropriation_report/profit_and_loss_appropriation_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function balance_sheet() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == TRUE)) {
            $this->data['title'] = "Balance Sheet Report";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/accounts_report/account_statement_report/balance_sheet_report/balance_sheet_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function statement_report_show_in_table() {
        // 1 == for trading account
        // 2 == profit and loss account
        // 3 == profit and loss appropriation account
        // 4 == balance sheet
        // 5 == trail balance
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == TRUE)) {
            $year = trim($this->input->post('year'));
            $start_date = get_start_date_format(trim($this->input->post('start_date')));
            $end_date = get_end_date_format(trim($this->input->post('end_date')));
            $is_custom = intval(trim($this->input->post('is_custom'))); // use for showing table title 
            $financial_statement_accounts_id = trim($this->input->post('financial_statement_accounts_id'));
            if (empty($year) || empty($financial_statement_accounts_id) || empty($start_date) || empty($end_date)) {
                echo '<div class="error-message text-align-center">Please Select Year.</div>';
            } else {
                $this->data['account_statement_report'] = $this->Financial_statement_accounts_assign_Model->get_statement($start_date, $end_date, $financial_statement_accounts_id);
//                echo '<pre>';
//                print_r($this->data['account_statement_report']);
//                echo '</pre>';
                $this->data['year'] = $year;
                $this->data['start_date'] = $start_date;
                $this->data['end_date'] = $end_date;
                $this->data['is_custom'] = $is_custom;
                $this->data['print_report_heading'] = $this->get_print_report_heading($financial_statement_accounts_id);
                $this->data['company_information'] = $this->Company_Model->get_company();
                $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
                $this->load->view('reports/accounts_report/account_statement_report/statement_report_table', $this->data);
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_print_report_heading($financial_statement_accounts_id) {
        // 1 == for trading account
        // 2 == profit and loss account
        // 3 == profit and loss appropriation account
        // 4 == balance sheet
        // 5 == trail balance
        $print_report_heading = '';
        if ((int) $financial_statement_accounts_id == 1) {
            $print_report_heading = 'Trading Account';
        } elseif ((int) $financial_statement_accounts_id == 2) {
            $print_report_heading = 'Profit and Loss Account';
        } elseif ((int) $financial_statement_accounts_id == 3) {
            $print_report_heading = 'Profit and Loss Appropriation';
        } elseif ((int) $financial_statement_accounts_id == 4) {
            $print_report_heading = 'Balance Sheet';
        } else {
            $print_report_heading = 'Trail Balance';
        }
        return $print_report_heading;
    }

}
