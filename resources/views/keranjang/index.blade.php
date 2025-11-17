@extends('home.app')

@section('content')
<style>
    body {
        background-color: #f5f7fa;
        font-family: 'Poppins', sans-serif;
    }

    .cart-container { margin-top: 40px; }

    .cart-box {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        padding: 20px;
        margin-bottom: 20px;
    }

    .cart-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .cart-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .cart-item:last-child { border-bottom: none; }

    .cart-item-info { flex: 1; }

    .cart-item-info h6 {
        font-weight: 500;
        font-size: 15px;
        margin-bottom: 5px;
    }

    .cart-item-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .qty-btn {
        background: #eee;
        border: none;
        border-radius: 6px;
        width: 28px;
        height: 28px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .summary-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        padding: 25px;
    }

    .checkout-btn {
        background-color: #00b14f;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 12px;
        font-weight: 600;
        width: 100%;
        margin-bottom: 10px;
    }

    .checkout-btn:disabled {
        background-color: #a9dfbf;
        cursor: not-allowed;
    }

    .clear-btn {
        border: 1px solid #ff4d4d;
        color: #ff4d4d;
        background: transparent;
        border-radius: 8px;
        padding: 12px;
        font-weight: 500;
        width: 100%;
    }

    .clear-btn:hover {
        background: #ff4d4d;
        color: white;
    }

    .empty-cart-box {
        background:white;
        border-radius:20px;
        padding: 45px 20px;
        box-shadow:0 2px 8px rgba(0,0,0,0.05);
        text-align:center;
    }
</style>

