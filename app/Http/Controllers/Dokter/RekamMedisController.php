<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\Reservasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RekamMedisController extends Controller
{
    /**
     * Daftar pasien dengan riwayat rekam medis (untuk sidebar menu)
     */
    public function listPasien(Request $request): View
    {
        $search = $request->get('search', '');
        $page = $request->get('page', 1);
        $perPage = 10;

        // Query pasien yang memiliki rekam medis (bisa dilihat semua dokter)
        $query = Pasien::whereHas('rekamMedis');

        // Search by nama atau NIK
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $pasiens = $query->withCount('rekamMedis')
                        ->orderByDesc('updated_at')
                        ->paginate($perPage);

        return view('dokter.rekam-medis.pasien-list', compact('pasiens', 'search'));
    }

    /**
     * Detail pasien dengan riwayat rekam medis lengkap
     */
    public function showPasien(Pasien $pasien): View
    {
        // Ambil rekam medis pasien (bisa dilihat semua dokter)
        $rekamMedis = $pasien->rekamMedis()
            ->with('dokter', 'reservasi')
            ->orderByDesc('tanggal')
            ->get();

        return view('dokter.rekam-medis.pasien-detail', compact('pasien', 'rekamMedis'));
    }

    /**
     * Edit form untuk rekam medis
     */
    public function editRekamMedis(RekamMedis $rekamMedis): View
    {
        // Cek bahwa dokter saat ini adalah yang membuat rekam medis ini
        if ($rekamMedis->id_user !== auth()->id()) {
            abort(403);
        }

        $pasien = $rekamMedis->pasien;

        return view('dokter.rekam-medis.edit', compact('rekamMedis', 'pasien'));
    }

    /**
     * Update rekam medis
     */
    public function updateRekamMedis(Request $request, RekamMedis $rekamMedis): RedirectResponse
    {
        // Cek bahwa dokter saat ini adalah yang membuat rekam medis ini
        if ($rekamMedis->id_user !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'keluhan' => ['nullable', 'string', 'max:1000'],
            'subjective' => ['required', 'string', 'max:1000'],
            'objective' => ['required', 'string', 'max:1000'],
            'assessment' => ['required', 'string', 'max:1000'],
            'plan' => ['required', 'string', 'max:1000'],
            'terapi' => ['required', 'string', 'max:1000'],
            'tarif' => ['required', 'numeric', 'min:0'],
        ]);

        $rekamMedis->update($validated);

        return redirect()->route('dokter.rekam-medis.pasien.show', $rekamMedis->pasien)
            ->with('success', 'Rekam medis berhasil diperbarui');
    }

    // ============ OLD METHODS (untuk reservasi) ============

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

        // Return JSON if AJAX request, otherwise redirect
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Rekam medis berhasil disimpan dan reservasi ditandai selesai'
            ]);
        }

        return redirect()->route('dokter.reservasi.index')
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

        return redirect()->route('dokter.reservasi.index')
            ->with('success', 'Penanganan ditandai selesai.');
    }

    protected function authorizeReservasi(Reservasi $reservasi): void
    {
        if ($reservasi->jadwal?->id_user !== auth()->id()) {
            abort(403);
        }
    }
}
