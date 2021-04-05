<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientwise_sales_analysis_report extends CI_Controller {

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
            $this->data['title'] = "Clientwise Sales Analysis";
            $this->data['page_title'] = "Clientwise Sales Analysis";
            $start_date = get_start_date_format(get_first_date_of_current_month());
            $end_date = get_end_date_format(get_last_date_of_current_month());
            $start_limit = 0;
            $end_limit = 25;
            $clientwise_sales_analysis = $this->Invoice_details_Model->get_clientwise_sales_analysis($start_date, $end_date, $start_limit, $end_limit);
//            get_print_r($this->db->last_query());
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->data['clientwise_sales_analysis'] = !empty($clientwise_sales_analysis) ? json_encode($clientwise_sales_analysis) : '';
            $this->data['user_type'] = $this->User_Model->get_loggedin_user_type();
            $this->data['report_content'] = $this->load->view('reports/sales_statement_report/sales_analysis_report/clientwise_sales_analysis_report/clientwise_sales_analysis', $this->data, TRUE);
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/sales_statement_report/sales_analysis_report/index', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function analysis_report() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->is_loggedin_user_type_admin()) == true)) {
            if ($this->input->is_ajax_request()) {
                $this->data['title'] = "Clientwise Sales Analysis";
                $this->data['page_title'] = "Clientwise Sales Analysis";
                $start_date = get_start_date_format(trim($this->input->post('start_date')));
                $end_date = get_end_date_format(trim($this->input->post('end_date')));
                $start_limit = intval(trim($this->input->post('start_limit')));
                $end_limit = intval(trim($this->input->post('end_limit')));
                if (!empty($start_date) && !empty($end_date) && ($start_limit >= 0) && ($end_limit > 0)) {
                    $clientwise_sales_analysis = $this->Invoice_details_Model->get_clientwise_sales_analysis($start_date, $end_date, $start_limit, $end_limit);
                    $this->data['clientwise_sales_analysis'] = !empty($clientwise_sales_analysis) ? json_encode($clientwise_sales_analysis) : '';
                    $html = $this->load->view('reports/sales_statement_report/sales_analysis_report/clientwise_sales_analysis_report/clientwise_sales_analysis_bar_chart', $this->data, TRUE);
                    set_json_output(array('html' => $html));
                } else {
                    $message = 'Please Check Input Fields.';
                }
            } else {
                redirect(base_url('reports/sales_statement_report/sales_analysis_report/clientwise_sales_analysis_report'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

}
