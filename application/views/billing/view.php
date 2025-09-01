    <div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center mb-3 mb-md-0">
                <div class="bill-status-indicator me-3">
                    <i class="fa fa-receipt text-success fa-2x"></i>
                </div>
                <div>
                    <h2 class="mb-1">Bill #<?php echo $bill->bill_number; ?></h2>
                    <p class="text-muted mb-0">
                        Created on <?php echo date('d M Y, h:i A', strtotime($bill->created_at)); ?>
                        <?php if ($bill->status === 'void'): ?>
                            <span class="badge bg-danger ms-2">VOID</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <!-- Desktop Button Group -->
            <div class="d-none d-md-flex justify-content-end">
                <div class="btn-group" role="group">
                    <a href="<?php echo base_url('billing'); ?>" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                    <a href="<?php echo base_url('billing/edit/' . $bill->id); ?>" class="btn btn-outline-primary">
                        <i class="fa fa-edit"></i> Edit Bill
                    </a>
                    <a href="<?php echo base_url('billing/pdf/' . $bill->id); ?>" class="btn btn-outline-success" target="_blank">
                        <i class="fa fa-download"></i> Download PDF
                    </a>
                    <a href="<?php echo base_url('billing/delete/' . $bill->id); ?>" class="btn btn-outline-danger delete-bill"
                       data-bill="<?php echo $bill->bill_number; ?>" title="Delete Bill">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </div>
            </div>

            <!-- Mobile Button Layout -->
            <div class="d-flex d-md-none flex-wrap gap-2">
                <a href="<?php echo base_url('billing'); ?>" class="btn btn-outline-secondary flex-fill">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                <a href="<?php echo base_url('billing/edit/' . $bill->id); ?>" class="btn btn-outline-primary flex-fill">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <a href="<?php echo base_url('billing/pdf/' . $bill->id); ?>" class="btn btn-outline-success flex-fill" target="_blank">
                    <i class="fa fa-download"></i> PDF
                </a>
                <a href="<?php echo base_url('billing/delete/' . $bill->id); ?>" class="btn btn-outline-danger delete-bill flex-fill"
                   data-bill="<?php echo $bill->bill_number; ?>" title="Delete Bill">
                    <i class="fa fa-trash"></i> Delete
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Panel - Bill & Customer Info -->
        <div class="col-12 col-md-4 order-2 order-md-1">
            <!-- Bill Information -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fa fa-file-text me-2"></i>Bill Details
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <span class="label">Bill Number:</span>
                        <span class="value"><?php echo $bill->bill_number; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">Date & Time:</span>
                        <span class="value"><?php echo date('d M Y, h:i A', strtotime($bill->created_at)); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">Items Count:</span>
                        <span class="value">
                            <?php 
                            // Group items for count
                            $grouped_for_count = array();
                            foreach ($bill->items as $item) {
                                $key = $item->title . '_' . $item->unit_price;
                                $grouped_for_count[$key] = true;
                            }
                            echo count($grouped_for_count); 
                            ?> items
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="label">Total Quantity:</span>
                        <span class="value text-info fw-bold">
                            <?php 
                            // Calculate total quantity
                            $total_qty = 0;
                            foreach ($bill->items as $item) {
                                $total_qty += $item->quantity;
                            }
                            echo $total_qty; 
                            ?> pieces
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="label">Total Amount:</span>
                        <span class="value text-success fw-bold"><?php echo $settings['currency_symbol'] . ' ' . number_format($bill->total_amount, 2); ?></span>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fa fa-user me-2"></i>Customer Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="customer-info">
                        <div class="customer-avatar mb-3 text-center">
                            <div class="avatar-circle">
                                <?php echo strtoupper(substr($bill->customer_name ?: 'WC', 0, 2)); ?>
                            </div>
                        </div>
                        <div class="info-row">
                            <span class="label">Name:</span>
                            <span class="value"><?php echo !empty($bill->customer_name) ? $bill->customer_name : 'Walk-in Customer'; ?></span>
                        </div>
                        <?php if (!empty($bill->customer_phone)): ?>
                        <div class="info-row">
                            <span class="label">Phone:</span>
                            <span class="value">
                                <i class="fa fa-phone me-1"></i><?php echo $bill->customer_phone; ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h6 class="card-title mb-0">
                        <i class="fa fa-bolt me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo base_url('billing/create'); ?>" class="btn btn-primary">
                            <i class="fa fa-plus me-2"></i>Create New Bill
                        </a>
                        <a href="<?php echo base_url('billing/pdf/' . $bill->id); ?>" class="btn btn-success" target="_blank">
                            <i class="fa fa-download me-2"></i>Download PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Items -->
        <div class="col-12 col-md-8 order-1 order-md-2 mb-4 mb-md-0">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h6 class="card-title mb-0">
                        <i class="fa fa-shopping-cart me-2"></i>Bill Items
                    </h6>
                </div>
                <div class="card-body p-0">
                    <!-- Items List Container with Scroll -->
                    <div class="items-scroll-container">
                        <?php
                        $counter = 1;

                        // Group items by title and unit_price
                        $grouped_items = array();
                        foreach ($bill->items as $item) {
                            $key = $item->title . '_' . $item->unit_price;
                            if (!isset($grouped_items[$key])) {
                                $grouped_items[$key] = array(
                                    'title' => $item->title,
                                    'sku' => $item->sku ?? '',
                                    'unit_price' => $item->unit_price,
                                    'quantity' => 0,
                                    'total_price' => 0
                                );
                            }
                            $grouped_items[$key]['quantity'] += $item->quantity;
                            $grouped_items[$key]['total_price'] += $item->total_price;
                        }
                        ?>

                        <?php if (!empty($grouped_items)): ?>
                            <?php foreach ($grouped_items as $index => $item): ?>
                            <div class="item-card">
                                <div class="item-header">
                                    <div class="item-number">#<?php echo $counter++; ?></div>
                                    <div class="item-title-section">
                                        <h6 class="item-title mb-1"><?php echo $item['title']; ?></h6>
                                        <?php if (!empty($item['sku'])): ?>
                                            <small class="text-muted">SKU: <?php echo $item['sku']; ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="item-details">
                                    <div class="detail-row">
                                        <span class="detail-label">Quantity:</span>
                                        <span class="detail-value">
                                            <span class="badge bg-light text-dark"><?php echo $item['quantity']; ?></span>
                                        </span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Unit Price:</span>
                                        <span class="detail-value"><?php echo $settings['currency_symbol'] . ' ' . number_format($item['unit_price'], 2); ?></span>
                                    </div>
                                    <div class="detail-row total-row">
                                        <span class="detail-label">Total:</span>
                                        <span class="detail-value fw-bold text-success"><?php echo $settings['currency_symbol'] . ' ' . number_format($item['total_price'], 2); ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-5 text-muted">
                                <i class="fa fa-shopping-cart fa-3x mb-3"></i>
                                <p>No items found in this bill</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Summary Section -->
                    <?php if (!empty($grouped_items)): ?>
                    <div class="items-summary">
                        <?php
                        // Calculate total quantity
                        $total_quantity = 0;
                        foreach ($grouped_items as $item) {
                            $total_quantity += $item['quantity'];
                        }
                        ?>
                        <div class="summary-row">
                            <div class="summary-label">Total Items:</div>
                            <div class="summary-value">
                                <span class="badge bg-warning text-dark"><?php echo $total_quantity; ?> items</span>
                            </div>
                        </div>
                        <div class="summary-row total-amount">
                            <div class="summary-label">Grand Total:</div>
                            <div class="summary-value">
                                <h5 class="mb-0 text-warning"><?php echo $settings['currency_symbol'] . ' ' . number_format($bill->total_amount, 2); ?></h5>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bill-status-indicator {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #f1f1f1;
}

