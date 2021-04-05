<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        exit;
    }

    public function index() { 
        exit;
        if (!empty($this->session->userdata('user_session')) == TRUE) {
            $this->data['title'] = "Bank";
            $this->data['bank_list'] = $this->Bank_Model->get_bank();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('bank/bank_details_list', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }
    
//    public function index() {
//        if (!empty($this->session->userdata('user_session')) == true) {
//            $this->data['title'] = 'Test';
//            $this->load->view('test1', $this->data);
//        } else {
//            redirect(base_url('user_login'));
//        }
//    }

}
