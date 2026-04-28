<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test doctor user
        $dokter = User::create([
            'nama' => 'Dr. Rudi Santoso',
            'email' => 'dokter@klinik.com',
            'password' => bcrypt('password'),
            'role' => 'dokter',
        ]);

        // Create jadwal for the next 30 days
        for ($i = 0; $i < 30; $i++) {
            $tanggal = Carbon::today()->addDays($i)->toDateString();
            
            Jadwal::create([
                'id_user' => $dokter->id,
                'tanggal' => $tanggal,
                'kuota' => 5,
                'status' => 'aktif',
            ]);
        }

        echo "✓ Test data created successfully!\n";
        echo "✓ Created doctor: Dr. Rudi Santoso\n";
        echo "✓ Created 30 days of jadwal with kuota 5\n";
    }
}
