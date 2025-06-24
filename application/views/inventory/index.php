<!-- Professional Inventory Management Page -->
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Inventory Management</h2>
            <p class="text-muted mb-0">Manage your products and items</p>
        </div>
        <a href="<?php echo site_url('inventory/add'); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Item
        </a>
    </div>

    <!-- Search and Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <form action="<?php echo site_url('inventory/search'); ?>" method="get">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" 
                                   placeholder="Search by item name, SKU, or description..." 
                                   value="<?php echo $this->input->get('q'); ?>">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <?php if($this->input->get('q')): ?>
                                <a href="<?php echo site_url('inventory'); ?>" class="btn btn-outline-warning">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-flex justify-content-end align-items-center gap-3">
                        <div class="text-muted">
                            <i class="fas fa-box"></i> <?php echo count($items); ?> items found
                        </div>
                        <button class="btn btn-outline-success btn-sm" id="exportInventoryBtn">
                            <i class="fas fa-download me-1"></i>Export PDF
                        </button>
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

    <!-- Items Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Items List</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="20%" class="text-center">SKU</th>
                            <th width="40%" class="text-start">Item Name</th>
                            <th width="25%" class="text-end">Price</th>
                            <th width="15%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($items)): ?>
                            <?php foreach($items as $item): ?>
                                <tr>
                                    <td class="text-center">
                                        <span class="font-monospace text-primary"><?php echo $item->sku; ?></span>
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
                                        <div class="btn-group">
                                            <a href="<?php echo site_url('inventory/edit/'.$item->id); ?>" 
                                               class="btn btn-sm btn-outline-primary" title="Edit Item">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?php echo site_url('inventory/delete/'.$item->id); ?>" 
                                               class="btn btn-sm btn-outline-danger" 
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
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-box fa-3x mb-3"></i>
                                        <h5>No items found</h5>
                                        <p>Start by adding your first item to the inventory.</p>
                                        <a href="<?php echo site_url('inventory/add'); ?>" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Add First Item
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
.font-monospace {
    font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
}

.table th {
    border-top: none;
    font-weight: 600;
    background-color: #f8f9fa;
}

.btn-group .btn {
    margin-right: 0.25rem;
}

.alert {
    border: none;
    border-radius: 0.5rem;
}
</style>

<script>
$(document).ready(function() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
    
    // Search input focus
    $('input[name="q"]').focus();
    
    // Export inventory functionality
    $('#exportInventoryBtn').click(function() {
        let search = $('input[name="q"]').val();
        let exportUrl = '<?php echo site_url('inventory/export_pdf'); ?>';
        
        if (search) {
            exportUrl += '?search=' + encodeURIComponent(search);
        }
        
        console.log('Exporting inventory with URL:', exportUrl);
        window.open(exportUrl, '_blank');
    });
});
</script> 