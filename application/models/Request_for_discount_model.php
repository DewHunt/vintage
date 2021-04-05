<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Request_for_discount_model extends CI_Model {

    public $table_name = 'request_for_discount';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function is_exists_request($token_number,$branch_id)
    {
    	$result = $this->db->query("SELECT * FROM request_for_discount WHERE token_number = '$token_number' AND branch_id = $branch_id AND status <> 2")->row();

    	return $result;
    }

    public function get_discount_info_by_token_key($token_key)
    {
        // echo "<pre>"; print_r($token_key); exit();
    	$result = $this->db->query("
    		SELECT `request_for_discount`.*, `branch_info`.`branch_name` AS `branchName`
    		FROM `request_for_discount`
    		LEFT JOIN `branch_info` ON `branch_info`.`id` = `request_for_discount`.`branch_id`
    		WHERE `request_for_discount`.`token_key` = '$token_key'
    	")->row();
    	return $result;
    }

    public function get_discount_info_by_id($discount_id)
    {
        $result = $this->db->query("
            SELECT `request_for_discount`.*, `branch_info`.`branch_name` AS `branchName`
            FROM `request_for_discount`
            LEFT JOIN `branch_info` ON `branch_info`.`id` = `request_for_discount`.`branch_id`
            WHERE `request_for_discount`.`id` = '$discount_id'
        ")->row();
        return $result;
    }
}
