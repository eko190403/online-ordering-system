<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Cafe D.Villa Lampung')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        :root {
            --primary-bg: #f4f7f6;
            --sidebar-bg: #0f172a;
            --sidebar-hover: rgba(255,255,255,0.08);
            --sidebar-active: rgba(255,255,255,0.15);
            --sidebar-color: #94a3b8;
            --sidebar-color-active: #ffffff;
        }
        body {
            background-color: var(--primary-bg);
            font-family: 'Inter', sans-serif;
            color: #334155;
        }
        .sidebar {
            min-height: 100vh;
            background: var(--sidebar-bg);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: var(--sidebar-color);
            padding: 0.8rem 1.2rem;
            margin: 0.25rem 1rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-weight: 500;
        }
        .sidebar .nav-link:hover {
            color: var(--sidebar-color-active);
            background: var(--sidebar-hover);
            transform: translateX(3px);
        }
        .sidebar .nav-link.active {
            color: var(--sidebar-color-active);
            background: var(--sidebar-active);
            box-shadow: inset 3px 0 0 #3b82f6;
        }
        .sidebar .nav-link i {
            width: 24px;
            text-align: center;
            margin-right: 0.5rem;
        }
        
        /* Modern Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.08), 0 4px 6px -2px rgba(0,0,0,0.04);
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #f1f5f9;
            border-top-left-radius: 12px !important;
            border-top-right-radius: 12px !important;
            padding: 1rem 1.25rem;
        }
        
        /* Modern Tables */
        .table {
            vertical-align: middle;
        }
        .table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border-bottom: none;
            padding: 1rem;
        }
        .table tbody td {
            padding: 1rem;
            color: #475569;
            border-bottom: 1px solid #f1f5f9;
        }
        .table-hover tbody tr:hover {
            background-color: #f8fafc;
        }
        
        /* Soft Badges */
        .badge-soft-success { background-color: #dcfce7; color: #166534; }
        .badge-soft-warning { background-color: #fef3c7; color: #92400e; }
        .badge-soft-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-soft-info { background-color: #e0f2fe; color: #075985; }
        .badge-soft-primary { background-color: #dbeafe; color: #1e40af; }
        .badge-soft-secondary { background-color: #f1f5f9; color: #475569; }
    </style>
    
    @yield('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="text-white text-center py-4 border-bottom border-secondary">
                    <h5 class="mb-1"><i class="fas fa-coffee"></i> D.Villa Lampung</h5>
                    <small class="text-muted">Admin Panel</small>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                       href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" 
                       href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-receipt"></i> Pesanan
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.menu.*') ? 'active' : '' }}" 
                       href="{{ route('admin.menu.index') }}">
                        <i class="fas fa-utensils"></i> Menu
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                       href="{{ route('admin.categories.index') }}">
                        <i class="fas fa-tags"></i> Kategori
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.stock.*') ? 'active' : '' }}" href="{{ route('admin.stock.index') }}">
                        <i class="fas fa-boxes fa-fw"></i> Stok Menu
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.expenses.*') ? 'active' : '' }}" href="{{ route('admin.expenses.index') }}">
                        <i class="fas fa-wallet fa-fw"></i> Pengeluaran
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" 
                       href="{{ route('admin.reports.sales') }}">
                        <i class="fas fa-chart-line"></i> Laporan
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.qrcode') ? 'active' : '' }}" 
                       href="{{ route('admin.qrcode') }}">
                        <i class="fas fa-qrcode"></i> QR Code
                    </a>
                    <a class="nav-link" href="{{ route('kitchen.index') }}" target="_blank">
                        <i class="fas fa-fire text-warning"></i> Layar Dapur (KDS)
                    </a>
                    <hr class="bg-secondary">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link border-0 w-100 text-start bg-transparent">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 px-4 py-3">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @yield('scripts')
</body>
</html>
