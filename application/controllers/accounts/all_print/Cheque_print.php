<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cheque_print extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Bank_Model');
        $this->load->model('Cheque_print_Model');
    }

    public function index() {  // Load cheque print
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['title'] = "Cheque Print";
            $this->data['bank_list'] = $this->Bank_Model->get_bank();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('accounts/all_print/cheque_print/cheque_print', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function cheque_print_save() { // cheque print save
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['title'] = "Cheque Print Save";
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $amount = trim($this->input->post('amount'));
            $cheque_print_data = array(
                'bank_id' => trim($this->input->post('bank_id')),
                'cheque_date' => trim($this->input->post('cheque_date')),
                'pay_to' => trim($this->input->post('pay_to')),
                'amount' => $amount,
                'amount_in_words' => trim($this->input->post('amount_in_words')),
                'details' => trim($this->input->post('details')),
                'current_date_time' => get_current_date_and_time(),
                'user_id' => $user_id,
            );
            $this->form_validation->set_rules('bank_id', 'Bank', 'required');
            $this->form_validation->set_rules('cheque_date', 'Date', 'required');
            $this->form_validation->set_rules('pay_to', 'Pay To', 'required');
            $this->form_validation->set_rules('amount', 'Amount', 'required');
            $this->form_validation->set_rules('amount_in_words', 'Amount In Words', 'required');
            if ($this->form_validation->run() === FALSE) {
                $this->data['title'] = "Cheque Print";
                $this->data['bank_list'] = $this->Bank_Model->get_bank();
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('accounts/all_print/cheque_print/cheque_print', $this->data);
            } else {
                if (valid_numeric_number_check($amount)) {
                    $this->Cheque_print_Model->db->insert('cheque_print', $cheque_print_data);
                    $currently_inserted_id = $this->db->insert_id();
                    if ((int) $currently_inserted_id > 0) {
                        $this->session->set_flashdata('cheque_print_save_success_message', 'Information has been saved Successfully');
                        $this->cheque_print_print($currently_inserted_id);
                    } else {
                        $this->session->set_flashdata('cheque_print_error_message', 'Error Occuered.');
                        redirect(base_url('accounts/all_print/cheque_print'));
                    }
                } else {
                    $this->session->set_flashdata('cheque_print_error_message', 'Please Input a Numeric value for Amount.');
                    redirect(base_url('accounts/all_print/cheque_print'));
                }
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function cheque_print_print($currently_inserted_id) {  // cheque print print page
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['cheque_print'] = $this->Cheque_print_Model->get_cheque_print($currently_inserted_id);
            $this->data['title'] = "Cheque Print Print";
            $this->load->view('header');
            $this->load->view('accounts/all_print/cheque_print/cheque_print_print', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

}
