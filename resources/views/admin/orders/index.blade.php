@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="row mt-4 mx-4">
    <div class="col-12">

        <div class="card mb-4">

            <div class="card-header pb-0">
                <h6>Daftar Pemesanan</h6>
            </div>

            <div class="card-body px-0 pt-0 pb-2">

                @if (session('success'))
                    <div class="alert alert-success mx-3 mt-3">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger mx-3 mt-3">{{ session('error') }}</div>
                @endif

                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>Kode Pesanan</th>
                                <th>Nama Pembeli</th>
                                <th>Alamat</th>
                                <th>No TLP</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Qty</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                                <th>Ongkir</th>
                                <th>Total Bayar</th>
                                <th>Ekspedisi</th>
                                <th>Status Bayar</th>
                                <th>Verifikasi Manual</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($orders as $order)
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>#{{ $order->kode_order }}</td>
                                        <td>{{ $order->nama }}</td>
                                        <td>{{ $order->alamat }}</td>
                                        <td>{{ $order->telepon }}</td>

                                        <td>{{ $item->product->kode_produk ?? '-' }}</td>
                                        <td>{{ $item->product->nama_produk ?? '-' }}</td>
                                        <td>{{ $item->qty }}</td>

                                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>

                                        <td>Rp {{ number_format($order->ongkir, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>

                                        <td>{{ $order->metode_pengiriman }}</td>

                                        <td>
                                            @if ($order->status == 'PAID')
                                                <span class="badge bg-success">PAID</span>
                                            @elseif ($order->status == 'NOT PAID')
                                                <span class="badge bg-warning text-dark">NOT PAID</span>
                                            @else
                                                <span class="badge bg-danger">CANCELLED</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($order->buktiPembayaran)
                                                @if ($order->buktiPembayaran->status == 'PENDING')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif ($order->buktiPembayaran->status == 'VALID')
                                                    <span class="badge bg-success">Valid</span>
                                                @else
                                                    <span class="badge bg-danger">Invalid</span>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary">Tidak Ada</span>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="14" class="text-center py-4 text-muted">
                                        Tidak ada order.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
