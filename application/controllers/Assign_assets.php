<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_assets extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Employee_Model');
        $this->load->model('Assets_info_Model');
        $this->load->model('Assign_assets_Model');
        $this->load->model('User_Model');
    }

    public function index() {  // load employee wise total assets
        if (get_user_permission('assign_assets') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = "Assign Assets";
        $this->data['assets_info_list'] = $this->Assets_info_Model->get_assets_info();
        $this->data['employee_list'] = $this->Employee_Model->get_employee();
        $this->data['all_assign_assets_by_employee_list'] = $this->Assign_assets_Model->get_all_assign_assets_by_employee_view();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('assign_assets/assign_assets_details', $this->data);
    }

    public function get_assets_in_table() {
        if (get_user_permission('assign_assets') === false) {
            redirect(base_url('user_login'));
        }

        if ($this->input->is_ajax_request()) {
            $assign_assets = $this->session->userdata('assign_assets');  // Assign Assets table list session
            if (!empty($assign_assets)) {
                $assign_assets_table_array = $assign_assets;
                $quantity = (int) trim($this->input->post('quantity'));
                $assets_info_id = trim($this->input->post('assets_info_id'));
                $assets_info = $this->Assets_info_Model->get_assets_info($assets_info_id);
                $assign_assets_details = array(
                    'array_id' => time(),
                    'assets_info_id' => $assets_info->id,
                    'assets_name' => $assets_info->assets_name,
                    'quantity' => $quantity,
                );
                $this->form_validation->set_rules('assets_info_id', 'Asset', 'required');
                $this->form_validation->set_rules('quantity', 'Quantity', 'required');

                if ($this->form_validation->run() === FALSE) {
                    $assets_info_list = $this->Assets_info_Model->get_assets_info();
                    $this->data['assets_info_list'] = $assets_info_list;
                    $this->load->view('header');
                    $this->load->view('navigation');
                    $this->load->view('assign_assets/assign_assets', $this->data);
                } else {
                    $assets_quantity = (int) ($assets_info->assets_quantity);
                    $assigned_assets_quantity = (int) ($assets_info->assigned_assets_quantity);
                    $available_quantity = (($assets_quantity) - ($assigned_assets_quantity));

                    if ($available_quantity >= $quantity) {
                        $assets_info_id_array = array_column($assign_assets_table_array, 'assets_info_id');
                        if (in_array($assign_assets_details['assets_info_id'], $assets_info_id_array)) {
                            $assets_info_list = $this->Assets_info_Model->get_assets_info();
                            $this->data['assets_info_list'] = $assets_info_list;
                            $assets_already_added_into_table_message = 'Already added in this Table go to update.';
                            $this->data['assets_already_added_into_table_message'] = $assets_already_added_into_table_message;
                            $this->load->view('assign_assets/assets_info_table', $this->data);
                        } else {
                            array_push($assign_assets_table_array, $assign_assets_details);
                            $this->session->set_userdata('assign_assets', $assign_assets_table_array);
                            $assets_info_list = $this->Assets_info_Model->get_assets_info();
                            $this->data['assets_info_list'] = $assets_info_list;
                            $this->load->view('assign_assets/assets_info_table', $this->data);
                        }
                    } else {
                        $assets_info_list = $this->Assets_info_Model->get_assets_info();
                        $this->data['assets_info_list'] = $assets_info_list;
                        $available_quantity_exceed = 'Available Quantity exceed';
                        $this->data['available_quantity_exceed'] = $available_quantity_exceed;
                        //echo 'Available Quantity exceed';
                        $this->load->view('assign_assets/assets_info_table', $this->data);
                    }
                }
            } else {  // when assign assets table info empty
                $assign_assets_table_array = array();
                $assets_info_id = trim($this->input->post('assets_info_id'));
                $quantity = trim($this->input->post('quantity'));
                $assets_info = $this->Assets_info_Model->get_assets_info($assets_info_id);
                $assign_assets_details = array(
                    'array_id' => time(),
                    'assets_info_id' => $assets_info->id,
                    'assets_name' => $assets_info->assets_name,
                    'quantity' => $quantity,
                );
                $this->form_validation->set_rules('assets_info_id', 'Asset', 'required');
                $this->form_validation->set_rules('quantity', 'Quantity', 'required');

                if ($this->form_validation->run() === FALSE) {
                    $assets_info_list = $this->Assets_info_Model->get_assets_info();
                    $this->data['assets_info_list'] = $assets_info_list;
                    $this->load->view('header');
                    $this->load->view('navigation');
                    $this->load->view('assign_assets/assign_assets', $this->data);
                }

                $assets_quantity = (int) ($assets_info->assets_quantity);
                $assigned_assets_quantity = (int) ($assets_info->assigned_assets_quantity);
                $available_quantity = (($assets_quantity) - ($assigned_assets_quantity));
                if ($available_quantity >= $quantity) {
                    array_push($assign_assets_table_array, $assign_assets_details);
                    $this->session->set_userdata('assign_assets', $assign_assets_table_array);
                    $assets_info_list = $this->Assets_info_Model->get_assets_info();
                    $this->data['assets_info_list'] = $assets_info_list;
                    $this->load->view('assign_assets/assets_info_table', $this->data);
                } else {
                    $assets_info_list = $this->Assets_info_Model->get_assets_info();
                    $this->data['assets_info_list'] = $assets_info_list;
                    $available_quantity_exceed = 'Available Quantity exceed';
                    $this->data['available_quantity_exceed'] = $available_quantity_exceed;
                    $this->load->view('assign_assets/assets_info_table', $this->data);
                }
            }
        }
        else {            
            redirect(base_url());
        }
    }

    public function create_new_assign_assets() {  // load create assign page
        if (get_user_permission('assign_assets') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = "Assign Assets";
        $this->data['assets_info_list'] = $this->Assets_info_Model->get_assets_info();
        $this->data['employee_list'] = $this->Employee_Model->get_employee();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('assign_assets/assign_assets', $this->data);
    }

    public function assign_assets_save() {
        if (get_user_permission('assign_assets') === false) {
            redirect(base_url('user_login'));
        }

        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id']; // session user id
        $assign_assets = $this->session->userdata('assign_assets');  //$new_assets waiting for add
        $employee_id = trim($this->input->post('employee_id'));
        if ((!empty($assign_assets))) {
            $assign_assets_by_employee_id = $this->Assign_assets_Model->get_assign_assets_by_employee_id($employee_id); //$previously_assign_assets
            foreach ($assign_assets as $new_assets) {
                $flag = FALSE;
                $id = 0;
                $perv_quantity = 0;
                foreach ($assign_assets_by_employee_id as $previously_assign_assets) {
                    if ((int) ($new_assets['assets_info_id']) == (int) ($previously_assign_assets->assets_info_id)) {
                        $flag = TRUE;
                        $id = $previously_assign_assets->id;
                        $perv_quantity = (int) $previously_assign_assets->quantity;
                    }
                }
                if ($flag) { //TRUE
                    $assign_assets_for_update_data = array(
                        'id' => $id,
                        'assets_info_id' => $new_assets['assets_info_id'],
                        'quantity' => (int) $perv_quantity + (int) $new_assets['quantity'],
                        'employee_id' => $employee_id,
                        'assign_date' => get_current_date(),
                        'user_id' => $user_id,
                    );
                    $this->db->where('id', $assign_assets_for_update_data['id']);
                    $this->Assign_assets_Model->db->update('assign_assets', $assign_assets_for_update_data);
                    $this->update_assigned_assets_quantity_in_assets_info($new_assets['assets_info_id']);
                } else {
                    $data = array(
                        'assets_info_id' => $new_assets['assets_info_id'],
                        'quantity' => $new_assets['quantity'],
                        'employee_id' => $employee_id,
                        'assign_date' => get_current_date(),
                        'user_id' => $user_id,
                    );
                    $this->Assign_assets_Model->db->insert('assign_assets', $data);
                    $currently_inserted_assign_assets_id = $this->db->insert_id();
                    $assign_assets = $this->Assign_assets_Model->get_assign_assets($currently_inserted_assign_assets_id);
                    if (!empty($assign_assets)) {
                        $this->update_assigned_assets_quantity_in_assets_info($assign_assets->assets_info_id);
                    }
                }
            }
            $this->session->unset_userdata('assign_assets');
            redirect(base_url('assign_assets'));
        } else {
            $this->session->set_flashdata('assign_assets_confirm_error_session', 'Please add Asset to confirm.');
            redirect(base_url('assign_assets/create_new_assign_assets'));
        }
    }

    public function assign_assets_details_view() {  //assign assets details view in a modal
        if (get_user_permission('assign_assets') === false) {
            redirect(base_url('user_login'));
        }
        $id = trim($this->input->post('id')); //$id=$employee_id
        $this->data['employee_information'] = $this->Employee_Model->get_employee($id);
        $this->data['assign_assets_by_employee_id'] = $this->Assign_assets_Model->get_assign_assets_by_employee_id($id);
        $this->load->view('assign_assets/assign_assets_details_modal', $this->data);
    }

    public function delete($id = 0) {
        if (get_user_permission('assign_assets') === false) {
            redirect(base_url('user_login'));
        }

        $assign_assets = $this->Assign_assets_Model->get_assign_assets($id);
        if (!empty($assign_assets)) {
            $assets_info_id = $assign_assets->assets_info_id;
            $this->Assign_assets_Model->delete($id);
            $this->update_assigned_assets_quantity_in_assets_info($assets_info_id);
            $this->session->set_flashdata('delete_success_message', 'Unassigned Successfully.');
            $current_url_session = $this->session->userdata('current_url_session');
            redirect($current_url_session);
        } else {
            $this->session->set_flashdata('delete_error_message', 'Unassigned Failed.');
            $current_url_session = $this->session->userdata('current_url_session');
            redirect($current_url_session);
        }
    }

    public function update_assign_assets($id = 0) {  // load assets information
        if (get_user_permission('assign_assets') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "Update Assign Assets";
        $this->data['employee_information'] = $this->Employee_Model->get_employee($id);
        $this->data['assign_assets_by_employee_id'] = $this->Assign_assets_Model->get_assign_assets_by_employee_id($id);  //$id=$employee_id
        $current_url_session = $this->session->set_userdata('current_url_session', current_url());
        $this->data['current_url_session'] = $current_url_session;
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('assign_assets/update_assign_assets_details', $this->data);
    }

    public function update_assets() {  //load update modal for update
        if (get_user_permission('assign_assets') === false) {
            redirect(base_url('user_login'));
        }
        $assign_assets_id = trim($this->input->post('id'));
        $assign_assets_information = $this->Assign_assets_Model->get_assign_assets($assign_assets_id);
        $assets_information = $this->Assets_info_Model->get_assets_info($assign_assets_information->assets_info_id);
        $this->data['assign_assets_information'] = $assign_assets_information;
        $this->data['assets_information'] = $assets_information;
        $this->load->view('assign_assets/update_assign_assets_details_modal', $this->data);
    }

    public function update() {  // for assign assets quantity update
        if (get_user_permission('assign_assets') === false) {
            redirect(base_url('user_login'));
        }

        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id']; // session user id
        $assign_assets_id = trim($this->input->post('id'));
        $assets_info_id = trim($this->input->post('assets_info_id'));
        $quantity = (int) trim($this->input->post('quantity'));
        $assign_assets_information = $this->Assign_assets_Model->get_assign_assets($assign_assets_id);
        $assets_information = $this->Assets_info_Model->get_assets_info($assets_info_id);
        $assets_quantity = (int) $assets_information->assets_quantity;
        if (($assets_quantity) >= ($quantity)) {
            $data = array(
                'id' => $assign_assets_id,
                'assets_info_id' => $assign_assets_information->assets_info_id,
                'quantity' => $quantity,
                'employee_id' => $assign_assets_information->employee_id,
                'assign_date' => $assign_assets_information->assign_date,
                'user_id' => $user_id,
            );
            $this->db->where('id', $data['id']);
            $this->Assign_assets_Model->db->update('assign_assets', $data);
            $this->update_assigned_assets_quantity_in_assets_info($assets_info_id);
            $this->session->set_flashdata('assign_assets_update_success', 'Successfully Updated.');
            $assign_assets_update_success = $this->session->flashdata('assign_assets_update_success');
            $current_url_session = $this->session->userdata('current_url_session');
            redirect($current_url_session);
        } else {
            $this->session->set_flashdata('assign_assets_update_error', 'Update Failed.');
            $assign_assets_update_error = $this->session->flashdata('assign_assets_update_error');
            $current_url_session = $this->session->userdata('current_url_session');
            redirect($current_url_session);
        }
    }

    public function update_assigned_assets_quantity_in_assets_info($assets_info_id = 0) {
        if (get_user_permission('assign_assets') === false) {
            redirect(base_url('user_login'));
        }
        if (!empty($assets_info_id) && ((int) $assets_info_id > 0)) {
            $assign_assets_quantity_total = $this->get_assign_assets_information_by_assets_info_id($assets_info_id);
            $assets_info_data = array(
                'id' => $assets_info_id,
                'assigned_assets_quantity' => $assign_assets_quantity_total,
            );
            $this->db->where('id', $assets_info_data['id']);
            $this->Assets_info_Model->db->update('assets_info', $assets_info_data);
        }
    }

    public function get_assign_assets_information_by_assets_info_id($assets_info_id = 0) {
        if (get_user_permission('assign_assets') === false) {
            redirect(base_url('user_login'));
        }

        $all_assign_assets_information_by_assets_info_id = $this->Assign_assets_Model->get_all_assign_assets_by_assets_info_id($assets_info_id);
        $assign_assets_quantity_total = 0;
        if (!empty($all_assign_assets_information_by_assets_info_id)) {
            foreach ($all_assign_assets_information_by_assets_info_id as $all_assign_assets_information)
                $assign_assets_quantity_total += (int) $all_assign_assets_information->quantity;
        }
        return $assign_assets_quantity_total;
    }

    public function clear_assign_assets_table_session() {  // clear assets table
        $this->session->unset_userdata('assign_assets');
        redirect(base_url('assign_assets/create_new_assign_assets'));
    }

    public function delete_single_asset_from_table() {
        if (get_user_permission('assign_assets') === false) {
            redirect(base_url('user_login'));
        }

        if ($this->input->is_ajax_request()) {
            $array_id = trim($this->input->post('array_id'));
            $assign_assets = $this->session->userdata('assign_assets');  // product table list session
            if ((!empty($assign_assets))) {
                $assets_array = array();
                foreach ($assign_assets as $assign_asset) {
                    if ($array_id != $assign_asset['array_id']) {
                        array_push($assets_array, $assign_asset);
                    }
                }
                $this->session->set_userdata('assign_assets', $assets_array);
                $this->data['assets_info_list'] = $this->Assets_info_Model->get_assets_info();
                $this->data['employee_list'] = $this->Employee_Model->get_employee();
                $this->load->view('assign_assets/assets_info_table', $this->data);
            } else {
                redirect(base_url('assign_assets/create_new_assign_assets'));
            }
        } else {
            redirect(base_url('assign_assets/create_new_assign_assets'));
        }
    }

}
