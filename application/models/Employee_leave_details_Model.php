<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_leave_details_Model extends CI_Model
{
    public $table_name = 'employee_leave_details';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_employee_leave_details($id = 0)
    {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_employee_leave_details($id = 0)
    {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'employee_id' => $this->input->post('employee_id'),
            'leave_type' => $this->input->post('leave_type'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'total_day' => $this->input->post('total_day'),
            'comments' => $this->input->post('comments'),
            'entry_date' => $this->input->post('entry_date'),
            'user_id' => $this->input->post('user_id'),
            'employee_total_leave_id' => $this->input->post('employee_total_leave_id'),
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
        $this->db->delete('employee_leave_details');
    }

    public function get_employee_leave_details_by_propose_time($employee_id, $propose_time)
    {
        $query_result = $this->db->query("SELECT * FROM employee_leave_details WHERE employee_id = $employee_id AND '$propose_time' BETWEEN start_date AND COALESCE(end_date, NOW())")->row();
        return $query_result;
    }

    public function get_employee_leave_details_by_employee_id($employee_id)
    {
        $query = $this->db->get_where($this->table_name, array('employee_id' => $employee_id));
        return $query->result();
    }
}