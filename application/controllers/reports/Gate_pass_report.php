<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gate_pass_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Invoice_details_Model');
        $this->load->model('Client_Model');
        $this->load->model('Dealer_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Sale_product_Model');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('User_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $this->data['title'] = "Invoice Report";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/gate_pass_report/gate_pass_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function gate_pass_report_show_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id'];
            $user_type = $user_info['user_type'];
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['currency_settings'] = $currency_settings;
            $gate_pass_report_list = $this->get_gate_pass_report_view();
            $user_info = $this->User_Model->get_user($user_id);
            $employee_id = $user_info->employee_id;
            $invoice_details = $this->get_invoice_details_view($id = 0, $employee_id, $user_type, $start_date, $end_date);
            $this->data['gate_pass_report_list'] = $gate_pass_report_list;
            $this->data['invoice_details'] = $invoice_details;
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->load->view('reports/gate_pass_report/gate_pass_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function gate_pass_modal_view() {  //modal show
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $invoice_id = $this->input->post('id');
            $gate_pass_report_by_invoice_id = $this->get_gate_pass_report_show($invoice_id);
            $gate_pass_report_view = $this->get_gate_pass_report_view($invoice_id);
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $this->data['gate_pass_report_by_invoice_id'] = $gate_pass_report_by_invoice_id;
            $this->data['gate_pass_report_view'] = $gate_pass_report_view;
            $this->load->view('reports/gate_pass_report/gate_pass_report_modal', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_gate_pass_report_view($id = 0) {
        if ($id == 0) {
            $gate_pass_report_list = $this->db->query("SELECT i.id, s.product_id, p.product_name, s.pack_size, s.quantity, s.gate_pass_remarks FROM invoice_details i LEFT JOIN sale_product s ON s.invoice_id=i.id LEFT JOIN product p ON s.product_id=p.id")->result();
            return $gate_pass_report_list;
        } else {
            $gate_pass_report_list = $this->db->query("SELECT i.id, s.product_id, p.product_name, s.pack_size, s.quantity, s.gate_pass_remarks FROM invoice_details i LEFT JOIN sale_product s ON s.invoice_id=i.id LEFT JOIN product p ON s.product_id=p.id WHERE i.id='$id'")->result();
            return $gate_pass_report_list;
        }
    }

    public function get_gate_pass_report_show($id = 0) {
        $gate_pass_report_list = $this->db->query("SELECT i.id, i.employee_id, i.dealer_id, i.date_of_issue, i.invoice_number, i.challan_number, i.order_number, i.order_date, e.employee_name, e.employee_code, d.dealer_code, g.source FROM invoice_details i LEFT JOIN employee_info e ON i.employee_id=e.id LEFT JOIN dealer_info d ON i.dealer_id=d.id LEFT JOIN gate_pass_details g ON g.invoice_id=i.id WHERE i.id='$id'")->row();
        return $gate_pass_report_list;
    }

    public function get_invoice_details_view($id = 0, $employee_id, $user_type, $start_date, $end_date) {
        if (($id == 0) && (strtolower($user_type) == 'marketing')) {
            $invoice_details_list = $this->db->query("SELECT i.id, i.vat_registration_id, i.employee_id, i.dealer_id, i.challan_number, i.invoice_number, i.date_of_issue, i.gross_payable, i.amount_to_paid, i.mode_of_payment, i.delivery_charge, i.others_charge, i.deduction, i.advance_adjusted, i.user_id, i.order_number, i.order_date, u.user_name, u.user_type, c.client_name, c.cell_number, c.phone_number, c.address, d.dealer_name, e.employee_name, g.source FROM invoice_details i LEFT JOIN client_info c ON i.client_id=c.id LEFT JOIN dealer_info d on c.dealer_id = d.id LEFT JOIN employee_info e ON i.employee_id=e.id LEFT JOIN user_info u ON i.user_id=u.id LEFT JOIN gate_pass_details g ON g.invoice_id=i.id WHERE e.id = '$employee_id' AND i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' ORDER BY i.id DESC ")->result();
        } else {
            $invoice_details_list = $this->db->query("SELECT i.id, i.vat_registration_id, i.employee_id, i.dealer_id, i.challan_number, i.invoice_number, i.date_of_issue, i.gross_payable, i.amount_to_paid, i.mode_of_payment, i.delivery_charge, i.others_charge, i.deduction, i.advance_adjusted, i.user_id, i.order_number, i.order_date, u.user_name, u.user_type, c.client_name, c.cell_number, c.phone_number, c.address, d.dealer_name, e.employee_name, g.source FROM invoice_details i LEFT JOIN client_info c ON i.client_id=c.id LEFT JOIN dealer_info d on c.dealer_id = d.id LEFT JOIN employee_info e ON i.employee_id=e.id LEFT JOIN user_info u ON i.user_id=u.id LEFT JOIN gate_pass_details g ON g.invoice_id=i.id WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' ORDER BY i.id DESC ")->result();
        }
        return $invoice_details_list;
    }

}
