<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assets_info_Model extends CI_Model
{
    public $table_name = 'assets_info';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_assets_info($id = 0)
    {
        if ($id === 0) {
            /*$query = $this->db->get_where($this->table_name);
            return $query->result();*/
            $this->db->from($this->table_name);
            $this->db->order_by("assets_name", "asc");
            $query = $this->db->get();
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_assets_info($id = 0)
    {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'assets_name' => $this->input->post('assets_name'),
            'assets_code' => $this->input->post('assets_code'),
            'assets_quantity' => $this->input->post('assets_quantity'),
            'assigned_assets_quantity' => $this->input->post('assigned_assets_quantity'),
            'entry_date' => $this->input->post('entry_date'),
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
        $this->db->delete('assets_info');
    }

    public function get_assets_info_by_name($assets_name)
    {
        $result = $this->db->query("SELECT * FROM assets_info WHERE assets_name = '$assets_name'")->row();
        return $result;
    }

    public function get_assets_info_by_id_for_duplicate_check($assets_name, $id)
    {
        $result = $this->db->query("SELECT * FROM assets_info WHERE assets_name='$assets_name' AND id != $id")->row();
        return $result;
    }
}
