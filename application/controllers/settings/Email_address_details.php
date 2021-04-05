<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Email_address_details extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Currency_settings_Model');
        $this->load->model('User_Model');
        $this->load->model('Email_address_details_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == true)) {
            $is_admin = $this->User_Model->is_loggedin_user_type_admin();
            if ($is_admin) {
                $this->data['title'] = "Email Address Details";
                $this->data['page_title'] = "Email Address Details";
                $email_address_details = $this->Email_address_details_Model->get_email_address_details();
                $this->data['button_text'] = (!empty($email_address_details)) ? "Update" : "Save";
                $this->data['email_address_details'] = $email_address_details;
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('settings/email_address_details/email_address_details', $this->data);
            } else {
                redirect(base_url());
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function save_email_address_details() {  // save Currency Settings information
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == true)) {
            $is_admin = $this->User_Model->is_loggedin_user_type_admin();
            if ($is_admin) {
                $this->data['title'] = 'Save Email Address Details';
                $id = intval(trim($this->input->post('id')));
                $email_to = trim($this->input->post('email_to'));
                $email_to = array_map('trim', explode(',', $email_to));
                $email_cc = trim($this->input->post('email_cc'));
                $email_cc = array_map('trim', explode(',', $email_cc));
                $email_bcc = trim($this->input->post('email_bcc'));
                $email_bcc = array_map('trim', explode(',', $email_bcc));
                $user_info = $this->session->userdata('user_session');
                $user_id = $user_info['user_id']; // session user id
                $data = array(
                    'id' => $id,
                    'email_to' => json_encode($email_to),
                    'email_cc' => json_encode($email_cc),
                    'email_bcc' => json_encode($email_bcc),
                    'user_id' => $user_id
                );
                $this->form_validation->set_rules('email_to', 'To', 'required');
//            $this->form_validation->set_rules('email_cc', 'CC', 'required');
//            $this->form_validation->set_rules('email_bcc', 'BCC', 'required');
                if ($this->form_validation->run() === FALSE) {
                    $this->load->view('header');
                    $this->load->view('navigation');
                    $this->load->view('settings/email_address_details/email_address_details', $this->data);
                } else {
                    if ((empty($id)) || ($id === 0)) {
                        $this->Email_address_details_Model->db->insert('email_address_details', $data);
                    } else {
                        $this->db->where('id', $data['id']);
                        $this->Email_address_details_Model->db->update('email_address_details', $data);
                    }
                    $this->session->set_flashdata('email_address_details_save_message', 'Information has been saved successfully.');
                    redirect(base_url('settings/email_address_details'));
                }
            } else {
                redirect(base_url());
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

}
