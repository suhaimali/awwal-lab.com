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
        /* Responsive Sidebar Toggle */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1100;
            background: linear-gradient(90deg, #06b6d4 0%, #a78bfa 100%);
            color: #fff;
            border: none;
            border-radius: 50%;
            padding: 14px 18px;
            font-size: 26px;
            box-shadow: 0 2px 16px rgba(6,182,212,0.18);
            transition: background 0.3s;
        }
        .sidebar-toggle:hover {
            background: linear-gradient(90deg, #a78bfa 0%, #06b6d4 100%);
        }
        @media (max-width: 1024px) {
            .sidebar {
                position: fixed;
                left: -260px;
                top: 0;
                width: 260px;
                height: 100vh;
                transition: left 0.3s;
                z-index: 1000;
                box-shadow: 4px 0 24px rgba(124,58,237,0.18);
            }
            .sidebar.active {
                left: 0;
            }
            .sidebar-toggle {
                display: block;
            }
            .main-wrapper {
                margin-left: 0;
            }
            .content {
                padding: 20px;
            }
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
            background: linear-gradient(135deg, #06b6d4 0%, #a78bfa 50%, #f472b6 100%);
            box-shadow: 4px 0 32px rgba(6,182,212,0.18);
            color: #fff;
            padding-top: 30px;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: background 0.4s;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #a78bfa #f0f4f8;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 40px;
        }

        .logo-box {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 800;
            position: relative;
            margin-right: 15px;
        }
        .logo-box span:nth-child(1) { color: #f52988; }
        .logo-box span:nth-child(2) { color: #fff; }
        
        .brand-text h3 {
            margin: 0;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 1px;
            color: #fff;
        }
        .brand-text span {
            font-size: 10px;
            color: #d946ef;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .sidebar a {
            padding: 15px 25px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            color: #f3e8ff;
            display: flex;
            align-items: center;
            transition: background 0.25s, color 0.25s, box-shadow 0.25s;
            position: relative;
            margin: 4px 12px;
            border-radius: 10px;
            background: rgba(255,255,255,0.06);
            box-shadow: 0 2px 8px rgba(6,182,212,0.08);
        }
        .sidebar a:hover, .sidebar a.active {
            color: #fff;
            background: linear-gradient(90deg,#f472b6,#a78bfa);
            box-shadow: 0 4px 16px rgba(167,139,250,0.15);
        }

        .sidebar a i {
            margin-right: 15px;
            font-size: 20px;
        }

        .logout-container {
            margin-top: auto;
            margin-bottom: 30px;
            padding: 0 15px;
        }

        .btn-logout {
            width: 100%;
            background: linear-gradient(90deg, #d946ef, #f52988);
            border: none;
            padding: 12px;
            border-radius: 10px;
            color: white;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(245, 41, 136, 0.3);
        }

        /* Main Content */
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(120deg, #f0f4f8 0%, #e0e7ef 100%);
        }
        
        .top-navbar {
            background: #fff;
            height: 80px;
            padding: 0 40px;
            display: flex;
            align-items: center;
            justify-content: flex-end; /* Push to right */
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            border-bottom: 1px solid #e1e8f0;
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
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2b1d6f 0%, #b8227b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
            border: 3px solid #fff;
            box-shadow: 0 2px 10px rgba(184, 34, 123, 0.3);
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
            background: linear-gradient(90deg, #7c3aed, #d946ef);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 10px rgba(217, 70, 239, 0.2);
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #6d28d9, #c026d3);
            box-shadow: 0 6px 15px rgba(217, 70, 239, 0.3);
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
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #f52988 0%, #7c3aed 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 900;
            color: #fff;
            margin-right: 15px;
            box-shadow: 0 2px 8px rgba(245,41,136,0.10);
        }
            .top-navbar { padding: 0 20px; }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    @auth
    <!-- Sidebar Toggle Button for Mobile -->
    <button class="sidebar-toggle" onclick="document.querySelector('.sidebar').classList.toggle('active')">
        <i class="fa fa-bars"></i>
    </button>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="logo-box">
                <span>S</span><span>S</span><span>L</span>
            </div>
            <div class="brand-text">
                <h3>SUHAIM SOFT LAB</h3>
                <span>Control Panel</span>
            </div>
        </div>
        <div style="flex:1; overflow-y:auto; min-height:0;">
        @if(auth()->user()->role == 'admin')
            <a href="{{ route('dashboard') }}" class="sidebar-link btn btn-light mb-2 w-100 text-start"><i class="fa-solid fa-chart-pie me-2"></i> Dashboard</a>
            <div class="mt-3 px-2">
                <div class="fw-bold text-secondary mb-2" style="font-size:13px; letter-spacing:1px;">Management</div>
                <a href="{{ route('patients.index') }}" class="btn btn-outline-primary mb-2 w-100 text-start"><i class="fa-solid fa-user-injured me-2"></i> Patient</a>
                <a href="#" class="btn btn-outline-primary mb-2 w-100 text-start" onclick="comingSoon(event)"><i class="fa-solid fa-vials me-2"></i> Tests</a>
                <a href="#admin-bookings" class="btn btn-outline-primary mb-2 w-100 text-start" onclick="showBookingsPage(event)"><i class="fa-solid fa-table-list me-2"></i> Bookings</a>
                <a href="#" class="btn btn-outline-primary mb-2 w-100 text-start" onclick="comingSoon(event)"><i class="fa-solid fa-chart-line me-2"></i> Reports & Analytics</a>
                <a href="/admin/test-reports" class="btn btn-outline-primary mb-2 w-100 text-start"><i class="fa-solid fa-file-medical me-2"></i> Test Reports</a>
                <script>
                function comingSoon(e) {
                    e.preventDefault();
                    alert('Coming Soon');
                }
                function showBookingsPage(e) {
                    e.preventDefault();
                    // If you want to show a coming soon message for Bookings, uncomment below:
                    // alert('Bookings page coming soon!');
                    // Otherwise, redirect to the real page:
                    window.location.href = '/admin/bookings';
                }
                </script>
                <a href="/payments" class="btn btn-outline-primary mb-2 w-100 text-start"><i class="fa-solid fa-money-check-dollar me-2"></i> Payments</a>
            </div>
            <div class="mt-3 px-2">
                <div class="fw-bold text-secondary mb-2" style="font-size:13px; letter-spacing:1px;">System Settings</div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-dark mb-2 w-100 text-start"><i class="fa-solid fa-users-gear me-2"></i> Users Management</a>
                <a href="{{ route('settings') }}" class="btn btn-outline-dark w-100 text-start"><i class="fa-solid fa-gear me-2"></i> System Settings</a>
            </div>
        @elseif(auth()->user()->role == 'staff')
            <a href="{{ route('dashboard') }}"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
            <a href="{{ route('staff.equipment.index') }}"><i class="fa-solid fa-tools"></i> Manage Equipment</a>
        @elseif(auth()->user()->role == 'student')
            <a href="{{ route('dashboard') }}"><i class="fa-solid fa-chart-pie"></i> My Dashboard</a>
            <a href="{{ route('student.labs.index') }}"><i class="fa-solid fa-vial-circle-check"></i> Explore Labs</a>
            <a href="{{ route('student.bookings.create') }}"><i class="fa-solid fa-calendar-plus"></i> Request Booking</a>
        @endif
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
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="user-profile">
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
    </script>
</body>
</html>

