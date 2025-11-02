<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';       // Nama tabel di database
    protected $primaryKey = 'id_dokumen'; // Primary key tabel

    public $incrementing = true;          // Karena auto_increment
    protected $keyType = 'int';           // Tipe integer

    // Kolom yang bisa diisi lewat create() atau update()
    protected $fillable = [
        'nomor_fpp',
        'tanggal_fpp',
        'judul_fpp',
        'surat_dasar',
        'nomor_surat_dasar',
        'tanggal_surat_dasar',
        'judul_surat',
        'status_progres',
        'file_path',
    ];


    // Aktifkan timestamps otomatis
    public $timestamps = true;
}
