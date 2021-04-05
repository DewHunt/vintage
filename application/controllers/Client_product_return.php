<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_product_return extends CI_Controller {

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
        $this->load->model('Product_receive_Model');
        $this->load->model('Stock_transfer_challan_Model');
        $this->load->model('Stock_transfer_Model');
        $this->load->model('Branch_stock_Model');
        $this->load->model('Branchwise_product_store_Model');
        $this->load->model('Product_store_Model');
        $this->load->model('Damage_or_defect_product_info_Model');
        $this->load->model('Damage_or_defect_product_details_Model');
        $this->load->model('Client_product_damage_or_defect_info_Model');
        $this->load->model('Client_product_damage_or_defect_details_Model');
        $this->load->model('Client_product_return_info_Model');
        $this->load->model('Client_product_return_details_Model');
        $this->load->model('Challan_details_Model');
        $this->load->model('Challan_product_Model');
        $this->load->model('Client_transaction_details_Model');
        $this->load->model('Client_sales_details_Model');
        $this->load->model('Edit_invoice_Model');
    }

    public function index() {
        if (get_user_permission('client_product_return') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "Client Return Product";
        $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
        $this->data['product_list'] = $this->Product_Model->get_product();
        $this->data['branch_list'] = $this->Branch_Model->get_branch();
        $this->data['client_list'] = $this->Client_Model->get_client();
        $this->get_session_empty();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('client_product_return/client_product_return', $this->data);
    }

    public function get_branch_info() { //show return product in table
        if (get_user_permission('client_product_return') === false) {
            redirect(base_url('user_login'));
        }
        $invoice_number = $this->input->post('invoice_number');
        $invoice_details = $this->Invoice_details_Model->get_invoice_details_by_invoice_number($invoice_number);
        $branch_info = $this->Branch_Model->get_branch($invoice_details->branch_id);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'branch_info' => $branch_info,
        )));
    }

    public function client_product_return_show_in_table() { //show return product in table
        if (get_user_permission('client_product_return') === false) {
            redirect(base_url('user_login'));
        }
        if ($this->input->is_ajax_request()) {
            $this->get_session_empty();
            $invoice_number = trim($this->input->post('invoice_number'));
            $output = "";

            if (empty($invoice_number)) {
                echo '<div class="error-message text-align-center">Please Enter Invoice Number.</div>';
                $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
                $this->load->view('client_product_return/client_product_return_table', $this->data);
            } else {
                $invoice_details = $this->Invoice_details_Model->get_invoice_details_by_invoice_number($invoice_number);
                // echo "<pre>"; print_r($invoice_details);

                if (empty($invoice_details)) {
                    echo '<div class="error-message text-align-center">Invoice Not Found.</div>';
                    $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
                    $output = $this->load->view('client_product_return/client_product_return_table', $this->data);
                } else {
                    $branch_info = $this->Branch_Model->get_branch($invoice_details->branch_id);
                    $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
                    $sale_product_list = $this->Sale_product_Model->get_sale_product_list($invoice_details->id);
                    $sale_product_list_row = $this->Sale_product_Model->get_sale_product_list_row($invoice_details->id);
                    // echo "<pre>"; print_r($sale_product_list_row); exit();
                    $this->data['invoice_details'] = $invoice_details;
                    $this->data['sale_product_list'] = $sale_product_list;
                    $this->data['sale_product_list_row'] = $sale_product_list_row;
                    $output = $this->load->view('client_product_return/client_product_return_table', $this->data);
                }
            }
        } else {
            redirect(base_url('client_product_return'));
        }
    }

    public function get_session_empty() {
        $this->session->unset_userdata('client_invoice_details_session');
        $this->session->unset_userdata('client_return_product_list_table_array');
    }

    public function return_quantity_from_table() {
        if (get_user_permission('client_product_return') === false) {
            redirect(base_url('user_login'));
        }
        if ($this->input->is_ajax_request()) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $reduce_quantity = 0;
            $reduce_unit_price = 0;
            $sale_product_id = trim($this->input->post('sale_product_id'));
            $new_quantity = trim($this->input->post('new_quantity'));
            $invoice_id = trim($this->input->post('invoice_id'));
            $product_id = trim($this->input->post('product_id'));
            $new_amount = trim($this->input->post('new_amount'));
            $status = trim($this->input->post('status'));
            $deduction = get_floating_point_number(trim($this->input->post('deduction')));
            $invoice_details = $this->Invoice_details_Model->get_invoice_details($invoice_id);
            $invoice_amount_to_paid = !empty($invoice_details) ? get_floating_point_number($invoice_details->amount_to_paid) : 0;
            $this->session->set_userdata('client_invoice_details_session', $invoice_details);
            $sale_product_by_invoice_id_and_product_id = $this->Sale_product_Model->get_sale_product_by_invoice_id_and_product_id($invoice_id, $product_id);
            $previous_quantity = $sale_product_by_invoice_id_and_product_id->quantity;
            $previous_amount = (double) $sale_product_by_invoice_id_and_product_id->unit_price * (double) $previous_quantity;

            if ((strtolower($status) != 'remove')) {
                $reduce_quantity = (int) $previous_quantity - (int) $new_quantity;
            } else {
                $reduce_quantity = (int) ($previous_quantity);
            }

            if ((strtolower($status) != 'remove') && (((int) $new_quantity >= (int) $sale_product_by_invoice_id_and_product_id->quantity)) && ((int) $new_quantity < 0)) {
                //echo 'failed';
            } else {
                $return_amount = 0;
                $total_amount_after_return = 0;

                $flag = TRUE;

                if ((strtolower($status) != 'remove') && ((double) $new_amount == (double) $previous_amount) && ((double) $new_quantity == (double) $previous_quantity)) {
                    $flag = FALSE;
                }

                if ((int) $reduce_quantity < 0) {
                    $flag = FALSE;
                }

                if ((int) $reduce_quantity > (int) $sale_product_by_invoice_id_and_product_id->quantity) {
                    $flag = FALSE;
                }

                $client_return_product_table_array_info = $this->session->userdata('client_return_product_list_table_array');
                $client_return_product_list_table_array = $client_return_product_table_array_info;
                $status_result = ''; // reduce or increase
                if ((double) $previous_amount > (double) $new_amount) {
                    $status_result = 'reduce';
                    $return_amount = $previous_amount - $new_amount;
                    $total_amount_after_return = (double) $invoice_details->product_total - (double) $return_amount;
                } elseif ((double) $previous_amount < (double) $new_amount) {
                    $status_result = 'increase';
                    $return_amount = $new_amount - $previous_amount;
                    $total_amount_after_return = (double) $invoice_details->product_total + (double) $return_amount;
                } else {

                    if ($status != 'remove') {
                        $status_result = 'reduce';
                        $return_amount = (double) $reduce_quantity * (double) $sale_product_by_invoice_id_and_product_id->unit_price;
                        $total_amount_after_return = (double) $invoice_details->product_total - $return_amount;
                    } else {
                        $status_result = 'reduce';
                        $return_amount = (double) $reduce_quantity * (double) $sale_product_by_invoice_id_and_product_id->unit_price;
                        $total_amount_after_return = (double) $invoice_details->product_total - $return_amount;
                    }
                }

                if (((double) $new_amount == (double) $previous_amount)) {
                    $return_amount = 0;
                }

                if ($status == 'remove') {
                    $return_amount = $previous_amount;
                }

                if ($flag) {
                    $reduce_product_details = array(
                        'array_id' => time(),
                        'sale_product_id' => $sale_product_id,
                        'product_id' => $product_id,
                        'invoice_id' => $invoice_id,
                        'invoice_number' => $invoice_details->invoice_number,
                        'challan_number' => $invoice_details->challan_number,
                        'client_id' => $invoice_details->client_id,
                        'branch_id' => $invoice_details->branch_id,
                        'previous_quantity' => $previous_quantity,
                        'quantity' => $reduce_quantity,
                        'total_amount' => $invoice_details->product_total,
                        'unit_price' => $sale_product_by_invoice_id_and_product_id->unit_price,
                        'previous_amount' => $previous_amount,
                        'new_amount' => $new_amount,
                        'return_amount' => $return_amount,
                        'total_amount_after_return' => $total_amount_after_return,
                        'user_id' => $user_id,
                        'status' => $status_result,
                    );

                    if (!empty($client_return_product_table_array_info)) {
                        $duplicate_status = $this->get_duplicate_sale_product_id($sale_product_id);
                        if ((strtolower($duplicate_status) != 'yes')) {
                            array_push($client_return_product_list_table_array, $reduce_product_details);
                        } else {
                            echo '<div class="error-message text-align-center">You have already added this product.</div>';
                        }
                        //echo 'updated';
                    } else {
                        $client_return_product_list_table_array = array();
                        array_push($client_return_product_list_table_array, $reduce_product_details);
                        //echo 'updated';
                    }
                    $this->session->set_userdata('client_return_product_list_table_array', $client_return_product_list_table_array);
                }
            }
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $reduce_product_list_table_array_session = $this->session->userdata('client_return_product_list_table_array');
            $this->data['deduction'] = $deduction;
            $this->data['invoice_amount_to_paid'] = $invoice_amount_to_paid;
            $this->data['total_return_amount'] = (double) $this->get_total_return_amount($reduce_product_list_table_array_session);

            if ($invoice_amount_to_paid == 0) {
                $this->data['current_deduction'] = $deduction - $this->data['total_return_amount'];
            }
            
            $this->data['reduce_product_list_table_array'] = $reduce_product_list_table_array_session;
            $this->load->view('client_product_return/client_reduce_product_return_table', $this->data);
//                $this->client_reduce_product_return_table();
        } else {
            redirect(base_url('client_product_return'));
        }
    }

    public function client_reduce_product_return_table() {
        $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
        $reduce_product_list_table_array_session = $this->session->userdata('client_return_product_list_table_array');
        $this->data['total_return_amount'] = (double) $this->get_total_return_amount($reduce_product_list_table_array_session);
        $this->data['reduce_product_list_table_array'] = $reduce_product_list_table_array_session;
        $this->load->view('client_product_return/client_reduce_product_return_table', $this->data);
    }

    /* public function client_product_quantity_from_table_update($sale_product_id) {
      $client_return_product_table_array_info = $this->session->userdata('client_return_product_list_table_array');
      if (!empty($client_return_product_table_array_info)) {
      $product_array = array();
      foreach ($client_return_product_table_array_info as $reduce_product_table) {
      if ((int) $sale_product_id != (int) $reduce_product_table['sale_product_id']) {
      array_push($product_array, $reduce_product_table);
      }
      }
      $this->session->set_userdata('client_return_product_list_table_array', $product_array);
      $this->session->userdata('client_return_product_list_table_array');
      }
      } */

    public function get_duplicate_sale_product_id($sale_product_id) {
        $duplicate_status = '';
        $client_return_product_table_array_info = $this->session->userdata('client_return_product_list_table_array');
        if (!empty($client_return_product_table_array_info)) {
            foreach ($client_return_product_table_array_info as $reduce_product_table) {
                if ((int) $sale_product_id == (int) $reduce_product_table['sale_product_id']) {
                    $duplicate_status = 'yes';
                    return $duplicate_status;
                }
            }
        }
    }

    public function client_product_return_information_save() {
        if (get_user_permission('client_product_return') === false) {
            redirect(base_url('user_login'));
        }
        // echo "<pre>"; print_r($this->input->post()); exit();

        $remarks = trim($this->input->post('remarks'));
        $return_date = trim($this->input->post('return_date'));
        $branch_id = trim($this->input->post('branch_id'));
        $adjust_deduction = trim($this->input->post('adjust_deduction'));
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id']; // session user id
        if (empty($return_date) || empty($remarks) || empty($branch_id)) {
            $this->get_session_empty();
            $this->session->set_flashdata('branch_return_date_and_remarks_error_message', 'Outlet, Date and Remarks Required');
            //redirect(base_url('client_product_return'));
        } else {
            $return_date = get_current_date_and_time($return_date); // get date with time
            $invoice_details_session = $this->session->userdata('client_invoice_details_session');
            $client_return_product_table_array_info = $this->session->userdata('client_return_product_list_table_array');
            if (!empty($client_return_product_table_array_info)) {
                $client_id = (int) ($invoice_details_session->client_id);
                $client_information = $this->Client_Model->get_client($client_id);
                //1st
                $res = $this->update_invoice_details_after_return($invoice_details_session, $remarks, $client_return_product_table_array_info);
                if (!$res) {
                    $this->session->set_flashdata('client_product_return_table_error_message', 'Amount can not be negative. Please check Order Information.');
                    redirect(base_url('client_product_return'));
                }
                //2nd
                $this->update_sale_product($invoice_details_session, $client_return_product_table_array_info); //ok
                //3rd
                $this->update_challan_product($invoice_details_session, $client_return_product_table_array_info); //ok
                //4th
                $this->update_return_amount_in_client_info($invoice_details_session, $client_return_product_table_array_info, $client_information);
                //5th
                $this->client_transaction_details_save($invoice_details_session, $client_return_product_table_array_info, $client_information);
                //6th
                $this->client_sales_details_save($invoice_details_session, $client_return_product_table_array_info, $client_information);
                //7th
                $this->save_edit_invoice_information($invoice_details_session, $client_return_product_table_array_info, $user_id);
                $total_return_amount = 0;
                $total_return_amount = $this->get_total_return_amount($client_return_product_table_array_info);
                //8th
                $currently_inserted_client_product_return_info_id = $this->save_client_product_return_info($return_date, $remarks, $invoice_details_session, $client_return_product_table_array_info);
                if (!empty($currently_inserted_client_product_return_info_id)) {
                    //9th
                    $this->save_client_product_return_details($client_return_product_table_array_info, $currently_inserted_client_product_return_info_id);
                    //10th
                    $this->update_client_return_product_in_branch_stock($branch_id, $client_return_product_table_array_info);
                    //11th
                    $this->branchwise_product_store_save($client_return_product_table_array_info, $branch_id, trim($this->input->post('return_date')));
                    //12th
                    $this->product_store_save($client_return_product_table_array_info, trim($this->input->post('return_date')));
                    //13th
                    $this->update_stock_in_product($client_return_product_table_array_info);
                }
                $this->get_session_empty();
                $this->session->set_flashdata('client_product_return_save_message', 'Information has been saved successfully.');
                //redirect(base_url('client_product_return'));
            } else {
                $this->session->Set_flashdata('client_product_return_table_error_message', 'Error occured please try again');
                //redirect(base_url('client_product_return'));
            }
        }
        redirect(base_url('client_product_return'));
    }

    public function get_total_return_amount($client_return_product_table_array_info) {
        $total_return_amount = 0;
        if (!empty($client_return_product_table_array_info)) {
            foreach ($client_return_product_table_array_info as $client_return_product_table) {
                $total_return_amount += (double) $client_return_product_table['return_amount'];
            }
        }
        return $total_return_amount;
    }

    public function get_total_previous_amount($client_return_product_table_array_info) {
        $total_previous_amount = 0;
        if (!empty($client_return_product_table_array_info)) {
            foreach ($client_return_product_table_array_info as $client_return_product_table) {
                $total_previous_amount += (double) $client_return_product_table['previous_amount'];
            }
        }
        return $total_previous_amount;
    }

    //8th
    public function save_client_product_return_info($return_date, $remarks, $invoice_details_session, $client_return_product_table_array_info) {
        $total_amount = 0;
        $total_amount_after_return = 0;
        $total_amount = (double) $invoice_details_session->product_total;
        $return_debit_or_credit_amount = (double) $this->get_return_debit_or_credit_amount($client_return_product_table_array_info);
        if ($return_debit_or_credit_amount < 0) {
            $result = 'credit'; //reduce(-)
            $total_amount_after_return = (double) $total_amount - (double) abs($return_debit_or_credit_amount);
        } else {
            $result = 'debit'; //increase(+)
            $total_amount_after_return = (double) $total_amount + (double) abs($return_debit_or_credit_amount);
        }
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id']; // session user id
        $data = array(
            'return_date' => $return_date,
            'branch_id' => $invoice_details_session->branch_id,
            'client_id' => $invoice_details_session->client_id,
            'invoice_number' => $invoice_details_session->invoice_number,
            'challan_number' => $invoice_details_session->challan_number,
            'total_amount' => $total_amount,
            'return_amount' => abs($return_debit_or_credit_amount),
            'total_amount_after_return' => $total_amount_after_return,
            'remarks' => $remarks,
            'user_id' => $user_id,
        );
        $this->Client_product_return_info_Model->db->insert('client_product_return_info', $data);
        $currently_inserted_client_product_return_info_id = $this->db->insert_id();
        return $currently_inserted_client_product_return_info_id;
    }

    //9th
    public function save_client_product_return_details($client_return_product_table_array_info, $currently_inserted_client_product_return_info_id) {
        if (!empty($client_return_product_table_array_info)) {
            foreach ($client_return_product_table_array_info as $client_return_product_table) {
                $data = array(
                    'product_id' => $client_return_product_table['product_id'],
                    'quantity' => $client_return_product_table['quantity'],
                    'unit_price' => $client_return_product_table['unit_price'],
                    'client_product_return_info_id' => $currently_inserted_client_product_return_info_id,
                );
                $this->Client_product_return_details_Model->db->insert('client_product_return_details', $data);
            }
        }
    }

    //1st
    public function update_invoice_details_after_return($invoice_details_session, $remarks, $client_return_product_table_array_info) {
        $flag = FALSE;
        $product_total = 0;
        $gross_payable = 0;
        $amount_to_paid = 0;
        $invoice_details_data = array();
        if (!empty($client_return_product_table_array_info) && !empty($invoice_details_session)) {
            $total_return_amount = (double) $this->get_total_return_amount($client_return_product_table_array_info);
            $invoice_id = $invoice_details_session->id;
            $invoice_details = $this->Invoice_details_Model->get_invoice_details($invoice_id);
            $invoice_amount_to_paid = (!empty($invoice_details)) ? get_floating_point_number($invoice_details->amount_to_paid) : 0;
            $deduction = (!empty($invoice_details)) ? get_floating_point_number($invoice_details->deduction) : 0;
//            get_print_r(get_floating_point_number($invoice_amount_to_paid). '<'. get_floating_point_number($total_return_amount));
            if (get_floating_point_number($invoice_amount_to_paid) < get_floating_point_number($total_return_amount)) {
                if ($deduction > 0) {
                    $deduction = $deduction - $total_return_amount;
                    $flag = TRUE;
                } else {
                    $flag = FALSE;
                }
            } else {
                $flag = TRUE;
            }
            if ($flag) {
                foreach ($client_return_product_table_array_info as $client_return_product_table) {
                    $return_amount = (double) $client_return_product_table['return_amount'];
                    if (strtolower($client_return_product_table['status']) == 'reduce') {
                        if (($invoice_amount_to_paid) == 0.00) {
                            $invoice_details_data['deduction'] = $deduction;
                        } else {
                            $product_total = (double) $invoice_details_session->product_total - $total_return_amount;
                            $gross_payable = (double) $invoice_details_session->gross_payable - $total_return_amount;
                            $amount_to_paid = (double) $invoice_details_session->amount_to_paid - $total_return_amount;
                        }
                    } else {
                        $product_total = (double) $invoice_details_session->product_total + $total_return_amount;
                        $gross_payable = (double) $invoice_details_session->gross_payable + $total_return_amount;
                        $amount_to_paid = (double) $invoice_details_session->amount_to_paid + $total_return_amount;
                    }
                    $invoice_details_data['product_total'] = $product_total;
                    $invoice_details_data['gross_payable'] = $gross_payable;
                    $invoice_details_data['amount_to_paid'] = $amount_to_paid;
                    $invoice_details_data['remarks'] = $remarks;
                    $this->db->where('id', $invoice_id);
                    $this->Invoice_details_Model->db->update('invoice_details', $invoice_details_data);
                    $flag = TRUE;
                }
            }
        }
        return $flag;
    }

    //2nd
    public function update_sale_product($invoice_details_session, $client_return_product_table_array_info) {
        if (!empty($client_return_product_table_array_info) && !empty($invoice_details_session)) {
            $quantity = 0;
            $invoice_id = $invoice_details_session->id;
            foreach ($client_return_product_table_array_info as $client_return_product_table) {
                $return_amount = (double) $client_return_product_table['return_amount'];
                $product_id = (double) $client_return_product_table['product_id'];
                $sale_product_by_invoice_id_and_product_id = $this->Sale_product_Model->get_sale_product_by_invoice_id_and_product_id($invoice_id, $product_id);
                echo "<pre>"; print_r($sale_product_by_invoice_id_and_product_id); //exit();
                $quantity = (int) $sale_product_by_invoice_id_and_product_id->quantity - (int) $client_return_product_table['quantity'];
                if (strtolower($client_return_product_table['status']) == 'reduce') { //reduce                    
                    $amount = (double) $sale_product_by_invoice_id_and_product_id->sales_price_excluding_vat - $return_amount;
                } else { //increase
                    $amount = (double) $sale_product_by_invoice_id_and_product_id->sales_price_excluding_vat + $return_amount;
                }
                $sale_product_data = array(
                    'quantity' => $quantity,
                    'sales_price_excluding_vat' => $amount,
                    'sales_price_including_vat' => $amount,
                );
                if ((int) $sale_product_by_invoice_id_and_product_id->quantity == (int) $client_return_product_table['quantity']) {
                    $this->Sale_product_Model->delete($sale_product_by_invoice_id_and_product_id->id);
                } else {
                    $this->db->where('id', $sale_product_by_invoice_id_and_product_id->id);
                    $this->Sale_product_Model->db->update('sale_product', $sale_product_data);
                }
            }
        }
    }

    //3rd
    public function update_challan_product($invoice_details_session, $client_return_product_table_array_info) {
        if (!empty($client_return_product_table_array_info) && !empty($invoice_details_session)) {
            $quantity = 0;
            $amount = 0;
            $invoice_id = $invoice_details_session->id;
            $challan_details_by_invoice_id = $this->Challan_details_Model->get_challan_details_by_invoice_id($invoice_id);
            if ($challan_details_by_invoice_id) {
                $challan_id = $challan_details_by_invoice_id->id;
            }
            else {
                $challan_id = 0;
            }
            foreach ($client_return_product_table_array_info as $client_return_product_table) {
                $return_amount = (double) $client_return_product_table['return_amount'];
                $product_id = (double) $client_return_product_table['product_id'];
                $challan_product_by_challan_id_and_product_id = $this->Challan_product_Model->get_challan_product_by_challan_id_and_product_id($challan_id, $product_id);
                $total_return_amount = (double) $this->get_total_return_amount($client_return_product_table_array_info);
                $quantity = (int) $challan_product_by_challan_id_and_product_id->quantity - (int) $client_return_product_table['quantity'];
                $total_price = (double) $challan_product_by_challan_id_and_product_id->total_price;
                if (strtolower($client_return_product_table['status']) == 'reduce') { //reduce                    
                    $amount = $total_price - $total_return_amount;
                } else { //increase
                    $amount = $total_price + $total_return_amount;
                }
                $challan_product_data = array(
                    'id' => $challan_product_by_challan_id_and_product_id->id,
                    'quantity' => $quantity,
                    'total_price' => $amount,
                );
                if ((int) $challan_product_by_challan_id_and_product_id->quantity == (int) $client_return_product_table['quantity']) {
                    $this->Challan_product_Model->delete($challan_product_data['id']);
                } else {
                    $this->db->where('id', $challan_product_data['id']);
                    $this->Challan_product_Model->db->update('challan_product', $challan_product_data);
                }
            }
        }
    }

    //4th
    public function update_return_amount_in_client_info($invoice_details_session, $client_return_product_table_array_info, $client_information) {
        if (!empty($client_return_product_table_array_info) && !empty($invoice_details_session)) {
            $client_id = $invoice_details_session->client_id;
            $client_current_credit_balance = 0;
            $client_current_advance_balance = 0;
            $current_total_sale = 0;
            $invoice_amount_to_paid = get_floating_point_number($invoice_details_session->amount_to_paid);
            if ($invoice_amount_to_paid == 0) {
                $return_debit_or_credit_amount = 0;
            } else {
                $return_debit_or_credit_amount = (double) $this->get_return_debit_or_credit_amount($client_return_product_table_array_info);
            }
            $return_amount = (double) abs($return_debit_or_credit_amount);
            $client_advance_balance = (double) $client_information->advance_balance;
            $client_credit_balance = (double) $client_information->credit_balance;
            $client_total_sale = (double) $client_information->total_sale;
            if (!empty($client_information)) {
                if ((double) $return_debit_or_credit_amount < 0) {
                    if ($client_credit_balance > 0) { //reduce(-)
                        $result = $client_credit_balance - $return_amount;
                        $client_current_credit_balance = $result;
                        if ($result < 0) {
                            $client_current_credit_balance = 0;
                            $client_current_advance_balance = $client_advance_balance + abs($result);
                        } else {
                            $client_current_advance_balance = 0;
                        }
                    } else {
                        $client_current_credit_balance = 0;
                        $client_current_advance_balance = $client_advance_balance + $return_amount;
                    }
                    $current_total_sale = $client_total_sale - $return_amount;
                } else { //increase(+)
                    if ($client_credit_balance > 0) {
                        $result = $client_credit_balance + $return_amount;
                        $client_current_credit_balance = $result;
                        $client_current_advance_balance = 0;
                    } else {
                        $result = $client_advance_balance - $return_amount;
                        $client_current_advance_balance = $result;
                        if ($result < 0) {
                            $client_current_advance_balance = 0;
                            $client_current_credit_balance = $client_credit_balance + abs($result);
                        } else {
                            $client_current_credit_balance = 0;
                        }
                    }
                    $current_total_sale = $client_total_sale + $return_amount;
                }
                $client_information_data = array(
                    'id' => $client_id,
                    'credit_balance' => $client_current_credit_balance,
                    'total_sale' => $current_total_sale,
                    'advance_balance' => $client_current_advance_balance,
                );
                $this->db->where('id', $client_information_data['id']);
                $this->Client_Model->db->update('client_info', $client_information_data);
            }
        }
    }

    //5th
    public function client_transaction_details_save($invoice_details_session, $client_return_product_table_array_info, $client_information) {
        if (!empty($client_return_product_table_array_info) && !empty($invoice_details_session)) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $narration = '';
            $narration = 'Invoice No(' . $invoice_details_session->invoice_number . ')(Ret.)';
            $payment_type = $invoice_details_session->mode_of_payment;
            $client_id = (int) $invoice_details_session->client_id;
            $current_date_time = get_current_date_and_time();
            $invoice_amount_to_paid = get_floating_point_number($invoice_details_session->amount_to_paid);
            if ($invoice_amount_to_paid == 0) {
                $return_debit_or_credit_amount = 0;
            } else {
                $return_debit_or_credit_amount = (double) $this->get_return_debit_or_credit_amount($client_return_product_table_array_info);
            }
            $result = '';
            $debit_amount = 0;
            $credit_amount = 0;
            if ($return_debit_or_credit_amount < 0) {
                $result = 'reduce';  //$result = 'credit';
            } else {
                $result = 'increase';  //$result = 'debit';
            }
//            if ($return_debit_or_credit_amount != 0) {
            $last_client_transaction_details = $this->Client_transaction_details_Model->get_last_client_transaction_details($client_id);
            $opening_balance = !empty($last_client_transaction_details) ? ($last_client_transaction_details->closing_balance) : 0;
            if (strtolower($result) == 'increase') {
                $debit_amount = (double) ($return_debit_or_credit_amount);
                $credit_amount = 0;
                if ((double) $last_client_transaction_details->closing_balance >= 0) {
                    $closing_balance = (!empty($last_client_transaction_details) ? (double) ($last_client_transaction_details->closing_balance) : 0) + (double) ($return_debit_or_credit_amount);
                } else {
                    $closing_balance = (!empty($last_client_transaction_details) ? (double) ($last_client_transaction_details->closing_balance) : 0) - (double) ($return_debit_or_credit_amount);  // credit balance contain minus in db thats why using minus isstead of plus
                }
            } else {
                $debit_amount = 0;
                $credit_amount = abs($return_debit_or_credit_amount);
                $closing_balance = (!empty($last_client_transaction_details) ? (double) ($last_client_transaction_details->closing_balance) : 0) - (double) ($return_debit_or_credit_amount);
            }
            $client_transaction_details_data = array(
                'client_id' => $client_id,
                'invoice_payment_id' => 0,
                'transaction_date' => $current_date_time,
                'opening_balance' => $opening_balance, //
                'debit_amount' => abs($credit_amount), //abs($debit_amount)
                'credit_amount' => abs($debit_amount), //abs($credit_amount)
                'closing_balance' => $closing_balance,
                'narration' => $narration,
                'payment_type' => $payment_type,
                'user_id' => $user_id,
            );
            $this->Client_transaction_details_Model->db->insert('client_transaction_details', $client_transaction_details_data);
//            }
        }
    }

    //6th
    public function client_sales_details_save($invoice_details_session, $client_return_product_table_array_info, $client_information) {
        $total_credit_balance = 0;
        $total_advance_balance = 0;
        $total_sale = 0;
        $total_payment = 0;
        $status = '';
        $resize_amount = 0;
        $invoice_amount_to_paid = get_floating_point_number($invoice_details_session->amount_to_paid);
        if ($invoice_amount_to_paid == 0) {
            $return_debit_or_credit_amount = 0;
        } else {
            $return_debit_or_credit_amount = (double) $this->get_return_debit_or_credit_amount($client_return_product_table_array_info);
        }
        if ($return_debit_or_credit_amount != 0) {
            $amount = abs($return_debit_or_credit_amount);
            if ($return_debit_or_credit_amount < 0) {
                $status = 'reduce';
                $resize_amount = (double) $amount; //$result = 'credit'; //reduce(-)
            } else {
                $status = 'increase';
                $resize_amount = (double) $amount; //$result = 'debit'; //increase(+)
            }
            $current_date = get_current_date();
            $client_id = (int) ($invoice_details_session->client_id);
            $current_client_sales_details_by_date = $this->Client_sales_details_Model->get_client_sales_details_by_date($client_id, $current_date);
            $client_credit_balance = (double) $client_information->credit_balance;
            $client_advance_balance = (double) $client_information->advance_balance;
            if ($client_credit_balance > 0) {
                if (strtolower($status) == 'increase') {
                    $total_credit_balance = $client_credit_balance + $resize_amount;
                    $total_advance_balance = 0;
                } else {
                    $result = $client_credit_balance - $resize_amount;
                    if ((double) $result < 0) {
                        $total_credit_balance = 0;
                        $total_advance_balance = abs($result);
                    } else {
                        $total_credit_balance = $result;
                        $total_advance_balance = 0;
                    }
                }
            } else {
                if (strtolower($status) == 'increase') {
                    $result = $client_advance_balance - $resize_amount;
                    if ($result < 0) {
                        $total_credit_balance = abs($result);
                        $total_advance_balance = 0;
                    } else {
                        $total_credit_balance = 0;
                        $total_advance_balance = abs($result);
                    }
                } else {
                    $total_credit_balance = 0;
                    $total_advance_balance = abs($client_advance_balance + $resize_amount);
                }
            }
            if (strtolower($status) == 'increase') {
                $total_sale = !empty($current_client_sales_details_by_date->total_sale) ? ((double) $current_client_sales_details_by_date->total_sale + $resize_amount) : (0 + $resize_amount);
            } else {
                $total_sale = !empty($current_client_sales_details_by_date->total_sale) ? ((double) $current_client_sales_details_by_date->total_sale - $resize_amount) : (0 - $resize_amount);
            }
            $total_payment = !empty($current_client_sales_details_by_date->total_payment) ? $current_client_sales_details_by_date->total_payment : 0;
            $client_sales_details_data = array(
                'id' => !empty($current_client_sales_details_by_date->id) ? $current_client_sales_details_by_date->id : '',
                'client_id' => $client_id,
                'sale_date' => $current_date,
                'total_credit_balance' => $total_credit_balance,
                'total_advance_balance' => $total_advance_balance,
                'total_sale' => $total_sale,
                'total_payment' => $total_payment,
            );
            if (empty($current_client_sales_details_by_date)) {
                $this->Client_sales_details_Model->db->insert('client_sales_details', $client_sales_details_data);
            } else {
                $this->db->where('id', $client_sales_details_data['id']);
                $this->Client_sales_details_Model->db->update('client_sales_details', $client_sales_details_data);
            }
        }
    }

    //7th
    public function save_edit_invoice_information($invoice_details_session, $client_return_product_table_array_info, $user_id) {
        if (!empty($client_return_product_table_array_info) && !empty($invoice_details_session)) {
            $invoice_id = $invoice_details_session->id;
            $invoice_number = $invoice_details_session->invoice_number;
            $challan_number = $invoice_details_session->challan_number;
            $current_date_time = get_current_date_and_time();
            foreach ($client_return_product_table_array_info as $client_return_product_table) {
                $edit_invoice_data = array(
                    'invoice_id' => $invoice_id,
                    'invoice_number' => $invoice_number,
                    'challan_number' => $challan_number,
                    'edit_invoice_date' => $current_date_time,
                    'product_id' => $client_return_product_table['product_id'],
                    'previous_quantity' => !empty($client_return_product_table['previous_quantity']) ? $client_return_product_table['previous_quantity'] : 0,
                    'reduce_quantity' => !empty($client_return_product_table['quantity']) ? $client_return_product_table['quantity'] : 0,
                    'current_quantity' => (int) (!empty($client_return_product_table['previous_quantity']) ? $client_return_product_table['previous_quantity'] : 0) - (int) (!empty($client_return_product_table['quantity']) ? $client_return_product_table['quantity'] : 0),
                    'unit_price' => !empty($client_return_product_table['unit_price']) ? $client_return_product_table['unit_price'] : 0,
                    'previous_amount' => !empty($client_return_product_table['previous_amount']) ? $client_return_product_table['previous_amount'] : 0,
                    'current_amount' => !empty($client_return_product_table['new_amount']) ? $client_return_product_table['new_amount'] : 0,
                    'usre_id' => $user_id,
                );
                $this->Edit_invoice_Model->db->insert('edit_invoice', $edit_invoice_data);
            }
        }
    }

    public function get_return_debit_or_credit_amount($client_return_product_table_array_info, $v = 1) {
        $amount = 0;
        if (1) {
            $client_return_product_table_array_info[0]['return_amount'];
        }
        if (!empty($client_return_product_table_array_info)) {
            foreach ($client_return_product_table_array_info as $client_return_product_table) {
                if (strtolower($client_return_product_table['status']) == 'reduce') {
                    $amount -= (double) $client_return_product_table['return_amount'];
                } else {
                    $amount += (double) $client_return_product_table['return_amount'];
                }
            }
        }
        return $amount;
    }

    public function get_reduce_product_table_array_clear() {
        if (!empty($this->session->unset_userdata('client_return_product_list_table_array'))) {
            $this->session->unset_userdata('client_return_product_list_table_array');
        }
    }

    //10th
    public function update_client_return_product_in_branch_stock($branch_id, $client_return_product_table_array_info) {
        if (!empty($branch_id) || ((int) $branch_id > 0)) {
            if (!empty($client_return_product_table_array_info)) {
                foreach ($client_return_product_table_array_info as $client_return_product_table) {
                    $product_id = $client_return_product_table['product_id'];
                    $branch_stock_by_product_id_branch_id = $this->Branch_stock_Model->get_branch_stock_by_product_id_branch_id($product_id, $branch_id);
                    if (!empty($branch_stock_by_product_id_branch_id)) {
                        $branch_stock_data = array(
                            'id' => $branch_stock_by_product_id_branch_id->id,
                            'product_id' => $product_id,
                            'branch_id' => $branch_id,
                            'stock' => (int) $branch_stock_by_product_id_branch_id->stock + (int) $client_return_product_table['quantity'],
                        );
                        $this->db->where('id', $branch_stock_data['id']);
                        $this->Branch_stock_Model->db->update('branch_stock', $branch_stock_data);
                    } else {
                        $branch_stock_data = array(
                            'product_id' => $product_id,
                            'branch_id' => $branch_id,
                            'stock' => (int) $client_return_product_table['quantity'],
                        );
                        $this->Branch_stock_Model->db->insert('branch_stock', $branch_stock_data);
                    }
                }
            }
        }
    }

    //11th
    public function branchwise_product_store_save($client_return_product_table_array_info, $branch_id, $date) {
        foreach ($client_return_product_table_array_info as $product) {
            $branchwise_product_store_by_date = $this->Branchwise_product_store_Model->get_branchwise_product_store_by_date($date, $product['product_id'], $branch_id);
            if (!empty($branchwise_product_store_by_date)) {
                $open_stock = (int) $branchwise_product_store_by_date->open_stock;
                $receive_stock = (int) $branchwise_product_store_by_date->receive_stock + (int) $product['quantity'];
                $transfer_stock = (int) $branchwise_product_store_by_date->transfer_stock;
                $sale_from_stock = (int) $branchwise_product_store_by_date->sale_from_stock;
                $damage_stock = (int) $branchwise_product_store_by_date->damage_stock;
                $closing_stock = (int) ($open_stock + $receive_stock - $transfer_stock - $sale_from_stock - $damage_stock);
                $branchwise_product_store_data = array(
                    'id' => $branchwise_product_store_by_date->id,
                    'product_store_date' => $date,
                    'product_id' => $product['product_id'],
                    'branch_id' => $branch_id,
                    'open_stock' => $open_stock,
                    'receive_stock' => $receive_stock,
                    'transfer_stock' => $transfer_stock,
                    'sale_from_stock' => $sale_from_stock,
                    'damage_stock' => $damage_stock,
                    'closing_stock' => $closing_stock,
                );
                $this->db->where('id', $branchwise_product_store_data['id']);
                $this->Branchwise_product_store_Model->db->update('branchwise_product_store', $branchwise_product_store_data);
            } else {
                $current_date = get_current_date();
                $branchwise_product_store_from_previous_date = $this->Branchwise_product_store_Model->get_branchwise_product_store_from_previous_date_by_product_id_branch_id($current_date, $product['product_id'], $branch_id);
                if (!empty($branchwise_product_store_from_previous_date)) {
                    $open_stock = (int) $branchwise_product_store_from_previous_date->closing_stock;
                } else {
                    $open_stock = 0;
                }
                $receive_stock = (int) $product['quantity'];
                $transfer_stock = 0;
                $sale_from_stock = 0;
                $damage_stock = 0;
                $closing_stock = (int) ($open_stock + $receive_stock - $transfer_stock - $sale_from_stock - $damage_stock);
                $branchwise_product_store_data = array(
                    'product_store_date' => $date,
                    'product_id' => $product['product_id'],
                    'branch_id' => $branch_id,
                    'open_stock' => $open_stock,
                    'receive_stock' => $receive_stock,
                    'transfer_stock' => $transfer_stock,
                    'sale_from_stock' => $sale_from_stock,
                    'damage_stock' => $damage_stock,
                    'closing_stock' => $closing_stock,
                );
                $this->Branchwise_product_store_Model->db->insert('branchwise_product_store', $branchwise_product_store_data);
            }
        }
    }

    //12th
    public function product_store_save($client_return_product_table_array_info, $date) {
        foreach ($client_return_product_table_array_info as $product) {
            $product_store_by_date = $this->Product_store_Model->get_product_store_by_date($product['product_id'], $date);
            if (!empty($product_store_by_date)) {
                $open_stock = (int) $product_store_by_date->open_stock;
                $receive_stock = (int) $product_store_by_date->receive_stock + (int) $product['quantity'];
                $transfer_stock = (int) $product_store_by_date->transfer_stock;
                $sale_from_stock = (int) $product_store_by_date->sale_from_stock;
                $damage_stock = (int) $product_store_by_date->damage_stock;
                $closing_stock = (int) ($open_stock + $receive_stock - $transfer_stock - $sale_from_stock - $damage_stock);
                $product_store_data = array(
                    'id' => $product_store_by_date->id,
                    'product_store_date' => $date,
                    'product_id' => $product['product_id'],
                    'open_stock' => $open_stock,
                    'receive_stock' => $receive_stock,
                    'transfer_stock' => $transfer_stock,
                    'sale_from_stock' => $sale_from_stock,
                    'damage_stock' => $damage_stock,
                    'closing_stock' => $closing_stock,
                );
                $this->db->where('id', $product_store_data['id']);
                $this->Product_store_Model->db->update('product_store', $product_store_data);
            } else {
                $current_date = get_current_date();
                $product_store_from_previous_date = $this->Product_store_Model->get_product_store_from_previous_date_by_product_id($current_date, $product['product_id']);
                if (!empty($product_store_from_previous_date)) {
                    $open_stock = (int) $product_store_from_previous_date->closing_stock;
                } else {
                    $open_stock = 0;
                }
                $receive_stock = (int) $product['quantity'];
                $transfer_stock = 0;
                $sale_from_stock = 0;
                $damage_stock = 0;
                $closing_stock = (int) ($open_stock + $receive_stock - $transfer_stock - $sale_from_stock - $damage_stock);
                $product_store_data = array(
                    'product_store_date' => $date,
                    'product_id' => $product['product_id'],
                    'open_stock' => $open_stock,
                    'receive_stock' => $receive_stock,
                    'transfer_stock' => $transfer_stock,
                    'sale_from_stock' => $sale_from_stock,
                    'damage_stock' => $damage_stock,
                    'closing_stock' => $closing_stock,
                );
                $this->Product_store_Model->db->insert('product_store', $product_store_data);
            }
        }
    }

    //13th
    public function update_stock_in_product($client_return_product_table_array_info) {
        if (!empty($client_return_product_table_array_info)) {
            foreach ($client_return_product_table_array_info as $product) {
                if ((int) $product['quantity'] > 0) {
                    $product_information = $this->Product_Model->get_product($product['product_id']);
                    if (!empty($product_information)) {
                        $product_data = array(
                            'id' => $product['product_id'],
                            'product_stock' => (int) $product_information->product_stock + (int) $product['quantity'],
                        );
                        $this->db->where('id', $product_data['id']);
                        $this->Product_Model->db->update('product', $product_data);
                    }
                }
            }
        }
    }

    public function invoice_void() {
        if (get_user_permission('client_product_return') === false) {
            redirect(base_url('user_login'));
        }
        if ($this->input->is_ajax_request()) {
            // echo "<pre>"; print_r($this->input->post()); exit();

            $invoice_number = trim($this->input->post('invoice_number'));
            $remarks = trim($this->input->post('remarks'));
            $return_date = trim($this->input->post('return_date'));
            $branch_id = trim($this->input->post('branch_id'));
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id

            if (empty($return_date) || empty($remarks) || empty($branch_id)) {
                $this->get_session_empty();
                $this->session->set_flashdata('branch_return_date_and_remarks_error_message', 'Outlet, Date and Remarks Required');
                //redirect(base_url('client_product_return'));
            } else {
                $return_date = get_current_date_and_time($return_date); // get date with time
                $invoice_details = $this->Invoice_details_Model->get_invoice_details_by_invoice_number($invoice_number);
                $sale_product_list = $this->Sale_product_Model->get_sale_product_list($invoice_details->id);
                // echo "<pre>"; print_r($invoice_details); exit();

                if (!empty($invoice_details) && !empty($sale_product_list)) {
                    $client_id = (int) ($invoice_details->client_id);
                    $client_information = "";
                    if ($client_id != 0) {
                        $client_information = $this->Client_Model->get_client($client_id);
                    }
                    // echo "<pre>"; print_r($client_information); exit();

                    //1st for void
                    $this->update_invoice_details_after_return_for_void($invoice_details, $remarks);

                    //2nd for void
                    $this->update_sale_product_for_void($invoice_details); //ok

                    //3rd for void
                    //$this->update_challan_product_for_void($invoice_details); //ok

                    $currently_inserted_client_product_return_info_id_for_void = "";

                    if ($client_information != "") {
                        if ($client_information->credit_balance > 0) {
                            //4th for void
                            $this->update_return_amount_in_client_info_for_void($invoice_details, $client_information);

                            //5th for void
                            $this->client_transaction_details_save_for_void($invoice_details, $client_information);

                            //6th for void
                            $this->client_sales_details_save_for_void($invoice_details, $client_information);
                        }
                    }
                    //8th for void
                    $currently_inserted_client_product_return_info_id_for_void = $this->save_client_product_return_info_for_void($return_date, $remarks, $invoice_details);

                    //7th for void
                    $this->save_edit_invoice_information_for_void($invoice_details, $user_id, $sale_product_list);


                    if (!empty($currently_inserted_client_product_return_info_id_for_void)) {
                        //9th for void
                        $this->save_client_product_return_details_for_void($invoice_details, $currently_inserted_client_product_return_info_id_for_void, $sale_product_list);
                    }

                    //10th for void
                    $this->update_client_return_product_in_branch_stock_for_void($branch_id, $invoice_details, $sale_product_list);

                    //11th for void
                    $this->branchwise_product_store_save_for_void($invoice_details, $sale_product_list, $branch_id, trim($this->input->post('return_date')));

                    //12th for void
                    $this->product_store_save_for_void($sale_product_list, trim($this->input->post('return_date')));

                    //13th for void
                    $this->update_stock_in_product_for_void($sale_product_list);

                    $this->get_session_empty();
                    $this->session->set_flashdata('client_product_return_save_message', 'Information has been saved successfully.');
                    //redirect(base_url('client_product_return'));
                } else {
                    $this->session->Set_flashdata('client_product_return_table_error_message', 'Error occured please try again');
                    //redirect(base_url('client_product_return'));
                }
            }
        } else {
            redirect(base_url('client_product_return'));
        }
    }

    //1st for void
    public function update_invoice_details_after_return_for_void($invoice_details, $remarks) {
        if (!empty($invoice_details)) {
            $modeOfPayment = $invoice_details->mode_of_payment;

            if ($modeOfPayment == 'pending') {
                $modeOfPayment = 'Void';
            }
            else {
                $modeOfPayment = 'Return';
            }

            $invoice_details_data = array(
                'product_total' => 0,
                'gross_payable' => 0,
                'amount_to_paid' => 0,
                'remarks' => $remarks,
                'delivery_charge' => 0,
                'others_charge' => 0,
                'deduction' => 0,
                'gross_payable' => 0,
                'advance_adjusted' => 0,
                'amount_to_paid' => 0,
                
                'mode_of_payment' => $modeOfPayment,
                'product_total' => 0,
                'deduction_rate' => 0,
                'total_vat' => 0,
                'cash_payment' => 0,
                'paid_amount' => 0,
                'change_amount' => 0,
                'card_payment' => 0,
            );
            $this->db->where('id', $invoice_details->id);
            $this->Invoice_details_Model->db->update('invoice_details', $invoice_details_data);
        }
    }

    //2nd for void
    public function update_sale_product_for_void($invoice_details) {
        if (!empty($invoice_details)) {
            $sale_product_list = $this->Sale_product_Model->get_sale_product_list($invoice_details->id);
            if (!empty($sale_product_list)) {
                foreach ($sale_product_list as $sale_product) {
                    $this->Sale_product_Model->delete($sale_product->id);
                }
            }
        }
    }

    //3rd for void
    public function update_challan_product_for_void($invoice_details) {
        if (!empty($invoice_details)) {
            $challan_details_by_invoice_id = $this->Challan_details_Model->get_challan_details_by_invoice_id($invoice_details->id);
            $challan_id = $challan_details_by_invoice_id->id;
            $challan_product_by_challan_id = $this->Challan_product_Model->get_challan_product_by_challan_id($challan_id);
            if (!empty($challan_product_by_challan_id)) {
                foreach ($challan_product_by_challan_id as $challan_product) {
                    $this->Challan_product_Model->delete($challan_product->id);
                }
            }
        }
    }

    //4th for void
    public function update_return_amount_in_client_info_for_void($invoice_details, $client_information) {
        if (!empty($invoice_details) && !empty($client_information)) {
            $client_id = $invoice_details->client_id;
            $client_current_credit_balance = 0;
            $client_current_advance_balance = 0;
            $current_total_sale = 0;
            $return_debit_or_credit_amount = (double) $invoice_details->amount_to_paid;
            $return_amount = (double) abs($return_debit_or_credit_amount);
            $client_advance_balance = (double) $client_information->advance_balance;
            $client_credit_balance = (double) $client_information->credit_balance;
            $client_total_sale = (double) $client_information->total_sale;
            if (!empty($client_information)) {
                if ($client_credit_balance > 0) {
                    $result = $client_credit_balance - $return_amount;
                    $client_current_credit_balance = $result;
                    if ($result < 0) {
                        $client_current_credit_balance = 0;
                        $client_current_advance_balance = $client_advance_balance + abs($result);
                    } else {
                        $client_current_advance_balance = 0;
                    }
                } else {
                    $client_current_credit_balance = 0;
                    $client_current_advance_balance = $client_advance_balance + $return_amount;
                }
                $current_total_sale = $client_total_sale - $return_amount;

                $client_information_data = array(
                    'id' => $client_id,
                    'credit_balance' => $client_current_credit_balance,
                    'total_sale' => $current_total_sale,
                    'advance_balance' => $client_current_advance_balance,
                );
                $this->db->where('id', $client_information_data['id']);
                $this->Client_Model->db->update('client_info', $client_information_data);
            }
        }
    }

    //5th for void
    public function client_transaction_details_save_for_void($invoice_details, $client_information) {
        if (!empty($invoice_details)) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $narration = '';
            $narration = 'Invoice No(' . $invoice_details->invoice_number . ')(Ret.)';
            $payment_type = $invoice_details->mode_of_payment;
            $client_id = (int) $invoice_details->client_id;
            $current_date_time = get_current_date_and_time();
            $return_debit_or_credit_amount = (double) $invoice_details->amount_to_paid;
            $debit_amount = 0;
            $credit_amount = 0;
            $client_credit_balance = (double) $client_information->credit_balance;
            $client_advance_balance = (double) $client_information->advance_balance;
            if ($return_debit_or_credit_amount != 0) {
                $last_client_transaction_details = $this->Client_transaction_details_Model->get_last_client_transaction_details($client_id);
                $opening_balance = !empty($last_client_transaction_details) ? ($last_client_transaction_details->closing_balance) : 0;

                $credit_amount = $return_debit_or_credit_amount;
                $debit_amount = 0;
                if ($client_credit_balance > 0) {
                    $closing_balance = (!empty($last_client_transaction_details) ? (double) ($last_client_transaction_details->closing_balance) : 0) + (double) ($return_debit_or_credit_amount); //if credit then closing balance  contains minus that's why using plus sign
                } else {
                    $closing_balance = (!empty($last_client_transaction_details) ? (double) ($last_client_transaction_details->closing_balance) : 0) + (double) ($return_debit_or_credit_amount);
                }
                $client_transaction_details_data = array(
                    'client_id' => $client_id,
                    'invoice_payment_id' => 0,
                    'transaction_date' => $current_date_time,
                    'opening_balance' => $opening_balance, //
                    'debit_amount' => abs($credit_amount), //abs($debit_amount)
                    'credit_amount' => abs($debit_amount), //abs($credit_amount)
                    'closing_balance' => $closing_balance,
                    'narration' => $narration,
                    'payment_type' => $payment_type,
                    'user_id' => $user_id,
                );
                $this->Client_transaction_details_Model->db->insert('client_transaction_details', $client_transaction_details_data);
            }
        }
    }

    //6th for void
    public function client_sales_details_save_for_void($invoice_details, $client_information) {
        $total_credit_balance = 0;
        $total_advance_balance = 0;
        $total_sale = 0;
        $total_payment = 0;
        $resize_amount = 0;
        $return_debit_or_credit_amount = (double) $invoice_details->amount_to_paid;
        if ($return_debit_or_credit_amount != 0) {
            $amount = abs($return_debit_or_credit_amount);
            $resize_amount = (double) $amount;
            $current_date = get_current_date();
            $client_id = (int) ($invoice_details->client_id);
            $current_client_sales_details_by_date = $this->Client_sales_details_Model->get_client_sales_details_by_date($client_id, $current_date);
            $client_credit_balance = (double) $client_information->credit_balance;
            $client_advance_balance = (double) $client_information->advance_balance;
            if ($client_credit_balance > 0) {
                $result = $client_credit_balance - $resize_amount;
                if ((double) $result < 0) {
                    $total_credit_balance = 0;
                    $total_advance_balance = abs($result);
                } else {
                    $total_credit_balance = $result;
                    $total_advance_balance = 0;
                }
            } else {
                $total_credit_balance = 0;
                $total_advance_balance = abs($client_advance_balance + $resize_amount);
            }
            if ($client_credit_balance == 0 && $client_advance_balance == 0) {
                $total_credit_balance = $resize_amount;
                $total_advance_balance = 0;
            }
            $total_sale = !empty($current_client_sales_details_by_date->total_sale) ? ((double) $current_client_sales_details_by_date->total_sale - $resize_amount) : (0);

            $total_payment = !empty($current_client_sales_details_by_date->total_payment) ? $current_client_sales_details_by_date->total_payment : 0;
            $client_sales_details_data = array(
                'id' => !empty($current_client_sales_details_by_date->id) ? $current_client_sales_details_by_date->id : '',
                'client_id' => $client_id,
                'sale_date' => $current_date,
                'total_credit_balance' => $total_credit_balance,
                'total_advance_balance' => $total_advance_balance,
                'total_sale' => $total_sale,
                'total_payment' => $total_payment,
            );
            if (empty($current_client_sales_details_by_date)) {
                $this->Client_sales_details_Model->db->insert('client_sales_details', $client_sales_details_data);
            } else {
                $this->db->where('id', $client_sales_details_data['id']);
                $this->Client_sales_details_Model->db->update('client_sales_details', $client_sales_details_data);
            }
        }
    }

    //7th for void
    public function save_edit_invoice_information_for_void($invoice_details, $user_id, $sale_product_list) {
        if (!empty($invoice_details)) {
            $invoice_id = $invoice_details->id;
            $invoice_number = $invoice_details->invoice_number;
            $challan_number = $invoice_details->challan_number;
            $current_date_time = get_current_date_and_time();
            if (!empty($sale_product_list)) {
                foreach ($sale_product_list as $sale_product) {
                    $edit_invoice_data = array(
                        'invoice_id' => $invoice_id,
                        'invoice_number' => $invoice_number,
                        'challan_number' => $challan_number,
                        'edit_invoice_date' => $current_date_time,
                        'product_id' => $sale_product->product_id,
                        'previous_quantity' => !empty($sale_product->quantity) ? $sale_product->quantity : 0,
                        'reduce_quantity' => !empty($sale_product->quantity) ? $sale_product->quantity : 0,
                        'current_quantity' => 0,
                        'unit_price' => !empty($sale_product->unit_price) ? $sale_product->unit_price : 0,
                        'previous_amount' => (!empty($sale_product->quantity) ? $sale_product->quantity : 0) * (!empty($sale_product->unit_price) ? $sale_product->unit_price : 0),
                        'current_amount' => 0,
                        'usre_id' => $user_id,
                    );
                    $this->Edit_invoice_Model->db->insert('edit_invoice', $edit_invoice_data);
                }
            }
        }
    }

    //8th for void
    public function save_client_product_return_info_for_void($return_date, $remarks, $invoice_details) {
        $total_amount = 0;
        $total_amount_after_return = 0;
        $total_amount = (double) $invoice_details->amount_to_paid;
        $return_debit_or_credit_amount = (double) $invoice_details->amount_to_paid;
        $total_amount_after_return = (double) $total_amount - (double) abs($return_debit_or_credit_amount);
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id']; // session user id
        $data = array(
            'return_date' => $return_date,
            'branch_id' => $invoice_details->branch_id,
            'client_id' => $invoice_details->client_id,
            'invoice_number' => $invoice_details->invoice_number,
            'challan_number' => $invoice_details->challan_number,
            'total_amount' => $total_amount,
            'return_amount' => abs($return_debit_or_credit_amount),
            'total_amount_after_return' => $total_amount_after_return,
            'remarks' => $remarks,
            'user_id' => $user_id,
        );
        $this->Client_product_return_info_Model->db->insert('client_product_return_info', $data);
        $currently_inserted_client_product_return_info_id = $this->db->insert_id();
        return $currently_inserted_client_product_return_info_id;
    }

    //9th for void
    public function save_client_product_return_details_for_void($invoice_details, $currently_inserted_client_product_return_info_id_for_void, $sale_product_list) {
        if (!empty($sale_product_list)) {
            foreach ($sale_product_list as $sale_product) {
                $client_product_return_details_data = array(
                    'product_id' => $sale_product->product_id,
                    'quantity' => $sale_product->quantity,
                    'unit_price' => $sale_product->unit_price,
                    'client_product_return_info_id' => $currently_inserted_client_product_return_info_id_for_void,
                );
                $this->Client_product_return_details_Model->db->insert('client_product_return_details', $client_product_return_details_data);
            }
        }
    }

    //10th for void
    public function update_client_return_product_in_branch_stock_for_void($branch_id, $invoice_details, $sale_product_list) {
        if (!empty($branch_id) || ((int) $branch_id > 0)) {
            if (!empty($sale_product_list)) {
                foreach ($sale_product_list as $sale_product) {
                    $product_id = $sale_product->product_id;
                    $branch_stock_by_product_id_branch_id = $this->Branch_stock_Model->get_branch_stock_by_product_id_branch_id($product_id, $branch_id);
                    if (!empty($branch_stock_by_product_id_branch_id)) {
                        $branch_stock_data = array(
                            'id' => $branch_stock_by_product_id_branch_id->id,
                            'product_id' => $product_id,
                            'branch_id' => $branch_id,
                            'stock' => (int) $branch_stock_by_product_id_branch_id->stock + (int) $sale_product->quantity,
                        );
                        $this->db->where('id', $branch_stock_data['id']);
                        $this->Branch_stock_Model->db->update('branch_stock', $branch_stock_data);
                    } else {
                        $branch_stock_data = array(
                            'product_id' => $product_id,
                            'branch_id' => $branch_id,
                            'stock' => (int) $sale_product->quantity,
                        );
                        $this->Branch_stock_Model->db->insert('branch_stock', $branch_stock_data);
                    }
                }
            }
        }
    }

    //11th for void
    public function branchwise_product_store_save_for_void($invoice_details, $sale_product_list, $branch_id, $date) {
        if (!empty($sale_product_list)) {
            foreach ($sale_product_list as $sale_product) {
                $product_id = $sale_product->product_id;
                $quantity = $sale_product->quantity;
                $branchwise_product_store_by_date = $this->Branchwise_product_store_Model->get_branchwise_product_store_by_date($date, $product_id, $branch_id);
                if (!empty($branchwise_product_store_by_date)) {
                    $open_stock = (int) $branchwise_product_store_by_date->open_stock;
                    $receive_stock = (int) $branchwise_product_store_by_date->receive_stock + (int) $quantity;
                    $transfer_stock = (int) $branchwise_product_store_by_date->transfer_stock;
                    $sale_from_stock = (int) $branchwise_product_store_by_date->sale_from_stock;
                    $damage_stock = (int) $branchwise_product_store_by_date->damage_stock;
                    $closing_stock = (int) ($open_stock + $receive_stock - $transfer_stock - $sale_from_stock - $damage_stock);
                    $branchwise_product_store_data = array(
                        'id' => $branchwise_product_store_by_date->id,
                        'product_store_date' => $date,
                        'product_id' => $product_id,
                        'branch_id' => $branch_id,
                        'open_stock' => $open_stock,
                        'receive_stock' => $receive_stock,
                        'transfer_stock' => $transfer_stock,
                        'sale_from_stock' => $sale_from_stock,
                        'damage_stock' => $damage_stock,
                        'closing_stock' => $closing_stock,
                    );
                    $this->db->where('id', $branchwise_product_store_data['id']);
                    $this->Branchwise_product_store_Model->db->update('branchwise_product_store', $branchwise_product_store_data);
                } else {
                    $current_date = get_current_date();
                    $branchwise_product_store_from_previous_date = $this->Branchwise_product_store_Model->get_branchwise_product_store_from_previous_date_by_product_id_branch_id($current_date, $product_id, $branch_id);
                    if (!empty($branchwise_product_store_from_previous_date)) {
                        $open_stock = (int) $branchwise_product_store_from_previous_date->closing_stock;
                    } else {
                        $open_stock = 0;
                    }
                    $receive_stock = (int) $quantity;
                    $transfer_stock = 0;
                    $sale_from_stock = 0;
                    $damage_stock = 0;
                    $closing_stock = (int) ($open_stock + $receive_stock - $transfer_stock - $sale_from_stock - $damage_stock);
                    $branchwise_product_store_data = array(
                        'product_store_date' => $date,
                        'product_id' => $product_id,
                        'branch_id' => $branch_id,
                        'open_stock' => $open_stock,
                        'receive_stock' => $receive_stock,
                        'transfer_stock' => $transfer_stock,
                        'sale_from_stock' => $sale_from_stock,
                        'damage_stock' => $damage_stock,
                        'closing_stock' => $closing_stock,
                    );
                    $this->Branchwise_product_store_Model->db->insert('branchwise_product_store', $branchwise_product_store_data);
                }
            }
        }
    }

    //12th for void
    public function product_store_save_for_void($sale_product_list, $date) {
        if (!empty($sale_product_list)) {
            foreach ($sale_product_list as $sale_product) {
                $product_id = $sale_product->product_id;
                $quantity = $sale_product->quantity;
                $product_store_by_date = $this->Product_store_Model->get_product_store_by_date($product_id, $date);
                if (!empty($product_store_by_date)) {
                    $open_stock = (int) $product_store_by_date->open_stock;
                    $receive_stock = (int) $product_store_by_date->receive_stock + (int) $quantity;
                    $transfer_stock = (int) $product_store_by_date->transfer_stock;
                    $sale_from_stock = (int) $product_store_by_date->sale_from_stock;
                    $damage_stock = (int) $product_store_by_date->damage_stock;
                    $closing_stock = (int) ($open_stock + $receive_stock - $transfer_stock - $sale_from_stock - $damage_stock);
                    $product_store_data = array(
                        'id' => $product_store_by_date->id,
                        'product_store_date' => $date,
                        'product_id' => $product_id,
                        'open_stock' => $open_stock,
                        'receive_stock' => $receive_stock,
                        'transfer_stock' => $transfer_stock,
                        'sale_from_stock' => $sale_from_stock,
                        'damage_stock' => $damage_stock,
                        'closing_stock' => $closing_stock,
                    );
                    $this->db->where('id', $product_store_data['id']);
                    $this->Product_store_Model->db->update('product_store', $product_store_data);
                } else {
                    $current_date = get_current_date();
                    $product_store_from_previous_date = $this->Product_store_Model->get_product_store_from_previous_date_by_product_id($current_date, $product_id);
                    if (!empty($product_store_from_previous_date)) {
                        $open_stock = (int) $product_store_from_previous_date->closing_stock;
                    } else {
                        $open_stock = 0;
                    }
                    $receive_stock = (int) $quantity;
                    $transfer_stock = 0;
                    $sale_from_stock = 0;
                    $damage_stock = 0;
                    $closing_stock = (int) ($open_stock + $receive_stock - $transfer_stock - $sale_from_stock - $damage_stock);
                    $product_store_data = array(
                        'product_store_date' => $date,
                        'product_id' => $product_id,
                        'open_stock' => $open_stock,
                        'receive_stock' => $receive_stock,
                        'transfer_stock' => $transfer_stock,
                        'sale_from_stock' => $sale_from_stock,
                        'damage_stock' => $damage_stock,
                        'closing_stock' => $closing_stock,
                    );
                    $this->Product_store_Model->db->insert('product_store', $product_store_data);
                }
            }
        }
    }

    //13th for void
    public function update_stock_in_product_for_void($sale_product_list) {
        if (!empty($sale_product_list)) {
            foreach ($sale_product_list as $sale_product) {
                $product_id = $sale_product->product_id;
                $quantity = $sale_product->quantity;
                if ((int) $quantity > 0) {
                    $product_information = $this->Product_Model->getProductById($product_id);
                    // echo "<pre>"; print_r($product_information); exit();
                    if (!empty($product_information)) {
                        $product_data = array(
                            'id' => $product_id,
                            'product_stock' => (int) $product_information->product_stock + (int) $quantity,
                        );
                        $this->db->where('id', $product_data['id']);
                        $this->Product_Model->db->update('product', $product_data);
                    }
                }
            }
        }
    }

    /* public function get_product_details_array($invoice_id) {
      $arr = array();
      $user_info = $this->session->userdata('user_session');
      $user_id = $user_info['user_id']; // session user id
      $invoice_details = $this->Invoice_details_Model->get_invoice_details($invoice_id);
      $sale_product_list = (array) $this->Sale_product_Model->get_sale_product_list($invoice_id);
      if (!empty($invoice_details) && !empty($sale_product_list)) {
      foreach ($sale_product_list as $sale_product) {
      $product_details = array(
      'array_id' => time(),
      'sale_product_id' => $sale_product->id,
      'product_id' => $sale_product->product_id,
      'invoice_id' => $sale_product->invoice_id,
      'invoice_number' => $invoice_details->invoice_number,
      'challan_number' => $invoice_details->challan_number,
      'client_id' => $invoice_details->client_id,
      'branch_id' => $invoice_details->branch_id,
      'previous_quantity' => $sale_product->quantity,
      'quantity' => $sale_product->quantity,
      'total_amount' => $invoice_details->product_total,
      'unit_price' => $sale_product->unit_price,
      'previous_amount' => $invoice_details->amount_to_paid,
      'new_amount' => $invoice_details->amount_to_paid,
      'return_amount' => $invoice_details->amount_to_paid,
      'total_amount_after_return' => $invoice_details->amount_to_paid,
      'user_id' => $user_id,
      'status' => 'reduce',
      );
      array_push($arr, $product_details);
      }
      }
      return $arr;
      } */
}
