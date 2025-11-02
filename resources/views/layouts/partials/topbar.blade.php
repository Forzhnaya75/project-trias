<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
    <!-- Tombol toggle sidebar -->
    <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle">
        <i data-feather="menu"></i>
    </button>

        <!-- Brand -->
    <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="
        @if(Auth::user()->role === 'super_admin')
        {{ route('dashboard.superadmin') }}
        @elseif(Auth::user()->role === 'admin')
        {{ route('dashboard.admin') }}
        @else
        {{ route('dashboard.teknisi') }}
        @endif
    ">
        TRIAS Group
    </a>

    <!-- Right Menu -->
    <ul class="navbar-nav align-items-center ms-auto">
        <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
            <!-- Avatar dropdown toggle -->
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="img-fluid rounded-circle"
                     src="{{ Auth::user()->profile_picture 
                            ? asset('storage/' . Auth::user()->profile_picture) 
                            : asset('sbadmin/assets/img/illustrations/profiles/profile-1.png') }}"
                     alt="User Avatar" style="width: 40px; height: 40px; object-fit: cover;" />
            </a>

            <!-- Dropdown -->
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                <h6 class="dropdown-header d-flex align-items-center">
                    <img class="dropdown-user-img rounded-circle"
                         src="{{ Auth::user()->profile_picture 
                                ? asset('storage/' . Auth::user()->profile_picture) 
                                : asset('sbadmin/assets/img/illustrations/profiles/profile-1.png') }}"
                         alt="User Avatar" style="width: 45px; height: 45px; object-fit: cover;" />
                    <div class="dropdown-user-details ms-2">
                        <div class="dropdown-user-details-name">{{ Auth::user()->username ?? 'User' }}</div>
                        <div class="dropdown-user-details-email">{{ Auth::user()->email ?? '-' }}</div>
                    </div>
                </h6>
                <div class="dropdown-divider"></div>

                <!-- Link ke halaman profil -->
                <a class="dropdown-item" href="{{ route('profile') }}">
                    <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                    Pengaturan Profil
                </a>

                <!-- Logout -->
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
