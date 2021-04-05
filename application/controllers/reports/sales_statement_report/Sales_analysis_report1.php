<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_analysis_report extends CI_Controller {

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
        $this->load->model('Client_sales_commission_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->is_loggedin_user_type_admin()) == true)) {
            $this->data['title'] = "Sales Analysis Report";
            $this->data['page_title'] = "Sales Analysis Report";

            $start_date = get_start_date_format(get_first_date_of_current_month()); //get_current_date()
            $end_date = get_end_date_format(get_last_date_of_current_month());
            $start_limit = 1;
            $end_limit = 25;
            $productwise_sales_analysis = $this->Invoice_details_Model->get_productwise_sales_analysis($start_date, $end_date, $start_limit, $end_limit);
//            $productwise_sales_analysis = $this->Invoice_details_Model->get_productwise_sales_analysis($limit = 25);
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->data['productwise_sales_analysis'] = !empty($productwise_sales_analysis) ? json_encode($productwise_sales_analysis) : '';
            $this->data['user_type'] = $this->User_Model->get_loggedin_user_type();
            $this->data['report_content'] = $this->load->view('reports/sales_statement_report/sales_analysis_report/product_sales_analysis/product_sales_analysis', $this->data, TRUE);
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/sales_statement_report/sales_analysis_report/index', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function product_sales_analysis_report() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->is_loggedin_user_type_admin()) == true)) {
            if ($this->input->is_ajax_request()) {
                $start_date = get_start_date_format(trim($this->input->post('start_date')));
                $end_date = get_end_date_format(trim($this->input->post('end_date')));
                $start_limit = intval(trim($this->input->post('start_limit')));
                $end_limit = intval(trim($this->input->post('end_limit')));
                if (!empty($start_date) && !empty($end_date) && !empty($start_limit) && !empty($end_limit)) {
                    $productwise_sales_analysis = $this->Invoice_details_Model->get_productwise_sales_analysis($start_date, $end_date, $start_limit, $end_limit);
                    $this->data['productwise_sales_analysis'] = !empty($productwise_sales_analysis) ? json_encode($productwise_sales_analysis) : '';
                    $html = $this->load->view('reports/sales_statement_report/sales_analysis_report/product_sales_analysis/product_sales_analysis_bar_chart', $this->data, TRUE);
                    set_json_output(array('html' => $html));
                } else {
                    $message = 'Please Check Input Fields.';
                }
            } else {
                redirect(base_url('reports/sales_statement_report/Sales_analysis_report'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

}
