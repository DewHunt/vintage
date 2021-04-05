<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('User_Model');
        $this->load->model('Notification_Model');
        $this->load->model('Notification_assign_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Company_Model');
        $this->load->model('Employee_leave_details_Model');
    }

    public function index() {
        if (!empty($this->session->userdata('user_session'))) {
            $this->data['title'] = "Notification";
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // sess$ion user id
            $employee_id = $user_info['employee_id']; // session user id

            $this->save_notification_assign_is_show_true($employee_id);

            $this->data['company_information'] = $this->Company_Model->get_company();

            $this->data['employee_list'] = $this->Employee_Model->get_employee();

            $employee_all_received_message = $this->Notification_Model->get_employee_all_received_message($employee_id, 5); // employee_id, limit
            $this->data['employee_all_received_message'] = $employee_all_received_message;

            $employee_all_sent_message = $this->Notification_Model->get_employee_all_sent_message($user_id, 5); // creator_id, limit
            $this->data['employee_all_sent_message'] = $employee_all_sent_message;

            $last_sent_message = $this->Notification_Model->get_last_sent_message($user_id, $limit = 1); // creator_id, employee_id, limit
            if (!empty($last_sent_message)) {
                $employee_by_notification_id = $this->Notification_Model->get_employee_message_by_notification_id($last_sent_message->id);
                $this->data['last_sent_message'] = $last_sent_message;
                $this->data['employee_by_notification_id'] = $employee_by_notification_id;
            }
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('notification/notification', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function save_notification_assign_is_show_true($employee_id) {  //make is_show true
        $is_show_notification_false_list = $this->Notification_assign_Model->get_is_show_notification_assign(0, $employee_id);  //$is_show, $employee_id
        if (!empty($is_show_notification_false_list)) {
            foreach ($is_show_notification_false_list as $is_show_notification_false) {
                $data = array(
                    'id' => $is_show_notification_false->id,
                    'is_show' => TRUE,
                );
                $this->db->where('id', $data['id']);
                $this->Notification_assign_Model->db->update('notification_assign', $data);
            }
        }
    }

    public function create_new_notification() {
        if (!empty($this->session->userdata('user_session'))) {
            $this->data['title'] = "Notification";
            $this->data['employee_list'] = $this->Employee_Model->get_employee();
            $this->session->unset_userdata('on_leave_message_session');
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('notification/create_new_notification', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function send_new_notification() {  //save new notification
        if (!empty($this->session->userdata('user_session'))) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id

            date_default_timezone_set("Asia/Dhaka");
            $current_date_time = date("Y-m-d H:i:s");

            $message_title = trim($this->input->post('message_title'));
            $message_body = trim($this->input->post('message_body'));
            $employee_id_list = $this->input->post('employee_id_list');
            $propose_time = trim($this->input->post('propose_time'));
            if ((!empty($message_body)) && (!empty($message_title))) {
                if ((!empty($employee_id_list))) {
                    $notification_data = array(
                        'creator_id' => $user_id,
                        'message_title' => $message_title,
                        'message_body' => $message_body,
                        'notification_date_time' => $current_date_time,
                        'propose_time' => $propose_time,
                    );
                    $this->Notification_Model->db->insert('notification', $notification_data);
                    $currently_inserted_notification_id = $this->db->insert_id();

                    if (!empty($currently_inserted_notification_id)) {
                        foreach ($employee_id_list as $employee_id) {
                            $notification_assign_data = array(
                                'notification_id' => $currently_inserted_notification_id,
                                'employee_id' => $employee_id,
                                'open_date_time' => '0000-00-00 00:00:00',
                                'is_show' => FALSE,
                            );
                            $this->Notification_assign_Model->db->insert('notification_assign', $notification_assign_data);
                        }
                        $this->session->set_flashdata('send_success_message', 'Message has been sent successfully.');
                        redirect(base_url('notification/create_new_notification'));
                    }
                } else {
                    $this->session->set_flashdata('employee_error', 'Please select employee to send message.');
                    redirect(base_url('notification/create_new_notification'));
                }
            } else {
                $this->session->set_flashdata('message_error', 'Please write a message with title to send.');
                redirect(base_url('notification/create_new_notification'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function view_more_modal_show() {
        if (!empty($this->session->userdata('user_session'))) {
            $this->data['title'] = "View More Modal";
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id

            $last_sent_message = $this->Notification_Model->get_last_sent_message($user_id, $limit = 1); // creator_id, employee_id, limit
            if (!empty($last_sent_message)) {
                $employee_by_notification_id = $this->Notification_Model->get_employee_message_by_notification_id($last_sent_message->id);
            }
            $this->data['last_sent_message'] = $last_sent_message;
            $this->data['employee_by_notification_id'] = $employee_by_notification_id;
            $this->load->view('notification/view_more_modal', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function old_message_view_more_modal_show() {
        if (!empty($this->session->userdata('user_session'))) {
            $this->data['title'] = "View More Modal";
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $notification_id = $this->input->post('id');  // notification_id

            $employee_by_notification_id = $this->Notification_Model->get_employee_message_by_notification_id($notification_id);
            $this->data['employee_by_notification_id'] = $employee_by_notification_id;
            $this->load->view('notification/old_message_view_more_modal', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function employee_all_received_message_show() {
        if (!empty($this->session->userdata('user_session'))) {
            $this->data['title'] = "Notification";
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $employee_id = $user_info['employee_id']; // session employee id
            $employee_all_received_message = $this->Notification_Model->get_employee_all_received_message($employee_id, 5);
            $this->data['employee_all_received_message'] = $employee_all_received_message;
            $employee_total_received_message = $this->Notification_Model->get_employee_all_received_message($employee_id, 0);
            $this->data['employee_total_received_message'] = $employee_total_received_message;
            $this->load->view('notification/old_received_message_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function employee_all_sent_message_show() {
        if (!empty($this->session->userdata('user_session'))) {
            $this->data['title'] = "Notification";
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $employee_all_sent_message = $this->Notification_Model->get_employee_all_sent_message($user_id, 5);  // creator_id, limit
            $this->data['employee_all_sent_message'] = $employee_all_sent_message;
            $employee_total_sent_message = $this->Notification_Model->get_employee_all_sent_message($user_id, 0);
            $this->data['employee_total_sent_message'] = $employee_total_sent_message;
            $this->load->view('notification/old_sent_message_table', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function sent_message_details_view_modal_show() {  //voucher report details show in Modal
        if (!empty($this->session->userdata('user_session'))) {
            $notification_id = $this->input->post('id');  // notification_id
            $creator_by_notification_id = $this->Notification_Model->get_creator_by_notification_id($notification_id);
            $this->data['creator_by_notification_id'] = $creator_by_notification_id;
            $employee_by_notification_id = $this->Notification_Model->get_employee_message_by_notification_id($notification_id);
            $this->data['employee_by_notification_id'] = $employee_by_notification_id;
            $this->load->view('notification/sent_message_details_view_modal', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function received_message_details_view_modal_show() {  //voucher report details show in Modal
        if (!empty($this->session->userdata('user_session'))) {
            $notification_id = trim($this->input->post('id'));  // notification_id
            $creator_by_notification_id = $this->Notification_Model->get_creator_by_notification_id($notification_id);
            $this->data['creator_by_notification_id'] = $creator_by_notification_id;
            $employee_by_notification_id = $this->Notification_Model->get_employee_message_by_notification_id($notification_id);
            $this->data['employee_by_notification_id'] = $employee_by_notification_id;
            $this->load->view('notification/received_message_details_view_modal', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function view_all_sent_message_modal_show() {
        if (!empty($this->session->userdata('user_session'))) {
            $this->data['title'] = "Notification";
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $employee_all_sent_message = $this->Notification_Model->get_employee_all_sent_message($user_id, 50);  // creator_id, limit
            $this->data['employee_all_sent_message'] = $employee_all_sent_message;
            $employee_total_sent_message = $this->Notification_Model->get_employee_all_sent_message($user_id, 0);
            $this->data['employee_total_sent_message'] = $employee_total_sent_message;
            $this->load->view('notification/view_all_sent_message_modal', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function view_all_received_message_modal_show() {
        if (!empty($this->session->userdata('user_session'))) {
            $this->data['title'] = "Notification";
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $employee_id = $user_info['employee_id']; // session employee id
            $employee_total_received_message = $this->Notification_Model->get_employee_all_received_message($employee_id, 0);
            $this->data['employee_total_received_message'] = $employee_total_received_message;
            $this->load->view('notification/view_all_received_message_modal', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function get_selected_employee_leave_information() {
        if ($this->input->is_ajax_request()) {
            $employee_id = trim($this->input->post('employee_id'));
            $propose_time = trim($this->input->post('propose_time'));
            //$propose_time = $propose_time . ' 00:00:00';
            $status = trim($this->input->post('status'));
            $query_result = $this->Employee_leave_details_Model->get_employee_leave_details_by_propose_time($employee_id, $propose_time);
            $on_leave_message_array = $this->session->userdata('on_leave_message_session');
            if (!is_array($on_leave_message_array))
                $on_leave_message_array = array();
            if (!empty($query_result)) {
                $employee = $this->Employee_Model->get_employee($employee_id);
                $employee_information_array = array(
                    'employee_id' => $employee->id,
                    'employee_name' => $employee->employee_name,
                );
                $result = '';
                if (in_array($employee_information_array, $on_leave_message_array)) {
                    $result = 'exists';
                }
                if ($result != 'exists') {
                    array_push($on_leave_message_array, $employee_information_array);
                }
                $this->session->set_userdata('on_leave_message_session', $on_leave_message_array);
            } else {
                $on_leave_message_array = $this->session->userdata('on_leave_message_session');
                if (!is_array($on_leave_message_array))
                    $on_leave_message_array = array();
            }
            // for pop message from array
            $on_leave_message_array1 = $this->pop_value_from_leave_message($employee_id, $on_leave_message_array, $status);

            if ($status === 'true') {
                if (!empty($on_leave_message_array)) {
                    foreach ($on_leave_message_array as $on_leave_message) {
                        print_r('<p>' . ucfirst($on_leave_message['employee_name']) . ' is on leave.' . '</p>');
                    }
                }
            } else {
                if (!empty($on_leave_message_array1)) {
                    foreach ($on_leave_message_array1 as $on_leave_message) {
                        print_r('<p>' . ucfirst($on_leave_message['employee_name']) . ' is on leave.' . '</p>');
                    }
                }
            }
        }
    }

    public function pop_value_from_leave_message($employee_id, $on_leave_message_array, $status) {
        if ($status === 'false') {
            $employee = $this->Employee_Model->get_employee($employee_id);
            $employee_information_array = array(
                'employee_id' => $employee->id,
                'employee_name' => $employee->employee_name,
            );
            $result = '';
            if (in_array($employee_information_array, $on_leave_message_array)) {
                $result = 'exists';
            }
            if ($result == 'exists') {
                if (($key = array_search($employee_information_array, $on_leave_message_array)) !== false) {
                    unset($on_leave_message_array[$key]);
                }
                $this->session->set_userdata('on_leave_message_session', $on_leave_message_array);
                return $on_leave_message_array;
            }
        } else {
            
        }
    }

}
