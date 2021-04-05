<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Loan_Model extends CI_Model {

    public $table_name = 'loan';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_loan($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_loan($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'employee_id' => $this->input->post('employee_id'),
            'loan_start_date' => $this->input->post('loan_start_date'),
            'total_loan_amount' => $this->input->post('total_loan_amount'),
            'number_of_installment' => $this->input->post('number_of_installment'),
            'per_installment_amount' => $this->input->post('per_installment_amount'),
            'details' => $this->input->post('details'),
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

    public function get_loan_by_employee_id($employee_id) {
        $query = $this->db->get_where($this->table_name, array('employee_id' => $employee_id));
        return $query->row();
    }

    public function get_employee_loan($employee_id = 0) {
        if ((int) $employee_id == 0) {
            $query = $this->db->query("SELECT l.id, l.employee_id, l.loan_start_date, l.total_loan_amount,l.number_of_installment, l.per_installment_amount, l.total_installment_amount, l.details, l.user_id, e.employee_name, e.employee_code, e.designation, u.user_name FROM loan l JOIN employee_info e ON l.employee_id=e.id JOIN user_info u ON l.user_id = u.id")->result();
        } else {
            $query = $this->db->query("SELECT l.id, l.employee_id, l.loan_start_date, l.total_loan_amount,l.number_of_installment, l.per_installment_amount, l.total_installment_amount, l.details, l.user_id, e.employee_name, e.employee_code, e.designation, u.user_name FROM loan l LEFT JOIN employee_info e ON l.employee_id=e.id LEFT JOIN user_info u ON l.user_id = u.id WHERE l.employee_id = '$employee_id'")->row();
        }

        return $query;
    }

}
