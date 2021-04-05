<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientwise_accounts_report extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Voucher_posting_details_Model');
        $this->load->model('Voucher_details_Model');
        $this->load->model('Head_details_Model');
        $this->load->model('Client_Model');
    }

    public function index()
    {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $this->data['title'] = "Clientwise Accounts Report";
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $client_list = $this->Client_Model->get_client();
            $this->data['client_list'] = $client_list;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/accounts_report/clientwise_accounts_report/clientwise_accounts_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function clientwise_accounts_report_show()  //voucher report show in table
    {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $client_id = trim($this->input->post('client_id'));
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $client_list = $this->Client_Model->get_client();
            $this->data['client_list'] = $client_list;
            $client_voucher_details_list = $this->get_client_voucher_details_by_date($client_id, $start_date, $end_date);
            $this->data['client_voucher_details_list'] = $client_voucher_details_list;
            $client_information = $this->Client_Model->get_client($client_id);
            if (!empty($client_information)) {
                $client_name = $client_information->client_name;
            } else {
                $client_name = 'All';
            }
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->data['client_name'] = $client_name;
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->load->view('reports/accounts_report/clientwise_accounts_report/clientwise_accounts_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function clientwise_voucher_details_report_modal_show()  //voucher report details show in Modal
    {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $id = $this->input->post('id');  // voucher posting details id
            $client_voucher_details_by_voucher_posting_details_id = $this->get_client_voucher_details_by_voucher_posting_details_id($id);
            $this->data['client_voucher_details_by_voucher_posting_details_id'] = $client_voucher_details_by_voucher_posting_details_id;
            $client_id = $client_voucher_details_by_voucher_posting_details_id->client_id;
            $client_information = $this->Client_Model->get_client($client_id);
            $this->data['client_information'] = $client_information;
            $clientwise_voucher_details_information = $this->get_clientwise_voucher_details_information($id, $client_id);
            $this->data['clientwise_voucher_details_information'] = $clientwise_voucher_details_information;
            $this->load->view('reports/accounts_report/clientwise_accounts_report/clientwise_accounts_report_modal', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_client_voucher_details_by_date($client_id, $start_date, $end_date)
    {
        if ($client_id <= 0) { // for all client
            $query_result = $this->db->query("SELECT vpd.id, vpd.posting_date, vpd.voucher_number, vpd.total_debit_amount, vpd.total_credit_amount, vpd.common_narration, vpd.user_id, vd.id as voucher_details_id, vd.income_head_id, vd.expense_head_id, vd.amount, SUM(vd.amount) as client_amount, vd.invoice_number, vd.mr_number, vd.client_id, vd.employee_id, vd.month, vd.year, vd.narration, vd.debit_amount, vd.credit_amount, vd.voucher_posting_details_id, c.client_name, c.client_code, c.dealer_id, c.employee_id FROM voucher_posting_details vpd JOIN voucher_details vd ON vpd.id=vd.voucher_posting_details_id JOIN client_info c ON vd.client_id = c.id WHERE vpd.posting_date >= '$start_date' AND vpd.posting_date <= '$end_date' GROUP BY vpd.id")->result();

        } else {
            $query_result = $this->db->query("SELECT vpd.id, vpd.posting_date, vpd.voucher_number, vpd.total_debit_amount, vpd.total_credit_amount, vpd.common_narration, vpd.user_id, vd.id as voucher_details_id, vd.income_head_id, vd.expense_head_id, vd.amount, SUM(vd.amount) as client_amount, vd.invoice_number, vd.mr_number, vd.client_id, vd.employee_id, vd.month, vd.year, vd.narration, vd.debit_amount, vd.credit_amount, vd.voucher_posting_details_id, c.client_name, c.client_code, c.dealer_id, c.employee_id FROM voucher_posting_details vpd JOIN voucher_details vd ON vpd.id=vd.voucher_posting_details_id JOIN client_info c ON vd.client_id = c.id WHERE vd.client_id = $client_id AND vpd.posting_date >= '$start_date' AND vpd.posting_date <= '$end_date' GROUP BY vpd.id")->result();
        }
        return $query_result;
    }

    public function get_client_voucher_details_by_voucher_posting_details_id($voucher_posting_details_id)
    {
        $query_result = $this->db->query("SELECT vpd.id, vpd.posting_date, vpd.voucher_number, vpd.total_debit_amount, vpd.total_credit_amount, vpd.common_narration, vpd.user_id, vd.id as voucher_details_id, vd.income_head_id, vd.expense_head_id, vd.amount, SUM(vd.amount) as client_amount, vd.invoice_number, vd.mr_number, vd.client_id, vd.employee_id, vd.month, vd.year, vd.narration, vd.debit_amount, vd.credit_amount, vd.voucher_posting_details_id, c.client_name, c.client_code, c.dealer_id, c.employee_id FROM voucher_posting_details vpd JOIN voucher_details vd ON vpd.id=vd.voucher_posting_details_id JOIN client_info c ON vd.client_id = c.id WHERE vpd.id = $voucher_posting_details_id")->row();
        return $query_result;
    }

    public function get_clientwise_voucher_details_information($voucher_posting_details_id, $client_id)
    {
        $query_result = $this->db->query("SELECT vpd.id, vpd.posting_date, vpd.voucher_number, vpd.total_debit_amount, vpd.total_credit_amount, vpd.common_narration, vpd.user_id, vd.id as voucher_details_id, vd.income_head_id, vd.expense_head_id, vd.amount, vd.invoice_number, vd.mr_number, vd.client_id, vd.employee_id, vd.month, vd.year, vd.narration, vd.debit_amount, vd.credit_amount, vd.voucher_posting_details_id, c.client_name, c.client_code, c.dealer_id, c.employee_id FROM voucher_posting_details vpd JOIN voucher_details vd ON vpd.id=vd.voucher_posting_details_id JOIN client_info c ON vd.client_id = c.id WHERE vd.client_id = $client_id AND vpd.id = '$voucher_posting_details_id'")->result();
        return $query_result;
    }
}