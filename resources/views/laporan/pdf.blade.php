<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reportTitle }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; }
        .page { width: 100%; margin: 0 auto; }
        .heading { text-align: center; margin-bottom: 16px; }
        .heading h1 { font-size: 18px; margin: 0; }
        .heading p { margin: 4px 0 0; font-size: 12px; }
        .info { margin: 16px 0; font-size: 12px; }
        .info .group { display: inline-block; width: 50%; vertical-align: top; }
        table { width: 100%; border-collapse: collapse; font-size: 11px; }
        table thead th { border: 1px solid #333; padding: 8px 6px; background: #f5f5f5; }
        table tbody td { border: 1px solid #333; padding: 8px 6px; }
        .summary { margin-top: 20px; font-size: 11px; }
        .summary .box { display: inline-block; width: 24%; padding: 10px; border: 1px solid #333; background: #f9f9f9; box-sizing: border-box; }
        .footer { margin-top: 28px; font-size: 11px; }
        .footer .signature { width: 250px; float: right; text-align: center; }
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
            <div class="group">
                <strong>Judul:</strong> {{ $reportTitle }}<br>
                <strong>Periode:</strong> {{ $periodLabel }}<br>
                <strong>Tanggal Cetak:</strong> {{ now()->format('d F Y') }}
            </div>
            <div class="group" style="text-align: right;">
                <strong>Ringkasan:</strong><br>
                Total kunjungan: {{ $summary['totalKunjungan'] }}<br>
                Total orang: {{ $summary['totalOrang'] }}<br>
                Laki-laki: {{ $summary['totalLakiLaki'] }}<br>
                Perempuan: {{ $summary['totalPerempuan'] }}
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Instansi/Alamat</th>
                    <th>Keperluan</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Jenis Kelamin</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataTamu as $index => $tamu)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $tamu->nama }}</td>
                        <td>{{ $tamu->instansi_alamat }}</td>
                        <td>{{ $tamu->keperluan }}</td>
                        <td>{{ $tamu->anda_sendirian === 'Rombongan' ? ($tamu->jumlah_rombongan ?? '-') . ' Orang' : '1 Orang' }}</td>
                        <td>{{ $tamu->created_at->format('d M Y') }}</td>
                        <td>{{ $tamu->jenis_kelamin }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Tidak ada data pengunjung pada periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            <div class="signature">
                <p>Semarang, {{ now()->format('d F Y') }}</p>
                <p>KETUA POKJA LAYANAN ARSIP</p>
                <br><br><br>
                <p><span style="text-decoration: underline;">IMAM SANYOTO, SE, MM</span>
</div></p>
                <p>NIP. 19731123 200604 1 003</p>
            
        </div>
    </div>
</body>
</html>
