<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id('id_reservasi');
            $table->foreignId('id_pasien')->constrained('pasien', 'id_pasien');
            $table->foreignId('id_jadwal')->constrained('jadwal', 'id_jadwal');
            $table->string('keluhan')->nullable();
            $table->enum('status', ['menunggu_konfirmasi', 'sudah_dikonfirmasi', 'selesai', 'dibatalkan'])->default('menunggu_konfirmasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
