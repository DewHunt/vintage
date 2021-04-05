<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_transfer extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->library('pagination');
        $this->load->model('User_Model');
        $this->load->model('Product_type_Model');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('Product_transfer_model');
        $this->load->model('Branch_Model');
        $this->load->model('Product_store_Model');

        $userInfo = $this->session->userdata('user_session');
        $userType = $userInfo['user_type'];
        
        if (get_menu_permission('factory_access') == false)
        {
            return redirect(base_url('user_login'));
        }
    }

    public function index() {
        if (get_user_permission('product_transfer') === false) {
            redirect(base_url('user_login'));
        }
        
    	$this->data['title'] = "Product Transfer List";
        $this->data['transferProductChallanList'] = $this->Product_transfer_model->get_all_transfer_product_challan();

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('product_transfer/index', $this->data);
    }

    public function add() {
        if (get_user_permission('product_transfer') === false) {
            redirect(base_url('user_login'));
        }
        
        $allProductType = $this->Product_type_Model->get_all_product_type();
        // $allBrnach = $this->Branch_Model->get_branch();
        $allBrnach = $this->Branch_Model->get_any_type_branch('OR',0,1);
        // echo "<pre>"; print_r($allProduct); exit();

        $this->data['title'] = "Add Product Transfer";
        $this->data['allProductType'] = $allProductType;
        $this->data['allBrnach'] = $allBrnach;
        
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('product_transfer/add', $this->data);
    }

    public function add_transfer_product() {
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
        $table_body = $this->load->view('product_transfer/product_transfer_table_body','',true);
        $table_footer = $this->load->view('product_transfer/product_transfer_table_footer','',true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'table_body' => $table_body,
            'table_footer' => $table_footer,
        )));
    }

    public function save() {
        if (get_user_permission('product_transfer') === false) {
            redirect(base_url('user_login'));
        }
        
    	$branch_id = $this->input->post('branch');
    	$challan_number = $this->input->post('challanNumber');
    	$date = $this->input->post('date');
    	$total_item = $this->input->post('total_item');
    	$total_qty = $this->input->post('total_qty');
    	$remarks = $this->input->post('remarks');

        $userInfo = $this->session->userdata('user_session');

		date_default_timezone_set("Asia/Dhaka");
		$currentTime = date("h:i:s");
    	$dateTime = $date." ".$currentTime;

        $this->Product_store_Model->product_store_save($this->input->post('productId'),$this->input->post('qty'),$date,'transfer_stock');
        // echo "<pre>"; print_r($this->input->post()); exit();

        $productTransferData = array(
            'user_id' => $userInfo['user_id'],
            'branch_id' => $branch_id,
            'challan_number' => $challan_number,
            'product_receive_date' => $dateTime,
            'total_item' => $total_item,
            'total_qty' => $total_qty,
            'remarks' => $remarks,
            'create_time' => date("Y-m-d h:i:s"),
        );

        $this->db->insert('product_receive_challan', $productTransferData);
        $lastInsertedProductTransferId = $this->db->insert_id();

        if ($this->input->post('productId')) {
        	$countProduct = count($this->input->post('productId'));
            for ($i = 0; $i < $countProduct; $i++) {
            	$productInfo = $this->Product_Model->getProductById($this->input->post('productId')[$i]);
            	$productData = array(
            		'product_stock' => $productInfo->product_stock - $this->input->post('qty')[$i],
            	);
                $this->db->where('id',$productInfo->id);
                $this->db->update('product', $productData);

                $productTransferListData = array(
                    'user_id' => $userInfo['user_id'],
                    'product_receive_challan_id' => $lastInsertedProductTransferId,
                    'product_id' => $this->input->post('productId')[$i],
                    'branch_id' => $branch_id,
                    'product_receive_date' => $dateTime,
                    'quantity' => $this->input->post('qty')[$i],
                    'product_source' => 'factory',
                );
                $this->db->insert('product_receive', $productTransferListData);
            }
        }

		$this->cart->destroy();

        $this->session->set_flashdata('successMessage', 'Product Transfer Information Saved Successfully.');
        redirect(base_url("product_transfer"));
    }

    public function edit($categoryId) {
        if (get_user_permission('product_transfer') === false) {
            redirect(base_url('user_login'));
        }
        
    	$category = $this->Product_type_Model->getCategoryInfoById($categoryId);
        $allPrinters = $this->Printer_setup_model->get_all_printer();

        $this->data['title'] = "Edit Category";
        $this->data['category'] = $category;
        $this->data['allPrinters'] = $allPrinters;
        
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('productType/edit', $this->data);
    }

    public function update() {
        if (get_user_permission('product_transfer') === false) {
            redirect(base_url('user_login'));
        }
        
    	// echo "<pre>"; print_r($this->input->post()); exit();

        $this->data['title'] = "Edit Category";
	    $categoryId = trim($this->input->post('categoryId'));

    	$this->form_validation->set_rules('name', 'Category Name','required');
    	$this->form_validation->set_rules('foodType', 'Food Type','required');

        if ($this->form_validation->run() === FALSE) {
        	redirect(base_url("product_type/edit/$categoryId"));
        } else {
	    	$name = trim($this->input->post('name'));
	        $isExists = $this->Product_type_Model->isCategoryNameExistsById($name,$categoryId);

	        if (empty($isExists)) {
	            $categoryData = array(
                    'printer_id' => $this->input->post('printerId'),
	                'product_type_name' => $name,
	                'food_type' => trim($this->input->post('foodType')),
                    'availability' => trim($this->input->post('availability')),
	                'button_color' => trim($this->input->post('buttonColor')),
	                'sort_order' => trim($this->input->post('sortOrder')),
	            );

	            $this->db->where('id', $categoryId);
                $this->Product_type_Model->db->update('product_type', $categoryData);
	            $this->session->set_flashdata('successMessage', 'Category Name Update Successfully.');
                redirect(base_url('product_type'));
	        }
	        else {
	            $this->session->set_flashdata('errorMessage', 'Category Name Already Exists.');
	            redirect(base_url("product_type/edit/$categoryId"));
	        }
        }
    }

    public function view()
    {
        if (get_user_permission('product_transfer') === false) {
            redirect(base_url('user_login'));
        }
        
    	// echo "Dew Hunt"; exit();
    	$transferProductChallanId = $this->input->post('transferProductChallanId');
        $this->data['companyInfo'] = $this->Company_Model->get_company();
        $this->data['transferProductChallanInfo'] = $this->Product_transfer_model->get_transfer_product_challan_by_id($transferProductChallanId);
        $this->data['transferProductList'] = $this->Product_transfer_model->get_transfer_product_list_by_transfer_product_challan_id($transferProductChallanId);

        $output = $this->load->view('product_transfer/transfer_product_info_modal',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }

    public function get_product_info_by_product_type() {
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

    public function delete($id) {
        if (get_user_permission('product_transfer') === false) {
            redirect(base_url('user_login'));
        }
        
        $this->Product_type_Model->delete($id);
        redirect(base_url('product_type'));
    }

    public function destroy_session_product_info() {
    	$cartRowId =  $this->input->post('cartRowId');

    	if (empty($cartRowId)) {
    		$this->cart->destroy();
    	}
    	else {
    		$this->cart->remove($this->input->post('cartRowId'));
    	}
    }
}
