<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 🔹 Nama tabel
    protected $table = 'users';

    // 🔹 Ubah primary key default
    protected $primaryKey = 'id_user';

    // 🔹 Kalau auto increment aktif
    public $incrementing = true;

    // 🔹 Tipe data primary key
    protected $keyType = 'int';

    // 🔹 Jika tabel punya kolom timestamps
    public $timestamps = true;

    // 🔹 Field yang bisa diisi
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'profile_picture',
    ];

    // 🔹 Field yang disembunyikan
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 🔹 Kolom remember token (supaya Auth tidak error)
    protected $rememberTokenName = 'remember_token';
}
