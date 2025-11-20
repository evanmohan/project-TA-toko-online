<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanPesanan;

class LaporanPesananController extends Controller
{
    public function index()
    {
        $laporan = LaporanPesanan::latest()->get();

        return view('admin.laporan.index', compact('laporan'));
    }
}
