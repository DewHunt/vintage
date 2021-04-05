<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_transfer_model extends CI_Model {

    public $table_name = 'product_receive_challan';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_transfer_product_challan() {
        $result = $this->db->query("
        	SELECT `product_receive_challan`.*, `branch_info`.`branch_name` AS `branchName`
        	FROM `product_receive_challan`
        	LEFT JOIN `branch_info` ON `branch_info`.`id` = `product_receive_challan`.`branch_id`
        ")->result();
        
        return $result;
    }

    public function get_transfer_product_challan_by_id($id)
    {
    	$result = $this->db->query("
    		SELECT `product_receive_challan`.*, `branch_info`.`branch_name` AS `branchName`
    		FROM `product_receive_challan`
        	LEFT JOIN `branch_info` ON `branch_info`.`id` = `product_receive_challan`.`branch_id`
    		WHERE `product_receive_challan`.`id` = $id
    	")->row();

    	return $result;
    }

    public function get_transfer_product_list_by_transfer_product_challan_id($transferProductChallanId)
    {
    	$result = $this->db->query("
    		SELECT `product_receive`.*, `product`.`product_name` AS `productName`
    		FROM product_receive
    		LEFT JOIN `product` ON `product`.`id` = `product_receive`.`product_id`
    		WHERE `product_receive`.`product_receive_challan_id` = $transferProductChallanId
    	")->result();

    	return $result;
    }
}
