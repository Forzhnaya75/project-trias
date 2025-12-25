@extends('layouts.app')

@section('title', 'Teknisi Dashboard - TRIAS Group')

@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="activity"></i></div>
                        Teknisi Dashboard
                    </h1>
                    <div class="page-header-subtitle">Field Operations & Maintenance</div>
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

<!-- Main page content-->
<div class="container-xl px-4 mt-n10">
    <!-- Welcome Card -->
    <div class="row">
        <div class="col-xxl-4 col-xl-12 mb-4">
            <div class="card h-100">
                <div class="card-body h-100 p-5">
                    <div class="row align-items-center">
                        <div class="col-xl-8 col-xxl-12">
                            <div class="text-center text-xl-start text-xxl-center mb-4 mb-xl-0 mb-xxl-4">
                                <h1 class="text-primary">Selamat Datang, {{ Auth::user()->username }}!</h1>
                                <p class="text-gray-700 mb-0">Halaman ini memberikan ringkasan tugas dan status pekerjaan lapangan Anda. Pantau jadwal dan progres pekerjaan Anda di sini.</p>
                            </div>
                        </div>
                        <div class="col-xl-4 col-xxl-12 text-center"><img class="img-fluid" src="{{ asset('sbadmin/assets/img/illustrations/at-work.svg') }}" style="max-width: 26rem" /></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        {{-- Total Pekerjaan --}}
        <div class="col-lg-6 col-xl-3 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75 small">Total Pekerjaan</div>
                            <div class="text-lg fw-bold">{{ $totalPekerjaan }}</div>
                        </div>
                        <i class="feather-xl text-white-50" data-feather="folder"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="{{ route('monitoring.pekerjaan') }}">Lihat Detail</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        {{-- Dalam Proses --}}
        <div class="col-lg-6 col-xl-3 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75 small">Dalam Proses</div>
                            <div class="text-lg fw-bold">{{ $totalProses }}</div>
                        </div>
                        <i class="feather-xl text-white-50" data-feather="loader"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="{{ route('monitoring.pekerjaan') }}">Lihat Detail</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        {{-- Tahap SN --}}
        <div class="col-lg-6 col-xl-3 mb-4">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75 small">Tahap SN</div>
                            <div class="text-lg fw-bold">{{ $totalSN }}</div>
                        </div>
                        <i class="feather-xl text-white-50" data-feather="file-text"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="{{ route('monitoring.pekerjaan') }}">Lihat Detail</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
         {{-- Selesai (Signed) --}}
        <div class="col-lg-6 col-xl-3 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75 small">Selesai (Signed)</div>
                            <div class="text-lg fw-bold">{{ $totalSigned }}</div>
                        </div>
                        <i class="feather-xl text-white-50" data-feather="check-circle"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="{{ route('monitoring.pekerjaan') }}">Lihat Detail</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
            if (code >= 51 && code <= 67) return '<i class="fas fa-cloud-rain text-info ms-1"></i>';
            if (code >= 95) return '<i class="fas fa-bolt text-warning ms-1"></i>';
            return '<i class="fas fa-cloud text-white-50 ms-1"></i>';
        }

        fetchWeather();
        setInterval(fetchWeather, 600000); // 10 mins
    });
</script>
@endsection
