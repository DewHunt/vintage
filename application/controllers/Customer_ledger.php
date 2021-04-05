<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_ledger extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->library('pagination');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Client_Model');
        $this->load->model('Client_transaction_details_Model');
    }

    public function index() {
        if (get_user_permission('customer_ledger') === false) {
            redirect(base_url('user_login'));
        }

    	$this->data['title'] = "Customer Ledger";
    	$this->data['clientList'] = $this->Client_Model->get_client();

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('customer_ledger/index', $this->data);
    }

    public function show() {
        if (get_user_permission('customer_ledger') === false) {
            redirect(base_url('user_login'));
        }
        
    	// echo "<pre>"; print_r($this->input->post()); exit();

        $start_date = trim($this->input->post('from_date'));
        $end_date = trim($this->input->post('to_date'));
    	$client_id = $this->input->post('client_id');

        $this->data['companyInfo'] = $this->Company_Model->get_company();
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->data['customerLedgerList'] = $this->Client_transaction_details_Model->get_customer_transaction_details_by_date_and_client_id($start_date,$end_date,$client_id);

        $output = $this->load->view('customer_ledger/customer_ledger_table',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }
}
