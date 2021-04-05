<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Envelope_print_Model extends CI_Model {

    public $table_name = 'envelope_print';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_envelope_print($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
    }

    public function get_all_envelope_print($envelope_id = 0) {
        if ((int) $envelope_id > 0) {
            $query = $this->db->query("SELECT ep.id, ep.envelope_title, ep.from_envelope_details, ep.to_envelope_details, ep.envelope_size, ep.current_date_time, ep.user_id, u.user_name, u.user_type FROM envelope_print ep LEFT JOIN user_info u ON ep.user_id = u.id WHERE ep.id = '$envelope_id'")->row();
        } else {
            $query = $this->db->query("SELECT ep.id, ep.envelope_title, ep.from_envelope_details, ep.to_envelope_details, ep.envelope_size, ep.current_date_time, ep.user_id, u.user_name, u.user_type FROM envelope_print ep LEFT JOIN user_info u ON ep.user_id = u.id")->result();
        }
        return $query;
    }

}
