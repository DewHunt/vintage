<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Envelope_print_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Envelope_print_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $this->data['title'] = "Envelope Print Report";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->data['all_envelope_print'] = $this->Envelope_print_Model->get_all_envelope_print();
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $this->load->view('reports/accounts_report/all_print_report/envelope_print_report/envelope_print_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function envelope_print_report_print() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $id = trim($this->input->post('id'));  // envelope print id
            $envelope_size = trim($this->input->post('envelope_size'));  // envelope size
            $this->data['envelope_print'] = $this->Envelope_print_Model->get_all_envelope_print($id);
            if (strtolower($envelope_size) == 'small') {
                $value = $this->load->view('reports/accounts_report/all_print_report/envelope_print_report/small_envelope_print_report_print', $this->data, TRUE);
            } elseif (strtolower($envelope_size) == 'medium') {
                $value = $this->load->view('reports/accounts_report/all_print_report/envelope_print_report/medium_envelope_print_report_print', $this->data, TRUE);
            } else { // large
                $value = $this->load->view('reports/accounts_report/all_print_report/envelope_print_report/large_envelope_print_report_print', $this->data, TRUE);
            }
            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('value' => $value)));
        } else {
            redirect(base_url('user_login'));
        }
    }

}
