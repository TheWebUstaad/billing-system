<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
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
        <div class="col-md-4 text-end">
            <div class="btn-group">
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
    </div>

    <div class="row">
        <!-- Left Panel - Bill & Customer Info -->
        <div class="col-md-4">
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
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h6 class="card-title mb-0">
                        <i class="fa fa-shopping-cart me-2"></i>Bill Items
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="45%">Item Description</th>
                                    <th width="15%" class="text-center">Quantity</th>
                                    <th width="17%" class="text-end">Unit Price</th>
                                    <th width="18%" class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                <?php foreach ($grouped_items as $item): ?>
                                <tr>
                                    <td class="text-center"><?php echo $counter++; ?></td>
                                    <td>
                                        <div class="item-info">
                                            <strong><?php echo $item['title']; ?></strong>
                                            <?php if (!empty($item['sku'])): ?>
                                                <br><small class="text-muted">SKU: <?php echo $item['sku']; ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark"><?php echo $item['quantity']; ?></span>
                                    </td>
                                    <td class="text-end"><?php echo $settings['currency_symbol'] . ' ' . number_format($item['unit_price'], 2); ?></td>
                                    <td class="text-end"><strong><?php echo $settings['currency_symbol'] . ' ' . number_format($item['total_price'], 2); ?></strong></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-dark">
                                <?php 
                                // Calculate total quantity
                                $total_quantity = 0;
                                foreach ($grouped_items as $item) {
                                    $total_quantity += $item['quantity'];
                                }
                                ?>
                                <tr>
                                    <td colspan="2" class="text-end text-white"><strong>Total Quantity:</strong></td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark fs-6">
                                            <?php echo $total_quantity; ?> items
                                        </span>
                                    </td>
                                    <td colspan="2" class="text-end text-white"><strong>Grand Total:</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end text-white"><strong>Amount Total:</strong></td>
                                    <td class="text-end">
                                        <h5 class="mb-0 text-warning">
                                            <?php echo $settings['currency_symbol'] . ' ' . number_format($bill->total_amount, 2); ?>
                                        </h5>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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
}

.info-row .value {
    font-weight: 600;
    color: #333;
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