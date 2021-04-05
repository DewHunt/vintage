<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_receive_challan_Model extends CI_Model {

    public $table_name = 'product_receive_challan';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_product_receive_challan($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_product($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'challan_number' => $this->input->post('challan_number'),
            'branch_id' => $this->input->post('branch_id'),
            'total_amount' => $this->input->post('total_amount'),
            'remarks' => $this->input->post('remarks'),
            'product_receive_date' => $this->input->post('product_receive_date'),
            'user_id' => $this->input->post('user_id'),
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
        $this->db->delete('product_receive_challan');
    }

    public function get_product_receive_Challan_report_by_date($branch_id, $start_date, $end_date) {
        if (!empty($branch_id) > 0) {
            $product_receive_Challan_report_by_date = $this->db->query("SELECT prc.id, prc.challan_number, prc.branch_id, prc.total_amount, prc.remarks, prc.product_receive_date, prc.user_id, br.branch_name, br.branch_code, br.branch_area, u.user_name, u.user_type FROM product_receive_challan prc LEFT JOIN branch_info br ON prc.branch_id=br.id LEFT JOIN user_info u ON prc.user_id=u.id WHERE prc.branch_id = '$branch_id' AND prc.product_receive_date >= '$start_date' AND prc.product_receive_date <= '$end_date'")->result();
        } else {
            $product_receive_Challan_report_by_date = $this->db->query("SELECT prc.id, prc.challan_number, prc.branch_id, prc.total_amount, prc.remarks, prc.product_receive_date, prc.user_id, br.branch_name, br.branch_code, br.branch_area, u.user_name, u.user_type FROM product_receive_challan prc LEFT JOIN branch_info br ON prc.branch_id=br.id LEFT JOIN user_info u ON prc.user_id=u.id WHERE prc.product_receive_date >= '$start_date' AND prc.product_receive_date <= '$end_date'")->result();
        }
        return $product_receive_Challan_report_by_date;
    }

    public function get_product_receive_challan_details_by_product_receive_challan_id($id) {
        $product_receive_challan_details_by_product_receive_challan_id = $this->db->query("SELECT prc.id, prc.challan_number, prc.branch_id, prc.total_amount, prc.remarks, prc.product_receive_date, prc.user_id, pr.product_id, pr.quantity,pr.product_source,pr.total_price,p.product_name, p.pack_size, p.purchase_price, br.branch_name FROM product_receive_challan prc LEFT JOIN product_receive pr ON prc.id=pr.product_receive_challan_id LEFT JOIN product p ON pr.product_id=p.id LEFT JOIN branch_info br ON prc.branch_id=br.id WHERE prc.id = '$id'")->result();
        return $product_receive_challan_details_by_product_receive_challan_id;
    }
    
    public function get_product_receive_challan_details_by_product_receive_challan_id_single_row($id) {
        $product_receive_challan_details_by_product_receive_challan_id = $this->db->query("SELECT prc.id, prc.challan_number, prc.branch_id, prc.total_amount, prc.remarks, prc.product_receive_date, prc.user_id, pr.product_id, pr.quantity,pr.product_source,pr.total_price,p.product_name, p.pack_size, p.purchase_price, br.branch_name FROM product_receive_challan prc LEFT JOIN product_receive pr ON prc.id=pr.product_receive_challan_id LEFT JOIN product p ON pr.product_id=p.id LEFT JOIN branch_info br ON prc.branch_id=br.id WHERE prc.id = '$id'")->row();
        return $product_receive_challan_details_by_product_receive_challan_id;
    }

}
