@extends('home.app')

@section('content')

    <style>
        body {
            background: #f5f5f5;
            font-family: "Poppins", sans-serif;
        }

        .card-shopee {
            background: #fff;
            border-radius: 10px;
            padding: 18px 22px;
            border: 1px solid #e5e7eb;
            margin-bottom: 20px;
        }

        .title-section {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #333;
        }

        .address-box {
            line-height: 1.6;
            font-size: 14px;
            color: #444;
        }

        .address-box strong {
            font-size: 15px;
        }

        .product-item {
            display: flex;
            gap: 15px;
            padding: 16px 0;
            border-bottom: 1px solid #eee;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .product-img {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #ddd;
        }

        .product-name {
            font-weight: 600;
            font-size: 15px;
        }

        .product-qty {
            font-size: 13px;
            color: #777;
        }

        .product-price {
            font-weight: 700;
            color: #ff5722;
            white-space: nowrap;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .summary-total {
            border-top: 1px solid #ddd;
            padding-top: 12px;
            font-size: 17px;
            font-weight: 700;
            color: #d84315;
        }

        .btn-shopee {
            background: #ff5722;
            border: none;
            color: white;
            padding: 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 17px;
            width: 100%;
            transition: 0.2s;
        }

        .btn-shopee:hover {
            background: #e64a19;
        }
    </style>

    <div class="container mt-4">

        <div class="row">

            <!-- LEFT SIDE -->
            <div class="col-lg-7">

                <!-- Alamat Pengiriman -->
                <div class="card-shopee">
                    <div class="title-section">Alamat Pengiriman</div>

                    <div class="address-box">
                        <strong>{{ Auth::user()->username }}</strong> • {{ Auth::user()->no_hp }} <br>
                        {{ Auth::user()->alamat }}
                    </div>
                </div>

                <!-- Produk -->
                <div class="card-shopee">
                    <div class="title-section">Produk Dipesan</div>

                    @foreach ($items as $i)
                        <div class="product-item">

                            {{-- IMAGE PRODUK --}}
                            {{-- <img
                                src="{{ $i['image'] ? asset('storage/' . $i['image']) : asset('assets/images/default-product.png') }}"
                                class="product-img"> --}}

                            <div style="flex-grow:1;">
                                <div class="product-name">{{ $i['nama_produk'] }}</div>
                                <div class="product-qty">Qty: {{ $i['qty'] }}</div>
                            </div>

                            <div class="product-price">
                                Rp {{ number_format($i['subtotal'], 0, ',', '.') }}
                            </div>

                        </div>
                    @endforeach
                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="col-lg-5">

                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf

                    <!-- Ekspedisi -->
                    <div class="card-shopee">
                        <div class="title-section">Pengiriman</div>

                        <label class="form-label">Pilih Ekspedisi</label>
                        <select name="metode_pengiriman" class="form-select mb-3" id="ekspedisi-select" required>
                            <option value="">Pilih Ekspedisi</option>
                            @foreach ($ekspedisi as $exp)
                                <option value="{{ $exp->id }}" data-ongkir="{{ $exp->ongkir }}">
                                    {{ $exp->nama }} - {{ $exp->kode_ekspedisi }}
                                </option>
                            @endforeach
                        </select>

                        <input type="hidden" name="ongkir" id="ongkir-hidden">
                    </div>

                    <!-- Payment Method From DB -->
                    <div class="card-shopee">
                        <div class="title-section">Metode Pembayaran</div>

                        <label class="form-label">Pilih Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select" required>
                            <option value="">Pilih Metode Pembayaran</option>

                            @foreach ($paymentMethods as $pm)
                                <option value="{{ $pm->id }}">
                                    {{ $pm->nama_metode }} - {{ ucfirst($pm->tipe) }}
                                    @if ($pm->tipe == 'bank')
                                        • {{ $pm->no_rekening }} ({{ $pm->atas_nama }})
                                    @endif
                                </option>
                            @endforeach

                        </select>

                    </div>

                    <!-- Summary -->
                    <div class="card-shopee">
                        <div class="title-section">Ringkasan Belanja</div>

                        <div class="summary-row">
                            <span>Total Harga</span>
                            <span>Rp {{ number_format($total_harga, 0, ',', '.') }}</span>
                        </div>

                        <div class="summary-row">
                            <span>Ongkir</span>
                            <span id="ongkir-display">Rp 0</span>
                        </div>

                        <div class="summary-row summary-total">
                            <span>Total Tagihan</span>
                            <span id="total-tagihan">Rp {{ number_format($total_harga, 0, ',', '.') }}</span>
                        </div>

                        <button class="btn-shopee mt-2">
                            Buat Pesanan
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

    <script>
        const ekspedisiSelect = document.getElementById("ekspedisi-select");
        const ongkirDisplay = document.getElementById("ongkir-display");
        const totalTagihan = document.getElementById("total-tagihan");
        const ongkirHidden = document.getElementById("ongkir-hidden");

        const baseTotal = {{ $total_harga }};

        ekspedisiSelect.addEventListener("change", function () {
            let ongkir = parseInt(this.options[this.selectedIndex].dataset.ongkir) || 0;

            ongkirDisplay.innerText = "Rp " + ongkir.toLocaleString();
            totalTagihan.innerText = "Rp " + (baseTotal + ongkir).toLocaleString();

            ongkirHidden.value = ongkir;
        });
    </script>

@endsection
