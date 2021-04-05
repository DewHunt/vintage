<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_statement extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->library('pagination');
        $this->load->model('User_Model');
        $this->load->model('Product_type_Model');
        $this->load->model('Product_Model');
        $this->load->model('Product_purchase_model');
        $this->load->model('Company_Model');
        $this->load->model('Supplier_model');
    }

    public function index() {
        if (get_user_permission('purchase_statement') === false) {
            redirect(base_url('user_login'));
        }
        
    	$this->data['title'] = "Purchase Statement";
        $this->data['supplierList'] = $this->Supplier_model->get_all_supplier();

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('purchase_statement/index', $this->data);
    }

    public function show() {
        if (get_user_permission('purchase_statement') === false) {
            redirect(base_url('user_login'));
        }

    	// echo "<pre>"; print_r($this->input->post()); exit();

        $start_date = trim($this->input->post('from_date'));
        $end_date = trim($this->input->post('to_date'));
    	$supplier_id = $this->input->post('supplier_id');

        $this->data['companyInfo'] = $this->Company_Model->get_company();
        $this->data['purchasedStatementList'] = $this->Product_purchase_model->get_purchased_statement($start_date,$end_date,$supplier_id);

        $output = $this->load->view('purchase_statement/purchase_statement_table',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }

    public function view()
    {
        if (get_user_permission('purchase_statement') === false) {
            redirect(base_url('user_login'));
        }
        
    	// echo "Dew Hunt"; exit();
    	$purchasedProductId = $this->input->post('purchasedProductId');
        $this->data['companyInfo'] = $this->Company_Model->get_company();
        $this->data['purchasedProductInfo'] = $this->Product_purchase_model->get_purchased_product_by_id($purchasedProductId);
        $this->data['purchasedProductList'] = $this->Product_purchase_model->get_purchased_product_list_by_purchased_product_id($purchasedProductId);

        $output = $this->load->view('purchase_statement/view_product_list_modal',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }
}
