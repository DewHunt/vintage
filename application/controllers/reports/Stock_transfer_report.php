<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_transfer_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Branch_stock_Model');
        $this->load->model('Product_receive_Model');
        $this->load->model('Stock_transfer_Model');
        $this->load->model('Stock_transfer_challan_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $this->data['title'] = "Stock Transfer Report";
            $branch_list = $this->Branch_Model->get_branch();
            $this->data['branch_list'] = $branch_list;
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/stock_transfer_report/stock_transfer_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function stock_transfer_report_show() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $branch_id = $this->input->post('branch_id');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $company_information = $this->Company_Model->get_company();
            $branch_information = $this->Branch_Model->get_branch($branch_id);
            if (!empty($branch_information)) {
                $branch_name = $branch_information->branch_name;
            } else {
                $branch_name = 'All';
            }
            $stock_transfer_report_view = $this->stock_transfer_report_view($branch_id, $start_date, $end_date);
            $this->data['company_information'] = $company_information;
            $this->data['branch_information'] = $branch_information;
            $this->data['branch_name'] = $branch_name;
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->data['stock_transfer_report_view'] = $stock_transfer_report_view;
            $this->load->view('reports/stock_transfer_report/stock_transfer_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function stock_transfer_report_view($branch_id, $start_date, $end_date) {
        if ($branch_id <= 0 || $branch_id == '') {
            $where_condition = "WHERE st.date_of_transfer >= '$start_date' AND st.date_of_transfer <= '$end_date'";
        } else {
            $where_condition = "WHERE st.date_of_transfer >= '$start_date' AND st.date_of_transfer <= '$end_date' AND st.from_branch_id='$branch_id'";
        }
        $stock_transfer_report_list = $this->db->query("SELECT st.id, st.from_branch_id, st.to_branch_id, st.product_id, st.quantity, st.date_of_transfer, st.transfer_reason,st.user_id, b.branch_name AS from_branch, (SELECT branch_name FROM branch_info WHERE id=st.to_branch_id) AS to_branch, p.product_name, u.user_name, stc.challan_number FROM stock_transfer st JOIN branch_info b ON st.from_branch_id = b.id JOIN product p ON st.product_id=p.id LEFT JOIN user_info u ON st.user_id=u.id LEFT JOIN stock_transfer_challan stc ON st.stock_transfer_challan_id=stc.id $where_condition");
        return $stock_transfer_report_list->result();
    }

}
