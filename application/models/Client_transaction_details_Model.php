<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_transaction_details_Model extends CI_Model {

    public $table_name = 'client_transaction_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_client_transaction_details($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_client_transaction_details($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'client_id' => $this->input->post('client_id'),
            'invoice_payment_id' => $this->input->post('invoice_payment_id'),
            'transaction_date' => $this->input->post('transaction_date'),
            'opening_balance' => $this->input->post('opening_balance'),
            'debit_amount' => $this->input->post('debit_amount'),
            'credit_amount' => $this->input->post('credit_amount'),
            'closing_balance' => $this->input->post('closing_balance'),
            'narration' => $this->input->post('narration'),
            'payment_type' => $this->input->post('payment_type'),
            'user_id' => $this->input->post('user_id'),
        );
        if ($id === 0) {
            return $this->db->insert($this->table_name, $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update($this->table_name, $data);
        }
    }

    public function get_customer_transaction_details_by_date_and_client_id($start_date,$end_date,$client_id)
    {
        $where_query = "";

        if ($start_date) {
            $where_query .= " DATE_FORMAT(`client_transaction_details`.`transaction_date`,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
        }

        if ($client_id) {
            $where_query .= " AND `client_transaction_details`.`client_id` = $client_id";
        }

        if ($where_query) {
            $where_query = 'WHERE '.$where_query;
        }

        $result = $this->db->query("
            SELECT `client_transaction_details`.*,`client_info`.`client_name` AS `clientName`,`client_info`.`client_code` AS `clientCode`,`client_info`.`phone_number` AS `clientPhoneNumber`
            FROM `client_transaction_details`
            LEFT JOIN `client_info` ON `client_info`.`id` = `client_transaction_details`.`client_id`
            $where_query
        ")->result();

        return $result;
    }

    public function get_single_customer_bill_by_date_and_customer_id($clientId,$startDate,$endDate)
    {
        $result = $this->db->query("SELECT * FROM client_transaction_details WHERE client_id = $clientId AND DATE_FORMAT(transaction_date,'%Y-%m-%d') BETWEEN '$startDate' AND '$endDate'")->result();

        return $result;
    }

    public function get_last_client_transaction_details($client_id) {
        $query = $this->db->query("SELECT * FROM client_transaction_details WHERE client_id='$client_id' ORDER BY id DESC LIMIT 1");
        return $query->row();
    }

    public function get_last_client_transaction_details_by_date($client_id, $date) {
        $start_date = get_start_date_format($date);
        $end_date = get_end_date_format($date);
        $query = $this->db->query("SELECT * FROM client_transaction_details WHERE client_id='$client_id' AND transaction_date >= '$start_date' AND transaction_date <= '$end_date' ORDER BY id DESC LIMIT 1");
        return $query->row();
    }

    public function get_client_last_transaction_from_current_date($client_id, $date) {
        $date = get_start_date_format($date);
        $query = $this->db->query("SELECT * FROM client_transaction_details WHERE client_id='$client_id' AND transaction_date < '$date' ORDER BY id DESC LIMIT 1");
        return $query->row();
    }

    public function get_client_current_date_first_transaction($client_id, $date) {
        $start_date = get_start_date_format($date);
        $end_date = get_end_date_format($date);
        $query = $this->db->query("SELECT * FROM client_transaction_details WHERE client_id='$client_id' AND transaction_date >= '$start_date' AND transaction_date <= '$end_date' ORDER BY id ASC LIMIT 1");
        return $query->row();
    }

    public function get_client_transaction_details_by_date($client_id, $start_date, $end_date) {
        $start_date = get_start_date_format($start_date);
        $end_date = get_end_date_format($end_date);
        $query = $this->db->query("SELECT ctd.id, ctd.client_id, ctd.invoice_payment_id, ctd.transaction_date, ctd.opening_balance, ctd.debit_amount, ctd.credit_amount, ctd.closing_balance, ctd.narration, ctd.payment_type, ctd.user_id, c.client_name, c.client_code FROM client_transaction_details ctd LEFT JOIN client_info c ON ctd.client_id=c.id WHERE ctd.client_id='$client_id' AND ctd.transaction_date >= '$start_date' AND ctd.transaction_date <= '$end_date' ORDER BY ctd.id ASC");
        return $query->result();
    }

    public function get_client_total_transaction_details_by_date($client_id, $start_date, $end_date) { //
        $start_date = get_start_date_format($start_date);
        $end_date = get_end_date_format($end_date);
        $query = $this->db->query("SELECT ctd.id, ctd.client_id, ctd.invoice_payment_id, ctd.transaction_date, ctd.opening_balance, SUM(ctd.debit_amount) AS total_debit_amount, SUM(ctd.credit_amount) AS total_credit_amount, ctd.closing_balance, ctd.narration, ctd.payment_type, ctd.user_id, c.client_name, c.client_code FROM client_transaction_details ctd LEFT JOIN client_info c ON ctd.client_id=c.id WHERE ctd.client_id='$client_id' AND ctd.transaction_date >= '$start_date' AND ctd.transaction_date <= '$end_date' GROUP BY ctd.client_id ORDER BY ctd.id ASC");
        return $query->row();
    }

}
