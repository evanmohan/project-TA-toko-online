@extends('layout')

@section('content')
<h3>Kelola Produk</h3>
<a href="{{ route('produk.create') }}" class="btn btn-primary">Tambah Produk</a>
<table class="table mt-3">
    <tr><th>Kode</th><th>Nama</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr>
    @foreach($produk as $p)
    <tr>
        <td>{{ $p->kode_produk }}</td>
        <td>{{ $p->nama_produk }}</td>
        <td>Rp {{ number_format($p->harga,0,',','.') }}</td>
        <td>{{ $p->stok }}</td>
        <td>
            <a href="{{ route('produk.edit',$p) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('produk.destroy',$p) }}" method="POST" style="display:inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
