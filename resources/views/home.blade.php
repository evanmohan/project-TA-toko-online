{{-- @extends('layouts.navbar.guest.app') --}}

@section('content')
<div class="container mt-5">
    <h3 class="text-center mb-4 fw-bold" style="color:#1f2d3d;">Produk Kami</h3>

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm border-0 h-100" style="border-radius: 12px;">
                    <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('argon/assets/img/default-product.png') }}"
                         class="card-img-top"
                         alt="{{ $product->nama_produk }}"
                         style="height: 180px; object-fit: cover; border-top-left-radius:12px; border-top-right-radius:12px;">
                    <div class="card-body text-center">
                        <h6 class="fw-semibold mb-2">{{ $product->nama_produk }}</h6>
                        <p class="text-muted mb-2">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                        <a href="#" class="btn btn-sm text-white" style="background-color:#f65f42; border-radius:6px;">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada produk tersedia.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
