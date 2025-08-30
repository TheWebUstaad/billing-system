<!-- Enhanced Inventory Management Page -->
<div class="container-fluid">
    <!-- Enhanced Page Header -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                    <i class="fas fa-box fa-lg"></i>
                </div>
        <div>
                    <h2 class="mb-1 fw-bold">Inventory Management</h2>
                    <p class="text-muted mb-0">Manage your products and items efficiently</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 text-end">
            <div class="d-flex flex-column flex-lg-row gap-2 justify-content-lg-end">
                <a href="<?php echo site_url('inventory/add'); ?>" class="btn btn-primary btn-lg">
            <i class="fas fa-plus me-2"></i>Add New Item
        </a>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" id="exportInventoryBtn"><i class="fas fa-download me-2"></i>Export PDF</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" onclick="bulkDelete()"><i class="fas fa-trash me-2"></i>Bulk Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Search and Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-lg-6">
                    <div class="search-container">
                        <form action="<?php echo site_url('inventory/search'); ?>" method="get" class="d-flex">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="q" class="form-control border-start-0 ps-0"
                                       placeholder="Search by item name or SKU..."
                                   value="<?php echo $this->input->get('q'); ?>">
                            <?php if($this->input->get('q')): ?>
                                <a href="<?php echo site_url('inventory'); ?>" class="btn btn-outline-warning">
                                        <i class="fas fa-times"></i>
                                </a>
                            <?php endif; ?>
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search me-1"></i>Search
                                </button>
                        </div>
                    </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-card">
                                <div class="stat-value fw-bold text-primary"><?php echo count($items); ?></div>
                                <div class="stat-label small text-muted">
                                    <?php echo $this->input->get('q') ? 'Search Results' : 'Total Items'; ?>
                                </div>
                            </div>
                            <div class="vr d-none d-lg-block"></div>
                            <div class="stat-card">
                                <div class="stat-value fw-bold text-success">
                                    <?php echo $settings['currency_symbol'] ?? '₹'; ?><?php echo number_format(array_sum(array_column($items, 'price')), 2); ?>
                                </div>
                                <div class="stat-label small text-muted">
                                    <?php echo $this->input->get('q') ? 'Results Value' : 'Total Value'; ?>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-info btn-sm" onclick="toggleView()">
                                <i class="fas fa-th-list"></i>
                        </button>
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

    <!-- Search Results Info -->
    <?php if($this->input->get('q')): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-search me-2"></i>
            <strong>Search Results:</strong> Found <?php echo count($items); ?> item<?php echo count($items) !== 1 ? 's' : ''; ?> matching "<?php echo htmlspecialchars($this->input->get('q')); ?>"
            <a href="<?php echo site_url('inventory'); ?>" class="btn btn-sm btn-outline-primary ms-2">
                <i class="fas fa-times me-1"></i>Clear Search
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Enhanced Items Display -->
    <div id="itemsContainer">
        <!-- Grid View (Default) -->
        <div id="gridView" class="row g-4">
            <?php if(!empty($items)): ?>
                <?php foreach($items as $item): ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="card item-card h-100 shadow-sm hover-card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="item-sku">
                                        <span class="badge bg-primary-subtle text-primary border"><?php echo $item->sku; ?></span>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?php echo site_url('inventory/edit/'.$item->id); ?>">
                                                <i class="fas fa-edit me-2"></i>Edit Item</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="duplicateItem(<?php echo $item->id; ?>)">
                                                <i class="fas fa-copy me-2"></i>Duplicate</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="<?php echo site_url('inventory/delete/'.$item->id); ?>"
                                                   onclick="return confirm('Are you sure you want to delete this item?')">
                                                <i class="fas fa-trash me-2"></i>Delete</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="item-content mb-3">
                                    <h6 class="card-title fw-bold text-dark mb-2"><?php echo $item->title; ?></h6>
                                    <div class="item-price">
                                        <div class="d-flex align-items-center">
                                            <span class="currency-symbol text-success me-1"><?php echo $settings['currency_symbol'] ?? '₹'; ?></span>
                                            <span class="price-amount fw-bold text-success fs-5"><?php echo number_format($item->price, 2); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="item-actions">
                                    <div class="d-flex gap-2">
                                        <a href="<?php echo site_url('inventory/edit/'.$item->id); ?>"
                                           class="btn btn-primary btn-sm flex-fill">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <button class="btn btn-outline-danger btn-sm" onclick="deleteItem(<?php echo $item->id; ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <div class="empty-icon mb-4">
                                <?php if($this->input->get('q')): ?>
                                    <i class="fas fa-search fa-4x text-muted"></i>
                                <?php else: ?>
                                    <i class="fas fa-box fa-4x text-muted"></i>
                                <?php endif; ?>
                            </div>
                            <?php if($this->input->get('q')): ?>
                                <h4 class="text-muted mb-3">No items found</h4>
                                <p class="text-muted mb-4">No items match your search for "<strong><?php echo htmlspecialchars($this->input->get('q')); ?></strong>". Try different keywords or <a href="<?php echo site_url('inventory'); ?>" class="text-primary">clear your search</a>.</p>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="<?php echo site_url('inventory'); ?>" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Clear Search
                                    </a>
                                    <a href="<?php echo site_url('inventory/add'); ?>" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Add New Item
                                    </a>
                                </div>
                            <?php else: ?>
                                <h4 class="text-muted mb-3">No items found</h4>
                                <p class="text-muted mb-4">Start building your inventory by adding your first item.</p>
                                <a href="<?php echo site_url('inventory/add'); ?>" class="btn btn-primary btn-lg">
                                    <i class="fas fa-plus me-2"></i>Add Your First Item
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Table View (Hidden by default) -->
        <div id="tableView" class="d-none">
            <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                    <th class="text-center">
                                        <input type="checkbox" id="selectAll" class="form-check-input">
                                    </th>
                                    <th class="text-start">SKU</th>
                                <th class="text-start">Item Name</th>
                                <th class="text-end">Price</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($items)): ?>
                                <?php foreach($items as $item): ?>
                                    <tr>
                                        <td class="text-center">
                                                <input type="checkbox" class="form-check-input item-checkbox" value="<?php echo $item->id; ?>">
                                            </td>
                                            <td class="text-start">
                                                <span class="font-monospace text-primary fw-semibold"><?php echo $item->sku; ?></span>
                                        </td>
                                        <td class="text-start">
                                            <strong><?php echo $item->title; ?></strong>
                                        </td>
                                        <td class="text-end">
                                            <span class="fw-bold text-success">
                                                <?php echo $settings['currency_symbol'] ?? '₹'; ?> <?php echo number_format($item->price, 2); ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?php echo site_url('inventory/edit/'.$item->id); ?>"
                                                   class="btn btn-outline-primary" title="Edit Item">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                    <a href="#" onclick="duplicateItem(<?php echo $item->id; ?>)"
                                                       class="btn btn-outline-info" title="Duplicate Item">
                                                        <i class="fas fa-copy"></i>
                                                </a>
                                                <a href="<?php echo site_url('inventory/delete/'.$item->id); ?>"
                                                   class="btn btn-outline-danger"
                                                   onclick="return confirm('Are you sure you want to delete this item?')"
                                                   title="Delete Item">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="empty-state">
                                            <?php if($this->input->get('q')): ?>
                                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No items found</h5>
                                                <p class="text-muted">No items match your search for "<strong><?php echo htmlspecialchars($this->input->get('q')); ?></strong>".</p>
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <a href="<?php echo site_url('inventory'); ?>" class="btn btn-outline-secondary">
                                                        <i class="fas fa-times me-2"></i>Clear Search
                                                    </a>
                                                    <a href="<?php echo site_url('inventory/add'); ?>" class="btn btn-primary">
                                                        <i class="fas fa-plus me-2"></i>Add New Item
                                                    </a>
                                                </div>
                                            <?php else: ?>
                                                <i class="fas fa-box fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No items found</h5>
                                                <p class="text-muted">Start by adding your first item to the inventory.</p>
                                            <a href="<?php echo site_url('inventory/add'); ?>" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Add First Item
                                            </a>
                                            <?php endif; ?>
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
    </div>
