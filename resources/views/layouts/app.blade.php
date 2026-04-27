<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Suhaim Soft Lab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,600;0,700;0,800;1,700&display=swap" rel="stylesheet">
    <style>
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 18px;
            left: 20px;
            z-index: 1100;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            color: #1e3a8a;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 14px;
            width: 44px;
            height: 44px;
            padding: 0;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
            transition: all 0.3s;
            align-items: center;
            justify-content: center;
        }
        .sidebar-toggle:hover {
            background: #ffffff;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.15);
            transform: translateY(-1px);
        }
        * {
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: linear-gradient(120deg, #f0f4f8 0%, #e0e7ef 100%);
            color: #2d3748;
            margin: 0;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 4px 0 25px rgba(37, 99, 235, 0.05);
            color: #1e293b;
            padding-top: 30px;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            
            /* Hidden scrollbar */
            overflow-y: auto;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .sidebar::-webkit-scrollbar {
            display: none;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 35px;
            padding: 0 20px;
        }

        .brand-icon {
            font-size: 26px;
            color: var(--primary-color);
            margin-right: 12px;
            background: rgba(var(--primary-color-rgb, 37, 99, 235), 0.1);
            padding: 10px;
            border-radius: 14px;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.15);
        }

        .brand-text {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 0.2px;
            color: #1e3a8a;
            margin: 0;
            line-height: 1.2;
        }

        .sidebar a {
            padding: 12px 20px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            color: #64748b;
            display: flex;
            align-items: center;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            margin: 4px 20px;
            border-radius: 14px;
            background: transparent;
            border: 1px solid transparent;
        }
        .sidebar a:hover, .sidebar a.active {
            color: var(--primary-color);
            background: rgba(var(--primary-color-rgb, 37, 99, 235), 0.1);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
            transform: translateX(4px);
        }

        .sidebar a i {
            margin-right: 15px;
            font-size: 20px;
        }

        .logout-container {
            margin-top: auto;
            margin-bottom: 20px;
            padding: 0 20px;
        }

        .btn-logout {
            width: 100%;
            background: transparent;
            border: 2px solid #e2e8f0;
            padding: 10px 12px;
            border-radius: 12px;
            color: #64748b;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-logout:hover {
            background: #fee2e2;
            color: #ef4444;
            border-color: #fca5a5;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
        }

        /* Main Content */
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(120deg, #f8fafc 0%, #e2e8f0 100%);
        }
        
        .top-navbar {
            background: transparent;
            height: 80px;
            padding: 0 40px;
            display: flex;
            align-items: center;
            justify-content: flex-end; /* Push to right */
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 700;
            font-size: 14px;
            color: #1a202c;
            margin: 0;
        }

        .user-role {
            font-size: 11px;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 16px;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
        }

        /* Status Bar Styling */
        .status-bar {
            background: #fff;
            margin: 0 40px 20px 40px;
            padding: 12px 25px;
            border-radius: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            border: 1px solid rgba(226, 232, 240, 0.5);
        }
        .status-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
        }
        .status-item i {
            color: #2563eb;
            font-size: 16px;
        }
        .holiday-badge {
            background: #fef2f2;
            color: #dc2626;
            padding: 4px 12px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            border: 1px solid #fee2e2;
        }

        .content {
            padding: 40px;
            flex: 1;
        }

        .content {
            padding: 40px;
            flex: 1;
        }

        /* Modern Cards */
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); /* Softer, larger shadow */
            background: #fff;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 25px;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.08); /* Lift effect */
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #f0f4f8;
            padding: 20px 25px;
            font-weight: 800;
            font-size: 18px;
            color: #2b1d6f; /* Deep brand purple */
        }

        .card-body {
            padding: 25px;
        }

        /* Modern Tables */
        .table {
            color: #4a5568;
            vertical-align: middle;
        }
        .table thead th {
            border-bottom: 2px solid #e2e8f0;
            color: #718096;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            padding: 15px;
        }
        .table tbody td {
            padding: 15px;
            border-bottom: 1px solid #edf2f7;
            font-size: 14px;
        }

        /* Form Inputs */
        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #2d3748;
            font-size: 14px;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            background: #fff;
            border-color: #d946ef;
            box-shadow: 0 0 0 3px rgba(217, 70, 239, 0.15);
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
        }
        .btn-primary:hover {
            background: #1d4ed8;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            transform: translateY(-1px);
        }
        .btn-success { background: #10b981; border: none; border-radius: 10px; }
        .btn-warning { background: #f59e0b; border: none; color: white; border-radius: 10px;}
        .btn-danger { background: #ef4444; border: none; border-radius: 10px;}
        .btn-info { background: #3b82f6; border: none; color: white; border-radius: 10px;}

        /* Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .bg-success { background: rgba(16, 185, 129, 0.1) !important; color: #059669 !important; }
        .bg-warning { background: rgba(245, 158, 11, 0.1) !important; color: #d97706 !important; }
        .bg-danger { background: rgba(239, 68, 68, 0.1) !important; color: #b91c1c !important; }
        .bg-info { background: rgba(59, 130, 246, 0.1) !important; color: #1d4ed8 !important; }

        /* Dashboard specific highlights */
        .stat-card {
            border-left: 5px solid #d946ef;
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #1e3a8a 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 900;
            color: #fff;
            margin-right: 15px;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.10);
        }
            .top-navbar { padding: 0 20px; }
        
        /* Mobile Overrides (Must be at bottom of style block) */
        @media (max-width: 1024px) {
            .sidebar {
                left: -280px !important;
                margin: 0 !important;
                border-radius: 0 !important;
                height: 100vh !important;
                box-shadow: 10px 0 30px rgba(0, 0, 0, 0.1);
            }
            .sidebar.active {
                left: 0 !important;
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(15, 23, 42, 0.4);
                backdrop-filter: blur(4px);
                z-index: 990;
                opacity: 0;
                transition: opacity 0.3s;
            }
            .sidebar-overlay.active {
                display: block;
                opacity: 1;
            }
            .sidebar-toggle {
                display: flex;
            }
            .main-wrapper {
                margin-left: 0 !important;
            }
            .top-navbar {
                padding-left: 80px; /* Space for the floating button */
                justify-content: space-between;
            }
            .content {
                padding: 15px;
            }
        }

        /* Mobile Status Bar Adjustments */
        @media (max-width: 768px) {
            .status-bar {
                margin: 0 15px 15px 15px;
                padding: 12px;
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }
            .status-bar .d-flex {
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px !important;
            }
            .status-item.border-start {
                border-left: none !important;
                padding-left: 0 !important;
                border-top: 1px solid rgba(226, 232, 240, 0.5);
                padding-top: 10px;
                width: 100%;
                justify-content: center;
            }
        }

        /* Advanced UI Settings Styles */
        :root {
            --accent-blue: #2563eb;
            --accent-purple: #8b5cf6;
            --accent-emerald: #10b981;
            --accent-rose: #f43f5e;
            --accent-amber: #f59e0b;
            --accent-cyan: #06b6d4;
            --primary-color: var(--accent-blue);
        }

        html[data-accent="blue"] { --primary-color: var(--accent-blue); --primary-color-rgb: 37, 99, 235; }
        html[data-accent="purple"] { --primary-color: var(--accent-purple); --primary-color-rgb: 139, 92, 246; }
        html[data-accent="emerald"] { --primary-color: var(--accent-emerald); --primary-color-rgb: 16, 185, 129; }
        html[data-accent="rose"] { --primary-color: var(--accent-rose); --primary-color-rgb: 244, 63, 94; }
        html[data-accent="amber"] { --primary-color: var(--accent-amber); --primary-color-rgb: 245, 158, 11; }
        html[data-accent="cyan"] { --primary-color: var(--accent-cyan); --primary-color-rgb: 6, 182, 212; }

        .btn-primary, .bg-primary { background-color: var(--primary-color) !important; color: white !important; }
        .text-primary { background: none !important; color: var(--primary-color) !important; }
        .border-primary { border-color: var(--primary-color) !important; }

        /* Glassmorphism */
        .glass-ui .sidebar, .glass-ui .card, .glass-ui .top-navbar, .glass-ui .topbar-nav {
            background: rgba(255, 255, 255, 0.7) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
        }

        /* Compact Mode */
        .compact-ui .content { padding: 20px !important; }
        .compact-ui .card-body { padding: 15px !important; }
        .compact-ui .table tbody td, .compact-ui .table thead th { padding: 8px 12px !important; font-size: 13px; }
        .compact-ui .form-control { padding: 8px 12px !important; }

        /* Topbar Layout Mode */
        [data-layout="topbar"] .sidebar { display: none !important; }
        [data-layout="topbar"] .main-wrapper { margin-left: 0 !important; }
        [data-layout="topbar"] .topbar-nav { display: flex !important; }
        .topbar-nav { display: none; background: #fff; border-bottom: 1px solid #e2e8f0; padding: 0 40px; height: 60px; align-items: center; gap: 20px; }
        .topbar-nav a { text-decoration: none; color: #64748b; font-weight: 600; font-size: 14px; padding: 8px 12px; border-radius: 8px; transition: all 0.2s; }
        .topbar-nav a:hover, .topbar-nav a.active { background: #eff6ff; color: var(--primary-color); }
    </style>
    <style>
        /* Dark Mode Definitions */
        body.dark-mode {
            background-color: #0f172a !important;
            color: #f1f5f9 !important;
        }
        body.dark-mode .sidebar {
            background: #1e293b !important;
            border-right: 1px solid #334155 !important;
        }
        body.dark-mode .top-navbar {
            background: rgba(15, 23, 42, 0.8) !important;
            border-bottom: 1px solid #334155 !important;
        }
        body.dark-mode .card, 
        body.dark-mode .activity-panel,
        body.dark-mode .standard-table {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }
        body.dark-mode .text-dark,
        body.dark-mode h1, body.dark-mode h2, body.dark-mode h3, body.dark-mode h4, body.dark-mode h5, body.dark-mode h6 {
            color: #f1f5f9 !important;
        }
        body.dark-mode .text-muted {
            color: #94a3b8 !important;
        }
        body.dark-mode .bg-light {
            background-color: #334155 !important;
        }
        body.dark-mode .border {
            border-color: #334155 !important;
        }
        body.dark-mode .table {
            color: #f1f5f9 !important;
        }
        body.dark-mode .table thead {
            background: rgba(51, 65, 85, 0.5) !important;
        }
    </style>
    <script>
        // Immediate Theme & UI Check to prevent flash
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark') {
                document.documentElement.classList.add('dark-mode');
                document.body.classList.add('dark-mode');
            }
            
            const glass = localStorage.getItem('ui_glass') === 'true';
            const compact = localStorage.getItem('ui_compact') === 'true';
            const layout = localStorage.getItem('ui_layout') || 'sidebar';
            const accent = localStorage.getItem('ui_accent') || 'blue';
            
            if (glass) document.documentElement.classList.add('glass-ui');
            if (compact) document.documentElement.classList.add('compact-ui');
            document.documentElement.setAttribute('data-layout', layout);
            document.documentElement.setAttribute('data-accent', accent);
        })();
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body>
    @auth
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    <!-- Sidebar Toggle Button for Mobile -->
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fa fa-bars"></i>
    </button>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand d-flex justify-content-between align-items-center w-100 pe-3">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-flask brand-icon"></i>
                <h3 class="brand-text">Suhaim Soft Lab</h3>
            </div>
            <a href="javascript:location.reload();" class="btn btn-link p-0 text-white opacity-75 hover-opacity-100" title="Refresh Page">
                <i class="fa-solid fa-rotate-right" style="font-size: 14px;"></i>
            </a>
        </div>
        <div style="flex:1; overflow-y:auto; min-height:0; -ms-overflow-style:none; scrollbar-width:none;">
            @if(auth()->user()->hasPermission('dashboard'))
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-pie me-2"></i> Control Center</a>
            @endif
            
            <div class="mt-4 px-2">
                <div class="sidebar-heading small text-muted text-uppercase fw-bold mb-2 ps-2" style="font-size: 10px; letter-spacing: 1px;">Clinical Operations</div>
                @if(auth()->user()->hasPermission('registration_desk'))
                <a href="{{ route('admin.patients.index') }}" class="{{ request()->routeIs('admin.patients.*') ? 'active' : '' }}"><i class="fa-solid fa-user-injured me-2"></i> Registration Desk</a>
                @endif
                @if(auth()->user()->hasPermission('investigation_library'))
                <a href="{{ route('admin.test-types.index') }}" class="{{ request()->routeIs('admin.test-types.*') ? 'active' : '' }}"><i class="fa-solid fa-vials me-2"></i> Investigation Library</a>
                @endif
                @if(auth()->user()->hasPermission('reference_network'))
                <a href="{{ route('admin.doctors.index') }}" class="{{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}"><i class="fa-solid fa-user-doctor me-2"></i> Reference Network</a>
                @endif
                @if(auth()->user()->hasPermission('lab_bookings'))
                <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}"><i class="fa-solid fa-calendar-check me-2"></i> Lab Bookings</a>
                @endif
                @if(auth()->user()->hasPermission('diagnostic_reports'))
                <a href="{{ route('admin.test-reports') }}" class="{{ request()->routeIs('admin.test-reports') ? 'active' : '' }}"><i class="fa-solid fa-file-waveform me-2"></i> Test Reports</a>
                @endif
                @if(auth()->user()->hasPermission('report_dispatch'))
                <a href="{{ route('admin.reports.dispatch') }}" class="{{ request()->routeIs('admin.reports.dispatch') ? 'active' : '' }}"><i class="fa-solid fa-truck-ramp-box me-2"></i> Report Dispatch</a>
                @endif
                @if(auth()->user()->hasPermission('financial_analysis'))
                <a href="{{ route('admin.analysis.index') }}" class="{{ request()->routeIs('admin.analysis.index') ? 'active' : '' }}"><i class="fa-solid fa-chart-line me-2"></i> Financial & Sales Analysis</a>
                @endif
                @if(auth()->user()->hasPermission('operational_tasks'))
                <a href="{{ route('admin.tasks.index') }}" class="{{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}"><i class="fa-solid fa-list-check me-2"></i> Operational Tasks</a>
                @endif
            </div>

            @if(auth()->user()->hasPermission('infrastructure'))
            <div class="mt-4 px-2">
                <div class="sidebar-heading small text-muted text-uppercase fw-bold mb-2 ps-2" style="font-size: 10px; letter-spacing: 1px;">Infrastructure</div>
                @if(auth()->user()->hasPermission('hardware_matrix'))
                <a href="{{ route('admin.equipment.index') }}" class="{{ request()->routeIs('admin.equipment.*') ? 'active' : '' }}"><i class="fa-solid fa-microscope me-2"></i> Hardware Matrix</a>
                @endif
                @if(auth()->user()->hasPermission('facility_network'))
                <a href="{{ route('admin.labs.index') }}" class="{{ request()->routeIs('admin.labs.*') ? 'active' : '' }}"><i class="fa-solid fa-server me-2"></i> Facility Network</a>
                @endif
                @if(auth()->user()->hasPermission('financial_treasury'))
                <a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments.*') ? 'active' : '' }}"><i class="fa-solid fa-file-invoice-dollar me-2"></i> Financial Treasury</a>
                @endif
                @if(auth()->user()->hasPermission('payment_terminal'))
                <a href="{{ route('admin.terminal') }}" class="{{ request()->routeIs('admin.terminal') ? 'active' : '' }}"><i class="fa-solid fa-cash-register me-2"></i> Payment Terminal</a>
                @endif
            </div>
            @endif

            <div class="mt-4 px-2">
                <div class="sidebar-heading small text-muted text-uppercase fw-bold mb-2 ps-2" style="font-size: 10px; letter-spacing: 1px;">Management</div>
                @if(auth()->user()->hasPermission('network_operators'))
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fa-solid fa-users-gear me-2"></i> Network Operators</a>
                @endif
                @if(auth()->user()->hasPermission('system_protocol'))
                <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}"><i class="fa-solid fa-sliders me-2"></i> Operational Protocol</a>
                @endif
            </div>
            <div class="mt-4 px-2">
                <div class="sidebar-heading small text-muted text-uppercase fw-bold mb-2 ps-2" style="font-size: 10px; letter-spacing: 1px;">Assistance</div>
                <a href="{{ route('admin.support.index') }}" class="{{ request()->routeIs('admin.support.*') ? 'active' : '' }}"><i class="fa-solid fa-headset me-2"></i> Support Desk</a>
            </div>
        </div>
        <div class="logout-container" style="margin-top:auto;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</button>
            </form>
        </div>
    </div>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        <!-- Topbar Nav (Visible only in Topbar Layout) -->
        <div class="topbar-nav">
            <div class="d-flex align-items-center me-4">
                <i class="fa-solid fa-flask text-primary fs-4 me-2"></i>
                <span class="fw-bold text-dark">Suhaim Lab</span>
            </div>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Center</a>
            @if(!request()->routeIs('dashboard'))
            <a href="{{ route('dashboard') }}" class="btn btn-soft-primary btn-sm rounded-pill ms-2 fw-bold text-primary border-0 px-3" style="background: rgba(37, 99, 235, 0.1);">
                <i class="fa-solid fa-house-chimney me-1"></i> Dashboard
            </a>
            @endif
            <a href="{{ route('admin.patients.index') }}" class="{{ request()->routeIs('admin.patients.*') ? 'active' : '' }}">Patients</a>
            <a href="{{ route('admin.test-types.index') }}" class="{{ request()->routeIs('admin.test-types.*') ? 'active' : '' }}">Library</a>
            <a href="{{ route('admin.doctors.index') }}" class="{{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}">Doctors</a>
            <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">Bookings</a>
            <a href="{{ route('admin.test-reports') }}" class="{{ request()->routeIs('admin.test-reports') ? 'active' : '' }}">Diagnostics</a>
            <a href="{{ route('admin.settings') }}" class="ms-auto {{ request()->routeIs('admin.settings') ? 'active' : '' }}"><i class="fa-solid fa-gear"></i> Operational Protocol</a>
        </div>

        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="d-flex align-items-center me-auto d-none d-lg-flex">
                <span class="badge bg-light text-dark border py-2 px-3 rounded-pill" style="font-size: 12px;">
                    <i class="fa-solid fa-shield-halved text-primary me-2"></i> Suhaim Soft Protection Active
                </span>
            </div>
            <div class="user-profile">
                <!-- Task Notification Bell -->
                <div class="dropdown me-3 position-relative">
                    <button class="btn btn-link p-0 text-muted position-relative shadow-none" type="button" id="taskNotificationBell" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-bell fs-4"></i>
                        <span id="taskNotificationCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none" style="font-size: 9px; padding: 3px 6px;">
                            0
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-0 mt-3" aria-labelledby="taskNotificationBell" style="width: 320px; border-radius: 20px; overflow: hidden;">
                        <div class="p-3 bg-primary text-white d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold">Operational Tasks</h6>
                            <span class="badge bg-white text-primary rounded-pill small" id="taskCountBadge">0 New</span>
                        </div>
                        <div id="taskNotificationList" style="max-height: 350px; overflow-y: auto;">
                            <!-- Tasks will be loaded here via AJAX -->
                            <div class="p-4 text-center text-muted small">
                                <i class="fa-solid fa-check-double fs-2 mb-2 opacity-25"></i>
                                <p class="mb-0">All tasks completed!</p>
                            </div>
                        </div>
                        <div class="p-2 border-top bg-light text-center">
                            <a href="{{ route('admin.tasks.index') }}" class="text-primary small fw-bold text-decoration-none">View All Tasks</a>
                        </div>
                    </div>
                </div>

                <div class="user-info">
                    <p class="user-name">{{ auth()->user()->name }}</p>
                    <p class="user-role">{{ ucfirst(auth()->user()->role) }} Control</p>
                </div>
                <!-- Initial of the user -->
                <div class="avatar">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </div>

        <!-- Status Bar with Real-time Clock & Holiday -->
        <div class="status-bar d-flex">
            <div class="d-flex gap-4">
                <div class="status-item">
                    <i class="fa-regular fa-calendar-check"></i>
                    <span id="current-date">Loading...</span>
                </div>
                <div class="status-item">
                    <i class="fa-regular fa-clock"></i>
                    <span id="current-time">00:00:00</span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="status-item border-start ps-3">
                    <i class="fa-solid fa-wifi text-success"></i>
                    <span class="text-success">System Online</span>
                </div>
            </div>
        </div>

        <!-- Dynamic Page Content -->
        <div class="content">
            @yield('content')
        </div>
    </div>
    @else
        <!-- For non-authenticated pages using this layout fallback -->
        <div class="content" style="margin-left: 0; padding: 0;">
            @yield('content')
        </div>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
            const overlay = document.querySelector('.sidebar-overlay');
            if (overlay) {
                if (overlay.classList.contains('active')) {
                    overlay.classList.remove('active');
                    setTimeout(() => { overlay.style.display = 'none'; }, 300);
                } else {
                    overlay.style.display = 'block';
                    setTimeout(() => { overlay.classList.add('active'); }, 10);
                }
            }
        }

        // Intercept form submissions to show the loading screen
        document.addEventListener('DOMContentLoaded', function() {
            // Loader logic removed
            
            // Real-time Clock
            function updateClock() {
                const now = new Date();
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                document.getElementById('current-date').textContent = now.toLocaleDateString('en-US', options);
                document.getElementById('current-time').textContent = now.toLocaleTimeString('en-US', { hour12: true });
            }
            setInterval(updateClock, 1000);
            updateClock();

            // Live Network Detection
            function updateNetworkStatus() {
                const wifiIcon = document.querySelector('.status-item i.fa-wifi');
                const statusText = document.querySelector('.status-item span.text-success, .status-item span.text-danger');
                
                if (navigator.onLine) {
                    if (wifiIcon) wifiIcon.className = 'fa-solid fa-wifi text-success';
                    if (statusText) {
                        statusText.className = 'text-success';
                        statusText.textContent = 'System Online';
                    }
                } else {
                    if (wifiIcon) wifiIcon.className = 'fa-solid fa-plane-slash text-danger';
                    if (statusText) {
                        statusText.className = 'text-danger';
                        statusText.textContent = 'System Offline';
                    }
                }
            }
            window.addEventListener('online', updateNetworkStatus);
            window.addEventListener('offline', updateNetworkStatus);
            function fetchRecentTasks() {
                fetch('{{ route("admin.tasks.recent") }}')
                    .then(response => response.json())
                    .then(tasks => {
                        const count = tasks.length;
                        const countBadge = document.getElementById('taskNotificationCount');
                        const countBadgeHeader = document.getElementById('taskCountBadge');
                        const listContainer = document.getElementById('taskNotificationList');

                        if (count > 0) {
                            if (countBadge) {
                                countBadge.textContent = count;
                                countBadge.classList.remove('d-none');
                            }
                            if (countBadgeHeader) countBadgeHeader.textContent = count + ' Pending';
                            
                            if (listContainer) {
                                listContainer.innerHTML = tasks.map(task => `
                                    <a href="{{ route('admin.tasks.index') }}" class="dropdown-item p-3 border-bottom d-flex align-items-start gap-3" style="white-space: normal;">
                                        <div class="rounded-circle bg-soft-primary p-2 text-primary">
                                            <i class="fa-solid fa-thumbtack"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-bold small text-dark">${task.title}</span>
                                                <span class="badge bg-soft-warning text-warning" style="font-size: 9px;">${task.status}</span>
                                            </div>
                                            <p class="mb-0 text-muted small" style="font-size: 11px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                ${task.description || 'No description provided.'}
                                            </p>
                                        </div>
                                    </a>
                                `).join('');
                            }
                        } else {
                            if (countBadge) countBadge.classList.add('d-none');
                            if (countBadgeHeader) countBadgeHeader.textContent = '0 New';
                            if (listContainer) {
                                listContainer.innerHTML = `
                                    <div class="p-4 text-center text-muted small">
                                        <i class="fa-solid fa-check-double fs-2 mb-2 opacity-25"></i>
                                        <p class="mb-0">All tasks completed!</p>
                                    </div>
                                `;
                            }
                        }
                    })
                    .catch(err => console.error('Error fetching tasks:', err));
            }

            // Initial fetch and set interval
            fetchRecentTasks();
            setInterval(fetchRecentTasks, 30000); 
            updateNetworkStatus();
        });
    </script>
    @stack('scripts')
</body>
</html>
