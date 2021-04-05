<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_evaluation_Model extends CI_Model {

    public $table_name = 'employee_evaluation';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_employee_evaluation($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_employee_evaluation($id = 0) {
        $this->load->helper('url');
        $data = array(
            'employee_id' => trim($this->input->post('employee_id')),
            'start_date' => trim($this->input->post('start_date')),
            'end_date' => trim($this->input->post('end_date')),
            'job_knowledge_rating' => trim($this->input->post('job_knowledge_rating')),
            'job_knowledge_comments' => trim($this->input->post('job_knowledge_comments')),
            'work_quality_rating' => trim($this->input->post('work_quality_rating')),
            'work_quality_comments' => trim($this->input->post('work_quality_comments')),
            'attendance_punctuality_rating' => trim($this->input->post('attendance_punctuality_rating')),
            'attendance_punctuality_comments' => trim($this->input->post('attendance_punctuality_comments')),
            'communication_listening_skills_rating' => trim($this->input->post('communication_listening_skills_rating')),
            'communication_listening_skills_comments' => trim($this->input->post('communication_listening_skills_comments')),
            'dependability_rating' => trim($this->input->post('dependability_rating')),
            'dependability_comments' => trim($this->input->post('dependability_comments')),
            'overall_rating' => trim($this->input->post('overall_rating')),
            'average_rating' => trim($this->input->post('average_rating')),
            'additional_comments' => trim($this->input->post('additional_comments')),
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

    public function get_employee_evaluation_by_employee_and_year($year, $employee_id) {
        if ((int) $employee_id > 0) {
            $where_condition = "YEAR(current_date_time) = '$year' AND employee_id = '$employee_id'";
        } else {
            $where_condition = "YEAR(current_date_time) = '$year'";
        }
        $query_result = $this->db->query("SELECT ev.id, ev.employee_id, ev.start_date, ev.end_date, ev.job_knowledge_rating, ev.job_knowledge_comments, ev.work_quality_rating, ev.work_quality_comments, ev.attendance_punctuality_rating, ev.attendance_punctuality_comments, ev.communication_listening_skills_rating, ev.communication_listening_skills_comments, ev.dependability_rating, ev.dependability_comments, ev.overall_rating, ev.average_rating, ev.additional_comments, ev.user_id, ev.user_id, ev.current_date_time, e.employee_name, e.employee_code, e.designation, e.mobile, u.user_name, u.user_type FROM employee_evaluation ev LEFT JOIN employee_info e ON ev.employee_id=e.id LEFT JOIN user_info u ON ev.user_id=u.id WHERE $where_condition");
        return $query_result->result();
    }

    public function get_employee_evaluation_by_employee_evaluation_id($employee_evaluation_id) {
        $query_result = $this->db->query("SELECT ev.id, ev.employee_id, ev.start_date, ev.end_date, ev.job_knowledge_rating, ev.job_knowledge_comments, ev.work_quality_rating, ev.work_quality_comments, ev.attendance_punctuality_rating, ev.attendance_punctuality_comments, ev.communication_listening_skills_rating, ev.communication_listening_skills_comments, ev.dependability_rating, ev.dependability_comments, ev.overall_rating, ev.average_rating, ev.additional_comments, ev.user_id, ev.user_id, ev.current_date_time, e.employee_name, e.employee_code, e.designation, e.mobile, u.user_name, u.user_type FROM employee_evaluation ev JOIN employee_info e ON ev.employee_id=e.id LEFT JOIN user_info u ON ev.user_id=u.id WHERE ev.id = '$employee_evaluation_id'");
        return $query_result->row();
    }

}
