<!-- Professional Bills Management Page -->
<div class="container-fluid">
    <!-- Enhanced Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 page-header-mobile">
        <div>
            <h2 class="mb-1 d-none d-md-block">Bills Management</h2>
            <div class="d-md-none mb-1 fw-bold text-primary" style="display: flex; align-items: center; gap: 8px;">
                <h4 class="mb-0 fw-bold text-primary" style="font-size:1.1rem;">Bills</h4>
                <span class="stats-number mb-0" id="mobileTotalBills" style="font-size:1.1rem;">0</span>
                <span class="stats-label mb-0" style="font-size:0.9rem;">Total Bills</span>
            </div>
            <p class="text-muted mb-0 small d-none d-md-block">Manage and track all your bills</p>
        </div>
        <div class="d-flex gap-2">
            <!-- Desktop Create Button -->
            <a href="<?php echo base_url('billing/create'); ?>" class="btn btn-primary d-none d-md-inline-flex align-items-center">
                <i class="fas fa-plus me-2"></i>
                <span class="d-none d-lg-inline">Create New Bill</span>
                <span class="d-lg-none">New Bill</span>
            </a>
        </div>
    </div>

    <!-- Floating Action Button for Mobile -->
    <div class="d-md-none">
        <a href="<?php echo base_url('billing/create'); ?>" class="mobile-fab">
            <i class="fas fa-plus"></i>
        </a>
    </div>

    <!-- Desktop Filters and Search -->
    <div class="d-none d-md-block">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Header with Quick Actions -->
    <div class="d-md-none mobile-header-sticky">
        <!-- <div class="mobile-quick-stats bg-white border-bottom p-3">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="stats-item">
                        <div class="stats-number" id="mobileTotalBills">0</div>
                        <div class="stats-label">Total Bills</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stats-item text-end">
                        <div class="stats-number" id="mobileTotalAmount">Rs 0</div>
                        <div class="stats-label">Total Amount</div>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="mobile-actions-bar bg-light p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" id="mobileSearchToggle">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" id="mobileFilterToggle">
                        <i class="fas fa-filter"></i>
                        <span class="badge badge-sm bg-primary ms-1" id="filterBadge" style="display: none;">0</span>
                        </button>
                    </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success btn-sm" id="mobileExportBtn">
                        <i class="fas fa-download"></i>
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="mobileSortDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-sort"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-sort="created_at" data-dir="desc">
                                <i class="fas fa-clock me-2"></i>Newest First
                            </a></li>
                            <li><a class="dropdown-item" href="#" data-sort="created_at" data-dir="asc">
                                <i class="fas fa-history me-2"></i>Oldest First
                            </a></li>
                            <li><a class="dropdown-item" href="#" data-sort="total_amount" data-dir="desc">
                                <i class="fas fa-rupee-sign me-2"></i>Highest Amount
                            </a></li>
                            <li><a class="dropdown-item" href="#" data-sort="total_amount" data-dir="asc">
                                <i class="fas fa-rupee-sign me-2"></i>Lowest Amount
                            </a></li>
                        </ul>
                </div>
            </div>
        </div>
    </div>

        <!-- Collapsible Mobile Search Panel -->
        <div class="mobile-search-panel  border-bottom" id="mobileSearchPanel" style="display: none;">
            <div class="p-3">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="mobileSearchInput" placeholder="Search bills...">
                    <button class="btn btn-primary" type="button" id="mobileSearchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <input type="date" class="form-control form-control-sm" id="mobileFromDate" value="<?php echo date('Y-m-01'); ?>">
                    </div>
                    <div class="col-6">
                        <input type="date" class="form-control form-control-sm" id="mobileToDate" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button class="btn btn-outline-secondary btn-sm flex-fill" id="mobileQuickFilterBtn">
                        <i class="fas fa-bolt me-1"></i>Quick Filter
                    </button>
                    <button class="btn btn-outline-danger btn-sm" id="mobileResetBtn">
                        <i class="fas fa-undo"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Filter Chips -->
        <div class="mobile-filter-chips px-3 py-2 bg-light" id="mobileFilterChips" style="display: none;">
            <div class="d-flex gap-2 overflow-auto">
                <span class="badge bg-primary filter-chip" data-action="today">Today</span>
                <span class="badge bg-info filter-chip" data-action="week">This Week</span>
                <span class="badge bg-success filter-chip" data-action="month">This Month</span>
                <span class="badge bg-secondary filter-chip" data-action="custom">Custom Range</span>
            </div>
        </div>
    </div>

    <!-- Desktop Table & Enhanced Mobile Cards -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 d-none d-md-block">Bills List</h5>
            <h6 class="mb-0 d-md-none">
                <i class="fas fa-receipt me-2"></i>Your Bills
            </h6>
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
            </div>
        </div>

        <!-- Desktop Table View -->
        <div class="d-none d-md-block">
        <div class="card-body p-0 width-100">
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

        <!-- Enhanced Mobile Card View -->
        <div class="d-md-none">
            <!-- Mobile Bills Container with Pull to Refresh -->
            <div class="mobile-bills-container" id="mobileBillsContainer">
                <!-- Bills will be loaded here -->
                </div>

            <!-- Enhanced Mobile Loading State -->
            <div id="mobileLoading" class="text-center py-5 d-none">
                <div class="mobile-loading-animation">
                    <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="loading-text">
                        <h6 class="text-primary mb-1">Loading Bills</h6>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 100%"></div>
                        </div>
                </div>
                </div>
            </div>

            <!-- Mobile Empty State -->
            <div id="mobileEmptyState" class="text-center py-5 d-none">
                <div class="empty-state-icon mb-4">
                    <i class="fas fa-receipt fa-4x text-muted"></i>
                </div>
                <h5 class="text-muted mb-2">No Bills Found</h5>
                <p class="text-muted small mb-4">Start by creating your first bill</p>
                <a href="<?php echo base_url('billing/create'); ?>" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Create New Bill
                </a>
            </div>

            <!-- Mobile Pagination -->
            <div class="mobile-pagination-container d-none" id="mobilePaginationContainer">
                <div class="d-flex justify-content-center p-3 bg-light">
                    <nav aria-label="Mobile pagination">
                        <ul class="pagination pagination-sm mb-0" id="mobilePagination">
                            <!-- Mobile pagination will be generated here -->
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Pull to Refresh Indicator -->
            <div class="pull-to-refresh-indicator text-center py-2 d-none" id="pullToRefreshIndicator">
                <i class="fas fa-arrow-down text-muted me-2"></i>
                <span class="text-muted small">Pull to refresh</span>
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
/* Complete Mobile UX Overhaul */

