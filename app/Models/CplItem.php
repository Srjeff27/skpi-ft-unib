<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CplItem extends Model
{
    protected $fillable = [
        'curriculum_id', 'category', 'code', 'desc_id', 'desc_en', 'order',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}

