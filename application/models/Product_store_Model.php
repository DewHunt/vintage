<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_store_Model extends CI_Model {

    public $table_name = 'product_store';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_product_store($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_product_store($id = 0) {
        $this->load->helper('url');
        $data = array(
            'product_store_date' => $this->input->post('product_store_date'),
            'product_id' => $this->input->post('product_id'),
            'open_stock' => $this->input->post('open_stock'),
            'receive_stock' => $this->input->post('receive_stock'),
            'transfer_stock' => $this->input->post('transfer_stock'),
            'sale_from_stock' => $this->input->post('sale_from_stock'),
            'damage_stock' => $this->input->post('damage_stock'),
            'closing_stock' => $this->input->post('closing_stock'),
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
        $this->db->delete('product_store');
    }

    public function get_product_store_by_date($product_id, $product_store_date) {
        $product_store_by_date = $this->db->query("SELECT * FROM product_store WHERE product_id='$product_id' AND product_store_date='$product_store_date'")->row();
        return $product_store_by_date;
    }

    public function get_product_store_from_previous_date() {
        $previous_date = date('Y-m-d', strtotime("-1 days"));
        $product_store_from_previous_day = $this->db->query("SELECT * FROM `product_store` WHERE product_store_date='$previous_date'")->result();
        return $product_store_from_previous_day;
    }

    public function get_product_store_from_previous_date_by_product_id($date, $product_id) {
        $product_store_from_previous_date = $this->db->query("SELECT * FROM product_store WHERE product_store_date < '$date' AND product_id='$product_id' ORDER BY id DESC LIMIT 1")->row();
        return $product_store_from_previous_date;
    }

    public function get_periodic_item_product_store_report_view($product_id, $start_date, $end_date) {
        if ($product_id == '' || $product_id <= 0) { // all
            $periodic_item_product_store_report_list = $this->db->query("SELECT ps.id, ps.product_store_date, ps.product_id, SUM(ps.open_stock) AS open_stock_sum, SUM(ps.receive_stock) AS receive_stock_sum, SUM(ps.transfer_stock) AS transfer_stock_sum, SUM(ps.sale_from_stock) AS sale_from_stock_sum, SUM(ps.damage_stock) AS damage_stock_sum, SUM(ps.closing_stock) AS closing_stock_sum, p.product_name FROM product_store ps LEFT JOIN product p ON ps.product_id=p.id WHERE ps.product_store_date >='$start_date' AND ps.product_store_date<='$end_date' GROUP BY ps.product_id")->result();
        } else {
            $periodic_item_product_store_report_list = $this->db->query("SELECT ps.id, ps.product_store_date, ps.product_id, SUM(ps.open_stock) AS open_stock_sum, SUM(ps.receive_stock) AS receive_stock_sum, SUM(ps.transfer_stock) AS transfer_stock_sum, SUM(ps.sale_from_stock) AS sale_from_stock_sum, SUM(ps.damage_stock) AS damage_stock_sum, SUM(ps.closing_stock) AS closing_stock_sum, p.product_name FROM product_store ps LEFT JOIN product p ON ps.product_id=p.id WHERE  ps.product_id='$product_id' AND ps.product_store_date >='$start_date' AND ps.product_store_date<='$end_date' GROUP BY ps.product_id")->result();
        }
        return $periodic_item_product_store_report_list;
    }

    public function get_last_product_store_by_date($product_id, $date) {
        $query = $this->db->query("SELECT * FROM product_store WHERE product_id='$product_id' AND DATE_FORMAT(product_store_date,'%Y-%m-%d') <= '$date' ORDER BY id DESC LIMIT 1");
        return $query->row();
    }

    public function get_periodic_item_product_store_by_product_and_date($product_id, $start_date, $end_date) {
        $periodic_item_product_store_report_list = $this->db->query("SELECT ps.id, ps.product_store_date, ps.product_id, ps.open_stock, ps.receive_stock, ps.transfer_stock, ps.sale_from_stock, ps.damage_stock, ps.closing_stock, p.product_name FROM product_store ps LEFT JOIN product p ON ps.product_id=p.id WHERE ps.product_id='$product_id' AND ps.product_store_date >='$start_date' AND ps.product_store_date<='$end_date'")->result();
        return $periodic_item_product_store_report_list;
    }

    public function product_store_save($products,$qtys,$date_of_issue,$type)
    {
        // echo "<pre>"; print_r($qty[1]); exit();

        $countProduct = count($products);
        for ($i=0; $i < $countProduct; $i++) {
            $productId = $products[$i];
            $qty = $qtys[$i];

            $receive_stock = 0;
            $return_to_supplier = 0;
            $return_from_branch = 0;
            $return_from_hot_kitchen = 0;
            $transfer_stock = 0;
            $sale_from_stock = 0;
            $damage_stock = 0;

            if ($type == 'receive_stock') {
                $receive_stock = $qty;
            }
            
            if ($type == 'return_from_branch') {
                $return_from_branch = $qty;
            }
            
            if ($type == 'return_from_hot_kitchen') {
                $return_from_hot_kitchen = $qty;
            }
            
            if ($type == 'transfer_stock') {
                $transfer_stock = $qty;
            }
            
            if ($type == 'sale_from_stock') {
                $sale_from_stock = $qty;
            }
            
            if ($type == 'damage_stock') {
                $damage_stock = $qty;
            }
            
            if ($type == 'return_to_supplier') {
                $return_to_supplier = $qty;
            }

            $isProductStoreExists = $this->db->query("SELECT * FROM product_store WHERE DATE_FORMAT(product_store_date,'%Y-%m-%d') = '$date_of_issue' AND product_id = $productId")->row();

            if ($isProductStoreExists) {
                $open_stock = $isProductStoreExists->open_stock;
                $receive_stock += $isProductStoreExists->receive_stock;
                $return_from_branch += $isProductStoreExists->return_from_branch;
                $return_from_hot_kitchen += $isProductStoreExists->return_from_hot_kitchen;
                $transfer_stock += $isProductStoreExists->transfer_stock;
                $sale_from_stock += $isProductStoreExists->sale_from_stock;
                $damage_stock += $isProductStoreExists->damage_stock;
                $return_to_supplier += $isProductStoreExists->return_to_supplier;

                $closing_stock = ($open_stock + $receive_stock + $return_from_branch + $return_from_hot_kitchen) - ($transfer_stock + $sale_from_stock + $damage_stock + $return_to_supplier);

                $productStoreData = array(
                    'receive_stock' => $receive_stock,
                    'return_from_branch' => $return_from_branch,
                    'return_from_hot_kitchen' => $return_from_hot_kitchen,
                    'transfer_stock' => $transfer_stock,
                    'sale_from_stock' => $sale_from_stock,
                    'damage_stock' => $damage_stock,
                    'return_to_supplier' => $return_to_supplier,
                    'closing_stock' => $closing_stock,
                );

                $this->db->where('id',$isProductStoreExists->id);
                $this->db->update('product_store',$productStoreData);
            } else {
                date_default_timezone_set("Asia/Dhaka");
                $currentTime = date("h:i:s");
                $dateTime = $date_of_issue." ".$currentTime;
                $productInfo = $this->db->query("SELECT * FROM product WHERE id = $productId")->row();

                $open_stock = $productInfo->product_stock;

                $closing_stock = ($open_stock + $receive_stock + $return_from_branch + $return_from_hot_kitchen) - ($transfer_stock + $sale_from_stock + $damage_stock + $return_to_supplier);

                $productStoreData = array(
                    'product_store_date' => $dateTime,
                    'product_id' => $productId,
                    'open_stock' => $open_stock,
                    'receive_stock' => $receive_stock,
                    'return_from_branch' => $return_from_branch,
                    'return_from_hot_kitchen' => $return_from_hot_kitchen,
                    'transfer_stock' => $transfer_stock,
                    'sale_from_stock' => $sale_from_stock,
                    'damage_stock' => $damage_stock,
                    'return_to_supplier' => $return_to_supplier,
                    'closing_stock' => $closing_stock,
                );

                $this->db->insert('product_store',$productStoreData);
            }
        }

        // if ($this->db->affected_rows() > 0) {
        //     return true;
        // }
        // return false; 
    }

    public function get_stock_report($product_id,$start_date,$end_date)
    {
        // echo 'Next Date ' . date('Y-m-d', strtotime('-1 day', strtotime($start_date)));
        // echo $start_date; exit();
        $result = $this->db->query("
            SELECT SUM(receive_stock) AS receive_stock, SUM(return_from_branch) AS return_from_branch, SUM(return_from_hot_kitchen) AS return_from_hot_kitchen, SUM(transfer_stock) AS transfer_stock, SUM(sale_from_stock) AS sale_from_stock, SUM(damage_stock) AS damage_stock, SUM(return_to_supplier) AS return_to_supplier
            FROM product_store
            WHERE product_id = $product_id AND DATE_FORMAT(product_store_date,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
            GROUP BY product_id
        ")->row();

        return $result;
    }
}
