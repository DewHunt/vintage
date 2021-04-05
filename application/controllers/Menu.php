<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Company_Model');
        $this->load->model('User_Model');
        $this->load->model('Menu_model');
    }

    public function index() {
        if (get_user_permission('menu') === false) {
            redirect(base_url('user_login'));
        }

        $this->data['title'] = "Menu Permission";
        $this->data['menu_lists'] = $this->Menu_model->get_all_menu_list();
        // echo "<pre>"; print_r($this->data); exit();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('menu/index', $this->data);
    }

    public function add() {
        if (get_user_permission('menu') === false) {
            redirect(base_url('user_login'));
        }

        $parentMenuMaxOrder = $this->Menu_model->get_parent_menu_max_order();

        if ($parentMenuMaxOrder) {
            $orderBy = $parentMenuMaxOrder->maxOrder + 1;
        } else {
            $orderBy = 1;
        }

        $this->data['title'] = "Add Menu Permission";
        $this->data['menu_lists'] = $this->Menu_model->get_all_parent_menu_info();
        $this->data['orderBy'] = $orderBy;
        // echo "<pre>"; print_r($this->data); exit();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('menu/add', $this->data);
    }

    public function save() {
        if (get_user_permission('menu') === false) {
            redirect(base_url('user_login'));
        }

    	// echo "<pre>"; print_r($this->input->post()); exit();

    	$menuLink = $this->input->post('menuLink');
    	$isExists = "";
		$parentMenu = NULL;

    	if ($menuLink) {
    		$isExists = $this->Menu_model->check_menu_exists($menuLink);
    	}  	

    	if ($isExists) {
    		$this->session->set_flashdata('error', 'Menu Link Already Exists.');
    		redirect(base_url('menu/add'));
    	}

		if ($this->input->post('parentMenu')) {
			$parentMenu = $this->input->post('parentMenu');
		}

        $data = array(
            'parent_menu' => $parentMenu,
            'menu_name' => trim($this->input->post('menuName')),
            'menu_link' => $menuLink,
            'menu_icon' => trim($this->input->post('menuIcon')),
            'order_by' => trim($this->input->post('orderBy')),
        );

        $this->db->insert('menus', $data);
		$this->session->set_flashdata('message', 'Menu Save Successfully.');
		redirect(base_url('menu/add'));
    }

    public function edit($menuId) {
        if (get_user_permission('menu') === false) {
            redirect(base_url('user_login'));
        }

        $menus = $this->Menu_model->get_all_menu_info();
        $menuInfo = $this->Menu_model->get_menu_info_by_id($menuId);

        $this->data['title'] = "Edit Menu";
        $this->data['menu_lists'] = $this->Menu_model->get_all_menu_info();
        $this->data['menuInfo'] = $menuInfo;
        // echo "<pre>"; print_r($this->data); exit();
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('menu/edit', $this->data);
    }

    public function update() {
        if (get_user_permission('menu') === false) {
            redirect(base_url('user_login'));
        }

    	// echo "<pre>"; print_r($this->input->post()); exit();

    	$menuLink = $this->input->post('menuLink');
        $id = $this->input->post('menuId');
    	$isExists = "";
		$parentMenu = NULL;

    	if ($menuLink) {
    		$isExists = $this->Menu_model->check_menu_exists($menuLink,$id);
    	}  	

    	if ($isExists) {
    		$this->session->set_flashdata('error', 'Menu Link Already Exists.');
    		redirect(base_url('menu/edit/'.$id));
    	}

		if ($this->input->post('parentMenu')) {
			$parentMenu = $this->input->post('parentMenu');
		}

        $data = array(
            'parent_menu' => $parentMenu,
            'menu_name' => trim($this->input->post('menuName')),
            'menu_link' => $menuLink,
            'menu_icon' => trim($this->input->post('menuIcon')),
            'order_by' => trim($this->input->post('orderBy')),
        );

        $this->db->where('id',$id);
        $this->db->update('menus', $data);
		$this->session->set_flashdata('message', 'Menu Update Successfully.');
		redirect(base_url('menu'));
    }

    public function delete($id) {
        if (get_user_permission('menu') === false) {
            redirect(base_url('user_login'));
        }

		$this->db->delete('menus', array('id' => $id));

		$this->session->set_flashdata('message', 'Menu Deleted Successfully.');
		redirect(base_url('menu'));
    }

    public function max_order() {
        if (get_user_permission('menu') === false) {
            redirect(base_url('user_login'));
        }
        
    	$parentMenuId = $this->input->post('parentMenuId');

    	if ($parentMenuId != "") {
            $menuMaxOrder = $this->Menu_model->GetMaxOrder($parentMenuId);
    	} else {
        	$menuMaxOrder = $this->Menu_model->get_parent_menu_max_order();
    	}

        if ($menuMaxOrder) {
            $orderBy = $menuMaxOrder->maxOrder + 1;
        }
        else {
            $orderBy = 1;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'orderBy' => $orderBy,
        )));   
    }
}
