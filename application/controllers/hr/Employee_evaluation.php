<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_evaluation extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Employee_evaluation_Model');
    }

    public function index() {  // Load Employee Leave
        if (get_user_permission('hr/employee_evaluation') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = "Employee Evaluation";
        $this->data['employee_list'] = $this->Employee_Model->get_employee();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('hr/employee_evaluation/employee_evaluation', $this->data);
    }

    public function employee_evaluation_save() {
        if (get_user_permission('hr/employee_evaluation') === false) {
            redirect(base_url('user_login'));
        }
        
        $this->data['title'] = "Employee Evaluation Save";
        $this->data['employee_list'] = $this->Employee_Model->get_employee();
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id']; // session user id
        $job_knowledge_rating = (int) trim($this->input->post('job_knowledge_rating'));
        $work_quality_rating = (int) trim($this->input->post('work_quality_rating'));
        $attendance_punctuality_rating = (int) trim($this->input->post('attendance_punctuality_rating'));
        $communication_listening_skills_rating = (int) trim($this->input->post('communication_listening_skills_rating'));
        $dependability_rating = (int) trim($this->input->post('dependability_rating'));

        $check_result = $this->check_valid_evaluation($job_knowledge_rating, $work_quality_rating, $attendance_punctuality_rating, $communication_listening_skills_rating, $dependability_rating);
        if ($check_result) {
            $employee_evaluation_data = array(
                'employee_id' => trim($this->input->post('employee_id')),
                'start_date' => trim($this->input->post('start_date')),
                'end_date' => trim($this->input->post('end_date')),
                'job_knowledge_rating' => $job_knowledge_rating,
                'job_knowledge_comments' => trim($this->input->post('job_knowledge_comments')),
                'work_quality_rating' => $work_quality_rating,
                'work_quality_comments' => trim($this->input->post('work_quality_comments')),
                'attendance_punctuality_rating' => $attendance_punctuality_rating,
                'attendance_punctuality_comments' => trim($this->input->post('attendance_punctuality_comments')),
                'communication_listening_skills_rating' => $communication_listening_skills_rating,
                'communication_listening_skills_comments' => trim($this->input->post('communication_listening_skills_comments')),
                'dependability_rating' => $dependability_rating,
                'dependability_comments' => trim($this->input->post('dependability_comments')),
                'overall_rating' => trim($this->input->post('overall_rating')),
//                'average_rating' => $average_rating,
                'additional_comments' => trim($this->input->post('additional_comments')),
                'user_id' => $user_id,
                'current_date_time' => get_current_date_and_time(),
            );
            $this->form_validation->set_rules('employee_id', 'Employee Name', 'required');
            $this->form_validation->set_rules('start_date', 'Start Date', 'required');
            $this->form_validation->set_rules('end_date', 'End Date', 'required');
            $this->form_validation->set_rules('job_knowledge_rating', 'Job knowledge rating', 'required');
            $this->form_validation->set_rules('work_quality_rating', 'Work quality rating', 'required');
            $this->form_validation->set_rules('attendance_punctuality_rating', 'Attendance punctuality rating', 'required');
            $this->form_validation->set_rules('communication_listening_skills_rating', 'Communication listening skills rating', 'required');
            $this->form_validation->set_rules('dependability_rating', 'Dependability rating', 'required');
            $this->form_validation->set_rules('overall_rating', 'Overall rating', 'required');
//            $this->form_validation->set_rules('average_rating', 'Average rating', 'required');

            if ($this->form_validation->run() === FALSE) {
                $this->data['title'] = "Employee Evaluation";
                $this->data['employee_list'] = $this->Employee_Model->get_employee();
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('hr/employee_evaluation/employee_evaluation', $this->data);
            } else {
                $all_rating = (int) ($job_knowledge_rating + $work_quality_rating + $attendance_punctuality_rating + $communication_listening_skills_rating + $dependability_rating);
                $average_rating = ($all_rating / 5);
                $employee_evaluation_data['average_rating'] = $average_rating;
                $this->Employee_evaluation_Model->db->insert('employee_evaluation', $employee_evaluation_data);
                $this->session->set_flashdata('employee_evaluation_save_success_message', 'Information has been saved Successfully');
                redirect(base_url('hr/employee_evaluation'));
            }
        } else {
            $this->session->set_flashdata('employee_evaluation_save_error_message', 'Please Evaluate with a valid evaluation point');
            redirect(base_url('hr/employee_evaluation'));
        }
    }

    public function check_valid_evaluation($job_knowledge_rating, $work_quality_rating, $attendance_punctuality_rating, $communication_listening_skills_rating, $dependability_rating) {
        if (!$this->check_valid_evaluation_with_evaluation_name($job_knowledge_rating)) {
            return FALSE;
        }
        if (!$this->check_valid_evaluation_with_evaluation_name($work_quality_rating)) {
            return FALSE;
        }
        if (!$this->check_valid_evaluation_with_evaluation_name($attendance_punctuality_rating)) {
            return FALSE;
        }
        if (!$this->check_valid_evaluation_with_evaluation_name($communication_listening_skills_rating)) {
            return FALSE;
        }
        if (!$this->check_valid_evaluation_with_evaluation_name($dependability_rating)) {
            return FALSE;
        }
        return TRUE;
    }

    public function check_valid_evaluation_with_evaluation_name($evaluation_name) {
        if ((int) $evaluation_name <= 0 || (int) $evaluation_name > 5) {
            return FALSE;
        }
        return TRUE;
    }

}
