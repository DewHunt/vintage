<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_application_Model extends CI_Model {

    public $table_name = 'leave_application';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_leave_application($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_leave_application($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'employee_id' => trim($this->input->post('employee_id')),
            'start_date' => trim($this->input->post('start_date')),
            'end_date' => trim($this->input->post('end_date')),
            'total_day' => trim($this->input->post('total_day')),
            'leave_type' => trim($this->input->post('leave_type')),
            'address' => trim($this->input->post('address')),
            'contact_no' => trim($this->input->post('contact_no')),
            'leave_details' => trim($this->input->post('leave_details')),
            'application_status' => trim($this->input->post('application_status')),
            'accept_reject_employee_id' => trim($this->input->post('accept_reject_employee_id')),
            'current_date_time' => get_current_date_and_time(),
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

    public function get_leave_application_by_application_status($application_status) {
        $query = $this->db->get_where($this->table_name, array('application_status' => $application_status));
        return $query->result();
    }

    public function get_leave_application_by_is_show($is_show_status) {
        $query = $this->db->query("SELECT la.id, la.employee_id, la.start_date, la.end_date, la.total_day, la.leave_type, la.address, la.contact_no, la.leave_details, la.application_status, la.accept_reject_employee_id, la.current_date_time, la.user_id, la.is_show, la.reason, e.employee_name, e.employee_code, e.employee_email, e.designation, e.mobile, u.user_name, u.user_type FROM leave_application la LEFT JOIN  employee_info e ON la.employee_id = e.id LEFT JOIN user_info u ON la.user_id = u.id WHERE la.is_show = '$is_show_status'");
        return $query->result();
    }

    public function get_leave_application_by_leave_application_id($leave_application_id) {
        $query = $this->db->query("SELECT la.id, la.employee_id, la.start_date, la.end_date, la.total_day, la.leave_type, la.address, la.contact_no, la.leave_details, la.application_status, la.accept_reject_employee_id, la.current_date_time, la.user_id, la.is_show, la.reason, e.employee_name, e.employee_code, e.employee_email, e.designation, e.mobile, u.user_name, u.user_type FROM leave_application la LEFT JOIN  employee_info e ON la.employee_id = e.id LEFT JOIN user_info u ON la.user_id = u.id WHERE la.id = '$leave_application_id'");
        return $query->row();
    }

    public function get_leave_application_by_employee_year_status($employee_id, $year, $application_status) {
        if (strtolower($application_status) == 'all' || empty($application_status)) {
            $where_condition = "WHERE la.employee_id = '$employee_id' AND YEAR(la.start_date) = '$year'";
        } else {
            $where_condition = "WHERE la.employee_id = '$employee_id' AND YEAR(la.start_date) = '$year' AND la.application_status = '$application_status'";
        }
        $query = $this->db->query("SELECT la.id, la.employee_id, la.start_date, la.end_date, la.total_day, la.leave_type, la.address, la.contact_no, la.leave_details, la.application_status, la.accept_reject_employee_id, la.current_date_time, la.user_id, la.is_show, la.reason, e.employee_name, e.employee_code, e.employee_email, e.designation, e.mobile, u.user_name, u.user_type FROM leave_application la LEFT JOIN  employee_info e ON la.employee_id = e.id LEFT JOIN user_info u ON la.user_id = u.id $where_condition");
        return $query->result();
    }

}
