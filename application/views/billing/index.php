<!-- Professional Bills Management Page -->
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Bills Management</h2>
            <p class="text-muted mb-0">Manage and track all your bills</p>
        </div>
        <a href="<?php echo base_url('billing/create'); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create New Bill
        </a>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Search Bills</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" 
                               placeholder="Search by bill#, customer name, phone...">
                        <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">From Date</label>
                    <input type="date" class="form-control" id="fromDate" value="<?php echo date('Y-m-01'); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">To Date</label>
                    <input type="date" class="form-control" id="toDate" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle flex-fill" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                <li><a class="dropdown-item" href="#" id="quickFilterBtn"><i class="fas fa-bolt"></i> Quick Filter</a></li>
                                <li><a class="dropdown-item" href="#" id="customRangeBtn"><i class="fas fa-calendar-alt"></i> Custom Range</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#" id="todayFilterBtn"><i class="fas fa-calendar-day"></i> Today</a></li>
                                <li><a class="dropdown-item" href="#" id="thisWeekFilterBtn"><i class="fas fa-calendar-week"></i> This Week</a></li>
                                <li><a class="dropdown-item" href="#" id="thisMonthFilterBtn"><i class="fas fa-calendar"></i> This Month</a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-outline-secondary" id="resetBtn">
                            <i class="fas fa-refresh"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bills Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Bills List</h5>
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center">
                    <label class="form-label me-2 mb-0">Show:</label>
                    <select class="form-select form-select-sm" id="perPage" style="width: auto;">
                        <option value="10">10</option>
                        <option value="25" selected>25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <button class="btn btn-outline-success btn-sm" id="exportBtn">
                    <i class="fas fa-download"></i> Export PDF
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="billsTable">
                    <thead class="table-light">
                        <tr>
                            <th width="15%" class="text-start">
                                <a href="#" class="text-decoration-none sortable" data-sort="bill_number">
                                    Bill Number <i class="fas fa-sort"></i>
                                </a>
                            </th>
                            <th width="25%" class="text-start">
                                <a href="#" class="text-decoration-none sortable" data-sort="customer_name">
                                    Customer <i class="fas fa-sort"></i>
                                </a>
                            </th>
                            <th width="15%" class="text-end">
                                <a href="#" class="text-decoration-none sortable" data-sort="total_amount">
                                    Amount <i class="fas fa-sort"></i>
                                </a>
                            </th>
                            <th width="15%" class="text-center">
                                <a href="#" class="text-decoration-none sortable" data-sort="created_at">
                                    Date <i class="fas fa-sort"></i>
                                </a>
                            </th>
                            <th width="10%" class="text-center">Items</th>
                            <th width="20%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="billsTableBody">
                        <!-- Dynamic content will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing <span id="showingFrom">1</span> to <span id="showingTo">25</span> of <span id="totalRecords">0</span> bills
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0" id="pagination">
                        <!-- Pagination will be generated here -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Export Date Range Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Export Bills to PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="exportForm">
                    <div class="mb-3">
                        <label for="exportFromDate" class="form-label">From Date</label>
                        <input type="date" class="form-control" id="exportFromDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="exportToDate" class="form-label">To Date</label>
                        <input type="date" class="form-control" id="exportToDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="exportSearch" class="form-label">Search Filter (Optional)</label>
                        <input type="text" class="form-control" id="exportSearch" 
                               placeholder="Bill number, customer name, phone...">
                        <div class="form-text">Leave empty to export all bills in date range</div>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Export will include:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Bill Number, Customer Info, Amount, Date</li>
                            <li>Total bills count and sum</li>
                            <li>Professional PDF format</li>
                        </ul>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmExportBtn">
                    <i class="fas fa-download"></i> Export PDF
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Custom Date Range Filter Modal -->
<div class="modal fade" id="customRangeModal" tabindex="-1" aria-labelledby="customRangeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customRangeModalLabel">
                    <i class="fas fa-calendar-alt"></i> Select Date Range for Filter
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="customRangeForm">
                    <div class="mb-3">
                        <label for="filterFromDate" class="form-label">From Date</label>
                        <input type="date" class="form-control" id="filterFromDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="filterToDate" class="form-label">To Date</label>
                        <input type="date" class="form-control" id="filterToDate" required>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Filter Options:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Select custom date range</li>
                            <li>Bills will be filtered by creation date</li>
                            <li>Search filter will also apply</li>
                        </ul>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="applyCustomRangeBtn">
                    <i class="fas fa-filter"></i> Apply Filter
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    transition: transform 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
}

