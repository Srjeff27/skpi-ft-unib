<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@unib.ac.id'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'nim' => null,
                'prodi_id' => null,
            ]
        );

        // Verifikator
        User::updateOrCreate(
            ['email' => 'verifikator@unib.ac.id'],
            [
                'name' => 'Verifikator',
                'password' => Hash::make('password'),
                'role' => 'verifikator',
                'nim' => null,
                'prodi_id' => null,
            ]
        );

        // Mahasiswa
        User::updateOrCreate(
            ['email' => 'mahasiswa@unib.ac.id'],
            [
                'name' => 'Mahasiswa',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
                'nim' => null,
                'prodi_id' => null,
            ]
        );
    }
}

