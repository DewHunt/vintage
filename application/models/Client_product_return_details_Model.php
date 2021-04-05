<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_product_return_details_Model extends CI_Model {

    public $table_name = 'client_product_return_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_client_product_return_details($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_client_product_return_details($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'product_id' => $this->input->post('product_id'),
            'quantity' => $this->input->post('quantity'),
            'unit_price' => $this->input->post('unit_price'),
            'client_product_return_info_id' => $this->input->post('client_product_return_info_id'),
        );
        if ($id === 0) {
            return $this->db->insert($this->table_name, $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update($this->table_name, $data);
        }
    }

    public function get_single_invoice_void_info_by_id($invoiceVoidId)
    {
        $result = $this->db->query("
            SELECT `client_product_return_details`.*,`product`.`product_name` AS `productName`
            FROM `client_product_return_details`
            LEFT JOIN `product` ON `product`.`id` = `client_product_return_details`.`product_id`
            WHERE `client_product_return_details`.`client_product_return_info_id` = $invoiceVoidId
        ")->result();
        
        return $result;
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
    }

    public function get_client_product_return_details_by_client_product_return_info_id($id) {
        $query_result = $this->db->query("SELECT cprd.id, cprd.product_id, cprd.quantity, cprd.unit_price, cprd.client_product_return_info_id, p.product_name, p.product_code, p.pack_size FROM client_product_return_details cprd LEFT JOIN product p ON cprd.product_id=p.id WHERE cprd.client_product_return_info_id='$id'")->result();
        return $query_result;
    }

    public function get_client_product_return_details_by_date_and_product($start_date, $end_date, $product_id) {
      	$start_date = get_start_date_format($start_date);
        $end_date = get_end_date_format($end_date);
        $product_condition = (intval($product_id) > 0) ? "AND cprd.product_id = '$product_id'" : "";
        $query_result = $this->db->query("SELECT cpri.*, cprd.product_id, cprd.quantity, cprd.unit_price FROM client_product_return_info cpri LEFT JOIN client_product_return_details cprd ON cpri.id = cprd.client_product_return_info_id WHERE cpri.return_date >= '$start_date' AND cpri.return_date <= '$end_date' $product_condition")->result();
        return $query_result;
    }

}
