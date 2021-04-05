<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher_details_Model extends CI_Model {

    public $table_name = 'voucher_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_voucher_details($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_voucher_details($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'income_head_id' => $this->input->post('income_head_id'),
            'expense_head_id' => $this->input->post('expense_head_id'),
            'amount' => $this->input->post('amount'),
            'invoice_number' => $this->input->post('invoice_number'),
            'mr_number' => $this->input->post('mr_number'),
            'client_id' => $this->input->post('client_id'),
            'employee_id' => $this->input->post('employee_id'),
            'month' => $this->input->post('month'),
            'year' => $this->input->post('year'),
            'narration' => $this->input->post('narration'),
            'debit_amount' => $this->input->post('debit_amount'),
            'credit_amount' => $this->input->post('credit_amount'),
            'voucher_posting_details_id' => $this->input->post('voucher_posting_details_id'),
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
        $this->db->delete('voucher_details');
    }

}
