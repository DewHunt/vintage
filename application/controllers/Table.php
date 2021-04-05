<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Table extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->helper('file');
        $this->load->model('User_Model');
        $this->load->model('Table_model');
        $this->load->model('Branch_Model');
    }

    public function index() {
        if (get_user_permission('table') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['branch_list'] = $this->Branch_Model->get_any_type_branch('AND',0,0);            
        $this->data['title'] = "Table Lists";
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('table/index', $this->data);
    }

    public function get_table_info_by_branch_id()
    {
    	$branch_id = $this->input->post('branchId');
    	$this->data['table_list'] = $this->Table_model->get_all_by_branch_id($branch_id);

    	$output = $this->load->view('table/table_list',$this->data,true);
        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
        )));
    }

    public function add() {
        if (get_user_permission('branch') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = "Add New Table";
        $this->data['outlet_lists'] = $this->Branch_Model->get_any_type_branch('AND',0,0);
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('table/add',$this->data);
    }

    public function save() {  // save company information
        if (get_user_permission('branch') === false) {
            redirect(base_url('user_login'));
        }

    	// echo "<pre>"; print_r($this->input->post()); exit();
    	$branch_id = $this->input->post('outletId');
    	$number = $this->input->post('tablenNumber');
    	$is_table_exists = $this->Table_model->is_table_exists($branch_id,$number);

    	if ($is_table_exists) {
        	$this->session->set_flashdata('error_message', 'Table Alredy Exists.');
    		redirect(base_url('table/add'));
    	}

        $data = array(
            'branch_id' => $branch_id,
            'table_number' => $number,
            'table_capacity' => $this->input->post('tableCapacity'),
        );

        $this->db->insert('tables', $data);
        $this->session->set_flashdata('success_message', 'Table Saved Successfully.');
        redirect(base_url('table'));
    }

    public function edit($id) {
        if (get_user_permission('branch') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "Edit Table";
        $this->data['outlet_lists'] = $this->Branch_Model->get_any_type_branch('AND',0,0);
        $this->data['table_info'] = $this->Table_model->get_table_by_id($id);
    	// echo "<pre>"; print_r($this->data['table_info']); exit();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('table/edit',$this->data);
    }

    public function update() {
        if (get_user_permission('branch') === false) {
            redirect(base_url('user_login'));
        }

    	// echo "<pre>"; print_r($this->input->post()); exit();
    	$table_id = $this->input->post('table_id');
    	$branch_id = $this->input->post('outletId');
    	$number = $this->input->post('tablenNumber');

    	$is_table_exists = $this->Table_model->is_table_exists($branch_id,$number,$table_id);

    	if ($is_table_exists) {
        	$this->session->set_flashdata('error_message', 'Table Alredy Exists.');
    		redirect(base_url('table/edit/'.$table_id));
    	}

        $data = array(
            'branch_id' => $this->input->post('outletId'),
            'table_number' => $this->input->post('tablenNumber'),
            'table_capacity' => $this->input->post('tableCapacity'),
        );

        $this->db->where('id',$table_id);
        $this->db->update('tables', $data);
        $this->session->set_flashdata('success_message', 'Table Updated Successfully.');
        redirect(base_url('table'));
    }

    public function delete($id) {
        if (get_user_permission('branch') === false) {
            redirect(base_url('user_login'));
        }
        
    	$this->db->delete('tables', array('id' => $id));
        $this->session->set_flashdata('success_message', 'Table Deleted Successfully.');
        redirect(base_url('table'));
    }
}
