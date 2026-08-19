<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use Illuminate\Http\Request;

class PengunjungController extends Controller
{
    public function index(Request $request)
    {
        $query = BukuTamu::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                                $q->where('nama_pengunjung', 'like', "%{$search}%")
                                    ->orWhere('alamat_pengunjung', 'like', "%{$search}%")
                                    ->orWhere('keperluan_pengunjung', 'like', "%{$search}%")
                                    ->orWhere('nomortelepon', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $dataTamu = $query->paginate($perPage)->withQueryString();

        return view('pengunjung.index', compact('dataTamu'));
    }

    public function edit(BukuTamu $bukuTamu)
    {
        return view('pengunjung.edit', compact('bukuTamu'));
    }

    public function update(Request $request, BukuTamu $bukuTamu)
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

        $bukuTamu->update($validated);

        return redirect()->route('pengunjung.index')->with('success', 'Data pengunjung berhasil diperbarui.');
    }

    public function destroy(BukuTamu $bukuTamu)
    {
        $bukuTamu->delete();

        return redirect()->route('pengunjung.index')->with('success', 'Data pengunjung berhasil dihapus.');
    }
}