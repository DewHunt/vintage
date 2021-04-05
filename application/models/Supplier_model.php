<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model {

    public $table_name = 'supplier';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_supplier()
    {
    	$result = $this->db->query("SELECT * FROM supplier ORDER BY name ASC")->result();

    	return $result;
    }

    public function get_supplier_info_by_id($id)
    {
    	$result = $this->db->query("SELECT * FROM supplier WHERE id = $id")->row();

    	return $result;
    }

    public function cheack_supplier_exists($supplier_conatact_number,$contact_person_conatact_number,$email)
    {
    	$isExists = $this->db->query("SELECT * FROM supplier WHERE supplier_contact_number = '$supplier_conatact_number' OR contact_person_contact_number = '$contact_person_conatact_number' OR email = '$email'")->row();

    	return $isExists;
    }

    public function cheack_supplier_exists_by_id($supplier_conatact_number,$contact_person_conatact_number,$email,$id)
    {
    	$isExists = $this->db->query("SELECT * FROM supplier WHERE (supplier_contact_number = '$supplier_conatact_number' OR contact_person_contact_number = '$contact_person_conatact_number' OR email = '$email') AND id <> $id")->row();

    	return $isExists;
    }

    public function update_status($id)
    {
    	$result = $this->db->query("SELECT * FROM supplier WHERE id = $id")->row();

    	// echo "<pre>"; print_r($findResult); exit();

    	if ($result->status == 0) {
    		$status = 1;
    	} else {
    		$status = 0;
    	}

    	$update = $this->db->query("UPDATE supplier SET status = $status WHERE id = $id");

    	if ($this->db->affected_rows() > 0)
    	{
    		return TRUE;
    	}
    	return FALSE; 
    }
}
