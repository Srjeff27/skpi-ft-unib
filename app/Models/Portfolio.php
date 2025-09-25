<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'user_id',
        'kategori_portfolio',
        'judul_kegiatan',
        'penyelenggara',
        'nomor_dokumen',
        'tanggal_dokumen',
        'nama_dokumen_id',
        'nama_dokumen_en',
        'deskripsi_kegiatan',
        'link_sertifikat',
        'status',
        'catatan_verifikator',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'tanggal_dokumen' => 'date',
        'verified_at' => 'datetime',
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
