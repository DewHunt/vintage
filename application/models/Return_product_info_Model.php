<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Return_product_info_Model extends CI_Model {

    public $table_name = 'return_product_info';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_return_product_info($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->row();  // get single company information
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_return_product_info($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'from_branch_id' => $this->input->post('from_branch_id'),
            'to_branch_id' => $this->input->post('to_branch_id'),
            'return_date' => $this->input->post('return_date'),
            'reason' => $this->input->post('reason'),
            'user_id' => $this->input->post('user_id'),
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
        $this->db->delete('return_product_info');
    }

    public function get_return_product_info_by_date_and_branch($start_date, $end_date, $branch_id) {
        if ((empty($branch_id)) || ((int) $branch_id <= 0)) {
            $query_result = $this->db->query("SELECT rpi.id, rpi.from_branch_id, rpi.to_branch_id, rpi.return_date, rpi.reason, rpi.user_id, br.branch_name, br.branch_code, u.user_name, u.user_type, SUM(rpd.quantity) AS total_quantity, SUM(rpd.purchase_price) AS total_purchase_price FROM return_product_info rpi LEFT JOIN branch_info br ON rpi.to_branch_id=br.id LEFT JOIN user_info u ON rpi.user_id=u.id LEFT JOIN return_product_details rpd ON rpi.id= rpd.return_product_info_id WHERE rpi.return_date >= '$start_date' AND rpi.return_date <= '$end_date' GROUP BY rpi.id")->result();
        } else {
            $query_result = $this->db->query("SELECT rpi.id, rpi.from_branch_id, rpi.to_branch_id, rpi.return_date, rpi.reason, rpi.user_id, br.branch_name, br.branch_code, u.user_name, u.user_type, SUM(rpd.quantity) AS total_quantity, SUM(rpd.purchase_price) AS total_purchase_price FROM return_product_info rpi LEFT JOIN branch_info br ON rpi.to_branch_id=br.id LEFT JOIN user_info u ON rpi.user_id=u.id LEFT JOIN return_product_details rpd ON rpi.id= rpd.return_product_info_id WHERE rpi.return_date >= '$start_date' AND rpi.return_date <= '$end_date' AND rpi.to_branch_id='$branch_id' GROUP BY rpi.id")->result();
        }
        return $query_result;
    }

    public function get_return_product_info_with_to_branch($id) {
        $query_result = $this->db->query("SELECT rpi.id, rpi.from_branch_id, rpi.to_branch_id, rpi.return_date, rpi.reason, rpi.user_id, br.branch_name, br.branch_code, u.user_name, u.user_type FROM return_product_info rpi LEFT JOIN branch_info br ON rpi.to_branch_id=br.id LEFT JOIN user_info u ON rpi.user_id=u.id WHERE rpi.id= '$id'")->row();
        return $query_result;
    }

}
