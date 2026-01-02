@extends('layouts.app')

@section('content')
<div class="container-fluid px-0" style="max-width: 100vw;">

  {{-- 🔹 Judul halaman utama --}}
  <h4 class="mt-4 mb-3 ps-4 fw-semibold">Monitoring Pekerjaan</h4>

  {{-- 🔹 Dashboard Summary --}}
  <div class="row mx-4 mb-4 g-3">
    <div class="col-12 col-md-6 col-xl-3">
      <div class="card border-0 shadow-sm rounded-4 text-white h-100" style="background: linear-gradient(135deg, #0d6efd, #0a58ca);">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h6 class="mb-1 text-white-50 small text-uppercase fw-bold">Total Pekerjaan</h6>
            <h2 class="fw-bold mb-0">{{ $totalPekerjaan }}</h2>
          </div>
          <div class="rounded-circle p-2 bg-white bg-opacity-25">
            <i class="bi bi-folder2-open fs-2"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
      <div class="card border-0 shadow-sm rounded-4 text-dark h-100" style="background: linear-gradient(135deg, #ffc107, #ffca2c);">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h6 class="mb-1 text-dark-50 small text-uppercase fw-bold">Dalam Proses</h6>
            <h2 class="fw-bold mb-0">{{ $totalProses }}</h2>
          </div>
          <div class="rounded-circle p-2 bg-black bg-opacity-10">
            <i class="bi bi-hourglass-split fs-2"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
      <div class="card border-0 shadow-sm rounded-4 text-white h-100" style="background: linear-gradient(135deg, #0dcaf0, #0aa2c0);">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h6 class="mb-1 text-white-50 small text-uppercase fw-bold">Tahap SN</h6>
            <h2 class="fw-bold mb-0">{{ $totalSN }}</h2>
          </div>
          <div class="rounded-circle p-2 bg-white bg-opacity-25">
            <i class="bi bi-envelope-paper fs-2"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
      <div class="card border-0 shadow-sm rounded-4 text-white h-100" style="background: linear-gradient(135deg, #198754, #157347);">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h6 class="mb-1 text-white-50 small text-uppercase fw-bold">Selesai (Signed)</h6>
            <h2 class="fw-bold mb-0">{{ $totalSigned }}</h2>
          </div>
          <div class="rounded-circle p-2 bg-white bg-opacity-25">
            <i class="bi bi-check-circle fs-2"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- 🔹 Card utama --}}
  <div class="card shadow-sm rounded-4 border-0 mx-4">
    <div class="card-body">

      {{-- 🔹 Tombol Tambah Pekerjaan di dalam card --}}
      @if(auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin')
      <div class="mb-3 d-flex gap-2">
        <button type="button"
          class="btn btn-primary rounded-pill px-4 shadow-sm"
          data-bs-toggle="modal"
          data-bs-target="#modalCreate">
          <i class="bi bi-plus-circle me-1"></i> Tambah Pekerjaan
        </button>

        <a href="{{ asset('format/format_fpp.docx') }}" class="btn btn-success rounded-pill px-4 shadow-sm" download>
          <i class="bi bi-download me-1"></i> Format FPP
        </a>
        
        <a href="{{ asset('format/format_sp.docx') }}" class="btn btn-warning rounded-pill px-4 shadow-sm" download>
          <i class="bi bi-download me-1"></i> Format SP
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
              @if(auth()->user()->role === 'super_admin' || auth()->user()->role === 'admin')
              <th>Aksi</th>
              @endif
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
                @if($doc->file_path)
                <a href="{{ route('documents.preview', $doc->id_dokumen) }}" target="_blank" class="btn btn-info btn-sm rounded-pill px-3 mb-1 text-white">
                  <i class="bi bi-eye"></i> Lihat
                </a>
                <br>
                @endif
                <button class="btn btn-{{ $doc->file_path ? 'secondary' : 'dark' }} btn-sm rounded-pill px-3 input-sn-btn"
                  data-id="{{ $doc->id_dokumen }}"
                  data-bs-toggle="modal"
                  data-bs-target="#modalSN">
                  {{ $doc->file_path ? 'Ganti File' : 'INPUT FILE' }}
                </button>
              </td>

              {{-- Status --}}
              <td>
                <span class="badge rounded-pill bg-{{ $doc->status_progres == 'Signed' ? 'success' : ($doc->status_progres == 'SN' ? 'info' : 'warning') }}">
                  {{ $doc->status_progres }}
                </span>
              </td>

              {{-- Aksi --}}
              {{-- Aksi --}}
              @if(auth()->user()->role === 'super_admin' || auth()->user()->role === 'admin')
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
              @endif
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

{{-- Modal Tambah Pekerjaan --}}
<div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Pekerjaan Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="POST" action="{{ route('documents.store') }}">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nomor FPP</label>
              <input type="text" name="nomor_fpp" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal FPP</label>
              <input type="date" name="tanggal_fpp" class="form-control" required>
            </div>
            <div class="col-12">
              <label class="form-label">Judul FPP</label>
              <input type="text" name="judul_fpp" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Surat Dasar</label>
              <select name="surat_dasar" class="form-select">
                <option value="SP">SP</option>
                <option value="SPMK">SPMK</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Nomor Surat Dasar</label>
              <input type="text" name="nomor_surat_dasar" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Surat Dasar</label>
              <input type="date" name="tanggal_surat_dasar" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Judul Surat</label>
              <input type="text" name="judul_surat" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Status Progres</label>
              <select name="status_progres" class="form-select">
                <option value="Proses">Proses</option>
                <option value="SN">SN</option>
                <option value="Signed">Signed</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary px-4">Simpan</button>
        </div>
      </form>
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

    // Listener untuk tombol Input SN / Ganti File
    const inputSnBtns = document.querySelectorAll('.input-sn-btn');
    inputSnBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            document.getElementById('idDokumenSN').value = id;
        });
    });
  });
</script>
@endsection