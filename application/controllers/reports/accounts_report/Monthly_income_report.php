<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Monthly_income_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Voucher_posting_details_Model');
        $this->load->model('Voucher_details_Model');
        $this->load->model('Head_details_Model');
        $this->load->model('Client_accounts_transaction_details_Model');
        $this->load->model('Daywise_head_posting_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $this->data['title'] = "Monthly Income Report";
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/accounts_report/monthly_income_report/monthly_income_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function monthly_income_report_show_in_table() {  //report show in table
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $year = trim($this->input->post('year'));
//            $income_head_details_list = $this->Head_details_Model->get_income_head_details();
            $income_head_details_list = $this->Head_details_Model->get_head_details();
            $this->data['income_head_details_list'] = $income_head_details_list;
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['year'] = $year;
            $this->load->view('reports/accounts_report/monthly_income_report/monthly_income_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

}
