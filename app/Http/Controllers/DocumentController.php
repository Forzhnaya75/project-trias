<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller
{
    /**
     * Tampilkan form tambah dokumen baru
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Simpan dokumen baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_fpp' => 'required|string|max:100',
            'tanggal_fpp' => 'required|date',
            'judul_fpp' => 'nullable|string|max:255',
            'surat_dasar' => 'nullable|string|in:SP,SPMK', // ⬅️ ubah dari dokumen_dasar
            'nomor_surat_dasar' => 'nullable|string|max:255',
            'tanggal_surat_dasar' => 'nullable|date',
            'judul_surat' => 'nullable|string|max:255', // ⬅️ gunakan ini, bukan judul_surat_dasar
            'status_progres' => 'nullable|string|in:Proses,SN,Signed',
        ]);

        Document::create([
            'nomor_fpp' => $request->nomor_fpp,
            'tanggal_fpp' => $request->tanggal_fpp,
            'judul_fpp' => $request->judul_fpp,
            'surat_dasar' => $request->surat_dasar, // ⬅️ ubah
            'nomor_surat_dasar' => $request->nomor_surat_dasar,
            'tanggal_surat_dasar' => $request->tanggal_surat_dasar,
            'judul_surat' => $request->judul_surat, // ⬅️ ubah
            'status_progres' => $request->status_progres ?? 'Proses',
        ]);

        return redirect()
            ->route('monitoring.pekerjaan')
            ->with('success', 'Dokumen baru berhasil ditambahkan.');
    }

    /**
     * Edit dokumen (jika pakai form terpisah, bukan modal)
     */
    public function edit($id)
    {
        $document = Document::findOrFail($id);
        return view('documents.edit', compact('document'));
    }

    /**
     * Update dokumen dari modal Edit
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_fpp' => 'required|string|max:100',
            'tanggal_fpp' => 'required|date',
            'judul_fpp' => 'nullable|string|max:255',
            'surat_dasar' => 'nullable|string|in:SP,SPMK', // ⬅️ ubah
            'nomor_surat_dasar' => 'nullable|string|max:255',
            'tanggal_surat_dasar' => 'nullable|date',
            'judul_surat' => 'nullable|string|max:255', // ⬅️ ubah
            'status_progres' => 'required|string|in:Proses,SN,Signed',
        ]);

        $doc = Document::findOrFail($id);

        $doc->update([
            'nomor_fpp' => $request->nomor_fpp,
            'tanggal_fpp' => $request->tanggal_fpp,
            'judul_fpp' => $request->judul_fpp,
            'surat_dasar' => $request->surat_dasar, // ⬅️ ubah
            'nomor_surat_dasar' => $request->nomor_surat_dasar,
            'tanggal_surat_dasar' => $request->tanggal_surat_dasar,
            'judul_surat' => $request->judul_surat, // ⬅️ ubah
            'status_progres' => $request->status_progres,
        ]);

        return redirect()
            ->route('monitoring.pekerjaan')
            ->with('success', 'Data dokumen berhasil diperbarui.');
    }

    /**
     * Hapus dokumen
     */
    public function destroy($id)
    {
        $doc = Document::findOrFail($id);
        $doc->delete();

        return redirect()
            ->route('monitoring.pekerjaan')
            ->with('success', 'Data dokumen berhasil dihapus.');
    }
}