.info-row:last-child {
    border-bottom: none;
}

.info-row .label {
    font-weight: 500;
    color: #666;
    flex-shrink: 0;
}

.info-row .value {
    font-weight: 600;
    color: #333;
    text-align: right;
    word-break: break-word;
}

/* Mobile responsive info rows */
@media (max-width: 575.98px) {
    .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }

    .info-row .value {
        text-align: left;
        font-size: 0.95rem;
    }

    .info-row .label {
        font-size: 0.85rem;
        opacity: 0.8;
    }
}

.avatar-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
    font-size: 18px;
    margin: 0 auto;
}

.card {
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    border: none;
    border-radius: 12px;
    margin-bottom: 1rem;
}

.card-header {
    border-radius: 12px 12px 0 0;
    border-bottom: 1px solid #dee2e6;
}

.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.9rem;
}

.item-info strong {
    color: #2c3e50;
}

.btn {
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-group .btn {
    border-radius: 8px;
    margin: 0 2px;
}

.badge {
    font-size: 0.8rem;
}

h2 {
    color: #2c3e50;
    font-weight: 700;
}

.text-muted {
    font-size: 0.9rem;
}

/* Comprehensive Mobile Responsiveness */
@media (max-width: 767.98px) {
    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
    }

    /* Header improvements */
    h2 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .bill-status-indicator .fa-2x {
        font-size: 1.5rem;
    }

    /* Mobile button layout */
    .d-flex.d-md-none .btn {
        min-height: 44px;
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem;
        margin-bottom: 0.25rem;
    }

    .d-flex.d-md-none .btn i {
        margin-right: 0.25rem;
    }

    /* Card improvements */
    .card {
        margin-bottom: 1rem;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .card-header {
        padding: 1rem;
        border-radius: 0.75rem 0.75rem 0 0;
    }

    .card-body {
        padding: 1rem;
    }

    /* Avatar improvements */
    .avatar-circle {
        width: 50px;
        height: 50px;
        font-size: 16px;
    }

    /* Table improvements */
    .table-responsive {
        border-radius: 0.5rem;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table-responsive .table {
        font-size: 0.875rem;
        margin-bottom: 0;
    }

    .table-responsive .table th,
    .table-responsive .table td {
        padding: 0.75rem 0.5rem;
        white-space: nowrap;
    }

    .table-responsive .table th {
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Badge improvements */
    .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.5rem;
    }

    /* Item info improvements */
    .item-info strong {
        font-size: 0.95rem;
        display: block;
        margin-bottom: 0.25rem;
    }

    .item-info small {
        font-size: 0.8rem;
    }

    /* Quick actions improvements */
    .d-grid.gap-2 {
        gap: 0.5rem !important;
    }

    .d-grid.gap-2 .btn {
        min-height: 48px;
        font-size: 0.95rem;
    }

    /* Footer table improvements */
    .table-dark td {
        padding: 0.5rem;
    }

    .table-dark .badge {
        font-size: 0.8rem;
    }

    /* Spacing improvements */
    .mb-4 {
        margin-bottom: 1.5rem !important;
    }

    .mb-3 {
        margin-bottom: 1rem !important;
    }

    /* Text improvements */
    .text-muted {
        font-size: 0.85rem;
    }

    /* Animation improvements for mobile */
    .bill-status-indicator {
        animation-duration: 3s; /* Slower on mobile to reduce battery usage */
    }
}

/* Extra small screen optimizations */
@media (max-width: 575.98px) {
    .container-fluid {
        padding-left: 10px;
        padding-right: 10px;
    }

    h2 {
        font-size: 1.25rem;
    }

    .card-body {
        padding: 0.75rem;
    }

    .table-responsive .table th,
    .table-responsive .table td {
        padding: 0.5rem 0.25rem;
    }

    .d-flex.d-md-none .btn {
        font-size: 0.85rem;
        padding: 0.5rem 0.5rem;
    }

    .btn i {
        font-size: 0.9rem;
    }

    /* Hide more table elements on very small screens */
    .d-none.d-sm-table-cell {
        display: none !important;
    }
}

/* Card-based Bill Items Layout */
.items-scroll-container {
    max-height: 400px;
    overflow-y: auto;
    padding: 1rem;
}

@media (max-width: 767.98px) {
    .items-scroll-container {
        max-height: 300px;
        padding: 0.75rem;
    }
}

.item-card {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 0.75rem;
    transition: all 0.3s ease;
}

.item-card:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transform: translateY(-1px);
}

.item-card:last-child {
    margin-bottom: 0;
}

.item-header {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
}

.item-number {
    background: #007bff;
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: bold;
    flex-shrink: 0;
}

.item-title-section {
    flex: 1;
}

.item-title {
    color: #2c3e50;
    font-weight: 600;
    margin: 0;
    font-size: 1rem;
}

.item-details {
    background: white;
    border-radius: 6px;
    padding: 0.75rem;
    border: 1px solid #e9ecef;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.375rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-row.total-row {
    background: #f8f9fa;
    margin: 0 -0.75rem;
    padding: 0.5rem 0.75rem;
    border-radius: 4px;
    border-bottom: none;
}

.detail-label {
    font-weight: 500;
    color: #666;
    font-size: 0.9rem;
}

.detail-value {
    font-weight: 600;
    color: #333;
    text-align: right;
}

.items-summary {
    background: #343a40;
    color: white;
    padding: 1rem;
    border-top: 1px solid #495057;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
}

.summary-row.total-amount {
    border-top: 2px solid #495057;
    margin-top: 0.5rem;
    padding-top: 1rem;
}

.summary-label {
    font-weight: 500;
    font-size: 0.95rem;
}

.summary-value {
    text-align: right;
}

/* Mobile Optimizations for Card Layout */
@media (max-width: 767.98px) {
    .item-card {
        padding: 0.75rem;
        margin-bottom: 0.5rem;
    }

    .item-header {
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .item-number {
        width: 25px;
        height: 25px;
        font-size: 0.7rem;
    }

    .item-title {
        font-size: 0.9rem;
    }

    .item-details {
        padding: 0.5rem;
    }

    .detail-row {
        padding: 0.25rem 0;
    }

    .detail-label {
        font-size: 0.85rem;
    }

    .detail-value {
        font-size: 0.9rem;
    }

    .items-summary {
        padding: 0.75rem;
    }

    .summary-label {
        font-size: 0.9rem;
    }
}

@media (max-width: 575.98px) {
    .items-scroll-container {
        max-height: 250px;
        padding: 0.5rem;
    }

    .item-card {
        padding: 0.5rem;
    }

    .item-title {
        font-size: 0.85rem;
    }

    .detail-label,
    .detail-value {
        font-size: 0.8rem;
    }
}
</style>

<script>
$(document).ready(function() {
    // Delete bill confirmation
    $('.delete-bill').click(function(e) {
        e.preventDefault();
        var link = $(this).attr('href');
        var billNumber = $(this).data('bill');
        
        Swal.fire({
            title: 'بل ڈیلیٹ کریں؟',
            html: '<div style="text-align: right; direction: rtl;">' +
                  '<p>کیا آپ واقعی بل <strong>"' + billNumber + '"</strong> کو ڈیلیٹ کرنا چاہتے ہیں؟</p>' +
                  '<p style="color: #e74c3c;"><i class="fas fa-exclamation-triangle"></i> یہ عمل واپس نہیں ہو سکتا!</p>' +
                  '</div>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ہاں، ڈیلیٹ کریں!',
            cancelButtonText: 'منسوخ کریں'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
            }
        });
    });
});
</script> 