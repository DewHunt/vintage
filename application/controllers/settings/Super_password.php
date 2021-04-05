<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Super_password extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->helper('file');
        $this->load->model('User_Model');
        $this->load->model('Company_Model');
        $this->load->model('Employee_Model');
    }

    public function index() {  // load company details
        if (get_user_permission('settings/super_password') === false) {
            redirect(base_url('user_login'));
        }
        $is_admin = $this->User_Model->is_loggedin_user_type_admin();
        if ($is_admin) {
            $this->data['title'] = "Super Password";
            $this->data['page_title'] = "Super Password";

            $this->data['company_information'] = $this->Company_Model->get_company();  // get single company information
            $this->data['button_text'] = !empty($this->data['company_information']) ? "Update" : "Save";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('settings/super_password/index', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function save_super_password() {
        if (get_user_permission('settings/super_password') === false) {
            redirect(base_url('user_login'));
        }
        if ($this->input->is_ajax_request()) {
            $message = '';
            $is_update = FALSE;
            $is_admin = $this->User_Model->is_loggedin_user_type_admin();
            if ($is_admin) {
                $id = intval(trim($this->input->post('id')));
                $super_password_without_encrypt = trim($this->input->post('password'));
                $confirm_super_password_without_encrypt = (trim($this->input->post('confirm_password')));
                $company = $this->Company_Model->get_company($id);
                if (!empty($company)) {
                    if ((!empty($super_password_without_encrypt)) && (!empty($confirm_super_password_without_encrypt))) {
                        if ($super_password_without_encrypt == $confirm_super_password_without_encrypt) {
                            if (strlen($super_password_without_encrypt) >= 5) {
                                if ($id > 0) {
                                    $company_data = array('id' => $id, 'super_password' => sha1($super_password_without_encrypt));
                                    $this->db->where('id', $company_data['id']);
                                    $is_update = $this->Company_Model->db->update('company_info', $company_data);
                                    $message = ($is_update) ? "Update successfully." : "Update Failed.";
                                }
                            } else {
                                $message = 'Your password must be at least 5 characters long';
                            }
                        } else {
                            $message = 'Password doest not match.';
                        }
                    } else {
                        $message = 'Please check input fields.';
                    }
                } else {
                    $message = 'Not allowed.';
                }
            } else {
                $message = 'Not allowed.';
            }
            set_json_output(array('isUpdate' => $is_update, 'message' => $message, 'redirectUrl' => base_url('settings/super_password')));
        } else {
            redirect(base_url('user_login'));
        }
    }

}
