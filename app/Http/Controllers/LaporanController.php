<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{
    private const PDF_COLUMNS = [
        'nama' => 'Nama',
        'jenis_kelamin' => 'Jenis Kelamin',
        'identitas' => 'Identitas',
        'instansi_alamat' => 'Instansi/Alamat',
        'keperluan' => 'Keperluan',
        'pegawai_temui' => 'Pegawai yang Ditemui',
        'jumlah' => 'Jumlah',
        'usia' => 'Usia',
        'tanggal' => 'Tanggal',
        'waktu' => 'Waktu',
    ];

    public function harian(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->format('Y-m-d'));

        $dataTamu = BukuTamu::whereDate('created', $tanggal)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('laporan.harian', compact('dataTamu', 'tanggal'));
    }

    public function bulanan(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $bulan = $request->input('bulan', now()->month);

        $dataTamu = BukuTamu::whereYear('created', $tahun)
            ->whereMonth('created', $bulan)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $tahunTersedia = $this->tahunTersedia();

        return view('laporan.bulanan', compact('dataTamu', 'tahun', 'bulan', 'tahunTersedia'));
    }

    public function tahunan(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);

        $dataTamu = BukuTamu::whereYear('created', $tahun)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $tahunTersedia = $this->tahunTersedia();

        return view('laporan.tahunan', compact('dataTamu', 'tahun', 'tahunTersedia'));
    }

    public function custom(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $dataTamu = BukuTamu::whereYear('created', $tahun)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $tahunTersedia = $this->tahunTersedia();

        return view('laporan.custom', compact('dataTamu', 'tahun', 'tahunTersedia'));
    }

    public function harianPdf(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->format('Y-m-d'));
        $table = $request->string('table', 'all')->toString();
        abort_unless(in_array($table, ['all', 'detail'], true), 404);
        $columns = $this->selectedPdfColumns($request);
        $dataTamu = BukuTamu::whereDate('created', $tanggal)
            ->latest()
            ->get();

        return $this->generatePdf('laporan.pdf-detail', [
            'dataTamu' => $dataTamu,
            'reportTitle' => 'Laporan Harian',
            'periodLabel' => Carbon::parse($tanggal)->format('d F Y'),
            'summary' => $this->pdfSummary($dataTamu),
            'table' => $table,
            'columns' => $columns,
        ], "laporan-harian-{$tanggal}.pdf", 'portrait');
    }

    public function bulananPdf(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $bulan = $request->input('bulan', now()->month);
        $table = $request->string('table', 'all')->toString();
        abort_unless(in_array($table, ['all', 'detail'], true), 404);
        $columns = $this->selectedPdfColumns($request);
        $dataTamu = BukuTamu::whereYear('created', $tahun)
            ->whereMonth('created', $bulan)
            ->latest()
            ->get();

        return $this->generatePdf('laporan.pdf-detail', [
            'dataTamu' => $dataTamu,
            'reportTitle' => 'Laporan Bulan',
            'periodLabel' => Carbon::createFromDate($tahun, $bulan, 1)->format('F Y'),
            'summary' => $this->pdfSummary($dataTamu),
            'table' => $table,
            'columns' => $columns,
        ], "laporan-bulanan-{$tahun}-{$bulan}.pdf", 'portrait');
    }

    public function tahunanPdf(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $table = $request->string('table', 'all')->toString();
        abort_unless(in_array($table, ['all', 'detail'], true), 404);
        $columns = $this->selectedPdfColumns($request);
        $dataTamu = BukuTamu::whereYear('created', $tahun)
            ->latest()
            ->get();

        return $this->generatePdf('laporan.pdf-detail', [
            'dataTamu' => $dataTamu,
            'reportTitle' => 'Laporan Tahun',
            'periodLabel' => $tahun,
            'summary' => $this->pdfSummary($dataTamu),
            'table' => $table,
            'columns' => $columns,
        ], "laporan-tahunan-{$tahun}.pdf", 'portrait');
    }

    public function customPdf(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $dataTamu = BukuTamu::whereYear('created', $tahun)
            ->latest()
            ->get();

        return $this->generatePdf('laporan.pdf-summary', [
            'dataTamu' => $dataTamu,
            'reportTitle' => 'Laporan Tahun',
            'periodLabel' => $tahun,
            'summary' => $this->pdfSummary($dataTamu),
            'summaryTable' => $this->prepareCustomSummary($dataTamu),
        ], "laporan-custom-{$tahun}.pdf", 'landscape');
    }

    private function pdfSummary($dataTamu)
    {
        $totalOrang = 0;
        foreach ($dataTamu as $tamu) {
            $totalOrang += $tamu->anda_sendirian === 'Rombongan' ? ($tamu->jumlah_rombongan ?? 0) : 1;
        }

        return [
            'totalKunjungan' => $dataTamu->count(),
            'totalOrang' => $totalOrang,
            'totalLakiLaki' => $dataTamu->where('jenis_kelamin', 'Laki-laki')->count(),
            'totalPerempuan' => $dataTamu->where('jenis_kelamin', 'Perempuan')->count(),
        ];
    }

    private function prepareCustomSummary($dataTamu)
    {
        $categories = [
            'Penelitian atau Mencari Arsip' => ['Penelitian atau Mencari Arsip'],
            'Kunjungan atau Wisata Arsip' => ['Kunjungan atau Wisata Arsip'],
            'Magang atau PKL' => ['Magang atau PKL'],
            'Konsultasi Kearsipan atau Perpustakaan' => ['Konsultasi Kearsipan atau Perpustakaan'],
            'Umum atau Lain - Lain' => ['Umum atau Lain - Lain'],
        ];

        $summary = [];
        foreach ($categories as $label => $values) {
            for ($month = 1; $month <= 12; $month++) {
                $summary[$label][$month] = ['kl' => 0, 'org' => 0];
            }
        }

        foreach ($dataTamu as $tamu) {
            $month = $tamu->created->month;
            $count = $tamu->anda_sendirian === 'Rombongan' ? ($tamu->jumlah_rombongan ?? 0) : 1;
            $categoryKey = 'Umum atau Lain - Lain';

            foreach ($categories as $label => $values) {
                if (in_array($tamu->keperluan, $values, true)) {
                    $categoryKey = $label;
                    break;
                }
            }

            $summary[$categoryKey][$month]['kl'] += 1;
            $summary[$categoryKey][$month]['org'] += $count;
        }

        $totals = [];
        for ($month = 1; $month <= 12; $month++) {
            $totals[$month] = ['kl' => 0, 'org' => 0];
            foreach ($summary as $categoryData) {
                $totals[$month]['kl'] += $categoryData[$month]['kl'];
                $totals[$month]['org'] += $categoryData[$month]['org'];
            }
        }

        return ['categories' => $categories, 'summary' => $summary, 'totals' => $totals];
    }

    private function generatePdf(string $view, array $data, string $filename, string $orientation = 'portrait')
    {
        ini_set('memory_limit', env('PDF_MEMORY_LIMIT', '512M'));

        $pdf = Pdf::loadView($view, $data)->setPaper('a4', $orientation);

        return $pdf->stream($filename);
    }

    private function selectedPdfColumns(Request $request): array
    {
        $selected = $request->input('columns');

        if (! is_array($selected)) {
            return array_keys(self::PDF_COLUMNS);
        }

        $selected = array_values(array_intersect($selected, array_keys(self::PDF_COLUMNS)));

        return $selected ?: array_keys(self::PDF_COLUMNS);
    }

    public function harianExcel(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->format('Y-m-d'));
        $dataTamu = BukuTamu::whereDate('created', $tanggal)->latest()->get();

        return $this->generateExcel('Laporan Harian', Carbon::parse($tanggal)->format('d F Y'), $dataTamu, "laporan-harian-{$tanggal}");
    }

    public function bulananExcel(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $bulan = $request->input('bulan', now()->month);
        $dataTamu = BukuTamu::whereYear('created', $tahun)
            ->whereMonth('created', $bulan)
            ->latest()
            ->get();

        $periodLabel = Carbon::createFromDate($tahun, $bulan, 1)->format('F Y');
        return $this->generateExcel('Laporan Bulan', $periodLabel, $dataTamu, "laporan-bulanan-{$tahun}-{$bulan}");
    }

    public function tahunanExcel(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $dataTamu = BukuTamu::whereYear('created', $tahun)->latest()->get();

        return $this->generateExcel('Laporan Tahun', $tahun, $dataTamu, "laporan-tahunan-{$tahun}");
    }

    public function customExcel(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $dataTamu = BukuTamu::whereYear('created', $tahun)->latest()->get();

        return $this->generateExcel('Laporan Tahun', $tahun, $dataTamu, "laporan-custom-{$tahun}");
    }

    private function generateExcel(string $title, $period, $dataTamu, string $filename)
    {
        $csvContent = "DATA LAYANAN ARSIP\n";
        $csvContent .= "DINAS KEARSIPAN DAN PERPUSTAKAAN PROVINSI JATENG\n";
        $csvContent .= "$title - $period\n";
        $csvContent .= "\n";
        $csvContent .= "Tanggal Cetak," . now()->format('d F Y') . "\n";
        $csvContent .= "\n";

        // Header kolom
        $headers = ['No', 'Nama', 'Jenis Kelamin', 'Identitas', 'Instansi/Alamat', 'Keperluan', 'Pegawai yang Ditemui', 'Jumlah', 'Usia', 'Tanggal', 'Waktu'];
        $csvContent .= implode(',', $this->escapeCsv($headers)) . "\n";

        // Data
        foreach ($dataTamu as $index => $tamu) {
            $row = [
                $index + 1,
                $tamu->nama_pengunjung ?? $tamu->nama ?? '-',
                $tamu->jenis_kelamin ?? '-',
                $tamu->identitas ?? '-',
                $tamu->alamat_pengunjung ?? $tamu->instansi_alamat ?? '-',
                $tamu->keperluan_pengunjung ?? $tamu->keperluan ?? '-',
                $tamu->pejabat ?? $tamu->pegawai_temui ?? '-',
                ($tamu->anda_sendirian === 'Rombongan' ? ($tamu->jumlah ?? '-') . ' Orang' : '1 Orang'),
                $tamu->usia ?? '-',
                optional($tamu->created)->format('d F Y') ?? '-',
                optional($tamu->created)->format('H:i:s') ?? '-',
            ];

            $csvContent .= implode(',', $this->escapeCsv($row)) . "\n";
        }

        return response()->streamDownload(
            fn () => print($csvContent),
            $filename . '.csv',
            [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
            ]
        );
    }

    private function escapeCsv(array $row): array
    {
        return array_map(function ($cell) {
            $cell = (string) ($cell ?? '');

            // Escape double quotes and wrap in quotes if needed
            if (strpos($cell, ',') !== false || strpos($cell, '"') !== false || strpos($cell, "\n") !== false) {
                return '"' . str_replace('"', '""', $cell) . '"';
            }
            return $cell;
        }, $row);
    }

    public static function pdfColumnLabels(): array
    {
        return self::PDF_COLUMNS;
    }

    private function tahunTersedia()
    {
        $tahunTersedia = BukuTamu::pluck('created')
            ->map(fn ($tanggal) => Carbon::parse($tanggal)->year)
            ->unique()
            ->sortDesc()
            ->values();

        return $tahunTersedia->isEmpty() ? collect([now()->year]) : $tahunTersedia;
    }
}