<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$pasien = App\Models\Pasien::count();
$rm = App\Models\RekamMedis::count();
$user = App\Models\User::where('role', 'dokter')->first();

echo "Pasien: " . $pasien . "\n";
echo "Rekam Medis: " . $rm . "\n";
echo "Dokter: " . ($user ? $user->id_user . " - " . $user->name : "Tidak ada") . "\n";

if ($rm > 0) {
    $lastRm = App\Models\RekamMedis::latest()->first();
    echo "Last RM id_user: " . $lastRm->id_user . "\n";
    echo "Last RM id_pasien: " . $lastRm->id_pasien . "\n";
    
    if ($user) {
        $query = App\Models\Pasien::whereHas('rekamMedis', function ($q) use ($user) {
            $q->where('id_user', $user->id_user);
        });
        echo "Pasien dengan RM dari dokter: " . $query->count() . "\n";
    }
}
