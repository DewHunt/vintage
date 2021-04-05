<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Recipe extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->library('pagination');
        $this->load->model('User_Model');
        $this->load->model('Product_type_Model');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('Recipe_model');
    }

    public function index() {
        if (get_user_permission('recipe/add') === false) {
            redirect(base_url('user_login'));
        }
    	$this->data['title'] = "Recipe List";
        // $this->data['recipeList'] = $this->Recipe_model->get_all_recipe();
        // $this->data['productList'] = $this->Product_Model->get_all_purchased_product();

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('recipe/index', $this->data);
    }

    public function add() {
        if (get_user_permission('recipe/add') === false) {
            redirect(base_url('user_login'));
        }

        $productTypeList = $this->Product_type_Model->get_all_product_type();
        // echo "<pre>"; print_r($allProduct); exit();

        $this->data['title'] = "Add Recipe";
        $this->data['productTypeList'] = $productTypeList;
        
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('recipe/add', $this->data);
    }

    public function add_recipe() {
    	// echo "<pre>"; print_r($this->input->post()); exit();
    	$product_type_id = $this->input->post('rawProductTypeId');
    	$product_id = $this->input->post('rawProductId');
    	$unit = $this->input->post('unit');
    	$qty = $this->input->post('qty');

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
            'unit' => $product_info->unit
        );

    	if ($isExists == true) {
			$data['rowid'] = $rowid;
    		$this->cart->update($data);
    	}
    	else {
        	$this->cart->insert($data);
    	}

    	// echo "<pre>"; print_r($data); exit();
        $table_body = $this->load->view('recipe/recipe_table_body','',true);
        $table_footer = $this->load->view('recipe/recipe_table_footer','',true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'table_body' => $table_body,
            'table_footer' => $table_footer,
        )));
    }

    public function get_recipe_info_by_parent_product_id()
    {
    	$parentProductId = $this->input->post('productId');

    	$recipeInfo = $this->Recipe_model->get_recipe_info_by_parent_product_id($parentProductId);

    	if ($recipeInfo) {
    		$this->cart->destroy();

	    	foreach ($recipeInfo as $recipe) {
		        $data = array(
		            'id' => $recipe->child_product_id,
		            'qty' => $recipe->qty,
		            'price' => 1,
		            'name' => $recipe->productName,
		            'unit' => $recipe->productUnit
		        );

	        	$this->cart->insert($data);
    		}
    	}

        $table_body = $this->load->view('recipe/recipe_table_body','',true);
        $table_footer = $this->load->view('recipe/recipe_table_footer','',true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'table_body' => $table_body,
            'table_footer' => $table_footer,
        )));
    }

    public function save() {
        if (get_user_permission('recipe/add') === false) {
            redirect(base_url('user_login'));
        }

    	// echo "<pre>"; print_r($this->input->post()); exit();
        $userInfo = $this->session->userdata('user_session');
    	$parentProductId = $this->input->post('product');
    	$recipeInfo = $this->Recipe_model->get_recipe_info_by_parent_product_id($parentProductId);


        if ($this->input->post('productId')) {
            $countProduct = count($this->input->post('productId'));
        	for ($i=0; $i < $countProduct; $i++) {
        		$recipeData = array(
        			'user_id' => $userInfo->id,
                    'parent_product_id' => $parentProductId,
        			'child_product_id' => $this->input->post('productId')[$i],
        			'qty' => $this->input->post('qty')[$i],
        		);

	        	if ($recipeInfo) {
	        		$isExists = false;
	        		foreach ($recipeInfo as $recipe) {
	        			if ($recipe->parent_product_id == $parentProductId && $recipe->child_product_id == $this->input->post('productId')[$i]) {
	        				$isExists = true;

	        				$this->db->where('id',$recipe->id);
	        				$this->db->update('recipe',$recipeData);
	        				break;
	        			}
	        		}

        			if ($isExists == false) {
        				$this->db->insert('recipe',$recipeData);
        			}
	        	}
	        	else {
	        		$this->db->insert('recipe', $recipeData);
	        	}
        	}
        }

        if ($recipeInfo) {
        	foreach ($recipeInfo as $recipe) {
        		$isExists = false;
        		for ($i=0; $i < $countProduct; $i++) { 
        			if ($recipe->parent_product_id == $parentProductId && $recipe->child_product_id == $this->input->post('productId')[$i]) {
        				$isExists = true;
        				break;
        			}
        		}

        		if ($isExists == false) {
        			$this->db->delete('recipe', array('id' => $recipe->id));
        		}
        	}
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }

    public function edit($categoryId) {
        if (get_user_permission('recipe/add') === false) {
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
        if (empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('settings_access')) == FALSE)) {
        	redirect(base_url('user_login'));
        }
        else {
	    	echo "<pre>"; print_r($this->input->post()); exit();

	        $this->data['title'] = "Edit Category";
	    }
    }

    public function view()
    {
        if (get_user_permission('recipe/add') === false) {
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

    public function get_product_info_by_product_type()
    {
    	$output = "";
    	$productTypeId = $this->input->post('productTypeId');
    	$section = $this->input->post('section');

    	if ($section == 'item') {
    		$id = 'product';
    		$name = 'product';
    	}
    	else {
			$id = 'rawProduct';
			$name = 'rawProduct';
    	}

    	if ($productTypeId) {
	    	$productList = $this->Product_Model->getSearchProductInfoByProductType($productTypeId);
	        $output .= "<select class='form-control select2' id=".$id." name=".$name.">";
	            $output .= "<option value=''>Select Product</option>";
		    	foreach ($productList as $product) {
		            $output .= "<option value='".$product->id."'>".$product->product_name."</option>";
		    	}
	        $output .= "</select>";
    	}
    	else {
	        $output .= "<select class='form-control select2' id=".$id." name=".$name.">";
	            $output .= "<option value=''>Select Product</option>";
	        $output .= "</select>";
    	}

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }

    public function get_product_info()
    {
    	$productId = $this->input->post('productId');
    	$productInfo = $this->Product_Model->getProductById($productId);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'unit' => $productInfo->unit,
        )));
    }

    public function delete($id)
    {
        if (get_user_permission('recipe/add') === false) {
            redirect(base_url('user_login'));
        }
        
        $this->Recipe_model->delete($id);
        redirect(base_url('recipe'));
    }

    public function destroy_session_item_info()
    {
    	$cartRowId =  $this->input->post('cartRowId');

    	if (empty($cartRowId)) {
    		$this->cart->destroy();
    	}
    	else {
    		$this->cart->remove($this->input->post('cartRowId'));
    	}

        $table_body = $this->load->view('recipe/recipe_table_body','',true);
        $table_footer = $this->load->view('recipe/recipe_table_footer','',true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'table_body' => $table_body,
            'table_footer' => $table_footer,
        )));
    }
}