</div>

<style>
/* Enhanced Inventory Styles */
.search-container .input-group {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 10px;
    overflow: hidden;
}

.search-container .input-group-text {
    border: none;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.search-container .form-control {
    border: none;
    font-size: 0.95rem;
}

.search-container .form-control:focus {
    box-shadow: none;
    border: none;
}

.stat-card {
    text-align: center;
    min-width: 80px;
}

.stat-value {
    font-size: 1.25rem;
    line-height: 1.2;
}

.stat-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Item Cards */
    .item-card {
    border: none;
    border-radius: 12px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.item-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #007bff 0%, #6610f2 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,123,255,0.15);
}

.hover-card:hover::before {
    opacity: 1;
    }

    .item-sku .badge {
        font-size: 0.75rem;
    font-weight: 600;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
}

.item-content .card-title {
    font-size: 1rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.currency-symbol {
    font-size: 0.9rem;
}

.price-amount {
    font-size: 1.1rem;
    }

    .item-actions .btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.item-actions .btn:hover {
    transform: translateY(-1px);
}

/* Empty State */
.empty-state {
    padding: 3rem 2rem;
}

.empty-icon {
    opacity: 0.5;
}

/* Table Styles */
.table th {
    border-top: none;
    font-weight: 600;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 2px solid #dee2e6;
    padding: 1rem 0.75rem;
}

.table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
}

.table tbody tr:hover {
    background-color: rgba(0,123,255,0.05);
}

/* View Toggle */
.view-toggle .btn {
    border-radius: 8px;
    padding: 0.5rem 1rem;
    transition: all 0.2s ease;
}

.view-toggle .btn.active {
    background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);
    color: white;
    border: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .search-container .input-group-lg .form-control {
        font-size: 0.9rem;
    }

    .stat-card {
        min-width: 60px;
    }

    .stat-value {
        font-size: 1rem;
    }

    .item-card .card-body {
        padding: 1rem;
    }

    .item-content .card-title {
        font-size: 0.95rem;
    }

    .price-amount {
        font-size: 1rem;
    }

    .empty-state {
        padding: 2rem 1rem;
    }
}

