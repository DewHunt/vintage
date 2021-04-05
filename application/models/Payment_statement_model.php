<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_statement_model extends CI_Model {

    public $table_name = 'purchased_product';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_purchased_product()
    {
    	$result = $this->db->query("SELECT * FROM purchased_product ORDER BY id DESC")->result();

    	return $result;
    }

    public function get_supplier_payment_info($supplierId,$startDate,$endDate)
    {
    	$result = $this->db->query("
            SELECT * FROM `supplier_payment` WHERE `supplier_id` = $supplierId AND DATE_FORMAT(`date`,'%Y-%m-%d') BETWEEN '$startDate' AND '$endDate'
        ")->result();

    	return $result;
    }

    public function get_payment_statement($start_date,$end_date,$supplier_id)
    {
        $where_query = "";

        if ($start_date) {
            $where_query .= " DATE_FORMAT(`b`.`date`,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
        }

        if ($supplier_id != 'all') {
            $where_query .= " AND `b`.`supplier_id` = $supplier_id";
        }


        $result = $this->db->query("
        	SELECT `b`.`supplier_id`, (SELECT `a`.`previous_amount` FROM `supplier_payment` AS a WHERE `a`.`supplier_id` = `b`.`supplier_id` ORDER BY `a`.`id` DESC LIMIT 1) AS `previousAmount`,SUM(`b`.`paid_amount`) AS `totalPaidAmount`,`supplier`.`name` AS `supplierName`,`user_info`.`user_name` AS `userName`
			FROM `supplier_payment` AS `b`
			LEFT JOIN `supplier` ON `supplier`.`id` = `b`.`supplier_id`
			LEFT JOIN `user_info` ON `user_info`.`id` = `b`.`user_id`
            WHERE $where_query
			GROUP BY `b`.`supplier_id`
        ")->result();

        return $result;
    }
}
