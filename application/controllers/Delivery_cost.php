<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_cost extends CI_Controller {

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
        $this->load->model('Delivery_cost_type_Model');
        $this->load->model('Delivery_cost_Model');
        $this->load->model('Delivery_cost_details_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $this->data['title'] = "Delivery Cost Details";
            $this->data['page_title'] = "Delivery Cost Details";
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $this->data['delivery_cost_type_list'] = $this->Delivery_cost_type_Model->get_delivery_cost_type();
            $start_date = get_start_date_format(get_previous_date_from_current_date_by_month($months = 6));
            $end_date = get_end_date_format(get_current_date());
            $this->data['delivery_cost_list'] = $this->Delivery_cost_Model->get_delivery_cost_by_date($start_date, $end_date);
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('delivery_cost/delivery_cost_list', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function create_new_delivery_cost() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            $this->data['title'] = "New Delivery Cost";
            $this->data['page_title'] = "New Delivery Cost";
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $this->data['delivery_cost_type_list'] = $this->Delivery_cost_type_Model->get_delivery_cost_type();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('delivery_cost/create_delivery_cost', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function delivery_cost_show_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $this->data['title'] = 'Delivery Cost';
                $invoice_number = trim($this->input->post('invoice_number'));
                $challan_number = trim($this->input->post('challan_number'));
                if (empty($invoice_number) && empty($challan_number)) {
                    echo '<div class="error-message text-align-center">Please Enter Invoice Number Or Challan Number.</div>';
                    $this->load->view('delivery_cost/delivery_cost_table', $this->data);
                } else {
                    if (!empty($invoice_number)) { //$invoice_number
                        $invoice_details = $this->Invoice_details_Model->get_invoice_details_by_invoice_number($invoice_number);
                    } else {  //$challan_number
                        $invoice_details = $this->Invoice_details_Model->get_invoice_details_by_challan_number($challan_number);
                    }
                    if (empty($invoice_details)) {
                        echo '<div class="error-message text-align-center">No Invoice Or Challan Found.</div>';
                        $this->load->view('delivery_cost/delivery_cost_table', $this->data);
                    } else {
                        $delivery_cost_by_invoice_details_id = $this->Delivery_cost_Model->get_delivery_cost_by_invoice_details_id(intval($invoice_details->id));
                        if (!empty($delivery_cost_by_invoice_details_id)) {
                            echo '<div class="error-message text-align-center">Already added delivery cost for this.</div>';
                            $this->load->view('delivery_cost/delivery_cost_table', $this->data);
                        } else {
                            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
                            $sale_product_list = $this->Sale_product_Model->get_sale_product_list(intval($invoice_details->id));
                            $sale_product_list_row = $this->Sale_product_Model->get_sale_product_list_row(intval($invoice_details->id));
                            $this->data['invoice_details'] = $invoice_details;
                            $this->data['sale_product_list'] = $sale_product_list;
                            $this->data['sale_product_list_row'] = $sale_product_list_row;
                            $this->data['delivery_cost_type_list'] = $this->Delivery_cost_type_Model->get_delivery_cost_type();
                            $this->load->view('delivery_cost/delivery_cost_table', $this->data);
                        }
                    }
                }
            } else {
                redirect(base_url('delivery_cost'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function save_delivery_cost() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $message = '';
                $is_delivery_cost_save = FALSE;
                $is_delivery_cost_details_save = FALSE;
                $invoice_details_id = intval(trim($this->input->post('invoice_details_id')));
                $delivery_cost_date = trim($this->input->post('delivery_cost_date'));
                $table_data = $this->input->post('table_data');
                $table_data = !empty($table_data) ? json_decode($table_data, TRUE) : NULL;
                $delivery_cost_details = get_array_key_value('data', $table_data);
                $total_amount = get_array_key_value('grand_total', $table_data);
                if (!empty($delivery_cost_details) && ($invoice_details_id > 0)) {
                    $user_info = $this->session->userdata('user_session');
                    $user_id = $user_info['user_id']; // session user id
                    $delivery_cost_data = array(
                        'invoice_details_id' => $invoice_details_id,
                        'total_amount' => get_floating_point_number($total_amount),
                        'delivery_cost_date' => $delivery_cost_date,
                        'user_id' => $user_id,
                        'current_date_time' => get_current_date_and_time()
                    );
                    $this->Delivery_cost_Model->db->insert('delivery_cost', $delivery_cost_data);
                    $currently_inserted_delivery_cost_id = $this->db->insert_id();
                    if (intval($currently_inserted_delivery_cost_id)) {
                        $is_delivery_cost_save = TRUE;
                        $is_delivery_cost_details_save = $this->Delivery_cost_details_Model->insert_delivery_cost_details($currently_inserted_delivery_cost_id, $delivery_cost_details);
                        $message = 'Information has been saved successfully.';
                    }
                } else {
                    $message = 'Please check input.';
                }
                $data_array = array('message' => $message, 'isDeliveryCostSave' => $is_delivery_cost_save, 'isDeliveryCostDetailsSave' => $is_delivery_cost_details_save, 'redirectUrl' => base_url('delivery_cost'));
                set_json_output($data_array);
            } else {
                redirect(base_url('delivery_cost'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update_delivery_cost($id = 0) {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            if ($id > 0) {
                $delivery_cost = $this->Delivery_cost_Model->get_delivery_cost($id);
                if (!empty($delivery_cost)) {
                    $delivery_cost_id = intval($delivery_cost->id);
                    $invoice_details_id = intval($delivery_cost->invoice_details_id);
                    if (intval($invoice_details_id) == 0) {
//                        Please Enter Invoice Number Or Challan Number.
                        alert_message($message = 'Error Occured.');
                    } else {
                        $invoice_details = $this->Invoice_details_Model->get_invoice_details($invoice_details_id);
                        if (empty($invoice_details)) {
//                            No Invoice Or Challan Found .
                            alert_message($message = 'Error Occured.');
                        } else {
                            $delivery_cost_details_by_delivery_cost_id = $this->Delivery_cost_details_Model->get_delivery_cost_details_by_delivery_cost_id($delivery_cost_id);
                            $this->data['delivery_cost'] = $delivery_cost;
                            $this->data['delivery_cost_details_by_delivery_cost_id'] = $delivery_cost_details_by_delivery_cost_id;
                            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
                            $sale_product_list = $this->Sale_product_Model->get_sale_product_list(intval($invoice_details->id));
                            $sale_product_list_row = $this->Sale_product_Model->get_sale_product_list_row(intval($invoice_details->id));
                            $this->data['invoice_details'] = $invoice_details;
                            $this->data['sale_product_list'] = $sale_product_list;
                            $this->data['sale_product_list_row'] = $sale_product_list_row;
                            $this->data['delivery_cost_type_list'] = $this->Delivery_cost_type_Model->get_delivery_cost_type();
                            $this->data['title'] = "Update Delivery Cost";
                            $this->data['page_title'] = "Update Delivery Cost";
                            $this->data['button_text'] = "Update";
                            $this->data['delete_button_text'] = "Delete";
                            $this->load->view('header');
                            $this->load->view('navigation');
                            $this->load->view('delivery_cost/update_delivery_cost', $this->data);
                        }
                    }
                } else {
                    redirect(base_url('delivery_cost'));
                }
            } else {
                redirect(base_url('delivery_cost'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $message = '';
                $is_delivery_cost_save = FALSE;
                $is_delivery_cost_details_save = FALSE;
                $delivery_cost_id = intval(trim($this->input->post('delivery_cost_id')));
                $invoice_details_id = intval(trim($this->input->post('invoice_details_id')));
                $delivery_cost_date = trim($this->input->post('delivery_cost_date'));
                $table_data = $this->input->post('table_data');
                $table_data = !empty($table_data) ? json_decode($table_data, TRUE) : NULL;
                $delivery_cost_details = get_array_key_value('data', $table_data);
                $total_amount = get_array_key_value('grand_total', $table_data);
                if (!empty($delivery_cost_details) && ($invoice_details_id > 0) && ($delivery_cost_id > 0)) {
                    $user_info = $this->session->userdata('user_session');
                    $user_id = $user_info['user_id']; // session user id
                    $delivery_cost_data = array(
                        'id' => $delivery_cost_id,
                        'invoice_details_id' => $invoice_details_id,
                        'total_amount' => get_floating_point_number($total_amount),
                        'delivery_cost_date' => $delivery_cost_date,
                        'user_id' => $user_id,
                        'current_date_time' => get_current_date_and_time()
                    );
                    $this->db->where('id', $delivery_cost_data['id']);
                    $is_delivery_cost_save = $this->Delivery_cost_Model->db->update('delivery_cost', $delivery_cost_data);
                    if (($is_delivery_cost_save)) {
                        $is_delivery_cost_details_save = $this->Delivery_cost_details_Model->update_delivery_cost_details($delivery_cost_id, $delivery_cost_details);
                        $message = 'Information has been updated successfully.';
                    }
                } else {
                    $message = 'Please check input.';
                }
                $data_array = array('message' => $message, 'isDeliveryCostSave' => $is_delivery_cost_save, 'isDeliveryCostDetailsSave' => $is_delivery_cost_details_save, 'redirectUrl' => base_url('delivery_cost'));
                set_json_output($data_array);
            } else {
                redirect(base_url('delivery_cost'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function delete() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $message = '';
                $is_delete_delivery_cost = FALSE;
                $is_delete_delivery_cost_details = FALSE;
                $id = intval(trim($this->input->post('id')));
                if ($id > 0) {
                    $is_delete_delivery_cost = $this->Delivery_cost_Model->delete($id);
                    if ($is_delete_delivery_cost) {
                        $is_delete_delivery_cost_details = $this->Delivery_cost_details_Model->delete_delivery_cost_details_by_delivery_cost_id($id);
                    }
                    $message = ($is_delete_delivery_cost) ? 'Information has been deleted successfully.' : 'Delation failed.';
                } else {
                    $message = 'Delation failed.';
                }
                set_json_output(array('message' => $message, 'isDeleteDeliveryCost' => $is_delete_delivery_cost, 'isDeleteDeliveryCostDetails' => $is_delete_delivery_cost_details, 'redirectUrl' => base_url('delivery_cost')));
            } else {
                redirect(base_url('delivery_cost'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

}
