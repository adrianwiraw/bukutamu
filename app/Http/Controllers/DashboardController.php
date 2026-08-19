<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $tahunSekarang = now()->year;
        $bulanSekarang = now()->month;

        $tahunTersedia = BukuTamu::pluck('created')
            ->map(fn ($tanggal) => Carbon::parse($tanggal)->year)
            ->unique()
            ->sortDesc()
            ->values();

        if ($tahunTersedia->isEmpty()) {
            $tahunTersedia = collect([$tahunSekarang]);
        }

        $feedbacks = Feedback::with('bukuTamu')->latest()->take(3)->get();

        return view('dashboard', [
            'tahunTersedia' => $tahunTersedia,
            'tahunSekarang' => $tahunSekarang,
            'bulanSekarang' => $bulanSekarang,
            'feedbacks' => $feedbacks,
        ]);
    }

    public function feedbackIndex()
    {
        $feedbacks = Feedback::with('bukuTamu')->latest()->get();

        return view('feedback.index', [
            'feedbacks' => $feedbacks,
        ]);
    }

    public function updateFeedback(Request $request, Feedback $feedback)
    {
        $validated = $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
            'status' => 'nullable|in:baru,selesai,diproses',
        ]);

        $feedback->update($validated);

        return redirect()->route('dashboard')->with('success', 'Feedback berhasil diperbarui.');
    }

    public function destroyFeedback(Feedback $feedback)
    {
        $feedback->delete();

        return redirect()->route('dashboard')->with('success', 'Feedback berhasil dihapus.');
    }

    // Grafik: jumlah pengunjung per bulan dalam 1 tahun
    public function chartBulan(Request $request)
    {
        $tahun = (int) $request->input('tahun', now()->year);

        $namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $data = array_fill(0, 12, 0);

        BukuTamu::whereYear('created', $tahun)
            ->get(['created'])
            ->each(function ($item) use (&$data) {
                $bulan = Carbon::parse($item->created)->month;
                $data[$bulan - 1]++;
            });

        return response()->json([
            'labels' => $namaBulan,
            'data' => $data,
        ]);
    }

    // Grafik: jumlah pengunjung per tanggal dalam 1 bulan
    public function chartTanggal(Request $request)
    {
        $tahun = (int) $request->input('tahun', now()->year);
        $bulan = (int) $request->input('bulan', now()->month);

        $jumlahHari = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;
        $data = array_fill(0, $jumlahHari, 0);
        $labels = range(1, $jumlahHari);

        BukuTamu::whereYear('created', $tahun)
            ->whereMonth('created', $bulan)
            ->get(['created'])
            ->each(function ($item) use (&$data) {
                $tanggal = Carbon::parse($item->created)->day;
                $data[$tanggal - 1]++;
            });

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    // Grafik: jumlah pengunjung per keperluan
    public function chartKeperluan(Request $request)
    {
        $tahun = (int) $request->input('tahun', now()->year);
        $bulan = $request->input('bulan');

        $query = BukuTamu::whereYear('created', $tahun);

        if ($bulan) {
            $query->whereMonth('created', (int) $bulan);
        }

        $hasil = $query->get(['keperluan_pengunjung'])
            ->groupBy('keperluan_pengunjung')
            ->map(fn ($grup) => $grup->count());

        return response()->json([
            'labels' => $hasil->keys(),
            'data' => $hasil->values(),
        ]);
    }
}