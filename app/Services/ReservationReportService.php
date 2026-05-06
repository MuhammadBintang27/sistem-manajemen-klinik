<?php

namespace App\Services;

use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ReservationReportService
{
    /**
     * Generate reservation report data for given date range
     * 
     * @param string|Carbon $startDate
     * @param string|Carbon $endDate
     * @return array
     */
    public function getReservationReport($startDate, $endDate)
    {
        // Ensure dates are Carbon instances
        $startDate = $startDate instanceof Carbon ? $startDate : Carbon::parse($startDate)->startOfDay();
        $endDate = $endDate instanceof Carbon ? $endDate : Carbon::parse($endDate)->endOfDay();

        // Get all reservasi data for the period (filtered by jadwal.tanggal)
        $reservasiData = Reservasi::query()
            ->join('jadwal', 'reservasi.id_jadwal', '=', 'jadwal.id_jadwal')
            ->join('pasien', 'reservasi.id_pasien', '=', 'pasien.id_pasien')
            ->join('users', 'jadwal.id_user', '=', 'users.id_user')
            ->whereBetween('jadwal.tanggal', [$startDate, $endDate])
            ->select(
                'reservasi.id_reservasi',
                'reservasi.status',
                'jadwal.tanggal as jadwal_tanggal',
                'pasien.nama as nama_pasien',
                'users.nama as nama_dokter',
                'reservasi.keluhan',
                'reservasi.created_at'
            )
            ->orderBy('jadwal.tanggal', 'desc')
            ->get();

        // Calculate statistics by status
        $statistics = [
            'total_reservasi' => $reservasiData->count(),
            'menunggu_konfirmasi' => $reservasiData->where('status', 'menunggu_konfirmasi')->count(),
            'sudah_dikonfirmasi' => $reservasiData->where('status', 'sudah_dikonfirmasi')->count(),
            'batal' => $reservasiData->where('status', 'dibatalkan')->count(),
            'selesai' => $reservasiData->where('status', 'selesai')->count(),
        ];

        // Calculate cancellation rate
        $cancellationRate = $statistics['total_reservasi'] > 0 
            ? round(($statistics['batal'] / $statistics['total_reservasi']) * 100, 2)
            : 0;

        return [
            'period' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'start_date_formatted' => $startDate->locale('id')->translatedFormat('d F Y'),
                'end_date_formatted' => $endDate->locale('id')->translatedFormat('d F Y'),
                'print_date' => now()->locale('id')->translatedFormat('d F Y H:i:s'),
            ],
            'statistics' => array_merge($statistics, [
                'cancellation_rate' => $cancellationRate . '%',
                'cancellation_rate_numeric' => $cancellationRate,
            ]),
            'details' => $reservasiData->map(function ($item, $index) {
                return [
                    'no' => $index + 1,
                    'tanggal_jadwal' => Carbon::parse($item->jadwal_tanggal)->locale('id')->translatedFormat('d M Y'),
                    'nama_pasien' => $item->nama_pasien,
                    'nama_dokter' => $item->nama_dokter,
                    'keluhan' => $item->keluhan ?? '-',
                    'status' => $this->translateStatus($item->status),
                ];
            })->toArray(),
        ];
    }

    /**
     * Get quick select date ranges
     * 
     * @return array
     */
    public static function getQuickSelectRanges()
    {
        $now = now();

        return [
            'minggu_ini' => [
                'label' => 'Minggu ini',
                'start' => $now->copy()->startOfWeek()->toDateString(),
                'end' => $now->copy()->endOfWeek()->toDateString(),
            ],
            'bulan_ini' => [
                'label' => 'Bulan ini',
                'start' => $now->copy()->startOfMonth()->toDateString(),
                'end' => $now->copy()->endOfMonth()->toDateString(),
            ],
            'tahun_ini' => [
                'label' => 'Tahun ini',
                'start' => $now->copy()->startOfYear()->toDateString(),
                'end' => $now->copy()->endOfYear()->toDateString(),
            ],
        ];
    }

    /**
     * Translate status to Indonesian
     * 
     * @param string $status
     * @return string
     */
    private function translateStatus($status)
    {
        $translations = [
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'sudah_dikonfirmasi' => 'Sudah Dikonfirmasi',
            'dibatalkan' => 'Batal',
            'selesai' => 'Selesai',
        ];

        return $translations[$status] ?? ucfirst($status);
    }
}
