<?php

namespace App\Http\Controllers;

use App\Models\BuktiPembayaran;
use App\Models\Order;
use Illuminate\Http\Request;
// use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    public function index($id)
    {
        $pesanan = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('payment.bayar', compact('pesanan'));
    }

    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'reqxuired|image|max:2048',
        ]);

        $pesanan = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $file = $request->file('bukti_pembayaran');
        $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/bukti_pembayaran'), $filename);

        $pesanan->update([
            'bukti_pembayaran' => $filename,
            'status_pembayaran' => 'PAID',
        ]);

        return redirect()->route('payment.index')->with('success', 'Bukti pembayaran berhasil diupload!');
    }

    public function list()
    {
        // Ambil semua pesanan milik user
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('payment.index', compact('orders'));
    }
    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        $order->status = 'cancelled';
        $order->save();

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function uploadForm($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('payment.upload', compact('order'));
    }

    // PROSES UPLOAD
    public function uploadSubmit(Request $request, $orderId)
    {
        $request->validate([
            'nama_pengirim' => 'required|string',
            'nominal'       => 'required|numeric',
            'bank_pengirim' => 'required|string',
            'foto_bukti'    => 'required|image|mimes:jpg,jpeg,png|max:5000',
        ]);

        $order = Order::findOrFail($orderId);

        // Simpan foto bukti
        $file = $request->file('foto_bukti');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/bukti'), $filename);

        // Simpan ke database bukti pembayaran
        BuktiPembayaran::create([
            'order_id'      => $order->id,
            'nama_pengirim' => $request->nama_pengirim,
            'nominal'       => $request->nominal,
            'bank_pengirim' => $request->bank_pengirim,
            'foto_bukti'    => $filename,
            'status'        => 'PENDING'
        ]);

        return redirect()->route('payment.index')
            ->with('success', 'Bukti pembayaran berhasil dikirim! Menunggu verifikasi admin.');
    }

}
