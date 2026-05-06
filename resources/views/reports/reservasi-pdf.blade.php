<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Reservasi Klinik</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            color: #1f2937;
            line-height: 1.6;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        
        /* Header */
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 4px solid #D94A8C;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 26px;
            color: #97215f;
            font-weight: 700;
        }
        
        .header p {
            margin: 8px 0 0 0;
            font-size: 13px;
            color: #6b7280;
        }
        
        /* Period Info */
        .period-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 13px;
            background: linear-gradient(135deg, #FEF8FB 0%, #FDF2F8 100%);
            padding: 14px;
            border: 1px solid #F8D6E3;
            border-radius: 8px;
        }
        
        .period-info div {
            flex: 1;
        }
        
        .period-info strong {
            color: #1f2937;
            font-weight: 600;
        }
        
        /* Statistics */
        .statistics {
            margin: 25px 0;
            page-break-inside: avoid;
        }
        
        .statistics h3 {
            font-size: 14px;
            color: #97215f;
            margin: 0 0 12px 0;
            border-bottom: 3px solid #D94A8C;
            padding-bottom: 8px;
            font-weight: 700;
        }
        
        .stats-table {
            width: 100%;
            margin-bottom: 12px;
            font-size: 12px;
            border-collapse: collapse;
        }
        
        .stats-table tr {
            background-color: #FEF8FB;
        }
        
        .stats-table tr:nth-child(even) {
            background-color: #ffffff;
        }
        
        .stats-table td {
            padding: 10px;
            border-bottom: 1px solid #F8D6E3;
        }
        
        .stats-table td:first-child {
            font-weight: 600;
            width: 70%;
            color: #374151;
        }
        
        .stats-table td:last-child {
            text-align: right;
            font-weight: 700;
            color: #D94A8C;
        }
        
        /* Detail Table */
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11px;
            page-break-inside: avoid;
        }
        
        .detail-table thead {
            background: linear-gradient(135deg, #97215f 0%, #D94A8C 100%);
            color: black;
        }
        
        .detail-table th {
            padding: 12px;
            text-align: left;
            font-weight: 700;
            border: 1px solid #97215f;
        }
        
        .detail-table td {
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
        }
        
        .detail-table tbody tr:nth-child(odd) {
            background-color: #FEF8FB;
        }
        
        .detail-table tbody tr:nth-child(even) {
            background-color: #ffffff;
        }
        
        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #9ca3af;
            border-top: 2px solid #F8D6E3;
            padding-top: 15px;
        }
        
        .footer p {
            margin: 4px 0;
        }
        
        /* Status Badge */
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 11px;
        }
        
        .status.menunggu {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status.dikonfirmasi {
            background-color: #F8D6E3;
            color: #97215f;
        }
        
        .status.batal {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .status.selesai {
            background-color: #F0B5CE;
            color: #7b1d55;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Laporan Reservasi Klinik</h1>
            <p>Dokumen resmi laporan reservasi pasien</p>
        </div>

        <!-- Period Info -->
        <div class="period-info">
            <div>
                <strong>Periode:</strong><br>
                {{ $reportData['period']['start_date_formatted'] }} s/d {{ $reportData['period']['end_date_formatted'] }}
            </div>
            <div style="text-align: right;">
                <strong>Tanggal Cetak:</strong><br>
                {{ $reportData['period']['print_date'] }}
            </div>
        </div>

        <!-- Statistics -->
        <div class="statistics">
            <h3>Statistik Ringkasan</h3>
            <table class="stats-table">
                <tr>
                    <td>Total Reservasi</td>
                    <td>{{ $reportData['statistics']['total_reservasi'] }}</td>
                </tr>
                <tr>
                    <td>Menunggu Konfirmasi</td>
                    <td>{{ $reportData['statistics']['menunggu_konfirmasi'] }}</td>
                </tr>
                <tr>
                    <td>Sudah Dikonfirmasi</td>
                    <td>{{ $reportData['statistics']['sudah_dikonfirmasi'] }}</td>
                </tr>
                <tr>
                    <td>Batal</td>
                    <td>{{ $reportData['statistics']['batal'] }}</td>
                </tr>
                <tr>
                    <td>Selesai</td>
                    <td>{{ $reportData['statistics']['selesai'] }}</td>
                </tr>
                <tr>
                    <td>Tingkat Pembatalan</td>
                    <td>{{ $reportData['statistics']['cancellation_rate'] }}</td>
                </tr>
            </table>
        </div>

        <!-- Detail Table -->
        @if (count($reportData['details']) > 0)
            <div class="statistics">
                <h3>Detail Reservasi</h3>
                <table class="detail-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 12%;">Tanggal Jadwal</th>
                            <th style="width: 18%;">Nama Pasien</th>
                            <th style="width: 18%;">Nama Dokter</th>
                            <th style="width: 30%;">Keluhan</th>
                            <th style="width: 17%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reportData['details'] as $item)
                            <tr>
                                <td>{{ $item['no'] }}</td>
                                <td>{{ $item['tanggal_jadwal'] }}</td>
                                <td>{{ $item['nama_pasien'] }}</td>
                                <td>{{ $item['nama_dokter'] }}</td>
                                <td>{{ Str::limit($item['keluhan'], 50) }}</td>
                                <td>
                                    <span class="status {{ 
                                        $item['status'] === 'Menunggu Konfirmasi' ? 'menunggu' : 
                                        ($item['status'] === 'Sudah Dikonfirmasi' ? 'dikonfirmasi' :
                                        ($item['status'] === 'Batal' ? 'batal' : 'selesai'))
                                    }}">
                                        {{ $item['status'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="statistics">
                <p style="text-align: center; color: #999; padding: 20px;">Tidak ada data reservasi untuk periode yang dipilih</p>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Laporan ini dihasilkan secara otomatis oleh sistem Manajemen Klinik</p>
            <p>&copy; 2026 Klinik. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>