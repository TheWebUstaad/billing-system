<!-- Professional Customer Management Page -->
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Customer Management</h2>
            <p class="text-muted mb-0">Manage your customers and track their purchase history</p>
        </div>
        <a href="<?php echo site_url('customer/add'); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Customer
        </a>
    </div>



    <!-- Search and Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" 
                               placeholder="Search by name or phone..." autocomplete="off">
                        <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button class="btn btn-outline-warning" type="button" id="resetBtn">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-flex justify-content-end align-items-center gap-3">
                        <div class="text-muted">
                            <i class="fas fa-users"></i> <span id="totalCustomers"><?php echo count($customers); ?></span> customers
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?php echo $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?php echo $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Customers Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Customers List</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="customersTable">
                    <thead class="table-light">
                        <tr>
                            <th width="30%" class="text-start">Customer Info</th>
                            <th width="20%" class="text-center">Contact</th>
                            <th width="15%" class="text-center">Bills Count</th>
                            <th width="18%" class="text-end">Total Spent</th>
                            <th width="12%" class="text-center">Joined</th>
                            <th width="8%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="customersTableBody">
                        <?php if(!empty($customers)): ?>
                            <?php foreach($customers as $customer): ?>
                                <tr class="customer-row">
                                    <td class="text-start">
                                        <div class="customer-info">
                                            <div class="customer-name fw-bold"><?php echo $customer->name; ?></div>
                                            <?php if($customer->bills_count > 0): ?>
                                                <small class="text-success">
                                                    <i class="fas fa-star me-1"></i>Regular Customer
                                                </small>
                                            <?php else: ?>
                                                <small class="text-muted">
                                                    <i class="fas fa-user me-1"></i>New Customer
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="contact-info">
                                            <?php if(!empty($customer->phone)): ?>
                                                <div class="phone">
                                                    <i class="fas fa-phone text-primary me-1"></i>
                                                    <small><?php echo $customer->phone; ?></small>
                                                </div>
                                            <?php else: ?>
                                                <small class="text-muted">No phone</small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php if($customer->bills_count > 0): ?>
                                            <span class="badge bg-primary bills-badge">
                                                <?php echo $customer->bills_count; ?> bills
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">
                                                No bills
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <?php if($customer->total_spent > 0): ?>
                                            <span class="fw-bold text-success">
                                                <?php echo $settings['currency_symbol'] ?? '₹'; ?> <?php echo number_format($customer->total_spent, 2); ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">₹ 0.00</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <small class="text-muted">
                                            <?php echo date('d M Y', strtotime($customer->created_at)); ?>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="<?php echo site_url('customer/view/'.$customer->id); ?>" 
                                               class="btn btn-sm btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo site_url('customer/edit/'.$customer->id); ?>" 
                                               class="btn btn-sm btn-outline-secondary" title="Edit Customer">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?php echo site_url('customer/delete/'.$customer->id); ?>" 
                                               class="btn btn-sm btn-outline-danger delete-customer" 
                                               data-name="<?php echo $customer->name; ?>"
                                               data-bills="<?php echo $customer->bills_count; ?>"
                                               title="Delete Customer">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-3x mb-3"></i>
                                        <h5>No customers found</h5>
                                        <p>Start by adding your first customer.</p>
                                        <a href="<?php echo site_url('customer/add'); ?>" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Add First Customer
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>


.customer-info {
    line-height: 1.4;
}

.customer-name {
    color: #495057;
    margin-bottom: 2px;
}

.contact-info {
    line-height: 1.3;
}

.contact-info .phone,
.contact-info .email {
    font-size: 0.875rem;
    margin-bottom: 1px;
}

.bills-badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.5rem;
}

.table th {
    border-top: none;
    font-weight: 600;
}

.btn-group .btn {
    margin-right: 0.125rem;
}

.alert {
    border: none;
    border-radius: 0.5rem;
}

.customer-row:hover {
    background-color: #f8f9fa;
}
</style>

<script>
$(document).ready(function() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
    
    // Search functionality
    $('#searchInput').on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase();
        var visibleRows = 0;
        
        $('.customer-row').each(function() {
            var customerName = $(this).find('.customer-name').text().toLowerCase();
            var phone = $(this).find('.contact-info').text().toLowerCase();
            var email = $(this).find('.contact-info').text().toLowerCase();
            
            if (customerName.includes(searchTerm) || phone.includes(searchTerm) || email.includes(searchTerm)) {
                $(this).show();
                visibleRows++;
            } else {
                $(this).hide();
            }
        });
        
        $('#totalCustomers').text(visibleRows);
    });
    
    // Clear search
    $('#resetBtn').click(function() {
        $('#searchInput').val('');
        $('.customer-row').show();
        $('#totalCustomers').text($('.customer-row').length);
    });
    
    // Search button
    $('#searchBtn').click(function() {
        $('#searchInput').trigger('keyup');
    });
    
    // Enter key search
    $('#searchInput').keypress(function(e) {
        if (e.which == 13) {
            $('#searchBtn').click();
        }
    });
    
    // Delete confirmation with bills warning
    $('.delete-customer').click(function(e) {
        e.preventDefault();
        var link = $(this).attr('href');
        var name = $(this).data('name');
        var billsCount = $(this).data('bills');
        
        if (billsCount > 0) {
            // Show error if customer has bills
            Swal.fire({
                title: 'کسٹمر ڈیلیٹ نہیں ہو سکتا!',
                html: '<div style="text-align: right; direction: rtl;">' +
                      '<p>کسٹمر <strong>"' + name + '"</strong> کو ڈیلیٹ نہیں کر سکتے۔</p>' +
                      '<p style="color: #e74c3c;"><i class="fas fa-exclamation-triangle"></i> اس کے <strong>' + billsCount + '</strong> بل موجود ہیں!</p>' +
                      '<p>پہلے تمام بل ڈیلیٹ کریں، پھر یہ کسٹمر ڈیلیٹ کریں۔</p>' +
                      '</div>',
                icon: 'error',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'سمجھ گیا'
            });
        } else {
            // Normal delete confirmation for customers without bills
            Swal.fire({
                title: 'کسٹمر ڈیلیٹ کریں؟',
                html: '<div style="text-align: right; direction: rtl;">' +
                      '<p>کیا آپ واقعی کسٹمر <strong>"' + name + '"</strong> کو ڈیلیٹ کرنا چاہتے ہیں؟</p>' +
                      '<p style="color: #27ae60;">یہ کسٹمر کے کوئی بل نہیں ہیں، محفوظ طریقے سے ڈیلیٹ ہو سکتا ہے۔</p>' +
                      '</div>',
                icon: 'question',
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
        }
    });
    
    // Focus search input
    $('#searchInput').focus();
});
</script>
