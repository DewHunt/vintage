<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Recipe_model extends CI_Model {

    public $table_name = 'recipe';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_recipe() {
        $product_list = $this->db->query("
            SELECT `product`.*, `product_type`.`product_type_name` AS productTypeName
            FROM product
            LEFT JOIN `product_type` ON `product_type`.`id` = `product`.`product_type_id`
        ")->result();
        
        return $product_list;
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

}
