<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    // public function index()
    // {
    //     return view('dashboard', [
    //         'totalProduk' => Product::count(),
    //         'totalPesanan' => Pesanan::count(),
    //         'totalUser' => User::count()
    //     ]);
    // }

    public function admin()
    {
        return view('admin.dashboard', [
            // 'totalProduk' => Product::count(),
            // 'totalPesanan' => Pesanan::count(),
            // 'totalUser'   => User::where('role', 'customer')->count(),
        ]);
    }
}
