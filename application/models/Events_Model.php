<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Events_Model extends CI_Model {

    public $table_name = 'events';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_events($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_events($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'color' => $this->input->post('color'),
            'date' => $this->input->post('date'),
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

    public function get_holidays_settings($id = 0) {
        if ($id == 0) {
            $result = $this->db->query("SELECT * FROM events WHERE user_id = 0 ")->result();
            return $result;
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function get_holiday_event_exists($event_date) {
        $query_result = $this->db->get_where($this->table_name, array('date' => $event_date));
        return $query_result->row();
    }

    public function get_holiday_event_exists_for_update($event_date, $id) {
        $query_result = $this->db->query("SELECT * FROM events WHERE date = '$event_date' AND id != $id")->row();
        return $query_result;
    }

    public function get_events_by_year($year, $user_id = 0) {
        $query_result = $this->db->query("SELECT * FROM events WHERE date LIKE '%$year%' AND user_id = '$user_id'");
        return $query_result->result();
    }

}
