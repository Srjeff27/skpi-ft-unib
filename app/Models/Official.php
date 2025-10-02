<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    protected $fillable = [
        'name','gelar_depan','gelar_belakang','jabatan','nip','signature_path','is_active'
    ];

    protected $casts = [
        'is_active' => 'bool',
    ];

    public function getDisplayNameAttribute(): string
    {
        $prefix = $this->gelar_depan ? $this->gelar_depan.' ' : '';
        $suffix = $this->gelar_belakang ? ', '.$this->gelar_belakang : '';
        return $prefix.$this->name.$suffix;
    }
}

