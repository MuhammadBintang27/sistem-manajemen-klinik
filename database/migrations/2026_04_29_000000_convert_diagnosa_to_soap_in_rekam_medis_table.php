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
        Schema::table('rekam_medis', function (Blueprint $table) {
            // Tambahkan kolom SOAP sebelum menghapus diagnosa
            $table->text('subjective')->nullable()->after('keluhan');
            $table->text('objective')->nullable()->after('subjective');
            $table->text('assessment')->nullable()->after('objective');
            $table->text('plan')->nullable()->after('assessment');
            
            // Hapus kolom diagnosa lama
            $table->dropColumn('diagnosa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam_medis', function (Blueprint $table) {
            // Kembalikan diagnosa
            $table->text('diagnosa')->nullable()->after('keluhan');
            
            // Hapus kolom SOAP
            $table->dropColumn(['subjective', 'objective', 'assessment', 'plan']);
        });
    }
};
