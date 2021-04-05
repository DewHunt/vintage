<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Damage_or_defect_product_details_Model extends CI_Model {

    public $table_name = 'damage_or_defect_product_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_damage_or_defect_product_details($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->row();  // get single company information
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_damage_or_defect_product_details($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'product_id' => $this->input->post('product_id'),
            'packsize' => $this->input->post('packsize'),
            'quantity' => $this->input->post('quantity'),
            'purchase_price' => $this->input->post('purchase_price'),
            'damage_or_defect_product_info_id' => $this->input->post('damage_or_defect_product_info_id'),
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
        $this->db->delete('damage_or_defect_product_details');
    }

    public function get_damage_or_defect_product_details_by_damage_or_defect_product_info_id($id) {
        $query_result = $this->db->query("SELECT ddpd.id, ddpd.product_id, ddpd.packsize, ddpd.quantity, ddpd.purchase_price, ddpd.damage_or_defect_product_info_id, p.product_name, p.product_code FROM damage_or_defect_product_details ddpd LEFT JOIN product p ON ddpd.product_id=p.id WHERE ddpd.damage_or_defect_product_info_id=$id")->result();
        return $query_result;
    }

}
