<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_sales_commission_Model extends CI_Model {

    public $table_name = 'client_sales_commission';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_client_sales_commission($id = 0) {
        if ($id === 0) {
            $this->db->order_by("id", "desc");
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function get_client_sales_commission_by_date($start_date, $end_date) {
        $this->db->order_by("id", "desc");
        return $this->db->get_where($this->table_name, array('current_date_time >=' => $start_date, 'current_date_time <=' => $end_date))->result(); //claim_date
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table_name);
    }

    public function get_client_sales_commission_by_invoice_details_id($invoice_details_id) {
        $query = $this->db->get_where($this->table_name, array('invoice_details_id' => $invoice_details_id));
        return $query->row();
    }

    public function get_sales_commission_report($start_date, $end_date, $client_id, $employee_id) {
        if (($client_id == 0) && ($employee_id > 0)) {
            $where_condition = "csc.current_date_time >= '$start_date' AND csc.current_date_time <= '$end_date' AND c.employee_id = '$employee_id' ORDER BY csc.id DESC";
        } elseif (($client_id > 0) && ($employee_id == 0)) {
            $where_condition = "csc.current_date_time >= '$start_date' AND csc.current_date_time <= '$end_date' AND i.client_id = '$client_id' ORDER BY csc.id DESC";
        } elseif (($client_id > 0) && ($employee_id > 0)) {
            $where_condition = "csc.current_date_time >= '$start_date' AND csc.current_date_time <= '$end_date' AND i.client_id = '$client_id' AND c.employee_id = '$employee_id' ORDER BY csc.id DESC";
        } else {
            $where_condition = "csc.current_date_time >= '$start_date' AND csc.current_date_time <= '$end_date' ORDER BY csc.id DESC";
        }
        return $this->db->query("SELECT csc.*, i.invoice_number, c.client_name, c.client_code, u.name, u.user_name, e.employee_name, e.employee_code FROM client_sales_commission csc LEFT JOIN invoice_details i ON csc.invoice_details_id = i.id LEFT JOIN client_info c ON i.client_id = c.id LEFT JOIN employee_info e ON c.employee_id = e.id LEFT JOIN user_info u ON csc.user_id = u.id WHERE $where_condition")->result();
    }

    public function get_sales_pfofit_report($start_date, $end_date, $client_id, $employee_id) {
        $remove_product_ids = 'AND sp.product_id NOT IN (100)';  // 100 = opening price
        if (($client_id == 0) && ($employee_id > 0)) {
            $where_condition = "i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND c.employee_id = '$employee_id' $remove_product_ids ORDER BY i.id DESC";
        } elseif (($client_id > 0) && ($employee_id == 0)) {
            $where_condition = "i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND i.client_id = '$client_id' $remove_product_ids ORDER BY i.id DESC";
        } elseif (($client_id > 0) && ($employee_id > 0)) {
            $where_condition = "i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND i.client_id = '$client_id' AND c.employee_id = '$employee_id' $remove_product_ids ORDER BY i.id DESC";
        } else {
            $where_condition = "i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' $remove_product_ids ORDER BY i.id DESC";
        }
        return $this->db->query("SELECT i.*, sp.id AS sale_product_id, sp.product_id, sp.branch_id, sp.pack_size, sp.quantity, sp.unit_price, sp.sales_price_excluding_vat, sp.vat, sp.sales_price_including_vat, sp.gate_pass_remarks, sp.purchase_price, b.branch_name, b.branch_code, b.branch_area, c.client_name, c.client_code, c.address, c.client_area, c.cell_number, c.phone_number, p.product_name, p.product_code, e.employee_name, e.employee_code, csc.claim_date, csc.commission_record_number, csc.commission_amount, dc.total_amount AS delivery_cost_total_amount FROM invoice_details i LEFT JOIN sale_product sp ON i.id = sp.invoice_id LEFT JOIN branch_info b ON i.branch_id = b.id LEFT JOIN client_info c ON i.client_id = c.id LEFT JOIN client_sales_commission csc ON i.id = csc.invoice_details_id LEFT JOIN delivery_cost dc ON i.id = dc.invoice_details_id LEFT JOIN employee_info e ON c.employee_id = e.id LEFT JOIN product p ON sp.product_id = p.id WHERE $where_condition")->result();
    }

    public function get_sales_pfofit_report_invoicewise($start_date, $end_date, $client_id, $employee_id) {
        if (($client_id == 0) && ($employee_id > 0)) {
            $where_condition = "i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND (SELECT c.employee_id FROM client_info c WHERE c.id = i.client_id) = '$employee_id' ORDER BY i.id DESC";
        } elseif (($client_id > 0) && ($employee_id == 0)) {
            $where_condition = "i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND i.client_id = '$client_id' ORDER BY i.id DESC";
        } elseif (($client_id > 0) && ($employee_id > 0)) {
            $where_condition = "i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND i.client_id = '$client_id' AND (SELECT c.employee_id FROM client_info c WHERE c.id = i.client_id) = '$employee_id' ORDER BY i.id DESC";
        } else {
            $where_condition = "i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' ORDER BY i.id DESC";
        }
        return $this->db->query("SELECT i.*, (SELECT SUM(sale_product.sales_price_excluding_vat - (sale_product.quantity * sale_product.purchase_price)) FROM sale_product WHERE sale_product.invoice_id = i.id) AS margin, (SELECT SUM((sale_product.quantity * sale_product.purchase_price)) FROM sale_product WHERE sale_product.invoice_id = i.id) AS sum_of_purchase_price, (SELECT csc.commission_amount FROM client_sales_commission csc WHERE csc.invoice_details_id = i.id) AS commission_amount, (SELECT dc.total_amount FROM delivery_cost dc WHERE dc.invoice_details_id = i.id) AS delivery_cost_total_amount, (SELECT c.client_name FROM client_info c WHERE c.id = i.client_id) AS client_name, (SELECT c.employee_id FROM client_info c WHERE c.id = i.client_id) AS employee_id, (SELECT e.employee_code FROM employee_info e WHERE e.id = i.employee_id) AS employee_code FROM invoice_details i WHERE $where_condition")->result();
    }

}
