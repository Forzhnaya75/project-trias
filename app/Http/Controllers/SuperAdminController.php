<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\User;

class SuperAdminController extends Controller
{
    /**
     * Tampilkan Dashboard Superadmin
     */
    public function dashboard()
    {
        // Hitung Statistik Dokumen
        $totalPekerjaan = Document::count();
        $totalProses = Document::where('status_progres', 'Proses')->count();
        $totalSN = Document::where('status_progres', 'SN')->count();
        $totalSigned = Document::where('status_progres', 'Signed')->count();

        // Hitung Statistik User (Khusus Superadmin)
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalTeknisi = User::where('role', 'teknisi')->count();

        // Ambil 5 dokumen terbaru
        $recentDocuments = Document::latest()->take(5)->get();

        return view('superadmin.dashboard', compact(
            'totalPekerjaan', 
            'totalProses', 
            'totalSN', 
            'totalSigned', 
            'totalUsers',
            'totalAdmins',
            'totalTeknisi',
            'recentDocuments'
        ));
    }
}
