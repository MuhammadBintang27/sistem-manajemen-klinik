<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Reservasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservasiController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->get('status', '');
        $dateRange = $request->get('date_range', 'week');
        $search = $request->get('search', '');
        $dokter = $request->get('dokter', '');

        // Determine date range
        $startDate = now()->toDateString();
        $endDate = now()->toDateString();

        if ($dateRange === 'week') {
            $endDate = now()->addDays(7)->toDateString();
        } elseif ($dateRange === 'month') {
            $endDate = now()->endOfMonth()->toDateString();
        } elseif ($dateRange === 'all') {
            $startDate = null;
            $endDate = null;
        }

        $query = Reservasi::with(['pasien', 'jadwal.dokter']);

        // Filter by date range
        if ($startDate && $endDate) {
            $query->whereHas('jadwal', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal', [$startDate, $endDate]);
            });
        }

        // Filter by status
        if ($status && $status !== '') {
            $query->where('status', $status);
        }

        // Filter by dokter
        if ($dokter && $dokter !== '') {
            $query->whereHas('jadwal', function ($q) use ($dokter) {
                $q->where('id_user', $dokter);
            });
        }

        // Filter by search (pasien nama atau nik)
        if ($search && $search !== '') {
            $query->whereHas('pasien', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $reservasis = $query->orderByDesc('created_at')->paginate(15);

        // Get all dokters for filter dropdown
        $dokters = \App\Models\User::where('role', 'dokter')->orderBy('nama')->get();
        $statusOptions = ['menunggu_konfirmasi', 'sudah_dikonfirmasi', 'selesai', 'dibatalkan'];

        return view('admin.reservasi.index', compact('reservasis', 'statusOptions', 'dokters', 'status', 'dateRange', 'search', 'dokter'));
    }

    public function show(Reservasi $reservasi): View
    {
        $reservasi->load(['pasien', 'jadwal.dokter']);
        
        // Generate virtual jadwal untuk 3 bulan ke depan
        $today = now()->startOfDay();
        $endDate = $today->copy()->addMonths(3);
        
        $jadwals = collect();
        $dokters = \App\Models\User::where('role', 'dokter')->get();
        
        foreach ($dokters as $dokter) {
            for ($date = $today->copy(); $date <= $endDate; $date->addDay()) {
                $dateStr = $date->format('Y-m-d');
                
                // Cek apakah jadwal sudah ada di database
                $jadwalDb = Jadwal::where('id_user', $dokter->id_user)
                    ->where('tanggal', $dateStr)
                    ->first();
                
                if ($jadwalDb) {
                    $jadwalDb->load('dokter', 'reservasi');
                    $jadwals->push($jadwalDb);
                } else {
                    // Buat virtual jadwal dengan default: status aktif, kuota 5
                    $jadwalVirtual = new Jadwal([
                        'id_jadwal' => null,
                        'id_user' => $dokter->id_user,
                        'tanggal' => $dateStr,
                        'kuota' => 5,
                        'status' => 'aktif',
                    ]);
                    $jadwalVirtual->setRelation('dokter', $dokter);
                    $jadwalVirtual->setRelation('reservasi', collect());
                    $jadwals->push($jadwalVirtual);
                }
            }
        }
        
        // Tentukan status options berdasarkan status saat ini
        $statusOptions = $this->getAvailableStatusTransitions($reservasi->status);

        return view('admin.reservasi.show', compact('reservasi', 'statusOptions', 'jadwals'));
    }

    public function update(Request $request, Reservasi $reservasi): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:menunggu_konfirmasi,sudah_dikonfirmasi,selesai,dibatalkan'],
            'id_jadwal' => ['required', 'exists:jadwal,id_jadwal'],
            'keluhan' => ['required', 'string', 'max:500'],
        ]);

        // Validasi transisi status
        $availableStatuses = $this->getAvailableStatusTransitions($reservasi->status);
        if (!in_array($validated['status'], $availableStatuses)) {
            return redirect()->route('admin.reservasi.show', $reservasi)
                ->withErrors(['status' => 'Transisi status tidak valid.']);
        }

        $reservasi->update([
            'status' => $validated['status'],
            'id_jadwal' => $validated['id_jadwal'],
            'keluhan' => $validated['keluhan'],
        ]);

        return redirect()->route('admin.reservasi.index')
            ->with('success', 'Reservasi berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Reservasi $reservasi): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:menunggu_konfirmasi,sudah_dikonfirmasi,selesai,dibatalkan'],
        ]);

        // Validasi transisi status
        $availableStatuses = $this->getAvailableStatusTransitions($reservasi->status);
        if (!in_array($validated['status'], $availableStatuses)) {
            return redirect()->route('admin.reservasi.index')
                ->withErrors(['status' => 'Transisi status tidak valid.']);
        }

        $reservasi->update([
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.reservasi.index')->with('success', 'Status reservasi berhasil diperbarui.');
    }

    private function getAvailableStatusTransitions(string $currentStatus): array
    {
        // Definisikan transisi status yang diizinkan
        $transitions = [
            'menunggu_konfirmasi' => ['menunggu_konfirmasi', 'sudah_dikonfirmasi', 'dibatalkan'],
            'sudah_dikonfirmasi' => ['sudah_dikonfirmasi', 'selesai', 'dibatalkan'],
            'selesai' => ['selesai'],
            'dibatalkan' => ['dibatalkan'],
        ];

        return $transitions[$currentStatus] ?? [];
    }
}
