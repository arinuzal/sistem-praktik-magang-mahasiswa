<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $casts = [
        'mata_kuliah' => 'array',
    ];

    public function getMataKuliahFormattedAttribute()
{
    $mataKuliah = $this->mata_kuliah;

    if (is_string($mataKuliah)) {
        try {
            $mataKuliah = json_decode($mataKuliah, true) ?? [];
        } catch (\Exception $e) {
            $mataKuliah = [];
        }
    }

    if (!empty($mataKuliah) && is_string($mataKuliah[0] ?? null)) {
        $formatted = [];
        foreach ($mataKuliah as $item) {
            $parts = explode('_', $item);
            $kelas = array_pop($parts);
            $nama = str_replace('_', ' ', implode('_', $parts));
            $formatted[] = ['nama' => $nama, 'kelas' => $kelas];
        }
        return $formatted;
    }

    return is_array($mataKuliah) ? $mataKuliah : [];
}

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
