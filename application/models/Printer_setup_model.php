<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Printer_setup_model extends CI_Model
{
    public $table_name = 'printer_info';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_printer()
    {
    	$result = $this->db->query("SELECT * FROM printer_info ORDER BY name")->result();

    	return $result;
    }

    public function get_printer_info_by_id($id)
    {
    	$result = $this->db->query("SELECT * FROM printer_info WHERE id = $id")->row();

    	return $result;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
    }
}
