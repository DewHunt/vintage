<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Currency_settings extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Currency_settings_Model');
        $this->load->model('User_Model');
        $this->load->model('Calendar_Model');
        $this->load->model('Events_Model');
    }

    public function index() {  // load assets details
        if (get_user_permission('settings/currency_settings') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "Currency Settings";
        $currency_settings = $this->Currency_settings_Model->get_currency_settings();
        $this->data['currency_settings'] = $currency_settings;
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('settings/currency_settings/currency_settings', $this->data);
    }

    public function save_currency_settings() {  // save Currency Settings information
        if (get_user_permission('settings/currency_settings') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = 'Save Currency Settings';
        $id = (int) trim($this->input->post('id'));
        $currency_symbol = trim($this->input->post('currency_symbol'));
        $currency_name = trim($this->input->post('currency_name'));
        $placement = trim($this->input->post('placement'));
        $currency_settings_data = array(
        'id' => $id,
        'currency_symbol' => $currency_symbol,
        'currency_name' => $currency_name,
        'placement' => $placement,
        );
        $this->form_validation->set_rules('currency_symbol', 'Currency Symbol', 'required');
        $this->form_validation->set_rules('currency_name', 'Currency Name', 'required');
        $this->form_validation->set_rules('placement', 'Placement', 'required');
        if ($this->form_validation->run() === FALSE) {
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('settings/currency_settings/currency_settings');
        } else {
        if (empty($id) || $id == 0) {
            $this->Currency_settings_Model->db->insert('currency_settings', $currency_settings_data);
        } else {
            $this->db->where('id', $currency_settings_data['id']);
            $this->Currency_settings_Model->db->update('currency_settings', $currency_settings_data);
        }
        $this->session->set_flashdata('currency_settings_save_message', 'Currency Settings has been saved successfully.');
        redirect(base_url('settings/currency_settings'));
        }
    }

}
