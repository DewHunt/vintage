<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Return_product_details_Model extends CI_Model {

    public $table_name = 'return_product_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_return_product_details($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->row();  // get single company information
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_return_product_details($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'product_id' => $this->input->post('product_id'),
            'packsize' => $this->input->post('packsize'),
            'quantity' => $this->input->post('quantity'),
            'purchase_price' => $this->input->post('purchase_price'),
            'return_product_info_id' => $this->input->post('return_product_info_id'),
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
        $this->db->delete('return_product_details');
    }

    public function get_return_product_details_by_return_product_info_id($id) {
        $query_result = $this->db->query("SELECT rpd.id, rpd.product_id, rpd.packsize, rpd.quantity, rpd.purchase_price, rpd.return_product_info_id, p.product_name, p.product_code FROM return_product_details rpd LEFT JOIN product p ON rpd.product_id=p.id WHERE rpd.return_product_info_id='$id'")->result();
        return $query_result;
    }

}
