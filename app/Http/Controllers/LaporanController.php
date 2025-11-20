<?php

namespace App\Http\Controllers;

use App\Models\LaporanPesanan;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = LaporanPesanan::latest()->get();
        return view('admin.laporan.index', compact('laporan'));
    }
}
