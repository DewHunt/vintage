<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_product_return_info_Model extends CI_Model {

    public $table_name = 'client_product_return_info';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_client_product_return_info($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_client_product_return_info($id = 0) {
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
        $this->db->delete($this->table_name);
    }

    public function get_invoice_void_report_by_date_and_branch_id($start_date,$end_date,$factory_id,$branch_id)
    {
        $where_query = "";
        $join_query = "";

        if ($start_date) {
            $where_query .= " DATE_FORMAT(`client_product_return_info`.`return_date`,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
        }

        if ($factory_id) {
            $where_query .= " AND `client_product_return_info`.`branch_id` = $factory_id";
            $join_query = " AND `branch_info`.`factory_status` = 1 AND `branch_info`.`hot_kitchen_status` = 0";
        }

        if ($branch_id) {
            $join_query = " AND `branch_info`.`factory_status` = 0 AND `branch_info`.`hot_kitchen_status` = 0";
            if ($branch_id != 'all') {
                $where_query .= " AND `client_product_return_info`.`branch_id` = $branch_id";
            }
        }

        if ($where_query) {
            $where_query = "WHERE ".$where_query;
        }

        $result = $this->db->query("
            SELECT `client_product_return_info`.*,`branch_info`.`branch_name` AS `branchName`,`client_info`.`client_name` AS `clientName`
            FROM `client_product_return_info`
            LEFT JOIN `client_info` ON `client_info`.`id` = `client_product_return_info`.`client_id`
            LEFT JOIN `branch_info` ON `branch_info`.`id` = `client_product_return_info`.`branch_id` $join_query
            $where_query AND `branch_info`.`id` IS NOT NULL
        ")->result();

        return $result;
    }

    public function get_client_product_return_info_by_date_and_client($start_date, $end_date, $client_id) {
        if (empty($client_id) || ((int) $client_id <= 0)) {
            $query_result = $this->db->query("SELECT cpri.id, cpri.return_date, cpri.branch_id, cpri.client_id, cpri.invoice_number, cpri.challan_number, cpri.total_amount, cpri.return_amount, cpri.total_amount_after_return, cpri.remarks, cpri.user_id, br.branch_name, br.branch_code, c.client_name, c.client_code, u.user_name, u.user_type FROM client_product_return_info cpri LEFT JOIN branch_info br ON cpri.branch_id=br.id LEFT JOIN client_info c ON cpri.client_id=c.id LEFT JOIN user_info u ON cpri.user_id=u.id WHERE cpri.return_date >= '$start_date' AND cpri.return_date <= '$end_date'")->result();
        } else {
            $query_result = $this->db->query("SELECT cpri.id, cpri.return_date, cpri.branch_id, cpri.client_id, cpri.invoice_number, cpri.challan_number, cpri.total_amount, cpri.return_amount, cpri.total_amount_after_return, cpri.remarks, cpri.user_id, br.branch_name, br.branch_code, c.client_name, c.client_code, u.user_name, u.user_type FROM client_product_return_info cpri LEFT JOIN branch_info br ON cpri.branch_id=br.id LEFT JOIN client_info c ON cpri.client_id=c.id LEFT JOIN user_info u ON cpri.user_id=u.id WHERE cpri.return_date >= '$start_date' AND cpri.return_date <= '$end_date' AND cpri.client_id = '$client_id'")->result();
        }
        return $query_result;
    }

    public function get_client_product_return_info_with_client($id) {
        $query = $this->db->query("SELECT cpri.id, cpri.return_date, cpri.branch_id, cpri.client_id, cpri.invoice_number, cpri.challan_number, cpri.total_amount, cpri.return_amount, cpri.total_amount_after_return, cpri.remarks, cpri.user_id, br.branch_name, br.branch_code, c.client_name, c.client_code, u.user_name, u.user_type FROM client_product_return_info cpri LEFT JOIN branch_info br ON cpri.branch_id=br.id LEFT JOIN client_info c ON cpri.client_id=c.id LEFT JOIN user_info u ON cpri.user_id=u.id WHERE cpri.id='$id'")->row();
        return $query;
    }

}
