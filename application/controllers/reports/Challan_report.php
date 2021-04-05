<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Challan_report extends CI_Controller {

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
        $this->load->model('Branch_Model');
    }

    public function index() {  // load challan details in table
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $this->data['title'] = "Invoice Report";
            $user_info = $this->session->userdata('user_session');
            $this->data['branch_list'] = $this->Branch_Model->get_branch();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/challan_product_report/challan_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function challan_report_show_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id'];
            $user_type = $user_info['user_type'];
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            $branch_id = intval(trim($this->input->post('branch_id')));
            $branch_information = $this->Branch_Model->get_branch($branch_id);
            if (($branch_id > 0) && !empty($branch_information)) {
                $branch_name = (!empty($branch_information->branch_name) ? $branch_information->branch_name : '');
            } else {
                $branch_name = 'All';
            }
            $this->data['branch_name'] = $branch_name;
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['currency_settings'] = $currency_settings;
            $user_info = $this->User_Model->get_user($user_id);
            $employee_id = $user_info->employee_id;
            $product = $this->Product_Model->get_product();
            $this->data['product'] = $product;
            $invoice_details = $this->get_invoice_details_view($id = 0, $employee_id, $user_type, $start_date, $end_date, $branch_id);
            $this->data['invoice_details'] = $invoice_details;
            $employee_id = $user_info->employee_id;
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->load->view('reports/challan_product_report/challan_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function challan_report_view() {  // modal show
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $challan_id = trim($this->input->post('id'));
            $challan_product_by_challan_id = $this->get_challan_product_by_challan_id($challan_id);
            $company_information = $this->Company_Model->get_company();
            $employee = $this->Employee_Model->get_employee($challan_product_by_challan_id->employee_id);
            $client = $this->Client_Model->get_client($challan_product_by_challan_id->client_id);
            $dealer = $this->Dealer_Model->get_dealer($challan_product_by_challan_id->dealer_id);
            $challan_product_view = $this->get_challan_product_by_challan_id($challan_id);
            $challan_product_list = $this->get_challan_product_list_show($challan_id);
            $this->data['challan_product_list'] = $challan_product_list;
            $this->data['challan_product_by_challan_id'] = $challan_product_by_challan_id;
            $this->data['challan_product_view'] = $challan_product_view;
            $this->data['company_information'] = $company_information;
            $this->data['client'] = $client;
            $this->data['employee'] = $employee;
            $this->data['dealer'] = $dealer;
            $this->load->view('reports/challan_product_report/challan_report_modal', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_challan_product_by_challan_id($challan_id = 0) {
//        $challan_product_list = $this->db->query("SELECT c.challan_id, c.branch_id, client.client_name, client.cell_number, client.phone_number, client.address, d.dealer_name, d.dealer_code, e.employee_name, i.employee_id, i.dealer_id, i.client_id, i.invoice_number, i.challan_number, i.vat_registration_id, i.order_number, i.order_date, cd.delivery_certificate, cd.date_of_issue, cd.invoice_id, c.id, c.pack_size, c.quantity, c.total_price, p.product_name, br.branch_name FROM challan_product c LEFT JOIN product p ON c.product_id=p.id LEFT JOIN challan_details cd ON c.challan_id=cd.id LEFT JOIN invoice_details i ON cd.invoice_id= i.id LEFT JOIN employee_info e ON i.employee_id=e.id LEFT JOIN dealer_info d ON i.dealer_id=d.id LEFT JOIN client_info client ON i.client_id = client.id LEFT JOIN branch_info br ON c.branch_id=br.id WHERE c.challan_id='$challan_id'")->row();
        $challan_product_by_challan_id = $this->db->query("SELECT cd.id, cd.invoice_id, cd.branch_id, cd.delivery_certificate, cd.date_of_issue, cd.user_id, i.invoice_number, i.employee_id, i.dealer_id, i.challan_number, i.client_id, i.branch_id, i.vat_registration_id, i.date_of_issue, i.product_total, i.delivery_charge, i.others_charge, i.deduction, i.deduction_type, i.gross_payable, i.advance_adjusted, i.amount_to_paid, i.mode_of_payment, i.user_id, i.order_number, i.order_date, i.remarks, i.delivery_address, e.employee_name, e.employee_code, e.employee_email, cl.client_name, cl.client_code, cl.address, cl.client_area, cl.cell_number, cl.phone_number, cl.email, d.dealer_name, d.dealer_code, br.branch_name, br.branch_code FROM challan_details cd LEFT JOIN invoice_details i ON cd.invoice_id=i.id LEFT JOIN employee_info e ON i.employee_id=e.id LEFT JOIN client_info cl ON i.client_id=cl.id LEFT JOIN dealer_info d ON i.dealer_id=d.id LEFT JOIN branch_info br ON i.branch_id=br.id WHERE cd.id = '$challan_id'")->row();
        return $challan_product_by_challan_id;
    }

    public function get_challan_product_list_show($id = 0) {
        $challan_product_list = $this->db->query("SELECT c.id, c.challan_id, c.pack_size, c.quantity, c.total_price, p.product_name FROM challan_product c LEFT JOIN product p ON c.product_id=p.id WHERE c.challan_id='$id'")->result();
        return $challan_product_list;
    }

    public function get_invoice_details_view($id = 0, $employee_id, $user_type, $start_date, $end_date, $branch_id) {
        $branch_id_condition = (intval($branch_id) > 0) ? "AND i.branch_id = '$branch_id'" : "";
        if (($id == 0) && (strtolower($user_type) === 'marketing')) {
            $where_condition = "WHERE e.id = '$employee_id' AND i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' $branch_id_condition ORDER BY i.id DESC";
        } else {
            $where_condition = "WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' $branch_id_condition ORDER BY i.id DESC";
        }
        $invoice_details_list = $this->db->query("SELECT i.id, i.branch_id, i.vat_registration_id, i.employee_id, i.dealer_id, i.challan_number, i.invoice_number, i.date_of_issue, i.gross_payable, i.amount_to_paid, i.mode_of_payment, i.delivery_charge, i.others_charge, i.deduction, i.advance_adjusted, i.user_id, i.order_number, i.order_date, i.client_id, i.delivery_address, u.user_name, u.user_type, c.client_name, d.dealer_name, e.employee_name, g.source, cd.id AS challan_id, br.branch_name FROM invoice_details i LEFT JOIN client_info c ON i.client_id=c.id LEFT JOIN dealer_info d on c.dealer_id = d.id LEFT JOIN employee_info e ON i.employee_id=e.id LEFT JOIN user_info u ON i.user_id=u.id LEFT JOIN gate_pass_details g ON g.invoice_id=i.id LEFT JOIN challan_details cd ON cd.invoice_id=i.id LEFT JOIN branch_info br ON i.branch_id=br.id $where_condition");
        return $invoice_details_list->result();
    }

}
