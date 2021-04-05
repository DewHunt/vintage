<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar_model extends CI_Model
{
    public $table_name = 'events';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    /*Read the data from DB */
    Public function getEvents()
    {
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id'];
        $sql = "SELECT * FROM events WHERE events.date BETWEEN ? AND ? AND user_id = $user_id OR user_id = 0 ORDER BY events.date ASC";
        return $this->db->query($sql, array($_GET['start'], $_GET['end'],))->result();
    }
    /*Create new events */
    Public function addEvent()
    {
        $sql = "INSERT INTO events (title, events.date, description, color, user_id) VALUES (?,?,?,?,?)";
        $this->db->query($sql, array($_POST['title'], $_POST['date'], $_POST['description'], $_POST['color'], $_POST['user_id']));
        return ($this->db->affected_rows() != 1) ? false : true;
    }
    /*Update  event */
    Public function updateEvent()
    {
        $id = $_POST['id'];
        $event_information = $this->db->get_where($this->table_name, array('id' => $id))->row();
        if ($event_information->user_id == 0) {
            return false;
        } else {
            $sql = "UPDATE events SET title = ?, events.date = ?, description = ?, color = ? WHERE id = ?";
            $this->db->query($sql, array($_POST['title'], $_POST['date'], $_POST['description'], $_POST['color'], $_POST['id']));
            return ($this->db->affected_rows() != 1) ? false : true;
        }
    }
    /*Delete event */
    Public function deleteEvent()
    {
        $id = $_GET['id'];
        $event_information = $this->db->get_where($this->table_name, array('id' => $id))->row();
        if ($event_information->user_id == 0) {
            return false;
        } else {
            $sql = "DELETE FROM events WHERE id = ?";
            $this->db->query($sql, array($_GET['id']));
            return ($this->db->affected_rows() != 1) ? false : true;
        }
    }
    /*Update  event */
    Public function dragUpdateEvent()
    {
        $id = $_POST['id'];
        $event_information = $this->db->get_where($this->table_name, array('id' => $id))->row();
        if ($event_information->user_id == 0) {
            return false;
        } else {
            $date = date('Y-m-d h:i:s', strtotime($_POST['date']));
            $sql = "UPDATE events SET  events.date = ? WHERE id = ?";
            $this->db->query($sql, array($date, $_POST['id']));
            return ($this->db->affected_rows() != 1) ? false : true;
        }
    }
}