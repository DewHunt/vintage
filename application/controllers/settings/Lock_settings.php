<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lock_settings extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Lock_time_Model');
        $this->load->model('Lock_user_Model');
    }

    public function index() {  // load assets details
        if (get_user_permission('settings/lock_settings') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "Lock Settings";
        $this->data['employee_list'] = $this->Employee_Model->get_employee();
        $this->data['user_list'] = $this->User_Model->get_user();
        $this->get_all_lock_day_name();
        $this->data['lock_user_list'] = $this->Lock_user_Model->get_lock_user();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('settings/lock_settings/lock_settings', $this->data);
    }

    public function get_all_lock_day_name() {
        $this->data['sunday_lock_time'] = $this->Lock_time_Model->get_lock_time_by_day_name('sunday');
        $this->data['monday_lock_time'] = $this->Lock_time_Model->get_lock_time_by_day_name('monday');
        $this->data['tuesday_lock_time'] = $this->Lock_time_Model->get_lock_time_by_day_name('tuesday');
        $this->data['wednesday_lock_time'] = $this->Lock_time_Model->get_lock_time_by_day_name('wednesday');
        $this->data['thursday_lock_time'] = $this->Lock_time_Model->get_lock_time_by_day_name('thursday');
        $this->data['friday_lock_time'] = $this->Lock_time_Model->get_lock_time_by_day_name('friday');
        $this->data['saturday_lock_time'] = $this->Lock_time_Model->get_lock_time_by_day_name('saturday');
    }

    public function save_lock_settings() {
        if (get_user_permission('settings/lock_settings') === false) {
            redirect(base_url('user_login'));
        }
        $this->Lock_time_Model->delete_all_from_lock_time();
        $this->Lock_user_Model->delete_all_from_lock_user();

        $lock_settings_array = $this->get_lock_settings_information_array();
        if (!empty($lock_settings_array)) {
            foreach ($lock_settings_array as $lock_settings) {
                if (!empty($lock_settings['start_time']) && (!empty($lock_settings['end_time']))) {
                    $this->Lock_time_Model->db->insert('lock_time', $lock_settings);
                }
            }
        }

        $user_id_list = $this->input->post('user_id_list');
        if (!empty($user_id_list)) {
            foreach ($user_id_list as $user_id) {
                $data = array(
                    'user_id' => $user_id
                );
                $this->Lock_user_Model->db->insert('lock_user', $data);
            }
        }
        $this->session->set_flashdata('lock_settings_success_message', 'Lock settings has been updated successfully.');
        redirect(base_url('settings/lock_settings'));
    }

    public function get_lock_settings_information_array() {
        $lock_settings_array = array();
        
        $sunday_array = array(
            'day_name' => 'sunday',
            'start_time' => trim($this->input->post('sunday_start_time')),
            'end_time' => trim($this->input->post('sunday_end_time')),
        );
        array_push($lock_settings_array, $sunday_array);

        $monday_array = array(
            'day_name' => 'monday',
            'start_time' => trim($this->input->post('monday_start_time')),
            'end_time' => trim($this->input->post('monday_end_time')),
        );
        array_push($lock_settings_array, $monday_array);

        $tuesday_array = array(
            'day_name' => 'tuesday',
            'start_time' => trim($this->input->post('tuesday_start_time')),
            'end_time' => trim($this->input->post('tuesday_end_time')),
        );
        array_push($lock_settings_array, $tuesday_array);

        $wednesday_array = array(
            'day_name' => 'wednesday',
            'start_time' => trim($this->input->post('wednesday_start_time')),
            'end_time' => trim($this->input->post('wednesday_end_time')),
        );
        array_push($lock_settings_array, $wednesday_array);

        $thursday_array = array(
            'day_name' => 'thursday',
            'start_time' => trim($this->input->post('thursday_start_time')),
            'end_time' => trim($this->input->post('thursday_end_time')),
        );
        array_push($lock_settings_array, $thursday_array);

        $friday_array = array(
            'day_name' => 'friday',
            'start_time' => trim($this->input->post('friday_start_time')),
            'end_time' => trim($this->input->post('friday_end_time')),
        );
        array_push($lock_settings_array, $friday_array);

        $saturday_array = array(
            'day_name' => 'saturday',
            'start_time' => trim($this->input->post('saturday_start_time')),
            'end_time' => trim($this->input->post('saturday_end_time')),
        );
        array_push($lock_settings_array, $saturday_array);

        return $lock_settings_array;
    }

}
