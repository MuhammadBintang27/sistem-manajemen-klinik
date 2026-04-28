<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Pasien;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservasiPublicController extends Controller
{
    /**
     * Landing page untuk reservasi publik
     */
    public function index(): View
    {
        return view('reservasi.index');
    }

    /**
     * Form reservasi - step 1: NIK lookup
     */
    public function create(): View
    {
        $jadwals = Jadwal::with(['dokter', 'reservasi'])
            ->where('status', 'aktif')
            ->whereDate('tanggal', '>=', Carbon::today()->toDateString())
            ->orderBy('tanggal')
            ->get();

        return view('reservasi.create', compact('jadwals'));
    }

    /**
     * AJAX: Check if NIK exists and return patient data
     */
    public function checkNik(Request $request): JsonResponse
    {
        $request->validate([
            'nik' => ['required', 'digits:16'],
        ]);

        $pasien = Pasien::where('nik', $request->nik)->first();

        if ($pasien) {
            return response()->json([
                'found' => true,
                'pasien' => [
                    'id_pasien' => $pasien->id_pasien,
                    'nik' => $pasien->nik,
                    'nama' => $pasien->nama,
                    'alamat' => $pasien->alamat,
                    'jenis_kelamin' => $pasien->jenis_kelamin,
                    'no_hp' => $pasien->no_hp,
                ]
            ]);
        }

        return response()->json(['found' => false]);
    }

    /**
     * Store reservasi dengan NIK lookup flow
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'id_jadwal' => ['required', 'integer', 'exists:jadwal,id_jadwal'],
                'nik' => ['required', 'digits:16'],
                'keluhan' => ['nullable', 'string', 'max:255'],

                // data pasien (nama wajib kalau NIK belum terdaftar)
                'nama' => ['nullable', 'string', 'max:50'],
                'alamat' => ['nullable', 'string', 'max:100'],
                'jenis_kelamin' => ['nullable', 'in:L,P'],
                'no_hp' => ['nullable', 'string', 'max:20'],
            ], [
                'id_jadwal.required' => 'Jadwal harus dipilih',
                'id_jadwal.exists' => 'Jadwal tidak ditemukan',
                'nik.required' => 'NIK harus diisi',
                'nik.digits' => 'NIK harus 16 digit',
            ]);

            $jadwal = Jadwal::with('dokter')->findOrFail($validated['id_jadwal']);

            $usedQuota = Reservasi::query()
                ->where('id_jadwal', $jadwal->id_jadwal)
                ->whereIn('status', ['pending', 'confirmed'])
                ->count();

            if ($jadwal->kuota < 1 || $usedQuota >= $jadwal->kuota) {
                return back()
                    ->withErrors(['id_jadwal' => 'Kuota jadwal ini sudah penuh.'])
                    ->withInput();
            }

            $pasien = Pasien::query()->where('nik', $validated['nik'])->first();

            if (!$pasien) {
                // Validate nama diperlukan untuk pasien baru
                if (!$validated['nama']) {
                    return back()
                        ->withErrors(['nama' => 'Nama harus diisi untuk pasien baru'])
                        ->withInput();
                }

                $pasien = Pasien::create([
                    'nik' => $validated['nik'],
                    'nama' => $validated['nama'],
                    'alamat' => $validated['alamat'] ?? null,
                    'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                    'no_hp' => $validated['no_hp'] ?? null,
                ]);
            }

            Reservasi::create([
                'id_pasien' => $pasien->id_pasien,
                'id_jadwal' => $jadwal->id_jadwal,
                'keluhan' => $validated['keluhan'] ?? null,
                'status' => 'pending',
            ]);

            return redirect()->route('reservasi.success')->with('success', 'Reservasi berhasil dibuat!');
        } catch (\Exception $e) {
            \Log::error('Reservasi Error: ' . $e->getMessage(), ['exception' => $e]);
            return back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Success page
     */
    public function success(): View
    {
        return view('reservasi.success');
    }
}
