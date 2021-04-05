<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_type_Model extends CI_Model {

    public $table_name = 'product_type';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_product_type($id = 0) {
        $query = $this->db->get_where($this->table_name);
        return $query->result();
    }

    public function get_all_product_type()
    {
        $result = $this->db->query("
            SELECT `product_type`.*,`printer_info`.`name` AS `printerName`
            FROM `product_type`
            LEFT JOIN `printer_info` ON `printer_info`.`id` = `product_type`.`printer_id`
            ORDER BY `product_type`.`sort_order`
        ")->result();

        return $result;
    }

    public function isCategoryNameExists($name)
    {
        $exists = $this->db->query("SELECT * FROM product_type WHERE product_type_name = '$name'")->row();
        return $exists;
    }

    public function isCategoryNameExistsById($name,$categoryId)
    {
        $exists = $this->db->query("SELECT * FROM product_type WHERE product_type_name = '$name' AND id != $categoryId")->row();
        return $exists;
    }

    public function getCategoryInfoById($categoryId)
    {
        $categoryInfo = $this->db->query("SELECT * FROM product_type WHERE id = $categoryId")->row();
        return $categoryInfo;
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
    }

}
