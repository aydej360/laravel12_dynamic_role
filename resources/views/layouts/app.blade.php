<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Dashboard') | Mantis Bootstrap 5 Admin Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
    <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
    <meta name="author" content="CodedThemes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    
    <!-- [ Sidebar Menu ] start -->
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="{{ route('dashboard') }}" class="b-brand text-primary">
                    <img src="{{ asset('assets/images/logo-dark.svg') }}" class="img-fluid logo-lg" alt="logo">
                </a>
            </div>
            <div class="navbar-content">
                <ul class="pc-navbar">
                    <li class="pc-item">
                        <a href="{{ route('dashboard') }}" class="pc-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>

                    @can('view users')
                    <li class="pc-item pc-caption">
                        <label>User Management</label>
                        <i class="ti ti-users"></i>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('users.index') }}" class="pc-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <span class="pc-micon"><i class="ti ti-user"></i></span>
                            <span class="pc-mtext">Users</span>
                        </a>
                    </li>
                    @endcan

                    @can('view roles')
                    <li class="pc-item">
                        <a href="{{ route('roles.index') }}" class="pc-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                            <span class="pc-micon"><i class="bi bi-person-badge"></i></span>
                            <span class="pc-mtext">Roles</span>
                        </a>
                    </li>
                    @endcan

                    <li class="pc-item pc-caption">
                        <label>Account</label>
                        <i class="ti ti-settings"></i>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('profile.edit') }}" class="pc-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <span class="pc-micon"><i class="bi bi-person-circle"></i></span>
                            <span class="pc-mtext">Profile</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ Sidebar Menu ] end -->

    <!-- [ Header Topbar ] start -->
    <header class="pc-header">
        <div class="header-wrapper">
            <!-- [Mobile Media Block] start -->
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="pc-h-item pc-sidebar-popup">
                        <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- [Mobile Media Block] end -->
            <div class="ms-auto">
                <ul class="list-unstyled">
                    <li class="pc-h-item">
                        <a href="#" class="pc-head-link position-relative" id="notification-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-bell"></i>
                            <span class="badge bg-danger pc-h-badge">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown" aria-labelledby="notification-dropdown">
                            <div class="dropdown-header">
                                <h6 class="dropdown-title m-0">Notifications</h6>
                            </div>
                            <div class="dropdown-body">
                                <a href="#" class="dropdown-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="user" class="rounded-circle" width="40">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">New user registered</h6>
                                            <p class="mb-0 text-muted">5 minutes ago</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="dropdown-footer">
                                <a href="#" class="btn btn-primary btn-sm">View All</a>
                            </div>
                        </div>
                    </li>
                    <li class="pc-h-item">
                        <a href="#" class="pc-head-link position-relative" id="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="user" class="user-avtar" width="40">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end pc-h-dropdown" aria-labelledby="user-dropdown">
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <i class="ti ti-user"></i>
                                <span>Profile</span>
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="ti ti-settings"></i>
                                <span>Settings</span>
                            </a>
                            <hr class="dropdown-divider">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="ti ti-logout"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- [ Header Topbar ] end -->

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ti ti-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- [ Footer ] start -->
    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <div class="col my-1">
                    <p class="m-0">Copyright © <a href="#">Codedthemes</a></p>
                </div>
                <div class="col-auto my-1">
                    <ul class="list-inline footer-link mb-0">
                        <li class="list-inline-item"><a href="#">Home</a></li>
                        <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="#">Contact us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- [ Footer ] end -->

    <!-- Required Js -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script>layout_change('light');</script>
    <script>change_box_container('false');</script>
    <script>layout_rtl_change('false');</script>
    <script>preset_change("preset-1");</script>
    <script>font_change("Public-Sans");</script>
</body>
</html>
