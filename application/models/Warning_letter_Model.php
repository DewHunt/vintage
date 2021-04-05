<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Warning_letter_Model extends CI_Model {

    public $table_name = 'warning_letter';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_warning_letter($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_warning_letter($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => trim($this->input->post('id')),
            'employee_id' => trim($this->input->post('employee_id')),
            'warning_date' => trim($this->input->post('warning_date')),
            'warning_type_id' => trim($this->input->post('warning_type_id')),
            'warning_details' => trim($this->input->post('warning_details')),
            'user_id' => trim($this->input->post('user_id')),
            'current_date_time' => trim($this->input->post('current_date_time')),
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

    public function get_warning_letter_by_employee($employee_id) {
        if ((int) $employee_id > 0) {
            $where_condition = "WHERE wl.employee_id = '$employee_id'";
        } else {
            $where_condition = "";
        }
        $query_result = $this->db->query("SELECT wl.id, wl.employee_id, wl.warning_date, wl.warning_type_id, wl.warning_details, wl.user_id, wl.current_date_time, e.employee_name, e.employee_code, e.designation, e.mobile, wt.warning_type, u.name, u.user_type FROM warning_letter wl LEFT JOIN employee_info e ON wl.employee_id=e.id LEFT JOIN warning_type wt ON wl.warning_type_id=wt.id LEFT JOIN user_info u ON wl.user_id=u.id $where_condition");
        return $query_result->result();
    }

    public function get_warning_letter_by_warning_letter_id($warning_letter_id) {
        $query_result = $this->db->query("SELECT wl.id, wl.employee_id, wl.warning_date, wl.warning_type_id, wl.warning_details, wl.user_id, wl.current_date_time, e.employee_name, e.employee_code, e.designation, e.mobile, wt.warning_type, u.name, u.user_type FROM warning_letter wl LEFT JOIN employee_info e ON wl.employee_id=e.id LEFT JOIN warning_type wt ON wl.warning_type_id=wt.id LEFT JOIN user_info u ON wl.user_id=u.id WHERE wl.id='$warning_letter_id'");
        return $query_result->row();
    }

}
