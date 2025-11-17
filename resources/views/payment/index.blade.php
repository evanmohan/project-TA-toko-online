@extends('home.app')

@section('content')
<style>
    body {
        background-color: #f5f7fa;
        font-family: 'Poppins', sans-serif;
    }

    .payment-container {
        margin-top: 40px;
    }

    .payment-box {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .payment-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .badge {
        padding: 6px 10px;
        border-radius: 6px;
    }

    .badge-success { background: #28a745; color: #fff; }
    .badge-warning { background: #ffc107; }
    .badge-danger  { background: #dc3545; color: #fff; }
</style>

<div class="container payment-container">
    <h2 class="mb-4">Riwayat Pembayaran</h2>

    @if($orders->count() == 0)
        <div class="alert alert-info">
            Belum ada pembayaran yang dilakukan.
        </div>
    @endif

    @foreach($orders as $order)
        <div class="payment-box">
            <div class="payment-title">
                Payment / Order #{{ $order->id }}
            </div>

            <p><strong>Total Bayar:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>

            <p><strong>Status:</strong>
                @if($order->status == 'paid')
                    <span class="badge badge-success">Sudah Dibayar</span>
                @elseif($order->status == 'pending')
                    <span class="badge badge-warning">Menunggu Pembayaran</span>
                @else
                    <span class="badge badge-danger">{{ ucfirst($order->status) }}</span>
                @endif
            </p>

            <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>

            @if($order->status == 'pending')
                <a href="{{ route('payment.bayar', $order->id) }}" class="btn btn-primary mt-3">Bayar Sekarang</a>
            @endif
        </div>
    @endforeach
</div>

@endsection
