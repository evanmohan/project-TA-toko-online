<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        $kategoris = Kategori::latest()->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    // Menampilkan form tambah kategori
    public function create()
    {
        return view('admin.kategori.index');
    }

    // Menyimpan data kategori
    public function store(Request $request)
    {
        $request->validate([
            // 'kode_kategori' => 'required|unique:kategoris,kode_kategori',
            'nama_kategori' => 'required',
            'deskripsi' => 'nullable',
        ]);

        Kategori::create($request->all());

        return redirect('/admin/kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.index', compact('kategoris'));
    }


    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            // 'kode_kategori' => 'required|unique:kategoris,kode_kategori,' . $kategori->id,
            'nama_kategori' => 'required',
        ]);

        $kategori->update([
            // 'kode_kategori' => $request->kode_kategori,
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('kategori')->with('success', 'Kategori berhasil diperbarui!');
    }

    // Hapus kategori
    public function destroy($id)
    {
        Kategori::findOrFail($id)->delete();
        return redirect()->route('kategori')->with('success', 'Kategori berhasil dihapus!');
    }
}
