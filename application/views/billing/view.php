    <!-- Professional Bill Container -->
    <div class="bill-container">
        <!-- Bill Header -->
        <div class="bill-header">
            <div class="nav-back">
                <a href="<?php echo base_url('billing'); ?>" class="back-btn">
                    <i class="fa fa-arrow-left"></i>
                </a>
                </div>
            <div class="bill-actions">
                <a href="<?php echo base_url('billing/edit/' . $bill->id); ?>" class="action-link">
                    <i class="fa fa-edit"></i>
                </a>
                <a href="<?php echo base_url('billing/pdf/' . $bill->id); ?>" class="action-link" target="_blank">
                    <i class="fa fa-download"></i>
                </a>
                <a href="<?php echo base_url('billing/delete/' . $bill->id); ?>" class="action-link delete-bill" data-bill="<?php echo $bill->bill_number; ?>">
                    <i class="fa fa-trash"></i>
                </a>
                </div>
            </div>

        <!-- Customer Information -->
        <div class="customer-info">
            <div class="info-row">
                <span class="info-label">Customer:</span>
                    <span class="info-value"><?php echo !empty($bill->customer_name) ? $bill->customer_name : 'Walk-in Customer'; ?></span>
                        </div>
                        <?php if (!empty($bill->customer_phone)): ?>
            <div class="info-row">
                    <span class="info-label">Phone:</span>
                    <span class="info-value"><?php echo $bill->customer_phone; ?></span>
                        </div>
                        <?php endif; ?>
            </div>

        <!-- Items Section -->
        <div class="items-section">
            <table class="items-table">
                <thead>
                    <tr>
                        <th class="item-col">Item Description</th>
                        <th class="qty-col">Qty</th>
                        <th class="price-col">Price</th>
                        <th class="total-col">Total</th>
                    </tr>
                </thead>
                <tbody>
                        <?php
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
                        <tr>
                            <td class="item-name"><?php echo $item['title']; ?></td>
                            <td class="item-qty"><?php echo $item['quantity']; ?></td>
                            <td class="item-price"><?php echo $settings['currency_symbol'] . ' ' . number_format($item['unit_price'], 2); ?></td>
                            <td class="item-total"><?php echo $settings['currency_symbol'] . ' ' . number_format($item['total_price'], 2); ?></td>
                        </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="4" class="no-items">No items found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Bill Summary -->
        <div class="bill-summary">
            <div class="summary-row">
                <span class="summary-label">Total Items:</span>
                <?php
                // Total quantity calculation
                $total_qty = 0;
                foreach ($bill->items as $item) {
                    $total_qty += $item->quantity;
                }
                echo '<span style="font-weight:bold;">(' . $total_qty . ' qty)</span>';
                ?>
                <span class="summary-value"><?php echo count($grouped_items); ?></span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Total Quantity:</span>
                <span class="summary-value">
                    <?php
                    $total_qty = 0;
                    foreach ($bill->items as $item) {
                        $total_qty += $item->quantity;
                    }
                    echo $total_qty;
                    ?>
                </span>
            </div>
        </div>

        <!-- Grand Total -->
        <div class="grand-total">
            <div class="total-row">
                <span class="total-label">GRAND TOTAL</span>
                <span class="total-amount"><?php echo $settings['currency_symbol'] . ' ' . number_format($bill->total_amount, 2); ?></span>
            </div>
            </div>

        <!-- Footer Actions -->
        <div class="bill-footer">
            <div class="footer-actions">
                <a href="<?php echo base_url('billing/create'); ?>" class="footer-btn primary">
                    <i class="fa fa-plus"></i> New Bill
                </a>
                <a href="<?php echo base_url('billing'); ?>" class="footer-btn secondary">
                    <i class="fa fa-list"></i> All Bills
                </a>
            </div>
            <div class="bill-footer-text">
                <p>Thank you for your business!</p>
                <p class="generated-date">Generated on <?php echo date('M d, Y h:i A'); ?></p>
            </div>
        </div>
    </div>

<style>
/* Professional Bill Design */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Courier New', monospace;
    background: #f5f5f5;
    color: #333;
    line-height: 1.4;
}

