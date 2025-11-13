@extends('home.app')

@section('content')
<div class="container mt-4">
    <h3>Checkout</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($keranjang as $item)
            <tr>
                <td>{{ $item->product->nama_produk }}</td>
                <td>{{ $item->qty }}</td>
                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h5>Total: <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></h5>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="form-group mt-3">
            <label>Pilih Ekspedisi</label>
            <select class="form-control" name="ekspedisi" required>
                <option value="">-- Pilih --</option>
                @foreach ($ekspedisi as $e)
                    <option value="{{ $e->nama }}">{{ $e->nama }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Pesan Sekarang</button>
    </form>
</div>
@endsection
