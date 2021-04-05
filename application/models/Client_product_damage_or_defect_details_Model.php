<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_product_damage_or_defect_details_Model extends CI_Model {

    public $table_name = 'client_product_damage_or_defect_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_client_product_damage_or_defect_details($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_client_product_damage_or_defect_details($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'product_id' => $this->input->post('product_id'),
            'quantity' => $this->input->post('quantity'),
            'unit_price' => $this->input->post('unit_price'),
            'client_product_damage_or_defect_info_id' => $this->input->post('client_product_damage_or_defect_info_id'),
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
        $this->db->delete('client_product_damage_or_defect_details');
    }

    public function get_client_product_damage_or_defect_details_by_client_product_damage_or_defect_id($id) {
        $query = $this->db->query("SELECT cpddd.id, cpddd.product_id, cpddd.quantity, cpddd.unit_price, cpddd.client_product_damage_or_defect_info_id, p.product_name, p.product_code, p.pack_size FROM client_product_damage_or_defect_details cpddd LEFT JOIN product p ON cpddd.product_id=p.id WHERE cpddd.client_product_damage_or_defect_info_id='$id'")->result();
        return $query;
    }

}
