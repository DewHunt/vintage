<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_wise_report extends CI_Controller {

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
    }

    public function index() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $this->data['title'] = "Payment Report";
            $this->data['employee_list'] = $this->Employee_Model->get_employee();
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/employee_wise_report/employee_wise_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function employee_wise_report_show() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == true)) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id'];
            $user_type = $user_info['user_type'];
            $user_info = $this->User_Model->get_user($user_id);
            $employee_id = $user_info->employee_id;
            $start_date = trim($this->input->post('start_date'));
            $end_date = trim($this->input->post('end_date'));
            $employee_id = trim($this->input->post('employee_id'));
            $employee_information = $this->Employee_Model->get_employee($employee_id);
            if (!empty($employee_information)) {
                $employee_name = $employee_information->employee_name;
                $designation = $employee_information->designation;
            } else {
                $employee_name = 'All';
                $designation = 'All';
            }
            $employee_wise_report_view_by_date = $this->employee_wise_report_view_by_date($employee_id, $start_date, $end_date);
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            $this->data['employee_information'] = $employee_information;
            $this->data['employee_name'] = $employee_name;
            $this->data['designation'] = $designation;
            $this->data['employee_wise_report_view_by_date'] = $employee_wise_report_view_by_date;
            $this->load->view('reports/employee_wise_report/employee_wise_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function employee_wise_report_view_by_date($employee_id, $start_date, $end_date) {
        if (($employee_id <= 0) || ($employee_id == '')) {
            $where_condition = "i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date'";
        } else {
            $where_condition = "i.employee_id ='$employee_id' AND i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date'";
        }
        return $employee_wise_report_list = $this->db->query("SELECT i.id, i.date_of_issue, i.invoice_number, i.employee_id, i.client_id, i.product_total, i.amount_to_paid, e.employee_name, e.designation, c.client_name, c.client_area FROM invoice_details i JOIN employee_info e ON i.employee_id=e.id JOIN client_info c ON i.client_id=c.id WHERE $where_condition")->result();
    }

}
