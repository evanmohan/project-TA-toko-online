<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ekspedisi;

class EkspedisiController extends Controller
{
    /**
     * Tampilkan daftar ekspedisi
     */
    public function index()
    {
        $ekspedisis = Ekspedisi::orderBy('id', 'desc')->get();
        return view('admin.ekspedisi.index', compact('ekspedisis'));
    }

    /**
     * Simpan data ekspedisi baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        // Simpan data awal (tanpa kode_ekspedisi dulu)
        $ekspedisi = Ekspedisi::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        // Update kode ekspedisi berdasarkan ID
        $ekspedisi->kode_ekspedisi = 'EXP' . str_pad($ekspedisi->id, 3, '0', STR_PAD_LEFT);
        $ekspedisi->saveQuietly();

        return redirect()->back()->with('success', 'Ekspedisi berhasil ditambahkan.');
    }

    /**
     * Update data ekspedisi
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $ekspedisi = Ekspedisi::findOrFail($id);
        $ekspedisi->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Data ekspedisi berhasil diperbarui.');
    }

    /**
     * Hapus data ekspedisi
     */
    public function destroy($id)
    {
        $ekspedisi = Ekspedisi::findOrFail($id);
        $ekspedisi->delete();

        return redirect()->back()->with('success', 'Ekspedisi berhasil dihapus.');
    }
}
