<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_receive extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Product_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Product_receive_Model');
        $this->load->model('Product_receive_challan_Model');
        $this->load->model('Branch_stock_Model');
        $this->load->model('Branchwise_product_store_Model');
        $this->load->model('Product_store_Model');
        $this->load->model('Company_Model');
        $this->load->model('Product_transfer_model');
        $this->load->model('Product_return_model');
        $this->load->model('Stock_transfer_Model');
    }

    public function index() {
        if (get_user_permission('product_receive') === false) {
            redirect(base_url('user_login'));
        }

        $userInfo = $this->session->userdata('user_session');
        $branchId = $userInfo['outlet'];
        $sessionBranchId = implode(',',$branchId);

        $this->data['title'] = "Product Receive List";
        $this->data['receiveProductChallanList'] = $this->Product_receive_Model->get_all_receive_product_challan($sessionBranchId);
        $this->data['receiveStockTransferChallanList'] = $this->Product_receive_Model->get_all_receive_stock_transfer_challan($sessionBranchId);
        $this->data['approveProductReturnChallanList'] = $this->Product_receive_Model->get_all_approve_return_product_challan($sessionBranchId);

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('product_receive/index', $this->data);
    }

    public function view()
    {
        if (get_user_permission('product_receive') === false) {
            redirect(base_url('user_login'));
        }
        
        $receiveChallanId = $this->input->post('receiveChallanId');
        $type = $this->input->post('type');
        $this->data['companyInfo'] = $this->Company_Model->get_company();

        if ($type == "FactoryToBranch") {
            $this->data['receiveChallanInfo'] = $this->Product_transfer_model->get_transfer_product_challan_by_id($receiveChallanId);
            $this->data['receiveProductList'] = $this->Product_transfer_model->get_transfer_product_list_by_transfer_product_challan_id($receiveChallanId);
        }
        elseif($type == "BranchToBranch") {
            $this->data['receiveChallanInfo'] = $this->Stock_transfer_Model->get_stock_transfer_product_challan_by_id($receiveChallanId);
            $this->data['receiveProductList'] = $this->Stock_transfer_Model->get_stock_transfer_product_list_by_stock_transfer_challan_id($receiveChallanId);
        }
        else {
            $this->data['receiveChallanInfo'] = $this->Product_return_model->get_product_return_challan_by_id($receiveChallanId);
            $this->data['receiveProductList'] = $this->Product_return_model->get_product_return_product_list_by_product_return_challan_id($receiveChallanId);                
        }

        $this->data['type'] = $type;

        $output = $this->load->view('product_receive/receive_product_info_modal',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }

    public function receive_product()
    {
        $productReceiveId = $this->input->post('productReceiveId');
        $type = $this->input->post('type');

        if ($type == "BranchToFactory") {
            $challanTableName = "product_return_challan";
            $productTableName = "product_return";
            $productTablecolumnName = "product_return_challan_id";

            $productReceiveInfo = $this->Product_receive_Model->get_receive_product_info_by_id($productTableName,$productReceiveId);
            
            $challanId = $productReceiveInfo->product_return_challan_id;
            $productId = $productReceiveInfo->product_id;
            $quantity = $productReceiveInfo->quantity;

            $productIdArray = array('0' => $productId);
            $quantityArray = array('0' => $quantity);
            $this->Product_store_Model->product_store_save($productIdArray,$quantityArray,date('Y-m-d'),'return_from_branch');

            $this->Product_Model->update_product_stock($productId,$quantity,'inc');
            $msg = "Approved";
        }
        else {
            if ($type == "FactoryToBranch") {
                $challanTableName = "product_receive_challan";
                $productTableName = "product_receive";
                $productTablecolumnName = "product_receive_challan_id";

                $productReceiveInfo = $this->Product_receive_Model->get_receive_product_info_by_id($productTableName,$productReceiveId);
                $challanId = $productReceiveInfo->product_receive_challan_id;
                $branchId = $productReceiveInfo->branch_id;
            }
            else {
                $challanTableName = "stock_transfer_challan";
                $productTableName = "stock_transfer";
                $productTablecolumnName = "stock_transfer_challan_id";

                $productReceiveInfo = $this->Product_receive_Model->get_receive_product_info_by_id($productTableName,$productReceiveId);
                $challanId = $productReceiveInfo->stock_transfer_challan_id;
                $branchId = $productReceiveInfo->to_branch_id;
            }

            $productId = $productReceiveInfo->product_id;
            $quantity = $productReceiveInfo->quantity;

            $branchIdArray = array('0' => $branchId);
            $productIdArray = array('0' => $productId);
            $quantityArray = array('0' => $quantity);
            $this->Branchwise_product_store_Model->product_store_save($branchIdArray,$productIdArray,$quantityArray,date('Y-m-d'),'receive_stock');

            $this->Branch_stock_Model->insert_update_branch_stock($branchId,$productId,$quantity,'inc');
            $msg = "Received";
        }

        $this->Product_receive_Model->product_update_status($productTableName,$productReceiveId,1);
        $this->Product_receive_Model->challan_update_status($challanTableName,$productTableName,$productTablecolumnName,$challanId,2);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'msg' => $msg,
        )));
    }

    public function reject_product()
    {
        $productReceiveId = $this->input->post('productReceiveId');
        $type = $this->input->post('type');

        if ($type == "FactoryToBranch") {
            $challanTableName = "product_receive_challan";
            $productTableName = "product_receive";
            $productTablecolumnName = "product_receive_challan_id";

            $productReceiveInfo = $this->Product_receive_Model->get_receive_product_info_by_id($productTableName,$productReceiveId);

            $challanId = $productReceiveInfo->product_receive_challan_id;
            $productId = $productReceiveInfo->product_id;
            $quantity = $productReceiveInfo->quantity;

            $productIdArray = array('0' => $productId);
            $quantityArray = array('0' => $quantity);
            $this->Product_store_Model->product_store_save($productIdArray,$quantityArray,date('Y-m-d'),'return_from_branch');

            $this->Product_Model->update_product_stock($productId,$quantity,'inc');
        }
        else {
            if ($type == "BranchToBranch") {
                $challanTableName = "stock_transfer_challan";
                $productTableName = "stock_transfer";
                $productTablecolumnName = "stock_transfer_challan_id";

                $productReceiveInfo = $this->Product_receive_Model->get_receive_product_info_by_id($productTableName,$productReceiveId);
                $challanId = $productReceiveInfo->stock_transfer_challan_id;
                $branchId = $productReceiveInfo->from_branch_id;
            }
            else {
                $challanTableName = "product_return_challan";
                $productTableName = "product_return";
                $productTablecolumnName = "product_return_challan_id";
                
                $productReceiveInfo = $this->Product_receive_Model->get_receive_product_info_by_id($productTableName,$productReceiveId);
                $challanId = $productReceiveInfo->product_return_challan_id;
                $branchId = $productReceiveInfo->branch_id;
            }


            $productId = $productReceiveInfo->product_id;
            $quantity = $productReceiveInfo->quantity;

            $branchIdArray = array('0' => $branchId);
            $productIdArray = array('0' => $productId);
            $quantityArray = array('0' => $quantity);
            $this->Branchwise_product_store_Model->product_store_save($branchIdArray,$productIdArray,$quantityArray,date('Y-m-d'),'receive_stock');

            $this->Branch_stock_Model->insert_update_branch_stock($branchId,$productId,$quantity,'inc');
        }

        $this->Product_receive_Model->product_update_status($productTableName,$productReceiveId,2);
        $this->Product_receive_Model->challan_update_status($challanTableName,$productTableName,$productTablecolumnName,$challanId,2);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'msg' => 'Rejected',
        )));
    }
}
