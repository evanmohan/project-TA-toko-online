<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/0698b5b56f.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #fafafa;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding-top: 125px;
            /* agar konten tidak tertutup navbar */
        }

        :root {
            --orange: #ff6600;
            --dark-orange: #ff3300;
            --light-orange: #fff4ec;
        }

        .hover-bg-light:hover {
            background-color: #f8f9fa;
        }

        #searchResults a:hover {
            background-color: #f8f9fa;
        }

        #searchResults img {
            border-radius: 5px;
        }



        /* ====== NAVBAR FIXED ====== */
        .navbar-wrapper {
            background: linear-gradient(90deg, var(--orange), var(--dark-orange));
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* ====== TOP NAVBAR ====== */
        .top-navbar {
            padding: 8px 40px;
            font-size: 14px;
            font-weight: 500;
            text-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-navbar a {
            color: #fff;
            text-decoration: none;
            margin: 0 5px;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: 0.2s;
        }

        .top-navbar a:hover {
            color: #ffebcc;
            text-decoration: underline;
        }

        .dropdown-toggle.text-white {
            font-weight: 600;
            text-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
        }

        .dropdown-toggle.text-white:hover {
            color: #ffebcc;
        }

        /* ====== MAIN NAVBAR ====== */
        .main-navbar {
            padding: 15px 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 50px;
        }

        .main-navbar .logo {
            display: flex;
            align-items: center;
        }

        .main-navbar .logo img {
            height: 50px;
            margin-right: 10px;
        }

        /* ====== SEARCH BAR ====== */
        .main-navbar .search-bar {
            flex-grow: 1;
            max-width: 650px;
            position: relative;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .main-navbar .search-bar input {
            width: 100%;
            padding: 10px 15px;
            border: none;
            outline: none;
            font-size: 14px;
            color: #333;
            border-radius: 5px 0 0 5px;
        }

        .main-navbar .search-bar input::placeholder {
            color: #888;
        }

        .main-navbar .search-bar button {
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 50px;
            border: none;
            background-color: var(--orange);
            color: #fff;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            transition: 0.2s;
        }

        .main-navbar .search-bar button:hover {
            background-color: var(--dark-orange);
        }

        /* ====== ICONS ====== */
        .main-navbar .icons {
            display: flex;
            align-items: center;
        }

        .main-navbar .icons a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            position: relative;
            font-weight: 500;
        }

        .main-navbar .icons a .badge {
            font-size: 10px;
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: #dc3545;
        }

        /* ====== CATEGORY BAR ====== */
        .category-bar {
            background: linear-gradient(90deg, var(--orange), var(--dark-orange));
            padding: 10px 60px;
        }

        .category-bar a {
            color: white;
            font-size: 14px;
            margin-right: 25px;
            text-decoration: none;
            font-weight: 500;
        }

        .category-bar a:hover {
            text-decoration: underline;
        }

        /* ====== FOOTER ====== */
        footer {
            background: linear-gradient(90deg, var(--orange), var(--dark-orange));
            color: white;
            padding: 40px 0 20px;
            margin-top: 60px;
        }

        footer h6 {
            font-weight: 700;
            font-size: 15px;
            margin-bottom: 15px;
        }

        footer a {
            display: block;
            color: white;
            text-decoration: none;
            margin-bottom: 6px;
            font-size: 14px;
            opacity: 0.9;
        }

        footer a:hover {
            opacity: 1;
            text-decoration: underline;
        }

        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            margin-top: 20px;
            padding-top: 10px;
            font-size: 13px;
            text-align: center;
        }

        /* ====== DROPDOWN ANIMATION ====== */
        .dropdown-menu {
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.25s ease;
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .dropdown-menu.show {
            opacity: 1;
            transform: translateY(0);
            animation: popupFade 0.25s ease;
        }

        @keyframes popupFade {
            0% {
                opacity: 0;
                transform: scale(0.95) translateY(-5px);
            }

            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .dropdown-item:hover {
            background: var(--light-orange);
            color: var(--dark-orange);
            transition: 0.2s;
        }
    </style>
</head>

<body>

    <!-- 🔹 NAVBAR GABUNG WARNA (FIXED) -->
    <nav class="navbar-wrapper">
        <div class="top-navbar">
            <div>
                <a href="#"><i class="bi bi-info-circle me-1"></i>Tentang Kami</a>
                <span>|</span>
                <a href="#"><i class="bi bi-question-circle me-1"></i>Bantuan</a>
                <span>|</span>
                <a href="#"><i class="bi bi-telephone me-1"></i>Hubungi Kami</a>
            </div>

            <div class="dropdown">
                @auth
                    <a class="dropdown-toggle text-white text-decoration-none d-flex align-items-center" href="#"
                        id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->username }}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a href="#" class="dropdown-item"><i class="bi bi-pencil-square me-2"></i> Edit Profil</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                @else
                    <a href="{{ route('login') }}" class="text-white text-decoration-none">Masuk</a> |
                    <a href="{{ route('register') }}" class="text-white text-decoration-none">Daftar</a>
                @endauth
            </div>
        </div>

        <div class="main-navbar">
            <a href="{{ route('home') }}" class="logo d-flex align-items-center text-decoration-none">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
                <h4 class="m-0 fw-bold text-white ms-2">Second Store</h4>
            </a>


            <!-- 🔍 SEARCH BAR -->
            <div class="search-bar position-relative">
                <input type="text" id="searchInput" placeholder="Cari produk unggulan...">
                <button type="button"><i class="bi bi-search"></i></button>

                <!-- hasil pencarian muncul di sini -->
                <div id="searchResults" class="position-absolute bg-white w-100 shadow-sm rounded mt-1"
                    style="z-index: 2000; display:none; max-height:250px; overflow-y:auto;">
                </div>

            </div>



            <div class="icons">
                <a href="{{ route(name: 'keranjang.index') }}"><i class="bi bi-cart3"></i> Keranjang<span
                        class="badge">2</span></a>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- 🔹 FOOTER -->
    <footer>
        <div class="container">
            <div class="row text-start">
                <div class="col-md-3 mb-3">
                    <h6>INFORMASI</h6>
                    <a href="#">Tentang Kami</a>
                    <a href="#">Kebijakan Privasi</a>
                    <a href="#">Syarat & Ketentuan</a>
                </div>
                <div class="col-md-3 mb-3">
                    <h6>LAYANAN PELANGGAN</h6>
                    <a href="#">Hubungi Kami</a>
                    <a href="#">Pengembalian Barang</a>
                    <a href="#">Bantuan</a>
                </div>
                <div class="col-md-3 mb-3">
                    <h6>EKSTRA</h6>
                    <a href="#">Promo Spesial</a>
                    <a href="#">Diskon Hari Ini</a>
                    <a href="#">Voucher</a>
                </div>
                <div class="col-md-3 mb-3">
                    <h6>AKUN SAYA</h6>
                    <a href="#">Akun Saya</a>
                    <a href="#">Keranjang</a>
                    <a href="#">Riwayat Belanja</a>
                </div>
            </div>
            <div class="copyright">
                &copy; {{ date('Y') }} Second Store. Semua hak cipta dilindungi.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const resultsDiv = document.getElementById('searchResults');

            let timeout = null;

            searchInput.addEventListener('keyup', function () {
                clearTimeout(timeout);
                const query = this.value.trim();

                if (query.length < 2) {
                    resultsDiv.style.display = 'none';
                    resultsDiv.innerHTML = '';
                    return;
                }

                timeout = setTimeout(() => {
                    fetch(`/produk/live-search?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.length === 0) {
                                resultsDiv.innerHTML = '<div class="p-2 text-muted small">Tidak ada hasil</div>';
                            } else {
                                resultsDiv.innerHTML = data.map(item => `
                            <a href="/produk/${item.id}" class="d-flex align-items-center text-decoration-none text-dark p-2 border-bottom hover-bg-light">
                               <img src="${item.image ? '/storage/' + item.image : '/assets/images/default-product.png'}"
                                <div>
                                    <div class="fw-semibold">${item.nama_produk}</div>
                                    <div class="text-muted small">Rp ${parseInt(item.harga).toLocaleString('id-ID')}</div>
                                </div>
                            </a>
                        `).join('');
                            }
                            resultsDiv.style.display = 'block';
                        });
                }, 300); // delay 300ms biar ga terlalu sering request
            });

            // Sembunyikan hasil ketika klik di luar
            document.addEventListener('click', function (e) {
                if (!resultsDiv.contains(e.target) && e.target !== searchInput) {
                    resultsDiv.style.display = 'none';
                }
            });
        });
    </script>

</body>

</html>
