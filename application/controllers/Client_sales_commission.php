<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_sales_commission extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Product_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Client_Model');
        $this->load->model('Invoice_details_Model');
        $this->load->model('Sale_product_Model');
        $this->load->model('Client_sales_commission_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Dealer_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $this->data['title'] = "Client Sales Commission";
            $this->data['page_title'] = "Client Sales Commission";
            $start_date = get_start_date_format(get_previous_date_from_current_date_by_month($months = 6));
            $end_date = get_end_date_format(get_current_date());
            $this->data['client_sales_commission_list'] = $this->Client_sales_commission_Model->get_client_sales_commission_by_date($start_date, $end_date);
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('client_sales_commission/client_sales_commission_list', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function create_client_sales_commission() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $this->data['title'] = "New Sales Commission";
            $this->data['page_title'] = "New Sales Commission";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('client_sales_commission/create_client_sales_commission', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_invoice_details() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $message = '';
                $invoice_details = NULL;
                $invoice_data = array();
                $is_invoice = FALSE;
                $invoice_number = trim($this->input->post('invoice_number'));
                if (!empty($invoice_number)) {
                    $invoice_details = $this->Invoice_details_Model->get_invoice_details_by_invoice_number($invoice_number);
                    if (!empty($invoice_details)) {
                        $client_sales_commission_by_invoice_details_id = $this->Client_sales_commission_Model->get_client_sales_commission_by_invoice_details_id($invoice_details->id);
                        if (!empty($client_sales_commission_by_invoice_details_id)) {
                            $message = '<div class="error-message">Already added commission for this invoice.</div>';
                        } else {
                            $is_invoice = TRUE;
                            $employee = $this->Employee_Model->get_employee($invoice_details->employee_id);
                            $dealer = $this->Dealer_Model->get_dealer($invoice_details->dealer_id);

                            $client_name_part_1 = '';
                            $client_name_part_2 = '';
                            $client = $this->Client_Model->get_client(intval($invoice_details->client_id));
                            if (strpos(($client->client_name), '(') !== FALSE) {
                                $client_name = explode("(", ($client->client_name));
                                $client_name_part_1 = $client_name[0];
                                $client_name_part_2 = $client_name[1];
                            } else {
                                $client_name_part_1 = $client->client_name;
                            }
                            $branch = $this->Branch_Model->get_branch($invoice_details->branch_id);
                            $order_date = date("d-m-Y", strtotime($invoice_details->order_date));
                            $order_date = ((is_valid_date($order_date))) ? $order_date : '';
                            $date_of_issue = date("d-m-Y", strtotime($invoice_details->date_of_issue));
                            $date_of_issue = ((is_valid_date($date_of_issue))) ? $date_of_issue : '';

                            $invoice_data = array(
                                'id' => intval($invoice_details->id),
                                'invoice_number' => $invoice_details->invoice_number,
                                'challan_number' => $invoice_details->challan_number,
                                'client_name' => $client_name_part_1,
                                'order_number' => !empty($invoice_details->order_number) ? $invoice_details->order_number : '',
                                'branch_name' => !empty($branch->branch_name) ? $branch->branch_name : '',
                                'employee_code' => !empty($employee->employee_code) ? $employee->employee_code : '',
                                'dealer_code' => !empty($dealer->dealer_code) ? $dealer->dealer_code : '',
                                'order_date' => $order_date,
                                'date_of_issue' => $date_of_issue,
                                'amount_to_paid' => !empty($invoice_details->amount_to_paid) ? get_floating_point_number($invoice_details->amount_to_paid) : get_floating_point_number(0),
                            );
                            $message = 'Invoice Found.';
                        }
                    } else {
                        $message = '<div class="error-message">No Invoice Found.</div>';
                    }
                } else {
                    $message = '<div class="error-message">Please Enter Invoice Number.</div>';
                }
                set_json_output(array('isInvoice' => $is_invoice, 'message' => $message, 'invoiceData' => $invoice_data));
            } else {
                redirect(base_url('client_sales_commission'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_invoice_details_for_update() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $message = '';
                $invoice_details = NULL;
                $invoice_data = array();
                $is_invoice = FALSE;
                $invoice_number = trim($this->input->post('invoice_number'));
                if (!empty($invoice_number)) {
                    $invoice_details = $this->Invoice_details_Model->get_invoice_details_by_invoice_number($invoice_number);
                    if (!empty($invoice_details)) {
                        $client_sales_commission_by_invoice_details_id = $this->Client_sales_commission_Model->get_client_sales_commission_by_invoice_details_id($invoice_details->id);
                        $is_invoice = TRUE;
                        $employee = $this->Employee_Model->get_employee($invoice_details->employee_id);
                        $dealer = $this->Dealer_Model->get_dealer($invoice_details->dealer_id);

                        $client_name_part_1 = '';
                        $client_name_part_2 = '';
                        $client = $this->Client_Model->get_client(intval($invoice_details->client_id));
                        if (strpos(($client->client_name), '(') !== FALSE) {
                            $client_name = explode("(", ($client->client_name));
                            $client_name_part_1 = $client_name[0];
                            $client_name_part_2 = $client_name[1];
                        } else {
                            $client_name_part_1 = $client->client_name;
                        }
                        $branch = $this->Branch_Model->get_branch($invoice_details->branch_id);
                        $order_date = date("d-m-Y", strtotime($invoice_details->order_date));
                        $order_date = ((is_valid_date($order_date))) ? $order_date : '';
                        $date_of_issue = date("d-m-Y", strtotime($invoice_details->date_of_issue));
                        $date_of_issue = ((is_valid_date($date_of_issue))) ? $date_of_issue : '';

                        $invoice_data = array(
                            'id' => intval($invoice_details->id),
                            'invoice_number' => $invoice_details->invoice_number,
                            'challan_number' => $invoice_details->challan_number,
                            'client_name' => $client_name_part_1,
                            'order_number' => !empty($invoice_details->order_number) ? $invoice_details->order_number : '',
                            'branch_name' => !empty($branch->branch_name) ? $branch->branch_name : '',
                            'employee_code' => !empty($employee->employee_code) ? $employee->employee_code : '',
                            'dealer_code' => !empty($dealer->dealer_code) ? $dealer->dealer_code : '',
                            'order_date' => $order_date,
                            'date_of_issue' => $date_of_issue,
                            'amount_to_paid' => !empty($invoice_details->amount_to_paid) ? get_floating_point_number($invoice_details->amount_to_paid) : get_floating_point_number(0),
                        );
                        $message = 'Invoice Found.';
                    } else {
                        $message = '<div class="error-message">No Invoice Found.</div>';
                    }
                } else {
                    $message = '<div class="error-message">Please Enter Invoice Number.</div>';
                }
                set_json_output(array('isInvoice' => $is_invoice, 'message' => $message, 'invoiceData' => $invoice_data));
            } else {
                redirect(base_url('client_sales_commission'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function save_client_sales_commission() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $this->data['title'] = "Save Sales Commission";
            $invoice_details_id = intval(trim($this->input->post('invoice_details_id')));
            $invoice_number = trim($this->input->post('invoice_number'));
            $commission_record_number = trim($this->input->post('commission_record_number'));
            $commission_amount = get_floating_point_number(trim($this->input->post('commission_amount')));
            $claim_date = trim($this->input->post('claim_date'));
            $commission_bank_name = trim($this->input->post('commission_bank_name'));
            $commission_bank_account = trim($this->input->post('commission_bank_account'));
            $commission_bkash_number = trim($this->input->post('commission_bkash_number'));
            if ((!empty($invoice_number) && ($invoice_number > 0)) && (!empty($commission_amount) && ($commission_amount > 0)) && !empty($claim_date)) {
                $invoice_details = $this->Invoice_details_Model->get_invoice_details_by_invoice_number($invoice_number);
                if (!empty($invoice_details)) {
                    $client_sales_commission_by_invoice_details_id = $this->Client_sales_commission_Model->get_client_sales_commission_by_invoice_details_id($invoice_details->id);
                    if (!empty($client_sales_commission_by_invoice_details_id)) {
                        alert_message('Already added commission for this invoice.');
                        redirect_using_jquery(base_url('client_sales_commission/create_client_sales_commission'));
                    } else {
                        $client_sales_commission_data = array(
                            'commission_record_number' => $commission_record_number,
                            'claim_date' => $claim_date,
                            'invoice_details_id	' => $invoice_details_id,
                            'commission_amount' => $commission_amount,
                            'commission_bank_name' => $commission_bank_name,
                            'commission_bank_account' => $commission_bank_account,
                            'commission_bkash_number' => $commission_bkash_number,
                            'user_id' => $user_id,
                            'current_date_time' => get_current_date_and_time()
                        );
                        $this->Client_sales_commission_Model->db->insert('client_sales_commission', $client_sales_commission_data);
                        $currently_inserted_id = $this->db->insert_id();
                        if ($currently_inserted_id > 0) {
                            $this->session->set_flashdata('client_sales_commission_success_message', 'Information has been saved successfully.');
                            redirect(base_url('client_sales_commission'));
                        } else {
                            alert_message('Insertion failed.');
                            redirect_using_jquery(base_url('client_sales_commission/create_client_sales_commission'));
                        }
                    }
                } else {
                    alert_message('No invoice details found.');
                    redirect_using_jquery(base_url('client_sales_commission/create_client_sales_commission'));
                }
            } else {
                alert_message('Please check the input fields.');
                redirect_using_jquery(base_url('client_sales_commission/create_client_sales_commission'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update_client_sales_commission($id = 0) {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $client_sales_commission = $this->Client_sales_commission_Model->get_client_sales_commission($id);
            if (!empty($client_sales_commission)) {
                $invoice_details = $this->Invoice_details_Model->get_invoice_details($client_sales_commission->invoice_details_id);
                if (!empty($invoice_details)) {
                    $this->data['title'] = "Update Sales Commission";
                    $this->data['page_title'] = "Update Sales Commission";
                    $this->data['client_sales_commission'] = $client_sales_commission;
                    $this->data['invoice_details'] = $invoice_details;
                    $this->load->view('header');
                    $this->load->view('navigation');
                    $this->load->view('client_sales_commission/update_client_sales_commission', $this->data);
                } else {
                    redirect(base_url('client_sales_commission'));
                }
            } else {
                redirect(base_url('client_sales_commission'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $is_update = FALSE;
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $this->data['title'] = "Update Sales Commission";
            $id = intval(trim($this->input->post('id')));
//            $invoice_details_id = intval(trim($this->input->post('invoice_details_id')));
            $invoice_number = trim($this->input->post('invoice_number'));
            $commission_record_number = trim($this->input->post('commission_record_number'));
            $commission_amount = get_floating_point_number(trim($this->input->post('commission_amount')));
            $claim_date = trim($this->input->post('claim_date'));
            $commission_bank_name = trim($this->input->post('commission_bank_name'));
            $commission_bank_account = trim($this->input->post('commission_bank_account'));
            $commission_bkash_number = trim($this->input->post('commission_bkash_number'));
            if (!empty($invoice_number) && !empty($commission_amount) && !empty($claim_date)) {
                $invoice_details = $this->Invoice_details_Model->get_invoice_details_by_invoice_number($invoice_number);
                if (!empty($invoice_details)) {
                    $client_sales_commission_data = array(
                        'id' => $id,
                        'commission_record_number' => $commission_record_number,
                        'claim_date' => $claim_date,
//                            'invoice_details_id	' => $invoice_details_id,
                        'commission_amount' => $commission_amount,
                        'commission_bank_name' => $commission_bank_name,
                        'commission_bank_account' => $commission_bank_account,
                        'commission_bkash_number' => $commission_bkash_number,
                        'user_id' => $user_id,
                        'current_date_time' => get_current_date_and_time()
                    );
                    $this->db->where('id', $client_sales_commission_data['id']);
                    $is_update = $this->Client_sales_commission_Model->db->update('client_sales_commission', $client_sales_commission_data);
                    if ($is_update) {
                        $this->session->set_flashdata('client_sales_commission_success_message', 'Information has been updated successfully.');
                        redirect(base_url('client_sales_commission'));
                    } else {
                        alert_message('Update failed.');
                        redirect_using_jquery(base_url('client_sales_commission/update_client_sales_commission/' . $id));
                    }
                } else {
                    alert_message('No invoice details found.');
                    redirect_using_jquery(base_url('client_sales_commission/update_client_sales_commission/' . $id));
                }
            } else {
                alert_message('Please check the input fields.');
                redirect_using_jquery(base_url('client_sales_commission/update_client_sales_commission/' . $id));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function delete() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $message = '';
                $is_delete_client_sales_commission = FALSE;
                $id = intval(trim($this->input->post('id')));
                if ($id > 0) {
                    $is_delete_client_sales_commission = $this->Client_sales_commission_Model->delete($id);
                    $message = ($is_delete_client_sales_commission) ? 'Information has been deleted successfully.' : 'Delation failed.';
                } else {
                    $message = 'Delation failed.';
                }
                set_json_output(array('message' => $message, 'isDeleteClientSalesCommission' => $is_delete_client_sales_commission, 'redirectUrl' => base_url('client_sales_commission')));
            } else {
                redirect(base_url('client_sales_commission'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

}
