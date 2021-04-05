<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profit_and_loss_account_report extends CI_Controller {

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
            $this->data['title'] = "Profit and Loss Account Report";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/accounts_report/account_statement_report/profit_and_loss_account_report/profit_and_loss_account_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function profit_and_loss_account_report_show_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == TRUE)) {
            $this->data['title'] = "Profit and Loss Account Report";
            $year = trim($this->input->post('year'));
            $financial_statement_accounts_id = 2; // 2 = profit and loss account
            if (empty($year)) {
                echo '<div class="error-message text-align-center">Please Select Year.</div>';
            } else {
                $this->data['profit_and_loss_account_statement'] = $this->Financial_statement_accounts_assign_Model->get_statement($year, $financial_statement_accounts_id);
                $this->data['year'] = $year;
                $this->data['company_information'] = $this->Company_Model->get_company();
                $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
                $this->load->view('reports/accounts_report/account_statement_report/profit_and_loss_account_report/profit_and_loss_account_report_table', $this->data);
            }
        } else {
            redirect(base_url('user_login'));
        }
    }
    
    public function statement_report_show_in_table() {
         if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == TRUE)) {
            $this->data['title'] = "Profit and Loss Account Report";
            $year = trim($this->input->post('year'));
            $financial_statement_accounts_id = 2; // 2 = profit and loss account
            if (empty($year)) {
                echo '<div class="error-message text-align-center">Please Select Year.</div>';
            } else {
                $this->data['account_statement_report'] = $this->Financial_statement_accounts_assign_Model->get_statement($year, $financial_statement_accounts_id);
                $this->data['year'] = $year;
                $this->data['company_information'] = $this->Company_Model->get_company();
                $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
                $this->load->view('reports/accounts_report/account_statement_report/statement_report_table', $this->data);
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

}
