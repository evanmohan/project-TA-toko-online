@extends('layouts.navbar.home.app')

@section('content')
<div class="container py-5">
    <h3 class="mb-4 fw-bold">🛒 Keranjang Belanja</h3>

    @if(session('cart') && count(session('cart')) > 0)
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Kuantiti</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach (session('cart') as $id => $item)
                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control w-50 d-inline">
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </td>
                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('cart.remove', $id) }}" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-end fw-bold">Total:</td>
                    <td colspan="2" class="fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="d-flex justify-content-end">
            <a href="{{ route('pesanan.checkout') }}" class="btn btn-success">Lanjutkan ke Checkout</a>
        </div>
    @else
        <p>Keranjang belanja kosong.</p>
    @endif
</div>
@endsection
