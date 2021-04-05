<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Weekend_settings extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Weekend_settings_Model');
        $this->load->model('User_Model');
    }

    public function index() {  // load assets details
        if (get_user_permission('settings/weekend_settings') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "Weekend Settings";
        $this->data['weekend_settings_list'] = $this->Weekend_settings_Model->get_weekend_settings();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('settings/weekend_settings/weekend_settings_details', $this->data);
    }

    public function create_weekend_settings() { // load create new weekend settings page
        if (get_user_permission('settings/weekend_settings') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = "Create Weekend Settings";
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('settings/weekend_settings/create_weekend_settings');
    }

    public function save_weekend_settings() {  // save Income Head information
        if (get_user_permission('settings/weekend_settings') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = 'Save Weekend Settings';
        $weekend_day = trim($this->input->post('weekend_day'));
        $weekend_day_name = $this->Weekend_settings_Model->get_weekend_day_name($weekend_day);
        if ((empty($weekend_day_name))) {
            $data = array(
                'weekend_day' => $weekend_day,
            );
            $this->form_validation->set_rules('weekend_day', 'Weekend Day', 'required');
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('settings/weekend_settings/create_weekend_settings', $data);
            } else {
                $this->Weekend_settings_Model->db->insert('weekend_settings', $data);
                redirect(base_url('settings/weekend_settings'));
            }
        } else {
            $this->session->set_flashdata('weekend_day_duplicate_error_message', 'Weekend Day Already Exists.');
            redirect(base_url('settings/weekend_settings/create_weekend_settings'));
        }
    }

    public function update_weekend_settings($id = 0) {  // load update Weekend Settings page
        if (get_user_permission('settings/weekend_settings') === false) {
            redirect(base_url('user_login'));
        }

        $weekend_settings = $this->Weekend_settings_Model->get_weekend_settings($id);
        if (!empty($weekend_settings)) {
            $this->data['title'] = "Update Weekend Settings";
            $this->data['weekend_settings'] = $weekend_settings;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('settings/weekend_settings/update_weekend_settings', $this->data);
        } else {
            redirect(base_url('settings/weekend_settings'));
        }
    }

    public function update() {  // update Weekend Head
        if (get_user_permission('settings/weekend_settings') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = 'Update Weekend Day';
        $id = $this->input->post('id');
        $weekend_day = trim($this->input->post('weekend_day'));
        $weekend_settings_info = $this->Weekend_settings_Model->get_weekend_settings($id);
        $this->data['weekend_settings_info'] = $weekend_settings_info;
        $weekend_day_by_id_for_duplicate_check = $this->Weekend_settings_Model->get_weekend_day_by_id_for_duplicate_check($weekend_day, $id);
        if ((empty($weekend_day_by_id_for_duplicate_check))) {
            $data = array(
                'id' => $id,
                'weekend_day' => $weekend_day,
            );
            $this->form_validation->set_rules('weekend_day', 'Weekend Day', 'required');

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('settings/weekend_settings/update_weekend_settings', $this->data);
            } else {
                $this->db->where('id', $data['id']);
                $this->Weekend_settings_Model->db->update('weekend_settings', $data);
                redirect(base_url('settings/weekend_settings'));
            }
        } else {
            $this->session->set_flashdata('weekend_day_duplicate_error_message', 'Weekend Day Already Exists.');
            redirect(base_url('settings/weekend_settings/update_weekend_settings/' . $id));
        }
    }

    public function delete($id) {
        if (get_user_permission('settings/weekend_settings') === false) {
            redirect(base_url('user_login'));
        }

        $this->Weekend_settings_Model->delete($id);
        redirect(base_url('settings/weekend_settings'));
    }

}
