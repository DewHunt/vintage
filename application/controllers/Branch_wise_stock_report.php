<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Branch_wise_stock_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Branchwise_product_store_Model');
    }

    public function index() {
        if (get_user_permission('branch_wise_stock_report') === false) {
            redirect(base_url('user_login'));
        }
        $allBranch = $this->Branch_Model->get_branch();

        $this->data['title'] = "Transfer Report";
        $this->data['allBranch'] = $allBranch;

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('branch_wise_stock_report/index', $this->data);
    }

    public function show()
    {
        if (get_user_permission('branch_wise_stock_report') === false) {
            redirect(base_url('user_login'));
        }
        $start_date = $this->input->post('from_date');
        $end_date = $this->input->post('to_date');
        $branchId = $this->input->post('branch');

    	$allProduct = $this->Product_Model->get_product();
    	$branchInfo = $this->Branch_Model->get_branch($branchId);

        $dateDifference = strtotime($end_date) - strtotime($start_date.'-1 day');
        $totalDays = abs(round($dateDifference / (60 * 60 * 24)));

    	$stockReports = array();

        foreach ($allProduct as $product) {
            $lastProductStoreInfoByStartDate = $this->Branchwise_product_store_Model->get_last_branchwise_product_store_by_date($branchId,$product->id,$start_date);
            $lastProductStoreInfoByEndDate = $this->Branchwise_product_store_Model->get_last_branchwise_product_store_by_date($branchId,$product->id,$end_date);

            $closing_stock = !empty($lastProductStoreInfoByEndDate) ? $lastProductStoreInfoByEndDate->closing_stock : 0;

            if ($lastProductStoreInfoByStartDate) {
                if (date('Y-m-d',strtotime($lastProductStoreInfoByStartDate->product_store_date)) == $start_date) {
                    $open_stock = $lastProductStoreInfoByStartDate->open_stock;
                } else {
                    $open_stock = $lastProductStoreInfoByStartDate->closing_stock;
                }
            } else {
                $open_stock = 0;
            }

            $stock = $this->Branchwise_product_store_Model->get_stock_report($branchId,$product->id,$start_date,$end_date);

            $receive_stock = 0;
            $transfer_stock = 0;
            $return_stock = 0;
            $sale_from_stock = 0;
            $damage_stock = 0;

            if (!empty($stock)) {
                $receive_stock = $stock->receive_stock;
                $transfer_stock = $stock->transfer_stock;
                $return_stock = $stock->return_stock;
                $sale_from_stock = $stock->sale_from_stock;
                $damage_stock = $stock->damage_stock;
            }

        	$stock = (object)[
        		'product_name' => $product->product_name,
        		'branch_name' => $branchInfo->branch_name,
        		'open_stock' => $open_stock,
        		'receive_stock' => $receive_stock,
        		'transfer_stock' => $transfer_stock,
        		'return_stock' => $return_stock,
        		'sale_from_stock' => $sale_from_stock,
        		'damage_stock' => $damage_stock,
        		'closing_stock' => $closing_stock,
        	];

        	array_push($stockReports,$stock);
        }

        // echo "<pre>"; print_r($stockReports); exit();

        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->data['companyInfo'] = $this->Company_Model->get_company();
        $this->data['stockReports'] = $stockReports;

        $output = $this->load->view('branch_wise_stock_report/stock_report_table',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }
}
