<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_leave_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Employee_total_leave_Model');
        $this->load->model('Employee_leave_details_Model');
        $this->load->model('Leave_application_Model');
    }

    public function index() {
        if (get_user_permission('reports/hr_report/employee_leave_report/employee_leave_report') === false) {
            redirect(base_url('user_login'));
        }
        $this->data['title'] = "Voucher Report";
        $company_information = $this->Company_Model->get_company();
        $this->data['company_information'] = $company_information;
        $employee_list = $this->Employee_Model->get_employee();
        $this->data['employee_list'] = $employee_list;
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('reports/hr_report/employee_leave_report/employee_leave_report', $this->data);
    }

    public function employee_leave_report_show_in_table() {  //yearly benefit report show in table
        if (get_user_permission('reports/hr_report/employee_leave_report/employee_leave_report') === false) {
            redirect(base_url('user_login'));
        }

        $year = trim($this->input->post('year'));
        if (empty($year)) {
            echo "<div class='error-message text-align-center'>Please Select Year.</div>";
        } else {
            $this->session->set_userdata('year_session', $year);
            $year_session = $this->session->userdata('year_session');
            $employee_id = trim($this->input->post('employee_id'));
            $employee = $this->Employee_Model->get_employee($employee_id);
            if (!empty($employee)) {
                $employee_name = $employee->employee_name;
            } else {
                $employee_name = 'All';
            }
            $employee_total_leave_by_year = $this->get_employee_total_leave_by_year($employee_id, $year);
            $this->data['employee_total_leave_by_year'] = $employee_total_leave_by_year;
            $this->data['year'] = $year;
            $this->data['employee'] = $employee;
            $this->data['employee_name'] = $employee_name;
            $this->data['company_information'] = $this->Company_Model->get_company();
            $this->load->view('reports/hr_report/employee_leave_report/employee_leave_report_table', $this->data);
        }
    }

    public function employee_leave_details_report_show_in_modal() {  //leave report details show in Modal
        if (get_user_permission('reports/hr_report/employee_leave_report/employee_leave_report') === false) {
            redirect(base_url('user_login'));
        }

        $company_information = $this->Company_Model->get_company();
        $this->data['company_information'] = $company_information;
        $id = trim($this->input->post('id'));  // employee_id
        $employee = $this->Employee_Model->get_employee($id);
        $year_session = $this->session->userdata('year_session');
        $employee_leave_details_by_year = $this->get_employee_leave_details_by_year($id, $year_session);
        $this->data['employee_leave_details_by_year'] = $employee_leave_details_by_year;
        $this->data['employee'] = $employee;
        $this->data['year_session'] = $year_session;
        $this->load->view('reports/hr_report/employee_leave_report/employee_leave_report_modal', $this->data);
    }

    public function get_employee_total_leave_by_year($employee_id, $year) {
        if ((int) $employee_id > 0) {
            $where_condition = "WHERE etl.employee_id = $employee_id AND etl.year = '$year' ORDER BY e.sort_order ASC";
        } else {
            $where_condition = "WHERE etl.year = '$year' ORDER BY e.sort_order ASC";
        }
        $query = $this->db->query("SELECT etl.id, etl.employee_id, etl.year, etl.total_casual_leave, etl.total_medical_leave, etl.total_earn_leave, etl.paid_casual_leave, etl.paid_medical_leave, etl.paid_earn_leave, e.employee_name, e.employee_code, e.designation FROM employee_total_leave etl LEFT JOIN employee_info e ON etl.employee_id= e.id $where_condition");
        return $query->result();
    }

    public function get_employee_leave_details_by_year($employee_id, $year) {
        $from_date = $year . '-01-01 00:00:00';
        $to_date = $year . '-12-31 23:59:59';
        $query = $this->db->query("SELECT eld.id, eld.employee_id, eld.leave_type, eld.start_date, eld.end_date, eld.total_day, eld.comments, eld.comments, eld.entry_date, eld.user_id, eld.employee_total_leave_id FROM employee_leave_details eld LEFT JOIN employee_info e ON eld.employee_id=e.id WHERE eld.employee_id= $employee_id AND eld.start_date >= '$from_date' AND eld.end_date <= '$to_date' ORDER BY eld.id DESC");
        return $query->result();
    }

    
