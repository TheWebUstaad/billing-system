<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Authentication
    public function login($username, $password) {
        $this->db->where('username', $username);
        $query = $this->db->get('administrators');
        if ($query->num_rows() > 0) {
            $admin = $query->row();
            if (password_verify($password, $admin->password)) {
                return $admin;
            }
        }
        return false;
    }

    // User Management
    public function get_all_admins() {
        return $this->db->get('administrators')->result();
    }

    public function add_admin($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return $this->db->insert('administrators', $data);
    }

    public function update_admin($id, $data) {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        $this->db->where('id', $id);
        return $this->db->update('administrators', $data);
    }

    public function delete_admin($id) {
        $this->db->where('id', $id);
        return $this->db->delete('administrators');
    }
} 