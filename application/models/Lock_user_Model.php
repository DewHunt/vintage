<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lock_user_Model extends CI_Model {

    public $table_name = 'lock_user';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_lock_user($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_lock_user($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
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

    public function delete_all_from_lock_user() {
        $this->db->query("DELETE FROM lock_user");
    }

    public function get_lock_user_by_user_id($user_id) {
        $query = $this->db->get_where($this->table_name, array('user_id' => $user_id));
        return $query->row();
    }

}
