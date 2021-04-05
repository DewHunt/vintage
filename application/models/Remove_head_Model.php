<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Remove_head_model extends CI_Model {

    public $table_name = 'remove_head';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_remove_head($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
    }

    public function get_remove_head_by_head_id($head_id) {
        $query = $this->db->get_where($this->table_name, array('head_id' => $head_id));
        return $query->row();
    }

}
