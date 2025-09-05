<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['billing_model', 'inventory_model', 'settings_model', 'customer_model']);
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
        
        // Check if user is logged in
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('auth');
        }
    }

    public function index() {
        $data['title'] = 'Bills';
        $data['settings'] = $this->settings_model->get_settings();
        $data['bills'] = $this->billing_model->get_all_bills(25, 0);
        $data['stats'] = $this->billing_model->get_billing_stats();
        
        $this->load->view('templates/header', $data);
        $this->load->view('billing/index', $data);
        $this->load->view('templates/footer', $data);
    }

    public function get_bills_ajax() {
        $page = (int)$this->input->get('page') ?: 1;
        $per_page = (int)$this->input->get('per_page') ?: 25;
        $search = $this->input->get('search') ?: '';
        $from_date = $this->input->get('from_date') ?: '';
        $to_date = $this->input->get('to_date') ?: '';
        $sort_field = $this->input->get('sort_field') ?: 'created_at';
        $sort_direction = $this->input->get('sort_direction') ?: 'desc';

        $offset = ($page - 1) * $per_page;
        
        // Get filtered bills
        $bills = $this->billing_model->get_filtered_bills($search, $from_date, $to_date, $sort_field, $sort_direction, $per_page, $offset);
        $total_bills = $this->billing_model->get_filtered_bills_count($search, $from_date, $to_date);
        
        // Calculate pagination
        $total_pages = ceil($total_bills / $per_page);
        $showing_from = $total_bills > 0 ? $offset + 1 : 0;
        $showing_to = min($offset + $per_page, $total_bills);
        
        $response = [
            'bills' => $bills,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $total_pages,
                'total_records' => $total_bills,
                'showing_from' => $showing_from,
                'showing_to' => $showing_to,
                'per_page' => $per_page
            ]
        ];
        
        echo json_encode($response);
    }

    public function create() {
        $data['title'] = 'Create Bill';
        $data['settings'] = $this->settings_model->get_settings();
        $data['inventory'] = $this->inventory_model->get_all_items();
        
        $this->load->view('templates/header', $data);
        $this->load->view('billing/create', $data);
        $this->load->view('templates/footer', $data);
    }

    public function store() {
        // Validate form
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
        $this->form_validation->set_rules('item_name[]', 'Items', 'required');
        $this->form_validation->set_rules('quantity[]', 'Quantities', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('unit_price[]', 'Unit Prices', 'required|numeric|greater_than[0]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->create();
            return;
        }

        // Check if customer exists or create new one (for customer database)
        $customer_phone = $this->input->post('customer_phone');
        $customer = $this->customer_model->get_customer_by_phone($customer_phone);
        
        if (!$customer) {
            $customer_data = array(
                'name' => $this->input->post('customer_name'),
               
            );
            $customer_id = $this->customer_model->add_customer($customer_data);
        } else {
            $customer_id = $customer->id;
            // Update customer name if different
            if ($customer->name !== $this->input->post('customer_name')) {
                $this->customer_model->update_customer($customer_id, ['name' => $this->input->post('customer_name')]);
            }
        }

        // Generate sequential bill number (auto increment)
        $last_bill_number = $this->billing_model->get_last_bill_number_global();
        $next_number = $last_bill_number ? ($last_bill_number + 1) : 1;
        $bill_number = sprintf('%04d', $next_number);

        // Get form data (simplified - no payment tracking)
        $bill_data = array(
            'bill_number' => $bill_number,
            'customer_id' => $customer_id,
            'total_amount' => $this->input->post('total_amount'),
            'created_by' => $this->session->userdata('admin_id'),
            'created_at' => date('Y-m-d H:i:s')
        );

        // Process items - Create inventory items if they don't exist
        $item_names = $this->input->post('item_name');
        $item_ids = $this->input->post('item_id');
        $quantities = $this->input->post('quantity');
        $unit_prices = $this->input->post('unit_price');

        $bill_items = array();
        for ($i = 0; $i < count($item_names); $i++) {
            if (!empty($item_names[$i])) {
                $item_id = $item_ids[$i];
                
                // If item_id is empty, create new inventory item
                if (empty($item_id)) {
                    $item_data = array(
                        'title' => trim($item_names[$i]),
                        'price' => $unit_prices[$i],
                        'stock' => 0, // No stock tracking for new items
                        'description' => 'Added from billing'
                    );
                    $item_id = $this->inventory_model->add_item($item_data);
                }
                
                $total_price = $quantities[$i] * $unit_prices[$i];
                $bill_items[] = array(
                    'item_id' => $item_id,
                    'quantity' => $quantities[$i],
                    'unit_price' => $unit_prices[$i],
                    'total_price' => $total_price
                );
            }
        }

        // Create bill and get bill ID
        $bill_id = $this->billing_model->create_simple_bill($bill_data, $bill_items);

        if ($bill_id) {
            $this->session->set_flashdata('success', 'بل کامیابی سے بن گیا');
            redirect('billing/view/' . $bill_id);
        } else {
            $this->session->set_flashdata('error', 'بل بنانے میں ناکامی');
            redirect('billing/create');
        }
    }

    public function search_customers() {
        $query = $this->input->get('q');
        $customers = $this->customer_model->search_customers($query);
        echo json_encode($customers);
    }

    public function get_customer_details() {
        $phone = $this->input->get('phone');
        $customer = $this->customer_model->get_customer_by_phone($phone);
        echo json_encode($customer);
    }

    public function view($id) {
        $data['title'] = 'View Bill';
        $data['settings'] = $this->settings_model->get_settings();
        $data['bill'] = $this->billing_model->get_bill($id);
        
        if (empty($data['bill'])) {
            show_404();
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('billing/view', $data);
        $this->load->view('templates/footer', $data);
    }

    public function print($id) {
        $data['title'] = 'Print Bill';
        $data['settings'] = $this->settings_model->get_settings();
        $data['bill'] = $this->billing_model->get_bill($id);
        
        if (empty($data['bill'])) {
            show_404();
        }
        
        $this->load->view('billing/print', $data);
    }

    public function pdf($id) {
        $data['settings'] = $this->settings_model->get_settings();
        $data['bill'] = $this->billing_model->get_bill($id);
        
        if (empty($data['bill'])) {
            show_404();
        }

        $this->load->library('pdf');
        
        // Generate PDF content
        $html = $this->load->view('billing/pdf_template', $data, true);
        
        // Set PDF parameters for A5 size with smaller margins
        $param = [
            'title' => 'Bill #' . $data['bill']->bill_number,
            'page_format' => 'A5',
            'margins' => [8, 8, 8]  // smaller margins for A5
        ];
        
        // Generate PDF
        $filename = 'Bill_' . $data['bill']->bill_number . '.pdf';
        $this->pdf->load($param)->generate($html, $filename, true);
    }



    public function get_item_details() {
        $item_id = $this->input->post('item_id');
        $item = $this->inventory_model->get_item($item_id);
        echo json_encode($item);
    }

    public function search_items() {
        $query = $this->input->get('q');
        $items = $this->inventory_model->search_items($query);
        
        // Format items for JSON response
        $formatted_items = array();
        foreach ($items as $item) {
            $formatted_items[] = array(
                'id' => $item->id,
                'title' => $item->title,
                'sku' => $item->sku,
                'price' => $item->price,
                'stock' => $item->stock
            );
        }
        
        echo json_encode($formatted_items);
    }

    public function add_customer() {
        $response = ['success' => false, 'message' => ''];
        
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            $response['message'] = validation_errors();
            echo json_encode($response);
            return;
        }
        
        // Check if customer with this phone already exists
        $existing_customer = $this->customer_model->get_customer_by_phone($this->input->post('phone'));
        if ($existing_customer) {
            $response['message'] = 'Customer with this phone number already exists';
            echo json_encode($response);
            return;
        }
        
        $customer_data = [
            'name' => $this->input->post('name'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address')
        ];
        
        $customer_id = $this->customer_model->add_customer($customer_data);
        
        if ($customer_id) {
            $response['success'] = true;
            $response['customer_id'] = $customer_id;
            $response['message'] = 'Customer added successfully';
        } else {
            $response['message'] = 'Failed to add customer';
        }
        
        echo json_encode($response);
    }



    public function get_bill_stats() {
        $stats = $this->billing_model->get_billing_stats();
        echo json_encode($stats);
    }

    public function get_dashboard_stats() {
        $stats = $this->billing_model->get_dashboard_stats();
        echo json_encode($stats);
    }

    // New method to add item directly from billing interface
    public function add_item_quick() {
        $response = ['success' => false, 'message' => '', 'item' => null];
        
        $this->form_validation->set_rules('title', 'Item Name', 'required|trim');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric|greater_than[0]');
        
        if ($this->form_validation->run() == FALSE) {
            $response['message'] = validation_errors();
            echo json_encode($response);
            return;
        }
        
        // Check if item already exists by title
        $existing_item = $this->inventory_model->get_item_by_title($this->input->post('title'));
        if ($existing_item) {
            $response['message'] = 'Item with this name already exists';
            $response['item'] = $existing_item;
            echo json_encode($response);
            return;
        }
        
        $item_data = [
            'title' => trim($this->input->post('title')),
            'price' => $this->input->post('price'),
            'stock' => 0, // No initial stock
            'description' => 'Added from billing interface'
        ];
        
        $item_id = $this->inventory_model->add_item($item_data);
        
        if ($item_id) {
            $new_item = $this->inventory_model->get_item($item_id);
            $response['success'] = true;
            $response['item'] = $new_item;
            $response['message'] = 'Item added successfully';
        } else {
            $response['message'] = 'Failed to add item';
        }
        
        echo json_encode($response);
    }



    public function delete($id) {
        $bill = $this->billing_model->get_bill($id);
        if (!$bill) {
            show_404();
        }

        if ($this->billing_model->delete_bill($id)) {
            $this->session->set_flashdata('success', 'بل کامیابی سے ڈیلیٹ ہو گیا');
        } else {
            $this->session->set_flashdata('error', 'بل ڈیلیٹ کرنے میں ناکامی');
        }
        redirect('billing');
    }

    public function export_bills() {
        $from_date = $this->input->get('from_date') ?: date('Y-m-01');
        $to_date = $this->input->get('to_date') ?: date('Y-m-d');
        $search = $this->input->get('search') ?: '';

        // Get filtered bills for export
        $bills = $this->billing_model->get_filtered_bills($search, $from_date, $to_date, 'created_at', 'desc', 1000, 0);
        $settings = $this->settings_model->get_settings();

        // Calculate totals
        $total_amount = 0;
        $total_bills = count($bills);
        foreach ($bills as $bill) {
            $total_amount += $bill->total_amount;
        }

        $data = [
            'bills' => $bills,
            'settings' => $settings,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'search' => $search,
            'total_bills' => $total_bills,
            'total_amount' => $total_amount,
            'export_date' => date('Y-m-d H:i:s')
        ];

        $this->load->library('pdf');

        // Generate PDF content
        $html = $this->load->view('billing/export_template', $data, true);

        // Set PDF parameters - keeping A4 for export reports as they have more data
        $param = [
            'title' => 'Bills Export Report - ' . date('d M Y'),
            'page_format' => 'A4',  // A4 for export reports
            'margins' => [15, 15, 15]
        ];

        // Generate PDF
        $filename = 'Bills_Export_' . date('Ymd_His') . '.pdf';
        $this->pdf->load($param)->generate($html, $filename, true);
    }

    public function edit($id) {
        $data['title'] = 'Edit Bill';
        $data['settings'] = $this->settings_model->get_settings();
        $data['bill'] = $this->billing_model->get_bill($id);
        $data['inventory'] = $this->inventory_model->get_all_items();

        if (empty($data['bill'])) {
            show_404();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('billing/edit', $data);
        $this->load->view('templates/footer', $data);
    }

    public function update($id) {
        // Validate form
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
        $this->form_validation->set_rules('item_name[]', 'Items', 'required');
        $this->form_validation->set_rules('quantity[]', 'Quantities', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('unit_price[]', 'Unit Prices', 'required|numeric|greater_than[0]');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
            return;
        }

        // Check if customer exists or create new one
        $customer_phone = $this->input->post('customer_phone');
        $customer = $this->customer_model->get_customer_by_phone($customer_phone);

        if (!$customer) {
            $customer_data = array(
                'name' => $this->input->post('customer_name'),
                'phone' => $customer_phone
            );
            $customer_id = $this->customer_model->add_customer($customer_data);
        } else {
            $customer_id = $customer->id;
            // Update customer name if different
            if ($customer->name !== $this->input->post('customer_name')) {
                $this->customer_model->update_customer($customer_id, ['name' => $this->input->post('customer_name')]);
            }
        }

        // Get form data
        $bill_data = array(
            'customer_id' => $customer_id,
            'total_amount' => $this->input->post('total_amount'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        // Process items
        $item_names = $this->input->post('item_name');
        $item_ids = $this->input->post('item_id');
        $quantities = $this->input->post('quantity');
        $unit_prices = $this->input->post('unit_price');

        $bill_items = array();
        for ($i = 0; $i < count($item_names); $i++) {
            if (!empty($item_names[$i])) {
                $item_id = $item_ids[$i];

                // If item_id is empty, create new inventory item
                if (empty($item_id)) {
                    $item_data = array(
                        'title' => trim($item_names[$i]),
                        'price' => $unit_prices[$i],
                        'stock' => 0,
                        'description' => 'Added from billing'
                    );
                    $item_id = $this->inventory_model->add_item($item_data);
                }

                $total_price = $quantities[$i] * $unit_prices[$i];
                $bill_items[] = array(
                    'item_id' => $item_id,
                    'quantity' => $quantities[$i],
                    'unit_price' => $unit_prices[$i],
                    'total_price' => $total_price
                );
            }
        }

        // Update bill
        if ($this->billing_model->update_bill($id, $bill_data, $bill_items)) {
            $this->session->set_flashdata('success', 'بل کامیابی سے اپ ڈیٹ ہو گیا');
            redirect('billing/view/' . $id);
        } else {
            $this->session->set_flashdata('error', 'بل اپ ڈیٹ کرنے میں ناکامی');
            redirect('billing/edit/' . $id);
        }
    }
} 