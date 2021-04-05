<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_purchase extends CI_Controller {

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
        $this->load->model('Product_store_Model');

        $userInfo = $this->session->userdata('user_session');
        $userType = $userInfo['user_type'];
        
        if (get_menu_permission('factory_access') == false)
        {
            return redirect(base_url('user_login'));
        }
    }

    public function index() {
        if (get_user_permission('product_purchase') === false) {
            redirect(base_url('user_login'));
        }
        
    	$this->data['title'] = "Product Purchase List";
        $this->data['purchasedProductList'] = $this->Product_purchase_model->get_all_purchased_product();

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('product_purchase/index', $this->data);
    }

    public function add() {
        if (get_user_permission('product_purchase') === false) {
            redirect(base_url('user_login'));
        }
        $allProduct = $this->Product_Model->get_product();
        $supplierLists = $this->Supplier_model->get_all_supplier();
        // echo "<pre>"; print_r($allProduct); exit();

        $this->data['title'] = "Add Product Purchase";
        $this->data['allProduct'] = $allProduct;
        $this->data['supplierLists'] = $supplierLists;
        
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('product_purchase/add', $this->data);
    }

    public function add_purchased_product()
    {
    	// echo "<pre>"; print_r($this->input->post()); exit();
    	$product_id = $this->input->post('productId');
    	$qty = $this->input->post('qty');
    	$amount = $this->input->post('amount');

    	if (empty($qty) || $qty == 0) {
    		$qty = 1;
    	}

    	if (empty($amount)) {
    		$amount = 0;
    	}

    	$product_info = $this->Product_Model->getProductById($product_id);

    	$isExists = false;

    	if (!empty($this->cart->contents())) {
			foreach ($this->cart->contents() as $productInfo) {
				if ($productInfo['id'] == $product_id) {
					$isExists = true;
					$qty = $productInfo['qty'] + $qty;
					$amount = $productInfo['price'] + $amount;
					$rowid = $productInfo['rowid'];
					break;
				}
			}
    	}

    	$purchase_rate = number_format(($amount / $qty),2,'.','');

        $data = array(
            'id' => $product_info->id,
            'qty' => $qty,
            'price' => $amount,
            'name' => $product_info->product_name,
            'rate' => $purchase_rate
        );

    	if ($isExists == true) {
			$data['rowid'] = $rowid;
    		$this->cart->update($data);
    	}
    	else {
        	$this->cart->insert($data);
    	}

    	// echo "<pre>"; print_r($data); exit();
        $table_body = $this->load->view('product_purchase/purchased_product_table_body','',true);
        $table_footer = $this->load->view('product_purchase/purchased_product_table_footer','',true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'table_body' => $table_body,
            'table_footer' => $table_footer,
        )));
    }

    public function save()
    {
        if (get_user_permission('product_purchase') === false) {
            redirect(base_url('user_login'));
        }
    	// echo "<pre>"; print_r($this->input->post()); exit();

    	$imagePath = '';
    	if (!empty($_FILES['moneyReceiptImage']['name'])) {
	        if ((int) $_FILES['moneyReceiptImage']["size"] > (150 * 1024)) {
	            $this->session->set_flashdata('errorMessage', 'Image size can not be more than 150 KB');
	            redirect(base_url('product_purchase/add'));
	        } else {
	            $imageName = $_FILES['moneyReceiptImage']['name'];
	            $config['file_name'] = $imageName;
	            $config['upload_path'] = './assets/uploads/money_receipt_images';
	            $config['allowed_types'] = 'gif|jpg|png';

	            $this->load->library('upload', $config);
	            if ($this->upload->do_upload('moneyReceiptImage')) {
	                $imagePath  = '/assets/uploads/money_receipt_images/' . $config['file_name'];
	            } else {
	                $this->session->set_flashdata('errorMessage', 'Something Went Wrong. Please Try Again');
	                redirect(base_url('product_purchase/add'));
	            }
	        }
    	}

    	$supplierId = $this->input->post('supplier');
    	$amountName = $this->input->post('amountName');
    	$displayAmount = $this->input->post('displayAmount');
    	$date = $this->input->post('date');
    	$paymentMode = $this->input->post('paymentMode');
    	$paidAmount = $this->input->post('paidAmount');
    	$moneyReceiptNumber = $this->input->post('moneyReceiptNumber');
    	$remarks = $this->input->post('remarks');
    	$purchaseAmount = $this->input->post('total_amount');

        $userInfo = $this->session->userdata('user_session');

		date_default_timezone_set("Asia/Dhaka");
		$currentTime = date("h:i:s");
    	$dateTime = $date." ".$currentTime;

    	// Insert Purchased Product Start Here
        $purchasedProductData = array(
            'user_id' => $userInfo['user_id'],
            'supplier_id' => $supplierId,
            'date' => $dateTime,
            'total_qty' => $this->input->post('total_qty'),
            'total_amount' => $purchaseAmount,
            'payment_mode' => $paymentMode,
            'paid_amount' => $paidAmount,
            'due_amount' => $purchaseAmount - $paidAmount,
            'remarks' => $this->input->post('remarks'),
        );

        $this->db->insert('purchased_product', $purchasedProductData);
        $lastInsertedPurchasedProductId = $this->db->insert_id();
    	// Insert Purchased Product End Here

    	// Insert Purchased Product List Start Here
        if ($this->input->post('productId')) {
            $productIdArray = $this->input->post('productId');
            $quantityArray = $this->input->post('qty');

            $this->Product_store_Model->product_store_save($productIdArray,$quantityArray,$date,'receive_stock');
            
        	$countProduct = count($this->input->post('productId'));
            for ($i = 0; $i < $countProduct; $i++) {
            	$productInfo = $this->Product_Model->getProductById($this->input->post('productId')[$i]);
            	$old_product_stock = $productInfo->product_stock;
            	$old_purchase_price = $productInfo->purchase_price;
            	$old_amount = $old_product_stock * $old_purchase_price;

            	$new_product_stock = $old_product_stock + $this->input->post('qty')[$i];
            	$new_amount = $old_amount + $this->input->post('amount')[$i];
            	$new_purchase_price = number_format(($new_amount / $new_product_stock),2,'.','');

            	$productData = array(
            		'product_stock' => $new_product_stock,
            		'purchase_price' => $new_purchase_price,
            	);

                $this->db->where('id',$productInfo->id);
                $this->db->update('product', $productData);

                $purchasedProductListData = array(
                    'purchased_product_id' => $lastInsertedPurchasedProductId,
                    'product_id' => $this->input->post('productId')[$i],
                    'rate' => $this->input->post('rate')[$i],
                    'qty' => $this->input->post('qty')[$i],
                    'amount' => $this->input->post('amount')[$i],
                );
                $this->db->insert('purchased_product_list', $purchasedProductListData);
            }
        }
    	// Insert Purchased Product List End Here

    	// Update Supplier Start Here
        $supplierInfo = $this->Supplier_model->get_supplier_info_by_id($supplierId);
        $status = 1;

        if ($supplierInfo->advanced_amount > 0) {
            $status = 2;
        }

    	if (!empty($purchaseAmount)) {
    		$supplierInfo->paid_amount += $paidAmount;
    		$supplierInfo->advanced_amount += $paidAmount - $purchaseAmount;

    		if ($supplierInfo->advanced_amount < 0) {
                $supplierInfo->due_amount += abs($supplierInfo->advanced_amount);
                $supplierInfo->advanced_amount = 0;
    		}
    	}

        $supplierData = array(
            'advanced_amount' => $supplierInfo->advanced_amount,
            'paid_amount' => $supplierInfo->paid_amount,
            'due_amount' => $supplierInfo->due_amount,
        );

        $this->db->where('id',$supplierInfo->id);
        $this->db->update('supplier', $supplierData);
    	// Update Supplier End Here
        
    	// Insert Supplier Payment Start Here
        $supplierPaymentData = array(
            'purchased_product_id' => $lastInsertedPurchasedProductId,
            'supplier_id' => $supplierId,
            'user_id' => $userInfo['user_id'],
            'date' => $dateTime,
            'money_receipt_no' => $moneyReceiptNumber,
            'payment_mode' => $paymentMode,
            'status' => $status,
            'previous_amount' => $displayAmount,
            'purchase_amount' => $purchaseAmount,
            'advanced_amount' => $supplierInfo->advanced_amount,
            'paid_amount' => $paidAmount,
            'due_amount' => $supplierInfo->due_amount,
            'money_receipt_image' => $imagePath,
            'remarks' => $remarks,
        );

        $this->db->insert('supplier_payment', $supplierPaymentData);
    	// Insert Supplier Payment End Here

		$this->cart->destroy();

        $this->session->set_flashdata('successMessage', 'Saved Purchased Product Successfully.');
        redirect(base_url("product_purchase"));
    }

    public function edit($categoryId) {
        if (get_user_permission('product_purchase') === false) {
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

    public function update()
    {
        if (get_user_permission('product_purchase') === false) {
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
        if (get_user_permission('product_purchase') === false) {
            redirect(base_url('user_login'));
        }

    	// echo "Dew Hunt"; exit();
    	$purchasedProductId = $this->input->post('purchasedProductId');
        $this->data['companyInfo'] = $this->Company_Model->get_company();
        $this->data['purchasedProductInfo'] = $this->Product_purchase_model->get_purchased_product_by_id($purchasedProductId);
        $this->data['purchasedProductList'] = $this->Product_purchase_model->get_purchased_product_list_by_purchased_product_id($purchasedProductId);

        $output = $this->load->view('product_purchase/purchased_product_info_modal',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }

    public function delete($id)
    {
        if (get_user_permission('product_purchase') === false) {
            redirect(base_url('user_login'));
        }
        $this->Product_type_Model->delete($id);
        redirect(base_url('product_type'));
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
