<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_cost_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Invoice_details_Model');
        $this->load->model('Client_Model');
        $this->load->model('Dealer_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Sale_product_Model');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Delivery_cost_type_Model');
        $this->load->model('Delivery_cost_Model');
        $this->load->model('Delivery_cost_details_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $this->data['title'] = "Delivery Cost Report";
            $this->data['page_title'] = "Delivery Cost Report";
            $employee_id = $this->User_Model->get_loggedin_user_employee_id();
            $all_client_by_employee_id = $this->Client_Model->get_all_client_by_employee_id($employee_id);
            $client_list = $this->Client_Model->get_client();
            $user_type = $this->User_Model->get_loggedin_user_type();
            $this->data['client_list'] = (strtolower($user_type) === 'marketing') ? $all_client_by_employee_id : $client_list;
            $this->data['employee_info'] = $this->Employee_Model->get_employee($employee_id);
            $this->data['employee_list'] = $this->Employee_Model->get_employee();
            $this->data['user_type'] = $user_type;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/delivery_cost_report/delivery_cost_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function delivery_cost_report_show_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $user_info = $this->session->userdata('user_session');
                $start_date = trim($this->input->post('start_date'));
                $end_date = trim($this->input->post('end_date'));
                $client_id = (trim($this->input->post('client_id')));
                $employee_id = (trim($this->input->post('employee_id')));
                if (!empty($start_date) && !empty($end_date) && !empty($client_id != '')) {
                    $client_information = !empty($client_id) ? $this->Client_Model->get_client($client_id) : '';
                    if (!empty($client_information)) {
                        $client_name = ucfirst($client_information->client_name);
                        $client_code = $client_information->client_code;
                    } else {
                        if (($client_id == 'import') || ($client_id == 'lubzone')) {
                            $client_name = 'All ' . '(' . $client_id . ')';
                            $client_code = '';
                        } else {
                            $client_name = 'All';
                            $client_code = '';
                        }
                    }
                    $employee_information = !empty($employee_id) ? $this->Employee_Model->get_employee($employee_id) : '';
                    if (!empty($employee_information)) {
                        $employee_name = ucfirst($employee_information->employee_name);
                        $employee_code = $employee_information->employee_code;
                    } else {
                        $employee_name = 'All';
                        $employee_code = '';
                    }
                    $this->data['delivery_cost_list_by_date'] = $this->Delivery_cost_Model->get_delivery_cost_list_by_date(get_start_date_format($start_date), get_end_date_format($end_date), $client_id, $employee_id);
//                    get_print_r($this->db->last_query());
                    $this->data['start_date'] = $start_date;
                    $this->data['end_date'] = $end_date;
                    $this->data['client_name'] = $client_name;
                    $this->data['employee_name'] = $employee_name;
                    $this->data['employee_code'] = $employee_code;
                    $this->load->view('reports/delivery_cost_report/delivery_cost_report_table', $this->data);
                } else {
                    redirect(base_url('reports/delivery_cost_report'));
                }
            } else {
                redirect(base_url('user_login'));
            }
        }
    }

    function delivery_cost_details_report_show_in_modal() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            if ($this->input->is_ajax_request()) {
                $id = intval(trim($this->input->post('id')));
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
                                $this->load->view('reports/delivery_cost_report/delivery_cost_report_modal', $this->data);
                            }
                        }
                    } else {
                        alert_message('Error Occured.');
                    }
                } else {
                    alert_message('Error Occured.');
                }
            } else {
                redirect(base_url('reports/delivery_cost_report'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

}