//    For leave application part
    public function leave_application_report_show_in_table() { // show in table        
        if (get_user_permission('reports/hr_report/employee_leave_report/employee_leave_report') === false) {
            redirect(base_url('user_login'));
        }

        $is_show_leave_application_false_list = $this->Leave_application_Model->get_leave_application_by_is_show(FALSE);
        $this->data['is_show_leave_application_false_list'] = $is_show_leave_application_false_list;
        $this->get_leave_application_is_show_true($is_show_leave_application_false_list);
        $this->data['title'] = 'Leave Application Report';
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('reports/hr_report/leave_application_report/leave_application_report_table', $this->data);
        
    }

    public function get_leave_application_is_show_true($is_show_leave_application_false_list) {
        if (!empty($is_show_leave_application_false_list)) {
            foreach ($is_show_leave_application_false_list as $is_show_leave_application_false) {
                $leave_application_data = array(
                    'id' => $is_show_leave_application_false->id,
                    'is_show' => TRUE,
                );
                $this->db->where('id', $leave_application_data['id']);
                $this->Leave_application_Model->db->update('leave_application', $leave_application_data);
            }
        }
    }

    public function leave_application_report_show_in_modal() {
        $this->data['title'] = 'Leave Application';
        $id = trim($this->input->post('id'));
        $leave_application_by_leave_application_id = $this->Leave_application_Model->get_leave_application_by_leave_application_id($id);
        $this->data['leave_application_by_leave_application_id'] = $leave_application_by_leave_application_id;
        $this->data['company_information'] = $this->Company_Model->get_company();
        $this->load->view('reports/hr_report/leave_application_report/leave_application_report_modal', $this->data);
    }

    public function reject_reason_update_in_leave_application() {
        if (get_user_permission('reports/hr_report/employee_leave_report/employee_leave_report') === false) {
            redirect(base_url('user_login'));
        }

        if ($this->input->is_ajax_request()) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $accept_reject_employee_id = $user_info['employee_id']; // session user id
            $leave_application_id = trim($this->input->post('leave_application_id'));
            $reject_reason = trim($this->input->post('reject_reason'));
            $application_status = 'reject';
            $result = $this->update_leave_application_information($leave_application_id, $application_status, $accept_reject_employee_id, $reject_reason);
            echo $result;
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function accept_leave_application() {
        if (get_user_permission('reports/hr_report/employee_leave_report/employee_leave_report') === false) {
            redirect(base_url('user_login'));
        }

        if ($this->input->is_ajax_request()) {
            $this->data['title'] = "Employee Leave Save";
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $accept_reject_employee_id = $user_info['employee_id']; // session user id
            $current_date = get_current_date();  //entry_date
            $current_year = get_current_year(); // current year
            $leave_application_id = trim($this->input->post('leave_application_id'));
            $leave_application_by_leave_application_id = $this->Leave_application_Model->get_leave_application_by_leave_application_id($leave_application_id);
            $employee_id = $leave_application_by_leave_application_id->employee_id;
            $leave_type = $leave_application_by_leave_application_id->leave_type;
            $start_date = $leave_application_by_leave_application_id->start_date;
            $end_date = $leave_application_by_leave_application_id->end_date;
            $total_day = $leave_application_by_leave_application_id->total_day;
            $comments = $leave_application_by_leave_application_id->leave_details;

            $employee_total_leave_by_current_year = $this->Employee_total_leave_Model->get_employee_total_leave_by_current_year($employee_id, $current_year);
            $employee_leave_details_data = array(
                'employee_id' => $employee_id,
                'leave_type' => $leave_type,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_day' => $total_day,
                'comments' => $comments,
                'entry_date' => $current_date,
                'user_id' => $user_id,
                'employee_total_leave_id' => ($employee_total_leave_by_current_year->id),
            );
            $leave_information_ability = $this->Employee_total_leave_Model->get_leave_information_ability($employee_id, $leave_type, $total_day);
            if ($leave_information_ability == FALSE) {
                echo 'no';  //echo 'Insufficient Leave';
            } else {
                $save_result = $this->Employee_leave_details_Model->db->insert('employee_leave_details', $employee_leave_details_data);
                // update_employee_total_leave while employee take a leave
                $this->update_employee_total_leave($employee_total_leave_by_current_year, $leave_type, $total_day);
                $application_status = 'accept';
                $reject_reason = '';
                $this->update_leave_application_information($leave_application_id, $application_status, $accept_reject_employee_id, $reject_reason);
                echo 'yes'; //echo 'Employee Leave Information has been saved Successfully';
            }
        } else {
            redirect(base_url('user_login'));
        }
        
    }

    public function update_employee_total_leave($employee_total_leave_by_current_year, $leave_type, $total_day) {
        if (strtolower($leave_type) == 'casual') {
            $paid_casual_leave = (int) $employee_total_leave_by_current_year->paid_casual_leave + (int) $total_day;
        } elseif (strtolower($leave_type) == 'medical') {
            $paid_medical_leave = (int) $employee_total_leave_by_current_year->paid_medical_leave + (int) $total_day;
        } else {  // For earn leave
            $paid_earn_leave = (int) $employee_total_leave_by_current_year->paid_earn_leave + (int) $total_day;
        }
        $employee_total_leave_data = array(
            'id' => $employee_total_leave_by_current_year->id,
            'employee_id' => $employee_total_leave_by_current_year->employee_id,
            'year' => $employee_total_leave_by_current_year->year,
            'total_casual_leave' => $employee_total_leave_by_current_year->total_casual_leave,
            'total_medical_leave' => $employee_total_leave_by_current_year->total_medical_leave,
            'total_earn_leave' => $employee_total_leave_by_current_year->total_earn_leave,
            'paid_casual_leave' => !empty($paid_casual_leave) ? $paid_casual_leave : $employee_total_leave_by_current_year->paid_casual_leave,
            'paid_medical_leave' => !empty($paid_medical_leave) ? $paid_medical_leave : $employee_total_leave_by_current_year->paid_medical_leave,
            'paid_earn_leave' => !empty($paid_earn_leave) ? $paid_earn_leave : $employee_total_leave_by_current_year->paid_earn_leave,
        );
        $this->db->where('id', $employee_total_leave_data['id']);
        $result = $this->Employee_total_leave_Model->db->update('employee_total_leave', $employee_total_leave_data);
        return $result;
    }

    public function update_leave_application_information($leave_application_id, $application_status, $accept_reject_employee_id, $reject_reason) {
        $leave_application_data = array(
            'id' => $leave_application_id,
            'application_status' => $application_status,
            'accept_reject_employee_id' => $accept_reject_employee_id,
            'reason' => !empty($reject_reason) ? $reject_reason : '',
        );
        $this->db->where('id', $leave_application_data['id']);
        $result = $this->Leave_application_Model->db->update('leave_application', $leave_application_data);
        return $result;
    }

}
