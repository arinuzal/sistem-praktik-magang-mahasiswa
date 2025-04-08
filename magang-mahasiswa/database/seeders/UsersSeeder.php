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
            'email' => 'mahasiswa@example.com',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        User::create([
            'name' => 'Siti Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Joko Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'super admin',
        ]);

        User::create([
            'name' => 'Rina Tempat Magang',
            'email' => 'tempatmagang@example.com',
            'password' => Hash::make('password123'),
            'role' => 'tempat magang',
        ]);
    }
}
