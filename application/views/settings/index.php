<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Shop Settings</h5>
                </div>
                <div class="card-body">
                    <?php echo form_open('settings', ['class' => 'needs-validation', 'novalidate' => true]); ?>
                        <div class="mb-3">
                            <label for="shop_name" class="form-label">Shop Name *</label>
                            <input type="text" class="form-control" id="shop_name" name="shop_name" required
                                   value="<?php echo set_value('shop_name', isset($settings['shop_name']) ? $settings['shop_name'] : ''); ?>">
                            <?php echo form_error('shop_name', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3"><?php echo set_value('address', isset($settings['address']) ? $settings['address'] : ''); ?></textarea>
                            <?php echo form_error('address', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                           value="<?php echo set_value('phone', isset($settings['phone']) ? $settings['phone'] : ''); ?>">
                                    <?php echo form_error('phone', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="<?php echo set_value('email', isset($settings['email']) ? $settings['email'] : ''); ?>">
                                    <?php echo form_error('email', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="currency_symbol" class="form-label">Currency Symbol *</label>
                                    <input type="text" class="form-control" id="currency_symbol" name="currency_symbol" required
                                           value="<?php echo set_value('currency_symbol', isset($settings['currency_symbol']) ? $settings['currency_symbol'] : '₹'); ?>">
                                    <?php echo form_error('currency_symbol', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="low_stock_alert" class="form-label">Low Stock Alert *</label>
                                    <input type="number" class="form-control" id="low_stock_alert" name="low_stock_alert" required
                                           value="<?php echo set_value('low_stock_alert', isset($settings['low_stock_alert']) ? $settings['low_stock_alert'] : '10'); ?>">
                                    <div class="form-text">Alert when item quantity falls below this number</div>
                                    <?php echo form_error('low_stock_alert', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="footer_text" class="form-label">Bill Footer Text</label>
                            <textarea class="form-control" id="footer_text" name="footer_text" rows="2"><?php echo set_value('footer_text', isset($settings['footer_text']) ? $settings['footer_text'] : ''); ?></textarea>
                            <div class="form-text">This text will appear at the bottom of bills</div>
                            <?php echo form_error('footer_text', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save Settings
                        </button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Preview</h5>
                </div>
                <div class="card-body">
                    <div class="border p-3 mb-3">
                        <h4 class="preview-shop-name"><?php echo isset($settings['shop_name']) ? $settings['shop_name'] : 'My Shop'; ?></h4>
                        <p class="preview-address mb-1"><?php echo isset($settings['address']) ? nl2br($settings['address']) : 'Shop Address'; ?></p>
                        <p class="preview-contact mb-1">
                            <?php if (isset($settings['phone']) && $settings['phone']): ?>
                            Phone: <?php echo $settings['phone']; ?><br>
                            <?php endif; ?>
                            <?php if (isset($settings['email']) && $settings['email']): ?>
                            Email: <?php echo $settings['email']; ?>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="border p-3">
                        <p class="mb-1">Sample Amount:</p>
                        <h3 class="preview-amount"><?php echo isset($settings['currency_symbol']) ? $settings['currency_symbol'] : '₹'; ?> 1,234.56</h3>
                        <hr>
                        <p class="preview-footer small text-muted mb-0">
                            <?php echo isset($settings['footer_text']) ? $settings['footer_text'] : 'Custom footer text'; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Live preview updates
$(document).ready(function() {
    $('#shop_name').on('input', function() {
        $('.preview-shop-name').text($(this).val() || 'My Shop');
    });

    $('#address').on('input', function() {
        $('.preview-address').html($(this).val().replace(/\n/g, '<br>') || 'Shop Address');
    });

    $('#currency_symbol').on('input', function() {
        var amount = $(this).val() + ' 1,234.56';
        $('.preview-amount').text(amount);
    });

    $('#footer_text').on('input', function() {
        $('.preview-footer').text($(this).val() || 'Custom footer text');
    });

    // Form validation
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
});</script> 