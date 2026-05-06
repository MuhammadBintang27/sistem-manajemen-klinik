<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReservationReportExport implements WithMultipleSheets
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function sheets(): array
    {
        return [
            'Summary' => new ReservationSummarySheet($this->reportData),
            'Detail'  => new ReservationDetailSheet($this->reportData),
        ];
    }
}

class ReservationSummarySheet implements FromArray, WithHeadings, WithStyles
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function array(): array
    {
        $stats = $this->reportData['statistics'] ?? [];

        // paksa default 0 supaya tidak null / tidak muncul "nihil"
        $total = ($stats['total_reservasi'] ?? "nihil");
        $menunggu = ($stats['menunggu_konfirmasi'] ?? "nihil");
        $dikonfirmasi =  ($stats['sudah_dikonfirmasi'] ?? "nihil");
        $batal = ($stats['batal'] ?? "nihil");
        $selesai =  ($stats['selesai'] ?? "nihil");

        // cancellation rate harus  numeric
        $cancellationRate = ($total > 0)
            ? round(($batal / $total) * 100, 2)
            : 0;

        return [
    ['Laporan Reservasi Klinik', ''],
    ['Periode', $this->reportData['period']['start_date_formatted'] . ' s/d ' . $this->reportData['period']['end_date_formatted']],
    ['Tanggal Cetak', $this->reportData['period']['print_date']],
    ['', ''],
    ['STATISTIK RINGKASAN', ''],
    ['Total Reservasi', (int) $total],
    ['Menunggu Konfirmasi', (int) $menunggu],
    ['Sudah Dikonfirmasi', (int) $dikonfirmasi],
    ['Batal', (int) $batal],
    ['Selesai', (int) $selesai],
    ['Tingkat Pembatalan (%)', (float) $cancellationRate],
];
    }

    public function headings(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A5')->getFont()->setBold(true)->setSize(12);

        // Make stat rows bold
        foreach (range(6, 11) as $row) {
            $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        }

        // format angka biasa (0) untuk B6-B10
        foreach (range(6, 10) as $row) {
            $sheet->getStyle('B' . $row)->getNumberFormat()->setFormatCode('0');
        }

        // format persen untuk cancellation rate (B11)
        $sheet->getStyle('B11')->getNumberFormat()->setFormatCode('0.00');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(25);

        return [];
    }
}

class ReservationDetailSheet implements FromArray, WithHeadings, WithStyles
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function array(): array
    {
        return $this->reportData['details'] ?? [];
    }

    public function headings(): array
    {
        return ['No', 'Tanggal Jadwal', 'Nama Pasien', 'Nama Dokter', 'Keluhan', 'Status Reservasi'];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FFC0C0C0');

        // Auto-size columns
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }
}