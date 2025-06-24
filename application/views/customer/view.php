<!-- Professional Customer Details Page -->
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Customer Details</h2>
            <p class="text-muted mb-0">View customer information and purchase history</p>
        </div>
        <div>
            <a href="<?php echo site_url('customer/edit/'.$customer->id); ?>" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Edit Customer
            </a>
            <a href="<?php echo site_url('customer'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>



    <div class="row">
        <!-- Customer Information -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>Customer Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="customer-profile text-center mb-4">
                        <div class="avatar bg-primary text-white rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; line-height: 80px; font-size: 2rem;">
                            <?php echo strtoupper(substr($customer->name, 0, 1)); ?>
                        </div>
                        <h5 class="mb-1"><?php echo $customer->name; ?></h5>
                        <?php if($bills_count > 0): ?>
                            <span class="badge bg-success">Regular Customer</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">New Customer</span>
                        <?php endif; ?>
                    </div>

                    <div class="info-list">
                        <div class="info-item d-flex align-items-center mb-3">
                            <div class="info-icon bg-primary text-white rounded-circle me-3" style="width: 40px; height: 40px; line-height: 40px; text-align: center;">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <small class="text-muted">Phone Number</small>
                                <div class="fw-bold"><?php echo $customer->phone; ?></div>
                            </div>
                        </div>



                        <div class="info-item d-flex align-items-center mb-3">
                            <div class="info-icon bg-success text-white rounded-circle me-3" style="width: 40px; height: 40px; line-height: 40px; text-align: center;">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <div>
                                <small class="text-muted">Joined Date</small>
                                <div class="fw-bold"><?php echo date('d M Y, h:i A', strtotime($customer->created_at)); ?></div>
                            </div>
                        </div>

                        <?php if(!empty($customer->updated_at) && $customer->updated_at != $customer->created_at): ?>
                        <div class="info-item d-flex align-items-center">
                            <div class="info-icon bg-secondary text-white rounded-circle me-3" style="width: 40px; height: 40px; line-height: 40px; text-align: center;">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div>
                                <small class="text-muted">Last Updated</small>
                                <div class="fw-bold"><?php echo date('d M Y, h:i A', strtotime($customer->updated_at)); ?></div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bills History -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>Bills History
                    </h5>
                    <?php if($bills_count > 5): ?>
                        <small class="text-muted">Showing recent 10 bills</small>
                    <?php endif; ?>
                </div>
                <div class="card-body p-0">
                    <?php if(!empty($customer_bills)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-start">Bill Number</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Items</th>
                                        <th class="text-end">Amount</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($customer_bills as $bill): ?>
                                        <tr>
                                            <td class="text-start">
                                                <strong class="text-primary"><?php echo $bill->bill_number; ?></strong>
                                            </td>
                                            <td class="text-center">
                                                <div><?php echo date('d M Y', strtotime($bill->created_at)); ?></div>
                                                <small class="text-muted"><?php echo date('h:i A', strtotime($bill->created_at)); ?></small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info"><?php echo $bill->items_count; ?> items</span>
                                            </td>
                                            <td class="text-end">
                                                <span class="fw-bold text-success">
                                                    <?php echo $settings['currency_symbol'] ?? '₹'; ?> <?php echo number_format($bill->total_amount, 2); ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="<?php echo site_url('billing/view/'.$bill->id); ?>" 
                                                       class="btn btn-sm btn-outline-primary" title="View Bill">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?php echo site_url('billing/pdf/'.$bill->id); ?>" 
                                                       class="btn btn-sm btn-outline-success" target="_blank" title="Download PDF">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-receipt fa-3x mb-3"></i>
                                <h5>No Bills Found</h5>
                                <p>This customer hasn't made any purchases yet.</p>
                                <a href="<?php echo site_url('billing/create'); ?>" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Create First Bill
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if($bills_count > 10): ?>
                    <div class="card-footer text-center">
                        <small class="text-muted">
                            Showing 10 of <?php echo $bills_count; ?> total bills
                        </small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>


.customer-profile {
    padding: 1rem 0;
}

.info-list {
    padding: 0;
}

.info-item {
    padding: 0.5rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-item:last-child {
    border-bottom: none;
}

.table th {
    border-top: none;
    font-weight: 600;
    background-color: #f8f9fa;
}

.btn-group .btn {
    margin-right: 0.125rem;
}

.avatar {
    font-weight: bold;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}
</style>

<script>
$(document).ready(function() {
    // Add hover effects and animations
    $('.info-item').hover(
        function() {
            $(this).css('background-color', '#f8f9fa');
        },
        function() {
            $(this).css('background-color', 'transparent');
        }
    );
});
</script> 