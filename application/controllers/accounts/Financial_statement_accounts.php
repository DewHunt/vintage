<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Financial_statement_accounts extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Head_details_Model');
        $this->load->model('Financial_statement_accounts_assign_Model');
        $this->load->model('User_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['title'] = "Financial Statement Accounts";
            $this->data['head_details_list'] = $this->Head_details_Model->get_head_details();
            $this->data['financial_statement_accounts_list'] = $this->get_financial_statement_accounts_list();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('accounts/financial_statement_accounts/financial_statement_accounts', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function financial_statement_accounts_name_show() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $financial_statement_accounts_id = trim($this->input->post('financial_statement_accounts_id'));
            if (empty($financial_statement_accounts_id)) {
                echo '<div class="error-message text-align-center">Please Select Financial Statement Accounts Name</div>';
            } else {
                $this->data['title'] = "Financial Statement Accounts Name";
//                $this->data['head_details_list'] = $this->Head_details_Model->get_head_details();
                $this->data['head_details_list_by_head_type_dr'] = $this->Financial_statement_accounts_assign_Model->get_financial_statement_accounts_assign_by_head_type_and_id($head_type = 'dr', $financial_statement_accounts_id);
                $this->data['head_details_list_by_head_type_cr'] = $this->Financial_statement_accounts_assign_Model->get_financial_statement_accounts_assign_by_head_type_and_id($head_type = 'cr', $financial_statement_accounts_id);
                $this->data['head_details_list_by_head_type_both'] = $this->Financial_statement_accounts_assign_Model->get_financial_statement_accounts_assign_by_head_type_and_id($head_type = 'both', $financial_statement_accounts_id);
                $this->data['financial_statement_accounts_list'] = $this->get_financial_statement_accounts_list();
                $this->data['financial_statement_accounts_id'] = $financial_statement_accounts_id;
                $this->load->view('accounts/financial_statement_accounts/financial_statement_accounts_name_section', $this->data);
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function save_financial_statement_accounts_assign() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $type = '';
            $financial_statement_accounts_id = trim($this->input->post('financial_statement_accounts_id'));
            $head_id_list = $this->input->post('head_id_list');
            if (!empty($financial_statement_accounts_id) && (int) $financial_statement_accounts_id > 0) {
                $this->Financial_statement_accounts_assign_Model->delete_all_financial_statement_accounts_assign_by_financial_statement_accounts_id($financial_statement_accounts_id);
                if (!empty($head_id_list)) {
                    foreach ($head_id_list as $head_id) {
                        if (trim($this->input->post('dr_' . $head_id))) {
                            $type = trim($this->input->post('dr_' . $head_id));
                        } else {
                            $type = trim($this->input->post('cr_' . $head_id));
                        }
                        $financial_statement_accounts_assign_data = array(
                            'head_id' => $head_id,
                            'financial_statement_accounts_type' => $type,
                            'financial_statement_accounts_id' => $financial_statement_accounts_id,
                        );
                        $this->Financial_statement_accounts_assign_Model->db->insert('financial_statement_accounts_assign', $financial_statement_accounts_assign_data);
                    }
                }
                $this->session->set_flashdata('financial_statement_accounts_save_success_message', 'Information has been saved successfully.');
            } else {
                $this->session->set_flashdata('financial_statement_accounts_save_error_message', 'Faild to save information.');
            }
            redirect(base_url('accounts/financial_statement_accounts'));
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_financial_statement_accounts_list() {
        $query_result = $this->db->query("SELECT * FROM financial_statement_accounts");
        return $query_result->result();
    }

}
