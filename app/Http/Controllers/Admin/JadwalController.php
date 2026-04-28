<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalController extends Controller
{
    /**
     * Calendar view — main jadwal page.
     */
    public function index(Request $request): View
    {
        $dokters = User::where('role', 'dokter')->orderBy('nama')->get();

        $selectedDokter = $request->query('dokter');
        $month = (int) $request->query('month', Carbon::now()->month);
        $year  = (int) $request->query('year', Carbon::now()->year);

        // Build calendar data
        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOfMonth   = $startOfMonth->copy()->endOfMonth();

        // Query jadwal counts per date for the selected doctor in this month
        $slotCounts = [];
        if ($selectedDokter) {
            $jadwals = Jadwal::where('id_user', $selectedDokter)
                ->whereBetween('tanggal', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->get();

            foreach ($jadwals as $jadwal) {
                $date = $jadwal->tanggal;
                if (!isset($slotCounts[$date])) {
                    $slotCounts[$date] = ['aktif' => 0, 'nonaktif' => 0, 'booked' => 0];
                }

                $effectiveStatus = $jadwal->effective_status;
                $slotCounts[$date][$effectiveStatus] = ($slotCounts[$date][$effectiveStatus] ?? 0) + 1;
            }
        }

        return view('admin.jadwal.index', compact(
            'dokters',
            'selectedDokter',
            'month',
            'year',
            'startOfMonth',
            'endOfMonth',
            'slotCounts'
        ));
    }

    /**
     * AJAX: Get reservasi for a specific date and doctor (per-tanggal with quota).
     */
    public function getSlots(Request $request): JsonResponse
    {
        $request->validate([
            'dokter' => ['required', 'integer', 'exists:users,id_user'],
            'tanggal' => ['required', 'date'],
        ]);

        $jadwal = Jadwal::with(['reservasi.pasien'])
            ->where('id_user', $request->dokter)
            ->where('tanggal', $request->tanggal)
            ->first();

        if (!$jadwal) {
            return response()->json(['jadwal' => null, 'reservasi' => []]);
        }

        // Get reservasi ordered by created_at (earliest = urutan 1)
        $reservasi = $jadwal->reservasi
            ->whereIn('status', ['pending', 'confirmed'])
            ->sortBy('created_at')
            ->values();

        $data = [
            'id' => $jadwal->id_jadwal,
            'tanggal' => $jadwal->tanggal,
            'status' => $jadwal->effective_status,
            'kuota' => $jadwal->kuota,
            'tersedia' => $jadwal->kuota - $reservasi->count(),
            'reservasi_count' => $reservasi->count(),
            'reservasi' => $reservasi->map(function ($r, $index) {
                return [
                    'urutan' => $index + 1,
                    'id' => $r->id_reservasi,
                    'nama_pasien' => $r->pasien->nama ?? '-',
                    'status' => $r->status,
                    'keluhan' => $r->keluhan,
                    'created_at' => $r->created_at->format('d/m/Y H:i'),
                ];
            })->toArray(),
        ];

        return response()->json(['jadwal' => $data]);
    }

    /**
     * AJAX: Toggle slot status (aktif <-> nonaktif).
     */
    public function toggleSlot(Request $request): JsonResponse
    {
        $request->validate([
            'id_jadwal' => ['required', 'integer', 'exists:jadwal,id_jadwal'],
        ]);

        $jadwal = Jadwal::findOrFail($request->id_jadwal);

        // Cannot toggle if the slot is booked
        if ($jadwal->isBooked()) {
            return response()->json([
                'success' => false,
                'message' => 'Slot ini sudah dipesan dan tidak dapat diubah.',
            ], 422);
        }

        // Toggle between aktif and nonaktif
        $jadwal->status = $jadwal->status === 'aktif' ? 'nonaktif' : 'aktif';
        $jadwal->save();

        return response()->json([
            'success' => true,
            'message' => 'Status slot berhasil diperbarui.',
            'new_status' => $jadwal->status,
        ]);
    }

    /**
     * AJAX: Create or update jadwal for a specific date and doctor (per-tanggal).
     */
    public function generateSlots(Request $request): JsonResponse
    {
        $request->validate([
            'dokter' => ['required', 'integer', 'exists:users,id_user'],
            'tanggal' => ['required', 'date'],
            'kuota' => ['required', 'integer', 'min:1'],
        ]);

        $jadwal = Jadwal::where('id_user', $request->dokter)
            ->where('tanggal', $request->tanggal)
            ->first();

        if ($jadwal) {
            // Update existing jadwal
            $jadwal->update(['kuota' => $request->kuota]);
            $message = "Jadwal berhasil diperbarui.";
        } else {
            // Create new jadwal
            $jadwal = Jadwal::create([
                'id_user' => $request->dokter,
                'tanggal' => $request->tanggal,
                'kuota' => $request->kuota,
                'status' => 'aktif',
            ]);
            $message = "Jadwal berhasil dibuat.";
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'jadwal' => $jadwal,
        ]);
    }

    /**
     * Keep legacy create page for backward compat (optional).
     */
    public function create(): View
    {
        $dokters = User::where('role', 'dokter')->orderBy('nama')->get();
        return view('admin.jadwal.create', compact('dokters'));
    }

    /**
     * Store a new jadwal (form).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_user' => ['required', 'integer', 'exists:users,id_user'],
            'tanggal' => ['required', 'date'],
            'kuota' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        // Check if jadwal already exists for this date and doctor
        $exists = Jadwal::where('id_user', $validated['id_user'])
            ->where('tanggal', $validated['tanggal'])
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Jadwal untuk tanggal dan dokter ini sudah ada.');
        }

        $validated['status'] = 'aktif';

        Jadwal::create($validated);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Jadwal $jadwal): View
    {
        $dokters = User::where('role', 'dokter')->orderBy('nama')->get();
        return view('admin.jadwal.edit', compact('jadwal', 'dokters'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $validated = $request->validate([
            'id_user' => ['required', 'integer', 'exists:users,id_user'],
            'tanggal' => ['required', 'date'],
            'kuota' => ['required', 'integer', 'min:1', 'max:100'],
            'status' => ['nullable', 'in:aktif,nonaktif'],
        ]);

        // Check if another jadwal exists with same date and doctor (but different id)
        $exists = Jadwal::where('id_user', $validated['id_user'])
            ->where('tanggal', $validated['tanggal'])
            ->where('id_jadwal', '!=', $jadwal->id_jadwal)
            ->exists();

        if ($exists) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal untuk tanggal dan dokter ini sudah ada.'
                ], 422);
            }
            return redirect()->back()->with('error', 'Jadwal untuk tanggal dan dokter ini sudah ada.');
        }

        $jadwal->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil diperbarui.',
                'jadwal' => $jadwal
            ]);
        }

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal): RedirectResponse
    {
        try {
            $jadwal->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.jadwal.index')
                ->with('error', 'Jadwal tidak bisa dihapus karena sudah memiliki reservasi.');
        }

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
