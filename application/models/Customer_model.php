<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_customers() {
        $this->db->select('customers.*, COUNT(bills.id) as bills_count, 
                          COALESCE(SUM(bills.total_amount), 0) as total_spent');
        $this->db->from('customers');
        $this->db->join('bills', 'customers.id = bills.customer_id', 'left');
        $this->db->group_by('customers.id');
        $this->db->order_by('customers.name', 'ASC');
        return $this->db->get()->result();
    }

    public function get_customers_with_bills_count() {
        $this->db->select('customers.*, COUNT(bills.id) as bills_count, 
                          COALESCE(SUM(bills.total_amount), 0) as total_spent,
                          MAX(bills.created_at) as last_bill_date');
        $this->db->from('customers');
        $this->db->join('bills', 'customers.id = bills.customer_id', 'left');
        $this->db->group_by('customers.id');
        $this->db->order_by('customers.name', 'ASC');
        return $this->db->get()->result();
    }

    public function get_customer($id) {
        return $this->db->get_where('customers', ['id' => $id])->row();
    }

    public function get_customer_by_phone($phone) {
        return $this->db->get_where('customers', ['phone' => $phone])->row();
    }

    public function search_customers($term) {
        $this->db->like('name', $term);
        $this->db->or_like('phone', $term);
        $this->db->limit(10);
        $query = $this->db->get('customers');
        return $query->result();
    }

    public function add_customer($data) {
        $this->db->insert('customers', $data);
        return $this->db->insert_id();
    }

    public function update_customer($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('customers', $data);
    }

    public function delete_customer($id) {
        // First check if customer has any bills
        $this->db->where('customer_id', $id);
        $bills_count = $this->db->count_all_results('bills');
        
        if ($bills_count > 0) {
            // Return error code for existing bills
            return 'has_bills';
        }
        
        // If no bills, proceed with deletion
        $this->db->where('id', $id);
        $result = $this->db->delete('customers');
        
        if ($result) {
            return 'success';
        } else {
            return 'error';
        }
    }

    public function get_customer_bills($customer_id, $limit = 10) {
        $this->db->select('bills.*, COUNT(bill_items.id) as items_count');
        $this->db->from('bills');
        $this->db->join('bill_items', 'bills.id = bill_items.bill_id', 'left');
        $this->db->where('bills.customer_id', $customer_id);
        $this->db->group_by('bills.id');
        $this->db->order_by('bills.created_at', 'DESC');
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get()->result();
    }

    public function get_customer_bills_count($customer_id) {
        $this->db->where('customer_id', $customer_id);
        return $this->db->count_all_results('bills');
    }
} 