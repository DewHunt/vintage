<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Update_closing_balance extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Head_details_Model');
        $this->load->model('Head_details_posting_Model');
        $this->load->model('Daywise_head_posting_Model');
        $this->load->model('Voucher_details_Model');
        $this->load->model('Voucher_posting_details_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['title'] = "Update Closing Balance";
            $this->data['head_details_list'] = $this->Head_details_Model->get_head_details();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('accounts/update_closing_balance/update_closing_balance', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function details_add_into_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $update_closing_balance_data = array();
                $user_info = $this->session->userdata('user_session');
                $user_type = $user_info['user_type'];
                $head_id = trim($this->input->post('head_id'));
                $amount = trim($this->input->post('amount'));
                $balance_type = trim($this->input->post('balance_type'));
                if (empty($head_id) || empty($amount) || empty($balance_type)) {
                    echo '<div class="error-message text-align-center">Please Select Head, Amount and Type</div>';
                } else {
                    $head_details = $this->Head_details_Model->get_head_details($head_id);
                    $update_closing_balance_session = $this->session->userdata('update_closing_balance_session');
                    $table_array = $update_closing_balance_session;
                    $array_data = array(
                        'array_id' => time(),
                        'head_id' => $head_id,
                        'head_name' => $head_details->head_name,
                        'amount' => $amount,
                        'balance_type' => $balance_type,
                    );
                    if (!empty($table_array)) {
                        array_push($table_array, $array_data);
                    } else {
                        $table_array = array();
                        array_push($table_array, $array_data);
                    }
                    $this->session->set_userdata('update_closing_balance_session', $table_array);
                }
                $this->data['Error_text'] = 'Add Data Into Table';
                $this->load->view('accounts/update_closing_balance/update_closing_balance_table', $this->data);
            } else {
                redirect(base_url('user_login'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update_closing_balance_clear_table_data() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $this->session->unset_userdata('update_closing_balance_session');
                $this->data['Error_text'] = 'Delete Data From Table';
                $this->load->view('accounts/update_closing_balance/update_closing_balance_table', $this->data);
            } else {
                redirect(base_url('user_login'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == true)) {
            $this->data['title'] = 'Update Closing Balance';
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $update_closing_balance_session = $this->session->userdata('update_closing_balance_session');
            if (!empty($update_closing_balance_session)) {
                foreach ($update_closing_balance_session as $update_closing_balance) {
                    $head_id = $update_closing_balance['head_id'];
                    $amount = $update_closing_balance['amount'];
                    $balance_type = $update_closing_balance['balance_type'];
                    $head_details = $this->Head_details_Model->get_head_details($head_id);
                    $head_details_posting_by_head_id = $this->Head_details_posting_Model->get_head_details_posting_by_head_id($head_id);
                    $previous_head_details_posting_balance = (double) $head_details_posting_by_head_id->total_amount;
                    $this->daywise_head_posting_save($head_id, $amount, $balance_type, $user_id, $previous_head_details_posting_balance);
                    $this->head_details_posting_save($head_id, $amount, $balance_type);
                    $currently_inserted_voucher_posting_details_id = $this->voucher_posting_details_save($head_id, $amount, $balance_type, $user_id);
                    $this->voucher_details_save($head_id, $currently_inserted_voucher_posting_details_id, $amount, $balance_type, $user_id, $previous_head_details_posting_balance);
                }
                $this->session->unset_userdata('update_closing_balance_session');
                $message = "Information has been Updated successfully.";
//                    $this->output
//                            ->set_content_type('application/json')
//                            ->set_output(json_encode(array(
//                                'success_message' => $message,
//                    )));
//                redirect(base_url('accounts/update_closing_balance'));
            } else {
                
            }
//            redirect(base_url('accounts/update_closing_balance'));
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function head_details_posting_save($head_id, $amount, $balance_type) {
        $head_details_information = $this->Head_details_Model->get_head_details($head_id);

        $head_details_posting_by_head_id = $this->Head_details_posting_Model->get_head_details_posting_by_head_id($head_id);

        if ($balance_type == 'debit') {
            $debit_amount = 0;
            $credit_amount = (double) ($amount);
            $total_amount = ((double) $head_details_posting_by_head_id->total_amount) + $credit_amount;
        } elseif ($balance_type == 'credit') {
            $debit_amount = (double) ($amount);
            $credit_amount = 0;
            $total_amount = ((double) $head_details_posting_by_head_id->total_amount) - $debit_amount;
        }
        if (!empty($head_details_posting_by_head_id)) {
            $head_details_posting_data = array(
                'id' => $head_details_posting_by_head_id->id,
                'head_id' => $head_details_posting_by_head_id->head_id,
                'total_amount' => $total_amount,
                'debit_amount' => ((double) $head_details_posting_by_head_id->debit_amount) + $debit_amount,
                'credit_amount' => ((double) $head_details_posting_by_head_id->credit_amount) + $credit_amount,
            );
            $this->db->where('id', $head_details_posting_data['id']);
            $this->Head_details_posting_Model->db->update('head_details_posting', $head_details_posting_data);
        } else {
            $head_details_posting_data = array(
                'head_id' => $head_id,
                'total_amount' => $total_amount,
                'debit_amount' => $debit_amount,
                'credit_amount' => $credit_amount,
            );
            $this->Head_details_posting_Model->db->insert('head_details_posting', $head_details_posting_data);
        }
    }

    public function daywise_head_posting_save($head_id, $amount, $balance_type, $user_id, $previous_head_details_posting_balance) {
        $current_date = get_current_year() . '-01-01';
         //     $current_date = '2019' . '-12-31';
        $daywise_head_posting_by_current_date_and_head_id = $this->Daywise_head_posting_Model->get_daywise_head_posting_by_date_and_head_id($current_date, $head_id);
        if (empty($daywise_head_posting_by_current_date_and_head_id)) {
            if ($balance_type == 'debit') {
                $opening_balance = (double) $previous_head_details_posting_balance;
                $debit_amount = (double) ($amount);
                $credit_amount = 0;
                $closing_balance = $opening_balance + $debit_amount;
            } elseif ($balance_type == 'credit') {
                $opening_balance = (double) $previous_head_details_posting_balance;
                $debit_amount = 0;
                $credit_amount = (double) ($amount);
                $closing_balance = $opening_balance - $credit_amount;
            }
            $daywise_head_posting_data = array(
                'head_id' => $head_id,
                'posting_date' => $current_date,
                'opening_balance' => $opening_balance,
                'debit_amount' => $debit_amount,
                'credit_amount' => $credit_amount,
                'closing_balance' => $closing_balance,
                'user_id' => $user_id,
            );
            $this->Daywise_head_posting_Model->db->insert('daywise_head_posting', $daywise_head_posting_data);
        } else {
            if ($balance_type == 'debit') {
                $opening_balance = $daywise_head_posting_by_current_date_and_head_id->opening_balance; //5000
                $debit_amount = (double) $daywise_head_posting_by_current_date_and_head_id->debit_amount + (double) ($amount); //500
                $credit_amount = ($daywise_head_posting_by_current_date_and_head_id->credit_amount); //0
                $closing_balance = ($daywise_head_posting_by_current_date_and_head_id->closing_balance) + (double) ($amount); //4500
            } elseif ($balance_type == 'credit') {
                $opening_balance = $daywise_head_posting_by_current_date_and_head_id->opening_balance;
                $debit_amount = $daywise_head_posting_by_current_date_and_head_id->debit_amount;
                $credit_amount = $daywise_head_posting_by_current_date_and_head_id->credit_amount + (double) ($amount);
                $closing_balance = ($daywise_head_posting_by_current_date_and_head_id->closing_balance) - (double) ($amount);
            }
            $daywise_head_posting_data = array(
                'id' => $daywise_head_posting_by_current_date_and_head_id->id,
                'head_id' => $daywise_head_posting_by_current_date_and_head_id->head_id,
                'posting_date' => $daywise_head_posting_by_current_date_and_head_id->posting_date,
                'opening_balance' => $opening_balance,
                'debit_amount' => $debit_amount,
                'credit_amount' => $credit_amount,
                'closing_balance' => $closing_balance,
                'user_id' => $daywise_head_posting_by_current_date_and_head_id->user_id,
            );
            $this->db->where('id', $daywise_head_posting_data['id']);
            $this->Daywise_head_posting_Model->db->update('daywise_head_posting', $daywise_head_posting_data);
        }
    }

    public function voucher_details_save($head_id, $currently_inserted_voucher_posting_details_id, $amount, $balance_type, $user_id, $previous_head_details_posting_balance) {  //voucher_details_save
        if ($balance_type == 'debit') {
            $income_head_id = 0;
            $expense_head_id = (int) $head_id;
            $debit_amount = $amount;
            $credit_amount = 0;
        } else {
            $income_head_id = (int) $head_id;
            $expense_head_id = 0;
            $debit_amount = 0;
            $credit_amount = $amount;
        }
        if (!empty($income_head_id) && $income_head_id > 0) {
            $head_id = $income_head_id;
        } else {
            $head_id = $expense_head_id;
        }
        $head_details_posting_information = $this->Head_details_posting_Model->get_head_details_posting_by_head_id($head_id);

        $voucher_details_data = array(
            'income_head_id' => $income_head_id,
            'expense_head_id' => $expense_head_id,
            'amount' => $amount,
            'invoice_number' => '',
            'mr_number' => '',
            'client_id' => 0,
            'employee_id' => 0,
            'month' => '',
            'year' => '',
            'narration' => '',
            'debit_amount' => $debit_amount,
            'credit_amount' => $credit_amount,
            'opening_balance' => ($previous_head_details_posting_balance),
            'closing_balance' => ($head_details_posting_information->total_amount),
            'voucher_posting_details_id' => $currently_inserted_voucher_posting_details_id,
        );
        $this->Voucher_details_Model->db->insert('voucher_details', $voucher_details_data);
    }

    public function voucher_posting_details_save($head_id, $amount, $balance_type, $user_id) {
        $current_date = get_current_year() . '-01-01';
      // $current_date = '2019' . '-12-31';
        $voucher_number = $this->get_voucher_number();
        if ($balance_type == 'debit') {
            $debit_amount = $amount;
            $credit_amount = 0;
        } else {
            $debit_amount = 0;
            $credit_amount = $amount;
        }
        $voucher_posting_details_data = array(
            'posting_date' => $current_date,
            'voucher_number' => $voucher_number,
            'total_debit_amount' => $debit_amount,
            'total_credit_amount' => $credit_amount,
            'common_narration' => '',
            'user_id' => $user_id,
        );
        $this->Voucher_posting_details_Model->db->insert('voucher_posting_details', $voucher_posting_details_data);
        $currently_inserted_voucher_posting_details_id = $this->db->insert_id();
        return $currently_inserted_voucher_posting_details_id;
    }

    private function get_voucher_number() {
        $last_voucher_number = $this->Voucher_posting_details_Model->get_last_voucher_number();
        if (!empty($last_voucher_number->voucher_number)) {
            $voucher_number = $last_voucher_number->voucher_number + 1;
        } else {
            $voucher_number = 1000;
        }
        return $voucher_number;
    }

}
