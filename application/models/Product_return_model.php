<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_return_model extends CI_Model {

    public $table_name = 'stock_transfer';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_product_return($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function get_all_product_return($sessionFromBranchId)
    {
        $whereQuery = "";
        if ($sessionFromBranchId != "all") {
            $whereQuery .= "WHERE `product_return_challan`.`branch_id` IN ($sessionFromBranchId)";
        }

        $result = $this->db->query("
            SELECT `product_return_challan`.*, `branch_info`.`branch_name` AS `branchName`
            FROM `product_return_challan`
            LEFT JOIN `branch_info` ON `branch_info`.`id` = `product_return_challan`.`branch_id`
            $whereQuery
            ORDER BY `product_return_challan`.`id` DESC
        ")->result();

        return $result;
    }

    public function get_product_return_challan_by_id($id)
    {
        $result = $this->db->query("
            SELECT `product_return_challan`.*, `branch_info`.`branch_name` AS `branchName`
            FROM `product_return_challan`
            LEFT JOIN `branch_info` ON `branch_info`.`id` = `product_return_challan`.`branch_id`
            WHERE `product_return_challan`.`id` = $id
        ")->row();

        return $result;
    }

    public function get_product_return_product_list_by_product_return_challan_id($productReturnChallanId)
    {
        $result = $this->db->query("
            SELECT `product_return`.*, `product`.`product_name` AS `productName`
            FROM `product_return`
            LEFT JOIN `product` ON `product`.`id` = `product_return`.`product_id`
            WHERE `product_return`.`product_return_challan_id` = $productReturnChallanId
        ")->result();

        return $result;
    }

}
