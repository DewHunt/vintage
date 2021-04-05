<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Productwise_profit_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Payment_Model');
        $this->load->model('Invoice_details_Model');
        $this->load->model('Client_Model');
        $this->load->model('Dealer_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Sale_product_Model');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->is_loggedin_user_type_admin()) == true)) {
            $this->data['title'] = "Productwise Profit Report";
            $this->data['page_title'] = "Productwise Profit Report";
            $this->data['product_list'] = $this->Product_Model->get_product();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/sales_statement_report/productwise_profit_report/productwise_profit_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function productwise_profit_report_show() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->is_loggedin_user_type_admin()) == true)) {
            if ($this->input->is_ajax_request()) {
                $this->data['report_title'] = "Productwise Profit Report";
                $start_date = get_start_date_format(trim($this->input->post('start_date')));
                $end_date = get_end_date_format(trim($this->input->post('end_date')));
                $product_id = (trim($this->input->post('product_id')));
                if (!empty($start_date) && !empty($end_date) && ($product_id != '')) {
                    $product_information = $this->Product_Model->get_product($product_id);
                    $product_name = (!empty($product_information)) ? $product_information->product_name : 'All';
                    $user_type = $this->User_Model->get_loggedin_user_type();
                    $print_access = $this->User_Model->is_loggedin_user_print_access();
                    $this->data['start_date'] = $start_date;
                    $this->data['end_date'] = $end_date;
                    $this->data['product_information'] = $product_information;
                    $this->data['product_name'] = $product_name;
                    $this->data['user_type'] = $user_type;
                    $this->data['print_access'] = $print_access;
                    $this->data['productwise_profit_report'] = $this->Invoice_details_Model->get_productwise_profit_report($start_date, $end_date, $product_id);
                    $this->load->view('reports/sales_statement_report/productwise_profit_report/productwise_profit_report_table', $this->data);
                } else {
                    echo '<div class="error-message text-align-center">Please check input fields.</div>';
                }
            } else {
                redirect(base_url('reports/sales_statement_report/sales_details_statement'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

}
