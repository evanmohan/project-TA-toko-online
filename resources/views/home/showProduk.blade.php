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

        /* ===== POPUP STYLE ===== */
        .cart-success-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(1);
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 420px;
            padding: 28px 24px;
            text-align: center;
            z-index: 9999;
            animation: fadeIn 0.35s ease;
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
            animation: pop 0.4s ease;
        }

        .cart-success-popup .success-icon i {
            color: #fff;
            font-size: 32px;
        }

        @keyframes pop {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translate(-50%, -45%) scale(0.95);
            }

            100% {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        .cart-success-popup h4 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .cart-success-popup p {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 20px;
        }

        .cart-success-popup .btn-green {
            background-color: var(--green);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 20px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .cart-success-popup .btn-green:hover {
            background-color: #04a95d;
            transform: translateY(-2px);
        }

        .cart-success-popup .close-btn {
            position: absolute;
            top: 12px;
            right: 16px;
            background: none;
            border: none;
            font-size: 1.4rem;
            color: #999;
            cursor: pointer;
        }

        .cart-success-popup .close-btn:hover {
            color: #000;
        }

        .popup-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: 9998;
            animation: fadeInBackdrop 0.3s ease;
        }

        @keyframes fadeInBackdrop {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
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
                    <p class="text-muted mb-1">Kategori: <strong>{{ $produk->kategori->nama_kategori ?? '-' }}</strong></p>
                    <p>Ukuran: {{ $produk->size ?? '-' }}</p>
                    <p class="price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    <p class="mt-3">{{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

                    <form id="addToCartForm" action="{{ route('keranjang.add', $produk->id) }}" method="POST">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-4">
                                <label for="qty" class="form-label fw-semibold">Jumlah</label>
                                <input type="number" name="qty" id="qty" class="form-control" min="1"
                                    max="{{ $produk->stok }}" value="1">
                            </div>
                        </div>
                    </form>

                    <div class="mt-4 d-flex gap-2">
                        <button form="addToCartForm" class="btn-orange w-100">Tambah ke Keranjang</button>

                        <form action="{{ route('checkout.buy-now', $produk->id) }}" method="POST" class="w-100">
                            @csrf
                            <input type="hidden" name="qty" value="1" id="buyNowQty">
                            <button type="submit" class="btn-outline-orange w-100">Beli Sekarang</button>
                        </form>
                    </div>

                    <p class="text-muted small mt-4">Stok tersedia: {{ $produk->stok }}</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a2e0e6ad45.js" crossorigin="anonymous"></script>

    <script>
        const addToCartForm = document.getElementById('addToCartForm');
        const addBtn = addToCartForm.querySelector('.btn-orange');

        addToCartForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            if (addBtn.disabled) return;
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
                console.error(error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            } finally {
                // Apapun hasilnya, tombol kembali normal
                addBtn.disabled = false;
                addBtn.innerHTML = originalText;
            }
        });

        function showCartSuccess(productName) {
            const backdrop = document.createElement('div');
            backdrop.className = 'popup-backdrop';
            document.body.appendChild(backdrop);

            const popup = document.createElement('div');
            popup.className = 'cart-success-popup';
            popup.innerHTML = `
                            <button class="close-btn" onclick="closePopup()">×</button>
                            <div class="success-icon"><i class="fas fa-check"></i></div>
                            <h4>Berhasil Ditambahkan!</h4>
                            <p>${productName} berhasil dimasukkan ke keranjang.</p>
                            <a href="{{ route('keranjang.index') }}" class="btn-green">Lihat Keranjang</a>
                        `;
            document.body.appendChild(popup);

            setTimeout(() => closePopup(), 3000);
        }

        function closePopup() {
            const popup = document.querySelector('.cart-success-popup');
            const backdrop = document.querySelector('.popup-backdrop');
            if (popup) popup.remove();
            if (backdrop) backdrop.remove();
        }

        document.getElementById("qty").addEventListener("input", function () {
            document.getElementById("buy-now-qty").value = this.value;
        });

    </script>
@endsection
