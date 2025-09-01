<!-- Professional Bills Management Page -->
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 page-header-mobile">
        <div>
            <h2 class="mb-1 d-none d-md-block">Bills Management</h2>
            <h4 class="mb-1 d-md-none fw-bold text-primary">Bills</h4>
            <p class="text-muted mb-0 small">Manage and track all your bills</p>
        </div>
        <div class="d-flex gap-2">
            <!-- Mobile Create Button -->
            <a href="<?php echo base_url('billing/create'); ?>" class="btn btn-primary btn-lg d-md-none mobile-create-btn">
                <i class="fas fa-plus me-1"></i>
                <span class="fw-bold">Create Bill</span>
            </a>
            <!-- Desktop Create Button -->
            <a href="<?php echo base_url('billing/create'); ?>" class="btn btn-primary d-none d-md-inline-flex align-items-center">
                <i class="fas fa-plus me-2"></i>
                <span class="d-none d-lg-inline">Create New Bill</span>
                <span class="d-lg-none">New Bill</span>
            </a>
        </div>
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
                    <label class="form-label d-none d-md-block">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle flex-fill" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="false">
                                <i class="fas fa-filter me-1"></i>
                                <span class="d-none d-sm-inline">Filter</span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                <li><a class="dropdown-item filter-option" href="#" id="quickFilterBtn" data-action="quick">
                                    <i class="fas fa-bolt me-2"></i>Quick Filter
                                </a></li>
                                <li><a class="dropdown-item filter-option" href="#" id="customRangeBtn" data-action="custom">
                                    <i class="fas fa-calendar-alt me-2"></i>Custom Range
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item filter-option" href="#" id="todayFilterBtn" data-action="today">
                                    <i class="fas fa-calendar-day me-2"></i>Today
                                </a></li>
                                <li><a class="dropdown-item filter-option" href="#" id="thisWeekFilterBtn" data-action="week">
                                    <i class="fas fa-calendar-week me-2"></i>This Week
                                </a></li>
                                <li><a class="dropdown-item filter-option" href="#" id="thisMonthFilterBtn" data-action="month">
                                    <i class="fas fa-calendar me-2"></i>This Month
                                </a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm d-none d-md-inline-block" id="resetBtn" title="Reset Filters">
                            <i class="fas fa-refresh"></i>
                        </button>
                        <!-- Mobile Reset Button -->
                        <button type="button" class="btn btn-outline-secondary btn-sm d-md-none" id="mobileResetBtn" title="Reset Filters">
                            <i class="fas fa-refresh"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bills List - Desktop Table & Mobile Cards -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Bills List</h5>
            <div class="d-flex align-items-center gap-2">
                <div class="d-none d-md-flex align-items-center me-3">
                    <label class="form-label me-2 mb-0 small">Show:</label>
                    <select class="form-select form-select-sm" id="perPage" style="width: auto;">
                        <option value="10">10</option>
                        <option value="25" selected>25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <button class="btn btn-outline-success btn-sm d-none d-md-inline-block" id="exportBtn">
                    <i class="fas fa-download me-1"></i> Export PDF
                </button>
                <!-- Mobile Export Button -->
                <button class="btn btn-outline-success btn-sm d-md-none w-100 mt-2" id="mobileExportBtn">
                    <i class="fas fa-download me-1"></i> Export PDF
                </button>
            </div>
        </div>

        <!-- Desktop Table View -->
        <div class="d-none d-md-block">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="billsTable">
                    <thead class="table-light">
                        <tr>
                                <th class="text-start">Bill #</th>
                                <th class="text-start">Customer</th>
                                <th class="text-end">Amount</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Items</th>
                                <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="billsTableBody">
                        <!-- Dynamic content will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
        </div>

        <!-- Mobile Card View -->
        <div class="d-md-none">
            <div class="card-body">
                <div id="mobileBillsContainer" class="row g-3">
                    <!-- Mobile bill cards will be loaded here -->
                </div>
                <div id="mobileLoading" class="text-center py-4 d-none">
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="mt-2 text-muted small">Loading bills...</div>
                </div>
            </div>
        </div>

        <!-- Footer with pagination -->
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-muted small">
                    <span class="d-none d-md-inline">Showing </span>
                    <span id="showingFrom">1</span> to <span id="showingTo">25</span> of <span id="totalRecords">0</span> bills
                </div>
                <nav class="d-none d-md-block">
                    <ul class="pagination pagination-sm mb-0" id="pagination">
                        <!-- Pagination will be generated here -->
                    </ul>
                </nav>
                <!-- Mobile Pagination -->
                <div class="d-md-none w-100">
                    <div class="d-flex justify-content-center gap-2" id="mobilePagination">
                        <!-- Mobile pagination buttons -->
                    </div>
                </div>
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
/* Mobile Bill Cards */
@media (max-width: 767.98px) {
    .bill-card {
        border: 1px solid #dee2e6;
        border-radius: 12px;
        transition: all 0.2s ease;
        margin-bottom: 0.75rem;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .bill-card:hover {
        border-color: #20c997 ;
        box-shadow: 0 4px 12px rgba(0,123,255,0.2);
        transform: translateY(-2px);
    }

    .bill-number {
        font-size: 1.1rem;
        font-weight: 600;
    }

    .customer-name {
        font-size: 0.95rem;
        color: #495057;
        margin-bottom: 0.25rem;
    }

    .bill-amount .fw-bold {
        font-size: 1.2rem;
        line-height: 1.2;
        color: #28a745;
    }

    .bill-date {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .bill-actions {
        border-top: 1px solid #e9ecef !important;
        background: #f8f9fa;
        border-radius: 0 0 12px 12px;
    }

    .bill-actions .btn {
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
        min-height: 40px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .bill-actions .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }

    .bill-actions .btn i {
        font-size: 0.8rem;
    }

    /* Mobile pagination improvements */
    #mobilePagination {
        padding: 1rem 0;
        background: #f8f9fa;
        border-radius: 10px;
        margin: 1rem 0;
    }

    #mobilePagination .btn {
        min-width: 44px;
        height: 40px;
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-weight: 500;
    }

    #mobilePagination span {
        font-size: 0.85rem;
        min-width: 70px;
        font-weight: 600;
    }

    /* Mobile export button */
    #mobileExportBtn {
        border-radius: 10px;
        font-weight: 600;
        padding: 0.75rem 1.25rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
    }

    #mobileExportBtn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    /* Mobile loading state */
    #mobileLoading {
        padding: 2.5rem 1.5rem;
        text-align: center;
    }

    #mobileLoading .spinner-border-sm {
        width: 1.25rem;
        height: 1.25rem;
    }

    /* Mobile filter improvements */
    .dropdown-menu {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border: none;
        margin-top: 0.5rem;
    }

    .dropdown-item {
        padding: 0.75rem 1rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background: #f8f9fa;
        transform: translateX(2px);
    }

    .dropdown-item i {
        width: 16px;
        text-align: center;
    }

    /* Mobile header improvements */
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .page-header-mobile {
        padding: 1.5rem 0 !important;
        margin-bottom: 1.5rem !important;
        border-bottom: 2px solid #f8f9fa;
    }

    /* Mobile card spacing */
    .card {
        margin-bottom: 1.5rem !important;
    }

    /* Mobile search container */
    .input-group {
        box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
        border-radius: 12px !important;
        overflow: hidden !important;
    }

    /* Mobile date inputs styling */
    #fromDate, #toDate {
        border-radius: 10px !important;
        font-size: 0.9rem !important;
    }

    /* Mobile table improvements */
    .table-responsive {
        border-radius: 12px !important;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1) !important;
    }

    /* Mobile Create Bill Button */
    .mobile-create-btn {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(0,123,255,0.3) !important;
        border-radius: 12px !important;
        font-size: 0.9rem !important;
        font-weight: 600 !important;
        padding: 0.75rem 1.25rem !important;
        transition: all 0.3s ease !important;
        position: fixed !important;
        bottom: 20px !important;
        right: 20px !important;
        z-index: 1050 !important;
        min-width: 140px !important;
    }

    .mobile-create-btn:hover {
        transform: translateY(-3px) scale(1.05) !important;
        box-shadow: 0 8px 20px rgba(0,123,255,0.4) !important;
        background: linear-gradient(135deg, #0056b3 0%, #004085 100%) !important;
    }

    .mobile-create-btn:active {
        transform: translateY(-1px) scale(1.02) !important;
    }

    .mobile-create-btn i {
        font-size: 1rem !important;
        margin-bottom: 2px !important;
    }

    /* Adjust body padding for fixed button */
    body {
        padding-bottom: 80px !important;
    }

    /* Mobile Filter Dropdown Improvements */
    .dropdown-menu {
        border-radius: 12px !important;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15) !important;
        border: none !important;
        margin-top: 0.75rem !important;
        animation: slideDown 0.2s ease-out !important;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-item {
        padding: 0.875rem 1.25rem !important;
        font-weight: 500 !important;
        transition: all 0.2s ease !important;
        border-radius: 8px !important;
        margin: 2px 4px !important;
    }

    .dropdown-item:hover {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
        transform: translateX(3px) !important;
        color: #20c997  !important;
    }

    .dropdown-item i {
        width: 18px !important;
        text-align: center !important;
        font-size: 0.9rem !important;
    }

    /* Mobile Filter Button */
    #filterDropdown {
        border-radius: 10px !important;
        font-weight: 600 !important;
        transition: all 0.2s ease !important;
        min-height: 40px !important;
    }

    #filterDropdown:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
    }

    /* Mobile search improvements */
    #searchInput {
        border-radius: 10px;
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
    }

    #searchInput:focus {
        border-color: #20c997 ;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
    }

    /* Mobile date inputs */
    #fromDate, #toDate {
        border-radius: 8px;
        padding: 0.5rem;
    }

    /* Mobile button improvements */
    .btn {
        border-radius: 8px;
        font-weight: 500;
    }

    .btn-primary {
        background: linear-gradient(135deg,  #20c997 0%, #20c997 100%);
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #20c997 0%, #20c997 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    /* Mobile card header */
    .card-header {
        padding: 1rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #dee2e6;
    }

    .card-header h5 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #495057;
    }
}

