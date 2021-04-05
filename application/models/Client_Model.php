<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_Model extends CI_Model {

    public $table_name = 'client_info';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_client($id = 0) {
        if ($id === 0) {
            /* $query = $this->db->get_where($this->table_name);
              return $query->result(); */
            $this->db->from($this->table_name);
            $this->db->order_by("client_name", "asc");
            $query = $this->db->get();
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function get_any_type_client($clientType)
    {
        $result = $this->db->query("SELECT * FROM `client_info` WHERE `client_type` = '$clientType'")->result();

        return $result;
    }

    public function save_client($id = 0) {
        $this->load->helper('url');
        $data = array(
            'client_name' => $this->input->post('client_name'),
            'client_code' => $this->input->post('client_code'),
            'address' => $this->input->post('address'),
            'client_area' => $this->input->post('client_area'),
            'cell_number' => $this->input->post('cell_number'),
            'phone_number' => $this->input->post('phone_number'),
            'email' => $this->input->post('email'),
            'dealer_id' => $this->input->post('dealer_id'),
            'employee_id' => $this->input->post('employee_id'),
            'remarks' => $this->input->post('remarks'),
            'credit_balance' => $this->input->post('credit_balance'),
            'total_sale' => $this->input->post('total_sale'),
            'advance_balance' => $this->input->post('advance_balance'),
            'client_type' => $this->input->post('client_type'),
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

    function is_client_name_exists($dealer_name) {
        return $result = $this->db->get_where($this->table_name, array('client_name' => $dealer_name))->row();
    }

    public function get_client_info_by_id($client_id)
    {
        $clientInfo = $this->db->query('SELECT * FROM client_info WHERE id = '.$client_id)->row();
        return $clientInfo;
    }

    function is_client_exists($id = 0, $email) {
        if ($id == 0) {
            $result = $this->db->query("SELECT * FROM client_info WHERE email = '$email'")->row();
        } else {
            $result = $this->db->query("SELECT * FROM client_info WHERE id <> $id AND email = '$email'")->row();
        }
        
        // echo "<pre>"; print_r($result); exit();
        return $result;
    }

    function get_client_by_id_for_duplicate_check($name, $id) {
        return $result = $this->db->query("SELECT * FROM client_info WHERE client_name = '$name' AND id != $id")->row();
    }

    public function get_all_client_list($employee_id, $user_type) {
        if (strtolower($user_type) == 'marketing') {
            return $query = $this->db->query("SELECT c.id, c.client_name, c.client_code, c.address, c.client_area, c.cell_number, c.phone_number, c.email, c.dealer_id, c.employee_id, c.remarks, c.credit_balance, c.total_sale, c.advance_balance, c.client_type, e.employee_name, u.id, u.user_name, u.user_type FROM client_info c LEFT JOIN employee_info e ON c.employee_id = e.id LEFT JOIN user_info u ON e.id=u.employee_id WHERE e.id = '$user_id' ORDER BY c.id desc")->result();
        } else {
            $query = $this->db->query("SELECT * FROM client_info ORDER BY id desc");
//            $this->db->from($this->table_name);
//            $this->db->order_by("id", "desc");
//            $query = $this->db->get();
            return $query->result();
        }
    }

    public function get_client_list_group_by_client_code($employee_id, $user_type) {
        if (strtolower($user_type) === 'marketing') {
            return $query = $this->db->query("SELECT c.id, c.client_name, c.client_code, c.address, c.client_area, c.cell_number, c.phone_number, c.email, c.dealer_id, c.employee_id, c.remarks, c.credit_balance, c.total_sale, c.advance_balance, c.client_type, e.employee_name, u.id, u.user_name, u.user_type FROM client_info c LEFT JOIN employee_info e ON c.employee_id = e.id LEFT JOIN user_info u ON e.id=u.employee_id WHERE e.id = '$employee_id' GROUP BY c.client_code ORDER BY c.id ASC")->result();
        } else {
            $query = $this->db->query("SELECT * FROM client_info GROUP BY client_code ORDER BY id asc");
//            $this->db->from($this->table_name);
//            $this->db->order_by("id", "asc");
//            $this->db->group_by('client_code');
//            $query = $this->db->get();
            return $query->result();
        }
    }

    public function get_client_list_with_employee($employee_id = 0) {
        if ($employee_id == 0) {
            $client_list_with_employee = $this->db->query("SELECT c.id, c.client_name, c.client_code, c.address, c.client_area, c.cell_number, c.phone_number, c.email, c.dealer_id, c.employee_id, c.remarks, c.credit_balance, c.total_sale, c.advance_balance, c.client_type, e.employee_name FROM client_info c LEFT JOIN employee_info e ON c.employee_id = e.id ORDER BY c.client_name ASC")->result();
        } else {
            $client_list_with_employee = $this->db->query("SELECT c.id, c.client_name, c.client_code, c.address, c.client_area, c.cell_number, c.phone_number, c.email, c.dealer_id, c.employee_id, c.remarks, c.credit_balance, c.total_sale, c.advance_balance, c.client_type, e.employee_name FROM client_info c LEFT JOIN employee_info e ON c.employee_id = e.id WHERE c.employee_id = '$employee_id' ORDER BY c.client_name ASC")->result();
        }
        return $client_list_with_employee;
    }

    public function get_single_client_with_employee($client_id, $employee_id = 0) {
        if ($employee_id == 0) {
            $client_with_employee = $this->db->query("SELECT c.id, c.client_name, c.client_code, c.address, c.client_area, c.cell_number, c.phone_number, c.email, c.dealer_id, c.employee_id, c.remarks, c.credit_balance, c.total_sale, c.advance_balance, c.client_type, e.employee_name FROM client_info c LEFT JOIN employee_info e ON c.employee_id = e.id WHERE c.id='$client_id'")->result();
        } else {
            $client_with_employee = $this->db->query("SELECT c.id, c.client_name, c.client_code, c.address, c.client_area, c.cell_number, c.phone_number, c.email, c.dealer_id, c.employee_id, c.remarks, c.credit_balance, c.total_sale, c.advance_balance, c.client_type, e.employee_name FROM client_info c LEFT JOIN employee_info e ON c.employee_id = e.id WHERE c.id='$client_id' AND c.employee_id = '$employee_id'")->result();
        }
        return $client_with_employee;
    }

    public function get_client_list_client_type_with_employee($client_type, $employee_id = 0) {
        if ($employee_id == 0) {
            $client_with_employee = $this->db->query("SELECT c.id, c.client_name, c.client_code, c.address, c.client_area, c.cell_number, c.phone_number, c.email, c.dealer_id, c.employee_id, c.remarks, c.credit_balance, c.total_sale, c.advance_balance, c.client_type, e.employee_name FROM client_info c LEFT JOIN employee_info e ON c.employee_id = e.id WHERE c.client_type='$client_type'")->result();
        } else {
            $client_with_employee = $this->db->query("SELECT c.id, c.client_name, c.client_code, c.address, c.client_area, c.cell_number, c.phone_number, c.email, c.dealer_id, c.employee_id, c.remarks, c.credit_balance, c.total_sale, c.advance_balance, c.client_type, e.employee_name FROM client_info c LEFT JOIN employee_info e ON c.employee_id = e.id WHERE c.client_type='$client_type' AND c.employee_id = '$employee_id'")->result();
        }
        return $client_with_employee;
    }

    public function get_all_client_by_employee_id($employee_id = 0) {
        $this->db->from($this->table_name);
        $this->db->where('employee_id', $employee_id);
        $this->db->order_by("client_name", "asc");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_client_list_by_client_type($client_type) {
        return $this->db->get_where($this->table_name, array('client_type' => $client_type))->result();
    }

    public function get_client_list_by_client_type_and_employee_id($client_type, $employee_id) {
        return $this->db->query("SELECT * FROM client_info WHERE client_type = '$client_type' AND employee_id= '$employee_id'")->result();
    }

    public function get_client_list_employee_id($employee_id) {
        return $this->db->get_where($this->table_name, array('employee_id' => $employee_id))->result();
    }

    public function get_employee_name_by_client_id($client_id) {
        $query = $this->db->query("SELECT c.*, e.employee_name FROM $this->table_name LEFT JOIN employee_info e ON c.employee_id = e.id")->row();
        return $employee_name = !empty($query) ? $query->employee_name : '';
    }

    public function get_comma_seperated_client_names($client_ids = array()) {
        $client_ids = implode(',', $client_ids);
        $query_result = $this->db->query("SELECT GROUP_CONCAT(client_name SEPARATOR ', ') AS client_names FROM $this->table_name WHERE id IN ($client_ids)")->row();
        return !empty($query_result->client_names) ? $query_result->client_names : '';
    }

    public function get_client_based_credit_reduction_report($start_month_year, $end_month_year, $client_ids = array()) {
        $total_report_array = array();
        $month_duration_count = get_month_diff($start_month_year, $end_month_year);
        $selected_month_year_array = get_selected_month_year_array($start_month_year, $end_month_year, $month_duration_count);

        if (!empty($client_ids)) {
            $client_ids_comma_seperated = implode(',', $client_ids);
            $client_list = $this->db->query("SELECT * FROM $this->table_name WHERE id IN ($client_ids_comma_seperated)")->result();
        } else {
            $client_list = $this->get_client();
        }
        if (!empty($client_list)) {
            foreach ($client_list as $client) {
                $report_array = array();
                $client_based_credit_reduction_report = array();
                if (TRUE) { // (intval($client->id) == 15)
                    $client_id = intval($client->id);
                    $client_name = ($client->client_name);
                    $client_type = ($client->client_type);
                    $cnt = 1;
                    foreach ($selected_month_year_array as $key => $value) { //$value=date
                        $month = date('m', strtotime($value));
                        $month_name = get_month_name_by_month_number($month);
                        $year = date('Y', strtotime($value));
                        $start_date = date('Y-m-01', strtotime(($year . '-' . $month)));
                        $end_date = date('Y-m-t', strtotime(($year . '-' . $month)));
                        $report = $this->get_client_sales_report($start_date, $end_date, array($client_id));
                        $report = !empty($report) ? $report[0] : '';
                        $opening_balance = !empty($report->opening_balance) ? get_floating_point_number((get_floating_point_number($report->opening_balance) * (-1))) : 0;
                        $sale_amount = !empty($report->sale_amount) ? get_floating_point_number($report->sale_amount) : 0;
                        $collection_amount = !empty($report->collection_amount) ? get_floating_point_number($report->collection_amount) : 0;
                        $closing_amount = ((($opening_balance) + $sale_amount) - $collection_amount);
                        $credit_reduction = ($opening_balance - $closing_amount);
                        $client_based_credit_reduction_report = array(
                            'client_id' => $client_id,
                            'client_name' => $client_name,
                            'client_type' => $client_type,
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'month_name' => $month_name,
                            'month' => $month,
                            'year' => $year,
                            'opening_balance' => $opening_balance,
                            'sale_amount' => $sale_amount,
                            'collection_amount' => $collection_amount,
                            'closing_amount' => $closing_amount,
                            'credit_reduction' => $credit_reduction,
                        );
//                        get_print_r($this->db->last_query());
                        array_push($report_array, $client_based_credit_reduction_report);
                        $cnt++;
                    }
                    array_push($total_report_array, array('client' => $client, 'report_array' => $report_array));
                }
            }
        }
        return $total_report_array;
    }

    /*public function get_client_sales_report($start_date, $end_date, $client_ids = array()) {
        $start_date = get_start_date_format($start_date);
        $end_date = get_end_date_format($end_date);
        $before_start_date = get_start_date_format(get_previous_month_from_selected_date($start_date, 1));
        $current_date = get_end_date_format(get_current_date());
        $client_ids = (!empty($client_ids)) ? implode(',', $client_ids) : '';
        $where_condition = (!empty($client_ids)) ? "WHERE c.id IN ($client_ids)" : "";
        return $query_result = $this->db->query("SELECT c.id, c.client_name, c.employee_id, e.employee_name, e.employee_code, 
(SELECT ctd.closing_balance FROM client_transaction_details ctd WHERE ctd.client_id = c.id AND (ctd.transaction_date) < '$start_date' ORDER BY ctd.id DESC LIMIT 1) AS opening_balance,
(SELECT SUM(amount_to_paid) FROM invoice_details i WHERE c.id = i.client_id AND i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date') AS sale_amount,
(SELECT SUM(p.amount_received) FROM payment p WHERE c.id = p.client_id AND p.receipt_date >= '$start_date' AND p.receipt_date <= '$end_date') AS collection_amount,
TIMESTAMPDIFF(MONTH, (SELECT date_of_issue FROM invoice_details i WHERE c.id = i.client_id AND i.date_of_issue < '$current_date' ORDER BY i.id DESC LIMIT 1), '$current_date') AS oldest_unpaid_bill
FROM client_info c LEFT JOIN employee_info e ON c.employee_id = e.id $where_condition")->result();
    }*/
    
    public function get_client_sales_report($start_date, $end_date, $client_ids = array()) {
        $start_date = get_start_date_format($start_date);
        $end_date = get_end_date_format($end_date);
        $before_start_date = get_start_date_format(get_previous_month_from_selected_date($start_date, 1));
        $current_date = get_end_date_format(get_current_date());
        $client_ids = (!empty($client_ids)) ? implode(',', $client_ids) : '';
        $where_condition = (!empty($client_ids)) ? "WHERE c.id IN ($client_ids)" : "";
        return $query_result = $this->db->query("SELECT c.id, c.client_name, c.employee_id, e.employee_name, e.employee_code, 
(SELECT ctd.closing_balance FROM client_transaction_details ctd WHERE ctd.client_id = c.id AND (ctd.transaction_date) < '$start_date' ORDER BY ctd.id DESC LIMIT 1) AS opening_balance,
(SELECT SUM(ctd.credit_amount) FROM client_transaction_details ctd WHERE c.id = ctd.client_id AND ctd.transaction_date >= '$start_date' AND ctd.transaction_date <= '$end_date') AS sale_amount,
(SELECT SUM(ctd.debit_amount) FROM client_transaction_details ctd WHERE c.id = ctd.client_id AND ctd.transaction_date >= '$start_date' AND ctd.transaction_date <= '$end_date') AS collection_amount,
TIMESTAMPDIFF(MONTH, (SELECT date_of_issue FROM invoice_details i WHERE c.id = i.client_id AND i.date_of_issue < '$current_date' ORDER BY i.id DESC LIMIT 1), '$current_date') AS oldest_unpaid_bill
FROM client_info c LEFT JOIN employee_info e ON c.employee_id = e.id $where_condition")->result();
    }
    
//    public function get_client_sales_report($start_date, $end_date, $client_ids = array()) {
//        $start_date = get_start_date_format($start_date);
//        $end_date = get_end_date_format($end_date);
//        $before_start_date = get_start_date_format(get_previous_month_from_selected_date($start_date, 1));
//        $current_date = get_end_date_format(get_current_date());
//        $client_ids = (!empty($client_ids)) ? implode(',', $client_ids) : '';
//        $where_condition = (!empty($client_ids)) ? "WHERE c.id IN ($client_ids)" : "";
//        return $query_result = $this->db->query("SELECT c.id, c.client_name, c.employee_id, e.employee_name, e.employee_code, 
//(SELECT ctd.closing_balance FROM client_transaction_details ctd WHERE ctd.client_id = c.id AND MONTH(ctd.transaction_date) = MONTH('$before_start_date') AND YEAR(ctd.transaction_date) = YEAR('$before_start_date') ORDER BY ctd.id DESC LIMIT 1) AS opening_balance,
//(SELECT SUM(amount_to_paid) FROM invoice_details i WHERE c.id = i.client_id AND i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date') AS sale_amount,
//(SELECT SUM(p.amount_received) FROM payment p WHERE c.id = p.client_id AND p.receipt_date >= '$start_date' AND p.receipt_date <= '$end_date') AS collection_amount,
//TIMESTAMPDIFF(MONTH, (SELECT date_of_issue FROM invoice_details i WHERE c.id = i.client_id AND i.date_of_issue < '$current_date' ORDER BY i.id DESC LIMIT 1), '$current_date') AS oldest_unpaid_bill
//FROM client_info c LEFT JOIN employee_info e ON c.employee_id = e.id $where_condition")->result();
//    }

}
