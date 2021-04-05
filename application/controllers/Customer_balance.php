<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_balance extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->library('pagination');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Client_Model');
    }

    public function index() {
        if (get_user_permission('customer_balance') === false) {
            redirect(base_url('user_login'));
        }
        
    	$this->data['title'] = "Customer Balance";
    	$this->data['clientInfo'] = $this->Client_Model->get_client();
        $this->data['companyInfo'] = $this->Company_Model->get_company();

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('customer_balance/index', $this->data);
    }
}
