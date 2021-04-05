<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher_posting_details_Model extends CI_Model {

    public $table_name = 'voucher_posting_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_voucher_posting_details($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_voucher_posting_details($id = 0) {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'posting_date' => $this->input->post('posting_date'),
            'voucher_number' => $this->input->post('voucher_number'),
            'total_debit_amount' => $this->input->post('total_debit_amount'),
            'total_credit_amount' => $this->input->post('total_credit_amount'),
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
        $this->db->delete('voucher_posting_details');
    }

    public function get_last_voucher_number() {
//        $last_row_id = $this->db->query("SELECT id, voucher_number FROM voucher_posting_details ORDER BY id DESC LIMIT 1")->row();
        $last_row_id = $this->db->query("SELECT id, MAX(CAST(voucher_number AS UNSIGNED)) AS voucher_number FROM voucher_posting_details")->row();
        return $last_row_id;
    }

    public function get_voucher_posting_details_by_date($start_date, $end_date) {
        $query = $this->db->query("SELECT * FROM voucher_posting_details WHERE posting_date >= '$start_date' AND posting_date <= '$end_date' ORDER BY id DESC")->result();
        return $query;
    }

    public function is_exist_voucher_number($voucher_number) {
        $query_result = $this->db->get_where($this->table_name, array('voucher_number' => $voucher_number))->row();
        if (!empty($query_result)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_voucher_number() {
        $last_voucher_number = $this->get_last_voucher_number();
        if (!empty($last_voucher_number->voucher_number)) {
            $voucher_number = $last_voucher_number->voucher_number + 1;
        } else {
            $voucher_number = 1000;
        }
        return $voucher_number;
    }

    public function get_voucher_posting_details_sum_by_head_id($head_id, $month_number, $year) {
        return $result = $this->db->query("SELECT vpd.id, vpd.posting_date, vpd.voucher_number, vpd.total_debit_amount, vpd.total_credit_amount, vpd.common_narration, vpd.user_id, vd.id AS voucher_details_id, vd.income_head_id, vd.expense_head_id, vd.amount ,vd.invoice_number, vd.mr_number, vd.client_id, vd.employee_id, vd.month, vd.year, vd.narration, SUM(vd.debit_amount) AS sum_of_debit_amount, SUM(vd.credit_amount) AS sum_of_credit_amount, vd.opening_balance, vd.closing_balance FROM voucher_posting_details vpd JOIN voucher_details vd ON vpd.id= vd.voucher_posting_details_id WHERE (vd.income_head_id = '$head_id' OR vd.expense_head_id='$head_id') AND MONTH(vpd.posting_date) = '$month_number' AND YEAR(vpd.posting_date) = '$year' GROUP BY (vd.income_head_id = '$head_id' OR vd.expense_head_id='$head_id') ORDER BY vd.id DESC")->row();
    }

    public function get_profit_loss_appropriation_first_transaction_amount_of_year($head_id = 114, $month_number = 1, $year, $dr_cr) {
        $result = $this->db->query("SELECT vpd.id, vpd.posting_date, vpd.voucher_number, vpd.total_debit_amount, vpd.total_credit_amount, vpd.common_narration, vpd.user_id, vd.id AS voucher_details_id, vd.income_head_id, vd.expense_head_id, vd.amount ,vd.invoice_number, vd.mr_number, vd.client_id, vd.employee_id, vd.month, vd.year, vd.narration, SUM(vd.debit_amount) AS sum_of_debit_amount, SUM(vd.credit_amount) AS sum_of_credit_amount, vd.opening_balance, vd.closing_balance FROM voucher_posting_details vpd JOIN voucher_details vd ON vpd.id= vd.voucher_posting_details_id WHERE (vd.income_head_id = '$head_id' OR vd.expense_head_id='$head_id') AND MONTH(vpd.posting_date) = '$month_number' AND YEAR(vpd.posting_date) = '$year' GROUP BY (vd.income_head_id = '$head_id' OR vd.expense_head_id='$head_id') ORDER BY vd.id ASC")->row();
        if (!empty($result)) {
            if ($dr_cr == 'dr') {
                return get_floating_point_number($result->total_debit_amount);
            } elseif ($dr_cr == 'cr') {
                return get_floating_point_number($result->total_credit_amount);
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

}
