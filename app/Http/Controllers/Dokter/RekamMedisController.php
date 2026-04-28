<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\Reservasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RekamMedisController extends Controller
{
    public function index(Reservasi $reservasi): View
    {
        $this->authorizeReservasi($reservasi);

        $reservasi->load('pasien', 'jadwal');
        $rekamMedisList = $reservasi->rekamMedis()->orderByDesc('tanggal')->get();

        return view('dokter.rekam-medis.index', compact('reservasi', 'rekamMedisList'));
    }

    public function create(Reservasi $reservasi): View
    {
        $this->authorizeReservasi($reservasi);

        $reservasi->load('pasien', 'jadwal');

        return view('dokter.rekam-medis.create', compact('reservasi'));
    }

    public function store(Request $request, Reservasi $reservasi)
    {
        $this->authorizeReservasi($reservasi);

        $validated = $request->validate([
            'keluhan' => ['nullable', 'string', 'max:255'],
            'diagnosa' => ['required', 'string', 'max:255'],
            'terapi' => ['required', 'string', 'max:255'],
        ]);

        RekamMedis::create([
            'id_pasien' => $reservasi->id_pasien,
            'id_user' => auth()->id(),
            'id_reservasi' => $reservasi->id_reservasi,
            'tanggal' => now()->toDateString(),
            'keluhan' => $validated['keluhan'] ?? null,
            'diagnosa' => $validated['diagnosa'],
            'terapi' => $validated['terapi'],
        ]);

        // Tandai reservasi selesai
        $reservasi->update(['status' => 'selesai']);

        // Return JSON if AJAX request, otherwise redirect
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Rekam medis berhasil disimpan dan reservasi ditandai selesai'
            ]);
        }

        return redirect()->route('dokter.rekam-medis.index', $reservasi)
            ->with('success', 'Rekam medis berhasil disimpan dan reservasi ditandai selesai');
    }

    public function show(RekamMedis $rekamMedis): View
    {
        $reservasi = $rekamMedis->reservasi;
        $this->authorizeReservasi($reservasi);

        $reservasi->load('pasien', 'jadwal');

        return view('dokter.rekam-medis.show', compact('reservasi', 'rekamMedis'));
    }

    public function markComplete(RekamMedis $rekamMedis): RedirectResponse
    {
        $reservasi = $rekamMedis->reservasi;
        $this->authorizeReservasi($reservasi);

        $reservasi->update(['status' => 'selesai']);

        return redirect()->route('dokter.rekam-medis.index', $reservasi)
            ->with('success', 'Penanganan ditandai selesai.');
    }

    protected function authorizeReservasi(Reservasi $reservasi): void
    {
        if ($reservasi->jadwal?->id_user !== auth()->id()) {
            abort(403);
        }
    }
}
