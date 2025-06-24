<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pos extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['product_model', 'customer_model']);
        $this->load->library(['form_validation', 'cart']);
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        $data['categories'] = $this->product_model->get_all_categories();
        $data['products'] = $this->product_model->get_all_products();
        $data['cart_items'] = $this->cart->contents();
        
        // Calculate cart totals
        $data['subtotal'] = $this->cart->total();
        $data['tax'] = $this->cart->total() * 0.1; // 10% tax
        $data['total'] = $data['subtotal'] + $data['tax'];
        
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('pos/index', $data);
        $this->load->view('templates/footer');
    }

    public function get_products_by_category() {
        $category_id = $this->input->post('category_id');
        if ($category_id) {
            $this->db->where('category_id', $category_id);
        }
        $products = $this->db->get('products')->result();
        echo json_encode($products);
    }

    public function add_to_cart() {
        $product_id = $this->input->post('product_id');
        $quantity = $this->input->post('quantity', true) ? $this->input->post('quantity', true) : 1;
        
        $product = $this->product_model->get_product($product_id);
        
        if ($product) {
            // Check stock
            if ($product->quantity < $quantity) {
                echo json_encode(['status' => 'error', 'message' => 'Insufficient stock']);
                return;
            }
            
            $data = array(
                'id'      => $product->product_id,
                'qty'     => $quantity,
                'price'   => $product->price,
                'name'    => $product->name,
                'options' => array(
                    'code' => $product->code,
                    'unit' => $product->unit
                )
            );
            
            $this->cart->insert($data);
            
            // Return updated cart data
            $response = array(
                'status' => 'success',
                'cart_count' => count($this->cart->contents()),
                'cart_total' => $this->cart->total(),
                'cart_items' => $this->cart->contents()
            );
            
            echo json_encode($response);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Product not found']);
        }
    }

    public function update_cart() {
        $rowid = $this->input->post('rowid');
        $quantity = $this->input->post('quantity');
        
        // Get product info to check stock
        $cart_item = $this->cart->get_item($rowid);
        $product = $this->product_model->get_product($cart_item['id']);
        
        if ($product->quantity < $quantity) {
            echo json_encode(['status' => 'error', 'message' => 'Insufficient stock']);
            return;
        }
        
        $data = array(
            'rowid' => $rowid,
            'qty'   => $quantity
        );
        
        $this->cart->update($data);
        
        // Return updated cart data
        $response = array(
            'status' => 'success',
            'cart_count' => count($this->cart->contents()),
            'cart_total' => $this->cart->total(),
            'cart_items' => $this->cart->contents()
        );
        
        echo json_encode($response);
    }

    public function remove_from_cart() {
        $rowid = $this->input->post('rowid');
        
        $this->cart->remove($rowid);
        
        // Return updated cart data
        $response = array(
            'status' => 'success',
            'cart_count' => count($this->cart->contents()),
            'cart_total' => $this->cart->total(),
            'cart_items' => $this->cart->contents()
        );
        
        echo json_encode($response);
    }

    public function clear_cart() {
        $this->cart->destroy();
        echo json_encode(['status' => 'success']);
    }

    public function search_customers() {
        $term = $this->input->post('term');
        $customers = $this->customer_model->search_customers($term);
        echo json_encode($customers);
    }

    public function process_sale() {
        if (empty($this->cart->contents())) {
            $this->session->set_flashdata('error', 'Cart is empty');
            redirect('pos');
        }
        
        $this->form_validation->set_rules('customer_id', 'Customer', 'required');
        $this->form_validation->set_rules('payment_method', 'Payment Method', 'required');
        $this->form_validation->set_rules('paid_amount', 'Paid Amount', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('pos');
        }
        
        // Generate invoice number
        $invoice_no = 'INV-' . date('Ymd') . '-' . random_string('numeric', 4);
        
        // Calculate totals
        $subtotal = $this->cart->total();
        $tax = $subtotal * 0.1; // 10% tax
        $total = $subtotal + $tax;
        $paid_amount = $this->input->post('paid_amount');
        $due_amount = $total - $paid_amount;
        
        // Prepare sale data
        $sale_data = array(
            'customer_id' => $this->input->post('customer_id'),
            'user_id' => $this->session->userdata('user_id'),
            'invoice_no' => $invoice_no,
            'total_amount' => $subtotal,
            'tax' => $tax,
            'grand_total' => $total,
            'paid_amount' => $paid_amount,
            'due_amount' => $due_amount,
            'payment_method' => $this->input->post('payment_method'),
            'payment_status' => $paid_amount >= $total ? 'paid' : ($paid_amount > 0 ? 'partial' : 'due'),
            'sale_status' => 'completed',
            'note' => $this->input->post('note')
        );
        
        // Start transaction
        $this->db->trans_start();
        
        // Insert sale
        $this->db->insert('sales', $sale_data);
        $sale_id = $this->db->insert_id();
        
        // Insert sale items and update stock
        foreach ($this->cart->contents() as $item) {
            $sale_item = array(
                'sale_id' => $sale_id,
                'product_id' => $item['id'],
                'quantity' => $item['qty'],
                'unit_price' => $item['price'],
                'subtotal' => $item['subtotal']
            );
            
            $this->db->insert('sale_items', $sale_item);
            
            // Update stock
            $this->db->where('product_id', $item['id']);
            $this->db->set('quantity', 'quantity-'.$item['qty'], false);
            $this->db->update('products');
            
            // Add to inventory log
            $log_data = array(
                'product_id' => $item['id'],
                'user_id' => $this->session->userdata('user_id'),
                'type' => 'out',
                'quantity' => $item['qty'],
                'note' => 'Sale: '.$invoice_no
            );
            $this->db->insert('inventory_log', $log_data);
        }
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Error processing sale');
            redirect('pos');
        }
        
        // Clear cart
        $this->cart->destroy();
        
        // Redirect to print invoice
        redirect('sales/invoice/'.$sale_id);
    }
} 