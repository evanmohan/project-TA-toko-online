@extends('layout')

@section('content')
<h3>Dashboard</h3>
<div class="row">
    <div class="col-md-4">
        <div class="card bg-primary text-white p-3">
            <h5>Total Produk</h5>
            <h2>{{ $totalProduk }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white p-3">
            <h5>Total Pesanan</h5>
            <h2>{{ $totalPesanan }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-white p-3">
            <h5>Total User</h5>
            <h2>{{ $totalUser }}</h2>
        </div>
    </div>
</div>
@endsection
