<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Head_details_posting_Model extends CI_Model
{
    public $table_name = 'head_details_posting';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_head_details_posting($id = 0)
    {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_head_details_posting($id = 0)
    {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'head_id' => $this->input->post('head_id'),
            'total_amount' => $this->input->post('total_amount'),
            'debit_amount' => $this->input->post('debit_amount'),
            'credit_amount' => $this->input->post('credit_amount'),
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
        $this->db->delete('head_details_posting');
    }

    public function get_head_details_posting_by_head_id($head_id)
    {
        $query = $this->db->get_where($this->table_name, array('head_id' => $head_id));
        return $query->row();
    }
}