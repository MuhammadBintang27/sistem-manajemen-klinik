<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Reservasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DokterController extends Controller
{
    public function dashboard(): View
    {
        $jadwals = Jadwal::where('id_user', auth()->id())
            ->whereDate('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal')
            ->get();

        $reservasiCount = Reservasi::whereHas('jadwal', function ($query) {
            $query->where('id_user', auth()->id());
        })->count();

        $pendingCount = Reservasi::whereHas('jadwal', function ($query) {
            $query->where('id_user', auth()->id());
        })->where('status', 'menunggu_konfirmasi')->count();

        return view('dokter.dashboard', compact('jadwals', 'reservasiCount', 'pendingCount'));
    }

    public function jadwal(Request $request): View
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        return view('dokter.jadwal.index', compact('month', 'year'));
    }

    public function getSlots(Request $request): JsonResponse
    {
        $tanggal = $request->get('tanggal');
        $dokterId = auth()->id();

        $jadwal = Jadwal::where('id_user', $dokterId)
            ->where('tanggal', $tanggal)
            ->with(['reservasi' => function ($q) {
                $q->select('id_reservasi', 'id_jadwal', 'id_pasien', 'status', 'keluhan', 'created_at');
                $q->with('pasien:id_pasien,nama,nik');
            }])
            ->first();

        if ($jadwal) {
            return response()->json([
                'jadwal' => [
                    'id' => $jadwal->id_jadwal,
                    'tanggal' => $jadwal->tanggal,
                    'kuota' => $jadwal->kuota,
                    'status' => $jadwal->status,
                    'reservasi_count' => $jadwal->reservasi->count(),
                    'reservasi' => $jadwal->reservasi->map(function ($r) {
                        return [
                            'id' => $r->id_reservasi,
                            'urutan' => $r->id_reservasi,
                            'nama_pasien' => $r->pasien?->nama ?? '-',
                            'keluhan' => $r->keluhan,
                            'status' => $r->status,
                            'created_at' => $r->created_at->format('d M Y H:i'),
                        ];
                    })->values(),
                ],
            ]);
        }

        return response()->json(['jadwal' => null]);
    }

    public function reservasi(): View
    {
        $reservasis = Reservasi::with(['pasien', 'jadwal', 'rekamMedis' => function ($q) {
            $q->orderByDesc('tanggal');
        }])
            ->whereHas('jadwal', function ($query) {
                $query->where('id_user', auth()->id());
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('dokter.reservasi.index', compact('reservasis'));
    }

    public function reservasiShow(Reservasi $reservasi): View
    {
        // Authorization check
        if ($reservasi->jadwal?->id_user !== auth()->id()) {
            abort(403);
        }

        $reservasi->load(['pasien', 'jadwal', 'rekamMedis' => function ($q) {
            $q->orderByDesc('tanggal');
        }]);

        return view('dokter.reservasi.show', compact('reservasi'));
    }
}
