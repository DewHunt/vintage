<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_type extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->library('pagination');
        $this->load->model('User_Model');
        $this->load->model('Product_type_Model');
        $this->load->model('Printer_setup_model');
    }

    public function index() {
        if (get_user_permission('product_type') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "Category List";
        $this->data['productTypeList'] = $this->Product_type_Model->get_all_product_type();

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('productType/index', $this->data);
    }

    public function add() {
        if (get_user_permission('product_type') === false) {
            redirect(base_url('user_login'));
        }
        $allPrinters = $this->Printer_setup_model->get_all_printer();

        $this->data['title'] = "Add Category";
        $this->data['allPrinters'] = $allPrinters;
        
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('productType/add', $this->data);
    }

    public function save()
    {
        if (get_user_permission('product_type') === false) {
            redirect(base_url('user_login'));
        }
    	// echo "<pre>"; print_r($this->input->post()); exit();

    	$this->form_validation->set_rules('name', 'Category Name','required');
    	$this->form_validation->set_rules('foodType', 'Food Type','required');

        if ($this->form_validation->run() === FALSE) {
        	redirect(base_url("product_type/add"));
        }

    	$name = trim($this->input->post('name'));
        $isExists = $this->Product_type_Model->isCategoryNameExists($name);

        if (!empty($isExists)) {
            $this->session->set_flashdata('error', 'Category Name Already Exists.');
            redirect(base_url("product_type/add"));
        }

        $upload_path = 'assets/uploads/category_images/';
        $link = 'product_type/add';
        $imagePath = upload_image('categoryImage',150,0,0,$upload_path,$link);

        $categoryData = array(
            'printer_id' => $this->input->post('printerId'),
            'product_type_name' => $name,
            'food_type' => trim($this->input->post('foodType')),
            'image' => $imagePath,
            'availability' => trim($this->input->post('availability')),
            'button_color' => trim($this->input->post('buttonColor')),
            'sort_order' => trim($this->input->post('sortOrder')),
        );

        $this->Product_type_Model->db->insert('product_type', $categoryData);
        $this->session->set_flashdata('successMessage', 'Category Name Saved Successfully.');
        redirect(base_url("product_type"));
    }

    public function edit($categoryId) {
        if (get_user_permission('product_type') === false) {
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
        if (get_user_permission('product_type') === false) {
            redirect(base_url('user_login'));
        }
    	// echo "<pre>"; print_r($this->input->post()); exit();

        $this->data['title'] = "Edit Category";
	    $categoryId = trim($this->input->post('categoryId'));

    	$this->form_validation->set_rules('name', 'Category Name','required');
    	$this->form_validation->set_rules('foodType', 'Food Type','required');

        if ($this->form_validation->run() === FALSE) {
        	redirect(base_url('product_type/edit/'.$categoryId));
        }

    	$name = trim($this->input->post('name'));
        $isExists = $this->Product_type_Model->isCategoryNameExistsById($name,$categoryId);

        if (!empty($isExists)) {
            $this->session->set_flashdata('error', 'Category Name Already Exists.');
            redirect(base_url("product_type/edit/$categoryId"));
        }

        if (empty($_FILES['categoryImage']['name'])) {
            $imagePath = $this->input->post('previousCategoryImage');
        } else {
            $upload_path = 'assets/uploads/category_images/';
            $link = 'product_type/edit/'.$categoryId;
            $imagePath = upload_image('categoryImage',150,0,0,$upload_path,$link);
        } 

        $categoryData = array(
            'printer_id' => $this->input->post('printerId'),
            'product_type_name' => $name,
            'food_type' => trim($this->input->post('foodType')),
            'image' => $imagePath,
            'availability' => trim($this->input->post('availability')),
            'button_color' => trim($this->input->post('buttonColor')),
            'sort_order' => trim($this->input->post('sortOrder')),
        );

        $this->db->where('id', $categoryId);
        $this->Product_type_Model->db->update('product_type', $categoryData);
        $this->session->set_flashdata('successMessage', 'Category Name Update Successfully.');
        redirect(base_url('product_type'));
    }

    public function delete($id) {
        if (get_user_permission('product_type') === false) {
            redirect(base_url('user_login'));
        }
        $this->Product_type_Model->delete($id);
        redirect(base_url('product_type'));
    }
}
