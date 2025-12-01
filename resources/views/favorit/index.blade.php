@extends('home.app')

@section('content')

<style>
    :root {
        --blue: #0D6EFD;
        --blue-dark: #1A325B;
        --blue-soft: #5A8DEE;
        --light-gray: #F8F9FB;
        --soft-gray: #DDE1E7;
        --text-dark: #2C2C2C;
    }

    /* Judul Produk Favorit */
    .fav-title {
        text-align: center;
        font-size: 2rem;
        font-weight: 800;
        color: var(--blue-dark);
        margin-bottom: 25px;
    }

    /* Grid sama seperti halaman home */
    .fav-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
    }

    /* Card produk */
    .product-card {
        border-radius: 15px;
        background: white;
        border: 1px solid var(--soft-gray);
        transition: .3s;
        position: relative;
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-5px);
        border-color: var(--blue);
        box-shadow: 0 6px 16px rgba(13, 110, 253, 0.25);
    }

    .product-card img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 15px 15px 0 0;
    }

    .price {
        color: var(--blue);
        font-size: 1.2rem;
        font-weight: 700;
    }

    /* Tombol hapus favorit */
    .remove-fav-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(3px);
        font-size: 20px;
        cursor: pointer;
        transition: .2s;
        z-index: 10;
        box-shadow: 0 0 0 rgba(255, 0, 0, 0);
    }

    .remove-fav-btn:hover {
        background: #ffdddd;
        color: #d80000;
        transform: scale(1.15);
        box-shadow: 0 0 12px rgba(255, 50, 50, 0.7);
    }

    .remove-fav-btn:hover::after {
        content: "Hapus dari Favorit";
        position: absolute;
        right: 50px;
        top: 6px;
        background: #333;
        padding: 6px 10px;
        color: white;
        font-size: 12px;
        border-radius: 5px;
        white-space: nowrap;
        opacity: 1;
        pointer-events: none;
    }

    /* Burst Effect */
    .burst {
        position: absolute;
        width: 120px;
        height: 120px;
        background: rgba(255, 80, 80, 0.3);
        border-radius: 50%;
        animation: burstAnim .45s ease-out forwards;
        pointer-events: none;
        z-index: 1;
    }

    @keyframes burstAnim {
        0% { transform: scale(0); opacity: 0.8; }
        100% { transform: scale(2.4); opacity: 0; }
    }

    /* EMPTY STATE CENTERED */
    .empty-fav {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        min-height: 60vh; /* pastikan center vertikal */
        text-align: center;
    }

    .empty-fav img {
        max-width: 180px;
        margin-bottom: 20px;
    }
</style>

<div class="container mt-4">

    <h2 class="fav-title">Produk Favorit</h2>

    {{-- EMPTY STATE --}}
    @if ($favorits->count() == 0)
        <div class="empty-fav">
            <img src="{{ asset('assets/images/Favorit.png') }}" alt="Favorit">
            <h4 class="fw-bold">Belum Ada Produk Favorit</h4>
            <p class="text-muted mb-4" style="font-size: 15px;">
                Kamu belum menambahkan produk ke daftar favorit.<br>
                Klik ikon ❤️ pada produk untuk menyimpannya di sini.
            </p>
            <a href="{{ route('home') }}" class="btn btn-success px-4 py-2" style="border-radius:12px;">
                Mulai Belanja
            </a>
        </div>
    @else
        {{-- GRID FAVORIT --}}
        <div class="fav-grid">
            @foreach ($favorits as $fav)
                <div class="product-card">

                    {{-- Hapus favorit --}}
                    <form action="{{ route('favorit.destroy', $fav->produk->id) }}"
                          method="POST" class="remove-fav-form position-relative">
                        @csrf
                        @method('DELETE')
                        <button class="remove-fav-btn fav-delete-btn" type="submit">✕</button>
                    </form>

                    {{-- Gambar Produk --}}
                    <a href="{{ route('produk.show', $fav->produk->id) }}">
                        <img src="{{ $fav->produk->image
                                    ? asset('storage/' . $fav->produk->image)
                                    : asset('argon/assets/img/default-product.png') }}"
                             alt="{{ $fav->produk->nama_produk }}">
                    </a>

                    <div class="p-3 text-center">
                        <h6 class="fw-semibold">{{ $fav->produk->nama_produk ?? 'Produk Tanpa Nama' }}</h6>
                        <p class="text-muted small">{{ $fav->produk->kategori->nama_kategori ?? 'Tanpa Kategori' }}</p>
                        <p class="price">Rp {{ number_format($fav->produk->harga, 0, ',', '.') }}</p>
                        <a href="{{ route('produk.show', $fav->produk->id) }}"
                           class="btn btn-primary btn-sm w-100 mb-2">
                            Lihat Detail
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</div>

{{-- BURST EFFECT --}}
<script>
    document.querySelectorAll(".fav-delete-btn").forEach(btn => {
        btn.addEventListener("click", function (e) {
            let burst = document.createElement("span");
            burst.classList.add("burst");

            let parent = this.parentElement.parentElement;
            parent.appendChild(burst);

            setTimeout(() => burst.remove(), 500);
        });
    });
</script>

@endsection
