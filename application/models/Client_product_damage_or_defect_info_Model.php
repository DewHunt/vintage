<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_product_damage_or_defect_info_Model extends CI_Model {

    public $table_name = 'client_product_damage_or_defect_info';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_client_product_damage_or_defect_info($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_client_product_damage_or_defect_info($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'return_date' => $this->input->post('return_date'),
            'branch_id' => $this->input->post('branch_id'),
            'client_id' => $this->input->post('client_id'),
            'invoice_number' => $this->input->post('invoice_number'),
            'challan_number' => $this->input->post('challan_number'),
            'total_amount' => $this->input->post('total_amount'),
            'return_amount' => $this->input->post('return_amount'),
            'total_amount_after_return' => $this->input->post('total_amount_after_return'),
            'remarks' => $this->input->post('remarks'),
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
        $this->db->delete('client_product_damage_or_defect_info');
    }

    public function get_client_product_damage_or_defect_info_by_date_and_client($start_date, $end_date, $client_id) {
        if (empty($client_id) || ((int) $client_id <= 0)) {
            $query_result = $this->db->query("SELECT cpddi.id, cpddi.return_date, cpddi.branch_id, cpddi.client_id, cpddi.invoice_number, cpddi.challan_number, cpddi.total_amount, cpddi.return_amount, cpddi.total_amount_after_return, cpddi.remarks, cpddi.user_id, c.client_name, c.client_code, br.branch_name, br.branch_code, u.user_name, u.user_type FROM client_product_damage_or_defect_info cpddi LEFT JOIN client_info c ON cpddi.client_id=c.id LEFT JOIN branch_info br ON cpddi.branch_id=br.id LEFT JOIN user_info u ON cpddi.user_id=u.id WHERE cpddi.return_date >= '$start_date' AND cpddi.return_date <= '$end_date'")->result();
        } else {
            $query_result = $this->db->query("SELECT cpddi.id, cpddi.return_date, cpddi.branch_id, cpddi.client_id, cpddi.invoice_number, cpddi.challan_number, cpddi.total_amount, cpddi.return_amount, cpddi.total_amount_after_return, cpddi.remarks, cpddi.user_id, c.client_name, c.client_code, br.branch_name, br.branch_code, u.user_name, u.user_type FROM client_product_damage_or_defect_info cpddi LEFT JOIN client_info c ON cpddi.client_id=c.id LEFT JOIN branch_info br ON cpddi.branch_id=br.id LEFT JOIN user_info u ON cpddi.user_id=u.id WHERE cpddi.return_date >= '$start_date' AND cpddi.return_date <= '$end_date' AND cpddi.client_id = '$client_id'")->result();
        }
        return $query_result;
    }

    public function get_client_product_damage_or_defect_info_with_client($id) {
        $query_result = $this->db->query("SELECT cpddi.id, cpddi.return_date, cpddi.branch_id, cpddi.client_id, cpddi.invoice_number, cpddi.challan_number, cpddi.total_amount, cpddi.return_amount, cpddi.total_amount_after_return, cpddi.remarks, cpddi.user_id, c.client_name, c.client_code, br.branch_name, br.branch_code, u.user_name, u.user_type FROM client_product_damage_or_defect_info cpddi LEFT JOIN client_info c ON cpddi.client_id=c.id LEFT JOIN branch_info br ON cpddi.branch_id=br.id LEFT JOIN user_info u ON cpddi.user_id=u.id WHERE cpddi.id = '$id'")->row();
        return $query_result;
    }
}
