<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_purchase_model extends CI_Model {

    public $table_name = 'purchased_product';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_purchased_product()
    {
    	$result = $this->db->query("SELECT * FROM purchased_product ORDER BY id DESC")->result();

    	return $result;
    }

    public function get_purchased_product_by_id($id)
    {
    	$result = $this->db->query("
            SELECT `purchased_product`.*,`supplier`.`name` AS `supplierName`
            FROM `purchased_product`
            LEFT JOIN `supplier` ON `supplier`.`id` = `purchased_product`.`supplier_id`
            WHERE `purchased_product`.`id` = $id
        ")->row();

    	return $result;
    }

    public function get_purchased_product_list_by_purchased_product_id($purchased_product_id)
    {
    	$result = $this->db->query("
    		SELECT `purchased_product_list`.*, `product`.`product_name` AS `productName` 
    		FROM `purchased_product_list`
    		LEFT JOIN `product` ON `product`.`id` = `purchased_product_list`.`product_id`
    		WHERE `purchased_product_list`.`purchased_product_id` = $purchased_product_id
    	")->result();

    	return $result;
    }

    public function get_purchased_statement($start_date,$end_date,$supplier_id)
    {
        $where_query = "";

        if ($start_date) {
            $where_query .= " DATE_FORMAT(date,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
        }

        if ($supplier_id) {
            $where_query .= " AND supplier_id = $supplier_id";
        }


        $result = $this->db->query("
            SELECT `purchased_product`.*,`supplier`.`name` AS `supplierName`
            FROM `purchased_product`
            LEFT JOIN `supplier` ON `supplier`.`id` = `purchased_product`.`supplier_id`
            WHERE $where_query
        ")->result();

        return $result;
    }
}
