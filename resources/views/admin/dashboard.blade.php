@extends('layout')

@section('content')
<h3>Dashboard Admin</h3>
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
            <h5>Total Customer</h5>
            <h2>{{ $totalUser }}</h2>
        </div>
    </div>
</div>

<hr>
<a href="{{ route('produk.index') }}" class="btn btn-primary">Kelola Produk</a>
<a href="{{ route('pesanan.index') }}" class="btn btn-success">Kelola Pesanan</a>
<a href="{{ route('user.index') }}" class="btn btn-warning">Kelola User</a>
@endsection
