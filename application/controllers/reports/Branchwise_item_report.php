<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Branchwise_item_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Branch_Model');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Branchwise_product_store_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $this->data['title'] = "Branchwise Item Report";
            $company_information = $this->Company_Model->get_company();
            $product_list = $this->Product_Model->get_product();
            $branch_list = $this->Branch_Model->get_branch();
            $this->data['product_list'] = $product_list;
            $this->data['branch_list'] = $branch_list;
            $this->data['company_information'] = $company_information;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/branchwise_item_report/branchwise_item_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function branchwise_item_report_show() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $branch_id = trim($this->input->post('branch_id'));
            $product_id = trim($this->input->post('product_id'));
            $start_date = get_start_date_format(trim($this->input->post('start_date')));
            $end_date = get_end_date_format(trim($this->input->post('end_date')));
            $company_information = $this->Company_Model->get_company();
            $product_information = $this->Product_Model->get_product($product_id);
            $branch_information = $this->Branch_Model->get_branch($branch_id);
            if (!empty($branch_information)) {
                $branch_name = $branch_information->branch_name;
            } else {
                $branch_name = 'All';
            }
            if (!empty($product_information)) {
                $product_name = $product_information->product_name;
            } else {
                $product_name = 'All';
            }
            $branchwise_item_product_store_report_view = $this->get_branchwise_item_product_store_report_view($branch_id, $product_id, $start_date, $end_date);
            $this->data['company_information'] = $company_information;
            $this->data['product_information'] = $product_information;
            $this->data['product_name'] = $product_name;
            $this->data['branch_name'] = $branch_name;
            $this->data['branch_information'] = $branch_information;
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->data['branchwise_item_product_store_report_view'] = $branchwise_item_product_store_report_view;
            $this->load->view('reports/branchwise_item_report/branchwise_item_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_branchwise_item_product_store_report_view($branch_id, $product_id, $start_date, $end_date) {
        if (($branch_id > 0) && ($product_id > 0)) {
            $branchwise_item_product_store_report_view = $this->db->query("SELECT bps.id, bps.product_store_date, bps.product_id, bps.branch_id, bps.open_stock, bps.receive_stock, bps.transfer_stock, bps.sale_from_stock, bps.damage_stock, p.product_name, b.branch_name FROM branchwise_product_store bps JOIN product p ON bps.product_id=p.id JOIN branch_info b ON bps.branch_id=b.id WHERE bps.branch_id='$branch_id' AND bps.product_id='$product_id' AND bps.product_store_date >= '$start_date' AND bps.product_store_date <= '$end_date'")->result();
        } elseif (($branch_id <= 0 || $branch_id == '') && ($product_id > 0)) {
            $branchwise_item_product_store_report_view = $this->db->query("SELECT bps.id, bps.product_store_date, bps.product_id, bps.branch_id, bps.open_stock, bps.receive_stock, bps.transfer_stock, bps.sale_from_stock, bps.damage_stock, p.product_name, b.branch_name FROM branchwise_product_store bps JOIN product p ON bps.product_id=p.id JOIN branch_info b ON bps.branch_id=b.id WHERE bps.product_id='$product_id' AND bps.product_store_date >= '$start_date' AND bps.product_store_date <= '$end_date'")->result();
        } elseif (($branch_id > 0) && ($product_id <= 0 || $product_id == '')) {
            $branchwise_item_product_store_report_view = $this->db->query("SELECT bps.id, bps.product_store_date, bps.product_id, bps.branch_id, bps.open_stock, bps.receive_stock, bps.transfer_stock, bps.sale_from_stock, bps.damage_stock, p.product_name, b.branch_name FROM branchwise_product_store bps JOIN product p ON bps.product_id=p.id JOIN branch_info b ON bps.branch_id=b.id WHERE bps.branch_id='$branch_id' AND bps.product_store_date >= '$start_date' AND bps.product_store_date <= '$end_date'")->result();
        } else {
            $branchwise_item_product_store_report_view = $this->db->query("SELECT bps.id, bps.product_store_date, bps.product_id, bps.branch_id, bps.open_stock, bps.receive_stock, bps.transfer_stock, bps.sale_from_stock, bps.damage_stock, p.product_name, b.branch_name FROM branchwise_product_store bps JOIN product p ON bps.product_id=p.id JOIN branch_info b ON bps.branch_id=b.id WHERE bps.product_store_date >= '$start_date' AND bps.product_store_date <= '$end_date'")->result();
        }
        return $branchwise_item_product_store_report_view;
    }

}
