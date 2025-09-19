<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Toko Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">TokoOnline</a>
            <div class="d-flex">
                <span class="navbar-text text-white me-3">
                    Halo, {{ Auth::user()->name }}
                </span>
                <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container py-4">
        <h2 class="mb-4">Dashboard Toko Online</h2>

        <div class="row">
            <!-- Card Produk -->
            <div class="col-md-3">
                <div class="card text-center shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Produk</h5>
                        <p class="card-text">Total produk tersedia.</p>
                        <h3>120</h3>
                        <a href="#" class="btn btn-primary btn-sm">Kelola</a>
                    </div>
                </div>
            </div>

            <!-- Card Pesanan -->
            <div class="col-md-3">
                <div class="card text-center shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Pesanan</h5>
                        <p class="card-text">Pesanan baru hari ini.</p>
                        <h3>15</h3>
                        <a href="#" class="btn btn-success btn-sm">Lihat</a>
                    </div>
                </div>
            </div>

            <!-- Card Pelanggan -->
            <div class="col-md-3">
                <div class="card text-center shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Pelanggan</h5>
                        <p class="card-text">Jumlah pelanggan terdaftar.</p>
                        <h3>350</h3>
                        <a href="#" class="btn btn-info btn-sm">Detail</a>
                    </div>
                </div>
            </div>

            <!-- Card Pendapatan -->
            <div class="col-md-3">
                <div class="card text-center shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Pendapatan</h5>
                        <p class="card-text">Pendapatan bulan ini.</p>
                        <h3>Rp 12jt</h3>
                        <a href="#" class="btn btn-warning btn-sm">Laporan</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Pesanan Terbaru -->
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-dark text-white">
                Pesanan Terbaru
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Pelanggan</th>
                            <th>Produk</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Budi</td>
                            <td>Sepatu Nike</td>
                            <td>Rp 750.000</td>
                            <td><span class="badge bg-success">Selesai</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Siti</td>
                            <td>Tas Gucci</td>
                            <td>Rp 1.200.000</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Andi</td>
                            <td>Jam Casio</td>
                            <td>Rp 500.000</td>
                            <td><span class="badge bg-danger">Batal</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>
