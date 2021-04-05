<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Yearend_head_assign_Model extends CI_Model {

    public $table_name = 'yearend_head_assign';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_yearend_head_assign($id = 0) {
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

    public function is_exists_yearend_head_assign($opening_head_id, $closing_head_id) {
        $query_result = $this->db->query("SELECT * FROM $this->table_name WHERE (opening_head_id = $opening_head_id OR closing_head_id = $opening_head_id) OR (opening_head_id = $closing_head_id OR closing_head_id = $closing_head_id)")->row();
        return $result = !empty($query_result) ? TRUE : FALSE;
    }

}
