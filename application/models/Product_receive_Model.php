<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_receive_Model extends CI_Model
{
    public $table_name = 'product_receive';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_receive_product_challan($sessionBranchId) {
        $whereQuery = "";
        if ($sessionBranchId != "all") {
            $whereQuery .= "WHERE `product_receive_challan`.`branch_id` IN ($sessionBranchId) ";
        }
        $statusQuery = "AND `product_receive_challan`.`status` = 0";

        $result = $this->db->query("
            SELECT `product_receive_challan`.*, `branch_info`.`branch_name` AS `branchName`
            FROM `product_receive_challan`
            LEFT JOIN `branch_info` ON `branch_info`.`id` = `product_receive_challan`.`branch_id`
            $whereQuery
            ORDER BY `product_receive_challan`.`id` DESC
        ")->result();
        
        return $result;
    }

    public function get_all_receive_stock_transfer_challan($sessionBranchId)
    {
        $whereQuery = "";
        if ($sessionBranchId != "all") {
            $whereQuery .= "WHERE `stock_transfer_challan`.`from_branch_id` IN ($sessionBranchId) ";
        }
        $statusQuery = "AND `stock_transfer_challan`.`status` = 0";

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

    public function get_all_approve_return_product_challan($sessionBranchId)
    {
        $whereQuery = "";
        if ($sessionBranchId != "all") {
            $whereQuery .= "WHERE `product_return_challan`.`branch_id` IN ($sessionBranchId) ";
        }
        $statusQuery = "AND `product_return_challan`.`status` = 0";

        $result = $this->db->query("
            SELECT `product_return_challan`.*, `branch_info`.`branch_name` AS `branchName`
            FROM `product_return_challan`
            LEFT JOIN `branch_info` ON `branch_info`.`id` = `product_return_challan`.`branch_id`
            $whereQuery
            ORDER BY `product_return_challan`.`id` DESC
        ")->result();

        return $result;
    }

    public function get_receive_product_info_by_id($tableName,$id)
    {
        $result = $this->db->query("SELECT * FROM $tableName WHERE id = $id")->row();
        return $result;
    }

    public function product_update_status($tableName,$id,$status)
    {
        $update = $this->db->query("UPDATE $tableName SET status = $status WHERE id = $id");

        if ($this->db->affected_rows() > 0) { return true; }
        return false; 
    }

    public function challan_update_status($challanTableName,$productTableName,$productTablecolumnName,$id,$status)
    {
        $rejectStatus = $this->db->query("SELECT COUNT(*) AS totalReject FROM $productTableName WHERE $productTablecolumnName = $id AND status = $status")->row();

        $receiveProduct = $this->db->query("SELECT COUNT(*) AS totalReceiveProduct FROM $productTableName WHERE $productTablecolumnName = $id")->row();

        if ($rejectStatus->totalReject != $receiveProduct->totalReceiveProduct) { $status = 1; }

        $update = $this->db->query("UPDATE $challanTableName SET status = $status WHERE id = $id");

        if ($this->db->affected_rows() > 0) { return true; }
        return false; 
    }

    public function get_transfer_report($start_date,$end_date,$branch_id)
    {
        $whereQuery = "";

        if ($start_date) {
            $whereQuery .= " DATE_FORMAT(`product_receive_challan`.`product_receive_date`,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
        }

        if ($branch_id) {
            $where_query .= " AND `product_receive_challan`.`branch_id` = $branch_id";
        }

        $result = $this->db->query("
            SELECT `product_receive_challan`.*, `branch_info`.`branch_name` AS `branchName`, `user_info`.`user_name` AS `userName`
            FROM `product_receive_challan`
            LEFT JOIN `branch_info` ON `branch_info`.`id` = `product_receive_challan`.`branch_id`
            LEFT JOIN `user_info` ON `user_info`.`id` = `product_receive_challan`.`user_id`
            WHERE $whereQuery
        ")->result();

        return $result;
    }
}
