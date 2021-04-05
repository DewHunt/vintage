<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order_sheet_Model extends CI_Model {

    public $table_name = 'order_sheet';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_order_sheet($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_order_sheet($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'online_order_number' => $this->input->post('online_order_number'),
            'issue_time' => $this->input->post('issue_time'),
            'client_id' => $this->input->post('client_id'),
            'delivery_address' => $this->input->post('delivery_address'),
            'work_order_number' => $this->input->post('work_order_number'),
            'work_order_date' => $this->input->post('work_order_date'),
            'issue_date' => $this->input->post('issue_date'),
            'delivery_date' => $this->input->post('delivery_date'),
            'freight_charge' => $this->input->post('freight_charge'),
            'discount' => $this->input->post('discount'),
            'bonus' => $this->input->post('bonus'),
            'total' => $this->input->post('total'),
            'remarks' => $this->input->post('remarks'),
            'current_date_time' => $this->input->post('current_date_time'),
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

    public function get_last_online_order_number() {
        $last_row_id = $this->db->query("SELECT id, online_order_number FROM order_sheet ORDER BY id DESC LIMIT 1")->row();
        return $last_row_id;
    }

    public function get_order_sheet_list($start_date, $end_date, $employee_id = 0, $user_type = NULL) {
        if (strtolower($user_type) == 'Marketing') {
            $query_result = $this->db->query("SELECT os.id, os.online_order_number, os.issue_date, os.issue_time, os.client_id, os.delivery_address, os.work_order_number, os.work_order_date, os.delivery_date, os.freight_charge, os.discount, os.bonus, os.total, os.remarks, os.current_date_time, os.user_id, c.client_name, c.client_code, c.employee_id, u.user_name, u.user_type FROM order_sheet os LEFT JOIN client_info c ON os.client_id = c.id LEFT JOIN user_info u ON os.user_id = u.id WHERE os.current_date_time >= '$start_date' AND os.current_date_time <= '$end_date' AND c.employee_id = '$employee_id' ORDER BY os.id DESC");
            return $query_result->result();
        } else {
            $query_result = $this->db->query("SELECT os.id, os.online_order_number, os.issue_date, os.issue_time, os.client_id, os.delivery_address, os.work_order_number, os.work_order_date, os.delivery_date, os.freight_charge, os.discount, os.bonus, os.total, os.remarks, os.current_date_time, os.user_id, c.client_name, c.client_code, u.user_name, u.user_type FROM order_sheet os LEFT JOIN client_info c ON os.client_id = c.id LEFT JOIN user_info u ON os.user_id = u.id WHERE os.current_date_time >= '$start_date' AND os.current_date_time <= '$end_date' ORDER BY os.id DESC");
            return $query_result->result();
        }
    }

}
