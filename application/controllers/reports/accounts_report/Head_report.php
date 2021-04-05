<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Head_report extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Voucher_posting_details_Model');
        $this->load->model('Voucher_details_Model');
        $this->load->model('Head_details_Model');
    }

    public function index()
    {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $this->data['title'] = "Head Report";
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $this->data['head_details_list'] = $this->Head_details_Model->get_head_details();
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/accounts_report/head_report/head_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function head_report_show_in_table()
    {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_report_access')) == true)) {
            $head_id = trim($this->input->post('head_id'));
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $head_details = $this->Head_details_Model->get_head_details($head_id);
            if (!empty($head_details)) {
                $head_name = $head_details->head_name;
            } else {
                $head_name = 'All';
            }
            $this->data['head_details'] = $head_details;
            $this->data['head_name'] = $head_name;
            $head_posting_details = $this->get_head_posting_details($head_id);
            $this->data['head_posting_details'] = $head_posting_details;
            $this->load->view('reports/accounts_report/head_report/head_report_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_head_posting_details($head_id = 0)
    {
        if($head_id == 0){
            $result = $this->db->query("SELECT hdp.id, hdp.head_id, hdp.total_amount, hdp.debit_amount, hdp.credit_amount, h.head_name, h.head_type FROM head_details_posting hdp JOIN head_details h ON h.id = hdp.head_id WHERE h.is_active = '1' ORDER BY h.head_name ASC")->result();
        }else{
            $result = $this->db->query("SELECT hdp.id, hdp.head_id, hdp.total_amount, hdp.debit_amount, hdp.credit_amount, h.head_name, h.head_type FROM head_details_posting hdp JOIN head_details h ON h.id = hdp.head_id WHERE hdp.head_id = '$head_id' AND h.is_active = '1' ORDER BY h.head_name ASC")->result();
        }
        return $result;
    }
}