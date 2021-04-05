<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Loan extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Employee_Model');
        $this->load->model('Loan_Model');
        $this->load->model('Loan_details_Model');
        $this->load->model('User_Model');
    }

    public function index() {  // load loan details
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['title'] = "Loan List";
            $this->data['loan_list'] = $this->Loan_Model->get_loan();
            $this->data['employee_loan_list'] = $this->Loan_Model->get_employee_loan();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('loan_information/loan_details_list', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function create_new_loan() {  // load create loan page
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['title'] = "Create Loan";
            $this->data['employee_list'] = $this->Employee_Model->get_employee();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('loan_information/create_new_loan', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function save_loan() {  // save loan information
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['title'] = 'Create New Loan';
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $employee_list = $this->Employee_Model->get_employee();
            $this->data['employee_list'] = $employee_list;
            $employee_id = trim($this->input->post('employee_id'));
            $employee = $this->Employee_Model->get_employee($employee_id); //employee information
            $current_loan_id = $employee->current_loan_id;
            $total_loan_amount = trim($this->input->post('total_loan_amount'));
            $current_loan_amount = trim($this->input->post('current_loan_amount'));
            $already_paid_loan_amount = trim($this->input->post('already_paid_loan_amount'));
            $per_installment_amount = trim($this->input->post('per_installment_amount'));
            $number_of_installment = trim($this->input->post('number_of_installment'));
            $data = array(
                'employee_id' => $employee_id,
                'loan_start_date' => trim($this->input->post('loan_start_date')),
                'total_loan_amount' => $total_loan_amount,
                'number_of_installment' => $number_of_installment,
                'per_installment_amount' => $per_installment_amount,
                'total_installment_amount' => !empty($already_paid_loan_amount) ? $already_paid_loan_amount : 0,
                'details' => trim($this->input->post('details')),
                'user_id' => $user_id,
                'already_paid_loan_amount' => !empty($already_paid_loan_amount) ? $already_paid_loan_amount : 0,
            );
            $this->form_validation->set_rules('employee_id', 'Employee Name', 'required');
            $this->form_validation->set_rules('loan_start_date', 'Loan Date', 'required');
            $this->form_validation->set_rules('total_loan_amount', 'Total Loan Amount', 'required');
            $this->form_validation->set_rules('number_of_installment', 'Number of Installment', 'required');
            $this->form_validation->set_rules('per_installment_amount', 'Per Installment Amount', 'required');
            $this->form_validation->set_rules('details', 'Details', 'required');

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('loan_information/create_new_loan', $this->data);
            } else {
                if ((int) $current_loan_id <= 0) {
                    $this->Loan_Model->db->insert('loan', $data);
                    $currently_inserted_loan_id = $this->db->insert_id();
                    if ((!empty($currently_inserted_loan_id))) {
                        $this->update_employee_loan_id($employee_id, $currently_inserted_loan_id, $per_installment_amount);
                        redirect(base_url('loan'));
                    } else {
                        
                    }
                } else {
                    $loan = $this->Loan_Model->get_loan($current_loan_id);
                    $due_loan_amount = ((double) ($loan->total_loan_amount) - ((double) $loan->total_installment_amount));
                    $already_paid_loan_amount = (double) ($loan->total_installment_amount);
                    $per_installment_amount = ((double) $loan->per_installment_amount) + ((double) trim($this->input->post('per_installment_amount')));
                    $loan_data = array(
                        'id' => $loan->id,
                        'employee_id' => $employee_id,
                        'loan_start_date' => trim($this->input->post('loan_start_date')),
                        'total_loan_amount' => ((double) $loan->total_loan_amount) + ((double) $total_loan_amount),
                        'number_of_installment' => $number_of_installment,
                        'per_installment_amount' => $per_installment_amount,
                        'total_installment_amount' => !empty($already_paid_loan_amount) ? $already_paid_loan_amount : 0,
                        'details' => trim($this->input->post('details')),
                        'user_id' => $user_id,
                        'already_paid_loan_amount' => !empty($already_paid_loan_amount) ? $already_paid_loan_amount : 0,
                    );
                    $this->db->where('id', $loan_data['id']);
                    $this->Loan_Model->db->update('loan', $loan_data);
                    $this->update_employee_loan_id($employee_id, $loan->id, $per_installment_amount);
                    redirect(base_url('loan'));
                }
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    //off
    public function update_loan($id = 0) {  // load update loan information page
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $loan = $this->Loan_Model->get_loan($id);
            if (!empty($loan)) {
                $this->data['title'] = "Update Loan";
                $this->data['loan'] = $loan;
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('loan_information/update_loan', $this->data);
            } else {
                redirect(base_url('loan'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    //off
    public function update() {  // update loan
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['title'] = 'Update Loan';
            $id = trim($this->input->post('id'));
            $loan = $this->Loan_Model->get_loan($id);
            $this->data['loan'] = $loan;
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $data = array(
                'id' => $id,
                'employee_id' => trim($this->input->post('employee_id')),
                'loan_start_date' => trim($this->input->post('loan_start_date')),
                'total_loan_amount' => trim($this->input->post('total_loan_amount')),
                'number_of_installment' => trim($this->input->post('number_of_installment')),
                'per_installment_amount' => trim($this->input->post('per_installment_amount')),
                'details' => trim($this->input->post('details')),
                'user_id' => $loan->user_id,
            );
            $this->form_validation->set_rules('employee_id', 'Employee Name', 'required');
            $this->form_validation->set_rules('loan_start_date', 'Loan Date', 'required');
            $this->form_validation->set_rules('total_loan_amount', 'Total Loan Amount', 'required');
            $this->form_validation->set_rules('number_of_installment', 'Number of Installment', 'required');
            $this->form_validation->set_rules('per_installment_amount', 'Per Installment Amount', 'required');
            $this->form_validation->set_rules('details', 'Details', 'required');

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('loan_information/update_loan', $this->data);
            } else {
                $this->db->where('id', $data['id']);
                $this->Loan_Model->db->update('loan', $data);
                redirect(base_url('loan'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function delete($id) {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $this->Loan_Model->delete($id);
            redirect(base_url('loan'));
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update_employee_loan_id($employee_id, $currently_inserted_loan_id, $per_installment_amount) {
        $employee = $this->Employee_Model->get_employee($employee_id);
        $data = array(
            'id' => $employee->id,
            'loan_installment' => $per_installment_amount,
            'is_loan' => TRUE,
            'current_loan_id' => $currently_inserted_loan_id,
        );
        $this->db->where('id', $data['id']);
        $this->Employee_Model->db->update('employee_info', $data);
    }

    public function partial_loan_payment() {  // Load Partial Loan Payment
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $this->data['title'] = "Partial Loan Payment";
//            $this->data['employee_list'] = $this->Employee_Model->get_employee();
            $this->data['employee_loan_list'] = $this->Loan_Model->get_employee_loan();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('loan_information/partial_loan_payment', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function partial_loan_payment_save() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == TRUE)) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $employee_id = trim($this->input->post('employee_id'));
            $current_payment = trim($this->input->post('current_payment'));
            $current_due_amount = trim($this->input->post('current_due_amount'));
            $partial_loan_payment_date = trim($this->input->post('partial_loan_payment_date'));
            $employee_loan_information = $this->Loan_Model->get_employee_loan($employee_id);
            $employee = $this->Employee_Model->get_employee($employee_id);

            $this->form_validation->set_rules('employee_id', 'Employee', 'required');
            $this->form_validation->set_rules('current_payment', 'Current Payment', 'required');
            $this->form_validation->set_rules('current_due_amount', 'Current Due Amount', 'required');
            $this->form_validation->set_rules('partial_loan_payment_date', 'Date', 'required');

            if ($this->form_validation->run() === FALSE) {
                $this->data['title'] = "Partial Loan Payment";
//                $this->data['employee_list'] = $this->Employee_Model->get_employee();
                $this->data['employee_loan_list'] = $this->Loan_Model->get_employee_loan();
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('loan_information/partial_loan_payment', $this->data);
            } else {
                $previous_due_amount = get_floating_point_number(((double) $employee_loan_information->total_loan_amount) - ((double) $employee_loan_information->total_installment_amount));
                $current_due_amount = ((double) $previous_due_amount - (double) $current_payment);
                /* if selected employee h */
                if ((double) $current_due_amount >= 0) {
                    $current_loan_id = $employee->current_loan_id;
                    /* if selected employee has loan */
                    if ((int) $current_loan_id > 0) {
                        $loan = $this->Loan_Model->get_loan($current_loan_id);
                        $total_loan_payment = ((double) $employee_loan_information->total_installment_amount) + ((double) $current_payment);

                        $currently_inserted_loan_details_id = $this->save_loan_details_for_partial_loan_payment($employee_id, $current_loan_id, $partial_loan_payment_date, $current_payment, $current_due_amount, $total_loan_payment, $loan, $user_id);

                        if ((int) $currently_inserted_loan_details_id > 0) {
                            $this->update_loan_for_partial_loan_payment($employee_id, $currently_inserted_loan_details_id, $current_loan_id, $total_loan_payment);
                        }
                        $this->session->set_flashdata('partial_loan_payment_save_success_message', 'Information has been saved successfully.');
                    } else {
                        $this->session->set_flashdata('partial_loan_payment_save_error_message', 'This employee has already paid his/her loan.');
                    }
                } else {
                    $this->session->set_flashdata('partial_loan_payment_save_error_message', 'Please Input corrent Payment.');
                }
                redirect(base_url('loan/partial_loan_payment'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    //loan_details save for partial loan payment
    public function save_loan_details_for_partial_loan_payment($employee_id, $current_loan_id, $partial_loan_payment_date, $current_payment, $current_due_amount, $total_loan_payment, $loan, $user_id) {
        $loan_details_data = array(
            'loan_id' => $current_loan_id,
            'employee_id' => $employee_id,
            'month' => 'partial',
            'year' => date('Y', strtotime($partial_loan_payment_date)),
            'loan_payment_date' => $partial_loan_payment_date,
            'per_installment' => $loan->per_installment_amount,
            'total_loan_amount' => $loan->total_loan_amount,
            'previous_loan_payment' => $loan->total_installment_amount, // before save loan->total_installment_amount in last month loan payment amount
            'total_loan_payment' => $total_loan_payment,
            'due_loan_amount' => $current_due_amount,
            'user_id' => $user_id,
        );
        $this->Loan_details_Model->db->insert('loan_details', $loan_details_data);
        return $currently_inserted_loan_details_id = $this->db->insert_id();
    }

    //loan info update for partial loan payment
    public function update_loan_for_partial_loan_payment($employee_id, $currently_inserted_loan_details_id, $current_loan_id, $total_loan_payment) {
        $loan_data = array(
            'id' => $current_loan_id,
            'employee_id' => $employee_id,
            'total_installment_amount' => $total_loan_payment,
            'already_paid_loan_amount' => $total_loan_payment,
        );
        $this->db->where('id', $loan_data['id']);
        $this->Loan_Model->db->update('loan', $loan_data);

        $loan = $this->Loan_Model->get_loan($current_loan_id);
        if ((double) $loan->total_loan_amount == (double) $loan->total_installment_amount) {
            $this->update_employee_loan_id_for_partial_loan_payment($employee_id);
        }
    }

    //update employee info for partial loan payment
    public function update_employee_loan_id_for_partial_loan_payment($employee_id) {
        $employee_info_data = array(
            'id' => $employee_id,
            'loan_installment' => 0,
            'is_loan' => FALSE,
            'current_loan_id' => 0,
        );
        $this->db->where('id', $employee_info_data['id']);
        $this->Employee_Model->db->update('employee_info', $employee_info_data);
    }

}
