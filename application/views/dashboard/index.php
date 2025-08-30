<div class="dashboard-page">
    <!-- Page Header -->
    <div class="dashboard-header mb-4">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="dashboard-title">Dashboard</h2>
                    <p class="dashboard-subtitle">websaaz solutions | <?php echo date('Y'); ?> Billing System</p>
                </div>
                <div class="col-auto">
                    <span class="current-time" id="current-time"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Key Stats -->
        <div class="row mb-4">
            <div class="col-12 col-md-6 mb-3">
                <div class="stat-card primary">
                    <div class="stat-icon">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-value"><?php echo isset($billing_stats['total_bills']) ? $billing_stats['total_bills'] : 0; ?></h3>
                        <p class="stat-label">Total Bills</p>
                        <small class="stat-change">📊 All time</small>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <div class="stat-card success">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-value"><?php echo $today_bills_count ?? 0; ?></h3>
                        <p class="stat-label">Today's Bills</p>
                        <small class="stat-change">📅 <?php echo $settings['currency_symbol'] . ' ' . number_format($daily_sales, 2); ?> sales</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="quick-actions-card">
                    <div class="quick-actions-header">
                        <h5 class="quick-actions-title">Quick Actions</h5>
                        <p class="quick-actions-subtitle">Frequently used functions</p>
                    </div>
                    <div class="quick-actions-grid">
                        <a href="<?php echo base_url('billing/create'); ?>" class="quick-action-item">
                            <div class="quick-action-icon">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <span class="quick-action-text">Create Bill</span>
                        </a>
                        <a href="<?php echo base_url('billing'); ?>" class="quick-action-item">
                            <div class="quick-action-icon">
                                <i class="fas fa-list"></i>
                            </div>
                            <span class="quick-action-text">View Bills</span>
                        </a>
                        <a href="<?php echo base_url('inventory'); ?>" class="quick-action-item">
                            <div class="quick-action-icon">
                                <i class="fas fa-boxes"></i>
                            </div>
                            <span class="quick-action-text">Manage Inventory</span>
                        </a>
                        <a href="<?php echo base_url('customer'); ?>" class="quick-action-item">
                            <div class="quick-action-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <span class="quick-action-text">Customers</span>
                        </a>
                        <a href="<?php echo base_url('settings'); ?>" class="quick-action-item">
                            <div class="quick-action-icon">
                                <i class="fas fa-cog"></i>
                            </div>
                            <span class="quick-action-text">Settings</span>
                        </a>
                        <a href="<?php echo base_url('inventory/add'); ?>" class="quick-action-item">
                            <div class="quick-action-icon">
                                <i class="fas fa-plus"></i>
                            </div>
                            <span class="quick-action-text">Add Item</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Dashboard Styles */
.dashboard-page {
    background-color: #f5f6fa;
    min-height: 100vh;
    padding: 20px 0;
}

.dashboard-header {
    background: #ffffff;
    color: #2c3e50;
    padding: 30px 0;
    border-radius: 8px;
    margin-bottom: 30px;
    border: 1px solid #e1e8ed;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.dashboard-title {
    font-weight: 700;
    margin: 0;
    font-size: 2.5rem;
}

.dashboard-subtitle {
    margin: 0;
    opacity: 0.9;
    font-size: 1.1rem;
}

.current-time {
    font-size: 1rem;
    background: #f8f9fa;
    color: #495057;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 500;
    border: 1px solid #dee2e6;
}

/* Stat Cards */
.stat-card {
    background: white;
    border-radius: 8px;
    padding: 25px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border: 1px solid #e1e8ed;
    display: flex;
    align-items: center;
    transition: all 0.2s ease;
    height: 110px;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.stat-card.primary {
    border-left: 5px solid #007bff;
}

.stat-card.success {
    border-left: 5px solid #28a745;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    font-size: 1.5rem;
}

.stat-card.primary .stat-icon {
    background: rgba(0, 123, 255, 0.1);
    color: #007bff;
}

.stat-card.success .stat-icon {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    color: #333;
}

.stat-label {
    font-size: 1.1rem;
    color: #666;
    margin: 5px 0;
    font-weight: 500;
}

.stat-change {
    color: #888;
    font-size: 0.9rem;
}

/* Quick Actions */
.quick-actions-card {
    background: white;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border: 1px solid #e1e8ed;
}

.quick-actions-header {
    text-align: center;
    margin-bottom: 30px;
}

.quick-actions-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
    margin: 0;
}

