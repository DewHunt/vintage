<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_benefit_Model extends CI_Model {

    public $table_name = 'employee_benefit';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_employee_benefit($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_employee_benefit($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'employee_id' => $this->input->post('employee_id'),
            'month' => $this->input->post('month'),
            'year' => $this->input->post('year'),
            'head_id' => $this->input->post('head_id'),
            'amount' => $this->input->post('amount'),
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
        $this->db->delete('employee_benefit');
    }

    public function get_employee_benefit_by_month_year($month, $year, $employee_id) {
        if ($month != '' && $year != '' && $employee_id > 0) {
            $query_result = $this->db->query("SELECT SUM(amount) AS sum_of_amount FROM employee_benefit WHERE month='$month' AND year='$year' AND employee_id='$employee_id'");
            return $query_result->row();
        }
        if ($month == '' && $employee_id > 0) {
            $query_result = $this->db->query("SELECT SUM(amount) AS sum_of_amount FROM employee_benefit WHERE year='$year' AND employee_id='$employee_id'");
            return $query_result->row();
        }
        $query_result = $this->db->query("SELECT SUM(amount) AS sum_of_amount FROM employee_benefit WHERE year='$year'");
        return $query_result->row();
    }

    public function get_employee_benefit_total_amount_by_month_year($month, $year, $employee_id) {
        $query_result = $this->db->query("SELECT SUM(amount) AS sum_of_amount FROM employee_benefit WHERE month='$month' AND year='$year' AND employee_id='$employee_id'");
        return $query_result->row();
    }

}
