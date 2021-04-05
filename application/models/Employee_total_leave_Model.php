<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_total_leave_Model extends CI_Model {

    public $table_name = 'employee_total_leave';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_employee_leave($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_employee_leave($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'employee_id' => $this->input->post('employee_id'),
            'year' => $this->input->post('year'),
            'total_casual_leave' => $this->input->post('total_casual_leave'),
            'total_medical_leave' => $this->input->post('total_medical_leave'),
            'total_earn_leave' => $this->input->post('total_earn_leave'),
            'paid_casual_leave' => $this->input->post('paid_casual_leave'),
            'paid_medical_leave' => $this->input->post('paid_medical_leave'),
            'paid_earn_leave' => $this->input->post('paid_earn_leave'),
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

    public function get_employee_total_leave_by_current_year($employee_id, $current_year) {
        $query = $this->db->query("SELECT * FROM employee_total_leave WHERE employee_id = $employee_id AND year = '$current_year'");
        return $query->row();
    }

    public function get_leave_information_ability($employee_id, $leave_type, $total_day) {
        $current_year = get_current_year();
        $employee_total_leave_by_current_year = $this->get_employee_total_leave_by_current_year($employee_id, $current_year);
        if ((!empty($employee_total_leave_by_current_year))) {
            $remain_casual_leave = (((int) $employee_total_leave_by_current_year->total_casual_leave) - ((int) $employee_total_leave_by_current_year->paid_casual_leave));
            $remain_medical_leave = (((int) $employee_total_leave_by_current_year->total_medical_leave) - ((int) $employee_total_leave_by_current_year->paid_medical_leave));
            $remain_earn_leave = (((int) $employee_total_leave_by_current_year->total_earn_leave) - ((int) $employee_total_leave_by_current_year->paid_earn_leave));
            if (strtolower($leave_type) == 'casual') {
                if ((int) $remain_casual_leave < (int) $total_day) {
                    return FALSE;
                }
                return TRUE;
            }
            if (strtolower($leave_type) == 'medical') {
                if ((int) $remain_medical_leave < (int) $total_day) {
                    return FALSE;
                }
                return TRUE;
            }
            if (strtolower($leave_type) == 'earn') {
                if ((int) $remain_earn_leave < (int) $total_day) {
                    return FALSE;
                }
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

}
