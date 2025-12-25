@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h3 class="mt-4 mb-3 fw-bold">Manajemen Dokumen (Admin)</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Semua Dokumen</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>No. FPP</th>
                            <th>Judul FPP</th>
                            <th>Status</th>
                            <th>Dokumen SN</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $doc->nomor_fpp }}</td>
                                <td>{{ $doc->judul_fpp }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-{{ $doc->status_progres == 'Signed' ? 'success' : ($doc->status_progres == 'SN' ? 'info' : 'warning') }}">
                                        {{ $doc->status_progres }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-dark btn-sm rounded-pill px-3 input-sn-btn" 
                                            data-id="{{ $doc->id_dokumen }}" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalSN">
                                        INPUT FILE
                                    </button>
                                </td>
                                <td>
                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('documents.destroy', $doc->id_dokumen) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada dokumen.</td>
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

<script>
document.addEventListener("DOMContentLoaded", () => {
  // Handle Input File Button
  document.querySelectorAll('.input-sn-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const id = this.dataset.id;
      document.getElementById('idDokumenSN').value = id;
    });
  });
});
</script>
@endsection
