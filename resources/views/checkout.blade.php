@extends('layouts.navbar.app')

@section('content')
    <div class="container py-5">
        <h3 class="fw-bold mb-4 text-center">Checkout</h3>

        <div class="row">
            <!-- FORM INFORMASI PEMBELI -->
            <div class="col-lg-7 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="mb-3 fw-semibold">Informasi Pembeli</h5>
                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', auth()->user()->firstname . ' ' . auth()->user()->lastname) }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email', auth()->user()->email) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">Nomor Telepon</label>
                                <input type="text" name="no_hp" id="no_hp" class="form-control"
                                    value="{{ old('no_hp', auth()->user()->no_hp) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat Lengkap</label>
                                <textarea name="alamat" id="alamat" rows="3" class="form-control"
                                    required>{{ old('alamat', auth()->user()->alamat) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan (opsional)</label>
                                <textarea name="catatan" id="catatan" rows="2" class="form-control"
                                    placeholder="Contoh: tanpa sambal, extra keju"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- RINGKASAN PESANAN -->
            <div class="col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="mb-3 fw-semibold">Ringkasan Pesanan</h5>
                        <ul class="list-group mb-3">
                            @foreach ($cartItems as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $item->name }}</strong>
                                        <p class="text-muted mb-0 small">{{ $item->quantity }} ×
                                            Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                    <span
                                        class="fw-bold">Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ongkir</span>
                            <span>Rp{{ number_format($ongkir ?? 10000, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total</span>
                            <span>Rp{{ number_format($subtotal + ($ongkir ?? 10000), 0, ',', '.') }}</span>
                        </div>

                        <hr class="my-4">
                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="total" value="{{ $subtotal + ($ongkir ?? 10000) }}">
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                Lanjut ke Pembayaran
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 15px;
        }
    </style>
@endsection
