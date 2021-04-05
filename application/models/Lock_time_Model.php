<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lock_time_Model extends CI_Model {

    public $table_name = 'lock_time';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_lock_time($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_lock_time($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'day_id' => $this->input->post('day_id'),
            'day_name' => $this->input->post('day_name'),
            'start_time' => $this->input->post('start_time'),
            'end_time' => $this->input->post('end_time'),
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

    public function delete_all_from_lock_time() {
        $this->db->query("DELETE FROM lock_time");
    }

    public function get_lock_time_by_day_name($day_name) {
        $query = $this->db->get_where($this->table_name, array('day_name' => $day_name));
        return $query->row();
    }

}
