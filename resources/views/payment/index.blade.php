@extends('home.app')

@section('content')
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Poppins', sans-serif;
        }

        .order-card {
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 22px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
            border: 1px solid #eee;
            transition: .2s;
        }

        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
        }

        .order-id {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .status-badge {
            padding: 7px 12px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
        }

        .badge-paid {
            background: #03ac0e;
            color: white;
        }

        .badge-pending {
            background: #e67e22;
            color: white;
        }

        .btn-tokped-pay {
            background: #03ac0e;
            color: white;
            border-radius: 10px;
            padding: 10px 22px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            text-decoration: none;
            transition: .2s;
        }

        .btn-tokped-pay:hover {
            background: #02950c;
        }

        .btn-tokped-cancel {
            background: white;
            border: 1px solid #dcdcdc;
            color: #333;
            border-radius: 10px;
            padding: 10px 22px;
            font-size: 14px;
            font-weight: 600;
            transition: .2s;
        }

        .btn-tokped-cancel:hover {
            background: #f3f3f3;
        }

        .product-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .collapse-btn {
            background: none;
            border: none;
            color: #007bff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            padding: 5px 0;
            transition: .2s;
        }

        .collapse-btn:hover {
            color: #0056c7;
        }
    </style>

    <div class="container payment-container">
        <h2 class="mb-4">Riwayat Pembayaran</h2>

        @if($orders->count() == 0)
            <div class="alert alert-info">Belum ada pembayaran.</div>
        @endif

        @foreach($orders as $order)
            <div class="order-card">

                <div class="order-header">
                    <div class="order-id">Order #{{ $order->kode_order }}</div>

                    @if($order->status == 'PAID')
                        <span class="status-badge badge-paid">Sudah Dibayar</span>

                    @elseif($order->status == 'CANCELED')
                        <span class="status-badge" style="background:#dc3545; color:white;">Dibatalkan</span>

                    @else
                        <span class="status-badge badge-pending">Belum Dibayar</span>
                    @endif
                </div>

                <p><strong>Total Bayar:</strong> Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</p>
                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y - H:i') }}</p>

                <!-- DETAIL PRODUK -->
                <button class="collapse-btn" data-bs-toggle="collapse" data-bs-target="#detail-{{ $order->id }}">
                    Lihat Detail Produk ▼
                </button>

                <div id="detail-{{ $order->id }}" class="collapse mt-3">
                    @foreach($order->items as $item)
                        <div class="product-item">
                            <div>
                                {{ $item->qty }} × Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- TOMBOL AKSI HANYA JIKA BELUM DIBAYAR -->
                @if($order->status == 'NOT PAID')
                    <div class="mt-3 d-flex gap-2 justify-content-end">

                        <a href="{{ route('payment.bayar', $order->id) }}" class="btn-tokped-pay">
                            Bayar Sekarang
                        </a>

                        <button class="btn-tokped-cancel" data-bs-toggle="modal" data-bs-target="#cancelModal-{{ $order->id }}">
                            Batal Pemesanan
                        </button>

                    </div>
                @endif

            </div>

            <!-- MODAL PEMBATALAN -->
            <div class="modal fade" id="cancelModal-{{ $order->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 12px;">

                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi Pembatalan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin membatalkan pesanan <strong>#{{ $order->kode_order }}</strong>?</p>
                            <p class="text-danger fw-bold">Tindakan ini tidak bisa dibatalkan.</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Tidak
                            </button>

                            <form action="{{ route('payment.cancel', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        @endforeach
    </div>
@endsection
