<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'user_id',
        'kategori',
        'tingkat',
        'judul_kegiatan',
        'penyelenggara',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi_kegiatan',
        'bukti_link',
        'status',
        'catatan_verifikator',
        'verified_by',
        'verified_at',
    ];

    // Relasi ke user mahasiswa
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

// Relasi ke user verifikator
public function verifikator()
{
    return $this->belongsTo(User::class, 'verified_by');
}
}
