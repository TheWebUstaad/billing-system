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
</body>
</html> 