/* General improvements */
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
    cursor: pointer;
    transition: all 0.2s ease;
}

.sortable:hover {
    color: #20c997 ;
    text-decoration: none;
}

.table th {
    border-top: none;
    font-weight: 600;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    position: sticky;
    top: 0;
    z-index: 10;
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

.badge {
    background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    color: #495057;
    font-weight: 500;
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
}

.action-buttons .btn {
    margin-right: 0.25rem;
    transition: all 0.2s ease;
    border-radius: 6px;
}

.action-buttons .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.15);
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

.no-results i {
    font-size: 3rem;
    color: #dee2e6;
    margin-bottom: 1rem;
}

.pagination .page-link {
    border-radius: 0.375rem;
    margin: 0 0.125rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.pagination .page-link:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #20c997 0%, #20c997 100%);
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.15);
}

/* Filter improvements */
#filterDropdown {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
}

#filterDropdown:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

#resetBtn, #mobileResetBtn {
    border-radius: 8px;
    transition: all 0.2s ease;
}

#resetBtn:hover, #mobileResetBtn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Search improvements */
#searchInput {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    transition: all 0.2s ease;
}

#searchInput:focus {
    border-color: #20c997 ;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
    transform: translateY(-1px);
}

#searchBtn {
    border-radius: 8px;
    transition: all 0.2s ease;
}

