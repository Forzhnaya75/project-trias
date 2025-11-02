@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 100vw;">

    {{-- 🔹 Judul halaman utama --}}
    <h4 class="mt-4 mb-3 ps-4 fw-semibold">Monitoring Pekerjaan</h4>

    {{-- 🔹 Card utama --}}
    <div class="card shadow-sm rounded-4 border-0 mx-4">
        <div class="card-body">

            {{-- 🔹 Tombol Tambah Pekerjaan di dalam card --}}
            @if(auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin')
                <div class="mb-3">
                    <a href="{{ route('documents.create') }}" 
                       class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Pekerjaan
                    </a>
                </div>
            @endif

            {{-- 🔹 Notifikasi sukses --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- 🔹 Tabel utama --}}
            <div class="table-responsive" style="overflow-x:auto; width:100%;">
                <table class="table table-bordered table-hover table-striped align-middle text-center w-100"
                       style="min-width: 2000px; table-layout: auto; width: 100%;">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>ID Dokumen</th>
                            <th>Nomor FPP</th>
                            <th>Tanggal FPP</th>
                            <th>Judul FPP</th>
                            <th>Surat Dasar</th>
                            <th>Nomor Surat Dasar</th>
                            <th>Tanggal Surat Dasar</th>
                            <th>Judul Surat</th>
                            <th>Dokumen SN</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $index => $doc)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $doc->id_dokumen }}</td>
                                <td>{{ $doc->nomor_fpp }}</td>
                                <td>{{ \Carbon\Carbon::parse($doc->tanggal_fpp)->format('d M Y') }}</td>
                                <td>{{ $doc->judul_fpp }}</td>
                                <td>{{ $doc->surat_dasar ?? '-' }}</td>
                                <td>{{ $doc->nomor_surat_dasar ?? '-' }}</td>
                                <td>
                                    @php
                                        $selisih = null;
                                        if ($doc->tanggal_fpp && $doc->tanggal_surat_dasar) {
                                            $selisih = \Carbon\Carbon::parse($doc->tanggal_fpp)
                                                ->diffInDays(\Carbon\Carbon::parse($doc->tanggal_surat_dasar));
                                        }
                                    @endphp
                                    {{ $doc->tanggal_surat_dasar 
                                        ? \Carbon\Carbon::parse($doc->tanggal_surat_dasar)->format('d M Y') 
                                        : '-' }}
                                    @if($selisih)
                                        <br><small class="text-muted">({{ $selisih }} hari)</small>
                                    @endif
                                </td>
                                <td>{{ $doc->judul_surat ?? '-' }}</td>

                                {{-- Dokumen SN --}}
                                <td>
                                    <button class="btn btn-dark btn-sm rounded-pill px-3 input-sn-btn" 
                                            data-id="{{ $doc->id_dokumen }}" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalSN">
                                        INPUT FILE
                                    </button>
                                </td>

                                {{-- Status --}}
                                <td>
                                    <select class="form-select form-select-sm status-progres" data-id="{{ $doc->id_dokumen }}">
                                        <option value="Proses" {{ $doc->status_progres == 'Proses' ? 'selected' : '' }}>Proses</option>
                                        <option value="SN" {{ $doc->status_progres == 'SN' ? 'selected' : '' }}>SN</option>
                                        <option value="Signed" {{ $doc->status_progres == 'Signed' ? 'selected' : '' }}>Signed</option>
                                    </select>
                                </td>

                                {{-- Aksi --}}
                                <td>
                                    <button 
                                        class="btn btn-warning btn-sm edit-btn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEdit"
                                        data-id="{{ $doc->id_dokumen }}"
                                        data-fpp="{{ $doc->nomor_fpp }}"
                                        data-tanggal="{{ \Carbon\Carbon::parse($doc->tanggal_fpp)->format('Y-m-d') }}"
                                        data-judul="{{ $doc->judul_fpp }}"
                                        data-dasar="{{ $doc->surat_dasar }}"
                                        data-no-dasar="{{ $doc->nomor_surat_dasar }}"
                                        data-tgl-dasar="{{ $doc->tanggal_surat_dasar ? \Carbon\Carbon::parse($doc->tanggal_surat_dasar)->format('Y-m-d') : '' }}"
                                        data-judul-surat="{{ $doc->judul_surat }}"
                                        data-status="{{ $doc->status_progres }}">
                                        Edit
                                    </button>

                                    <form action="{{ route('documents.destroy', $doc->id_dokumen) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus dokumen ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center text-muted">Belum ada data pekerjaan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Upload SN --}}
<div class="modal fade" id="modalSN" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title">Upload Dokumen SN</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formUploadSN" method="POST" action="{{ route('documents.uploadSN') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_dokumen" id="idDokumenSN">
            <div class="mb-3">
                <label class="form-label">Pilih File</label>
                <input type="file" name="file_path" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Upload</button>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Modal Edit Dokumen --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title">Edit Dokumen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="formEdit" method="POST" action="">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nomor FPP</label>
              <input type="text" name="nomor_fpp" id="editNomorFpp" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal FPP</label>
              <input type="date" name="tanggal_fpp" id="editTanggalFpp" class="form-control" required>
            </div>
            <div class="col-12">
              <label class="form-label">Judul FPP</label>
              <input type="text" name="judul_fpp" id="editJudulFpp" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Surat Dasar</label>
              <select name="surat_dasar" id="editSuratDasar" class="form-select">
                <option value="SP">SP</option>
                <option value="SPMK">SPMK</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Nomor Surat Dasar</label>
              <input type="text" name="nomor_surat_dasar" id="editNomorSuratDasar" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Surat Dasar</label>
              <input type="date" name="tanggal_surat_dasar" id="editTanggalSuratDasar" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Judul Surat</label>
              <input type="text" name="judul_surat" id="editJudulSurat" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Status Progres</label>
              <select name="status_progres" id="editStatusProgres" class="form-select">
                <option value="Proses">Proses</option>
                <option value="SN">SN</option>
                <option value="Signed">Signed</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const formEdit = document.getElementById('formEdit');
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const id = this.dataset.id;
      formEdit.action = `${window.location.origin}/documents/${id}`;
      document.getElementById('editNomorFpp').value = this.dataset.fpp || '';
      document.getElementById('editTanggalFpp').value = this.dataset.tanggal || '';
      document.getElementById('editJudulFpp').value = this.dataset.judul || '';
      document.getElementById('editSuratDasar').value = this.dataset.dasar || '';
      document.getElementById('editNomorSuratDasar').value = this.dataset.noDasar || '';
      document.getElementById('editTanggalSuratDasar').value = this.dataset.tglDasar || '';
      document.getElementById('editJudulSurat').value = this.dataset.judulSurat || '';
      document.getElementById('editStatusProgres').value = this.dataset.status || '';
    });
  });
});
</script>
@endsection
