<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Branch_wise_stock_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Branch_stock_Model');
        $this->load->model('Product_receive_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $this->data['title'] = "Branch Wise Stock Report";
            $branch_list = $this->Branch_Model->get_branch();
            $this->data['branch_list'] = $branch_list;
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/branch_wise_stock_report/branch_wise_stock_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function branch_wise_stock_report_show() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $branch_id = trim($this->input->post('branch_id'));
            $company_information = $this->Company_Model->get_company();
            $branch_information = $this->Branch_Model->get_branch($branch_id);
            if ((intval($branch_id) > 0) && !empty($branch_information)) {
                $branch_name = $branch_information->branch_name;
            } else {
                $branch_name = 'All';
            }
            $branch_wise_stock_report_view = $this->Branch_stock_Model->branch_wise_stock_report_view($branch_id);
            $this->data['company_information'] = $company_information;
            $this->data['branch_information'] = $branch_information;
            $this->data['branch_name'] = $branch_name;
            $this->data['branch_wise_stock_report_view'] = $branch_wise_stock_report_view;
            $this->load->view('reports/branch_wise_stock_report/branch_wise_stock_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }    

}
