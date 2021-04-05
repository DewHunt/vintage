<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends CI_Controller
{
    function __construct()
    {
        // Call the Model constructor
        parent:: __construct();
        $this->load->model('Calendar_Model');
        $this->load->helper('settings_helper');
    }

    /*Home page Calendar view  */
    Public function index()
    {
        $user_info = $this->session->userdata('user_session');
        if (!empty($user_info) && (($user_info['user_type']) == 'admin')) {
            $this->load->view('calendar');
        }else{
            redirect(base_url('user_login'));
        }
    }

    /*Get all Events */
    Public function getEvents()
    {
        $result = $this->Calendar_Model->getEvents();
        echo json_encode($result);
    }

    /*Add new event */
    Public function addEvent()
    {
        $result = $this->Calendar_Model->addEvent();
        echo $result;
    }

    /*Update Event */
    Public function updateEvent()
    {
        $result = $this->Calendar_Model->updateEvent();
        echo $result;
    }

    /*Delete Event*/
    Public function deleteEvent()
    {
        $result = $this->Calendar_Model->deleteEvent();
        echo $result;
    }

    /*Drag Event*/
    Public function dragUpdateEvent()
    {
        $result = $this->Calendar_Model->dragUpdateEvent();
        echo $result;
    }
}
