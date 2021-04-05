<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_bill extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->library('pagination');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Client_Model');
        $this->load->model('Client_sales_details_Model');
        $this->load->model('Client_transaction_details_Model');
    }

    public function index() {
        if (get_user_permission('customer_bill') === false) {
            redirect(base_url('user_login'));
        }
        
    	$this->data['title'] = "Purchase Statement";
    	$this->data['clientList'] = $this->Client_Model->get_client();

        $start_date = date('Y-m-01');
        $end_date = date('Y-m-t');
        $client_id = 'all';

        // echo $start_date." - ".$end_date; exit();

        $this->data['companyInfo'] = $this->Company_Model->get_company();
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->data['customerBillList'] = $this->Client_sales_details_Model->get_customer_bill_by_date_and_customer_id($start_date,$end_date,$client_id);

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('customer_bill/index', $this->data);
    }

    public function show()
    {
        if (get_user_permission('customer_bill') === false) {
            redirect(base_url('user_login'));
        }
        
    	// echo "<pre>"; print_r($this->input->post()); exit();

        $start_date = trim($this->input->post('from_date'));
        $end_date = trim($this->input->post('to_date'));
    	$client_id = $this->input->post('client_id');

        $this->data['companyInfo'] = $this->Company_Model->get_company();
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->data['customerBillList'] = $this->Client_sales_details_Model->get_customer_bill_by_date_and_customer_id($start_date,$end_date,$client_id);

        $output = $this->load->view('customer_bill/customer_bill_table',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }

    public function view()
    {
        if (get_user_permission('customer_bill') === false) {
            redirect(base_url('user_login'));
        }
        
    	// echo "<pre>"; print_r($this->input->post()); exit();
    	$clientId = $this->input->post('clientId');
    	$openingBalance = $this->input->post('openingBalance');
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');

        $this->data['companyInfo'] = $this->Company_Model->get_company();
        $this->data['openingBalance'] = $openingBalance;
        $this->data['start_date'] = $startDate;
        $this->data['end_date'] = $endDate;
        $this->data['clientInfo'] = $this->Client_Model->get_client($clientId);
        $this->data['customerBillInfo'] = $this->Client_transaction_details_Model->get_single_customer_bill_by_date_and_customer_id($clientId,$startDate,$endDate);

        $output = $this->load->view('customer_bill/view_customer_bill_modal',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }
}
