<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
   // Izinkan pengisian massal untuk kolom berikut
   protected $fillable = [
       'nama_prodi',
       'jenjang',
   ];

   public function users()
{
    return $this->hasMany(User::class);
}
}
