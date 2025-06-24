<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['inventory_model', 'settings_model']);
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
        
        // Check if user is logged in
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('auth');
        }
    }

    public function index() {
        $data['title'] = 'Inventory Management';
        $data['settings'] = $this->settings_model->get_settings();
        $data['items'] = $this->inventory_model->get_all_items();
        
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/index', $data);
        $this->load->view('templates/footer', $data);
    }

    public function add() {
        $data['title'] = 'Add New Item';
        $data['settings'] = $this->settings_model->get_settings();
        
        // Set validation rules
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric|greater_than_equal_to[0]');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('inventory/add', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $item_data = array(
                'title' => $this->input->post('title'),
                'price' => $this->input->post('price'),
                'stock' => 0, // Default stock to 0 as we don't track stock
                'created_at' => date('Y-m-d H:i:s')
            );
            
            if ($this->inventory_model->add_item($item_data)) {
                $this->session->set_flashdata('success', 'آئیٹم کامیابی سے شامل ہو گیا');
            } else {
                $this->session->set_flashdata('error', 'آئیٹم شامل کرنے میں ناکامی');
            }
            redirect('inventory');
        }
    }

    public function edit($id = NULL) {
        if ($id === NULL) {
            show_404();
        }
        
        $data['title'] = 'Edit Item';
        $data['settings'] = $this->settings_model->get_settings();
        $data['item'] = $this->inventory_model->get_item($id);
        
        if (empty($data['item'])) {
            show_404();
        }
        
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('inventory/edit', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $item_data = array(
                'title' => $this->input->post('title'),
                'price' => $this->input->post('price'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            if ($this->inventory_model->update_item($id, $item_data)) {
                $this->session->set_flashdata('success', 'آئیٹم کی معلومات اپڈیٹ ہو گئیں');
            } else {
                $this->session->set_flashdata('error', 'آئیٹم اپڈیٹ کرنے میں ناکامی');
            }
            redirect('inventory');
        }
    }

    public function delete($id = NULL) {
        if ($id === NULL) {
            show_404();
        }
        
        // Check if item is used in any bills before deleting
        $this->load->model('billing_model');
        $bills_using_item = $this->billing_model->check_item_usage($id);
        
        if ($bills_using_item > 0) {
            $this->session->set_flashdata('error', 
                'یہ آئیٹم ڈیلیٹ نہیں ہو سکتا کیونکہ یہ ' . $bills_using_item . ' بل میں استعمال ہو رہا ہے');
        } else {
            if ($this->inventory_model->delete_item($id)) {
                $this->session->set_flashdata('success', 'آئیٹم کامیابی سے ڈیلیٹ ہو گیا');
            } else {
                $this->session->set_flashdata('error', 'آئیٹم ڈیلیٹ کرنے میں ناکامی');
            }
        }
        redirect('inventory');
    }



    public function search() {
        $query = $this->input->get('q');
        $data['title'] = 'Search Results';
        $data['settings'] = $this->settings_model->get_settings();
        $data['items'] = $this->inventory_model->search_items($query);
        
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/index', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function get_next_sku() {
        echo json_encode(['sku' => $this->inventory_model->generate_next_sku()]);
    }

    public function export_pdf() {
        // Load PDF library
        $this->load->library('pdf');
        
        // Get settings
        $settings = $this->settings_model->get_settings();
        
        // Get items (with search filter if provided)
        $search = $this->input->get('search');
        if ($search) {
            $items = $this->inventory_model->search_items($search);
            $title_suffix = ' - Search: ' . $search;
        } else {
            $items = $this->inventory_model->get_all_items();
            $title_suffix = ' - All Items';
        }
        
        // Calculate totals
        $total_items = count($items);
        $total_value = 0;
        foreach ($items as $item) {
            $total_value += $item->price;
        }
        
        // Prepare data for PDF
        $data = array(
            'items' => $items,
            'settings' => $settings,
            'search' => $search,
            'total_items' => $total_items,
            'total_value' => $total_value,
            'export_date' => date('d M Y'),
            'title_suffix' => $title_suffix
        );
        
        // Load view and generate PDF
        $html = $this->load->view('inventory/export_template', $data, true);
        
        // Create PDF
        $this->pdf->load(['title' => 'Inventory Report' . $title_suffix]);
        $this->pdf->generate($html, 'inventory-report-' . date('Y-m-d') . '.pdf', false);
    }
} 