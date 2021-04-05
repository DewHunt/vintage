<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Remove_head extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Head_details_Model');
        $this->load->model('Remove_head_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['title'] = "Remove Head";
//            $this->data['head_details_list'] = $this->Head_details_Model->get_head_details();
            $this->data['remove_head_list'] = $this->Remove_head_Model->get_remove_head();
            $this->data['head_details_list_by_head_type_dr'] = $this->Head_details_Model->get_head_details_by_head_type($head_type = 'dr');
            $this->data['head_details_list_by_head_type_cr'] = $this->Head_details_Model->get_head_details_by_head_type($head_type = 'cr');
            $this->data['head_details_list_by_head_type_both'] = $this->Head_details_Model->get_head_details_by_head_type($head_type = 'both');
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('accounts/remove_head/remove_head', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function remove_head_save() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $user_info = $this->session->userdata('user_session');
            $user_type = $user_info['user_type'];
                $head_id_list = $this->input->post('head_id_list');
                if (!empty($head_id_list)) {
                    $this->update_remove_head($head_id_list);
                    $this->session->set_flashdata('remove_head_save_success_message', 'Information has been saved successfully.');
                }
                redirect(base_url('accounts/remove_head'));
        } else {
            redirect(base_url('user_login'));
        }
    }

    private function update_remove_head($head_id_list) {
        $remove_head_list = $this->Remove_head_Model->get_remove_head();
        //for insert new
        $flag = FALSE;
        foreach ($head_id_list as $head_id) {
            $flag = FALSE;
            foreach ($remove_head_list as $remove_head) {
                if (intval($head_id) == intval($remove_head->head_id)) {
                    $flag = TRUE;
                }
            }
            if (!$flag) {
                $remove_head_data = array(
                    'head_id' => $head_id,
                );
                $this->Remove_head_Model->db->insert('remove_head', $remove_head_data);
            }
        }
        // for remove
        $flag = FALSE;
        foreach ($remove_head_list as $remove_head) {
            $flag = FALSE;
            foreach ($head_id_list as $head_id) {
                if (intval($head_id) == intval($remove_head->head_id)) {
                    $flag = TRUE;
                }
            }
            if (!$flag) {
                $this->Remove_head_Model->delete($remove_head->id);
            }
        }
    }

}
