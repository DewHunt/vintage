<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_Model extends CI_Model
{
    public $table_name = 'notification';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_notification($id = 0)
    {
        if ($id === 0) {
            $query = $this->db->get_where($this->table_name);
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function save_notification($id = 0)
    {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'creator_id' => $this->input->post('creator_id'),
            'message_title' => $this->input->post('message_title'),
            'message_body' => $this->input->post('message_body'),
            'notification_date_time' => $this->input->post('notification_date_time'),
            'propose_time' => $this->input->post('propose_time'),
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

    public function get_last_sent_message($creator_id, $limit)
    {
        return $query = $this->db->query("SELECT n.id, n.creator_id, n.message_title, n.message_body, n.notification_date_time, n.propose_time, na.id AS notification_assign_id, na.employee_id, na.open_date_time, na.is_show, u.user_name FROM notification n JOIN notification_assign na ON n.id=na.notification_id LEFT JOIN user_info u ON n.creator_id=u.id WHERE n.creator_id= $creator_id  ORDER BY n.id DESC LIMIT $limit")->row();
    }

    public function get_employee_message_by_notification_id($notification_id)
    {
        return $query = $this->db->query("SELECT n.id, n.creator_id, n.message_title, n.message_body, n.notification_date_time, n.propose_time, na.id AS notification_assign_id, na.employee_id, na.open_date_time, na.is_show, e.employee_name, e.designation FROM notification n JOIN notification_assign na ON n.id=na.notification_id LEFT JOIN employee_info e ON na.employee_id=e.id WHERE n.id= $notification_id")->result();
    }

    public function get_employee_all_received_message($employee_id, $limit)
    {
        if ($limit > 0) {
            return $query = $this->db->query("SELECT n.id, n.creator_id, n.message_title, n.message_body, n.notification_date_time, n.propose_time, na.id AS notification_assign_id, na.employee_id, na.open_date_time, na.is_show, e.employee_name, e.designation FROM notification n JOIN notification_assign na ON n.id=na.notification_id LEFT JOIN employee_info e ON na.employee_id=e.id WHERE na.employee_id= $employee_id ORDER BY n.id DESC LIMIT $limit")->result();
        } else {
            return $query = $this->db->query("SELECT n.id, n.creator_id, n.message_title, n.message_body, n.notification_date_time, n.propose_time, na.id AS notification_assign_id, na.employee_id, na.open_date_time, na.is_show, e.employee_name, e.designation FROM notification n JOIN notification_assign na ON n.id=na.notification_id LEFT JOIN employee_info e ON na.employee_id=e.id WHERE na.employee_id= $employee_id ORDER BY n.id DESC")->result();
        }
    }

    public function get_employee_all_sent_message($creator_id, $limit)
    {
        if ($limit > 0) {
            return $query = $this->db->query("SELECT n.id, n.creator_id, n.message_title, n.message_body, n.notification_date_time, n.propose_time, na.id AS notification_assign_id, na.employee_id, na.open_date_time, na.is_show, e.employee_name, e.designation, u.user_name FROM notification n JOIN notification_assign na ON n.id=na.notification_id JOIN user_info u ON n.creator_id=u.id LEFT JOIN employee_info e ON na.employee_id=e.id WHERE n.creator_id = $creator_id GROUP BY n.id DESC LIMIT $limit")->result();
        } else {
            return $query = $this->db->query("SELECT n.id, n.creator_id, n.message_title, n.message_body, n.notification_date_time, n.propose_time, na.id AS notification_assign_id, na.employee_id, na.open_date_time, na.is_show, e.employee_name, e.designation, u.user_name FROM notification n JOIN notification_assign na ON n.id=na.notification_id JOIN user_info u ON n.creator_id=u.id LEFT JOIN employee_info e ON na.employee_id=e.id WHERE n.creator_id = $creator_id GROUP BY n.id DESC")->result();
        }
    }

    public function get_creator_by_notification_id($notification_id)
    {
        $query = $this->db->query("SELECT n.id, n.creator_id, n.message_title, n.message_body, n.notification_date_time, n.propose_time, u.user_name FROM notification n JOIN user_info u ON n.creator_id=u.id WHERE n.id = $notification_id");
        return $query->row();
    }
}
