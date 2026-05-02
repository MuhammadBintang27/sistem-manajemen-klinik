<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    /**
     * Store rekam medis dari admin
     */
    public function store(Request $request, Reservasi $reservasi)
    {
        $validated = $request->validate([
            'keluhan' => ['nullable', 'string', 'max:1000'],
            'subjective' => ['required', 'string', 'max:1000'],
            'objective' => ['required', 'string', 'max:1000'],
            'assessment' => ['required', 'string', 'max:1000'],
            'plan' => ['required', 'string', 'max:1000'],
            'terapi' => ['required', 'string', 'max:1000'],
            'tarif' => ['required', 'numeric', 'min:0'],
        ]);

        RekamMedis::create([
            'id_pasien' => $reservasi->id_pasien,
            'id_user' => auth()->id(),
            'id_reservasi' => $reservasi->id_reservasi,
            'tanggal' => now()->toDateString(),
            'keluhan' => $validated['keluhan'] ?? null,
            'subjective' => $validated['subjective'],
            'objective' => $validated['objective'],
            'assessment' => $validated['assessment'],
            'plan' => $validated['plan'],
            'terapi' => $validated['terapi'],
            'tarif' => $validated['tarif'],
        ]);

        // Tandai reservasi selesai
        $reservasi->update(['status' => 'selesai']);

        return redirect()->route('admin.reservasi.index')
            ->with('success', 'Rekam medis berhasil disimpan dan reservasi ditandai selesai');
    }
}
