<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Loan_details_Model extends CI_Model {

    public $table_name = 'loan_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_loan_details($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_loan_details($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'loan_id' => $this->input->post('loan_id'),
            'employee_id' => $this->input->post('employee_id'),
            'month' => $this->input->post('month'),
            'year' => $this->input->post('year'),
            'loan_payment_date' => $this->input->post('loan_payment_date'),
            'per_installment' => $this->input->post('per_installment'),
            'total_loan_amount' => $this->input->post('total_loan_amount'),
            'previous_loan_payment' => $this->input->post('previous_loan_payment'),
            'total_loan_payment' => $this->input->post('total_loan_payment'),
            'due_loan_amount' => $this->input->post('due_loan_amount'),
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
        $this->db->delete('loan_details');
    }

    public function get_loan_details_by_employee_id_current_loan_id_month_year($employee_id, $current_loan_id, $month, $year) {
        $this->db->select('*');
        $this->db->from('loan_details');
        $this->db->where("(employee_id='$employee_id' AND loan_id = '$current_loan_id' AND month = '$month' AND year = '$year')");
        $query = $this->db->get();
        return $query->row();
    }

}