<div class="container cart-container">
    <h4 class="mb-4 fw-bold">Keranjang</h4>

    {{-- ===================== KERANJANG KOSONG ===================== --}}
    @if ($items->isEmpty())
        <div class="row">
            <div class="col-lg-8">
                <div class="empty-cart-box">
                    <img src="{{ asset('assets/images/empty_cart.png') }}" width="170" class="mb-3">
                    <h4 class="fw-bold">Wah, keranjang belanjamu kosong</h4>
                    <p class="text-muted mb-4">Yuk, isi dengan barang-barang impianmu!</p>
                    <a href="{{ route('home') }}" class="btn btn-success px-4 py-2" style="border-radius:12px;">
                        Mulai Belanja
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="summary-card">
                    <h5 class="fw-bold">Ringkasan belanja</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <strong>Total</strong><span>-</span>
                    </div>

                    <hr>

                    <div class="p-3 mt-2"
                         style="background:#eaffe6; border:1px solid #bff5c2; border-radius:12px;">
                        <strong>✨ Makin hemat pakai promo</strong>
                    </div>

                    <button class="checkout-btn mt-4" disabled style="background:#f0f0f0; color:#bfbfbf;">
                        Beli
                    </button>
                </div>
            </div>
        </div>
    @else

    {{-- ===================== KERANJANG ADA ISI ===================== --}}
    <div class="cart-header">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkAll">
            <label class="form-check-label ms-2 fw-semibold">Pilih Semua</label>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="cart-box">
                @foreach($items as $it)
                    <div class="cart-item">

                        <input class="form-check-input item-check me-3"
                               type="checkbox"
                               value="{{ $it->id }}"
                               data-price="{{ $it->harga_satuan }}"
                               data-qty="{{ $it->qty }}">

                        <div class="cart-item-info">
                            <h6>{{ $it->product->nama_produk ?? $it->product->name }}</h6>
                            <small>{{ Str::limit($it->product->deskripsi ?? '-', 60) }}</small>
                            <div class="text-success mt-1 fw-semibold">
                                Rp {{ number_format($it->harga_satuan, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="cart-item-actions">
                            <button class="qty-btn decrease">-</button>

                            <input type="number" min="1"
                                   class="form-control form-control-sm text-center qty-input"
                                   value="{{ $it->qty }}" style="width: 60px;">

                            <button class="qty-btn increase">+</button>

                            <button class="btn btn-sm btn-outline-danger delete-btn"
                                    data-url="{{ route('keranjang.remove', $it->id) }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-lg-4">
            <div class="summary-card">
                <h5>Ringkasan Belanja</h5>

                <div class="d-flex justify-content-between mb-2">
                    <strong>Total Barang:</strong>
                    <span id="totalItems">0</span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <strong>Total Harga:</strong>
                    <span id="totalPrice">Rp 0</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between mb-2">
                    <strong>Subtotal:</strong>
                    <span id="subtotal">Rp 0</span>
                </div>

                <hr>

                {{-- =============== FORM CHECKOUT =============== --}}
                <form action="{{ route('checkout.cart') }}" method="POST">
                    @csrf
                    <input type="hidden" name="items" id="selectedItems">

                    <button type="submit" class="checkout-btn" id="buyBtn" disabled>
                        Checkout Produk Terpilih
                    </button>
                </form>

                <button class="clear-btn"
                        onclick="if(confirm('Kosongkan semua isi keranjang?')) location.href='{{ route('keranjang.clear') }}'">
                    Kosongkan Keranjang
                </button>
            </div>
        </div>
    </div>

    @endif
</div>

{{-- ========================= JAVASCRIPT ========================= --}}
<script>
    // PILIH SEMUA
    document.querySelector('#checkAll')?.addEventListener('change', function () {
        document.querySelectorAll('.item-check').forEach(i => i.checked = this.checked);
        updateSummary();
    });

    // UPDATE TOTAL
    function updateSummary() {
        let totalQty = 0;
        let totalPrice = 0;

        document.querySelectorAll('.item-check:checked').forEach(c => {
            let qty = parseInt(c.dataset.qty);
            let price = parseInt(c.dataset.price);
            totalQty += qty;
            totalPrice += qty * price;
        });

        document.getElementById('totalItems').innerText = totalQty;
        document.getElementById('totalPrice').innerText = 'Rp ' + totalPrice.toLocaleString('id-ID');
        document.getElementById('subtotal').innerText = 'Rp ' + totalPrice.toLocaleString('id-ID');

        // Hidupkan / Matikan tombol Checkout
        document.getElementById('buyBtn').disabled = totalQty === 0;
    }

    // Kumpulkan item terpilih + qty untuk dikirim ke controller
    function gatherSelectedItems() {
        let selected = [];

        document.querySelectorAll('.item-check:checked').forEach(c => {
            selected.push({
                id: c.value,
                qty: parseInt(c.dataset.qty)
            });
        });

        document.getElementById('selectedItems').value = JSON.stringify(selected);
    }

    // Saat klik checkout → kumpulkan data
    document.querySelector('#buyBtn').addEventListener('click', function () {
        gatherSelectedItems();
    });

    // EVENT CHECKBOX ITEM
    document.querySelectorAll('.item-check').forEach(chk => {
        chk.addEventListener('change', () => updateSummary());
    });

    // QTY BUTTON + HITUNG TOTAL
    document.querySelectorAll('.increase').forEach((btn, i) => {
        btn.addEventListener('click', () => {
            let input = document.querySelectorAll('.qty-input')[i];
            input.value = parseInt(input.value) + 1;
            document.querySelectorAll('.item-check')[i].dataset.qty = input.value;
            updateSummary();
        });
    });

    document.querySelectorAll('.decrease').forEach((btn, i) => {
        btn.addEventListener('click', () => {
            let input = document.querySelectorAll('.qty-input')[i];
            if (input.value > 1) {
                input.value = parseInt(input.value) - 1;
                document.querySelectorAll('.item-check')[i].dataset.qty = input.value;
                updateSummary();
            }
        });
    });

    // DELETE PRODUK
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            if (confirm('Hapus produk ini dari keranjang?')) {
                window.location.href = this.dataset.url;
            }
        });
    });
</script>

@endsection
