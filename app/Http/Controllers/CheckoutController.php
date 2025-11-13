<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Keranjang;

class CheckoutController extends Controller
{
    // Checkout 1 produk dari tombol "Beli Sekarang"
    public function checkoutSingle(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $qty = $request->qty ?? 1;

        $items = [[
            'id' => $product->id,
            'nama_produk' => $product->nama_produk,
            'harga' => $product->harga,
            'qty' => $qty,
            'subtotal' => $product->harga * $qty
        ]];

        session(['checkout_items' => $items]);

        return redirect()->route('checkout.index');
    }

    // Checkout dari keranjang (produk yang dicentang)
    public function checkoutCart(Request $request)
    {
        $ids = $request->input('selected_items', []);
        $cartItems = Keranjang::whereIn('id', $ids)->with('product')->get();

        $items = $cartItems->map(function($it) {
            return [
                'id' => $it->product->id,
                'nama_produk' => $it->product->nama_produk,
                'harga' => $it->harga_satuan,
                'qty' => $it->qty,
                'subtotal' => $it->harga_satuan * $it->qty,
            ];
        })->toArray();

        session(['checkout_items' => $items]);

        return redirect()->route('checkout.index');
    }

    // Halaman checkout
    public function index()
    {
        $items = session('checkout_items', []);
        if (empty($items)) {
            return redirect()->route('keranjang.index')->with('warning', 'Tidak ada item untuk checkout.');
        }

        $total = collect($items)->sum('subtotal');

        return view('checkout.index', compact('items', 'total'));
    }
}
