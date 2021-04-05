<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Warning_letter extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Warning_letter_Model');
    }

    public function index() {  // Load Employee Leave
        if (get_user_permission('hr/warning_letter') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = "Warning Letter";
        $this->data['employee_list'] = $this->Employee_Model->get_employee();
        $this->data['warning_type_list'] = $this->get_warning_types();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('hr/warning_letter/warning_letter', $this->data);
    }

    public function warning_letter_save() {
        if (get_user_permission('hr/warning_letter') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = "Warning Letter Save";
        $this->data['employee_list'] = $this->Employee_Model->get_employee();
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id']; // session user id        
        $warning_letter_data = array(
            'employee_id' => trim($this->input->post('employee_id')),
            'warning_date' => trim($this->input->post('warning_date')),
            'warning_type_id' => trim($this->input->post('warning_type_id')),
            'warning_details' => trim($this->input->post('warning_details')),
            'user_id' => $user_id,
            'current_date_time' => get_current_date_and_time(),
        );
        $this->form_validation->set_rules('employee_id', 'Employee Name', 'required');
        $this->form_validation->set_rules('warning_date', 'warning Date', 'required');
        $this->form_validation->set_rules('warning_type_id', 'Warning Type', 'required');
        $this->form_validation->set_rules('warning_details', 'Warning Details', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->data['title'] = "Warning Letter";
            $this->data['employee_list'] = $this->Employee_Model->get_employee();
            $this->data['warning_type_list'] = $this->get_warning_types();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('hr/warning_letter/warning_letter', $this->data);
        } else {
            $this->Warning_letter_Model->db->insert('warning_letter', $warning_letter_data);
            $this->session->set_flashdata('warning_letter_save_success_message', 'Information has been saved Successfully');
            redirect(base_url('hr/warning_letter'));
        }
    }

    public function get_warning_types() {
        $warning_type_list = $this->db->query("SELECT * FROM warning_type;")->result();
        return $warning_type_list;
    }

}
