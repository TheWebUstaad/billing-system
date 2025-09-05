<div class="update-payment-page">
    <!-- Simple Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="header-content">
                <div class="page-info">
                    <h2 class="page-title">
                        <i class="fas fa-credit-card me-2"></i>Update Payment
                    </h2>
                    <p class="page-subtitle">Update payment for Bill #<?php echo $bill->bill_number; ?></p>
                </div>
                <div class="header-actions">
                    <a href="<?php echo base_url('billing'); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Bills
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Payment Summary Card -->
                <div class="payment-summary-card mb-4">
                    <?php 
                    $paid_amount = isset($bill->paid_amount) ? $bill->paid_amount : 0;
                    $remaining = $bill->total_amount - $paid_amount;
                    $percentage = ($bill->total_amount > 0) ? ($paid_amount / $bill->total_amount) * 100 : 0;
                    ?>
                    
                    <div class="summary-header">
                        <div class="bill-info">
                            <h4 class="bill-number">Bill #<?php echo $bill->bill_number; ?></h4>
                            <p class="customer-name">
                                <?php echo !empty($bill->customer_name) ? $bill->customer_name : 'Walk-in Customer'; ?>
                                <?php if (!empty($bill->customer_phone)): ?>
                                    <span class="customer-phone"> • <?php echo $bill->customer_phone; ?></span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="bill-date">
                            <small class="text-muted"><?php echo date('d M Y, h:i A', strtotime($bill->created_at)); ?></small>
                        </div>
                    </div>
                    
                    <div class="amount-summary">
                        <div class="amount-grid">
                            <div class="amount-item">
                                <span class="amount-label">Total Amount</span>
                                <span class="amount-value total-amount"><?php echo $settings['currency_symbol'] . ' ' . number_format($bill->total_amount, 2); ?></span>
                            </div>
                            <div class="amount-item">
                                <span class="amount-label">Already Paid</span>
                                <span class="amount-value paid-amount"><?php echo $settings['currency_symbol'] . ' ' . number_format($paid_amount, 2); ?></span>
                            </div>
                            <div class="amount-item remaining">
                                <span class="amount-label">Remaining</span>
                                <span class="amount-value remaining-amount"><?php echo $settings['currency_symbol'] . ' ' . number_format($remaining, 2); ?></span>
                            </div>
                        </div>
                        
                        <div class="payment-progress">
                            <div class="progress-info">
                                <span>Payment Progress</span>
                                <span class="percentage"><?php echo number_format($percentage, 1); ?>%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?php echo $percentage; ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Form Card -->
                <div class="payment-form-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-plus-circle me-2"></i>Add Payment
                        </h5>
                    </div>
                    
                    <div class="card-body">
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <?php echo form_open('billing/process_payment_update/' . $bill->id, ['id' => 'paymentForm']); ?>
                        
                        <!-- Payment Amount -->
                        <div class="form-group mb-4">
                            <label class="form-label">Payment Amount <span class="required">*</span></label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text"><?php echo $settings['currency_symbol']; ?></span>
                                <input type="number" class="form-control" 
                                       name="payment_amount" id="payment_amount" 
                                       step="0.01" min="0.01" max="<?php echo $remaining; ?>"
                                       placeholder="0.00" required>
                            </div>
                            <div class="form-text">
                                Maximum amount: <?php echo $settings['currency_symbol'] . ' ' . number_format($remaining, 2); ?>
                            </div>
                            <?php echo form_error('payment_amount', '<div class="invalid-feedback d-block">', '</div>'); ?>
                        </div>

                        <!-- Quick Amount Buttons -->
                        <div class="quick-amounts mb-4">
                            <label class="form-label">Quick Amount</label>
                            <div class="quick-buttons">
                                <?php 
                                $half = $remaining / 2;
                                $three_quarter = ($remaining * 3) / 4;
                                ?>
                                <button type="button" class="btn btn-outline-primary quick-btn" 
                                        onclick="setAmount(<?php echo $half; ?>)">
                                    50% (<?php echo $settings['currency_symbol'] . number_format($half, 0); ?>)
                                </button>
                                <button type="button" class="btn btn-outline-primary quick-btn" 
                                        onclick="setAmount(<?php echo $three_quarter; ?>)">
                                    75% (<?php echo $settings['currency_symbol'] . number_format($three_quarter, 0); ?>)
                                </button>
                                <button type="button" class="btn btn-outline-success quick-btn" 
                                        onclick="setAmount(<?php echo $remaining; ?>)">
                                    Full Amount
                                </button>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="form-group mb-4">
                            <label class="form-label">Payment Method <span class="required">*</span></label>
                            <div class="payment-methods">
                                <div class="method-option">
                                    <input type="radio" id="cash" name="payment_method" value="cash" required>
                                    <label for="cash" class="method-card">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <span>Cash</span>
                                    </label>
                                </div>
                                <div class="method-option">
                                    <input type="radio" id="card" name="payment_method" value="card" required>
                                    <label for="card" class="method-card">
                                        <i class="fas fa-credit-card"></i>
                                        <span>Card</span>
                                    </label>
                                </div>
                                <div class="method-option">
                                    <input type="radio" id="upi" name="payment_method" value="upi" required>
                                    <label for="upi" class="method-card">
                                        <i class="fas fa-mobile-alt"></i>
                                        <span>UPI</span>
                                    </label>
                                </div>
                            </div>
                            <?php echo form_error('payment_method', '<div class="invalid-feedback d-block">', '</div>'); ?>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-check me-2"></i>Update Payment
                            </button>
                        </div>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function setAmount(amount) {
    document.getElementById('payment_amount').value = amount.toFixed(2);
}

