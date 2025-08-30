<!-- Simple Add Item Page -->
<div class="container-fluid">
    <!-- Simple Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Add New Item</h2>
            <p class="text-muted mb-0">Add a new product to your inventory</p>
        </div>
        <a href="<?php echo site_url('inventory'); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Inventory
        </a>
    </div>

    <!-- Simple Add Item Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Add New Item</h5>
                </div>
                <div class="card-body">
                    <?php echo form_open('inventory/add', ['class' => 'needs-validation', 'novalidate' => true]); ?>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="sku" class="form-label">
                                    <i class="fas fa-barcode me-1"></i>SKU (Auto-Generated)
                                </label>
                                <input type="text" class="form-control form-control-lg" id="sku" name="sku_display"
                                       value="Loading..." readonly style="background-color: #f8f9fa;">
                                <div class="form-text">Automatically generated unique identifier</div>
                            </div>

                            <div class="col-md-6">
                                <label for="title" class="form-label">
                                    <i class="fas fa-tag me-1"></i>Item Name*
                                </label>
                                <input type="text" class="form-control form-control-lg <?php echo form_error('title') ? 'is-invalid' : ''; ?>"
                                       id="title" name="title" required value="<?php echo set_value('title'); ?>"
                                       placeholder="Enter item name">
                                <div class="form-text">Name of the product/item</div>
                                <?php echo form_error('title', '<div class="text-danger mt-1">', '</div>'); ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="price" class="form-label">
                                <i class="fas fa-money-bill me-1"></i>Selling Price*
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text"><?php echo $settings['currency_symbol'] ?? '₹'; ?></span>
                                <input type="number" class="form-control <?php echo form_error('price') ? 'is-invalid' : ''; ?>"
                                       id="price" name="price" step="0.01" min="0" required
                                       value="<?php echo set_value('price'); ?>" placeholder="0.00">
                                <?php echo form_error('price', '<div class="text-danger mt-1">', '</div>'); ?>
                            </div>
                            <div class="form-text">Price at which you'll sell this item</div>
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Save Item
                            </button>
                            <a href="<?php echo site_url('inventory'); ?>" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card bg-light">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Quick Tips</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong><i class="fas fa-barcode text-primary me-2"></i>SKU:</strong>
                        <p class="small mb-0">Use a unique code for each item. Can include letters, numbers, and hyphens.</p>
                    </div>

                    <div class="mb-3">
                        <strong><i class="fas fa-tag text-success me-2"></i>Item Name:</strong>
                        <p class="small mb-0">Use clear, descriptive names that customers will understand.</p>
                    </div>

                    <div class="mb-3">
                        <strong><i class="fas fa-money-bill text-warning me-2"></i>Price:</strong>
                        <p class="small mb-0">Set competitive prices. You can always update them later.</p>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>No Stock Tracking:</strong> Items will be automatically available during billing without stock limits.
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
.form-control-lg {
    font-size: 1.1rem;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
}

.alert-info {
    border: none;
    background: rgba(13, 202, 240, 0.1);
    color: #0dcaf0;
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
}
</style>

<script>
// Enhanced form validation
(function() {
    'use strict';

    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Auto-format price
    $('#price').on('blur', function() {
        var value = parseFloat($(this).val());
        if (!isNaN(value)) {
            $(this).val(value.toFixed(2));
        }
    });

    // Auto-generate sequential SKU on page load
    function loadNextSKU() {
        $.get('<?php echo base_url("inventory/get_next_sku"); ?>', function(data) {
            var response = JSON.parse(data);
            $('#sku').val(response.sku);
        }).fail(function() {
            // Fallback if AJAX fails
            $('#sku').val('SKU-0001');
        });
    }

    // Load next SKU on page load
    if (!$('#sku').val()) {
        loadNextSKU();
    }

    // Focus on first input
    $('#sku').focus();
})();
</script>