<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class FinancialReportExport implements WithMultipleSheets
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function sheets(): array
    {
        return [
            'Summary' => new FinancialSummarySheet($this->reportData),
            'Detail' => new FinancialDetailSheet($this->reportData),
        ];
    }
}

class FinancialSummarySheet implements FromArray, WithHeadings, WithStyles
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function array(): array
    {
        $stats = $this->reportData['statistics'];

        return [
            ['Laporan Keuangan Klinik'],
            ['Periode', $this->reportData['period']['start_date_formatted'] . ' s/d ' . $this->reportData['period']['end_date_formatted']],
            ['Tanggal Cetak', $this->reportData['period']['print_date']],
            [],
            ['STATISTIK RINGKASAN'],
            ['Total Pendapatan', $stats['total_pendapatan']],
            ['Total Transaksi', $stats['total_transaksi']],
            ['Rata-rata Pendapatan per Transaksi', $stats['rata_rata_pendapatan']],
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
        
        // Make all stat rows bold
        foreach (range(6, 8) as $row) {
            $sheet->getStyle($row)->getFont()->setBold(true);
        }

        // Format currency columns
        $sheet->getStyle('B6')->getNumberFormat()->setFormatCode('0');
        
        // Format Total Transaksi as regular number (B7)
        $sheet->getStyle('B7')->getNumberFormat()->setFormatCode('0');
        
        // Format rata-rata as currency (B8)
        $sheet->getStyle('B8')->getNumberFormat()->setFormatCode('_("Rp"* #,##0.00_);_("Rp"* (#,##0.00);_("Rp"* "-"??_);_(@_)');

        return [];
    }
}

class FinancialDetailSheet implements FromArray, WithHeadings, WithStyles
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function array(): array
    {
        return collect($this->reportData['details'])->map(function ($item) {
            return [
                'no' => $item['no'],
                'tanggal' => $item['tanggal'],
                'nama_pasien' => $item['nama_pasien'],
                'nama_dokter' => $item['nama_dokter'],
                'terapi' => $item['terapi'],
                'tarif' => $item['tarif'],
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return ['No', 'Tanggal', 'Nama Pasien', 'Dokter', 'Terapi', 'Tarif'];
    }

    public function styles(Worksheet $sheet)
    {
        // Header styling
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFC0C0C0');

        // Format currency column (F)
        $sheet->getStyle('F')->getNumberFormat()->setFormatCode('_("Rp"* #,##0.00_);_("Rp"* (#,##0.00);_("Rp"* "-"??_);_(@_)');

        // Auto-size columns
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Right align numeric columns
        $sheet->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        return [];
    }
}
