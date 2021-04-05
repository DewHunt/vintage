<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Printer_setup extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Printer_setup_model');
    }

    public function index() {  // load Branch details
        if (get_user_permission('printer_setup') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "Printer Setup";
        $this->data['printer_list'] = $this->Printer_setup_model->get_all_printer();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('printer_setup/index', $this->data);
    }

    public function add() { // load create new Branch page
        if (get_user_permission('printer_setup') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "Add New Printer";
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('printer_setup/add', $this->data);
    }

    public function save() {  // save Branch information
        if (get_user_permission('printer_setup') === false) {
            redirect(base_url('user_login'));
        }
        // echo "<pre>"; print_r($this->input->post()); exit();

        $this->data['title'] = 'Save Printer Name';
        $printerData = array(
            'name' => trim($this->input->post('name')),
            'address' => trim($this->input->post('printerAddress')),
        );
        $this->Printer_setup_model->db->insert('printer_info', $printerData);
        $this->session->set_flashdata('successMessage', 'Printer Saved Successfully.');
        redirect(base_url('printer_setup'));
    }

    public function edit($printerId) { // load create new Branch page
        if (get_user_permission('printer_setup') === false) {
            redirect(base_url('user_login'));
        }
        // echo "<pre>"; print_r($printerId); exit();

    	$printerInfo = $this->Printer_setup_model->get_printer_info_by_id($printerId);
        $this->data['title'] = "Edit Printer";
        $this->data['printerInfo'] = $printerInfo;
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('printer_setup/edit', $this->data);
    }

    public function update() {  // save Branch information
        if (get_user_permission('printer_setup') === false) {
            redirect(base_url('user_login'));
        }
        // echo "<pre>"; print_r($this->input->post()); exit();
        $printerId = $this->input->post('printerId');

        $this->data['title'] = 'Save Printer Name';
        $printerData = array(
            'name' => trim($this->input->post('name')),
            'address' => trim($this->input->post('printerAddress')),
        );

        $this->db->where('id', $printerId);
        $this->Printer_setup_model->db->update('printer_info', $printerData);
        $this->session->set_flashdata('successMessage', 'Printer Updated Successfully.');
        redirect(base_url('printer_setup'));
    }

    public function delete($id) {
        if (get_user_permission('printer_setup') === false) {
            redirect(base_url('user_login'));
        }
        $this->Printer_setup_model->delete($id);
        redirect(base_url('printer_setup'));
    }

}
