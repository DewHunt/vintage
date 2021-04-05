<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->library('pagination');
        $this->load->model('Product_Model');
        $this->load->model('User_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Product_reorder_level_Model');
        $this->load->model('Product_type_Model');
        $this->load->model('Company_Model');
    }

    public function index() {  // load product details
        if (get_user_permission('product') === false) {
            redirect(base_url('user_login'));
        }

        $user_info = $this->session->userdata('user_session');
        $user_type = $user_info['user_type'];
        $product_list = $this->Product_Model->get_product();
        $product_type_list = $this->Product_type_Model->get_product_type();
        $company_information = $this->Company_Model->get_company();

        // echo "<pre>"; print_r($product_list); exit();

        $this->data['title'] = "Product";
        $this->data['product_list'] = $product_list;
        $this->data['product_type_list'] = $product_type_list;
        $this->data['company_information'] = $company_information;
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('product/product_details_list', $this->data);
    }

    public function create_new_product() { // load create product page
        if (get_user_permission('product') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "Product";
        $this->data['branch_list'] = $this->Branch_Model->get_branch();
        $this->data['product_type_list'] = $this->Product_type_Model->get_product_type();
        $this->data['unitList'] = $this->Product_Model->get_all_unit();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('product/create_new_product', $this->data);
    }

    public function save_product() {
        if (get_user_permission('product') === false) {
            redirect(base_url('user_login'));
        }
        // echo "<pre>"; print_r($_FILES['productImage']); print_r($this->input->post()); exit();

        $this->form_validation->set_rules('product_name', 'Product Name', 'required');
        $this->form_validation->set_rules('product_code', 'Product Code', 'required');
        $this->form_validation->set_rules('fixed_price', 'Fixed Price', 'required');
        $this->form_validation->set_rules('product_type_id', 'Product Type', 'required');

        if ($this->form_validation->run() === FALSE) {
            redirect(base_url("product/create_new_product"));
        } else {
            $this->data['title'] = 'Create New Product';

            $upload_path = 'assets/uploads/product_images/';
            $link = 'product/create_new_product';
            $imagePath = upload_image('productImage',150,0,0,$upload_path,$link);
            // echo $imagePath; exit();

            $product_name = trim($this->input->post('product_name'));

            $product_info_by_product_name = $this->Product_Model->get_product_info_by_product_name($product_name);

            if ((empty($product_info_by_product_name))) {
                $data = array(
                    'product_name' => $product_name,
                    'product_code' => trim($this->input->post('product_code')),
                    'image' => $imagePath,
                    'hot_kitchen_status' => trim($this->input->post('hotKitchenStatus')),
                    'availability' => trim($this->input->post('availability')),
                    'unit' => trim($this->input->post('unit')),
                    'minimum_price' => trim($this->input->post('minimum_price')),
                    'maximum_price' => trim($this->input->post('maximum_price')),
                    'fixed_price' => trim($this->input->post('fixed_price')),
                    'purchase_price' => trim($this->input->post('purchase_price')),
                    'product_type_id' => trim($this->input->post('product_type_id')),
                    'sort_order' => trim($this->input->post('sort_order')),
                );

                $this->Product_Model->db->insert('product', $data);

                $this->session->set_flashdata('message', 'Product Name Saved Successfully.');
                redirect(base_url('product'));
            } else {
                $this->session->set_flashdata('error', 'Product Name Already Exists.');
                redirect('product/create_new_product');
            }
        }
    }

    public function valid_numeric_number_check($minimum_price, $maximum_price, $fixed_price, $purchase_price, $reorder_level) {
        if (empty($minimum_price) || (!is_numeric($minimum_price))) {
            return FALSE;
        }
        if (empty($maximum_price) || (!is_numeric($maximum_price))) {
            return FALSE;
        }
        if (empty($fixed_price) || (!is_numeric($fixed_price))) {
            return FALSE;
        }
        if (empty($purchase_price) || (!is_numeric($purchase_price))) {
            return FALSE;
        }
        if (empty($reorder_level) || (!is_numeric($reorder_level))) {
            if (($reorder_level == 0)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
        return TRUE;
    }

    public function update_product($id = 0) {  // load update product information page
        if (get_user_permission('product') === false) {
            redirect(base_url('user_login'));
        }
        $product = $this->Product_Model->getProductById($id);
        if (!empty($product)) {
            $this->data['title'] = "Update Product";
            $this->data['product'] = $product;
            $this->data['product_type_list'] = $this->Product_type_Model->get_product_type();
            $this->data['unitList'] = $this->Product_Model->get_all_unit();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('product/update_product', $this->data);
        } else {
            redirect(base_url('product'));
        }
    }

    public function update() {
        if (get_user_permission('product') === false) {
            redirect(base_url('user_login'));
        }
        // echo "<pre>"; print_r($this->input->post()); exit();

        $this->form_validation->set_rules('product_name', 'Product Name', 'required');
        $this->form_validation->set_rules('product_code', 'Product Code', 'required');
        $this->form_validation->set_rules('fixed_price', 'Fixed Price', 'required');
        $this->form_validation->set_rules('product_type_id', 'Product Type', 'required');
        $id = trim($this->input->post('id'));

        if ($this->form_validation->run() === FALSE) {
            redirect(base_url('product/update_product/'.$id));
        } else {
            $this->data['title'] = 'Create New Product';

            if (empty($_FILES['productImage']['name'])) {
                $imagePath = $this->input->post('previousProductImage');
            } else {
                $upload_path = 'assets/uploads/product_images/';
                $link = 'product/update_product/'.$id;
                $imagePath = upload_image('productImage',150,0,0,$upload_path,$link);
            }                

            // echo $imagePath; exit();

            $product_name = trim($this->input->post('product_name'));

            $product_info_by_product_name = $this->Product_Model->get_product_info_by_id_for_duplicate_check($product_name, $id);

            if ((empty($product_info_by_product_name))) {
                $data = array(
                    'product_name' => $product_name,
                    'product_code' => trim($this->input->post('product_code')),
                    'image' => $imagePath,
                    'hot_kitchen_status' => trim($this->input->post('hotKitchenStatus')),
                    'availability' => trim($this->input->post('availability')),
                    'unit' => trim($this->input->post('unit')),
                    'minimum_price' => trim($this->input->post('minimum_price')),
                    'maximum_price' => trim($this->input->post('maximum_price')),
                    'fixed_price' => trim($this->input->post('fixed_price')),
                    'purchase_price' => trim($this->input->post('purchase_price')),
                    'product_type_id' => trim($this->input->post('product_type_id')),
                    'sort_order' => trim($this->input->post('sort_order')),
                );
                $this->db->where('id', $id);
                $this->Product_Model->db->update('product', $data);

                $this->session->set_flashdata('message','Product Name Update Successfully.');
                redirect(base_url('product'));
            } else {
                $this->session->set_flashdata('error','Product Name Already Exists.');
                redirect('product/update_product/'.$id);
            }
        }
    }

    public function searchProduct()
    {
        $output = '';
        $sl = 1;

        $productTypeId = $this->input->post('productTypeId');

        if ($productTypeId == "") {
            $productList = $this->Product_Model->get_product();
        } else {
            $productList = $this->Product_Model->getSearchProductInfoByProductType($productTypeId);
        }

        foreach ($productList as $product) {                                
            $output .= '<tr>';
            $output .= '<td>'.$sl++.'</td>';
            $output .= '<td>'.$product->product_code.'</td>';
            $output .= '<td>'.$product->product_name.'</td>';
            $output .= '<td>'.$product->productTypeName.'</td>';
            $output .= '<td>'.$product->purchase_price.'</td>';
            $output .= '<td>'.$product->minimum_price.'</td>';
            $output .= '<td>'.$product->maximum_price.'</td>';
            $output .= '<td>'.$product->fixed_price.'</td>';
            $output .= '<td class="action-fixed-width">';
            $output .= '<a href="'.base_url("product/update_product/$product->id").'" class="btn btn-primary"><i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>';
            $output .= '<a href="'.base_url("product/delete/$product->id").'" class="btn btn-danger" onclick="return delete_confirm();"><i class="fa fa-times" aria-hidden="true"></i></a>';
            $output .= '</td>';
            $output .= '</tr>';
        }

        echo $output;
    }

    public function delete($id) {
        if (get_user_permission('product') === false) {
            redirect(base_url('user_login'));
        }
        if (intval($id) > 0) {
            $this->Product_Model->delete($id);
        }
        redirect(base_url('product'));
    }

    public function low_stock_product($branch_id = 0) {
        if (get_user_permission('product') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "Low Stock Products";
        $this->data['page_title'] = "Low Stock Products";
        $this->data['branch_list'] = $this->Branch_Model->get_branch();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $branch_id = intval(trim($this->input->post('branch_id')));
        }
        if ($branch_id > 0) {
            $branch = $this->Branch_Model->get_branch($branch_id);
            $branch_name = !empty($branch) ? $branch->branch_name : '';
        } else {
            $branch_name = "All";
        }
        $this->data['branch_id'] = $branch_id;
        $this->data['branch_name'] = $branch_name;
        $this->data['low_stock_product_by_branch_id'] = $this->Product_reorder_level_Model->get_low_stock_product_count_by_branch_id($branch_id);
        if ($this->input->is_ajax_request()) {
            $low_stock_product_list_table = $this->load->view('product/low_stock_product_list_table', $this->data, TRUE);
            set_json_output(array('lowStockProductListTable' => $low_stock_product_list_table));
        } else {
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('product/low_stock_product_list', $this->data);
        }
    }

}
