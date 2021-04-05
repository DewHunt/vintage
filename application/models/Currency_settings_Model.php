<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Currency_settings_Model extends CI_Model {

    public $table_name = 'currency_settings';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_currency_settings($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            //return $query->result();
            return $query->row();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_currency_settings($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'currency_symbol' => $this->input->post('currency_symbol'),
            'currency_name' => $this->input->post('currency_name'),
            'placement' => $this->input->post('placement'),
        );
        if ($id === 0) {
            return $this->db->insert($this->table_name, $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update($this->table_name, $data);
        }
    }

}
