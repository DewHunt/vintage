<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Narration extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->model('Narration_Model');
        $this->load->model('User_Model');
    }

    public function index()  // load Narration details
    {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == true)) {
            $this->data['title'] = "Narration";
            $narration_list = $this->Narration_Model->get_narration();
            $this->data['narration_list'] = $narration_list;
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('accounts/narration/narration_details_list', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function create_new_narration() // load create new Narration page
    {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == true)) {
            $this->data['title'] = "Create Narration";
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('accounts/narration/create_narration');
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function save_narration()  // save Narration information
    {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == true)) {
            $this->data['title'] = 'Save Narration';
            $narration = trim($this->input->post('narration'));
            $narration_by_narration = $this->Narration_Model->get_narration_by_narration($narration);
            if (empty($narration_by_narration)) {
                $data = array(
                    'narration' => $narration,
                );
                $this->form_validation->set_rules('narration', 'Narration', 'required');

                if ($this->form_validation->run() === FALSE) {
                    $this->load->view('header');
                    $this->load->view('navigation');
                    $this->load->view('accounts/narration/create_narration', $data);
                } else {
                    $this->Narration_Model->db->insert('narration', $data);
                    redirect(base_url('accounts/narration'));
                }
            } else {
                $this->session->set_flashdata('narration_duplicate_error_message', 'Narration Already Exists.');
                redirect('accounts/narration/create_new_narration');
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update_narration($id = 0)  // load update Narration information page
    {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == true)) {
            $narration = $this->Narration_Model->get_narration($id);
            if (!empty($narration)) {
                $this->data['title'] = "Update Narration";
                $this->data['narration'] = $narration;
                $this->load->view('header');
                $this->load->view('navigation');
                $this->load->view('accounts/narration/update_narration', $this->data);
            } else {
                redirect(base_url('accounts/narration'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update()  // update Narration
    {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == true)) {
            $this->data['title'] = 'Update Narration';
            $id = trim($this->input->post('id'));
            $narration = trim($this->input->post('narration'));
            $narration_by_narration_id_for_duplicate_check = $this->Narration_Model->get_narration_by_narration_id_for_duplicate_check($narration, $id);
            if ((empty($narration_by_narration_id_for_duplicate_check))) {
                $data = array(
                    'id' => $id,
                    'narration' => $narration,
                );
                $this->form_validation->set_rules('narration', 'Narration', 'required');

                if ($this->form_validation->run() === FALSE) {
                    $this->load->view('header');
                    $this->load->view('navigation');
                    $this->load->view('accounts/narration/update_narration', $this->data);
                } else {
                    $this->db->where('id', $data['id']);
                    $this->Narration_Model->db->update('narration', $data);
                    redirect(base_url('accounts/narration'));
                }

            } else {
                $this->session->set_flashdata('narration_duplicate_error_message', 'Narration Already Exists.');
                redirect('accounts/narration/update_narration/' . $id);
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function delete($id)
    {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('accounts_access')) == true)) {
            $this->Narration_Model->delete($id);
            redirect(base_url('accounts/narration'));
        } else {
            redirect(base_url('user_login'));
        }
    }
}
