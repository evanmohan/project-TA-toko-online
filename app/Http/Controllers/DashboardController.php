<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Dashboard untuk ADMIN
    public function admin()
    {
        // tanpa hitung produk/pesanan/user dulu
        return view('admin.dashboard');
    }

    // Dashboard untuk USER
    public function user()
    {
        $user = Auth::user();
        return view('customer.dashboard', compact('user'));
    }
}
