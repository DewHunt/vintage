<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Product_receive_Model');
        $this->load->model('Product_transfer_model');
    }

    public function index() {
        if (get_user_permission('transfer_report') === false) {
            redirect(base_url('user_login'));
        }
        $branch_list = $this->Branch_Model->get_branch();
        $company_information = $this->Company_Model->get_company();

        $this->data['title'] = "Transfer Report";
        $this->data['branch_list'] = $branch_list;

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('transfer_report/index', $this->data);
    }

    public function show() {
        if (get_user_permission('transfer_report') === false) {
            redirect(base_url('user_login'));
        }
        
        $start_date = trim($this->input->post('from_date'));
        $end_date = trim($this->input->post('to_date'));
    	$branch_id = $this->input->post('branch_id');

        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->data['companyInfo'] = $this->Company_Model->get_company();
        $this->data['transferReport'] = $this->Product_receive_Model->get_transfer_report($start_date,$end_date,$branch_id);
        // echo "<pre>"; print_r($this->data['transferReport']); exit();

        $output = $this->load->view('transfer_report/transfer_report_table',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }

    public function view() {
        if (get_user_permission('transfer_report') === false) {
            redirect(base_url('user_login'));
        }

    	$transferId = $this->input->post('transferId');
        $this->data['companyInfo'] = $this->Company_Model->get_company();
        $this->data['transferReportInfo'] = $this->Product_transfer_model->get_transfer_product_challan_by_id($transferId);
        $this->data['transferReportProductList'] = $this->Product_transfer_model->get_transfer_product_list_by_transfer_product_challan_id($transferId);

        $output = $this->load->view('transfer_report/transfer_report_modal',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }
}
