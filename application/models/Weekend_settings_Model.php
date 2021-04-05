<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weekend_settings_Model extends CI_Model
{
    public $table_name = 'weekend_settings';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_weekend_settings($id = 0)
    {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_weekend_settings($id = 0)
    {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'weekend_day' => $this->input->post('weekend_day'),
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
        $this->db->delete('weekend_settings');
    }

    public function get_weekend_day_name($weekend_day)
    {
        $query = $this->db->get_where($this->table_name, array('weekend_day' => $weekend_day));
        return $query->row();
    }

    public function get_weekend_day_by_id_for_duplicate_check($weekend_day, $id)
    {
        $result = $this->db->query("SELECT * FROM weekend_settings WHERE weekend_day = '$weekend_day' AND id != $id")->row();
        return $result;
    }
}
