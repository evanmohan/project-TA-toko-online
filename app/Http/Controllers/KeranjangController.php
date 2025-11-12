<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Product;
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
        $items = Keranjang::with('product')->where('user_id', $user->id)->get();

        $total = $items->sum(fn($i) => $i->qty * $i->harga_satuan);

        return view('keranjang.index', compact('items', 'total'));
    }

    // Tambah produk ke keranjang (POST)
    public function add(Request $request, $productId)
    {
        $user = Auth::user();
        $product = Product::findOrFail($productId);

        $request->validate([
            'qty' => 'nullable|integer|min:1',
        ]);

        $qty = $request->qty ?? 1;

        // cek apakah sudah ada di keranjang user
        $cart = Keranjang::where('user_id', $user->id)->where('product_id', $product->id)->first();

        if ($cart) {
            // update qty
            $cart->qty = $cart->qty + $qty;
            // keep harga_satuan as snapshot (do not update)
            $cart->save();
        } else {
            Keranjang::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'qty' => $qty,
                'harga_satuan' => $product->harga,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // Update qty (POST)
    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $item = Keranjang::findOrFail($id);
        if ($item->user_id != Auth::id()) {
            abort(403);
        }

        $item->qty = $request->qty;
        $item->save();

        return redirect()->route('keranjang.index')->with('success', 'Keranjang diperbarui.');
    }

    // Hapus item (DELETE or GET)
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
