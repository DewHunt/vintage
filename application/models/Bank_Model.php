<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_Model extends CI_Model {

    public $table_name = 'bank_info';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_bank($id = 0) {
        if ($id === 0) {
            /* $query = $this->db->get_where($this->table_name);
              return $query->result(); */
            $this->db->from($this->table_name);
            $this->db->order_by("bank_name", "asc");
            $query = $this->db->get();
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_bank($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'bank_name' => $this->input->post('bank_name'),
            'branch_name' => $this->input->post('branch_name'),
            'branch_location' => $this->input->post('branch_location'),
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

    function is_bank_name_exists($bank_name) {
        return $result = $this->db->get_where($this->table_name, array('bank_name' => $bank_name))->row();
    }

    function get_bank_by_id_for_duplicate_check($name, $id) {
        return $result = $this->db->query("SELECT * FROM bank_info WHERE bank_name = '$name' AND id != $id")->row();
    }

    function is_bank_branch_name_exists($bank_name, $branch_name) {
        $query_result = $this->db->query("SELECT * FROM bank_info WHERE bank_name = '$bank_name' AND branch_name = '$branch_name'");
        return $query_result->row();
    }

    function is_bank_branch_name_exists_check_for_update($bank_name, $branch_name, $id) {
        $query_result = $this->db->query("SELECT * FROM bank_info WHERE bank_name = '$bank_name' AND branch_name = '$branch_name' AND id != $id");
        return $query_result->row();
    }

    public function get_all_distinct_bank_name() {
        $query_result = $this->db->query("SELECT DISTINCT bank_name FROM bank_info");
        return $query_result->result();
    }

    public function get_all_branches_by_bank($bank_name) {
        $query = $this->db->get_where($this->table_name, array('bank_name' => $bank_name));
        return $query->result();
    }

}
