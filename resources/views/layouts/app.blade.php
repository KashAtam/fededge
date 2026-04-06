<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Fededge') }} - @yield('title', 'Vehicle Registration & Compliance')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --fededge-red: #d32f2f;
            --fededge-dark-red: #b71c1c;
            --fededge-light-red: #ef5350;
            --fededge-white: #ffffff;
            --fededge-light-gray: #f5f5f5;
            --fededge-dark-gray: #212529;
        }

        html[data-bs-theme="dark"] {
            --fededge-light-gray: #212529;
            --fededge-white: #1a1a1a;
        }

        * {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--fededge-light-gray) 0%, var(--fededge-white) 100%);
            min-height: 100vh;
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(90deg, var(--fededge-dark-red) 0%, var(--fededge-red) 100%);
            box-shadow: 0 4px 15px rgba(211, 47, 47, 0.2);
            padding: 1rem 2rem;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--fededge-white) !important;
            letter-spacing: 1px;
        }

        .navbar .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem !important;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .navbar .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            color: var(--fededge-white) !important;
        }

        .navbar .nav-link.active {
            background: rgba(255, 255, 255, 0.25);
            color: var(--fededge-white) !important;
        }

        /* Sidebar */
        .sidebar {
            background: var(--fededge-light-gray);
            border-right: 3px solid var(--fededge-red);
            min-height: 100vh;
            padding: 0;
        }

        html[data-bs-theme="dark"] .sidebar {
            background: #1e1e1e;
            border-right: 3px solid var(--fededge-red);
        }

        .sidebar .nav-link {
            color: var(--fededge-dark-gray);
            padding: 1rem 1.5rem;
            border-left: 4px solid transparent;
            margin: 0.25rem 0;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        html[data-bs-theme="dark"] .sidebar .nav-link {
            color: #e9ecef;
        }

        .sidebar .nav-link:hover {
            background: rgba(211, 47, 47, 0.1);
            border-left-color: var(--fededge-red);
            color: var(--fededge-dark-red);
        }

        .sidebar .nav-link.active {
            background: rgba(211, 47, 47, 0.2);
            border-left-color: var(--fededge-red);
            color: var(--fededge-dark-red);
            font-weight: 700;
        }

        .sidebar-header {
            padding: 1.5rem;
            background: var(--fededge-dark-red);
            color: var(--fededge-white);
            font-weight: 700;
            font-size: 1.1rem;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            padding: 2rem;
            min-height: 100vh;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-left: 4px solid var(--fededge-red);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background: linear-gradient(90deg, var(--fededge-dark-red) 0%, var(--fededge-red) 100%);
            color: var(--fededge-white);
            border: none;
            padding: 1.5rem;
            font-weight: 600;
        }

        /* Stat Cards */
        .stat-card {
            background: var(--fededge-white);
            border: 1px solid rgba(211, 47, 47, 0.2);
            border-left: 4px solid var(--fededge-red);
            padding: 1.5rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: all 0.3s ease;
        }

        html[data-bs-theme="dark"] .stat-card {
            background: #2d2d2d;
        }

        .stat-card:hover {
            box-shadow: 0 8px 20px rgba(211, 47, 47, 0.15);
            transform: translateY(-2px);
        }

        .stat-icon {
            font-size: 2.5rem;
            color: var(--fededge-red);
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(211, 47, 47, 0.1);
            border-radius: 8px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--fededge-dark-red);
        }

        .stat-label {
            font-size: 0.95rem;
            color: #666;
        }

        html[data-bs-theme="dark"] .stat-label {
            color: #adb5bd;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(90deg, var(--fededge-dark-red) 0%, var(--fededge-red) 100%);
            border: none;
            padding: 0.7rem 1.5rem;
            font-weight: 600;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, var(--fededge-red) 0%, var(--fededge-light-red) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(211, 47, 47, 0.3);
            color: white;
        }

        .btn-outline-primary {
            color: var(--fededge-red);
            border: 2px solid var(--fededge-red);
        }

        .btn-outline-primary:hover {
            background: var(--fededge-red);
            border-color: var(--fededge-red);
        }

        /* Tables */
        .table {
            background: var(--fededge-white);
        }

        html[data-bs-theme="dark"] .table {
            background: #2d2d2d;
        }

        .table thead th {
            background: var(--fededge-dark-red);
            color: var(--fededge-white);
            border: none;
            font-weight: 600;
            padding: 1rem;
        }

        .table tbody tr:hover {
            background: rgba(211, 47, 47, 0.05);
        }

        html[data-bs-theme="dark"] .table tbody tr:hover {
            background: rgba(211, 47, 47, 0.1);
        }

        /* Badges */
        .badge {
            padding: 0.5rem 0.75rem;
            font-weight: 600;
            border-radius: 4px;
        }

        .badge-success {
            background: #28a745;
            color: white;
        }

        .badge-warning {
            background: #ffc107;
            color: #000;
        }

        .badge-danger {
            background: var(--fededge-red);
            color: white;
        }

        .badge-info {
            background: #17a2b8;
            color: white;
        }

        .badge-pending {
            background: #ffc107;
            color: #000;
        }

        .badge-approved {
            background: #28a745;
            color: white;
        }

        /* Forms */
        .form-control, .form-select {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--fededge-red);
            box-shadow: 0 0 0 0.2rem rgba(211, 47, 47, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: var(--fededge-dark-gray);
            margin-bottom: 0.5rem;
        }

        html[data-bs-theme="dark"] .form-label {
            color: #e9ecef;
        }

        /* Alerts */
        .alert {
            border: none;
            border-left: 4px solid;
            border-radius: 6px;
        }

        .alert-success {
            background: #d4edda;
            border-left-color: #28a745;
            color: #155724;
        }

        html[data-bs-theme="dark"] .alert-success {
            background: #1e3a2d;
            color: #9eca9e;
        }

        .alert-danger {
            background: #f8d7da;
            border-left-color: var(--fededge-red);
            color: #721c24;
        }

        html[data-bs-theme="dark"] .alert-danger {
            background: #3a1e1e;
            color: #e9a0a0;
        }

        /* Footer */
        .footer {
            background: var(--fededge-dark-red);
            color: var(--fededge-white);
            padding: 2rem;
            text-align: center;
            margin-top: 3rem;
        }

        .footer p {
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -260px;
                height: 100vh;
                width: 260px;
                transition: left 0.3s ease;
                z-index: 1040;
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                padding: 1rem;
            }

            .navbar {
                padding: 0.5rem 1rem;
            }
        }

        /* Theme Toggle Button */
        .theme-toggle {
            background: none;
            border: none;
            color: var(--fededge-white);
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Loading Spinner */
        .spinner-border {
            color: var(--fededge-red);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--fededge-light-gray);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--fededge-red);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--fededge-dark-red);
        }

        /* Page Title */
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--fededge-dark-red);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .page-title i {
            color: var(--fededge-red);
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-car-front-fill"></i> Fededge
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        @if (auth()->user()->isVehicleOwner())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                    href="{{ route('dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('vehicle.*') ? 'active' : '' }}"
                                    href="{{ route('vehicle.index') }}">
                                    <i class="bi bi-car-front"></i> My Vehicles
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('document.*') ? 'active' : '' }}"
                                    href="{{ route('document.index') }}">
                                    <i class="bi bi-file-pdf"></i> Documents
                                </a>
                            </li>
                        @elseif (auth()->user()->isRoadOfficer())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('officer.dashboard') ? 'active' : '' }}"
                                    href="{{ route('officer.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('officer.search*') ? 'active' : '' }}"
                                    href="{{ route('officer.search') }}">
                                    <i class="bi bi-search"></i> Search Vehicles
                                </a>
                            </li>
                        @elseif (auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                    href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown">
                                    <i class="bi bi-gear"></i> Management
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ route('admin.vehicles.index') }}">Vehicles</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Users</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.documents.index') }}">Documents</a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        <li class="nav-item ms-2">
                            <button class="theme-toggle" id="themeToggle" title="Toggle theme">
                                <i class="bi bi-moon-fill"></i>
                            </button>
                        </li>

                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="nav-link btn btn-outline-light btn-sm" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar -->
        @auth
            <nav class="sidebar d-lg-block">
                <div class="sidebar-header">
                    @if (auth()->user()->isAdmin())
                        <i class="bi bi-shield-lock"></i> Admin Panel
                    @elseif (auth()->user()->isRoadOfficer())
                        <i class="bi bi-person-badge"></i> Road Officer
                    @else
                        <i class="bi bi-person"></i> Vehicle Owner
                    @endif
                </div>

                <nav class="nav flex-column">
                    @if (auth()->user()->isVehicleOwner())
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('vehicle.*') ? 'active' : '' }}"
                            href="{{ route('vehicle.index') }}">
                            <i class="bi bi-car-front"></i> My Vehicles
                        </a>
                        <a class="nav-link {{ request()->routeIs('document.*') ? 'active' : '' }}"
                            href="{{ route('document.index') }}">
                            <i class="bi bi-file-pdf"></i> Documents
                        </a>
                    @elseif (auth()->user()->isRoadOfficer())
                        <a class="nav-link {{ request()->routeIs('officer.dashboard') ? 'active' : '' }}"
                            href="{{ route('officer.dashboard') }}">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('officer.search*') ? 'active' : '' }}"
                            href="{{ route('officer.search') }}">
                            <i class="bi bi-search"></i> Search Vehicles
                        </a>
                    @elseif (auth()->user()->isAdmin())
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                            href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.vehicles*') ? 'active' : '' }}"
                            href="{{ route('admin.vehicles.index') }}">
                            <i class="bi bi-car-front"></i> Vehicles
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}"
                            href="{{ route('admin.users.index') }}">
                            <i class="bi bi-people"></i> Users
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.documents*') ? 'active' : '' }}"
                            href="{{ route('admin.documents.index') }}">
                            <i class="bi bi-file-pdf"></i> Documents
                        </a>
                    @endif
                </nav>
            </nav>
        @endauth

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            @auth
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Oops!</strong> Please fix the following errors:
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container-fluid">
            <p>&copy; {{ date('Y') }} <strong>Fededge</strong> - Vehicle Registration & Compliance Management System.
                All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const htmlElement = document.documentElement;

        // Load saved theme or default to light
        const savedTheme = localStorage.getItem('theme') || 'light';
        htmlElement.setAttribute('data-bs-theme', savedTheme);
        updateThemeIcon();

        themeToggle?.addEventListener('click', function () {
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            htmlElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon();
        });

        function updateThemeIcon() {
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            const icon = themeToggle?.querySelector('i');
            if (icon) {
                if (currentTheme === 'dark') {
                    icon.className = 'bi bi-sun-fill';
                } else {
                    icon.className = 'bi bi-moon-fill';
                }
            }
        }

        // Mobile sidebar toggle
        const navbarToggler = document.querySelector('.navbar-toggler');
        const sidebar = document.querySelector('.sidebar');

        navbarToggler?.addEventListener('click', function () {
            sidebar?.classList.toggle('show');
        });

        // Close sidebar when clicking on a link
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', function () {
                sidebar?.classList.remove('show');
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
