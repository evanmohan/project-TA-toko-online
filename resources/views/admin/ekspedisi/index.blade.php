@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

<style>
    .carousel-img {
        height: 260px;
        object-fit: cover;
        border-radius: 12px;
    }
</style>

<div class="row mt-4 mx-4">
    <div class="col-12">

        <!-- ============================= -->
        <!--        FORM TAMBAH IKLAN      -->
        <!-- ============================= -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6 class="text-uppercase fw-bold mb-0" style="color:#1f2d3d;">Manajemen Iklan</h6>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.iklan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Judul Iklan</label>
                            <input type="text" name="judul" class="form-control shadow-sm" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Pilih Produk (Opsional)</label>
                            <select name="product_id" class="form-select shadow-sm">
                                <option value="">-- Tanpa Produk --</option>
                                @foreach($produk as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Gambar Iklan</label>
                            <input type="file" name="gambar" class="form-control shadow-sm" accept="image/*" required>
                        </div>
                    </div>

                    <button class="btn text-white px-4" style="background-color:#f65f42; border-radius:8px;">
                        Simpan Iklan
                    </button>
                </form>
            </div>
        </div>

        <!-- ============================= -->
        <!--      PREVIEW CAROUSEL IKLAN   -->
        <!-- ============================= -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header pb-0">
                <h6 class="text-uppercase fw-bold mb-0" style="color:#1f2d3d;">Preview Carousel</h6>
            </div>

            <div class="card-body">
                @if ($iklans->count() > 0)
                    <div id="iklanCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($iklans as $key => $iklan)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $iklan->gambar) }}" class="d-block w-100 carousel-img">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>{{ $iklan->judul }}</h5>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#iklanCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#iklanCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                @else
                    <p class="text-muted">Belum ada iklan tersedia</p>
                @endif
            </div>
        </div>

        <!-- ============================= -->
        <!--       LIST IKLAN (TABLE)      -->
        <!-- ============================= -->
        <div class="card shadow-sm border-0">
            <div class="card-header pb-0">
                <h6 class="text-uppercase fw-bold mb-0" style="color:#1f2d3d;">Daftar Semua Iklan</h6>
            </div>

            <div class="card-body px-0 pt-0 pb-2">

                @if($iklans->count())
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm">
                            <thead style="background-color:#f8fafc;">
                                <tr>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Produk Terkait</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($iklans as $iklan)
                                    <tr>
                                        <td width="120">
                                            <img src="{{ asset('storage/' . $iklan->gambar) }}" width="100" class="rounded">
                                        </td>

                                        <td>{{ $iklan->judul }}</td>

                                        <td>
                                            @if($iklan->product)
                                                <span class="badge bg-success">{{ $iklan->product->nama_produk }}</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak Ada</span>
                                            @endif
                                        </td>

                                        <td class="text-center" width="150">
                                            <form action="{{ route('admin.iklan.destroy', $iklan->id) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus iklan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" style="border-radius:8px;">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @else
                    <p class="text-muted text-center py-4">Belum ada iklan</p>
                @endif

            </div>
        </div>

    </div>
</div>

@endsection
