<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Tampilkan halaman manajemen user
     */
    public function index(Request $request)
    {
        $query = User::latest();

        if ($request->has('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->get();
        $selectedRole = $request->role; // Untuk kebutuhan view (judul, param modal)

        return view('superadmin.users', compact('users', 'selectedRole'));
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,superadmin,teknisi', // Sesuaikan enum role
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'profile_picture' =>'default.jpg', // Opsional
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Update user yang sudah ada
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'role' => 'required|in:admin,superadmin,teknisi',
            'password' => 'nullable|string|min:6', // Jika kosong, password tidak diubah
        ]);

        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Hapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Opsional: cegah hapus diri sendiri jika sedang login
        if (auth()->id() == $user->id_user) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
