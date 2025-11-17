@extends('home.app')

@section('content')
<div class="container mt-4">
    <h3>Pembayaran Pesanan</h3>
    <p><strong>Kode Pesanan:</strong> {{ $pesanan->kode_pesanan }}</p>
    <p><strong>Total Bayar:</strong> Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
    <p><strong>Ekspedisi:</strong> {{ $pesanan->ekspedisi }}</p>
    <p><strong>Status:</strong>
        <span class="badge bg-{{ $pesanan->status_pembayaran == 'PAID' ? 'success' : 'danger' }}">
            {{ $pesanan->status_pembayaran }}
        </span>
    </p>

    <div class="mt-4">
        <h5>Silakan transfer ke:</h5>
        <p>Bank BCA - 1234567890 a.n. Toko Laravel</p>

        @if(!$pesanan->bukti_pembayaran)
        {{-- <form action="{{ route('checkout.upload', $pesanan->id) }}" method="POST" enctype="multipart/form-data"> --}}
            @csrf
            <div class="form-group mt-3">
                <label>Upload Bukti Pembayaran</label>
                <input type="file" name="bukti_pembayaran" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Sudah Bayar</button>
        {{-- </form> --}}
        @else
        <p class="text-success mt-3">Bukti pembayaran sudah dikirim. Menunggu verifikasi admin.</p>
        <img src="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}" alt="Bukti" class="img-fluid mt-3" width="300">
        @endif
    </div>
</div>
@endsection
