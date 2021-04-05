<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Model extends CI_Model {

    public $table_name = 'company_info';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_company($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->row();  // get single company information
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_company($id = 0) {
        $this->load->helper('url');
        $data = array(
            'company_name_1' => $this->input->post('company_name_1'),
            'company_name_2' => $this->input->post('company_name_2'),
            'company_address_1' => $this->input->post('company_address_1'),
            'company_address_2' => $this->input->post('company_address_2'),
            'phone' => $this->input->post('phone'),
            'mobile' => $this->input->post('mobile'),
            'fax' => $this->input->post('fax'),
            'email' => $this->input->post('email'),
            'website' => $this->input->post('website'),
        );
        if ($id === 0) {
            return $this->db->insert($this->table_name, $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update($this->table_name, $data);
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('company_info');
    }

    public function is_company_name_exists($name) {
        return $result = $this->db->get_where($this->table_name, array('company_name_1' => $name))->row();
    }

    public function get_company_by_id_for_duplicate_check($name, $id) {
        return $result = $this->db->query("SELECT * FROM company_info WHERE company_name_1 = '$name' AND id != $id")->row();
    }

    public function is_super_password($password) { // encrypt password
        $company = $this->get_company();
        $super_password = (!empty($company)) ? $company->super_password : '';
        return ($password === $super_password) ? TRUE : FALSE;
    }

}
