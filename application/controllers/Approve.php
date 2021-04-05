<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Approve extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->library('cart');
        $this->load->helper('settings_helper');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('User_Model');
        $this->load->model('Product_Model');
        $this->load->model('Product_type_Model');
        $this->load->model('Client_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Sale_product_Model');
        $this->load->model('Invoice_details_Model');
        $this->load->model('Branchwise_product_store_Model');
        $this->load->model('Request_for_discount_model');
    }

    public function approve_discount_request($token_key)
    {
        // echo "<pre>"; print_r($token_key); exit();
        $this->data['title'] = 'Approve Discount Request';
        $this->data['discountInfo'] = $this->Request_for_discount_model->get_discount_info_by_token_key($token_key);
        $this->data['companyInfo'] = $this->Company_Model->get_company();
        // echo "<pre>"; print_r($this->data['discountInfo']); exit();

        $this->load->view('approve/approve_discount_request', $this->data);
    }

    public function approved_requested_discount()
    {
        // echo "<pre>"; print_r($this->input->post()); exit();
        $token_key = $this->input->post('token_key');

        $this->data['title'] = 'Approve Discount Request';
        $approvedDiscountData = array(
        	'approved_discount' => $this->input->post('approved_discount'),
        	'status' => 1
        );
        $this->db->where('token_key',$token_key);
        $this->db->update('request_for_discount',$approvedDiscountData);

        redirect(base_url('approve/approve_discount_request/'.$token_key));
    }

    public function reject_request_discount($token_key)
    {
        // echo "<pre>"; print_r($this->input->post()); exit();
        $this->data['title'] = 'Approve Discount Request';
        $approvedDiscountData = array(
        	'approved_discount' => 0,
        	'status' => 2
        );
        $this->db->where('token_key',$token_key);
        $this->db->update('request_for_discount',$approvedDiscountData);

        redirect(base_url('approve/approve_discount_request/'.$token_key));
    }
}
