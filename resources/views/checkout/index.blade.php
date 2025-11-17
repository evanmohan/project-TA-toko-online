{{-- @extends('home.app')

@section('content')
    <div class="container mt-4">
        <h2>Checkout Page</h2>

        @foreach($items as $i)
            <p>{{ $i->product->nama_produk }} x {{ $i->qty }} = Rp {{ number_format($i->subtotal) }}</p>
        @endforeach

        <p>Total Produk: Rp {{ number_format($total_produk) }}</p>

        <form method="POST" action="{{ route('checkout.process') }}">
            @csrf

            <input type="text" name="nama" placeholder="Nama" required>
            <input type="text" name="telepon" placeholder="Telepon" required>
            <textarea name="alamat" placeholder="Alamat" required></textarea>

            <input type="text" name="provinsi" placeholder="Provinsi" required>
            <input type="text" name="kota" placeholder="Kota" required>

            <textarea name="catatan" placeholder="Catatan (opsional)"></textarea>

            <select name="metode_pembayaran" required>
                <option value="COD">COD</option>
                <option value="Transfer Bank">Transfer Bank</option>
                <option value="E-wallet">E-wallet</option>
            </select>

            <input type="number" name="ongkir" min="0" placeholder="Ongkir" required>

            <button type="submit">Proses Pesanan</button>
        </form>

    </div>
@endsection --}}
