<!-- Enhanced Create Bill Page for Small Shop -->
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>نیا بل بنائیں</h2>
        <a href="<?php echo base_url('billing'); ?>" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> واپس
        </a>
    </div>

    <?php echo form_open('billing/store', ['id' => 'billForm']); ?>
    
    <div class="row">
        <!-- Main Bill Form -->
        <div class="col-md-8">
            <!-- Customer Info -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">کسٹمر کی معلومات</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">کسٹمر کا نام*</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" required 
                                   placeholder="کسٹمر کا نام درج کریں...">
                            <div id="customer_list" class="list-group mt-1" style="display: none; position: absolute; z-index: 1000; width: 90%;"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">فون نمبر*</label>
                            <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required placeholder="فون نمبر درج کریں...">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Section -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">بل کے آئیٹمز</h5>
                        <button type="button" class="btn btn-success btn-sm" onclick="addItemRow()">
                            <i class="fa fa-plus"></i> آئیٹم شامل کریں
                        </button>
                    </div>
                    
                    <div class="alert alert-info">
                        <small><i class="fa fa-info-circle"></i> 
                        <strong>ٹپ:</strong> آئیٹم کا نام لکھیں - اگر پہلے سے موجود ہے تو تجویز آئے گی، ورنہ نام اور قیمت ڈال کر نیا آئیٹم شامل کر سکتے ہیں۔</small>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th width="45%">آئیٹم کا نام</th>
                                    <th width="15%">تعداد</th>
                                    <th width="20%">فی یونٹ قیمت (PKR)</th>
                                    <th width="15%">کل (PKR)</th>
                                    <th width="5%">ایکشن</th>
                                </tr>
                            </thead>
                            <tbody id="items_table">
                                <!-- Items will be added here dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Total Section -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert alert-success">
                                <small><i class="fa fa-check-circle"></i> 
                                <strong>نوٹ:</strong> بل بننے کے بعد پرنٹ کر سکتے ہیں۔</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <h4 class="text-primary">کل رقم: <span id="grand_total">PKR 0.00</span></h4>
                                <input type="hidden" id="total_amount" name="total_amount" value="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fa fa-receipt"></i> بل بنائیں
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Tips Sidebar -->
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">فوری ٹپس</h5>
                    <div class="small text-muted">
                        <p><i class="fa fa-info-circle text-primary"></i> کسٹمر کا نام لکھیں - اگر ڈیٹا میں ہے تو تجویز آئے گی</p>
                        <p><i class="fa fa-lightbulb text-warning"></i> اگر نیا کسٹمر ہے تو نام اور فون نمبر ڈالیں - خودکار محفوظ ہو جائے گا</p>
                        <p><i class="fa fa-shopping-cart text-success"></i> آئیٹم کا نام لکھیں - نئے آئیٹمز خودکار انوینٹری میں شامل ہو جائیں گے</p>
                    </div>
                </div>
            </div>

            <!-- Bill Summary -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">بل کا خلاصہ</h5>
                    <div class="d-flex justify-content-between">
                        <span>کل آئیٹمز:</span>
                        <span id="item_count">0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>کل تعداد:</span>
                        <span id="total_quantity">0</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>کل رقم:</span>
                        <span id="summary_total">PKR 0.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo form_close(); ?>
</div>

<script>
let itemIndex = 0;
const currency = 'PKR';

// Add first item row on page load
$(document).ready(function() {
    addItemRow();
});

// Enhanced Customer Search
let customerTimeout;
$('#customer_name').on('input', function() {
    clearTimeout(customerTimeout);
    const query = $(this).val().trim();
    
    if (query.length >= 2) {
        customerTimeout = setTimeout(() => {
            searchCustomers(query);
        }, 300);
    } else {
        $('#customer_list').hide();
    }
});

function searchCustomers(query) {
    $.get('<?php echo base_url("billing/search_customers"); ?>', { q: query }, function(data) {
        showCustomers(JSON.parse(data));
    });
}

function showCustomers(customers) {
    const list = $('#customer_list');
    list.empty();
    
    if (customers.length > 0) {
        customers.forEach(customer => {
            list.append(`
                <a href="#" class="list-group-item list-group-item-action" onclick="selectCustomer('${customer.name}', '${customer.phone || ''}')">
                    <div class="d-flex justify-content-between">
                        <strong>${customer.name}</strong>
                        <small class="text-muted">${customer.phone || 'No phone'}</small>
                    </div>
                </a>
            `);
        });
        list.show();
    } else {
        list.hide();
    }
}

function selectCustomer(name, phone) {
    $('#customer_name').val(name);
    $('#customer_phone').val(phone);
    $('#customer_list').hide();
}

// Auto-validate phone when customer name is typed
$('#customer_phone').on('blur', function() {
    const phone = $(this).val().trim();
    const name = $('#customer_name').val().trim();
    
    if (phone && name) {
        // Check if customer exists with this phone
        $.get('<?php echo base_url("billing/get_customer_details"); ?>', { phone: phone }, function(data) {
            const customer = JSON.parse(data);
            if (customer && customer.name !== name) {
                if (confirm(`Phone number ${phone} belongs to ${customer.name}. Update name?`)) {
                    $('#customer_name').val(customer.name);
                }
            }
        });
    }
});

