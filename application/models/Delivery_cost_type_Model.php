<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_cost_type_Model extends CI_Model {

    public $table_name = 'delivery_cost_type';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_delivery_cost_type($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_delivery_cost_type($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'delivery_cost_name' => $this->input->post('delivery_cost_name'),
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

    public function get_delivery_cost_type_by_delivery_cost_name($delivery_cost_name) {
        $query = $this->db->get_where($this->table_name, array('delivery_cost_name' => $delivery_cost_name));
        return $query->row();
    }

    public function is_delivery_cost_type_exists($delivery_cost_name, $id = 0) {
        $wehere_condition = ((intval($id)) > 0) ? "delivery_cost_name = '$delivery_cost_name' AND id != $id" : "delivery_cost_name = '$delivery_cost_name'";
        $query = $this->db->query("SELECT * FROM $this->table_name WHERE $wehere_condition")->row();
        return (!empty($query)) ? TRUE : FALSE;
    }

    public function get_delivery_cost_name_by_id($delivery_cost_type_id) {
        $delivery_cost_name = '';
        if (intval($delivery_cost_type_id) > 0) {
            $result = $this->get_delivery_cost_type($delivery_cost_type_id);
            $delivery_cost_name = !empty($result) ? $result->delivery_cost_name : '';
        }
        return $delivery_cost_name;
    }

}
