<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dealer_wise_sales_report extends CI_Controller
{
    public function __construct()
    {
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
    }

    public function index()
    {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_access')) == true)) {
            $this->data['title'] = "DealerWise Sales Report";
            $dealer_list = $this->Dealer_Model->get_dealer();
            $this->data['dealer_list'] = $dealer_list;
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/dealer_wise_sales_report/dealer_wise_sales_report', $this->data);

        } else {
            redirect(base_url('user_login'));
        }
    }

    public function dealer_wise_sales_report_show()
    {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_access')) == true)) {
            $dealer_id = trim($this->input->post('dealer_id'));
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            $dealer_information = $this->Dealer_Model->get_dealer($dealer_id);//
            if (!empty($dealer_information)) {
                $dealer_name = $dealer_information->dealer_name;
            } else {
                $dealer_name = 'All';
            }
            $company_information = $this->Company_Model->get_company();
            $dealer_invoice_details_list = $this->get_dealer_invoice_details_list($dealer_id, $start_date, $end_date);
            $this->data['company_information'] = $company_information;
            $this->data['dealer_invoice_details_list'] = $dealer_invoice_details_list;
            $this->data['dealer_name'] = $dealer_name;
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->load->view('reports/dealer_wise_sales_report/dealer_wise_sales_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function dealer_invoice_report_view() //client_wise_sales_report_modal
    {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_access')) == true)) {
            $id = trim($this->input->post('id'));  // invoice id
            $company_information = $this->Company_Model->get_company();
            $invoice_details_by_invoice_id = $this->get_invoice_details_view($id);
            $employee = $this->Employee_Model->get_employee($invoice_details_by_invoice_id->employee_id);
            $dealer = $this->Dealer_Model->get_dealer($invoice_details_by_invoice_id->dealer_id);
            $sale_product_list = $this->Sale_product_Model->get_sale_product_list($invoice_details_by_invoice_id->id);
            $this->data['company_information'] = $company_information;
            $this->data['invoice_details_by_invoice_id'] = $invoice_details_by_invoice_id;
            $this->data['sale_product_list'] = $sale_product_list;
            $this->data['employee'] = $employee;
            $this->data['dealer'] = $dealer;
            $this->load->view('reports/dealer_wise_sales_report/dealer_wise_sales_report_modal', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_dealer_invoice_details_list($dealer_id, $start_date, $end_date)
    {
        if ($dealer_id <= 0 || $dealer_id == '') {
            $dealer_invoice_details_list = $this->db->query("SELECT i.id, i.invoice_number, i.employee_id, i.dealer_id, i.vat_registration_id, i.date_of_issue, i.product_total,i.user_id, i.client_id,c.client_name,e.employee_name,d.dealer_name,br.branch_name, u.user_name FROM invoice_details i JOIN client_info c ON i.client_id = c.id JOIN employee_info e ON i.employee_id=e.id JOIN dealer_info d ON i.dealer_id=d.id LEFT JOIN branch_info br ON i.branch_id = br.id LEFT JOIN user_info u ON i.user_id=u.id WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND i.dealer_id > 0")->result();

        } else {
            $dealer_invoice_details_list = $this->db->query("SELECT i.id, i.invoice_number, i.employee_id, i.dealer_id, i.vat_registration_id, i.date_of_issue, i.product_total,i.user_id, i.client_id,c.client_name,e.employee_name,d.dealer_name,br.branch_name, u.user_name FROM invoice_details i JOIN client_info c ON i.client_id = c.id JOIN employee_info e ON i.employee_id=e.id JOIN dealer_info d ON i.dealer_id=d.id LEFT JOIN branch_info br ON i.branch_id = br.id LEFT JOIN user_info u ON i.user_id=u.id WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND i.dealer_id='$dealer_id'")->result();
        }
        return $dealer_invoice_details_list;
    }

    public function get_invoice_details_view($id = 0)
    {
        if ($id == 0) {
            $invoice_details_list = $this->db->query("SELECT i.id, i.branch_id, i.vat_registration_id, i.employee_id, i.dealer_id, i.challan_number, i.invoice_number, i.date_of_issue, i.gross_payable, i.amount_to_paid, i.mode_of_payment, i.delivery_charge, i.others_charge, i.deduction, i.advance_adjusted, i.user_id, u.user_name, c.client_name, d.dealer_name, e.employee_name, e.employee_code, g.source, br.branch_name FROM invoice_details i JOIN client_info c ON i.client_id=c.id JOIN dealer_info d on c.dealer_id = d.id JOIN employee_info e ON i.employee_id=e.id JOIN user_info u ON i.user_id=u.id JOIN gate_pass_details g ON g.invoice_id=i.id LEFT JOIN branch_info br ON i.branch_id=br.id")->result();
            return $invoice_details_list;
        } else {
            $invoice_details_list = $this->db->query("SELECT i.id, i.branch_id, i.vat_registration_id, i.employee_id, i.dealer_id, i.challan_number, i.invoice_number, i.date_of_issue, i.gross_payable, i.amount_to_paid, i.mode_of_payment, i.delivery_charge, i.others_charge, i.deduction, i.advance_adjusted, i.user_id, u.user_name, c.client_name, d.dealer_name, e.employee_name, e.employee_code, g.source, br.branch_name FROM invoice_details i JOIN client_info c ON i.client_id=c.id JOIN dealer_info d on c.dealer_id = d.id JOIN employee_info e ON i.employee_id=e.id JOIN user_info u ON i.user_id=u.id JOIN gate_pass_details g ON g.invoice_id=i.id LEFT JOIN branch_info br ON i.branch_id=br.id WHERE i.id='$id'")->row();
            return $invoice_details_list;
        }
    }
}
