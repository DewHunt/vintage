<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cheque_print_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Cheque_print_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $this->data['title'] = "Cheque Print Report";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/accounts_report/all_print_report/cheque_print_report/cheque_print_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function cheque_print_report_show_in_table() {  //Cheque Print report show in table
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            $this->data['cheque_print_by_date'] = $this->Cheque_print_Model->get_cheque_print_by_date($start_date, $end_date);
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $this->load->view('reports/accounts_report/all_print_report/cheque_print_report/cheque_print_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function cheque_print_report_print() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $id = trim($this->input->post('id'));  // cheque print id
            $this->data['cheque_print'] = $this->Cheque_print_Model->get_cheque_print_by_cheque_id($id);
            $value = $this->load->view('reports/accounts_report/all_print_report/cheque_print_report/cheque_print_report_print', $this->data, TRUE);
            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('value' => $value)));
        } else {
            redirect(base_url('user_login'));
        }
    }

}
