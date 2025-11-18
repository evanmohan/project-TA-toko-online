<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class RiwayatPesananController extends Controller
{
    public function index()
    {
        // Ambil semua pesanan user + relasi lengkap
        $pesanan = Pesanan::with([
            'detailPesanan.produk',
            'pengiriman.ekspedisi'
        ])
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

        return view('payment.index', compact('pesanan'));
    }
}
