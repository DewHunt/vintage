<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_log_details_Model extends CI_Model {

    public $table_name = 'login_log_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_login_log_details($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_login_log_details($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'login_time' => $this->input->post('login_time'),
            'logout_time' => $this->input->post('logout_time'),
            'user_id' => $this->input->post('user_id'),
            'user_name_or_email' => $this->input->post('user_name_or_email'),
            'ip_address' => $this->input->post('ip_address'),
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

    public function get_login_log_details_with_limit($limit) {
        $query = $this->db->query("SELECT * FROM login_log_details WHERE login_time > '0000-00-00 00:00:00' ORDER BY id DESC LIMIT $limit")->result();
        return $query;
    }

}
