<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bonus_incentive_system extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Bonus_incentive_system_Model');
    }

    public function index() {  // load bonus_incentive_system details
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['title'] = "Bonus Incentive System";
            $this->data['bonus_incentive_system_list'] = $this->Bonus_incentive_system_Model->get_bonus_incentive_system();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('settings/bonus_incentive_system/bonus_incentive_system_list', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function create_bonus_incentive_system() { // load create new bonus_incentive_system page
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['title'] = "Bonus Incentive System";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('settings/bonus_incentive_system/create_bonus_incentive_system');
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function save_bonus_incentive_system() {  // save bonus_incentive_system information
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['title'] = "Create Bonus Incentive System";
            $incentive_type = trim($this->input->post('incentive_type'));
            $from_amount = trim($this->input->post('from_amount'));
            $to_amount = trim($this->input->post('to_amount'));
            $percent_of_incentive = trim($this->input->post('percent_of_incentive'));
            $data = array(
                'incentive_type' => $incentive_type,
                'from_amount' => $from_amount,
                'to_amount' => $to_amount,
                'percent_of_incentive' => $percent_of_incentive,
            );
            $this->form_validation->set_rules('incentive_type', 'Type', 'required');
            $this->form_validation->set_rules('from_amount', 'From Amount', 'required');
            $this->form_validation->set_rules('to_amount', 'From Amount', 'required');
            $this->form_validation->set_rules('percent_of_incentive', '% of Incentive', 'required');

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('settings/bonus_incentive_system/create_bonus_incentive_system', $this->data);
            } else {
                $this->Bonus_incentive_system_Model->db->insert('bonus_incentive_system', $data);
                redirect(base_url('bonus_incentive_system'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update_bonus_incentive_system($id = 0) {  // load update bonus_incentive_system information page
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $bonus_incentive_system = $this->Bonus_incentive_system_Model->get_bonus_incentive_system($id);
            if (!empty($bonus_incentive_system)) {
                $this->data['title'] = "Update Bonus Incentive System";
                $this->data['bonus_incentive_system'] = $bonus_incentive_system;
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('settings/bonus_incentive_system/update_bonus_incentive_system', $this->data);
            } else {
                redirect(base_url('bonus_incentive_system'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update() {  // update bonus_incentive_system
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['title'] = "Update Bonus Incentive System";
            $id = intval(trim($this->input->post('id')));
            $bonus_incentive_system = $this->Bonus_incentive_system_Model->get_bonus_incentive_system($id);
            $this->data['bonus_incentive_system'] = $bonus_incentive_system;

            $data = array(
                'id' => $id,
                'incentive_type' => trim($this->input->post('incentive_type')),
                'from_amount' => trim($this->input->post('from_amount')),
                'to_amount' => trim($this->input->post('to_amount')),
                'percent_of_incentive' => trim($this->input->post('percent_of_incentive')),
            );
            $this->form_validation->set_rules('incentive_type', 'Type', 'required');
            $this->form_validation->set_rules('from_amount', 'From Amount', 'required');
            $this->form_validation->set_rules('to_amount', 'From Amount', 'required');
            $this->form_validation->set_rules('percent_of_incentive', '% of Incentive', 'required');

            if ($this->form_validation->run() === FALSE) {
                $this->data['bonus_incentive_system'] = $bonus_incentive_system;
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('settings/bonus_incentive_system/update_bonus_incentive_system', $this->data);
            } else {
                $this->db->where('id', $data['id']);
                $this->Bonus_incentive_system_Model->db->update('bonus_incentive_system', $data);
                redirect(base_url('bonus_incentive_system'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function delete($id) {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->Bonus_incentive_system_Model->delete($id);
            redirect(base_url('bonus_incentive_system'));
        } else {
            redirect(base_url('user_login'));
        }
    }

}
