<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BukuTamu;
use App\Models\Feedback;
use App\Models\Keperluan;

class BukuTamuController extends Controller
{
    public function create()
    {
        $keperluans = Keperluan::orderBy('nama')->get();
    return view('bukutamu.welcome.create', compact('keperluans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'identitas' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'instansi_alamat' => 'required|string|max:255',
            'keperluan' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'pegawai_temui' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'anda_sendirian' => 'required|in:Hanya saya,Rombongan',
            'jumlah_rombongan' => 'nullable|integer|min:2|required_if:anda_sendirian,Rombongan',
            'usia' => 'required|integer|min:1',
        ]);

        $bukuTamu = BukuTamu::create($validated);

        $feedbackRating = $request->input('feedback_rating');
        $feedbackMessage = $request->input('feedback_message');

        if ($feedbackRating || $feedbackMessage) {
            Feedback::create([
                'buku_tamu_id' => $bukuTamu->id,
                'rating' => $feedbackRating ? (int) $feedbackRating : null,
                'feedback' => $feedbackMessage,
                'status' => 'baru',
            ]);
        }

        return redirect()->route('bukutamu.create')
            ->with('success', 'Terima kasih, data berhasil disimpan!')
            ->with('showFeedbackModal', true)
            ->with('latest_buku_tamu_id', $bukuTamu->id);
    }

    public function storeFeedback(Request $request)
    {
        $bukuTamuId = $request->input('latest_buku_tamu_id') ?? $request->session()->get('latest_buku_tamu_id');

        if (! $bukuTamuId) {
            return redirect()->route('bukutamu.create')->with('feedback_error', 'Sesi feedback tidak tersedia.');
        }

        $validated = $request->validate([
            'feedback_rating' => 'nullable|integer|min:1|max:5',
            'feedback_message' => 'nullable|string|max:1000',
        ]);

        $feedbackRating = $validated['feedback_rating'] ?? null;
        $feedbackMessage = $validated['feedback_message'] ?? null;

        if ($feedbackRating || $feedbackMessage) {
            Feedback::create([
                'buku_tamu_id' => $bukuTamuId,
                'rating' => $feedbackRating ? (int) $feedbackRating : null,
                'feedback' => $feedbackMessage,
                'status' => 'baru',
            ]);
        }

        return redirect()->route('bukutamu.create')
            ->with('feedback_success', 'Terima kasih atas feedback Anda.');
    }
}