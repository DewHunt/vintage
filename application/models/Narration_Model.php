<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Narration_Model extends CI_Model
{
    public $table_name = 'narration';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_narration($id = 0)
    {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_narration($id = 0)
    {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'narration' => $this->input->post('narration'),
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
        $this->db->delete('narration');
    }

    public function get_narration_by_narration($narration)
    {
        $query = $this->db->get_where($this->table_name, array('narration' => $narration));
        return $query->row();
    }

    public function get_narration_by_narration_id_for_duplicate_check($narration, $id)
    {
        return $query = $this->db->query("SELECT * FROM narration WHERE narration='$narration' AND id != $id")->row();
    }
}
