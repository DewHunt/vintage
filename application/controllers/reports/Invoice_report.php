<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->helper('settings_helper');
        $this->load->model('Currency_settings_Model');
        $this->load->model('Company_Model');
        $this->load->model('Invoice_details_Model');
        $this->load->model('Client_Model');
        $this->load->model('Dealer_Model');
        $this->load->model('Employee_Model');
        $this->load->model('Sale_product_Model');
        $this->load->model('Product_Model');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Challan_product_Model');
        $this->load->model('Challan_details_Model');
        $this->load->model('Email_address_details_Model');
        $this->load->model('Branch_Model');
    }

    public function index() {  // load bank details
        if (get_user_permission('reports/invoice_report') === false) {
            redirect(base_url('user_login'));
        }
        $user_info = $this->session->userdata('user_session');
        // echo "<pre>"; print_r($user_info); exit();
        $user_id = $user_info['user_id'];
        $user_type = $user_info['user_type'];
        $employee_id = $user_info['employee_id'];

        $this->data['title'] = "Invoice Report";
        $this->data['client_list'] = $this->Client_Model->get_client();
        // echo "<pre>"; print_r($this->Client_Model->get_client()); exit();
        // $this->data['branch_list'] = $this->Branch_Model->get_branch();

        $factoryStatus = 0;
        $hotKitchenStatus = 0;
        // $this->data['branch_list'] = $this->Branch_Model->get_only_all_branch_by_id($user_info['outlet'],0);
        $this->data['branch_list'] = $this->Branch_Model->get_any_type_branch_by_id($user_info['outlet'],'AND',$factoryStatus,$hotKitchenStatus);
        $this->data['all_client_by_employee_id'] = $this->Client_Model->get_all_client_by_employee_id($employee_id);
        $this->data['company_information'] = $this->Company_Model->get_company();
        $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('reports/invoice_report/invoice_report', $this->data);
    }

    public function get_order_summary()
    {
        if (get_user_permission('reports/invoice_report') === false) {
            redirect(base_url('user_login'));
        }
        // echo "<pre>"; print_r($this->input->post()); exit();

        if ($this->input->post('from_date')) {
            $start_date = $this->input->post('from_date');
        } else {
            $start_date = date('Y-m-d');
        }

        if ($this->input->post('to_date')) {
            $end_date = $this->input->post('to_date');
        } else {
            $end_date = date('Y-m-d');
        }
        $branch_id = $this->input->post('branch_id');

        if ($end_date == $start_date) {
            $totalDays = 0;
        }
        else {
            $dateDifference = strtotime($end_date) - strtotime($start_date.'-1 day');
            $totalDays = abs(round($dateDifference / (60 * 60 * 24)));
        }

        if ($totalDays > 0) {
            $orderSummaryOnDateRange = $this->Invoice_details_Model->get_order_summary_by_date_range($start_date,$end_date,$branch_id);
            $totalOrderSummary = $this->Invoice_details_Model->get_total_order_summary($start_date,$end_date,$branch_id);
            $orderSummaryProduct = $this->Sale_product_Model->get_order_summary_product($start_date,$end_date,$branch_id);
            $this->data['orderSummaryOnDateRange'] = $orderSummaryOnDateRange;
            $this->data['totalOrderSummary'] = $totalOrderSummary;
            $this->data['orderSummaryProduct'] = $orderSummaryProduct;
        } else {
            $singleDayOrderSummary = $this->Invoice_details_Model->get_single_day_order_summary($start_date,$end_date,$branch_id);
            $this->data['singleDayOrderSummary'] = $singleDayOrderSummary;
        }
        

        $companyInfo = $this->Company_Model->get_company();
        // echo "<pre>"; print_r($totalOrderSummary); exit();

        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->data['companyInfo'] = $companyInfo;
        $this->data['totalDays'] = $totalDays;
        $orderSummaryReport = $this->load->view('reports/invoice_report/order_summary_report',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'orderSummaryReport' => $orderSummaryReport,
        )));
    }

    public function invoice_report_show_in_table() {
        if (get_user_permission('reports/invoice_report') === false) {
            redirect(base_url('user_login'));
        }
        // echo "<pre>"; print_r($this->input->post()); exit();
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id'];
        $user_type = $user_info['user_type'];

        // $start_date = trim($this->input->post('from_date'));
        // $end_date = trim($this->input->post('to_date'));

        if ($this->input->post('from_date')) {
            $start_date = trim($this->input->post('from_date'));
        } else {
            $start_date = date('Y-m-d');
        }

        if ($this->input->post('to_date')) {
            $end_date = trim($this->input->post('to_date'));
        } else {
            $end_date = date('Y-m-d');
        }
        
        $client_id = trim($this->input->post('client_id'));
        $branch_id = trim($this->input->post('branch_id'));
        // echo "<pre>"; print_r($start_date); exit();

        $client_information = $this->Client_Model->get_client($client_id);
        // echo "<pre>"; print_r($client_information); exit();

        if (!empty($client_information)) {
            $client_name = ucfirst($client_information->client_name);
            $client_code = $client_information->client_code;
        }
        else {
            $client_name = "ALL";
            $client_code = "ALL";                
        }

        if (!empty($branch_id)) {
            $branch = $this->Branch_Model->get_branch($branch_id);
            $branch_name = !empty($branch) ? $branch->branch_name : '';
        } else {
            $branch_name = 'All';
        }

        $this->data['branch_name'] = $branch_name;
        $this->data['company_information'] = $this->Company_Model->get_company();
        $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
        $user_info = $this->User_Model->get_user($user_id);
        $employee_id = $user_info->employee_id;
        $invoice_details_view = $this->get_invoice_details_view($id = 0, $employee_id, $user_type, $start_date, $end_date, $client_id, $branch_id);
//            get_print_r($this->db->last_query());
        $this->data['invoice_details_view'] = $invoice_details_view;
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->data['client_name'] = $client_name;
        $this->load->view('reports/invoice_report/invoice_report_table', $this->data);
    }

    public function invoice_report_view() {  // modal view
        if (get_user_permission('reports/invoice_report') === false) {
            redirect(base_url('user_login'));
        }
        $id = trim($this->input->post('id')); // invoice id
        $user_info = $this->session->userdata('user_session');
        $user_id = $user_info['user_id'];
        $user_type = $user_info['user_type'];
        $user_info = $this->User_Model->get_user($user_id);
        $employee_id = $user_info->employee_id;
        $invoice_details_by_invoice_id = $this->get_invoice_details_view($id, $employee_id, $user_type, '', '', 0, 0);
        $employee = $this->Employee_Model->get_employee($invoice_details_by_invoice_id->employee_id);
        $dealer = $this->Dealer_Model->get_dealer($invoice_details_by_invoice_id->dealer_id);
        $sale_product_list_row = $this->Sale_product_Model->get_sale_product_list_row($invoice_details_by_invoice_id->id);
        $company_information = $this->Company_Model->get_company();
        $currency_settings = $this->Currency_settings_Model->get_currency_settings();

        $invoice_details = $this->Invoice_details_Model->getInvoiceDetailsById($id);
        $sale_product_list = $this->Sale_product_Model->get_sale_product_list($id);

        $this->data['sale_product_list_row'] = $sale_product_list_row;
        $this->data['employee'] = $employee;
        $this->data['dealer'] = $dealer;
        $this->data['company_information'] = $company_information;
        $this->data['currency_settings'] = $currency_settings;
        $this->data['invoice_details_by_invoice_id'] = $invoice_details_by_invoice_id;

        $this->data['invoice_details'] = $invoice_details;
        $this->data['sale_product_list'] = $sale_product_list;
        $this->load->view('reports/invoice_report/invoice_report_modal', $this->data);
    }

    public function get_invoice_details_view($id = 0, $employee_id, $user_type, $start_date, $end_date, $client_id = 0, $branch_id = 0) {
        $branch_id_condition = (intval($branch_id) > 0) ? "AND i.branch_id = '$branch_id'" : "";
        if ($id == 0) { // invoice id
            if (strtolower($user_type) === 'marketing') {  // for marketing type user
                if ((int) $client_id > 0) {
                    $where_condition = "WHERE DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') <= '$end_date' AND i.client_id = '$client_id' AND e.id = '$employee_id' $branch_id_condition ORDER BY i.id DESC";
                } elseif ($client_id == 'import' || $client_id == 'lubzone') {
                    $client_type = $client_id;
                    $where_condition = "WHERE DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') <= '$end_date' AND c.client_type = '$client_type' AND e.id = '$employee_id' $branch_id_condition ORDER BY i.id DESC";
                } else { // for all $client_id == 0
                    $where_condition = "WHERE DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') <= '$end_date' AND e.id = '$employee_id' $branch_id_condition ORDER BY i.id DESC";
                }
            } else {
                if ((int) $client_id > 0) {
                    $where_condition = "WHERE DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') <= '$end_date' AND i.client_id = '$client_id' $branch_id_condition ORDER BY i.id DESC";
                } elseif ($client_id == 'import' || $client_id == 'lubzone') {
                    $client_type = $client_id;
                    $where_condition = "WHERE DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') <= '$end_date' AND c.client_type = '$client_type' $branch_id_condition ORDER BY i.id DESC";
                } else { // for all $client_id == 0
                    $where_condition = "WHERE DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(i.date_of_issue,'%Y-%m-%d') <= '$end_date' $branch_id_condition ORDER BY i.id DESC";
                }
            }
        } else {
            $where_condition = "WHERE i.id='$id' $branch_id_condition ORDER BY i.id DESC";
        }

        $query = $this->db->query("
            SELECT i.id, i.branch_id, i.vat_registration_id, i.employee_id, i.dealer_id, i.challan_number, i.invoice_number, i.date_of_issue, i.gross_payable, i.amount_to_paid, i.mode_of_payment, i.product_total, i.delivery_charge, i.others_charge, i.deduction, i.advance_adjusted, i.user_id, i.order_number, i.order_date, i.client_id, i.delivery_address, u.user_name, u.user_type, c.client_name, c.address, c.cell_number, c.phone_number, c.client_type, d.dealer_name, e.employee_name, g.source, br.branch_name 
            FROM invoice_details i 
            LEFT JOIN client_info c ON i.client_id=c.id 
            LEFT JOIN dealer_info d on c.dealer_id = d.id 
            LEFT JOIN employee_info e ON i.employee_id=e.id 
            LEFT JOIN user_info u ON i.user_id=u.id 
            LEFT JOIN gate_pass_details g ON g.invoice_id=i.id 
            LEFT JOIN branch_info br ON i.branch_id=br.id 
            $where_condition
        ");

        if ($id == 0) {
            return $query->result();
        } else {
            return $query->row();
        }
    }

    public function send_pdf_as_email() {
        if (get_user_permission('reports/invoice_report') === false) {
            redirect(base_url('user_login'));
        }
        if ($this->input->is_ajax_request()) {
            $this->email->clear(TRUE);
            $message = '';
            $is_sent = FALSE;
            $path = '';
            $file_destination = '';
            $invoice_report_file_destination = '';
            $challan_report_file_destination = '';
            $gate_pass_report_file_destination = '';
            $id = intval(trim($this->input->post('invoice_details_id')));
            $is_invoice = intval(trim($this->input->post('is_invoice')));
            $special_notes = trim($this->input->post('special_notes'));
            /* invoice report */
            $invoice_details_id = $id; // invoice id
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id'];
            $user_type = $user_info['user_type'];
            $user_info = $this->User_Model->get_user($user_id);
            $employee_id = $user_info->employee_id;
            $invoice_details_by_invoice_id = $this->get_invoice_details_view($invoice_details_id, $employee_id, $user_type, '', '', 0, 0);

            if (!empty($invoice_details_by_invoice_id)) {
                $this->data['sale_product_list'] = $this->Sale_product_Model->get_sale_product_list($invoice_details_by_invoice_id->id);
                $this->data['sale_product_list_row'] = $this->Sale_product_Model->get_sale_product_list_row($invoice_details_by_invoice_id->id);
                $this->data['employee'] = $this->Employee_Model->get_employee($invoice_details_by_invoice_id->employee_id);
                $this->data['dealer'] = $this->Dealer_Model->get_dealer($invoice_details_by_invoice_id->dealer_id);
                $this->data['company_information'] = $this->Company_Model->get_company();
                $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
                $this->data['invoice_details_by_invoice_id'] = $invoice_details_by_invoice_id;
                /* //invoice report */
                /* gate pass report */
                $invoice_id = $id;
                $gate_pass_report_by_invoice_id = $this->Invoice_details_Model->get_gate_pass_report_show($invoice_id);
                $gate_pass_report_view = $this->Invoice_details_Model->get_gate_pass_report_view($invoice_id);
                $this->data['gate_pass_report_by_invoice_id'] = $gate_pass_report_by_invoice_id;
                $this->data['gate_pass_report_view'] = $gate_pass_report_view;
                /* //gate pass report */
                /* challan report */
                $challan_details_by_invoice_id = $this->Challan_details_Model->get_challan_details_by_invoice_id($id); // invoice id      
                $challan_id = intval($challan_details_by_invoice_id->id);
                $challan_product_by_challan_id = $this->Challan_details_Model->get_challan_product_by_challan_id($challan_id);
                $this->data['challan_product_list'] = $this->Challan_product_Model->get_challan_product_list_show($challan_id);
                $this->data['challan_product_by_challan_id'] = $challan_product_by_challan_id;
                $this->data['challan_product_view'] = $this->Challan_details_Model->get_challan_product_by_challan_id($challan_id);
                $this->data['client'] = $this->Client_Model->get_client($challan_product_by_challan_id->client_id);
                /* //challan report */

                $email_address_details_array = $this->Email_address_details_Model->get_email_address_details_for_email();
                $email_to = !empty($email_address_details_array) ? (array_key_exists('email_to', $email_address_details_array) ? $email_address_details_array['email_to'] : '') : '';
                $email_cc = !empty($email_address_details_array) ? (array_key_exists('email_cc', $email_address_details_array) ? $email_address_details_array['email_cc'] : '') : '';
                $email_bcc = !empty($email_address_details_array) ? (array_key_exists('email_bcc', $email_address_details_array) ? $email_address_details_array['email_bcc'] : '') : '';
                $name = '';
                $email = $email_to;
                $this->data['name'] = $name;
//                $this->data['email'] = $email;
                $this->data['content_array'] = array(
                    'header_title' => get_company_name(),
                    'header_body' => '',
                    'name' => $name,
                    'body_content' => '<h4>Hi,</h4>' . '<p>' . $special_notes . '</p>',
                );
//                    $body = $this->load->view('email_template/index', $this->data, TRUE);
                $invoice_report_html = $this->load->view('email_template/invoice_report_pdf', $this->data, TRUE);
                $challan_report_html = $this->load->view('email_template/challan_report_pdf', $this->data, TRUE);
                $gate_pass_report_html = $this->load->view('email_template/gate_pass_report_pdf', $this->data, TRUE);
                if ($is_invoice > 0) {
                    $invoice_report_file_destination = $this->pdf->save_pdf($invoice_report_html, ('Invoice_' . time()));
                    sleep(1);
                }
                $challan_report_file_destination = $this->pdf->save_pdf($challan_report_html, ('Challan_' . time()));
                sleep(1);
                $gate_pass_report_file_destination = $this->pdf->save_pdf($gate_pass_report_html, ('Gatepass' . time()));
                sleep(1);
                $client_name = !empty($challan_product_by_challan_id->client_name) ? $challan_product_by_challan_id->client_name : '';
                $challan_number = !empty($challan_product_by_challan_id->invoice_number) ? $challan_product_by_challan_id->invoice_number : '';
                $data = array(
                    'name' => $name,
                    'email' => ($email),
                    'cc' => ($email_cc),
                    'bcc' => ($email_bcc),
                    'subject' => $client_name . ' - ' . $challan_number,
                    'body' => '<h4>Hi,</h4>' . '<p>' . $special_notes . '</p>',
                    'attach' => array($invoice_report_file_destination, $challan_report_file_destination, $gate_pass_report_file_destination),
                    'from_title' => get_smtp_mail_form_title(),
                    'from_email' => get_smtp_host_user(),
                    'to_email_array' => ($email),
                );
                $is_sent = email_send($data);
                if ($is_sent) {
                    $attach_array = array_key_exists('attach', $data) ? $data['attach'] : '';
                    $attach_array_count = !empty($attach_array) ? ((is_array($attach_array)) ? count($attach_array) : 0) : 0;
                    if ($attach_array_count > 0) {
                        foreach ($attach_array as $key => $value) {
                            $file_destination = $value;
                            $str = !empty($file_destination) ? $file_destination : '';
                            $str = (explode("assets", $str));
                            if (!empty($str[1])) {
                                $path = 'assets' . $str[1];
                            }
                            delete_uploaded_file($path);
                        }
                    }
                    $message = 'Email has been sent successfully.';
                } else {
                    $message = 'Sending failed.';
                }
            } else {
                $message = 'Error Occured.';
            }
            set_json_output(array('invoiceDetailsId' => $invoice_details_id, 'message' => $message, 'isSent' => $is_sent));
        } else {
            redirect(base_url());
        }
    }

    /* public function get_invoice_details_view($id = 0, $employee_id, $user_type, $start_date, $end_date, $client_id) {
      $query_details = "SELECT i.id, i.branch_id, i.vat_registration_id, i.employee_id, i.dealer_id, i.challan_number, i.invoice_number, i.date_of_issue, i.gross_payable, i.amount_to_paid, i.mode_of_payment, i.product_total, i.delivery_charge, i.others_charge, i.deduction, i.advance_adjusted, i.user_id, i.order_number, i.order_date, i.client_id, i.delivery_address, u.user_name,u.user_type, c.client_name, c.address, c.cell_number, c.phone_number, c.client_type, d.dealer_name, e.employee_name, g.source, br.branch_name FROM invoice_details i LEFT JOIN client_info c ON i.client_id=c.id LEFT JOIN dealer_info d on c.dealer_id = d.id LEFT JOIN employee_info e ON i.employee_id=e.id LEFT JOIN user_info u ON i.user_id=u.id LEFT JOIN gate_pass_details g ON g.invoice_id=i.id LEFT JOIN branch_info br ON i.branch_id=br.id";
      if ($id == 0) {
      if (strtolower($user_type) === 'marketing') {
      $invoice_details_list = $this->db->query("$query_details WHERE e.id = '$employee_id' AND i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' ORDER BY i.id DESC")->result();
      return $invoice_details_list;
      } else {
      $invoice_details_list = $this->db->query("$query_details WHERE i.date_of_issue >= '$start_date' AND i.date_of_issue <= '$end_date' ORDER BY i.id DESC")->result();
      return $invoice_details_list;
      }
      } else {
      $invoice_details_list = $this->db->query("$query_details WHERE i.id='$id' ORDER BY i.id DESC")->row();
      return $invoice_details_list;
      }
      } */
}