// Simple Item Management - Bas type karo aur enter karo!
function addItemRow() {
    const row = `
        <tr class="item-row" data-index="${itemIndex}">
            <td>
                <input type="text" class="form-control form-control-sm item-search" 
                       name="item_name[]" placeholder="آئیٹم کا نام لکھیں..." 
                       onkeyup="searchItems(this)" onfocus="searchItems(this)" required>
                <div class="item-suggestions position-absolute bg-white border rounded shadow" 
                     style="display: none; z-index: 1000; width: 300px; max-height: 200px; overflow-y: auto;"></div>
                <input type="hidden" class="item-id" name="item_id[]">
            </td>
            <td>
                <input type="number" class="form-control form-control-sm quantity" 
                       name="quantity[]" value="1" min="1" onchange="calculateRowTotal(this)" required>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm unit-price" 
                       name="unit_price[]" step="0.01" min="0.01" placeholder="قیمت درج کریں" 
                       onchange="calculateRowTotal(this)" required>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm row-total" readonly placeholder="0.00">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)" title="آئیٹم ہٹائیں">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
    `;
    $('#items_table').append(row);
    itemIndex++;
    updateSummary();
}

// Item Search - Agar pehle se hai to suggestion show hogi
let itemSearchTimeout;
function searchItems(input) {
    clearTimeout(itemSearchTimeout);
    const query = $(input).val().trim();
    const suggestions = $(input).siblings('.item-suggestions');
    
    if (query.length >= 1) {
        itemSearchTimeout = setTimeout(() => {
            $.get('<?php echo base_url("billing/search_items"); ?>', { q: query }, function(data) {
                showItemSuggestions(JSON.parse(data), suggestions, input);
            });
        }, 300);
    } else {
        suggestions.hide();
    }
}

function showItemSuggestions(items, suggestions, input) {
    suggestions.empty();
    
    if (items.length > 0) {
        // Agar items pehle se hain to show karein
        suggestions.append('<div class="p-2 bg-light fw-bold small">دستیاب آئیٹمز</div>');
        
        items.forEach(item => {
            suggestions.append(`
                <div class="p-2 border-bottom suggestion-item" style="cursor: pointer;" 
                     onclick="selectExistingItem(this, '${item.id}', '${item.title}', '${item.price}')">
                    <div class="d-flex justify-content-between">
                        <strong>${item.title}</strong>
                        <span class="text-success">PKR ${item.price}</span>
                    </div>
                    <small class="text-muted">SKU: ${item.sku}</small>
                </div>
            `);
        });
        suggestions.show();
    } else {
        suggestions.hide();
    }
}

function selectExistingItem(element, id, title, price) {
    const row = $(element).closest('tr');
    row.find('.item-search').val(title);
    row.find('.item-id').val(id);
    row.find('.unit-price').val(price);
    $(element).parent().hide();
    calculateRowTotal(row.find('.quantity')[0]);
}

// Calculate Functions
function calculateRowTotal(element) {
    const row = $(element).closest('tr');
    const qty = parseFloat(row.find('.quantity').val()) || 0;
    const price = parseFloat(row.find('.unit-price').val()) || 0;
    const total = qty * price;
    
    row.find('.row-total').val(total.toFixed(2));
    calculateGrandTotal();
    updateSummary();
}

function calculateGrandTotal() {
    let total = 0;
    $('.item-row').each(function() {
        const qty = parseFloat($(this).find('.quantity').val()) || 0;
        const price = parseFloat($(this).find('.unit-price').val()) || 0;
        total += qty * price;
    });
    
    $('#grand_total').text(currency + ' ' + total.toFixed(2));
    $('#summary_total').text(currency + ' ' + total.toFixed(2));
    $('#total_amount').val(total.toFixed(2));
}

function updateSummary() {
    let itemCount = 0;
    let totalQty = 0;
    
    $('.item-row').each(function() {
        const itemName = $(this).find('.item-search').val().trim();
        const qty = parseInt($(this).find('.quantity').val()) || 0;
        
        if (itemName) {
            itemCount++;
            totalQty += qty;
        }
    });
    
    $('#item_count').text(itemCount);
    $('#total_quantity').text(totalQty);
}

function removeRow(button) {
    if ($('.item-row').length > 1) {
        $(button).closest('tr').remove();
        calculateGrandTotal();
        updateSummary();
    } else {
        alert('کم از کم ایک آئیٹم ضروری ہے');
    }
}

// Hide suggestions when clicking outside
$(document).on('click', function(e) {
    if (!$(e.target).closest('.item-search, .item-suggestions, #customer_name, #customer_list').length) {
        $('.item-suggestions, #customer_list').hide();
    }
});

// Enhanced Form Validation
$('#billForm').on('submit', function(e) {
    let hasValidItems = false;
    let hasEmptyPrice = false;
    
    $('.item-row').each(function() {
        const itemName = $(this).find('.item-search').val().trim();
        const price = parseFloat($(this).find('.unit-price').val()) || 0;
        const qty = parseInt($(this).find('.quantity').val()) || 0;
        
        if (itemName && qty > 0) {
            if (price <= 0) {
                hasEmptyPrice = true;
            } else {
                hasValidItems = true;
            }
        }
    });
    
    if (!hasValidItems) {
        e.preventDefault();
        alert('براہ کرم کم از کم ایک آئیٹم کی تفصیلات درج کریں');
        return false;
    }
    
    if (hasEmptyPrice) {
        e.preventDefault();
        alert('براہ کرم تمام آئیٹمز کی قیمت درج کریں');
        return false;
    }
    
    if (!$('#customer_name').val().trim() || !$('#customer_phone').val().trim()) {
        e.preventDefault();
        alert('براہ کرم کسٹمر کی تفصیلات درج کریں');
        return false;
    }
});
</script>

<style>
.suggestion-item:hover {
    background-color: #f8f9fa !important;
}

.item-suggestions {
    max-height: 250px;
    overflow-y: auto;
}

.table-bordered td {
    vertical-align: middle;
}

.item-row input:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

#quickAddModal .modal-body {
    background-color: #f8f9fa;
}

.alert-info {
    border-left: 4px solid #17a2b8;
}
</style>
