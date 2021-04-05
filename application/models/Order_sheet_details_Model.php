<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order_sheet_details_Model extends CI_Model {

    public $table_name = 'order_sheet_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_order_sheet_details($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_order_sheet_details($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'product_id' => $this->input->post('product_id'),
            'pack_size' => $this->input->post('pack_size'),
            'quantity' => $this->input->post('quantity'),
            'unit_price' => $this->input->post('unit_price'),
            'amount' => $this->input->post('amount'),
            'order_sheet_id' => $this->input->post('order_sheet_id'),
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

    public function get_order_sheet_details_by_order_sheet_id($order_sheet_id) {
        $query = $this->db->get_where($this->table_name, array('order_sheet_id' => $order_sheet_id));
        return $query->result();
    }

}
