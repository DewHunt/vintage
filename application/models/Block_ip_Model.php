<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Block_ip_Model extends CI_Model {

    public $table_name = 'block_ip';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_block_ip($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_block_ip($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => trim($this->input->post('id')),
            'ip_address' => trim($this->input->post('ip_address')),
            'login_log_details_id' => trim($this->input->post('login_log_details_id')),
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

    public function get_block_ip_by_ip_address($ip_address) {
        $query_result = $this->db->get_where($this->table_name, array('ip_address' => $ip_address));
        return $query_result->row();
    }

    public function is_ip_block($ip_address) {
        $query_result = $this->db->get_where($this->table_name, array('ip_address' => $ip_address))->row();
        return !empty($query_result) ? TRUE : FALSE;
    }

}
