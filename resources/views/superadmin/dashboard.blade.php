<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Superadmin Dashboard PT Tri Agung Sinergi- TRIAS Group</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />

    <link href="{{ asset('sbadmin/css/styles.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('sbadmin/assets/img/logo trias.png') }}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
</head>
<body class="nav-fixed">

    @include('layouts.partials.topbar')

    <div id="layoutSidenav">
        @include('layouts.partials.sidebar')

        <div id="layoutSidenav_content">
            <main>
                <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                    <div class="container-xl px-4">
                        <div class="page-header-content pt-4">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mt-4">
                                    <h1 class="page-header-title">
                                        <div class="page-header-icon"><i data-feather="activity"></i></div>
                                        SuperAdmin Dashboard
                                    </h1>
                                    <div class="page-header-subtitle">Electrical and Automation Specialist</div>
                                </div>
                                <div class="col-12 col-xl-auto mt-4">
                                    <div class="text-white text-xl-end mb-1" style="font-weight: 500; font-size: 1.1rem;" id="realTimeClock"></div>
                                    <div class="text-white-50 text-xl-end small" id="weatherWidget">
                                        <div class="spinner-border spinner-border-sm text-white-50" role="status"></div> Loading weather...
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Main Content -->
                <div class="container-xl px-4 mt-n10">
                    
                    <!-- Welcome Card -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body p-5">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-7">
                                    <h2 class="text-primary fw-bold">Selamat Datang !</h2>
                                    <p class="text-gray-700 lead mb-0">Anda memiliki akses penuh untuk mengelola pengguna (Admin/Teknisi) baru dan memantau seluruh aktivitas dokumen dalam Sistem Manajemen Dokumen TRIAS Group</p>
                                </div>
                                <div class="col-lg-5 text-center d-none d-lg-block">
                                   <img class="img-fluid" src="{{ asset('sbadmin/assets/img/illustrations/statistics.svg') }}" style="max-width: 20rem" alt="Dashboard" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Users -->
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="card bg-purple text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-white-75 small">Total User</div>
                                            <div class="text-lg fw-bold">{{ $totalUsers }} User</div>
                                        </div>
                                        <i class="feather-xl text-white-50" data-feather="users"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between small">
                                    <a class="text-white stretched-link" href="{{ route('users.index') }}">Kelola User</a>
                                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="card bg-blue text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-white-75 small">Total Admin</div>
                                            <div class="text-lg fw-bold">{{ $totalAdmins }} Admin</div>
                                        </div>
                                        <i class="feather-xl text-white-50" data-feather="shield"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between small">
                                    <a class="text-white stretched-link" href="{{ route('users.index', ['role' => 'admin']) }}">Lihat Admin</a>
                                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="card bg-teal text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-white-75 small">Total Teknisi</div>
                                            <div class="text-lg fw-bold">{{ $totalTeknisi }} Teknisi</div>
                                        </div>
                                        <i class="feather-xl text-white-50" data-feather="tool"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between small">
                                    <a class="text-white stretched-link" href="{{ route('users.index', ['role' => 'teknisi']) }}">Lihat Teknisi</a>
                                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Documents -->
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card bg-primary text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-white-75 small">Total Pekerjaan</div>
                                            <div class="text-lg fw-bold">{{ $totalPekerjaan }} Doc</div>
                                        </div>
                                        <i class="feather-xl text-white-50" data-feather="folder"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card bg-warning text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-white-75 small">Proses</div>
                                            <div class="text-lg fw-bold">{{ $totalProses }} Doc</div>
                                        </div>
                                        <i class="feather-xl text-white-50" data-feather="loader"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card bg-info text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-white-75 small">Tahap SN</div>
                                            <div class="text-lg fw-bold">{{ $totalSN }} Doc</div>
                                        </div>
                                        <i class="feather-xl text-white-50" data-feather="file-text"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card bg-success text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-white-75 small">Selesai</div>
                                            <div class="text-lg fw-bold">{{ $totalSigned }} Doc</div>
                                        </div>
                                        <i class="feather-xl text-white-50" data-feather="check-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Docs -->
                    <div class="card mb-4">
                        <div class="card-header">Dokumen Terbaru</div>
                        <div class="card-body">
                             <div class="table-responsive">
                                 <table class="table table-striped table-hover rounded">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No FPP</th>
                                            <th>Judul FPP</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentDocuments as $doc)
                                        <tr>
                                            <td class="fw-bold">{{ $doc->nomor_fpp }}</td>
                                            <td>{{ Str::limit($doc->judul_fpp, 60) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($doc->tanggal_fpp)->format('d M Y') }}</td>
                                            <td>
                                                 <span class="badge rounded-pill bg-{{ $doc->status_progres == 'Signed' ? 'success' : ($doc->status_progres == 'SN' ? 'info' : 'warning') }}">
                                                    {{ $doc->status_progres }}
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada dokumen.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="footer-admin mt-auto footer-light">
                <div class="container-fluid px-4">
                    <div class="small">Copyright &copy; TRIAS Group {{ date('Y') }}</div>
                </div>
            </footer>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('sbadmin/js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            feather.replace();

            // --- Real-time Clock ---
            function updateClock() {
                const now = new Date();
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
                
                const dateString = now.toLocaleDateString('id-ID', options);
                const timeString = now.toLocaleTimeString('id-ID', timeOptions);
                
                const clockEl = document.getElementById('realTimeClock');
                if(clockEl) {
                    clockEl.innerText = `${dateString} | ${timeString}`;
                }
            }
            setInterval(updateClock, 1000);
            updateClock(); // Initial call


            // --- Weather Widget ---
            const weatherElement = document.getElementById('weatherWidget');

            async function fetchWeather() {
                if(!weatherElement) return;
                
                try {
                    // Default to Jakarta
                    const lat = -6.1751;
                    const lon = 106.8650;
                    
                    const response = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true&timezone=auto`);
                    const data = await response.json();
                    
                    if (data.current_weather) {
                        const { temperature, weathercode } = data.current_weather;
                        const weatherDesc = getWeatherDescription(weathercode);
                        const icon = getWeatherIcon(weathercode);
                        
                        weatherElement.innerHTML = `
                           <i class="fas fa-map-marker-alt me-1"></i> Jakarta | <span class="fw-bold">${temperature}°C</span> ${weatherDesc} ${icon}
                        `;
                    }
                } catch (error) {
                    console.error("Error fetching weather:", error);
                    weatherElement.innerHTML = "Cuaca tidak tersedia";
                }
            }

            function getWeatherDescription(code) {
                const codes = {
                    0: 'Cerah', 1: 'Cerah Berawan', 2: 'Berawan', 3: 'Mendung',
                    45: 'Berkabut', 48: 'Berkabut',
                    51: 'Gerimis', 53: 'Gerimis', 55: 'Gerimis',
                    61: 'Hujan Ringan', 63: 'Hujan Sedang', 65: 'Hujan Lebat',
                    80: 'Hujan', 81: 'Hujan', 82: 'Hujan',
                    95: 'Badai Petir', 96: 'Badai Petir', 99: 'Badai Petir'
                };
                return codes[code] || '';
            }

            function getWeatherIcon(code) {
                if (code === 0) return '<i class="fas fa-sun text-warning ms-1"></i>';
                if (code >= 1 && code <= 3) return '<i class="fas fa-cloud-sun text-white-50 ms-1"></i>';
                if (code >= 51 && code <= 67) return '<i class="fas fa-cloud-rain text-infos ms-1"></i>';
                if (code >= 95) return '<i class="fas fa-bolt text-warning ms-1"></i>';
                return '<i class="fas fa-cloud text-white-50 ms-1"></i>';
            }

            fetchWeather();
            setInterval(fetchWeather, 600000); // 10 mins
        });
    </script>
</body>
</html>
