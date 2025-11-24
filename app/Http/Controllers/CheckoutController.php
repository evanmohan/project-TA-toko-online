<?php

namespace App\Http\Controllers;

use App\Models\Ekspedisi;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Keranjang;
use App\Models\PaymentMethod;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // =============================
    // 1. GENERATE KODE ORDER
    // =============================
    private function generateKodeOrder()
    {
        return 'ORD-' . strtoupper(uniqid());
    }

    // =============================
    // 2. CHECKOUT BELI SEKARANG
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
    // 3. CHECKOUT DARI KERANJANG
    // =============================
    public function checkoutCart(Request $request)
    {
        $selected = json_decode($request->items, true);

        if (!is_array($selected) || count($selected) == 0) {
            return redirect()->route('keranjang.index')->with('error', 'Tidak ada produk yang dipilih.');
        }

        $ids = collect($selected)->pluck('id');

        $cartItems = Keranjang::whereIn('id', $ids)->with('product')->get();

        $items = [];

        foreach ($cartItems as $cart) {
            $match = collect($selected)->firstWhere('id', $cart->id);

            $qty = $match['qty'];

            $items[] = [
                'product_id'     => $cart->product_id,
                'nama_produk'    => $cart->product->nama_produk,
                'qty'            => $qty,
                'harga_satuan'   => $cart->harga_satuan,
                'subtotal'       => $qty * $cart->harga_satuan,
                'image'          => $cart->product->image,
            ];
        }

        session(['checkout_items' => $items]);

        return redirect()->route('checkout.page');
    }

    // =============================
    // 4. HALAMAN CHECKOUT
    // =============================
    public function page()
    {
        $checkout = session('checkout_items', []);

        if (empty($checkout)) {
            return redirect()->route('keranjang.index')->with('error', 'Tidak ada item untuk checkout.');
        }

        $items = collect($checkout);
        $ekspedisi = Ekspedisi::all();
        $paymentMethods = PaymentMethod::where('aktif', 1)->get();

        return view('checkout.checkout', [
            'items'        => $items,
            'total_barang' => $items->sum('qty'),
            'total_harga'  => $items->sum(fn($i) => $i['subtotal']),
            'ekspedisi'    => $ekspedisi,
            'paymentMethods' => $paymentMethods
        ]);
    }

    // =============================
    // 5. PROSES CHECKOUT (SAVE ORDER)
    // =============================
    public function store(Request $request)
    {
        $request->validate([
            'metode_pengiriman' => 'required|exists:ekspedisi,id',
            'metode_pembayaran' => 'required|exists:payment_methods,id',
            'ongkir' => 'required|numeric'
        ]);

        $cart = collect(session('checkout_items', []));

        if ($cart->isEmpty()) {
            return redirect()->back()->with('error', 'Checkout gagal, tidak ada item.');
        }

        $exp = Ekspedisi::findOrFail($request->metode_pengiriman);
        $paymentMethod = PaymentMethod::findOrFail($request->metode_pembayaran);

        $items = $cart->map(function ($i) {
            return [
                'product_id' => $i['product_id'],
                'qty'        => $i['qty'],
                'harga'      => $i['harga_satuan'],
                'subtotal'   => $i['subtotal'],
                'image'      => $i['image'],
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
            'metode_pembayaran' => $paymentMethod->nama_metode,
            'kode_order'        => $this->generateKodeOrder(),
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

        // =========================
        // HAPUS ITEM KERANJANG YANG DI-CHECKOUT
        // =========================
        Keranjang::where('user_id', auth()->id())
            ->whereIn('product_id', $items->pluck('product_id'))
            ->delete();

        // =========================
        // HANDLE METODE PEMBAYARAN
        // =========================
        session()->forget('checkout_items');

        if ($paymentMethod->tipe === 'BANK') {
            return redirect()->route('payment.bayar', $order->id);
        }

        if ($paymentMethod->tipe === 'cod') {
            $order->status_pembayaran = 'COD';
            $order->save();
            return redirect()->route('payment.index')->with('success', 'Pesanan COD berhasil dibuat!');
        }

        return redirect()->route('payment.index')->with('success', 'Pesanan berhasil dibuat!');
    }

    // =============================
    // 6. BUY NOW (ALTERNATIF)
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
    // 7. CHECKOUT DARI KERANJANG (ALTERNATIF)
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
    // 8. VIEW CHECKOUT
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

