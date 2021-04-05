<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_transfer_challan_Model extends CI_Model {

    public $table_name = 'stock_transfer_challan';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_stock_transfer_challan($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_stock_transfer_challan($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'from_branch_id' => $this->input->post('from_branch_id'),
            'to_branch_id' => $this->input->post('to_branch_id'),
            'challan_number' => $this->input->post('challan_number'),
            'total_amount' => $this->input->post('total_amount'),
            'reason' => $this->input->post('reason'),
            'transfer_date' => $this->input->post('transfer_date'),
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
        $this->db->delete($this->table_name);
    }

    public function get_stock_transfer_details_report_by_date($from_branch_id, $to_branch_id, $start_date, $end_date) {
        if ($from_branch_id > 0 && $to_branch_id > 0) {
            $where_condition = "WHERE stc.from_branch_id = '$from_branch_id' AND stc.to_branch_id = '$to_branch_id' AND stc.transfer_date >= '$start_date' AND stc.transfer_date <= '$end_date'";
        } elseif ($from_branch_id > 0 && $to_branch_id == 0) {
            $where_condition = "WHERE stc.from_branch_id = '$from_branch_id' AND stc.transfer_date >= '$start_date' AND stc.transfer_date <= '$end_date'";
        } elseif ($from_branch_id == 0 && $to_branch_id > 0) {
            $where_condition = "WHERE stc.to_branch_id = '$to_branch_id' AND stc.transfer_date >= '$start_date' AND stc.transfer_date <= '$end_date'";
        } else {
            $where_condition = "WHERE stc.transfer_date >= '$start_date' AND stc.transfer_date <= '$end_date'";
        }
        $stock_transfer_details_report_by_date = $this->db->query("SELECT stc.id, stc.from_branch_id, stc.to_branch_id, stc.challan_number, stc.total_amount, stc.reason, stc.transfer_date, stc.user_id, br.branch_name AS from_branch_name, (SELECT branch_name FROM branch_info WHERE branch_info.id= stc.to_branch_id) AS to_branch_name, u.user_name, u.user_type FROM stock_transfer_challan stc LEFT JOIN branch_info br ON stc.from_branch_id = br.id LEFT JOIN user_info u ON stc.user_id=u.id $where_condition");
        return $stock_transfer_details_report_by_date->result();
    }

    public function get_stock_transfer_challan_details_by_stock_transfer_challan_id($id) {
        $stock_transfer_challan_details_by_stock_transfer_challan_id = $this->db->query("SELECT stc.id, stc.from_branch_id, stc.to_branch_id, stc.challan_number, stc.total_amount, stc.reason, stc.transfer_date, stc.user_id, br.branch_name AS from_branch_name, (SELECT branch_name FROM branch_info WHERE branch_info.id= stc.to_branch_id) AS to_branch_name, u.user_name, u.user_type, st.product_id, st.quantity, st.total_price, st.product_source, p.product_name, p.product_code, p.purchase_price, p.pack_size FROM stock_transfer_challan stc LEFT JOIN branch_info br ON stc.from_branch_id = br.id LEFT JOIN user_info u ON stc.user_id=u.id LEFT JOIN stock_transfer st ON stc.id=st.stock_transfer_challan_id LEFT JOIN product p ON st.product_id = p.id WHERE stc.id = '$id'")->result();
        return $stock_transfer_challan_details_by_stock_transfer_challan_id;
    }

    public function get_stock_transfer_challan_details_by_stock_transfer_challan_id_single_row($id) {
        $stock_transfer_challan_details_by_stock_transfer_challan_id = $this->db->query("SELECT stc.id, stc.from_branch_id, stc.to_branch_id, stc.challan_number, stc.total_amount, stc.reason, stc.transfer_date, stc.user_id, br.branch_name AS from_branch_name, (SELECT branch_name FROM branch_info WHERE branch_info.id= stc.to_branch_id) AS to_branch_name, u.user_name, u.user_type, u.employee_id, (SELECT employee_code FROM employee_info WHERE u.employee_id = employee_info.id) AS employee_code, st.product_id, st.quantity, st.total_price, st.product_source, p.product_name, p.product_code, p.purchase_price, p.pack_size FROM stock_transfer_challan stc LEFT JOIN branch_info br ON stc.from_branch_id = br.id LEFT JOIN user_info u ON stc.user_id=u.id LEFT JOIN stock_transfer st ON stc.id=st.stock_transfer_challan_id LEFT JOIN product p ON st.product_id = p.id WHERE stc.id = '$id'")->row();
        return $stock_transfer_challan_details_by_stock_transfer_challan_id;
    }

}
