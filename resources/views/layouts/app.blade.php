<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('Stock Management'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg-start: #1e2a3a;
            --sidebar-bg-end: #2d1b4e;
            --sidebar-active-bg: rgba(99, 102, 241, 0.15);
            --sidebar-active-color: #818cf8;
            --sidebar-hover-bg: rgba(255, 255, 255, 0.05);
            --sidebar-text: #94a3b8;
            --sidebar-text-hover: #e2e8f0;
            --sidebar-section-text: #64748b;
            --sidebar-border: rgba(255, 255, 255, 0.08);
            --sidebar-width: 260px;
            --primary: #4f46e5;
            --primary-light: #818cf8;
            --primary-gradient: linear-gradient(135deg, #4f46e5, #7c3aed);
            --body-bg: #f1f5f9;
            --card-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.06);
            --card-shadow-hover: 0 4px 6px rgba(0,0,0,0.04), 0 10px 24px rgba(0,0,0,0.1);
            --card-radius: 0.75rem;
            --table-header-bg: #eef2ff;
            --table-header-color: #3730a3;
            --table-stripe-bg: #f8fafc;
            --table-hover-bg: #eef2ff;
            --transition-fast: 0.15s ease;
            --transition-normal: 0.25s ease;
        }

        html { scroll-behavior: smooth; }
        body {
            background-color: var(--body-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            height: 100vh;
            background: linear-gradient(180deg, var(--sidebar-bg-start) 0%, var(--sidebar-bg-end) 100%);
            padding-top: 0;
            position: fixed;
            width: var(--sidebar-width);
            overflow-y: auto;
            z-index: 1000;
        }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        .brand-title {
            color: #fff;
            font-size: 1.15rem;
            font-weight: 700;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--sidebar-border);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .brand-title i {
            font-size: 1.4rem;
            color: var(--primary-light);
            filter: drop-shadow(0 0 8px rgba(129, 140, 248, 0.4));
        }

        .sidebar-section {
            color: var(--sidebar-section-text);
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 1.2rem 1.5rem 0.4rem;
            font-weight: 600;
        }

        .sidebar .nav-link {
            color: var(--sidebar-text);
            padding: 0.55rem 1.5rem;
            font-size: 0.875rem;
            margin: 1px 0.75rem;
            border-radius: 0.5rem;
            transition: all var(--transition-fast);
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }
        .sidebar .nav-link i {
            font-size: 1.05rem;
            width: 1.25rem;
            text-align: center;
            margin-right: 0;
        }
        .sidebar .nav-link:hover {
            color: var(--sidebar-text-hover);
            background: var(--sidebar-hover-bg);
        }
        .sidebar .nav-link.active {
            color: var(--sidebar-active-color);
            background: var(--sidebar-active-bg);
            font-weight: 500;
        }
        .sidebar .nav-link.active i { color: var(--sidebar-active-color); }

        .user-info {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--sidebar-border);
            margin-top: auto;
            background: rgba(0,0,0,0.15);
        }
        .user-info .name {
            color: #e2e8f0;
            font-size: 0.85rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .user-info .name i {
            font-size: 1.3rem;
            color: var(--primary-light);
            background: rgba(99, 102, 241, 0.15);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .user-info .role {
            color: var(--sidebar-section-text);
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-left: 42px;
        }

        .lang-switch a {
            color: var(--sidebar-text);
            font-size: 0.8rem;
            text-decoration: none;
            padding: 2px 6px;
            border-radius: 4px;
            transition: all var(--transition-fast);
        }
        .lang-switch a:hover {
            color: #fff;
            background: rgba(255,255,255,0.08);
        }
        .lang-switch a.active-lang {
            color: #fff;
            font-weight: 600;
            background: rgba(99, 102, 241, 0.2);
        }

        .user-info .btn-outline-light {
            border-color: rgba(255,255,255,0.12);
            color: var(--sidebar-text);
            font-size: 0.8rem;
            border-radius: 0.5rem;
            transition: all var(--transition-fast);
        }
        .user-info .btn-outline-light:hover {
            background: rgba(220, 38, 38, 0.15);
            border-color: rgba(220, 38, 38, 0.3);
            color: #fca5a5;
        }

        /* ===== MAIN CONTENT ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            animation: fadeInUp 0.4s ease-out;
        }

        /* ===== PAGE HEADER ===== */
        .main-content > h4:first-child,
        .main-content > .d-flex:first-child h4 {
            font-size: 1.35rem;
            font-weight: 700;
            color: #1e293b;
            position: relative;
            padding-bottom: 0.75rem;
        }
        .main-content > h4:first-child::after,
        .main-content > .d-flex:first-child h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }
        .main-content > .d-flex.justify-content-between {
            padding-bottom: 0.5rem;
            margin-bottom: 1.25rem !important;
            border-bottom: 1px solid #e2e8f0;
        }

        /* ===== CARDS ===== */
        .card {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            transition: box-shadow var(--transition-normal);
        }
        .card-header {
            border-bottom: 1px solid #e2e8f0;
            background: transparent;
            padding: 1rem 1.25rem;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .card-header.bg-danger { background: linear-gradient(135deg, #dc2626, #ef4444) !important; border-bottom: none; }
        .card-header.bg-primary { background: linear-gradient(135deg, #4f46e5, #6366f1) !important; border-bottom: none; }
        .card-header.bg-success { background: linear-gradient(135deg, #059669, #10b981) !important; border-bottom: none; }

        /* ===== STAT CARDS ===== */
        .stat-card {
            border-left: none;
            border-radius: var(--card-radius);
            position: relative;
            overflow: hidden;
            transition: transform var(--transition-normal), box-shadow var(--transition-normal);
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
        }
        .stat-card.blue::before  { background: linear-gradient(90deg, #4f46e5, #818cf8); }
        .stat-card.green::before { background: linear-gradient(90deg, #059669, #34d399); }
        .stat-card.yellow::before { background: linear-gradient(90deg, #d97706, #fbbf24); }
        .stat-card.red::before   { background: linear-gradient(90deg, #dc2626, #f87171); }

        .stat-card .stat-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 2.5rem;
            opacity: 0.08;
        }
        .stat-card .text-muted.small {
            font-size: 0.78rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: #64748b !important;
        }

        /* ===== TABLES ===== */
        .table { font-size: 0.875rem; }
        .table thead th,
        .table thead.table-light th {
            background-color: var(--table-header-bg) !important;
            color: var(--table-header-color);
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-bottom: 2px solid #c7d2fe;
            padding: 0.75rem 1rem;
            white-space: nowrap;
        }
        .table-hover tbody tr:nth-child(even) { background-color: var(--table-stripe-bg); }
        .table-hover tbody tr:hover { background-color: var(--table-hover-bg) !important; }
        .table td {
            padding: 0.7rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }
        .card .table-sm th {
            background: var(--table-header-bg);
            color: var(--table-header-color);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            font-weight: 600;
        }

        /* DataTables controls */
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 0.5rem;
            border: 1.5px solid #e2e8f0;
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
            transition: border-color var(--transition-fast);
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            outline: none;
        }
        .dataTables_wrapper .dataTables_length select {
            border-radius: 0.5rem;
            border: 1.5px solid #e2e8f0;
            padding: 0.3rem 0.6rem;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 0.375rem !important;
            margin: 0 2px;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary) !important;
            border-color: var(--primary) !important;
            color: #fff !important;
        }

        /* ===== ACTION BUTTONS IN TABLES ===== */
        .table .btn-sm {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            font-size: 0.8rem;
            transition: all var(--transition-fast);
            border: none;
        }
        .table .btn-warning {
            background: #fef3c7;
            color: #92400e;
        }
        .table .btn-warning:hover {
            background: #fde68a;
            color: #78350f;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(217, 119, 6, 0.2);
        }
        .table .btn-danger {
            background: #fee2e2;
            color: #991b1b;
        }
        .table .btn-danger:hover {
            background: #fecaca;
            color: #7f1d1d;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.2);
        }
        .table .btn-info {
            background: #e0f2fe;
            color: #075985;
        }
        .table .btn-info:hover {
            background: #bae6fd;
            color: #0c4a6e;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(8, 145, 178, 0.2);
        }

        /* ===== FORMS ===== */
        .form-label {
            font-weight: 500;
            font-size: 0.85rem;
            color: #374151;
            margin-bottom: 0.35rem;
        }
        .form-control, .form-select {
            border-radius: 0.5rem;
            border: 1.5px solid #e2e8f0;
            padding: 0.55rem 0.85rem;
            font-size: 0.9rem;
            transition: all var(--transition-fast);
            color: #1e293b;
        }
        .form-control:focus, .form-select:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        .input-group-text {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            color: #94a3b8;
            border-radius: 0.5rem 0 0 0.5rem;
            font-size: 0.85rem;
        }
        .input-group .form-control,
        .input-group .form-select {
            border-radius: 0 0.5rem 0.5rem 0;
        }
        .input-group:focus-within .input-group-text {
            border-color: #818cf8;
            color: #4f46e5;
        }

        /* ===== BUTTONS ===== */
        .btn {
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all var(--transition-fast);
        }
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            border: none;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.2);
        }
        .btn-primary:hover, .btn-primary:focus {
            background: linear-gradient(135deg, #4338ca, #4f46e5);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            transform: translateY(-1px);
        }
        .btn-success {
            background: linear-gradient(135deg, #059669, #10b981);
            border: none;
            box-shadow: 0 2px 8px rgba(5, 150, 105, 0.2);
        }
        .btn-success:hover, .btn-success:focus {
            background: linear-gradient(135deg, #047857, #059669);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
            transform: translateY(-1px);
        }
        .btn-info:not(.table .btn-info) {
            background: linear-gradient(135deg, #0891b2, #06b6d4);
            border: none;
            color: #fff;
        }
        .btn-info:not(.table .btn-info):hover {
            background: linear-gradient(135deg, #0e7490, #0891b2);
            color: #fff;
            transform: translateY(-1px);
        }
        .btn-secondary {
            background: #e2e8f0;
            border: none;
            color: #475569;
        }
        .btn-secondary:hover {
            background: #cbd5e1;
            color: #334155;
            transform: translateY(-1px);
        }
        .btn-outline-secondary {
            border: 1.5px solid #e2e8f0;
            color: #475569;
        }
        .btn-outline-secondary:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #334155;
        }

        /* ===== ALERTS ===== */
        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .alert {
            border: none;
            border-radius: 0.75rem;
            padding: 1rem 1.25rem;
            font-size: 0.875rem;
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            animation: slideInDown 0.3s ease-out;
        }
        .alert-success {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            color: #065f46;
            border-left: 4px solid #059669;
        }
        .alert-success::before {
            content: '\F26A';
            font-family: 'bootstrap-icons';
            font-size: 1.1rem;
            color: #059669;
            flex-shrink: 0;
        }
        .alert-danger {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }
        .alert-danger::before {
            content: '\F33B';
            font-family: 'bootstrap-icons';
            font-size: 1.1rem;
            color: #dc2626;
            flex-shrink: 0;
        }

        /* ===== BADGES ===== */
        .badge {
            font-weight: 500;
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            border-radius: 0.375rem;
        }
        .badge.bg-success { background: #d1fae5 !important; color: #065f46; }
        .badge.bg-danger { background: #fee2e2 !important; color: #991b1b; }
        .badge.bg-warning { background: #fef3c7 !important; color: #92400e !important; }

        /* ===== MODALS ===== */
        .modal-content {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }
        .modal-header {
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem 1.5rem;
        }
        .modal-title { font-weight: 600; font-size: 1rem; color: #1e293b; }
        .modal-body { padding: 1.5rem; }
        .modal-footer { border-top: 1px solid #e2e8f0; padding: 1rem 1.5rem; }

        /* ===== FILTER CARDS ===== */
        .no-print.card {
            background: linear-gradient(135deg, #f8fafc, #eef2ff);
            border: 1px solid #e0e7ff;
        }

        /* ===== PRINT ===== */
        @media print {
            .sidebar, .no-print { display: none !important; }
            .main-content { margin-left: 0; padding: 0; animation: none; }
            .card { box-shadow: none; border: 1px solid #ddd; }
            .stat-card:hover { transform: none; }
        }
    </style>
</head>
<body>
    <nav class="sidebar d-flex flex-column">
        <div class="brand-title">
            <i class="bi bi-box-seam"></i> {{ __('Stock Manager') }}
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> {{ __('Dashboard') }}
                </a>
            </li>

            <div class="sidebar-section">{{ __('Inventory') }}</div>
            @if(auth()->user()->hasPermission('categories.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                    <i class="bi bi-tags"></i> {{ __('Categories') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('brands.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('brands.*') ? 'active' : '' }}" href="{{ route('brands.index') }}">
                    <i class="bi bi-bookmark-star"></i> {{ __('Brands') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('units.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('units.*') ? 'active' : '' }}" href="{{ route('units.index') }}">
                    <i class="bi bi-rulers"></i> {{ __('Units') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('products.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                    <i class="bi bi-box"></i> {{ __('Products') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('warehouses.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('warehouses.*') ? 'active' : '' }}" href="{{ route('warehouses.index') }}">
                    <i class="bi bi-building"></i> {{ __('Warehouses') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('suppliers.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                    <i class="bi bi-people"></i> {{ __('Suppliers') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('customers.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                    <i class="bi bi-person-lines-fill"></i> {{ __('Customers') }}
                </a>
            </li>
            @endif

            <div class="sidebar-section">{{ __('Transactions') }}</div>
            @if(auth()->user()->hasPermission('pos.access'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pos.*') ? 'active' : '' }}" href="{{ route('pos.index') }}">
                    <i class="bi bi-tv"></i> {{ __('POS') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('purchases.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}" href="{{ route('purchases.index') }}">
                    <i class="bi bi-cart-plus"></i> {{ __('Purchases') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('sales.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                    <i class="bi bi-cart-check"></i> {{ __('Sales') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('quotations.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('quotations.*') ? 'active' : '' }}" href="{{ route('quotations.index') }}">
                    <i class="bi bi-file-earmark-text"></i> {{ __('Quotations') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('purchase-returns.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('purchase-returns.*') ? 'active' : '' }}" href="{{ route('purchase-returns.index') }}">
                    <i class="bi bi-arrow-return-left"></i> {{ __('Purchase Returns') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('sale-returns.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('sale-returns.*') ? 'active' : '' }}" href="{{ route('sale-returns.index') }}">
                    <i class="bi bi-arrow-return-right"></i> {{ __('Sale Returns') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('payments.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}" href="{{ route('payments.index') }}">
                    <i class="bi bi-cash-stack"></i> {{ __('Payments') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('expenses.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('expenses.*') || request()->routeIs('expense-categories.*') ? 'active' : '' }}" href="{{ route('expenses.index') }}">
                    <i class="bi bi-wallet2"></i> {{ __('Expenses') }}
                </a>
            </li>
            @endif

            <div class="sidebar-section">{{ __('Stock') }}</div>
            @if(auth()->user()->hasPermission('stock-adjustments.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('stock-adjustments.*') ? 'active' : '' }}" href="{{ route('stock-adjustments.index') }}">
                    <i class="bi bi-sliders"></i> {{ __('Stock Adjustments') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('notifications.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}" href="{{ route('notifications.index') }}">
                    <i class="bi bi-bell"></i> {{ __('Notifications') }}
                </a>
            </li>
            @endif

            @if(auth()->user()->hasPermission('reports.view'))
            <div class="sidebar-section">{{ __('Reports') }}</div>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('reports.stock') ? 'active' : '' }}" href="{{ route('reports.stock') }}">
                    <i class="bi bi-clipboard-data"></i> {{ __('Stock Report') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('reports.purchase') ? 'active' : '' }}" href="{{ route('reports.purchase') }}">
                    <i class="bi bi-file-earmark-arrow-down"></i> {{ __('Purchase Report') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('reports.sale') ? 'active' : '' }}" href="{{ route('reports.sale') }}">
                    <i class="bi bi-file-earmark-arrow-up"></i> {{ __('Sale Report') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('reports.profit') ? 'active' : '' }}" href="{{ route('reports.profit') }}">
                    <i class="bi bi-graph-up-arrow"></i> {{ __('Profit / Loss') }}
                </a>
            </li>
            @endif

            @if(auth()->user()->hasPermission('users.view') || auth()->user()->hasPermission('roles.view') || auth()->user()->hasPermission('expense-categories.view') || auth()->user()->hasPermission('activity-logs.view') || auth()->user()->hasPermission('backups.manage') || auth()->user()->hasPermission('settings.manage'))
            <div class="sidebar-section">{{ __('Admin') }}</div>
            @if(auth()->user()->hasPermission('users.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <i class="bi bi-person-gear"></i> {{ __('Users') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('roles.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                    <i class="bi bi-shield-lock"></i> {{ __('Roles & Permissions') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('expense-categories.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('expense-categories.*') ? 'active' : '' }}" href="{{ route('expense-categories.index') }}">
                    <i class="bi bi-list-check"></i> {{ __('Expense Categories') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('activity-logs.view'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}" href="{{ route('activity-logs.index') }}">
                    <i class="bi bi-clock-history"></i> {{ __('Activity Log') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('backups.manage'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('backups.*') ? 'active' : '' }}" href="{{ route('backups.index') }}">
                    <i class="bi bi-hdd"></i> {{ __('Database Backup') }}
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermission('settings.manage'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                    <i class="bi bi-gear"></i> {{ __('Settings') }}
                </a>
            </li>
            @endif
            @endif
        </ul>

        <div class="user-info mt-auto">
            <div class="name"><i class="bi bi-person-circle"></i> <span>{{ Auth::user()->name }}</span></div>
            <div class="role">{{ __(Auth::user()->role->name) }}</div>
            <div class="lang-switch mt-2 mb-2">
                <i class="bi bi-translate" style="color:#64748b;"></i>
                <a href="{{ route('language.switch', 'bn') }}" class="{{ app()->getLocale() === 'bn' ? 'active-lang' : '' }}">বাংলা</a>
                |
                <a href="{{ route('language.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'active-lang' : '' }}">English</a>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light w-100">
                    <i class="bi bi-box-arrow-left"></i> {{ __('Logout') }}
                </button>
            </form>
        </div>
    </nav>

    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script>
        var dtLanguage = {
            processing: "{{ __('Processing...') }}",
            search: "{{ __('Search:') }}",
            lengthMenu: "{{ __('Show _MENU_ entries') }}",
            info: "{{ __('Showing _START_ to _END_ of _TOTAL_ entries') }}",
            infoEmpty: "{{ __('No data') }}",
            infoFiltered: "({{ __('Filtered from _MAX_ total entries') }})",
            zeroRecords: "{{ __('No data found.') }}",
            emptyTable: "{{ __('No data found.') }}",
            paginate: { first: "{{ __('First') }}", previous: "{{ __('Previous') }}", next: "{{ __('Next') }}", last: "{{ __('Last') }}" }
        };

        // Initialize tooltips
        function initTooltips() {
            var list = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            list.map(function(el) { return new bootstrap.Tooltip(el); });
        }
        document.addEventListener('DOMContentLoaded', initTooltips);
        $(document).on('draw.dt', initTooltips);

        // Auto-dismiss success alerts after 5s
        setTimeout(function() {
            document.querySelectorAll('.alert-success').forEach(function(el) {
                el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                el.style.opacity = '0';
                el.style.transform = 'translateY(-10px)';
                setTimeout(function() { el.remove(); }, 500);
            });
        }, 5000);
    </script>
    @stack('scripts')
</body>
</html>