.bill-container {
    max-width: 800px;
    margin: 20px auto;
    background: white;
    border: 1px solid #ddd;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Bill Header */
.bill-header {
    background: #2c3e50;
    color: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #34495e;
}

.nav-back {
    flex: 0 0 auto;
}

.back-btn {
    color: white;
    text-decoration: none;
    font-size: 18px;
    padding: 8px 12px;
    border-radius: 4px;
    transition: background 0.3s;
}

.back-btn:hover {
    background: rgba(255,255,255,0.1);
}

.bill-info {
    flex: 1;
    text-align: center;
}

.bill-info h1 {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.shop-address {
    font-size: 14px;
    opacity: 0.9;
    margin-bottom: 8px;
}

.bill-number {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 4px;
}

.bill-date {
    font-size: 12px;
    opacity: 0.8;
}

.bill-actions {
    display: flex;
    gap: 8px;
}

.action-link {
    color: white;
    text-decoration: none;
    font-size: 16px;
    padding: 8px;
    border-radius: 4px;
    transition: background 0.3s;
}

.action-link:hover {
    background: rgba(255,255,255,0.1);
}

/* Customer Information */
.customer-info {
    padding: 20px;
    border-bottom: 1px solid #eee;
    background: #f9f9f9;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px 0;
}

.info-label {
    font-size: 14px;
    font-weight: bold;
    color: #555;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 14px;
    font-weight: 600;
    color: #2c3e50;
}

/* Items Section */
.items-section {
    padding: 20px;
}

.items-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    border: 1px solid #ddd;
}

.items-table th {
    background: #34495e;
    color: white;
    padding: 12px 8px;
    text-align: left;
    font-size: 12px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 1px solid #ddd;
}

.items-table td {
    padding: 12px 8px;
    border: 1px solid #ddd;
    font-size: 13px;
}

.item-col {
    width: 50%;
}

.qty-col, .price-col, .total-col {
    width: 16.67%;
    text-align: center;
}

.item-name {
    font-weight: bold;
    color: #2c3e50;
}

.item-qty, .item-price, .item-total {
    text-align: center;
    font-weight: 600;
}

.no-items {
    text-align: center;
    padding: 20px;
    color: #666;
    font-style: italic;
}

/* Bill Summary */
.bill-summary {
    padding: 15px 20px;
    background: #f8f8f8;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 4px 0;
}

.summary-label {
    font-size: 12px;
    font-weight: bold;
    color: #555;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.summary-value {
    font-size: 12px;
    font-weight: bold;
    color: #2c3e50;
}

/* Grand Total */
.grand-total {
    padding: 20px;
    background: #2c3e50;
    color: white;
    border-top: 2px solid #34495e;
}

.total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.total-label {
    font-size: 18px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.total-amount {
    font-size: 24px;
    font-weight: bold;
    color: #ffffff;
}

/* Bill Footer */
.bill-footer {
    padding: 20px;
    background: #f9f9f9;
    border-top: 1px solid #ddd;
}

.footer-actions {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
}

.footer-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: bold;
    transition: all 0.3s;
    border: 2px solid transparent;
}

.footer-btn.primary {
    background: #27ae60;
    color: white;
    border-color: #27ae60;
}

.footer-btn.primary:hover {
    background: #229954;
    border-color: #229954;
}

.footer-btn.secondary {
    background: #3498db;
    color: white;
    border-color: #3498db;
}

.footer-btn.secondary:hover {
    background: #2980b9;
    border-color: #2980b9;
}

.bill-footer-text {
    text-align: center;
    color: #666;
}

.bill-footer-text p {
    margin-bottom: 4px;
    font-size: 12px;
}

.generated-date {
    font-size: 10px;
    opacity: 0.7;
}

/* Responsive Design */
@media (max-width: 768px) {
    .bill-container {
        max-width: 100%;
        margin: 10px;
    }

    .bill-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }

    .bill-info h1 {
        font-size: 24px;
    }

    .items-table {
        font-size: 12px;
    }

    .items-table th,
    .items-table td {
        padding: 8px 4px;
    }

    .footer-actions {
        flex-direction: column;
    }

    .total-label {
        font-size: 16px;
    }

    .total-amount {
        font-size: 20px;
    }
}

@media (max-width: 480px) {
    .bill-header {
        padding: 15px;
    }

    .bill-info h1 {
        font-size: 20px;
    }

    .customer-info,
    .items-section,
    .bill-footer {
        padding: 15px;
    }

    .grand-total {
        padding: 15px;
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
