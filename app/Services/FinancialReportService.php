<?php

namespace App\Services;

use App\Models\RekamMedis;
use Carbon\Carbon;

class FinancialReportService
{
    /**
     * Generate financial report data for given date range
     * 
     * @param string|Carbon $startDate
     * @param string|Carbon $endDate
     * @return array
     */
    public function getFinancialReport($startDate, $endDate)
    {
        // Ensure dates are Carbon instances
        $startDate = $startDate instanceof Carbon ? $startDate : Carbon::parse($startDate)->startOfDay();
        $endDate = $endDate instanceof Carbon ? $endDate : Carbon::parse($endDate)->endOfDay();

        // Get all rekam medis data for the period (filtered by rekam_medis.tanggal)
        $rekamMedisData = RekamMedis::query()
            ->join('pasien', 'rekam_medis.id_pasien', '=', 'pasien.id_pasien')
            ->join('users', 'rekam_medis.id_user', '=', 'users.id_user')
            ->whereBetween('rekam_medis.tanggal', [$startDate, $endDate])
            ->select(
                'rekam_medis.id_rekam_medis',
                'rekam_medis.tanggal',
                'pasien.nama as nama_pasien',
                'users.nama as nama_dokter',
                'rekam_medis.terapi',
                'rekam_medis.tarif',
                'rekam_medis.created_at'
            )
            ->orderBy('rekam_medis.tanggal', 'desc')
            ->get();

        // Calculate statistics
        $totalTarif = $rekamMedisData->sum('tarif');
        $totalTransaksi = $rekamMedisData->count();
        $averageTarif = $totalTransaksi > 0 ? $totalTarif / $totalTransaksi : 0;

        $statistics = [
            'total_pendapatan' => $totalTarif,
            'total_pendapatan_formatted' => 'Rp ' . number_format($totalTarif, 0, ',', '.'),
            'total_transaksi' => $totalTransaksi,
            'rata_rata_pendapatan' => round($averageTarif, 2),
            'rata_rata_pendapatan_formatted' => 'Rp ' . number_format($averageTarif, 0, ',', '.'),
        ];

        return [
            'period' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'start_date_formatted' => $startDate->locale('id')->translatedFormat('d F Y'),
                'end_date_formatted' => $endDate->locale('id')->translatedFormat('d F Y'),
                'print_date' => now()->locale('id')->translatedFormat('d F Y H:i:s'),
            ],
            'statistics' => $statistics,
            'details' => $rekamMedisData->map(function ($item, $index) {
                return [
                    'no' => $index + 1,
                    'tanggal' => Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d M Y'),
                    'nama_pasien' => $item->nama_pasien,
                    'nama_dokter' => $item->nama_dokter,
                    'terapi' => $item->terapi ?? '-',
                    'tarif' => $item->tarif,
                    'tarif_formatted' => 'Rp ' . number_format($item->tarif, 0, ',', '.'),
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
}
