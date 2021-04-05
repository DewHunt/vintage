<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Income_head extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Head_details_Model');
        $this->load->model('Head_details_posting_Model');
        $this->load->model('Daywise_head_posting_Model');
    }

    public function index() {  // load Income Head details
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == true)) {
            $this->data['title'] = "Income Head";
            $this->data['income_head_list'] = $this->Head_details_Model->get_income_head_details();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('accounts/income_head/income_head_details_list', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function create_new_income_head() { // load create new Income Head page
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == true)) {
            $this->data['title'] = "Create Income Head";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('accounts/income_head/create_income_head', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function save_income_head() {  // save Income Head information
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == true)) {
            $this->data['title'] = 'Save Income Head';
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $income_head_name = trim($this->input->post('income_head_name'));
            $debit_credit_both = trim($this->input->post('debit_credit_both'));
            $opening_balance = trim($this->input->post('opening_balance'));
            $balance_type = trim($this->input->post('balance_type'));

            if (empty($balance_type)) {
                $this->session->set_flashdata('balance_type_error_message', 'Please Select Opening Balance Type (Debit or Credit)');
                redirect(base_url('accounts/income_head/create_new_income_head'));
            }
            if (empty($debit_credit_both)) {
                $debit_credit_both = 'cr';
            } else {
                $debit_credit_both = 'both';
            }
            $head_details_head_name = $this->Head_details_Model->get_head_details_head_name($income_head_name);
            if (empty($head_details_head_name)) {
                $data = array(
                    'head_name' => $income_head_name,
                    'head_type' => $debit_credit_both,
                );
                $this->form_validation->set_rules('income_head_name', 'Income Head', 'required');
                $this->form_validation->set_rules('opening_balance', 'Opening Balance', 'required');

                if ($this->form_validation->run() === FALSE) {
                    $this->data['title'] = 'Create Income Head';
                    $this->load->view('header');
                    $this->load->view('navigation');
                    $this->load->view('accounts/income_head/create_new_income_head', $this->data);
                } else {
                    $this->Head_details_Model->db->insert('head_details', $data);
                    $currently_inserted_head_id = $this->db->insert_id();
                    $this->head_details_posting_save($currently_inserted_head_id, $opening_balance, $balance_type);
                    $this->daywise_head_posting_save($currently_inserted_head_id, $opening_balance, $balance_type, $user_id);
                    redirect(base_url('accounts/income_head'));
                }
            } else {
                $this->session->set_flashdata('income_head_name_duplicate_error_message', 'Income Head Already Exists.');
                redirect(base_url('accounts/income_head/create_new_income_head'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function head_details_posting_save($head_id, $opening_balance, $balance_type) {
        if ($balance_type == 'credit') {
            $debit_amount = $opening_balance;
            $credit_amount = 0;
            $total_amount = -$opening_balance;
        } else {
            $debit_amount = 0;
            $credit_amount = $opening_balance;
            $total_amount = $opening_balance;
        }
        $head_details_posting_by_head_id = $this->Head_details_posting_Model->get_head_details_posting_by_head_id($head_id);
        if (empty($head_details_posting_by_head_id)) {
            $head_details_posting_data = array(
                'head_id' => $head_id,
                'total_amount' => $total_amount,
                'debit_amount' => $debit_amount,
                'credit_amount' => $credit_amount,
            );
            $this->Head_details_posting_Model->db->insert('head_details_posting', $head_details_posting_data);
        } else {
            $head_details_posting_data = array(
                'id' => $head_details_posting_by_head_id->id,
                'head_id' => $head_id,
                'total_amount' => $total_amount,
                'debit_amount' => $debit_amount,
                'credit_amount' => $credit_amount,
            );
            $this->db->where('id', $head_details_posting_data['id']);
            $this->Head_details_posting_Model->db->update('head_details_posting', $head_details_posting_data);
        }
    }

    public function daywise_head_posting_save($head_id, $opening_balance, $balance_type, $user_id) {
        if ($balance_type == 'debit') {
            $debit_amount = $opening_balance;
            $credit_amount = 0;
            $closing_balance = $debit_amount;
        } else {
            $debit_amount = 0;
            $credit_amount = $opening_balance;
            //$closing_balance = $credit_amount; // previous ok
            /* Start Edit on 21082017 */
            $closing_balance = -$credit_amount;
            /* End Edit on 21082017 */
        }
        $previous_date = date('Y-m-d', strtotime("-1 days"));
        $daywise_head_posting_by_date_and_head_id = $this->Daywise_head_posting_Model->get_daywise_head_posting_by_date_and_head_id($previous_date, $head_id);
        if (empty($daywise_head_posting_by_date_and_head_id)) {
            $daywise_head_posting_data = array(
                'head_id' => $head_id,
                'posting_date' => date('Y-m-d'),
                'opening_balance' => 0,
                'debit_amount' => $debit_amount,
                'credit_amount' => $credit_amount,
                'closing_balance' => $closing_balance,
                'user_id' => $user_id,
            );
            $this->Daywise_head_posting_Model->db->insert('daywise_head_posting', $daywise_head_posting_data);
        } else {
            $daywise_head_posting_data = array(
                'id' => $daywise_head_posting_by_date_and_head_id->id,
                'head_id' => $daywise_head_posting_by_date_and_head_id->head_id,
                'posting_date' => $daywise_head_posting_by_date_and_head_id->posting_date,
                'opening_balance' => 0,
                'debit_amount' => $debit_amount,
                'credit_amount' => $credit_amount,
                'closing_balance' => $closing_balance,
                'user_id' => $daywise_head_posting_by_date_and_head_id->user_id,
            );
            $this->db->where('id', $daywise_head_posting_data['id']);
            $this->Daywise_head_posting_Model->db->update('daywise_head_posting', $daywise_head_posting_data);
        }
    }

    public function update_income_head($id = 0) {  // load update Income Head information page
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == true)) {
            $income_head = $this->Head_details_Model->get_head_details($id);
            if (!empty($income_head)) {
                $this->data['title'] = "Update Income Head";
                $this->data['income_head'] = $income_head;
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('accounts/income_head/update_income_head', $this->data);
            } else {
                redirect(base_url('accounts/income_head'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update() {  // update Income Head
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == true)) {
            $this->data['title'] = 'Update income Head';
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $id = $this->input->post('id');
            $income_head_name = trim($this->input->post('income_head_name'));
            $debit_credit_both = trim($this->input->post('debit_credit_both'));
            //$opening_balance = trim($this->input->post('opening_balance'));
            //$balance_type = trim($this->input->post('balance_type'));

            /* if (empty($balance_type)) {
              $this->session->set_flashdata('balance_type_error_message', 'Please Select Opening Balance Type (Debit or Credit)');
              redirect('accounts/income_head/update_income_head/' . $id);
              } */

            if (empty($debit_credit_both)) {
                $debit_credit_both = 'cr';
            } else {
                $debit_credit_both = 'both';
            }
            $income_head = $this->Head_details_Model->get_head_details($id);
            $this->data['income_head'] = $income_head;
            $head_details_by_head_details_id_for_duplicate_check = $this->Head_details_Model->get_head_details_by_head_details_id_for_duplicate_check($income_head_name, $id);
            if ((empty($head_details_by_head_details_id_for_duplicate_check))) {
                $data = array(
                    'id' => $id,
                    'head_name' => $income_head_name,
                    'head_type' => $debit_credit_both,
                );
                $this->form_validation->set_rules('income_head_name', 'Income Head', 'required');
                /* $this->form_validation->set_rules('opening_balance', 'Opening Balance', 'required'); */

                if ($this->form_validation->run() === FALSE) {
                    $this->load->view('header');
                    $this->load->view('navigation');
                    $this->load->view('accounts/income_head/update_income_head', $this->data);
                } else {
                    $this->db->where('id', $data['id']);
                    $this->Head_details_Model->db->update('head_details', $data);
                    //$this->head_details_posting_save($data['id'], $opening_balance, $balance_type);
                    //$this->daywise_head_posting_save($data['id'], $opening_balance, $balance_type, $user_id);
                    redirect(base_url('accounts/income_head'));
                }
            } else {
                $this->session->set_flashdata('income_head_name_duplicate_error_message', 'Income Head Already Exists.');
                $income_head_name_duplicate_error_message = $this->session->flashdata('income_head_name_duplicate_error_message');
                $this->data['income_head_name_duplicate_error_message'] = $income_head_name_duplicate_error_message;
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('accounts/income_head/update_income_head', $this->data);
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function delete($id) {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == true)) {
            $this->Head_details_Model->delete($id);
            redirect(base_url('accounts/income_head'));
        } else {
            redirect(base_url('user_login'));
        }
    }

}
