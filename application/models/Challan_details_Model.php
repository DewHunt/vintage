<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Challan_details_Model extends CI_Model {

    public $table_name = 'challan_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_challan_details($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_challan_details($id = 0) {
        $this->load->helper('url');
        $data = array(
            'invoice_id' => $this->input->post('invoice_id'),
            'branch_id' => $this->input->post('branch_id'),
            'delivery_certificate' => $this->input->post('delivery_certificate'),
            'date_of_issue' => $this->input->post('date_of_issue'),
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

    public function get_challan_details_by_invoice_id($invoice_id) {
        $query = $this->db->get_where($this->table_name, array('invoice_id' => $invoice_id));
        return $query->row();
    }

    public function get_challan_product_by_challan_id($challan_id = 0) {
        return $challan_product_by_challan_id = $this->db->query("SELECT cd.id, cd.invoice_id, cd.branch_id, cd.delivery_certificate, cd.date_of_issue, cd.user_id, i.invoice_number, i.employee_id, i.dealer_id, i.challan_number, i.client_id, i.branch_id, i.vat_registration_id, i.date_of_issue, i.product_total, i.delivery_charge, i.others_charge, i.deduction, i.deduction_type, i.gross_payable, i.advance_adjusted, i.amount_to_paid, i.mode_of_payment, i.user_id, i.order_number, i.order_date, i.remarks, i.delivery_address, e.employee_name, e.employee_code, e.employee_email, cl.client_name, cl.client_code, cl.address, cl.client_area, cl.cell_number, cl.phone_number, cl.email, d.dealer_name, d.dealer_code, br.branch_name, br.branch_code FROM challan_details cd LEFT JOIN invoice_details i ON cd.invoice_id=i.id LEFT JOIN employee_info e ON i.employee_id=e.id LEFT JOIN client_info cl ON i.client_id=cl.id LEFT JOIN dealer_info d ON i.dealer_id=d.id LEFT JOIN branch_info br ON i.branch_id=br.id WHERE cd.id = '$challan_id'")->row();
    }

}
