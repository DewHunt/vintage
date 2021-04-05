<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->helper('file');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Employee_total_leave_Model');
        $this->load->model('Employee_leave_details_Model');
    }

    public function index() {  // load company details
        if (get_user_permission('company') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['company_information'] = $this->Company_Model->get_company();  // get single company information
        
        $this->data['title'] = "Company";
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('company/company_details_info', $this->data);
    }

    public function create_new_company() { // load create new company page
        if (get_user_permission('company') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "Company";
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('company/create_new_company');
    }

    public function save_company() {  // save company information
        if (get_user_permission('company') === false) {
            redirect(base_url('user_login'));
        }

        $this->form_validation->set_rules('company_name_1', 'company name 1', 'required');

        if ($this->form_validation->run() === FALSE) {
            redirect(base_url('company/create_new_company'));
        }

        $this->data['title'] = 'Add Company';

        $upload_path = 'assets/uploads/company_logo/';
        $link = 'company/create_new_company';
        $imagePath = upload_image('image',100,0,0,$upload_path,$link);
        // echo $imagePath; exit();

        $company_data = array(
            'company_name_1' => trim($this->input->post('company_name_1')),
            'company_name_2' => trim($this->input->post('company_name_2')),
            'company_address_1' => trim($this->input->post('company_address_1')),
            'company_address_2' => trim($this->input->post('company_address_2')),
            'button_backgound' => trim($this->input->post('buttonBackground')),
            'category_name' => trim($this->input->post('categoryName')),
            'phone' => trim($this->input->post('phone')),
            'mobile' => trim($this->input->post('mobile')),
            'fax' => trim($this->input->post('fax')),
            'email' => trim($this->input->post('email')),
            'website' => strtolower(trim($this->input->post('website'))),
            'casual_leave' => 0,
            'medical_leave' => 0,
            'earn_leave' => 0,
            'company_logo' => $imagePath,
        );

        $this->Company_Model->db->insert('company_info', $company_data);
        redirect(base_url('company'));
    }

    public function update_company($id = 0) {  // load update company information page
        if (get_user_permission('company') === false) {
            redirect(base_url('user_login'));
        }

        $company = $this->Company_Model->get_company($id);
        if (!empty($company)) {
            $this->data['title'] = "Update Company";
            $this->data['company'] = $company;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('company/update_company', $this->data);
        } else {
            redirect(base_url('company'));
        }
    }

    public function update() {  // update company
        if (get_user_permission('company') === false) {
            redirect(base_url('user_login'));
        }
        // echo "<pre>"; print_r($this->input->post()); exit();
        $this->form_validation->set_rules('company_name_1', 'company name 1', 'required');

        if ($this->form_validation->run() === FALSE) {
            redirect(base_url("company"));
        }

        $this->data['title'] = 'Update Company';
        $id = trim($this->input->post('id'));
        $company = $this->Company_Model->get_company($id);

        $upload_path = 'assets/uploads/company_logo/';
        $link = 'company/update_company/'.$id;
        $imagePath = upload_image('image',100,0,0,$upload_path,$link);
        
        $company_data = array(
            'id' => $id,
            'company_name_1' => trim($this->input->post('company_name_1')),
            'company_name_2' => trim($this->input->post('company_name_2')),
            'company_address_1' => trim($this->input->post('company_address_1')),
            'company_address_2' => trim($this->input->post('company_address_2')),
            'button_backgound' => trim($this->input->post('buttonBackground')),
            'category_name' => trim($this->input->post('categoryName')),
            'phone' => trim($this->input->post('phone')),
            'mobile' => trim($this->input->post('mobile')),
            'fax' => trim($this->input->post('fax')),
            'email' => trim($this->input->post('email')),
            'website' => strtolower(trim($this->input->post('website'))),
            'casual_leave' => $company->casual_leave,
            'medical_leave' => $company->medical_leave,
            'earn_leave' => $company->earn_leave,
            'company_logo' => !empty($imagePath) ? $imagePath : $company->company_logo,
        );
        $this->db->where('id', $company_data['id']);
        $this->Company_Model->db->update('company_info', $company_data);
        redirect(base_url('company'));
    }

    public function save_menu_permission()
    {
        if (get_user_permission('company') === false) {
            redirect(base_url('user_login'));
        }
        // echo "<pre>"; print_r($this->input->post()); exit();
        $company_id = $this->input->post('company_id');
        $form_data = data_form_post(array('outlet_access','factory_access','kitchen_room_access','money_receipt_access','edit_money_receipt_access','transaction_access'));
        $json_data = json_encode($form_data);
            
        $company_data = array(
            'menu_permission' => $json_data,
        );

        $this->db->where('id', $company_id);
        $this->db->update('company_info', $company_data);
        redirect(base_url('company'));
    }

    public function delete_uploaded_image($company_logo) {
        unlink(($company_logo));
    }

    public function delete($id) {
        if (get_user_permission('company') === false) {
            redirect(base_url('user_login'));
        }
        $this->Company_Model->delete($id);
        redirect(base_url('company'));
    }

    public function leave_settings() {  // load leave settings page
        if (get_user_permission('company/leave_settings') === false) {
            redirect(base_url('user_login'));
        }

        $company = $this->Company_Model->get_company();
        if (!empty($company)) {
            $this->data['title'] = "Leave Settings";
            $this->data['company'] = $company;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('hr/leave_settings/leave_settings', $this->data);
        } else {
            redirect(base_url('company'));
        }
    }

    public function leave_settings_update() {  //update leave settings in company information
        if (get_user_permission('company/leave_settings') === false) {
            redirect(base_url('user_login'));
        }
        
        $this->data['title'] = 'Leave Settings Update';
        $casual_leave = trim($this->input->post('casual_leave'));
        $medical_leave = trim($this->input->post('medical_leave'));
        $earn_leave = trim($this->input->post('earn_leave'));
        $company = $this->Company_Model->get_company();
        $leave_settings_data = array(
            'id' => $company->id,
            'casual_leave' => $casual_leave,
            'medical_leave' => $medical_leave,
            'earn_leave' => $earn_leave,
        );
        $this->form_validation->set_rules('casual_leave', 'Casual Leave', 'required');
        $this->form_validation->set_rules('medical_leave', 'Medical Leave', 'required');
        $this->form_validation->set_rules('earn_leave', 'Earn Leave', 'required');
        if ($this->form_validation->run() === FALSE) {
            $company = $this->Company_Model->get_company();
            $this->data['company'] = $company;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('hr/leave_settings/leave_settings', $this->data);
        } else {
            $this->db->where('id', $leave_settings_data['id']);
            $this->Company_Model->db->update('company_info', $leave_settings_data);
            $this->session->set_flashdata('leave_settings_success_message', 'Saved Successfully');
            redirect(base_url('company/leave_settings'));
        }
    }

    public function generate_employee_leave() {
        $company = $this->Company_Model->get_company();
        $current_year = get_current_year();
        $employee_list = $this->Employee_Model->get_employee();
        foreach ($employee_list as $employee) {
            $employee_total_leave_by_current_year = $this->Employee_total_leave_Model->get_employee_total_leave_by_current_year($employee->id, $current_year);
            if (empty($employee_total_leave_by_current_year)) {
                if (((int) $employee->deactivate_employee) <= 0) {
                    $employee_total_leave_data = array(
                        'employee_id' => $employee->id,
                        'year' => $current_year,
                        'total_casual_leave' => $company->casual_leave,
                        'total_medical_leave' => $company->medical_leave,
                        'total_earn_leave' => $company->earn_leave,
                        'paid_casual_leave' => 0,
                        'paid_medical_leave' => 0,
                        'paid_earn_leave' => 0,
                    );
                    $this->Employee_total_leave_Model->db->insert('employee_total_leave', $employee_total_leave_data);
                }
            }
        }
        redirect(base_url('reports/hr_report/employee_leave_report/employee_leave_report'));
    }

}
