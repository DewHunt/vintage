<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_mr_Model extends CI_Model {

    public $table_name = 'edit_mr';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_edit_mr($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_edit_mr($id = 0) {
        $this->load->helper('url');
        $data = array(
            'dealer_name' => $this->input->post('dealer_name'),
            'dealer_code' => $this->input->post('dealer_code'),
            'address' => $this->input->post('address'),
            'cell_number' => $this->input->post('cell_number'),
            'phone_number' => $this->input->post('phone_number'),
            'email' => $this->input->post('email'),
        );
        if ($id === 0) {
            return $this->db->insert($this->table_name, $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update($this->table_name, $data);
        }
    }
}
