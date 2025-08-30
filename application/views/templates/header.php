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

        /* Mobile Responsive Styles */
        @media (max-width: 767.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                width: 280px;
                height: 100vh;
                z-index: 1050;
                transition: left 0.3s ease-in-out;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                padding: 1rem;
            }

            .mobile-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.5);
                z-index: 1040;
                display: none;
            }

            .mobile-overlay.show {
                display: block;
            }

            .navbar-toggler {
                border: none;
                padding: 0.5rem;
            }

            .navbar-toggler:focus {
                box-shadow: none;
            }

            .shop-name {
                font-size: 1rem;
            }

            .stat-card {
                margin-bottom: 1rem;
            }

            .quick-action-item {
                padding: 1rem !important;
                margin-bottom: 0.5rem;
            }

            .btn {
                min-height: 44px;
                font-size: 1rem;
            }

            .form-control {
                min-height: 44px;
                font-size: 1rem;
            }

            .table-responsive {
                font-size: 0.9rem;
            }

            .table td, .table th {
                padding: 0.5rem;
            }
        }

        /* Tablet Styles */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                padding: 1.5rem;
            }
        }

        /* RTL Support for Urdu */
        @media (max-width: 767.98px) {
            .rtl-text {
                direction: rtl;
                text-align: right;
            }

            .mobile-item-details .form-control {
                text-align: right;
            }

            .suggestion-item {
                text-align: right;
            }

            .navbar-toggler {
                margin-left: auto;
                margin-right: 0;
            }

            .dropdown-menu {
                left: auto;
                right: 0;
            }
        }

        /* Additional Mobile Enhancements */
        @media (max-width: 767.98px) {
            /* Better form field spacing */
            .form-group {
                margin-bottom: 1rem;
            }

            /* Improved table readability */
            .table-responsive .table {
                font-size: 0.875rem;
            }

            /* Better modal experience on mobile */
            .modal-dialog {
                margin: 0.5rem;
            }

            .modal-content {
                border-radius: 0.5rem;
            }

            /* Touch-friendly select elements */
            .select2-container--default .select2-selection--single {
                min-height: 44px !important;
                padding: 0.375rem 0.75rem;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 32px;
                font-size: 1rem;
            }

            /* Better spacing for alerts */
            .alert {
                margin-bottom: 1rem;
                padding: 0.75rem 1rem;
            }

            /* Improved card spacing */
            .card {
                margin-bottom: 1rem;
                border-radius: 0.5rem;
            }

            .card-body {
                padding: 1.25rem;
            }
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

        // Mobile Menu Toggle Functionality
        $('#mobile-menu-toggle').on('click', function() {
            $('#sidebar').toggleClass('show');
            $('#mobile-overlay').toggleClass('show');
            $('body').toggleClass('sidebar-open');
        });

        $('#mobile-overlay').on('click', function() {
            $('#sidebar').removeClass('show');
            $('#mobile-overlay').removeClass('show');
            $('body').removeClass('sidebar-open');
        });

        // Close mobile menu when clicking on sidebar links
        $('#sidebar .nav-link').on('click', function() {
            if ($(window).width() < 768) {
                $('#sidebar').removeClass('show');
                $('#mobile-overlay').removeClass('show');
                $('body').removeClass('sidebar-open');
            }
        });

        // Close mobile menu on window resize if screen becomes larger
        $(window).on('resize', function() {
            if ($(window).width() >= 768) {
                $('#sidebar').removeClass('show');
                $('#mobile-overlay').removeClass('show');
                $('body').removeClass('sidebar-open');
            }
        });
    });
    </script>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobile-overlay"></div>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar" id="sidebar">
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
            <div class="col-12 col-md-9 col-lg-10 px-0">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <!-- Mobile Menu Button -->
                        <button class="navbar-toggler d-lg-none me-2" type="button" id="mobile-menu-toggle">
                            <i class="fa fa-bars"></i>
                        </button>

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