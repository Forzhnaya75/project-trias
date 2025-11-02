<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\DocumentController;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('landing'));

/*
|--------------------------------------------------------------------------
| Login & Logout
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard per Role
|--------------------------------------------------------------------------
*/
Route::get('/superadmin/dashboard', fn() => view('superadmin.dashboard'))->name('dashboard.superadmin');
Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('dashboard.admin');
Route::get('/teknisi/dashboard', fn() => view('teknisi.dashboard'))->name('dashboard.teknisi');

/*
|--------------------------------------------------------------------------
| Profil User
|--------------------------------------------------------------------------
*/
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

/*
|--------------------------------------------------------------------------
| ROUTE YANG MEMBUTUHKAN LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Monitoring → Pekerjaan
    |--------------------------------------------------------------------------
    */
    Route::get('/monitoring/pekerjaan', [MonitoringController::class, 'pekerjaan'])->name('monitoring.pekerjaan');

    // Input Nomor SN (opsional)
    Route::get('/monitoring/pekerjaan/{id}/sn', [MonitoringController::class, 'inputSN'])->name('documents.sn');
    Route::post('/monitoring/pekerjaan/{id}/sn', [MonitoringController::class, 'storeSN'])->name('documents.storeSN');

    // Upload file SN via modal
    Route::post('/monitoring/pekerjaan/upload-sn', [MonitoringController::class, 'uploadSN'])->name('documents.uploadSN');

    /*
    |--------------------------------------------------------------------------
    | CRUD Dokumen (Edit, Delete, Create)
    |--------------------------------------------------------------------------
    */
    Route::resource('documents', DocumentController::class)->only([
        'create', 'store', 'edit', 'update', 'destroy'
    ]);
});
