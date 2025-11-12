<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $cartItems = session('cart', []);
        $subtotal = collect($cartItems)->sum(fn($i) => $i['price'] * $i['quantity']);
        return view('checkout.checkout', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'ongkir' => 10000,
        ]);
    }

    public function store(Request $request)
    {
        // proses simpan order ke database
        return redirect()->route('home')->with('success', 'Pesanan kamu berhasil diproses!');
    }
}
