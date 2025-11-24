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

        .btn-orange:hover { opacity: 0.9; transform: translateY(-2px); }
        .btn-orange:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

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

        .size-option:hover { border-color: var(--orange); color: var(--orange); }
        .size-option.active { border-color: var(--orange); background: var(--orange); color: #fff; }

        .cart-success-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 420px;
            padding: 28px 24px;
            text-align: center;
            z-index: 9999;
        }

        .cart-success-popup .success-icon {
            width: 70px;
            height: 70px;
            background: var(--green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px auto;
        }

        .cart-success-popup .success-icon i { color: #fff; font-size: 32px; }
        .popup-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: 9998;
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
                                <input type="number" name="qty" id="qty"
                                       class="form-control" min="1"
                                       max="{{ $produk->stok }}" value="1">
                            </div>
                        </div>
                    </form>

                    <div class="mt-4 d-flex gap-2">
                        <button id="addToCartBtn" form="addToCartForm"
                                class="btn-orange w-100">
                            Tambah ke Keranjang
                        </button>

                        <form action="{{ route('checkout.buy-now', $produk->id) }}"
                              method="POST" class="w-100">
                            @csrf
                            <input type="hidden" name="qty" value="1" id="buyNowQty">
                            <input type="hidden" name="size" id="buyNowSize">

                            <button type="submit"
                                    class="btn-outline-orange w-100">
                                Beli Sekarang
                            </button>
                        </form>
                    </div>

                    <p class="text-muted small mt-4">
                        Stok tersedia: {{ $produk->stok }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a2e0e6ad45.js" crossorigin="anonymous"></script>

    <script>
        const addToCartForm = document.getElementById('addToCartForm');
        const addBtn = document.getElementById('addToCartBtn');

        const sizeOptions = document.querySelectorAll('.size-option');
        const selectedSizeInput = document.getElementById('selectedSize');
        const buyNowSize = document.getElementById('buyNowSize');

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

        // ======================================================
        //            PERBAIKAN: HANDLE USER LOGIN
        // ======================================================

        @guest
        addBtn.addEventListener('click', () => {
            window.location.href = "{{ route('login') }}";
        });

        document.querySelector('.btn-outline-orange').addEventListener('click', () => {
            window.location.href = "{{ route('login') }}";
        });
        @endguest

        @auth
        addToCartForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            if (!selectedSizeInput.value) {
                alert("Pilih ukuran dulu!");
                return;
            }

            const originalText = addBtn.innerHTML;
            addBtn.disabled = true;
            addBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menambahkan...';

            const formData = new FormData(this);

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': formData.get('_token') },
                    body: formData
                });

                if (response.ok) {
                    showCartSuccess("{{ $produk->nama_produk }}");
                } else {
                    alert('Gagal menambahkan ke keranjang.');
                }
            } catch (error) {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            } finally {
                addBtn.disabled = false;
                addBtn.innerHTML = originalText;
            }
        });
        @endauth

        function showCartSuccess(productName) {
            const backdrop = document.createElement('div');
            backdrop.className = 'popup-backdrop';
            document.body.appendChild(backdrop);

            const popup = document.createElement('div');
            popup.className = 'cart-success-popup';
            popup.innerHTML = `
                <div class="success-icon"><i class="fas fa-check"></i></div>
                <h4>Berhasil Ditambahkan!</h4>
                <p>${productName} berhasil dimasukkan ke keranjang.</p>
                <a href="{{ route('keranjang.index') }}" class="btn-green">Lihat Keranjang</a>
            `;
            document.body.appendChild(popup);

            setTimeout(() => {
                popup.remove();
                backdrop.remove();
            }, 2800);
        }

        document.getElementById("qty").addEventListener("input", function () {
            document.getElementById("buyNowQty").value = this.value;
        });
    </script>
@endsection
