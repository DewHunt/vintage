<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoicewise_product_sales_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Product_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Invoice_details_Model');
        $this->load->model('Sale_product_Model');
        $this->load->model('Client_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $this->data['title'] = "Invoicewise Product Sales Report";
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id'];
            $user_type = $user_info['user_type'];
            $employee_id = $user_info['employee_id'];
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['currency_settings'] = $currency_settings;
            $product_list = $this->Product_Model->get_product();
            $this->data['product_list'] = $product_list;
            $this->data['client_list'] = $this->Client_Model->get_client();
            $this->data['branch_list'] = $this->Branch_Model->get_branch();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/invoicewise_product_sales_report/invoicewise_product_sales_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function invoicewise_product_sales_report_show_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $branch_id = trim($this->input->post('branch_id'));
            $product_id = trim($this->input->post('product_id'));
            $client_id = trim($this->input->post('client_id'));
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            if (empty($start_date) || empty($end_date)) {
                echo "<div class='error text-align-center'>Please Select Date</div>";
            } else {
                $product_information = $this->Product_Model->get_product($product_id);
                if (!empty($product_information)) {
                    $product_name = $product_information->product_name;
                    $pack_size = $product_information->pack_size;
                } else {
                    $product_name = 'All';
                    $pack_size = '';
                }
                $client_information = $this->Client_Model->get_client($client_id);
                if (!empty($client_information)) {
                    $client_name = $client_information->client_name;
                    $client_code = $client_information->client_code;
                } else {
                    if ($client_id == 'import' || $client_id == 'lubzone') {
                        $client_name = 'All ' . '(' . $client_id . ')';
                        $client_code = '';
                    } else {
                        $client_name = 'All';
                        $client_code = '';
                    }
                }
                if (!empty($branch_id)) {
                    $branch = $this->Branch_Model->get_branch($branch_id);
                    $branch_name = !empty($branch) ? $branch->branch_name : '';
                } else {
                    $branch_name = 'All';
                }
                $this->data['branch_name'] = $branch_name;
                $invoice_details_by_product_list = $this->get_invoice_details_by_product($branch_id, $client_id, $product_id, $start_date, $end_date);
                $this->data['invoice_details_by_product_list'] = $invoice_details_by_product_list;
                $company_information = $this->Company_Model->get_company();
                $this->data['company_information'] = $company_information;
                $currency_settings = $this->Currency_settings_Model->get_currency_settings();
                $this->data['currency_settings'] = $currency_settings;
                $this->data['product_information'] = $product_information;
                $this->data['client_information'] = $client_information;
                $this->data['product_name'] = $product_name;
                $this->data['pack_size'] = $pack_size;
                $this->data['client_name'] = $client_name;
                $this->data['client_code'] = $client_code;
                $this->data['start_date'] = $start_date;
                $this->data['end_date'] = $end_date;
                $this->load->view('reports/invoicewise_product_sales_report/invoicewise_product_sales_report_table', $this->data);
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_invoice_details_by_product($branch_id = 0, $client_id, $product_id, $start_date, $end_date) {
        $branch_id_condition = (intval($branch_id) > 0) ? "AND sp.branch_id = '$branch_id'" : "";
        if (((int) $client_id > 0) && ((int) $product_id > 0)) {
            $where_condition = "i.client_id='$client_id' AND sp.product_id='$product_id' AND i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' $branch_id_condition";
        } elseif (($client_id == 'import' || $client_id == 'lubzone') && ((int) $product_id == 0)) {
            $client_type = $client_id;
            $where_condition = "c.client_type='$client_type' AND i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' $branch_id_condition";
        } elseif (($client_id == 'import' || $client_id == 'lubzone') && ((int) $product_id > 0)) {
            $client_type = $client_id;
            $where_condition = "c.client_type='$client_type' AND sp.product_id='$product_id' AND i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' $branch_id_condition";
        } elseif ((int) $client_id == 0 && (int) $product_id > 0) {
            $where_condition = "sp.product_id='$product_id' AND i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' $branch_id_condition";
        } elseif (((int) $client_id > 0) && ((int) $product_id == 0)) {
            $where_condition = "i.client_id='$client_id' AND i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' $branch_id_condition";
        } else {
            $where_condition = "i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' $branch_id_condition";
        }
        $query_result = $this->db->query("SELECT sp.id, sp.product_id, sp.branch_id, (SELECT branch_name FROM branch_info WHERE sp.branch_id = branch_info.id) AS branch_name, sp.pack_size, sp.quantity, sp.unit_price, sp.sales_price_excluding_vat, sp.vat, sp.sales_price_including_vat, sp.invoice_id, sp.gate_pass_remarks, p.product_name, p.product_code, p.pack_size, i.date_of_issue, i.invoice_number, i.challan_number, i.client_id, c.client_name, c.client_type FROM sale_product sp LEFT JOIN product p ON sp.product_id=p.id LEFT JOIN invoice_details i ON i.id=sp.invoice_id LEFT JOIN client_info c ON c.id=i.client_id WHERE $where_condition");
        return $query_result->result();
    }

    /* public function get_invoice_details_by_product($product_id = 0, $start_date, $end_date) {
      if (!empty($product_id) && (int) $product_id > 0) {
      $query_result = $this->db->query("SELECT sp.id, sp.product_id, sp.branch_id, sp.pack_size, sp.quantity, sp.unit_price, sp.sales_price_excluding_vat, sp.vat, sp.sales_price_including_vat, sp.invoice_id, sp.gate_pass_remarks, p.product_name, p.product_code, p.pack_size, i.date_of_issue, i.invoice_number, i.challan_number, i.client_id, c.client_name, c.client_type FROM sale_product sp LEFT JOIN product p ON sp.product_id=p.id LEFT JOIN invoice_details i ON i.id=sp.invoice_id LEFT JOIN client_info c ON c.id=i.client_id WHERE sp.product_id='$product_id' AND i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date'")->result();
      } else {
      $query_result = $this->db->query("SELECT sp.id, sp.product_id, sp.branch_id, sp.pack_size, sp.quantity, sp.unit_price, sp.sales_price_excluding_vat, sp.vat, sp.sales_price_including_vat, sp.invoice_id, sp.gate_pass_remarks, p.product_name, p.product_code, p.pack_size, i.date_of_issue, i.invoice_number, i.challan_number, i.client_id, c.client_name, c.client_type FROM sale_product sp LEFT JOIN product p ON sp.product_id=p.id LEFT JOIN invoice_details i ON i.id=sp.invoice_id LEFT JOIN client_info c ON c.id=i.client_id WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date'")->result();
      }
      return $query_result;
      } */
}
