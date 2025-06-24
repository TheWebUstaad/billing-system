<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' : ''; ?>Billing System</title>
    
    <!-- Bootstrap CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="<?php echo base_url('assets/css/all.min.css'); ?>" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="<?php echo base_url('assets/css/dataTables.bootstrap5.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/responsive.bootstrap5.min.css'); ?>" rel="stylesheet">
    
    <!-- Toastr CSS -->
    <link href="<?php echo base_url('assets/css/toastr.min.css'); ?>" rel="stylesheet">
    
    <!-- SweetAlert2 CSS -->
    <link href="<?php echo base_url('assets/css/sweetalert2.min.css'); ?>" rel="stylesheet">
    
    <!-- Select2 CSS -->
    <link href="<?php echo base_url('assets/css/select2.min.css'); ?>" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    
    <!-- Bootstrap JS -->
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    
    <!-- DataTables JS -->
    <script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/dataTables.bootstrap5.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/dataTables.responsive.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/responsive.bootstrap5.min.js'); ?>"></script>
    
    <!-- Toastr JS -->
    <script src="<?php echo base_url('assets/js/toastr.min.js'); ?>"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="<?php echo base_url('assets/js/sweetalert2.min.js'); ?>"></script>
    
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #2c3e50;
            color: white;
            padding-top: 1rem;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.8rem 1rem;
        }
        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255,255,255,0.1);
        }
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.2);
            color: white;
        }
        .main-content {
            padding: 2rem;
        }
        .navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .shop-name {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c3e50;
        }
        
        /* Toast Notification Styling */
        .toast-top-right {
            top: 65px;
        }
        
        /* Select2 Fixes */
        .select2-container {
            width: 100% !important;
        }
        .select2-container .select2-selection--single {
            height: 38px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <!-- Load JavaScript libraries -->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/select2.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/toastr.min.js'); ?>"></script>

    <script>
    // Wait for all scripts to load
    window.addEventListener('load', function() {
        // Configure Toastr
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };
        
        // Set up CSRF token for AJAX requests
        $.ajaxSetup({
            beforeSend: function(xhr, settings) {
                if (!/^(GET|HEAD|OPTIONS|TRACE)$/i.test(settings.type)) {
                    xhr.setRequestHeader('X-CSRF-Token', '<?= $this->security->get_csrf_hash() ?>');
                }
            }
        });
        
        // Add CSRF token to all forms
        var csrf_token = '<?= $this->security->get_csrf_hash() ?>';
        var csrf_name = '<?= $this->security->get_csrf_token_name() ?>';
        
        $('form').each(function() {
            if (!$(this).find('input[name="' + csrf_name + '"]').length) {
                $(this).append('<input type="hidden" name="' + csrf_name + '" value="' + csrf_token + '">');
            }
        });
    });
    </script>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="text-center py-4">
                    <h4><?php echo $settings['shop_name']; ?></h4>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $this->uri->segment(1) == 'dashboard' ? 'active' : ''; ?>" href="<?php echo base_url('dashboard'); ?>">
                            <i class="fa fa-dashboard"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $this->uri->segment(1) == 'billing' ? 'active' : ''; ?>" href="<?php echo base_url('billing'); ?>">
                            <i class="fa fa-file-text"></i> Billing
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $this->uri->segment(1) == 'inventory' ? 'active' : ''; ?>" href="<?php echo base_url('inventory'); ?>">
                            <i class="fa fa-cubes"></i> Inventory
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $this->uri->segment(1) === 'customer' ? 'active' : ''; ?>" href="<?php echo site_url('customer'); ?>">
                            <i class="fa fa-users"></i> Customers
                        </a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link <?php echo $this->uri->segment(1) === 'settings' ? 'active' : ''; ?>" href="<?php echo site_url('settings'); ?>">
                            <i class="fa fa-cog"></i> Settings
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 px-0">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <span class="navbar-text shop-name">
                            <?php echo $settings['shop_name']; ?>
                        </span>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fa fa-user"></i> <?php echo $this->session->userdata('admin_name'); ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="<?php echo base_url('auth/logout'); ?>">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Page Content -->
                <div class="main-content">
</body>
</html> 