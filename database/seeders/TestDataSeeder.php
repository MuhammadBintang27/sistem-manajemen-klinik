<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'nama' => 'Admin Miss Dentist',
            'email' => 'adminmissdentist@gmail.com',
            'password' => Hash::make('senyumkita123'),
            'role' => 'admin',
        ]);

        // Dokter
        User::create([
            'nama' => 'Rusfa Tursina',
            'email' => 'rusfatursina@gmail.com',
            'password' => Hash::make('siapmelayani123'),
            'role' => 'dokter',
        ]);
    }
}