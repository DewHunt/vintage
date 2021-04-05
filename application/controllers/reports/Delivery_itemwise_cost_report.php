<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_itemwise_cost_report extends CI_Controller {

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
            $this->data['title'] = "Delivery Item Wise Cost Report";
            $this->data['page_title'] = "Delivery Item Wise Cost Report";
            $this->data['delivery_cost_type_list'] = $this->Delivery_cost_type_Model->get_delivery_cost_type();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/delivery_itemwise_cost_report/delivery_itemwise_cost_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function delivery_itemwise_cost_report_show_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $user_info = $this->session->userdata('user_session');
                $user_id = $user_info['user_id'];
                $user_type = $user_info['user_type'];
                $employee_id = $user_info['employee_id'];
                $start_date = trim($this->input->post('start_date'));
                $end_date = trim($this->input->post('end_date'));
                $delivery_cost_type_id = intval(trim($this->input->post('delivery_cost_type_id')));
                $this->data['delivery_cost_name'] = ($delivery_cost_type_id > 0) ? $this->Delivery_cost_type_Model->get_delivery_cost_name_by_id($delivery_cost_type_id) : 'All';
                $this->data['delivery_itemwise_cost_report'] = $this->Delivery_cost_details_Model->get_delivery_itemwise_cost_report(get_start_date_format($start_date), get_end_date_format($end_date), $delivery_cost_type_id);
                $this->data['start_date'] = $start_date;
                $this->data['end_date'] = $end_date;
                if ($delivery_cost_type_id > 0) {
                    $this->load->view('reports/delivery_itemwise_cost_report/delivery_itemwise_cost_report_table', $this->data);
                } else {
                    $this->load->view('reports/delivery_itemwise_cost_report/delivery_itemwise_cost_report_table_all', $this->data);
                }
                
            } else {
                redirect(base_url('reports/delivery_itemwise_cost_report'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

}
