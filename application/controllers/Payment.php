<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Client_Model');
        $this->load->model('Bank_Model');
        $this->load->model('Payment_Model');
        $this->load->model('User_Model');
        $this->load->model('Client_sales_details_Model');
        $this->load->model('Client_transaction_details_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Company_Model');
    }

    public function index() {
        if (get_user_permission('payment') === false) {
            redirect(base_url('user_login'));
        }
        $receipt_mr_no = $this->get_max_mr_number();
        $factoryStatus = 1; $hotKitchenStatus = 0;

        $this->data['title'] = "Payment";
        $this->data['all_distinct_bank_name'] = $this->Bank_Model->get_all_distinct_bank_name();
        $this->data['client_list'] = $this->Client_Model->get_client();
        $this->data['bank_list'] = $this->Bank_Model->get_bank();
        $this->data['branch_list'] = $this->Branch_Model-> get_any_type_branch('AND',$factoryStatus,$hotKitchenStatus);
        $this->data['receipt_mr_no'] = $receipt_mr_no;
        
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('payment/payment', $this->data);
    }

    public function get_max_mr_number() {
        $receipt_mr_no = 0;
        $max_mr_number = $this->Payment_Model->get_last_row_id();
        $receipt_mr_no = !empty($max_mr_number->max_receipt_mr_no) ? (((int) $max_mr_number->max_receipt_mr_no) + 1) : 1000;
        return $receipt_mr_no;
    }

    public function getclientInfoById()
    {
        $clientInfo = $this->Client_Model->get_client_info_by_id($this->input->post('clientId'));

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'clientInfo' => $clientInfo
        )));
    }

    public function save_payment() {
        if (get_user_permission('payment') === false) {
            redirect(base_url('user_login'));
        }
        // echo "<pre>"; print_r($this->input->post()); exit();
        $this->data['title'] = 'Payment';

        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id'];

        $amount_received = (double) trim($this->input->post('amount_received'));
        $client_id = trim($this->input->post('client_id'));
        $receipt_mr_no = trim($this->input->post('receipt_mr_no'));
        $receipt_mr_no = $this->get_max_mr_number();
        $payment_type = trim($this->input->post('payment_type'));
        $remarks = trim($this->input->post('remarks'));
        $bank_id = trim($this->input->post('bank_id'));
        $branch_id = intval(trim($this->input->post('branch_id')));

        $bank_information = $this->Bank_Model->get_bank($bank_id);
        $client_information = $this->Client_Model->get_client($client_id);
        $valid_numeric_number_check_result = $this->valid_numeric_number_check($amount_received);

        if (!empty($valid_numeric_number_check_result) == TRUE) {
            $data = array(
                'receipt_mr_no' => $receipt_mr_no,
                'receipt_date' => get_current_date_and_time($this->input->post('receipt_date')),
                'client_id' => $client_id,
                'amount_received' => (double) $amount_received,
                'client_code' => !empty($client_information->client_code) ? $client_information->client_code : '',
                'payment_type' => $payment_type,
                'cheque_number' => trim($this->input->post('cheque_number')),
                'cheque_date' => trim($this->input->post('cheque_date')),
                'bank_id' => $bank_id,
                'invoice_number' => trim($this->input->post('invoice_number')),
                'remarks' => $remarks,
                'branch_id' => $branch_id,
            );

            $this->Payment_Model->db->insert('payment', $data);                
            $currently_inserted_payment_id = $this->db->insert_id();

            $this->client_sales_details_save($client_information, $amount_received);
            $this->update_client_credit_balance($client_information, $amount_received);

            $narration = '';
            $narration = 'MR No(' . $receipt_mr_no . ')';
            $invoice_payment_id = $currently_inserted_payment_id;

            $this->client_transaction_details_save($client_information, $invoice_payment_id, $amount_received, $narration, $user_id, $payment_type);

            $this->session->set_flashdata('payment_success_message', 'Payment has been completed successfully.');
            redirect(base_url('Payment'));
        } else {
            $this->session->set_flashdata('valid_numeric_number_check_error_message', 'Please Input a Numeric Number for Amount Received.');
            redirect(base_url('Payment'));
        }
    }

    public function client_transaction_details_save($client_information, $invoice_payment_id, $amount, $narration, $user_id, $payment_type) {
        $client_id = $client_information->id;
        $current_date_time = $this->User_Model->get_current_date_and_time();
        $last_client_transaction_details = $this->Client_transaction_details_Model->get_last_client_transaction_details($client_id);

        $opening_balance = !empty($last_client_transaction_details) ? ($last_client_transaction_details->closing_balance) : 0;
        $debit_amount = (double) $amount;
        $credit_amount = (double) 0;
        $closing_balance = (!empty($last_client_transaction_details) ? (double) ($last_client_transaction_details->closing_balance) : (double) 0) - (double) $amount;
        $data = array(
            'client_id' => $client_id,
            'invoice_payment_id' => $invoice_payment_id,
            'transaction_date' => $current_date_time,
            'opening_balance' => $opening_balance,
            'debit_amount' => $debit_amount,
            'credit_amount' => $credit_amount,
            'closing_balance' => $closing_balance,
            'narration' => $narration,
            'payment_type' => $payment_type,
            'user_id' => $user_id,
        );
        $this->Client_transaction_details_Model->db->insert('client_transaction_details', $data);
    }

    public function client_sales_details_save($client_information, $amount) {
        $current_date = get_current_date();
        $client_id = trim($client_information->id);
        $current_client_sales_details_by_date = $this->Client_sales_details_Model->get_client_sales_details_by_date($client_id, $current_date);
        
        if (empty($current_client_sales_details_by_date)) {
            $data = array(
                'client_id' => $client_id,
                'sale_date' => $current_date,
                'total_credit_balance' => (double) $client_information->credit_balance,
                'total_advance_balance' => (double) $client_information->advance_balance,
                'total_sale' => 0,
                'total_payment' => 0,
            );
            $this->Client_sales_details_Model->db->insert('client_sales_details', $data);
        }
        if (empty($current_client_sales_details_by_date)) {
            $current_client_sales_details_by_date = $this->Client_sales_details_Model->get_client_sales_details_by_date($client_id, $current_date);
        }
        if (!empty($current_client_sales_details_by_date)) {
            $current_payment_amount = (double) $amount;
            $previous_credit = (double) ($current_client_sales_details_by_date->total_credit_balance);
            $advance_balance = (double) 0;
            if ($current_payment_amount > $previous_credit) {
                $advance_balance = (double) ($current_payment_amount - $previous_credit);
                $total_credit_balance = (double) 0;
            } else {
                $total_credit_balance = $previous_credit - $current_payment_amount - $advance_balance;
            }
            $total_payment = $current_payment_amount - $advance_balance;
            $total_advance_balance = (double) $current_client_sales_details_by_date->total_advance_balance;
            $total_advance_balance += (double) $advance_balance;
            $total_payment += (double) $current_client_sales_details_by_date->total_payment;
            
            $data = array(
                'id' => ($current_client_sales_details_by_date->id),
                'client_id' => $client_id,
                'sale_date' => $current_date,
                'total_credit_balance' => $total_credit_balance,
                'total_advance_balance' => $total_advance_balance,
                'total_sale' => $current_client_sales_details_by_date->total_sale,
                'total_payment' => $total_payment,
            );
            $this->db->where('id', $data['id']);
            $this->Client_sales_details_Model->db->update('client_sales_details', $data);
        }
    }

    public function update_client_credit_balance($client_information, $amount) {
        $current_payment_amount = (double) $amount;
        $previous_credit = (double) ($client_information->credit_balance);
        $advance_balance = (double) 0;
        if ($current_payment_amount > $previous_credit) {
            $advance_balance = (double) ($current_payment_amount - $previous_credit);
            $total_credit_balance = (double) 0;
        } else {
            $total_credit_balance = $previous_credit - $current_payment_amount - $advance_balance;
        }
        $total_advance_balance = $client_information->advance_balance;
        $total_advance_balance += (double) $advance_balance;
        $client_information_data = array(
            'credit_balance' => $total_credit_balance,
            'advance_balance' => $total_advance_balance,
        );
        $this->db->where('id', $client_information->id);
        $this->Client_Model->db->update('client_info', $client_information_data);
    }

    public function valid_numeric_number_check($amount_received) {
        if (empty($amount_received) || (!is_numeric($amount_received))) {
            return FALSE;
        }
        return TRUE;
    }

    public function get_all_branches_of_selected_bank() {
        $bank_name = trim($this->input->post('bank_name'));
        $all_branches_by_bank = $this->Bank_Model->get_all_branches_by_bank($bank_name);
        echo '<option value="', '', '">', 'Please Select', '</option>';
        foreach ($all_branches_by_bank as $branches) {
            echo '<option value="', $branches->id, '">', $branches->branch_name, '</option>';
        }
    }

}
