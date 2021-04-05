<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_details_Model extends CI_Model {

    public $table_name = 'invoice_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getMaxInvoiceDetailsId()
    {
        $maxId = $this->db->query("SELECT MAX(id) AS maxId FROM invoice_details")->row();
        return $maxId;
    }

    public function getMaxTokenNumber($currentDateTime,$outletId)
    {
        $maxTokenNumber = $this->db->query("SELECT COUNT(token_number) AS maxTokenNumber FROM invoice_details WHERE DATE_FORMAT(order_date, '%Y-%m-%d') = '$currentDateTime' AND branch_id = $outletId")->row();
        return $maxTokenNumber;
    }

    public function is_token_number_exists($tokenNumber,$branchId)
    {
        $result = $this->db->query("SELECT * FROM invoice_details WHERE token_number = '$tokenNumber' AND branch_id = $branchId")->row();

        return $result;
    }

    public function getInvoiceDetailsById($invoiceId)
    {
        $invoiceDetails = $this->db->query('
            SELECT `branch_info`.*, `client_info`.*, `invoice_details`.* , `branch_info`.`address` as `branch_address`
            FROM `invoice_details` 
            LEFT JOIN `branch_info` ON `branch_info`.`id` = `invoice_details`.`branch_id`
            LEFT JOIN `client_info` ON `client_info`.`id` = `invoice_details`.`client_id`
            WHERE `invoice_details`.`id` = '.$invoiceId
        )->row();
        return $invoiceDetails;
    }

    public function get_invoice_info_by_token_number_and_branch_id($branch_id,$token_number)
    {
        $result = $this->db->query("SELECT * FROM `invoice_details` WHERE `branch_id` = $branch_id AND `token_number`='$token_number'")->row();
        return $result;
    }

    public function get_only_invoice_details_by_id($id,$tableId)
    {
        $query = "";
        if ($tableId) {
            $query = "WHERE mode_of_payment = 'pending' AND table_id = $tableId";
        } else {
            $query = "WHERE id = $id";
        }
        
        $result = $this->db->query("SELECT * FROM invoice_details $query")->row();

        return $result;
    }

    public function get_all_invoice_by_user_id_and_outlet_id($user_id,$outlet_id,$user_type)
    {
        if ($user_type == 'admin') {
            $result = $this->db->query("SELECT * FROM invoice_details WHERE branch_id = $outlet_id AND delivery_status = 0 ORDER BY id")->result();
        } else {
            $result = $this->db->query("SELECT * FROM invoice_details WHERE user_id = $user_id AND branch_id = $outlet_id AND delivery_status = 0 ORDER BY id")->result();
        }       

        return $result;
    }

    public function update_order_delivery_status($id)
    {
        $this->db->query("UPDATE invoice_details SET delivery_status = 1 WHERE id = $id");

        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        return FALSE;    
    }

    public function get_invoice_details($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function get_pending_order_list_by_branch_id($branchId)
    {
        $result = $this->db->query("
            SELECT `invoice_details`.*,`tables`.`table_number` AS tableNumber
            FROM `invoice_details`
            LEFT JOIN `tables` ON `tables`.`id` = `invoice_details`.`table_id`
            WHERE `invoice_details`.`mode_of_payment` = 'pending' AND `invoice_details`.`branch_id` = $branchId"
        )->result();

        return $result;
    }

    public function get_order_summary_by_date_range($start_date,$end_date,$branch_id)
    {
        $where_condition = "";

        if ($start_date) {
            $where_condition .= "DATE_FORMAT(order_date,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
        }

        if ($branch_id) {
            $where_condition .= "AND branch_id = $branch_id";
        }        

        $result = $this->db->query("
            SELECT order_date, SUM(payableAmount) AS payableAmount
            FROM view_order_summary 
            WHERE $where_condition
            GROUP BY DATE_FORMAT(order_date,'%Y-%M-%d')
        ")->result();

        return $result;
    }

    public function get_total_order_summary($start_date,$end_date,$branch_id)
    {
        $where_condition = "";

        if ($start_date) {
            $where_condition .= "DATE_FORMAT(order_date,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
        }

        if ($branch_id) {
            $where_condition .= "AND branch_id = $branch_id";
        }        

        $result = $this->db->query("
            SELECT order_date, SUM(totalOrder) AS totalOrder, SUM(subTotal) AS subTotal, SUM(vatTotal) AS vatTotal, SUM(discountAmount) AS discountAmount, SUM(payableAmount) AS payableAmount, SUM(cashPayment) AS cashPayment, SUM(cardPayment) AS cardPayment
            FROM view_order_summary 
            WHERE $where_condition
        ")->row();

        return $result;
    }

    public function get_single_day_order_summary($start_date,$end_date,$branch_id)
    {
        $where_condition = "";

        if ($start_date) {
            $where_condition .= "DATE_FORMAT(order_date,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
        }

        if ($branch_id) {
            $where_condition .= "AND branch_id = $branch_id";
        }        

        $result = $this->db->query("
            SELECT order_date, SUM(totalOrder) AS totalOrder, SUM(subTotal) AS subTotal, SUM(vatTotal) AS vatTotal, SUM(discountAmount) AS discountAmount, SUM(payableAmount) AS payableAmount, SUM(cashPayment) AS cashPayment, SUM(cardPayment) AS cardPayment
            FROM view_order_summary 
            WHERE $where_condition
            GROUP BY DATE_FORMAT(order_date,'%Y-%M-%d')
        ")->row();

        return $result;
    }

    public function save_invoice_details($id = 0) {
        $this->load->helper('url');
        $data = array(
            'invoice_number' => $this->input->post('invoice_number'),
            'employee_id' => $this->input->post('employee_id'),
            'dealer_id' => $this->input->post('dealer_id'),
            'challan_number' => $this->input->post('challan_number'),
            'client_id' => $this->input->post('client_id'),
            'branch_id' => $this->input->post('branch_id'),
            'vat_registration_id' => $this->input->post('vat_registration_id'),
            'date_of_issue' => $this->input->post('date_of_issue'),
            'product_total' => $this->input->post('product_total'),
            'delivery_charge' => $this->input->post('delivery_charge'),
            'others_charge' => $this->input->post('others_charge'),
            'deduction' => $this->input->post('deduction'),
            'deduction_type' => $this->input->post('deduction_type'),
            'gross_payable' => $this->input->post('gross_payable'),
            'advance_adjusted' => $this->input->post('advance_adjusted'),
            'amount_to_paid' => $this->input->post('amount_to_paid'),
            'mode_of_payment' => $this->input->post('mode_of_payment'),
            'user_id' => $this->input->post('user_id'),
            'remarks' => $this->input->post('remarks'),
        );
        if ($id === 0) {
            return $this->db->insert($this->table_name, $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update($this->table_name, $data);
        }
    }

    public function get_last_invoice_details_invoice_number() {
        $max_invoice_number = $this->db->query("SELECT MAX(CAST(invoice_number AS UNSIGNED)) AS max_invoice_number FROM invoice_details")->row();
        return $max_invoice_number;
    }

    public function get_last_invoice_details_challan_number() {
        $max_challan_number = $this->db->query("SELECT MAX(CAST(challan_number AS UNSIGNED)) AS max_challan_number FROM invoice_details")->row();
        return $max_challan_number;
    }

    public function is_exist_invoice_number($invoice_number) {
        $query_result = $this->db->get_where($this->table_name, array('invoice_number' => $invoice_number))->row();
        if (!empty($query_result)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function is_exist_challan_number($challan_number) {
        $query_result = $this->db->get_where($this->table_name, array('challan_number' => $challan_number))->row();
        if (!empty($query_result)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_invoice_details_by_invoice_number($invoice_number) {
        $query = $this->db->get_where($this->table_name, array('invoice_number' => $invoice_number))->row();
        return $query;
    }

    public function get_invoice_details_by_challan_number($challan_number) {
        $query = $this->db->get_where($this->table_name, array('challan_number' => $challan_number))->row();
        return $query;
    }

    public function get_gate_pass_report_show($id = 0) {
        return $gate_pass_report_list = $this->db->query("SELECT i.id, i.employee_id, i.dealer_id, i.date_of_issue, i.invoice_number, i.challan_number, i.order_number, i.order_date, e.employee_name, e.employee_code, d.dealer_code, g.source FROM invoice_details i LEFT JOIN employee_info e ON i.employee_id=e.id LEFT JOIN dealer_info d ON i.dealer_id=d.id LEFT JOIN gate_pass_details g ON g.invoice_id=i.id WHERE i.id='$id'")->row();
    }

    public function get_gate_pass_report_view($id = 0) {
        if ($id == 0) {
            $gate_pass_report_list = $this->db->query("SELECT i.id, s.product_id, p.product_name, s.pack_size, s.quantity, s.gate_pass_remarks FROM invoice_details i LEFT JOIN sale_product s ON s.invoice_id=i.id LEFT JOIN product p ON s.product_id=p.id")->result();
            return $gate_pass_report_list;
        } else {
            $gate_pass_report_list = $this->db->query("SELECT i.id, s.product_id, p.product_name, s.pack_size, s.quantity, s.gate_pass_remarks FROM invoice_details i LEFT JOIN sale_product s ON s.invoice_id=i.id LEFT JOIN product p ON s.product_id=p.id WHERE i.id='$id'")->result();
            return $gate_pass_report_list;
        }
    }

    public function get_sales_details_statemnt_report($start_date, $end_date, $client_id, $user_type, $employee_id) {
        $remove_product_ids = 'AND sp.product_id NOT IN (100)';  // 100 = opening price
        if (strtolower($user_type) === 'marketing') {  // for marketing type user
            if ((int) $client_id > 0) {
                $where_condition = "WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND i.client_id = '$client_id' AND c.employee_id = '$employee_id' $remove_product_ids ORDER BY i.id DESC";
            } elseif ($client_id == 'import' || $client_id == 'lubzone') {
                $client_type = $client_id;
                $where_condition = "WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND c.client_type = '$client_type' AND c.employee_id = '$employee_id' $remove_product_ids ORDER BY i.id DESC";
            } else { // for all $client_id == 0
                $where_condition = "WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND c.employee_id = '$employee_id' $remove_product_ids ORDER BY i.id DESC";
            }
        } else {
            if ((int) $client_id > 0) {
                $where_condition = "WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND i.client_id = '$client_id' $remove_product_ids ORDER BY i.id DESC";
            } elseif ($client_id == 'import' || $client_id == 'lubzone') {
                $client_type = $client_id;
                $where_condition = "WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND c.client_type = '$client_type' $remove_product_ids ORDER BY i.id DESC";
            } else { // for all $client_id == 0
                $where_condition = "WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' $remove_product_ids ORDER BY i.id DESC";
            }
        }
        $query = $this->db->query("SELECT i.*, sp.id AS sale_product_id, sp.product_id, sp.branch_id, sp.pack_size, sp.quantity, sp.unit_price, sp.sales_price_excluding_vat, sp.vat, sp.sales_price_including_vat, sp.gate_pass_remarks, sp.purchase_price, b.branch_name, b.branch_code, b.branch_area, c.client_name, c.client_code, c.address, c.client_area, c.cell_number, c.phone_number, p.product_name, p.product_code FROM invoice_details i LEFT JOIN sale_product sp ON i.id = sp.invoice_id LEFT JOIN branch_info b ON i.branch_id = b.id LEFT JOIN client_info c ON i.client_id = c.id LEFT JOIN product p ON sp.product_id = p.id $where_condition");
        return $query->result();
    }

    public function get_productwise_profit_report($start_date, $end_date, $product_id) {
        $remove_product_ids = 'AND sp.product_id NOT IN (100)';  // 100 = opening price
        if (intval($product_id) > 0) {
            $where_condition = "i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND sp.product_id = '$product_id' $remove_product_ids GROUP BY sp.product_id ORDER BY margin DESC";
        } else {
            $where_condition = "i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' $remove_product_ids GROUP BY sp.product_id ORDER BY margin DESC";
        }
        return $query = $this->db->query("SELECT i.*, sp.product_id, sp.pack_size, p.product_name, p.product_code, SUM(sp.quantity) AS sum_of_quantity, SUM(sp.sales_price_excluding_vat) AS sum_of_sales_price_excluding_vat, SUM(sp.quantity*sp.purchase_price) AS cost_price, SUM(sp.sales_price_excluding_vat - (sp.quantity*sp.purchase_price)) AS margin FROM invoice_details i LEFT JOIN sale_product sp ON i.id = sp.invoice_id LEFT JOIN product p ON sp.product_id = p.id WHERE $where_condition")->result();
    }

    public function get_productwise_sales_analysis($start_date, $end_date, $start_limit = 0, $end_limit = 0) {
        $remove_product_ids = "AND p.id NOT IN (100)";  // 100 = opening price
        $where_condition = "i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' $remove_product_ids GROUP BY sp.product_id ORDER BY margin DESC LIMIT $start_limit, $end_limit";
        return $query = $this->db->query("SELECT i.*, sp.product_id, sp.pack_size, p.product_name, p.product_code, SUM(sp.quantity) AS sum_of_quantity, SUM(sp.sales_price_excluding_vat) AS sum_of_sales_price_excluding_vat, SUM(sp.quantity*sp.purchase_price) AS cost_price, SUM(sp.sales_price_excluding_vat - (sp.quantity*sp.purchase_price)) AS margin FROM invoice_details i LEFT JOIN sale_product sp ON i.id = sp.invoice_id LEFT JOIN product p ON sp.product_id = p.id WHERE $where_condition")->result();
    }

    public function get_clientwise_sales_analysis($start_date, $end_date, $start_limit = 0, $end_limit = 0) {
        $where_condition = "i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' GROUP BY i.client_id ORDER BY margin DESC LIMIT $start_limit, $end_limit";
        return $this->db->query("SELECT i.*, SUM((SELECT SUM(sale_product.sales_price_excluding_vat - (sale_product.quantity * sale_product.purchase_price)) FROM sale_product WHERE sale_product.invoice_id = i.id)) AS margin, (SELECT SUM((sale_product.quantity * sale_product.purchase_price)) FROM sale_product WHERE sale_product.invoice_id = i.id) AS sum_of_purchase_price, (SELECT csc.commission_amount FROM client_sales_commission csc WHERE csc.invoice_details_id = i.id) AS commission_amount, (SELECT dc.total_amount FROM delivery_cost dc WHERE dc.invoice_details_id = i.id) AS delivery_cost_total_amount, (SELECT c.client_name FROM client_info c WHERE c.id = i.client_id) AS client_name, (SELECT e.employee_code FROM employee_info e WHERE e.id = i.employee_id) AS employee_code FROM invoice_details i WHERE $where_condition")->result();
    }

    public function get_employeewise_sales_analysis($start_date, $end_date, $start_limit = 0, $end_limit = 0) {
        $where_condition = "i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND i.employee_id > 0 GROUP BY i.employee_id ORDER BY margin DESC LIMIT $start_limit, $end_limit";
        return $this->db->query("SELECT i.*, SUM((SELECT SUM(sale_product.sales_price_excluding_vat - (sale_product.quantity * sale_product.purchase_price)) FROM sale_product WHERE sale_product.invoice_id = i.id)) AS margin, (SELECT SUM((sale_product.quantity * sale_product.purchase_price)) FROM sale_product WHERE sale_product.invoice_id = i.id) AS sum_of_purchase_price, (SELECT csc.commission_amount FROM client_sales_commission csc WHERE csc.invoice_details_id = i.id) AS commission_amount, (SELECT dc.total_amount FROM delivery_cost dc WHERE dc.invoice_details_id = i.id) AS delivery_cost_total_amount, (SELECT c.client_name FROM client_info c WHERE c.id = i.client_id) AS client_name, (SELECT e.employee_name FROM employee_info e WHERE e.id = i.employee_id) AS employee_name, (SELECT e.employee_code FROM employee_info e WHERE e.id = i.employee_id) AS employee_code FROM invoice_details i WHERE $where_condition")->result();
    }

    public function get_clientwise_sale_total_amount_by_date($client_id, $start_date, $end_date) {
        $where_condition = "i.client_id = '$client_id' AND i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' GROUP BY i.client_id";
        $result = $this->db->query("SELECT SUM(i.amount_to_paid) AS sum_of_amount_to_paid FROM invoice_details i WHERE $where_condition")->row();
        return (!empty($result)) ? $result->sum_of_amount_to_paid : 0;
    }

}
