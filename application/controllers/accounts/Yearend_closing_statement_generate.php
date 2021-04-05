<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Yearend_closing_statement_generate extends CI_Controller {

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
        $this->load->model('Financial_statement_accounts_assign_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['title'] = "Yearend Closing Statement";
            $this->data['head_details_list'] = $this->Head_details_Model->get_head_details();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('accounts/yearend_closing_statement_generate/yearend_closing_statement_generate', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    private function profit_and_loss_appropriation_ac_head_id() {
        return $arr = 114;
    }

    private function get_first_or_last_date($status) {
//        $date = NULL;
        $current_year = get_current_year();
//        if ($status == 'first') {
//            $year = strtotime($current_year);
//            $next_year = strtotime('+ 1 year', $year);
//            $date = date('Y', $next_year) . '-01-01';
//        } elseif ($status == 'last') {
//            $date = $current_year . '-01-01';
//        }
        $date = $current_year . '-01-01';
        return $date;
    }

    public function statement_generate() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == true)) {

            $trading_and_profit_loss_assign_head_list = $this->Financial_statement_accounts_assign_Model->get_trading_and_profit_loss_assign_head_list();

            $this->data['title'] = 'Yearend Closing Statement Generate';
            $result = $this->update_for_profit_and_loss_appropriation_ac();
            if ($result == TRUE) {
                $result_1 = $this->update_trading_proft_loss_ac_all_head_balance_zero();
                if ($result_1 == TRUE) {
                    $this->session->set_flashdata('yearend_closing_statement_generate_message', 'Information has been Updated Successfully.');
                } else {
                    $this->session->set_flashdata('yearend_closing_statement_generate_message', 'Error Occured.');
                }
            } else {
                $this->session->set_flashdata('yearend_closing_statement_generate_message', 'Error Occured.');
            }
            redirect(base_url('accounts/yearend_closing_statement_generate'));
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update_trading_proft_loss_ac_all_head_balance_zero() {

        $trading_and_profit_loss_assign_head_list = $this->Financial_statement_accounts_assign_Model->get_trading_and_profit_loss_assign_head_list();
        $result = FALSE;
        if (!empty($trading_and_profit_loss_assign_head_list)) {
            foreach ($trading_and_profit_loss_assign_head_list as $trading_and_profit_loss) {
                $user_info = $this->session->userdata('user_session');
                $user_id = $user_info['user_id']; // session user id
                $first_date_of_the_next_year = $this->get_first_or_last_date($status = 'first');

                $head_id = (int) $trading_and_profit_loss->head_id;
                $amount = 0;
                $balance_type = $trading_and_profit_loss->financial_statement_accounts_type == 'dr' ? 'debit' : 'credit';
                $head_details_posting_by_head_id = $this->Head_details_posting_Model->get_head_details_posting_by_head_id($head_id);
                $previous_head_details_posting_balance = 0;
                $this->daywise_head_posting_save($head_id, $amount, $balance_type, $user_id, $previous_head_details_posting_balance, $first_date_of_the_next_year);
                $this->update_head_posting_details_by_zero($head_id);
                $currently_inserted_voucher_posting_details_id = $this->voucher_posting_details_save($head_id, $amount, $balance_type, $user_id, $first_date_of_the_next_year);
                $this->voucher_details_save($head_id, $currently_inserted_voucher_posting_details_id, $amount, $balance_type, $user_id, $previous_head_details_posting_balance);
            }
            $result = TRUE;
        }
        return $result;
    }

    public function update_for_profit_and_loss_appropriation_ac() {
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id']; // session user id
        $last_date_of_the_year = $this->get_first_or_last_date($status = 'first');
        $amount_for_profit_and_loss_appropriation_ac = 0;
        $start_date = get_current_year() .'-01-01';
        $end_date = get_current_year().'-12-31';
        $account_statement_report = $this->Financial_statement_accounts_assign_Model->get_statement($start_date, $end_date, $financial_statement_accounts_id = 3);
        $result = FALSE;
        if (!empty($account_statement_report)) {
            $previous_account_statement_profit = !empty($account_statement_report[0]['previous_profit']) ? $account_statement_report[0]['previous_profit'] : 0;
            $previous_account_statement_loss = !empty($account_statement_report[0]['previous_loss']) ? $account_statement_report[0]['previous_loss'] : 0;
            $profit_and_loss_appropriation_ac_head_id = $this->profit_and_loss_appropriation_ac_head_id();
            $arr = array();
            if ((double) $previous_account_statement_profit > 0) { // for profit
                $arr = array(
                    'amount' => $previous_account_statement_profit,
                    'balance_type' => 'credit',
                );
            } else { // for loss
                $arr = array(
                    'amount' => $previous_account_statement_loss,
                    'balance_type' => 'debit',
                );
            }
            $head_id = (int) $profit_and_loss_appropriation_ac_head_id;
            $amount = $arr['amount'];
            $balance_type = $arr['balance_type'];
            $head_details_posting_by_head_id = $this->Head_details_posting_Model->get_head_details_posting_by_head_id($head_id);
            $previous_head_details_posting_balance = (double) $head_details_posting_by_head_id->total_amount;
            $this->daywise_head_posting_save($head_id, $amount, $balance_type, $user_id, $previous_head_details_posting_balance, $last_date_of_the_year);
            $this->head_details_posting_save($head_id, $amount, $balance_type);
            $currently_inserted_voucher_posting_details_id = $this->voucher_posting_details_save($head_id, $amount, $balance_type, $user_id, $last_date_of_the_year);
            $this->voucher_details_save($head_id, $currently_inserted_voucher_posting_details_id, $amount, $balance_type, $user_id, $previous_head_details_posting_balance);
            $result = TRUE;
        }
        return $result;
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

    public function daywise_head_posting_save($head_id, $amount, $balance_type, $user_id, $previous_head_details_posting_balance, $posting_date) {
        $daywise_head_posting_by_current_date_and_head_id = $this->Daywise_head_posting_Model->get_daywise_head_posting_by_date_and_head_id($posting_date, $head_id);
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
                'posting_date' => $posting_date,
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
            'closing_balance' => (!empty($head_details_posting_information->total_amount)? $head_details_posting_information->total_amount:0 ),
            'voucher_posting_details_id' => $currently_inserted_voucher_posting_details_id,
        );
        $this->Voucher_details_Model->db->insert('voucher_details', $voucher_details_data);
    }

    public function voucher_posting_details_save($head_id, $amount, $balance_type, $user_id, $posting_date) {
        $voucher_number = $this->Voucher_posting_details_Model->get_voucher_number();
        if ($balance_type == 'debit') {
            $debit_amount = $amount;
            $credit_amount = 0;
        } else {
            $debit_amount = 0;
            $credit_amount = $amount;
        }
        $voucher_posting_details_data = array(
            'posting_date' => $posting_date,
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

    public function update_head_posting_details_by_zero($head_id) {
        $head_details_posting_by_head_id = $this->Head_details_posting_Model->get_head_details_posting_by_head_id($head_id);
        if (!empty($head_details_posting_by_head_id)) {
            $head_details_posting_data = array(
                'id' => $head_details_posting_by_head_id->id,
                'head_id' => $head_id,
                'total_amount' => 0,
                'debit_amount' => 0,
                'credit_amount' => 0,
            );
            $this->db->where('id', $head_details_posting_data['id']);
            $this->Head_details_posting_Model->db->update('head_details_posting', $head_details_posting_data);
        }
    }

}
