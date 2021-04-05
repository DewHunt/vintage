<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Test1 extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Bank_Model');
        $this->load->model('User_Model');
    }

    public function index() {  // load bank details
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $this->data['title'] = "Bank";
            $this->data['bank_list'] = $this->Bank_Model->get_bank();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('test_2', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

}
