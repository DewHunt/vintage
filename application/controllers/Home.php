<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Login_log_details_Model');
        $this->load->model('Notification_Model');
        $this->load->model('Notification_assign_Model');
        $this->load->model('Weekend_settings_Model');
        $this->load->model('Calendar_Model');
        $this->load->model('Events_Model');
        $this->load->model('Product_Model');
        $this->load->model('Product_reorder_level_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session'))) {
            $this->data['title'] = "Home";
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $weekend_settings = $this->Weekend_settings_Model->get_weekend_settings();
            $this->data['weekend_settings'] = $weekend_settings;
            $login_log_details_with_limit = $this->Login_log_details_Model->get_login_log_details_with_limit(10);
            $this->data['login_log_details_with_limit'] = $login_log_details_with_limit;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('front_page', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function login_log_details_show_in_modal() {
        if (!empty($this->session->userdata('user_session'))) {
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $login_log_details_with_limit = $this->Login_log_details_Model->get_login_log_details_with_limit(100);
            $this->data['login_log_details_with_limit'] = $login_log_details_with_limit;
            $this->load->view('home/login_log_details_modal', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

}
