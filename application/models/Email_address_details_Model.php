<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Email_address_details_Model extends CI_Model {

    public $table_name = 'email_address_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_email_address_details($id = 0) {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->row();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
    }

    public function get_email_address_details_column_value($email_address_details) {
        $arr = array();
        if (!empty($email_address_details)) {
            $id = !empty($email_address_details->id) ? intval($email_address_details->id) : 0;

            $email_to = !empty($email_address_details->email_to) ? $email_address_details->email_to : '';
            $email_to = (is_json($email_to)) ? json_decode($email_to) : '';
            $email_to = implode(",", $email_to);

            $email_cc = !empty($email_address_details->email_cc) ? $email_address_details->email_cc : '';
            $email_cc = (is_json($email_cc)) ? json_decode($email_cc) : '';
            $email_cc = implode(",", $email_cc);

            $email_bcc = !empty($email_address_details->email_bcc) ? $email_address_details->email_bcc : '';
            $email_bcc = (is_json($email_bcc)) ? json_decode($email_bcc) : '';
            $email_bcc = implode(",", $email_bcc);
            $arr = array(
                'id' => $id,
                'email_to' => $email_to,
                'email_cc' => $email_cc,
                'email_bcc' => $email_bcc
            );
        }
        return $arr;
    }

    public function get_email_address_details_for_email() {
        $arr = array();
        $email_address_details = $this->get_email_address_details();
        if (!empty($email_address_details)) {
            $id = !empty($email_address_details) ? intval($email_address_details->id) : 0;
            $email_to = !empty($email_address_details) ? (is_json($email_address_details->email_to) ? json_decode($email_address_details->email_to) : '') : '';
            $email_cc = !empty($email_address_details) ? (is_json($email_address_details->email_cc) ? json_decode($email_address_details->email_cc) : '') : '';
            $email_bcc = !empty($email_address_details) ? (is_json($email_address_details->email_bcc) ? json_decode($email_address_details->email_bcc) : '') : '';
            $arr = array(
                'id' => $id,
                'email_to' => $email_to,
                'email_cc' => $email_cc,
                'email_bcc' => $email_bcc
            );
        }
        return $arr;
    }

}
