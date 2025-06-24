<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('settings_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
        
        // Check if user is logged in
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('auth');
        }
    }
    
    public function index() {
        $data['title'] = 'Shop Settings';
        $data['settings'] = $this->settings_model->get_settings();
        
        // Form validation rules
        $this->form_validation->set_rules('shop_name', 'Shop Name', 'required|trim');
        $this->form_validation->set_rules('address', 'Address', 'trim');
        $this->form_validation->set_rules('phone', 'Phone', 'trim');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        $this->form_validation->set_rules('currency_symbol', 'Currency Symbol', 'required|trim');
        $this->form_validation->set_rules('footer_text', 'Footer Text', 'trim');
        $this->form_validation->set_rules('low_stock_alert', 'Low Stock Alert', 'required|numeric|greater_than[0]');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('settings/index', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $settings_data = array(
                'shop_name' => $this->input->post('shop_name'),
                'address' => $this->input->post('address'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
                'currency_symbol' => $this->input->post('currency_symbol'),
                'footer_text' => $this->input->post('footer_text'),
                'low_stock_alert' => $this->input->post('low_stock_alert')
            );
            
            if ($this->settings_model->update_settings($settings_data)) {
                            $this->session->set_flashdata('success', 'سیٹنگز کامیابی سے اپڈیٹ ہو گئیں');
        } else {
            $this->session->set_flashdata('error', 'سیٹنگز اپڈیٹ کرنے میں ناکامی');
            }
            redirect('settings');
        }
    }
} 