<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Production_model extends CI_Model {

    public $table_name = 'production';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_production() {
        $result = $this->db->query("SELECT * FROM production")->result();
        
        return $result;
    }

    public function get_recipe_info_by_parent_product_id($parentProductId){
        // echo $id; exit();
        $result = $this->db->query("
            SELECT `recipe`.*, `product`.`product_name` AS `productName`, `product`.`unit` AS `productUnit`
            FROM `recipe`
            LEFT JOIN `product` ON `product`.`id` = `recipe`.`child_product_id`
            WHERE `recipe`.`parent_product_id` = $parentProductId
        ")->result();
        
        return $result;
    }

    public function get_production_by_id($id)
    {
    	$result = $this->db->query("SELECT * FROM production WHERE id = $id")->row();

    	return $result;
    }

    public function get_production_product_list_by_production_id($productionId)
    {
    	$result = $this->db->query("
    		SELECT `production_product_list`.*, `product`.`product_name` AS `productName`
    		FROM production_product_list
    		LEFT JOIN `product` ON `product`.`id` = `production_product_list`.`product_id`
    		WHERE `production_product_list`.`production_id` = $productionId
    	")->result();

    	return $result;
    }
}
