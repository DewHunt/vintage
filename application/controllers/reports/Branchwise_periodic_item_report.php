<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Branchwise_periodic_item_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Branch_Model');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Branchwise_product_store_Model');
        $this->load->model('Branch_stock_Model');
        $this->load->model('Client_product_return_details_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
//            $this->get_branchwise_product_stock_correction();
//            $this->get_branch_stock_correction();
//            $this->get_branch_stock_correction();
            $this->data['title'] = "Branchwise Item Report";
            $this->data['product_list'] = $this->Product_Model->get_product();
            $this->data['branch_list'] = $this->Branch_Model->get_branch();
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/branchwise_periodic_item_report/branchwise_periodic_item_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function branchwise_periodic_item_report_show() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $branch_id = (int) trim($this->input->post('branch_id'));
            $product_id = (int) trim($this->input->post('product_id'));
            $start_date = get_start_date_format(trim($this->input->post('start_date')));
            $end_date = get_end_date_format(trim($this->input->post('end_date')));
            $company_information = $this->Company_Model->get_company();
            $product_information = $this->Product_Model->get_product($product_id);
            $branch_information = $this->Branch_Model->get_branch($branch_id);
            if (!empty($branch_information) && (intval($branch_id) > 0)) {
                $branch_name = $branch_information->branch_name;
            } else {
                $branch_name = '';
            }
            if (!empty($product_information) && (intval($product_id) > 0)) {
                $product_name = $product_information->product_name;
            } else {
                $product_name = '';
            }
            if (empty($start_date) || empty($end_date) || $branch_id <= 0 || $product_id <= 0) {
                echo '<div class="error error-message text-align-center">Please select Date, Outlet and Product</div>';
            } else {
                $branchwise_periodic_item_product_store_report_view = $this->get_branchwise_periodic_item_product_store_report($branch_information, $product_information, $start_date, $end_date);
                $this->data['company_information'] = $company_information;
                $this->data['product_information'] = $product_information;
                $this->data['product_name'] = $product_name;
                $this->data['branch_name'] = $branch_name;
                $this->data['branch_information'] = $branch_information;
                $this->data['start_date'] = $start_date;
                $this->data['end_date'] = $end_date;
                $this->data['branchwise_periodic_item_product_store_report_view'] = $branchwise_periodic_item_product_store_report_view;
                $this->load->view('reports/branchwise_periodic_item_report/branchwise_periodic_item_report_table', $this->data);
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_branchwise_periodic_item_product_store_report($branch, $product, $start_date, $end_date) {
        $open_stock = 0;
        $closing_stock = 0;
        $receive_stock_sum = 0;
        $transfer_stock_sum = 0;
        $sale_from_stock_sum = 0;
        $damage_stock_sum = 0;
        $return_stock_sum = 0;
        $branch_id = $branch->id;
        $branch_name = $branch->branch_name;
        $product_id = $product->id;
        $product_name = $product->product_name;
        $last_branchwise_product_store_by_date = $this->Branchwise_product_store_Model->get_last_branchwise_product_store_by_date($branch_id, $product_id, $start_date);
        $last_branchwise_product_store_by_end_date = $this->Branchwise_product_store_Model->get_last_branchwise_product_store_by_date($branch_id, $product_id, $end_date);
        $open_stock = !empty($last_branchwise_product_store_by_date) ? $last_branchwise_product_store_by_date->closing_stock : 0;
        if (get_date_interval($start_date, $end_date) == 1) {
            $open_stock = !empty($last_branchwise_product_store_by_date) ? $last_branchwise_product_store_by_date->open_stock : 0;
        }
        $closing_stock = !empty($last_branchwise_product_store_by_end_date) ? $last_branchwise_product_store_by_end_date->closing_stock : 0;

        $client_product_return_details_by_date_and_product = $this->Client_product_return_details_Model->get_client_product_return_details_by_date_and_product($start_date, $end_date, $product_id);
        if (!empty($client_product_return_details_by_date_and_product)) {
            foreach ($client_product_return_details_by_date_and_product as $client_product_return) {
                $return_stock_sum += intval($client_product_return->quantity);
            }
        }

        $branchwise_product_store_by_branch_product_date = $this->Branchwise_product_store_Model->get_branchwise_product_store_by_branch_product_date($branch_id, $product_id, $start_date, $end_date);
        if (!empty($branchwise_product_store_by_branch_product_date)) {
            foreach ($branchwise_product_store_by_branch_product_date as $branchwise_product_store) {
                $receive_stock_sum += (int) $branchwise_product_store->receive_stock;
                $transfer_stock_sum += (int) $branchwise_product_store->transfer_stock;
                $sale_from_stock_sum += (int) $branchwise_product_store->sale_from_stock;
                $damage_stock_sum += (int) $branchwise_product_store->damage_stock;
            }
        }

        $branchwise_periodic_item_product_store_report_array = array(
            'branch_name' => $branch_name,
            'product_name' => $product_name,
            'open_stock' => $open_stock,
            'receive_stock' => ($receive_stock_sum - $return_stock_sum),
            'transfer_stock' => $transfer_stock_sum,
            'sale_from_stock' => $sale_from_stock_sum,
            'damage_stock' => $damage_stock_sum,
            'return_stock' => $return_stock_sum,
            'closing_stock' => $closing_stock,
        );
        return $branchwise_periodic_item_product_store_report_array;
    }

    //test
    //this method will correct the branchwise product store table values
    public function get_branchwise_product_stock_correction() {
        $branchwise_product_store_list = $this->Branchwise_product_store_Model->get_branchwise_product_store();
        if (!empty($branchwise_product_store_list)) {
            $arr = array();
            foreach ($branchwise_product_store_list as $branchwise_product_store) {
                $branchwise_product_store_from_previous_date_by_product_id_branch_id = $this->Branchwise_product_store_Model->get_branchwise_product_store_from_previous_date_by_product_id_branch_id($branchwise_product_store->product_store_date, $branchwise_product_store->product_id, $branchwise_product_store->branch_id);
                $open_stock = !empty($branchwise_product_store_from_previous_date_by_product_id_branch_id) ? $branchwise_product_store_from_previous_date_by_product_id_branch_id->closing_stock : 0;
                $closing_stock = (int) ($open_stock + $branchwise_product_store->receive_stock - $branchwise_product_store->transfer_stock - $branchwise_product_store->sale_from_stock - $branchwise_product_store->damage_stock);
                $branchwise_product_store_data = array(
                    'id' => $branchwise_product_store->id,
                    'product_store_date' => $branchwise_product_store->product_store_date,
                    'product_id' => $branchwise_product_store->product_id,
                    'branch_id' => $branchwise_product_store->branch_id,
                    'open_stock' => $open_stock,
                    'receive_stock' => $branchwise_product_store->receive_stock,
                    'transfer_stock' => $branchwise_product_store->transfer_stock,
                    'sale_from_stock' => $branchwise_product_store->sale_from_stock,
                    'damage_stock' => $branchwise_product_store->damage_stock,
                    'closing_stock' => $closing_stock,
                );
                array_push($arr, $branchwise_product_store_data);
                //$this->db->where('id', $branchwise_product_store_data['id']);
                //$this->Branchwise_product_store_Model->db->update('branchwise_product_store', $branchwise_product_store_data);
            }
            echo 'branchwise product store';
            echo '<br>';
            echo '<pre>';
            print_r($arr);
            echo '</pre>';
            die();
        }
    }

    //test
    //this method will correct the branch_stock table values
    public function get_branch_stock_correction() {
        $branch_stock_list = $this->Branch_stock_Model->get_branch_stock();
        $date = get_current_date();
        if (!empty($branch_stock_list)) {
            $arr = array();
            foreach ($branch_stock_list as $branch_stock) {
                if ($branch_stock->product_id == 103) {
                    $branchwise_product_store_from_previous_date_by_product_id_branch_id = $this->db->query("SELECT * FROM branchwise_product_store WHERE product_store_date <= '$date' AND product_id='$branch_stock->product_id' AND branch_id='$branch_stock->branch_id' ORDER BY id DESC LIMIT 1")->row();
                    $branch_stock_data = array(
                        'id' => $branch_stock->id,
                        'branchwise_product_store' => $branchwise_product_store_from_previous_date_by_product_id_branch_id->id,
                        'product_id' => $branchwise_product_store_from_previous_date_by_product_id_branch_id->product_id,
                        'branch_id' => $branchwise_product_store_from_previous_date_by_product_id_branch_id->branch_id,
                        'stock' => (int) $branchwise_product_store_from_previous_date_by_product_id_branch_id->closing_stock,
                    );
                    array_push($arr, $branch_stock_data);
//                    $this->db->where('id', $branch_stock_data['id']);
//                    $this->Branch_stock_Model->db->update('branch_stock', $branch_stock_data);
                }
            }
            echo 'branch Stock';
            echo '<br>';
            echo '<pre>';
            print_r($arr);
            echo '</pre>';
            die();
        }
    }

}
