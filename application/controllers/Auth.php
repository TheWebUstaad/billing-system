<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('dashboard');
        }
        $this->load->view('auth/login');
    }

    public function login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $admin = $this->admin_model->login($username, $password);

        if ($admin) {
            $session_data = array(
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'admin_username' => $admin->username,
                'admin_logged_in' => TRUE
            );
            $this->session->set_userdata($session_data);
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'غلط یوزر نیم یا پاس ورڈ');
            redirect('auth');
        }
    }

    public function logout() {
        $this->session->unset_userdata('admin_logged_in');
        $this->session->sess_destroy();
        redirect('auth');
    }
} 