<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_product_damage_or_defect extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Product_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Client_Model');
        $this->load->model('Invoice_details_Model');
        $this->load->model('Sale_product_Model');
        $this->load->model('Product_receive_Model');
        $this->load->model('Branch_stock_Model');
        $this->load->model('Stock_transfer_challan_Model');
        $this->load->model('Stock_transfer_Model');
        $this->load->model('Branchwise_product_store_Model');
        $this->load->model('Product_store_Model');
        $this->load->model('Damage_or_defect_product_info_Model');
        $this->load->model('Damage_or_defect_product_details_Model');
        $this->load->model('Client_product_damage_or_defect_info_Model');
        $this->load->model('Client_product_damage_or_defect_details_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_access')) == TRUE)) {
            $this->data['title'] = "Company";
            $product_list = $this->Product_Model->get_product();
            $branch_list = $this->Branch_Model->get_branch();
            $client_list = $this->Client_Model->get_client();
            $this->data['product_list'] = $product_list;
            $this->data['branch_list'] = $branch_list;
            $this->data['client_list'] = $client_list;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('client_product_damage_or_defect/client_product_damage_or_defect', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function client_product_damage_or_defect_show_in_table() { //add damage or defect product in table
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $this->get_session_empty();
                $invoice_number = trim($this->input->post('invoice_number'));
                $challan_number = trim($this->input->post('challan_number'));

                if (empty($invoice_number) && empty($challan_number)) {
                    echo '<div class="error-message text-align-center">Please Enter Invoice Number Or Challan Number.</div>';
                    $this->load->view('client_product_damage_or_defect/client_product_damage_or_defect_table');
                } else {
                    if (!empty($invoice_number)) { //$invoice_number
                        $invoice_details = $this->Invoice_details_Model->get_invoice_details_by_invoice_number($invoice_number);
                    } else {  //$challan_number
                        $invoice_details = $this->Invoice_details_Model->get_invoice_details_by_challan_number($challan_number);
                    }
                    if (empty($invoice_details)) {
                        echo '<div class="error-message text-align-center">No Invoice Or Challan Found.</div>';
                        $this->load->view('client_product_damage_or_defect/client_product_damage_or_defect_table');
                    } else {
                        $sale_product_list = $this->Sale_product_Model->get_sale_product_list($invoice_details->id);
                        $sale_product_list_row = $this->Sale_product_Model->get_sale_product_list_row($invoice_details->id);
                        $this->data['invoice_details'] = $invoice_details;
                        $this->data['sale_product_list'] = $sale_product_list;
                        $this->data['sale_product_list_row'] = $sale_product_list_row;
                        $this->load->view('client_product_damage_or_defect/client_product_damage_or_defect_table', $this->data);
                    }
                }
            } else {
                redirect(base_url('client_product_damage_or_defect'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_session_empty() {
        $this->session->unset_userdata('invoice_details_session');
        $this->session->unset_userdata('reduce_product_list_table_array');
    }

    public function reduce_quantity_from_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $user_info = $this->session->userdata('user_session');
                $user_id = $user_info['user_id']; // session user id
                $reduce_quantity = 0;
                $sale_product_id = trim($this->input->post('sale_product_id'));
                $new_quantity = trim($this->input->post('new_quantity'));
                $invoice_id = trim($this->input->post('invoice_id'));
                $product_id = trim($this->input->post('product_id'));
                $status = trim($this->input->post('status'));

                $this->reduce_quantity_from_table_update($sale_product_id);

                $invoice_details = $this->Invoice_details_Model->get_invoice_details($invoice_id);
                $this->session->set_userdata('invoice_details_session', $invoice_details);

                $sale_product_by_invoice_id_and_product_id = $this->Sale_product_Model->get_sale_product_by_invoice_id_and_product_id($invoice_id, $product_id);

                if (($status != 'remove')) {
                    $reduce_quantity = (int) $sale_product_by_invoice_id_and_product_id->quantity - (int) $new_quantity;
                } else {
                    $reduce_quantity = (int) $sale_product_by_invoice_id_and_product_id->quantity;
                }

                if (($status != 'remove') && ((empty($new_quantity)) || ((int) $new_quantity >= (int) $sale_product_by_invoice_id_and_product_id->quantity))) {
                    //echo 'failed';
                } else {
                    $reduce_product_table_array_info = $this->session->userdata('reduce_product_list_table_array');
                    $reduce_product_list_table_array = $reduce_product_table_array_info;

                    $return_amount = 0;
                    $total_amount_after_return = 0;
                    $return_amount = (double) $sale_product_by_invoice_id_and_product_id->unit_price * $reduce_quantity;
                    $total_amount_after_return = (double) $invoice_details->product_total - (double) $return_amount;

                    $reduce_product_details = array(
                        'array_id' => time(),
                        'sale_product_id' => $sale_product_id,
                        'product_id' => $product_id,
                        'invoice_id' => $invoice_id,
                        'invoice_number' => $invoice_details->invoice_number,
                        'challan_number' => $invoice_details->challan_number,
                        'client_id' => $invoice_details->client_id,
                        'branch_id' => $invoice_details->branch_id,
                        'quantity' => $reduce_quantity,
                        'total_amount' => $invoice_details->product_total,
                        'unit_price' => $sale_product_by_invoice_id_and_product_id->unit_price,
                        'return_amount' => $return_amount,
                        'total_amount_after_return' => $total_amount_after_return,
                        'user_id' => $user_id,
                    );
                    if (!empty($reduce_product_table_array_info)) {
                        array_push($reduce_product_list_table_array, $reduce_product_details);
                        //echo 'updated';
                    } else {
                        $reduce_product_list_table_array = array();
                        array_push($reduce_product_list_table_array, $reduce_product_details);
                        //echo 'updated';
                    }
                    $this->session->set_userdata('reduce_product_list_table_array', $reduce_product_list_table_array);
                }
                $this->client_reduce_product_damage_or_defect_table();
            } else {
                redirect(base_url('client_product_damage_or_defect'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function client_reduce_product_damage_or_defect_table() {
        $reduce_product_list_table_array_session = $this->session->userdata('reduce_product_list_table_array');
        $this->data['reduce_product_list_table_array'] = $reduce_product_list_table_array_session;
        $this->load->view('client_product_damage_or_defect/client_reduce_product_damage_or_defect_table', $this->data);
    }

    public function reduce_quantity_from_table_update($sale_product_id) {
        $reduce_product_table_array_info = $this->session->userdata('reduce_product_list_table_array');
        if (!empty($reduce_product_table_array_info)) {
            $product_array = array();
            foreach ($reduce_product_table_array_info as $reduce_product_table) {
                if ((int) $sale_product_id != (int) $reduce_product_table['sale_product_id']) {
                    array_push($product_array, $reduce_product_table);
                }
            }
            $this->session->set_userdata('reduce_product_list_table_array', $product_array);
            $this->session->userdata('reduce_product_list_table_array');
        }
    }

    public function client_product_damage_information_save() {
        $remarks = trim($this->input->post('remarks'));
        $return_date = trim($this->input->post('return_date'));

        if (empty($return_date) || empty($remarks)) {
            $this->get_session_empty();
            $this->session->set_flashdata('return_date_and_remarks_error_message', 'Date and Remarks Required');
            redirect(base_url('client_product_damage_or_defect'));
        } else {
            date_default_timezone_set("Asia/Dhaka");
            $return_date = date($return_date . ' H:i:s');

            $invoice_details_session = $this->session->userdata('invoice_details_session');
            $reduce_product_table_array_info = $this->session->userdata('reduce_product_list_table_array');

            if (!empty($reduce_product_table_array_info)) {
                $total_return_amount = 0;
                $total_return_amount = $this->get_total_return_amount($reduce_product_table_array_info);
                $currently_inserted_client_product_damage_or_defect_info_id = $this->save_client_product_damage_or_defect_info($return_date, $remarks, $invoice_details_session, $reduce_product_table_array_info, $total_return_amount);
                if (!empty($currently_inserted_client_product_damage_or_defect_info_id)) {
                    $this->save_client_product_damage_or_defect_details($reduce_product_table_array_info, $currently_inserted_client_product_damage_or_defect_info_id);

                    $this->update_remarks_in_invoice_details($invoice_details_session, $remarks);
                    $this->update_return_amount_in_client_info($invoice_details_session, $total_return_amount);
                }
                $this->get_session_empty();
                $this->session->set_flashdata('client_product_damage_or_defect_save_message', 'Information has been saved successfully.');
                redirect(base_url('client_product_damage_or_defect'));
            } else {
                $this->session->Set_flashdata('client_product_table_error_message', 'Error occured please try again');
                redirect(base_url('client_product_damage_or_defect'));
            }
        }
    }

    public function get_total_return_amount($reduce_product_table_array_info) {
        $total_return_amount = 0;
        if (!empty($reduce_product_table_array_info)) {
            foreach ($reduce_product_table_array_info as $reduce_product_table) {
                $total_return_amount += (double) $reduce_product_table['return_amount'];
            }
        }
        return $total_return_amount;
    }

    public function save_client_product_damage_or_defect_info($return_date, $remarks, $invoice_details_session, $reduce_product_table_array_info, $total_return_amount) {

        $total_amount = 0;
        $total_amount_after_return = 0;
        $total_amount = $invoice_details_session->product_total;
        $total_amount_after_return = (double) $total_amount - (double) $total_return_amount;

        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id']; // session user id
        $data = array(
            'return_date' => $return_date,
            'branch_id' => $invoice_details_session->branch_id,
            'client_id' => $invoice_details_session->client_id,
            'invoice_number' => $invoice_details_session->invoice_number,
            'challan_number' => $invoice_details_session->challan_number,
            'total_amount' => $total_amount,
            'return_amount' => $total_return_amount,
            'total_amount_after_return' => $total_amount_after_return,
            'remarks' => $remarks,
            'user_id' => $user_id,
        );
        $this->Client_product_damage_or_defect_info_Model->db->insert('client_product_damage_or_defect_info', $data);
        $currently_inserted_client_product_damage_or_defect_info_id = $this->db->insert_id();
        return $currently_inserted_client_product_damage_or_defect_info_id;
    }

    public function save_client_product_damage_or_defect_details($reduce_product_table_array_info, $currently_inserted_client_product_damage_or_defect_info_id) {

        if (!empty($reduce_product_table_array_info)) {
            foreach ($reduce_product_table_array_info as $reduce_product_table) {
                $data = array(
                    'product_id' => $reduce_product_table['product_id'],
                    'quantity' => $reduce_product_table['quantity'],
                    'unit_price' => $reduce_product_table['unit_price'],
                    'client_product_damage_or_defect_info_id' => $currently_inserted_client_product_damage_or_defect_info_id,
                );
                $this->Client_product_damage_or_defect_details_Model->db->insert('client_product_damage_or_defect_details', $data);
            }
        }
    }

    public function update_remarks_in_invoice_details($invoice_details_session, $remarks) {
        $data = array(
            'id' => $invoice_details_session->id,
            'remarks' => $remarks,
        );
        $this->db->where('id', $data['id']);
        $this->Invoice_details_Model->db->update('invoice_details', $data);
    }

    public function update_return_amount_in_client_info($invoice_details_session, $total_return_amount) {
        if (!empty($invoice_details_session)) {
            $client_id = $invoice_details_session->client_id;
            $client_information = $this->Client_Model->get_client($client_id);
            if (!empty($client_information)) {
                $return_amount = 0;
                $credit_balance = 0;
                $advance_balance = 0;
                $remain_amount = 0;
                if (((double) $client_information->credit_balance) > 0) { //credit_balance
                    if ((double) $client_information->credit_balance >= (double) $total_return_amount) {
                        $credit_balance = (double) $client_information->credit_balance - (double) $total_return_amount;
                        $advance_balance = $client_information->advance_balance;
                    } else {
                        $remain_amount = (double) $total_return_amount - (double) $client_information->credit_balance;
                        $advance_balance = (double) $client_information->advance_balance + (double) $remain_amount;
                    }
                } else {  // advance_balance
                    $credit_balance = $client_information->credit_balance;
                    $advance_balance = (double) $client_information->advance_balance + (double) $total_return_amount;
                }
                $return_amount = (double) $client_information->return_amount + (double) $total_return_amount;
                $data = array(
                    'id' => $client_id,
                    'credit_balance' => $credit_balance,
                    'advance_balance' => $advance_balance,
                    'return_amount' => $return_amount,
                );
                $this->db->where('id', $data['id']);
                $this->Client_Model->db->update('client_info', $data);
            }
        }
    }

}
