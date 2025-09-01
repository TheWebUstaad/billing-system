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
                        <div class="text-muted d-md-none">
                            <i class="fas fa-users"></i> <span id="totalCustomersMobile"><?php echo count($customers); ?></span> customers
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

    <!-- Customers Cards Grid -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Customers List</h5>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-info" id="totalCustomersBadge">
                    <i class="fas fa-users me-1"></i><?php echo count($customers); ?> customers
                </span>
            </div>
        </div>
        <div class="card-body">
            <?php if(!empty($customers)): ?>
                <!-- Desktop View Toggle -->
                <div class="d-none d-md-block mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="viewToggle" checked>
                        <label class="form-check-label" for="viewToggle">
                            <small class="text-muted">Card View</small>
                        </label>
                    </div>
                </div>

                <!-- Customers Cards Container -->
                <div class="row g-3" id="customersContainer">
                    <?php foreach($customers as $customer): ?>
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 customer-card" data-customer-id="<?php echo $customer->id; ?>">
                            <div class="card h-100 customer-card-item border-0 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <!-- Customer Header -->
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="flex-grow-1">
                                            <h6 class="card-title mb-1 customer-name fw-bold text-truncate" title="<?php echo $customer->name; ?>">
                                                <?php echo $customer->name; ?>
                                            </h6>
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
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="<?php echo site_url('customer/view/'.$customer->id); ?>">
                                                        <i class="fas fa-eye me-2"></i>View Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="<?php echo site_url('customer/edit/'.$customer->id); ?>">
                                                        <i class="fas fa-edit me-2"></i>Edit Customer
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item text-danger delete-customer"
                                                       href="<?php echo site_url('customer/delete/'.$customer->id); ?>"
                                                       data-name="<?php echo $customer->name; ?>"
                                                       data-bills="<?php echo $customer->bills_count; ?>">
                                                        <i class="fas fa-trash me-2"></i>Delete Customer
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Contact Info -->
                                    <div class="mb-3">
                                        <?php if(!empty($customer->phone)): ?>
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="fas fa-phone text-primary me-2"></i>
                                                <small class="text-muted"><?php echo $customer->phone; ?></small>
                                            </div>
                                        <?php else: ?>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-phone-slash text-muted me-2"></i>
                                                <small class="text-muted">No phone</small>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Bills Count -->
                                    <div class="mb-3">
                                        <?php if($customer->bills_count > 0): ?>
                                            <span class="badge bg-primary w-100 justify-content-center py-2">
                                                <i class="fas fa-receipt me-1"></i><?php echo $customer->bills_count; ?> bills
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary w-100 justify-content-center py-2">
                                                <i class="fas fa-receipt me-1"></i>No bills
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Total Spent -->
                                    <div class="mb-3">
                                        <div class="text-center">
                                            <small class="text-muted d-block">Total Spent</small>
                                            <?php if($customer->total_spent > 0): ?>
                                                <span class="fw-bold text-success fs-5">
                                                    <?php echo $settings['currency_symbol'] ?? '₹'; ?> <?php echo number_format($customer->total_spent, 2); ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted"> 0.00</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Joined Date -->
                                    <div class="mt-auto">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            Joined <?php echo date('d M Y', strtotime($customer->created_at)); ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-users fa-4x mb-4 text-muted"></i>
                        <h5 class="mb-2">No customers found</h5>
                        <p class="mb-4">Start by adding your first customer.</p>
                        <a href="<?php echo site_url('customer/add'); ?>" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>Add First Customer
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
/* Customer Cards Styles */
.customer-card-item {
    transition: all 0.3s ease;
    border-radius: 0.75rem;
    overflow: hidden;
}

.customer-card-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.customer-name {
    color: #495057;
    margin-bottom: 2px;
    font-size: 1rem;
}

.customer-card-item .card-title {
    font-size: 1rem;
}

.customer-card-item .badge {
    font-size: 0.75rem;
    border-radius: 0.5rem;
}

.customer-card-item .dropdown-toggle {
    border: none;
    padding: 0.25rem 0.5rem;
}

.customer-card-item .dropdown-toggle:focus {
    box-shadow: none;
}

.customer-card-item .dropdown-menu {
    border: none;
    box-shadow: 0 0.25rem 1rem rgba(0, 0, 0, 0.15);
    border-radius: 0.5rem;
}

.customer-card-item .dropdown-item {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.customer-card-item .dropdown-item i {
    width: 1rem;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .customer-card-item {
        margin-bottom: 0.5rem;
    }

    .customer-card-item .card-body {
        padding: 1rem 0.75rem;
    }

    .customer-name {
        font-size: 0.9rem;
    }

    .customer-card-item .fs-5 {
        font-size: 1.1rem !important;
    }
}

@media (min-width: 768px) and (max-width: 991px) {
    .col-lg-4 {
        flex: 0 0 50%;
        max-width: 50%;
    }
}

@media (min-width: 992px) and (max-width: 1199px) {
    .col-lg-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }
}

@media (min-width: 1200px) {
    .col-xl-3 {
        flex: 0 0 25%;
        max-width: 25%;
    }
}

/* Alert styles */
.alert {
    border: none;
    border-radius: 0.5rem;
}

/* Search and filter styles */
.input-group .btn {
    border-color: #dee2e6;
}

.input-group .btn:hover {
    border-color: #adb5bd;
}

/* Toggle switch styling */
.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.form-check-label {
    cursor: pointer;
}

/* Loading state for cards */
.customer-card-item.loading {
    opacity: 0.6;
    pointer-events: none;
}

/* Empty state improvements */
.text-center .fa-users {
    opacity: 0.5;
}
</style>

<script>
$(document).ready(function() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);

    // Search functionality for cards
    $('#searchInput').on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase();
        var visibleCards = 0;

        $('.customer-card').each(function() {
            var customerName = $(this).find('.customer-name').text().toLowerCase();
            var phone = $(this).find('small').text().toLowerCase();
            var cardText = $(this).text().toLowerCase();

            if (customerName.includes(searchTerm) || phone.includes(searchTerm) || cardText.includes(searchTerm)) {
                $(this).show();
                visibleCards++;
            } else {
                $(this).hide();
            }
        });

        // Update badge count
        updateCustomerCount(visibleCards);

        // Update mobile counter if exists
        if ($('#totalCustomersMobile').length) {
            $('#totalCustomersMobile').text(visibleCards);
        }
    });

    // Clear search
    $('#resetBtn').click(function() {
        $('#searchInput').val('');
        $('.customer-card').show();
        var totalCount = $('.customer-card').length;
        updateCustomerCount(totalCount);

        // Update mobile counter if exists
        if ($('#totalCustomersMobile').length) {
            $('#totalCustomersMobile').text(totalCount);
        }
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

    // Function to update customer count badge
    function updateCustomerCount(count) {
        $('#totalCustomersBadge').html('<i class="fas fa-users me-1"></i>' + count + ' customers');
    }

    // Delete confirmation with bills warning
    $(document).on('click', '.delete-customer', function(e) {
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
                    // Add loading state to card
                    $(this).closest('.customer-card-item').addClass('loading');
                    window.location.href = link;
                }
            });
        }
    });

    // Card hover effects
    $(document).on('mouseenter', '.customer-card-item', function() {
        $(this).addClass('hovered');
    }).on('mouseleave', '.customer-card-item', function() {
        $(this).removeClass('hovered');
    });

    // Focus search input
    $('#searchInput').focus();

    // Optional: Add smooth scrolling for mobile
    if ($(window).width() < 768) {
        $('.customer-card-item').css('scroll-margin-top', '1rem');
    }
});
</script>
