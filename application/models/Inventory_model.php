<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_items() {
        $this->db->order_by('title', 'ASC');
        return $this->db->get('inventory')->result();
    }

    public function get_item($id) {
        $this->db->where('id', $id);
        return $this->db->get('inventory')->row();
    }

    public function get_item_by_sku($sku) {
        $this->db->where('sku', $sku);
        return $this->db->get('inventory')->row();
    }

    public function get_item_by_title($title) {
        $this->db->where('title', $title);
        return $this->db->get('inventory')->row();
    }

    public function add_item($data) {
        // Generate sequential SKU if not provided
        if (!isset($data['sku']) || empty($data['sku'])) {
            $data['sku'] = $this->generate_next_sku();
        }
        $this->db->insert('inventory', $data);
        return $this->db->insert_id();
    }

    public function generate_next_sku() {
        $this->db->select('sku');
        $this->db->like('sku', 'SKU-', 'after');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $result = $this->db->get('inventory')->row();
        
        if ($result) {
            // Extract number from SKU-0001 format
            $sku_parts = explode('-', $result->sku);
            $last_number = isset($sku_parts[1]) ? (int)$sku_parts[1] : 0;
            $next_number = $last_number + 1;
        } else {
            $next_number = 1;
        }
        
        return 'SKU-' . sprintf('%04d', $next_number);
    }

    public function update_item($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('inventory', $data);
    }

    public function delete_item($id) {
        $this->db->where('id', $id);
        return $this->db->delete('inventory');
    }

    public function update_stock($id, $quantity) {
        $this->db->where('id', $id);
        $this->db->set('stock', 'stock + ' . $quantity, FALSE);
        return $this->db->update('inventory');
    }

    public function search_items($query) {
        $this->db->group_start();
        $this->db->like('title', $query);
        $this->db->or_like('sku', $query);
        $this->db->group_end();
        $this->db->order_by('title', 'ASC');
        return $this->db->get('inventory')->result();
    }

    public function get_low_stock_items($threshold = 10) {
        $this->db->where('stock <=', $threshold);
        $this->db->order_by('stock', 'ASC');
        return $this->db->get('inventory')->result();
    }
} 