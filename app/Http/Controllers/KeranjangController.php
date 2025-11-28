<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // List keranjang user
    public function index()
    {
        $user = Auth::user();
        $items = Keranjang::with(['product', 'variant'])
                    ->where('user_id', $user->id)
                    ->get();

        $total = $items->sum(fn($i) => $i->qty * $i->harga_satuan);

        return view('keranjang.index', compact('items', 'total'));
    }

    // Tambah produk ke keranjang
    public function add(Request $request, $productId)
    {
        $user = Auth::user();
        $product = Product::findOrFail($productId);

        $request->validate([
            'qty'        => 'nullable|integer|min:1',
            'variant_id' => 'nullable',
            'size'       => 'nullable|string',
            'color'      => 'nullable|string',
        ]);

        $qty = $request->qty ?? 1;

        // Jika ada variant
        $variant = null;
        if ($request->variant_id) {
            $variant = ProductVariant::find($request->variant_id);
        }

        // Ambil harga
        $price = 0;

        if ($variant) {
            $price = $variant->harga; // pastikan kolom "harga" ada di variant
        } else {
            $price = $product->price ?? 0; // fallback, tidak boleh null
        }

        // Cek apakah item sudah ada di keranjang
        $existing = Keranjang::where('user_id', $user->id)
                            ->where('product_id', $product->id)
                            ->where('variant_id', $request->variant_id)
                            ->first();

        if ($existing) {

            // Jika sama-sama product + variant → update qty
            $existing->qty += $qty;
            $existing->save();

        } else {

            // Buat item baru
            Keranjang::create([
                'user_id'      => $user->id,
                'product_id'   => $product->id,
                'variant_id'   => $request->variant_id,
                'size'         => $request->size,
                'color'        => $request->color,
                'qty'          => $qty,
                'harga_satuan' => $price,
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // Update qty
    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $item = Keranjang::findOrFail($id);
        if ($item->user_id != Auth::id()) abort(403);

        $item->qty = $request->qty;
        $item->save();

        return redirect()->route('keranjang.index')->with('success', 'Keranjang diperbarui.');
    }

    // Hapus item
    public function remove($id)
    {
        $item = Keranjang::findOrFail($id);
        if ($item->user_id != Auth::id()) abort(403);

        $item->delete();

        return redirect()->route('keranjang.index')->with('success', 'Produk dihapus dari keranjang.');
    }

    // Kosongkan keranjang user
    public function clear()
    {
        Keranjang::where('user_id', Auth::id())->delete();

        return redirect()->route('keranjang.index')->with('success', 'Keranjang dikosongkan.');
    }
}
