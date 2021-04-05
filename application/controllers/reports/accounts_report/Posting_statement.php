<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Posting_statement extends CI_Controller {

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
        $this->load->model('Daywise_head_posting_Model');
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
            $this->load->view('reports/accounts_report/posting_statement/posting_statement', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function posting_statement_show_in_table() {
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
            $posting_statement_details = $this->get_posting_statement($start_date, $end_date, $head_id);
            $this->data['posting_statement_details'] = $posting_statement_details;
            $this->data['head_details'] = $head_details;
            $this->data['head_name'] = $head_name;
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->data['head_id'] = $head_id;
            $this->load->view('reports/accounts_report/posting_statement/posting_statement_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_posting_statement($start_date, $end_date, $head_id) {
        if ((empty($head_id)) || $head_id == 0) {
            $result = $this->db->query("SELECT dhp.id, dhp.head_id, dhp.posting_date, dhp.opening_balance, dhp.debit_amount, dhp.credit_amount, dhp.closing_balance, dhp.user_id, hd.head_name, hd.head_type, u.user_name, u.user_type FROM daywise_head_posting dhp JOIN head_details hd ON dhp.head_id=hd.id JOIN user_info u ON dhp.user_id=u.id WHERE dhp.posting_date >= '$start_date' AND dhp.posting_date <= '$end_date' AND hd.is_active = '1' ORDER BY dhp.posting_date DESC")->result();
        } else {
            $result = $this->db->query("SELECT dhp.id, dhp.head_id, dhp.posting_date, dhp.opening_balance, dhp.debit_amount, dhp.credit_amount, dhp.closing_balance, dhp.user_id, hd.head_name, hd.head_type, u.user_name, u.user_type FROM daywise_head_posting dhp JOIN head_details hd ON dhp.head_id=hd.id JOIN user_info u ON dhp.user_id=u.id WHERE dhp.posting_date >= '$start_date' AND dhp.posting_date <= '$end_date' AND dhp.head_id = '$head_id' AND hd.is_active = '1' ORDER BY dhp.posting_date DESC")->result();
        }
        return $result;
    }

}
