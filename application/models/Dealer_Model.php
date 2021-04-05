<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dealer_Model extends CI_Model
{
    public $table_name = 'dealer_info';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_dealer($id = 0)
    {
        if ($id === 0) {
            /*$query = $this->db->get_where($this->table_name);
            return $query->result();*/
            $this->db->from($this->table_name);
            $this->db->order_by("dealer_name", "asc");
            $query = $this->db->get();
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_dealer($id = 0)
    {
        $this->load->helper('url');
        $data = array(
            'dealer_name' => $this->input->post('dealer_name'),
            'dealer_code' => $this->input->post('dealer_code'),
            'address' => $this->input->post('address'),
            'cell_number' => $this->input->post('cell_number'),
            'phone_number' => $this->input->post('phone_number'),
            'email' => $this->input->post('email'),
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
        $this->db->delete($this->table_name);
    }

    function is_dealer_name_exists($dealer_name)
    {
        $result = $this->db->get_where($this->table_name, array('dealer_name' => $dealer_name))->row();
        return $result;
    }

    function get_dealer_by_id_for_duplicate_check($name, $id)
    {
        $result = $this->db->query("SELECT * FROM dealer_info WHERE dealer_name = '$name' AND id != $id")->row();
        return $result;
    }
}
