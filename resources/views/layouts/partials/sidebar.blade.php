<!-- resources/views/layouts/partials/sidebar.blade.php -->
<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">

                <div class="sidenav-menu-heading">Menu</div>

                <!-- Dashboard -->
                <a class="nav-link" href="{{ route('dashboard.superadmin') }}">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboard
                </a>

                <!-- Monitoring Dropdown -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMonitoring"
                   aria-expanded="false" aria-controls="collapseMonitoring">
                    <div class="nav-link-icon"><i data-feather="file-text"></i></div>
                    Monitoring
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseMonitoring" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('monitoring.pekerjaan') }}">Pekerjaan</a>
                    </nav>
                </div>

                <!-- Manajemen User Dropdown -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUser"
                   aria-expanded="false" aria-controls="collapseUser">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Manajemen User
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseUser" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="#">Admin</a>
                        <a class="nav-link" href="#">Teknisi</a>
                    </nav>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Halo, Selamat datang</div>
                <div class="sidenav-footer-title">{{ Auth::user()->username ?? 'Guest' }}</div>
            </div>
        </div>
    </nav>
</div>
