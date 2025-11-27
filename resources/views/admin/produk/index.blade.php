@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">

                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Manajemen Produk</h6>

                    <!-- Tombol tambah -->
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahProduk">
                        + Tambah Produk
                    </button>
                </div>

                <div class="card-body px-0 pt-0 pb-2">

                    @if (session('success'))
                        <div class="alert alert-success mx-3 mt-3">{{ session('success') }}</div>
                    @endif

                    {{-- TABEL --}}
                    <div class="table-responsive p-3">
                        <table class="table table-hover align-items-center mb-0">

                            <thead class="bg-light">
                                <tr>
                                    <th>Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Deskripsi</th>
                                    <th class="text-center">Tanggal Dibuat</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($products as $p)
                                    <tr>
                                        <td>
                                            <img src="{{ $p->image ? asset('storage/' . $p->image) : asset('argon/assets/img/default-product.png') }}"
                                                alt="{{ $p->nama_produk }}"
                                                class="img-thumbnail"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                        </td>

                                        <td>{{ $p->nama_produk }}</td>
                                        <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>

                                        <td>Rp {{ number_format($p->harga, 0, ',', '.') }}</td>

                                        <td>{{ $p->stok }}</td>

                                        <td class="text-truncate" style="max-width: 150px;">
                                            {{ $p->deskripsi ?? '-' }}
                                        </td>

                                        <td class="text-center">{{ $p->created_at->format('d/m/Y') }}</td>

                                        <td class="text-center">

                                            {{-- Tombol Detail --}}
                                            <button class="btn btn-info btn-sm text-white mx-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalDetailProduk{{ $p->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            {{-- Tombol Edit --}}
                                            <button class="btn btn-warning btn-sm mx-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditProduk{{ $p->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('admin.produk.destroy', $p->id) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus produk ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger btn-sm mx-1">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>

                                    {{-- ========================== --}}
                                    {{--       MODAL DETAIL         --}}
                                    {{-- ========================== --}}
                                    <div class="modal fade" id="modalDetailProduk{{ $p->id }}" tabindex="-1"
                                        aria-labelledby="detailProdukLabel{{ $p->id }}" aria-hidden="true">

                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        Detail Produk: {{ $p->nama_produk }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="row">

                                                        <div class="col-md-5 text-center">
                                                            <img src="{{ $p->image ? asset('storage/' . $p->image) : asset('argon/assets/img/default-product.png') }}"
                                                                class="img-fluid rounded"
                                                                style="max-height: 250px; object-fit: cover;">
                                                        </div>

                                                        <div class="col-md-7">
                                                            <h5>{{ $p->nama_produk }}</h5>

                                                            <p><strong>Kategori:</strong> {{ $p->kategori->nama_kategori ?? '-' }}</p>
                                                            <p><strong>Ukuran:</strong> {{ $p->size ?? '-' }}</p>
                                                            <p><strong>Harga:</strong> Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                                                            <p><strong>Stok:</strong> {{ $p->stok }}</p>

                                                            <p><strong>Deskripsi:</strong></p>
                                                            <p>{{ $p->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

                                                            <p class="text-muted small">
                                                                Dibuat: {{ $p->created_at->format('d M Y, H:i') }}
                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    {{-- ========================== --}}
                                    {{--         MODAL EDIT         --}}
                                    {{-- ========================== --}}
                                    <div class="modal fade" id="modalEditProduk{{ $p->id }}" tabindex="-1"
                                        aria-labelledby="editProdukLabel{{ $p->id }}" aria-hidden="true">

                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Produk</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <form action="{{ route('admin.produk.update', $p->id) }}"
                                                      method="POST" enctype="multipart/form-data">

                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-body">
                                                        <div class="row">

                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Nama Produk</label>
                                                                <input type="text" name="nama_produk"
                                                                    class="form-control" value="{{ $p->nama_produk }}"
                                                                    required>
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Kategori</label>
                                                                <select name="kategori_id" class="form-control" required>
                                                                    <option value="">-- Pilih Kategori --</option>
                                                                    @foreach ($kategoris as $k)
                                                                        <option value="{{ $k->id }}"
                                                                            {{ $p->kategori_id == $k->id ? 'selected' : '' }}>
                                                                            {{ $k->nama_kategori }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label">Harga</label>
                                                                <input type="number" name="harga"
                                                                    class="form-control" value="{{ $p->harga }}" required>
                                                            </div>

                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label">Stok</label>
                                                                <input type="number" name="stok"
                                                                    class="form-control" value="{{ $p->stok }}" required>
                                                            </div>

                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label">Ukuran (opsional)</label>
                                                                <input type="text" name="size"
                                                                    class="form-control" value="{{ $p->size }}">
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Gambar Produk</label>
                                                                <input type="file" name="image" class="form-control">

                                                                @if ($p->image)
                                                                    <img src="{{ asset('storage/' . $p->image) }}"
                                                                        class="mt-2"
                                                                        style="width:80px; height:80px; object-fit:cover; border-radius:6px;">
                                                                @endif
                                                            </div>

                                                            <div class="col-12 mb-3">
                                                                <label class="form-label">Deskripsi</label>
                                                                <textarea name="deskripsi" class="form-control" rows="3">{{ $p->deskripsi }}</textarea>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>

                                                        <button type="submit" class="btn btn-primary">
                                                            Simpan Perubahan
                                                        </button>
                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            Belum ada produk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- ========================== --}}
    {{--     MODAL TAMBAH PRODUK     --}}
    {{-- ========================== --}}
    <div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-labelledby="tambahProdukLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" name="nama_produk" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="kategori_id" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($kategoris as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" name="harga" class="form-control" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Stok</label>
                                <input type="number" name="stok" class="form-control" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Ukuran (opsional)</label>
                                <input type="text" name="size" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gambar Produk</label>
                                <input type="file" name="image" class="form-control">
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
