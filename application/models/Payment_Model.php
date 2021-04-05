<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_Model extends CI_Model {

    public $table_name = 'payment';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_payment($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function get_customer_payment_by_date_client_id($start_date,$end_date,$client_id)
    {
        $where_query = "";

        if ($start_date) {
            $where_query .= " DATE_FORMAT(`payment`.`receipt_date`,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
        }

        if ($client_id != 'all') {
            $where_query .= " AND `payment`.`client_id` = $client_id";
        }

        if ($where_query) {
            $where_query = 'WHERE '.$where_query;
        }

        $result = $this->db->query("
            SELECT `payment`.*,`client_info`.`client_name` AS `clientName`,`client_info`.`client_code` AS `clientCode`,`client_info`.`phone_number` AS `clientPhoneNumber`
            FROM `payment`
            LEFT JOIN `client_info` ON `client_info`.`id` = `payment`.`client_id`
            $where_query
        ")->result();

        return $result;
    }

    public function save_payment($id = 0) {
        $this->load->helper('url');
        $data = array(
            'receipt_mr_no' => $this->input->post('receipt_mr_no'),
            'receipt_date' => $this->input->post('receipt_date'),
            'client_id' => $this->input->post('client_id'),
            'amount_received' => $this->input->post('amount_received'),
            'client_code' => $this->input->post('client_code'),
            'payment_type' => $this->input->post('payment_type'),
            'cheque_number' => $this->input->post('cheque_number'),
            'cheque_date' => $this->input->post('cheque_date'),
            'bank_id' => $this->input->post('bank_id'),
            'branch_name' => $this->input->post('branch_name'),
            'purpose' => $this->input->post('purpose'),
            'invoice_number' => $this->input->post('invoice_number'),
            'remarks' => $this->input->post('remarks'),
        );
        if ($id === 0) {
            return $this->db->insert($this->table_name, $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update($this->table_name, $data);
        }
    }

    public function get_last_row_id() {
//        $last_row_id = $this->db->query("SELECT id, receipt_mr_no FROM payment ORDER BY id DESC LIMIT 1")->row();
//        return $last_row_id;
        $max_receipt_mr_no = $this->db->query("SELECT MAX(CAST(receipt_mr_no AS UNSIGNED)) AS max_receipt_mr_no FROM payment")->row();
        return $max_receipt_mr_no;
    }

    public function get_payment_by_mr_number($mr_number) {
        $query = $this->db->get_where($this->table_name, array('receipt_mr_no' => $mr_number));
        return $query->row();
    }

    public function get_clientwise_payment_total_amount_by_date($client_id, $start_date, $end_date) {
        $where_condition = "p.client_id = '$client_id' AND p.receipt_date >= '$start_date' AND p.receipt_date <= '$end_date' GROUP BY p.client_id";
        $result = $this->db->query("SELECT SUM(p.amount_received) AS sum_of_amount_received FROM payment p WHERE $where_condition")->row();
        return (!empty($result)) ? $result->sum_of_amount_received : 0;
    }

}
