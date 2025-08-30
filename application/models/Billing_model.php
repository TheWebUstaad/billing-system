<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_bill($bill_data, $items) {
        $this->db->trans_start();

        // Insert bill header
        $this->db->insert('bills', $bill_data);
        $bill_id = $this->db->insert_id();

        // Insert bill items
        foreach ($items as $item) {
            $item['bill_id'] = $bill_id;
            $this->db->insert('bill_items', $item);
            
            // Update inventory stock
            $this->db->where('id', $item['item_id']);
            $this->db->set('stock', 'stock - ' . $item['quantity'], FALSE);
            $this->db->update('inventory');
        }

        $this->db->trans_complete();
        return ($this->db->trans_status() === TRUE) ? $bill_id : FALSE;
    }

    public function create_simple_bill($bill_data, $items) {
        $this->db->trans_start();

        // Insert bill header (no payment tracking)
        $this->db->insert('bills', $bill_data);
        $bill_id = $this->db->insert_id();

        // Insert bill items (no stock update, no payment tracking)
        foreach ($items as $item) {
            $item['bill_id'] = $bill_id;
            $this->db->insert('bill_items', $item);
        }

        $this->db->trans_complete();
        return ($this->db->trans_status() === TRUE) ? $bill_id : FALSE;
    }

    public function create_bill_without_stock_update($bill_data, $items) {
        $this->db->trans_start();

        // Insert bill header
        $this->db->insert('bills', $bill_data);
        $bill_id = $this->db->insert_id();

        // Insert bill items (without stock update)
        foreach ($items as $item) {
            $item['bill_id'] = $bill_id;
            $this->db->insert('bill_items', $item);
            // No stock update for small shop management
        }

        $this->db->trans_complete();
        return ($this->db->trans_status() === TRUE) ? $bill_id : FALSE;
    }

    public function get_bill($id) {
        // Get bill header with customer information
        $this->db->select('bills.*, customers.name as customer_name, customers.phone as customer_phone, customers.email as customer_email');
        $this->db->from('bills');
        $this->db->join('customers', 'customers.id = bills.customer_id', 'left');
        $this->db->where('bills.id', $id);
        $bill = $this->db->get()->row();

        if ($bill) {
            // Get bill items with inventory information
            $this->db->select('bill_items.*, inventory.title, inventory.sku');
            $this->db->from('bill_items');
            $this->db->join('inventory', 'inventory.id = bill_items.item_id');
            $this->db->where('bill_id', $id);
            $bill->items = $this->db->get()->result();
        }

        return $bill;
    }

    public function get_all_bills($limit = NULL, $offset = NULL) {
        $this->db->select('bills.*, customers.name as customer_name, customers.phone as customer_phone, customers.email as customer_email');
        $this->db->from('bills');
        $this->db->join('customers', 'customers.id = bills.customer_id', 'left');
        $this->db->order_by('bills.created_at', 'DESC');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $bills = $this->db->get()->result();

        // Get items for each bill
        foreach ($bills as $bill) {
            $this->db->select('bill_items.*, inventory.title');
            $this->db->from('bill_items');
            $this->db->join('inventory', 'inventory.id = bill_items.item_id');
            $this->db->where('bill_id', $bill->id);
            $bill->items = $this->db->get()->result();
        }

        return $bills;
    }

    public function get_bills_by_date_range($start_date, $end_date) {
        $this->db->select('bills.*, customers.name as customer_name, customers.phone as customer_phone, customers.email as customer_email');
        $this->db->from('bills');
        $this->db->join('customers', 'customers.id = bills.customer_id', 'left');
        $this->db->where('bills.created_at >=', $start_date);
        $this->db->where('bills.created_at <=', $end_date);
        $this->db->order_by('bills.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_daily_sales($date) {
        $this->db->select_sum('total_amount');
        $this->db->where('DATE(created_at)', $date);
        $this->db->where('status', 'paid');
        return $this->db->get('bills')->row()->total_amount ?? 0;
    }

    public function get_monthly_sales($month, $year) {
        $this->db->select_sum('total_amount');
        $this->db->where('MONTH(created_at)', $month);
        $this->db->where('YEAR(created_at)', $year);
        $this->db->where('status', 'paid');
        return $this->db->get('bills')->row()->total_amount ?? 0;
    }

    public function void_bill($id) {
        $this->db->trans_start();

        // Get bill items to restore inventory
        $this->db->where('bill_id', $id);
        $items = $this->db->get('bill_items')->result();

        foreach ($items as $item) {
            // Restore inventory stock
            $this->db->where('id', $item->item_id);
            $this->db->set('stock', 'stock + ' . $item->quantity, FALSE);
            $this->db->update('inventory');
        }

        // Mark bill as void
        $this->db->where('id', $id);
        $this->db->update('bills', ['status' => 'void']);

        $this->db->trans_complete();
        return $this->db->trans_status() === TRUE;
    }

    public function search_bills($search = '', $start_date = '', $end_date = '') {
        $this->db->select('bills.*, customers.name as customer_name, customers.phone as customer_phone, customers.email as customer_email');
        $this->db->from('bills');
        $this->db->join('customers', 'customers.id = bills.customer_id', 'left');
        
        if ($search) {
            $this->db->group_start();
            $this->db->like('bills.bill_number', $search);
            $this->db->or_like('customers.name', $search);
            $this->db->or_like('customers.phone', $search);
            $this->db->group_end();
        }
        
        if ($start_date) {
            $this->db->where('DATE(bills.created_at) >=', $start_date);
        }
        
        if ($end_date) {
            $this->db->where('DATE(bills.created_at) <=', $end_date);
        }
        
        $this->db->order_by('bills.created_at', 'DESC');
        $bills = $this->db->get()->result();
        
        // Get items for each bill
        foreach ($bills as $bill) {
            $this->db->select('bill_items.*, inventory.title, inventory.sku');
            $this->db->from('bill_items');
            $this->db->join('inventory', 'inventory.id = bill_items.item_id');
            $this->db->where('bill_id', $bill->id);
            $bill->items = $this->db->get()->result();
        }
        
        return $bills;
    }

    public function get_bill_count() {
        return $this->db->count_all('bills');
    }

    public function get_today_bills_count() {
        $this->db->where('DATE(created_at)', date('Y-m-d'));
        return $this->db->count_all_results('bills');
    }

    public function get_today_revenue() {
        $this->db->select_sum('total_amount');
        $this->db->where('DATE(created_at)', date('Y-m-d'));
        $result = $this->db->get('bills')->row();
        return $result->total_amount ?? 0;
    }

    public function get_monthly_revenue() {
        $this->db->select_sum('total_amount');
        $this->db->where('MONTH(created_at)', date('m'));
        $this->db->where('YEAR(created_at)', date('Y'));
        $result = $this->db->get('bills')->row();
        return $result->total_amount ?? 0;
    }

    public function get_total_revenue() {
        $this->db->select_sum('total_amount');
        $result = $this->db->get('bills')->row();
        return $result->total_amount ?? 0;
    }

    public function get_dashboard_stats() {
        $stats = [];
        
        // Total bills
        $stats['total_bills'] = $this->db->count_all('bills');
        
        // Today's bills count
        $this->db->where('DATE(created_at)', date('Y-m-d'));
        $stats['today_bills'] = $this->db->count_all_results('bills');
        $this->db->reset_query();
        
        // Today's revenue
        $stats['today_revenue'] = $this->get_today_revenue();
        
        // Total revenue
        $stats['total_revenue'] = $this->get_total_revenue();
        
        // Monthly revenue
        $stats['monthly_revenue'] = $this->get_monthly_revenue();
        
        return $stats;
    }

    public function update_bill_payment($id, $update_data) {
        $this->db->where('id', $id);
        return $this->db->update('bills', $update_data);
    }

    public function get_billing_stats() {
        $stats = [];
        
        // Total bills
        $stats['total_bills'] = $this->db->count_all('bills');
        
        // Paid bills
        $this->db->where('payment_status', 'paid');
        $this->db->or_where('payment_status IS NULL');
        $this->db->where('status !=', 'void');
        $stats['paid_bills'] = $this->db->count_all_results('bills');
        $this->db->reset_query();
        
        // Pending bills
        $this->db->where('payment_status', 'pending');
        $this->db->where('status !=', 'void');
        $stats['pending_bills'] = $this->db->count_all_results('bills');
        $this->db->reset_query();
        
        // Partial bills
        $this->db->where('payment_status', 'partial');
        $this->db->where('status !=', 'void');
        $stats['partial_bills'] = $this->db->count_all_results('bills');
        $this->db->reset_query();
        
        // Total outstanding amount
        $this->db->select('SUM(total_amount - COALESCE(paid_amount, 0)) as outstanding');
        $this->db->where_in('payment_status', ['pending', 'partial']);
        $this->db->where('status !=', 'void');
        $result = $this->db->get('bills')->row();
        $stats['total_outstanding'] = $result->outstanding ?? 0;
        $this->db->reset_query();
        
        // Total collected amount
        $this->db->select('SUM(COALESCE(paid_amount, total_amount)) as collected');
        $this->db->where('status !=', 'void');
        $result = $this->db->get('bills')->row();
        $stats['total_collected'] = $result->collected ?? 0;
        
        return $stats;
    }

    public function get_last_bill_number($date) {
        $this->db->select('bill_number');
        $this->db->like('bill_number', 'BILL-' . $date . '-', 'after');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $result = $this->db->get('bills')->row();

        if ($result) {
            // Extract number from BILL-20250624-001 format
            $parts = explode('-', $result->bill_number);
            return isset($parts[2]) ? (int)$parts[2] : 0;
        }
        return 0;
    }

    public function get_last_bill_number_global() {
        $this->db->select('bill_number');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $result = $this->db->get('bills')->row();

        if ($result) {
            // Extract number from 0001, 0002, etc. format
            return (int)$result->bill_number;
        }
        return 0;
    }

    public function update_bill($id, $bill_data, $items) {
        $this->db->trans_start();

        // Update bill header
        $this->db->where('id', $id);
        $this->db->update('bills', $bill_data);

        // Delete existing bill items
        $this->db->where('bill_id', $id);
        $this->db->delete('bill_items');

        // Insert updated bill items
        foreach ($items as $item) {
            $item['bill_id'] = $id;
            $this->db->insert('bill_items', $item);
        }

        $this->db->trans_complete();
        return $this->db->trans_status() === TRUE;
    }

    public function get_filtered_bills($search = '', $from_date = '', $to_date = '', $sort_field = 'created_at', $sort_direction = 'desc', $limit = 25, $offset = 0) {
        $this->db->select('bills.*, customers.name as customer_name, customers.phone as customer_phone');
        $this->db->from('bills');
        $this->db->join('customers', 'customers.id = bills.customer_id', 'left');
        
        if ($search) {
            $this->db->group_start();
            $this->db->like('bills.bill_number', $search);
            $this->db->or_like('customers.name', $search);
            $this->db->or_like('customers.phone', $search);
            $this->db->group_end();
        }
        
        if ($from_date) {
            $this->db->where('DATE(bills.created_at) >=', $from_date);
        }
        
        if ($to_date) {
            $this->db->where('DATE(bills.created_at) <=', $to_date);
        }
        
        $this->db->order_by('bills.' . $sort_field, $sort_direction);
        $this->db->limit($limit, $offset);
        
        $bills = $this->db->get()->result();
        
        // Get items for each bill
        foreach ($bills as $bill) {
            $this->db->select('bill_items.*, inventory.title, inventory.sku');
            $this->db->from('bill_items');
            $this->db->join('inventory', 'inventory.id = bill_items.item_id');
            $this->db->where('bill_id', $bill->id);
            $bill->items = $this->db->get()->result();
        }
        
        return $bills;
    }

    public function get_filtered_bills_count($search = '', $from_date = '', $to_date = '') {
        $this->db->from('bills');
        $this->db->join('customers', 'customers.id = bills.customer_id', 'left');
        
        if ($search) {
            $this->db->group_start();
            $this->db->like('bills.bill_number', $search);
            $this->db->or_like('customers.name', $search);
            $this->db->or_like('customers.phone', $search);
            $this->db->group_end();
        }
        
        if ($from_date) {
            $this->db->where('DATE(bills.created_at) >=', $from_date);
        }
        
        if ($to_date) {
            $this->db->where('DATE(bills.created_at) <=', $to_date);
        }
        
        return $this->db->count_all_results();
    }
    
    public function check_item_usage($item_id) {
        $this->db->where('item_id', $item_id);
        return $this->db->count_all_results('bill_items');
    }

    public function delete_bill($id) {
        $this->db->trans_start();
        
        // Delete bill items first
        $this->db->where('bill_id', $id);
        $this->db->delete('bill_items');
        
        // Delete the bill
        $this->db->where('id', $id);
        $this->db->delete('bills');
        
        $this->db->trans_complete();
        return $this->db->trans_status() === TRUE;
    }
} 