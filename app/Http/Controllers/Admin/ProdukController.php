<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $products = Product::with('kategori')->latest()->get();
        $kategoris = Kategori::all();

        return view('admin.produk.index', compact('products', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'size' => 'nullable|string|max:20',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('produk', 'public') : null;

        Product::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'size' => $request->size,
            'satuan' => 'pcs',
            'harga' => $request->harga,
            'stok' => $request->stok,
            'sisa_stok' => $request->sisa_stok ?? $request->stok,
            'image' => $imagePath,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, string $id)
    {
        $produk = Product::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'size' => 'nullable|string|max:20',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($produk->image) {
                Storage::disk('public')->delete($produk->image);
            }
            $produk->image = $request->file('image')->store('produk', 'public');
        }

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'size' => $request->size,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'sisa_stok' => $request->sisa_stok ?? $request->stok,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $produk = Product::findOrFail($id);

        if ($produk->image) {
            Storage::disk('public')->delete($produk->image);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
