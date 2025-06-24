<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['customer_model', 'settings_model']);
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
        
        // Check if user is logged in
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('auth');
        }
    }

    public function index() {
        $data['title'] = 'Customer Management';
        $data['settings'] = $this->settings_model->get_settings();
        $data['customers'] = $this->customer_model->get_all_customers();
        
        $this->load->view('templates/header', $data);
        $this->load->view('customer/index', $data);
        $this->load->view('templates/footer', $data);
    }

    public function add() {
        $data['title'] = 'Add Customer';
        $data['settings'] = $this->settings_model->get_settings();
        
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|is_unique[customers.phone]');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('customer/add', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $customer_data = array(
                'name' => $this->input->post('name'),
                'phone' => $this->input->post('phone')
            );
            
            if ($this->customer_model->add_customer($customer_data)) {
                $this->session->set_flashdata('success', 'کسٹمر کامیابی سے شامل ہو گیا');
            } else {
                $this->session->set_flashdata('error', 'کسٹمر شامل کرنے میں ناکامی');
            }
            redirect('customer');
        }
    }

    public function edit($id = NULL) {
        if ($id === NULL) {
            show_404();
        }
        
        $data['title'] = 'Edit Customer';
        $data['settings'] = $this->settings_model->get_settings();
        $data['customer'] = $this->customer_model->get_customer($id);
        
        if (empty($data['customer'])) {
            show_404();
        }
        
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        if ($this->input->post('phone') !== $data['customer']->phone) {
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|is_unique[customers.phone]');
        }
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('customer/edit', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $customer_data = array(
                'name' => $this->input->post('name'),
                'phone' => $this->input->post('phone'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            if ($this->customer_model->update_customer($id, $customer_data)) {
                $this->session->set_flashdata('success', 'کسٹمر کی معلومات اپڈیٹ ہو گئیں');
            } else {
                $this->session->set_flashdata('error', 'کسٹمر اپڈیٹ کرنے میں ناکامی');
            }
            redirect('customer');
        }
    }

    public function delete($id = NULL) {
        if ($id === NULL) {
            show_404();
        }
        
        $result = $this->customer_model->delete_customer($id);
        
        switch($result) {
            case 'success':
                $this->session->set_flashdata('success', 'کسٹمر کامیابی سے ڈیلیٹ ہو گیا');
                break;
            case 'has_bills':
                $customer = $this->customer_model->get_customer($id);
                $bills_count = $this->customer_model->get_customer_bills_count($id);
                $this->session->set_flashdata('error', 'اس کسٹمر کو ڈیلیٹ نہیں کر سکتے کیونکہ اس کے ' . $bills_count . ' بل موجود ہیں۔ پہلے تمام بل ڈیلیٹ کریں پھر کسٹمر ڈیلیٹ کریں۔');
                break;
            default:
                $this->session->set_flashdata('error', 'کسٹمر ڈیلیٹ کرنے میں ناکامی');
                break;
        }
        redirect('customer');
    }

    public function view($id = NULL) {
        if ($id === NULL) {
            show_404();
        }
        
        $this->load->model('billing_model');
        
        $data['title'] = 'Customer Details';
        $data['settings'] = $this->settings_model->get_settings();
        $data['customer'] = $this->customer_model->get_customer($id);
        
        if (empty($data['customer'])) {
            show_404();
        }
        
        // Get customer bills and stats
        $data['customer_bills'] = $this->customer_model->get_customer_bills($id);
        $data['bills_count'] = count($data['customer_bills']);
        $data['total_spent'] = 0;
        foreach($data['customer_bills'] as $bill) {
            $data['total_spent'] += $bill->total_amount;
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('customer/view', $data);
        $this->load->view('templates/footer', $data);
    }

    public function search() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $term = $this->input->post('term');
        $customers = $this->customer_model->search_customers($term);
        echo json_encode($customers);
    }

    public function quick_add() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $data = array(
            'name' => $this->input->post('name'),
            'whatsapp' => $this->input->post('whatsapp'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $customer_id = $this->customer_model->create_customer($data);
        
        if ($customer_id) {
            $customer = $this->customer_model->get_customer($customer_id);
            echo json_encode(array(
                'success' => true,
                'customer' => $customer
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'Failed to add customer'
            ));
        }
    }
} 