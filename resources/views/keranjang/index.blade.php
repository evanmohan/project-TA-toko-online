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
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ===== Ringkasan ===== */
        .summary-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
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

        .summary-line span {
            font-weight: 600;
            color: #00b14f;
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

        /* ===== Empty Cart ===== */
        .empty-cart-box {
            background: #fff;
            border-radius: 12px;
            padding: 50px 20px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .empty-summary {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
    </style>

    <div class="container cart-container">
        <h4 class="mb-4 fw-bold">Keranjang</h4>


            {{-- FORM CHECKOUT --}}
            {{-- <form id="checkoutForm" action="{{ route('checkout.Cart') }}" method="POST">
                @csrf
                <input type="hidden" name="selected_items" id="checkoutItems">
            </form> --}}

            {{-- ========== KERANJANG ADA ISI ========== --}}
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
                                <input class="form-check-input item-check me-3" type="checkbox" value="{{ $it->id }}"
                                    data-price="{{ $it->harga_satuan }}" data-qty="{{ $it->qty }}">

                                {{-- <img
                                    src="{{ $it->product->image ? asset('storage/' . $it->product->image) : asset('assets/images/default-product.png') }}"> --}}

                                <div class="cart-item-info">
                                    <h6>{{ $it->product->nama_produk ?? $it->product->name }}</h6>
                                    <small>{{ Str::limit($it->product->deskripsi ?? '-', 60) }}</small>
                                    <div class="text-success mt-1 fw-semibold">
                                        Rp {{ number_format($it->harga_satuan, 0, ',', '.') }}
                                    </div>
                                </div>

                                <div class="cart-item-actions">
                                    <button class="qty-btn decrease">-</button>

                                    <input type="number" min="1" class="form-control form-control-sm text-center qty-input"
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

                        <button type="button" class="checkout-btn" id="buyBtn" disabled onclick="submitCheckout()">
                            Checkout Produk Terpilih
                        </button>


                        <button class="clear-btn"
                            onclick="if(confirm('Kosongkan semua isi keranjang?')) location.href='{{ route('keranjang.clear') }}'">
                            Kosongkan Keranjang
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        // CHECK ALL
        document.querySelector('#checkAll')?.addEventListener('change', function () {
            document.querySelectorAll('.item-check').forEach(i => i.checked = this.checked);
            updateSummary();
        });

        // PER ITEM CHECK
        document.querySelectorAll('.item-check').forEach(chk => {
            chk.addEventListener('change', updateSummary);
        });

        // UPDATE SUMMARY
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

            document.getElementById('buyBtn').disabled = totalQty === 0;
        }

        // SUBMIT CHECKOUT
        function submitCheckout() {
            let selected = [];

            document.querySelectorAll('.item-check:checked').forEach(c => {
                selected.push({
                    id: c.value,
                    qty: c.dataset.qty
                });
            });

            document.getElementById('checkoutItems').value = JSON.stringify(selected);
            document.getElementById('checkoutForm').submit();
        }

        // QTY BUTTONS
        document.querySelectorAll('.increase').forEach((btn, i) => {
            btn.addEventListener('click', () => {
                let qtyInput = document.querySelectorAll('.qty-input')[i];
                qtyInput.value = parseInt(qtyInput.value) + 1;
                document.querySelectorAll('.item-check')[i].dataset.qty = qtyInput.value;
                updateSummary();
            });
        });

        document.querySelectorAll('.decrease').forEach((btn, i) => {
            btn.addEventListener('click', () => {
                let qtyInput = document.querySelectorAll('.qty-input')[i];
                if (qtyInput.value > 1) {
                    qtyInput.value = parseInt(qtyInput.value) - 1;
                    document.querySelectorAll('.item-check')[i].dataset.qty = qtyInput.value;
                    updateSummary();
                }
            });
        });
    </script>
@endsection
