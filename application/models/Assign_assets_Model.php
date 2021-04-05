<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_assets_Model extends CI_Model
{
    public $table_name = 'assign_assets';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_assign_assets($id = 0)
    {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_assign_assets($id = 0)
    {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'assets_info_id' => $this->input->post('assets_info_id'),
            'quantity' => $this->input->post('quantity'),
            'employee_id' => $this->input->post('employee_id'),
            'assign_date' => $this->input->post('assign_date'),
            'user_id' => $this->input->post('user_id'),
        );
        if ($id === 0) {
            return $this->db->insert($this->table_name, $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update($this->table_name, $data);
        }
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('assign_assets');
    }

    public function get_all_assign_assets_by_assets_info_id($assets_info_id = 0)
    {
        $result = $this->db->query("SELECT * FROM assign_assets WHERE assets_info_id = '$assets_info_id'")->result();
        return $result;
    }

    public function get_all_assign_assets_by_employee_view()
    {
        $query = $this->db->query("SELECT a.id, a.assets_info_id, SUM(a.quantity) AS total_quantity, a.employee_id, a.assign_date, a.user_id, e.employee_name, e.employee_code, e.designation FROM assign_assets a JOIN employee_info e ON a.employee_id =e.id GROUP BY a.employee_id");
        return $query->result();
    }

    public function get_assign_assets_by_employee_id($employee_id = 0)
    {
        $query = $this->db->query("SELECT a.id, a.assets_info_id, a.quantity, a.employee_id, a.assign_date, a.user_id, e.employee_name, e.employee_code, e.designation, ai.assets_name FROM assign_assets a JOIN employee_info e ON a.employee_id = e.id JOIN assets_info ai ON a.assets_info_id=ai.id WHERE a.employee_id = '$employee_id'");
        return $query->result();
    }

    public function get_all_assign_assets_by_assets_info_id_view()
    {
        $query = $this->db->query("SELECT a.id, a.assets_info_id, COUNT(a.quantity) AS total_quantity, a.employee_id, a.assign_date, a.user_id, e.employee_name, e.employee_code, e.designation FROM assign_assets a JOIN employee_info e ON a.employee_id =e.id GROUP BY a.assets_info_id");
        return $query->result();
    }
}
