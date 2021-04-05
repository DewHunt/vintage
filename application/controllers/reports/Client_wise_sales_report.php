<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_wise_sales_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Client_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Dealer_Model');
        $this->load->model('Sale_product_Model');
        $this->load->model('Invoice_details_Model');
    }

    public function index() {
        if (get_user_permission('reports/client_wise_sales_report') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "ClientWise Sales Report";
        $client_list = $this->Client_Model->get_client();
        $this->data['client_list'] = $client_list;
        $company_information = $this->Company_Model->get_company();
        $this->data['company_information'] = $company_information;
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('reports/client_wise_sales_report/client_wise_sales_report', $this->data);
    }

    public function client_wise_sales_report_show() {  // show in table
        if (get_user_permission('reports/client_wise_sales_report') === false) {
            redirect(base_url('user_login'));
        }
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id'];
        $user_type = $user_info['user_type'];

        $client_id = trim($this->input->post('client_id'));
        // $start_date = trim($this->input->post('from_date'));
        // $end_date = trim($this->input->post('to_date'));

        if ($this->input->post('from_date')) {
            $start_date = trim($this->input->post('from_date'));
        } else {
            $start_date = date('Y-m-d');
        }

        if ($this->input->post('to_date')) {
            $end_date = trim($this->input->post('to_date'));
        } else {
            $end_date = date('Y-m-d');
        }
        
        $client_information = $this->Client_Model->get_client($client_id);
        if (!empty($client_information)) {
            $client_name = $client_information->client_name;
        } else {
            $client_name = 'All';
        }
        $company_information = $this->Company_Model->get_company();
        $user_info = $this->User_Model->get_user($user_id);
        $employee_id = $user_info->employee_id;
        $client_invoice_details_list = $this->get_client_invoice_details_list($client_id, $start_date, $end_date, $employee_id, $user_type);
        $this->data['company_information'] = $company_information;
        $this->data['client_invoice_details_list'] = $client_invoice_details_list;
        $this->data['client_name'] = $client_name;
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->load->view('reports/client_wise_sales_report/client_wise_sales_report_table', $this->data);
    }

    public function client_invoice_report_view() { //client_wise_sales_report_modal
        if (get_user_permission('reports/client_wise_sales_report') === false) {
            redirect(base_url('user_login'));
        }
        $id = trim($this->input->post('id'));  // invoice id

        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id'];
        $user_type = $user_info['user_type'];

        $company_information = $this->Company_Model->get_company();
        // $invoice_details_by_invoice_id = $this->get_invoice_details_view($id);
        // $employee = $this->Employee_Model->get_employee($invoice_details_by_invoice_id->employee_id);
        // $dealer = $this->Dealer_Model->get_dealer($invoice_details_by_invoice_id->dealer_id);
        // $sale_product_list = $this->Sale_product_Model->get_sale_product_list($invoice_details_by_invoice_id->id);

        $invoice_details_by_invoice_id = $this->Invoice_details_Model->getInvoiceDetailsById($id);
        $sale_product_list = $this->Sale_product_Model->getSaleProductInformationByInvoiceId($id);
        // echo "<>";
        $this->data['company_information'] = $company_information;
        $this->data['invoice_details_by_invoice_id'] = $invoice_details_by_invoice_id;
        $this->data['sale_product_list'] = $sale_product_list;
        // $this->data['employee'] = $employee;
        // $this->data['dealer'] = $dealer;
        $this->load->view('reports/client_wise_sales_report/client_wise_sales_report_modal', $this->data);
    }

    public function get_client_invoice_details_list($client_id, $start_date, $end_date, $employee_id, $user_type) {
        if ($client_id <= 0 || $client_id == '') {
            if (strtolower($user_type) === 'marketing') {
                $client_invoice_details_list = $this->db->query("
                    SELECT i.id, i.invoice_number, i.employee_id, i.dealer_id, i.vat_registration_id, i.date_of_issue, i.product_total, i.mode_of_payment, i.amount_to_paid, i.user_id, i.client_id,c.client_name,e.employee_name,d.dealer_name,br.branch_name, u.user_name, u.user_type 
                    FROM invoice_details i 
                    LEFT JOIN client_info c ON i.client_id = c.id 
                    LEFT JOIN employee_info e ON i.employee_id=e.id 
                    LEFT JOIN dealer_info d ON i.dealer_id=d.id 
                    LEFT JOIN branch_info br ON i.branch_id = br.id 
                    LEFT JOIN user_info u ON i.user_id=u.id 
                    WHERE DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') <= '$end_date' AND c.employee_id = '$employee_id' 
                    ORDER BY i.id DESC 
                ")->result();
            } else {
                $client_invoice_details_list = $this->db->query("
                    SELECT i.id, i.invoice_number, i.employee_id, i.dealer_id, i.vat_registration_id, i.date_of_issue, i.product_total, i.mode_of_payment, i.amount_to_paid, i.user_id, i.client_id,c.client_name,e.employee_name,d.dealer_name,br.branch_name, u.user_name, u.user_type 
                    FROM invoice_details i 
                    LEFT JOIN client_info c ON i.client_id = c.id 
                    LEFT JOIN employee_info e ON i.employee_id=e.id 
                    LEFT JOIN dealer_info d ON i.dealer_id=d.id 
                    LEFT JOIN branch_info br ON i.branch_id = br.id 
                    LEFT JOIN user_info u ON i.user_id=u.id 
                    WHERE DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') <= '$end_date' 
                    ORDER BY i.id DESC 
                ")->result();
            }
        } else {
            if (strtolower($user_type) === 'marketing') {
                $client_invoice_details_list = $this->db->query("
                    SELECT i.id, i.invoice_number, i.employee_id, i.dealer_id, i.vat_registration_id, i.date_of_issue, i.product_total, i.mode_of_payment, i.amount_to_paid, i.user_id, i.client_id,c.client_name,e.employee_name,d.dealer_name,br.branch_name, u.user_name, u.user_type 
                    FROM invoice_details i 
                    LEFT JOIN client_info c ON i.client_id = c.id 
                    LEFT JOIN employee_info e ON i.employee_id=e.id 
                    LEFT JOIN dealer_info d ON i.dealer_id=d.id 
                    LEFT JOIN branch_info br ON i.branch_id = br.id 
                    LEFT JOIN user_info u ON i.user_id=u.id 
                    WHERE DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') <= '$end_date' AND i.client_id='$client_id' AND c.employee_id = '$employee_id' 
                    ORDER BY i.id DESC
                ")->result();
            } else {
                $client_invoice_details_list = $this->db->query("SELECT i.id, i.invoice_number, i.employee_id, i.dealer_id, i.vat_registration_id, i.date_of_issue, i.product_total, i.mode_of_payment, i.amount_to_paid, i.user_id, i.client_id,c.client_name,e.employee_name,d.dealer_name,br.branch_name, u.user_name, u.user_type 
                    FROM invoice_details i 
                    LEFT JOIN client_info c ON i.client_id = c.id 
                    LEFT JOIN employee_info e ON i.employee_id=e.id 
                    LEFT JOIN dealer_info d ON i.dealer_id=d.id 
                    LEFT JOIN branch_info br ON i.branch_id = br.id 
                    LEFT JOIN user_info u ON i.user_id=u.id 
                    WHERE DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') <= '$end_date' AND i.client_id='$client_id' 
                    ORDER BY i.id DESC
                ")->result();
            }
        }
        return $client_invoice_details_list;
    }

    public function get_invoice_details_view($id = 0) {
        if ($id == 0) {
            $invoice_details_list = $this->db->query("
                SELECT i.id, i.branch_id, i.vat_registration_id, i.employee_id, i.dealer_id, i.challan_number, i.invoice_number, i.date_of_issue, i.gross_payable, i.amount_to_paid, i.mode_of_payment, i.delivery_charge, i.others_charge, i.deduction, i.advance_adjusted, i.user_id, u.user_name, c.client_name, d.dealer_name, e.employee_name, e.employee_code, g.source, br.branch_name 
                FROM invoice_details i 
                LEFT JOIN client_info c ON i.client_id=c.id 
                LEFT JOIN dealer_info d on c.dealer_id = d.id 
                LEFT JOIN employee_info e ON i.employee_id=e.id 
                LEFT JOIN user_info u ON i.user_id=u.id 
                LEFT JOIN gate_pass_details g ON g.invoice_id=i.id 
                LEFT JOIN branch_info br ON i.branch_id=br.id 
                ORDER BY i.id DESC 
            ")->result();
            return $invoice_details_list;
        } else {
            $invoice_details_list = $this->db->query("SELECT i.id, i.branch_id, i.vat_registration_id, i.employee_id, i.dealer_id, i.challan_number, i.invoice_number, i.date_of_issue, i.gross_payable, i.amount_to_paid, i.mode_of_payment, i.delivery_charge, i.others_charge, i.deduction, i.advance_adjusted, i.user_id, u.user_name, c.client_name, d.dealer_name, e.employee_name, e.employee_code, g.source, br.branch_name 
                FROM invoice_details i 
                LEFT JOIN client_info c ON i.client_id=c.id 
                LEFT JOIN dealer_info d on c.dealer_id = d.id 
                LEFT JOIN employee_info e ON i.employee_id=e.id 
                LEFT JOIN user_info u ON i.user_id=u.id 
                LEFT JOIN gate_pass_details g ON g.invoice_id=i.id 
                LEFT JOIN branch_info br ON i.branch_id=br.id 
                WHERE i.id='$id'
            ")->row();
            return $invoice_details_list;
        }
    }
}
