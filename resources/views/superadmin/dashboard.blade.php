<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title', 'TRIAS Group')</title>

    <!-- SB Admin CSS -->
    <link href="{{ asset('sbadmin/css/styles.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('sbadmin/assets/img/favicon.png') }}" />

    <!-- FontAwesome + Feather -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"
        crossorigin="anonymous"></script>
</head>
<body class="nav-fixed">

    {{-- 🔹 Topbar --}}
    @include('layouts.partials.topbar')

    <div id="layoutSidenav">
        {{-- 🔹 Sidebar --}}
        @include('layouts.partials.sidebar')

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    @yield('content')
                </div>
            </main>
            <footer class="footer-admin mt-auto footer-light">
                <div class="container-fluid px-4">
                    <div class="small">Copyright &copy; TRIAS Group {{ date('Y') }}</div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Bootstrap Bundle (sudah ada Popper.js untuk dropdown) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>

    <!-- Feather Icons Init -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            feather.replace();
        });
    </script>

    <!--  SB Admin Custom Script -->
    <script src="{{ asset('sbadmin/js/scripts.js') }}"></script>
</body>
</html>
