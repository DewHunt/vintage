<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dealer extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Dealer_Model');
        $this->load->model('User_Model');
    }

    public function index() {  // load Dealer details
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $this->data['title'] = "Dealer";
            $this->data['dealer_list'] = $this->Dealer_Model->get_dealer();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('dealer/dealer_details_list', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function create_new_dealer() { // load create new Dealer page
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $this->data['title'] = "Dealer";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('dealer/create_new_dealer');
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function save_dealer() {  // save dealer information
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $this->data['title'] = 'Create New Dealer';
            $dealer_name = trim($this->input->post('dealer_name'));
            $is_dealer_name_exists = $this->Dealer_Model->is_dealer_name_exists($dealer_name);
            if (!empty($is_dealer_name_exists)) {
                $this->session->set_flashdata('dealer_name_exists_message', 'Dealer Already Exists');
                redirect('dealer/create_new_dealer');
            } else {
                $data = array(
                    'dealer_name' => $dealer_name,
                    'dealer_code' => trim($this->input->post('dealer_code')),
                    'address' => trim($this->input->post('address')),
                    'cell_number' => trim($this->input->post('cell_number')),
                    'phone_number' => trim($this->input->post('phone_number')),
                    'email' => trim($this->input->post('email')),
                );

                $this->form_validation->set_rules('dealer_name', 'Dealer name', 'required');

                if ($this->form_validation->run() === FALSE) {
                    $this->load->view('header');
                    $this->load->view('navigation');
                    $this->load->view('dealer/create_new_dealer', $this->data);
                } else {
                    $this->Dealer_Model->db->insert('dealer_info', $data);
                    redirect(base_url('dealer'));
                }
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update_dealer($id = 0) {  // load update dealer information page
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $dealer = $this->Dealer_Model->get_dealer($id);
            if (!empty($dealer)) {
                $this->data['title'] = "Update dealer";
                $this->data['dealer'] = $dealer;
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('dealer/update_dealer', $this->data);
            } else {
                redirect(base_url('dealer'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update() {  // update dealer
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $this->data['title'] = 'Update Dealer';
            $id = trim($this->input->post('id'));
            $dealer_name = trim($this->input->post('dealer_name'));
            $dealer = $this->Dealer_Model->get_dealer($id);
            $this->data['dealer'] = $dealer;
            $dealer_by_id_for_duplicate_check = $this->Dealer_Model->get_dealer_by_id_for_duplicate_check($dealer_name, $id);
            if (empty($dealer_by_id_for_duplicate_check)) {
                $data = array(
                    'id' => $id,
                    'dealer_name' => $dealer_name,
                    'dealer_code' => trim($this->input->post('dealer_code')),
                    'address' => trim($this->input->post('address')),
                    'cell_number' => trim($this->input->post('cell_number')),
                    'phone_number' => trim($this->input->post('phone_number')),
                    'email' => trim($this->input->post('email')),
                );
                $this->form_validation->set_rules('dealer_name', 'Dealer name', 'required');

                if ($this->form_validation->run() === FALSE) {
                    $this->load->view('header');
                    $this->load->view('navigation');
                    $this->load->view('dealer/update_dealer', $this->data);
                } else {
                    $this->db->where('id', $data['id']);
                    $this->Dealer_Model->db->update('dealer_info', $data);
                    redirect(base_url('dealer'));
                }
            } else {
                $this->session->set_flashdata('dealer_name_duplicate_error_message', 'Dealer Already Exists.');
                redirect(base_url('dealer/update_dealer/' . $id));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function delete($id) {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $this->Dealer_Model->delete($id);
            redirect(base_url('dealer'));
        } else {
            redirect(base_url('user_login'));
        }
    }

}
