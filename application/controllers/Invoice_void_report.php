<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_void_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->library('pagination');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Client_product_return_info_Model');
        $this->load->model('Client_product_return_details_Model');
    }

    public function index() {
        if (get_user_permission('invoice_void_report') === false) {
            redirect(base_url('user_login'));
        }

    	$this->data['title'] = "Purchase Statement";
    	// get_any_type_branch($condition,$factoryStatus,$hotKitchenStatus)
    	$this->data['factoryList'] = $this->Branch_Model->get_any_type_branch("AND",1,0);
    	$this->data['outletList'] = $this->Branch_Model->get_any_type_branch("AND",0,0);

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('invoice_void_report/index', $this->data);
    }

    public function show()
    {
        if (get_user_permission('invoice_void_report') === false) {
            redirect(base_url('user_login'));
        }
        
    	// echo "<pre>"; print_r($this->input->post()); exit();

        $start_date = $this->input->post('from_date');
        $end_date = $this->input->post('to_date');
    	$factory_id = $this->input->post('factory_id');
        $branch_id = $this->input->post('branch_id');

        $branchHead = "Factory/Outlet";  

        if ($factory_id) {
            $branchHead = "Factory";
        }
        elseif ($branch_id){
            $branchHead = "Outlet";                
        }

        $this->data['companyInfo'] = $this->Company_Model->get_company();
        $this->data['start_date'] = $start_date;
        $this->data['branch_head'] = $branchHead;
        $this->data['end_date'] = $end_date;
        $this->data['invoiceVoidList'] = $this->Client_product_return_info_Model->get_invoice_void_report_by_date_and_branch_id($start_date,$end_date,$factory_id,$branch_id);

        $output = $this->load->view('invoice_void_report/invoice_void_report_table',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }

    public function view()
    {
        if (get_user_permission('invoice_void_report') === false) {
            redirect(base_url('user_login'));
        }
        
    	// echo "<pre>"; print_r($this->input->post()); exit();
        $invoiceVoidId = $this->input->post('invoiceVoidId');
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');

        $this->data['companyInfo'] = $this->Company_Model->get_company();
        $this->data['start_date'] = $startDate;
        $this->data['end_date'] = $endDate;
        $this->data['invoiceVoidInfo'] = $this->Client_product_return_details_Model->get_single_invoice_void_info_by_id($invoiceVoidId);

        $output = $this->load->view('invoice_void_report/view_invoice_void_report_modal',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }
}
