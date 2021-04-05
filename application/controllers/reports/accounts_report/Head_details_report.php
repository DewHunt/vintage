<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Head_details_report extends CI_Controller {

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
            $this->data['title'] = "Head Report";
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $head_details_list = $this->Head_details_Model->get_head_details();
            $this->data['head_details_list'] = $head_details_list;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/accounts_report/head_details_report/head_details_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function head_details_report_show_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            $head_id = trim($this->input->post('head_id'));
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $head_details = $this->Head_details_Model->get_head_details($head_id);
            if (!empty($head_details)) {
                $head_name = $head_details->head_name;
            } else {
                $head_name = 'All';
            }
            $this->data['head_details'] = $head_details;
            $this->data['head_name'] = $head_name;
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $head_details_report_by_head_id = $this->get_head_details_report_by_head_id($head_id, $start_date, $end_date);
//            echo '<pre>';
//            print_r($head_details_report_by_head_id);
//            echo '</pre>';
            $this->data['head_details_report_by_head_id'] = $head_details_report_by_head_id;
            $this->load->view('reports/accounts_report/head_details_report/head_details_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_head_details_report_by_head_id($head_id, $start_date, $end_date) {
        if ((int) $head_id <= 0) {
            $where_condition = "WHERE vpd.posting_date >= '$start_date' AND vpd.posting_date <= '$end_date' ORDER BY vd.id DESC";
        } else {
            $where_condition = "WHERE (vd.income_head_id = '$head_id' OR vd.expense_head_id='$head_id') AND vpd.posting_date >= '$start_date' AND vpd.posting_date <= '$end_date' ORDER BY vd.id DESC";
        }
        $result = $this->db->query("SELECT vpd.id, vpd.posting_date, vpd.voucher_number, vpd.total_debit_amount, vpd.total_credit_amount, vpd.common_narration, vpd.user_id, vd.id AS voucher_details_id, vd.income_head_id, vd.expense_head_id, vd.amount ,vd.invoice_number, vd.mr_number, vd.client_id, vd.employee_id, vd.month, vd.year, vd.narration, vd.debit_amount, vd.credit_amount FROM voucher_posting_details vpd JOIN voucher_details vd ON vpd.id= vd.voucher_posting_details_id $where_condition ")->result();
        return $result;
    }

}
