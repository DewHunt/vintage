<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Yearend_head_assign extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Head_details_Model');
        $this->load->model('Yearend_head_assign_Model');
        $this->load->model('User_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $user_info = $this->session->userdata('user_session');
            $user_type = $user_info['user_type'];
            if (strtolower($user_type) == 'admin') {
                $this->data['title'] = "Yearend Head Assign";
                $this->data['head_details_list'] = $this->Head_details_Model->get_head_details();
                $this->load->view('header');
                $this->load->view('navigation');
                $this->data['yearend_head_assign_table_list'] = $this->Yearend_head_assign_Model->get_yearend_head_assign();
                $this->load->view('settings/yearend_head_assign/yearend_head_assign', $this->data);
            } else {
                redirect(base_url('user_login'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function save_yearend_head_assign() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $user_info = $this->session->userdata('user_session');
                $user_type = $user_info['user_type'];
                if (strtolower($user_type) == 'admin') {
                    $opening_head_id = trim($this->input->post('opening_head_id'));
                    $closing_head_id = trim($this->input->post('closing_head_id'));
                    if (empty($opening_head_id) || empty($closing_head_id)) {
                        echo '<div class="error-message text-align-center">Please Select Opening and Closing Head</div>';
                    } else {
                        if ((int) $opening_head_id == (int) $closing_head_id) {
                            echo '<div class="error-message text-align-center">Please Select Correct Opening and Closing Head</div>';
                        } else {
                            $is_exists_yearend_head_assign = $this->Yearend_head_assign_Model->is_exists_yearend_head_assign($opening_head_id, $closing_head_id);
                            if ($is_exists_yearend_head_assign) { // true
                                echo '<div class="error-message text-align-center">Already Assigned.</div>';
                            } else {
                                echo '<div class="success-message text-align-center">Successfully Assigned.</div>';
                                $yearend_head_assign_data = array(
                                    'opening_head_id' => $opening_head_id,
                                    'closing_head_id' => $closing_head_id,
                                );
                                $this->Yearend_head_assign_Model->db->insert('yearend_head_assign', $yearend_head_assign_data);
                            }
                        }
                    }
                    $this->data['yearend_head_assign_table_list'] = $this->Yearend_head_assign_Model->get_yearend_head_assign();
                    $this->load->view('settings/yearend_head_assign/yearend_head_assign_table_section', $this->data);
                } else {
                    redirect(base_url('user_login'));
                }
            } else {
                redirect(base_url('user_login'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function delete_yearend_head_assign() { //delete product info from table
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $user_info = $this->session->userdata('user_session');
                $user_type = $user_info['user_type'];
                if (strtolower($user_type) == 'admin') {
                    $yearend_head_assign_id = trim($this->input->post('yearend_head_assign_id'));
                    if (!empty($yearend_head_assign_id) && (int) $yearend_head_assign_id > 0) {
                        $this->Yearend_head_assign_Model->delete($yearend_head_assign_id);
                    }
                    $this->data['yearend_head_assign_table_list'] = $this->Yearend_head_assign_Model->get_yearend_head_assign();
                    $this->load->view('settings/yearend_head_assign/yearend_head_assign_table_section', $this->data);
                } else {
                    redirect(base_url('user_login'));
                }
            } else {
                redirect(base_url('user_login'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

}
