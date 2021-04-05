<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Item_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Product_store_Model');
        $this->load->model('Branch_stock_Model');
        $this->load->model('Branchwise_product_store_Model');
        $this->load->model('Branch_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
//            $this->stock_correction();
//            echo 'Ok';
//            die();
            $this->data['title'] = "Item Report";
            $this->data['product_list'] = $this->Product_Model->get_product();
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/item_report/item_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function item_report_show() {  //show in table
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $product_id = trim($this->input->post('product_id'));
            $start_date = get_start_date_format(trim($this->input->post('start_date')));
            $end_date = get_end_date_format(trim($this->input->post('end_date')));
            $product_information = $this->Product_Model->get_product($product_id);
            if (!empty($product_information)) {
                $product_name = $product_information->product_name;
            } else {
                $product_name = 'All';
            }
            $item_product_store_report_view = $this->get_item_product_store_report_view($product_id, $start_date, $end_date);
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['product_information'] = $product_information;
            $this->data['product_name'] = $product_name;
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->data['item_product_store_report_view'] = $item_product_store_report_view;
            $this->load->view('reports/item_report/item_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_item_product_store_report_view($product_id, $start_date, $end_date) {
        if ((int) $product_id > 0) {
            $where_condition = "WHERE ps.product_id = '$product_id' AND ps.product_store_date >= '$start_date' AND ps.product_store_date <= '$end_date'";
        } else {
            $where_condition = "WHERE ps.product_store_date >= '$start_date' AND ps.product_store_date <= '$end_date'";
        }
        $item_product_store_report_list = $this->db->query("SELECT ps.id, ps.product_store_date,ps.product_id,ps.open_stock,ps.receive_stock,ps.transfer_stock,ps.sale_from_stock, ps.damage_stock, ps.closing_stock, p.product_name FROM product_store ps JOIN product p ON ps.product_id=p.id $where_condition");
        return $item_product_store_report_list->result();
    }

    //work for stock correction
    public function stock_correction() {
        $product_list = $this->db->query("SELECT * FROM product ORDER BY id ASC")->result();
        $sum_of_stock = 0;
        foreach ($product_list as $product) {
            $product_id = $product->id;
            $branch_stock_list_by_product_id = $this->Branch_stock_Model->get_branch_stock_by_product_id($product_id);
            $sum_of_stock = 0;
            foreach ($branch_stock_list_by_product_id as $branch_stock) {
                if ((int) $branch_stock->stock >= 0) {
                    $sum_of_stock += intval($branch_stock->stock);
                }
            }
            //product stock save in product
            $product_data = array(
                'id' => $product_id,
                'product_stock' => $sum_of_stock,
            );
            $this->db->where('id', $product_data['id']);
            $this->Product_Model->db->update('product', $product_data);

            //product store save
            $date = date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d'))));
            $product_store_data = array(
                'product_store_date' => $date,
                'product_id' => $product_id,
                'open_stock' => $sum_of_stock,
                'receive_stock' => 0,
                'transfer_stock' => 0,
                'sale_from_stock' => 0,
                'damage_stock' => 0,
                'closing_stock' => $sum_of_stock,
            );
            $this->Product_store_Model->db->insert('product_store', $product_store_data);



            foreach ($branch_stock_list_by_product_id as $branch_stock) {
                $branchwise_product_store_data = array(
                    'product_store_date' => $date,
                    'product_id' => $product_id,
                    'branch_id' => $branch_stock->branch_id,
                    'open_stock' => ((int) $branch_stock->stock >= 0) ? $branch_stock->stock : 0,
                    'receive_stock' => 0,
                    'transfer_stock' => 0,
                    'sale_from_stock' => 0,
                    'damage_stock' => 0,
                    'closing_stock' => ((int) $branch_stock->stock >= 0) ? $branch_stock->stock : 0,
                );
                $this->Branchwise_product_store_Model->db->insert('branchwise_product_store', $branchwise_product_store_data);
            }
//            echo '<pre>';
//            print_r($branch_stock_list_by_product_id);
//            echo '</pre>';
//            die();
        }
    }

}
