<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Payment_Model');
        $this->load->model('Invoice_details_Model');
        $this->load->model('Client_Model');
        $this->load->model('Dealer_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Sale_product_Model');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Branch_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $this->data['title'] = "Payment Report";
            $this->data['branch_list'] = $this->Branch_Model->get_branch();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/payment_report/payment_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function payment_report_show_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id'];
            $user_type = $user_info['user_type'];
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            $branch_id = intval(trim($this->input->post('branch_id')));
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['currency_settings'] = $currency_settings;
            $user_info = $this->User_Model->get_user($user_id);
            $employee_id = $user_info->employee_id;
            $payment_list = $this->Payment_Model->get_payment();
            $this->data['payment_list'] = $payment_list;
            $payment_report_list = $this->payment_report_view($start_date, $end_date, $branch_id);
            $this->data['payment_report_list'] = $payment_report_list;
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->load->view('reports/payment_report/payment_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function payment_report_modal_show() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $id = $this->input->post('id');
            $payment_report_by_payment_id = $this->payment_report_by_payment_id($id);
            $this->data['payment_report_by_payment_id'] = $payment_report_by_payment_id;
            $payment_list = $this->Payment_Model->get_payment();
            $this->data['payment_list'] = $payment_list;
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['currency_settings'] = $currency_settings;
            $this->load->view('reports/payment_report/payment_report_modal', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function payment_report_view($start_date, $end_date, $branch_id) {
        $where_condition = (intval($branch_id) > 0) ? "p.receipt_date >= '$start_date' AND p.receipt_date <= '$end_date' AND p.branch_id = '$branch_id' ORDER BY p.id DESC" : "p.receipt_date >= '$start_date' AND p.receipt_date <= '$end_date' ORDER BY p.id DESC";
        $payment_report_list = $this->db->query("SELECT p.id, p.receipt_mr_no, p.receipt_date, p.amount_received, p.payment_type, p.invoice_number, p.remarks, p.branch_id, p.branch_mr_no, c.client_name, br.branch_name FROM payment p JOIN client_info c ON p.client_id=c.id LEFT JOIN branch_info br ON p.branch_id = br.id WHERE $where_condition")->result();
        return $payment_report_list;
    }

    public function payment_report_by_payment_id($id = 0) {
        $payment_report_by_payment_id = $this->db->query("SELECT p.id, p.receipt_mr_no, p.receipt_date, p.client_id, p.amount_received, p.client_code, p.payment_type, p.cheque_number, p.cheque_date, p.bank_id, p.branch_name, p.purpose, p.invoice_number, p.remarks, p.branch_id, p.branch_mr_no, c.client_name, c.address AS client_address, b.bank_name, br.branch_name FROM payment p JOIN client_info c ON p.client_id=c.id LEFT JOIN bank_info b ON p.bank_id=b.id LEFT JOIN branch_info br ON p.branch_id = br.id WHERE p.id = '$id'")->row();
        return $payment_report_by_payment_id;
    }

}
