<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_Model extends CI_Model {

    public $table_name = 'employee_info';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_employee($id = 0) {
        if ($id === 0) {
            /* $query = $this->db->get_where($this->table_name);
              return $query->result(); */
            $this->db->from($this->table_name);
            $this->db->order_by("sort_order", "asc");
            $query = $this->db->get();
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_employee($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'employee_name' => $this->input->post('employee_name'),
            'employee_code' => $this->input->post('employee_code'),
            'employee_email' => $this->input->post('employee_email'),
            'designation' => $this->input->post('designation'),
            'gender' => $this->input->post('gender'),
            'phone' => $this->input->post('phone'),
            'mobile' => $this->input->post('mobile'),
            'address' => $this->input->post('address'),
            'joining_date' => $this->input->post('joining_date'),
            'closing_date' => $this->input->post('closing_date'),
            'basic_salary' => $this->input->post('basic_salary'),
            'phone_allowance' => $this->input->post('phone_allowance'),
            'tuition_allowance' => $this->input->post('tuition_allowance'),
            'attendance_allowance' => $this->input->post('attendance_allowance'),
            'bonus' => $this->input->post('bonus'),
            'others' => $this->input->post('others'),
            'pf_contribution' => $this->input->post('pf_contribution'),
            'loan_installment' => $this->input->post('loan_installment'),
            'is_loan' => $this->input->post('is_loan'),
            'current_loan_id' => $this->input->post('current_loan_id'),
            'deactivate_employee' => $this->input->post('deactivate_employee'),
            'sort_order' => $this->input->post('sort_order'),
            'permanent_address' => $this->input->post('permanent_address'),
            'blood_group' => $this->input->post('blood_group'),
            'others_benefit' => $this->input->post('others_benefit'),
            'less_others_benefit' => $this->input->post('less_others_benefit'),
            'less_others_misc' => $this->input->post('less_others_misc'),
            'pf_contribution_company_part' => $this->input->post('pf_contribution_company_part'),
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
        $this->db->delete('employee_info');
    }

    public function get_employee_list($employee_id) {
        if ($employee_id == 0) {
//            $query = $this->db->get_where($this->table_name);
//            return $query->result();
            $this->db->from($this->table_name);
            $this->db->order_by("sort_order", "asc");
            $query = $this->db->get();
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $employee_id));
            return $query->result();
        }
    }

    public function get_employee_by_sort_order() {
        $this->db->from($this->table_name);
        $this->db->order_by("sort_order", "asc");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_employee_name_by_id($id) {
        $query = $this->db->get_where($this->table_name, array('id' => $id))->row();
        return (!empty($query)) ? $query->employee_name : '';
    }

    public function get_comma_seperated_employee_names($employee_ids = array()) {
        $employee_ids = implode(',', $employee_ids);
        $query_result = $this->db->query("SELECT GROUP_CONCAT(employee_name SEPARATOR ', ') AS employee_names FROM $this->table_name WHERE id IN ($employee_ids)")->row();
        return !empty($query_result->employee_names) ? $query_result->employee_names : '';
    }

    public function get_monthly_sales_collection_report($start_date, $end_date, $employee_ids) {
        //$employee_ids = array()
        //here get always last target of an employee
        if (empty($employee_ids)) { // for all employee
            $res = $this->db->query("SELECT id FROM $this->table_name")->result_array();
            $employee_ids = (!empty($res) ? (array_column($res, 'id')) : '');
        }
        if (!empty($employee_ids)) {
            $array = array();
            foreach ($employee_ids as $key => $value) {
                $emp = $value;
                $where_condition = (!empty($emp)) ? "WHERE e.id IN ($emp)" : "";
                $client_ids = (!empty($emp)) ? $this->db->query("SELECT c.id AS client_id FROM client_info c WHERE c.employee_id IN ($emp)")->result() : '';
                $client_ids = !empty($client_ids) ? implode(",", array_column($client_ids, "client_id")) : '';
                $client_ids_condition = !empty($client_ids) ? "(SELECT SUM(amount_to_paid) FROM invoice_details i WHERE i.client_id IN ($client_ids) AND i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date') AS sale_amount, " : "0 AS sale_amount, ";
                $query_result = $this->db->query("SELECT e.id AS employee_id, e.employee_name, e.employee_code, "
                                . "(SELECT et.target_amount FROM employee_target et WHERE et.employee_id = e.id ORDER BY et.id DESC LIMIT 1) AS target_amount, "
                                . $client_ids_condition
                                . "(SELECT SUM(p.amount_received) FROM payment p LEFT JOIN client_info c ON p.client_id = c.id WHERE c.employee_id = e.id AND p.receipt_date >= '$start_date' AND p.receipt_date <= '$end_date') AS collection_amount "
                                . "FROM employee_info e $where_condition")->result();
                if (!empty($query_result)) {
                    array_push($array, ($query_result[0]));
                }
            }
            return !empty($array) ? $array : '';
        }
    }
    
    /*public function get_monthly_sales_collection_report($start_date, $end_date, $employee_ids) {
        //$employee_ids = array()
        //here get always last target of an employee
        if (empty($employee_ids)) { // for all employee
            $res = $this->db->query("SELECT id FROM $this->table_name")->result_array();
            $employee_ids = (!empty($res) ? (array_column($res, 'id')) : '');
        }
        if (!empty($employee_ids)) {
            $array = array();
            foreach ($employee_ids as $key => $value) {
                $emp = $value;
                $where_condition = (!empty($emp)) ? "WHERE e.id IN ($emp)" : "";

                $client_ids = (!empty($emp)) ? $this->db->query("SELECT c.id AS client_id FROM client_info c WHERE c.employee_id IN ($emp)")->result() : '';
                $client_ids = !empty($client_ids) ? implode(",", array_column($client_ids, "client_id")) : '';
                $client_ids_condition = !empty($client_ids) ? "i.client_id IN ($client_ids) AND" : '';
                $query_result = $this->db->query("SELECT e.id AS employee_id, e.employee_name, e.employee_code, "
                                . "(SELECT et.target_amount FROM employee_target et WHERE et.employee_id = e.id ORDER BY et.id DESC LIMIT 1) AS target_amount, "
                                . "(SELECT SUM(amount_to_paid) FROM invoice_details i WHERE $client_ids_condition i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date') AS sale_amount, "
                                . "(SELECT SUM(p.amount_received) FROM payment p LEFT JOIN client_info c ON p.client_id = c.id WHERE c.employee_id = e.id AND p.receipt_date >= '$start_date' AND p.receipt_date <= '$end_date') AS collection_amount "
                                . "FROM employee_info e $where_condition")->result();
                if (!empty($query_result)) {
                    array_push($array, ($query_result[0]));
                }
            }
            return !empty($array) ? $array : '';
        }
    }*/

    /* public function get_monthly_sales_collection_report($start_date, $end_date, $employee_ids) {
      //$employee_ids = array()
      //here get always last target of an employee
      $employee_ids = (!empty($employee_ids)) ? implode(',', $employee_ids) : '';
      $where_condition = (!empty($employee_ids)) ? "WHERE e.id IN ($employee_ids)" : "";

      $client_ids = (!empty($employee_ids)) ? $this->db->query("SELECT c.id AS client_id FROM client_info c WHERE c.employee_id IN ($employee_ids)")->result() : '';
      $client_ids = !empty($client_ids) ? implode(",", array_column($client_ids, "client_id")) : '';
      $client_ids_condition = !empty($client_ids) ? "i.client_id IN ($client_ids) AND" : '';
      return $query_result = $this->db->query("SELECT e.id AS employee_id, e.employee_name, e.employee_code, "
      . "(SELECT et.target_amount FROM employee_target et WHERE et.employee_id = e.id ORDER BY et.id DESC LIMIT 1) AS target_amount, "
      . "(SELECT SUM(amount_to_paid) FROM invoice_details i WHERE $client_ids_condition i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date') AS sale_amount, "
      . "(SELECT SUM(p.amount_received) FROM payment p LEFT JOIN client_info c ON p.client_id = c.id WHERE c.employee_id = e.id AND p.receipt_date >= '$start_date' AND p.receipt_date <= '$end_date') AS collection_amount "
      . "FROM employee_info e $where_condition")->result();
      } */
    
    /*public function get_monthly_sales_collection_report($start_date, $end_date, $employee_ids) {
        //$employee_ids = array()
        //here get always last target of an employee
        $employee_ids = (!empty($employee_ids)) ? implode(',', $employee_ids) : '';
        $where_condition = (!empty($employee_ids)) ? "WHERE e.id IN ($employee_ids)" : "";
        return $query_result = $this->db->query("SELECT e.id AS employee_id, e.employee_name, e.employee_code, (SELECT et.target_amount FROM employee_target et WHERE et.employee_id = e.id ORDER BY et.id DESC LIMIT 1) AS target_amount, (SELECT SUM(amount_to_paid) FROM invoice_details i WHERE e.id = i.employee_id AND i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date') AS sale_amount, (SELECT SUM(p.amount_received) FROM payment p LEFT JOIN client_info c ON p.client_id = c.id WHERE c.employee_id = e.id AND p.receipt_date >= '$start_date' AND p.receipt_date <= '$end_date') AS collection_amount FROM employee_info e $where_condition")->result();
    }*/

    public function get_monthly_progress_report($start_month_year, $end_month_year, $employee_ids = array()) {
        $employee_target_obj = new Employee_target_Model();
        $total_report_array = array();
        $month_duration_count = get_month_diff($start_month_year, $end_month_year);

//        $previous_month_year_array_by_duration = $this->get_previous_month_year_array_by_duration($start_month_year_string, $end_month_year_string, $month_duration_count);
        $selected_month_year_array = get_selected_month_year_array($start_month_year, $end_month_year, $month_duration_count);

        if (!empty($employee_ids)) {
            $employee_ids_comma_seperated = implode(',', $employee_ids);
            $employee_list = $this->db->query("SELECT * FROM $this->table_name WHERE id IN ($employee_ids_comma_seperated)")->result();
        } else {
            $employee_list = $this->get_employee();
        }

        if (!empty($employee_list)) {
            foreach ($employee_list as $employee) {
                $report_array = array();
                $employee_progress_report_array = array();
                if (TRUE) { // (intval($employee->id) == 15)
                    $employee_id = intval($employee->id);
                    $employee_name = ($employee->employee_name);
                    $employee_code = ($employee->employee_code);
                    $target_amount = 0;
                    $accumulated_target_amount = 0;
                    $accumulated_sale_amount = 0;
                    $accumulated_collection_amount = 0;
                    foreach ($selected_month_year_array as $key => $value) { //$value=date
                        $month = date('m', strtotime($value));
                        $month_name = get_month_name_by_month_number($month);
                        $year = date('Y', strtotime($value));
                        $start_date = date('Y-m-01', strtotime(($year . '-' . $month)));
                        $end_date = date('Y-m-t', strtotime(($year . '-' . $month)));
                        $target_amount = $employee_target_obj->get_employee_target_amount_by_date($start_date, $end_date, $employee_id);
//                        echo '<pre>';
//                        print_r($this->db->last_query());
                        $monthly_sales_collection_report = $this->get_monthly_sales_collection_report($start_date, $end_date, array($employee_id));
                        $monthly_sales_collection_report = !empty($monthly_sales_collection_report) ? $monthly_sales_collection_report[0] : '';
                        $sale_amount = !empty($monthly_sales_collection_report->sale_amount) ? get_floating_point_number($monthly_sales_collection_report->sale_amount) : 0;
                        $collection_amount = !empty($monthly_sales_collection_report->collection_amount) ? get_floating_point_number($monthly_sales_collection_report->collection_amount) : 0;


                        $monthly_sales_collection_report_for_average = $this->get_monthly_sales_collection_report(get_previous_month_from_selected_date($start_date, ($month_duration_count - 1)), $end_date, array($employee_id));

                        $monthly_sales_collection_report_for_average = !empty($monthly_sales_collection_report_for_average) ? $monthly_sales_collection_report_for_average[0] : '';

                        $average_sale_amount = !empty($monthly_sales_collection_report_for_average->sale_amount) ? (get_floating_point_number($monthly_sales_collection_report_for_average->sale_amount) / $month_duration_count) : 0;
                        $average_collection_amount = !empty($monthly_sales_collection_report_for_average->collection_amount) ? (get_floating_point_number($monthly_sales_collection_report_for_average->collection_amount) / $month_duration_count) : 0;

                        $accumulated_target_amount += $target_amount;
                        $accumulated_sale_amount += $sale_amount;
                        $accumulated_collection_amount += $collection_amount;
                        $employee_progress_report_array = array(
                            'employee_id' => $employee_id,
                            'employee_name' => $employee_name,
                            'employee_code' => $employee_code,
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'month_name' => $month_name,
                            'month' => $month,
                            'year' => $year,
                            'target_amount' => $target_amount,
                            'sale_amount' => $sale_amount,
                            'collection_amount' => $collection_amount,
                            'average_sale_amount' => $average_sale_amount,
                            'average_collection_amount' => $average_collection_amount,
                            'accumulated_target_amount' => $accumulated_target_amount,
                            'accumulated_sale_amount' => $accumulated_sale_amount,
                            'accumulated_collection_amount' => $accumulated_collection_amount,
                        );
                        array_push($report_array, $employee_progress_report_array);
                    }
                    array_push($total_report_array, array('employee' => $employee, 'report_array' => $report_array));
                }
            }
        }
        return $total_report_array;
    }

    public function get_previous_month_year_array_by_duration($start_month_year_string, $end_month_year_string, $month_duration_count) {
        $array = array();
        $date = '';
        $start = date("Y-m-01", strtotime($start_month_year_string));
        $end = date("Y-m-t", strtotime($end_month_year_string));
        for ($i = 1; $i < $month_duration_count; $i++) {
            $date = get_previous_month_from_selected_date($start, $i);
            array_push($array, $date);
        }
        return $array;
    }

    /* public function get_itemwise_sales_report($start_date, $end_date, $employee_ids = array()) {
      //        $start_date = get_start_date_format(date('Y-m-01', strtotime(($start_month_year))));
      //        $end_date = get_end_date_format(date('Y-m-t', strtotime(($end_month_year))));
      if (!empty($employee_ids)) {
      $employee_ids = implode(',', $employee_ids);
      $employee_id_condition = "AND i.employee_id IN ($employee_ids)";
      } else {
      $employee_id_condition = "";
      }
      $where_condition = "WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' $employee_id_condition AND p.id > 0 GROUP BY s.product_id ORDER BY p.sort_order ASC";
      return $this->db->query("SELECT i.employee_id, i.invoice_number, c.client_name, i.date_of_issue, i.branch_id, br.branch_name, p.product_name, p.api, p.sae, p.iso, s.product_id, s.pack_size, SUM(s.quantity) AS quantity, s.unit_price, ((SELECT SUM(sale_product.quantity * sale_product.unit_price) AS total_amount FROM sale_product LEFT JOIN invoice_details ON sale_product.invoice_id = invoice_details.id WHERE sale_product.product_id = s.product_id AND invoice_details.date_of_issue >= '$start_date' AND invoice_details.date_of_issue <= '$end_date' GROUP BY sale_product.product_id)) AS total_amount, u.user_name, u.user_type, u.employee_id AS user_employee_id FROM invoice_details i LEFT JOIN sale_product s ON s.invoice_id=i.id LEFT JOIN client_info c ON c.id= i.client_id LEFT JOIN branch_info br ON i.branch_id = br.id LEFT JOIN product p ON s.product_id = p.id LEFT JOIN user_info u ON i.user_id=u.id $where_condition")->result();
      } */

    public function get_itemwise_sales_report($start_date, $end_date, $employee_ids = array()) {
        if (!empty($employee_ids)) {
            $employee_ids = implode(',', $employee_ids);
            $employee_id_condition = "AND i.employee_id IN($employee_ids)";
        } else {
            $employee_id_condition = "";
        }
        $where_condition = "WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' $employee_id_condition AND p.id > 0 GROUP BY sp.product_id ORDER BY p.sort_order ASC";
        return $this->db->query("SELECT i.employee_id, sp.product_id, sp.pack_size, p.product_name, p.api, p.sae, p.iso, SUM(sp.quantity) AS quantity, sp.unit_price, SUM(sp.quantity*sp.unit_price) AS total_amount FROM sale_product sp LEFT JOIN invoice_details i ON sp.invoice_id = i.id LEFT JOIN product p ON sp.product_id = p.id $where_condition")->result();
    }

    public function get_outstanding_report($start_date, $end_date, $employee_ids = array()) {
        //$employee_ids = array()
        //here get always last target of an employee
//        $start_date = get_start_date_format(date('Y-m-01', strtotime(($start_month_year))));
//        $end_date = get_end_date_format(date('Y-m-t', strtotime(($end_month_year))));

        $current_date = get_end_date_format(get_current_date());
        $before_start_date = get_end_date_format($start_date);
        $employee_ids = (!empty($employee_ids)) ? implode(',', $employee_ids) : '';
        $where_condition = (!empty($employee_ids)) ? "WHERE c.employee_id IN ($employee_ids)" : "";

        return $query_result = $this->db->query("SELECT c.id AS client_id, c.client_name, c.employee_id, e.employee_name, e.employee_code, 
(SELECT ctd.closing_balance FROM client_transaction_details ctd WHERE ctd.client_id = c.id AND ctd.transaction_date <= '$before_start_date' ORDER BY ctd.id DESC LIMIT 1) AS opening_balance,
(SELECT SUM(amount_to_paid) FROM invoice_details i WHERE c.id = i.client_id AND i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date') AS sale_amount,
(SELECT SUM(p.amount_received) FROM payment p WHERE c.id = p.client_id AND p.receipt_date >= '$start_date' AND p.receipt_date <= '$end_date') AS collection_amount
FROM client_info c LEFT JOIN employee_info e ON c.employee_id = e.id $where_condition")->result();
    }

    //TIMESTAMPDIFF(MONTH, (SELECT date_of_issue FROM invoice_details i WHERE c.id = i.client_id AND i.date_of_issue < '$current_date' ORDER BY i.id DESC LIMIT 1), '$current_date') AS oldest_unpaid_bill

    public function get_oldest_unpaid_bill_date($client_id) {
        $res = $this->db->query("SELECT i.id, i.date_of_issue, i.client_id, i.amount_to_paid, c.total_sale, c.credit_balance, (c.total_sale - c.credit_balance) AS client_payment FROM invoice_details i LEFT JOIN client_info c ON i.client_id = c.id WHERE i.client_id = '$client_id'")->result();
        $client_payment = 0;
        $sum = 0;
        if (!empty($res)) {
            foreach ($res as $r) {
                $client_payment = !empty($r->client_payment) ? $r->client_payment : 0;
                $sum += !empty($r->amount_to_paid) ? $r->amount_to_paid : 0;
                if ($sum > $client_payment) {
                    return !empty($r->date_of_issue) ? $r->date_of_issue : NULL;
                }
            }
        }
        return NULL;
//        $res = $this->db->query("SELECT i.id, i.date_of_issue, i.client_id, i.amount_to_paid, c.total_sale, c.credit_balance, (c.total_sale - c.credit_balance) AS client_payment FROM invoice_details i LEFT JOIN client_info c ON i.client_id = c.id WHERE i.client_id = $client_id GROUP BY i.client_id HAVING SUM(i.amount_to_paid) > client_payment")->row();
//        return !empty($res->date_of_issue) ? $res->date_of_issue : NULL;
    }

    public function get_employee_based_credit_reduction_report($start_month_year, $end_month_year, $employee_ids = array()) {
      	$emp_id = 0;
        $client_id = 0;
        $client_name = '';
        $client_type = '';
        $total_report_array = array();
        $month_duration_count = get_month_diff($start_month_year, $end_month_year);
        $selected_month_year_array = get_selected_month_year_array($start_month_year, $end_month_year, $month_duration_count);

        if (!empty($employee_ids)) {
            foreach ($employee_ids as $k => $emp_id) {
                $employee = $this->get_employee($emp_id);
                $client_list = $this->db->query("SELECT * FROM client_info WHERE employee_id IN ($emp_id)")->result();
//                get_print_r($emp_id);
                $report_array = array();
                foreach ($selected_month_year_array as $key => $value) { //$value=date
                    $month = date('m', strtotime($value));
                    $month_name = get_month_name_by_month_number($month);
                    $year = date('Y', strtotime($value));
                    $start_date = date('Y-m-01', strtotime(($year . '-' . $month)));
                    $end_date = date('Y-m-t', strtotime(($year . '-' . $month)));
                    $sum_of_opening_balance = 0;
                    $sum_of_sale_amount = 0;
                    $sum_of_collection_amount = 0;
                    $sum_of_closing_amount = 0;
                    $sum_of_credit_reduction = 0;
                    if (!empty($client_list)) {
                        foreach ($client_list as $client) {
//                        $client_list = array(1136, 1137, 1138, 1139, 1143, 1148, 1149, 1150, 1151, 1153);
//                        foreach ($client_list as $k => $v) {
//                            $client = $this->db->query("SELECT * FROM client_info WHERE id = $v")->row();
                            $client_id = intval($client->id);
                            $client_name = ($client->client_name);
                            $client_type = ($client->client_type);
                            $report = $this->get_client_sales_report($start_date, $end_date, array($client_id));
//                            get_print_r($this->db->last_query());
                            $report = !empty($report) ? $report[0] : '';
                            $opening_balance = !empty($report->opening_balance) ? get_floating_point_number((get_floating_point_number($report->opening_balance) * (-1))) : 0;
                            $sum_of_opening_balance += $opening_balance;
                            $sale_amount = !empty($report->sale_amount) ? get_floating_point_number($report->sale_amount) : 0;
                            $sum_of_sale_amount += $sale_amount;
                            $collection_amount = !empty($report->collection_amount) ? get_floating_point_number($report->collection_amount) : 0;
                            $sum_of_collection_amount += $collection_amount;
                            $closing_amount = $this->get_closing_balance($start_date, $end_date, $client_id);
                            $closing_amount = ((($opening_balance) + $sale_amount) - $collection_amount);
                            $credit_reduction = ($opening_balance - $closing_amount);
//                            $closing_amount = !empty($report->closing_balance) ? get_floating_point_number($report->closing_balance) : 0;
//                            $closing_amount = (($opening_balance + $sale_amount) - $collection_amount);
                            $sum_of_closing_amount += $closing_amount;
//                            $credit_reduction = ($opening_balance - ($closing_amount*(-1)));
                            $sum_of_credit_reduction += $credit_reduction;
                        }
                    }
                    $client_based_credit_reduction_report = array(
                        'employee_id' => $emp_id,
                        'client_id' => $client_id,
                        'client_name' => $client_name,
                        'client_type' => $client_type,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'month_name' => $month_name,
                        'month' => $month,
                        'year' => $year,
                        'opening_balance' => $sum_of_opening_balance,
                        'sale_amount' => $sum_of_sale_amount,
                        'collection_amount' => $sum_of_collection_amount,
                        'closing_amount' => $sum_of_closing_amount,
                        'credit_reduction' => $sum_of_credit_reduction,
                    );
//                                            get_print_r($this->db->last_query());
                    array_push($report_array, $client_based_credit_reduction_report);
                }
                array_push($total_report_array, array('employee' => $employee, 'report_array' => $report_array));
            }
        }
//        get_print_r($total_report_array);
        return $total_report_array;
    }

    /* public function get_client_sales_report($start_date, $end_date, $client_ids = array()) {
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
      } */

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

    public function get_closing_balance($start_date, $end_date, $client_id) {
        $start_date = get_start_date_format($start_date);
        $end_date = get_end_date_format($end_date);
        $result = $this->db->query("SELECT ctd.opening_balance FROM client_transaction_details ctd WHERE ctd.client_id = $client_id AND (ctd.transaction_date) > ('$end_date') LIMIT 1")->row();
        if (!empty($result)) {
            return $result->opening_balance;
        } else {
            $res = $this->db->query("SELECT ctd.closing_balance FROM client_transaction_details ctd WHERE ctd.client_id = $client_id AND (ctd.transaction_date) <= ('$end_date') ORDER BY ctd.id DESC LIMIT 1")->row();
            return !empty($res->closing_balance) ? $res->closing_balance : 0;
        }
    }

//    public function get_client_sales_report($start_date, $end_date, $client_ids = array()) {
//        $start_date = get_start_date_format($start_date);
//        $end_date = get_end_date_format($end_date);
//        $before_start_date = get_start_date_format(get_previous_month_from_selected_date($start_date, 1));
//        $current_date = get_end_date_format(get_current_date());
//        $client_ids = (!empty($client_ids)) ? implode(',', $client_ids) : '';
//        $where_condition = (!empty($client_ids)) ? "WHERE c.id IN ($client_ids)" : "";
//        return $query_result = $this->db->query("SELECT c.id, c.client_name, c.employee_id, e.employee_name, e.employee_code, 
//(SELECT ctd.closing_balance FROM client_transaction_details ctd WHERE ctd.client_id = c.id AND (ctd.transaction_date) < '$start_date' ORDER BY ctd.id DESC LIMIT 1) AS opening_balance,
//    (SELECT ctd.closing_balance FROM client_transaction_details ctd WHERE ctd.client_id = c.id AND MONTH(ctd.transaction_date) = MONTH('$start_date') AND YEAR(ctd.transaction_date) = YEAR('$start_date') ORDER BY ctd.id DESC LIMIT 1) AS closing_balance,
//(SELECT SUM(amount_to_paid) FROM invoice_details i WHERE c.id = i.client_id AND i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date') AS sale_amount,
//(SELECT SUM(p.amount_received) FROM payment p WHERE c.id = p.client_id AND p.receipt_date >= '$start_date' AND p.receipt_date <= '$end_date') AS collection_amount,
//TIMESTAMPDIFF(MONTH, (SELECT date_of_issue FROM invoice_details i WHERE c.id = i.client_id AND i.date_of_issue < '$current_date' ORDER BY i.id DESC LIMIT 1), '$current_date') AS oldest_unpaid_bill
//FROM client_info c LEFT JOIN employee_info e ON c.employee_id = e.id $where_condition")->result();
//    }

    public function get_originwise_sale_collection_report($start_month_year, $end_month_year, $employee_ids) {
        $total_report_array = array();
        $start_date = get_start_date_format(date('Y-m-01', strtotime(($start_month_year))));
        $end_date = get_end_date_format(date('Y-m-t', strtotime(($end_month_year))));
        if (!empty($employee_ids)) {
            $employee_ids_comma_seperated = implode(',', $employee_ids);
            $employee_list = $this->db->query("SELECT * FROM $this->table_name WHERE id IN ($employee_ids_comma_seperated)")->result();
        } else {
            $employee_list = $this->get_employee();
        }
        if (!empty($employee_list)) {
            foreach ($employee_list as $employee) {
                $employee_id = intval($employee->id);
                $employee_name = ($employee->employee_name);
                //here get always last target of an employee
                $where_condition = (($employee_id) > 0) ? "WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND i.employee_id = $employee_id" : "WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date'";
                $target_amount = "(SELECT et.target_amount FROM employee_target et WHERE et.employee_id = i.employee_id ORDER BY et.id DESC LIMIT 1) AS target_amount";
                $query_result = $this->db->query("SELECT $target_amount, sp.*, SUM(sp.quantity * sp.unit_price) AS total_amount, p.product_type_id, (SELECT product_type_name FROM product_type WHERE product_type.id = p.product_type_id) AS product_type_name, i.employee_id FROM sale_product sp LEFT JOIN product p ON sp.product_id = p.id LEFT JOIN invoice_details i ON sp.invoice_id = i.id $where_condition GROUP BY p.product_type_id ORDER BY p.product_type_id ASC")->result();
                if (!empty($query_result)) {
                    $array = array(
                        'employee_id' => $employee_id,
                        'employee_name' => $employee_name,
                        'target_amount' => $employee_name,
                    );
                    $total_sale = 0;
                    $total_collection = 0;
                    foreach ($query_result as $query) {
                        $product_type_id = intval($query->product_type_id);
                        $array['target_amount'] = !empty($query->target_amount) ? $query->target_amount : 0;
                        $total_amount = !empty($query->total_amount) ? $query->total_amount : 0;
                        $res = $this->db->query("SELECT SUM(sp.quantity * sp.unit_price) AS collection_amount FROM sale_product sp LEFT JOIN product p ON sp.product_id = p.id INNER JOIN invoice_details i ON sp.invoice_id = i.id WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND i.employee_id = $employee_id AND p.product_type_id = $product_type_id AND i.mode_of_payment != 'credit' ORDER BY p.product_type_id ASC")->row();
                        $collection_amount = !empty($res->collection_amount) ? $res->collection_amount : 0;
                        if ($product_type_id == 1) {
                            $array['lubzone_sale'] = $total_amount;
                            $total_sale += $total_amount;
                            $array['lubzone_collection'] = $collection_amount;
                            $total_collection += $collection_amount;
                        }
                        if ($product_type_id == 2) {
                            $array['repsol_sale'] = $total_amount;
                            $total_sale += $total_amount;
                            $array['repsol_collection'] = $collection_amount;
                            $total_collection += $collection_amount;
                        }
                        if ($product_type_id == 3) {
                            $array['usa_sale'] = $total_amount;
                            $total_sale += $total_amount;
                            $array['usa_collection'] = $collection_amount;
                            $total_collection += $collection_amount;
                        }
                    }
                    $array['total_sale'] = $total_sale;
                    $array['total_collection'] = $total_collection;
                    array_push($total_report_array, $array);
                }
            }
        }
        return $total_report_array;
    }

    public function get_incentive_report($start_month_year, $end_month_year, $employee_ids) {
        $bonus_incentive_system_obj = new Bonus_incentive_system_Model();
        $total_report_array = array();
        $start_date = get_start_date_format(date('Y-m-01', strtotime(($start_month_year))));
        $end_date = get_end_date_format(date('Y-m-t', strtotime(($end_month_year))));
        if (!empty($employee_ids)) {
            $employee_ids_comma_seperated = implode(',', $employee_ids);
            $employee_list = $this->db->query("SELECT * FROM $this->table_name WHERE id IN ($employee_ids_comma_seperated)")->result();
        } else {
            $employee_list = $this->get_employee();
        }
        if (!empty($employee_list)) {
            foreach ($employee_list as $employee) {
                $employee_id = intval($employee->id);
                $employee_name = ($employee->employee_name);
                //here get always last target of an employee
                $where_condition = (($employee_id) > 0) ? "WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND i.employee_id = $employee_id" : "WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date'";
                $target_amount = "(SELECT et.target_amount FROM employee_target et WHERE et.employee_id = i.employee_id ORDER BY et.id DESC LIMIT 1) AS target_amount";
                $query_result = $this->db->query("SELECT $target_amount, sp.*, SUM(sp.quantity * sp.unit_price) AS total_amount, p.product_type_id, (SELECT product_type_name FROM product_type WHERE product_type.id = p.product_type_id) AS product_type_name, i.employee_id FROM sale_product sp LEFT JOIN product p ON sp.product_id = p.id LEFT JOIN invoice_details i ON sp.invoice_id = i.id $where_condition GROUP BY p.product_type_id ORDER BY p.product_type_id ASC")->result();
                if (!empty($query_result)) {
                    $array = array(
                        'employee_id' => $employee_id,
                        'employee_name' => $employee_name,
                        'target_amount' => $employee_name,
                    );
                    $total_sale = 0;
                    $total_collection = 0;
                    $total_incentive = 0;
                    foreach ($query_result as $query) {
                        $product_type_id = intval($query->product_type_id);
                        $array['target_amount'] = !empty($query->target_amount) ? $query->target_amount : 0;
                        $total_amount = !empty($query->total_amount) ? $query->total_amount : 0;
                        $res = $this->db->query("SELECT SUM(sp.quantity * sp.unit_price) AS collection_amount FROM sale_product sp LEFT JOIN product p ON sp.product_id = p.id INNER JOIN invoice_details i ON sp.invoice_id = i.id WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND i.employee_id = $employee_id AND p.product_type_id = $product_type_id AND i.mode_of_payment != 'credit' ORDER BY p.product_type_id ASC")->row();
                        $collection_amount = !empty($res->collection_amount) ? $res->collection_amount : 0;
                        if ($product_type_id == 1) {
                            $array['lubzone_sale'] = $total_amount;
                            $total_sale += $total_amount;
                            $array['lubzone_collection'] = $collection_amount;
                            $total_collection += $collection_amount;
                            $import_client_amount = $this->get_incentive_amount($start_date, $end_date, $employee_id, $product_type_id, $client_type = 'import');
                            $lubzone_client_amount = $this->get_incentive_amount($start_date, $end_date, $employee_id, $product_type_id, $client_type = 'lubzone');
                            $array['lubzone_incentive'] = ($import_client_amount + $lubzone_client_amount);
                            $total_incentive += $array['lubzone_incentive'];
                        }
                        if ($product_type_id == 2) {
                            $array['repsol_sale'] = $total_amount;
                            $total_sale += $total_amount;
                            $array['repsol_collection'] = $collection_amount;
                            $total_collection += $collection_amount;
                            $import_client_amount = $this->get_incentive_amount($start_date, $end_date, $employee_id, $product_type_id, $client_type = 'import');
                            $lubzone_client_amount = $this->get_incentive_amount($start_date, $end_date, $employee_id, $product_type_id, $client_type = 'lubzone');
                            $array['repsol_incentive'] = ($import_client_amount + $lubzone_client_amount);
                            $total_incentive += $array['repsol_incentive'];
                        }
                        if ($product_type_id == 3) {
                            $array['usa_sale'] = $total_amount;
                            $total_sale += $total_amount;
                            $array['usa_collection'] = $collection_amount;
                            $total_collection += $collection_amount;
                            $import_client_amount = $this->get_incentive_amount($start_date, $end_date, $employee_id, $product_type_id, $client_type = 'import');
                            $lubzone_client_amount = $this->get_incentive_amount($start_date, $end_date, $employee_id, $product_type_id, $client_type = 'lubzone');
                            $array['usa_incentive'] = ($import_client_amount + $lubzone_client_amount);
                            $total_incentive += $array['usa_incentive'];
                        }
                    }
                    $array['total_sale'] = $total_sale;
                    $array['total_collection'] = $total_collection;
                    $array['total_incentive'] = $total_incentive;
                    array_push($total_report_array, $array);
                }
            }
        }
        return $total_report_array;
    }

    public function get_incentive_amount($start_date, $end_date, $employee_id, $product_type_id, $client_type) {
        $bonus_incentive_system_obj = new Bonus_incentive_system_Model();
        $res = $this->db->query("SELECT SUM(sp.quantity * sp.unit_price) AS collection_amount FROM sale_product sp LEFT JOIN product p ON sp.product_id = p.id INNER JOIN invoice_details i ON sp.invoice_id = i.id WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' AND i.employee_id = $employee_id AND p.product_type_id = $product_type_id AND i.mode_of_payment != 'credit' AND ((SELECT client_type FROM client_info WHERE i.client_id = client_info.id) = '$client_type') ORDER BY p.product_type_id ASC")->row();
//        get_print_r($this->db->last_query());
        $collection_amount = !empty($res->collection_amount) ? $res->collection_amount : 0;
        $percent_of_incentive = $bonus_incentive_system_obj->get_percent_of_incentive($collection_amount, $client_type); //$client_type == lubzone or import
        return ($percent_of_incentive > 0) ? (($collection_amount * $percent_of_incentive) / 100) : 0;
    }

}
