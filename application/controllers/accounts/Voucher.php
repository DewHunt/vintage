<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Voucher_posting_details_Model');
        $this->load->model('Voucher_details_Model');
        $this->load->model('Head_details_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Client_Model');
        $this->load->model('Employee_benefit_Model');
        $this->load->model('Head_details_posting_Model');
        $this->load->model('Salary_details_Model');
        $this->load->model('Narration_Model');
        $this->load->model('Daywise_head_posting_Model');
        $this->load->model('Client_accounts_transaction_details_Model');
    }

    public function index() {  // load Income Head details
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['title'] = "Voucher";
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $income_head_list = $this->Head_details_Model->get_income_head_details();
            $this->data['income_head_list'] = $income_head_list;
            $expense_head_list = $this->Head_details_Model->get_expense_head_details();
            $this->data['expense_head_list'] = $expense_head_list;
            $employee_list = $this->Employee_Model->get_employee();
            $this->data['employee_list'] = $employee_list;
            $client_list = $this->Client_Model->get_client();
            $this->data['client_list'] = $client_list;

            $narration_list = $this->Narration_Model->get_narration();  // for narration
            $this->data['narration_list'] = $narration_list;

            $last_voucher_number = $this->Voucher_posting_details_Model->get_last_voucher_number();
            if (!empty($last_voucher_number->voucher_number)) {
                $voucher_number = $last_voucher_number->voucher_number + 1;
            } else {
                $voucher_number = 1000;
            }
            $this->data['voucher_number'] = $voucher_number;

            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('accounts/voucher/voucher', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_voucher_info_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $count = time();
                $income_head_name = '';
                $expense_head_name = '';
                $client_name = '';
                $employee_name = '';
                $credit_amount = '';
                $debit_amount = '';
                $head_type = '';

                $income_head_id = trim($this->input->post('income_head_id'));
                $expense_head_id = trim($this->input->post('expense_head_id'));
                $total_amount = trim($this->input->post('total_amount'));
                $invoice_number = trim($this->input->post('invoice_number'));
                $mr_number = trim($this->input->post('mr_number'));
                $client_id = trim($this->input->post('client_id'));
                $employee_id = trim($this->input->post('employee_id'));
                $month = trim($this->input->post('month'));
                $year = trim($this->input->post('year'));
                $narration = trim($this->input->post('narration'));
                $head_radio = trim($this->input->post('head_radio'));

                if (!empty($head_radio)) {
                    if ($head_radio == 'cr') {
                        $income_head_information = $this->Head_details_Model->get_head_details($income_head_id);
                        if (!empty($income_head_information)) {
                            $income_head_name = $income_head_information->head_name;
                        }
                        $expense_head_id = '';
                        $employee_id = '';
                        $credit_amount = $total_amount;
                    } else {
                        $expense_head_information = $this->Head_details_Model->get_head_details($expense_head_id);
                        if (!empty($expense_head_information)) {
                            $expense_head_name = $expense_head_information->head_name;
                        }
                        $income_head_id = '';
                        $debit_amount = $total_amount;
                    }
                }

                if (!empty($income_head_id) && $income_head_id > 0) {
                    $head_id = $income_head_id;
                } else {
                    $head_id = $expense_head_id;
                }
                $head_details_information = $this->Head_details_Model->get_head_details($head_id);
                if (!empty($head_details_information)) {
                    $head_type = $head_details_information->head_type;
                }
                if ($income_head_id > 0) {
                    $posting_type = 'cr';
                } else {
                    $posting_type = 'dr';
                }

                if (empty($income_head_id) && empty($expense_head_id)) {
                    $result = FALSE;
                    $head_id_error_message = 'Please select head';
                } else {
                    $head_id_error_message = '';
                    $result = $this->get_valid_head_in_table($head_id, $head_type, $posting_type, $total_amount);
                }

                if ($result == FALSE) {
                    if (!empty($head_id_error_message)) {
                        echo '<div class="error-message text-align-center">Please select head</div>';
                    } else {
                        echo '<div class="error-message text-align-center">Insufficient Balance</div>';
                    }
                    $income_head_list = $this->Head_details_Model->get_income_head_details();
                    $this->data['income_head_list'] = $income_head_list;
                    $expense_head_list = $this->Head_details_Model->get_expense_head_details();
                    $this->data['expense_head_list'] = $expense_head_list;
                    $employee_list = $this->Employee_Model->get_employee();
                    $this->data['employee_list'] = $employee_list;
                    $this->load->view('accounts/voucher/voucher_info_table', $this->data);
                } else {
                    $head_sundry_debitors = $this->is_head_sundry_debitors($income_head_id, $expense_head_id, $client_id);
                    if ($head_sundry_debitors == TRUE) {
                        echo '<div class="error-message text-align-center">Please Select Client.</div>';
                        $income_head_list = $this->Head_details_Model->get_income_head_details();
                        $this->data['income_head_list'] = $income_head_list;
                        $expense_head_list = $this->Head_details_Model->get_expense_head_details();
                        $this->data['expense_head_list'] = $expense_head_list;
                        $employee_list = $this->Employee_Model->get_employee();
                        $this->data['employee_list'] = $employee_list;
                        $this->load->view('accounts/voucher/voucher_info_table', $this->data);
                    } else {
                        $employee_information = $this->Employee_Model->get_employee($employee_id);
                        if (!empty($employee_information)) {
                            $employee_name = $employee_information->employee_name;
                        }

                        $client_information = $this->Client_Model->get_client($client_id);
                        if (!empty($client_information)) {
                            $client_name = $client_information->client_name;
                        }
                        $voucher_info = $this->session->userdata('voucher_info');  // voucher_info table list session
//                    if (!empty($voucher_info)) {
//                        $count = time();
//                    }
                        $voucher_info_table_array = $voucher_info;
                        $voucher_details = array(
                            'array_id' => time(),
                            'income_head_id' => $income_head_id,
                            'expense_head_id' => $expense_head_id,
                            'income_head_name' => $income_head_name,
                            'expense_head_name' => $expense_head_name,
                            'total_amount' => $total_amount,
                            'invoice_number' => $invoice_number,
                            'mr_number' => $mr_number,
                            'client_id' => $client_id,
                            'client_name' => $client_name,
                            'employee_id' => $employee_id,
                            'employee_name' => $employee_name,
                            'month' => $month,
                            'year' => $year,
                            'narration' => $narration,
                            'debit_amount' => $debit_amount,
                            'credit_amount' => $credit_amount,
                        );

                        if (!empty($voucher_info)) {
                            array_push($voucher_info_table_array, $voucher_details);
                        } else {
                            $voucher_info_table_array = array();
                            array_push($voucher_info_table_array, $voucher_details);
                        }
                        $this->session->set_userdata('voucher_info', $voucher_info_table_array);

                        $voucher_debit_amount = 0;
                        foreach ($this->session->userdata('voucher_info') as $voucher) {
                            $voucher_debit_amount += (double) $voucher['debit_amount'];
                        }
                        $this->session->set_userdata('voucher_debit_amount', $voucher_debit_amount);
                        $this->session->userdata('voucher_debit_amount');

                        $voucher_credit_amount = 0;
                        foreach ($this->session->userdata('voucher_info') as $voucher) {
                            $voucher_credit_amount += (double) $voucher['credit_amount'];
                        }
                        $this->session->set_userdata('voucher_credit_amount', $voucher_credit_amount);
                        $this->session->userdata('voucher_credit_amount');

                        $income_head_list = $this->Head_details_Model->get_income_head_details();
                        $this->data['income_head_list'] = $income_head_list;
                        $expense_head_list = $this->Head_details_Model->get_expense_head_details();
                        $this->data['expense_head_list'] = $expense_head_list;
                        $employee_list = $this->Employee_Model->get_employee();
                        $this->data['employee_list'] = $employee_list;
                        $this->load->view('accounts/voucher/voucher_info_table', $this->data);
                    }
                }
            } else {
                redirect('accounts/voucher');
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function is_head_sundry_debitors($income_head_id = 0, $expense_head_id = 0, $client_id = 0) {
        $head_sundry_debitors = FALSE;
        if (($income_head_id == 105 || $expense_head_id == 105) && $client_id <= 0) { //Sundry Debitors (Import -Savar)
            $head_sundry_debitors = TRUE;
        }
        if (($income_head_id == 100 || $expense_head_id == 100) && $client_id <= 0) { //Sundry Debitors (Lubzone -Savar)
            $head_sundry_debitors = TRUE;
        }
        return $head_sundry_debitors;
    }

    public function get_valid_head_in_table($head_id, $head_type, $posting_type, $total_amount) {
        $head_details_posting_by_head_id = $this->Head_details_posting_Model->get_head_details_posting_by_head_id($head_id);
        if (!empty($head_details_posting_by_head_id)) {
            if ($head_type == 'both' && $posting_type == 'cr') {
                if ($total_amount > ($head_details_posting_by_head_id->total_amount)) {  //100 >100000
                    return FALSE;
                } else {
                    return TRUE;
                }
            } else {
                return TRUE;
            }
        } else {
            if ($head_type != 'both' && $posting_type == 'cr') {
                return TRUE;
            } elseif ($posting_type == 'dr') {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function clear_voucher_info_table_session() {  // clear assets table
        $this->session->unset_userdata('voucher_info');
        $this->session->unset_userdata('voucher_debit_amount');
        $this->session->unset_userdata('voucher_credit_amount');
        redirect('accounts/voucher');
    }

    public function save_voucher() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $posting_date = $this->input->post('posting_date');
            $voucher_number = $this->input->post('voucher_number');
            $voucher_number_exist_result = $this->Voucher_posting_details_Model->is_exist_voucher_number(trim($voucher_number));
            if (!empty($voucher_number_exist_result) == TRUE) {
                $voucher_number = $voucher_number + 1;
            } else {
                $voucher_number = $this->input->post('voucher_number');
            }
            $common_narration = trim($this->input->post('common_narration'));
            $voucher_info = $this->session->userdata('voucher_info');
            if (empty($voucher_info)) {
                $this->session->set_flashdata('voucher_info_table_error_message', 'Please Add Voucher Information into the Table');
                redirect('accounts/voucher');
            }

            $voucher_debit_amount_session = (double) ($this->session->userdata('voucher_debit_amount'));
            $voucher_credit_amount_session = (double) ($this->session->userdata('voucher_credit_amount'));

            //if ($voucher_debit_amount_session != $voucher_credit_amount_session) {
            if (get_floating_point_number($voucher_debit_amount_session) != get_floating_point_number($voucher_credit_amount_session)) {
                $this->session->set_flashdata('debit_credit_error_message', 'Please check debit/credit total amount');
                redirect('accounts/voucher');
            }
//            echo '<pre>';
//            print_r($voucher_info);
//            echo '</pre>';
//            die();
            $currently_inserted_voucher_posting_details_id = $this->voucher_posting_details_save($posting_date, $voucher_number, $voucher_debit_amount_session, $voucher_credit_amount_session, $common_narration, $user_id);

            if (!empty($currently_inserted_voucher_posting_details_id)) {
                if ((!empty($voucher_info))) {
                    foreach ($voucher_info as $voucher) {

                        if (!empty($voucher['employee_id']) && ((int) $voucher['employee_id']) > 0) {
                            //employee_benefit_save
                            $this->employee_benefit_save($voucher, $currently_inserted_voucher_posting_details_id, $user_id);
                        }

                        $previous_head_details_posting_total_balance = $this->get_previous_head_details_posting_balance($voucher);
                        //head_details_posting_save
                        $this->head_details_posting_save($voucher);
                        //voucher_details_save
                        $this->voucher_details_save($voucher, $currently_inserted_voucher_posting_details_id, $previous_head_details_posting_total_balance);
                        //daywise_head_posting_save
                        $this->daywise_head_posting_save($voucher, $user_id, $previous_head_details_posting_total_balance);
                        //client_accounts_transaction_details_save
                        if (!empty($voucher['client_id']) && ((int) $voucher['client_id']) > 0) {
                            $client_accounts_transaction_details_array = array();
                            $client_accounts_transaction_details_array = array(
                                'client_id' => $voucher['client_id'],
                                'voucher_number' => $voucher_number,
                                'invoice_number' => $voucher['invoice_number'],
                                'mr_number' => $voucher['mr_number'],
                                'posting_date' => $posting_date,
                                'debit_amount' => $voucher['debit_amount'],
                                'credit_amount' => $voucher['credit_amount'],
                                'narration' => $voucher['narration'],
                                'income_head_id' => $voucher['income_head_id'],
                                'expense_head_id' => $voucher['expense_head_id'],
                                'user_id' => $user_id,
                            );
                            $this->client_accounts_transaction_details_save($client_accounts_transaction_details_array);
                        }
                    }
                    $this->session->set_userdata('voucher_Session_for_print', $voucher_info);

                    $this->get_session_clear();

                    $this->session->set_flashdata('voucher_success_message', 'Voucher information has been saved successfully');

                    redirect('accounts/voucher');
                } else {
                    
                }
            } else {
                
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function client_accounts_transaction_details_save($client_accounts_transaction_details_array) {

        $client_id = $client_accounts_transaction_details_array['client_id'];

        $current_date_time = $this->User_Model->get_current_date_and_time();

        $last_client_accounts_transaction_details = $this->Client_accounts_transaction_details_Model->get_last_client_accounts_transaction_details($client_id);

//        echo '<pre>';
//        print_r($last_client_accounts_transaction_details);
//        echo '</pre>';
//        die();

        if (!empty($client_accounts_transaction_details_array['credit_amount']) && ((int) $client_accounts_transaction_details_array['credit_amount'] > 0)) {
            $opening_balance = !empty($last_client_accounts_transaction_details) ? ($last_client_accounts_transaction_details->closing_balance) : 0;
            $debit_amount = 0;
            $credit_amount = $client_accounts_transaction_details_array['credit_amount'];
            $closing_balance = (!empty($last_client_accounts_transaction_details) ? ($last_client_accounts_transaction_details->closing_balance) : 0) - (double) $client_accounts_transaction_details_array['credit_amount'];
        } else {
            $opening_balance = !empty($last_client_accounts_transaction_details) ? ($last_client_accounts_transaction_details->closing_balance) : 0;
            $debit_amount = $client_accounts_transaction_details_array['debit_amount'];
            $credit_amount = 0;
            $closing_balance = (!empty($last_client_accounts_transaction_details) ? (double) ($last_client_accounts_transaction_details->closing_balance) : 0) + (double) $client_accounts_transaction_details_array['debit_amount'];
        }
        $head_id = 0;
        if (!empty($client_accounts_transaction_details_array['income_head_id']) && ((int) $client_accounts_transaction_details_array['income_head_id'] > 0)) {
            $head_id = $client_accounts_transaction_details_array['income_head_id'];
        } else {
            $head_id = $client_accounts_transaction_details_array['expense_head_id'];
        }

        $client_accounts_transaction_details_data = array(
            'client_id' => $client_id,
            'voucher_number' => $client_accounts_transaction_details_array['voucher_number'],
            'invoice_number' => !empty($client_accounts_transaction_details_array['invoice_number']) ? $client_accounts_transaction_details_array['invoice_number'] : '',
            'mr_number' => !empty($client_accounts_transaction_details_array['mr_number']) ? $client_accounts_transaction_details_array['mr_number'] : '',
            'transaction_date' => $current_date_time,
            'opening_balance' => $opening_balance,
            'debit_amount' => $debit_amount,
            'credit_amount' => $credit_amount,
            'closing_balance' => $closing_balance,
            'narration' => !empty($client_accounts_transaction_details_array['narration']) ? $client_accounts_transaction_details_array['narration'] : '',
            'head_id' => $head_id,
            'user_id' => $client_accounts_transaction_details_array['user_id'],
        );
        $this->Client_accounts_transaction_details_Model->db->insert('client_accounts_transaction_details', $client_accounts_transaction_details_data);
    }

    public function get_session_clear() {
        $this->session->unset_userdata('voucher_info');
        $this->session->unset_userdata('voucher_debit_amount');
        $this->session->unset_userdata('voucher_credit_amount');
    }

    public function voucher_posting_details_save($posting_date, $voucher_number, $voucher_debit_amount_session, $voucher_credit_amount_session, $common_narration, $user_id) {
        $voucher_posting_details_data = array(
            'posting_date' => $posting_date,
            'voucher_number' => $voucher_number,
            'total_debit_amount' => $voucher_debit_amount_session,
            'total_credit_amount' => $voucher_credit_amount_session,
            'common_narration' => $common_narration,
            'user_id' => $user_id,
        );
        $this->Voucher_posting_details_Model->db->insert('voucher_posting_details', $voucher_posting_details_data);
        $currently_inserted_voucher_posting_details_id = $this->db->insert_id();
        return $currently_inserted_voucher_posting_details_id;
    }

    public function employee_benefit_save($voucher, $currently_inserted_voucher_posting_details_id, $user_id) {  //employee_benefit_save
        if (((!empty($voucher['expense_head_id']) || ($voucher['expense_head_id'] > 0)) && (!empty($voucher['employee_id'])))) {
            $salary_details_by_month_year_employee_id = $this->Salary_details_Model->get_salary_details_by_month_year_employee_id($voucher['employee_id'], $voucher['month'], $voucher['year']);
            if (!empty($salary_details_by_month_year_employee_id)) {
                $this->update_employee_benefit_in_salary_details($salary_details_by_month_year_employee_id, $voucher);
            } else {
                // if salary don't generate yet then salary generate first
                //$this->salary_details_save($voucher, $user_id);
            }
            $employee_benefit_data = array(
                'employee_id' => $voucher['employee_id'],
                'month' => $voucher['month'],
                'year' => $voucher['year'],
                'head_id' => $voucher['expense_head_id'],
                'amount' => $voucher['debit_amount'],
                'voucher_posting_details_id' => $currently_inserted_voucher_posting_details_id,
            );
            $this->Employee_benefit_Model->db->insert('employee_benefit', $employee_benefit_data);
        }
    }

    public function update_employee_benefit_in_salary_details($salary_details_by_month_year_employee_id, $voucher) {
        $salary_details_data = array(
            'id' => $salary_details_by_month_year_employee_id->id,
            'employee_benefit' => ($salary_details_by_month_year_employee_id->employee_benefit) + ($voucher['debit_amount']),
            'user_id' => $salary_details_by_month_year_employee_id->user_id,
        );
        $this->db->where('id', $salary_details_data['id']);
        $this->Salary_details_Model->db->update('salary_details', $salary_details_data);
    }

    public function salary_details_save($voucher, $user_id) {
        $employee = $this->Employee_Model->get_employee($voucher['employee_id']);
        if (!empty($employee)) {
            if (($employee->deactivate_employee) <= 0) {
                $gross_salary = ($employee->basic_salary) + ($employee->phone_allowance) + ($employee->tuition_allowance) + ($employee->attendance_allowance) + ($employee->bonus) + ($employee->others);
                $pf_and_loan = ($employee->pf_contribution) + ($employee->loan_installment);
                $salary_details_data = array(
                    'employee_id' => $employee->id,
                    'basic_salary' => $employee->basic_salary,
                    'phone_allowance' => $employee->phone_allowance,
                    'tuition_allowance' => $employee->tuition_allowance,
                    'attendance_allowance' => $employee->attendance_allowance,
                    'bonus' => $employee->bonus,
                    'others' => $employee->others,
                    'gross_salary' => $gross_salary,
                    'pf_contribution' => $employee->pf_contribution,
                    'loan_installment' => $employee->loan_installment,
                    'net_salary' => $gross_salary - $pf_and_loan,
                    'month' => $voucher['month'],
                    'year' => $voucher['year'],
                    'employee_benefit' => ($voucher['debit_amount']),
                    'user_id' => $user_id,
                );
                $this->Salary_details_Model->db->insert('salary_details', $salary_details_data);
            } else {
                $gross_salary = ($employee->basic_salary) + ($employee->phone_allowance) + ($employee->tuition_allowance) + ($employee->attendance_allowance) + ($employee->bonus) + ($employee->others);
                $pf_and_loan = ($employee->pf_contribution) + ($employee->loan_installment);
                $salary_details_data = array(
                    'employee_id' => $employee->id,
                    'basic_salary' => 0,
                    'phone_allowance' => 0,
                    'tuition_allowance' => 0,
                    'attendance_allowance' => 0,
                    'bonus' => 0,
                    'others' => 0,
                    'gross_salary' => 0,
                    'pf_contribution' => 0,
                    'loan_installment' => 0,
                    'net_salary' => 0,
                    'month' => $voucher['month'],
                    'year' => $voucher['year'],
                    'employee_benefit' => ($voucher['debit_amount']),
                    'user_id' => $user_id,
                );
                $this->Salary_details_Model->db->insert('salary_details', $salary_details_data);
            }
        }
    }

    public function get_previous_head_details_posting_balance($voucher) {
        $income_head_id = (int) ($voucher['income_head_id']);
        $expense_head_id = (int) ($voucher['expense_head_id']);

        if (!empty($income_head_id) && $income_head_id > 0) {
            $head_id = $income_head_id;
        } else {
            $head_id = $expense_head_id;
        }
        $head_details_posting_information = $this->Head_details_posting_Model->get_head_details_posting_by_head_id($head_id);
        return $previous_head_details_posting_balance = ($head_details_posting_information->total_amount);
    }

    public function voucher_details_save($voucher, $currently_inserted_voucher_posting_details_id, $previous_head_details_posting_total_balance) {  //voucher_details_save
        $income_head_id = (int) ($voucher['income_head_id']);
        $expense_head_id = (int) ($voucher['expense_head_id']);

        if (!empty($income_head_id) && $income_head_id > 0) {
            $head_id = $income_head_id;
        } else {
            $head_id = $expense_head_id;
        }
        $head_details_posting_information = $this->Head_details_posting_Model->get_head_details_posting_by_head_id($head_id);

        $voucher_details_data = array(
            'income_head_id' => $voucher['income_head_id'],
            'expense_head_id' => $voucher['expense_head_id'],
            'amount' => $voucher['total_amount'],
            'invoice_number' => $voucher['invoice_number'],
            'mr_number' => $voucher['mr_number'],
            'client_id' => $voucher['client_id'],
            'employee_id' => $voucher['employee_id'],
            'month' => $voucher['month'],
            'year' => $voucher['year'],
            'narration' => $voucher['narration'],
            'debit_amount' => $voucher['debit_amount'],
            'credit_amount' => $voucher['credit_amount'],
            'opening_balance' => ($previous_head_details_posting_total_balance),
            'closing_balance' => ($head_details_posting_information->total_amount),
            'voucher_posting_details_id' => $currently_inserted_voucher_posting_details_id,
        );
        $this->Voucher_details_Model->db->insert('voucher_details', $voucher_details_data);
    }

    public function head_details_posting_save($voucher) {
        $income_head_id = (int) ($voucher['income_head_id']);
        $expense_head_id = (int) ($voucher['expense_head_id']);

        if (!empty($income_head_id) && $income_head_id > 0) {
            $head_id = $income_head_id;
        } else {
            $head_id = $expense_head_id;
        }
        $head_details_information = $this->Head_details_Model->get_head_details($head_id);
        $head_type = $head_details_information->head_type;

        $head_details_posting_by_head_id = $this->Head_details_posting_Model->get_head_details_posting_by_head_id($head_id);

        if ($head_type == 'dr') {
            $head_id = ($head_details_information->id);
            $debit_amount = 0;
            $credit_amount = (double) ($voucher['debit_amount']);
            //$total_amount = $credit_amount;
            $total_amount = ((double) $head_details_posting_by_head_id->total_amount) + $credit_amount;
        } elseif ($head_type == 'cr') {
            $head_id = ($head_details_information->id);
            $debit_amount = (double) ($voucher['credit_amount']);
            $credit_amount = 0;
            $total_amount = ((double) $head_details_posting_by_head_id->total_amount) - $debit_amount;
        } else {
            $voucher_debit_amount = (double) ($voucher['debit_amount']);
            $voucher_credit_amount = (double) ($voucher['credit_amount']);
            if (!empty($voucher_debit_amount) && $voucher_debit_amount > 0) {  // my debit for both
                $head_id = ($head_details_information->id);
                $debit_amount = 0;
                $credit_amount = $voucher_debit_amount;
                //$total_amount = $credit_amount;
                $total_amount = ((double) $head_details_posting_by_head_id->total_amount) + $credit_amount;
            } else { // my credit for both
                $head_id = ($head_details_information->id);
                $debit_amount = $voucher_credit_amount;
                $credit_amount = 0;
                //$total_amount = $debit_amount;
                $total_amount = ((double) $head_details_posting_by_head_id->total_amount) - $debit_amount;
            }
        }
        if (!empty($head_details_posting_by_head_id)) {
            $head_details_posting_data = array(
                'id' => $head_details_posting_by_head_id->id,
                'head_id' => $head_details_posting_by_head_id->head_id,
                'total_amount' => $total_amount,
                'debit_amount' => ((double) $head_details_posting_by_head_id->debit_amount) + $debit_amount,
                'credit_amount' => ((double) $head_details_posting_by_head_id->credit_amount) + $credit_amount,
            );
            $this->db->where('id', $head_details_posting_data['id']);
            $this->Head_details_posting_Model->db->update('head_details_posting', $head_details_posting_data);
        } else {
            $head_details_posting_data = array(
                'head_id' => $head_id,
                'total_amount' => $total_amount,
                'debit_amount' => $debit_amount,
                'credit_amount' => $credit_amount,
            );
            $this->Head_details_posting_Model->db->insert('head_details_posting', $head_details_posting_data);
        }
    }

    public function delete_voucher_info($array_id = 0) {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $voucher_info = $this->session->userdata('voucher_info');
            if ((!empty($voucher_info))) {
                $credit_array = array();
                foreach ($voucher_info as $credit) {
                    if ($array_id != $credit['array_id']) {
                        array_push($credit_array, $credit);
                    }
                }
                $this->session->set_userdata('voucher_info', $credit_array);
                $this->session->userdata('voucher_info');

                $voucher_debit_amount = 0;
                foreach ($this->session->userdata('voucher_info') as $voucher) {
                    $voucher_debit_amount += (double) $voucher['debit_amount'];
                }
                $this->session->set_userdata('voucher_debit_amount', $voucher_debit_amount);
                $this->session->userdata('voucher_debit_amount');

                $voucher_credit_amount = 0;
                foreach ($this->session->userdata('voucher_info') as $voucher) {
                    $voucher_credit_amount += (double) $voucher['credit_amount'];
                }
                $this->session->set_userdata('voucher_credit_amount', $voucher_credit_amount);
                $this->session->userdata('voucher_credit_amount');
                redirect('accounts/voucher');
            } else {
                redirect('accounts/voucher');
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function daywise_head_posting_save($voucher, $user_id, $previous_head_details_posting_total_balance) {
        $income_head_id = (int) ($voucher['income_head_id']);
        $expense_head_id = (int) ($voucher['expense_head_id']);

        if (!empty($income_head_id) && $income_head_id > 0) {
            $head_id = $income_head_id;
            $posting_type = 'credit';
        } else {
            $head_id = $expense_head_id;
            $posting_type = 'debit';
        }
        $current_date = date('Y-m-d');
        $daywise_head_posting_by_current_date_and_head_id = $this->Daywise_head_posting_Model->get_daywise_head_posting_by_date_and_head_id($current_date, $head_id);
        $head_details_posting_by_head_id = $this->Head_details_posting_Model->get_head_details_posting_by_head_id($head_id);
        if (empty($daywise_head_posting_by_current_date_and_head_id)) {
            if ($posting_type == 'debit') {
                //$opening_balance = ($head_details_posting_by_head_id->total_amount);
                $opening_balance = ($previous_head_details_posting_total_balance);
                $debit_amount = (double) ($voucher['debit_amount']);
                $credit_amount = 0;
                $closing_balance = $opening_balance + $debit_amount;
            } else {
                //$opening_balance = ($head_details_posting_by_head_id->total_amount);
                $opening_balance = ($previous_head_details_posting_total_balance);
                $debit_amount = 0;
                $credit_amount = (double) ($voucher['credit_amount']);
                $closing_balance = $opening_balance - $credit_amount;
            }
            $daywise_head_posting_data = array(
                'head_id' => $head_id,
                'posting_date' => date('Y-m-d'),
                'opening_balance' => $opening_balance,
                'debit_amount' => $debit_amount,
                'credit_amount' => $credit_amount,
                'closing_balance' => $closing_balance,
                'user_id' => $user_id,
            );
            $this->Daywise_head_posting_Model->db->insert('daywise_head_posting', $daywise_head_posting_data);
        } else {
            if ($posting_type == 'debit') {
                $opening_balance = $daywise_head_posting_by_current_date_and_head_id->opening_balance; //5000
                $debit_amount = (double) $daywise_head_posting_by_current_date_and_head_id->debit_amount + (double) ($voucher['debit_amount']); //500
                $credit_amount = ($daywise_head_posting_by_current_date_and_head_id->credit_amount); //0
                $closing_balance = ($daywise_head_posting_by_current_date_and_head_id->closing_balance) + (double) ($voucher['debit_amount']); //4500
            } else {
                $opening_balance = $daywise_head_posting_by_current_date_and_head_id->opening_balance;
                $debit_amount = $daywise_head_posting_by_current_date_and_head_id->debit_amount;
                $credit_amount = $daywise_head_posting_by_current_date_and_head_id->credit_amount + (double) ($voucher['credit_amount']);
                $closing_balance = ($daywise_head_posting_by_current_date_and_head_id->closing_balance) - (double) ($voucher['credit_amount']);
            }
            $daywise_head_posting_data = array(
                'id' => $daywise_head_posting_by_current_date_and_head_id->id,
                'head_id' => $daywise_head_posting_by_current_date_and_head_id->head_id,
                'posting_date' => $daywise_head_posting_by_current_date_and_head_id->posting_date,
                'opening_balance' => $opening_balance,
                'debit_amount' => $debit_amount,
                'credit_amount' => $credit_amount,
                'closing_balance' => $closing_balance,
                'user_id' => $daywise_head_posting_by_current_date_and_head_id->user_id,
            );
            $this->db->where('id', $daywise_head_posting_data['id']);
            $this->Daywise_head_posting_Model->db->update('daywise_head_posting', $daywise_head_posting_data);
        }
    }

}
