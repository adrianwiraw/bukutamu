<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reportTitle }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; margin: 0; padding: 0; }
        .page { width: 100%; margin: 0 auto; padding: 8px 10px; }
        .heading { text-align: center; margin-bottom: 8px; }
        .heading h1 { font-size: 16px; margin: 0; }
        .heading p { margin: 1px 0; font-size: 10px; }
        .info { margin-bottom: 8px; font-size: 9.5px; }
        .info .left, .info .right { display: inline-block; vertical-align: top; }
        .info .left { width: 55%; }
        .info .right { width: 43%; text-align: right; }
        table { width: 100%; border-collapse: collapse; font-size: 7px; table-layout: fixed; }
        table thead th, table tbody td { border: 1px solid #333; padding: 3px 2px; }
        table thead th { background: #f5f5f5; }
        .number-cell { text-align: center; }
        .activity-cell { line-height: 1.2; overflow-wrap: break-word; }
        .footer { margin-top: 10px; font-size: 9.5px; }
        .footer .signature { width: 220px; float: right; text-align: center; }
        .bottom-summary { display: table; width: 100%; table-layout: fixed; margin-top: 10px; font-size: 9px; }
        .bottom-summary .box { display: table-cell; width: 25%; padding: 6px; border: 1px solid #333; background: #f6f6f6; }
    </style>
</head>
<body>
    <div class="page">
        <div class="heading">
            <h1>DATA LAYANAN ARSIP</h1>
            <p>DINAS KEARSIPAN DAN PERPUSTAKAAN <br> PROVINSI JATENG</p>
            <p>{{ $reportTitle }} - {{ $periodLabel }}</p>
        </div>

        <div class="info">
            <div class="left">
                <strong>Periode:</strong> {{ $periodLabel }}<br>
                <strong>Tanggal Cetak:</strong> {{ now()->format('d F Y') }}
            </div>
            <div class="right">
                <strong>Total Kunjungan:</strong> {{ $summary['totalKunjungan'] }}<br>
                <strong>Total Orang:</strong> {{ $summary['totalOrang'] }}<br>
                <strong>Laki-laki:</strong> {{ $summary['totalLakiLaki'] }}<br>
                <strong>Perempuan:</strong> {{ $summary['totalPerempuan'] }}
            </div>
        </div>

        <table>
            <colgroup>
                <col style="width: 3%;">
                <col style="width: 24%;">
                @for ($column = 1; $column <= 24; $column++)
                    <col style="width: 2.7%;">
                @endfor
                <col style="width: 4%;">
                <col style="width: 4%;">
            </colgroup>
            <thead>
                <tr>
                    <th rowspan="3">No</th>
                    <th rowspan="3">Kegiatan</th>
                    <th colspan="24">Bulan</th>
                    <th colspan="2">Jumlah</th>
                </tr>
                <tr>
                    @foreach (['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'] as $month)
                        <th colspan="2">{{ $month }}</th>
                    @endforeach
                </tr>
                <tr>
                    @foreach (range(1, 12) as $month)
                        <th>KL</th>
                        <th>Org</th>
                    @endforeach
                    <th>KL</th>
                    <th>Org</th>
                </tr>
            </thead>
            <tbody>
                @php $row = 1; @endphp
                @foreach ($summaryTable['summary'] as $category => $months)
                    <tr>
                        <td>{{ $row++ }}</td>
                        <td class="activity-cell">{{ $category }}</td>
                        @php $rowTotalKl = 0; $rowTotalOrg = 0; @endphp
                        @foreach ($months as $month => $values)
                            @php $rowTotalKl += $values['kl']; $rowTotalOrg += $values['org']; @endphp
                            <td class="number-cell">{{ $values['kl'] }}</td>
                            <td class="number-cell">{{ $values['org'] }}</td>
                        @endforeach
                        <td class="number-cell">{{ $rowTotalKl }}</td>
                        <td class="number-cell">{{ $rowTotalOrg }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2"><strong>Jumlah Total</strong></td>
                    @foreach ($summaryTable['totals'] as $month => $values)
                        <td class="number-cell"><strong>{{ $values['kl'] }}</strong></td>
                        <td class="number-cell"><strong>{{ $values['org'] }}</strong></td>
                    @endforeach
                    @php
                        $totalKl = collect($summaryTable['totals'])->sum(fn($value) => $value['kl']);
                        $totalOrg = collect($summaryTable['totals'])->sum(fn($value) => $value['org']);
                    @endphp
                    <td><strong>{{ $totalKl }}</strong></td>
                    <td><strong>{{ $totalOrg }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="bottom-summary">
            <div class="box"><strong>Total Kunjungan</strong><br>{{ $summary['totalKunjungan'] }} Kali</div>
            <div class="box"><strong>Total Orang</strong><br>{{ $summary['totalOrang'] }} Orang</div>
            <div class="box"><strong>Laki-Laki</strong><br>{{ $summary['totalLakiLaki'] }} Orang</div>
            <div class="box"><strong>Perempuan</strong><br>{{ $summary['totalPerempuan'] }} Orang</div>
        </div>

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
