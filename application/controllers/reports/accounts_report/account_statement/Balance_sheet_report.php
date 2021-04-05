<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Balance_sheet_report extends CI_Controller {

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
            $this->data['title'] = "Balance Sheet Report";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/accounts_report/account_statement_report/balance_sheet_report/balance_sheet_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function balance_sheet_report_show_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == TRUE)) {
            $this->data['title'] = "Balance Sheet Report";
            $year = trim($this->input->post('year'));
            $financial_statement_accounts_id = 4; // 3 = Balance Sheet
            if (empty($year)) {
                echo '<div class="error-message text-align-center">Please Select Year.</div>';
            } else {
                $this->data['dr'] = $this->Financial_statement_accounts_assign_Model->get_account_statement_report_for_dr($year, $financial_statement_accounts_id);
                $this->data['cr'] = $this->Financial_statement_accounts_assign_Model->get_account_statement_report_for_cr($year, $financial_statement_accounts_id);
                $this->data['profit_and_loss_appropriation_balance_profit_or_loss'] = $this->Financial_statement_accounts_assign_Model->get_total_balance_array_for_dr_and_cr($year, 3); // for getting Profit and Loss Appropriation loss or profit                
                $this->data['year'] = $year;
                $this->data['company_information'] = $this->Company_Model->get_company();
                $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
                $this->load->view('reports/accounts_report/account_statement_report/balance_sheet_report/balance_sheet_report_table', $this->data);
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

}
