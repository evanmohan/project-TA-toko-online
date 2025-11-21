@extends('home.app')

@section('content')

<style>
    :root {
        --blue: #0b5ed7;
        --blue-dark: #063e91;
        --light-gray: #f5f5f5;
        --orange: #ff6600;
    }

    body {
        background: var(--light-gray);
        font-family: 'Poppins', sans-serif;
    }

    /* ================ HERO CAROUSEL STYLE ================ */
    .hero-banner {
        position: relative;
        background: linear-gradient(135deg, #0b5ed7, #063e91);
        border-radius: 20px;
        overflow: hidden;
        height: 420px;
        color: white;
        padding: 40px;
    }

    .hero-text h1 {
        font-size: 45px;
        font-weight: 800;
        margin-bottom: 10px;
        line-height: 1.1;
    }

    .hero-text p {
        font-size: 18px;
        opacity: .9;
    }

    .hero-price {
        font-size: 24px;
        font-weight: bold;
        color: #ffe600;
    }

    .hero-img-left,
    .hero-img-right {
        position: absolute;
        width: 320px;
        top: 50%;
        transform: translateY(-50%);
    }

    .hero-img-left {
        left: 5%;
    }

    .hero-img-right {
        right: 5%;
    }

    .hero-indicators {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
    }

    .hero-indicators span {
        width: 10px;
        height: 10px;
        display: inline-block;
        background: white;
        border-radius: 50%;
        margin: 0 4px;
        opacity: .5;
        cursor: pointer;
    }

    .hero-indicators span.active {
        opacity: 1;
        background: #ffe600;
    }

    /* ================= CATEGORY ================= */
    .category-wrapper {
        background: white;
        padding: 20px 0;
        border-radius: 20px;
        margin-top: -50px;
        margin-bottom: 30px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.07);
        position: relative;
        z-index: 10;
    }

    .category-box {
        text-align: center;
        padding: 12px;
        transition: 0.3s;
        border-radius: 12px;
    }

    .category-box:hover {
        transform: translateY(-5px);
        background: #eef3ff;
    }

    .category-box img {
        width: 50px;
        height: 50px;
    }

    /* PRODUCTS */
    .product-card {
        border-radius: 15px;
        background: white;
        border: 1px solid #eee;
        overflow: hidden;
        transition: 0.3s;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        border-color: var(--blue);
    }

    .product-card img {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }

    .price {
        color: var(--blue);
        font-size: 1.2rem;
        font-weight: 700;
    }

    .section-title {
        font-size: 22px;
        font-weight: 700;
        border-left: 5px solid var(--blue);
        padding-left: 12px;
    }
</style>


{{-- ========================================================= --}}
{{-- 🔥 HERO BANNER (MIRIP GAMBAR) --}}
{{-- ========================================================= --}}
@if(count($iklans) > 0)
<div class="container mb-4">
    <div class="hero-banner position-relative">

        {{-- TEXT --}}
        <div class="hero-text position-absolute" style="top: 50%; left: 50px; transform: translateY(-50%); max-width: 420px;">
            <small>DualSense Wireless Controller</small>

            <h1>Bring Gaming<br>Worlds To Life</h1>

            <p>Starting at</p>
            <div class="hero-price">$449.99</div>

            <a href="#" class="btn btn-light mt-3 px-4 py-2 fw-semibold">
                Shop Now →
            </a>
        </div>

        {{-- GAMBAR KIRI --}}
        @if(isset($iklans[0]))
            <img src="{{ asset('storage/' . $iklans[0]->gambar) }}" class="hero-img-right">
        @endif

        {{-- GAMBAR KANAN --}}
        {{-- @if(isset($iklans[1]))
            <img src="{{ asset('storage/' . $iklans[1]->gambar) }}" class="hero-img-right">
        @endif --}}

        {{-- DOTS --}}
        <div class="hero-indicators">
            @foreach($iklans as $i => $d)
                <span class="{{ $i === 0 ? 'active' : '' }}"></span>
            @endforeach
        </div>

    </div>
</div>
@endif



{{-- ========================================================= --}}
{{-- 🔥 CATEGORY SECTION --}}
{{-- ========================================================= --}}
<div class="container category-wrapper">
    <div class="row text-center justify-content-center">

        @foreach ($kategori as $cat)
            <div class="col-3 col-md-1 mb-3">
                <a href="{{ route('home', $cat->id) }}" class="text-decoration-none text-dark">
                    <div class="category-box">
                        <img src="{{ $cat->icon ? asset('storage/'.$cat->icon) : 'https://via.placeholder.com/60' }}">
                        <p class="fw-semibold small mt-2">{{ $cat->nama_kategori }}</p>
                    </div>
                </a>
            </div>
        @endforeach

    </div>
</div>



{{-- ========================================================= --}}
{{-- 🔥 PRODUK TERBARU --}}
{{-- ========================================================= --}}
<div class="container mt-4">
    <h4 class="section-title">Produk Terbaru</h4>

    <div class="row">
        @forelse ($products as $product)
            <div class="col-6 col-md-3 mb-4">
                <div class="product-card h-100">
                    <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('argon/assets/img/default-product.png') }}">

                    <div class="p-3 text-center">
                        <h6 class="fw-semibold">{{ $product->nama_produk }}</h6>
                        <p class="text-muted small">{{ $product->kategori->nama_kategori ?? 'Tanpa Kategori' }}</p>
                        <p class="price">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>

                        <a href="{{ route('produk.show', $product->id) }}" class="btn btn-primary btn-sm w-100 mb-2">
                            Lihat Detail
                        </a>

                        <form action="{{ route('checkout.buy-now', $product->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-secondary btn-sm w-100">Beli Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Belum ada produk.</p>
        @endforelse
    </div>
</div>

@endsection
