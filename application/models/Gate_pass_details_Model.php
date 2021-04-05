<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gate_pass_details_Model extends CI_Model
{
    public $table_name = 'gate_pass_details';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_gate_pass_details($id = 0)
    {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_gate_pass_details($id = 0)
    {
        $this->load->helper('url');
        $data = array(
            'invoice_id' => $this->input->post('invoice_id'),
            'challan_id' => $this->input->post('challan_id'),
            'branch_id' => $this->input->post('branch_id'),
            'source' => $this->input->post('source'),
            'date_of_issue' => $this->input->post('date_of_issue'),
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
        $this->db->delete('gate_pass_details');
    }
}
