@extends('layouts.navbar.home.app')

@section('content')
<style>
    body {
        background-color: #fafafa;
        font-family: 'Poppins', sans-serif;
    }

    :root {
        --orange: #ff6600;
        --dark-orange: #ff3300;
        --light-orange: #fff4ec;
    }

    .product-detail {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        padding: 25px;
        margin-top: 30px;
    }

    .product-image {
        border-radius: 12px;
        width: 100%;
        height: 350px;
        object-fit: cover;
    }

    .product-info h3 {
        font-weight: 700;
        color: #333;
    }

    .product-info p {
        margin-bottom: 10px;
    }

    .price {
        color: var(--orange);
        font-weight: 700;
        font-size: 1.4rem;
        margin: 10px 0;
    }

    .btn-orange {
        background: linear-gradient(90deg, var(--orange), var(--dark-orange));
        color: white;
        border-radius: 8px;
        font-weight: 600;
        padding: 10px 20px;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-orange:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }

    .btn-outline-orange {
        border: 2px solid var(--orange);
        color: var(--orange);
        border-radius: 8px;
        font-weight: 600;
        padding: 10px 20px;
        transition: all 0.3s ease;
        background: transparent;
    }

    .btn-outline-orange:hover {
        background: linear-gradient(90deg, var(--orange), var(--dark-orange));
        color: white;
        transform: translateY(-2px);
    }

    .form-control {
        border-radius: 8px;
    }
</style>

<div class="container">
    <div class="product-detail">
        <div class="row">
            <div class="col-md-5 mb-3 mb-md-0">
                <img src="{{ $produk->image ? asset('storage/'.$produk->image) : asset('argon/assets/img/default-product.png') }}"
                     alt="{{ $produk->nama_produk }}"
                     class="product-image">
            </div>

            <div class="col-md-7 product-info">
                <h3>{{ $produk->nama_produk }}</h3>
                <p class="text-muted mb-1">Kategori: <strong>{{ $produk->kategori->nama_kategori ?? '-' }}</strong></p>
                <p>Ukuran: {{ $produk->size ?? '-' }}</p>
                <p class="price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>

                <p class="mt-3">{{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

                <form action="{{ route('login') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                    <div class="row align-items-center">
                        <div class="col-4">
                            <label for="jumlah" class="form-label fw-semibold">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" max="{{ $produk->stok }}" value="1">
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn-orange flex-fill">Tambah ke Keranjang</button>
                        <a href="{{ route('login', $produk->id) }}" class="btn-outline-orange flex-fill text-center">Beli Sekarang</a>
                    </div>
                </form>

                <p class="text-muted small mt-4">Stok tersedia: {{ $produk->stok }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
