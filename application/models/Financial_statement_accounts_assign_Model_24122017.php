<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Financial_statement_accounts_assign_Model extends CI_Model {

    public $table_name = 'financial_statement_accounts_assign';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_financial_statement_accounts_assign($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
    }

    public function delete_all_financial_statement_accounts_assign_by_financial_statement_accounts_id($financial_statement_accounts_id) {
        $this->db->where('financial_statement_accounts_id', $financial_statement_accounts_id);
        $this->db->delete($this->table_name);
    }

    public function get_financial_statement_accounts_assign_by_head_type_and_id($head_type = null, $financial_statement_accounts_id) {
        if ($head_type != null) {
            if ((int) $financial_statement_accounts_id == 4 || (int) $financial_statement_accounts_id == 5) {
                $where_condition = "WHERE h.head_type = '$head_type' ORDER BY h.head_name ASC";
            } else {
                $where_condition = "WHERE h.head_type = '$head_type' AND (fa.financial_statement_accounts_id = $financial_statement_accounts_id OR fa.financial_statement_accounts_id IS null) ORDER BY h.head_name ASC";
            }
        } else {
            $where_condition = "WHERE fa.financial_statement_accounts_id = $financial_statement_accounts_id OR fa.financial_statement_accounts_id IS null ORDER BY h.head_name ASC";
        }
        $query_result = $this->db->query("SELECT h.id, h.head_name, h.head_type, fa.head_id, fa.financial_statement_accounts_type, fa.financial_statement_accounts_id, f.account_name FROM head_details h LEFT JOIN financial_statement_accounts_assign fa ON fa.head_id = h.id LEFT JOIN financial_statement_accounts f ON fa.financial_statement_accounts_id = f.id $where_condition");
        return $query_result->result();
    }

    public function get_financial_statement_accounts_assign_by_assign_id_and_type($financial_statement_accounts_type, $financial_statement_accounts_id) {
        $query_result = $this->db->query("SELECT fa.id, fa.head_id, fa.financial_statement_accounts_type, fa.financial_statement_accounts_id, h.head_name, h.head_type FROM financial_statement_accounts_assign fa LEFT JOIN head_details h ON fa.head_id = h.id WHERE financial_statement_accounts_type = '$financial_statement_accounts_type' AND financial_statement_accounts_id = $financial_statement_accounts_id");
        return $query_result->result();
    }

    public function get_account_statement_report_for_dr($year, $financial_statement_accounts_id) {
        // 1 == for trading account
        // 2 == profit and loss account
        // 3 == profit and loss appropriation account
        // 4 == balance sheet
        // 5 == trail balance
        $trading_account_report_for_dr_array = array();
        $trading_account_balance_for_dr_list = $this->get_financial_statement_accounts_assign_by_assign_id_and_type('dr', $financial_statement_accounts_id);
        if (!empty($trading_account_balance_for_dr_list)) {
            $m_daywise_head_posting = new Daywise_head_posting_Model();
            foreach ($trading_account_balance_for_dr_list as $trading_account) {
                $head_id = $trading_account->head_id;
                $single_head_current_balance = $m_daywise_head_posting->get_single_head_current_balance($head_id, $year);
                $arr = array(
                    'head_id' => $head_id,
                    'head_name' => $trading_account->head_name,
                    'balance' => $single_head_current_balance,
                );
                array_push($trading_account_report_for_dr_array, $arr);
            }
        }
        return $trading_account_report_for_dr_array;
    }

    public function get_account_statement_report_for_cr($year, $financial_statement_accounts_id) {
        // 1 == for trading account
        // 2 == profit and loss account
        // 3 == profit and loss appropriation account
        // 4 == balance sheet
        // 5 == trail balance
        $trading_account_report_for_dr_array = array();
        $trading_account_balance_for_cr_list = $this->get_financial_statement_accounts_assign_by_assign_id_and_type('cr', $financial_statement_accounts_id);
        if (!empty($trading_account_balance_for_cr_list)) {
            $m_daywise_head_posting = new Daywise_head_posting_Model();
            foreach ($trading_account_balance_for_cr_list as $trading_account) {
                $head_id = $trading_account->head_id;
                $single_head_current_balance = $m_daywise_head_posting->get_single_head_current_balance($head_id, $year);
                $arr = array(
                    'head_id' => $head_id,
                    'head_name' => $trading_account->head_name,
                    'balance' => $single_head_current_balance,
                );
                array_push($trading_account_report_for_dr_array, $arr);
            }
        }
        return $trading_account_report_for_dr_array;
    }

    public function get_account_statement_report_for_dr_exclude_balance_zero($year, $financial_statement_accounts_id) {
        $dr = $this->get_account_statement_report_for_dr($year, $financial_statement_accounts_id);
        $dr_array = array();
        $head_name = '';
        foreach ($dr as $d) {
            $d['head_name'] = $this->get_head_name_without_ac($d['head_name']);
            if ((double) $d['balance'] != (double) 0) {
                array_push($dr_array, $d);
            }
        }
        return $dr_array;
    }

    public function get_account_statement_report_for_cr_exclude_balance_zero($year, $financial_statement_accounts_id) {
        $cr = $this->get_account_statement_report_for_cr($year, $financial_statement_accounts_id);
        $cr_array = array();
        $head_name = '';
        foreach ($cr as $c) {
            $c['head_name'] = $this->get_head_name_without_ac($c['head_name']);
            if ((double) $c['balance'] != (double) 0) {
                array_push($cr_array, $c);
            }
        }
        return $cr_array;
    }

    public function financial_account_statement($year, $financial_statement_accounts_id) {
        $i = 0;
        $total_dr = 0;
        $total_cr = 0;
        $profit = 0;
        $loss = 0;
        $grand_total_dr = 0;
        $grand_total_cr = 0;
        $arr = array();
        $dr = $this->get_account_statement_report_for_dr_exclude_balance_zero($year, $financial_statement_accounts_id);
        $cr = $this->get_account_statement_report_for_cr_exclude_balance_zero($year, $financial_statement_accounts_id);
        $dr = $this->get_remove_particular_head_for_dr($dr);
        $cr = $this->get_remove_particular_head_for_cr($cr);
        if (!empty($dr) || !empty($cr)) {
            $maximum_length = max(count($dr), count($cr));
            while ((int) $i < (int) $maximum_length) {
                $total_dr += !empty($dr[$i]) ? (double) (abs($dr[$i]['balance'])) : 0;
                $total_cr += !empty($cr[$i]) ? (double) (abs($cr[$i]['balance'])) : 0;
                $balance_array = array(
                    'dr' => $financial_statement_accounts_id == 4 ? $cr : $dr,
                    'cr' => $financial_statement_accounts_id == 4 ? $dr : $cr,
                    'total_dr' => $financial_statement_accounts_id == 4 ? $total_cr : $total_dr,
                    'total_cr' => $financial_statement_accounts_id == 4 ? $total_dr : $total_cr,
                    'difference' => abs((double) $total_dr - (double) $total_cr),
                );
                $i++;
            }
            array_push($arr, $balance_array);
        }
        return $arr;
    }

    public function balance($balance_array, $financial_statement_accounts_id = 0) {
        $total_dr = !empty($balance_array[0]['total_dr']) ? $balance_array[0]['total_dr'] : 0;
        $total_cr = !empty($balance_array[0]['total_cr']) ? $balance_array[0]['total_cr'] : 0;
        $difference = !empty($balance_array[0]['difference']) ? $balance_array[0]['difference'] : 0;
        if (abs($total_dr) >= abs($total_cr)) {
            $profit = (double) 0;
            $loss = (double) abs($difference);
        } else {
            $profit = (double) abs($difference);
            $loss = (double) 0;
        }
        $grand_total_dr = $total_dr + $profit;
        $grand_total_cr = $total_cr + $loss;
        if ($financial_statement_accounts_id == 4) {
            $balance_array['loss'] = $profit;
            $balance_array['profit'] = $loss;
            $balance_array['grand_total_cr'] = $grand_total_dr;
            $balance_array['grand_total_dr'] = $grand_total_cr;
        } else {
            $balance_array['profit'] = $profit;
            $balance_array['loss'] = $loss;
            $balance_array['grand_total_dr'] = $grand_total_dr;
            $balance_array['grand_total_cr'] = $grand_total_cr;
        }

        return $balance_array;
    }

    public function get_total_dr_cr($account_statement, $balance_array, $financial_statement_accounts_id = 0) {
        $account_statement_profit = $account_statement['profit'];
        $account_statement_loss = $account_statement['loss'];
        if ((double) $account_statement_loss != (double) 0) {
            $total_dr = $account_statement_loss;
            $total_cr = 0;
        } else {
            $total_dr = 0;
            $total_cr = $account_statement_profit;
        }
        if ($financial_statement_accounts_id == 4) {
            $balance_array[0]['previous_profit'] = $total_dr;
            $balance_array[0]['previous_loss'] = $total_cr;
            $balance_array[0]['total_cr'] = !empty($balance_array[0]['total_dr']) ? $balance_array[0]['total_dr'] : 0 + $total_dr;
            $balance_array[0]['total_dr'] = !empty($balance_array[0]['total_cr']) ? $balance_array[0]['total_cr'] : 0 + $total_cr;
            $balance_array[0]['difference'] = abs((!empty($balance_array[0]['total_dr']) ? $balance_array[0]['total_dr'] : 0) - !empty($balance_array[0]['total_cr']) ? $balance_array[0]['total_cr'] : 0);
        } else {
            $balance_array[0]['previous_loss'] = $total_dr;
            $balance_array[0]['previous_profit'] = $total_cr;
            $balance_array[0]['total_dr'] = (!empty($balance_array[0]['total_dr']) ? $balance_array[0]['total_dr'] : 0) + $total_dr;
            $balance_array[0]['total_cr'] = (!empty($balance_array[0]['total_cr']) ? $balance_array[0]['total_cr'] : 0) + $total_cr;
            $balance_array[0]['difference'] = abs((!empty($balance_array[0]['total_dr']) ? $balance_array[0]['total_dr'] : 0) - (!empty($balance_array[0]['total_cr']) ? $balance_array[0]['total_cr'] : 0));
        }

        return $balance_array;
    }

    public function get_statement($year, $financial_statement_accounts_id) {
        // 1 == for trading account
        // 2 == profit and loss account
        // 3 == profit and loss appropriation account
        // 4 == balance sheet
        // 5 == trail balance
        $result_array = array();
        if (!empty($year) && !empty($financial_statement_accounts_id)) {
            if ((int) $financial_statement_accounts_id == 1) {
                $result_array = $this->get_trading($year, $financial_statement_accounts_id);
            } elseif ((int) $financial_statement_accounts_id == 2) {
                $result_array = $this->get_profit_loss($year, $financial_statement_accounts_id);
            } elseif ((int) $financial_statement_accounts_id == 3) {
                $result_array = $this->get_profit_loss_appropriation($year, $financial_statement_accounts_id);
            } elseif ((int) $financial_statement_accounts_id == 4) {
                $result_array = $this->get_balance_sheet($year, $financial_statement_accounts_id);
            }
        }
        return $result_array;
    }

    public function get_trading($year, $financial_statement_accounts_id) {
        $balance_array = $this->financial_account_statement($year, $financial_statement_accounts_id);
        $result_array = $this->balance($balance_array);
        $result_array[0]['previous_loss'] = 0;
        $result_array[0]['previous_profit'] = 0;
        $result_array[0]['previous_loss_heading'] = '';
        $result_array[0]['previous_profit_heading'] = '';
        $result_array[0]['loss_heading'] = 'Gross Loss (Transfer To Profit & Loss Account)';
        $result_array[0]['profit_heading'] = 'Gross Profit (Transfer To Profit & Loss Account)';
        $result_array['table_heading_1'] = 'Particular(DR.)';
        $result_array['table_heading_2'] = 'Amount';
        $result_array['table_heading_3'] = 'Particular(CR.)';
        $result_array['table_heading_4'] = 'Amount';
        return $result_array;
    }

    public function get_profit_loss($year, $financial_statement_accounts_id) {
        $balance_array = $this->financial_account_statement($year, $financial_statement_accounts_id);
        $trading_account_statement = $this->get_trading($year, 1); // 1 == for trading account
        $arr = $this->get_total_dr_cr($trading_account_statement, $balance_array);
        $result_array = $this->balance($arr);
        $result_array[0]['previous_loss_heading'] = 'Gross Loss (Transfer from Trading Account)';
        $result_array[0]['previous_profit_heading'] = 'Gross Profit (Transfer from Trading Account)';
        $result_array[0]['loss_heading'] = 'Net Loss (Transfer to Profit & Loss Appropriation Account)';
        $result_array[0]['profit_heading'] = 'Net Profit (Transfer to Profit & Loss Appropriation Account)';
        $result_array['table_heading_1'] = 'Particular(DR.)';
        $result_array['table_heading_2'] = 'Amount';
        $result_array['table_heading_3'] = 'Particular(CR.)';
        $result_array['table_heading_4'] = 'Amount';
        return $result_array;
    }

    public function get_profit_loss_appropriation($year, $financial_statement_accounts_id) {
        $balance_array = $this->financial_account_statement($year, $financial_statement_accounts_id);
        $profit_loss_statement = $this->get_profit_loss($year, 2); // 2 == profit and loss account
        $balance_array = $this->get_total_dr_cr($profit_loss_statement, $balance_array);
        $result_array = $this->balance($balance_array);
        $result_array[0]['previous_loss_heading'] = 'Net Loss during the year';
        $result_array[0]['previous_profit_heading'] = 'Net Profit during the year';
        $result_array[0]['loss_heading'] = 'Profit & Loss Appropriation Account';
        $result_array[0]['profit_heading'] = 'Profit & Loss Appropriation Account';
        $result_array['table_heading_1'] = 'Particular(DR.)';
        $result_array['table_heading_2'] = 'Amount';
        $result_array['table_heading_3'] = 'Particular(CR.)';
        $result_array['table_heading_4'] = 'Amount';
        return $result_array;
    }

    public function get_balance_sheet($year, $financial_statement_accounts_id) {
        // for balance sheet swap dr and cr
        $balance_array = $this->financial_account_statement($year, $financial_statement_accounts_id);
        $profit_loss_appropriation_statement = $this->get_profit_loss_appropriation($year, 3); // 3 == profit and loss appropriation account
        $balance_array = $this->get_total_dr_cr($profit_loss_appropriation_statement, $balance_array, $financial_statement_accounts_id);
        $result_array = $this->balance($balance_array, $financial_statement_accounts_id);
        $result_array[0]['previous_loss_heading'] = 'Profit and Loss Appropriation';
        $result_array[0]['previous_profit_heading'] = 'Profit and Loss Appropriation';
        $result_array[0]['loss_heading'] = 'Net Loss';
        $result_array[0]['profit_heading'] = 'Gross Profit';
        $result_array['table_heading_1'] = 'Capital & Liabilities (CR.)';
        $result_array['table_heading_2'] = 'Amount';
        $result_array['table_heading_3'] = 'Property & Assets (DR.)';
        $result_array['table_heading_4'] = 'Amount';
        return $result_array;
    }

    public function get_head_name_without_ac($name_of_head) {
        $head_name = "";
        if (!empty($name_of_head)) {
            if (strpos(($name_of_head), "A/C") !== false) {
                $head_name = str_replace("A/C", "", $name_of_head);
            } else {
                $head_name = $name_of_head;
            }
        }
        return $head_name;
    }

    public function get_remove_particular_head_for_cr($cr) {
        $cr_array = array();
        if (!empty($cr)) {
            foreach ($cr as $c) {
                if (!in_array($c['head_id'], $this->head_remove_from_all_account_statement())) {
                    array_push($cr_array, $c);
                }
            }
        }
        return $cr_array;
    }

    public function get_remove_particular_head_for_dr($dr) {
        $dr_array = array();
        if (!empty($dr)) {
            foreach ($dr as $d) {
                if (!in_array($d['head_id'], $this->head_remove_from_all_account_statement())) {
                    array_push($dr_array, $d);
                }
            }
        }
        return $dr_array;
    }

    public function head_remove_from_all_account_statement() {
        $head_id_array = array();
        $head_id_array = array(92, 93, 95, 96);
        return $head_id_array;
    }

}
