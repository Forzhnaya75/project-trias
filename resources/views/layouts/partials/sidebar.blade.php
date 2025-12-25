<!-- resources/views/layouts/partials/sidebar.blade.php -->
<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">

                <div class="sidenav-menu-heading">Menu</div>

                <!-- Dashboard (Superadmin) -->
                @if(Auth::user()->role === 'superadmin')
                <a class="nav-link" href="{{ route('dashboard.superadmin') }}">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboard
                </a>
                @endif

                <!-- Dashboard (Admin) -->
                @if(Auth::user()->role === 'admin')
                <a class="nav-link" href="{{ route('dashboard.admin') }}">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboard
                </a>
                @endif

                <!-- Dashboard (Teknisi) -->
                @if(Auth::user()->role === 'teknisi')
                <a class="nav-link" href="{{ route('dashboard.teknisi') }}">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboard
                </a>
                @endif

                <!-- Monitoring Dropdown (Accessible by all authorized roles) -->
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

                <!-- Manajemen User Dropdown (Superadmin ONLY) -->
                @if(Auth::user()->role === 'superadmin')
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUser"
                   aria-expanded="false" aria-controls="collapseUser">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Manajemen User
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseUser" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('users.index', ['role' => 'admin']) }}">Admin</a>
                        <a class="nav-link" href="{{ route('users.index', ['role' => 'teknisi']) }}">Teknisi</a>
                    </nav>
                </div>
                @endif


            </div>
        </div>

        <!-- Footer -->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Halo, Selamat datang</div>
                <div class="sidenav-footer-title d-flex align-items-center">
                    <img class="img-fluid rounded-circle me-2"
                         src="{{ Auth::user()->profile_picture ? Storage::url(Auth::user()->profile_picture) . '?v=' . time() : asset('sbadmin/assets/img/illustrations/profiles/profile-1.png') }}"
                         onerror="this.onerror=null; this.src='{{ asset('sbadmin/assets/img/illustrations/profiles/profile-1.png') }}';"
                         style="width: 30px; height: 30px; object-fit: cover;">
                    {{ Auth::user()->username ?? 'Guest' }}
                </div>
            </div>
        </div>
    </nav>
</div>
