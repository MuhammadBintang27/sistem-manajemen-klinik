<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FotoRekamMedis;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\Reservasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

        // Query pasien yang memiliki rekam medis
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

        return view('admin.rekam-medis.pasien-list', compact('pasiens', 'search'));
    }

    /**
     * Detail pasien dengan riwayat rekam medis lengkap
     */
    public function showPasien(Pasien $pasien): View
    {
        // Ambil rekam medis pasien
        $rekamMedis = $pasien->rekamMedis()
            ->with('dokter', 'reservasi')
            ->orderByDesc('tanggal')
            ->get();

        return view('admin.rekam-medis.pasien-detail', compact('pasien', 'rekamMedis'));
    }

    /**
     * Edit form untuk rekam medis
     */
    public function editRekamMedis(RekamMedis $rekamMedis): View
    {
        $pasien = $rekamMedis->pasien;

        return view('admin.rekam-medis.edit', compact('rekamMedis', 'pasien'));
    }

    /**
     * Update rekam medis
     */
    public function updateRekamMedis(Request $request, RekamMedis $rekamMedis): RedirectResponse
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

        $rekamMedis->update($validated);

        return redirect()->route('admin.rekam-medis.pasien.show', $rekamMedis->pasien)
            ->with('success', 'Rekam medis berhasil diperbarui');
    }

    /**
     * Create rekam medis dari reservasi (form integrated)
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
            'fotos' => ['nullable', 'array', 'max:5'],
            'fotos.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
        ]);

        $rekamMedis = RekamMedis::create([
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

        // Handle foto uploads
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $file) {
                $filename = 'rekam-medis-' . $rekamMedis->id_rekam_medis . '-' . time() . rand(1, 999) . '.' . $file->getClientOriginalExtension();
                
                $path = $file->storeAs(
                    'foto-rekam-medis',
                    $filename,
                    'local'
                );

                FotoRekamMedis::create([
                    'id_rekam_medis' => $rekamMedis->id_rekam_medis,
                    'foto_path' => $path,
                ]);
            }
        }

        // Tandai reservasi selesai
        $reservasi->update(['status' => 'selesai']);

        // Return JSON if AJAX request, otherwise redirect
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Rekam medis berhasil disimpan dan reservasi ditandai selesai'
            ]);
        }

        return redirect()->route('admin.reservasi.index')
            ->with('success', 'Rekam medis berhasil disimpan dan reservasi ditandai selesai');
    }

    /**
     * Upload foto untuk rekam medis (AJAX)
     */
    public function uploadFoto(Request $request, RekamMedis $rekamMedis): JsonResponse
    {
        $request->validate([
            'fotos' => ['required', 'array'],
            'fotos.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'], // max 5MB each
        ]);

        // Cek jumlah foto yang sudah ada
        $existingCount = $rekamMedis->fotoRekamMedis()->count();
        $newCount = count($request->file('fotos'));
        
        if ($existingCount + $newCount > 5) {
            return response()->json([
                'success' => false,
                'message' => 'Total foto tidak boleh lebih dari 5. Saat ini ada ' . $existingCount . ' foto.'
            ], 422);
        }

        try {
            $uploadedFotos = [];
            
            foreach ($request->file('fotos') as $file) {
                $filename = 'rekam-medis-' . $rekamMedis->id_rekam_medis . '-' . time() . rand(1, 999) . '.' . $file->getClientOriginalExtension();
                
                // Store in private storage
                $path = $file->storeAs(
                    'foto-rekam-medis',
                    $filename,
                    'local'
                );

                $foto = FotoRekamMedis::create([
                    'id_rekam_medis' => $rekamMedis->id_rekam_medis,
                    'foto_path' => $path,
                ]);

                $uploadedFotos[] = [
                    'id_foto' => $foto->id_foto,
                    'foto_path' => $path,
                    'created_at' => $foto->created_at->format('d M Y H:i'),
                ];
            }

            return response()->json([
                'success' => true,
                'message' => count($uploadedFotos) . ' foto berhasil diunggah',
                'fotos' => $uploadedFotos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload foto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete foto dari rekam medis (AJAX)
     */
    public function deleteFoto(Request $request, RekamMedis $rekamMedis, FotoRekamMedis $foto): JsonResponse
    {
        // Cek bahwa foto ini milik rekam medis yang sesuai
        if ($foto->id_rekam_medis !== $rekamMedis->id_rekam_medis) {
            abort(404);
        }

        try {
            // Delete file dari storage
            if ($foto->foto_path && Storage::disk('local')->exists($foto->foto_path)) {
                Storage::disk('local')->delete($foto->foto_path);
            }

            // Delete record dari database
            $foto->delete();

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus foto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get foto untuk rekam medis (AJAX)
     */
    public function getFoto(RekamMedis $rekamMedis): JsonResponse
    {
        $fotos = $rekamMedis->fotoRekamMedis()
            ->get()
            ->map(function ($foto) {
                return [
                    'id_foto' => $foto->id_foto,
                    'foto_path' => $foto->foto_path,
                    'keterangan' => $foto->keterangan,
                    'created_at' => $foto->created_at->format('d M Y H:i'),
                    'url' => route('storage.private', ['path' => $foto->foto_path]),
                ];
            });

        return response()->json([
            'success' => true,
            'fotos' => $fotos
        ]);
    }
}