@media (max-width: 576px) {
    .d-flex.justify-content-between.align-items-center {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }

    .stat-card {
        text-align: left;
    }

    .item-actions .btn {
        font-size: 0.85rem;
        padding: 0.4rem 0.75rem;
    }
}

/* Alert Styles */
.alert {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Loading Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.item-card {
    animation: fadeIn 0.3s ease-out;
}
</style>

<script>
$(document).ready(function() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
    
    // Search input focus and enhancement
    $('input[name="q"]').focus();

    // Enhanced search with debouncing
    let searchTimeout;
    let currentSearchTerm = '<?php echo $this->input->get('q'); ?>';

    // Initialize search input with current value
    $('input[name="q"]').val(currentSearchTerm);

    // Show/hide clear button based on input
    function updateClearButton() {
        const searchTerm = $('input[name="q"]').val().trim();
        if (searchTerm.length > 0) {
            $('.btn-outline-warning').show();
        } else {
            $('.btn-outline-warning').hide();
        }
    }

    // Initialize clear button visibility
    updateClearButton();

    $('input[name="q"]').on('input', function() {
        clearTimeout(searchTimeout);
        const searchTerm = $(this).val().trim();

        // Update clear button visibility
        updateClearButton();

        // Show loading indicator
        $('.search-container .input-group-text i').removeClass('fa-search').addClass('fa-spinner fa-spin');

        searchTimeout = setTimeout(function() {
            // Hide loading indicator
            $('.search-container .input-group-text i').removeClass('fa-spinner fa-spin').addClass('fa-search');

            // Only search if term has changed
            if (searchTerm !== currentSearchTerm) {
                if (searchTerm.length >= 1 || searchTerm.length === 0) {
                    performSearch(searchTerm);
                }
            }
        }, 500); // Increased delay for better UX
    });

    // Handle Enter key press
    $('input[name="q"]').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            e.preventDefault();
            clearTimeout(searchTimeout);
            const searchTerm = $(this).val().trim();
            $('.search-container .input-group-text i').removeClass('fa-spinner fa-spin').addClass('fa-search');
            performSearch(searchTerm);
        }
    });

    // Handle search button click
    $('.btn-primary[type="submit"]').on('click', function(e) {
        e.preventDefault();
        clearTimeout(searchTimeout);
        const searchTerm = $('input[name="q"]').val().trim();
        $('.search-container .input-group-text i').removeClass('fa-spinner fa-spin').addClass('fa-search');
        performSearch(searchTerm);
    });

    // Handle clear button click
    $('.btn-outline-warning').on('click', function(e) {
        e.preventDefault();
        clearTimeout(searchTimeout);
        $('input[name="q"]').val('');
        updateClearButton();
        $('.search-container .input-group-text i').removeClass('fa-spinner fa-spin').addClass('fa-search');
        performSearch('');
    });

    // Function to perform search
    function performSearch(searchTerm) {
        currentSearchTerm = searchTerm;

        // Show loading state
        $('.search-container .input-group-text i').removeClass('fa-search').addClass('fa-spinner fa-spin');

        if (searchTerm.length > 0) {
            // Redirect to search URL
            window.location.href = '<?php echo site_url('inventory/search'); ?>?q=' + encodeURIComponent(searchTerm);
        } else {
            // Go back to main inventory page
            window.location.href = '<?php echo site_url('inventory'); ?>';
        }
    }

    // View toggle functionality
    $('.btn-outline-info').click(function() {
        const gridView = $('#gridView');
        const tableView = $('#tableView');
        const toggleBtn = $(this);

        if (gridView.hasClass('d-none')) {
            // Switch to grid view
            tableView.addClass('d-none');
            gridView.removeClass('d-none');
            toggleBtn.html('<i class="fas fa-th-list"></i>');
            toggleBtn.attr('title', 'Switch to Table View');
        } else {
            // Switch to table view
            gridView.addClass('d-none');
            tableView.removeClass('d-none');
            toggleBtn.html('<i class="fas fa-th"></i>');
            toggleBtn.attr('title', 'Switch to Grid View');
        }

        // Save preference to localStorage
        const currentView = gridView.hasClass('d-none') ? 'table' : 'grid';
        localStorage.setItem('inventoryView', currentView);
    });

    // Load saved view preference
    const savedView = localStorage.getItem('inventoryView');
    if (savedView === 'table') {
        $('#gridView').addClass('d-none');
        $('#tableView').removeClass('d-none');
        $('.btn-outline-info').html('<i class="fas fa-th"></i>');
    }

    // Bulk operations
    $('#selectAll').change(function() {
        $('.item-checkbox').prop('checked', $(this).prop('checked'));
        updateBulkActions();
    });

    $('.item-checkbox').change(function() {
        const checkedCount = $('.item-checkbox:checked').length;
        const totalCount = $('.item-checkbox').length;

        $('#selectAll').prop('checked', checkedCount === totalCount);
        $('#selectAll').prop('indeterminate', checkedCount > 0 && checkedCount < totalCount);

        updateBulkActions();
    });
    
    // Export inventory functionality
    $('#exportInventoryBtn').click(function(e) {
        e.preventDefault();
        let search = $('input[name="q"]').val();
        let exportUrl = '<?php echo site_url('inventory/export_pdf'); ?>';
        
        if (search) {
            exportUrl += '?search=' + encodeURIComponent(search);
        }
        
        console.log('Exporting inventory with URL:', exportUrl);
        window.open(exportUrl, '_blank');
    });

    // Enhanced delete confirmation
    window.deleteItem = function(itemId) {
        Swal.fire({
            title: 'Delete Item?',
            text: 'This action cannot be undone. The item will be permanently removed from your inventory.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?php echo site_url('inventory/delete/'); ?>' + itemId;
            }
        });
    };

    // Duplicate item function
    window.duplicateItem = function(itemId) {
        Swal.fire({
            title: 'Duplicate Item?',
            text: 'This will create a copy of the selected item with "(Copy)" appended to the name.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#007bff',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Duplicate',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Duplicating...',
                    text: 'Please wait while we create a copy of this item.',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Here you would make an AJAX call to duplicate the item
                // For now, we'll simulate it
                setTimeout(() => {
                    window.location.href = '<?php echo site_url('inventory/add'); ?>?duplicate=' + itemId;
                }, 1000);
            }
        });
    };

    // Bulk delete function
    window.bulkDelete = function() {
        const selectedItems = $('.item-checkbox:checked');
        if (selectedItems.length === 0) {
            Swal.fire({
                title: 'No Items Selected',
                text: 'Please select items to delete.',
                icon: 'warning'
            });
            return;
        }

        Swal.fire({
            title: 'Delete Selected Items?',
            text: `Are you sure you want to delete ${selectedItems.length} item(s)? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete All',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Here you would submit a form with selected item IDs
                // For now, we'll show a message
                Swal.fire({
                    title: 'Bulk Delete',
                    text: 'Bulk delete functionality would be implemented here.',
                    icon: 'info'
                });
            }
        });
    };

    // Update bulk actions visibility
    function updateBulkActions() {
        const checkedCount = $('.item-checkbox:checked').length;
        // You can add bulk action buttons that show/hide based on selection
    }

    // Smooth scroll for better UX
    $('.dropdown-item[href^="#"]').click(function(e) {
        e.preventDefault();
        const target = $(this).attr('href');
        $('html, body').animate({
            scrollTop: $(target).offset().top - 100
        }, 500);
    });

    // Keyboard shortcuts
    $(document).keydown(function(e) {
        // Ctrl/Cmd + F for search focus
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            $('input[name="q"]').focus().select();
        }

        // Ctrl/Cmd + N for new item
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            window.location.href = '<?php echo site_url('inventory/add'); ?>';
        }
    });

    // Add loading animation for actions
    $('.item-actions .btn, .dropdown-item').click(function() {
        const btn = $(this);
        if (!btn.hasClass('no-loading')) {
            btn.prop('disabled', true);
            btn.html('<i class="fas fa-spinner fa-spin me-1"></i>' + btn.text().trim());
        }
    });
});
</script> 