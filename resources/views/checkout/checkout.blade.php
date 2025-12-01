{{-- resources/views/checkout/checkout.blade.php --}}

@extends('home.app')

@section('content')
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Poppins', sans-serif;
        }
        .checkout-container { margin-top: 40px; }
        .checkout-box {
            background: #fff; border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            padding: 20px; margin-bottom: 20px;
        }
        .checkout-header {
            font-size: 18px; font-weight: 600; margin-bottom: 15px;
        }
        .checkout-item {
            display: flex; align-items: center;
            padding: 15px 0; border-bottom: 1px solid #f0f0f0;
        }
        .checkout-item:last-child { border-bottom: none; }
        .checkout-item img {
            border-radius: 10px; width: 75px; height: 75px;
            object-fit: cover; margin-right: 15px;
        }
        .checkout-item-info { flex: 1; }
        .checkout-item-info h6 { font-size: 15px; margin-bottom: 5px; }
        .checkout-item-info small { font-size: 13px; color: #555; display: block; }
        .checkout-price {
            font-weight: 600; color: #ff5722; white-space: nowrap;
        }
        .summary-card {
            background: #fff; border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            padding: 25px;
        }
        .checkout-btn {
            background-color: #00b14f; color: white;
            border: none; border-radius: 8px;
            padding: 12px; font-weight: 600;
            width: 100%; margin-top: 10px;
        }
        .checkout-btn:disabled { background-color: #a9dfbf; cursor: not-allowed; }
    </style>

    <div class="container checkout-container">
        <h4 class="mb-4 fw-bold">Checkout</h4>

        <div class="row">
            {{-- LEFT SIDE --}}
            <div class="col-lg-7">
                {{-- Alamat Pengiriman --}}
                <div class="checkout-box">
                    <div class="checkout-header">Alamat Pengiriman</div>
                    <div>
                        <strong>{{ Auth::user()->username }}</strong> • {{ Auth::user()->no_hp }}<br>
                        {{ Auth::user()->alamat }}
                    </div>
                </div>

                {{-- Produk Dipesan --}}
                <div class="checkout-box">
                    <div class="checkout-header">Produk Dipesan</div>

                    @foreach ($items as $i)
                        <div class="checkout-item">
                            {{-- GAMBAR SUDAH FIX --}}
                            <img src="{{ $i['image'] ? asset('storage/' . $i['image']) : asset('assets/images/card_search.png') }}"
                                 alt="Produk">

                            <div class="checkout-item-info">
                                <h6>{{ $i['nama_produk'] }}</h6>

                                <small>
                                    Variant: <strong>
                                        {{ $i['variant_name'] ?? ($i['variant']['warna'] ?? '-') }}
                                    </strong>
                                </small>

                                <small>
                                    Size: <strong>
                                        {{ $i['size_name'] ?? ($i['size']['size'] ?? '-') }}
                                    </strong>
                                </small>

                                <small>Jumlah: {{ $i['qty'] }}</small>
                            </div>

                            <div class="checkout-price">
                                Rp {{ number_format($i['subtotal'],0,',','.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- RIGHT SIDE --}}
            <div class="col-lg-5">
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf

                    {{-- Ekspedisi --}}
                    <div class="checkout-box">
                        <div class="checkout-header">Pengiriman</div>
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

                    {{-- Payment --}}
                    <div class="checkout-box">
                        <div class="checkout-header">Metode Pembayaran</div>
                        <label class="form-label">Pilih Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select" required>
                            <option value="">Pilih Metode Pembayaran</option>
                            @foreach ($paymentMethods as $pm)
                                <option value="{{ $pm->id }}">
                                    {{ $pm->nama_metode }} - {{ ucfirst($pm->tipe) }}
                                    @if($pm->tipe == 'bank')
                                        • {{ $pm->no_rekening }} ({{ $pm->atas_nama }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Summary --}}
                    <div class="summary-card">
                        <div class="checkout-header">Ringkasan Belanja</div>
                        <div class="d-flex justify-content-between mb-2">
                            <strong>Total Barang</strong>
                            <span>{{ $items->sum('qty') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <strong>Total Harga</strong>
                            <span>Rp {{ number_format($items->sum('subtotal'),0,',','.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <strong>Ongkir</strong>
                            <span id="ongkir-display">Rp 0</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <strong>Total Bayar</strong>
                            <span id="totalTagihan">Rp {{ number_format($items->sum('subtotal'),0,',','.') }}</span>
                        </div>

                        <button type="submit" class="checkout-btn">Buat Pesanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const ekspedisiSelect = document.getElementById("ekspedisi-select");
        const ongkirDisplay = document.getElementById("ongkir-display");
        const totalTagihan = document.getElementById("totalTagihan");
        const ongkirHidden = document.getElementById("ongkir-hidden");

        const baseTotal = {{ $items->sum('subtotal') }};

        ekspedisiSelect.addEventListener("change", function () {
            let ongkir = parseInt(this.options[this.selectedIndex].dataset.ongkir) || 0;
            ongkirDisplay.innerText = "Rp " + ongkir.toLocaleString('id-ID');
            totalTagihan.innerText = "Rp " + (baseTotal + ongkir).toLocaleString('id-ID');
            ongkirHidden.value = ongkir;
        });
    </script>
@endsection
