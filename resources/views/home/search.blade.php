@extends('home.app')

@section('content')
<div class="container my-5">

    <h3 class="fw-bold mb-4">
        Hasil Pencarian untuk: <span class="text-primary">"{{ $keyword }}"</span>
    </h3>

    {{-- EMPTY STATE --}}
    @if($products->count() == 0)
        <div class="d-flex justify-content-center my-5">
            <div class="text-center">

                <img src="{{ asset('assets/images/card_search.png') }}" width="180" class="mb-3">

                <h4 class="fw-bold">Produk Tidak Ditemukan</h4>

                <p class="text-muted mb-4" style="font-size: 15px;">
                    Tidak ada hasil untuk pencarian:
                    <b>"{{ $keyword }}"</b><br>
                    Coba gunakan kata kunci lain.
                </p>

                <a href="{{ route('home') }}" class="btn btn-success px-4 py-2" style="border-radius:12px;">
                    Kembali Belanja
                </a>

            </div>
        </div>
    @endif
    {{-- END EMPTY --}}

    {{-- LIST PRODUK --}}
    @if($products->count() > 0)
    <div class="row g-4">
        @foreach ($products as $p)
            <div class="col-6 col-md-4 col-lg-3">

                <div class="card h-100 shadow-sm border-0">

                    <img src="{{ $p->image
                        ? asset('storage/'.$p->image)
                        : asset('assets/images/default-product.png') }}"
                        class="card-img-top"
                        style="height: 220px; object-fit: cover;">

                    <div class="card-body d-flex flex-column">

                        <h6 class="card-title fw-semibold mb-2">
                            {{ Str::limit($p->nama_produk, 50) }}
                        </h6>

                        <p class="text-primary fw-bold mb-3">
                            Rp {{ number_format($p->harga, 0, ',', '.') }}
                        </p>

                        <a href="/produk/{{ $p->id }}" class="btn btn-dark w-100 mt-auto">
                            Lihat Produk
                        </a>
                    </div>

                </div>

            </div>
        @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links() }}
    </div>
    @endif

</div>
@endsection
