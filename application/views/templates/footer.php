                </div> <!-- End of main-content -->
            </div> <!-- End of col-md-9 -->
        </div> <!-- End of row -->
        
        <!-- Footer -->
        <div class="row mt-4">
            <div class="col-12">
                <hr class="my-3">
                <div class="text-center">
                    <small class="text-muted">
                        © <?php echo date('Y'); ?> Billing System | Developed by 
                        <a href="https://www.facebook.com/websaazsolution/" target="_blank" class="text-decoration-none fw-bold" style="color: #1877f2;">
                            Websaaz Solutions
                        </a>
                    </small>
                </div>
            </div>
        </div>
    </div> <!-- End of container-fluid -->

    <!-- Mobile Bottom Tab Navigation -->
    <nav class="mobile-bottom-nav d-md-none">
        <div class="nav-container">
            <a href="<?php echo base_url('dashboard'); ?>" class="nav-item <?php echo $this->uri->segment(1) == 'dashboard' ? 'active' : ''; ?>">
                <i class="fa fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="<?php echo base_url('billing'); ?>" class="nav-item <?php echo $this->uri->segment(1) == 'billing' ? 'active' : ''; ?>">
                <i class="fa fa-file-invoice-dollar"></i>
                <span>Billing</span>
            </a>
            <a href="<?php echo base_url('inventory'); ?>" class="nav-item <?php echo $this->uri->segment(1) == 'inventory' ? 'active' : ''; ?>">
                <i class="fa fa-boxes"></i>
                <span>Inventory</span>
            </a>
            <a href="<?php echo site_url('customer'); ?>" class="nav-item <?php echo $this->uri->segment(1) === 'customer' ? 'active' : ''; ?>">
                <i class="fa fa-users"></i>
                <span>Customers</span>
            </a>
            <a href="<?php echo site_url('settings'); ?>" class="nav-item <?php echo $this->uri->segment(1) === 'settings' ? 'active' : ''; ?>">
                <i class="fa fa-cog"></i>
                <span>Settings</span>
            </a>
        </div>
    </nav>

    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/sweetalert2.min.js'); ?>"></script>
    
    <?php if($this->session->flashdata('success')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '<?php echo $this->session->flashdata('success'); ?>',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
    <?php endif; ?>

    <?php if($this->session->flashdata('error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?php echo $this->session->flashdata('error'); ?>',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
    <?php endif; ?>

    <?php if($this->session->flashdata('password_success')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Password Changed',
            text: '<?php echo $this->session->flashdata('password_success'); ?>',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
    <?php endif; ?>

    <?php if($this->session->flashdata('password_error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Password Change Failed',
            text: '<?php echo $this->session->flashdata('password_error'); ?>',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
    <?php endif; ?>
</body>
</html> 