<!-- Edit Bill Page -->
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Bill - <?php echo $bill->bill_number; ?></h2>
        <div class="btn-group">
            <a href="<?php echo base_url('billing/view/' . $bill->id); ?>" class="btn btn-secondary">
                <i class="fa fa-eye"></i> View Bill
            </a>
            <a href="<?php echo base_url('billing'); ?>" class="btn btn-outline-secondary">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <?php echo form_open('billing/update/' . $bill->id, ['id' => 'editBillForm']); ?>
    
    <div class="row">
        <!-- Main Bill Form -->
        <div class="col-md-8">
            <!-- Customer Info -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Customer Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Customer Name*</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" required 
                                   value="<?php echo set_value('customer_name', $bill->customer_name); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number*</label>
                            <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required 
                                   value="<?php echo set_value('customer_phone', $bill->customer_phone); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Section -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Bill Items</h5>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addItemRow()">
                            <i class="fa fa-plus"></i> Add Item
                        </button>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered" id="itemsTable">
                            <thead class="table-light">
                                <tr>
                                    <th width="35%">Item Name</th>
                                    <th width="15%">Quantity</th>
                                    <th width="20%">Unit Price</th>
                                    <th width="20%">Total</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="itemsTableBody">
                                <?php if (!empty($bill->items)): ?>
                                    <?php foreach ($bill->items as $index => $item): ?>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control item-name" name="item_name[]" 
                                                   value="<?php echo set_value('item_name[' . $index . ']', $item->title); ?>" 
                                                   placeholder="Type item name..." autocomplete="off" required>
                                            <div class="suggestion-list" style="display: none;"></div>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control quantity" name="quantity[]" 
                                                   value="<?php echo set_value('quantity[' . $index . ']', $item->quantity); ?>" 
                                                   min="1" step="1" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control unit-price" name="unit_price[]" 
                                                   value="<?php echo set_value('unit_price[' . $index . ']', $item->unit_price); ?>" 
                                                   min="0.01" step="0.01" required>
                                        </td>
                                        <td>
                                            <span class="item-total"><?php echo number_format($item->total_price, 2); ?></span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeItemRow(this)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control item-name" name="item_name[]" 
                                                   placeholder="Type item name..." autocomplete="off" required>
                                            <div class="suggestion-list" style="display: none;"></div>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control quantity" name="quantity[]" 
                                                   value="1" min="1" step="1" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control unit-price" name="unit_price[]" 
                                                   min="0.01" step="0.01" required>
                                        </td>
                                        <td>
                                            <span class="item-total">0.00</span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeItemRow(this)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bill Summary -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Bill Summary</h5>
                    
                    <div class="summary-item">
                        <span>Bill Number:</span>
                        <strong><?php echo $bill->bill_number; ?></strong>
                    </div>
                    
                    <div class="summary-item">
                        <span>Date:</span>
                        <strong><?php echo date('d M Y', strtotime($bill->created_at)); ?></strong>
                    </div>
                    
                    <hr>
                    
                    <div class="summary-item">
                        <span>Total Items:</span>
                        <span id="totalItems"><?php echo count($bill->items); ?></span>
                    </div>
                    
                    <div class="summary-item total-amount">
                        <span>Grand Total:</span>
                        <strong id="grandTotal"><?php echo $settings['currency_symbol']; ?> <?php echo number_format($bill->total_amount, 2); ?></strong>
                    </div>
                    
                    <hr>
                    
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fa fa-save"></i> Update Bill
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <?php echo form_close(); ?>
</div>

<style>
.summary-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.total-amount {
    font-size: 1.2em;
    border-top: 2px solid #dee2e6;
    padding-top: 10px;
    margin-top: 10px;
}

.suggestion-list {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #ddd;
    border-top: none;
    max-height: 200px;
    overflow-y: auto;
    z-index: 1000;
}

.suggestion-item {
    padding: 8px 12px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
}

.suggestion-item:hover {
    background-color: #f8f9fa;
}
</style>

<script>
$(document).ready(function() {
    updateBillSummary();
    
    // Real-time calculation
    $(document).on('input', '.quantity, .unit-price', function() {
        updateRowTotal($(this).closest('tr'));
        updateBillSummary();
    });
    
    // Item search suggestions
    $(document).on('input', '.item-name', function() {
        let input = $(this);
        let query = input.val();
        
        if (query.length > 2) {
            $.get('<?php echo base_url('billing/search_items'); ?>', {q: query}, function(data) {
                let suggestions = JSON.parse(data);
                let html = '';
                
                suggestions.forEach(function(item) {
                    html += `<div class="suggestion-item" data-title="${item.title}" data-price="${item.price}">
                        <strong>${item.title}</strong> - ${item.sku} - Rs. ${item.price}
                    </div>`;
                });
                
                input.siblings('.suggestion-list').html(html).show();
            });
        } else {
            input.siblings('.suggestion-list').hide();
        }
    });
    
    // Select suggestion
    $(document).on('click', '.suggestion-item', function() {
        let row = $(this).closest('tr');
        let title = $(this).data('title');
        let price = $(this).data('price');
        
        row.find('.item-name').val(title);
        row.find('.unit-price').val(price);
        $(this).parent().hide();
        
        updateRowTotal(row);
        updateBillSummary();
    });
    
    // Hide suggestions when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).hasClass('item-name')) {
            $('.suggestion-list').hide();
        }
    });
});

function addItemRow() {
    let newRow = `
        <tr>
            <td>
                <input type="text" class="form-control item-name" name="item_name[]" 
                       placeholder="Type item name..." autocomplete="off" required>
                <div class="suggestion-list" style="display: none;"></div>
            </td>
            <td>
                <input type="number" class="form-control quantity" name="quantity[]" 
                       value="1" min="1" step="1" required>
            </td>
            <td>
                <input type="number" class="form-control unit-price" name="unit_price[]" 
                       min="0.01" step="0.01" required>
            </td>
            <td>
                <span class="item-total">0.00</span>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeItemRow(this)">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
    `;
    
    $('#itemsTableBody').append(newRow);
    updateBillSummary();
}

function removeItemRow(button) {
    if ($('#itemsTableBody tr').length > 1) {
        $(button).closest('tr').remove();
        updateBillSummary();
    } else {
        alert('At least one item is required!');
    }
}

function updateRowTotal(row) {
    let quantity = parseFloat(row.find('.quantity').val()) || 0;
    let unitPrice = parseFloat(row.find('.unit-price').val()) || 0;
    let total = quantity * unitPrice;
    
    row.find('.item-total').text(total.toFixed(2));
}

function updateBillSummary() {
    let totalItems = $('#itemsTableBody tr').length;
    let grandTotal = 0;
    
    $('#itemsTableBody tr').each(function() {
        let quantity = parseFloat($(this).find('.quantity').val()) || 0;
        let unitPrice = parseFloat($(this).find('.unit-price').val()) || 0;
        let total = quantity * unitPrice;
        
        $(this).find('.item-total').text(total.toFixed(2));
        grandTotal += total;
    });
    
    $('#totalItems').text(totalItems);
    $('#grandTotal').text('<?php echo $settings['currency_symbol']; ?> ' + grandTotal.toFixed(2));
}
</script> 