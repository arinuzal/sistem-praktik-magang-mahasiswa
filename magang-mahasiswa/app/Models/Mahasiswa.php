<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $casts = [
        'mata_kuliah' => 'array',
    ];

    protected $fillable = [
        'user_id',
        'nama',
        'nim',
        'semester',
        'mata_kuliah',
        'bukti_pembayaran',
        'bukti_krs',
        'status_dokumen',
        'status_magang',
        'nilai_magang',
        'kelompok',
    ];

      public function user()
      {
         return $this->belongsTo(User::class);
      }

      public function tempatMagang()
      {
         return $this->belongsTo(TempatMagang::class);
      }

      public function penilaian()
      {
          return $this->hasOne(Penilaian::class);
      }

      public function dosen()
     {
         return $this->belongsTo(User::class, 'dosen_id');
     }
}
