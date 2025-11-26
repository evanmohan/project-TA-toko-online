@extends('home.app')

@section('content')
    <style>
        body {
            background-color: #fafafa;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --orange: #ff6600;
            --dark-orange: #ff3300;
            --green: #06c167;
            --text-dark: #2d3436;
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
            color: var(--text-dark);
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
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 20px;
            border: none;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-orange:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .btn-orange:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-outline-orange {
            border: 2px solid var(--orange);
            color: var(--orange);
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 20px;
            background: transparent;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-outline-orange:hover {
            background: linear-gradient(90deg, var(--orange), var(--dark-orange));
            color: white;
            transform: translateY(-2px);
        }

        .size-option {
            padding: 8px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.25s ease;
            user-select: none;
        }

        .size-option:hover {
            border-color: var(--orange);
            color: var(--orange);
        }

        .size-option.active {
            border-color: var(--orange);
            background: var(--orange);
            color: #fff;
        }

        /* -----------------------------------------
           ❤️ FAVORIT SHOPEE STYLE
        ----------------------------------------- */
        .favorite-btn {
            position: relative;
            font-size: 30px;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: .25s ease;
            user-select: none;
            background: #fff;
        }

        .favorite-btn i {
            font-size: 28px;
            color: #ccc;
            transition: .25s ease;
        }

        .favorite-btn.active i {
            color: #ff3d3d;
        }

        .favorite-btn:hover {
            box-shadow: 0 0 12px rgba(255, 61, 61, 0.5);
            transform: scale(1.15);
        }

        .favorite-btn[data-tooltip]::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: -32px;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: #fff;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            opacity: 0;
            pointer-events: none;
            transition: .2s ease;
            white-space: nowrap;
        }

        .favorite-btn:hover::after {
            opacity: 1;
        }

        /* Burst animation */
        .burst {
            position: absolute;
            top: 50%;
            left: 50%;
            pointer-events: none;
        }

        .burst span {
            position: absolute;
            width: 6px;
            height: 6px;
            background: #ff3d3d;
            border-radius: 50%;
            opacity: 0;
        }

        .burst span:nth-child(1) {
            --x: 20px;
            --y: -5px;
        }

        .burst span:nth-child(2) {
            --x: -20px;
            --y: -5px;
        }

        .burst span:nth-child(3) {
            --x: 0;
            --y: -25px;
        }

        .burst span:nth-child(4) {
            --x: 15px;
            --y: 20px;
        }

        .burst span:nth-child(5) {
            --x: -15px;
            --y: 20px;
        }

        @keyframes burstAnim {
            0% {
                transform: scale(0.2) translate(0, 0);
                opacity: 1;
            }

            80% {
                opacity: 1;
            }

            100% {
                transform: scale(1.5) translate(var(--x), var(--y));
                opacity: 0;
            }
        }
    </style>

    <div class="container">
        <div class="product-detail">
            <div class="row">
                <div class="col-md-5 mb-3 mb-md-0">
                    <img src="{{ $produk->image ? asset('storage/' . $produk->image) : asset('argon/assets/img/default-product.png') }}"
                        alt="{{ $produk->nama_produk }}" class="product-image">
                </div>

                <div class="col-md-7 product-info">
                    <h3>{{ $produk->nama_produk }}</h3>
                    <p class="text-muted mb-1">Kategori:
                        <strong>{{ $produk->kategori->nama_kategori ?? '-' }}</strong>
                    </p>

                    <p class="price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>

                    <p class="mt-3">{{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

                    <div class="mb-3">
                        <label class="fw-semibold d-block mb-2">Pilih Ukuran</label>

                        <div class="size-selector d-flex gap-2 flex-wrap">
                            @foreach(['S', 'M', 'L', 'XL', 'XXL'] as $size)
                                <div class="size-option" data-size="{{ $size }}">
                                    {{ $size }}
                                </div>
                            @endforeach
                        </div>

                        <input type="hidden" name="size" id="selectedSize">
                    </div>

                    <form id="addToCartForm" action="{{ route('keranjang.add', $produk->id) }}" method="POST">
                        @csrf

                        <div class="row align-items-center">
                            <div class="col-4">
                                <label for="qty" class="form-label fw-semibold">Jumlah</label>
                                <div class="d-flex gap-4">

                                    <input type="number" name="qty" id="qty" class="form-control" min="1"
                                        max="{{ $produk->stok }}" value="1">
                                    {{-- ❤️ TOMBOL FAVORIT SHOPEE --}}
                                    <div class="col-2 d-flex justify-content-center align-items-end pb-1">
                                        @auth
                                            @php
                                                $isFavorit = auth()->user()->favorits->contains('produk_id', $produk->id);
                                               @endphp
                                            <span id="favoriteBtn" class="favorite-btn {{ $isFavorit ? 'active' : '' }}"
                                                data-tooltip="{{ $isFavorit ? 'Hapus dari Favorit' : 'Tambahkan ke Favorit' }}">
                                                <i class="{{ $isFavorit ? 'fas' : 'far' }} fa-heart"></i>
                                                <div class="burst">
                                                    <span></span><span></span><span></span><span></span><span></span>
                                                </div>
                                            </span>
                                        @else
                                            <a href="{{ route('login') }}" class="favorite-btn">
                                                <i class="far fa-heart"></i>
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

                    <div class="mt-4 d-flex gap-2">
                        <button id="addToCartBtn" form="addToCartForm" class="btn-orange w-100">
                            Tambah ke Keranjang
                        </button>

                        <form action="{{ route('checkout.buy-now', $produk->id) }}" method="POST" class="w-100">
                            @csrf
                            <input type="hidden" name="qty" value="1" id="buyNowQty">
                            <input type="hidden" name="size" id="buyNowSize">

                            <button type="submit" class="btn-outline-orange w-100">
                                Beli Sekarang
                            </button>
                        </form>
                    </div>

                    <script src="https://kit.fontawesome.com/a2e0e6ad45.js" crossorigin="anonymous"></script>

                    <script>
                        /* -------------------------------
                           SIZE SELECT
                        ------------------------------- */
                        const sizeOptions = document.querySelectorAll('.size-option');
                        const selectedSizeInput = document.getElementById('selectedSize');
                        const buyNowSize = document.getElementById('buyNowSize');
                        const addBtn = document.getElementById('addToCartBtn');

                        addBtn.disabled = true;
                        document.querySelector('.btn-outline-orange').disabled = true;

                        sizeOptions.forEach(option => {
                            option.addEventListener('click', function () {
                                sizeOptions.forEach(o => o.classList.remove('active'));
                                this.classList.add('active');

                                selectedSizeInput.value = this.dataset.size;
                                buyNowSize.value = this.dataset.size;

                                addBtn.disabled = false;
                                document.querySelector('.btn-outline-orange').disabled = false;
                            });
                        });


                        /* ---------------------------------------
                           FAVORIT TOGGLE + BURST ANIMATION
                        --------------------------------------- */
                        @auth
                            document.getElementById("favoriteBtn").addEventListener("click", async function () {

                                const btn = this;
                                const icon = btn.querySelector("i");
                                const burst = btn.querySelectorAll(".burst span");
                                const isActive = btn.classList.contains("active");

                                const url = isActive
                                    ? "{{ route('favorit.destroy', $produk->id) }}"
                                    : "{{ route('favorit.store', $produk->id) }}";

                                const method = isActive ? "DELETE" : "POST";

                                // AJAX
                                const response = await fetch(url, {
                                    method: method,
                                    headers: {
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                        "Content-Type": "application/json"
                                    }
                                });

                                // UI update
                                if (response.ok) {
                                    btn.classList.toggle("active");

                                    icon.className = btn.classList.contains("active") ? "fas fa-heart" : "far fa-heart";

                                    btn.setAttribute("data-tooltip",
                                        btn.classList.contains("active")
                                            ? "Hapus dari Favorit"
                                            : "Tambahkan ke Favorit"
                                    );

                                    // Burst animation
                                    if (btn.classList.contains("active")) {
                                        burst.forEach((el) => {
                                            el.style.animation = "none";
                                            void el.offsetWidth;
                                            el.style.animation = "burstAnim .45s ease-out";
                                        });
                                    }
                                } else {
                                    alert("Gagal mengubah favorit.");
                                }
                            });
                        @endauth
                    </script>

@endsection
