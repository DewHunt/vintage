<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gate_pass_transfer_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('User_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Branch_stock_Model');
        $this->load->model('Product_receive_Model');
        $this->load->model('Product_receive_challan_Model');
        $this->load->model('Stock_transfer_Model');
        $this->load->model('Stock_transfer_challan_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $this->data['title'] = "Stock Transfer Challan Report";
            $branch_list = $this->Branch_Model->get_branch();
            $this->data['branch_list'] = $branch_list;
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['currency_settings'] = $currency_settings;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/gate_pass_transfer_report/gate_pass_transfer_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function stock_transfer_challan_report_show_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $from_branch_id = trim($this->input->post('from_branch_id'));
            $to_branch_id = trim($this->input->post('to_branch_id'));
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            $company_information = $this->Company_Model->get_company();
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $from_branch_information = $this->Branch_Model->get_branch($from_branch_id);
            $to_branch_information = $this->Branch_Model->get_branch($to_branch_id);
            if ((intval($from_branch_id) > 0) && !empty($from_branch_information)) {
                $from_branch_name = $from_branch_information->branch_name;
            } else {
                $from_branch_name = 'All';
            }
            if ((intval($to_branch_id) > 0) && !empty($to_branch_information)) {
                $to_branch_name = $to_branch_information->branch_name;
            } else {
                $to_branch_name = 'All';
            }
            $stock_transfer_details_report_by_date = $this->Stock_transfer_challan_Model->get_stock_transfer_details_report_by_date($from_branch_id, $to_branch_id, $start_date, $end_date);
            $this->data['company_information'] = $company_information;
            $this->data['currency_settings'] = $currency_settings;
            $this->data['from_branch_information'] = $from_branch_information;
            $this->data['from_branch_name'] = $from_branch_name;
            $this->data['to_branch_information'] = $to_branch_information;
            $this->data['to_branch_name'] = $to_branch_name;
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->data['stock_transfer_details_report_by_date'] = $stock_transfer_details_report_by_date;
            $this->load->view('reports/gate_pass_transfer_report/gate_pass_transfer_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function stock_transfer_challan_report_show_in_modal() {  //details show in Modal
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['currency_settings'] = $currency_settings;
            $id = $this->input->post('id');  // stock transfer challan id
            $stock_transfer_challan_details_by_stock_transfer_challan_id = $this->Stock_transfer_challan_Model->get_stock_transfer_challan_details_by_stock_transfer_challan_id($id);
            $this->data['stock_transfer_challan_details_by_stock_transfer_challan_id'] = $stock_transfer_challan_details_by_stock_transfer_challan_id;
            $stock_transfer_challan_details_by_stock_transfer_challan_id_single_row = $this->Stock_transfer_challan_Model->get_stock_transfer_challan_details_by_stock_transfer_challan_id_single_row($id);
            $this->data['stock_transfer_challan_details_by_stock_transfer_challan_id_single_row'] = $stock_transfer_challan_details_by_stock_transfer_challan_id_single_row;
            $this->load->view('reports/gate_pass_transfer_report/gate_pass_transfer_report_modal', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

}
