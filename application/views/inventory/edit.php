<!-- Simple Edit Item Page -->
<div class="container-fluid">
    <!-- Simple Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Edit Item</h2>
            <p class="text-muted mb-0">Update details for <strong><?php echo $item->title; ?></strong></p>
        </div>
        <a href="<?php echo site_url('inventory'); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Inventory
        </a>
    </div>

    <!-- Simple Edit Item Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Item</h5>
                </div>
                <div class="card-body">
                    <?php echo form_open('inventory/edit/'.$item->id, ['class' => 'needs-validation', 'novalidate' => true]); ?>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="sku" class="form-label">
                                    <i class="fas fa-barcode me-1"></i>SKU (Read-only)
                                </label>
                                <input type="text" class="form-control form-control-lg"
                                       id="sku" name="sku" value="<?php echo set_value('sku', $item->sku); ?>"
                                       readonly style="background-color: #f8f9fa;">
                                <div class="form-text">
                                    <i class="fas fa-lock text-muted me-1"></i>SKU cannot be modified after creation
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="title" class="form-label">
                                    <i class="fas fa-tag me-1"></i>Item Name*
                                </label>
                                <input type="text" class="form-control form-control-lg <?php echo form_error('title') ? 'is-invalid' : ''; ?>"
                                       id="title" name="title" value="<?php echo set_value('title', $item->title); ?>" required
                                       placeholder="Enter item name">
                                <div class="form-text">Name of the product/item</div>
                                <?php echo form_error('title', '<div class="invalid-feedback">', '</div>'); ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="price" class="form-label">
                                <i class="fas fa-money-bill me-1"></i>Selling Price*
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text"><?php echo $settings['currency_symbol'] ?? '₹'; ?></span>
                                <input type="number" step="0.01" class="form-control <?php echo form_error('price') ? 'is-invalid' : ''; ?>"
                                       id="price" name="price" value="<?php echo set_value('price', $item->price); ?>" required
                                       placeholder="0.00">
                                <?php echo form_error('price', '<div class="invalid-feedback">', '</div>'); ?>
                            </div>
                            <div class="form-text">Price at which you'll sell this item</div>
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Update Item
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
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Item Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong><i class="fas fa-calendar text-primary me-2"></i>Created:</strong>
                        <p class="small mb-0"><?php echo date('d M Y, h:i A', strtotime($item->created_at)); ?></p>
                    </div>

                    <?php if(isset($item->updated_at) && $item->updated_at): ?>
                    <div class="mb-3">
                        <strong><i class="fas fa-clock text-success me-2"></i>Last Updated:</strong>
                        <p class="small mb-0"><?php echo date('d M Y, h:i A', strtotime($item->updated_at)); ?></p>
                    </div>
                    <?php endif; ?>

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

.alert-warning {
    border: none;
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
}

.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    display: block;
}
</style>

<script>
$(document).ready(function() {
    // Auto-format price input on change
    $('#price').on('blur', function() {
        var value = parseFloat($(this).val());
        if (!isNaN(value)) {
            $(this).val(value.toFixed(2));
        }
    });

    // Form validation
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
    })();

    // Focus on title field
    $('#title').focus().select();
});
</script>