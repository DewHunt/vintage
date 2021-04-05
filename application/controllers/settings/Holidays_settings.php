<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Holidays_settings extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Weekend_settings_Model');
        $this->load->model('User_Model');
        $this->load->model('Calendar_Model');
        $this->load->model('Events_Model');
    }

    public function index() {  // load holidays details
        if (get_user_permission('settings/holidays_settings') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = "Weekend Settings";
        $year = !empty(trim($this->input->post('year'))) ? trim($this->input->post('year')) : get_current_year();
        // $this->data['holidays_settings_list'] = $this->Events_Model->get_holidays_settings();
        $this->data['holidays_settings_list'] = $this->get_all_events_by_year($year);
        $event_show_year_session = $this->session->userdata('event_show_year_session');
        $this->get_event_show_year_session_clear();
        $this->data['event_show_year_session'] = !empty($event_show_year_session) ? $event_show_year_session : get_current_year();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('settings/holidays_settings/holidays_settings_details', $this->data);
    }

    public function get_all_events_by_year($year) {
        $this->session->set_userdata('event_show_year_session', $year);
        $events_by_year_list = $this->Events_Model->get_events_by_year($year);
        return $events_by_year_list;
    }

    public function get_event_show_year_session_clear() {
        $this->session->unset_userdata('event_show_year_session');
    }

    public function create_holidays_settings() { // load create new holidays settings page
        if (get_user_permission('settings/holidays_settings') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = "Create Holidays Settings";
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('settings/holidays_settings/create_holidays_settings', $this->data);
    }

    public function save_holidays_settings() {  // save Holiday information
        if (get_user_permission('settings/holidays_settings') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = 'Save Holidays Settings';
        $title = trim($this->input->post('title'));
        $description = trim($this->input->post('description'));
        $event_date = trim($this->input->post('event_date'));
        $event_color = '#FF0000';  // red
        $event_date_exists = $this->Events_Model->get_holiday_event_exists($event_date);
        if ((empty($event_date_exists))) {
            $data = array(
                'title' => $title,
                'description' => $description,
                'color' => $event_color,
                'date' => $event_date,
                'user_id' => 0,
            );
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('event_date', 'Date', 'required');
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('settings/holidays_settings/create_holidays_settings', $this->data);
            } else {
                $this->Events_Model->db->insert('events', $data);
                redirect(base_url('settings/holidays_settings'));
            }
        } else {
            $this->session->set_flashdata('holiday_duplicate_error_message', 'Holiday Already Exists.');
            redirect(base_url('settings/holidays_settings/create_holidays_settings'));
        }
    }

    public function update_holidays_settings($id = 0) {  // load update holidays Settings page
        if (get_user_permission('settings/holidays_settings') === false) {
            redirect(base_url('user_login'));
        }
        $holidays_settings = $this->Events_Model->get_holidays_settings($id);
        if (!empty($holidays_settings)) {
            $this->data['title'] = "Update Holidays Settings";
            $this->data['holidays_settings'] = $holidays_settings;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('settings/holidays_settings/update_holidays_settings', $this->data);
        } else {
            redirect(base_url('settings/holidays_settings'));
        }
    }

    public function update() {  // update Holidays Head
        if (get_user_permission('settings/holidays_settings') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = 'Update Holidays Settings';
        $id = $this->input->post('id');
        $title = trim($this->input->post('title'));
        $description = trim($this->input->post('description'));
        $event_date = trim($this->input->post('event_date'));
        $event_color = '#FF0000';   // red
        $user_id = 0;
        $holidays_settings = $this->Events_Model->get_holidays_settings($id);
        $this->data['holidays_settings'] = $holidays_settings;
        $holiday_event_exists_for_update = $this->Events_Model->get_holiday_event_exists_for_update($event_date, $id);
        if ((empty($holiday_event_exists_for_update))) {
            $events_data = array(
                'id' => $id,
                'title' => $title,
                'description' => $description,
                'color' => $event_color,
                'date' => $event_date,
                'user_id' => $user_id,
            );
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('event_date', 'Date', 'required');
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('settings/holidays_settings/update_holidays_settings', $this->data);
            } else {
                $this->db->where('id', $events_data['id']);
                $this->Events_Model->db->update('events', $events_data);
                redirect(base_url('settings/holidays_settings'));
            }
        } else {
            $this->session->set_flashdata('holiday_duplicate_error_message', 'Weekend Day Already Exists.');
            redirect(base_url('settings/holidays_settings/update_holidays_settings/' . $id));
        }
    }

    public function delete($id) { // delete holiday information
        if (get_user_permission('settings/holidays_settings') === false) {
            redirect(base_url('user_login'));
        }
        $this->Events_Model->delete($id);
        redirect(base_url('settings/holidays_settings'));
    }

}
