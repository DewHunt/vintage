<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pf_funds_details_Model extends CI_Model {

    public $table_name = 'pf_funds_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_pf_funds_details($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_pf_funds_details($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'employee_id' => $this->input->post('employee_id'),
            'deposit_date' => $this->input->post('deposit_date'),
            'previous_deposit_amount' => $this->input->post('previous_deposit_amount'),
            'deposit_amount' => $this->input->post('deposit_amount'),
            'deposit_amount_total' => $this->input->post('deposit_amount_total'),
            'user_id' => $this->input->post('user_id'),
            'salary_details_id' => $this->input->post('salary_details_id'),
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
        $this->db->delete('pf_funds_details');
    }

    public function get_pf_funds_details_by_employee_id($employee_id) {
        return $query = $this->db->query("SELECT * FROM pf_funds_details WHERE employee_id = $employee_id")->result();
    }

    /* public function get_pf_funds_details_by_employee_id($employee_id, $month, $year)
      {
      return $query = $this->db->query("SELECT pd.id, pd.employee_id, pd.deposit_date,pd.month,pd.year,pd.deposit_amount,pd.deposit_amount_total,pd.is_generate,pd.user_id, e.employee_name, e.employee_code,e.joining_date,e.closing_date FROM pf_funds_details pd JOIN employee_info e ON pd.employee_id=e.id WHERE pd.employee_id = $employee_id AND pd.month='$month' AND pd.year='$year'")->row();
      } */

    public function get_pf_details_by_salary_details_id($salary_details_id) {
        $query = $this->db->get_where($this->table_name, array('salary_details_id' => $salary_details_id));
        return $query->row();
    }

}
