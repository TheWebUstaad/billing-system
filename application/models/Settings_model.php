<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_settings() {
        $query = $this->db->get('settings');
        $settings = array();
        
        foreach ($query->result() as $row) {
            $settings[$row->setting_key] = $row->setting_value;
        }
        
        // Set default values for missing settings
        $defaults = array(
            'shop_name' => 'My Shop',
            'address' => '',
            'phone' => '',
            'email' => '',
            'currency_symbol' => 'PKR',
            // 'footer_text' => 'Thank you for your business!',
            'low_stock_alert' => '10'
        );
        
        foreach ($defaults as $key => $value) {
            if (!isset($settings[$key])) {
                $settings[$key] = $value;
            }
        }
        
        return $settings;
    }

    public function update_settings($data) {
        $this->db->trans_start();
        
        foreach ($data as $key => $value) {
            $this->db->where('setting_key', $key);
            $exists = $this->db->get('settings')->num_rows() > 0;
            
            if ($exists) {
                $this->db->where('setting_key', $key);
                $this->db->update('settings', array('setting_value' => $value));
            } else {
                $this->db->insert('settings', array(
                    'setting_key' => $key,
                    'setting_value' => $value
                ));
            }
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status() === TRUE;
    }

    public function get_setting($key) {
        $this->db->where('setting_key', $key);
        $query = $this->db->get('settings');
        
        if ($query->num_rows() > 0) {
            return $query->row()->setting_value;
        }
        
        return NULL;
    }
} 