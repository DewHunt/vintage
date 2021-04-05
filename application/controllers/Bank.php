<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bank extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Bank_Model');
        $this->load->model('User_Model');
    }

    public function index() {  // load bank details
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $this->data['title'] = "Bank";
            $this->data['bank_list'] = $this->Bank_Model->get_bank();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('bank/bank_details_list', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function create_new_bank() { // load create new bank page
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $this->data['title'] = "Bank";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('bank/create_new_bank');
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function save_bank() {  // save bank information
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $this->data['title'] = 'Create New Bank';
            $bank_name = trim($this->input->post('bank_name'));
            $branch_name = trim($this->input->post('branch_name'));
            $branch_location = trim($this->input->post('branch_location'));
            $is_bank_branch_name_exists = $this->Bank_Model->is_bank_branch_name_exists($bank_name, $branch_name);
            if (empty($is_bank_branch_name_exists)) {
                $data = array(
                    'bank_name' => $bank_name,
                    'branch_name' => $branch_name,
                    'branch_location' => $branch_location,
                );
                $this->form_validation->set_rules('bank_name', 'Bank name', 'required');
                $this->form_validation->set_rules('branch_name', 'Branch name', 'required');
                $this->form_validation->set_rules('branch_location', 'Branch Location', 'required');

                if ($this->form_validation->run() === FALSE) {
                    $this->load->view('header');
                    $this->load->view('navigation');
                    $this->load->view('bank/create_new_bank', $this->data);
                } else {
                    $this->Bank_Model->db->insert('bank_info', $data);
                    redirect(base_url('bank'));
                }
            } else {
                $this->session->set_flashdata('name_exists_message', 'Branch Already Exists');
                redirect('bank/create_new_bank');
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update_bank($id = 0) {  // load update bank information page
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $bank = $this->Bank_Model->get_bank($id);
            if (!empty($bank)) {
                $this->data['title'] = "Update Bank";
                $this->data['bank'] = $bank;
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('bank/update_bank', $this->data);
            } else {
                redirect(base_url('bank'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update() {  // update bank
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $this->data['title'] = 'Update Bank';
            $id = trim($this->input->post('id'));
            $bank_name = trim($this->input->post('bank_name'));
            $branch_name = trim($this->input->post('branch_name'));
            $branch_location = trim($this->input->post('branch_location'));
            $bank = $this->Bank_Model->get_bank($id);
            $this->data['bank'] = $bank;
            $is_bank_branch_name_exists_check_for_update = $this->Bank_Model->is_bank_branch_name_exists_check_for_update($bank_name, $branch_name, $id);
            if (!empty($is_bank_branch_name_exists_check_for_update)) {
                $this->session->set_flashdata('name_exists_message', 'Branch Already Exists.');
                redirect(base_url('bank/update_bank/' . $id));
            } else {
                $data = array(
                    'id' => $id,
                    'bank_name' => $bank_name,
                    'branch_name' => $branch_name,
                    'branch_location' => $branch_location,
                );
                $this->form_validation->set_rules('bank_name', 'Bank name', 'required');
                $this->form_validation->set_rules('branch_name', 'Branch name', 'required');
                $this->form_validation->set_rules('branch_location', 'Branch Location', 'required');

                if ($this->form_validation->run() === FALSE) {
                    $this->load->view('header');
                    $this->load->view('navigation');
                    $this->load->view('bank/update_bank', $this->data);
                } else {
                    $this->db->where('id', $data['id']);
                    $this->Bank_Model->db->update('bank_info', $data);
                    redirect(base_url('bank'));
                }
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function delete($id) {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $this->Bank_Model->delete($id);
            redirect(base_url('bank'));
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function bank_exists() {
        /* $result = $this->db->query("SELECT * FROM bank_info WHERE bank_name = '$bank_name' ")->row();
          if(empty($result)){
          return TRUE;
          }else{
          return FALSE;
          } */
        if ($this->input->is_ajax_request()) {
            $bank_name = trim($this->input->post('bank_name'));
            $is_bank_name_exists = $this->Bank_Model->is_bank_name_exists($bank_name);
            if (empty($is_bank_name_exists)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

}
