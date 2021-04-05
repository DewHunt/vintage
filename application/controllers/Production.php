<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Production extends CI_Controller {

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
        $this->load->model('Recipe_model');
        $this->load->model('Production_model');

        $userInfo = $this->session->userdata('user_session');
        $userType = $userInfo['user_type'];

        if (get_menu_permission('factory_access') == false)
        {
            return redirect(base_url('user_login'));
        }
    }

    public function index() {
        if (get_user_permission('production') === false) {
            redirect(base_url('user_login'));
        }
        
    	$this->data['title'] = "Production List";
        $this->data['productionList'] = $this->Production_model->get_all_production();

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('production/index', $this->data);
    }

    public function add() {
        if (get_user_permission('production') === false) {
            redirect(base_url('user_login'));
        }
        
        $allProduct = $this->Product_Model->get_product();
        // echo "<pre>"; print_r($allProduct); exit();

        $this->data['title'] = "Add Production";
        $this->data['allProduct'] = $allProduct;
        
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('production/add', $this->data);
    }

    public function add_production_product()
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
        $table_body = $this->load->view('production/production_table_body','',true);
        $table_footer = $this->load->view('production/production_table_footer','',true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'table_body' => $table_body,
            'table_footer' => $table_footer,
        )));
    }

    public function save()
    {
        if (get_user_permission('production') === false) {
            redirect(base_url('user_login'));
        }
        
    	// echo "<pre>"; print_r($this->input->post()); exit();

    	$batch_no = $this->input->post('batchNumber');
    	$date = $this->input->post('date');
    	$expire_date = $this->input->post('expireDate');
    	$total_item = $this->input->post('total_item');
    	$total_qty = $this->input->post('total_qty');
    	$remarks = $this->input->post('remarks');

        $userInfo = $this->session->userdata('user_session');

		date_default_timezone_set("Asia/Dhaka");
		$currentTime = date("h:i:s");
    	$dateTime = $date." ".$currentTime;
    	$expireDateTime = $expire_date." ".$currentTime;

        $productionData = array(
            'user_id' => $userInfo['user_id'],
            'batch_no' => $batch_no,
            'date' => $dateTime,
            'expire_date' => $expireDateTime,
            'total_item' => $total_item,
            'total_qty' => $total_qty,
            'remarks' => $remarks,
            'create_time' => date("Y-m-d h:i:s"),
        );

        $this->db->insert('production', $productionData);
        $lastInsertedProductionId = $this->db->insert_id();

        if ($this->input->post('productId')) {
        	$countProduct = count($this->input->post('productId'));
            for ($i = 0; $i < $countProduct; $i++) {
            	$productId = $this->input->post('productId')[$i];
            	$qty = $this->input->post('qty')[$i];

                $parentProductInfo = $this->Product_Model->getProductById($productId);

            	$parentProductData = array(
            		'product_stock' => $parentProductInfo->product_stock + $qty,
            	);

                $this->db->where('id',$productId);
                $this->db->update('product', $parentProductData);

            	$recipeInfo = $this->Recipe_model->get_recipe_info_by_parent_product_id($productId);

            	if ($recipeInfo) {
                	foreach ($recipeInfo as $recipe) {
                		$newQty = $recipe->qty * $qty;
                		$productInfo = $this->Product_Model->getProductById($recipe->child_product_id);

	                	$productData = array(
	                		'product_stock' => $productInfo->product_stock - $newQty,
	                	);

		                $this->db->where('id',$recipe->child_product_id);
		                $this->db->update('product', $productData);
                	}
            	}

                $productionProductListData = array(
                    'production_id' => $lastInsertedProductionId,
                    'product_id' => $productId,
                    'qty' => $qty,
                );
                $this->db->insert('production_product_list', $productionProductListData);
            }
        }

		$this->cart->destroy();

        $this->session->set_flashdata('successMessage', 'Production Saved Successfully.');
        redirect(base_url("production"));
    }

    public function edit($categoryId) {
        if (get_user_permission('production') === false) {
            redirect(base_url('user_login'));
        }

        if (empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == FALSE)) {
        	redirect(base_url('user_login'));
        }
        else {
	    	$category = $this->Product_type_Model->getCategoryInfoById($categoryId);
	        $allPrinters = $this->Printer_setup_model->get_all_printer();

	        $this->data['title'] = "Edit Category";
	        $this->data['category'] = $category;
	        $this->data['allPrinters'] = $allPrinters;
	        
	        $this->load->view('header');
	        $this->load->view('navigation');
	        $this->load->view('productType/edit', $this->data);
	    }
    }

    public function update()
    {
        if (get_user_permission('production') === false) {
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
        if (get_user_permission('production') === false) {
            redirect(base_url('user_login'));
        }
        
    	// echo "Dew Hunt"; exit();
    	$productionId = $this->input->post('productionId');
        $this->data['companyInfo'] = $this->Company_Model->get_company();
        $this->data['productionInfo'] = $this->Production_model->get_production_by_id($productionId);
        $this->data['productionProductList'] = $this->Production_model->get_production_product_list_by_production_id($productionId);

        $output = $this->load->view('production/production_product_info_modal',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }

    public function delete($id)
    {
        if (get_user_permission('production') === false) {
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
