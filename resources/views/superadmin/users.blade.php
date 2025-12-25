@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="users"></i></div>
                            Manajemen {{ $selectedRole ? ucfirst($selectedRole) : 'User' }}
                        </h1>
                        <div class="page-header-subtitle">Kelola akun {{ $selectedRole ? ucfirst($selectedRole) : 'Admin dan Teknisi' }}</div>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">
                        <button class="btn btn-light text-primary" data-bs-toggle="modal" data-bs-target="#modalCreateUser">
                            <i class="me-1" data-feather="user-plus"></i> Tambah {{ $selectedRole ? ucfirst($selectedRole) : 'User' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container-xl px-4 mt-n10">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">Daftar {{ $selectedRole ? ucfirst($selectedRole) : 'Pengguna' }}</div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 20%">Username</th>
                            <th style="width: 40%">Email</th>
                            <th style="width: 15%">Role</th>
                            <th style="width: 20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $user->role == 'superadmin' ? 'purple' : ($user->role == 'admin' ? 'primary' : 'success') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-datatable btn-icon btn-transparent-dark dropdown-toggle no-caret" id="dropdownMenuButton{{ $user->id_user }}" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i data-feather="more-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $user->id_user }}">
                                        <li>
                                            <button class="dropdown-item edit-user-btn" 
                                                data-id="{{ $user->id_user }}"
                                                data-username="{{ $user->username }}"
                                                data-email="{{ $user->email }}"
                                                data-role="{{ $user->role }}"
                                                data-bs-toggle="modal" data-bs-target="#modalEditUser">
                                                <div class="dropdown-item-icon"><i data-feather="edit"></i></div>
                                                Edit
                                            </button>
                                        </li>
                                        <li>
                                            <form action="{{ route('users.destroy', $user->id_user) }}" method="POST" onsubmit="return confirm('Hapus user {{ $user->username }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <div class="dropdown-item-icon"><i data-feather="trash-2"></i></div>
                                                    Hapus
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah User --}}
<div class="modal fade" id="modalCreateUser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah {{ $selectedRole ? ucfirst($selectedRole) : 'User' }} Baru</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="small mb-1" for="inputUsername">Username</label>
                        <input class="form-control" id="inputUsername" name="username" type="text" placeholder="Masukkan username" required />
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="inputEmail">Email</label>
                        <input class="form-control" id="inputEmail" name="email" type="email" placeholder="Masukkan email" required />
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="inputRole">Role</label>
                        <select class="form-select" id="inputRole" name="role" required>
                            <option value="admin" {{ (isset($selectedRole) && $selectedRole == 'admin') ? 'selected' : '' }}>Admin</option>
                            <option value="teknisi" {{ (isset($selectedRole) && $selectedRole == 'teknisi') ? 'selected' : '' }}>Teknisi</option>
                            <option value="superadmin">Superadmin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="inputPassword">Password</label>
                        <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Masukkan password" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit User --}}
<div class="modal fade" id="modalEditUser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditUser" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="small mb-1" for="editUsername">Username</label>
                        <input class="form-control" id="editUsername" name="username" type="text" required />
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="editEmail">Email</label>
                        <input class="form-control" id="editEmail" name="email" type="email" required />
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="editRole">Role</label>
                        <select class="form-select" id="editRole" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="teknisi">Teknisi</option>
                            <option value="superadmin">Superadmin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="editPassword">Password (biarkan kosong jika tidak diubah)</label>
                        <input class="form-control" id="editPassword" name="password" type="password" placeholder="Password baru" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const formEdit = document.getElementById('formEditUser');
        const editBtns = document.querySelectorAll('.edit-user-btn');

        editBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const username = this.dataset.username;
                const email = this.dataset.email;
                const role = this.dataset.role;

                formEdit.action = `/superadmin/users/${id}`;
                document.getElementById('editUsername').value = username;
                document.getElementById('editEmail').value = email;
                document.getElementById('editRole').value = role;
            });
        });
    });
</script>
@endsection
