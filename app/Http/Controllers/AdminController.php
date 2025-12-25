<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class AdminController extends Controller
{
    /**
     * Tampilkan halaman manajemen dokumen untuk Admin
     */
    public function index()
    {
        // Ambil semua dokumen, urutkan dari yang terbaru
        $documents = Document::orderBy('created_at', 'desc')->get();
        
        return view('admin.documents', compact('documents'));
    }

    /**
     * Tampilkan Dashboard Admin
     */
    public function dashboard()
    {
        // Hitung Statistik
        $totalPekerjaan = Document::count();
        $totalProses = Document::where('status_progres', 'Proses')->count();
        $totalSN = Document::where('status_progres', 'SN')->count();
        $totalSigned = Document::where('status_progres', 'Signed')->count();

        // Ambil 5 dokumen terbaru untuk tabel mini dashboard
        $recentDocuments = Document::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalPekerjaan', 'totalProses', 'totalSN', 'totalSigned', 'recentDocuments'));
    }
}
