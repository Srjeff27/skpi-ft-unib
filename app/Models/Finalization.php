<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finalization extends Model
{
    protected $fillable = [
        'period_ym','official_id','is_locked','locked_at'
    ];

    protected $casts = [
        'is_locked' => 'bool',
        'locked_at' => 'datetime',
    ];

    public function official()
    {
        return $this->belongsTo(Official::class);
    }
}

