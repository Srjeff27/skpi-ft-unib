<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nim',
        'angkatan',
        'profile_photo_path',
        'role',
        'prodi_id',
        'tempat_lahir',
        'tanggal_lahir',
        'nomor_hp',
        'tanggal_lulus',
        'nomor_ijazah',
        'nomor_skpi',
        'gelar_id',
        'gelar_en',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Batasi akses panel Filament per role
    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->role === 'admin',
            'verifikator' => in_array($this->role, ['verifikator', 'admin'], true),
            'mahasiswa' => in_array($this->role, ['mahasiswa', 'admin'], true),
            default => false,
        };
    }

    // Relasi ke Prodi
public function prodi()
{
    return $this->belongsTo(Prodi::class);
}

// Relasi ke Portfolio
public function portfolios()
{
    return $this->hasMany(Portfolio::class);
}
}
