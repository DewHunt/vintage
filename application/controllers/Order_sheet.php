<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order_sheet extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Product_Model');
        $this->load->model('Client_Model');
        $this->load->model('Dealer_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Product_Model');
        $this->load->model('Order_sheet_Model');
        $this->load->model('Order_sheet_details_Model');
    }

    public function index() {  // load Order sheet details
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('order_sheet_access')) == TRUE)) {
            $this->data['title'] = "Order Sheet Details";
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('order_sheet/index', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function order_sheet_details_show_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('order_sheet_access')) == TRUE)) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id'];
            $user_type = $user_info['user_type'];
            $start_date = trim($this->input->post('start_date'));
            $start_date = $start_date . ' 00:00:00';
            $end_date = trim($this->input->post('end_date'));
            $end_date = $end_date . ' 23:59:59';
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $user_info = $this->User_Model->get_user($user_id);
            $employee_id = $user_info->employee_id;
            $this->data['order_sheet_list'] = $this->Order_sheet_Model->get_order_sheet_list($start_date, $end_date, $employee_id, $user_type);
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->load->view('order_sheet/order_sheet_list', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function order_sheet_details_show_in_modal() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('order_sheet_access')) == TRUE)) {
            $order_sheet_id = trim($this->input->post('id')); //$order_sheet_id
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id'];
            $user_type = $user_info['user_type'];
            $user_info = $this->User_Model->get_user($user_id);
            $employee_id = $user_info->employee_id;
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $order_sheet = $this->Order_sheet_Model->get_order_sheet($order_sheet_id);
            $this->data['order_sheet'] = $order_sheet;
            $client_information = $this->Client_Model->get_client($order_sheet->client_id);
            $this->data['client_information'] = $client_information;
            if ((int) $client_information->dealer_id > 0) {
                $dealer_information = $this->Dealer_Model->get_dealer($client_information->dealer_id);
            } else {
                $dealer_information = '';
            }
            $this->data['dealer_information'] = $dealer_information;
            if ((int) $client_information->employee_id > 0) {
                $employee_information = $this->Employee_Model->get_employee($client_information->employee_id);
            } else {
                $employee_information = '';
            }
            $this->data['dealer_information'] = $dealer_information;
            $this->data['employee_information'] = $employee_information;
            $this->data['order_sheet_details_by_order_sheet_id'] = $this->Order_sheet_details_Model->get_order_sheet_details_by_order_sheet_id($order_sheet_id);
            $this->load->view('order_sheet/order_sheet_details_modal', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function create_new_order_sheet() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('order_sheet_access')) == TRUE)) {
            $this->data['title'] = "Create New Order Sheet";
            $this->data['product_list'] = $this->Product_Model->get_product();
            $this->data['client_list'] = $this->Client_Model->get_client();
            $this->data['online_order_sheet_number'] = $this->get_online_order_sheet_number();
            $this->data['current_date'] = get_current_date();
            $this->data['current_time'] = get_current_time();
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('order_sheet/create_new_order_sheet', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_online_order_sheet_number() {
        $online_order_sheet_number = 0;
        $last_online_order_number = $this->Order_sheet_Model->get_last_online_order_number();
        if (!empty($last_online_order_number->online_order_number)) {
            $online_order_sheet_number = $last_online_order_number->online_order_number + 1;
        } else {
            $online_order_sheet_number = 1000;
        }
        return $online_order_sheet_number;
    }

    public function add_product_in_order_sheet_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('order_sheet_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $product_id = trim($this->input->post('product_id'));
                $quantity = trim($this->input->post('quantity'));
                $unit_price = trim($this->input->post('unit_price'));
                $amount = (trim($this->input->post('unit_price'))) * (trim($this->input->post('quantity')));
                if (empty($product_id) || empty($quantity)) {
                    echo '<div class="error-message text-align-center">Please select product and input quantity.</div>';
                    $this->data['order_sheet_total_price_session'] = $this->session->userdata('order_sheet_total_price');
                    $this->data['product_list'] = $this->Product_Model->get_product();
                    $this->load->view('order_sheet/order_sheet_table', $this->data);
                } else {
                    $order_sheet_table_array_info = $this->session->userdata('order_sheet_table_array');
                    $order_sheet_table_array = $order_sheet_table_array_info;
                    $product = $this->Product_Model->get_product($product_id);
                    $order_sheet_details = array(
                        'array_id' => time(),
                        'product_id' => $product->id,
                        'product_name' => $product->product_name,
                        'pack_size' => $product->pack_size,
                        'quantity' => $quantity,
                        'fixed_price' => $product->fixed_price,
                        'total_amount' => ((double) $quantity) * ((double) $product->fixed_price),
                    );
                    if (!empty($order_sheet_table_array_info)) {
                        array_push($order_sheet_table_array, $order_sheet_details);
                    } else {
                        $order_sheet_table_array = array();
                        array_push($order_sheet_table_array, $order_sheet_details);
                    }
                    $this->session->set_userdata('order_sheet_table_array', $order_sheet_table_array);

                    $order_sheet_total_amount = 0;
                    foreach ($this->session->userdata('order_sheet_table_array') as $product) {
                        $order_sheet_total_amount += (double) $product['total_amount'];
                    }
                    $this->session->set_userdata('order_sheet_total_price', $order_sheet_total_amount);
                    $this->data['order_sheet_total_price_session'] = $this->session->userdata('order_sheet_total_price');
                    $this->data['product_list'] = $this->Product_Model->get_product();
                    $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
                    $this->load->view('order_sheet/order_sheet_table', $this->data);
                }
            } else {
                redirect(base_url('order_sheet/create_new_order_sheet'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function delete_product_in_order_sheet_table($array_id = 0) { //delete product info from table
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('order_sheet_access')) == TRUE)) {
            $order_sheet_table_array_info = $this->session->userdata('order_sheet_table_array');
            if ((!empty($order_sheet_table_array_info))) {
                $product_array = array();
                foreach ($order_sheet_table_array_info as $product) {
                    if ($array_id != $product['array_id']) {
                        array_push($product_array, $product);
                    }
                }
                $this->session->set_userdata('order_sheet_table_array', $product_array);
                $this->session->userdata('order_sheet_table_array');

                $order_sheet_total_amount = 0;
                foreach ($this->session->userdata('order_sheet_table_array') as $product) {
                    $order_sheet_total_amount += (double) $product['total_amount'];
                }
                $this->session->set_userdata('order_sheet_total_price', $order_sheet_total_amount);
                $this->session->userdata('order_sheet_total_price');
                redirect(base_url('order_sheet/create_new_order_sheet'));
            } else {
                redirect(base_url('order_sheet/create_new_order_sheet'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_order_sheet_table_array_clear() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('order_sheet_access')) == TRUE)) {
            $order_sheet_table_array_info = $this->session->userdata('order_sheet_table_array');
            if (!empty($order_sheet_table_array_info)) {
                $this->session->unset_userdata('order_sheet_table_array');
                $this->session->unset_userdata('order_sheet_total_price');
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function order_sheet_information_save() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('order_sheet_access')) == TRUE)) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id'];
            $current_date_time = get_current_date_and_time();
            $online_order_sheet_number = $this->get_online_order_sheet_number();
            $issue_date = trim($this->input->post('issue_date'));
            $issue_time = trim($this->input->post('issue_time'));
            $client_id = trim($this->input->post('client_id'));
            $work_order_number = trim($this->input->post('work_order_number'));
            $work_order_date = trim($this->input->post('work_order_date'));
            $delivery_date = trim($this->input->post('delivery_date'));
            $freight_charge = !empty(trim($this->input->post('freight_charge'))) ? trim($this->input->post('freight_charge')) : 0;
            $discount = !empty(trim($this->input->post('discount'))) ? trim($this->input->post('discount')) : 0;
            $bonus = !empty(trim($this->input->post('bonus'))) ? trim($this->input->post('bonus')) : 0;
            $delivery_address = trim($this->input->post('delivery_address'));
            $remarks = trim($this->input->post('remarks'));

            $this->form_validation->set_rules('client_id', 'Client', 'required');
            if ($this->form_validation->run() === FALSE) {
                redirect(base_url('order_sheet/create_new_order_sheet'));
            } else {
                $order_sheet_table_array_info = $this->session->userdata('order_sheet_table_array');
                $order_sheet_total_price_session = (double) $this->session->userdata('order_sheet_total_price');
                if (empty($order_sheet_table_array_info)) {
                    $this->session->set_flashdata('order_sheet_table_error_message', 'Please add product into the table first');
                    redirect(base_url('order_sheet/create_new_order_sheet'));
                } else {
                    $total = 0;
                    $total = (double) $order_sheet_total_price_session + (double) $freight_charge - (double) $discount - (double) $bonus;
                    $order_sheet_data = array(
                        'online_order_number' => $online_order_sheet_number,
                        'issue_time' => $issue_time,
                        'client_id' => $client_id,
                        'delivery_address' => $delivery_address,
                        'work_order_number' => $work_order_number,
                        'work_order_date' => $work_order_date,
                        'issue_date' => $issue_date,
                        'delivery_date' => $delivery_date,
                        'freight_charge' => $freight_charge,
                        'discount' => $discount,
                        'bonus' => $bonus,
                        'total' => $total,
                        'remarks' => $remarks,
                        'current_date_time' => $current_date_time,
                        'user_id' => $user_id,
                    );
                    $this->Order_sheet_Model->db->insert('order_sheet', $order_sheet_data);
                    $currently_inserted_order_sheet_id = $this->db->insert_id();
                    if (!empty($currently_inserted_order_sheet_id) && (int) $currently_inserted_order_sheet_id > 0) {
                        $this->order_sheet_details_save($currently_inserted_order_sheet_id, $order_sheet_table_array_info);
                        $this->get_session_clear();
                        $this->session->set_flashdata('order_sheet_save_message', 'Information has been saved successfully.');
                        redirect(base_url('order_sheet'));
                    }
                }
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function order_sheet_details_save($currently_inserted_order_sheet_id, $order_sheet_table_array_info) {
        if (!empty($currently_inserted_order_sheet_id) && !empty($order_sheet_table_array_info)) {
            foreach ($order_sheet_table_array_info as $order_sheet) {
                $order_sheet_details_data = array(
                    'product_id' => $order_sheet['product_id'],
                    'pack_size' => $order_sheet['pack_size'],
                    'quantity' => $order_sheet['quantity'],
                    'unit_price' => $order_sheet['fixed_price'],
                    'amount' => $order_sheet['total_amount'],
                    'order_sheet_id' => $currently_inserted_order_sheet_id,
                );
                $this->Order_sheet_details_Model->db->insert('order_sheet_details', $order_sheet_details_data);
            }
        }
    }

    public function get_session_clear() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('order_sheet_access')) == TRUE)) {
            $order_sheet_table_array_info = $this->session->unset_userdata('order_sheet_table_array');
            $order_sheet_total_price_session = (double) $this->session->unset_userdata('order_sheet_total_price');
        } else {
            redirect(base_url('user_login'));
        }
    }

}
