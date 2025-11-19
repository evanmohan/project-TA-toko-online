<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuktiPembayaran;
use App\Models\Order;
use Illuminate\Http\Request;

class BuktiPembayaranController extends Controller
{
    public function index()
    {
        $list = BuktiPembayaran::with('order')
            ->latest()
            ->get();

        return view('admin.bukti_pembayaran.index', compact('list'));
    }

    public function show($id)
    {
        $bukti = BuktiPembayaran::with('order')->findOrFail($id);
        return view('admin.bukti_pembayaran.show', compact('bukti'));
    }

    public function approve($id)
    {
        $bukti = BuktiPembayaran::findOrFail($id);

        $bukti->status = 'VALID';
        $bukti->save();

        $order = Order::find($bukti->order_id);
        $order->status = 'PAID';
        $order->save();

        return back()->with('success', 'Bukti pembayaran diterima.');
    }

    public function reject($id)
    {
        $bukti = BuktiPembayaran::findOrFail($id);

        $bukti->status = 'INVALID';
        $bukti->save();

        $order = Order::find($bukti->order_id);
        $order->status = ' NOTPAID';
        $order->save();

        return back()->with('error', 'Bukti pembayaran ditolak.');
    }

    public function destroy($id)
    {
        $bukti = BuktiPembayaran::findOrFail($id);
        $bukti->delete();

        return back()->with('success', 'Bukti pembayaran dihapus.');
    }
}
