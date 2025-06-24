<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['billing_model', 'inventory_model', 'settings_model']);
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        
        // Check if user is logged in
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('auth');
        }
    }
    
    public function index() {
        $data['title'] = 'Dashboard';
        $data['settings'] = $this->settings_model->get_settings();
        
        // Get today's date
        $today = date('Y-m-d');
        
        // Get current month and year
        $current_month = date('m');
        $current_year = date('Y');
        
        // Get sales statistics
        $data['daily_sales'] = $this->billing_model->get_daily_sales($today);
        $data['monthly_sales'] = $this->billing_model->get_monthly_sales($current_month, $current_year);
        
        // Get billing statistics
        $billing_stats = $this->billing_model->get_billing_stats();
        $data['billing_stats'] = $billing_stats;
        
        // Get recent bills
        $data['recent_bills'] = $this->billing_model->get_all_bills(5);
        
        // Get low stock items (less than 10 items)
        $data['low_stock_items'] = $this->db->where('stock <', 10)->get('inventory')->result();
        
        // Get pending bills count
        $data['pending_bills_count'] = $this->db->where('payment_status', 'pending')
                                                ->or_where('payment_status', 'partial')
                                                ->get('bills')->num_rows();
        
        // Get today's bills count
        $data['today_bills_count'] = $this->db->where('DATE(created_at)', $today)->get('bills')->num_rows();
        
        // Load the dashboard view
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer', $data);
    }
} 