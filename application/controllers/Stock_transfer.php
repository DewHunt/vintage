<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_transfer extends CI_Controller {

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
        $this->load->model('Company_Model');
    }

    public function index() {
        if (get_user_permission('stock_transfer') === false) {
            redirect(base_url('user_login'));
        }
        $userInfo = $this->session->userdata('user_session');
        $branchId = $userInfo['outlet'];
        $sessionFromBranchId = implode(',',$branchId);
        
        $this->data['title'] = "Stock Transfer";
        $this->data['stockTransferList'] = $this->Stock_transfer_Model->get_all_stock_transfer($sessionFromBranchId);

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('stock_transfer/index', $this->data);
    }

    public function add() {
        if (get_user_permission('stock_transfer') === false) {
            redirect(base_url('user_login'));
        }
        
        $userInfo = $this->session->userdata('user_session');
        // echo "<pre>"; print_r($userInfo); exit();

        $factoryStatus = 0;
        $hotKitchenStatus = 1;

        $allFromBranch = $this->Branch_Model->get_any_type_branch_by_id($userInfo['outlet'],"OR",$factoryStatus,$hotKitchenStatus);

        if (count($allFromBranch) == 1) {
            $singleOutlect = $allFromBranch[0];
            $allFromBranch = array();
            $this->data['singleOutlect'] = $singleOutlect;
            $this->session->set_userdata('sessionBranchId',$singleOutlect->id);
            $this->session->set_userdata('sessionBranchName',$singleOutlect->branch_name);
        }

        $allProductType = $this->Product_type_Model->get_all_product_type();
        $allToBrnach = array();
        if ($this->session->userdata('sessionBranchId')) {
            $allToBrnach = $this->Branch_Model->get_all_branch_list_except_selected_branch_id($this->session->userdata('sessionBranchId'),"OR",$factoryStatus,$hotKitchenStatus);
        }

        $this->data['title'] = "Add Product Transfer";
        $this->data['allProductType'] = $allProductType;
        $this->data['allFromBranch'] = $allFromBranch;
        $this->data['allToBrnach'] = $allToBrnach;
        
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('stock_transfer/add', $this->data);
    }

    public function add_transfer_product()
    {
        // echo "<pre>"; print_r($this->input->post()); exit();
        $product_id = $this->input->post('productId');
        $qty = $this->input->post('qty');
        $fromBranchId = $this->input->post('fromBranchId');

        $product_info = $this->Product_Model->getProductById($product_id);
        $errorMessage = "";

        $branchStock = $this->Branch_stock_Model->is_branch_stock_exists($fromBranchId,$product_id);

        if (empty($branchStock)) {
            $errorMessage = $product_info->product_name." Has Insufficient Quantity";
        }
        else {
            if (empty($qty) || $qty == 0) {
                $qty = 1;
            }

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

            if ($branchStock->stock < $qty) {
                $errorMessage = $product_info->product_name." Has Insufficient Quantity. Available Stock is ".$branchStock->stock;
            }
            else {
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
            }
        }

        // echo "<pre>"; print_r($data); exit();
        $table_body = $this->load->view('stock_transfer/stock_transfer_table_body','',true);
        $table_footer = $this->load->view('stock_transfer/stock_transfer_table_footer','',true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'table_body' => $table_body,
            'table_footer' => $table_footer,
            'errorMessage' => $errorMessage,
        )));
    }

    public function save()
    {
        if (get_user_permission('stock_transfer') === false) {
            redirect(base_url('user_login'));
        }
        
        // echo "<pre>"; print_r($this->input->post()); exit();

        $from_branch_id = $this->input->post('fromBranch');

        if ($this->input->post('productId')) {
            $countProduct = count($this->input->post('productId'));
            for ($i = 0; $i < $countProduct; $i++) {
                $productId = $this->input->post('productId')[$i];
                $qty = $this->input->post('qty')[$i];

                $productInfo = $this->Product_Model->getProductById($productId);

                $branchStock = $this->Branch_stock_Model->is_branch_stock_exists($from_branch_id,$productId);

                if (empty($branchStock)) {
                    $this->session->set_flashdata('errorMessage', $productInfo->product_name." Has Insufficient Quantity");
                    redirect(base_url("stock_transfer/add"));
                }
                else {
                    if ($branchStock->stock < $qty) {
                        $this->session->set_flashdata('errorMessage', $productInfo->product_name." Has Insufficient Quantity. Available Stock is ".$branchStock->stock);
                        redirect(base_url("stock_transfer/add"));
                    }
                }
            }
        }

        $to_branch_id = $this->input->post('toBranch');
        $challan_number = $this->input->post('challanNumber');
        $date = $this->input->post('date');
        $total_item = $this->input->post('total_item');
        $total_qty = $this->input->post('total_qty');
        $remarks = $this->input->post('remarks');

        $userInfo = $this->session->userdata('user_session');

        date_default_timezone_set("Asia/Dhaka");
        $currentTime = date("h:i:s");
        $dateTime = $date." ".$currentTime;

        $branchIdArray = array();
        $countProduct = count($this->input->post('productId'));
        for ($i=0; $i < $countProduct; $i++) { 
            array_push($branchIdArray, $from_branch_id);
        }

        $this->Branchwise_product_store_Model->product_store_save($branchIdArray,$this->input->post('productId'),$this->input->post('qty'),$date,'transfer_stock');

        $stockTransferData = array(
            'user_id' => $userInfo['user_id'],
            'from_branch_id' => $from_branch_id,
            'to_branch_id ' => $to_branch_id,
            'challan_number' => $challan_number,
            'transfer_date' => $dateTime,
            'total_item' => $total_item,
            'total_qty' => $total_qty,
            'reason' => $remarks,
            'create_time' => date("Y-m-d h:i:s"),
        );

        $this->db->insert('stock_transfer_challan', $stockTransferData);
        $lastInsertedStockTransferId = $this->db->insert_id();

        if ($this->input->post('productId')) {
            $countProduct = count($this->input->post('productId'));
            for ($i = 0; $i < $countProduct; $i++) {
                $productId = $this->input->post('productId')[$i];
                $qty = $this->input->post('qty')[$i];

                $this->Branch_stock_Model->insert_update_branch_stock($from_branch_id,$productId,$qty,'dec');

                // $branchStock = $this->Branch_stock_Model->is_branch_stock_exists($from_branch_id,$productId);

                // if ($branchStock) {
                //     $branchStockData['stock'] = $branchStock->stock - $qty;
                //     $this->db->where('id',$branchStock->id);
                //     $this->db->update('branch_stock', $branchStockData);
                // }

                $stockTransferListData = array(
                    'user_id' => $userInfo['user_id'],
                    'stock_transfer_challan_id' => $lastInsertedStockTransferId,
                    'from_branch_id' => $from_branch_id,
                    'to_branch_id' => $to_branch_id,
                    'product_id' => $productId,
                    'date_of_transfer' => $dateTime,
                    'quantity' => $qty,
                    'transfer_reason' => $remarks,
                    'product_source' => 'factory',
                );
                $this->db->insert('stock_transfer', $stockTransferListData);
            }
        }

        $this->cart->destroy();

        $this->session->set_flashdata('successMessage', 'Stock Transfer Information Saved Successfully.');
        redirect(base_url("stock_transfer"));
    }

    public function view()
    {
        if (get_user_permission('stock_transfer') === false) {
            redirect(base_url('user_login'));
        }
        
        // echo "Dew Hunt"; exit();
        $stockTransferChallanId = $this->input->post('stockTransferChallanId');
        $this->data['companyInfo'] = $this->Company_Model->get_company();
        $this->data['stockTransferChallanInfo'] = $this->Stock_transfer_Model->get_stock_transfer_product_challan_by_id($stockTransferChallanId);
        $this->data['stockTransferProductList'] = $this->Stock_transfer_Model->get_stock_transfer_product_list_by_stock_transfer_challan_id($stockTransferChallanId);

        $output = $this->load->view('stock_transfer/stock_transfer_product_info_modal',$this->data,true);

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
            $factoryStatus = 0;
            $hotKitchenStatus = 1;
            $toBranchList = $this->Branch_Model->get_all_branch_list_except_selected_branch_id($this->session->userdata('sessionBranchId'),"OR",$factoryStatus,$hotKitchenStatus);

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
