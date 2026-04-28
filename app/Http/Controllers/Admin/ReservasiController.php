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
    public function index(): View
    {
        $reservasis = Reservasi::with(['pasien', 'jadwal.dokter'])
            ->orderByDesc('created_at')
            ->paginate(10);

        $statusOptions = ['pending', 'confirmed', 'selesai', 'batal'];

        return view('admin.reservasi.index', compact('reservasis', 'statusOptions'));
    }

    public function show(Reservasi $reservasi): View
    {
        $reservasi->load(['pasien', 'jadwal.dokter']);
        
        // Tentukan status options berdasarkan status saat ini
        $statusOptions = $this->getAvailableStatusTransitions($reservasi->status);

        return view('admin.reservasi.show', compact('reservasi', 'statusOptions'));
    }

    public function update(Request $request, Reservasi $reservasi): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,selesai,batal'],
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
            'status' => ['required', 'in:pending,confirmed,selesai,batal'],
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
            'pending' => ['pending', 'confirmed', 'batal'],
            'confirmed' => ['confirmed', 'selesai', 'batal'],
            'selesai' => ['selesai'],
            'batal' => ['batal'],
        ];

        return $transitions[$currentStatus] ?? [];
    }
}
