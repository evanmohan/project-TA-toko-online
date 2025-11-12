@extends('home.app')

@section('content')
<style>
    body {
        background-color: #f5f7fa;
        font-family: 'Poppins', sans-serif;
    }

    .cart-container {
        margin-top: 40px;
    }

    .cart-box {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
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

    .cart-item:last-child {
        border-bottom: none;
    }

    .cart-item img {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
        margin-right: 15px;
    }

    .cart-item-info {
        flex: 1;
    }

    .cart-item-info h6 {
        font-weight: 500;
        font-size: 15px;
        margin-bottom: 5px;
    }

    .cart-item-info small {
        color: #636e72;
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
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    /* ==== Ringkasan Belanja Card ==== */
    .summary-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        padding: 25px;
    }

    .summary-card h5 {
        font-weight: 600;
        font-size: 18px;
        margin-bottom: 15px;
        color: #2d3436;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 15px;
    }

    .summary-line strong {
        color: #333;
    }

    .summary-line span {
        color: #00b14f;
        font-weight: 500;
    }

    hr {
        margin: 15px 0;
        color: #ddd;
    }

    .checkout-btn {
        background-color: #00b14f;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px;
        font-weight: 600;
        width: 100%;
        margin-bottom: 10px;
        transition: background 0.3s;
    }

    .checkout-btn:disabled {
        background-color: #a9dfbf;
        cursor: not-allowed;
    }

    .checkout-btn:hover:not(:disabled) {
        background-color: #009944;
    }

    .clear-btn {
        border: 1px solid #ff4d4d;
        color: #ff4d4d;
        background: transparent;
        border-radius: 8px;
        padding: 10px;
        font-weight: 500;
        width: 100%;
        transition: 0.3s;
    }

    .clear-btn:hover {
        background: #ff4d4d;
        color: white;
    }

    /* ==== Empty Cart ==== */
    .empty-cart-box {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        padding: 50px 20px;
        text-align: center;
    }

    .empty-cart-box img {
        width: 120px;
        margin-bottom: 20px;
    }

    .empty-cart-box h5 {
        font-weight: 600;
        margin-bottom: 8px;
        color: #2d3436;
    }

    .empty-cart-box p {
        color: #636e72;
        margin-bottom: 20px;
    }

    .empty-cart-box .btn-success {
        background-color: #00b14f;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 600;
    }

    .empty-summary {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        padding: 25px;
        text-align: center;
    }

    .empty-summary p {
        background: #e9fff2;
        border-radius: 8px;
        padding: 10px;
        color: #00b14f;
        font-weight: 500;
        margin-bottom: 20px;
    }

    .empty-summary button {
        background-color: #a9dfbf;
        border: none;
        border-radius: 8px;
        color: #fff;
        padding: 10px;
        width: 100%;
        font-weight: 600;
    }
</style>

<div class="container cart-container">
    <h4 class="mb-4 fw-bold">Keranjang</h4>

    @if($items->isEmpty())
        {{-- ======== Tampilan Keranjang Kosong ======== --}}
        <div class="row">
            <div class="col-lg-8">
                <div class="empty-cart-box">
                    <img src="{{ asset('assets/images/empty_cart.png') }}" alt="Keranjang Kosong">
                    <h5>Wah, keranjang belanjamu kosong</h5>
                    <p>Yuk, isi dengan barang-barang impianmu!</p>
                    <a href="{{ route('home') }}" class="btn btn-success">Mulai Belanja</a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="empty-summary">
                    <h5>Ringkasan belanja</h5>
                    <p>Makin hemat pakai promo</p>
                    <button disabled>Beli</button>
                </div>
            </div>
        </div>
    @else
        {{-- ======== Tampilan Keranjang dengan Isi ======== --}}
        <div class="cart-header">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="checkAll">
                <label class="form-check-label ms-2 fw-semibold" for="checkAll">Pilih Semua</label>
            </div>
            {{-- <a href="{{ route('keranjang.clear') }}" class="text-success text-decoration-none" onclick="return confirm('Hapus semua item di keranjang?')">Hapus Semua</a> --}}
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="cart-box">
                    @foreach ($items as $it)
                    <div class="cart-item">
                        <input class="form-check-input item-check me-3" type="checkbox"
                            value="{{ $it->id }}"
                            data-price="{{ $it->harga_satuan }}"
                            data-qty="{{ $it->qty }}">
                        <img src="{{ $it->product->image ? asset('storage/'.$it->product->image) : asset('assets/images/default-product.png') }}" alt="Produk">
                        <div class="cart-item-info">
                            <h6>{{ $it->product->nama_produk ?? $it->product->name }}</h6>
                            <small>{{ Str::limit($it->product->deskripsi ?? '-', 60) }}</small>
                            <div class="text-success mt-1 fw-semibold">Rp {{ number_format($it->harga_satuan, 0, ',', '.') }}</div>
                        </div>

                        <div class="cart-item-actions">
                            <button class="qty-btn decrease">-</button>
                            <input type="number" value="{{ $it->qty }}" min="1" class="form-control form-control-sm text-center qty-input" style="width:60px;">
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

                    <div class="summary-line">
                        <strong>Total Barang:</strong>
                        <span id="totalItems">0</span>
                    </div>

                    <div class="summary-line">
                        <strong>Total Harga:</strong>
                        <span id="totalPrice">Rp 0</span>
                    </div>

                    <hr>

                    <div class="summary-line">
                        <strong>Subtotal:</strong>
                        <span id="subtotal">Rp 0</span>
                    </div>

                    <hr>

                    <button class="checkout-btn" id="buyBtn" disabled>Checkout Produk Terpilih</button>
                    <button class="clear-btn" onclick="if(confirm('Kosongkan semua isi keranjang?')) location.href='{{ route('keranjang.clear') }}'">Kosongkan Keranjang</button>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const checkAll = document.getElementById("checkAll");
    const itemChecks = document.querySelectorAll(".item-check");
    const qtyInputs = document.querySelectorAll(".qty-input");
    const totalPrice = document.getElementById("totalPrice");
    const subtotal = document.getElementById("subtotal");
    const totalItems = document.getElementById("totalItems");
    const buyBtn = document.getElementById("buyBtn");

    if (!checkAll) return; // jika keranjang kosong, hentikan script

    // Check All
    checkAll.addEventListener("change", () => {
        const checked = checkAll.checked;
        itemChecks.forEach(chk => chk.checked = checked);
        updateTotal();
    });

    // Item Checkbox
    itemChecks.forEach(chk => {
        chk.addEventListener("change", () => {
            const allChecked = [...itemChecks].every(i => i.checked);
            const anyChecked = [...itemChecks].some(i => i.checked);
            checkAll.checked = allChecked;
            buyBtn.disabled = !anyChecked;
            updateTotal();
        });
    });

    // Qty Buttons
    document.querySelectorAll(".increase").forEach((btn, i) => {
        btn.addEventListener("click", () => {
            const qtyInput = qtyInputs[i];
            qtyInput.value = parseInt(qtyInput.value) + 1;
            itemChecks[i].dataset.qty = qtyInput.value;
            updateTotal();
        });
    });

    document.querySelectorAll(".decrease").forEach((btn, i) => {
        btn.addEventListener("click", () => {
            const qtyInput = qtyInputs[i];
            if (qtyInput.value > 1) qtyInput.value = parseInt(qtyInput.value) - 1;
            itemChecks[i].dataset.qty = qtyInput.value;
            updateTotal();
        });
    });

    // Tombol Hapus
    document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const url = btn.getAttribute("data-url");
            if (confirm("Apakah kamu yakin ingin menghapus produk ini dari keranjang?")) {
                window.location.href = url;
            }
        });
    });

    // Hitung Total
    function updateTotal() {
        let total = 0;
        let count = 0;
        itemChecks.forEach(chk => {
            if (chk.checked) {
                total += parseInt(chk.dataset.price) * parseInt(chk.dataset.qty);
                count += parseInt(chk.dataset.qty);
            }
        });
        totalItems.textContent = count;
        totalPrice.textContent = 'Rp ' + total.toLocaleString('id-ID');
        subtotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
        buyBtn.disabled = count === 0;
    }
});
</script>
@endsection
