<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_receive_challan_report extends CI_Controller {

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
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $this->data['title'] = "Product Receive Challan Report";
            $branch_list = $this->Branch_Model->get_branch();
            $this->data['branch_list'] = $branch_list;
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['currency_settings'] = $currency_settings;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/product_receive_challan_report/product_receive_challan_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function product_receive_challan_report_show_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $branch_id = trim($this->input->post('branch_id'));
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            $company_information = $this->Company_Model->get_company();
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $branch_information = $this->Branch_Model->get_branch($branch_id);
            if (!empty($branch_information)) {
                $branch_name = $branch_information->branch_name;
            } else {
                $branch_name = 'All';
            }
            $product_receive_Challan_report_by_date = $this->Product_receive_challan_Model->get_product_receive_Challan_report_by_date($branch_id, $start_date, $end_date);
            $this->data['company_information'] = $company_information;
            $this->data['currency_settings'] = $currency_settings;
            $this->data['branch_information'] = $branch_information;
            $this->data['branch_name'] = $branch_name;
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->data['product_receive_Challan_report_by_date'] = $product_receive_Challan_report_by_date;
            $this->load->view('reports/product_receive_challan_report/product_receive_challan_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function product_receive_challan_report_show_in_modal() {  //details show in Modal
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['currency_settings'] = $currency_settings;
            $id = $this->input->post('id');  // product receive challan id
            $product_receive_challan_details_by_product_receive_challan_id = $this->Product_receive_challan_Model->get_product_receive_challan_details_by_product_receive_challan_id($id);
            $this->data['product_receive_challan_details_by_product_receive_challan_id'] = $product_receive_challan_details_by_product_receive_challan_id;
            $product_receive_challan_details_by_product_receive_challan_id_single_row = $this->Product_receive_challan_Model->get_product_receive_challan_details_by_product_receive_challan_id_single_row($id);
            $this->data['product_receive_challan_details_by_product_receive_challan_id_single_row'] = $product_receive_challan_details_by_product_receive_challan_id_single_row;
            $this->load->view('reports/product_receive_challan_report/product_receive_challan_report_modal', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

}
