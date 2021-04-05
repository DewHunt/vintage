<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Table_model extends CI_Model {

    public $table_name = 'tables';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_table()
    {
    	$result = $this->db->query("
    		SELECT `tables`.*,`branch_info`.`branch_name` AS `outletName`
    		FROM `tables`
    		LEFT JOIN `branch_info` ON `branch_info`.`id` = `tables`.`branch_id`
    		ORDER BY `outletName` ASC
    	")->result();

    	return $result;
    }

    public function get_table_by_id($id = 0) {
    	$result = $this->db->query("SELECT * FROM tables WHERE id = $id")->row();
    	return $result;
    }

    public function get_all_by_branch_id($branch_id)
    {
    	$result = $this->db->query("
    		SELECT `tables`.*,`branch_info`.`branch_name` AS `outletName`
    		FROM tables
    		LEFT JOIN `branch_info` ON `branch_info`.`id` = `tables`.`branch_id`
    		WHERE `tables`.`branch_id` = $branch_id
    		ORDER BY `outletName` ASC
    		"
    	)->result();
    	return $result;
    }

    public function is_table_exists($branch_id,$number,$table_id = 0)
    {
    	$query = "";
    	if ($table_id > 0) {
    		$query .= "AND id <> $table_id";
    	}
    	$result = $this->db->query("SELECT * FROM tables WHERE branch_id = $branch_id AND table_number = '$number' $query")->row();
    	return $result;
    }
}
