<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Request_for_discount extends CI_Controller {

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

    public function save()
    {
        // echo "<pre>"; print_r($this->input->post()); exit();
        $token_number = $this->input->post('requestTokenNumber');
        $branch_id = $this->input->post('requestBranchId');

        $isExists = $this->Request_for_discount_model->is_exists_request($token_number,$branch_id);
        $msg = "";
        $errorMsg = "";

        if ($isExists) {
        	$discount_id = $isExists->id;
        	$errorMsg = 'You Already Send Request For This Order. Please Wait A Minute.';
        }
        else {
        	$token_key = $this->generate_random_string(25);
	        $data = array(
	        	'token_number' => $token_number,
	        	'branch_id' => $branch_id,
	        	'discount' => $this->input->post('requestDiscount'),
	        	'reason' => $this->input->post('requestReason'),
	        	'token_key' => $token_key,
	        );
        	// echo "<pre>"; print_r($data); exit();
        	$this->db->insert('request_for_discount',$data);
        	$discount_id = $this->db->insert_id();;

        	$msg = 'Request Send Successfully. Please Wait 5 Minutes For Confirmation.';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'msg' => $msg,
            'errorMsg' => $errorMsg,
            'discount_id' => $discount_id
        )));
    }

    function generate_random_string($length = 10) {
    	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$charactersLength = strlen($characters);
    	$randomString = '';
    	for ($i = 0; $i < $length; $i++) {
    		$randomString .= $characters[rand(0, $charactersLength - 1)];
    	}
    	return $randomString;
    }
}
