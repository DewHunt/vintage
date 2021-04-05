<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sale_product_Model extends CI_Model {

    public $table_name = 'sale_product';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getSaleProductInformationByInvoiceId($invoiceId)
    {
        $saleProductDetails = $this->db->query("
            SELECT `sale_product`.*,`product`.`product_name` AS `productName`,`product`.`product_code` AS `productCode`,`product`.`vat_rate` AS `productVatRate`
            FROM `sale_product`
            LEFT JOIN `product` ON `product`.`id` = `sale_product`.`product_id`
            WHERE `sale_product`.`invoice_id` = $invoiceId
        ")->result();

        return $saleProductDetails;
    }

    public function get_sale_product($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function get_sale_product_list($id = 0) {
        // $query = $this->db->get_where($this->table_name, array('invoice_id' => $id));
        $result = $this->db->query("
            SELECT `sale_product`.*, `product`.`product_name` AS `productName`, `branch_info`.`branch_name` AS `branchName`
            FROM `sale_product`
            LEFT JOIN `product` ON `product`.`id` = `sale_product`.`product_id`
            LEFT JOIN `branch_info` ON `branch_info`.`id` = `sale_product`.`branch_id`
            WHERE `sale_product`.`invoice_id` = $id
        ")->result();
        return $result;
    }

    public function get_sale_product_list_row($id = 0) {
        $query = $this->db->get_where($this->table_name, array('invoice_id' => $id));
        return $query->row();
    }

    public function save_sale_product($id = 0) {
        $this->load->helper('url');
        $data = array(
            'product_id' => $this->input->post('product_id'),
            'branch_id' => $this->input->post('branch_id'),
            'pack_size' => $this->input->post('pack_size'),
            'quantity' => $this->input->post('quantity'),
            'unit_price' => $this->input->post('unit_price'),
            'sales_price_excluding_vat' => $this->input->post('sales_price_excluding_vat'),
            'vat' => $this->input->post('vat'),
            'sales_price_including_vat' => $this->input->post('sales_price_including_vat'),
            'invoice_id' => $this->input->post('invoice_id'),
            'gate_pass_remarks' => $this->input->post('gate_pass_remarks'),
        );
        if ($id === 0) {
            return $this->db->insert($this->table_name, $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update($this->table_name, $data);
        }
    }

    public function get_order_summary_product($start_date,$end_date,$branch_id)
    {
        $where_condition = "";
        $groupBy = "";

        if ($start_date) {
            $where_condition .= "DATE_FORMAT(order_date,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
            $groupBy = "product_id";
        }

        if ($branch_id) {
            $where_condition .= "AND branchId = $branch_id";
            $groupBy = "branchId, product_id";
        }        

        $result = $this->db->query("
            SELECT productName, SUM(sales_price_excluding_vat) AS sales_price_excluding_vat
            FROM view_order_summary_product 
            WHERE $where_condition
            GROUP BY $groupBy
        ")->result();

        return $result;
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
    }

    public function get_sale_product_by_invoice_id_and_product_id($invoice_id, $product_id) {
        $query = $this->db->query("SELECT * FROM sale_product WHERE invoice_id = '$invoice_id' AND product_id = '$product_id'");
        return $query->row();
    }

    public function update_product_delivery_status_by_id_and_invoice_id($id,$delivery_status,$invoice_id)
    {
        if ($delivery_status == 0) {
            $status_value = 1;
        }
        else {
            $status_value = 2;
        }

        $this->db->query("UPDATE sale_product SET delivery_status = $status_value WHERE id = $id");

        $total_invoice = $this->db->query("SELECT COUNT(`invoice_id`) AS `totalInvoice` FROM `sale_product` WHERE `invoice_id` = $invoice_id AND `delivery_status` = 1")->row();

        if ($total_invoice->totalInvoice == 0) {
            $this->db->query("UPDATE invoice_details SET delivery_status = 1 WHERE id = $invoice_id");
        }
        
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        return FALSE;    
    }

    public function update_product_delivery_status_by_invoice_id($invoice_id)
    {
        $this->db->query("UPDATE sale_product SET delivery_status = 2 WHERE invoice_id = $invoice_id");

        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        return FALSE;    
    }
}
