<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title', 'TRIAS Group')</title>

    <!-- SB Admin CSS -->
    <link href="{{ asset('sbadmin/css/styles.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('sbadmin/assets/img/logo trias.png') }}" />

    <!-- FontAwesome + Feather -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"
        crossorigin="anonymous"></script>

    <!-- 🔹 Compact Table Style (lebih luas & padat) -->
    <style>
        /* ====== Compact Table Style (lebih luas dan padat) ====== */
        .table {
            font-size: 0.9rem;
            /* ukuran standar agar lebih terbaca */
            border-collapse: collapse;
            white-space: nowrap;
        }

        .table th {
            background-color: #f8fafc;
            font-weight: 600;
            text-transform: capitalize;
            font-size: 0.85rem;
        }

        .table td,
        .table th {
            padding: 1.25rem;
            /* jarak lebih lega lagi */
            line-height: 1.6;
            /* spasi antar baris */
            vertical-align: middle;
            border-color: #dee2e6;
        }

        /* ====== Tampilan Baris ====== */
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9fafc;
        }

        .table-hover tbody tr:hover {
            background-color: #eef2ff;
            transition: 0.2s ease;
        }

        /* ====== Wrapper Responsif ====== */
        .table-responsive {
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }

        /* ====== Perbaiki tampilan teks kolom ====== */
        .table td {
            white-space: normal !important;
            word-wrap: break-word;
            max-width: 250px;
            /* sedikit lebih kecil */
        }

        /* ====== Estetika Umum ====== */
        .card {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        h4,
        h5 {
            color: #1e293b;
        }

        .btn {
            border-radius: 50px;
            font-size: 0.8rem;
            /* tombol ikut lebih kecil */
            padding: 0.3rem 0.9rem;
        }

        /* ====== Sticky Header opsional (biar header tetap di atas saat scroll) ====== */
        .table thead th {
            position: sticky;
            top: 0;
            z-index: 5;
            background-color: #f8fafc;
        }
    </style>
</head>

<body class="nav-fixed">

    {{-- 🔹 Topbar --}}
    @include('layouts.partials.topbar')

    <div id="layoutSidenav">
        {{-- 🔹 Sidebar --}}
        @include('layouts.partials.sidebar')

        <div id="layoutSidenav_content">
            <main>
                {{-- 🔹 Konten utama halaman --}}
                <div class="container-fluid px-0" style="max-width: 100vw;">
                    @yield('content')
                </div>
            </main>

            {{-- 🔹 Footer --}}
            <footer class="footer-admin mt-auto footer-light">
                <div class="container-fluid px-4">
                    <div class="small">Copyright &copy; TRIAS Group {{ date('Y') }}</div>
                </div>
            </footer>
        </div>
    </div>

    <!-- 🔹 Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>

    <!-- 🔹 Feather Icons -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            feather.replace();
        });
    </script>

    <!-- 🔹 SB Admin Custom Script -->
    <script src="{{ asset('sbadmin/js/scripts.js') }}"></script>

    {{-- 🔹 Slot script untuk halaman --}}
    @yield('scripts')
</body>

</html>