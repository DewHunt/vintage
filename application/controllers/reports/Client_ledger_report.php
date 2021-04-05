<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_ledger_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Invoice_details_Model');
        $this->load->model('Client_Model');
        $this->load->model('Dealer_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Sale_product_Model');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
    }

    public function index() {  // Client Ledger Report
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_report_access')) == TRUE)) {
            $this->data['title'] = "Client Ledger Report";
            $company_information = $this->Company_Model->get_company();
            $this->data['company_information'] = $company_information;
            $currency_settings = $this->Currency_settings_Model->get_currency_settings();
            $this->data['currency_settings'] = $currency_settings;
            $clients_details_array = $this->get_client_ledger_report();
            $this->data['clients_details_array'] = $clients_details_array;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('reports/client_ledger_report/client_ledger_report', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }
	
	 /*public function get_client_ledger_report() {
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id'];
        $user_type = $user_info['user_type'];
        $employee_id = $user_info['employee_id'];
        $client_list = $this->Client_Model->get_all_client_list($employee_id, $user_type);
        $client_array = (array) $client_list;
        $user_info = $this->User_Model->get_user($user_id);
        $employee_id = $user_info->employee_id;
        $client_list_group_by_client_code = $this->Client_Model->get_client_list_group_by_client_code($employee_id, $user_type);
        $clients_details_array = array();
        foreach ($client_list_group_by_client_code as $group_by_client_code) {
            $key = array_search($group_by_client_code->client_code, array_column($client_array, 'client_code'));
            $arr = '';
            $arr = $client_array[$key];
            $im_credit_balance = 0;
            $lp_credit_balance = 0;
            if (((string)$group_by_client_code->client_type) == 'import') {
                $im_credit_balance = $group_by_client_code->credit_balance;
            } else {
                $lp_credit_balance = $group_by_client_code->credit_balance;
            }
            if ($group_by_client_code->id != $arr->id) {
                if ($arr->client_type == 'import') {
                    $im_credit_balance = $arr->credit_balance;
                } else {
                    $lp_credit_balance = $arr->credit_balance;
                }
            }
            $client_ledger_data = array(
                'id' => $arr->id,
                'client_type' => $group_by_client_code->client_type,
                'client_name' => $group_by_client_code->client_name,
                'client_code' => $group_by_client_code->client_code,
                'lp_credit_balance' => $lp_credit_balance,
                'im_credit_balance' => $im_credit_balance,
                'total_credit_balance' => (double) $lp_credit_balance + (double) $im_credit_balance,
            );
            array_push($clients_details_array, $client_ledger_data);
        }
        return $clients_details_array;
    }*/

    public function get_client_ledger_report() {
        $clients_details_array = array();
        $client_list_by_client_code = $this->db->query("SELECT DISTINCT client_code FROM client_info")->result();
        foreach ($client_list_by_client_code as $client) {
            $client_code = $client->client_code;
            $client_lubzone = $this->db->query("SELECT * FROM client_info WHERE client_code='$client_code' AND client_type='lubzone'")->row();
            $client_import = $this->db->query("SELECT * FROM client_info WHERE client_code='$client_code' AND client_type='import'")->row();
            $client_name = !empty($client_lubzone) ? $client_lubzone->client_name : $client_import->client_name;
            $lp_credit_balance = !empty($client_lubzone) ? $client_lubzone->credit_balance : 0;
            $im_credit_balance = !empty($client_import) ? $client_import->credit_balance : 0;
            $total_credit_balance = (double) $lp_credit_balance + (double) $im_credit_balance;
//            if ((string) $client->client_code == '1018') {
//                echo '<pre>';
//                print_r($client_lubzone);
//                echo '</pre>';
//                echo '<br>';
//                echo '<pre>';
//                print_r($total_credit_balance);
//                echo '</pre>';
//                die();
//            }
            $client_ledger_data = array(
//                'id' => $arr->id,
//                'client_type' => $group_by_client_code->client_type,
                'client_name' => $client_name,
                'client_code' => $client->client_code,
                'lp_credit_balance' => $lp_credit_balance,
                'im_credit_balance' => $im_credit_balance,
                'total_credit_balance' => $total_credit_balance,
            );
            array_push($clients_details_array, $client_ledger_data);
        }
//        echo '<pre>';
//        print_r($clients_details_array);
//        echo '</pre>';
//        die();
        return $clients_details_array;
//        echo '<pre>';
//        print_r($client_list_by_client_code);
//        echo '</pre>';
    }

}
