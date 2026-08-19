<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reportTitle }}</title>
    @php $columnLabels = \App\Http\Controllers\LaporanController::pdfColumnLabels(); @endphp
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; margin: 0; padding: 0; }
        .page { width: 100%; margin: 0 auto; padding: 8px 10px; }
        .heading { text-align: center; margin-bottom: 8px; }
        .heading h1 { font-size: 16px; margin: 0; }
        .heading p { margin: 1px 0; font-size: 10px; }
        .info { margin: 8px 0; font-size: 9.5px; }
        .info .left, .info .right { display: inline-block; vertical-align: top; }
        .info .left { width: 55%; }
        .info .right { width: 43%; text-align: right; }
        table { width: 100%; border-collapse: collapse; font-size: 8px; }
        table thead th { border: 1px solid #333; padding: 3px 2px; background: #f5f5f5; }
        table tbody td { border: 1px solid #333; padding: 3px 2px; vertical-align: top; }
        .footer { margin-top: 10px; font-size: 9.5px; }
        .footer .signature { width: 220px; float: right; text-align: center; }
        .no-data { text-align: center; margin: 16px 0; font-size: 10px; }
    </style>
</head>
<body>
    <div class="page">
        <div class="heading">
            <h1>DATA LAYANAN</h1>
            <p>DINAS KEARSIPAN DAN PERPUSTAKAAN PROV. JATENG</p>
            <p>{{ $reportTitle }} - {{ $periodLabel }}</p>
        </div>

        @if ($table === 'all')
        <div class="info">
            <div class="left">
                <strong>Periode:</strong> {{ $periodLabel }}<br>
                <strong>Tanggal Cetak:</strong> {{ now()->format('d F Y') }}
            </div>
            <div class="right">
                <strong>Total Data:</strong> {{ $summary['totalKunjungan'] }}<br>
                <strong>Total Orang:</strong> {{ $summary['totalOrang'] }}<br>
                <strong>Laki-laki:</strong> {{ $summary['totalLakiLaki'] }}<br>
                <strong>Perempuan:</strong> {{ $summary['totalPerempuan'] }}
            </div>
        </div>
        @endif

        @if ($dataTamu->isEmpty())
            <div class="no-data">Tidak ada data pengunjung pada periode ini.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        @foreach ($columns as $column)
                            <th>{{ $columnLabels[$column] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataTamu as $index => $tamu)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            @foreach ($columns as $column)
                                <td>
                                    @if ($column === 'jumlah')
                                        {{ $tamu->anda_sendirian === 'Rombongan' ? ($tamu->jumlah_rombongan ?? '-') . ' Orang' : '1 Orang' }}
                                    @elseif ($column === 'tanggal')
                                        {{ $tamu->created?->format('d F Y') ?? '-' }}
                                    @elseif ($column === 'waktu')
                                        {{ $tamu->created?->format('H:i:s') ?? '-' }}
                                    @else
                                        {{ $tamu->{$column} ?? '-' }}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div class="footer">
            <div class="signature">
                <p>Semarang, {{ now()->format('d F Y') }}</p>
                <p>KETUA POKJA LAYANAN ARSIP</p>
                <br><br><br>
                <p style="text-decoration: underline;">IMAM SANYOTO, SE, MM</p>
                <p>NIP. 19731123 200604 1 003</p>
            </div>
        </div>
    </div>
</body>
</html>
