<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_statement extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->library('pagination');
        $this->load->model('User_Model');
        $this->load->model('Product_type_Model');
        $this->load->model('Product_Model');
        $this->load->model('Product_purchase_model');
        $this->load->model('Company_Model');
        $this->load->model('Supplier_model');
        $this->load->model('Payment_statement_model');
    }

    public function index() {
        if (get_user_permission('payment_statement') === false) {
            redirect(base_url('user_login'));
        }
        
    	$this->data['title'] = "Purchase Statement";
        $this->data['supplierList'] = $this->Supplier_model->get_all_supplier();

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('payment_statement/index', $this->data);
    }

    public function show()
    {
        if (get_user_permission('payment_statement') === false) {
            redirect(base_url('user_login'));
        }
        
    	// echo "<pre>"; print_r($this->input->post()); exit();

        $start_date = trim($this->input->post('from_date'));
        $end_date = trim($this->input->post('to_date'));
    	$supplier_id = $this->input->post('supplier_id');

        $this->data['companyInfo'] = $this->Company_Model->get_company();
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->data['paymentStatementList'] = $this->Payment_statement_model->get_payment_statement($start_date,$end_date,$supplier_id);

        $output = $this->load->view('payment_statement/payment_statement_table',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }

    public function view()
    {
        if (get_user_permission('payment_statement') === false) {
            redirect(base_url('user_login'));
        }
        
    	// echo "<pre>"; print_r($this->input->post()); exit();
    	$supplierId = $this->input->post('supplierId');
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $this->data['companyInfo'] = $this->Company_Model->get_company();
        $this->data['start_date'] = $startDate;
        $this->data['end_date'] = $endDate;
        $this->data['supplierInfo'] = $this->Supplier_model->get_supplier_info_by_id($supplierId);
        $this->data['supplierPaymentInfo'] = $this->Payment_statement_model->get_supplier_payment_info($supplierId,$startDate,$endDate);

        $output = $this->load->view('payment_statement/view_supplier_payment_modal',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }
}
