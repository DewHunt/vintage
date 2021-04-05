<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Challan_product_Model extends CI_Model {

    public $table_name = 'challan_product';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_challan_product($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_challan_product($id = 0) {
        $this->load->helper('url');
        $data = array(
            'product_id' => $this->input->post('product_id'),
            'branch_id' => $this->input->post('branch_id'),
            'pack_size' => $this->input->post('pack_size'),
            'quantity' => $this->input->post('quantity'),
            'unit_price' => $this->input->post('unit_price'),
            'total_price' => $this->input->post('total_price'),
            'challan_id' => $this->input->post('challan_id'),
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

    public function get_challan_product_by_challan_id_and_product_id($challan_id, $product_id) {
        $query = $this->db->query("SELECT * FROM challan_product WHERE challan_id = '$challan_id' AND product_id = '$product_id'");
        return $query->row();
    }

    public function get_challan_product_by_challan_id($challan_id) {
        $query = $this->db->query("SELECT * FROM challan_product WHERE challan_id = '$challan_id'");
        return $query->result();
    }

    public function get_challan_product_list_show($id = 0) {
        return $challan_product_list = $this->db->query("SELECT c.id, c.challan_id, c.pack_size, c.quantity, c.total_price, p.product_name FROM challan_product c LEFT JOIN product p ON c.product_id=p.id WHERE c.challan_id='$id'")->result();
    }

}
