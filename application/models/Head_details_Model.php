<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Head_details_Model extends CI_Model {

    public $table_name = 'head_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_head_details($id = 0) {
        if ($id === 0) {
            /* $query = $this->db->get_where($this->table_name);
              return $query->result(); */
            $this->db->from($this->table_name);
            $this->db->order_by("head_name", "asc");
            $this->db->where('is_active', '1');
            $query = $this->db->get();
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id, 'is_active' => '1'));
            return $query->row();
        }
    }

    public function save_head_details($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'head_name' => $this->input->post('head_name'),
            'head_type' => $this->input->post('head_type'),
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

    public function get_income_head_details() {
        return $result = $this->db->query("SELECT * FROM head_details WHERE (head_type='both' OR head_type = 'cr') AND is_active = '1' ORDER BY head_name ASC")->result();
    }

    public function get_expense_head_details() {
        return $result = $this->db->query("SELECT * FROM head_details WHERE (head_type='both' OR head_type = 'dr') AND is_active = '1' ORDER BY head_name ASC")->result();
    }

    public function get_head_details_head_name($head_name) {
        return $result = $this->db->query("SELECT * FROM head_details WHERE head_name = '$head_name'")->row();
    }

    public function get_head_details_by_head_details_id_for_duplicate_check($head_name, $id) {
        return $result = $this->db->query("SELECT * FROM head_details WHERE head_name='$head_name' AND id != $id")->row();
    }

    public function get_head_details_by_head_type($head_type) {
        $query = $this->db->get_where($this->table_name, array('head_type' => $head_type, 'is_active' => '1'));
        return $query->result();
    }

}
