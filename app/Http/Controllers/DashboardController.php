<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalProduk' => Produk::count(),
            'totalPesanan' => Pesanan::count(),
            'totalUser' => User::count()
        ]);
    }
}