.quick-actions-subtitle {
    color: #666;
    margin: 5px 0 0 0;
}

.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
    max-width: 800px;
    margin: 0 auto;
}

.quick-action-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px 15px;
    background: #f8f9fa;
    border-radius: 6px;
    text-decoration: none;
    color: #495057;
    transition: all 0.2s ease;
    border: 1px solid #e9ecef;
}

.quick-action-item:hover {
    background: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border-color: #007bff;
    color: #007bff;
    text-decoration: none;
}

.quick-action-icon {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: #007bff;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
    font-size: 1.2rem;
    transition: all 0.2s ease;
}

.quick-action-item:hover .quick-action-icon {
    background: #0056b3;
    transform: scale(1.05);
}

.quick-action-text {
    font-weight: 500;
    font-size: 0.95rem;
    text-align: center;
}

/* Responsive Design */
@media (max-width: 767.98px) {
    .dashboard-page {
        padding: 10px 0;
    }

    .dashboard-header {
        padding: 20px 0;
        margin-bottom: 20px;
    }

    .dashboard-title {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .dashboard-subtitle {
        font-size: 0.9rem;
    }

    .current-time {
        font-size: 0.8rem;
        padding: 6px 12px;
    }

    .stat-card {
        padding: 20px;
        margin-bottom: 1rem;
        height: auto;
        min-height: 100px;
    }

    .stat-value {
        font-size: 1.8rem;
    }

    .stat-label {
        font-size: 1rem;
        margin: 5px 0 8px 0;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        margin-right: 15px;
    }

    .quick-actions-card {
        padding: 20px;
    }

    .quick-actions-title {
        font-size: 1.25rem;
        margin-bottom: 20px;
    }

    .quick-actions-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        max-width: none;
        margin: 0 auto;
    }

    .quick-action-item {
        padding: 15px 8px;
        min-height: 80px;
    }

    .quick-action-icon {
        width: 35px;
        height: 35px;
        margin-bottom: 8px;
        font-size: 1rem;
    }

    .quick-action-text {
        font-size: 0.85rem;
        line-height: 1.2;
    }

    /* Touch-friendly buttons */
    .btn {
        min-height: 44px;
        font-size: 1rem;
    }

    /* Better spacing */
    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
    }
}

/* Tablet Styles */
@media (min-width: 768px) and (max-width: 991.98px) {
    .dashboard-title {
        font-size: 2.2rem;
    }

    .stat-value {
        font-size: 2.2rem;
    }

    .quick-actions-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    .quick-action-item {
        padding: 18px 12px;
    }
}
</style>

<script>
// Update time every second
function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('en-US', {
        hour12: true,
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });
    const dateString = now.toLocaleDateString('en-US', {
        weekday: 'short',
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
    
    document.getElementById('current-time').innerHTML = `${dateString}<br>${timeString}`;
}

// Update time immediately and then every second
updateTime();
setInterval(updateTime, 1000);

// Add some interactive effects
$(document).ready(function() {
    // Animate stat cards on page load
    $('.stat-card').each(function(index) {
        $(this).css('opacity', '0');
        $(this).css('transform', 'translateY(30px)');
        
        setTimeout(() => {
            $(this).animate({
                opacity: 1
            }, 500);
            $(this).css('transform', 'translateY(0)');
        }, index * 100);
    });
    
    // Animate quick actions
    $('.quick-action-item').each(function(index) {
        $(this).css('opacity', '0');
        $(this).css('transform', 'translateY(20px)');
        
        setTimeout(() => {
            $(this).animate({
                opacity: 1
            }, 400);
            $(this).css('transform', 'translateY(0)');
        }, 500 + (index * 50));
    });
});
</script>