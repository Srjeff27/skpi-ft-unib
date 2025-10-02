<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    protected $fillable = [
        'prodi_id', 'name', 'year', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'bool',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function cplItems()
    {
        return $this->hasMany(CplItem::class);
    }
}

