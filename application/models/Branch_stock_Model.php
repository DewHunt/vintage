<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Branch_stock_Model extends CI_Model {

    public $table_name = 'branch_stock';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_branch_stock($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_branch_stock($id = 0) {
        $this->load->helper('url');
        $data = array(
            'product_id' => $this->input->post('product_id'),
            'branch_id' => $this->input->post('branch_id'),
            'stock' => $this->input->post('stock'),
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
        $this->db->delete('branch_stock');
    }

    public function get_branch_stock_by_product_id_branch_id($product_id, $branch_id) {
        $get_branch_stock_by_product_id_branch_id = $this->db->query("SELECT * FROM branch_stock WHERE product_id = '$product_id' AND branch_id = '$branch_id'")->row();
        return $get_branch_stock_by_product_id_branch_id;
    }

    public function get_branch_stock_by_product_id($product_id) {
        $query = $this->db->get_where($this->table_name, array('product_id' => $product_id));
        return $query->result();
    }
    
    public function branch_wise_stock_report_view($branch_id) {
        if ($branch_id <= 0 || $branch_id == '') {
            $branch_wise_stock_report_list = $this->db->query("SELECT bs.id, SUM(stock) as stock, b.branch_name, b.branch_area, p.product_name FROM branch_stock bs JOIN branch_info b ON bs.branch_id=b.id JOIN product p ON bs.product_id=p.id GROUP BY bs.product_id")->result();
        } else {
            $branch_wise_stock_report_list = $this->db->query("SELECT bs.id, bs.stock, b.branch_name, b.branch_area, p.product_name FROM branch_stock bs JOIN branch_info b ON bs.branch_id=b.id JOIN product p ON bs.product_id=p.id WHERE bs.branch_id='$branch_id'")->result();
        }
        return $branch_wise_stock_report_list;
    }

    public function is_branch_stock_exists($branchId,$productId)
    {
        $result = $this->db->query("SELECT * FROM branch_stock WHERE branch_id = $branchId AND product_id = $productId")->row();
        return $result;
    }    

    public function update_branch_stock($branchId,$productId,$quantity,$inc_dec)
    {
        $isBranchStockExists = $this->is_branch_stock_exists($branchId,$productId);

        if ($inc_dec == "inc") {
            $stock = $isBranchStockExists->stock + $quantity;
        }
        else {
            $stock = $isBranchStockExists->stock - $quantity;
        }

        $branchStockData = array(
            'stock' => $stock,
        );
        $this->db->where('id',$isBranchStockExists->id);
        $this->db->update('branch_stock', $branchStockData);
    }

    public function insert_update_branch_stock($branchId,$productId,$quantity,$inc_dec)
    {
        $branchStockData = array(
            'branch_id' => $branchId,
            'product_id' => $productId,
            'stock' => $quantity,
        );

        $isBranchStockExists = $this->is_branch_stock_exists($branchId,$productId);

        if ($isBranchStockExists) {
            if ($inc_dec == 'inc') {
                $branchStockData['stock'] += $isBranchStockExists->stock;
            }
            else {
                $branchStockData['stock'] = $isBranchStockExists->stock - $branchStockData['stock'];
            }

            $this->db->where('id',$isBranchStockExists->id);
            $this->db->update('branch_stock', $branchStockData);
        }
        else {
            $this->db->insert('branch_stock', $branchStockData);
        }
    }
}
