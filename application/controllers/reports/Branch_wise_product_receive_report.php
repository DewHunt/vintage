<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Branch_wise_product_receive_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Branch_stock_Model');
        $this->load->model('Product_receive_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $this->data['title'] = "BranchWise Product Receive Report";
            $branch_list = $this->Branch_Model->get_branch();
            $this->data['branch_list'] = $branch_list;
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $user_information = $this->User_Model->get_user();
            $this->data['user_information'] = $user_information;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/branch_wise_product_receive_report/branch_wise_product_receive_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function branch_wise_product_receive_report_show() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $branch_id = $this->input->post('branch_id');
            $user_id = $this->input->post('user_id');
            $company_information = $this->Company_Model->get_company();
            $branch_information = $this->Branch_Model->get_branch($branch_id);
            $user_information = $this->User_Model->get_user($user_id);
            if (!empty($branch_information)) {
                $branch_name = $branch_information->branch_name;
            } else {
                $branch_name = 'All';
            }
            if (!empty($user_information)) {
                $user_name = $user_information->user_name;
            } else {
                $user_name = 'All';
            }
            $branch_wise_product_receive_report_view_by_date = $this->branch_wise_product_receive_report_view_by_date($branch_id, $user_id, $start_date, $end_date);
            $this->data['company_information'] = $company_information;
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->data['branch_information'] = $branch_information;
            $this->data['branch_name'] = $branch_name;
            $this->data['user_name'] = $user_name;
            $this->data['branch_wise_product_receive_report_view_by_date'] = $branch_wise_product_receive_report_view_by_date;
            $this->load->view('reports/branch_wise_product_receive_report/branch_wise_product_receive_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function branch_wise_product_receive_report_view_by_date($branch_id, $user_id, $start_date, $end_date) {
        if (($branch_id > 0) && ($user_id > 0)) {
            $branch_wise_product_receive_report_list = $this->db->query("SELECT pr.id, pr.user_id, pr.quantity, pr.product_source,pr.total_price,pr.product_receive_date, b.branch_name, b.branch_area, p.product_name, u.user_name FROM product_receive pr JOIN branch_info b ON pr.branch_id=b.id JOIN product p ON pr.product_id=p.id JOIN user_info u ON pr.user_id=u.id WHERE pr.user_id='$user_id' AND pr.branch_id='$branch_id' AND pr.product_receive_date >= '$start_date' AND pr.product_receive_date <= '$end_date'")->result();
        } elseif (($branch_id <= 0 || $branch_id == '') && ($user_id > 0)) {
            $branch_wise_product_receive_report_list = $this->db->query("SELECT pr.id, pr.user_id, pr.quantity, pr.product_source,pr.total_price,pr.product_receive_date, b.branch_name, b.branch_area, p.product_name, u.user_name FROM product_receive pr JOIN branch_info b ON pr.branch_id=b.id JOIN product p ON pr.product_id=p.id JOIN user_info u ON pr.user_id=u.id WHERE pr.user_id='$user_id' AND pr.product_receive_date >= '$start_date' AND pr.product_receive_date <= '$end_date'")->result();
        } elseif (($branch_id > 0) && ($user_id <= 0 || $user_id == '')) {
            $branch_wise_product_receive_report_list = $this->db->query("SELECT pr.id, pr.user_id, pr.quantity, pr.product_source,pr.total_price,pr.product_receive_date, b.branch_name, b.branch_area, p.product_name, u.user_name FROM product_receive pr JOIN branch_info b ON pr.branch_id=b.id JOIN product p ON pr.product_id=p.id JOIN user_info u ON pr.user_id=u.id WHERE pr.branch_id='$branch_id' AND pr.product_receive_date >= '$start_date' AND pr.product_receive_date <= '$end_date'")->result();
        } else {
            $branch_wise_product_receive_report_list = $this->db->query("SELECT pr.id, pr.quantity, pr.product_source,pr.total_price,pr.product_receive_date, b.branch_name, b.branch_area, p.product_name, u.user_name FROM product_receive pr JOIN branch_info b ON pr.branch_id=b.id JOIN product p ON pr.product_id=p.id JOIN user_info u ON pr.user_id=u.id WHERE pr.product_receive_date >= '$start_date' AND pr.product_receive_date <= '$end_date'")->result();
        }
        return $branch_wise_product_receive_report_list;
    }

}
