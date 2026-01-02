<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

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
Route::get('/superadmin/dashboard', [\App\Http\Controllers\SuperAdminController::class, 'dashboard'])->name('dashboard.superadmin');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard.admin');
Route::get('/teknisi/dashboard', function () {
    $totalPekerjaan = \App\Models\Document::count();
    $totalProses = \App\Models\Document::where('status_progres', 'Proses')->count();
    $totalSN = \App\Models\Document::where('status_progres', 'SN')->count();
    $totalSigned = \App\Models\Document::where('status_progres', 'Signed')->count();

    return view('teknisi.dashboard', compact('totalPekerjaan', 'totalProses', 'totalSN', 'totalSigned'));
})->name('dashboard.teknisi');

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
    | Admin Management
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/documents', [AdminController::class, 'index'])->name('admin.documents');

    /*
    |--------------------------------------------------------------------------
    | CRUD Dokumen (Edit, Delete, Create)
    |--------------------------------------------------------------------------
    */
    Route::get('/documents/{id}/preview', [DocumentController::class, 'preview'])->name('documents.preview');

    Route::resource('documents', DocumentController::class)->only([
        'create',
        'store',
        'edit',
        'update',
        'destroy'
    ]);

    /*
    |--------------------------------------------------------------------------
    | Manajemen User (Superadmin)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:super_admin'])->group(function () {
        Route::get('/superadmin/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/superadmin/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/superadmin/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/superadmin/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});
