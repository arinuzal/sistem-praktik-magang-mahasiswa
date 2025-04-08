<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TempatMagang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TempatMagangSeeder extends Seeder
{
    public function run(): void
    {
        $tempatMagangList = [
            [
                'name' => 'PT Sinar Jaya',
                'email' => 'sinarjaya@example.com',
                'alamat' => 'Jl. Merdeka No. 12, Jakarta',
                'kontak' => '02112345678',
                'bidang_usaha' => 'Teknologi Informasi',
            ],
            [
                'name' => 'CV Mandiri Abadi',
                'email' => 'mandiriabadi@example.com',
                'alamat' => 'Jl. Sudirman No. 5, Bandung',
                'kontak' => '02298765432',
                'bidang_usaha' => 'Konsultan Hukum',
            ],
            [
                'name' => 'PT Amanah Utama',
                'email' => 'amanahutama@example.com',
                'alamat' => 'Jl. Gajah Mada No. 33, Surabaya',
                'kontak' => '0311234567',
                'bidang_usaha' => 'Keuangan',
            ],
        ];

        foreach ($tempatMagangList as $item) {
            $user = User::create([
                'name' => $item['name'],
                'email' => $item['email'],
                'password' => Hash::make('password123'),
                'role' => 'tempat magang',
            ]);

            TempatMagang::create([
                'user_id' => $user->id,
                'nama_instansi' => $item['name'],
                'alamat' => $item['alamat'],
                'kontak' => $item['kontak'],
                'bidang_usaha' => $item['bidang_usaha'],
            ]);
        }
    }
}
