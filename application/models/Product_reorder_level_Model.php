<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_reorder_level_Model extends CI_Model {

    public $table_name = 'product_reorder_level';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_product_reorder_level($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
    }

    public function get_product_reorder_level_by_product_id($product_id) {
        return $this->db->get_where($this->table_name, array('product_id' => $product_id))->result();
    }

    public function get_product_reorder_level_by_product_id_and_branch_id($product_id, $branch_id) {
        return $this->db->get_where($this->table_name, array('product_id' => $product_id, 'branch_id' => $branch_id))->row();
    }

    public function get_product_reorder_level_value_by_product_id_and_branch_id($product_id, $branch_id) {
        $result = $this->get_product_reorder_level_by_product_id_and_branch_id($product_id, $branch_id);
        return (!empty($result)) ? $result->reorder_level : 0;
    }

    public function get_product_reorder_level_with_branch_stock($product_id = 0) {
        $where_condition = (intval($product_id) > 0) ? "WHERE prl.product_id = '$product_id'" : "";
        return $result = $this->db->query("SELECT prl.id, prl.product_id, p.product_name, p.product_code, prl.branch_id, (SELECT branch_name FROM branch_info WHERE branch_info.id = prl.branch_id) AS branch_name, prl.reorder_level, (SELECT branch_stock.stock FROM branch_stock WHERE branch_stock.product_id = prl.product_id AND branch_stock.branch_id = prl.branch_id) AS stock FROM product_reorder_level prl LEFT JOIN product p ON prl.product_id = p.id $where_condition")->result();
    }

    public function get_low_stock_product_count_by_branch_id($branch_id = 0) {

        if (intval($branch_id) > 0) {
            $where_condition = "WHERE prl.reorder_level > (SELECT branch_stock.stock FROM branch_stock WHERE branch_stock.product_id = prl.product_id AND branch_stock.branch_id = prl.branch_id) AND prl.branch_id = '$branch_id' GROUP BY prl.branch_id";
        } else {
            $where_condition = "WHERE prl.reorder_level > (SELECT branch_stock.stock FROM branch_stock WHERE branch_stock.product_id = prl.product_id AND branch_stock.branch_id = prl.branch_id) GROUP BY prl.branch_id";
        }
        return $result = $this->db->query("SELECT COUNT(prl.id) AS count_low_stock_product, prl.id, prl.product_id, p.product_name, p.product_code, prl.branch_id, (SELECT branch_name FROM branch_info WHERE branch_info.id = prl.branch_id) AS branch_name, prl.reorder_level, (SELECT branch_stock.stock FROM branch_stock WHERE branch_stock.product_id = prl.product_id AND branch_stock.branch_id = prl.branch_id) AS stock FROM product_reorder_level prl LEFT JOIN product p ON prl.product_id = p.id $where_condition")->result();
    }

    public function branchwise_low_stock_prooduct() {
        $branch_list = $this->db->query("SELECT * FROM branch_info")->result();
        $array = array();
        if (!empty($branch_list)) {
            foreach ($branch_list as $branch) {
                $branch_id = intval($branch->id);
                $branch_name = ($branch->branch_name);
                $result = $this->Product_reorder_level_Model->get_low_stock_product_count_by_branch_id($branch_id);
                $count_low_stock_product = !empty($result) ? ($result[0]->count_low_stock_product) : 0;
                $arr = array('branch_id' => $branch_id, 'branch_name' => $branch_name, 'count_low_stock_product' => $count_low_stock_product);
                array_push($array, $arr);
            }
        }
        return $array;
    }

}
