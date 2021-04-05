<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_accounts_transaction_details_Model extends CI_Model {

    public $table_name = 'client_accounts_transaction_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_client_accounts_transaction_details($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_client_accounts_transaction_details($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'client_id' => $this->input->post('client_id'),
            'voucher_number' => $this->input->post('voucher_number'),
            'invoice_number' => $this->input->post('invoice_number'),
            'mr_number' => $this->input->post('mr_number'),
            'transaction_date' => $this->input->post('transaction_date'),
            'opening_balance' => $this->input->post('opening_balance'),
            'debit_amount' => $this->input->post('debit_amount'),
            'credit_amount' => $this->input->post('credit_amount'),
            'closing_balance' => $this->input->post('closing_balance'),
            'narration' => $this->input->post('narration'),
            'head_id' => $this->input->post('head_id'),
            'user_id' => $this->input->post('user_id'),
        );
        if ($id === 0) {
            return $this->db->insert($this->table_name, $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update($this->table_name, $data);
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
    }

    public function get_last_client_accounts_transaction_details($client_id) {
        $query = $this->db->query("SELECT * FROM client_accounts_transaction_details WHERE client_id='$client_id' ORDER BY id DESC LIMIT 1");
        return $query->row();
    }

    public function get_last_client_accounts_transaction_details_by_date($client_id, $date) {
        $start_date = $date . ' 00:00:00';
        $end_date = $date . ' 23:59:59';
        $query = $this->db->query("SELECT * FROM client_accounts_transaction_details WHERE client_id='$client_id' AND transaction_date >= '$start_date' AND transaction_date <= '$end_date' ORDER BY id DESC LIMIT 1");
        return $query->row();
    }

    public function get_last_transaction_from_current_date($client_id, $date) {
        $date = $date . ' 00:00:00';
        $query = $this->db->query("SELECT * FROM client_accounts_transaction_details WHERE client_id='$client_id' AND transaction_date < '$date' ORDER BY id DESC LIMIT 1");
        return $query->row();
    }

    public function get_current_date_first_transaction($client_id, $date) {
        $start_date = $date . ' 00:00:00';
        $end_date = $date . ' 23:59:59';
        $query = $this->db->query("SELECT * FROM client_accounts_transaction_details WHERE client_id='$client_id' AND transaction_date >= '$start_date' AND transaction_date <= '$end_date' ORDER BY id ASC LIMIT 1");
        return $query->row();
    }

    public function get_client_accounts_transaction_details_by_date($client_id, $start_date, $end_date) {
        $start_date = $start_date . ' 00:00:00';
        $end_date = $end_date . ' 23:59:59';
        $query = $this->db->query("SELECT catd.id, catd.client_id, catd.voucher_number, catd.invoice_number, catd.mr_number, catd.transaction_date, catd.opening_balance, catd.debit_amount, catd.credit_amount, catd.closing_balance, catd.narration, catd.head_id, catd.user_id, c.client_name, c.client_code, h.head_name, h.head_type, u.user_name, u.user_type FROM client_accounts_transaction_details catd LEFT JOIN client_info c ON catd.client_id=c.id LEFT JOIN head_details h ON catd.head_id=h.id LEFT JOIN user_info u ON catd.user_id=u.id WHERE catd.client_id='$client_id' AND catd.transaction_date >= '$start_date' AND catd.transaction_date <= '$end_date' ORDER BY catd.id ASC");
        return $query->result();
    }

    public function get_client_total_accounts_transaction_details_by_date($client_id, $start_date, $end_date) {
        $start_date = $start_date . ' 00:00:00';
        $end_date = $end_date . ' 23:59:59';
        $query = $this->db->query("SELECT catd.id, catd.client_id, catd.voucher_number, catd.invoice_number, catd.mr_number, catd.transaction_date, catd.opening_balance, SUM(catd.debit_amount) AS total_debit_amount, SUM(catd.credit_amount) AS total_credit_amount, catd.closing_balance, catd.narration, catd.head_id, catd.user_id, c.client_name, c.client_code, h.head_name, h.head_type, u.user_name, u.user_type FROM client_accounts_transaction_details catd LEFT JOIN client_info c ON catd.client_id=c.id LEFT JOIN head_details h ON catd.head_id=h.id LEFT JOIN user_info u ON catd.user_id=u.id WHERE catd.client_id='$client_id' AND catd.transaction_date >= '$start_date' AND catd.transaction_date <= '$end_date' GROUP BY catd.client_id ORDER BY catd.id ASC");
        return $query->row();
    }

    public function get_client_accounts_transaction_details_by_start_date_end_date($head_id, $start_date, $end_date) {
        $start_date = $start_date . ' 00:00:00';
        $end_date = $end_date . ' 23:59:59';
        $query = $this->db->query("SELECT * FROM client_accounts_transaction_details WHERE head_id = '$head_id' AND transaction_date >= '$start_date' AND transaction_date <= '$end_date' ORDER BY id ASC");
        return $query->result();
    }

}
