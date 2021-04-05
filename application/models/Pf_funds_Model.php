<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pf_funds_Model extends CI_Model
{
    public $table_name = 'pf_funds';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_pf_funds($id = 0)
    {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_pf_funds($id = 0)
    {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'employee_id' => $this->input->post('employee_id'),
            'pf_contribution_per_month' => $this->input->post('pf_contribution_per_month'),
            'total_deposit_amount' => $this->input->post('total_deposit_amount'),
            'starting_date' => $this->input->post('starting_date'),
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
        $this->db->delete('pf_funds');
    }

    public function get_pf_funds_by_employee_id($employee_id)
    {
        return $query = $this->db->query("SELECT * FROM pf_funds WHERE employee_id = $employee_id")->row();
    }

    public function get_pf_funds_current_month_by_employee_id($employee_id = 0)
    {
        //return $result = $this->db->query("SELECt * FROM pf_funds WHERE employee_id = $employee_id" AND date >= '$start_date' AND date <= '$end_date')->row();
    }
}
