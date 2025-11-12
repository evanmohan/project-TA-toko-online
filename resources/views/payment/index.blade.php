@extends('home.app')

@section('content')
<div class="container py-5">
    <h3 class="fw-bold mb-4">💰 Pembayaran Pesanan</h3>

    <div class="card">
        <div class="card-body">
            <p><strong>Kode Pesanan:</strong> {{ $pesanan->kode_pesanan }}</p>
            <p><strong>Total Bayar:</strong> Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
            <p><strong>Status Pembayaran:</strong> {{ $pesanan->status_pembayaran }}</p>

            <hr>

            <h5>Transfer ke Rekening Berikut:</h5>
            <ul>
                <li>Bank BCA - 1234567890 a.n Second Store</li>
                <li>Bank Mandiri - 9876543210 a.n Second Store</li>
            </ul>

            <form action="{{ route('payment.upload', $pesanan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Upload Bukti Pembayaran</label>
                    <input type="file" name="bukti_pembayaran" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Bukti</button>
            </form>
        </div>
    </div>
</div>
@endsection
