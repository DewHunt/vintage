<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_pfofit_report_invoicewise extends CI_Controller {

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
            $this->data['title'] = "Sales Profit Report";
            $this->data['page_title'] = "Sales Profit Report";
            $employee_id = $this->User_Model->get_loggedin_user_employee_id();
            $all_client_by_employee_id = $this->Client_Model->get_all_client_by_employee_id($employee_id);
            $client_list = $this->Client_Model->get_client();
            $user_type = $this->User_Model->get_loggedin_user_type();
            $this->data['client_list'] = (strtolower($user_type) === 'marketing') ? $all_client_by_employee_id : $client_list;
            $this->data['employee_info'] = $this->Employee_Model->get_employee($employee_id);
            $this->data['employee_list'] = $this->Employee_Model->get_employee();
            $this->data['user_type'] = $user_type;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/sales_statement_report/sales_pfofit_report_invoicewise/sales_pfofit_report_invoicewise', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function sales_pfofit_report_invoicewise_show() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->is_loggedin_user_type_admin()) == true)) {
            if ($this->input->is_ajax_request()) {
                $this->data['report_title'] = "Sales Profit Report";
                $start_date = get_start_date_format(trim($this->input->post('start_date')));
                $end_date = get_end_date_format(trim($this->input->post('end_date')));
                $client_id = (trim($this->input->post('client_id')));
                $employee_id = (trim($this->input->post('employee_id')));
                if (!empty($start_date) && !empty($end_date) && !empty($client_id != '') && ($employee_id != '')) {
                    $client_information = $this->Client_Model->get_client($client_id);
                    if (!empty($client_information)) {
                        $client_name = ucfirst($client_information->client_name);
                        $client_code = $client_information->client_code;
                    } else {
                        if (($client_id == 'import') || ($client_id == 'lubzone')) {
                            $client_name = 'All ' . '(' . $client_id . ')';
                            $client_code = '';
                        } else {
                            $client_name = 'All';
                            $client_code = '';
                        }
                    }
                    $user_type = $this->User_Model->get_loggedin_user_type();
                    $print_access = $this->User_Model->is_loggedin_user_print_access();
                    $this->data['start_date'] = $start_date;
                    $this->data['end_date'] = $end_date;
                    $this->data['client_name'] = $client_name;
                    $this->data['user_type'] = $user_type;
                    $this->data['print_access'] = $print_access;
                    $this->data['sales_pfofit_report_invoicewise'] = $this->Client_sales_commission_Model->get_sales_pfofit_report_invoicewise($start_date, $end_date, $client_id, $employee_id);
//                get_print_r($this->db->last_query());
                    $this->load->view('reports/sales_statement_report/sales_pfofit_report_invoicewise/sales_pfofit_report_invoicewise_table', $this->data);
                } else {
                    echo '<div class="error-message text-align-center">Please check input fields.</div>';
                }
            } else {
                redirect(base_url('reports/sales_statement_report/sales_pfofit_report_invoicewise'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

}
