<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class MonitoringController extends Controller
{
    /**
     * Tampilkan halaman Monitoring Pekerjaan
     */
    public function pekerjaan()
    {
        $user = auth()->user();

        // Data yang ditampilkan tergantung role user
        if ($user->role == 'superadmin') {
            $documents = Document::latest()->get();
        } elseif ($user->role == 'admin') {
            // Admin bisa melihat semua dokumen kecuali yang sudah Signed (opsional)
            $documents = Document::orderBy('id_dokumen', 'desc')->get();
        } else {
            // Teknisi hanya lihat saja
            $documents = Document::orderBy('id_dokumen', 'desc')->get();
        }

        return view('monitoring.pekerjaan', compact('documents'));
    }

    /**
     * (Opsional) Fitur Input SN untuk Admin
     */
    public function inputSN($id)
    {
        $document = Document::findOrFail($id);
        return view('monitoring.input_sn', compact('document'));
    }

    /**
     * (Opsional) Simpan perubahan SN
     */
    public function storeSN(Request $request, $id)
    {
        $request->validate([
            'nomor_sn' => 'required|string|max:255',
        ]);

        $document = Document::findOrFail($id);
        $document->nomor_sn = $request->nomor_sn;
        $document->status_progres = 'SN';
        $document->save();

        return redirect()->route('monitoring.pekerjaan')->with('success', 'Nomor SN berhasil diperbarui.');
    }
    
      /**
    * Upload file dokumen SN dari modal
    */
    public function uploadSN(Request $request)
    {
     $request->validate([
         'id_dokumen' => 'required|integer|exists:documents,id_dokumen',
         'file_path' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
     ]);

     $doc = Document::findOrFail($request->id_dokumen);

     // Simpan file ke storage
     $path = $request->file('file_path')->store('dokumen_sn', 'public');

     // Update database
     $doc->file_path = $path;
     $doc->status_progres = 'SN'; // otomatis ubah status ke SN
     $doc->save();

     return redirect()->back()->with('success', 'Dokumen SN berhasil diupload.');
    }

}
