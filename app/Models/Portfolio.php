<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'user_id',
        'kategori_portfolio',
        'link_sertifikat',
        'nomor_dokumen',
        'tanggal_dokumen',
        'nama_dokumen_id',
        'nama_dokumen_en',
        'judul_kegiatan',
        'penyelenggara',
        'deskripsi_kegiatan',
        'status',
        'catatan_verifikator',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'tanggal_dokumen' => 'date',
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
