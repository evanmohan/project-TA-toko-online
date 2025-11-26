<?php

namespace App\Http\Controllers;

use App\Models\Favorit;
use Illuminate\Http\Request;

class FavoritController extends Controller
{
    // Tambah ke favorit
    public function store($produk_id)
    {
        Favorit::firstOrCreate([
            'user_id' => auth()->id(),
            'produk_id' => $produk_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk ditambahkan ke favorit'
        ]);
    }

    // Hapus dari favorit
    public function destroy($produk_id)
    {
        Favorit::where('user_id', auth()->id())
            ->where('produk_id', $produk_id)
            ->delete();

        // Jika request AJAX → balikan JSON
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk dihapus dari favorit'
            ]);
        }

        // Jika bukan AJAX → redirect back
        return back()->with('success', 'Produk dihapus dari favorit!');
    }


    // List favorit user
    public function index()
    {
        $favorits = Favorit::with('produk')
            ->where('user_id', auth()->id())
            ->get();

        return view('favorit.index', compact('favorits'));
    }
}
