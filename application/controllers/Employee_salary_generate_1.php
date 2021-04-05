<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_salary_generate extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Company_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Salary_details_Model');
        $this->load->model('Pf_funds_Model');
        $this->load->model('Pf_funds_details_Model');
        $this->load->model('Loan_Model');
        $this->load->model('Loan_details_Model');
        $this->load->model('User_Model');
        $this->load->model('Employee_benefit_Model');
        date_default_timezone_set("Asia/Dhaka");
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == true)) {
            $user_info = $this->session->userdata('user_session');
            $this->data['title'] = "Employee Salary Generate";
            $employee_list = $this->Employee_Model->get_employee();

            $month_name_session = $this->session->userdata('month_name_session');
            $year_session = $this->session->userdata('year_session');
            $this->get_clear_month_and_year_session();
            if ((!empty($month_name_session)) && (!empty($year_session))) {
                $month = $month_name_session;
                $year = $year_session;
            } else {
                //$current_month = date('F');
                //$month = Date('F', strtotime($current_month . " last month"));
                date_default_timezone_set("Asia/Dhaka");
                $current_date = date('Y-m-d');
                $prev = strtotime("first day of last month");
                $previous_date_from_current_date = date('Y-m-d', $prev);

                $previous_month_with_date = strtotime($previous_date_from_current_date);
                $month = date('F', $previous_month_with_date);
                $year = date('Y', $previous_month_with_date);
            }
            $this->data['employee_list'] = $employee_list;
            //employee_id, month, year
            $employee_salary_details = $this->get_employee_salary_details_by_employee_id_month(0, $month, $year); //get list
            $this->data['employee_salary_details'] = $employee_salary_details;
            $this->data['month'] = $month;
            $this->data['year'] = $year;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('employee/employee_salary_information', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_clear_month_and_year_session() {
        $this->session->unset_userdata('month_name_session');
        $this->session->unset_userdata('year_session');
    }

    public function salary_generate() {  //salary_generate
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == true)) {
            $user_info = $this->session->userdata('user_session');
            $this->data['title'] = "Employee Salary Generate";
            $user_info = $this->session->userdata('user_session');
            $month = trim($this->input->post('month'));
            $this->session->set_flashdata('month_name_flashdata', $month);
            $this->session->set_userdata('month_name_session', $month);
            $month_name_session = $this->session->userdata('month_name_session');
            $this->data['month_name_session'] = $month_name_session;
            $year = trim($this->input->post('year'));
            $this->session->set_flashdata('year_flashdata', $year);
            $this->session->set_userdata('year_session', $year);
            $year_session = $this->session->userdata('year_session');
            $this->data['year_session'] = $year_session;
            $user_id = $user_info['user_id']; // session user id
            $employee_list = $this->Employee_Model->get_employee();
            $this->data['employee_list'] = $employee_list;

            $select_month_year = $this->get_date_by_month_name($month, $year);

            $current_date_time = (date('Y-m-d') . ' 00:00:00');
            $previous_date_time = Date('Y-m-d', strtotime($current_date_time . " last month"));
            $previous_date_time = ($previous_date_time . ' 00:00:00');

            $select_month_year = date('Y-m-d', strtotime($select_month_year));
            $previous_date_time = date('Y-m-d', strtotime($previous_date_time));
            if ($select_month_year <= $previous_date_time) {
                $this->salary_details_save($employee_list, $select_month_year, $month, $year, $user_id);
                $this->session->set_flashdata('salary_generate_success_message', 'Employee Salary has been generated Successfully');
                redirect(base_url('employee_salary_generate'));
            } else {
                $this->session->set_flashdata('selected_month_year_error_message', 'Please Select Correct Month and Year');
                redirect(base_url('employee_salary_generate'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_date_by_month_name($month, $year) {
        $month_number = date("n", strtotime(ucfirst($month)));
        if ($month_number < 10) {
            $month_number = '0' . $month_number;
        }
        $select_month_year = $year . '-' . $month_number . '-' . '01' . ' ' . '00:00:00';
        return $select_month_year;
    }

    public function employee_salary_details($salary_details_id = 0) { // show employee salary details information
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == true)) {
            $salary_details = $this->Salary_details_Model->get_salary_details($salary_details_id);
            $employee_id = $salary_details->employee_id;
            $user_info = $this->session->userdata('user_session');
            $this->session->set_userdata('url_session', current_url());
            $this->data['title'] = "Salary Generate Details";
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $employee = $this->Employee_Model->get_employee($employee_id);  // $id = $employee_id
            $this->data['employee'] = $employee;
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;

            //$current_month = date('F');
            //$previous_month = Date('F', strtotime($current_month . " last month"));
            $month_name_session = $this->session->userdata('month_name_session');
            $year_session = $this->session->userdata('year_session');
            /* if ((!empty($month_name_session)) && (!empty($year_session))) {
              $month = $month_name_session;
              $year = $year_session;
              } else {
              //$current_month = date('F');
              //$month = Date('F', strtotime($current_month . " last month"));
              $current_date = date('Y-m-d');
              $previous_date_from_current_date = Date('Y-m-d', strtotime($current_date . " last month"));
              $previous_month_with_date = strtotime($previous_date_from_current_date);
              $month = date('F', $previous_month_with_date);
              $year = date('Y', $previous_month_with_date);
              } */
            $employee_salary_details = $this->get_employee_salary_details_by_employee_id_salary_details_id($employee_id, $salary_details_id);
            $month = $salary_details->month;
            $year = $salary_details->year;
            $employee_loan_information = $this->get_employee_loan_information_by_employee_id_month($employee_id, $month, $year);
            $pf_funds_by_employee_id = $this->Pf_funds_Model->get_pf_funds_by_employee_id($employee_id);
            $pf_details_by_salary_details_id = $this->Pf_funds_details_Model->get_pf_details_by_salary_details_id($employee_salary_details->id);
            $this->data['employee_salary_details'] = $employee_salary_details;
            $this->data['employee_loan_information'] = $employee_loan_information;
            $this->data['pf_funds_by_employee_id'] = $pf_funds_by_employee_id;
            $this->data['pf_details_by_salary_details_id'] = $pf_details_by_salary_details_id;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('employee/employee_salary_generate', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_employee_salary_details_by_employee_id_month($employee_id, $month, $year) {
        if ($employee_id == 0) {
            $result = $this->db->query("SELECT s.id, s.employee_id, s.basic_salary, s.phone_allowance, s.tuition_allowance, s.attendance_allowance, s.bonus, s.others, s.gross_salary,s.pf_contribution, s.loan_installment, s.net_salary, s.month, s.year, s.employee_benefit, s.user_id, e.employee_name, e.employee_code, e.designation, e.gender, e.phone, e.mobile,e.address,e.joining_date,e.closing_date,e.is_loan,s.others_benefit, e.pf_contribution_company_part, s.less_others_benefit, s.less_others_misc, s.take_home_salary, pfd.previous_deposit_amount,pfd.deposit_amount_total,u.user_name, p.total_deposit_amount AS p_total_deposit_amount FROM salary_details s LEFT JOIN employee_info e ON s.employee_id=e.id LEFT JOIN pf_funds p ON s.employee_id=p.employee_id LEFT JOIN pf_funds_details pfd ON s.id=pfd.salary_details_id LEFT JOIN user_info u ON s.user_id=u.id WHERE s.month='$month' AND s.year='$year' ORDER BY e.sort_order")->result();
        } else {
            $result = $this->db->query("SELECT s.id, s.employee_id, s.basic_salary, s.phone_allowance, s.tuition_allowance, s.attendance_allowance, s.bonus, s.others, s.gross_salary,
s.pf_contribution, s.loan_installment, s.net_salary, s.month, s.year, s.employee_benefit, s.user_id, e.employee_name, e.employee_code, e.designation, e.gender, e.phone, e.mobile,e.address,e.joining_date,e.closing_date,e.is_loan,s.others_benefit, e.pf_contribution_company_part, s.less_others_benefit, s.less_others_misc, s.take_home_salary, pfd.previous_deposit_amount,pfd.deposit_amount_total,u.user_name, p.total_deposit_amount AS p_total_deposit_amount FROM salary_details s LEFT JOIN employee_info e ON s.employee_id=e.id LEFT JOIN pf_funds p ON s.employee_id=p.employee_id LEFT JOIN pf_funds_details pfd ON s.id=pfd.salary_details_id LEFT JOIN user_info u ON s.user_id=u.id WHERE s.employee_id = '$employee_id' AND s.month='$month' AND s.year='$year' ORDER BY e.sort_order")->row();
        }
        return $result;
    }

    public function get_employee_salary_details_by_employee_id_salary_details_id($employee_id, $salary_details_id) {
        $result = $this->db->query("SELECT s.id, s.employee_id, s.basic_salary, s.phone_allowance, s.tuition_allowance, s.attendance_allowance, s.bonus, s.others, s.gross_salary,
s.pf_contribution, s.loan_installment, s.net_salary, s.month, s.year, s.employee_benefit, s.user_id, e.employee_name, e.employee_code, e.designation, e.gender, e.phone, e.mobile,e.address,e.joining_date,e.closing_date,e.is_loan,s.others_benefit, e.pf_contribution_company_part, s.less_others_benefit, s.less_others_misc, s.take_home_salary, pfd.previous_deposit_amount,pfd.deposit_amount_total,u.user_name, p.total_deposit_amount AS p_total_deposit_amount FROM salary_details s LEFT JOIN employee_info e ON s.employee_id=e.id LEFT JOIN pf_funds p ON s.employee_id=p.employee_id LEFT JOIN pf_funds_details pfd ON s.id=pfd.salary_details_id LEFT JOIN user_info u ON s.user_id=u.id WHERE s.employee_id = '$employee_id' AND s.id='$salary_details_id' ORDER BY e.sort_order")->row();
        return $result;
    }

    public function get_employee_loan_information_by_employee_id_month($employee_id, $month, $year) {
        return $result = $this->db->query("SELECT l.id, l.employee_id, l.loan_start_date, l.total_loan_amount, l.number_of_installment, l.per_installment_amount, l.total_installment_amount, l.details,l.user_id, ld.month, ld.year, ld.loan_payment_date, ld.previous_loan_payment, ld.due_loan_amount, ld.total_loan_payment FROM loan l JOIN loan_details ld ON l.id=ld.loan_id WHERE l.employee_id = '$employee_id' AND ld.month='$month' AND ld.year='$year'")->row();
    }

    public function salary_details_save($employee_list, $select_month_year, $month, $year, $user_id) {
        $select_month_year = date('Y-m-d', strtotime($select_month_year));
        if (!empty($employee_list)) {
            foreach ($employee_list as $employee) {
                if (((int) $employee->deactivate_employee) <= 0) {
                    $joining_date = date('Y-m-d', strtotime($employee->joining_date));
                    $closing_date = date('Y-m-d', strtotime($employee->closing_date));
                    if ((($joining_date <= $select_month_year))) {
                        if (($closing_date >= $select_month_year) || (!empty(($employee->closing_date == "0000-00-00 00:00:00")))) {
                            $salary_details_by_month_year_employee_id = $this->Salary_details_Model->get_salary_details_by_month_year_employee_id($employee->id, $month, $year);
//                            if((int)$employee->id == 13){
//                                echo '<pre>';
//                                print_r($salary_details_by_month_year_employee_id);
//                                echo '</pre>';
//                                die();
//                            }
                            if (empty($salary_details_by_month_year_employee_id)) {
                                /* edit */
                                $loan_information = $this->Loan_Model->get_loan($employee->current_loan_id);
                                if (!empty($loan_information)) {
                                    $per_installment_amount = $loan_information->per_installment_amount;
                                } else {
                                    $per_installment_amount = 0;
                                }
                                /* edit */
                                $gross_salary = (double) ((double) $employee->basic_salary) + ((double) $employee->phone_allowance) + ((double) $employee->tuition_allowance) + ((double) $employee->attendance_allowance) + ((double) $employee->bonus) + ((double) $employee->others) + ((double) $employee->others_benefit) + ((double) $employee->pf_contribution_company_part);
                                $net_salary = (double) ((double) $gross_salary) - ((double) $employee->pf_contribution_company_part) - ((double) $employee->pf_contribution) - ((double) $employee->less_others_benefit) - ((double) $employee->less_others_misc);
                                $take_home_salary = $net_salary - $per_installment_amount;
                                $pf_and_loan = ((double) $employee->pf_contribution) + ((double) $per_installment_amount);
                                $employee_benefit_amount = $this->get_employee_benefit_total_by_month_year($month, $year, $employee->id);
                                $data = array(
                                    'employee_id' => $employee->id,
                                    'basic_salary' => $employee->basic_salary,
                                    'phone_allowance' => $employee->phone_allowance,
                                    'tuition_allowance' => $employee->tuition_allowance,
                                    'attendance_allowance' => $employee->attendance_allowance,
                                    'bonus' => $employee->bonus,
                                    'others' => $employee->others,
                                    'gross_salary' => $gross_salary,
                                    'pf_contribution' => $employee->pf_contribution,
                                    'loan_installment' => $per_installment_amount,
                                    'net_salary' => $net_salary,
                                    'month' => $month,
                                    'year' => $year,
                                    'employee_benefit' => $employee_benefit_amount,
                                    'user_id' => $user_id,
                                    'others_benefit' => $employee->others_benefit,
                                    'less_others_benefit' => $employee->less_others_benefit,
                                    'less_others_misc' => $employee->less_others_misc,
                                    'take_home_salary' => $take_home_salary,
                                    'current_date_time' => get_current_date_and_time(),
                                );
                                $this->Salary_details_Model->db->insert('salary_details', $data);
                                $currently_inserted_salary_details_id = $this->db->insert_id();
                                if (!empty($currently_inserted_salary_details_id)) {
                                    $this->pf_information_save($currently_inserted_salary_details_id, $employee, $user_id);
                                    $loan = $this->Loan_Model->get_loan($employee->current_loan_id);
                                    if (!empty($loan)) {
                                        if ((int) ($employee->current_loan_id) > 0) {
                                            $this->loan_information_save($employee, $month, $year, $user_id);
                                        }
                                    }
                                }
                            } else {
//                                $this->session->set_flashdata('salary_generate_error', 'Salary Already Generated');
//                                redirect(base_url('employee_salary_generate'));
                            }
                        }
                    } else {
//                        redirect(base_url('employee_salary_generate'));
                    }
                } else {
                    
                }
            }
        }
    }

    public function get_employee_benefit_total_by_month_year($month, $year, $employee_id) {
        $employee_benefit_by_month_year = $this->Employee_benefit_Model->get_employee_benefit_total_amount_by_month_year($month, $year, $employee_id);
        return !empty($employee_benefit_by_month_year->sum_of_amount) ? $employee_benefit_by_month_year->sum_of_amount : 0;
    }

    //pf_funds and pf_funds_details save
    public function pf_information_save($currently_inserted_salary_details_id, $employee, $user_id) {
        $pf_funds_by_employee_id = $this->Pf_funds_Model->get_pf_funds_by_employee_id($employee->id);
        if (empty($pf_funds_by_employee_id)) {
            $total_deposit_amount = (double) $employee->pf_contribution;
            $pf_funds_data = array(
                'employee_id' => $employee->id,
                'pf_contribution_per_month' => $employee->pf_contribution,
                'total_deposit_amount' => $total_deposit_amount,
                'starting_date' => $employee->joining_date,
                'user_id' => $user_id,
            );
            $this->Pf_funds_Model->db->insert('pf_funds', $pf_funds_data);
        } else {
            $total_deposit_amount = ((double) $pf_funds_by_employee_id->total_deposit_amount) + ((double) $employee->pf_contribution);
            $pf_funds_data = array(
                'id' => $pf_funds_by_employee_id->id,
                'employee_id' => $employee->id,
                'pf_contribution_per_month' => $employee->pf_contribution,
                'total_deposit_amount' => $total_deposit_amount,
                'starting_date' => $employee->joining_date,
                'user_id' => $user_id,
            );
            $this->db->where('id', $pf_funds_data['id']);
            $this->Pf_funds_Model->db->update('pf_funds', $pf_funds_data);
        }
        $pf_funds_details_data = array(
            'employee_id' => $employee->id,
            'deposit_date' => date("Y-m-d"),
            'previous_deposit_amount' => $total_deposit_amount - ((double) $employee->pf_contribution),
            'deposit_amount' => $employee->pf_contribution,
            'deposit_amount_total' => $total_deposit_amount,
            'user_id' => $user_id,
            'salary_details_id' => $currently_inserted_salary_details_id,
        );
        $this->Pf_funds_details_Model->db->insert('pf_funds_details', $pf_funds_details_data);
    }

    //loan and loan_details save
    public function loan_information_save($employee, $month, $year, $user_id) {
        $employee_id = $employee->id;
        $loan = $this->Loan_Model->get_loan($employee->current_loan_id);
        $total_loan_payment = ((double) $loan->total_installment_amount) + ((double) $loan->per_installment_amount);
        $due_loan_amount = ((double) $loan->total_loan_amount) - ((double) $total_loan_payment);
        $loan_details_data = array(
            'loan_id' => $employee->current_loan_id,
            'employee_id' => $employee_id,
            'month' => $month,
            'year' => $year,
            'loan_payment_date' => date("Y-m-d"),
            'per_installment' => $loan->per_installment_amount,
            'total_loan_amount' => $loan->total_loan_amount,
            'previous_loan_payment' => $loan->total_installment_amount, // before save loan->total_installment_amount in last month loan payment amount
            'total_loan_payment' => $total_loan_payment,
            'due_loan_amount' => $due_loan_amount,
            'user_id' => $user_id,
        );
        $this->Loan_details_Model->db->insert('loan_details', $loan_details_data);
        $currently_inserted_loan_details_id = $this->db->insert_id();

        $loan_details = $this->Loan_details_Model->get_loan_details($currently_inserted_loan_details_id);

        $total_loan_amount = $loan->total_loan_amount;
        $total_installment_amount = $loan_details->total_loan_payment;

        $loan_data = array(
            'id' => $employee->current_loan_id,
            'employee_id' => $employee_id,
            'loan_start_date' => $loan->loan_start_date,
            'total_loan_amount' => $loan->total_loan_amount,
            'number_of_installment' => $loan->number_of_installment,
            'per_installment_amount' => $loan->per_installment_amount,
            'total_installment_amount' => $total_loan_payment,
            'already_paid_loan_amount' => $total_loan_payment,
            'details' => $loan->details,
            'user_id' => $user_id,
        );
        $this->db->where('id', $loan_data['id']);
        $this->Loan_Model->db->update('loan', $loan_data);

        if ($total_loan_amount <= $total_installment_amount) {
            $this->update_employee_loan_id($employee_id);
        }
    }

    public function update_employee_loan_id($employee_id) {
        $employee = $this->Employee_Model->get_employee($employee_id);
        $data = array(
            'id' => $employee->id,
            'loan_installment' => 0,
            'is_loan' => false,
            'current_loan_id' => 0,
        );
        $this->db->where('id', $data['id']);
        $this->Employee_Model->db->update('employee_info', $data);
    }

    public function get_double_type_value($pf_contribution_from_post) {
        $pf_contribution_part_1 = '';
        $pf_contribution_part_2 = '';
        $var = '';
        $pf_contribution = '';
        if (strpos(($pf_contribution_from_post), ',') !== false) {
            $var = explode(",", ($pf_contribution_from_post));
            $pf_contribution_part_1 = $var[0];
            $pf_contribution_part_2 = $var[1];
            $pf_contribution = $pf_contribution_part_1 . $pf_contribution_part_2;
        } else {
            $pf_contribution = $pf_contribution_from_post;
        }
        return $pf_contribution;
    }

    public function salary_generate_update() {
        if (!empty($this->session->userdata('user_session'))) {
            $user_info = $this->session->userdata('user_session');
            $url = $this->session->userdata('url_session');
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $employee_id = trim($this->input->post('employee_id'));
            $this->data['employee_id'] = $employee_id;
            $basic_salary = trim($this->input->post('basic_salary'));
            $phone_allowance = trim($this->input->post('phone_allowance'));
            $tuition_allowance = trim($this->input->post('tuition_allowance'));
            $attendance_allowance = trim($this->input->post('attendance_allowance'));
            $bonus = trim($this->input->post('bonus'));
            $others = trim($this->input->post('others'));
            $pf_contribution_from_post = trim($this->input->post('pf_contribution'));
            $pf_contribution = (double) $this->get_double_type_value($pf_contribution_from_post);
            $others_benefit = trim($this->input->post('others_benefit'));
            $less_others_benefit = trim($this->input->post('less_others_benefit'));
            $less_others_misc = trim($this->input->post('less_others_misc'));

            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;

            $salary_details_id = trim($this->input->post('salary_details_id'));

            $salary_details = $this->Salary_details_Model->get_salary_details($salary_details_id);

            $employee = $this->Employee_Model->get_employee($employee_id);
            if ((int) $employee->current_loan_id > 0) {
                $loan_per_installment = trim($this->input->post('loan_per_installment'));
            } else {
                $loan_per_installment = 0;
            }
            $employee_salary_details = $this->get_employee_salary_details_by_employee_id_month($employee_id, $salary_details->month, $salary_details->year);
            $employee_loan_information = $this->get_employee_loan_information_by_employee_id_month($employee_id, $salary_details->month, $salary_details->year);
            $this->data['employee'] = $employee;
            $this->data['employee_salary_details'] = $employee_salary_details;
            $this->data['employee_loan_information'] = $employee_loan_information;

            $gross_salary = ((double) $basic_salary) + ((double) $phone_allowance) + ((double) $tuition_allowance) + ((double) $attendance_allowance) + ((double) $bonus) + ((double) $others) + ((double) $others_benefit) + ((double) $employee_salary_details->pf_contribution_company_part);
            $net_salary = ((double) $gross_salary) - ((double) $employee_salary_details->pf_contribution_company_part) - ((double) $pf_contribution) - ((double) $less_others_benefit) - ((double) $less_others_misc);
            $take_home_salary = ((double) $net_salary) - ((double) $loan_per_installment);
            $pf_and_loan = ((double) $pf_contribution) + ((double) $loan_per_installment);
            $month = $salary_details->month;
            $year = $salary_details->year;
            $data = array(
                'id' => $salary_details_id,
                'employee_id' => $employee_id,
                'basic_salary' => $basic_salary,
                'phone_allowance' => $phone_allowance,
                'tuition_allowance' => $tuition_allowance,
                'attendance_allowance' => $attendance_allowance,
                'bonus' => $bonus,
                'others' => $others,
                'gross_salary' => $gross_salary,
                'pf_contribution' => $pf_contribution,
                'loan_installment' => $loan_per_installment,
                'net_salary' => $net_salary,
                'month' => $month,
                'year' => $year,
                'employee_benefit' => 0,
                'user_id' => $user_id,
                'others_benefit' => $others_benefit,
                'less_others_benefit' => $less_others_benefit,
                'less_others_misc' => $less_others_misc,
                'take_home_salary' => $take_home_salary,
            );
            $this->form_validation->set_rules('basic_salary', 'Basic Salary', 'required');
            $this->form_validation->set_rules('phone_allowance', 'Phone Allowance', 'required');
            $this->form_validation->set_rules('tuition_allowance', 'Tuition Allowance', 'required');
            $this->form_validation->set_rules('attendance_allowance', 'Attendance Allowance', 'required');
            $this->form_validation->set_rules('bonus', 'Bonus', 'required');
            $this->form_validation->set_rules('others', 'Others', 'required');
            $this->form_validation->set_rules('pf_contribution', 'P/F Contribution', 'required');
            $this->form_validation->set_rules('loan_per_installment', 'Loan Per Installment', 'required');

            if ($this->form_validation->run() === FALSE) {
                redirect($url);
            } else {
                $this->db->where('id', $data['id']);
                $this->Salary_details_Model->db->update('salary_details', $data);
                $this->pf_information_update($employee, $month, $year, $user_id, $salary_details, $pf_contribution);
                $this->loan_information_update($employee, $month, $year, $user_id, $loan_per_installment);
                redirect(base_url('employee_salary_generate'));
                //redirect($url);
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function pf_information_update($employee, $month, $year, $user_id, $salary_details, $pf_contribution) {
        $employee_id = $employee->id;
        $salary_details_id = $salary_details->id;
        $pf_funds_by_employee_id = $this->Pf_funds_Model->get_pf_funds_by_employee_id($employee->id);
        $pf_details_by_salary_details_id = $this->Pf_funds_details_Model->get_pf_details_by_salary_details_id($salary_details_id);
        $deposit_amount_total = 0;

        if (!empty($pf_details_by_salary_details_id)) {
            $deposit_amount_total = (double) ($pf_details_by_salary_details_id->deposit_amount_total) + (double) ($pf_contribution) - (double) ($pf_details_by_salary_details_id->deposit_amount);
            $pf_funds_details_data = array(
                'id' => $pf_details_by_salary_details_id->id,
                'employee_id' => $employee_id,
                'deposit_date' => date("Y-m-d"),
                'previous_deposit_amount' => $pf_details_by_salary_details_id->previous_deposit_amount,
                'deposit_amount' => $pf_contribution,
                'deposit_amount_total' => $deposit_amount_total,
                'user_id' => $user_id,
                'salary_details_id' => $salary_details_id,
            );
            $this->db->where('id', $pf_funds_details_data['id']);
            $this->Pf_funds_details_Model->db->update('pf_funds_details', $pf_funds_details_data);
        }
        $total_deposit_amount = (double) ($pf_funds_by_employee_id->total_deposit_amount) + (double) ($pf_contribution) - (double) ($pf_details_by_salary_details_id->deposit_amount);
        $pf_funds_data = array(
            'id' => $pf_funds_by_employee_id->id,
            'employee_id' => $employee->id,
            'pf_contribution_per_month' => $employee->pf_contribution,
            'total_deposit_amount' => $total_deposit_amount,
            'starting_date' => $employee->joining_date,
            'user_id' => $user_id,
        );
        $this->db->where('id', $pf_funds_data['id']);
        $this->Pf_funds_Model->db->update('pf_funds', $pf_funds_data);
    }

    public function loan_information_update($employee, $month, $year, $user_id, $loan_per_installment) {
        $employee_id = $employee->id;
        $current_loan_id = $employee->current_loan_id;
        if ((int) $current_loan_id > 0) {
            $loan = $this->Loan_Model->get_loan($current_loan_id);
            $loan_details_by_employee_id_current_loan_id_month_year = $this->Loan_details_Model->get_loan_details_by_employee_id_current_loan_id_month_year($employee_id, $current_loan_id, $month, $year);
            $total_loan_amount = (double) ($loan->total_loan_amount);
            $total_loan_payment = ((double) $loan_details_by_employee_id_current_loan_id_month_year->previous_loan_payment) + ((double) $loan_per_installment);
            $due_loan_amount = ((double) $total_loan_amount) - ((double) $total_loan_payment);
            $loan_details_data = array(
                'id' => $loan_details_by_employee_id_current_loan_id_month_year->id,
                'loan_id' => $current_loan_id,
                'employee_id' => $employee_id,
                'month' => $month,
                'year' => $year,
                'loan_payment_date' => date("Y-m-d"),
                'per_installment' => $loan_per_installment, // new input
                'total_loan_amount' => $total_loan_amount,
                'previous_loan_payment' => $loan_details_by_employee_id_current_loan_id_month_year->previous_loan_payment, // before save loan->total_installment_amount in last month loan payment amount
                'total_loan_payment' => $total_loan_payment,
                'due_loan_amount' => $due_loan_amount,
                'user_id' => $user_id,
            );
            $this->db->where('id', $loan_details_data['id']);
            $this->Loan_Model->db->update('loan_details', $loan_details_data);

            $loan_details = $this->Loan_details_Model->get_loan_details($loan_details_by_employee_id_current_loan_id_month_year->id);
            $total_installment_amount = $loan_details->total_loan_payment;
            $loan_data = array(
                'id' => $current_loan_id,
                'employee_id' => $employee_id,
                'loan_start_date' => $loan->loan_start_date,
                'total_loan_amount' => $total_loan_amount,
                'number_of_installment' => $loan->number_of_installment,
                'per_installment_amount' => $loan->per_installment_amount,
                'total_installment_amount' => $loan_details->total_loan_payment,
                'already_paid_loan_amount' => $loan_details->total_loan_payment,
                'details' => $loan->details,
                'user_id' => $user_id,
            );
            $this->db->where('id', $loan_data['id']);
            $this->Loan_Model->db->update('loan', $loan_data);

            if ($total_loan_amount <= $total_installment_amount) {
                $this->update_employee_loan_id($employee_id); // loan id and isntallment amount will be 0 while is loan closed
            }
        }
    }

    public function is_salary_generate_or_not() {
        $is_salary_generate_or_not = FALSE;
        $month = trim($this->input->post('month'));
        $year = trim($this->input->post('year'));
        $salary_details_by_month_year = $this->Salary_details_Model->get_salary_details_by_month_year($month, $year);
        if (!empty($salary_details_by_month_year)) {
            echo $is_salary_generate_or_not = TRUE;
        } else {
            echo $is_salary_generate_or_not = FALSE;
        }
    }

}
