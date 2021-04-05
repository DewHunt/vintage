<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Periodic_item_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Product_store_Model');
        $this->load->model('Client_product_return_details_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $this->data['title'] = "Item Report";
            $company_information = $this->Company_Model->get_company();
            $product_list = $this->Product_Model->get_product();
            $this->data['product_list'] = $product_list;
            $this->data['company_information'] = $company_information;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/periodic_item_report/periodic_item_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function periodic_item_report_show() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $product_id = (int) trim($this->input->post('product_id'));
            $start_date = get_start_date_format(trim($this->input->post('start_date')));
            $end_date = get_end_date_format(trim($this->input->post('end_date')));
            if (empty($start_date) || empty($end_date)) {
                echo '<div class="error error-message text-align-center">Please Select Date</div>';
            } else {
                $company_information = $this->Company_Model->get_company();
                $product_information = $this->Product_Model->get_product($product_id);
                $flag = FALSE;
                if (!empty($product_information) && (int) $product_id > 0) {
                    $product_name = $product_information->product_name;
                    $flag = TRUE;
                } else {
                    $product_name = 'All';
                }
                $report_array_for_product_stock = array();
                $periodic_item_product_store_report_view = array();
                $product_list = $this->Product_Model->get_product();
                if (!empty($product_list)) {
                    foreach ($product_list as $product) {
                        if (($flag) && ((int) $product_id === (int) $product->id)) { // for single product stock
                            $periodic_item_product_store_report_view = $this->get_periodic_item_report($product, $start_date, $end_date);
                            array_push($report_array_for_product_stock, $periodic_item_product_store_report_view);
                            $periodic_item_product_store_report_view = $report_array_for_product_stock;
                        } elseif (!$flag) { // for all product stock
                            $periodic_item_product_store_report_view = $this->get_periodic_item_report($product, $start_date, $end_date);
                            array_push($report_array_for_product_stock, $periodic_item_product_store_report_view);
                            $periodic_item_product_store_report_view = $report_array_for_product_stock;
                        }
                    }
                }
                $this->data['company_information'] = $company_information;
                $this->data['product_information'] = $product_information;
                $this->data['product_name'] = $product_name;
                $this->data['start_date'] = $start_date;
                $this->data['end_date'] = $end_date;
                $this->data['periodic_item_product_store_report_view'] = $periodic_item_product_store_report_view;
                $this->load->view('reports/periodic_item_report/periodic_item_report_table', $this->data);
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_periodic_item_report($product, $start_date, $end_date) {
        //$start_date = date('Y-m-d', strtotime('-1 day', strtotime($start_date)));
        $open_stock = 0;
        $closing_stock = 0;
        $receive_stock_sum = 0;
        $transfer_stock_sum = 0;
        $sale_from_stock_sum = 0;
        $damage_stock_sum = 0;
        $return_stock_sum = 0;
        $product_id = (int) $product->id;
        $product_name = $product->product_name;
        $last_product_store_by_date = $this->Product_store_Model->get_last_product_store_by_date($product_id, $start_date);
        $last_product_store_by_end_date = $this->Product_store_Model->get_last_product_store_by_date($product_id, $end_date);
        $periodic_item_product_store_by_product_and_date = $this->Product_store_Model->get_periodic_item_product_store_by_product_and_date($product_id, $start_date, $end_date);

        $open_stock = !empty($last_product_store_by_date) ? $last_product_store_by_date->closing_stock : 0;
        if (get_date_interval($start_date, $end_date) == 1) {
            $open_stock = !empty($last_product_store_by_date) ? $last_product_store_by_date->open_stock : 0;
        }
        $closing_stock = !empty($last_product_store_by_end_date) ? $last_product_store_by_end_date->closing_stock : 0;
        
        $client_product_return_details_by_date_and_product = $this->Client_product_return_details_Model->get_client_product_return_details_by_date_and_product($start_date, $end_date, $product_id);
        if (!empty($client_product_return_details_by_date_and_product)) {
            foreach ($client_product_return_details_by_date_and_product as $client_product_return) {
                $return_stock_sum += intval($client_product_return->quantity);
            }
        }
        
        if (!empty($periodic_item_product_store_by_product_and_date)) {
            foreach ($periodic_item_product_store_by_product_and_date as $periodic_item) {
                $receive_stock_sum += (int) $periodic_item->receive_stock;
                $transfer_stock_sum += (int) $periodic_item->transfer_stock;
                $sale_from_stock_sum += (int) $periodic_item->sale_from_stock;
                $damage_stock_sum += (int) $periodic_item->damage_stock;
            }
        }
        $periodic_item_report_array = array(
            'product_name' => $product_name,
            'open_stock' => $open_stock,
            'receive_stock' => ($receive_stock_sum - $return_stock_sum),
            'transfer_stock' => $transfer_stock_sum,
            'sale_from_stock' => $sale_from_stock_sum,
            'damage_stock' => $damage_stock_sum,
            'return_stock' => $return_stock_sum,
            'closing_stock' => $closing_stock,
        );
        return $periodic_item_report_array;
    }

}
