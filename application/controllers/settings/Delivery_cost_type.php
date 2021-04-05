<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_cost_type extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Delivery_cost_type_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == true)) {
            $this->data['title'] = "Delivery Cost Type";
            $this->data['delivery_cost_type_list'] = $this->Delivery_cost_type_Model->get_delivery_cost_type();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('settings/delivery_cost_type/delivery_cost_type_details', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function create_delivery_cost_type() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == true)) {
            $this->data['title'] = "Create Delivery Cost Type";
            $this->data['page_title'] = "Create Delivery Cost Type";
            $this->data['button_text'] = "Save";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('settings/delivery_cost_type/create_delivery_cost_type', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function save_delivery_cost_type() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == true)) {
            $this->data['title'] = 'Save Delivery Cost Type';
            $delivery_cost_name = trim($this->input->post('delivery_cost_name'));
            if (empty($delivery_cost_name)) {
                $this->session->set_flashdata('delivery_cost_name_error_message', 'Please enter delivery cost name.');
                redirect(base_url('settings/delivery_cost_type/create_delivery_cost_type'));
            } else {
                $is_exists = $this->Delivery_cost_type_Model->is_delivery_cost_type_exists($delivery_cost_name);
                if ($is_exists) {
                    $this->session->set_flashdata('delivery_cost_type_duplicate_error_message', 'This Delivery cost Name Already Exists.');
                    redirect(base_url('settings/delivery_cost_type/create_delivery_cost_type'));
                } else {
                    $data = array('delivery_cost_name' => $delivery_cost_name);
                    $this->Delivery_cost_type_Model->db->insert('delivery_cost_type', $data);
                    redirect(base_url('settings/delivery_cost_type'));
                }
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update_delivery_cost_type($id = 0) { // load create new weekend settings page
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == true)) {
            if (intval($id) > 0) {
                $this->data['title'] = "Update Delivery Cost Type";
                $this->data['page_title'] = "Update Delivery Cost Type";
                $this->data['button_text'] = "Update";
                $this->data['delivery_cost_type'] = $this->Delivery_cost_type_Model->get_delivery_cost_type($id);
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('settings/delivery_cost_type/update_delivery_cost_type', $this->data);
            } else {
                redirect(base_url('settings/delivery_cost_type'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update() {  // save Income Head information
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == true)) {
            $this->data['title'] = 'Update Delivery Cost Type';
            $id = intval(trim($this->input->post('id')));
            $delivery_cost_name = trim($this->input->post('delivery_cost_name'));
            if (empty($delivery_cost_name)) {
                $this->session->set_flashdata('delivery_cost_name_error_message', 'Please enter delivery cost name.');
                redirect(base_url('settings/delivery_cost_type/update_delivery_cost_type'));
            } else {
                $is_exists = $this->Delivery_cost_type_Model->is_delivery_cost_type_exists($delivery_cost_name, $id);
                if ($is_exists) {
                    $this->session->set_flashdata('delivery_cost_type_duplicate_error_message', 'This Delivery cost Name Already Exists.');
                    redirect(base_url('settings/delivery_cost_type/update_delivery_cost_type'));
                } else {
                    $data = array('id' => $id, 'delivery_cost_name' => $delivery_cost_name);
                    $this->db->where('id', $data['id']);
                    $this->Delivery_cost_type_Model->db->update('delivery_cost_type', $data);
                    redirect(base_url('settings/delivery_cost_type'));
                }
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function delete($id) {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == true)) {
            if (intval($id) > 0) {
                $delivery_cost_type = $this->Delivery_cost_type_Model->get_delivery_cost_type($id);
                if (!empty($delivery_cost_type)) {
                    $this->Delivery_cost_type_Model->delete($id);
                }
            }
            redirect(base_url('settings/delivery_cost_type'));
        } else {
            redirect(base_url('user_login'));
        }
    }

}
