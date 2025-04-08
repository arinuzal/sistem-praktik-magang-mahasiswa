<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TempatMagang extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_instansi',
        'alamat',
        'kontak',
        'bidang_usaha',
    ];

    public function user()
    {
       return $this->belongsTo(User::class);
    }
}
