@extends('layouts.navbar.auth.app')

@section('content')
<style>
    /* ====== GLOBAL ====== */
    body {
        background-color: #fafafa;
        font-family: 'Poppins', sans-serif;
    }

    /* ====== HERO ====== */
    .hero-banner {
        background: linear-gradient(135deg, #ff8a65, #f65f42);
        color: #fff;
        border-radius: 18px;
        padding: 60px 20px;
        text-align: center;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }
    .hero-banner::before {
        content: "";
        position: absolute;
        top: -40px;
        right: -40px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    .hero-banner h2 {
        font-weight: 800;
        font-size: 2rem;
        letter-spacing: 0.5px;
    }
    .hero-banner p {
        font-size: 1rem;
        margin-top: 10px;
        opacity: 0.9;
    }
    .hero-banner .btn-light {
        background-color: #fff;
        color: #f65f42;
        font-weight: 600;
        border-radius: 25px;
        padding: 10px 25px;
        transition: all 0.3s ease;
    }
    .hero-banner .btn-light:hover {
        background-color: #ffe0d8;
        transform: translateY(-2px);
    }

    /* ====== KATEGORI ====== */
    .category-badge {
        background: linear-gradient(135deg, #fff3f1, #ffeae6);
        color: #f65f42;
        font-size: 15px;
        font-weight: 600;
        padding: 8px 15px;
        border-radius: 25px;
        border: 1px solid #ffd2c7;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .category-badge:hover {
        background: #f65f42;
        color: #fff;
        transform: scale(1.05);
    }

    /* ====== PRODUK ====== */
    .product-card {
        border: none;
        border-radius: 16px;
        transition: all 0.3s ease;
        background-color: #fff;
        overflow: hidden;
        position: relative;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }
    .product-card img {
        height: 220px;
        object-fit: cover;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
        transition: all 0.4s ease;
    }
    .product-card:hover img {
        transform: scale(1.05);
    }
    .product-card .card-body {
        padding: 15px;
    }
    .price {
        color: #f65f42;
        font-weight: 700;
        font-size: 1.1rem;
    }

    /* ====== BUTTON ====== */
    .btn-orange {
        background-color: #f65f42;
        color: white;
        border-radius: 8px;
        font-weight: 600;
        padding: 6px 14px;
        transition: all 0.3s ease;
    }
    .btn-orange:hover {
        background-color: #e04b32;
        transform: translateY(-2px);
    }

    .btn-outline-orange {
        border: 2px solid #f65f42;
        color: #f65f42;
        border-radius: 8px;
        font-weight: 600;
        padding: 6px 14px;
        transition: all 0.3s ease;
    }
    .btn-outline-orange:hover {
        background-color: #f65f42;
        color: white;
        transform: translateY(-2px);
    }

    /* ====== FOOTER ====== */
    footer {
        background-color: #fff;
        border-top: 1px solid #eee;
        padding-top: 20px;
        padding-bottom: 20px;
    }
</style>

<div class="container mt-4">

    <!-- Hero Banner -->
    <div class="hero-banner mb-5">
        <h2>Selamat Datang di <span class="fw-bold">Second Store</span> 🛍️</h2>
        <p class="mt-2">Temukan produk fashion terbaik dan terbaru dengan harga spesial setiap hari.</p>
        <a href="{{ route('login') }}" class="btn btn-light mt-3 shadow-sm px-4 fw-semibold">
            Login untuk Belanja
        </a>
    </div>

    <!-- Kategori -->
    <div class="mb-5">
        <h5 class="fw-bold mb-3 text-dark">Kategori Populer</h5>
        <div class="d-flex flex-wrap gap-2">
            <span class="category-badge">Baju</span>
            <span class="category-badge">Celana</span>
            <span class="category-badge">Sepatu</span>
            <span class="category-badge">Hem</span>
            <span class="category-badge">Aksesoris</span>
        </div>
    </div>

    <!-- Produk -->
    <h4 class="fw-bold mb-4 text-dark text-center">Produk Terbaru</h4>
    <div class="row">
        @forelse ($products as $product)
            <div class="col-6 col-md-3 mb-4">
                <div class="card product-card shadow-sm h-100">
                    <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('argon/assets/img/default-product.png') }}"
                         alt="{{ $product->nama_produk }}">
                    <div class="card-body text-center">
                        <h6 class="fw-semibold text-dark">{{ $product->nama_produk }}</h6>
                        <p class="text-muted small mb-1">{{ $product->kategori->nama_kategori ?? 'Tanpa Kategori' }}</p>
                        <p class="price mb-3">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>

                        <a href="{{ route('login') }}" class="btn btn-orange btn-sm w-100 mb-2">
                            Lihat Detail
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-orange btn-sm w-100">
                            Beli Sekarang
                        </a>
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

<!-- Footer -->
<footer class="mt-5 text-center">
    <p class="mb-0 text-muted small">
        &copy; {{ date('Y') }} Second Store. Semua hak cipta dilindungi.
    </p>
</footer>
@endsection
x
