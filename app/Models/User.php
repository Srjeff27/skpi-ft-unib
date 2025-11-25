<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
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
        'avatar',
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
            'tanggal_lahir' => 'date',
            'tanggal_lulus' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (User $user) {
            // Set foreign keys to null on related portfolios to avoid constraint errors.
            // The user's own portfolios will be cascade deleted by the database.
            Portfolio::where('verified_by', $user->id)->update(['verified_by' => null]);
            Portfolio::where('locked_by', $user->id)->update(['locked_by' => null]);
        });
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

    public function isAcademicProfileComplete(): bool
    {
        $required = ['nim', 'tempat_lahir', 'tanggal_lahir', 'nomor_hp', 'angkatan', 'prodi_id'];
        foreach ($required as $field) {
            if (blank($this->$field)) {
                return false;
            }
        }
        return true;
    }

    // Computed URL for selected avatar (fallback based on role)
    public function getAvatarUrlAttribute(): string
    {
        $map = [
            'mahasiswa_male' => 'student-male.svg',
            'mahasiswa_female' => 'student-female.svg',
            'dosen' => 'lecturer.svg',
            'verifikator' => 'verifikator.svg',
            'admin' => 'admin.svg',
        ];

        $key = $this->avatar;

        if (!$key) {
            // Reasonable defaults by role
            if ($this->role === 'admin') $key = 'admin';
            elseif ($this->role === 'verifikator') $key = 'verifikator';
            else $key = 'mahasiswa_male';
        }

        $filename = $map[$key] ?? $map['mahasiswa_male'];
        return asset('avatars/' . $filename);
    }
}
