<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_benefit_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Voucher_posting_details_Model');
        $this->load->model('Voucher_details_Model');
        $this->load->model('Head_details_Model');
        $this->load->model('Employee_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $this->data['title'] = "Employee Benefit Report";
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $employee_list = $this->Employee_Model->get_employee();
            $this->data['employee_list'] = $employee_list;
            $head_details_list = $this->Head_details_Model->get_head_details();
            $this->data['head_details_list'] = $head_details_list;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/accounts_report/employee_benefit_report/employee_benefit_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function employee_benefit_report_show() {  //benefit report show in table
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            $employee_id = trim($this->input->post('employee_id'));
            $head_id = trim($this->input->post('head_id'));
            $employee = $this->Employee_Model->get_employee($employee_id);            
            if (!empty($employee)) {
                $employee_name = $employee->employee_name;
            } else {
                $employee_name = 'All';
            }
            $head_information = $this->Head_details_Model->get_head_details($head_id);
            if (!empty($head_information)) {
                $head_name = $head_information->head_name;
            } else {
                $head_name = 'All';
            }
            $this->data['employee'] = $employee;
            $this->data['employee_name'] = $employee_name;
            $this->data['head_information'] = $head_information;
            $this->data['head_name'] = $head_name;
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['currency_settings'] = $currency_settings;
            $month_year_list_array = $this->get_month_year_array($start_date, $end_date);
            $employee_total_benefit_by_month_year = array();

            foreach ($month_year_list_array as $month_year_list) {
                $employee_total_benefit_by_month_year_1 = $this->get_employee_total_benefit_by_month_year($head_id, $employee_id, $month_year_list[0], $month_year_list[1]);
                foreach ($employee_total_benefit_by_month_year_1 as $employee_total) {
                    array_push($employee_total_benefit_by_month_year, $employee_total);
                }
            }
            $this->data['employee_total_benefit_by_month_year'] = $employee_total_benefit_by_month_year;
            $this->load->view('reports/accounts_report/employee_benefit_report/employee_benefit_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_month_year_array($start_date, $end_date) {
        $month_list_array = array();
        $month_year_list_array = array();
        $d1 = strtotime($start_date);
        $d2 = strtotime($end_date);
        $min_date = min($d1, $d2);
        $max_date = max($d1, $d2);
        $i = 0;
        while (($min_date = $min_date) <= $max_date) {
            $month = date('F', $min_date);
            $year = date('Y', $min_date);
            array_push($month_list_array, $month, $year);
            array_push($month_year_list_array, $month_list_array);
            $min_date = strtotime("+1 MONTH", $min_date);
            $i++;
            $month_list_array = array();
        }
        return $month_year_list_array;
    }

    public function get_employee_total_benefit_by_month_year($head_id, $employee_id, $month, $year) {
        if ($employee_id <= 0 && $head_id > 0) {
            $query_result = $this->db->query("SELECT vpd.id, vpd.posting_date, vpd.voucher_number, vpd.total_debit_amount, vpd.total_credit_amount, vpd.common_narration, vpd.user_id, eb.id AS employee_benefit_id, eb.employee_id, eb.month, eb.year, eb.head_id, eb.amount, e.employee_name, e.employee_code, e.designation, h.head_name,h.head_type FROM voucher_posting_details vpd JOIN employee_benefit eb ON vpd.id=eb.voucher_posting_details_id LEFT JOIN employee_info e ON eb.employee_id=e.id LEFT JOIN head_details h ON eb.head_id = h.id WHERE h.id = '$head_id' AND eb.month='$month' AND eb.year ='$year' AND h.is_active = '1'")->result();
        } elseif ($employee_id > 0 && $head_id <= 0) {
            $query_result = $this->db->query("SELECT vpd.id, vpd.posting_date, vpd.voucher_number, vpd.total_debit_amount, vpd.total_credit_amount, vpd.common_narration, vpd.user_id, eb.id AS employee_benefit_id, eb.employee_id, eb.month, eb.year, eb.head_id, eb.amount, e.employee_name, e.employee_code, e.designation, h.head_name,h.head_type FROM voucher_posting_details vpd JOIN employee_benefit eb ON vpd.id=eb.voucher_posting_details_id LEFT JOIN employee_info e ON eb.employee_id=e.id LEFT JOIN head_details h ON eb.head_id = h.id WHERE eb.employee_id = '$employee_id' AND eb.month='$month' AND eb.year ='$year' AND h.is_active = '1'")->result();
        } elseif ($employee_id > 0 && $head_id > 0) {
            $query_result = $this->db->query("SELECT vpd.id, vpd.posting_date, vpd.voucher_number, vpd.total_debit_amount, vpd.total_credit_amount, vpd.common_narration, vpd.user_id, eb.id AS employee_benefit_id, eb.employee_id, eb.month, eb.year, eb.head_id, eb.amount, e.employee_name, e.employee_code, e.designation, h.head_name,h.head_type FROM voucher_posting_details vpd JOIN employee_benefit eb ON vpd.id=eb.voucher_posting_details_id LEFT JOIN employee_info e ON eb.employee_id=e.id LEFT JOIN head_details h ON eb.head_id = h.id WHERE h.id='$head_id' AND eb.employee_id = '$employee_id' AND eb.month='$month' AND eb.year ='$year' AND h.is_active = '1'")->result();
        } else {
            $query_result = $this->db->query("SELECT vpd.id, vpd.posting_date, vpd.voucher_number, vpd.total_debit_amount, vpd.total_credit_amount, vpd.common_narration, vpd.user_id, eb.id AS employee_benefit_id, eb.employee_id, eb.month, eb.year, eb.head_id, eb.amount, e.employee_name, e.employee_code, e.designation, h.head_name,h.head_type FROM voucher_posting_details vpd JOIN employee_benefit eb ON vpd.id=eb.voucher_posting_details_id LEFT JOIN employee_info e ON eb.employee_id=e.id LEFT JOIN head_details h ON eb.head_id = h.id WHERE eb.month='$month' AND eb.year ='$year' AND h.is_active = '1'")->result();
        }
        return $query_result;
    }

    /* public function employee_benefit_details_report_modal_show()  //employee benefit details show in Modal
      {
      if (!empty($this->session->userdata('user_session'))) {
      $company_information = $this->Company_Model->get_company();
      $this->data['company_information'] = $company_information;
      $employee_id = $this->input->post('id');  // voucher posting details id
      $employee = $this->Employee_Model->get_employee($employee_id);
      $this->data['employee'] = $employee;

      $month = $this->session->userdata('month_session');
      $year = $this->session->userdata('year_session');
      $this->data['month'] = $month;
      $this->data['year'] = $year;

      $employee_benefit_details_by_month_year = $this->get_employee_benefit_details_by_month_year($employee_id, $month, $year);
      $this->data['employee_benefit_details_by_month_year'] = $employee_benefit_details_by_month_year;
      $this->load->view('reports/accounts_report/employee_benefit_report/employee_benefit_report_modal', $this->data);
      } else {
      redirect(base_url('user_login'));
      }
      } */

    /* public function get_employee_benefit_details_by_month_year($employee_id, $month, $year)
      {
      $query_result = $this->db->query("SELECT eb.id, eb.employee_id, eb.month, eb.year, eb.head_id, eb.amount, eb.voucher_posting_details_id, vpd.posting_date, vpd.voucher_number, vpd.total_debit_amount, vpd.total_credit_amount, vpd.common_narration, vpd.user_id, h.head_name, h.head_type FROM employee_benefit eb JOIN voucher_posting_details vpd ON eb.voucher_posting_details_id=vpd.id JOIN head_details h ON eb.head_id = h.id WHERE eb.employee_id='$employee_id' AND eb.month = '$month' AND eb.year='$year'")->result();
      return $query_result;
      } */
}
