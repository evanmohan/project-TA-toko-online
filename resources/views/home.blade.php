@extends('layouts.navbar.home.app')

@section('content')
<style>
    /* ====== GLOBAL ====== */
    body {
        background-color: #fafafa;
        font-family: 'Poppins', sans-serif;
    }

    :root {
        --orange: #ff6600;
        --dark-orange: #ff3300;
        --light-orange: #fff4ec;
    }

    .section-title {
        font-weight: 700;
        text-align: center;
        color: var(--dark-orange);
        margin: 40px 0 25px;
    }

    /* ====== PRODUK ====== */
    .product-card {
        border: 1px solid #eee;
        border-radius: 15px;
        background-color: #fff;
        transition: all 0.3s ease;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
        border-color: var(--orange);
    }

    .product-card img {
        height: 220px;
        object-fit: cover;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        transition: transform 0.3s ease;
    }

    .product-card:hover img {
        transform: scale(1.05);
    }

    .price {
        color: var(--orange);
        font-weight: 700;
        font-size: 1.1rem;
    }

    .btn-orange {
        background: linear-gradient(90deg, var(--orange), var(--dark-orange));
        color: white;
        border-radius: 8px;
        font-weight: 600;
        padding: 6px 14px;
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
        padding: 6px 14px;
        transition: all 0.3s ease;
        background: transparent;
    }

    .btn-outline-orange:hover {
        background: linear-gradient(90deg, var(--orange), var(--dark-orange));
        color: white;
        transform: translateY(-2px);
    }

    .card-body {
        padding: 15px;
    }
</style>

<!-- 🔹 PRODUK TERBARU -->
<div class="container mt-4">
    <h4 class="section-title">Produk Terbaru</h4>
    <div class="row">
        @forelse ($products as $product)
            <div class="col-6 col-md-3 mb-4">
                <div class="card product-card h-100">
                    <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('argon/assets/img/default-product.png') }}" alt="{{ $product->nama_produk }}">
                    <div class="card-body text-center">
                        <h6 class="fw-semibold text-dark">{{ $product->nama_produk }}</h6>
                        <p class="text-muted small mb-1">{{ $product->kategori->nama_kategori ?? 'Tanpa Kategori' }}</p>
                        <p class="price mb-3">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                        <a href="{{ route('produk.show', $product->id) }}" class="btn btn-orange btn-sm w-100 mb-2">Lihat Detail</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-orange btn-sm w-100">Beli Sekarang</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">Belum ada produk tersedia 😢</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
