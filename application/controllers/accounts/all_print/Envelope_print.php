<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Envelope_print extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Envelope_print_Model');
    }

    public function index() { // envelope print 
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['title'] = "Small Envelope Print";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('accounts/all_print/envelope_print/envelope_print', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function envelope_print_save() { // envelope print save
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['title'] = "Envelope Print Save";
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $envelope_size = trim($this->input->post('envelope_size'));
            $envelope_print_data = array(
                'envelope_title' => trim($this->input->post('envelope_title')),
                'from_envelope_details' => trim($this->input->post('from_envelope_details')),
                'to_envelope_details' => trim($this->input->post('to_envelope_details')),
                'envelope_size' => $envelope_size,
                'current_date_time' => get_current_date_and_time(),
                'user_id' => $user_id,
            );
            if (empty($envelope_print_data['envelope_title'])) {
                $this->session->set_flashdata('envelope_print_error_message', 'Please Enter Title.');
                redirect(base_url('accounts/all_print/envelope_print'));
            } else {
                if (empty($envelope_size)) {
                    $this->session->set_flashdata('envelope_print_error_message', 'Please Enter Envelope Size.');
                    redirect(base_url('accounts/all_print/envelope_print'));
                } else {
                    if (empty($envelope_print_data['from_envelope_details']) && empty($envelope_print_data['to_envelope_details'])) {
                        $this->session->set_flashdata('envelope_print_error_message', 'Please Enter From Or To Details.');
                        redirect(base_url('accounts/all_print/envelope_print'));
                    } else {
                        $this->Envelope_print_Model->db->insert('envelope_print', $envelope_print_data);
                        $currently_inserted_id = $this->db->insert_id();
                        if ((int) $currently_inserted_id > 0) {
                            $this->session->set_flashdata('envelope_print_save_success_message', 'Information has been saved Successfully');
                            $this->envelope_print_print($currently_inserted_id, $envelope_size);
                            //redirect(base_url('accounts/all_print/envelope_print'));
                        } else {
                            $this->session->set_flashdata('envelope_print_error_message', 'Error Occuered.');
                            redirect(base_url('accounts/all_print/envelope_print'));
                        }
                    }
                }
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function envelope_print_print($currently_inserted_id, $envelope_size) {  // envelope print print page
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['envelope_print'] = $this->Envelope_print_Model->get_envelope_print($currently_inserted_id);
            $this->data['title'] = "Envelope Print Print";
            $this->load->view('header');
            if (strtolower($envelope_size) == 'small') {
                $this->load->view('accounts/all_print/envelope_print/small_envelope_print', $this->data);
            } elseif (strtolower($envelope_size) == 'medium') {
                $this->load->view('accounts/all_print/envelope_print/medium_envelope_print', $this->data);
            } else { // large
                $this->load->view('accounts/all_print/envelope_print/large_envelope_print', $this->data);
            }            
        } else {
            redirect(base_url('user_login'));
        }
    }

}
