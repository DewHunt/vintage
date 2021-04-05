<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Periodic_sales_details_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Payment_Model');
        $this->load->model('Invoice_details_Model');
        $this->load->model('Client_Model');
        $this->load->model('Dealer_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Sale_product_Model');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Branch_Model');
    }

    public function index() {
        if (get_user_permission('reports/periodic_sales_details_report') === false) {
            redirect(base_url('user_login'));
        }
        $user_info = $this->session->userdata('user_session');
        // echo "<pre>"; print_r($user_info); exit();
        $user_id = $user_info['user_id'];
        $user_type = $user_info['user_type'];

        $this->data['title'] = "Periodice Sales Details Report";
        $payment_list = $this->Payment_Model->get_payment();
        $this->data['payment_list'] = $payment_list;
        // $periodic_report_list = $this->periodic_report_view();
        // $this->data['periodic_report_list'] = $periodic_report_list;

        $factoryStatus = 0;
        $hotKitchenStatus = 0;
        // $this->data['branch_list'] = $this->Branch_Model->get_only_all_branch_by_id($user_info['outlet'],0);
        $this->data['branch_list'] = $this->Branch_Model->get_any_type_branch_by_id($user_info['outlet'],'AND',$factoryStatus,$hotKitchenStatus);
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('reports/periodic_sales_details_report/periodic_sales_details_report', $this->data);
    }

    public function periodic_sale_details_show() {  // show in table
        if (get_user_permission('reports/periodic_sales_details_report') === false) {
            redirect(base_url('user_login'));
        }
        // $start_date = trim($this->input->post('from_date'));
        // $end_date = trim($this->input->post('to_date'));

        if ($this->input->post('from_date')) {
            $start_date = trim($this->input->post('from_date'));
        } else {
            $start_date = date('Y-m-d');
        }

        if ($this->input->post('to_date')) {
            $end_date = trim($this->input->post('to_date'));
        } else {
            $end_date = date('Y-m-d');
        }
        $branch_id = intval(trim($this->input->post('branch_id')));

        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id'];
        $user_type = $user_info['user_type'];
        $company_information = $this->Company_Model->get_company();
        $user_info = $this->User_Model->get_user($user_id);
        $employee_id = $user_info->employee_id;
        $periodic_report_view_by_date = $this->periodic_report_view_by_date($start_date, $end_date, $employee_id, $user_type, $branch_id);
        
        if (!empty($branch_id)) {
            $branch = $this->Branch_Model->get_branch($branch_id);
            $branch_name = !empty($branch) ? $branch->branch_name : '';
        } else {
            $branch_name = 'All';
        }
        $this->data['branch_name'] = $branch_name;
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->data['company_information'] = $company_information;
        $this->data['periodic_report_view_by_date'] = $periodic_report_view_by_date;
        $this->load->view('reports/periodic_sales_details_report/periodic_sales_details_table', $this->data);
    }

    public function periodic_report_view_by_date($start_date, $end_date, $employee_id, $user_type, $branch_id = 0) {
        $branch_id_condition = (intval($branch_id) > 0) ? "AND i.branch_id = '$branch_id'" : "";
        if (strtolower($user_type) === 'marketing') {
            $where_condition = "WHERE c.employee_id = '$employee_id' AND DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') <= '$end_date' $branch_id_condition ORDER BY i.id DESC";
        } else {
            $where_condition = "WHERE DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') <= '$end_date' $branch_id_condition ORDER BY i.id DESC";
        }
        return $this->db->query("SELECT i.invoice_number, c.client_name, i.date_of_issue, i.branch_id, br.branch_name, p.product_name, s.pack_size, s.quantity, s.unit_price, (s.quantity * s.unit_price) AS total_amount, u.user_name, u.user_type, u.employee_id FROM invoice_details i LEFT JOIN sale_product s ON s.invoice_id=i.id LEFT JOIN client_info c ON c.id= i.client_id LEFT JOIN branch_info br ON i.branch_id = br.id LEFT JOIN product p ON s.product_id = p.id LEFT JOIN user_info u ON i.user_id=u.id $where_condition")->result();
    }

}
