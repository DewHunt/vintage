<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Monthly_expences_report extends CI_Controller {

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
        $this->load->model('Remove_head_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $this->data['title'] = "Monthly Expences Report";
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/accounts_report/monthly_expences_report/monthly_expences_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function monthly_expences_report_show_in_table() {  //report show in table
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $year = trim($this->input->post('year'));
//            $expense_head_details_list = $this->Head_details_Model->get_expense_head_details();
            $expense_head_details_list = $this->get_monthly_expences_report();
            $this->data['expense_head_details_list'] = $expense_head_details_list;
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['year'] = $year;
            $this->load->view('reports/accounts_report/monthly_expences_report/monthly_expences_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    private function get_monthly_expences_report() {
        $arr = array();
//        $expense_head_details_list = $this->Head_details_Model->get_expense_head_details();
        $expense_head_details_list = $this->Head_details_Model->get_head_details();
        $remove_head_list = $this->Remove_head_Model->get_remove_head();
        if (!empty($expense_head_details_list)) {
            foreach ($expense_head_details_list as $expense_head_details) {
                $flag = FALSE;
                foreach ($remove_head_list as $remove_head) {
                    if (intval($remove_head->head_id) == intval($expense_head_details->id)) {
                        $flag = TRUE;
                    }
                }
                if (!$flag) {
                    array_push($arr, $expense_head_details);
                }
            }
        }
        return $arr;
    }

}
