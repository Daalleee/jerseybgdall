<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JerseyDall - Jual Beli Jersey Online')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    @yield('styles')
</head>
<body>
    <!-- Top Navbar -->
    <nav class="top-navbar">
        <button class="sidebar-toggle-btn d-none d-md-block" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Mobile toggle button that moves to top-right on small screens -->
        <button class="sidebar-toggle-btn d-md-none ms-2" id="mobileSidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        @auth
            @if(Auth::user()->isAdmin())
                <a class="navbar-brand d-none d-md-block" href="{{ route('admin.dashboard') }}">JerseyDall</a>
                <a class="navbar-brand d-md-none" href="{{ route('admin.dashboard') }}">JD</a>
            @else
                <a class="navbar-brand d-none d-md-block" href="{{ route('customer.dashboard') }}">JerseyDall</a>
                <a class="navbar-brand d-md-none" href="{{ route('customer.dashboard') }}">JD</a>
            @endif
        @else
            <a class="navbar-brand d-none d-md-block" href="{{ url('/') }}">JerseyDall</a>
            <a class="navbar-brand d-md-none" href="{{ url('/') }}">JD</a>
        @endauth
        
        <ul class="navbar-nav ms-auto">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user"></i> <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); 
                                        if(confirm('Apakah Anda yakin ingin keluar dari aplikasi?')) {
                                            document.getElementById('logout-form').submit();
                                        }">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            @endguest
        </ul>
    </nav>



    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="p-3 text-center border-bottom">
            <h5 class="text-white mb-0">
                @auth
                    @if(Auth::user()->isAdmin())
                        Admin Panel
                    @else
                        Pelanggan
                    @endif
                @endauth
            </h5>
        </div>
        
        <ul class="nav flex-column mt-3">
            @auth
                @if(Auth::user()->isAdmin())
                    <!-- Admin Navigation -->
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-3"></i>
                            <span class="sidebar-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.jerseys.index') }}">
                            <i class="fas fa-tshirt me-3"></i>
                            <span class="sidebar-text">Manajemen Jersey</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.transactions.index') }}">
                            <i class="fas fa-exchange-alt me-3"></i>
                            <span class="sidebar-text">Transaksi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.jerseys.system') }}">
                            <i class="fas fa-tshirt me-3"></i>
                            <span class="sidebar-text">Jersey Sistem</span>
                        </a>
                    </li>
                @else
                    <!-- Customer Navigation -->
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('customer.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-3"></i>
                            <span class="sidebar-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('customer.profile') }}">
                            <i class="fas fa-user me-3"></i>
                            <span class="sidebar-text">Profil Saya</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('jerseys.sell.form') }}">
                            <i class="fas fa-upload me-3"></i>
                            <span class="sidebar-text">Jual Jersey</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('transactions.customer.bought') }}">
                            <i class="fas fa-shopping-cart me-3"></i>
                            <span class="sidebar-text">Pembelian Saya</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('transactions.customer.sold') }}">
                            <i class="fas fa-hand-holding-usd me-3"></i>
                            <span class="sidebar-text">Penjualan Saya</span>
                        </a>
                    </li>
                @endif
            @endauth
        </ul>
    </div>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span>&copy; {{ date('Y') }} JerseyDall. All rights reserved.</span>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const desktopToggleBtn = document.getElementById('sidebarToggle');
            const mobileToggleBtn = document.getElementById('mobileSidebarToggle');
            
            // Check if sidebar state is stored in localStorage
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
                document.body.classList.add('sidebar-collapsed');
            }
            
            // Function to handle sidebar toggle for both desktop and mobile
            function toggleSidebar() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                
                // Toggle body class for navbar adjustment
                document.body.classList.toggle('sidebar-collapsed');
                
                // Store the state in localStorage
                const isCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            }
            
            desktopToggleBtn.addEventListener('click', toggleSidebar);
            mobileToggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
        });
    </script>
    @yield('scripts')
</body>
</html>