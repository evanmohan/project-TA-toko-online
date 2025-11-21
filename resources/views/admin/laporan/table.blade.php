<table class="table table-bordered">
    <thead class="bg-light">
        <tr>
            <th>Tanggal</th>
            <th>Kode Order</th>
            <th>Pembeli</th>
            <th>Total Item</th>
            <th>Total Bayar</th>
            <th>Ongkir</th>
            <th>Ekspedisi</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($list as $row)
            <tr>
                <td>{{ $row->created_at->format('d M Y') }}</td>
                <td>#{{ $row->kode_order }}</td>
                <td>{{ $row->nama_pembeli }}</td>
                <td>{{ $row->total_item }}</td>
                <td>Rp {{ number_format($row->total_bayar,0,',','.') }}</td>
                <td>Rp {{ number_format($row->ongkir,0,',','.') }}</td>
                <td>{{ $row->ekspedisi }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-3">Tidak ada data.</td>
            </tr>
        @endforelse
    </tbody>
</table>
