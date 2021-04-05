<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bonus_incentive_system_Model extends CI_Model {

    public $table_name = 'bonus_incentive_system';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_bonus_incentive_system($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_bonus_incentive_system($id = 0) {
        $this->load->helper('url');
        $data = array(
            'from_amount' => $this->input->post('from_amount'),
            'to_amount' => $this->input->post('to_amount'),
            'percent_of_incentive' => $this->input->post('percent_of_incentive')
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
        return $this->db->delete($this->table_name);
    }

    public function get_percent_of_incentive($amount, $incentive_type = '') {
        $incentive_type_condition = !empty($incentive_type) ? "AND incentive_type = '$incentive_type'" : "";
        $amount = doubleval($amount);
        $query = $this->db->query("SELECT percent_of_incentive FROM $this->table_name WHERE from_amount < $amount AND to_amount >= $amount $incentive_type_condition ORDER BY id LIMIT 1")->row();
        return !empty($query->percent_of_incentive) ? $query->percent_of_incentive : 0;
    }

}
