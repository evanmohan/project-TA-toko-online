<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    public function index($id)
    {
        $pesanan = Pesanan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('payment.index', compact('pesanan'));
    }

    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'reqxuired|image|max:2048',
        ]);

        $pesanan = Pesanan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $file = $request->file('bukti_pembayaran');
        $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/bukti_pembayaran'), $filename);

        $pesanan->update([
            'bukti_pembayaran' => $filename,
            'status_pembayaran' => 'PAID',
        ]);

        return redirect()->route('orders.index')->with('success', 'Bukti pembayaran berhasil diupload!');
    }
}
