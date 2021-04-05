<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Branchwise_product_store_Model extends CI_Model {

    public $table_name = 'branchwise_product_store';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_branchwise_product_store($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_branchwise_product_store($id = 0) {
        $this->load->helper('url');
        $data = array(
            'product_store_date' => $this->input->post('product_store_date'),
            'product_id' => $this->input->post('product_id'),
            'branch_id' => $this->input->post('branch_id'),
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
        $this->db->delete($this->table_name);
    }

    public function get_branchwise_product_store_by_date($product_store_date, $product_id, $branch_id) {
        $branchwise_product_store_by_date = $this->db->query("SELECT * FROM branchwise_product_store WHERE branch_id='$branch_id' AND product_id='$product_id' AND product_store_date='$product_store_date'")->row();
        return $branchwise_product_store_by_date;
    }

    public function get_branchwise_product_store_from_previous_date_by_product_id_branch_id($date, $product_id, $branch_id) {
        $branchwise_product_store_from_previous_date = $this->db->query("SELECT * FROM branchwise_product_store WHERE product_store_date < '$date' AND product_id='$product_id' AND branch_id='$branch_id' ORDER BY id DESC LIMIT 1")->row();
        return $branchwise_product_store_from_previous_date;
    }

    public function get_branchwise_periodic_item_product_store_report_view($branch_id, $product_id, $start_date, $end_date) {
        if (($branch_id > 0) && ($product_id > 0)) {
            $branchwise_item_product_store_report_view = $this->db->query("SELECT bps.id, bps.product_store_date, bps.product_id, bps.branch_id, SUM(bps.open_stock) AS open_stock_sum, SUM(bps.receive_stock) AS receive_stock_sum, SUM(bps.transfer_stock) AS transfer_stock_sum, SUM(bps.sale_from_stock) AS sale_from_stock_sum, SUM(bps.damage_stock) AS damage_stock_sum, SUM(bps.closing_stock) AS closing_stock_sum, p.product_name, b.branch_name FROM branchwise_product_store bps JOIN product p ON bps.product_id=p.id JOIN branch_info b ON bps.branch_id=b.id WHERE bps.branch_id='$branch_id' AND bps.product_id='$product_id' AND bps.product_store_date >= '$start_date' AND bps.product_store_date <= '$end_date' GROUP BY bps.product_id")->result();
        } elseif (($branch_id <= 0 || $branch_id == '') && ($product_id > 0)) {
            $branchwise_item_product_store_report_view = $this->db->query("SELECT bps.id, bps.product_store_date, bps.product_id, bps.branch_id, SUM(bps.open_stock) AS open_stock_sum, SUM(bps.receive_stock) AS receive_stock_sum, SUM(bps.transfer_stock) AS transfer_stock_sum, SUM(bps.sale_from_stock) AS sale_from_stock_sum, SUM(bps.damage_stock) AS damage_stock_sum, SUM(bps.closing_stock) AS closing_stock_sum, p.product_name, b.branch_name FROM branchwise_product_store bps JOIN product p ON bps.product_id=p.id JOIN branch_info b ON bps.branch_id=b.id WHERE bps.product_id='$product_id' AND bps.product_store_date >= '$start_date' AND bps.product_store_date <= '$end_date' GROUP BY bps.product_id")->result();
        } elseif (($branch_id > 0) && ($product_id <= 0 || $product_id == '')) {
            $branchwise_item_product_store_report_view = $this->db->query("SELECT bps.id, bps.product_store_date, bps.product_id, bps.branch_id, SUM(bps.open_stock) AS open_stock_sum, SUM(bps.receive_stock) AS receive_stock_sum, SUM(bps.transfer_stock) AS transfer_stock_sum, SUM(bps.sale_from_stock) AS sale_from_stock_sum, SUM(bps.damage_stock) AS damage_stock_sum, SUM(bps.closing_stock) AS closing_stock_sum, p.product_name, b.branch_name FROM branchwise_product_store bps JOIN product p ON bps.product_id=p.id JOIN branch_info b ON bps.branch_id=b.id WHERE bps.branch_id='$branch_id' AND bps.product_store_date >= '$start_date' AND bps.product_store_date <= '$end_date' GROUP BY bps.product_id")->result();
        } else {
            $branchwise_item_product_store_report_view = $this->db->query("SELECT bps.id, bps.product_store_date, bps.product_id, bps.branch_id, SUM(bps.open_stock) AS open_stock_sum, SUM(bps.receive_stock) AS receive_stock_sum, SUM(bps.transfer_stock) AS transfer_stock_sum, SUM(bps.sale_from_stock) AS sale_from_stock_sum, SUM(bps.damage_stock) AS damage_stock_sum, SUM(bps.closing_stock) AS closing_stock_sum, p.product_name, b.branch_name FROM branchwise_product_store bps JOIN product p ON bps.product_id=p.id JOIN branch_info b ON bps.branch_id=b.id WHERE bps.product_store_date >= '$start_date' AND bps.product_store_date <= '$end_date' GROUP BY bps.product_id")->result();
        }
        return $branchwise_item_product_store_report_view;
    }

    public function get_last_branchwise_product_store_by_date($branch_id, $product_id, $date) {
        $query = $this->db->query("SELECT * FROM branchwise_product_store WHERE branch_id='$branch_id' AND product_id='$product_id' AND DATE_FORMAT(product_store_date,'%Y-%m-%d') <= '$date' ORDER BY id DESC LIMIT 1");
        return $query->row();
    }

    public function get_branchwise_product_store_by_branch_product_date($branch_id, $product_id, $start_date, $end_date) {
        $start_date = get_start_date_format($start_date);
        $end_date = get_end_date_format($end_date);
        $query = $this->db->query("SELECT bps.id, bps.product_store_date, bps.product_id, bps.branch_id, bps.open_stock, bps.receive_stock, bps.transfer_stock, bps.sale_from_stock, bps.damage_stock, bps.closing_stock, p.product_name, b.branch_name FROM branchwise_product_store bps JOIN product p ON bps.product_id=p.id JOIN branch_info b ON bps.branch_id=b.id WHERE bps.branch_id='$branch_id' AND bps.product_id='$product_id' AND bps.product_store_date >= '$start_date' AND bps.product_store_date <= '$end_date'");
        return $query->result();
    }


    public function product_store_save($branchs,$products,$qty,$date_of_issue,$type)
    {
        $countProduct = count($products);
        for ($i=0; $i < $countProduct; $i++) {
            $productId = $products[$i];
            $branchId = $branchs[$i];

            $receive_stock = 0;
            $transfer_stock = 0;
            $return_stock = 0;
            $sale_from_stock = 0;
            $damage_stock = 0;

            if ($type == 'receive_stock') {
                $receive_stock = $qty[$i];
            }
            
            if ($type == 'transfer_stock') {
                $transfer_stock = $qty[$i];
            }
            
            if ($type == 'return_stock') {
                $return_stock = $qty[$i];
            }
            
            if ($type == 'sale_from_stock') {
                $sale_from_stock = $qty[$i];
            }
            
            if ($type == 'damage_stock') {
                $damage_stock = $qty[$i];
            }

            $isBranchwiseProductStoreExists = $this->db->query("SELECT * FROM branchwise_product_store WHERE DATE_FORMAT(product_store_date,'%Y-%m-%d') = '$date_of_issue' AND branch_id = $branchId AND product_id = $productId")->row();

            if ($isBranchwiseProductStoreExists) {
                $open_stock = $isBranchwiseProductStoreExists->open_stock;
                $receive_stock += $isBranchwiseProductStoreExists->receive_stock;
                $transfer_stock += $isBranchwiseProductStoreExists->transfer_stock;
                $return_stock += $isBranchwiseProductStoreExists->return_stock;
                $sale_from_stock += $isBranchwiseProductStoreExists->sale_from_stock;
                $damage_stock += $isBranchwiseProductStoreExists->damage_stock;

                $closing_stock = ($open_stock + $receive_stock) - ($transfer_stock + $return_stock + $sale_from_stock + $damage_stock);

                $productStoreData = array(
                    'receive_stock' => $receive_stock,
                    'transfer_stock' => $transfer_stock,
                    'return_stock' => $return_stock,
                    'sale_from_stock' => $sale_from_stock,
                    'damage_stock' => $damage_stock,
                    'closing_stock' => $closing_stock,
                );

                $this->db->where('id',$isBranchwiseProductStoreExists->id);
                $this->db->update('branchwise_product_store',$productStoreData);
            } else {
                date_default_timezone_set("Asia/Dhaka");
                $currentTime = date("h:i:s");
                $dateTime = $date_of_issue." ".$currentTime;
                $branchStock = $this->db->query("SELECT * FROM branch_stock WHERE branch_id = $branchId AND product_id = $productId")->row();

                if ($branchStock) {
                    $open_stock = $branchStock->stock;
                }
                else {
                    $open_stock = 0;
                }

                $closing_stock = ($open_stock + $receive_stock) - ($transfer_stock + $return_stock + $sale_from_stock + $damage_stock);

                $productStoreData = array(
                    'product_store_date' => $dateTime,
                    'product_id' => $products[$i],
                    'branch_id' => $branchs[$i],
                    'open_stock' => $open_stock,
                    'receive_stock' => $receive_stock,
                    'transfer_stock' => $transfer_stock,
                    'return_stock' => $return_stock,
                    'sale_from_stock' => $sale_from_stock,
                    'damage_stock' => $damage_stock,
                    'closing_stock' => $closing_stock,
                );

                $this->db->insert('branchwise_product_store',$productStoreData);
            }
        }

        // if ($this->db->affected_rows() > 0) {
        //     return true;
        // }
        // return false; 
    }

    public function get_stock_report($branch_id,$product_id,$start_date,$end_date)
    {
        $result = $this->db->query("
            SELECT SUM(receive_stock) AS receive_stock, SUM(transfer_stock) AS transfer_stock, SUM(return_stock) AS return_stock, SUM(sale_from_stock) AS sale_from_stock, SUM(damage_stock) AS damage_stock
            FROM branchwise_product_store
            WHERE product_id = $product_id AND branch_id = $branch_id AND DATE_FORMAT(product_store_date,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'
            GROUP BY product_id,branch_id
        ")->row();

        return $result;
    }

}