/* Mobile Header Styles */
@media (max-width: 767.98px) {
    .mobile-header-sticky {
        position: sticky;
        top: 0;
        z-index: 1020;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .mobile-quick-stats {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .stats-item {
        text-align: center;
    }

    .stats-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #20c997;
        line-height: 1.2;
    }

    .stats-label {
        font-size: 0.75rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .mobile-actions-bar {
        border-top: 1px solid #dee2e6;
        border-bottom: 1px solid #dee2e6;
    }

    /* Enhanced Mobile Bill Cards */
    .mobile-bill-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        margin-bottom: 16px;
        border: none;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }

    .mobile-bill-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }

    .mobile-bill-card.pressed {
        transform: scale(0.98);
        transition: transform 0.1s ease;
    }

    .bill-card-header {
        background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%);
        color: white;
        padding: 12px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .bill-number-large {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
    }

    .bill-amount-large {
        font-size: 1.2rem;
        font-weight: 700;
        margin: 0;
    }

    .bill-card-body {
        padding: 16px;
    }

    .bill-customer-info {
        margin-bottom: 12px;
    }

    .customer-name-mobile {
        font-size: 1rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 4px;
    }

    .customer-phone-mobile {
        font-size: 0.85rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .bill-meta-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f8f9fa;
    }

    .bill-date-mobile {
        font-size: 0.8rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .bill-items-count {
        background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        color: #495057;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .bill-card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    .bill-action-btn {
        padding: 10px 12px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .bill-action-btn.view {
        background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%);
        color: white;
    }

    .bill-action-btn.edit {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        color: white;
    }

    .bill-action-btn.pdf {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }

    .bill-action-btn.delete {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
        color: white;
    }

    .bill-action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .bill-action-btn:active {
        transform: translateY(0);
    }

    /* Mobile Search Panel */
    .mobile-search-panel {
        animation: slideDown 0.3s ease-out;
    }

    .mobile-filter-chips {
        animation: slideUp 0.3s ease-out;
    }

    /* Filter Chips */
    .filter-chip {
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
        font-size: 0.75rem;
        padding: 6px 12px;
    }

    .filter-chip:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .filter-chip.active {
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    /* Mobile Loading Animation */
    .mobile-loading-animation {
        animation: pulse 2s infinite;
    }

    .loading-text {
        animation: fadeIn 0.5s ease-out;
    }

    /* Pull to Refresh */
    .pull-to-refresh-indicator {
        animation: bounce 1s infinite;
    }

    /* Mobile Pagination */
    .mobile-pagination-container {
        border-top: 1px solid #dee2e6;
        background: #f8f9fa;
    }

    /* Enhanced Button Styles for Mobile */
    .btn {
        border-radius: 12px !important;
        font-weight: 600 !important;
        transition: all 0.2s ease !important;
    }

    .btn:active {
        transform: scale(0.98) !important;
    }

    /* Form Controls for Mobile */
    .form-control {
        border-radius: 12px !important;
        border: 2px solid #e9ecef !important;
        font-size: 1rem !important;
        padding: 12px 16px !important;
    }

    .form-control:focus {
        border-color: #20c997 !important;
        box-shadow: 0 0 0 0.2rem rgba(32, 201, 151, 0.25) !important;
        transform: translateY(-1px) !important;
    }

    /* Empty State */
    .empty-state-icon {
        opacity: 0.6;
        animation: float 3s ease-in-out infinite;
    }

    /* Animations */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-4px);
        }
        60% {
            transform: translateY(-2px);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    /* Mobile Scroll Improvements */
    .mobile-bills-container {
        width: 100%;
        padding: 16px;
        min-height: calc(100vh - 200px);
    }

    /* Touch Feedback */
    .touch-feedback {
        position: relative;
        overflow: hidden;
    }

    .touch-feedback:active::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: translate(-50%, -50%);
        animation: ripple 0.6s linear;
    }

    @keyframes ripple {
        to {
            width: 300px;
            height: 300px;
            opacity: 0;
        }
    }

    /* Floating Action Button */
    .mobile-fab {
        position: fixed;
        bottom: 100px;
        right: 20px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: 0 4px 16px rgba(32, 201, 151, 0.4);
        z-index: 1030;
        transition: all 0.3s ease;
        font-size: 1.2rem;
    }

    .mobile-fab:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(32, 201, 151, 0.6);
        color: white;
        text-decoration: none;
    }

    .mobile-fab:active {
        transform: scale(0.95);
    }

    /* Mobile Specific Improvements */
    body {
        padding-bottom: 120px; /* Space for mobile navigation and FAB */
    }

    .container-fluid {
        padding-left: 8px;
        padding-right: 8px;
    }

    /* Enhanced Mobile Layout */
    .mobile-actions-bar .btn {
        padding: 8px 16px;
        font-size: 0.9rem;
    }

    .mobile-actions-bar .btn i {
        font-size: 1rem;
    }

    /* Mobile Search Panel Enhancements */
    .mobile-search-panel .form-control {
        margin-bottom: 8px;
    }

    /* Active States */
    #mobileSearchToggle.active {
        background-color: #20c997 !important;
        border-color: #20c997 !important;
    }

    #mobileFilterToggle.active {
        background-color: #20c997 !important;
        border-color: #20c997 !important;
    }

    /* Mobile Modal Improvements */
    .modal-content {
        border-radius: 16px;
        border: none;
        margin: 16px;
    }

    .modal-header {
        border-radius: 16px 16px 0 0;
        padding: 20px;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 20px;
        border-radius: 0 0 16px 16px;
    }
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
        background: linear-gradient(135deg, #20c997 0%, #20c997 100%) !important;
        border: none !important;
        box-shadow: 0 3px 8px rgba(0,123,255,0.25) !important;
        border-radius: 50px !important;
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        padding: 0.625rem !important;
        transition: all 0.3s ease !important;
        position: fixed !important;
        bottom: 4.5rem !important; /* Position above bottom navigation */
        right: 15px !important;
        z-index: 1040 !important;
        width: 48px !important;
        height: 48px !important;
    }

    .mobile-create-btn:hover {
        transform: translateY(-2px) scale(1.03) !important;
        box-shadow: 0 5px 15px rgba(0,123,255,0.35) !important;
        background: linear-gradient(135deg, #0056b3 0%, #004085 100%) !important;
    }

    .mobile-create-btn:active {
        transform: translateY(0px) scale(1.01) !important;
    }

    .mobile-create-btn i {
        font-size: 0.9rem !important;
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
    
    // Mobile UX Variables
    let isSearchPanelOpen = false;
    let isFilterPanelOpen = false;
    let pullToRefreshEnabled = false;

    // Load initial data with enhanced mobile UX
    console.log('Loading bills page with enhanced mobile UX...');

    // Initialize mobile features
    initializeMobileUX();
    
    // Use fallback initially, AJAX for filtering
    loadBillsFallback();

    function initializeMobileUX() {
        // Mobile Search Toggle
        $('#mobileSearchToggle').click(function() {
            toggleMobileSearch();
        });

        // Mobile Filter Toggle
        $('#mobileFilterToggle').click(function() {
            toggleMobileFilters();
        });

        // Mobile Search Button
        $('#mobileSearchBtn').click(function() {
            performMobileSearch();
        });

        // Mobile Quick Filter
        $('#mobileQuickFilterBtn').click(function() {
            applyMobileQuickFilter();
        });

        // Mobile Reset
        $('#mobileResetBtn').click(function() {
            resetMobileFilters();
        });

        // Filter Chips
        $('.filter-chip').click(function() {
            applyFilterChip($(this));
        });

        // Mobile Sort Dropdown
        $('#mobileSortDropdown .dropdown-item').click(function() {
            applyMobileSort($(this));
        });

        // Pull to Refresh for Mobile
        initializePullToRefresh();

        // Enhanced touch feedback
        $(document).on('touchstart', '.mobile-bill-card', function() {
            $(this).addClass('pressed');
        });

        $(document).on('touchend', '.mobile-bill-card', function() {
            $(this).removeClass('pressed');
        });
    }

    function toggleMobileSearch() {
        if (isSearchPanelOpen) {
            $('#mobileSearchPanel').slideUp(300);
            $('#mobileSearchToggle').removeClass('active');
            isSearchPanelOpen = false;
        } else {
            $('#mobileSearchPanel').slideDown(300);
            $('#mobileSearchToggle').addClass('active');
            // Close filter panel if open
            if (isFilterPanelOpen) {
                toggleMobileFilters();
            }
            isSearchPanelOpen = true;
        }
    }

    function toggleMobileFilters() {
        if (isFilterPanelOpen) {
            $('#mobileFilterChips').slideUp(300);
            $('#mobileFilterToggle').removeClass('active');
            isFilterPanelOpen = false;
        } else {
            $('#mobileFilterChips').slideDown(300);
            $('#mobileFilterToggle').addClass('active');
            // Close search panel if open
            if (isSearchPanelOpen) {
                toggleMobileSearch();
            }
            isFilterPanelOpen = true;
        }
    }

    function performMobileSearch() {
        let searchTerm = $('#mobileSearchInput').val();
        let fromDate = $('#mobileFromDate').val();
        let toDate = $('#mobileToDate').val();

        $('#searchInput').val(searchTerm);
        $('#fromDate').val(fromDate);
        $('#toDate').val(toDate);

        currentPage = 1;
        loadBills();

        // Close search panel
        toggleMobileSearch();

        toastr.success('Search applied successfully');
    }

    function applyMobileQuickFilter() {
        let fromDate = $('#mobileFromDate').val();
        let toDate = $('#mobileToDate').val();

        $('#fromDate').val(fromDate);
        $('#toDate').val(toDate);

        currentPage = 1;
        loadBills();

        toggleMobileSearch();
        toastr.info('Quick filter applied');
    }

    function resetMobileFilters() {
        $('#mobileSearchInput').val('');
        $('#mobileFromDate').val('<?php echo date('Y-m-01'); ?>');
        $('#mobileToDate').val('<?php echo date('Y-m-d'); ?>');

        $('#searchInput').val('');
        $('#fromDate').val('<?php echo date('Y-m-01'); ?>');
        $('#toDate').val('<?php echo date('Y-m-d'); ?>');

        currentPage = 1;
        loadBills();

        toggleMobileSearch();
        toastr.success('Filters reset');
    }

    function applyFilterChip($chip) {
        let action = $chip.data('action');
        $('.filter-chip').removeClass('active');

        switch(action) {
            case 'today':
                let today = new Date().toISOString().split('T')[0];
                $('#fromDate').val(today);
                $('#toDate').val(today);
                $('#mobileFromDate').val(today);
                $('#mobileToDate').val(today);
                break;
            case 'week':
                let weekStart = new Date();
                weekStart.setDate(weekStart.getDate() - weekStart.getDay());
                let weekEnd = new Date(weekStart);
                weekEnd.setDate(weekStart.getDate() + 6);
                $('#fromDate').val(weekStart.toISOString().split('T')[0]);
                $('#toDate').val(weekEnd.toISOString().split('T')[0]);
                $('#mobileFromDate').val(weekStart.toISOString().split('T')[0]);
                $('#mobileToDate').val(weekEnd.toISOString().split('T')[0]);
                break;
            case 'month':
                let monthStart = new Date(new Date().getFullYear(), new Date().getMonth(), 1);
                let monthEnd = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0);
                $('#fromDate').val(monthStart.toISOString().split('T')[0]);
                $('#toDate').val(monthEnd.toISOString().split('T')[0]);
                $('#mobileFromDate').val(monthStart.toISOString().split('T')[0]);
                $('#mobileToDate').val(monthEnd.toISOString().split('T')[0]);
                break;
            case 'custom':
                // Open custom range modal
                $('#customRangeModal').modal('show');
                return;
        }

        $chip.addClass('active');
        currentPage = 1;
        loadBills();

        toastr.info('Filter applied: ' + $chip.text());
    }

    function applyMobileSort($item) {
        let sortBy = $item.data('sort');
        let direction = $item.data('dir');

        sortField = sortBy;
        sortDirection = direction;

        currentPage = 1;
        loadBills();

        // Update dropdown text
        $('#mobileSortDropdown .btn').html('<i class="fas fa-sort"></i> ' + $item.text());

        toastr.info('Sorted by: ' + $item.text());
    }

    function initializePullToRefresh() {
        let startY = 0;
        let currentY = 0;
        let isPulling = false;

        $(document).on('touchstart', '.mobile-bills-container', function(e) {
            if ($(window).scrollTop() === 0) {
                startY = e.touches[0].clientY;
                pullToRefreshEnabled = true;
            }
        });

        $(document).on('touchmove', '.mobile-bills-container', function(e) {
            if (pullToRefreshEnabled && $(window).scrollTop() === 0) {
                currentY = e.touches[0].clientY;
                let pullDistance = currentY - startY;

                if (pullDistance > 50) {
                    e.preventDefault();
                    $('#pullToRefreshIndicator').show();
                    isPulling = true;
                }
            }
        });

        $(document).on('touchend', '.mobile-bills-container', function(e) {
            if (isPulling) {
                $('#pullToRefreshIndicator').hide();
                // Refresh the bills
                currentPage = 1;
                loadBills();
                toastr.info('Refreshing bills...');
                isPulling = false;
            }
            pullToRefreshEnabled = false;
        });
    }
    
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

                // Enhanced Mobile Card
                mobileHtml += `
                    <div class="mobile-bill-card touch-feedback" data-bill-id="${bill.id}">
                        <div class="bill-card-header">
                            <h6 class="bill-number-large">#${bill.bill_number}</h6>
                            <h6 class="bill-amount-large"><?php echo $settings['currency_symbol']; ?> ${parseFloat(bill.total_amount).toFixed(2)}</h6>
                                        </div>

                        <div class="bill-card-body">
                            <div class="bill-customer-info">
                                <div class="customer-name-mobile">
                                    <i class="fas fa-user me-2 text-muted"></i>${customerName}
                                        </div>
                                ${customerPhone ? `<div class="customer-phone-mobile">
                                    <i class="fas fa-phone"></i> ${customerPhone}
                                </div>` : ''}
                                        </div>

                            <div class="bill-meta-info">
                                <div class="bill-date-mobile">
                                    <i class="fas fa-calendar-alt"></i> ${new Date(bill.created_at).toLocaleDateString('en-GB')}
                                        </div>
                                <div class="bill-items-count">
                                    <i class="fas fa-box me-1"></i>${itemsCount}
                                    </div>
                                </div>

                            <div class="bill-card-actions">
                                <a href="<?php echo base_url('billing/view/'); ?>${bill.id}" class="bill-action-btn view">
                                    <i class="fas fa-eye"></i>
                                    <span>View</span>
                                </a>
                                <a href="<?php echo base_url('billing/edit/'); ?>${bill.id}" class="bill-action-btn edit">
                                    <i class="fas fa-edit"></i>
                                    <span>Edit</span>
                                </a>
                                <a href="<?php echo base_url('billing/pdf/'); ?>${bill.id}" class="bill-action-btn pdf" target="_blank">
                                    <i class="fas fa-download"></i>
                                    <span>PDF</span>
                                </a>
                                <a href="<?php echo base_url('billing/delete/'); ?>${bill.id}" class="bill-action-btn delete delete-bill" data-bill="${bill.bill_number}">
                                    <i class="fas fa-trash"></i>
                                    <span>Delete</span>
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        $('#billsTableBody').html(tableHtml);
        $('#mobileBillsContainer').html(mobileHtml);

        // Update mobile stats
        updateMobileStats(bills);
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

        // Enhanced Mobile pagination
        let mobileHtml = '';

        if (pagination.total_pages > 1) {
            // Previous button
            mobileHtml += `<li class="page-item ${pagination.current_page <= 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${pagination.current_page - 1}" ${pagination.current_page <= 1 ? 'tabindex="-1" aria-disabled="true"' : ''}>
                <i class="fas fa-chevron-left"></i>
                </a>
            </li>`;

            // Page info
            mobileHtml += `<li class="page-item disabled">
                <span class="page-link">
                    <small class="text-muted">${pagination.current_page} of ${pagination.total_pages}</small>
                </span>
            </li>`;

            // Next button
            mobileHtml += `<li class="page-item ${pagination.current_page >= pagination.total_pages ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${pagination.current_page + 1}" ${pagination.current_page >= pagination.total_pages ? 'tabindex="-1" aria-disabled="true"' : ''}>
                <i class="fas fa-chevron-right"></i>
                </a>
            </li>`;
        }

        $('#mobilePagination').html(mobileHtml);

        // Show/hide pagination container
        if (pagination.total_pages > 1) {
            $('#mobilePaginationContainer').removeClass('d-none');
        } else {
            $('#mobilePaginationContainer').addClass('d-none');
        }

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

        // Update mobile stats if available
        if (pagination.total_amount) {
            $('#mobileTotalBills').text(pagination.total_records || 0);
            $('#mobileTotalAmount').text('<?php echo $settings['currency_symbol']; ?> ' + (pagination.total_amount || '0'));
        }
    }

    // Mobile-specific enhancements
    function updateMobileStats(bills) {
        let totalBills = bills.length;
        let totalAmount = 0;

        bills.forEach(bill => {
            totalAmount += parseFloat(bill.total_amount) || 0;
        });

        $('#mobileTotalBills').text(totalBills);
        $('#mobileTotalAmount').text('<?php echo $settings['currency_symbol']; ?> ' + totalAmount.toFixed(2));
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