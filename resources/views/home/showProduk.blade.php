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
        height: 500px;
        object-fit: cover;
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
        width: 100%;
    }

    .btn-outline-orange {
        border: 2px solid var(--orange);
        color: var(--orange);
        border-radius: 10px;
        font-weight: 600;
        padding: 10px 20px;
        background: transparent;
        width: 100%;
    }

    .variant-option, .size-option {
        padding: 8px 15px;
        border: 2px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        margin: 3px;
        display: inline-block;
    }

    .variant-option.active, .size-option.active {
        border-color: var(--orange);
        background: var(--orange);
        color: #fff;
    }

    .variant-option.disabled, .size-option.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .variant-color {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
        vertical-align: middle;
        border: 1px solid #ccc;
    }

    .quantity-wrapper {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 15px;
    }

    .quantity-btn {
        width: 30px;
        height: 30px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        user-select: none;
    }

    .quantity-input {
        width: 50px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 5px;
        height: 30px;
    }

    .stok-info {
        margin-left: 10px;
        color: #555;
        font-size: 0.9rem;
    }
</style>

{{-- ========================= --}}
{{--   POPUP SUCCESS SWEETALERT --}}
{{-- ========================= --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 2000
    });
</script>
@endif

<div class="container">
    <div class="product-detail row">
        <div class="col-md-5">
            <img src="{{ $produk->image ? asset('storage/' . $produk->image) : asset('argon/assets/img/default-product.png') }}"
                 alt="{{ $produk->nama_produk }}" class="product-image" id="productImage">
        </div>

        <div class="col-md-7">
            <h3>{{ $produk->nama_produk }}</h3>
            <p class="price" id="dynamicPrice">
                @if($produk->variants->count() == 0)
                    Rp {{ number_format($produk->harga,0,',','.') }}
                @else
                    Rp {{ number_format($produk->variants->min('harga'),0,',','.') }}
                    - Rp {{ number_format($produk->variants->max('harga'),0,',','.') }}
                @endif
            </p>

            <p>{{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

            @if($produk->variants->count() > 0)
            <div class="mb-3">
                <label class="fw-semibold">Warna / Variant</label>
                <div id="variantWrapper">
                    @foreach($produk->variants as $v)
                        <div class="variant-option"
                             data-variant-id="{{ $v->id }}"
                             data-harga="{{ $v->harga }}"
                             data-image="{{ $v->image ? asset('storage/' . $v->image) : asset('argon/assets/img/default-product.png') }}">
                            <span class="variant-color" style="background-color: {{ $v->warna }}"></span>
                            {{ $v->warna }}
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3" id="sizeWrapper" style="display:none;">
                <label class="fw-semibold">Ukuran</label>
                <div id="sizeOptions"></div>
            </div>
            @endif

            <form id="addToCartForm" action="{{ route('keranjang.add', $produk->id) }}" method="POST">
                @csrf
                <input type="hidden" name="variant_id" id="variant_id">
                <input type="hidden" name="size_id" id="size_id">

                <label class="form-label fw-semibold">Kuantitas</label>
                <div class="quantity-wrapper">
                    <div class="quantity-btn" id="qtyMinus">-</div>
                    <input type="number" id="qty" name="qty" class="quantity-input" min="1" value="1" disabled>
                    <div class="quantity-btn" id="qtyPlus">+</div>
                    <span class="stok-info" id="stokInfo">Tersedia 0</span>
                </div>
            </form>

            <div class="d-flex gap-2">
                <button id="addToCartBtn" form="addToCartForm" class="btn-orange" disabled>
                    Tambah ke Keranjang
                </button>

                <form action="{{ route('checkout.buy-now', $produk->id) }}" method="POST" class="w-100">
                    @csrf
                    <input type="hidden" name="variant_id" id="buy_variant_id">
                    <input type="hidden" name="size_id" id="buy_size_id">
                    <input type="hidden" name="qty" value="1">
                    <button type="submit" class="btn-outline-orange w-100" id="buyNowBtn" disabled>
                        Beli Sekarang
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
const variants = @json($produk->variants);

const variantOptions = document.querySelectorAll('.variant-option');
const sizeWrapper = document.getElementById('sizeWrapper');
const sizeOptionsContainer = document.getElementById('sizeOptions');

const productImage = document.getElementById('productImage');
const dynamicPrice = document.getElementById('dynamicPrice');

const variantInput = document.getElementById('variant_id');
const sizeInput = document.getElementById('size_id');
const buyVariantInput = document.getElementById('buy_variant_id');
const buySizeInput = document.getElementById('buy_size_id');
const qtyInput = document.getElementById('qty');
const stokInfo = document.getElementById('stokInfo');
const addToCartBtn = document.getElementById('addToCartBtn');
const buyNowBtn = document.getElementById('buyNowBtn');

const qtyMinus = document.getElementById('qtyMinus');
const qtyPlus = document.getElementById('qtyPlus');

variantOptions.forEach(v => {
    v.addEventListener('click', function() {
        variantOptions.forEach(o => o.classList.remove('active'));
        this.classList.add('active');

        const variantId = this.dataset.variantId;
        const harga = this.dataset.harga;
        const image = this.dataset.image;

        dynamicPrice.innerHTML = 'Rp ' + Number(harga).toLocaleString('id-ID');
        productImage.src = image;

        variantInput.value = variantId;
        buyVariantInput.value = variantId;
        sizeInput.value = '';
        buySizeInput.value = '';

        const selectedVariant = variants.find(v => v.id == variantId);
        sizeOptionsContainer.innerHTML = '';

        if(selectedVariant.sizes.length > 0){
            sizeWrapper.style.display = 'block';
            selectedVariant.sizes.forEach(size => {
                const div = document.createElement('div');
                div.classList.add('size-option');
                if(size.stok == 0) div.classList.add('disabled');
                div.dataset.variantId = variantId;
                div.dataset.sizeId = size.id;
                div.dataset.stok = size.stok;
                div.innerText = size.size + (size.stok == 0 ? ' (Habis)' : '');
                sizeOptionsContainer.appendChild(div);

                div.addEventListener('click', function(){
                    document.querySelectorAll('.size-option').forEach(s => s.classList.remove('active'));
                    this.classList.add('active');

                    sizeInput.value = this.dataset.sizeId;
                    buySizeInput.value = this.dataset.sizeId;

                    const stok = parseInt(this.dataset.stok);
                    qtyInput.disabled = stok === 0;
                    addToCartBtn.disabled = stok === 0;
                    buyNowBtn.disabled = stok === 0;
                    qtyInput.max = stok;
                    qtyInput.value = stok > 0 ? 1 : 0;
                    stokInfo.innerText = `Tersedia ${stok}`;
                });
            });
        } else {
            sizeWrapper.style.display = 'none';
            qtyInput.disabled = false;
            addToCartBtn.disabled = false;
            buyNowBtn.disabled = false;
            qtyInput.max = 9999;
            qtyInput.value = 1;
            stokInfo.innerText = '';
        }
    });
});

qtyMinus.addEventListener('click', () => {
    let val = parseInt(qtyInput.value);
    if(val > 1) qtyInput.value = val - 1;
});
qtyPlus.addEventListener('click', () => {
    let val = parseInt(qtyInput.value);
    if(val < parseInt(qtyInput.max)) qtyInput.value = val + 1;
});

qtyInput.addEventListener('input', () => {
    let max = parseInt(qtyInput.max) || 1;
    if(parseInt(qtyInput.value) > max) qtyInput.value = max;
    if(parseInt(qtyInput.value) < 1) qtyInput.value = 1;
});
</script>
@endsection
