<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Damage_or_defect_product extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Product_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Product_receive_Model');
        $this->load->model('Stock_transfer_challan_Model');
        $this->load->model('Stock_transfer_Model');
        $this->load->model('Branch_stock_Model');
        $this->load->model('Branchwise_product_store_Model');
        $this->load->model('Product_store_Model');
        $this->load->model('Damage_or_defect_product_info_Model');
        $this->load->model('Damage_or_defect_product_details_Model');

        if (get_menu_permission('factory_access') == false) {
            redirect(base_url());
        }
    }

    public function index() {
        if (get_user_permission('damage_or_defect_product') === false) {
            redirect(base_url('user_login'));
        }
        $user_info = $this->session->userdata('user_session');
        $factoryStatus = 1;
        $hotKitchenStatus = 0;

        $product_list = $this->Product_Model->get_product();
        $branch_list = $this->Branch_Model->get_any_type_branch_by_id($user_info['outlet'],'AND',$factoryStatus,$hotKitchenStatus);

        $this->data['title'] = "Company";
        $this->data['product_list'] = $product_list;
        $this->data['branch_list'] = $branch_list;

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('damage_or_defect_product/damage_or_defect_product', $this->data);
    }

    public function add_damage_or_defect_product_details_in_table() { //add damage or defect product in table
        if (get_user_permission('damage_or_defect_product') === false) {
            redirect(base_url('user_login'));
        }
        if ($this->input->is_ajax_request()) {
            $product_id = trim($this->input->post('product_id'));
            $quantity = trim($this->input->post('quantity'));
            if (empty($product_id) || empty($quantity)) {
                echo '<div class="error-message text-align-center">Please select product and input quantity.</div>';
                $product_list = $this->Product_Model->get_product();
                $this->data['product_list'] = $product_list;
                $this->load->view('damage_or_defect_product/damage_or_defect_product_table', $this->data);
            } else {
                $damage_or_defect_product_table_array_info = $this->session->userdata('damage_or_defect_product_table_array');
                $damage_or_defect_product_table_array = $damage_or_defect_product_table_array_info;

                $product = $this->Product_Model->getProductById($product_id);
                $damage_or_defect_product_details = array(
                    'array_id' => time(),
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'pack_size' => $product->pack_size,
                    'quantity' => $quantity,
                    'purchase_price' => $product->purchase_price,
                );
                if (!empty($damage_or_defect_product_table_array_info)) {
                    array_push($damage_or_defect_product_table_array, $damage_or_defect_product_details);
                } else {
                    $damage_or_defect_product_table_array = array();
                    array_push($damage_or_defect_product_table_array, $damage_or_defect_product_details);
                }

                $this->session->set_userdata('damage_or_defect_product_table_array', $damage_or_defect_product_table_array);
                $product_list = $this->Product_Model->get_product();
                
                $this->data['product_list'] = $product_list;
                $this->load->view('damage_or_defect_product/damage_or_defect_product_table', $this->data);
            }
        } else {
            redirect(base_url('damage_or_defect_product'));
        }
    }

    public function delete_damage_or_defect_product_details_from_table($array_id = 0) { //delete damage or defect product from table
        if (get_user_permission('damage_or_defect_product') === false) {
            redirect(base_url('user_login'));
        }

        $damage_or_defect_product_table_array = $this->session->userdata('damage_or_defect_product_table_array');
        if ((!empty($damage_or_defect_product_table_array))) {
            $product_array = array();
            foreach ($damage_or_defect_product_table_array as $product) {
                if ($array_id != $product['array_id']) {
                    array_push($product_array, $product);
                }
            }
            $this->session->set_userdata('damage_or_defect_product_table_array', $product_array);
            $this->session->userdata('damage_or_defect_product_table_array');
            redirect('damage_or_defect_product');
        } else {
            redirect('damage_or_defect_product');
        }
    }

    public function save_damage_or_defect_product_information() {
        if (get_user_permission('damage_or_defect_product') === false) {
            redirect(base_url('user_login'));
        }
        
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id']; // session user id
        $damage_or_defect_date = trim($this->input->post('damage_or_defect_date'));

        date_default_timezone_set("Asia/Dhaka");
        $damage_or_defect_date = date($damage_or_defect_date . ' H:i:s');

        $branch_id = trim($this->input->post('branch_id'));
        $reason = trim($this->input->post('reason'));
        $this->form_validation->set_rules('damage_or_defect_date', 'Date', 'required');
        $this->form_validation->set_rules('branch_id', 'Outlet', 'required');
        $this->form_validation->set_rules('reason', 'Reason', 'required');

        if ($this->form_validation->run() === FALSE) {
            $product_list = $this->Product_Model->get_product();
            $branch_list = $this->Branch_Model->get_branch();
            $this->data['product_list'] = $product_list;
            $this->data['branch_list'] = $branch_list;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('damage_or_defect_product/damage_or_defect_product', $this->data);
        } else {
            $damage_or_defect_product_table_array = $this->session->userdata('damage_or_defect_product_table_array');

            if (!empty($damage_or_defect_product_table_array)) {

                $this->is_insufficient_branch_stock_check($damage_or_defect_product_table_array, $branch_id);

                $this->damage_or_defect_product_information_save($damage_or_defect_product_table_array, $branch_id, $damage_or_defect_date, $reason, $user_id);
                $this->session->unset_userdata('damage_or_defect_product_table_array');
                $this->session->set_flashdata('damage_or_defect_product_table_save_message', 'Information has been saved successfully.');
                redirect('damage_or_defect_product');
            } else {
                $this->session->set_flashdata('damage_or_defect_product_table_error_message', 'Please Insert Product in Table First.');
                redirect('damage_or_defect_product');
            }
        }
    }

    public function is_insufficient_branch_stock_check($damage_or_defect_product_table_array, $branch_id) {
        if (!empty($damage_or_defect_product_table_array)) {
            foreach ($damage_or_defect_product_table_array as $damage_or_defect_product) {
                $branch_stock_by_product_id_branch_id = $this->Branch_stock_Model->get_branch_stock_by_product_id_branch_id($damage_or_defect_product['product_id'], $branch_id);
                if (!empty($branch_stock_by_product_id_branch_id)) {

                    if (((int) $branch_stock_by_product_id_branch_id->stock) < (int) ($damage_or_defect_product['quantity'])) {
                        $this->session->set_flashdata('stock_insufficient_message', $damage_or_defect_product['product_name'] . ' ' . 'Stock Insufficient.');
                        redirect('damage_or_defect_product');
                    }
                } else {
                    $this->session->set_flashdata('stock_insufficient_message', $damage_or_defect_product['product_name'] . ' ' . 'Stock Insufficient');
                    redirect('damage_or_defect_product');
                }
            }
        }
    }

    public function damage_or_defect_product_information_save($damage_or_defect_product_table_array, $branch_id, $damage_or_defect_date, $reason, $user_id) {
        $currently_inserted_damage_or_defect_product_info_id = $this->save_damage_or_defect_product_info($branch_id, $damage_or_defect_date, $reason, $user_id);
        if (!empty($currently_inserted_damage_or_defect_product_info_id) && ((int) $currently_inserted_damage_or_defect_product_info_id > 0)) {
            $this->save_damage_or_defect_product_details($damage_or_defect_product_table_array, $currently_inserted_damage_or_defect_product_info_id, $branch_id, $damage_or_defect_date);
        }
    }

    public function save_damage_or_defect_product_info($branch_id, $damage_or_defect_date, $reason, $user_id) {
        $data = array(
            'branch_id' => $branch_id,
            'damage_or_defect_date' => $damage_or_defect_date,
            'reason' => $reason,
            'user_id' => $user_id,
        );
        $this->Damage_or_defect_product_info_Model->db->insert('damage_or_defect_product_info', $data);
        $currently_inserted_damage_or_defect_product_info_id = $this->db->insert_id();
        return $currently_inserted_damage_or_defect_product_info_id;
    }

    public function save_damage_or_defect_product_details($damage_or_defect_product_table_array, $currently_inserted_damage_or_defect_product_info_id, $branch_id, $damage_or_defect_date) {
        if (!empty($damage_or_defect_product_table_array)) {
            $damage_or_defect_date = date('Y-m-d', strtotime($damage_or_defect_date));
            foreach ($damage_or_defect_product_table_array as $damage_or_defect_product) {

                $this->update_branch_stock_information($damage_or_defect_product['product_id'], $branch_id, $damage_or_defect_product['quantity']);

                $this->branchwise_product_store_save($damage_or_defect_product['product_id'], $damage_or_defect_product['quantity'], $branch_id, $damage_or_defect_date);

                $this->product_store_save($damage_or_defect_product['product_id'], $damage_or_defect_product['quantity'], $damage_or_defect_date);

                $this->update_stock_in_product($damage_or_defect_product['product_id'], $damage_or_defect_product['quantity']);

                $data = array(
                    'product_id' => $damage_or_defect_product['product_id'],
                    'packsize' => $damage_or_defect_product['pack_size'],
                    'quantity' => $damage_or_defect_product['quantity'],
                    'purchase_price' => $damage_or_defect_product['purchase_price'],
                    'damage_or_defect_product_info_id' => $currently_inserted_damage_or_defect_product_info_id,
                );
                $this->Damage_or_defect_product_details_Model->db->insert('damage_or_defect_product_details', $data);
            }
        }
    }

    public function update_branch_stock_information($product_id, $branch_id, $quantity) {
        $branch_stock_by_product_id_branch_id = $this->Branch_stock_Model->get_branch_stock_by_product_id_branch_id($product_id, $branch_id);
        if (!empty($branch_stock_by_product_id_branch_id)) {
            $data = array(
                'id' => $branch_stock_by_product_id_branch_id->id,
                'product_id' => $product_id,
                'branch_id' => $branch_id,
                'stock' => ((int) $branch_stock_by_product_id_branch_id->stock) - ((int) $quantity),
            );
            $this->db->where('id', $data['id']);
            $this->Branch_stock_Model->db->update('branch_stock', $data);
        }
    }

    public function branchwise_product_store_save($product_id, $quantity, $branch_id, $date) {
        $branchwise_product_store_by_date = $this->Branchwise_product_store_Model->get_branchwise_product_store_by_date($date, $product_id, $branch_id);
        if (!empty($branchwise_product_store_by_date)) {
            $open_stock = (int) $branchwise_product_store_by_date->open_stock;
            $receive_stock = (int) $branchwise_product_store_by_date->receive_stock;
            $transfer_stock = (int) $branchwise_product_store_by_date->transfer_stock;
            $sale_from_stock = (int) $branchwise_product_store_by_date->sale_from_stock;
            $damage_stock = (int) $branchwise_product_store_by_date->damage_stock + (int) $quantity;
            $closing_stock = (int) ($open_stock + $receive_stock - $transfer_stock - $sale_from_stock - $damage_stock);
            $branchwise_product_store_data = array(
                'id' => $branchwise_product_store_by_date->id,
                'product_store_date' => $date,
                'product_id' => $product_id,
                'branch_id' => $branch_id,
                'open_stock' => $open_stock,
                'receive_stock' => $receive_stock,
                'transfer_stock' => $transfer_stock,
                'sale_from_stock' => $sale_from_stock,
                'damage_stock' => $damage_stock,
                'closing_stock' => $closing_stock,
            );
            $this->db->where('id', $branchwise_product_store_data['id']);
            $this->Branchwise_product_store_Model->db->update('branchwise_product_store', $branchwise_product_store_data);
        } else {
            $current_date = get_current_date();
            $branchwise_product_store_from_previous_date = $this->Branchwise_product_store_Model->get_branchwise_product_store_from_previous_date_by_product_id_branch_id($current_date, $product_id, $branch_id);
            if (!empty($branchwise_product_store_from_previous_date)) {
                $open_stock = (int) $branchwise_product_store_from_previous_date->closing_stock;
            } else {
                $open_stock = 0;
            }
            $receive_stock = 0;
            $transfer_stock = 0;
            $sale_from_stock = 0;
            $damage_stock = (int) $quantity;
            $closing_stock = (int) ($open_stock + $receive_stock - $transfer_stock - $sale_from_stock - $damage_stock);
            $branchwise_product_store_data = array(
                'product_store_date' => $date,
                'product_id' => $product_id,
                'branch_id' => $branch_id,
                'open_stock' => $open_stock,
                'receive_stock' => $receive_stock,
                'transfer_stock' => $transfer_stock,
                'sale_from_stock' => $sale_from_stock,
                'damage_stock' => $damage_stock,
                'closing_stock' => $closing_stock,
            );
            $this->Branchwise_product_store_Model->db->insert('branchwise_product_store', $branchwise_product_store_data);
        }
    }

    public function product_store_save($product_id, $quantity, $date) {
        $product_store_by_date = $this->Product_store_Model->get_product_store_by_date($product_id, $date);
        if (!empty($product_store_by_date)) {
            $open_stock = (int) $product_store_by_date->open_stock;
            $receive_stock = (int) $product_store_by_date->receive_stock;
            $transfer_stock = (int) $product_store_by_date->transfer_stock;
            $sale_from_stock = (int) $product_store_by_date->sale_from_stock;
            $damage_stock = (int) $product_store_by_date->damage_stock + (int) $quantity;
            $closing_stock = (int) ($open_stock + $receive_stock - $transfer_stock - $sale_from_stock - $damage_stock);
            $product_store_data = array(
                'id' => $product_store_by_date->id,
                'product_store_date' => $date,
                'product_id' => $product_id,
                'open_stock' => $open_stock,
                'receive_stock' => $receive_stock,
                'transfer_stock' => $transfer_stock,
                'sale_from_stock' => $sale_from_stock,
                'damage_stock' => $damage_stock,
                'closing_stock' => $closing_stock,
            );
            $this->db->where('id', $product_store_data['id']);
            $this->Product_store_Model->db->update('product_store', $product_store_data);
        } else {
            $current_date = get_current_date();
            $product_store_from_previous_date = $this->Product_store_Model->get_product_store_from_previous_date_by_product_id($current_date, $product_id);
            if (!empty($product_store_from_previous_date)) {
                $open_stock = (int) $product_store_from_previous_date->closing_stock;
            } else {
                $open_stock = 0;
            }
            $receive_stock = 0;
            $transfer_stock = 0;
            $sale_from_stock = 0;
            $damage_stock = (int) $quantity;
            $closing_stock = (int) ($open_stock + $receive_stock - $transfer_stock - $sale_from_stock - $damage_stock);
            $product_store_data = array(
                'product_store_date' => $date,
                'product_id' => $product_id,
                'open_stock' => $open_stock,
                'receive_stock' => $receive_stock,
                'transfer_stock' => $transfer_stock,
                'sale_from_stock' => $sale_from_stock,
                'damage_stock' => $damage_stock,
                'closing_stock' => $closing_stock,
            );
            $this->Product_store_Model->db->insert('product_store', $product_store_data);
        }
    }

    public function update_stock_in_product($product_id, $quantity) {
        if (!empty($product_id) && !empty($quantity)) {
            $product_information = $this->Product_Model->get_product($product_id);
            if (!empty($product_information)) {
                $product_data = array(
                    'id' => $product_id,
                    'product_stock' => (int) $product_information->product_stock - (int) $quantity,
                );
                $this->db->where('id', $product_data['id']);
                $this->Product_Model->db->update('product', $product_data);
            }
        }
    }

}
