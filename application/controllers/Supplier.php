<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->library('pagination');
        $this->load->model('User_Model');
        $this->load->model('Product_Model');
        $this->load->model('Product_purchase_model');
        $this->load->model('Company_Model');
        $this->load->model('Supplier_model');

        if (get_menu_permission('factory_access') == false) {
            return redirect(base_url('user_login'));
        }
    }

    public function index() {
        if (get_user_permission('supplier') === false) {
            redirect(base_url('user_login'));
        }

    	$this->data['title'] = "Product Purchase List";
        $this->data['supplierLists'] = $this->Supplier_model->get_all_supplier();

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('supplier/index', $this->data);
    }

    public function add() {
        if (get_user_permission('supplier') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = "Add New Supplier";
        
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('supplier/add', $this->data);
    }

    public function save()
    {
        if (get_user_permission('supplier') === false) {
            redirect(base_url('user_login'));
        }

    	$supplier_conatact_number = $this->input->post('supplierConatactNumber');
    	$contact_person_conatact_number = $this->input->post('contactPersonConatactNumber');
    	$email = $this->input->post('email');

    	$isSupplierExists = $this->Supplier_model->cheack_supplier_exists($supplier_conatact_number,$contact_person_conatact_number,$email);

    	if (!empty($isSupplierExists)) {
            $this->session->set_flashdata('errorMessage', 'Sorry! This Supplier Already Exists.');
            redirect(base_url("supplier/add"));
    	} else {
            $userInfo = $this->session->userdata('user_session');

            $supplierData = array(
                'user_id' => $userInfo['user_id'],
                'name' => $this->input->post('supplierName'),
                'vat_id' => $this->input->post('vatId'),
                'supplier_contact_number' => $supplier_conatact_number,
                'contact_person_name' => $this->input->post('contactPersonName'),
                'contact_person_contact_number' => $contact_person_conatact_number,
                'email' => $email,
                'address' => $this->input->post('address'),
                'remarks' => $this->input->post('remarks'),
            );

            $this->db->insert('supplier', $supplierData);

            $this->session->set_flashdata('successMessage', 'Supplier Information Saved Successfully.');
            redirect(base_url("supplier"));
    	}
    }

    public function edit($supplierId) {
        if (get_user_permission('supplier') === false) {
            redirect(base_url('user_login'));
        }
        
    	$supplierInfo = $this->Supplier_model->get_supplier_info_by_id($supplierId);

        $this->data['title'] = "Edit Category";
        $this->data['supplierInfo'] = $supplierInfo;
        
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('supplier/edit', $this->data);
    }

    public function update() {
        if (get_user_permission('supplier') === false) {
            redirect(base_url('user_login'));
        }
        
    	// echo "<pre>"; print_r($this->input->post()); exit();

    	$supplier_id = $this->input->post('supplierId');
    	$supplier_conatact_number = $this->input->post('supplierConatactNumber');
    	$contact_person_conatact_number = $this->input->post('contactPersonConatactNumber');
    	$email = $this->input->post('email');

    	$isSupplierExists = $this->Supplier_model->cheack_supplier_exists_by_id($supplier_conatact_number,$contact_person_conatact_number,$email,$supplier_id);

    	if (!empty($isSupplierExists)) {
            $this->session->set_flashdata('errorMessage', 'Sorry! This Supplier Already Exists.');
            redirect(base_url("supplier/edit"));
    	} else {
            $userInfo = $this->session->userdata('user_session');

            $supplierData = array(
                'user_id' => $userInfo['user_id'],
                'name' => $this->input->post('supplierName'),
                'vat_id' => $this->input->post('vatId'),
                'supplier_contact_number' => $supplier_conatact_number,
                'contact_person_name' => $this->input->post('contactPersonName'),
                'contact_person_contact_number' => $contact_person_conatact_number,
                'email' => $email,
                'address' => $this->input->post('address'),
                'remarks' => $this->input->post('remarks'),
            );

            $this->db->where('id',$supplier_id);
            $this->db->update('supplier', $supplierData);

            $this->session->set_flashdata('successMessage', 'Supplier Information Updated Successfully.');
            redirect(base_url("supplier"));
    	}
    }

    public function payment() {
        if (get_user_permission('supplier') === false) {
            redirect(base_url('user_login'));
        }

    	// echo "Dew Hunt"; exit();

        $this->data['title'] = "Add New Supplier";
        $this->data['supplierLists'] = $this->Supplier_model->get_all_supplier();
        
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('supplier/payment', $this->data);
    }

    public function save_payment()
    {
        if (get_user_permission('supplier') === false) {
            redirect(base_url('user_login'));
        }
        
    	// echo "<pre>"; print_r($this->input->post()); exit();

    	$imagePath = '';
    	if (!empty($_FILES['moneyReceiptImage']['name'])) {
	        if ((int) $_FILES['moneyReceiptImage']["size"] > (150 * 1024)) {
	            $this->session->set_flashdata('errorMessage', 'Image size can not be more than 150 KB');
	            redirect(base_url('supplier/payment'));
	        } else {
	            $imageName = $_FILES['moneyReceiptImage']['name'];
	            $config['file_name'] = $imageName;
	            $config['upload_path'] = './assets/uploads/money_receipt_images';
	            $config['allowed_types'] = 'gif|jpg|png';

	            $this->load->library('upload', $config);
	            if ($this->upload->do_upload('moneyReceiptImage')) {
	                $imagePath  = '/assets/uploads/money_receipt_images/' . $config['file_name'];
	            } else {
	                $this->session->set_flashdata('errorMessage', 'Something Went Wrong. Please Try Again');
	                redirect(base_url('supplier/payment'));
	            }
	        }
	    }

        if (!empty($this->input->post())) {
        	$supplierId = $this->input->post('supplier');
        	$amountName = $this->input->post('amountName');
        	$amount = $this->input->post('amount');
        	$date = $this->input->post('date');
        	$paymentMode = $this->input->post('paymentMode');
        	$paidAmount = $this->input->post('paidAmount');
        	$moneyReceiptNumber = $this->input->post('moneyReceiptNumber');
        	$remarks = $this->input->post('remarks');
        }

		date_default_timezone_set("Asia/Dhaka");
		$currentTime = date("h:i:s");
    	$dateTime = $date." ".$currentTime;

        $userInfo = $this->session->userdata('user_session');

        $supplierInfo = $this->Supplier_model->get_supplier_info_by_id($supplierId);
        $status = 1;
        
        if ($supplierInfo->advanced_amount > 0) {
            $status = 2;
        }

		$supplierInfo->paid_amount += $paidAmount;
		$supplierInfo->due_amount -= $paidAmount;

		if ($supplierInfo->due_amount < 0) {
			$supplierInfo->advanced_amount += abs($supplierInfo->due_amount);
			$supplierInfo->due_amount = 0;
		}

        $supplierData = array(
            'advanced_amount' => $supplierInfo->advanced_amount,
            'paid_amount' => $supplierInfo->paid_amount,
            'due_amount' => $supplierInfo->due_amount,
        );

        $this->db->where('id',$supplierInfo->id);
        $this->db->update('supplier', $supplierData);

        $supplierPaymentData = array(
            'supplier_id' => $supplierId,
            'user_id' => $userInfo['user_id'],
            'date' => $dateTime,
            'money_receipt_no' => $moneyReceiptNumber,
            'payment_mode' => $paymentMode,
            'status' => $status,
            'previous_amount' => $amount,
            'purchase_amount' => 0,
            'advanced_amount' => $supplierInfo->advanced_amount,
            'paid_amount' => $paidAmount,
            'due_amount' => $supplierInfo->due_amount,
            'money_receipt_image' => $imagePath,
            'remarks' => $remarks,
        );

        $this->db->insert('supplier_payment', $supplierPaymentData);

        $this->session->set_flashdata('successMessage', 'Supplier Payment Saved Successfully.');
        redirect(base_url("supplier"));
    }

    public function get_supplier_info()
    {
    	$supplierId = $this->input->post('supplierId');

    	$supplierInfo = $this->Supplier_model->get_supplier_info_by_id($supplierId);

    	$amountName = 'Due Amount';
    	$amount = 0;

    	if ($supplierInfo->advanced_amount > 0) {
	    	$amountName = 'Advanced Amount';
	    	$amount = $supplierInfo->advanced_amount;
    	} else {
	    	$amount = $supplierInfo->due_amount;
    	}

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'amountName' => $amountName,
            'amount' => $amount,
        )));    	
    }

    public function delete($id)
    {
        if (get_user_permission('supplier') === false) {
            redirect(base_url('user_login'));
        }
        
    	$this->db->delete('supplier', array('id' => $id));
        redirect(base_url('supplier'));
    }

    public function status($supplier_id)
    {
        if (get_user_permission('supplier') === false) {
            redirect(base_url('user_login'));
        }
        
        $supplier_id = $this->input->post('supplier_id');
        $this->Supplier_model->update_status($supplier_id);
    }
}
