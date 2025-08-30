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
        <div class="col-12 col-lg-8">
            <!-- Customer Info -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">کسٹمر کی معلومات</h5>
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">کسٹمر کا نام*</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" required
                                   placeholder="کسٹمر کا نام درج کریں...">
                            <div id="customer_list" class="list-group mt-1" style="display: none; position: absolute; z-index: 1000; width: 90%;"></div>
                        </div>
                        </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="form-label">فون نمبر</label>
                            <input type="tel" class="form-control" id="customer_phone" name="customer_phone"
                                   placeholder="مثال: 0300-1234567" pattern="[0-9]{4}-[0-9]{7}">
                            <div class="form-text">فون نمبر درج کرنے سے کسٹمر کی پہچان آسان ہوگی</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Section -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">بل کے آئیٹمز</h5>
                        <button type="button" class="btn btn-success mobile-add-btn" onclick="addItemRow()">
                            <i class="fa fa-plus"></i> <span class="d-none d-sm-inline">آئیٹم شامل کریں</span>
                        </button>
                    </div>
            
                    <!-- Desktop Table View -->
                    <div class="table-responsive d-none d-md-block">
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
                            <tbody id="items_table_desktop">
                                <!-- Desktop items will be added here dynamically -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div id="items_container_mobile" class="d-md-none">
                        <!-- Mobile items will be added here dynamically -->
                    </div>

                    <!-- Add Item Button for Mobile -->
                    <div class="text-center d-md-none mt-3">
                        <button type="button" class="btn btn-success btn-lg w-100" onclick="addItemRow()">
                            <i class="fa fa-plus-circle fa-lg"></i> نیا آئیٹم شامل کریں
                        </button>
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
        <div class="col-12 col-lg-4">
            
            <!-- Bill Summary -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">بل کا خلاصہ</h5>
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <div class="fw-bold text-primary" id="item_count">0</div>
                                <small class="text-muted">کل آئیٹمز</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="fw-bold text-success" id="total_quantity">0</div>
                                <small class="text-muted">کل تعداد</small>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <div class="fw-bold fs-5 text-danger" id="summary_total">PKR 0.00</div>
                        <small class="text-muted">کل رقم</small>
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

// Initialize on page load
$(document).ready(function() {
    // Add first item row
    addItemRow();

    // Mobile-specific enhancements
    if ($(window).width() < 768) {
        // Improve mobile UX
        $('.form-control').attr('inputmode', 'text');
        $('#customer_phone').attr('inputmode', 'tel');

        // Add visual feedback for form completion
        $('.form-control').on('blur', function() {
            if ($(this).val().trim()) {
                $(this).addClass('is-valid');
            } else {
                $(this).removeClass('is-valid');
            }
        });
    }

    // Handle window resize for responsive behavior
    $(window).on('resize', function() {
        handleResponsiveLayout();
    });

    handleResponsiveLayout();

    // Initial calculation on page load
    setTimeout(() => {
        calculateGrandTotal();
        updateSummary();
    }, 200);
});

// Function to handle responsive layout changes
function handleResponsiveLayout() {
    if ($(window).width() >= 768) {
        // Desktop: move items from mobile to desktop if needed
        const mobileItems = $('.mobile-item-card');
        if (mobileItems.length > 0 && $('#items_table_desktop tr.item-row').length === 0) {
            // Convert mobile cards to desktop rows (optional - for now just ensure proper display)
            $('.d-none.d-md-block').show();
            $('#items_container_mobile').hide();
        }
    } else {
        // Mobile: ensure mobile layout is active
        $('.d-none.d-md-block').hide();
        $('#items_container_mobile').show();
    }
}

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

    // Add visual feedback on mobile
    if ($(window).width() < 768) {
        $('#customer_name').addClass('is-valid');
        if (phone) {
            $('#customer_phone').addClass('is-valid');
        }
    }
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

