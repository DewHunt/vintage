<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kitchen_room extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->library('cart');
        $this->load->helper('settings_helper');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('User_Model');
        $this->load->model('Product_Model');
        $this->load->model('Product_type_Model');
        $this->load->model('Client_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Sale_product_Model');
        $this->load->model('Invoice_details_Model');
        $this->load->model('Challan_details_Model');
        $this->load->model('Gate_pass_details_Model');
        $this->load->model('Challan_product_Model');
        $this->load->model('Branchwise_product_store_Model');
        $this->load->model('Product_store_Model');
        $this->load->model('Payment_Model');
        $this->load->model('Client_sales_details_Model');
        $this->load->model('Client_transaction_details_Model');
        $this->load->model('Branch_stock_Model');
        $this->load->model('Invoice_details_Model');
    }

    public function index()
    {
        if (get_user_permission('kitchen_room') === false) {
            redirect(base_url('user_login'));
        }
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id'];
        $user_type = $user_info['user_type'];
        // echo "<pre>"; print_r($user_info); exit();
        // echo "<pre>"; print_r($this->session->userdata()); exit();
        $factoryStatus = 0;
        $hotKitchenStatus = 0;

        // $outlet_list = $this->Branch_Model->get_only_all_branch_by_id($user_info['outlet'],0);
        $outlet_list = $this->Branch_Model->get_any_type_branch_by_id($user_info['outlet'],'AND',$factoryStatus,$hotKitchenStatus);
        $number_of_outlet = count($outlet_list);
        $all_orders = array();

        if ($number_of_outlet == 1) {
        	$outlet_id = $user_info['outlet'];
            $all_orders = $this->Invoice_details_Model->get_all_invoice_by_user_id_and_outlet_id($user_id,$outlet_id[0],$user_type);
        	// echo "<pre>"; print_r($all_orders); exit();
        }
        else {
        	$sessionOutletId = $this->session->userdata('sessionKitchenOutletId');

        	if ($sessionOutletId) {
        		$all_orders = $this->Invoice_details_Model->get_all_invoice_by_user_id_and_outlet_id($user_id,$sessionOutletId,$user_type);
        	}
        }

        $this->data['title'] = "Sale Product";
        $this->data['number_of_outlet'] = $number_of_outlet;
        $this->data['all_orders'] = $all_orders;

        $this->data['outlet_list'] = $outlet_list;
        // echo "<pre>"; print_r($this->data); exit();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('kitchen_room/index', $this->data);
    }

    public function find_all_order_by_outlet_id()
    {
        $outletId = $this->input->post('outletVal');
        $outletName = $this->input->post('outletName');
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id'];
        $user_type = $user_info['user_type'];

        $this->session->set_userdata('sessionKitchenOutletId',$outletId);
        $this->session->set_userdata('sessionKitchenOutletName',$outletName);

        $sessionOutletId = $this->session->userdata('sessionKitchenOutletId');

        $all_orders = $this->Invoice_details_Model->get_all_invoice_by_user_id_and_outlet_id($user_id,$sessionOutletId,$user_type);
        $this->data['all_orders'] = $all_orders;
        $view_all_orders = $this->load->view('kitchen_room/view_all_orders',$this->data,TRUE);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'outletId' => $this->session->userdata('sessionKitchenOutletId'),
            'outletName' => $this->session->userdata('sessionKitchenOutletName'),
            'view_all_orders' => $view_all_orders,
        )));
    }

    public function sale_product_delivered()
    {
    	$sale_product_id = $this->input->post('sale_product_id');
        $delivery_status = $this->input->post('delivery_status');
    	$invoice_id = $this->input->post('invoice_id');

    	$this->Sale_product_Model->update_product_delivery_status_by_id_and_invoice_id($sale_product_id,$delivery_status,$invoice_id);
    }

    public function order_delivered()
    {
    	$invoice_id = $this->input->post('invoice_id');

    	$this->Sale_product_Model->update_product_delivery_status_by_invoice_id($invoice_id);
    	$this->Invoice_details_Model->update_order_delivery_status($invoice_id);
    }
}
