<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Damage_or_defect_product_info_Model extends CI_Model {

    public $table_name = 'damage_or_defect_product_info';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_damage_or_defect_product_info($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->row();  // get single company information
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_damage_or_defect_product_info($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'branch_id' => $this->input->post('branch_id'),
            'damage_or_defect_date' => $this->input->post('damage_or_defect_date'),
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
        $this->db->delete('damage_or_defect_product_info');
    }

    public function get_damage_or_defect_product_info_by_date_and_branch($start_date, $end_date, $branch_id) {
        if ((empty($branch_id)) || ((int) $branch_id <= 0)) {
            $query_result = $this->db->query("SELECT ddp.id, ddp.branch_id, ddp.damage_or_defect_date, ddp.reason, ddp.user_id, br.branch_name, br.branch_code, u.user_name, u.user_type, ddpd.product_id, ddpd.packsize, SUM(ddpd.quantity) AS total_quantity, SUM(ddpd.purchase_price) AS total_purchase_price FROM damage_or_defect_product_info ddp LEFT JOIN branch_info br ON ddp.branch_id=br.id LEFT JOIN user_info u ON ddp.user_id=u.id LEFT JOIN damage_or_defect_product_details ddpd ON ddp.id=ddpd.damage_or_defect_product_info_id WHERE ddp.damage_or_defect_date >= '$start_date' AND ddp.damage_or_defect_date <= '$end_date' GROUP BY ddp.id")->result();
        } else {
            $query_result = $this->db->query("SELECT ddp.id, ddp.branch_id, ddp.damage_or_defect_date, ddp.reason, ddp.user_id, br.branch_name, br.branch_code, u.user_name, u.user_type, ddpd.product_id, ddpd.packsize, SUM(ddpd.quantity) AS total_quantity, SUM(ddpd.purchase_price) AS total_purchase_price FROM damage_or_defect_product_info ddp LEFT JOIN branch_info br ON ddp.branch_id=br.id LEFT JOIN user_info u ON ddp.user_id=u.id LEFT JOIN damage_or_defect_product_details ddpd ON ddp.id=ddpd.damage_or_defect_product_info_id WHERE ddp.damage_or_defect_date >= '$start_date' AND ddp.damage_or_defect_date <= '$end_date' AND ddp.branch_id='$branch_id' GROUP BY ddp.id")->result();
        }
        return $query_result;
    }

    public function get_damage_or_defect_product_info_with_branch($id) {
        $query = $this->db->query("SELECT ddp.id, ddp.branch_id, ddp.damage_or_defect_date, ddp.reason, ddp.user_id, br.branch_name, br.branch_code, u.user_name, u.user_type FROM damage_or_defect_product_info ddp LEFT JOIN branch_info br ON ddp.branch_id= br.id LEFT JOIN user_info u ON ddp.user_id=u.id WHERE ddp.id='$id'")->row();
        return $query;
    }

}
