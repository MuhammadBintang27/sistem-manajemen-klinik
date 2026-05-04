<?php

use App\Http\Controllers\DokterController;
use App\Http\Controllers\Dokter\RekamMedisController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\ReservasiController as AdminReservasiController;
use App\Http\Controllers\Admin\RekamMedisController as AdminRekamMedisController;
use App\Http\Controllers\ReservasiPublicController;
use App\Http\Controllers\StorageController;
use App\Models\Jadwal;
use App\Models\Pasien;
use App\Models\Reservasi;
use Illuminate\Support\Facades\Route;

Route::get('/', [ReservasiPublicController::class, 'index'])->name('reservasi.index');
Route::get('/reservasi', [ReservasiPublicController::class, 'create'])->name('reservasi.create');
Route::post('/reservasi/check-nik', [ReservasiPublicController::class, 'checkNik'])->name('reservasi.checkNik');
Route::post('/reservasi', [ReservasiPublicController::class, 'store'])->name('reservasi.store');
Route::get('/reservasi/success', [ReservasiPublicController::class, 'success'])->name('reservasi.success');

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->role === 'dokter') {
        return redirect()->route('dokter.dashboard');
    }

    abort(403);
})->middleware(['auth'])->name('dashboard');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('dashboard', function () {
        $pasienCount = Pasien::count();
        $jadwalCount = Jadwal::count();
        $reservasiPending = Reservasi::where('status', 'menunggu_konfirmasi')->count();

        return view('admin.dashboard', compact('pasienCount', 'jadwalCount', 'reservasiPending'));
    })->name('dashboard');

    Route::resource('pasien', PasienController::class);
    Route::resource('jadwal', JadwalController::class)->except(['show']);

    // AJAX routes for jadwal calendar
    Route::post('jadwal/get-slots', [JadwalController::class, 'getSlots'])->name('jadwal.getSlots');
    Route::post('jadwal/toggle-slot', [JadwalController::class, 'toggleSlot'])->name('jadwal.toggleSlot');
    Route::post('jadwal/generate-slots', [JadwalController::class, 'generateSlots'])->name('jadwal.generateSlots');

    Route::get('reservasi', [AdminReservasiController::class, 'index'])->name('reservasi.index');
    Route::get('reservasi/{reservasi}', [AdminReservasiController::class, 'show'])->name('reservasi.show');
    Route::patch('reservasi/{reservasi}', [AdminReservasiController::class, 'update'])->name('reservasi.update');
    Route::patch('reservasi/{reservasi}/status', [AdminReservasiController::class, 'updateStatus'])->name('reservasi.status');
    
    // Rekam Medis - List pasien dengan search & pagination
    Route::get('rekam-medis', [AdminRekamMedisController::class, 'listPasien'])->name('rekam-medis.list-pasien');
    Route::get('rekam-medis/pasien/{pasien}', [AdminRekamMedisController::class, 'showPasien'])->name('rekam-medis.pasien.show');
    Route::get('rekam-medis/{rekamMedis}/edit', [AdminRekamMedisController::class, 'editRekamMedis'])->name('rekam-medis.edit');
    Route::patch('rekam-medis/{rekamMedis}', [AdminRekamMedisController::class, 'updateRekamMedis'])->name('rekam-medis.update');

    // Rekam Medis - Foto (AJAX)
    Route::post('rekam-medis/{rekamMedis}/foto', [AdminRekamMedisController::class, 'uploadFoto'])->name('rekam-medis.foto.upload');
    Route::delete('rekam-medis/{rekamMedis}/foto/{foto}', [AdminRekamMedisController::class, 'deleteFoto'])->name('rekam-medis.foto.delete');
    Route::get('rekam-medis/{rekamMedis}/foto', [AdminRekamMedisController::class, 'getFoto'])->name('rekam-medis.foto.get');

    // Rekam Medis - Create dari reservasi
    Route::post('rekam-medis/reservasi/{reservasi}', [AdminRekamMedisController::class, 'store'])->name('rekam-medis.store');
});

Route::prefix('dokter')->name('dokter.')->middleware(['auth', 'role:dokter'])->group(function () {
    Route::get('dashboard', [DokterController::class, 'dashboard'])->name('dashboard');
    Route::get('jadwal', [DokterController::class, 'jadwal'])->name('jadwal.index');
    Route::post('jadwal/get-slots', [DokterController::class, 'getSlots'])->name('jadwal.getSlots');
    Route::get('reservasi', [DokterController::class, 'reservasi'])->name('reservasi.index');
    Route::get('reservasi/{reservasi}', [DokterController::class, 'reservasiShow'])->name('reservasi.show');

    // Rekam Medis - List pasien dengan search & pagination
    Route::get('rekam-medis', [RekamMedisController::class, 'listPasien'])->name('rekam-medis.list-pasien');
    Route::get('rekam-medis/pasien/{pasien}', [RekamMedisController::class, 'showPasien'])->name('rekam-medis.pasien.show');
    Route::get('rekam-medis/{rekamMedis}/edit', [RekamMedisController::class, 'editRekamMedis'])->name('rekam-medis.edit');
    Route::patch('rekam-medis/{rekamMedis}', [RekamMedisController::class, 'updateRekamMedis'])->name('rekam-medis.update');

    // Rekam Medis - Foto (AJAX)
    Route::post('rekam-medis/{rekamMedis}/foto', [RekamMedisController::class, 'uploadFoto'])->name('rekam-medis.foto.upload');
    Route::delete('rekam-medis/{rekamMedis}/foto/{foto}', [RekamMedisController::class, 'deleteFoto'])->name('rekam-medis.foto.delete');
    Route::get('rekam-medis/{rekamMedis}/foto', [RekamMedisController::class, 'getFoto'])->name('rekam-medis.foto.get');

    // Rekam Medis - Create dari reservasi
    Route::post('rekam-medis/reservasi/{reservasi}', [RekamMedisController::class, 'store'])->name('rekam-medis.store');
});

// Private storage access (authenticated only)
Route::middleware(['auth'])->group(function () {
    Route::get('/storage/private', [StorageController::class, 'privateFile'])->name('storage.private');
});

require __DIR__.'/auth.php';