.sortable {
    color: #495057;
}

.sortable:hover {
    color: #007bff;
}

.table th {
    border-top: none;
    font-weight: 600;
}

.customer-info {
    line-height: 1.4;
}

.customer-name {
    font-weight: 500;
    color: #495057;
}

.customer-phone {
    font-size: 0.875rem;
    color: #6c757d;
}

.amount-info {
    text-align: right;
}

.total-amount {
    font-weight: 600;
    color: #28a745;
}

.badge-items {
    background-color: #e9ecef;
    color: #495057;
    font-weight: 500;
}

.action-buttons .btn {
    margin-right: 0.25rem;
}

.loading {
    text-align: center;
    padding: 2rem;
    color: #6c757d;
}

.no-results {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
}

.pagination .page-link {
    border-radius: 0.375rem;
    margin: 0 0.125rem;
}
</style>

<script>
// Bills Management v2.0 - Stats removed, filter dropdown added
$(document).ready(function() {
    let currentPage = 1;
    let perPage = 25;
    let sortField = 'created_at';
    let sortDirection = 'desc';
    
    // Load initial data
    console.log('Loading bills page...');
    
    // Use fallback initially, AJAX for filtering
    loadBillsFallback();
    
    // Search functionality
    $('#searchBtn, #filterBtn').click(function() {
        currentPage = 1;
        // Use AJAX for filtering, fallback if fails
        loadBills();
    });
    
    $('#searchInput').keypress(function(e) {
        if (e.which == 13) {
            currentPage = 1;
            loadBills();
        }
    });
    
    // Reset filters
    $('#resetBtn').click(function() {
        $('#searchInput').val('');
        $('#fromDate').val('<?php echo date('Y-m-01'); ?>');
        $('#toDate').val('<?php echo date('Y-m-d'); ?>');
        currentPage = 1;
        loadBills();
    });
    
    // Per page change
    $('#perPage').change(function() {
        perPage = $(this).val();
        currentPage = 1;
        loadBills();
    });
    
    // Sorting
    $(document).on('click', '.sortable', function(e) {
        e.preventDefault();
        let field = $(this).data('sort');
        
        if (sortField === field) {
            sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            sortField = field;
            sortDirection = 'asc';
        }
        
        currentPage = 1;
        loadBills();
        updateSortIcons();
    });
    
    // Pagination
    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        if (page && page !== currentPage) {
            currentPage = page;
            loadBills();
        }
    });
    
    // Export functionality
    $('#exportBtn').click(function() {
        // Pre-fill modal with current filter values
        let currentFromDate = $('#fromDate').val() || '<?php echo date('Y-m-01'); ?>';
        let currentToDate = $('#toDate').val() || '<?php echo date('Y-m-d'); ?>';
        let currentSearch = $('#searchInput').val();
        
        $('#exportFromDate').val(currentFromDate);
        $('#exportToDate').val(currentToDate);
        $('#exportSearch').val(currentSearch);
        
        // Show modal
        $('#exportModal').modal('show');
    });
    
    // Confirm export button
    $('#confirmExportBtn').click(function() {
        let exportFromDate = $('#exportFromDate').val();
        let exportToDate = $('#exportToDate').val();
        let exportSearch = $('#exportSearch').val();
        
        // Validate dates
        if (!exportFromDate || !exportToDate) {
            alert('Please select both from and to dates');
            return;
        }
        
        if (new Date(exportFromDate) > new Date(exportToDate)) {
            alert('From date cannot be later than to date');
            return;
        }
        
        // Build export URL
        let exportUrl = '<?php echo base_url('billing/export_bills'); ?>';
        let params = [];
        
        params.push('from_date=' + encodeURIComponent(exportFromDate));
        params.push('to_date=' + encodeURIComponent(exportToDate));
        if (exportSearch) params.push('search=' + encodeURIComponent(exportSearch));
        
        exportUrl += '?' + params.join('&');
        
        console.log('Exporting with URL:', exportUrl);
        
        // Close modal and open PDF
        $('#exportModal').modal('hide');
        window.open(exportUrl, '_blank');
    });
    
    // Filter dropdown functionality
    $('#quickFilterBtn').click(function(e) {
        e.preventDefault();
        // Use current form values and apply filter
        currentPage = 1;
        loadBills();
    });
    
    $('#customRangeBtn').click(function(e) {
        e.preventDefault();
        // Pre-fill modal with current values
        let currentFromDate = $('#fromDate').val() || '<?php echo date('Y-m-01'); ?>';
        let currentToDate = $('#toDate').val() || '<?php echo date('Y-m-d'); ?>';
        
        $('#filterFromDate').val(currentFromDate);
        $('#filterToDate').val(currentToDate);
        
        $('#customRangeModal').modal('show');
    });
    
    $('#applyCustomRangeBtn').click(function() {
        let filterFromDate = $('#filterFromDate').val();
        let filterToDate = $('#filterToDate').val();
        
        // Validate dates
        if (!filterFromDate || !filterToDate) {
            alert('Please select both from and to dates');
            return;
        }
        
        if (new Date(filterFromDate) > new Date(filterToDate)) {
            alert('From date cannot be later than to date');
            return;
        }
        
        // Update main form fields
        $('#fromDate').val(filterFromDate);
        $('#toDate').val(filterToDate);
        
        // Apply filter
        currentPage = 1;
        loadBills();
        
        // Close modal
        $('#customRangeModal').modal('hide');
    });
    
    // Quick date filters
    $('#todayFilterBtn').click(function(e) {
        e.preventDefault();
        let today = new Date().toISOString().split('T')[0];
        $('#fromDate').val(today);
        $('#toDate').val(today);
        currentPage = 1;
        loadBills();
    });
    
    $('#thisWeekFilterBtn').click(function(e) {
        e.preventDefault();
        let today = new Date();
        let firstDay = new Date(today.setDate(today.getDate() - today.getDay()));
        let lastDay = new Date(today.setDate(today.getDate() - today.getDay() + 6));
        
        $('#fromDate').val(firstDay.toISOString().split('T')[0]);
        $('#toDate').val(lastDay.toISOString().split('T')[0]);
        currentPage = 1;
        loadBills();
    });
    
    $('#thisMonthFilterBtn').click(function(e) {
        e.preventDefault();
        let today = new Date();
        let firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        let lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        
        $('#fromDate').val(firstDay.toISOString().split('T')[0]);
        $('#toDate').val(lastDay.toISOString().split('T')[0]);
        currentPage = 1;
        loadBills();
    });
    
    function loadBills() {
        let search = $('#searchInput').val();
        let fromDate = $('#fromDate').val();
        let toDate = $('#toDate').val();
        
        $('#billsTableBody').html('<tr><td colspan="6" class="loading"><i class="fas fa-spinner fa-spin"></i> Loading bills...</td></tr>');
        
        let ajaxUrl = '<?php echo base_url('billing/get_bills_ajax'); ?>';
        console.log('AJAX URL:', ajaxUrl);
        
        $.ajax({
            url: ajaxUrl,
            method: 'GET',
            data: {
                page: currentPage,
                per_page: perPage,
                search: search,
                from_date: fromDate,
                to_date: toDate,
                sort_field: sortField,
                sort_direction: sortDirection
            },
            success: function(response) {
                try {
                    let data = JSON.parse(response);
                    renderBillsTable(data.bills);
                    renderPagination(data.pagination);
                    updateShowingText(data.pagination);
                } catch(e) {
                    console.error('Error parsing JSON:', e);
                    loadBillsFallback();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                loadBillsFallback();
            }
        });
    }
    
    function loadBillsFallback() {
        // Fallback to show existing bills from PHP
        let existingBills = <?php echo json_encode($bills); ?>;
        renderBillsTable(existingBills);
        
        // Simple pagination for fallback
        let totalBills = existingBills.length;
        let pagination = {
            current_page: 1,
            total_pages: Math.ceil(totalBills / perPage),
            total_records: totalBills,
            showing_from: 1,
            showing_to: Math.min(perPage, totalBills),
            per_page: perPage
        };
        
        renderPagination(pagination);
        updateShowingText(pagination);
    }
    
    function renderBillsTable(bills) {
        let html = '';
        
        if (bills.length === 0) {
            html = '<tr><td colspan="6" class="no-results"><i class="fas fa-inbox"></i><br>No bills found</td></tr>';
        } else {
            bills.forEach(function(bill) {
                let itemsCount = bill.items ? bill.items.length : 0;
                let customerName = bill.customer_name || 'Walk-in Customer';
                let customerPhone = bill.customer_phone || '';
                
                html += `
                    <tr>
                        <td class="text-start">
                            <strong class="text-primary">${bill.bill_number}</strong>
                        </td>
                        <td class="text-start">
                            <div class="customer-info">
                                <div class="customer-name">${customerName}</div>
                                ${customerPhone ? `<small class="customer-phone"><i class="fas fa-phone me-1"></i>${customerPhone}</small>` : ''}
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="amount-info">
                                <div class="total-amount"><?php echo $settings['currency_symbol']; ?> ${parseFloat(bill.total_amount).toFixed(2)}</div>
                                <small class="text-muted">${itemsCount} items</small>
                            </div>
                        </td>
                        <td class="text-center">
                            <div>${formatDate(bill.created_at)}</div>
                            <small class="text-muted">${formatTime(bill.created_at)}</small>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-items">${itemsCount}</span>
                        </td>
                        <td class="text-center">
                            <div class="action-buttons">
                                <a href="<?php echo base_url('billing/view/'); ?>${bill.id}" class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo base_url('billing/edit/'); ?>${bill.id}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo base_url('billing/pdf/'); ?>${bill.id}" class="btn btn-sm btn-outline-success" target="_blank" title="Download PDF">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="<?php echo base_url('billing/delete/'); ?>${bill.id}" class="btn btn-sm btn-outline-danger delete-bill" 
                                   data-bill="${bill.bill_number}" title="Delete Bill">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
            });
        }
        
        $('#billsTableBody').html(html);
    }
    
    function renderPagination(pagination) {
        let html = '';
        
        // Previous button
        html += `<li class="page-item ${pagination.current_page <= 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${pagination.current_page - 1}">Previous</a>
        </li>`;
        
        // Page numbers
        for (let i = 1; i <= pagination.total_pages; i++) {
            if (i <= 3 || i > pagination.total_pages - 3 || Math.abs(i - pagination.current_page) <= 2) {
                html += `<li class="page-item ${i === pagination.current_page ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>`;
            } else if (i === 4 && pagination.current_page > 6) {
                html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            } else if (i === pagination.total_pages - 3 && pagination.current_page < pagination.total_pages - 5) {
                html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }
        
        // Next button
        html += `<li class="page-item ${pagination.current_page >= pagination.total_pages ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${pagination.current_page + 1}">Next</a>
        </li>`;
        
        $('#pagination').html(html);
    }
    
    function updateShowingText(pagination) {
        $('#showingFrom').text(pagination.showing_from);
        $('#showingTo').text(pagination.showing_to);
        $('#totalRecords').text(pagination.total_records);
    }
    
    function updateSortIcons() {
        $('.sortable i').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');
        $(`.sortable[data-sort="${sortField}"] i`).removeClass('fa-sort').addClass(sortDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down');
    }
    
    function formatDate(dateString) {
        let date = new Date(dateString);
        return date.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }
    
    function formatTime(dateString) {
        let date = new Date(dateString);
        return date.toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        });
    }

    // Delete bill confirmation
    $(document).on('click', '.delete-bill', function(e) {
        e.preventDefault();
        var link = $(this).attr('href');
        var billNumber = $(this).data('bill');
        
        Swal.fire({
            title: 'بل ڈیلیٹ کریں؟',
            html: '<div style="text-align: right; direction: rtl;">' +
                  '<p>کیا آپ واقعی بل <strong>"' + billNumber + '"</strong> کو ڈیلیٹ کرنا چاہتے ہیں؟</p>' +
                  '<p style="color: #e74c3c;"><i class="fas fa-exclamation-triangle"></i> یہ عمل واپس نہیں ہو سکتا!</p>' +
                  '</div>',
            icon: 'warning',
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
    });
});
</script> 