    <!-- Simple Mobile Container -->
    <div class="simple-mobile">
        <!-- Simple Header -->
        <div class="simple-header">
            <div class="back-button">
                <a href="<?php echo base_url('billing'); ?>" class="back-link">
                    <i class="fa fa-arrow-left"></i>
                </a>
                </div>
            <div class="bill-title">
                <h1>Bill #<?php echo $bill->bill_number; ?></h1>
                <div class="bill-date"><?php echo date('d M Y, h:i A', strtotime($bill->created_at)); ?></div>
            </div>
        </div>

        <!-- Total Amount - Most Important -->
        <div class="total-section">
            <div class="total-label">Total Amount</div>
            <div class="total-amount"><?php echo $settings['currency_symbol'] . ' ' . number_format($bill->total_amount, 2); ?></div>
            </div>

        <!-- Simple Action Buttons -->
        <div class="action-buttons">
            <a href="<?php echo base_url('billing/edit/' . $bill->id); ?>" class="action-btn">
                    <i class="fa fa-edit"></i> Edit
                </a>
            <a href="<?php echo base_url('billing/pdf/' . $bill->id); ?>" class="action-btn" target="_blank">
                    <i class="fa fa-download"></i> PDF
                </a>
            <a href="<?php echo base_url('billing/delete/' . $bill->id); ?>" class="action-btn delete-bill"
                   data-bill="<?php echo $bill->bill_number; ?>" title="Delete Bill">
                    <i class="fa fa-trash"></i> Delete
                </a>
    </div>

        <!-- Simple Bill Information -->
        <div class="simple-section">
            <div class="section-title">Bill Information</div>
            <div class="info-list">
                <div class="info-item">
                    <span class="info-label">Items:</span>
                    <span class="info-value">
                            <?php 
                            // Group items for count
                            $grouped_for_count = array();
                            foreach ($bill->items as $item) {
                                $key = $item->title . '_' . $item->unit_price;
                                $grouped_for_count[$key] = true;
                            }
                            echo count($grouped_for_count); 
                        ?>
                        </span>
                    </div>
                <div class="info-item">
                    <span class="info-label">Quantity:</span>
                    <span class="info-value">
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
                </div>
            </div>

        <!-- Simple Customer Information -->
        <div class="simple-section">
            <div class="section-title">Customer</div>
            <div class="info-list">
                <div class="info-item">
                    <span class="info-label">Name:</span>
                    <span class="info-value"><?php echo !empty($bill->customer_name) ? $bill->customer_name : 'Walk-in Customer'; ?></span>
                        </div>
                        <?php if (!empty($bill->customer_phone)): ?>
                <div class="info-item">
                    <span class="info-label">Phone:</span>
                    <span class="info-value"><?php echo $bill->customer_phone; ?></span>
                        </div>
                        <?php endif; ?>
                </div>
            </div>

            <!-- Quick Actions -->
        <div class="simple-section">
            <div class="section-title">Actions</div>
            <div class="quick-actions">
                <a href="<?php echo base_url('billing/create'); ?>" class="quick-action-link">
                    <i class="fa fa-plus"></i> New Bill
                </a>
            </div>
        </div>

        <!-- Simple Items List -->
        <div class="simple-section">
            <div class="section-title">Items</div>
            <div class="items-list">
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
                    <div class="simple-item">
                        <div class="item-name"><?php echo $item['title']; ?></div>
                        <div class="item-details-simple">
                            <span>Qty: <?php echo $item['quantity']; ?></span>
                            <span>Price: <?php echo $settings['currency_symbol'] . ' ' . number_format($item['unit_price'], 2); ?></span>
                            <span class="item-total"><?php echo $settings['currency_symbol'] . ' ' . number_format($item['total_price'], 2); ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                    <div class="no-items">No items found</div>
                    <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
/* Simple Mobile-First Design with Dark/White Theme */
.simple-mobile {
    max-width: 100%;
    margin: 0 auto;
    padding: 8px;
    background: #f8f9fa;
    min-height: 100vh;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Dark Header */
.simple-header {
    display: flex;
    align-items: center;
    padding: 20px;
    background: #1a1a1a;
    color: white;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.back-button {
    margin-right: 16px;
}

.back-link {
    color: #ffffff;
    text-decoration: none;
    font-size: 20px;
    padding: 8px;
    border-radius: 8px;
    transition: background-color 0.2s;
}

.back-link:hover {
    background: rgba(255,255,255,0.1);
}

.bill-title h1 {
    margin: 0;
    font-size: 26px;
    font-weight: 700;
    color: #ffffff;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
}

.bill-date {
    font-size: 14px;
    color: #cccccc;
    margin-top: 6px;
}

/* Total Amount Section - Dark Theme */
.total-section {
    background: #2c3e50;
    color: white;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 20px;
    text-align: center;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    border: 2px solid #34495e;
}

.total-label {
    font-size: 12px;
    color: #ecf0f1;
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
        font-weight: 600;
}

.total-amount {
    font-size: 32px;
    font-weight: 700;
    color: #ffffff;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

/* Action Buttons - Dark Theme */
.action-buttons {
    display: flex;
    gap: 12px;
    margin-bottom: 24px;
}

.action-btn {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 16px 12px;
    background: #34495e;
    border: 2px solid #2c3e50;
    border-radius: 10px;
    text-decoration: none;
    color: #ffffff;
    font-size: 12px;
    font-weight: 600;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.action-btn:hover {
    background: #2c3e50;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.2);
}

.action-btn i {
    font-size: 18px;
    margin-bottom: 6px;
}

/* Simple Sections with Dark Accents */
.simple-section {
    margin-bottom: 24px;
    padding: 20px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border: 1px solid #e9ecef;
}

.simple-section:last-child {
    border-bottom: none;
}

.section-title {
    font-size: 18px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 2px solid #34495e;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

/* Information Lists with Dark Styling */
.info-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid #34495e;
}

.info-label {
    font-size: 14px;
    color: #666;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 15px;
    color: #2c3e50;
    font-weight: 700;
}

/* Items List with Dark Accents */
.items-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.simple-item {
    padding: 16px;
    background: #ffffff;
    border-radius: 10px;
    border: 2px solid #e9ecef;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
}

.simple-item:hover {
    border-color: #34495e;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}

.item-name {
    font-size: 17px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 6px;
}

.item-details-simple {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    color: #666;
    font-weight: 500;
}

.item-details-simple span {
    flex: 1;
    text-align: center;
    padding: 4px 8px;
}

.item-total {
    font-weight: 700;
    color: #2c3e50;
    background: #ecf0f1;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 15px;
}

.no-items {
    text-align: center;
    padding: 20px;
    color: #666;
    font-size: 14px;
}

/* Quick Actions with Dark Theme */
.quick-actions {
    margin-top: 12px;
}

.quick-action-link {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 20px;
    background: #34495e;
    border: 2px solid #2c3e50;
    border-radius: 8px;
    text-decoration: none;
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.quick-action-link:hover {
    background: #2c3e50;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.quick-action-link i {
    font-size: 16px;
}

/* Customer Styling */
.customer-name {
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 6px;
    font-size: 16px;
}

.customer-phone {
    color: #666;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.customer-phone i {
    color: #34495e;
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
