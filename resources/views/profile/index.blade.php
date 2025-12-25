@extends('layouts.app')

@section('title', 'Pengaturan Profil')

@section('content')
<div class="container-xl px-4 mt-4">
    <nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="{{ route('profile') }}">Profil</a>
    </nav>
    <hr class="mt-0 mb-4" />

    <div class="row justify-content-center">
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Detail Akun</div>
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-4 text-center mb-4 mb-md-0">
                                <label class="small mb-1">Foto Profil</label>
                                <div class="position-relative d-inline-block">
                                    <img id="preview" 
                                         src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) . '?t=' . time() : asset('sbadmin/assets/img/illustrations/profiles/profile-1.png') }}" 
                                         class="img-fluid rounded-circle shadow-sm border" 
                                         style="width: 160px; height: 160px; object-fit: cover; cursor: pointer;"
                                         onclick="document.getElementById('profile_picture').click()">
                                    
                                    <div class="position-absolute bottom-0 end-0 bg-white rounded-circle p-2 shadow border" 
                                         style="cursor: pointer; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"
                                         onclick="document.getElementById('profile_picture').click()">
                                        <i data-feather="camera" class="text-primary"></i>
                                    </div>
                                </div>
                                
                                <input type="file" name="profile_picture" id="profile_picture" class="d-none" accept="image/*">
                                <div class="small font-italic text-muted mt-2">JPG atau PNG tidak lebih dari 2 MB</div>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputUsername">Username</label>
                                    <input class="form-control" id="inputUsername" name="username" type="text" value="{{ Auth::user()->username }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputEmail">Email Address</label>
                                    <input class="form-control" id="inputEmail" name="email" type="email" value="{{ Auth::user()->email }}" required>
                                </div>
                                
                                <div class="d-grid gap-2 d-md-block">
                                    <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById('profile_picture');
        const preview = document.getElementById('preview');

        input.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    preview.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush
