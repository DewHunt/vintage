<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_cost_details_Model extends CI_Model {

    public $table_name = 'delivery_cost_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_delivery_cost_details($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function get_delivery_cost_details_by_id($id) {
        if ($id > 0) {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table_name);
    }

    public function insert_delivery_cost_details($currently_inserted_delivery_cost_id, $delivery_cost_details) {
        $batch_data = array();
        if ((intval($currently_inserted_delivery_cost_id) > 0) && (!empty($delivery_cost_details))) {
            foreach ($delivery_cost_details as $details) {
                $details = !is_array($details) ? (array) $details : $details;
                $details['delivery_cost_id'] = $currently_inserted_delivery_cost_id;
                array_push($batch_data, $details);
            }
        }
        return !empty($batch_data) ? $this->insert_batch($batch_data) : FALSE;
    }

    public function insert_batch($data = null) {

        if (!empty($data)) {
            return $this->db->insert_batch($this->table_name, $data);
        } else {
            return FALSE;
        }
    }

    public function get_delivery_cost_details_by_delivery_cost_id($delivery_cost_id) {
        $query = $this->db->get_where($this->table_name, array('delivery_cost_id' => $delivery_cost_id));
        return $query->result();
    }

    public function get_delivery_cost_details_id_and_amount($delivery_cost_details_by_delivery_cost_id, $delivery_cost_type_id) {
        $arr = array();
        foreach ($delivery_cost_details_by_delivery_cost_id as $delivery_cost_details) {
            $delivery_cost_details_delivery_cost_type_id = intval($delivery_cost_details->delivery_cost_type_id);
            $delivery_cost_details_amount = get_floating_point_number($delivery_cost_details->amount);
            if (($delivery_cost_details_delivery_cost_type_id == $delivery_cost_type_id)) {
                return $arr = array('delivery_cost_details_id' => intval($delivery_cost_details->id), 'amount' => $delivery_cost_details_amount);
            }
        }
    }

    public function update_delivery_cost_details($delivery_cost_id, $delivery_cost_details) {
        $delivery_cost_details_ids = array();
        if (intval($delivery_cost_id) > 0 && !empty($delivery_cost_details)) {
            foreach ($delivery_cost_details as $cost_details) {
                $cost_details = !is_array($cost_details) ? (array) $cost_details : $cost_details;
                $delivery_cost_details_id = intval($cost_details['delivery_cost_details_id']);
                $details = $this->get_delivery_cost_details_by_id($delivery_cost_details_id);
                $cost_details['id'] = $cost_details['delivery_cost_details_id'];
                unset($cost_details['delivery_cost_details_id']);
                if (!empty($details)) {
                    //update                    
                    $this->db->where('id', $delivery_cost_details_id);
                    $this->db->update($this->table_name, $cost_details);
                } else {
                    //insert
                    $cost_details['delivery_cost_id'] = $delivery_cost_id;
                    $this->db->insert($this->table_name, $cost_details);
                    $delivery_cost_details_id = $this->db->insert_id();
                }
                array_push($delivery_cost_details_ids, $delivery_cost_details_id);
            }
            return $this->delete_delivery_cost_details($delivery_cost_id, $delivery_cost_details_ids);
        } else {
            return FALSE;
        }
    }

    public function delete_delivery_cost_details($delivery_cost_id, $delivery_cost_details_ids) {
        if (intval($delivery_cost_id) > 0 && !empty($delivery_cost_details_ids)) {
            $this->db->where_not_in('id', $delivery_cost_details_ids);
            $this->db->where('delivery_cost_id', $delivery_cost_id);
            return $this->db->delete($this->table_name);
        } else {
            return false;
        }
    }

    public function delete_delivery_cost_details_by_delivery_cost_id($id) {
        if ($id) {
            $this->db->where('delivery_cost_id', $id);
            return $this->db->delete($this->table_name);
        } else {
            return FALSE;
        }
    }

    public function get_delivery_itemwise_cost_report($start_date, $end_date, $delivery_cost_type_id = 0) {
        if ($delivery_cost_type_id > 0) {
            return $this->db->query("SELECT dc.*, dcd.id AS delivery_cost_details_id, dcd.delivery_cost_type_id, dcd.amount, dct.delivery_cost_name, i.invoice_number, i.challan_number FROM delivery_cost dc LEFT JOIN delivery_cost_details dcd ON dc.id = dcd.delivery_cost_id LEFT JOIN delivery_cost_type dct ON dcd.delivery_cost_type_id = dct.id LEFT JOIN invoice_details i ON dc.invoice_details_id = i.id WHERE dc.delivery_cost_date >= '$start_date' AND dc.delivery_cost_date <= '$end_date' AND dct.id = $delivery_cost_type_id")->result();
        } else {
            return $this->db->query("SELECT dc.*, dcd.id AS delivery_cost_details_id, dcd.delivery_cost_type_id, SUM(dcd.amount) AS sum_of_amount, dct.delivery_cost_name FROM delivery_cost dc LEFT JOIN delivery_cost_details dcd ON dc.id = dcd.delivery_cost_id LEFT JOIN delivery_cost_type dct ON dcd.delivery_cost_type_id = dct.id WHERE dc.delivery_cost_date >= '$start_date' AND dc.delivery_cost_date <= '$end_date' GROUP BY dcd.delivery_cost_type_id")->result();
        }
    }

}
