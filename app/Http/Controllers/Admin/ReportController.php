<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReservationReportService;
use App\Services\FinancialReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    protected $reservationService;
    protected $financialService;

    public function __construct(
        ReservationReportService $reservationService,
        FinancialReportService $financialService
    ) {
        $this->reservationService = $reservationService;
        $this->financialService = $financialService;
    }

    /**
     * Show report selection form
     */
    public function index()
    {
        $quickSelectRanges = ReservationReportService::getQuickSelectRanges();

        return view('reports.laporan-form', [
            'quickSelectRanges' => $quickSelectRanges,
        ]);
    }

    /**
     * Export Reservation Report
     */
    public function exportReservasi(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:csv,pdf,xlsx',
        ]);

        try {
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);

            // Get report data
            $reportData = $this->reservationService->getReservationReport($startDate, $endDate);

            // Generate file based on format
            switch ($request->format) {
                case 'csv':
                    return $this->exportReservationCSV($reportData);
                case 'pdf':
                    return $this->exportReservationPDF($reportData);
                case 'xlsx':
                    return $this->exportReservationExcel($reportData);
                default:
                    return redirect()->back()->with('error', 'Format tidak didukung');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menggenerate laporan: ' . $e->getMessage());
        }
    }

    /**
     * Export Financial Report
     */
    public function exportKeuangan(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:csv,pdf,xlsx',
        ]);

        try {
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);

            // Get report data
            $reportData = $this->financialService->getFinancialReport($startDate, $endDate);

            // Generate file based on format
            switch ($request->format) {
                case 'csv':
                    return $this->exportKeuanganCSV($reportData);
                case 'pdf':
                    return $this->exportKeuanganPDF($reportData);
                case 'xlsx':
                    return $this->exportKeuanganExcel($reportData);
                default:
                    return redirect()->back()->with('error', 'Format tidak didukung');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menggenerate laporan: ' . $e->getMessage());
        }
    }

    /**
     * Export Reservation to CSV
     */
    private function exportReservationCSV($reportData)
    {
        $filename = 'Laporan_Reservasi_' . $reportData['period']['start_date'] . '_' . $reportData['period']['end_date'] . '.csv';

        $response = new StreamedResponse(function () use ($reportData) {
            $file = fopen('php://output', 'w');

            // Set BOM for UTF-8 (Excel compatibility)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header info
            fputcsv($file, ['LAPORAN RESERVASI KLINIK']);
            fputcsv($file, ['Periode', $reportData['period']['start_date_formatted'] . ' s/d ' . $reportData['period']['end_date_formatted']]);
            fputcsv($file, ['Tanggal Cetak', $reportData['period']['print_date']]);
            fputcsv($file, []);

            // Statistics
            fputcsv($file, ['STATISTIK RINGKASAN']);
            fputcsv($file, ['Total Reservasi', $reportData['statistics']['total_reservasi']]);
            fputcsv($file, ['Menunggu Konfirmasi', $reportData['statistics']['menunggu_konfirmasi']]);
            fputcsv($file, ['Sudah Dikonfirmasi', $reportData['statistics']['sudah_dikonfirmasi']]);
            fputcsv($file, ['Batal', $reportData['statistics']['batal']]);
            fputcsv($file, ['Selesai', $reportData['statistics']['selesai']]);
            fputcsv($file, ['Tingkat Pembatalan', $reportData['statistics']['cancellation_rate']]);
            fputcsv($file, []);

            // Detail table header
            fputcsv($file, ['No', 'Tanggal Jadwal', 'Nama Pasien', 'Nama Dokter', 'Keluhan', 'Status Reservasi']);

            // Detail data
            foreach ($reportData['details'] as $item) {
                fputcsv($file, [
                    $item['no'],
                    $item['tanggal_jadwal'],
                    $item['nama_pasien'],
                    $item['nama_dokter'],
                    $item['keluhan'],
                    $item['status'],
                ]);
            }

            fclose($file);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }

    /**
     * Export Reservation to PDF
     */
    private function exportReservationPDF($reportData)
    {
        $pdf = Pdf::loadView('reports.reservasi-pdf', [
            'reportData' => $reportData,
        ]);

        $filename = 'Laporan_Reservasi_' . $reportData['period']['start_date'] . '_' . $reportData['period']['end_date'] . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export Reservation to Excel
     */
    private function exportReservationExcel($reportData)
    {
        $filename = 'Laporan_Reservasi_' . $reportData['period']['start_date'] . '_' . $reportData['period']['end_date'] . '.xlsx';

        return Excel::download(
            new \App\Exports\ReservationReportExport($reportData),
            $filename
        );
    }

    /**
     * Export Financial to CSV
     */
    private function exportKeuanganCSV($reportData)
    {
        $filename = 'Laporan_Keuangan_' . $reportData['period']['start_date'] . '_' . $reportData['period']['end_date'] . '.csv';

        $response = new StreamedResponse(function () use ($reportData) {
            $file = fopen('php://output', 'w');

            // Set BOM for UTF-8 (Excel compatibility)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header info
            fputcsv($file, ['LAPORAN KEUANGAN KLINIK']);
            fputcsv($file, ['Periode', $reportData['period']['start_date_formatted'] . ' s/d ' . $reportData['period']['end_date_formatted']]);
            fputcsv($file, ['Tanggal Cetak', $reportData['period']['print_date']]);
            fputcsv($file, []);

            // Statistics
            fputcsv($file, ['STATISTIK RINGKASAN']);
            fputcsv($file, ['Total Pendapatan', $reportData['statistics']['total_pendapatan_formatted']]);
            fputcsv($file, ['Total Transaksi', $reportData['statistics']['total_transaksi']]);
            fputcsv($file, ['Rata-rata Pendapatan per Transaksi', $reportData['statistics']['rata_rata_pendapatan_formatted']]);
            fputcsv($file, []);

            // Detail table header
            fputcsv($file, ['No', 'Tanggal', 'Nama Pasien', 'Dokter', 'Terapi', 'Tarif']);

            // Detail data
            foreach ($reportData['details'] as $item) {
                fputcsv($file, [
                    $item['no'],
                    $item['tanggal'],
                    $item['nama_pasien'],
                    $item['nama_dokter'],
                    $item['terapi'],
                    $item['tarif_formatted'],
                ]);
            }

            fclose($file);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }

    /**
     * Export Financial to PDF
     */
    private function exportKeuanganPDF($reportData)
    {
        $pdf = Pdf::loadView('reports.keuangan-pdf', [
            'reportData' => $reportData,
        ]);

        $filename = 'Laporan_Keuangan_' . $reportData['period']['start_date'] . '_' . $reportData['period']['end_date'] . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export Financial to Excel
     */
    private function exportKeuanganExcel($reportData)
    {
        $filename = 'Laporan_Keuangan_' . $reportData['period']['start_date'] . '_' . $reportData['period']['end_date'] . '.xlsx';

        return Excel::download(
            new \App\Exports\FinancialReportExport($reportData),
            $filename
        );
    }
}