// Enhanced Item Management for Desktop and Mobile
function addItemRow() {
    // Desktop Table Row
    const desktopRow = `
        <tr class="item-row" data-index="${itemIndex}">
            <td>
                <input type="text" class="form-control form-control-sm item-search"
                       name="item_name[]" placeholder="آئیٹم کا نام لکھیں..."
                       onkeyup="searchItems(this)" onfocus="searchItems(this)" required>
                <div class="item-suggestions position-absolute bg-white border rounded shadow"
                     style="display: none; z-index: 1000; width: 100%; max-height: 200px; overflow-y: auto; top: 100%; left: 0;"></div>
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

    // Mobile Card Layout
    const mobileCard = `
        <div class="mobile-item-card card mb-3 item-row" data-index="${itemIndex}" style="border-left: 4px solid #007bff;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="card-title mb-0 text-primary">آئیٹم #${itemIndex + 1}</h6>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeMobileCard(this)">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">آئیٹم کا نام *</label>
                    <input type="text" class="form-control item-search"
                           name="item_name[]" placeholder="آئیٹم کا نام لکھیں..."
                           onkeyup="searchItems(this)" onfocus="searchItems(this)" required>
                    <div class="item-suggestions position-absolute bg-white border rounded shadow"
                         style="display: none; z-index: 1000; width: 100%; max-height: 200px; overflow-y: auto; top: 100%; left: 0;"></div>
                    <input type="hidden" class="item-id" name="item_id[]">
                </div>

                <div class="row g-2">
                    <div class="col-4">
                        <label class="form-label small fw-bold">تعداد *</label>
                        <input type="number" class="form-control quantity"
                               name="quantity[]" value="1" min="1" onchange="calculateRowTotal(this)" required>
                    </div>
                    <div class="col-4">
                        <label class="form-label small fw-bold">قیمت *</label>
                        <input type="number" class="form-control unit-price"
                               name="unit_price[]" step="0.01" min="0.01" placeholder="0.00"
                               onchange="calculateRowTotal(this)" required>
                    </div>
                    <div class="col-4">
                        <label class="form-label small fw-bold">کل رقم</label>
                        <input type="text" class="form-control row-total fw-bold text-success" readonly placeholder="0.00">
                    </div>
                </div>
            </div>
        </div>
    `;

    // Add to appropriate container based on screen size
    if ($(window).width() >= 768) {
        $('#items_table_desktop').append(desktopRow);
    } else {
        $('#items_container_mobile').append(mobileCard);
    }

    itemIndex++;
    updateSummary();

    // Trigger initial calculation for new row
    setTimeout(() => {
        calculateGrandTotal();
    }, 50);
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
    console.log('Showing item suggestions:', items.length, 'items'); // Debug log
    suggestions.empty();
    
    if (items.length > 0) {
        console.log('Items found, displaying suggestions');
        // Agar items pehle se hain to show karein
        suggestions.append('<div class="p-2 bg-light fw-bold small">دستیاب آئیٹمز</div>');
        
        items.forEach(item => {
            const suggestionItem = $(`
                <div class="p-2 border-bottom suggestion-item" style="cursor: pointer;">
                    <div class="d-flex justify-content-between">
                        <strong>${item.title}</strong>
                        <span class="text-success">PKR ${item.price}</span>
                    </div>
                    <small class="text-muted">SKU: ${item.sku}</small>
                </div>
            `);

            // Add click event using jQuery instead of inline onclick for better reliability
            suggestionItem.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                selectExistingItem(this, item.id, item.title, item.price);
            });

            suggestions.append(suggestionItem);
        });
        suggestions.show();
    } else {
        suggestions.hide();
    }
}

function selectExistingItem(element, id, title, price) {
    console.log('Selecting item:', {id, title, price}); // Debug log

    // Handle both desktop table rows and mobile cards
    let itemContainer;

    // Check if we're in a table row (desktop)
    if ($(element).closest('tr').length > 0) {
        itemContainer = $(element).closest('tr');
        console.log('Found desktop table row');
    }
    // Check if we're in a mobile card
    else if ($(element).closest('.mobile-item-card').length > 0) {
        itemContainer = $(element).closest('.mobile-item-card');
        console.log('Found mobile card');
    }
    // Fallback for any other container
    else {
        itemContainer = $(element).closest('.item-row');
        console.log('Using fallback item-row selector');
    }

    if (itemContainer.length === 0) {
        console.error('Could not find item container for element:', element);
        return;
    }

    console.log('Setting values for item container:', itemContainer);

    // Set the values
    const itemSearchInput = itemContainer.find('.item-search');
    const itemIdInput = itemContainer.find('.item-id');
    const unitPriceInput = itemContainer.find('.unit-price');

    itemSearchInput.val(title);
    itemIdInput.val(id);
    unitPriceInput.val(price);

    console.log('Values set:', {
        itemSearch: itemSearchInput.val(),
        itemId: itemIdInput.val(),
        unitPrice: unitPriceInput.val()
    });

    // Hide the suggestions
    $(element).closest('.item-suggestions').hide();

    // Calculate total for the row/card
    const quantityInput = itemContainer.find('.quantity')[0];
    if (quantityInput) {
        calculateRowTotal(quantityInput);
    }

    // Add visual feedback for mobile
    if ($(window).width() < 768) {
        itemContainer.find('.item-search').addClass('is-valid');
        itemContainer.find('.unit-price').addClass('is-valid');
    }

    // Trigger change event to update calculations
    itemContainer.find('.item-search').trigger('change');
    itemContainer.find('.unit-price').trigger('change');
    itemContainer.find('.quantity').trigger('change');

    // Also manually trigger calculation after a small delay to ensure values are set
    setTimeout(() => {
        calculateGrandTotal();
        updateSummary();
    }, 100);

    // Add a brief success animation
    itemContainer.find('.item-search').css({
        'background-color': '#d4edda',
        'transition': 'background-color 0.3s ease'
    });

    setTimeout(() => {
        itemContainer.find('.item-search').css('background-color', '');
    }, 300);
}

// Mobile-specific enhancements
$(document).ready(function() {
    // Add mobile-specific classes and enhancements
    if ($(window).width() < 768) {
        $('.card').addClass('mb-3');
        $('.btn').addClass('w-100 mb-2');
        $('.form-control').addClass('mb-2');
    }
});

// Calculate Functions
function calculateRowTotal(element) {
    console.log('Calculating row total for element:', element); // Debug log

    // Handle both desktop table rows and mobile cards
    let itemContainer;

    // Check if we're in a table row (desktop)
    if ($(element).closest('tr').length > 0) {
        itemContainer = $(element).closest('tr');
        console.log('Found desktop table row for calculation');
    }
    // Check if we're in a mobile card
    else if ($(element).closest('.mobile-item-card').length > 0) {
        itemContainer = $(element).closest('.mobile-item-card');
        console.log('Found mobile card for calculation');
    }
    // Fallback for any other container
    else {
        itemContainer = $(element).closest('.item-row');
        console.log('Using fallback item-row for calculation');
    }

    if (itemContainer.length === 0) {
        console.error('Could not find item container for calculation:', element);
        return;
    }

    const qty = parseFloat(itemContainer.find('.quantity').val()) || 0;
    const price = parseFloat(itemContainer.find('.unit-price').val()) || 0;
    const total = qty * price;
    
    console.log('Calculation values:', { qty, price, total }); // Debug log

    itemContainer.find('.row-total').val(total.toFixed(2));
    calculateGrandTotal();
    updateSummary();
}

function calculateGrandTotal() {
    console.log('Calculating grand total...'); // Debug log
    let total = 0;
    let itemCount = 0;

    $('.item-row').each(function(index) {
        const qty = parseFloat($(this).find('.quantity').val()) || 0;
        const price = parseFloat($(this).find('.unit-price').val()) || 0;
        const itemTotal = qty * price;

        console.log(`Item ${index + 1}: qty=${qty}, price=${price}, itemTotal=${itemTotal}`); // Debug log

        total += itemTotal;
        itemCount++;
    });

    console.log(`Grand total calculation: ${itemCount} items, total=${total}`); // Debug log
    
    $('#grand_total').text(currency + ' ' + total.toFixed(2));
    $('#summary_total').text(currency + ' ' + total.toFixed(2));
    $('#total_amount').val(total.toFixed(2));

    console.log('Grand total updated to:', total.toFixed(2)); // Debug log
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

function removeMobileCard(button) {
    if ($('.item-row').length > 1) {
        $(button).closest('.mobile-item-card').remove();
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

// Enhanced Form Validation for Mobile and Desktop
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
        if ($(window).width() < 768) {
            // Mobile alert with better styling
            showMobileAlert('براہ کرم کم از کم ایک آئیٹم کی تفصیلات درج کریں', 'warning');
        } else {
        alert('براہ کرم کم از کم ایک آئیٹم کی تفصیلات درج کریں');
        }
        return false;
    }
    
    if (hasEmptyPrice) {
        e.preventDefault();
        if ($(window).width() < 768) {
            showMobileAlert('براہ کرم تمام آئیٹمز کی قیمت درج کریں', 'warning');
        } else {
        alert('براہ کرم تمام آئیٹمز کی قیمت درج کریں');
        }
        return false;
    }
    
    if (!$('#customer_name').val().trim()) {
        e.preventDefault();
        if ($(window).width() < 768) {
            showMobileAlert('براہ کرم کسٹمر کا نام درج کریں', 'warning');
            $('#customer_name').focus();
        } else {
        alert('براہ کرم کسٹمر کی تفصیلات درج کریں');
        }
        return false;
    }
});

function showMobileAlert(message, type = 'info') {
    // Create mobile-friendly alert
    const alertClass = type === 'warning' ? 'alert-warning' : 'alert-info';
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed mobile-alert" role="alert"
             style="top: 20px; left: 10px; right: 10px; z-index: 9999; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <i class="fa fa-info-circle me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    // Remove existing alerts
    $('.mobile-alert').remove();

    // Add new alert
    $('body').append(alertHtml);

    // Auto remove after 5 seconds
    setTimeout(() => {
        $('.mobile-alert').fadeOut();
    }, 5000);
}

// Manual recalculation function (can be called from console for testing)
function forceRecalculate() {
    console.log('Force recalculating...');
    calculateGrandTotal();
    updateSummary();
}
</script>

<style>
.suggestion-item:hover {
    background-color: #f8f9fa !important;
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.suggestion-item:active {
    background-color: #e9ecef !important;
    transform: translateY(0);
}

.item-suggestions {
    max-height: 250px;
    overflow-y: auto;
    border-radius: 0.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
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

/* Enhanced Mobile-specific styles */
@media (max-width: 767.98px) {
    /* Page Layout */
    .container-fluid {
        padding-left: 10px;
        padding-right: 10px;
    }

    /* Header */
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch !important;
    }

    .d-flex.justify-content-between h2 {
        font-size: 1.5rem;
        margin-bottom: 0;
    }

    /* Customer Section */
    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    /* Form Controls */
    .form-control {
        font-size: 1rem;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        border: 2px solid #e9ecef;
        transition: border-color 0.15s ease-in-out;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: #495057;
    }

    /* Mobile Item Cards */
    .mobile-item-card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 1rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .mobile-item-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .mobile-item-card .card-body {
        padding: 1rem;
    }

    .mobile-item-card .card-title {
        font-size: 1rem;
        color: #007bff;
        margin-bottom: 1rem;
    }

    /* Buttons */
    .btn {
        min-height: 48px;
        font-size: 1rem;
        font-weight: 500;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        transition: all 0.2s ease;
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        font-size: 1.1rem;
        padding: 1rem 2rem;
        margin-top: 1rem;
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    }

    .btn-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 12px rgba(40, 167, 69, 0.4);
    }

    .btn-danger {
        background: #dc3545;
        border: none;
    }

    .btn-outline-danger {
        border: 2px solid #dc3545;
        color: #dc3545;
        background: transparent;
    }

    .btn-outline-danger:hover {
        background: #dc3545;
        color: white;
    }

    /* Add Item Button */
    .mobile-add-btn {
        display: none;
    }

    /* Total Section */
    .text-end {
        text-align: center !important;
    }

    .text-end h4 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    /* Alerts */
    .alert {
        font-size: 0.95rem;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    /* Sidebar */
    .col-12.col-lg-4 {
        order: -1;
        margin-bottom: 2rem;
    }

    .col-12.col-lg-4 .card {
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* Summary Cards */
    .row > .col-6 {
        margin-bottom: 1rem;
    }

    .fw-bold {
        font-weight: 700 !important;
    }

    /* Number inputs */
    input[type="number"] {
        -webkit-appearance: none;
        -moz-appearance: textfield;
    }

    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Item Suggestions */
    .item-suggestions {
        max-width: 90vw;
        left: 5vw !important;
        right: 5vw !important;
        width: auto !important;
    }

    /* Customer List */
    #customer_list {
        max-width: 90vw;
        left: 5vw !important;
        right: 5vw !important;
        width: auto !important;
    }

    /* Loading states */
    .btn:disabled {
        opacity: 0.6;
    }

    /* Focus states for accessibility */
    .btn:focus,
    .form-control:focus {
        outline: none;
    }

    /* Spacing improvements */
    .card-body {
        padding: 1.25rem;
    }

    .mb-3 {
        margin-bottom: 1rem !important;
    }

    /* Improve readability */
    body {
        font-size: 1rem;
        line-height: 1.5;
    }
}

/* Form validation styles */
.form-control.is-valid {
    border-color: #28a745;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='m2.3 6.73 4.89-4.89-1.42-1.42L1.89 5.3l-1.42-1.42L-.3 5.3z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.form-control.is-invalid {
    border-color: #dc3545;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

/* Mobile alerts */
.mobile-alert {
    animation: slideInFromTop 0.3s ease-out;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

@keyframes slideInFromTop {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.mobile-alert.fade {
    animation: fadeOut 0.3s ease-out;
}

@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}

/* Extra small screens */
@media (max-width: 575.98px) {
    .container-fluid {
        padding-left: 8px;
        padding-right: 8px;
    }

    .mobile-item-card .card-body {
        padding: 0.75rem;
    }

    .form-control {
        font-size: 1rem;
        padding: 0.625rem 0.875rem;
    }

    .btn {
        min-height: 44px;
        font-size: 0.95rem;
    }

    /* Smaller text on very small screens */
    .card-title {
        font-size: 1rem;
    }

    .form-label {
        font-size: 0.85rem;
    }

    /* Adjust mobile card spacing */
    .mobile-item-card {
        margin-bottom: 0.75rem;
    }
}
</style>
