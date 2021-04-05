<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_transfer_Model extends CI_Model {

    public $table_name = 'stock_transfer';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_stock_transfer($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function get_all_stock_transfer($sessionFromBranchId)
    {
        $whereQuery = "";
        if ($sessionFromBranchId != "all") {
            $whereQuery .= "WHERE `stock_transfer_challan`.`from_branch_id` IN ($sessionFromBranchId)";
        }

        $result = $this->db->query("
            SELECT `stock_transfer_challan`.*, `fromBranch`.`branch_name` AS `fromBranchName`, `toBranch`.`branch_name` AS `toBranchName`
            FROM `stock_transfer_challan`
            LEFT JOIN `branch_info` AS `fromBranch` ON `fromBranch`.`id` = `stock_transfer_challan`.`from_branch_id`
            LEFT JOIN `branch_info` AS `toBranch` ON `toBranch`.`id` = `stock_transfer_challan`.`to_branch_id`
            $whereQuery
            ORDER BY `stock_transfer_challan`.`id` DESC
        ")->result();

        return $result;
    }

    public function get_stock_transfer_product_challan_by_id($id)
    {
        $result = $this->db->query("
            SELECT `stock_transfer_challan`.*, `fromBranch`.`branch_name` AS `fromBranchName`, `toBranch`.`branch_name` AS `toBranchName`
            FROM `stock_transfer_challan`
            LEFT JOIN `branch_info` AS `fromBranch` ON `fromBranch`.`id` = `stock_transfer_challan`.`from_branch_id`
            LEFT JOIN `branch_info` AS `toBranch` ON `toBranch`.`id` = `stock_transfer_challan`.`to_branch_id`
            WHERE `stock_transfer_challan`.`id` = $id
        ")->row();

        return $result;
    }

    public function get_stock_transfer_product_list_by_stock_transfer_challan_id($stockTransferChallanId)
    {
        $result = $this->db->query("
            SELECT `stock_transfer`.*, `product`.`product_name` AS `productName`
            FROM `stock_transfer`
            LEFT JOIN `product` ON `product`.`id` = `stock_transfer`.`product_id`
            WHERE `stock_transfer`.`stock_transfer_challan_id` = $stockTransferChallanId
        ")->result();

        return $result;
    }

    public function save_stock_transfer($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'from_branch_id' => $this->input->post('from_branch_id'),
            'to_branch_id' => $this->input->post('to_branch_id'),
            'product_id' => $this->input->post('product_id'),
            'quantity' => $this->input->post('quantity'),
            'date_of_transfer' => $this->input->post('date_of_transfer'),
            'transfer_reason' => $this->input->post('transfer_reason'),
            'user_id' => $this->input->post('user_id'),
            'total_price' => $this->input->post('total_price'),
            'product_source' => $this->input->post('product_source'),
            'stock_transfer_challan_id' => $this->input->post('stock_transfer_challan_id'),
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

}
