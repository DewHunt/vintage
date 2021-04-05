<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher_report extends CI_Controller {

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
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $this->data['title'] = "Voucher Report";
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/accounts_report/voucher_report/voucher_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function voucher_report_show() {  //voucher report show in table
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $voucher_posting_details_by_date = $this->Voucher_posting_details_Model->get_voucher_posting_details_by_date($start_date, $end_date);
            $this->data['voucher_posting_details_by_date'] = $voucher_posting_details_by_date;
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->load->view('reports/accounts_report/voucher_report/voucher_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function voucher_details_report_modal_show() {  //voucher report details show in Modal
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['currency_settings'] = $currency_settings;
            $id = trim($this->input->post('id'));  // voucher posting details id
            $voucher_details_information_by_voucher_posting_details_id = $this->get_voucher_details_information_by_voucher_posting_details_id($id);
            $this->data['voucher_details_information_by_voucher_posting_details_id'] = $voucher_details_information_by_voucher_posting_details_id;
            $voucher_details_information_by_voucher_posting_details_id_row = $this->get_voucher_details_information_by_voucher_posting_details_id_row($id);
            $this->data['voucher_details_information_by_voucher_posting_details_id_row'] = $voucher_details_information_by_voucher_posting_details_id_row;
            $this->load->view('reports/accounts_report/voucher_report/voucher_details_report_modal', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_voucher_details_information_by_voucher_posting_details_id($voucher_posting_details_id) {
        $query = $this->db->query("SELECT vpd.id, vpd.posting_date, vpd.voucher_number, vpd.total_debit_amount, vpd.total_credit_amount, vpd.common_narration, vpd.user_id, vd.id as voucher_details_id, vd.income_head_id, vd.expense_head_id, vd.amount, vd.invoice_number, vd.mr_number, vd.client_id, vd.employee_id, vd.month, vd.year, vd.narration, vd.debit_amount, vd.credit_amount FROM voucher_posting_details vpd JOIN voucher_details vd ON vpd.id=vd.voucher_posting_details_id WHERE vpd.id = $voucher_posting_details_id")->result();
        return $query;
    }

    public function get_voucher_details_information_by_voucher_posting_details_id_row($voucher_posting_details_id) {
        $query = $this->db->query("SELECT vpd.id, vpd.posting_date, vpd.voucher_number, vpd.total_debit_amount, vpd.total_credit_amount, vpd.common_narration, vpd.user_id, vd.id as voucher_details_id, vd.income_head_id, vd.expense_head_id, vd.amount, vd.invoice_number, vd.mr_number, vd.client_id, vd.employee_id, vd.month, vd.year, vd.narration, vd.debit_amount, vd.credit_amount FROM voucher_posting_details vpd JOIN voucher_details vd ON vpd.id=vd.voucher_posting_details_id WHERE vpd.id = $voucher_posting_details_id");
        return $query->row();
    }

}
