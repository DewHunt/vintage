<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_sales_details_Model extends CI_Model {

    public $table_name = 'client_sales_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_client_sales_details($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_client_sales_details($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'client_id' => $this->input->post('client_id'),
            'sale_date' => $this->input->post('sale_date'),
            'total_credit_balance' => $this->input->post('total_credit_balance'),
            'total_advance_balance' => $this->input->post('total_advance_balance'),
            'total_sale' => $this->input->post('total_sale'),
            'total_payment' => $this->input->post('total_payment'),
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
        $this->db->delete('client_sales_details');
    }

    public function get_customer_bill_by_date_and_customer_id($start_date,$end_date,$client_id)
    {
        $where_query = "";

        if ($start_date) {
            $where_query .= " DATE_FORMAT(`client_sales_details`.`sale_date`,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
        }

        if ($client_id != 'all') {
            $where_query .= " AND `client_sales_details`.`client_id` = $client_id";
        }

        if ($where_query) {
            $where_query = 'WHERE '.$where_query;
        }

        $result = $this->db->query("
            SELECT `client_sales_details`.`client_id` AS `clientId`,`client_info`.`client_name` AS `clientName`,`client_info`.`client_code` AS `clientCode`,`client_info`.`phone_number` AS `clientPhoneNumber`,(SELECT COUNT(`invoice_details`.`id`) AS `totalOrder` FROM `invoice_details` WHERE `invoice_details`.`client_id` = `client_sales_details`.`client_id` AND DATE_FORMAT(`invoice_details`.`order_date`,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date') AS `totalOrder`,SUM(`client_sales_details`.`total_payment_from_advanced` + `client_sales_details`.`total_payment`) AS `paidAmount`,SUM(`client_sales_details`.`total_sale`) AS `saleAmount`
            FROM `client_sales_details`
            LEFT JOIN `client_info` ON `client_info`.`id` = `client_sales_details`.`client_id`
            $where_query
            GROUP BY `client_sales_details`.`client_id`
        ")->result();
                    // echo "<pre>"; print_r($result); exit();

        return $result;
    }

    public function get_opening_balance_by_date_and_client_id($client_id,$start_date)
    {
        $result = $this->db->query("SELECT * FROM `client_sales_details` WHERE `client_id` = $client_id AND DATE_FORMAT(`sale_date`,'%Y-%m-%d') < '$start_date' ORDER BY `id` DESC LIMIT 1")->row();

        return $result;
    }

    public function get_client_sales_details_by_client_id($client_id) {
        $query = $this->db->get_where($this->table_name, array('client_id' => $client_id));
        return $query->row();
    }

    public function get_client_sales_details_by_date($client_id, $sale_date) {
        //$query = $this->db->query("SELECT * FROM client_sales_details WHERE client_id='$client_id' AND sale_date='$sale_date'");
        $this->db->from('client_sales_details');
        $this->db->where("(client_id='$client_id' AND DATE_FORMAT(sale_date,'%Y-%m-%d')='$sale_date')");
        $query = $this->db->get();
        return $query->row();
    }

    public function get_last_client_sales_details_by_date($client_id, $date) {
        $date = get_start_date_format($date);
        $query = $this->db->query("SELECT * FROM client_sales_details WHERE client_id='$client_id' AND sale_date < '$date' ORDER BY id DESC LIMIT 1");
        return $query->row();
    }
    
    public function get_last_client_sales_details_by_end_date($client_id, $date) {
        $date = get_end_date_format($date);
        $query = $this->db->query("SELECT * FROM client_sales_details WHERE client_id='$client_id' AND sale_date <= '$date' ORDER BY id DESC LIMIT 1");
        return $query->row();
    }
    
    public function get_client_sales_details_by_end_date($client_id, $date) {
        $date = get_end_date_format($date);
        $query = $this->db->query("SELECT * FROM client_sales_details WHERE client_id='$client_id' AND sale_date <= '$date' ORDER BY id DESC LIMIT 1");
        return $query->row();
    }

    public function get_client_all_sales_details_by_date($client_id, $start_date, $end_date) {
        if ($client_id > 0) {
            $query = $this->db->query("SELECT csd.id, csd.client_id, csd.sale_date, csd.total_credit_balance, csd.total_advance_balance, csd.total_sale, csd.total_payment, c.client_name, c.client_code, d.dealer_name, d.dealer_code, e.employee_name, e.employee_code FROM client_sales_details csd LEFT JOIN client_info c ON csd.client_id=c.id LEFT JOIN dealer_info d ON c.dealer_id=d.id LEFT JOIN employee_info e ON c.employee_id=e.id WHERE csd.client_id='$client_id' AND csd.sale_date >= '$start_date' AND csd.sale_date <= '$end_date' ORDER BY csd.id ASC");
        } else {
            $query = $this->db->query("SELECT csd.id, csd.client_id, csd.sale_date, csd.total_credit_balance, csd.total_advance_balance, SUM(csd.total_sale), SUM(csd.total_payment), c.client_name, c.client_code, d.dealer_code, e.employee_code FROM client_sales_details csd LEFT JOIN client_info c ON csd.client_id=c.id LEFT JOIN dealer_info d ON c.dealer_id=d.id LEFT JOIN employee_info e ON c.employee_id=e.id WHERE csd.sale_date >= '$start_date' AND csd.sale_date <= '$end_date' ORDER BY csd.id ASC");
        }
        return $query->result();
    }

    public function get_immediate_last_date($client_id, $date) {
        $query = $this->db->query("SELECT * FROM client_sales_details WHERE client_id='$client_id' AND sale_date < '$date' ORDER BY id DESC LIMIT 1");
        return $query->row();
    }

}
