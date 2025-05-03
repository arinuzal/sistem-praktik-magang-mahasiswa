<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'nilai_magang',
        'nilai_mediasi',
        'video_mediasi',
        'nilai_video_mediasi',
        'penyuluhan_perizinan',
        'nilai_penyuluhan',
        'nilai_akhir',
        'dosen_id'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
