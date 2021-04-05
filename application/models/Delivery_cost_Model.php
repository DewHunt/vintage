<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_cost_Model extends CI_Model {

    public $table_name = 'delivery_cost';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_delivery_cost($id = 0) {
        if ($id === 0) {
            $this->db->order_by("id", "desc");
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function get_delivery_cost_by_date($start_date, $end_date) {
        $this->db->order_by("id", "desc");
        return $this->db->get_where($this->table_name, array('current_date_time >=' => $start_date, 'current_date_time <=' => $end_date))->result(); //delivery_cost_date
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
    }

    public function get_delivery_cost_by_invoice_details_id($invoice_details_id) {
        $query = $this->db->get_where($this->table_name, array('invoice_details_id' => $invoice_details_id));
        return $query->row();
    }

    public function get_delivery_cost_list_by_date($start_date, $end_date, $client_id, $employee_id) {
        if (($client_id == 0) && ($employee_id > 0)) {
            $where_condition = "dc.current_date_time >= '$start_date' AND dc.current_date_time <= '$end_date' AND c.employee_id = '$employee_id' ORDER BY dc.id DESC";
        } elseif (($client_id > 0) && ($employee_id == 0)) {
            $where_condition = "dc.current_date_time >= '$start_date' AND dc.current_date_time <= '$end_date' AND i.client_id = '$client_id' ORDER BY dc.id DESC";
        } elseif (($client_id > 0) && ($employee_id > 0)) {
            $where_condition = "dc.current_date_time >= '$start_date' AND dc.current_date_time <= '$end_date' AND i.client_id = '$client_id' AND c.employee_id = '$employee_id' ORDER BY dc.id DESC";
        } else {
            $where_condition = "dc.current_date_time >= '$start_date' AND dc.current_date_time <= '$end_date' ORDER BY dc.id DESC";
        }
        return $query = $this->db->query("SELECT dc.*, i.invoice_number, i.challan_number, i.client_id, i.branch_id, c.client_name, c.client_code, c.employee_id, e.employee_name, e.employee_code FROM delivery_cost dc LEFT JOIN invoice_details i ON dc.invoice_details_id = i.id LEFT JOIN client_info c ON i.client_id = c.id LEFT JOIN employee_info e ON c.employee_id = e.id WHERE $where_condition")->result();
    }

}
