<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Thalassemia') }} - @yield('title', 'Dashboard')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: #f5f7fa;
            overflow-x: hidden;
        }

        /* Top Navbar */
        .top-navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 22px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .navbar-user img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #667eea;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: #2d3748;
            margin: 0;
        }

        .user-role {
            font-size: 12px;
            color: #718096;
            margin: 0;
        }

        .btn-logout {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }

        /* Dashboard Layout */
        .dashboard-wrapper {
            display: flex;
            min-height: calc(100vh - 64px);
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 0;
            position: sticky;
            top: 64px;
            height: calc(100vh - 64px);
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }

        .sidebar-header {
            padding: 0 25px 30px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h5 {
            margin: 0;
            font-weight: 600;
            font-size: 18px;
        }

        .sidebar-header p {
            margin: 5px 0 0;
            font-size: 13px;
            opacity: 0.8;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin: 5px 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
            opacity: 0.8;
            font-size: 15px;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.15);
            opacity: 1;
            border-left: 3px solid white;
            padding-left: 22px;
        }

        .sidebar-menu i {
            margin-right: 12px;
            font-size: 18px;
            width: 20px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 30px;
            background: #f5f7fa;
            min-height: calc(100vh - 64px);
        }

        /* Page Header */
        .page-header {
            margin-bottom: 30px;
        }

        .page-header h2 {
            margin: 0;
            font-weight: 700;
            color: #2d3748;
            font-size: 28px;
        }

        .page-header p {
            margin: 5px 0 0;
            color: #718096;
        }

        /* Breadcrumb */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 20px;
        }

        .breadcrumb-item a {
            color: #667eea;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #718096;
        }

        /* Card Styles */
        .content-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border: none;
            margin-bottom: 20px;
        }

        .content-card h5 {
            margin: 0 0 20px;
            font-weight: 600;
            color: #2d3748;
        }

        /* Mobile Toggle Button */
        .mobile-toggle {
            display: none;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 20px;
            cursor: pointer;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: fixed;
                top: 64px;
                left: -100%;
                transition: left 0.3s;
                z-index: 999;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                padding: 20px;
            }

            .mobile-toggle {
                display: block;
            }

            .user-info {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 18px;
            }

            .page-header h2 {
                font-size: 22px;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Top Navbar -->
    <nav class="top-navbar">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <button class="mobile-toggle" onclick="toggleSidebar()">☰</button>
                    <a class="navbar-brand" href="{{ route('home') }}">
                        Thalassemia
                    </a>
                </div>

                <div class="navbar-user">
                    <div class="user-info">
                        <p class="user-name">{{ Auth::user()->email }}</p>
                        <p class="user-role">Administrator</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=667eea&color=fff" alt="User">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-logout">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Dashboard Layout -->
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h5>Navigation</h5>
                <p>Main Menu</p>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        <i>📊</i>
                        <span>Dashboard</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('tickets.index') }}" class="{{ request()->is('tickets*') ? 'active' : '' }}">
                        <i>🎫</i>
                        <span>Tickets</span>
                    </a>
                </li> --}}
                <li>
                    <a href="{{ route('reports.index') }}" class="{{ request()->is('reports*') ? 'active' : '' }}">
                        <i>📝</i>
                        <span>Reports</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('manage-ticket') }}" class="{{ request()->is('manage-ticket') ? 'active' : '' }}">
                        <i>📝</i>
                        <span>Manage Tickets</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-toggle');

            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
