<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_assign_Model extends CI_Model
{
    public $table_name = 'notification_assign';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_notification_assign($id = 0)
    {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_notification_assign($id = 0)
    {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'notification_id' => $this->input->post('notification_id'),
            'employee_id' => $this->input->post('employee_id'),
            'open_date_time' => $this->input->post('open_date_time'),
            'is_show' => $this->input->post('is_show'),
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

    public function get_is_show_notification_assign($is_show, $employee_id)
    {
        $query = $this->db->query("SELECT * FROM notification_assign WHERE employee_id = $employee_id AND is_show = $is_show");
        return $query->result();
    }
}
