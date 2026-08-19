<?php

namespace App\Http\Controllers;

use App\Models\Keperluan;
use Illuminate\Http\Request;

class KeperluanController extends Controller
{
    public function index(Request $request)
    {
        $keperluans = Keperluan::when($request->cari, function ($q) use ($request) {
                $q->where('keperluan', 'like', '%' . $request->cari . '%');
            })
            ->latest()
            ->paginate(10);

        return view('pengaturan.keperluan.index', compact('keperluans'));
    }

    public function create()
    {
        return view('pengaturan.keperluan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Keperluan::create($validated);

        return redirect()->route('keperluan.index')->with('success', 'Keperluan berhasil ditambahkan.');
    }

    public function edit(Keperluan $keperluan)
    {
        return view('pengaturan.keperluan.edit', compact('keperluan'));
    }

    public function update(Request $request, Keperluan $keperluan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $keperluan->update($validated);

        return redirect()->route('keperluan.index')->with('success', 'Keperluan berhasil diperbarui.');
    }

    public function destroy(Keperluan $keperluan)
    {
        $keperluan->delete();
        return redirect()->route('keperluan.index')->with('success', 'Keperluan berhasil dihapus.');
    }
}