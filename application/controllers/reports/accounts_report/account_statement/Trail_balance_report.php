<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Trail_balance_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Head_details_Model');
        $this->load->model('Daywise_head_posting_Model');
        $this->load->model('Financial_statement_accounts_assign_Model');
        $this->load->model('User_Model');
    }

    public function index() {
//        get_print_r(get_last_date_of_selected_month(date('Y-09-01')));
//        $dateToTest = "2015-09-01";
//        $lastday = date('t', strtotime($dateToTest));
//        get_print_r($lastday);

        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == TRUE)) {
            $this->data['title'] = "Trail Balance Report";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/accounts_report/account_statement_report/trail_balance_report/trail_balance_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function trail_balance_report_show_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == TRUE)) {
            $this->data['title'] = "Trail Balance Report";
            $year = trim($this->input->post('year'));
            $start_date = get_start_date_format(trim($this->input->post('start_date')));
            $end_date = get_end_date_format(trim($this->input->post('end_date')));
            $is_custom = intval(trim($this->input->post('is_custom')));
            if (empty($year) || empty($start_date) || empty($end_date)) {
                echo '<div class="error-message text-align-center">Please Select Year.</div>';
            } else {
                $dr = $this->get_all_dr_or_both_head_current_balance($start_date, $end_date);
                $cr = $this->get_all_cr_or_both_head_current_balance($start_date, $end_date);

                $dr = $this->dr_or_cr_without_closing_inventory($dr);
                $cr = $this->dr_or_cr_without_closing_inventory($cr);
                $this->data['dr'] = $dr;
                $this->data['cr'] = $cr;
                $this->data['year'] = $year;
                $this->data['start_date'] = $start_date;
                $this->data['end_date'] = $end_date;
                $this->data['is_custom'] = $is_custom;
                $this->data['company_information'] = $this->Company_Model->get_company();
                $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
                $this->load->view('reports/accounts_report/account_statement_report/trail_balance_report/trail_balance_report_table', $this->data);
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function dr_or_cr_without_closing_inventory($dr_or_cr) {
        $result_array = array();
        $closing_inventory_head_remove_from_trail_balance = $this->closing_inventory_head_remove_from_trail_balance();
        if (!empty($dr_or_cr)) {
            foreach ($dr_or_cr as $d_or_c) {
                if (!in_array($d_or_c['head_id'], $closing_inventory_head_remove_from_trail_balance)) {
                    array_push($result_array, $d_or_c);
                }
            }
        }
        return $result_array;
    }

    public function get_all_dr_or_both_head_current_balance($start_date, $end_date) {
        $result_array = array();
        $head_remove_from_all_account_statement = $this->Financial_statement_accounts_assign_Model->head_remove_from_all_account_statement();
        $m_daywise_head_posting = new Daywise_head_posting_Model();
        $m_head_details = new Head_details_Model();
        $head_list = $m_head_details->get_head_details();
        if (!empty($head_list)) {
            foreach ($head_list as $head_info) {
                $head_id = $head_info->id;
                $result = $m_daywise_head_posting->get_current_balance_from_daywise_head_posting_by_head_by_date($head_id, $start_date, $end_date);
                if (empty($result)) {
                    $result = $m_daywise_head_posting->get_current_balance_from_previous_year_daywise_head_posting_by_head_by_date($head_id, $start_date, $end_date);
                }
                if (!empty($result)) {
                    if ((double) $result->closing_balance < 0) {
                        $head_name = $this->Financial_statement_accounts_assign_Model->get_head_name_without_ac($head_info->head_name);
                        $arr = array(
                            'head_id' => $head_info->id,
                            'head_name' => $head_name,
                            'head_type' => $head_info->head_type,
                            'balance' => $result->closing_balance,
                        );
                        if ((double) $arr['balance'] != (double) 0) {
                            if (!in_array($head_id, $head_remove_from_all_account_statement)) {
                                array_push($result_array, $arr);
                            }
                        }
                    }
                }
            }
        }
        return $result_array;
    }

    public function get_all_cr_or_both_head_current_balance($start_date, $end_date) {
        $result_array = array();
        $head_remove_from_all_account_statement = $this->Financial_statement_accounts_assign_Model->head_remove_from_all_account_statement();
        $m_daywise_head_posting = new Daywise_head_posting_Model();
        $m_head_details = new Head_details_Model();
        $head_list = $m_head_details->get_head_details();
        if (!empty($head_list)) {
            foreach ($head_list as $head_info) {
                $head_id = $head_info->id;
                $result = $m_daywise_head_posting->get_current_balance_from_daywise_head_posting_by_head_by_date($head_id, $start_date, $end_date);
                if (empty($result)) {
                    $result = $m_daywise_head_posting->get_current_balance_from_previous_year_daywise_head_posting_by_head_by_date($head_id, $start_date, $end_date);
                }
                if (!empty($result)) {
                    if ((double) $result->closing_balance > 0) {
                        $head_name = $this->Financial_statement_accounts_assign_Model->get_head_name_without_ac($head_info->head_name);
                        $arr = array(
                            'head_id' => $head_info->id,
                            'head_name' => $head_name,
                            'head_type' => $head_info->head_type,
                            'balance' => $result->closing_balance,
                        );
                        if ((double) $arr['balance'] != (double) 0) {
                            if (!in_array($head_id, $head_remove_from_all_account_statement)) {
                                array_push($result_array, $arr);
                            }
                        }
                    }
                }
            }
        }
        return $result_array;
    }

    public function closing_inventory_head_remove_from_trail_balance() {
//        Closing Inventory(Import-Bangla Bazar)-123
//        Closing Inventory(Import-H/O-Showroom)-125
//        Closing Inventory(Import-Mohakhali S/R)-141
//        Closing Inventory(Lubzone-Bangla Bazar)-127
//        Closing Inventory(Lubzone-H/O-Showroom)-128
//        Closing Inventory(Lubzone-Mohakhali S/R)-142
//        
//        Closing Inventory(Import-Savar-AOCL)- 124
//        Closing Inventory(Lubzone-Savar-AOCL)-126
//        Closing Inventory (Import-Mohakhali S/R)-145
//        Closing Inventory (Lubzone-Mohakhali S/R)-146

        $head_id_array = array();
        $head_id_array = array(123, 125, 127, 128, 141, 142, 145, 146, 124, 126);
        return $head_id_array;
    }

}
