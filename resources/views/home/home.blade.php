@extends('home.app')

@section('content')

    <style>
        :root {
            --blue: #0D6EFD;
            /* Primary */
            --blue-dark: #1A325B;
            /* Deep Blue */
            --blue-soft: #5A8DEE;
            /* Secondary */
            --light-gray: #F8F9FB;
            /* Background */
            --soft-gray: #DDE1E7;
            /* Border */
            --text-dark: #2C2C2C;
        }

        body {
            background: var(--light-gray);
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
        }

        /* ============================================================
           🔵 FULL BACKGROUND WRAPPER
        ============================================================ */
        .hero-bg-full {
            background: linear-gradient(135deg, #0D6EFD, #1A325B);
        }

        .carousel-wrapper {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .hero-slides-container {
            display: flex;
            width: 100%;
            transition: .6s ease-in-out;
        }

        .hero-slide {
            min-width: 100%;
        }

        .hero-banner {
            position: relative;
            background: linear-gradient(135deg, #0D6EFD, #1A325B);
            height: 525px;
            overflow: hidden;
            color: white;
        }

        .hero-text h1 {
            font-size: 50px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .hero-text small {
            font-size: 15px;
        }

        .hero-price {
            font-size: 26px;
            font-weight: bold;
            color: #FFE600;
            /* tetap cocok sebagai highlight */
        }

        .hero-img-right {
            position: absolute;
            right: 150px;
            top: 50%;
            width: 360px;
            transform: translateY(-50%);
        }

        .hero-indicators {
            position: absolute;
            bottom: 75px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
        }

        .hero-indicators span {
            width: 12px;
            height: 12px;
            background: white;
            border-radius: 50%;
            opacity: .4;
            margin: 0 4px;
            cursor: pointer;
        }

        .hero-indicators span.active {
            opacity: 1;
            background: #FFE600;
        }

        /* Arrow buttons */
        .hero-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
            background: white;
            color: var(--blue);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 5;
        }

        .hero-arrow:hover {
            background: #e9e9e9c2;
        }

        .arrow-left {
            left: 20px;
        }

        .arrow-right {
            right: 20px;
        }


        /* ============================================================
            CATEGORY STYLING
        ============================================================ */
        .category-wrapper {
            background: white;
            padding: 20px 0;
            border-radius: 10px;
            margin-top: -75px;
            margin-bottom: 30px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 10;
        }

        .category-box {
            text-align: center;
            padding: 10px;
            transition: .3s;
            border-radius: 12px;
        }

        .category-box:hover {
            transform: translateY(-5px);
            background: #eef3ff;
        }

        .category-box img {
            width: 55px;
            height: 55px;
        }

        .image-product {
            border-radius: 15px 15px 0 0;
        }


        /* ============================================================
            PRODUCT CARD STYLING
        ============================================================ */
        .product-card {
            border-radius: 15px;
            background: white;
            border: 1px solid var(--soft-gray);
            transition: .3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            border-color: var(--blue);
            box-shadow: 0 6px 16px rgba(13, 110, 253, 0.15);
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
            border-left: 6px solid var(--blue);
            padding-left: 12px;
            color: var(--blue-dark);
        }

        /* BUTTON RECOLOR */
        .btn-primary {
            background-color: var(--blue);
            border-color: var(--blue);
        }

        .btn-primary:hover {
            background-color: var(--blue-soft);
            border-color: var(--blue-soft);
        }

        .btn-outline-secondary {
            border-color: var(--blue-dark);
            color: var(--blue-dark);
        }

        .btn-outline-secondary:hover {
            background-color: var(--blue-dark);
            color: white;
        }
    </style>



    {{-- ========================================================= --}}
    {{-- 🔵 HERO CAROUSEL --}}
    {{-- ========================================================= --}}
    @if(count($iklans) > 0)
        <div class="hero-bg-full">

            <div class="position-relative mb-4">

                {{-- ARROW LEFT --}}
                <div class="hero-arrow arrow-left" onclick="prevSlide()">
                    ❮
                </div>

                {{-- ARROW RIGHT --}}
                <div class="hero-arrow arrow-right" onclick="nextSlide()">
                    ❯
                </div>

                <div class="carousel-wrapper">
                    <div class="hero-slides-container" id="heroSlides">

                        @foreach($iklans as $ads)
                            <div class="hero-slide">
                                <div class="hero-banner">

                                    {{-- TEXT --}}
                                    <div class="hero-text position-absolute"
                                        style="top: 50%; left: 150px; transform: translateY(-50%); max-width: 420px;">
                                        <small>Selamat Datang Di Second Store🤙</small>
                                        <h1>Pilih Barang<br>Yang & Bagus</h1>
                                        <div class="hero-price">Kepoin Barang Kita😊👌</div>
                                        <a href="#" class="btn btn-light mt-3 px-4 py-2 fw-semibold">Shop Now →</a>
                                    </div>

                                    {{-- GAMBAR --}}
                                    <img src="{{ asset('storage/' . $ads->gambar) }}" class="hero-img-right">

                                </div>
                            </div>
                        @endforeach

                    </div>

                    {{-- DOTS --}}
                    <div class="hero-indicators" id="heroDots">
                        @foreach($iklans as $index => $d)
                            <span onclick="goToSlide({{ $index }})" class="{{ $index === 0 ? 'active' : '' }}"></span>
                        @endforeach
                    </div>

                </div>

            </div>
        </div>
    @endif



    {{-- ========================================================= --}}
    {{-- 🔵 CATEGORY --}}
    {{-- ========================================================= --}}
    <div class="container category-wrapper">
        <div class="row text-center justify-content-center">
            @foreach ($kategori as $cat)
                <div class="col-3 col-md-1 mb-3">
                    <a href="{{ route('home', $cat->id) }}" class="text-decoration-none text-dark">
                        <div class="category-box">
                            <img src="{{ $cat->image ? asset('storage/' . $cat->image) : 'https://via.placeholder.com/120' }}"
                                style="width:60px; height:60px; border-radius:12px; object-fit:cover;">
                            <p class="fw-semibold small mt-2">{{ $cat->nama_kategori }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>



    {{-- ========================================================= --}}
    {{-- 🔵 PRODUK TERBARU --}}
    {{-- ========================================================= --}}
    <div class="container mt-4">
        <h4 class="section-title">Produk Terbaru</h4>

        <div class="row">
            @forelse ($products as $product)
                <div class="col-6 col-md-3 mb-4">
                    <div class="product-card h-100">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('argon/assets/img/default-product.png') }}"
                            class="image-product">

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



    {{-- ========================================================= --}}
    {{-- 🔵 JAVASCRIPT CAROUSEL --}}
    {{-- ========================================================= --}}
    <script>
        let index = 0;
        const slides = document.querySelectorAll(".hero-slide");
        const container = document.getElementById("heroSlides");
        const dots = document.querySelectorAll("#heroDots span");

        function goToSlide(i) {
            index = i;
            container.style.transform = "translateX(" + (-index * 100) + "%)";
            dots.forEach(d => d.classList.remove("active"));
            dots[index].classList.add("active");
        }

        function nextSlide() {
            index = (index + 1) % slides.length;
            goToSlide(index);
        }

        function prevSlide() {
            index = (index - 1 + slides.length) % slides.length;
            goToSlide(index);
        }

        setInterval(() => {
            nextSlide();
        }, 4000);
    </script>

@endsection
