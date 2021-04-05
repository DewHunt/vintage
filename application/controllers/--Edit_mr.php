<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_mr extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Bank_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Client_Model');
        $this->load->model('Payment_Model');
        $this->load->model('Edit_mr_Model');
        $this->load->model('Client_transaction_details_Model');
        $this->load->model('Client_sales_details_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('edit_mr_access')) == TRUE)) {
            $this->data['title'] = "Company";
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('edit_mr/edit_mr', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function edit_mr_information_show() { //show return product in table
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('edit_mr_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $mr_number = trim($this->input->post('mr_number'));
                $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();

                if (empty($mr_number)) {
                    echo '<div class="error-message text-align-center">Please Enter MR Number.</div>';
                } else {
                    if (!empty($mr_number)) { //$mr_number                        
                        $payment_information = $this->Payment_Model->get_payment_by_mr_number($mr_number);
                    }
                    if (empty($payment_information)) {
                        echo '<div class="error-message text-align-center">No information found with this MR Number.</div>';
                    } else {
                        $this->data['client'] = $this->Client_Model->get_client($payment_information->client_id);
                        $this->data['bank'] = $this->Bank_Model->get_bank($payment_information->bank_id);
                        $this->data['payment_information'] = $payment_information;
                        $this->load->view('edit_mr/edit_mr_information_show', $this->data);
                    }
                }
            } else {
                redirect(base_url('edit_mr'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function save_edit_mr_information() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('edit_mr_access')) == TRUE)) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $id = trim($this->input->post('id'));
            $amount = trim($this->input->post('amount_received'));
            $payment_information = $this->Payment_Model->get_payment($id);
            $client_id = $payment_information->client_id;
            $client_information = $this->Client_Model->get_client($client_id);
            $amount_received = $payment_information->amount_received;
            $current_date_time = get_current_date_and_time();
            $data = array(
                'payment_id' => $id,
                'mr_number' => $payment_information->receipt_mr_no,
                'client_id' => $client_id,
                'previous_amount' => $amount_received,
                'resize_amount' => $amount,
                'edit_mr_date' => $current_date_time,
                'user_id' => $user_id,
            );
            if (empty($id) && empty($amount)) {
                $this->session->set_flashdata('save_error_message', 'Please Input Amount.');
                redirect(base_url('edit_mr'));
            } else {
                if ((double) $amount_received == (double) $amount) {
                    $this->session->set_flashdata('save_error_message', 'Please Input Correct Amount.');
                    redirect(base_url('edit_mr'));
                } else {
                    $this->Edit_mr_Model->db->insert('edit_mr', $data);
                    $this->update_payment_amount_after_edit_mr($payment_information, $amount);
                    $this->update_client_balance_information($client_information, $payment_information, $amount);
                    $this->client_transaction_details_save($client_information, $payment_information, $amount, $user_id);
                    $this->client_sales_details_save($client_information, $payment_information, $amount);
                    $this->session->set_flashdata('save_success_message', 'Information has been saved successfully.');
                    redirect(base_url('edit_mr'));
                }
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update_payment_amount_after_edit_mr($payment_information, $amount) {
        $payment_information_data = array(
            'id' => $payment_information->id,
            'amount_received' => $amount,
        );
        $this->db->where('id', $payment_information_data['id']);
        $this->Payment_Model->db->update('payment', $payment_information_data);
    }

    public function update_client_balance_information($client_information, $payment_information, $amount) {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('edit_mr_access')) == TRUE)) {
            $client_id = (int) ($client_information->id);
            $total_credit_balance = 0;
            $total_advance_balance = 0;
            $total_sale = 0;
            $total_payment = 0;
            $status = '';
            $resize_amount = 0;
            $previous_amount = (double) $payment_information->amount_received;
            $current_amount = (double) $amount;
            if ($current_amount > $previous_amount) {
                $status = 'increase';
                $resize_amount = $current_amount - $previous_amount;
            } else {
                $status = 'reduce';
                $resize_amount = $previous_amount - $current_amount;
            }
            $client_credit_balance = (double) $client_information->credit_balance;
            $client_advance_balance = (double) $client_information->advance_balance;
            if ($client_credit_balance > 0) {
                if (strtolower($status) == 'increase') {
                    $result = $client_credit_balance - $resize_amount;
                    if ($result < 0) {
                        $total_credit_balance = 0;
                        $total_advance_balance = abs($result);
                    } else {
                        $total_credit_balance = $result;
                        $total_advance_balance = 0;
                    }
                } else {
                    $total_credit_balance = $client_credit_balance + $resize_amount;
                    $total_advance_balance = 0;
                }
            } else {
                if (strtolower($status) == 'increase') {
                    $total_credit_balance = 0;
                    $total_advance_balance = ($client_advance_balance + $resize_amount);
                } else {
                    $result = $client_advance_balance - $resize_amount;
                    if ($result < 0) {
                        $total_credit_balance = abs($result);
                        $total_advance_balance = 0;
                    } else {
                        $total_credit_balance = 0;
                        $total_advance_balance = $result;
                    }
                }
            }
            $client_information_data = array(
                'id' => $client_id,
                'credit_balance' => $total_credit_balance,
                'advance_balance' => $total_advance_balance,
            );
            $this->db->where('id', $client_information_data['id']);
            $this->Client_Model->db->update('client_info', $client_information_data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function client_transaction_details_save($client_information, $payment_information, $amount, $user_id) {
        $narration = '';
        $narration = 'MR No(' . $payment_information->receipt_mr_no . ')(Ret.)';
        $payment_type = $payment_information->payment_type;
        $client_id = (int) $client_information->id;
        $current_date_time = get_current_date_and_time();
        $last_client_transaction_details = $this->Client_transaction_details_Model->get_last_client_transaction_details($client_id);

        $opening_balance = !empty($last_client_transaction_details) ? ($last_client_transaction_details->closing_balance) : 0;
//        $debit_amount = $amount;
//        $credit_amount = 0;
        $status = '';
        $resize_amount = 0;
        $previous_amount = (double) $payment_information->amount_received;
        $current_amount = (double) $amount;
        if ($current_amount > $previous_amount) { //6000 > 5000
            $status = 'increase';
            $resize_amount = $current_amount - $previous_amount;
        } else {
            $status = 'reduce';
            $resize_amount = $previous_amount - $current_amount;
        }
        if ($status == 'increase') {
            $debit_amount = $resize_amount;
            $credit_amount = 0;
            $closing_balance = (!empty($last_client_transaction_details) ? (double) ($last_client_transaction_details->closing_balance) : 0) + (double) $resize_amount;
        } else {
            $debit_amount = 0;
            $credit_amount = $resize_amount;
            $closing_balance = (!empty($last_client_transaction_details) ? (double) ($last_client_transaction_details->closing_balance) : 0) - (double) $resize_amount;
        }
        $data = array(
            'client_id' => $client_id,
            'invoice_payment_id' => 0,
            'transaction_date' => $current_date_time,
            'opening_balance' => $opening_balance, //0
            'debit_amount' => $debit_amount, //0
            'credit_amount' => $credit_amount, //10000
            'closing_balance' => $closing_balance, // 0-10000=10000
            'narration' => $narration,
            'payment_type' => $payment_type,
            'user_id' => $user_id,
        );
        $this->Client_transaction_details_Model->db->insert('client_transaction_details', $data);
    }

    public function client_sales_details_save($client_information, $payment_information, $amount) {
        $total_credit_balance = 0;
        $total_advance_balance = 0;
        $total_sale = 0;
        $total_payment = 0;
        $status = '';
        $resize_amount = 0;
        $previous_amount = (double) $payment_information->amount_received;
        $current_amount = (double) $amount;
        if ($current_amount > $previous_amount) {
            $status = 'increase';
            $resize_amount = $current_amount - $previous_amount;
        } else {
            $status = 'reduce';
            $resize_amount = $previous_amount - $current_amount;
        }
        $current_date = get_current_date();
        $client_id = (int) ($client_information->id);
        $current_client_sales_details_by_date = $this->Client_sales_details_Model->get_client_sales_details_by_date($client_id, $current_date);
        $client_credit_balance = (double) $client_information->credit_balance;
        $client_advance_balance = (double) $client_information->advance_balance;
        if ($client_credit_balance > 0) {
            if ($status == 'increase') {
                $result = $client_credit_balance - $resize_amount;
                if ($result < 0) {
                    $total_credit_balance = 0;
                    $total_advance_balance = abs($result);
                } else {
                    $total_credit_balance = $result;
                    $total_advance_balance = 0;
                }
            } else {
                $total_credit_balance = $client_credit_balance + $resize_amount;
                $total_advance_balance = 0;
            }
        } else {
            if ($status == 'increase') {
                $total_credit_balance = 0;
                $total_advance_balance = ($client_advance_balance + $resize_amount);
            } else {
                $result = $client_advance_balance - $resize_amount;
                if ($result < 0) {
                    $total_credit_balance = abs($result);
                    $total_advance_balance = 0;
                } else {
                    $total_credit_balance = 0;
                    $total_advance_balance = $result;
                }
            }
        }
        $total_sale = !empty($current_client_sales_details_by_date->total_sale) ? $current_client_sales_details_by_date->total_sale : 0;
        if ($status == 'increase') {
            $total_payment = !empty($current_client_sales_details_by_date->total_payment) ? ((double) $current_client_sales_details_by_date->total_payment + $resize_amount) : (0 + $resize_amount);
        } else {
            $total_payment = !empty($current_client_sales_details_by_date->total_payment) ? ((double) $current_client_sales_details_by_date->total_payment - $resize_amount) : (0 - $resize_amount);
        }
        $client_sales_details_data = array(
            'id' => !empty($current_client_sales_details_by_date->id) ? $current_client_sales_details_by_date->id : '',
            'client_id' => $client_id,
            'sale_date' => $current_date,
            'total_credit_balance' => $total_credit_balance,
            'total_advance_balance' => $total_advance_balance,
            'total_sale' => $total_sale,
            'total_payment' => $total_payment,
        );
        if (empty($current_client_sales_details_by_date)) {
            $this->Client_sales_details_Model->db->insert('client_sales_details', $client_sales_details_data);
        } else {
            $this->db->where('id', $client_sales_details_data['id']);
            $this->Client_sales_details_Model->db->update('client_sales_details', $client_sales_details_data);
        }
    }

}
