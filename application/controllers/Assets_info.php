<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Assets_info extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Assets_info_Model');
        $this->load->model('Assign_assets_Model');
        $this->load->model('User_Model');
    }

    public function index() {
        if (get_user_permission('assets_info') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = "Assets Info";
        $this->data['assets_info_list'] = $this->Assets_info_Model->get_assets_info();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('assets_info/assets_info_details_list', $this->data);
    }

    public function create_new_assets_info() { // load create new assets page
        if (get_user_permission('assets_info') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = "Assets Create";
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('assets_info/create_new_assets_info');
    }

    public function save_assets_info() {  // save assets information
        if (get_user_permission('assets_info') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = 'Create New Assets Info';
        $assets_name = trim($this->input->post('assets_name'));
        $assets_info_by_name = $this->Assets_info_Model->get_assets_info_by_name($assets_name);
        if (empty($assets_info_by_name)) {
            $data = array(
                'assets_name' => $assets_name,
                'assets_code' => trim($this->input->post('assets_code')),
                'assets_quantity' => trim($this->input->post('assets_quantity')),
                'assigned_assets_quantity' => 0,
                'entry_date' => trim($this->input->post('entry_date')),
            );
            $this->form_validation->set_rules('assets_name', 'Asset name', 'required');
            $this->form_validation->set_rules('assets_quantity', 'Quantity', 'required');
            $this->form_validation->set_rules('entry_date', 'Date', 'required');

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('assets_info/create_new_assets_info', $this->data);
            } else {
                $this->Assets_info_Model->db->insert('assets_info', $data);
                redirect(base_url('assets_info'));
            }
        } else {
            $this->session->set_flashdata('assets_name_duplicate_error_message', 'Name Already Exists.');
            redirect(base_url('assets_info/create_new_assets_info'));
        }
    }

    public function update_assets_info($id = 0) {  // load update assets information page
        if (get_user_permission('assets_info') === false) {
            redirect(base_url('user_login'));
        }

        $assets_info = $this->Assets_info_Model->get_assets_info($id);

        if (!empty($assets_info)) {
            redirect(base_url('assets_info'));
        }

        $this->data['title'] = "Update Assets Info";
        $this->data['assets_info'] = $assets_info;
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('assets_info/update_assets_info', $this->data);
    }

    public function update() {  // update assets
        if (get_user_permission('assets_info') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = 'Update Assets Info';
        $id = trim($this->input->post('id')); //assets info id
        $assets_name = trim($this->input->post('assets_name'));
        $assets_info = $this->Assets_info_Model->get_assets_info($id);
        $this->data['assets_info'] = $assets_info;
        $assets_quantity = (int) trim($this->input->post('assets_quantity'));
        $assets_info_by_id_for_duplicate_check = $this->Assets_info_Model->get_assets_info_by_id_for_duplicate_check($assets_name, $id);

        $assign_assets_by_assets_info_id = $this->Assign_assets_Model->get_all_assign_assets_by_assets_info_id($id);  //$id = $assets_info_id

        $assign_assets_quantity = 0;
        if ((!empty($assign_assets_by_assets_info_id))) {
            foreach ($assign_assets_by_assets_info_id as $assign_assets) {
                $assign_assets_quantity += (int) $assign_assets->quantity;
            }
        }

        if ($assets_quantity >= $assign_assets_quantity) {
            if ((empty($assets_info_by_id_for_duplicate_check))) {
                $data = array(
                    'id' => $id,
                    'assets_name' => $assets_name,
                    'assets_code' => trim($this->input->post('assets_code')),
                    'assets_quantity' => $assets_quantity,
                    'assigned_assets_quantity' => $assign_assets_quantity,
                    'entry_date' => trim($this->input->post('entry_date')),
                );
                $this->form_validation->set_rules('assets_name', 'Asset name', 'required');
                $this->form_validation->set_rules('assets_quantity', 'Quantity', 'required');
                $this->form_validation->set_rules('entry_date', 'Date', 'required');

                if ($this->form_validation->run() === FALSE) {
                    $this->load->view('header');
                    $this->load->view('navigation');
                    $this->load->view('assets_info/update_assets_info', $this->data);
                } else {
                    $this->db->where('id', $data['id']);
                    $this->Assets_info_Model->db->update('assets_info', $data);
                    redirect(base_url('assets_info'));
                }
            } else {
                $this->session->set_flashdata('assets_name_duplicate_error_message', 'Name Already Exists.');
                redirect(base_url('assets_info/update_assets_info/' . $id));
            }
        } else {
            $this->session->set_flashdata('assets_quantity_error_message', 'Input quantity less than assigned quantity.');
            redirect(base_url('assets_info/update_assets_info/' . $id));
        }
    }

    public function delete($id) {
        if (get_user_permission('assets_info') === false) {
            redirect(base_url('user_login'));
        }

        $assets_info = $this->Assets_info_Model->get_assets_info($id);
        if (!empty($assets_info)) {
            if ((int) $assets_info->assigned_assets_quantity <= 0) {
                $this->Assets_info_Model->delete($id);
                redirect(base_url('assets_info'));
            } else {
                $this->session->set_flashdata('delete_error_message', 'Already assigned.');
                redirect(base_url('assets_info'));
            }
        }
    }

}
