@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="text-uppercase fw-bold mb-0" style="color:#1f2d3d;">Manajemen Ekspedisi</h6>
                    <button class="btn btn-sm"
                        style="background-color:#f65f42; color:white; border:none; border-radius:8px; padding:8px 18px;"
                        data-bs-toggle="modal" data-bs-target="#modalTambahEkspedisi">
                        + Tambah Ekspedisi
                    </button>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    @if (session('success'))
                        <div class="alert alert-success mx-3 mt-3">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm">
                            <thead style="background-color:#f8fafc;">
                                <tr>
                                    <th>#</th>
                                    <th>Kode Ekspedisi</th>
                                    <th>Nama Ekspedisi</th>
                                    <th>Deskripsi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ekspedisis as $e)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $e->kode_ekspedisi ?? '-' }}</td>
                                        <td>{{ $e->nama }}</td>
                                        <td>{{ $e->deskripsi ?? '-' }}</td>
                                        <td class="text-center">
                                            <!-- Tombol Edit -->
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalEditEkspedisi{{ $e->id }}">
                                                Edit
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('admin.ekspedisi.destroy', $e->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus ekspedisi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="modalEditEkspedisi{{ $e->id }}" tabindex="-1"
                                        aria-labelledby="editEkspedisiLabel{{ $e->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content shadow-sm border-0" style="border-radius: 12px;">
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title fw-bold" id="editEkspedisiLabel{{ $e->id }}"
                                                        style="color:#1f2d3d;">Edit Ekspedisi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <form action="{{ route('admin.ekspedisi.update', $e->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body pt-0">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Nama Ekspedisi</label>
                                                            <input type="text" name="nama" class="form-control shadow-sm"
                                                                value="{{ $e->nama }}" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Deskripsi</label>
                                                            <textarea name="deskripsi" class="form-control shadow-sm" rows="3"
                                                                placeholder="Masukkan deskripsi ekspedisi">{{ $e->deskripsi }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer border-0 d-flex justify-content-end">
                                                        <button type="button" class="btn btn-secondary px-4"
                                                            style="border-radius: 8px;" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn text-white px-4"
                                                            style="background-color:#f65f42; border-radius: 8px;">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Belum ada ekspedisi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Ekspedisi -->
    <div class="modal fade" id="modalTambahEkspedisi" tabindex="-1" aria-labelledby="tambahEkspedisiLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.ekspedisi.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahEkspedisiLabel">Tambah Ekspedisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Ekspedisi</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn" style="background-color:#f65f42; color:white;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
