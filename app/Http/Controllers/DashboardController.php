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

    // Profile untuk ADMIN
    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile');

    }
    // Billing untuk ADMIN
    public function billing(){
        $user = Auth::user();
        return view('auth.billing');
    }
    // Management untuk ADMIN
    public function management(){
        $user = Auth::user();
        return view('auth.management');
    }
    // // Tables untuk ADMIN
    // public function tables(){
    //     $user = Auth::user();
    //     return view('auth.tables');
    // }
    // Kategori untuk ADMIN
    // public function kategori(){
    //     $user = Auth::user();
    //     return view('auth.kategori');
    // }
}
