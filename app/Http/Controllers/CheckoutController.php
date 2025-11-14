<?php

namespace App\Http\Controllers;

use App\Models\Ekspedisi;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Keranjang;

class CheckoutController extends Controller
{
    // =============================
    // 1. CHECKOUT BELI SEKARANG
    // =============================
    public function checkoutSingle(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $qty = $request->qty ?? 1;

        $items = [[
            'product_id'     => $product->id,
            'nama_produk'    => $product->nama_produk,
            'qty'            => $qty,
            'harga_satuan'   => $product->harga,
            'subtotal'       => $product->harga * $qty,
            'image'          => $product->image,
        ]];

        session(['checkout_items' => $items]);

        return redirect()->route('checkout.page');
    }

    // =============================
    // 2. CHECKOUT DARI KERANJANG
    // =============================
    public function checkoutCart(Request $request)
    {
        $selected = json_decode($request->items, true);

        if (!is_array($selected) || count($selected) == 0) {
            return redirect()->route('keranjang.index')->with('error', 'Tidak ada produk yang dipilih.');
        }

        $ids = collect($selected)->pluck('id');

        $cart = Keranjang::whereIn('id', $ids)->with('product')->get();

        $items = $cart->map(function ($c) use ($selected) {
            $match = collect($selected)->firstWhere('id', $c->id);

            return [
                'product_id'     => $c->product_id,
                'nama_produk'    => $c->product->nama_produk,
                'qty'            => $match['qty'],
                'harga_satuan'   => $c->harga_satuan,
                'subtotal'       => $match['qty'] * $c->harga_satuan,
                'image'          => $c->product->image,
            ];
        })->toArray();

        session(['checkout_items' => $items]);

        return redirect()->route('checkout.page');
    }



    // =============================
    // 3. HALAMAN CHECKOUT
    // =============================
    public function page()
    {
        $checkout = session('checkout_items', []);

        if (empty($checkout)) {
            return redirect()->route('keranjang.index')->with('error', 'Tidak ada item untuk checkout.');
        }

        $items = collect($checkout);
        $ekspedisi = Ekspedisi::all();

        return view('checkout.checkout', [
            'items'        => $items,
            'total_barang' => $items->sum('qty'),
            'total_harga'  => $items->sum(fn($i) => $i['subtotal']),
            'ekspedisi'    => $ekspedisi,
        ]);
    }



    // =============================
    // 4. PROSES CHECKOUT (SAVE ORDER)
    // =============================
    public function store(Request $request)
    {
        $request->validate([
            'metode_pengiriman' => 'required|exists:ekspedisis,id',
            'metode_pembayaran' => 'required',
            'ongkir' => 'required|numeric'
        ]);

        $cart = collect(session('checkout_items', []));

        if ($cart->isEmpty()) {
            return redirect()->back()->with('error', 'Checkout gagal, tidak ada item.');
        }

        $exp = Ekspedisi::find($request->metode_pengiriman);

        $items = $cart->map(function ($i) {
            return [
                'product_id' => $i['product_id'],
                'qty'        => $i['qty'],
                'harga'      => $i['harga_satuan'],
                'subtotal'   => $i['subtotal'],
                'image'      => $i['image'], // tetap ikut agar tidak error
            ];
        });

        $total_barang = $items->sum('qty');
        $total_harga  = $items->sum('subtotal');
        $ongkir       = $request->ongkir;
        $total_bayar  = $total_harga + $ongkir;

        $order = Order::create([
            'user_id'           => auth()->id(),
            'nama'              => auth()->user()->username,
            'telepon'           => auth()->user()->no_hp,
            'alamat'            => auth()->user()->alamat,

            'total_barang'      => $total_barang,
            'total_harga'       => $total_harga,
            'ongkir'            => $ongkir,
            'total_bayar'       => $total_bayar,

            'metode_pengiriman' => $exp->nama,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['product_id'],
                'qty'        => $item['qty'],
                'harga'      => $item['harga'],
                'subtotal'   => $item['subtotal'],
            ]);
        }

        session()->forget('checkout_items');

        return redirect()->route('home')->with('success', 'Pesanan berhasil dibuat!');
    }



    // =============================
    // 5. BUY NOW (ALTERNATIF)
    // =============================
    public function buyNow(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $qty = $request->qty ?? 1;

        session([
            'checkout_items' => [
                [
                    'product_id'     => $product->id,
                    'nama_produk'    => $product->nama_produk,
                    'qty'            => $qty,
                    'harga_satuan'   => $product->harga,
                    'subtotal'       => $qty * $product->harga,
                    'image'          => $product->image,
                ]
            ]
        ]);

        return redirect()->route('checkout.page');
    }


    // =============================
    // 6. CHECKOUT DARI KERANJANG (ALTERNATIF)
    // =============================
    public function fromCart(Request $request)
    {
        $selected = json_decode($request->selected_items, true);

        if (!$selected || count($selected) == 0) {
            return back()->with('error', 'Tidak ada produk yang dipilih.');
        }

        $items = [];
        $total = 0;

        foreach ($selected as $cartItem) {

            $cart = Keranjang::where('id', $cartItem['id'])
                ->where('user_id', auth()->id())
                ->first();

            if (!$cart) continue;

            $product = $cart->product;

            $items[] = [
                'product_id'    => $product->id,
                'nama_produk'   => $product->nama_produk,
                'qty'           => $cartItem['qty'],
                'harga_satuan'  => $cart->harga_satuan,
                'subtotal'      => $cartItem['qty'] * $cart->harga_satuan,
                'image'         => $product->image,
            ];

            $total += $cartItem['qty'] * $cart->harga_satuan;
        }

        session()->put('checkout_items', $items);
        session()->put('checkout_total', $total);

        return redirect()->route('checkout.page');
    }


    // =============================
    // 7. VIEW CHECKOUT
    // =============================
    public function view()
    {
        $items = session('checkout_items');
        $total = session('checkout_total');

        if (!$items) {
            return redirect()->route('keranjang.index')->with('error', 'Tidak ada item untuk checkout');
        }

        return view('checkout.index', [
            'items'       => $items,
            'total_harga' => $total,
            'user'        => auth()->user()
        ]);
    }
}
