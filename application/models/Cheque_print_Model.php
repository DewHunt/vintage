<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cheque_print_Model extends CI_Model {

    public $table_name = 'cheque_print';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_cheque_print($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
    }

    public function get_cheque_print_by_date($start_date, $end_date) {
        $query = $this->db->query("SELECT cp.id, cp.bank_id, cp.cheque_date, cp.pay_to, cp.amount, cp.amount_in_words, cp.details, cp.current_date_time, cp.user_id, u.user_name, u.user_type, b.bank_name FROM cheque_print cp LEFT JOIN user_info u ON cp.user_id = u.id LEFT JOIN bank_info b ON cp.bank_id = b.id WHERE cp.cheque_date >= '$start_date' AND cp.cheque_date <= '$end_date'");
        return $query->result();
    }

    public function get_cheque_print_by_cheque_id($cheque_id) {
        $query = $this->db->query("SELECT cp.id, cp.bank_id, cp.cheque_date, cp.pay_to, cp.amount, cp.amount_in_words, cp.details, cp.current_date_time, cp.user_id, u.user_name, u.user_type, b.bank_name FROM cheque_print cp LEFT JOIN user_info u ON cp.user_id = u.id LEFT JOIN bank_info b ON cp.bank_id = b.id WHERE cp.id = '$cheque_id'");
        return $query->row();
    }

}
