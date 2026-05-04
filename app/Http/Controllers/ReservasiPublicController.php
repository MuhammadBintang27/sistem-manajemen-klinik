<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Pasien;
use App\Models\Reservasi;
use App\Models\User;
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
        // Get semua dokter yang aktif
        $dokters = User::where('role', 'dokter')->get();
        
        // Generate jadwal default untuk 3 bulan ke depan
        $today = Carbon::today();
        $endDate = $today->copy()->addMonths(3);
        
        $jadwals = collect();
        
        // Loop setiap dokter
        foreach ($dokters as $dokter) {
            // Loop setiap tanggal dari hari ini hingga 3 bulan ke depan
            for ($date = $today->copy(); $date <= $endDate; $date->addDay()) {
                $dateStr = $date->toDateString();
                
                // Cek apakah jadwal sudah ada di database
                $jadwalDb = Jadwal::where('id_user', $dokter->id_user)
                    ->where('tanggal', $dateStr)
                    ->first();
                
                if ($jadwalDb) {
                    // Jika ada di database, ambil dari sana (sudah di-adjust admin)
                    if ($jadwalDb->status === 'aktif') {
                        $jadwalDb->load('dokter', 'reservasi');
                        $jadwals->push($jadwalDb);
                    }
                } else {
                    // Jika tidak ada, buat instance jadwal virtual dengan default
                    $jadwalVirtual = new Jadwal([
                        'id_user' => $dokter->id_user,
                        'tanggal' => $dateStr,
                        'kuota' => 5,
                        'status' => 'aktif',
                    ]);
                    $jadwalVirtual->setRelation('dokter', $dokter);
                    $jadwalVirtual->setRelation('reservasi', collect()); // Tidak ada reservasi untuk jadwal baru
                    
                    $jadwals->push($jadwalVirtual);
                }
            }
        }
        
        // Sort by tanggal
        $jadwals = $jadwals->sortBy(function ($jadwal) {
            return $jadwal->tanggal;
        })->values();

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
            // Parse id_jadwal yang bisa dari format "user_tanggal" atau integer
            $idJadwalInput = $request->input('id_jadwal');
            $jadwal = null;
            $idUser = null;
            $tanggal = null;
            
            // Cek format jadwal yang di-submit
            if (strpos($idJadwalInput, '_') !== false) {
                // Format "user_tanggal" untuk jadwal virtual
                [$idUser, $tanggal] = explode('_', $idJadwalInput);
                
                // Coba cari di database, jika tidak ada buat baru
                $jadwal = Jadwal::where('id_user', $idUser)
                    ->where('tanggal', $tanggal)
                    ->first();
                
                if (!$jadwal) {
                    // Buat jadwal baru dengan default
                    $jadwal = Jadwal::create([
                        'id_user' => $idUser,
                        'tanggal' => $tanggal,
                        'kuota' => 5,
                        'status' => 'aktif',
                    ]);
                }
            } else {
                // Format integer - jadwal dari database
                $jadwal = Jadwal::findOrFail($idJadwalInput);
            }
            
            $jadwal->load('dokter');
            
            $validated = $request->validate([
                'id_jadwal' => ['required'],
                'nik' => ['required', 'digits:16'],
                'keluhan' => ['nullable', 'string', 'max:255'],

                // data pasien (nama wajib kalau NIK belum terdaftar)
                'nama' => ['nullable', 'string', 'max:50'],
                'alamat' => ['nullable', 'string', 'max:100'],
                'jenis_kelamin' => ['nullable', 'in:L,P'],
                'no_hp' => ['nullable', 'string', 'max:20'],
            ], [
                'id_jadwal.required' => 'Jadwal harus dipilih',
                'nik.required' => 'NIK harus diisi',
                'nik.digits' => 'NIK harus 16 digit',
            ]);

            // Hitung SEMUA reservasi di jadwal ini (menunggu_konfirmasi, sudah_dikonfirmasi, selesai)
            $usedQuota = Reservasi::query()
                ->where('id_jadwal', $jadwal->id_jadwal)
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
                'status' => 'menunggu_konfirmasi',
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
