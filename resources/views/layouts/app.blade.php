<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Peminjaman Kampus') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #6366f1;
            --primary-light: #a5b4fc;
            --primary-dark: #4f46e5;
            --secondary-color: #f8fafc;
            --accent-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --bg-light: #f8fafc;
            --bg-white: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --border-radius: 12px;
            --border-radius-lg: 16px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-primary);
            line-height: 1.6;
        }

        /* Modern Sidebar */
        .sidebar-modern {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 80px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            z-index: 1000;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-lg);
            backdrop-filter: blur(10px);
        }

        .sidebar-modern:hover {
            width: 280px;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.05);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-logo i {
            font-size: 1.75rem;
            color: #e0e7ff;
        }

        .sidebar-logo .logo-text {
            display: none;
        }

        .sidebar-modern:hover .sidebar-logo .logo-text {
            display: block;
        }

        .sidebar-logo .logo-text h5 {
            margin: 0;
            font-weight: 700;
            font-size: 1.125rem;
            color: white;
        }

        .sidebar-logo .logo-text small {
            color: rgba(255,255,255,0.7);
            font-size: 0.75rem;
        }

        .sidebar-modern.collapsed .sidebar-logo .logo-text {
            display: none;
        }

        .sidebar-modern.collapsed:hover .sidebar-logo .logo-text {
            display: block;
        }

        .sidebar-nav {
            padding: 1rem 0;
            max-height: calc(100vh - 120px);
            overflow-y: auto;
        }

        .sidebar-nav .nav-item {
            margin: 0.25rem 0.5rem;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .sidebar-nav .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }

        .sidebar-nav .nav-link:hover::before {
            left: 100%;
        }

        .sidebar-nav .nav-link:hover {
            color: white;
            background: rgba(255,255,255,0.15);
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .sidebar-nav .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .sidebar-nav .nav-link i {
            font-size: 1.125rem;
            width: 20px;
            margin-right: 0.75rem;
            text-align: center;
        }

        .sidebar-nav .nav-link span {
            display: none;
            white-space: nowrap;
        }

        .sidebar-modern:hover .sidebar-nav .nav-link span {
            display: inline;
        }

        /* Main Content */
        .main-content-modern {
            margin-left: 80px;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
        }

        .sidebar-modern:hover ~ .main-content-modern {
            margin-left: 280px;
        }

        /* Top Navigation */
        .top-nav {
            background: var(--bg-white);
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 2rem;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .top-nav .navbar-brand {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.25rem;
        }

        .user-menu .dropdown-toggle::after {
            margin-left: 0.5rem;
        }

        /* Modern Cards */
        .card-modern {
            background: var(--bg-white);
            border: none;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-md);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .card-modern:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .card-modern .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            padding: 1.5rem;
            font-weight: 600;
        }

        .card-modern .card-body {
            padding: 2rem;
        }

        /* Contact footer for mahasiswa */
        .contact-footer {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.08), rgba(16, 185, 129, 0.05));
            border: 1px solid rgba(99, 102, 241, 0.12);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
        }

        .contact-footer h6 {
            font-weight: 700;
        }

        .contact-footer .contact-card {
            border: none;
            background: white;
            box-shadow: var(--shadow-sm);
        }

        body.sipkam-dark .contact-footer {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.2), rgba(34, 197, 94, 0.12));
            border-color: rgba(99, 102, 241, 0.35);
            color: #e5e7eb;
        }

        body.sipkam-dark .contact-footer .contact-card {
            background: #0b1224;
            border: 1px solid rgba(255, 255, 255, 0.06);
            color: #e5e7eb;
        }

        body.sipkam-dark .contact-footer .text-muted {
            color: #cbd5e1 !important;
        }

        /* Modern Buttons */
        .btn-modern {
            border-radius: var(--border-radius);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
        }

        .btn-modern-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
        }

        .btn-modern-secondary {
            background: var(--secondary-color);
            color: var(--text-primary);
            border: 1px solid #e2e8f0;
        }

        .btn-modern-success {
            background: linear-gradient(135deg, var(--accent-color), #059669);
            color: white;
        }

        .btn-modern-warning {
            background: linear-gradient(135deg, var(--warning-color), #d97706);
            color: white;
        }

        .btn-modern-danger {
            background: linear-gradient(135deg, var(--danger-color), #dc2626);
            color: white;
        }

        /* Modern Form Elements */
        .form-control-modern {
            border: 2px solid #e2e8f0;
            border-radius: var(--border-radius);
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: var(--bg-white);
        }

        .form-control-modern:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            outline: none;
        }

        .form-label-modern {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        /* Modern Tables */
        .table-modern {
            background: var(--bg-white);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .table-modern thead th {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            padding: 1rem;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-modern tbody tr {
            transition: all 0.2s ease;
        }

        .table-modern tbody tr:hover {
            background: #f8fafc;
            transform: scale(1.01);
        }

        .table-modern tbody td {
            padding: 1rem;
            border: none;
            vertical-align: middle;
        }

        /* Modern Badges */
        .badge-modern {
            border-radius: 20px;
            font-weight: 600;
            padding: 0.375rem 0.875rem;
            font-size: 0.75rem;
        }

        .badge-modern-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
        }

        .badge-modern-success {
            background: linear-gradient(135deg, var(--accent-color), #059669);
            color: white;
        }

        .badge-modern-warning {
            background: linear-gradient(135deg, var(--warning-color), #d97706);
            color: white;
        }

        .badge-modern-danger {
            background: linear-gradient(135deg, var(--danger-color), #dc2626);
            color: white;
        }

        /* Modern Alerts */
        .alert-modern {
            border: none;
            border-radius: var(--border-radius);
            padding: 1rem 1.5rem;
            font-weight: 500;
            box-shadow: var(--shadow-sm);
        }

        .alert-modern-success {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            color: #166534;
            border-left: 4px solid var(--accent-color);
        }

        .alert-modern-danger {
            background: linear-gradient(135deg, #fef2f2, #fecaca);
            color: #991b1b;
            border-left: 4px solid var(--danger-color);
        }

        .alert-modern-warning {
            background: linear-gradient(135deg, #fffbeb, #fde68a);
            color: #92400e;
            border-left: 4px solid var(--warning-color);
        }

        /* Dashboard Stats Cards */
        .stats-card {
            background: var(--bg-white);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            box-shadow: var(--shadow-md);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e2e8f0;
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stats-icon.primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
        }

        .stats-icon.success {
            background: linear-gradient(135deg, var(--accent-color), #059669);
            color: white;
        }

        .stats-icon.warning {
            background: linear-gradient(135deg, var(--warning-color), #d97706);
            color: white;
        }

        .stats-icon.danger {
            background: linear-gradient(135deg, var(--danger-color), #dc2626);
            color: white;
        }

        .stats-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .stats-label {
            color: var(--text-secondary);
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar-modern {
                transform: translateX(-100%);
            }
            .sidebar-modern.show {
                transform: translateX(0);
            }
            .main-content-modern {
                margin-left: 0;
            }

            .top-nav {
                padding: 1rem;
            }

            .stats-card {
                margin-bottom: 1rem;
            }

            .table-responsive {
                border-radius: var(--border-radius);
                box-shadow: var(--shadow-sm);
            }
        }

        @media (max-width: 576px) {
            .sidebar-modern {
                width: 100%;
            }

            .card-modern .card-body {
                padding: 1.5rem;
            }

            .stats-card {
                padding: 1.5rem;
            }

            .btn-modern {
                padding: 0.625rem 1.25rem;
                font-size: 0.9rem;
            }
        }

        /* Loading Animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        /* === DARK MODE GLOBAL (TAMBAHAN) === */
        :root {
            --sipkam-bg-light: #f3f4f6;
            --sipkam-bg-dark: #020617;
            --sipkam-text-dark: #0f172a;
            --sipkam-text-dark-mode: #e5e7eb;
            --sipkam-muted-dark: #9ca3af;
            --sipkam-accent-green: #22c55e;
        }

        body.sipkam-light {
            background: var(--sipkam-bg-light);
            color: var(--sipkam-text-dark);
        }

        body.sipkam-dark {
            background: var(--sipkam-bg-dark);
            color: var(--sipkam-text-dark-mode);
        }

        /* sidebar & top nav */
        body.sipkam-dark .top-nav {
            background-color: #020617 !important;
            border-bottom-color: #111827 !important;
            color: var(--sipkam-text-dark-mode);
            box-shadow: 0 10px 25px rgba(0,0,0,.9);
        }

        body.sipkam-dark .navbar-brand,
        body.sipkam-dark .top-nav .text-primary {
            color: var(--sipkam-accent-green) !important;
        }

        body.sipkam-dark .sidebar-modern {
            background: #020617 !important;
            box-shadow: 0 0 0 rgba(0,0,0,.9);
        }

        body.sipkam-dark .sidebar-modern .nav-link {
            color: var(--sipkam-muted-dark);
        }

        body.sipkam-dark .sidebar-modern .nav-link.active,
        body.sipkam-dark .sidebar-modern .nav-link:hover {
            background: var(--sipkam-accent-green);
            color: #020617;
        }

        /* cards & tables */
        body.sipkam-dark .card-modern,
        body.sipkam-dark .stats-card,
        body.sipkam-dark .table-modern {
            background-color: #020617 !important;
            color: var(--sipkam-text-dark-mode);
            border-color: #111827 !important;
            box-shadow: 0 18px 40px rgba(0,0,0,.75);
        }

        body.sipkam-dark .card-modern .card-header {
            background: #020617;
            color: var(--sipkam-accent-green);
            border-bottom: 1px solid #111827;
        }

        body.sipkam-dark .table-modern thead th {
            background: #020617;
            color: var(--sipkam-accent-green);
        }

        body.sipkam-dark .card {
            background-color: #020617;
            color: var(--sipkam-text-dark-mode);
            border-color: #111827;
        }

        body.sipkam-dark .table {
            color: var(--sipkam-text-dark-mode);
        }

        body.sipkam-dark .table thead th {
            border-color: #1f2937;
        }

        body.sipkam-dark .table tbody td {
            border-color: #111827;
        }

        /* link & breadcrumb */
        body.sipkam-dark a,
        body.sipkam-dark .nav-link,
        body.sipkam-dark .breadcrumb-item a {
            color: var(--sipkam-accent-green);
        }

        /* alerts */
        body.sipkam-dark .alert-modern {
            background: #020617;
            color: var(--sipkam-text-dark-mode);
            border: 1px solid #111827;
        }

        /* outline buttons */
        body.sipkam-dark .btn-outline-primary,
        body.sipkam-dark .btn-outline-secondary {
            border-color: var(--sipkam-accent-green);
            color: var(--sipkam-accent-green);
        }

        /* avatar circle */
        body.sipkam-dark .avatar-circle {
            background: var(--sipkam-accent-green);
            color: #020617;
        }
    </style>
</head>
<body>
    @if(auth()->check() && auth()->user()->role === 'petugas')
        <!-- Modern Sidebar untuk Petugas -->
        <nav class="sidebar-modern collapsed" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i class="fas fa-graduation-cap"></i>
                    <div class="logo-text">
                        <h5>SIPKAM</h5>
                        <small>Sistem Peminjaman</small>
                    </div>
                </div>
            </div>

            <div class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}" href="{{ route('petugas.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}" href="{{ route('barang.index') }}">
                            <i class="fas fa-box"></i>
                            <span>Barang</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('petugas.kategori.*') ? 'active' : '' }}" href="{{ route('petugas.kategori.index') }}">
                            <i class="fas fa-tags"></i>
                            <span>Kategori</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('petugas.booking.*') ? 'active' : '' }}" href="{{ route('petugas.booking.index') }}">
                            <i class="fas fa-calendar-check"></i>
                            <span>Booking</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('petugas.peminjaman.*') ? 'active' : '' }}" href="{{ route('petugas.peminjaman.index') }}">
                            <i class="fas fa-hand-holding"></i>
                            <span>Peminjaman</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('petugas.perpanjangan.*') ? 'active' : '' }}" href="{{ route('petugas.perpanjangan.index') }}">
                            <i class="fas fa-clock"></i>
                            <span>Perpanjangan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('petugas.keluhan.*') ? 'active' : '' }}" href="{{ route('petugas.keluhan.index') }}">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Keluhan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('petugas.service.*') ? 'active' : '' }}" href="{{ route('petugas.service.index') }}">
                            <i class="fas fa-tools"></i>
                            <span>Service</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('petugas.pengembalian.*') ? 'active' : '' }}" href="{{ route('petugas.pengembalian.index') }}">
                            <i class="fas fa-undo"></i>
                            <span>Pengembalian</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('petugas.riwayat.*') ? 'active' : '' }}" href="{{ route('petugas.riwayat.index') }}">
                            <i class="fas fa-folder-open"></i>
                            <span>Histori</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('petugas.denda.*') ? 'active' : '' }}" href="{{ route('petugas.denda.index') }}">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Denda</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.show') ? 'active' : '' }}" href="{{ route('profile.show') }}">
                            <i class="fas fa-user"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('petugas.notifikasi.*') ? 'active' : '' }}" href="{{ route('petugas.notifikasi.index') }}">
                            <i class="fas fa-bell"></i>
                            <span>Notifikasi</span>
                        </a>
                    </li>

                </ul>
            </div>
        </nav>

        <!-- Main Content Wrapper -->
        <div class="main-content-modern" id="main-content">
            <!-- Top Navigation -->
            <nav class="top-nav">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-link text-decoration-none me-3 d-md-none" id="sidebar-toggle">
                            <i class="fas fa-bars fa-lg"></i>
                        </button>
                        <button class="btn btn-link text-decoration-none me-3" onclick="history.back()" title="Kembali">
                            <i class="fas fa-arrow-left fa-lg"></i>
                        </button>
                        <h4 class="mb-0 fw-bold text-primary">
                            @yield('page-title', 'Dashboard')
                        </h4>
                    </div>

                    <div class="user-menu">
                        <div class="dropdown">
                            <button class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                                <div class="avatar-circle me-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="p-4">
                @if (session('success'))
                    <div class="alert alert-modern alert-modern-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-modern alert-modern-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-modern alert-modern-warning alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    @else
        <!-- Modern Sidebar untuk Mahasiswa -->
        <nav class="sidebar-modern" id="sidebar-mahasiswa">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i class="fas fa-graduation-cap"></i>
                    <div class="logo-text">
                        <h5>SIPKAM</h5>
                    </div>
                </div>
            </div>

            <div class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}" href="{{ route('mahasiswa.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}" href="{{ route('barang.index') }}">
                            <i class="fas fa-box"></i>
                            <span>Barang</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('mahasiswa.peminjaman.*') ? 'active' : '' }}" href="{{ route('mahasiswa.peminjaman.index') }}">
                            <i class="fas fa-hand-holding"></i>
                            <span>Peminjaman</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('mahasiswa.perpanjangan.*') ? 'active' : '' }}" href="{{ route('mahasiswa.perpanjangan.index') }}">
                            <i class="fas fa-clock"></i>
                            <span>Perpanjangan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('mahasiswa.keluhan.*') ? 'active' : '' }}" href="{{ route('mahasiswa.keluhan.index') }}">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Keluhan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('mahasiswa.riwayat.*') ? 'active' : '' }}" href="{{ route('mahasiswa.riwayat.index') }}">
                            <i class="fas fa-history"></i>
                            <span>Riwayat</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.show') ? 'active' : '' }}" href="{{ route('profile.show') }}">
                            <i class="fas fa-user"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content Wrapper untuk Mahasiswa -->
        <div class="main-content-modern" id="main-content-mahasiswa">
            <!-- Top Navigation Minimal -->
            <nav class="top-nav">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-link text-decoration-none me-3 d-md-none" id="sidebar-toggle-mahasiswa">
                            <i class="fas fa-bars fa-lg"></i>
                        </button>
                        <button class="btn btn-link text-decoration-none me-3" onclick="history.back()">
                            <i class="fas fa-arrow-left fa-lg"></i>
                        </button>
                        <div class="navbar-brand fw-bold text-primary">
                            SIPKAM
                        </div>
                    </div>

                    <div class="user-menu">
                        <div class="dropdown">
                            <button class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                                <div class="avatar-circle me-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'User' }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="p-4">
                @if (session('success'))
                    <div class="alert alert-modern alert-modern-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-modern alert-modern-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-modern alert-modern-warning alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')

                {{-- Contact footer for mahasiswa views --}}
                <footer class="contact-footer mt-5">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-3">
                        <div>
                            <h6 class="mb-1">Butuh bantuan petugas?</h6>
                            <p class="mb-0 text-muted">Hubungi tim SIPKAM kapan saja jika ada kendala peminjaman.</p>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success bg-opacity-75 text-white"><i class="fas fa-circle me-1"></i>Aktif</span>
                            <small class="text-muted">Respons cepat pada jam kerja</small>
                        </div>
                    </div>

                    @php
                        $contactList = [
                            ['nama' => 'Call Center SIPKAM', 'nomor' => '0812-3456-7890', 'ikon' => 'fa-headset', 'warna' => 'primary'],
                            ['nama' => 'Email SIPKAM', 'nomor' => 'SIPKAM@admin.ac.id', 'ikon' => 'fa-envelope', 'warna' => 'success'],
                        ];
                    @endphp

                    <div class="row g-3">
                        @foreach($contactList as $contact)
                            <div class="col-md-4">
                                <div class="contact-card d-flex align-items-center gap-3 h-100">
                                    <div class="rounded-circle bg-{{ $contact['warna'] }} bg-opacity-10 text-{{ $contact['warna'] }} d-flex align-items-center justify-content-center" style="width:52px;height:52px;">
                                        <i class="fas {{ $contact['ikon'] }}"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $contact['nama'] }}</div>
                                        <div class="text-muted">{{ $contact['nomor'] }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </footer>
            </main>
        </div>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Modern UI Interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle for mobile (Petugas)
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Sidebar toggle for mobile (Mahasiswa)
            const sidebarToggleMahasiswa = document.getElementById('sidebar-toggle-mahasiswa');
            const sidebarMahasiswa = document.getElementById('sidebar-mahasiswa');
            const mainContentMahasiswa = document.getElementById('main-content-mahasiswa');

            if (sidebarToggleMahasiswa && sidebarMahasiswa) {
                sidebarToggleMahasiswa.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    sidebarMahasiswa.classList.toggle('show');
                });
            }

            // Close sidebar when clicking outside on mobile
            if (mainContent && sidebar) {
                mainContent.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768 && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                });
            }

            if (mainContentMahasiswa && sidebarMahasiswa) {
                mainContentMahasiswa.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768 && sidebarMahasiswa.classList.contains('show')) {
                        sidebarMahasiswa.classList.remove('show');
                    }
                });
            }

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert-modern');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add loading state to forms
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<span class="loading-spinner"></span> Memproses...';
                        submitBtn.disabled = true;
                    }
                });
            });

            // Enhanced dropdown animations
            document.querySelectorAll('.dropdown').forEach(dropdown => {
                dropdown.addEventListener('show.bs.dropdown', function() {
                    const menu = this.querySelector('.dropdown-menu');
                    if (menu) {
                        menu.style.opacity = '0';
                        menu.style.transform = 'translateY(-10px)';
                        setTimeout(() => {
                            menu.style.transition = 'all 0.3s ease';
                            menu.style.opacity = '1';
                            menu.style.transform = 'translateY(0)';
                        }, 1);
                    }
                });
            });

            // Add ripple effect to buttons
            document.querySelectorAll('.btn-modern').forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple-effect');

                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Utility functions
        function showAlert(message, type = 'success') {
            const alertClass = type === 'success' ? 'alert-modern-success' :
                              type === 'error' ? 'alert-modern-danger' :
                              type === 'warning' ? 'alert-modern-warning' : 'alert-modern-success';

            const alert = document.createElement('div');
            alert.className = `alert alert-modern ${alertClass} alert-dismissible fade show mb-4`;
            alert.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'exclamation-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            const main = document.querySelector('main');
            if (main) {
                main.insertBefore(alert, main.firstChild);
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            }
        }

        // Add CSS for ripple effect
        const style = document.createElement('style');
        style.textContent = `
            .ripple-effect {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.4);
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            }

            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }

            .avatar-circle {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                background: var(--primary-color);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 0.875rem;
            }
        `;
        document.head.appendChild(style);
    </script>

    {{-- SCRIPT TAMBAHAN: baca tema dari localStorage & apply ke body --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const savedTheme = localStorage.getItem('sipkam-theme');
            const prefersDark = window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches;

            const initialTheme = savedTheme || (prefersDark ? 'sipkam-dark' : 'sipkam-light');

            document.body.classList.remove('sipkam-light', 'sipkam-dark');
            document.body.classList.add(initialTheme);
        });
    </script>
</body>
</html>
