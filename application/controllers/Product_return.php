<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_return extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Product_type_Model');
        $this->load->model('Product_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Product_receive_Model');
        $this->load->model('Branch_stock_Model');
        $this->load->model('Stock_transfer_challan_Model');
        $this->load->model('Stock_transfer_Model');
        $this->load->model('Branchwise_product_store_Model');
        $this->load->model('Product_store_Model');
        $this->load->model('Product_return_model');
        $this->load->model('Company_Model');
    }

    public function index() {
        if (get_user_permission('product_return') === false) {
            redirect(base_url('user_login'));
        }
        $userInfo = $this->session->userdata('user_session');
        $branchId = $userInfo['outlet'];
        $sessionFromBranchId = implode(',',$branchId);
        
        $this->data['title'] = "Product Return";
        $this->data['productReturnList'] = $this->Product_return_model->get_all_product_return($sessionFromBranchId);

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('product_return/index', $this->data);
    }

    public function add() {
        if (get_user_permission('product_return') === false) {
            redirect(base_url('user_login'));
        }
        
        $userInfo = $this->session->userdata('user_session');
        // echo "<pre>"; print_r($userInfo); exit();

        $allBranch = $this->Branch_Model->getAllBranchById($userInfo['outlet']);
        $allProductType = $this->Product_type_Model->get_all_product_type();

        $this->data['title'] = "Add Product Transfer";
        $this->data['allProductType'] = $allProductType;
        $this->data['allBranch'] = $allBranch;
        
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('product_return/add', $this->data);
    }

    public function add_return_product()
    {
        // echo "<pre>"; print_r($this->input->post()); exit();
        $product_id = $this->input->post('productId');
        $qty = $this->input->post('qty');

        if (empty($qty) || $qty == 0) {
            $qty = 1;
        }

        $product_info = $this->Product_Model->getProductById($product_id);

        $isExists = false;

        if (!empty($this->cart->contents())) {
            foreach ($this->cart->contents() as $productInfo) {
                if ($productInfo['id'] == $product_id) {
                    $isExists = true;
                    $qty = $productInfo['qty'] + $qty;
                    $rowid = $productInfo['rowid'];
                    break;
                }
            }
        }

        $data = array(
            'id' => $product_info->id,
            'qty' => $qty,
            'price' => 1,
            'name' => $product_info->product_name,
        );

        if ($isExists == true) {
            $data['rowid'] = $rowid;
            $this->cart->update($data);
        }
        else {
            $this->cart->insert($data);
        }

        // echo "<pre>"; print_r($data); exit();
        $table_body = $this->load->view('product_return/product_return_table_body','',true);
        $table_footer = $this->load->view('product_return/product_return_table_footer','',true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'table_body' => $table_body,
            'table_footer' => $table_footer,
        )));
    }

    public function save()
    {
        if (get_user_permission('product_return') === false) {
            redirect(base_url('user_login'));
        }
        
        // echo "<pre>"; print_r($this->input->post()); exit();
        $branchId = $this->input->post('branch');
        $challan_number = $this->input->post('challanNumber');
        $date = $this->input->post('date');
        $total_item = $this->input->post('total_item');
        $total_qty = $this->input->post('total_qty');
        $remarks = $this->input->post('remarks');

        $userInfo = $this->session->userdata('user_session');

        date_default_timezone_set("Asia/Dhaka");
        $currentTime = date("h:i:s");
        $dateTime = $date." ".$currentTime;

        $productIdArray = $this->input->post('productId');
        $quantityArray = $this->input->post('qty');
        $branchIdArray = array();
        $countProduct = count($this->input->post('productId'));
        for ($i=0; $i < $countProduct; $i++) { 
            array_push($branchIdArray, $branchId);
        }

        $this->Branchwise_product_store_Model->product_store_save($branchIdArray,$productIdArray,$quantityArray,$date,'return_stock');

        $productReturnData = array(
            'user_id' => $userInfo['user_id'],
            'branch_id' => $branchId,
            'challan_number ' => $challan_number,
            'product_return_date' => $dateTime,
            'total_item' => $total_item,
            'total_qty' => $total_qty,
            'remarks' => $remarks,
            'create_time' => date("Y-m-d h:i:s"),
        );

        $this->db->insert('product_return_challan', $productReturnData);
        $lastInsertedProductReturnId = $this->db->insert_id();

        if ($this->input->post('productId')) {
            $countProduct = count($this->input->post('productId'));
            for ($i = 0; $i < $countProduct; $i++) {
            	$productId = $this->input->post('productId')[$i];
            	$quantity = $this->input->post('qty')[$i];

            	$this->Branch_stock_Model->insert_update_branch_stock($branchId,$productId,$quantity,'dec');

                $productReturnListData = array(
                    'user_id' => $userInfo['user_id'],
                    'product_return_challan_id' => $lastInsertedProductReturnId,
                    'product_id' => $productId,
                    'branch_id' => $branchId,
                    'product_return_date' => $dateTime,
                    'quantity' => $quantity,
                    'product_source' => 'factory',
                );
                $this->db->insert('product_return', $productReturnListData);
            }
        }

        $this->cart->destroy();

        $this->session->set_flashdata('successMessage', 'Product Return Information Saved Successfully.');
        redirect(base_url("product_return"));
    }

    public function view()
    {
        if (get_user_permission('product_return') === false) {
            redirect(base_url('user_login'));
        }
        
        // echo "Dew Hunt"; exit();
        $productReturnChallanId = $this->input->post('productReturnChallanId');
        $this->data['companyInfo'] = $this->Company_Model->get_company();
        $this->data['productReturnChallanInfo'] = $this->Product_return_model->get_product_return_challan_by_id($productReturnChallanId);
        $this->data['productReturnProductList'] = $this->Product_return_model->get_product_return_product_list_by_product_return_challan_id($productReturnChallanId);

        $output = $this->load->view('product_return/product_return_product_info_modal',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }

    public function get_product_info_by_product_type()
    {
        $output = "";
        $productTypeId = $this->input->post('productTypeId');

        if ($productTypeId != "") {
            $productList = $this->Product_Model->getSearchProductInfoByProductType($productTypeId);
            $output .= "<select class='form-control select2' id='product' name='product'>";
                $output .= "<option value=''>Select Product</option>";
                foreach ($productList as $product) {
                    $output .= "<option value='".$product->id."'>".$product->product_name."</option>";
                }
            $output .= "</select>";
        }
        else {
            $output .= "<select class='form-control select2' id='product' name='product'>";
                $output .= "<option value=''>Select Product</option>";
            $output .= "</select>";
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }

    public function set_branch_id_in_session()
    {
        $toBranchOutput = "";
        $branchId = $this->input->post('branchId');

        $branchInfo = $this->Branch_Model->get_branch($branchId);

        $formBranchId = $branchInfo->id;
        $fromBranchName = $branchInfo->branch_name;

        $this->session->set_userdata('sessionBranchId',$formBranchId);
        $this->session->set_userdata('sessionBranchName',$fromBranchName);

        if ($branchId != "") {
            $toBranchList = $this->Branch_Model->get_all_branch_list_except_selected_branch_id($this->session->userdata('sessionBranchId'));

            $toBranchOutput .= "<select class='form-control select2' id='toBranch' name='toBranch'>";
                $toBranchOutput .= "<option value=''>Select Outlet</option>";
                foreach ($toBranchList as $toBranch) {
                    $toBranchOutput .= "<option value='".$toBranch->id."'>".$toBranch->branch_name."</option>";
                }
            $toBranchOutput .= "</select>";
        }
        else {
            $toBranchOutput .= "<select class='form-control select2' id='toBranch' name='toBranch'>";
                $toBranchOutput .= "<option value=''>Select Outlet</option>";
            $toBranchOutput .= "</select>";
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'formBranchId' => $formBranchId,
            'fromBranchName' => $fromBranchName,
            'toBranchOutput' => $toBranchOutput,
        )));
    }

    public function destroy_session_product_info()
    {
        $cartRowId =  $this->input->post('cartRowId');

        if (empty($cartRowId)) {
            $this->cart->destroy();
        }
        else {
            $this->cart->remove($this->input->post('cartRowId'));
        }
    }
}
