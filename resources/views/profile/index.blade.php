@extends('layouts.app')

@section('title', 'Pengaturan Profil')

@section('content')
    <h1 class="mt-4">Pengaturan Profil</h1>
    <p>Halo <b>{{ Auth::user()->username }}</b>, kamu bisa update profilmu di sini.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 text-center">
            <label for="profile_picture" class="form-label d-block">Foto Profil</label>
            <img id="preview" 
                 src="{{ Auth::user()->profile_picture 
                        ? asset('storage/' . Auth::user()->profile_picture) 
                        : asset('sbadmin/assets/img/illustrations/profiles/profile-1.png') }}" 
                 class="rounded-circle mb-3" 
                 style="width:120px;height:120px;object-fit:cover;">
            <input type="file" name="profile_picture" id="profile_picture" class="form-control mt-2">
        </div>
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="username" class="form-control" value="{{ Auth::user()->username }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
@endsection

@push('scripts')
    {{-- 🔹 Cropper.js --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <script>
        const input = document.getElementById('profile_picture');
        const preview = document.getElementById('preview');
        let cropper;

        input.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    preview.src = event.target.result;
                    if (cropper) cropper.destroy();
                    cropper = new Cropper(preview, {
                        aspectRatio: 1,
                        viewMode: 1,
                        autoCropArea: 1,
                    });
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
