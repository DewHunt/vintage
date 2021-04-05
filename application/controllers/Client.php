<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Client_Model');
        $this->load->model('Dealer_Model');
        $this->load->model('Employee_Model');
        $this->load->model('User_Model');
    }

    public function index() {
        if (get_user_permission('client') === false) {
            redirect(base_url('user_login'));
        }
        $user_info = $this->session->userdata('user_session');
        $user_type = $user_info['user_type'];
        $employee_id = $user_info['employee_id'];
        $client_id = trim($this->input->post('client_id'));
        $this->session->set_flashdata('client_id_flashdata', $client_id);
        $client_list = $this->get_client_list($user_type, $client_id, $employee_id);
        $this->data['client_list'] = $client_list;
        $this->data['all_client_list'] = $this->get_all_client_list($user_type);
        $this->data['title'] = "Customer";
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('client/client_details_list', $this->data);
    }

    public function get_all_customer_for_invoice()
    {
        $customerType = $this->input->post('customerType');

        $this->data['lastInsertedCustomerId'] = $this->input->post('lastInsertedCustomerId');
        $this->data['allCustomer'] = $this->Client_Model->get_any_type_client($customerType);
        $customerDropdownList = $this->load->view('sale/customer_dorpdown_list',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'customerDropdownList' => $customerDropdownList,
        )));
    }

    public function get_all_client_list($user_type) {
        if (strtolower($user_type) == 'marketing') {
            $all_client_list = $this->Client_Model->get_client_list_with_employee($employee_id);
        } else {
            $all_client_list = $this->Client_Model->get_client_list_with_employee();
        }
        return $all_client_list;
    }

    public function get_client_list($user_type, $client_id, $employee_id) {
        $client_list = '';
        if (!empty($this->session->userdata('user_session')) && (string) (strtolower($user_type) == 'marketing')) {
            if (!empty($client_id) && ((int) $client_id > 0)) {
                $client_list = $this->Client_Model->get_single_client_with_employee($client_id, $employee_id);
            } elseif ($client_id == 'import' || $client_id == 'lubzone') {
                $client_type = $client_id;
                $client_list = $this->Client_Model->get_client_list_client_type_with_employee($client_type, $employee_id);
            } else {
                $client_list = $this->Client_Model->get_client_list_with_employee($employee_id);
            }
        } else {
            if (!empty($client_id) && ((int) $client_id > 0)) {
                $client_list = $this->Client_Model->get_single_client_with_employee($client_id);
            } elseif ($client_id == 'import' || $client_id == 'lubzone') {
                $client_type = $client_id;
                $client_list = $this->Client_Model->get_client_list_client_type_with_employee($client_type);
            } else {
                $client_list = $this->Client_Model->get_client_list_with_employee();
            }
        }
        return $client_list;
    }

    public function create_new_client() { // load create new client page
        if (get_user_permission('client') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "Create New Customer";
        $dealer_list = $this->Dealer_Model->get_dealer();
        $this->data['dealer_list'] = $dealer_list;
        $employee_list = $this->Employee_Model->get_employee();
        $this->data['employee_list'] = $employee_list;
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('client/create_new_client', $this->data);
    }

    public function save_client() {
        if (get_user_permission('client') === false) {
            redirect(base_url('user_login'));
        }
        // echo "<pre>"; print_r($this->input->post()); exit();
        $this->data['title'] = 'Create New Client';

        $email = trim($this->input->post('email'));
        $is_client_name_exists = $this->Client_Model->is_client_exists(0,$email);

        if (!empty($is_client_name_exists)) {
            $this->session->set_flashdata('errorMessage', 'Client Already Exists With This Email');

            if ($this->input->post('saveFrom') == 'outside') {
                $this->output->set_content_type('application/json')->set_output(json_encode(array(
                    'errorMessage' => 'Client Already Exists With This Email',
                )));
            }
            else {
                redirect(base_url('client/create_new_client'));
            }
        } else {
            $data = array(
                'client_name' => trim($this->input->post('client_name')),
                'client_code' => trim($this->input->post('client_code')),
                'address' => trim($this->input->post('address')),
                'client_area' => trim($this->input->post('client_area')),
                'cell_number' => trim($this->input->post('cell_number')),
                'phone_number' => trim($this->input->post('phone_number')),
                'email' => trim($this->input->post('email')),
                'client_type' => trim($this->input->post('customerFor')),
                'remarks' => trim($this->input->post('remarks')),
                'credit_balance' => 0,
                'total_sale' => 0,
                'advance_balance' => 0,
            );

            $this->db->insert('client_info', $data);
            $this->session->set_flashdata('successMessage', 'Client Saved Successfully');

            if ($this->input->post('saveFrom') == 'outside') {
                $lastInsertedCustomerId = $this->db->insert_id();
                $this->output->set_content_type('application/json')->set_output(json_encode(array(
                    'lastInsertedCustomerId' => $lastInsertedCustomerId,
                    'successMessage' => 'Customer Saved Successfully',
                )));
            }
            else {
                redirect(base_url('client'));
            }
        }
    }

    public function update_client($id = 0) {  // load update client information page
        if (get_user_permission('client') === false) {
            redirect(base_url('user_login'));
        }
        $client = $this->Client_Model->get_client($id);

        if (!empty($client)) {
            $this->data['title'] = "Update Customer";
            $dealer_list = $this->Dealer_Model->get_dealer();
            $employee_list = $this->Employee_Model->get_employee();
            $employee_info = $this->Employee_Model->get_employee($client->employee_id);
            $dealer_info = $this->Dealer_Model->get_dealer($client->dealer_id);

            $this->data['client'] = $client;
            $this->data['dealer_list'] = $dealer_list;
            $this->data['employee_list'] = $employee_list;
            $this->data['employee_info'] = $employee_info;
            $this->data['dealer_info'] = $dealer_info;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('client/update_client', $this->data);
        } else {
            redirect(base_url('client'));
        }
    }

    public function update() {
        if (get_user_permission('client') === false) {
            redirect(base_url('user_login'));
        }

        // echo "<pre>"; print_r($this->input->post()); exit();
        $this->data['title'] = 'Update Client';

        $id = trim($this->input->post('id'));
        $email = trim($this->input->post('email'));

        $client = $this->Client_Model->get_client($id);
        $this->data['client'] = $client;

        $client_by_id_for_duplicate_check = $this->Client_Model->is_client_exists($id,$email);

        if (!empty($client_by_id_for_duplicate_check)) {
            $this->session->set_flashdata('errorMessage', 'Client Already Exists');
            redirect(base_url('client/update_client/' . $id));
        } else {
            $data = array(
                'client_name' => trim($this->input->post('client_name')),
                'client_code' => trim($this->input->post('client_code')),
                'address' => trim($this->input->post('address')),
                'client_area' => trim($this->input->post('client_area')),
                'cell_number' => trim($this->input->post('cell_number')),
                'phone_number' => trim($this->input->post('phone_number')),
                'email' => trim($this->input->post('email')),
                'client_type' => trim($this->input->post('customerFor')),
                'remarks' => trim($this->input->post('remarks')),
                'credit_balance' => $client->credit_balance,
                'total_sale' => $client->total_sale,
                'advance_balance' => $client->advance_balance,
            );

            $this->db->where('id', $id);
            $this->db->update('client_info', $data);
            $this->session->set_flashdata('successMessage', 'Client Updated Successfully');
            redirect(base_url('client'));
        }
    }

    public function delete($id) {
        if (get_user_permission('client') === false) {
            redirect(base_url('user_login'));
        }
        $this->Client_Model->delete($id);
        redirect(base_url('client'));
    }

    // public function get_diplicate_client() {
    //     $client_list_by_client_code = $this->db->query("SELECT DISTINCT client_code, id, client_type FROM client_info ORDER BY client_code")->result();
    //     $client_list = $this->Client_Model->get_client();
    //     $client_array = array();
    //     $count = 1;

    //     foreach ($client_list_by_client_code as $client_by_client_code) {
    //         foreach ($client_list as $client) {
    //             if (((string) $client_by_client_code->client_code == (string) $client->client_code) && ((int) $client_by_client_code->id != (int) $client->id)) {
    //                 if ((string) $client_by_client_code->client_type == (string) $client->client_type) {
    //                     echo $count++;
    //                     echo '.<br>';
    //                     echo 'client name ' . $client->client_name;
    //                     echo '<br>';
    //                     echo 'client code ' . $client->client_code;
    //                     echo '<br>';
    //                     echo 'client type ' . $client->client_type;
    //                     echo '<br>';
    //                     echo '------------------------------------------------------------<br>';
    //                 }
    //             }
    //         }

    //         // if ($count > 2) {
    //         //     array_push($client_array, $client_by_client_code);
    //         // }
    //     }

    //     // echo '<pre>'; print_r(count($client_array));
    //     // echo '<pre>'; print_r($client_array); die();
    // } 
}
