<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Branch_Model');
        $this->load->model('Employee_Model');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
    }

    public function index() {  // load Branch details
        if (get_user_permission('branch') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "Branch";
        $this->data['branch_list'] = $this->Branch_Model->get_branch();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('branch/branch_details_list', $this->data);
    }

    public function create_new_branch() { // load create new Branch page
        if (get_menu_permission('outlet_access') == false) {
            redirect(base_url('user_login'));
        }

        if (get_user_permission('branch') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = "Branch";
        $this->data['assignedBranchList'] = $this->Branch_Model->get_assigned_branch_list();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('branch/create_new_branch', $this->data);
    }

    public function save_branch() {  // save Branch information
        if (get_user_permission('branch') === false) {
            redirect(base_url('user_login'));
        }

        // echo "<pre>"; print_r($this->input->post()); exit();

        $this->data['title'] = 'Create New Branch';
        $branch_name = $this->input->post('branch_name');
        $branch_code = $this->input->post('branch_code');
        $mobile = $this->input->post('mobile');

        $is_branch_name_exists = $this->Branch_Model->is_branch_name_exists($branch_name,$branch_code,$mobile);

        if (empty($is_branch_name_exists)) {                
            $imagePath = '';
            $new_name = $_FILES["logo"]['name'];
            $config['file_name'] = $new_name;
            $size = $_FILES["logo"]["size"];
            $config['upload_path'] = './assets/uploads/branch_logo/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 100;

            $this->load->library('upload', $config);

            if ((int) $size > (100 * 1024)) {
                $this->session->set_flashdata('errorMessage', 'Image size can not be more than 100 kb');
                redirect(base_url('branch/create_new_branch'));
            }
            else {
                $is_upload = $this->upload->do_upload('logo');
                $data = array('upload_data' => $this->upload->data());

                if (!empty(trim($new_name))) {
                    $imagePath = 'assets/uploads/branch_logo/' . $data['upload_data']['file_name'];
                }

                $hotKitchenStatus = $this->input->post('hotKitchenStatus');
                $assinedBranch = NULL;
                if ($hotKitchenStatus == 1) {
                    $assinedBranchArray = $this->input->post('branch');
                    $assinedBranch = implode(',',$assinedBranchArray);
                }

                $branchData = array(
                    'branch_name' => $branch_name,
                    'branch_code' => $branch_code,
                    'business_type' => $this->input->post('businessType'),
                    'hot_kitchen_status' => $hotKitchenStatus,
                    'factory_status' => $this->input->post('isFactory'),
                    'assigned_branches' => $assinedBranch,
                    'vat_reg' => $this->input->post('vatReg'),
                    'mobile' => $mobile,
                    'logo' => $imagePath,
                    'footer_text' => $this->input->post('footerText'),
                    'address' => $this->input->post('address'),
                );

                $this->db->insert('branch_info', $branchData);
                redirect(base_url('branch'));
            }
        }
        else {
            $this->session->set_flashdata('errorMessage', 'Outlet Already Exists.');
            redirect(base_url('branch/create_new_branch'));
        }
    }

    public function update_branch($id = 0) {  // load update Branch information page
        if (get_user_permission('branch') === false) {
            redirect(base_url('user_login'));
        }

        $branch = $this->Branch_Model->get_branch($id);
        if (!empty($branch)) {
            $this->data['title'] = "Update Branch";
            $this->data['assignedBranchList'] = $this->Branch_Model->get_assigned_branch_list($id);
            $this->data['isHotKitchen'] = $this->Branch_Model->check_hot_kitchen($id);
            $this->data['branch'] = $branch;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('branch/update_branch', $this->data);
        } else {
            redirect(base_url('branch'));
        }
    }

    public function update() {  // update Branch
        if (get_user_permission('branch') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = 'Update Outlet';
        $id = $this->input->post('id');
        $branch_name = $this->input->post('branch_name');
        $branch_code = $this->input->post('branch_code');
        $mobile = $this->input->post('mobile');

        // $branch_name = trim($this->input->post('branch_name'));
        // $branch = $this->Branch_Model->get_branch($id);
        // $this->data['branch'] = $branch;

        $branch_by_id_for_duplicate_check = $this->Branch_Model->get_branch_by_id_for_duplicate_check($branch_name, $id);

        if (empty($branch_by_id_for_duplicate_check)) {
            if (!empty($_FILES["logo"]['name'])) {
                $new_name = $_FILES["logo"]['name'];
                $config['file_name'] = $new_name;
                $size = $_FILES["logo"]["size"];
                $config['upload_path'] = './assets/uploads/branch_logo/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 100;

                $this->load->library('upload', $config);

                if ((int) $size > (100 * 1024)) {
                    $this->session->set_flashdata('image_upload_error_message', 'Image size can not be more than 100 kb');
                    redirect(base_url('branch/update_branch'));
                }
                else {
                    $is_upload = $this->upload->do_upload('logo');
                    $data = array('upload_data' => $this->upload->data());
                    if (!empty(trim($new_name))) {
                        $imagePath = 'assets/uploads/branch_logo/' . $data['upload_data']['file_name'];
                    }
                }
            }
            else {
                $imagePath = $this->input->post('previousLogo');
            }

            $hotKitchenStatus = $this->input->post('hotKitchenStatus');
            $assinedBranch = NULL;
            if ($hotKitchenStatus == 1) {
                $assinedBranchArray = $this->input->post('branch');
                $assinedBranch = implode(',',$assinedBranchArray);
            }

            $branchData = array(
                'branch_name' => $branch_name,
                'branch_code' => $branch_code,
                'business_type' => $this->input->post('businessType'),
                'hot_kitchen_status' => $hotKitchenStatus,
                'factory_status' => $this->input->post('isFactory'),
                'assigned_branches' => $assinedBranch,
                'vat_reg' => $this->input->post('vatReg'),
                'mobile' => $mobile,
                'logo' => $imagePath,
                'footer_text' => $this->input->post('footerText'),
                'address' => $this->input->post('address'),
            );

            $this->db->where('id', $id);
            $this->db->update('branch_info', $branchData);
            redirect(base_url('branch'));
        }
        else {
            $this->session->set_flashdata('name_exists_message', 'Outlet Already Exists.');
            redirect(base_url('branch/update_branch/' . $id));
        }
    }

    public function delete($id) {
        if (get_menu_permission('outlet_access') == false) {
            redirect(base_url('user_login'));
        }

        if (get_user_permission('branch') === false) {
            redirect(base_url('user_login'));
        }
        
        $this->Branch_Model->delete($id);
        redirect(base_url('branch'));
    }

}
