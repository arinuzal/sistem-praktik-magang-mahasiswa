<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Budi Mahasiswa',
            'nim' => '111111',
            'email' => 'mahasiswa@example.com',
            'no_hp' => '0895392121',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        User::create([
            'name' => 'Siti Admin',
            'nim' => null,
            'email' => 'admin@example.com',
            'no_hp' => '08953921222',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Joko Super Admin',
            'nim' => null,
            'email' => 'superadmin@example.com',
            'no_hp' => '08953921223',
            'password' => Hash::make('password123'),
            'role' => 'super admin',
        ]);

        User::create([
            'name' => 'Pak Bambang',
            'nim' => null,
            'email' => 'arinuzalramadesta@gmail.com',
            'no_hp' => '08953921223',
            'password' => Hash::make('password123'),
            'role' => 'dosen',
        ]);
    }
}
