@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Laporan Pesanan</h5>
    </div>

    <div class="card-body table-responsive">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode Order</th>
                    <th>Pembeli</th>
                    <th>Total Item</th>
                    <th>Total Bayar</th>
                    <th>Ongkir</th>
                    <th>Ekspedisi</th>
                    <th>Tanggal Validasi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($laporan as $row)
                    <tr>
                        <td>#{{ $row->kode_order }}</td>
                        <td>{{ $row->nama_pembeli }}</td>
                        <td>{{ $row->total_item }}</td>
                        <td>Rp {{ number_format($row->total_bayar, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($row->ongkir, 0, ',', '.') }}</td>
                        <td>{{ $row->ekspedisi }}</td>
                        <td>{{ $row->tanggal_validasi }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-3 text-muted">Belum ada laporan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
@endsection