#searchBtn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Export button improvements */
#exportBtn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
}

#exportBtn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Responsive table improvements */
@media (max-width: 767.98px) {
    .table-responsive {
        font-size: 0.85rem;
        border-radius: 10px;
        overflow: hidden;
    }

    .table td, .table th {
        padding: 0.5rem 0.25rem;
        vertical-align: middle;
    }

    .table .btn-group-sm .btn {
        padding: 0.25rem 0.375rem;
        font-size: 0.75rem;
        border-radius: 4px;
    }

    /* Hide desktop table elements on mobile */
    .d-md-none .table-responsive {
        display: none !important;
    }

    .d-md-block .table-responsive {
        display: none !important;
    }
}

/* Loading animation improvements */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.bill-card, .table tbody tr {
    animation: fadeInUp 0.3s ease-out;
}

/* Toast notifications improvement */
.toast {
    border-radius: 10px;
    font-weight: 500;
}

/* Card improvements */
.card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    transform: translateY(-1px);
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
    border-bottom: 1px solid #dee2e6;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.card-body {
    border-radius: 0 0 12px 12px;
}

/* Form control improvements */
.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #20c997 ;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
    transform: translateY(-1px);
}

/* Modal improvements */
.modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.modal-header {
    border-radius: 12px 12px 0 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
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
    $('#resetBtn, #mobileResetBtn').click(function() {
        $('#searchInput').val('');
        $('#fromDate').val('<?php echo date('Y-m-01'); ?>');
        $('#toDate').val('<?php echo date('Y-m-d'); ?>');
        currentPage = 1;
        loadBills();

        // Show success message
        toastr.success('Filters have been reset');
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
    
    // Export functionality - Desktop and Mobile
    $('#exportBtn, #mobileExportBtn').click(function() {
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
    
    // Filter dropdown functionality - Close dropdown after selection
    $('.filter-option').click(function(e) {
        e.preventDefault();
        e.stopPropagation();

        // Close the dropdown properly using Bootstrap method
        const dropdown = $(this).closest('.dropdown');
        const dropdownToggle = dropdown.find('.dropdown-toggle');
        const dropdownMenu = dropdown.find('.dropdown-menu');

        // Hide dropdown menu
        dropdownMenu.removeClass('show');
        dropdownToggle.attr('aria-expanded', 'false');
        dropdown.removeClass('show');

        let action = $(this).data('action');

        switch(action) {
            case 'quick':
        // Use current form values and apply filter
        currentPage = 1;
        loadBills();
                toastr.info('Applying current filters...');
                break;
    
            case 'custom':
        // Pre-fill modal with current values
        let currentFromDate = $('#fromDate').val() || '<?php echo date('Y-m-01'); ?>';
        let currentToDate = $('#toDate').val() || '<?php echo date('Y-m-d'); ?>';
        
        $('#filterFromDate').val(currentFromDate);
        $('#filterToDate').val(currentToDate);
        
        $('#customRangeModal').modal('show');
                break;

            case 'today':
                let today = new Date().toISOString().split('T')[0];
                $('#fromDate').val(today);
                $('#toDate').val(today);
                currentPage = 1;
                loadBills();
                toastr.info('Showing today\'s bills');
                break;

            case 'week':
                let today_week = new Date();
                let firstDay = new Date(today_week.setDate(today_week.getDate() - today_week.getDay()));
                let lastDay = new Date(today_week.setDate(today_week.getDate() - today_week.getDay() + 6));

                $('#fromDate').val(firstDay.toISOString().split('T')[0]);
                $('#toDate').val(lastDay.toISOString().split('T')[0]);
                currentPage = 1;
                loadBills();
                toastr.info('Showing this week\'s bills');
                break;

            case 'month':
                let today_month = new Date();
                let firstDay_month = new Date(today_month.getFullYear(), today_month.getMonth(), 1);
                let lastDay_month = new Date(today_month.getFullYear(), today_month.getMonth() + 1, 0);

                $('#fromDate').val(firstDay_month.toISOString().split('T')[0]);
                $('#toDate').val(lastDay_month.toISOString().split('T')[0]);
                currentPage = 1;
                loadBills();
                toastr.info('Showing this month\'s bills');
                break;
        }
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
        let tableHtml = '';
        let mobileHtml = '';
        
        if (bills.length === 0) {
            tableHtml = '<tr><td colspan="6" class="text-center py-4"><div class="text-muted"><i class="fas fa-inbox fa-2x mb-2"></i><br>No bills found</div></td></tr>';
            mobileHtml = '<div class="col-12"><div class="text-center py-5"><div class="text-muted"><i class="fas fa-inbox fa-3x mb-3"></i><h5>No bills found</h5><p>Start by creating your first bill</p></div></div></div>';
        } else {
            bills.forEach(function(bill) {
                let itemsCount = bill.items ? bill.items.length : 0;
                let customerName = bill.customer_name || 'Walk-in Customer';
                let customerPhone = bill.customer_phone || '';
                
                // Desktop Table Row
                tableHtml += `
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
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="small">${formatDate(bill.created_at)}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark">${itemsCount}</span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo base_url('billing/view/'); ?>${bill.id}" class="btn btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo base_url('billing/edit/'); ?>${bill.id}" class="btn btn-outline-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo base_url('billing/pdf/'); ?>${bill.id}" class="btn btn-outline-success" target="_blank" title="PDF">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                `;

                // Mobile Card
                mobileHtml += `
                    <div class="col-12">
                        <div class="card bill-card h-100">
                            <div class="card-body p-3">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <div class="bill-number mb-1">
                                            <strong class="text-primary">#${bill.bill_number}</strong>
                                        </div>
                                        <div class="customer-info mb-2">
                                            <div class="customer-name fw-medium">${customerName}</div>
                                            ${customerPhone ? `<small class="text-muted"><i class="fas fa-phone me-1"></i>${customerPhone}</small>` : ''}
                                        </div>
                                        <div class="bill-date small text-muted">
                                            <i class="fas fa-calendar me-1"></i>${formatDate(bill.created_at)}
                                        </div>
                                        <div class="bill-amount mb-2 mt-2">
                                            <div class="fw-bold text-success fs-6"><?php echo $settings['currency_symbol']; ?> ${parseFloat(bill.total_amount).toFixed(2)}</div>
                                            <small class="text-muted">${itemsCount} items</small>
                                        </div>
                                    </div>
                                  
                                </div>
                                <div class="bill-actions mt-3 pt-2 border-top">
                                    <div class="row g-1">
                                        <div class="col-4">
                                            <a href="<?php echo base_url('billing/view/'); ?>${bill.id}" class="btn btn-primary btn-sm w-100" style="background-color: #20c997;"    >
                                                <i class="fas fa-eye me-1"></i>View
                                            </a>
                                        </div>
                                        <div class="col-4">
                                            <a href="<?php echo base_url('billing/edit/'); ?>${bill.id}" class="btn btn-outline-secondary btn-sm w-100" style="background-color: #20c997;"   >
                                                <i class="fas fa-edit me-1"></i>Edit
                                            </a>
                                        </div>
                                        <div class="col-4">
                                            <a href="<?php echo base_url('billing/pdf/'); ?>${bill.id}" class="btn btn-outline-success btn-sm w-100" target="_blank" style="background-color: #20c997;">
                                                <i class="fas fa-download me-1"></i>PDF
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        $('#billsTableBody').html(tableHtml);
        $('#mobileBillsContainer').html(mobileHtml);
    }
    
    function renderPagination(pagination) {
        // Desktop pagination
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

        // Mobile pagination (simplified)
        let mobileHtml = '';

        if (pagination.total_pages > 1) {
            // Previous button
            mobileHtml += `<button class="btn btn-outline-primary btn-sm ${pagination.current_page <= 1 ? 'disabled' : ''}"
                            data-page="${pagination.current_page - 1}" ${pagination.current_page <= 1 ? 'disabled' : ''}>
                <i class="fas fa-chevron-left"></i>
            </button>`;

            // Current page indicator
            mobileHtml += `<span class="px-3 py-1 bg-primary text-white rounded small fw-medium">
                ${pagination.current_page} of ${pagination.total_pages}
            </span>`;

            // Next button
            mobileHtml += `<button class="btn btn-outline-primary btn-sm ${pagination.current_page >= pagination.total_pages ? 'disabled' : ''}"
                            data-page="${pagination.current_page + 1}" ${pagination.current_page >= pagination.total_pages ? 'disabled' : ''}>
                <i class="fas fa-chevron-right"></i>
            </button>`;
        }

        $('#mobilePagination').html(mobileHtml);

        // Add click handlers for mobile pagination
        $('#mobilePagination .btn').off('click').on('click', function(e) {
            e.preventDefault();
            if (!$(this).hasClass('disabled')) {
                let page = $(this).data('page');
                if (page && page !== currentPage) {
                    currentPage = page;
                    loadBills();
                }
            }
        });
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

    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdown').length) {
            $('.dropdown-menu').removeClass('show');
            $('.dropdown-toggle').attr('aria-expanded', 'false');
            $('.dropdown').removeClass('show');
        }
    });

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