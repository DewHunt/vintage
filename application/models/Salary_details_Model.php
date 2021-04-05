<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_details_Model extends CI_Model
{
    public $table_name = 'salary_details';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_salary_details($id = 0)
    {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_salary_details($id = 0)
    {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'employee_id' => $this->input->post('employee_id'),
            'basic_salary' => $this->input->post('basic_salary'),
            'phone_allowance' => $this->input->post('phone_allowance'),
            'tuition_allowance' => $this->input->post('tuition_allowance'),
            'attendance_allowance' => $this->input->post('attendance_allowance'),
            'bonus' => $this->input->post('bonus'),
            'others' => $this->input->post('others'),
            'gross_salary' => $this->input->post('gross_salary'),
            'pf_contribution' => $this->input->post('pf_contribution'),
            'loan_installment' => $this->input->post('loan_installment'),
            'net_salary' => $this->input->post('net_salary'),
            'month' => $this->input->post('month'),
            'year' => $this->input->post('year'),
            'employee_benefit' => $this->input->post('employee_benefit'),
            'user_id' => $this->input->post('user_id'),
            'others_benefit' => $this->input->post('others_benefit'),
            'less_others_benefit' => $this->input->post('less_others_benefit'),
            'less_others_misc' => $this->input->post('less_others_misc'),
            'take_home_salary' => $this->input->post('take_home_salary'),
        );
        if ($id === 0) {
            return $this->db->insert($this->table_name, $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update($this->table_name, $data);
        }
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('salary_details');
    }

    public function get_salary_details_by_month_year_employee_id($employee_id, $month, $year)
    {
        return $result = $this->db->query("SELECT * FROM salary_details WHERE employee_id = $employee_id AND month='$month' AND year= '$year'")->row();
    }
    
    public function get_salary_details_by_month_year($month, $year)
    {
        return $result = $this->db->query("SELECT * FROM salary_details WHERE month='$month' AND year= '$year'")->row();
    }

    public function get_salary_details_by_year($year, $employee_id)
    {
        if ($employee_id > 0) {
            $query = $this->db->query("SELECT * FROM salary_details WHERE year='$year' AND employee_id=$employee_id")->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('year' => $year))->result();
        }
        return $query;
    }
}
