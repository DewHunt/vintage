<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_Model extends CI_Model {

    public $table_name = 'product';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_product() {
        $product_list = $this->db->query("
            SELECT `product`.*, `product_type`.`product_type_name` AS productTypeName,`unit`.`name` AS `unitName`
            FROM product
            LEFT JOIN `product_type` ON `product_type`.`id` = `product`.`product_type_id`
            LEFT JOIN `unit` ON `unit`.`unit_id` = `product`.`unit`
        ")->result();
        
        return $product_list;
    }

    public function get_all_unit($unitId = 0)
    {
        if ($unitId === 0) {
            $result = $this->db->query("SELECT * FROM unit WHERE status = 1")->result();
        } else {
            $result = $this->db->query("SELECT * FROM unit WHERE unit_id = $unitId AND status = 1")->row();
        }

        return $result;
    }

    public function getProductById($id){
        // echo $id; exit();
        $product_list = $this->db->query("
            SELECT `product`.*, `product_type`.`product_type_name` AS productTypeName
            FROM product
            LEFT JOIN `product_type` ON `product_type`.`id` = `product`.`product_type_id`
            WHERE `product`.`id` = $id
        ")->row();
        
        return $product_list;
    }

    public function getSearchProductInfoByProductType($productTypeId) {
        $product_list = $this->db->query("
            SELECT `product`.*, `product_type`.`product_type_name` AS productTypeName
            FROM product
            LEFT JOIN `product_type` ON `product_type`.`id` = `product`.`product_type_id`
            WHERE `product`.`product_type_id` = $productTypeId
        ")->result();
        
        return $product_list;
    }

    public function check_hot_kitchen_product($id)
    {
        $result = $this->db->query("SELECT * FROM product WHERE id = $id AND hot_kitchen_status = 1")->row();
        return $result;
    }

    public function update_product_stock($productId,$quantity,$inc_dec)
    {
        $productInfo = $this->getProductById($productId);

        if ($inc_dec == "inc") {
            $product_stock = $productInfo->product_stock + $quantity;
        }
        else {
            $product_stock = $productInfo->product_stock - $quantity;
        }

        $productData = array(
            'product_stock' => $product_stock,
        );
        $this->db->where('id',$productInfo->id);
        $this->db->update('product', $productData);
    }

    public function save_product($id = 0) {
        $this->load->helper('url');
        $data = array(
            'product_name' => $this->input->post('product_name'),
            'product_code' => $this->input->post('product_code'),
            'product_range' => $this->input->post('product_range'),
            'minimum_price' => $this->input->post('minimum_price'),
            'maximum_price' => $this->input->post('maximum_price'),
            'fixed_price' => $this->input->post('fixed_price'),
            'product_stock' => $this->input->post('product_stock'),
            'api' => $this->input->post('product_api'),
            'sae' => $this->input->post('product_sae'),
            'iso' => $this->input->post('product_iso'),
            'pack_size' => $this->input->post('pack_size'),
            'origin_of_country' => $this->input->post('origin_of_country'),
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
        $this->db->delete($this->table_name);
    }

    public function get_product_by_product_type($product_type_id)
    {
        if (!empty($product_type_id))
        {
            $products = $this->db->query("
                SELECT `product`.*,`product_type`.`button_color` AS `buttonColor` 
                FROM product 
                LEFT JOIN `product_type` ON `product_type`.`id` = `product`.`product_type_id`
                WHERE `product`.`product_type_id` = '$product_type_id'
            ")->result();
        }
        else
        {
            $products = "";
        }
        
        return $products;
    }

    public function get_product_info_by_id($product_id)
    {
        $productInfo = $this->db->query('SELECT * FROM product WHERE id = '.$product_id)->row();
        return $productInfo;
    }

    public function get_product_info_by_product_name($product_name) {
        $result = $this->db->query("SELECT * FROM $this->table_name WHERE product_name = '$product_name'")->row();
        return $result;
    }

    public function get_product_info_by_id_for_duplicate_check($product_name, $id) {
        $result = $this->db->query("SELECT * FROM $this->table_name WHERE product_name = '$product_name' AND id != $id")->row();
        return $result;
    }

//    public function get_low_stock_product_by_branch_id($branch_id = 0) {
//        $where_condition = (intval($branch_id) > 0) ? "p.reorder_level > bs.stock AND bs.branch_id = '$branch_id' ORDER BY p.id ASC" : "p.reorder_level > bs.stock ORDER BY p.id ASC";
//        return $this->db->query("SELECT p.id, p.product_name, p.pack_size, p.reorder_level, bs.branch_id, bs.stock, (SELECT b.branch_name FROM branch_info b WHERE bs.branch_id = b.id) AS branch_name FROM product p LEFT JOIN branch_stock bs ON p.id =bs.product_id WHERE $where_condition")->result();
//    }

    public function get_stock_report($start_date, $end_date, $branch_ids = array()) {
//        $start_date = get_start_date_format(date('Y-m-01', strtotime(($start_month_year))));
//        $end_date = get_end_date_format(date('Y-m-t', strtotime(($end_month_year))));
        if (!empty($branch_ids)) {
            $branch_ids = implode(',', $branch_ids);
            $branch_id_condition = "AND i.branch_id IN ($branch_ids)";
            $current_stock_query = "(SELECT SUM(stock) as stock FROM branch_stock bs JOIN branch_info b ON bs.branch_id=b.id JOIN product p ON bs.product_id=p.id WHERE bs.product_id = s.product_id AND b.id IN ($branch_ids) GROUP BY bs.product_id) AS current_stock";
        } else {
            $branch_id_condition = "";
            $current_stock_query = "(SELECT SUM(stock) as stock FROM branch_stock bs JOIN branch_info b ON bs.branch_id=b.id JOIN product p ON bs.product_id=p.id WHERE bs.product_id = s.product_id GROUP BY bs.product_id) AS current_stock";
        }        
        $where_condition = "WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' $branch_id_condition GROUP BY s.product_id ORDER BY i.id DESC";
        return $this->db->query("SELECT $current_stock_query, s.product_id, i.employee_id, i.invoice_number, c.client_name, i.date_of_issue, i.branch_id, br.branch_name, p.product_name, p.api, p.sae, p.iso, s.pack_size, SUM(s.quantity) AS quantity, s.unit_price, (s.quantity * s.unit_price) AS total_amount, u.user_name, u.user_type, u.employee_id AS user_employee_id FROM invoice_details i LEFT JOIN sale_product s ON s.invoice_id=i.id LEFT JOIN client_info c ON c.id= i.client_id LEFT JOIN branch_info br ON i.branch_id = br.id LEFT JOIN product p ON s.product_id = p.id LEFT JOIN user_info u ON i.user_id=u.id $where_condition")->result();
    }

}
