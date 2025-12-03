<?php

namespace App\Http\Controllers;

use App\Models\Favorit;
use Illuminate\Http\Request;

class FavoritController extends Controller
{
    /**
     * Tambah ke favorit berdasarkan variant & size
     */
    public function store(Request $request)
    {
        $data = [
            'user_id' => auth()->id(),
            'produk_id' => $request->produk_id,
            'variant_id' => $request->variant_id,
            'size_id' => $request->size_id,
        ];

        Favorit::firstOrCreate($data);

        return response()->json([
            'success' => true,
            'message' => 'Produk ditambahkan ke favorit'
        ]);
    }


    /**
     * Hapus favorit berdasarkan produk + variant + size
     */
    public function destroy(Request $request)
    {
        Favorit::where('user_id', auth()->id())
            ->where('produk_id', $request->produk_id)
            ->where('variant_id', $request->variant_id)
            ->where('size_id', $request->size_id)
            ->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk dihapus dari favorit'
            ]);
        }

        return back()->with('success', 'Produk dihapus dari favorit!');
    }



    /**
     * List semua favorit user
     */
    public function index()
    {
        $favorits = Favorit::with(['produk', 'variant', 'size'])
            ->where('user_id', auth()->id())
            ->get();

        return view('favorit.index', compact('favorits'));
    }
}
