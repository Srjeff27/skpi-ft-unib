<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'subject_type',
        'subject_id',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the human-readable description of the log.
     */
    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->action) {
                'auth.login' => 'melakukan login',
                'auth.logout' => 'melakukan logout',
                'profile.update' => 'memperbarui profil',
                'student.portfolios.store' => 'membuat portofolio baru',
                'student.portfolios.update' => 'memperbarui portofolio',
                'student.portfolios.destroy' => 'menghapus portofolio',
                'verifikator.portfolios.approve' => 'menyetujui portofolio',
                'verifikator.portfolios.reject' => 'menolak portofolio',
                'verifikator.portfolios.request_edit' => 'meminta perbaikan portofolio',
                'admin.users.store' => 'membuat user baru',
                'admin.users.update' => 'memperbarui data user',
                'admin.users.destroy' => 'menghapus user',
                'admin.announcements.store' => 'membuat pengumuman baru',
                'admin.announcements.destroy' => 'menghapus pengumuman',
                default => 'melakukan aksi: ' . $this->action,
            },
        );
    }
}

