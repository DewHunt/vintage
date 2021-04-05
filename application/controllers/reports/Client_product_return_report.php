<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_product_return_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Product_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Client_Model');
        $this->load->model('Invoice_details_Model');
        $this->load->model('Sale_product_Model');
        $this->load->model('Product_receive_Model');
        $this->load->model('Branch_stock_Model');
        $this->load->model('Stock_transfer_challan_Model');
        $this->load->model('Stock_transfer_Model');
        $this->load->model('Branchwise_product_store_Model');
        $this->load->model('Product_store_Model');
        $this->load->model('Damage_or_defect_product_info_Model');
        $this->load->model('Damage_or_defect_product_details_Model');
        $this->load->model('Client_product_damage_or_defect_info_Model');
        $this->load->model('Client_product_damage_or_defect_details_Model');
        $this->load->model('Client_product_return_info_Model');
        $this->load->model('Client_product_return_details_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $this->data['title'] = "Client Product (Damage / Defect) Report";
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id'];
            $user_type = $user_info['user_type'];
            $employee_id = $user_info['employee_id'];
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['currency_settings'] = $currency_settings;
            $client_list = $this->Client_Model->get_client();
            $this->data['client_list'] = $client_list;
            $branch_list = $this->Branch_Model->get_branch();
            $this->data['branch_list'] = $branch_list;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/client_product_return_report/client_product_return_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function client_product_return_report_show_in_table() {  // show in table
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id'];
            $user_type = $user_info['user_type'];
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            $client_id = trim($this->input->post('client_id'));
            $client_information = $this->Client_Model->get_client($client_id);
            if (!empty($client_information)) {
                $client_name = $client_information->client_name;
            } else {
                $client_name = 'All';
            }
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['currency_settings'] = $currency_settings;

            if (empty($start_date) || empty($end_date)) {  // please select value= -1
                echo '<div class="error-message text-align-center">Please Select Date</div>';
            } else {
                $start_date = $start_date . ' 00:00:00';
                $end_date = $end_date . ' 23:59:59';
                $client_product_return_info_by_date_and_client = $this->Client_product_return_info_Model->get_client_product_return_info_by_date_and_client($start_date, $end_date, $client_id);
                $this->data['client_product_return_info_by_date_and_client'] = $client_product_return_info_by_date_and_client;
                $this->data['client_name'] = $client_name;
                $this->data['start_date'] = $start_date;
                $this->data['end_date'] = $end_date;
                $this->load->view('reports/client_product_return_report/client_product_return_report_table', $this->data);
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function client_product_return_report_details_show_in_modal() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $id = $this->input->post('id');
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id'];
            $user_type = $user_info['user_type'];
            $user_info = $this->User_Model->get_user($user_id);
            $employee_id = $user_info->employee_id;
            $client_product_return_info_with_client = $this->Client_product_return_info_Model->get_client_product_return_info_with_client($id);
            $this->data['client_product_return_info_with_client'] = $client_product_return_info_with_client;
            $client_product_return_details_by_client_product_return_info_id = $this->Client_product_return_details_Model->get_client_product_return_details_by_client_product_return_info_id($id);
            $this->data['client_product_return_details_by_client_product_return_info_id'] = $client_product_return_details_by_client_product_return_info_id;
            $company_information = $this->Company_Model->get_company();
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['company_information'] = $company_information;
            $this->data['currency_settings'] = $currency_settings;
            $this->load->view('reports/client_product_return_report/client_product_return_report_modal', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

}
