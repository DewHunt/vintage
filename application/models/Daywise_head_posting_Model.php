<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daywise_head_posting_Model extends CI_Model {

    public $table_name = 'daywise_head_posting';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_daywise_head_posting($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_daywise_head_posting($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'head_id' => $this->input->post('bank_name'),
            'posting_date' => $this->input->post('posting_date'),
            'opening_balance' => $this->input->post('opening_balance'),
            'debit_amount' => $this->input->post('debit_amount'),
            'credit_amount' => $this->input->post('credit_amount'),
            'closing_balance' => $this->input->post('closing_balance'),
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

    public function get_daywise_head_posting_by_date_and_head_id($posting_date, $head_id) {
        $result = $this->db->query("SELECT * FROM daywise_head_posting WHERE posting_date= '$posting_date' AND head_id= $head_id")->row();
        return $result;
    }

    public function get_opening_and_closing($start_date, $end_date, $head_id) {
        if ((int) $head_id <= 0) {
            $where_condition = "WHERE dhp.posting_date >= '$start_date' AND dhp.posting_date <= '$end_date' AND hd.is_active = '1' ORDER BY dhp.posting_date DESC";
        } else {
            $where_condition = "WHERE dhp.posting_date >= '$start_date' AND dhp.posting_date <= '$end_date' AND dhp.head_id = $head_id AND hd.is_active = '1' ORDER BY dhp.posting_date DESC";
        }
        return $result = $this->db->query("SELECT dhp.id, dhp.head_id, dhp.posting_date, dhp.opening_balance, dhp.debit_amount, dhp.credit_amount, dhp.user_id, dhp.closing_balance, hd.head_name FROM daywise_head_posting dhp JOIN head_details hd ON dhp.head_id=hd.id JOIN user_info u ON dhp.user_id=u.id $where_condition")->result();
    }

    public function get_opening_and_closing_for_lower_check($start_date, $end_date, $head_id) {
        if ((int) $head_id <= 0) {
            $where_condition = "WHERE dhp.posting_date <= '$start_date' AND hd.is_active = '1' ORDER BY dhp.posting_date DESC";
        } else {
            $where_condition = "WHERE dhp.posting_date <= '$start_date' AND dhp.head_id = $head_id AND hd.is_active = '1' ORDER BY dhp.posting_date DESC";
        }
        return $result = $this->db->query("SELECT dhp.id, dhp.head_id, dhp.posting_date, dhp.opening_balance, dhp.debit_amount, dhp.credit_amount, dhp.user_id, dhp.closing_balance, hd.head_name FROM daywise_head_posting dhp JOIN head_details hd ON dhp.head_id=hd.id JOIN user_info u ON dhp.user_id=u.id $where_condition")->result();
    }

    public function get_opening_and_closing_by_head_id($start_date, $end_date, $head_id) {
        return $result = $this->db->query("SELECT dhp.id, dhp.head_id, dhp.posting_date, dhp.opening_balance, dhp.debit_amount, dhp.credit_amount, dhp.user_id, dhp.closing_balance, hd.head_name FROM daywise_head_posting dhp JOIN head_details hd ON dhp.head_id=hd.id JOIN user_info u ON dhp.user_id=u.id WHERE dhp.posting_date >= '$start_date' AND dhp.posting_date <= '$end_date' AND dhp.head_id = $head_id AND hd.is_active = '1' ORDER BY dhp.posting_date DESC")->result();
    }

    public function get_opening_and_closing_by_head_id_for_lower_check($start_date, $end_date, $head_id) {
        return $result = $this->db->query("SELECT dhp.id, dhp.head_id, dhp.posting_date, dhp.opening_balance, dhp.debit_amount, dhp.credit_amount, dhp.user_id, dhp.closing_balance, hd.head_name FROM daywise_head_posting dhp JOIN head_details hd ON dhp.head_id=hd.id JOIN user_info u ON dhp.user_id=u.id WHERE dhp.posting_date <= '$start_date' AND dhp.head_id = $head_id AND hd.is_active = '1' ORDER BY dhp.posting_date DESC")->result();
    }

    public function get_last_daywise_head_posting_by_head($head_id, $month_number, $year) {
        return $result = $this->db->query("SELECT * FROM daywise_head_posting WHERE head_id=$head_id AND MONTH(posting_date) = '$month_number' AND YEAR(posting_date) = '$year' ORDER BY id DESC LIMIT 1")->row();
    }

    public function get_current_balance_from_daywise_head_posting_by_head($head_id, $year) {
        return $result = $this->db->query("SELECT * FROM daywise_head_posting WHERE head_id=$head_id AND YEAR(posting_date) = '$year' ORDER BY id DESC LIMIT 1")->row();
    }

    public function get_current_balance_from_previous_year_daywise_head_posting_by_head($head_id, $year) {
        return $result = $this->db->query("SELECT * FROM daywise_head_posting WHERE head_id=$head_id AND YEAR(posting_date) < '$year' ORDER BY id DESC LIMIT 1")->row();
    }

    public function get_single_head_current_balance($head_id, $year) {
        $amount = 0;
        $result = $this->get_current_balance_from_daywise_head_posting_by_head($head_id, $year);
        if (empty($result)) {
            $result = $this->get_current_balance_from_previous_year_daywise_head_posting_by_head($head_id, $year);
        }
        if (!empty($result)) {
            $amount = $result->closing_balance;
        } else {
            $amount = 0;
        }
        return !empty($amount) ? $amount : 0;
    }

    public function get_current_balance_from_daywise_head_posting_by_head_by_date($head_id, $start_date, $end_date) {
        return $result = $this->db->query("SELECT * FROM $this->table_name WHERE head_id = $head_id AND posting_date >= '$start_date' AND posting_date <= '$end_date' ORDER BY id DESC LIMIT 1")->row();
    }

    public function get_current_balance_from_previous_year_daywise_head_posting_by_head_by_date($head_id, $start_date, $end_date) {
        return $result = $this->db->query("SELECT * FROM $this->table_name WHERE head_id = $head_id AND posting_date < '$start_date' ORDER BY id DESC LIMIT 1")->row();
    }

    public function get_single_head_current_balance_by_date($head_id, $start_date, $end_date) {
        $amount = 0;
        $result = $this->get_current_balance_from_daywise_head_posting_by_head_by_date($head_id, $start_date, $end_date);
        if (empty($result)) {
            $result = $this->get_current_balance_from_previous_year_daywise_head_posting_by_head_by_date($head_id, $start_date, $end_date);
        }
        if (!empty($result)) {
            $amount = $result->closing_balance;
        } else {
            $amount = 0;
        }
        return !empty($amount) ? $amount : 0;
    }

    public function is_head_posting($head_id, $year, $type) {
        $start_date = $year . '-01-01';
        $end_date = $year . '-12-31';
        if ((int) $type == 1) { // 1 for income
            $where_condition = "WHERE posting_date >= '$start_date' AND posting_date <= '$end_date' AND head_id=$head_id AND closing_balance < 0";
        } else { // 2 for expences
            $where_condition = "WHERE posting_date >= '$start_date' AND posting_date <= '$end_date' AND head_id=$head_id AND closing_balance > 0";
        }
        $result = $this->db->query("SELECT * FROM $this->table_name $where_condition")->result();
        return !empty($result) ? TRUE : FALSE;
    }

    public function get_desc_daywise_head_posting_by_date_and_head_id($head_id) {
        $result = $this->db->query("SELECT * FROM $this->table_name WHERE head_id= $head_id ORDER BY id DESC LIMIT 1")->row();
        return $result;
    }

}