// Form validation
document.getElementById('paymentForm').addEventListener('submit', function(e) {
    const amount = parseFloat(document.getElementById('payment_amount').value);
    const maxAmount = <?php echo $remaining; ?>;
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
    
    if (!amount || amount <= 0) {
        e.preventDefault();
        alert('Please enter a valid payment amount');
        return;
    }
    
    if (amount > maxAmount) {
        e.preventDefault();
        alert('Payment amount cannot exceed remaining amount');
        return;
    }
    
    if (!paymentMethod) {
        e.preventDefault();
        alert('Please select a payment method');
        return;
    }
});
</script>

<style>
/* Page Styles */
.update-payment-page {
    background: #f8f9fa;
    min-height: 100vh;
}

/* Header */
.page-header {
    background: white;
    border-bottom: 1px solid #dee2e6;
    padding: 1.5rem 0;
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: #212529;
    margin: 0;
}

.page-subtitle {
    color: #6c757d;
    margin: 0.25rem 0 0 0;
    font-size: 0.95rem;
}

/* Payment Summary Card */
.payment-summary-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
}

.summary-header {
    background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%);
    color: white;
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.bill-number {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0 0 0.5rem 0;
}

.customer-name {
    margin: 0;
    opacity: 0.9;
}

.customer-phone {
    font-size: 0.9rem;
}

.amount-summary {
    padding: 1.5rem;
}

.amount-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.amount-item {
    text-align: center;
    padding: 1rem;
    border-radius: 8px;
    background: #f8f9fa;
}

.amount-item.remaining {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
}

.amount-label {
    display: block;
    font-size: 0.85rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.amount-value {
    display: block;
    font-size: 1.1rem;
    font-weight: 600;
    color: #212529;
}

.remaining .amount-value {
    color: #856404;
}

.payment-progress {
    margin-top: 1rem;
}

.progress-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    font-weight: 500;
}

.progress-bar {
    height: 8px;
    background: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #28a745, #20c997);
    transition: width 0.3s ease;
}

/* Payment Form Card */
.payment-form-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    padding: 1rem 1.5rem;
}

.card-title {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    color: #212529;
}

.card-body {
    padding: 1.5rem;
}

/* Form Elements */
.form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.5rem;
}

.required {
    color: #dc3545;
}

.input-group-lg .form-control {
    font-size: 1.1rem;
    padding: 0.75rem 1rem;
}

.form-text {
    font-size: 0.85rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

/* Quick Amount Buttons */
.quick-amounts {
    margin-bottom: 1.5rem;
}

.quick-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.quick-btn {
    flex: 1;
    min-width: 120px;
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
}

/* Payment Methods */
.payment-methods {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.method-option {
    position: relative;
}

.method-option input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.method-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
}

.method-card:hover {
    border-color: #20c997;
    background: #f8f9fa;
}

.method-option input[type="radio"]:checked + .method-card {
    border-color: #20c997;
    background: rgba(32, 201, 151, 0.1);
    color: #20c997;
}

.method-card i {
    font-size: 1.5rem;
}

.method-card span {
    font-weight: 500;
}

/* Form Actions */
.form-actions {
    margin-top: 2rem;
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .summary-header {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .amount-grid {
        grid-template-columns: 1fr;
    }
    
    .payment-methods {
        grid-template-columns: 1fr;
    }
    
    .quick-buttons {
        flex-direction: column;
    }
    
    .quick-btn {
        width: 100%;
    }
}

/* Alert Styles */
.alert {
    border-radius: 8px;
    border: none;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
}

.invalid-feedback {
    font-size: 0.85rem;
    color: #dc3545;
    margin-top: 0.25rem;
}
</style> 