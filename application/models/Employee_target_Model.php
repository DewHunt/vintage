<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_target_Model extends CI_Model {

    public $table_name = 'employee_target';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_employee_target($id = 0) {
        if ($id === 0) {
            return $this->db->query("SELECT et1.*, e.employee_name, e.employee_code FROM employee_target et1 LEFT JOIN employee_target et2 ON (et1.employee_id = et2.employee_id AND et1.id < et2.id) LEFT JOIN employee_info e ON et1.employee_id = e.id WHERE et2.id IS NULL")->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
    }

    public function get_employee_target_by_employee_id($employee_id) {
        $query = $this->db->get_where($this->table_name, array('employee_id' => $employee_id));
        return $query->result();
    }

    public function get_last_target_by_employee_id($employee_id) {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get_where($this->table_name, array('employee_id' => $employee_id));
        return $query->row();
    }

    public function get_employee_target_amount_by_date($start_date, $end_date, $employee_id) {
        $start_date = get_start_date_format($start_date);
        $end_date = get_end_date_format($end_date);
        $query = $this->db->query("SELECT * FROM employee_target WHERE employee_id = '$employee_id' AND ((target_start_date BETWEEN '$start_date' AND '$end_date')
OR (target_end_date BETWEEN '$start_date' AND '$end_date'))")->row();
//        $query = $this->db->query("SELECT * FROM $this->table_name WHERE target_start_date >= '$start_date' AND target_end_date <= '$end_date' AND employee_id = '$employee_id' ORDER BY id ASC LIMIT 1")->row();
        return !empty($query) ? get_floating_point_number($query->target_amount) : 0;
    }

}
